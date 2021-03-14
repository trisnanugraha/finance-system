<script>
    $(function() {
        let customer = "";
        let owner = "";
        let startDate = "";
        let endDate = "";

        window.onload = function() {
            tampilElectricity(owner, customer, startDate, endDate);
            tampilOwner();
            tampilCustomer(owner);
        }

        $("#owner").on("change", function() {
            owner = $('#owner').find(':selected').val();
            tampilCustomer(owner);
        });

        $("#filter").on("click", function() {
            customer = $("#customer").find(":selected").val();
            owner = $("#owner").find(":selected").val();
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            tampilElectricity(owner, customer, startDate, endDate);
        });

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

        function tampilCustomer(owner) {
            $.getJSON('<?php echo base_url('Customer/getCustomerJson'); ?>', {
                    owner: owner
                },
                function(response) {
                    if (response.data.length > 0) {
                        $("#customer").empty().append('<option selected value=""> --All customer-- </option>')
                        response.data.forEach(function(item, index) {
                            $("#customer").append($('<option>', {
                                value: item.kodeCus,
                                text: item.nama
                            }));
                        });
                    }
                });
        }

        //Electricity Bills
        function tampilElectricity(owner, customer, startDate, endDate) {
            $.ajax({
                url: "<?php echo base_url('Electricity/tampil'); ?>",
                data: {
                    owner: owner,
                    customer: customer,
                    startDate: startDate,
                    endDate: endDate
                },
                type: "GET",
                datatype: "html",
                success: function(response) {
                    MyTable.fnDestroy();
                    $('#data-electricity').html(response);
                    refresh();
                }
            });
        }

        var id_electricity;
        $(document).on("click", ".konfirmasiHapus-electricity", function() {
            id_electricity = $(this).attr("data-id");
        });

        $(document).on("click", ".hapus-dataElectricity", function() {
            var id = id_electricity;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Electricity/delete'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilElectricity();
                    $('.msg').html(data);
                    effect_msg();
                })
        });

        $(document).on("click", ".update-dataElectricity", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Electricity/update'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#update-electricity').modal('show');
                })
        })

        $(document).on("click", ".detail-dataElectricity", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Electricity/detail'); ?>",
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
                    $('#detail-electricity').modal('show');
                })
        })

        $('#form-tambah-electricity').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Electricity/prosesTambah'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilElectricity();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-tambah-electricity").reset();
                        $('#hiddenCapacity').val('');
                        $('#electricityCapacity').text('-');
                        $('#tambah-electricity').modal('hide');

                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-electricity').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        })
    });
</script>