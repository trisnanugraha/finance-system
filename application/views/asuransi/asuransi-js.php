<script>
    $(function(){
        let startDate = "";
        let endDate = "";
        let owner = "";

        window.onload = function(){
            tampilAsuransi(owner, startDate, endDate);
            tampilOwner();
        }

        $('#filter').on("click", function(){
            owner = $('#owner').find(':selected').val();
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            tampilAsuransi(owner, startDate, endDate);
        });

        function  tampilAsuransi(owner, startDate, endDate){
            $.ajax({
                url : "<?php echo base_url('Asuransi/Tampil')?>",
                data : {owner : owner, startDate : startDate, endDate : endDate},
                type: "GET",
                datatype: "html",
                success: function(response){
                    MyTable.fnDestroy();
                    $("#data-asuransi").html(response);
                    refresh();
                }
            })
        }
        
        function tampilOwner() {
            $.getJSON('<?php echo base_url('Owner/getOwnerJson'); ?>',
                function(response) {
                    if (response.data.length > 0) {
                        response.data.forEach(function(item, index) {
                            $("#owner").append($('<option>', {
                                value: item.kode_owner,
                                text: item.nama_owner
                            }));
                        });
                    }
                });
        }

        var id_asuransi;
        $(document).on("click", ".konfirmasiHapus-asuransi", function() {
            id_asuransi = $(this).attr("data-id");
        });

        $(document).on("click", ".hapus-dataAsuransi", function() {
            var id = id_asuransi;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Asuransi/delete'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilAsuransi();
                    $('.msg').html(data);
                    effect_msg();
                })
        });

        $(document).on("click", ".print-dataAsuransi", function() {
            var id = $(this).attr("data-id");
            var go_to_url = '<?php echo base_url('Asuransi/print/'); ?>' + id;
            window.open(go_to_url, '_blank');
        });

        $(document).on("click", ".update-dataAsuransi", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Asuransi/update'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#update-asuransi').modal('show');
                })
        })

        $(document).on("click", ".detail-dataAsuransi", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Asuransi/detail'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#tabel-detail').dataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    });
                    $('#detail-asuransi').modal('show');
                })
        })

        $('#form-tambah-asuransi').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Asuransi/prosesTambah'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilAsuransi();

                    if (out.status == 'form') {
                        $('#tambah-asuransi').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    } else {
                        document.getElementById("form-tambah-asuransi").reset();
                        $('#tambah-asuransi').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $(document).on('submit', '#form-update-asuransi', function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Asuransi/prosesUpdate'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilAsuransi();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-update-asuransi").reset();
                        $('#update-asuransi').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-asuransi').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        })

        $('#update-asuransi').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });

        $('#print-multiple-asuransi').on('shown.bs.modal', function(e) {

            $.get('<?= base_url('Asuransi/period'); ?>', function(data, status) {
                var markup;
                var dbSelect = $('.print-period');
                dbSelect.empty();
                dbSelect.append('<option selected disabled>Choose Period</option>');
                for (var i = 0; i < data.data.length; i++) {
                    dbSelect.append($('<option/>', {
                        value: data.data[i].id_periode,
                        text: moment(data.data[i].start_periode, 'YYYY/MM/DD').format('DD/MMM/YYYY') + ' ~ ' + moment(data.data[i].end_periode, 'YYYY/MM/DD').format('DD/MMM/YYYY')
                    }));
                }
        }); 
    });

    $(".kodeOwner").on("change", function() {
            var kode_owner = $(this).find(':selected').val();
            $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Asuransi/tampilPeriodeOwner'); ?>',
                data: {
                    kodeOwner: kode_owner
                },
                success: function(result) {
                    var markup;
                    var dbSelect = $('#period');
                    dbSelect.empty();
                    dbSelect.append('<option selected disabled>Choose Period</option>');
                    for (var i = 0; i < result.data.length; i++) {
                        dbSelect.append($('<option/>', {
                            value: result.data[i].id_periode,
                            text: moment(result.data[i].first_day, 'YYYY/MM/DD').format('DD/MMM/YYYY') + ' ~ ' + moment(result.data[i].last_day, 'YYYY/MM/DD').format('DD/MMM/YYYY')
                        }));
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
    
    $("#check_all").click(function(){
        if($(this).is(":checked")){
            $(".check_item").prop("checked", true);
            $(this).closest('tr').addClass('removeRow');
        }else{
            $(".check_item").prop("checked", false);
            $(this).closest('tr').removeClass('removeRow');
        }
    });

    $('.check_item').click(function(){
        if($(this).is(':checked')){
            $(this).closest('tr').addClass('removeRow');
        }else{
            $(this).closest('tr').removeClass('removeRow');
        }
    });

    $(document).on("click", "#delete_all", function() {
        var checkbox = $('.check_item:checked');
        var confirm = window.confirm("Delete This Data ?")

        if(checkbox.length > 0 && confirm){
            var checkbox_value = new Array();
            
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });

            sendValue = JSON.stringify(checkbox_value);
            
            $.ajax({
                url:"<?php echo base_url('Asuransi/delete_all'); ?>",
                method:"POST",
                data: {checkbox_value : sendValue},
            })
            .done(function(data) {
                tampilAsuransi();
                $('.msg').html(data);
                effect_msg();
                setInterval('location.reload()', 1000);
            })
            
        }else if(checkbox.length <= 0 && confirm){
            alert('Select at least one records');
        }else{}
    });
});
</script>