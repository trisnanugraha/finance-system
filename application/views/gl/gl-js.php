<script>
    $(function() {
        let startDate = "";
        let endDate = "";
        let akun = "";

        window.onload = function() {
            tampilGL(akun, startDate, endDate);
            tampilAkun();
        }

        $('#filter').on("click", function() {
            akun = $('#akun').find(':selected').val();
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            tampilGL(akun, startDate, endDate);
        });

        function tampilGL(akun, startDate, endDate) {
            $.ajax({
                url: "<?php echo base_url('GL/Tampil') ?>",
                data: {
                    akun: akun,
                    startDate: startDate,
                    endDate: endDate
                },
                type: "GET",
                datatype: "html",
                success: function(response) {
                    MyTable.fnDestroy();
                    $("#data-gl").html(response);
                    refresh();
                }
            })
        }

        function tampilAkun() {
            $.getJSON('<?php echo base_url('Coa/getAkunJson'); ?>',
                function(response) {
                    if (response.data.length > 0) {
                        response.data.forEach(function(item, index) {
                            $("#akun").append($('<option>', {
                                value: item.id_akun,
                                text: item.coa_id + ' - ' + item.coa_name
                            }));
                        });
                    }
                });
        }

        var id_gl;
        $(document).on("click", ".konfirmasiHapus-gl", function() {
            id_gl = $(this).attr("data-id");
        });

        $(document).on("click", ".hapus-dataGL", function() {
            var id = id_gl;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('GL/delete'); ?>",
                    data: "id_gl=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilGL();
                    $('.msg').html(data);
                    effect_msg();
                    setInterval('location.reload()', 1000);
                });
        });

        $('#form-tambah-gl').submit(function(e) {
            var lastRowId = $('#tableBody tr:last').attr("id");
            var code = new Array();
            var keterangan = new Array();
            var akun = new Array();
            var debit = new Array();
            var kredit = new Array();
            var sendDate = $('#date').val();

            for (var i = 1; i <= lastRowId; i++) {
                code.push($("#" + i + " .code" + i).html());
                keterangan.push($('#' + i + " .keterangan" + i).html());
                akun.push($('#' + i + " .coa" + i).html());
                debit.push($('#' + i + " .debit").html());
                kredit.push($('#' + i + " .kredit").html());
            }

            var sendCode = JSON.stringify(code);
            var sendKeterangan = JSON.stringify(keterangan);
            var sendAkun = JSON.stringify(akun);
            var sendDebit = JSON.stringify(debit);
            var sendKredit = JSON.stringify(kredit);

            console.log(code);
            console.log(keterangan);
            console.log(akun);
            console.log(debit);
            console.log(kredit);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('GL/prosesTambah'); ?>',
                data: {
                    code: sendCode,
                    keterangan: sendKeterangan,
                    akun: sendAkun,
                    debit: sendDebit,
                    kredit: sendKredit,
                    date: sendDate
                }
            }).done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilGL();
                if (out.status == 'form') {
                    $('#tambah-gl').modal('hide');
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                    $('#data_table').remove();
                    setInterval('location.reload()', 1000);
                } else {
                    document.getElementById("form-tambah-gl").reset();
                    $('#tambah-gl').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                    $('#data_table').remove();
                    setInterval('location.reload()', 1000);
                }
            });
            e.preventDefault();
        });

        $("#check_all").click(function() {
            if ($(this).is(":checked")) {
                $(".check_item").prop("checked", true);
                $(this).closest('tr').addClass('removeRow');
            } else {
                $(".check_item").prop("checked", false);
                $(this).closest('tr').removeClass('removeRow');
            }
        });

        $('.check_item').click(function() {
            if ($(this).is(':checked')) {
                $(this).closest('tr').addClass('removeRow');
            } else {
                $(this).closest('tr').removeClass('removeRow');
            }
        });

        $(document).on("click", "#delete_all", function() {
            var checkbox = $('.check_item:checked');
            var confirm = window.confirm("Delete This Data ?")

            if (checkbox.length > 0 && confirm) {
                var checkbox_value = new Array();

                $(checkbox).each(function() {
                    checkbox_value.push($(this).val());
                });

                sendValue = JSON.stringify(checkbox_value);

                console.log(sendValue);

                $.ajax({
                        url: "<?php echo base_url('GL/delete_all'); ?>",
                        method: "POST",
                        data: {
                            checkbox_value: sendValue
                        },
                    })
                    .done(function(data) {
                        tampilGL();
                        $('.msg').html(data);
                        effect_msg();
                    })

            } else if (checkbox.length <= 0 && confirm) {
                alert('Select at least one records');
            } else {}
        });

        $('#tambah-gl').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });

        $(document).on("click", ".update-dataGL", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('GL/update'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#update-gl').modal('show');
                });
        })

        $(document).on('submit', '#form-update-gl', function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('GL/prosesUpdate'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilGL();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-update-gl").reset();
                        $('#update-gl').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#update-gl').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });

    });
</script>