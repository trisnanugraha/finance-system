<script>
    $(function() {
        let customer = "";
        let owner = "";
        let startDate = "";
        let endDate = "";

        window.onload = function() {
            tampilWater(owner, customer, startDate, endDate);
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
            tampilWater(owner, customer, startDate, endDate);
        });


        //Water Bills
        function tampilWater(owner, customer, startDate, endDate) {
            $.ajax({
                url: "<?php echo base_url('Water/tampil'); ?>",
                data: {
                    owner: owner,
                    customer: customer,
                    startDate : startDate, 
                    endDate : endDate
                },
                type: "GET",
                datatype: "html",
                success: function(response) {
                    MyTable.fnDestroy();
                    $('#data-water').html(response);
                    refresh();
                }
            });
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

        var id_water;
        $(document).on("click", ".konfirmasiHapus-water", function() {
            id_water = $(this).attr("data-id");
        });

        $(document).on("click", ".hapus-dataWater", function() {
            var id = id_water;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Water/delete'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilWater();
                    $('.msg').html(data);
                    effect_msg();
                })
        });

        $(document).on("click", ".update-dataWater", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Water/update'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#update-water').modal('show');
                })
        })

        $(document).on("click", ".detail-dataWater", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Water/detail'); ?>",
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
                    $('#detail-water').modal('show');
                })
        })

        $('#form-tambah-water').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Water/prosesTambah'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilWater();

                    if (out.status == 'form') {
                        $('#tambah-water').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    } else {
                        document.getElementById("form-tambah-water").reset();
                        $('#tambah-water').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $(document).on('submit', '#form-update-water', function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Water/prosesUpdate'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilWater();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-update-water").reset();
                        $('#update-water').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-water').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        })

        $('#update-water').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });
    });
</script>