<script>
    window.onload = function() {
        tampilCustomer();
    }

    var table = $('#table-customer').DataTable();

    function tampilCustomer() {
        table.destroy();
        $(document).ready(function() {
            
            var i = 1;
			table = $('#table-customer').DataTable({
				"processing": true,
                "serverSide": true,
                "ordering": true,
                "order": [[ 0, 'asc' ]],
                "ajax":
                    {
                        "url": "<?php echo base_url('Customer/getAjax') ?>",
                        "type": "POST"
                    },
                "deferRender": true,
                "aLengthMenu": [[10, 25, 50, 100],[10, 25, 50, 100]],
                "columns": [
                    {"data" : "no"},
                    {"data" : "kodeCus"},
                    {"data" : "kodeVir"},
                    {"data" : "nama"},
                    {"data" : "unit"},
                    {"data" : "owner"},
                    {"render" : function(data, type, row){
                        var html = "<button class='btn btn-warning btn-sm update-dataCustomer' data-id="+ row.kodeCus +"><i class='glyphicon glyphicon-edit'></i></button> "
                        html += "<button class='btn btn-info btn-sm detail-dataCustomer' data-id="+ row.kodeCus +"><i class='glyphicon glyphicon-info-sign'></i></button> "
                        html += "<button class='btn btn-danger btn-sm konfirmasiHapus-customer' data-toggle='modal' data-target='#konfirmasiHapus' data-id="+ row.kodeCus +"><i class='glyphicon glyphicon-trash'></i></button>"

                        return html
                    }}
                ],
                "columnDefs": [
                    { 
                        "targets": [0, 1, 4, 5],
                        "className": 'text-center'
                    },
                    { 
                        "targets": [6], 
                        "orderable": false
                    }
                    ],
			});
		});
    }

    var id_cus;
    $(document).on("click", ".konfirmasiHapus-customer", function() {
        id_cus = $(this).attr("data-id");
    });

    $(document).on("click", ".hapus-dataCustomer", function() {
        var id = id_cus;

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Customer/delete'); ?>",
                data: "kodeCus=" + id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilCustomer();
                $('.msg').html(data);
                effect_msg();
            });
    });

    $(document).on("click", ".update-dataCustomer", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Customer/update'); ?>",
                data: "kodeCus=" + id
            })
            .done(function(data) {
                $('#tempat-modal').html(data);
                $('#update-customer').modal('show');
            });
    });

    $('#form-tambah-customer').submit(function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Customer/prosesTambah'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilCustomer();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-customer").reset();
                    $('#tambah-customer').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $(document).on('submit', '#form-update-customer', function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Customer/prosesUpdate'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilCustomer();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-update-customer").reset();
                    $('#update-customer').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $(document).on("click", ".detail-dataCustomer", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Customer/detail'); ?>",
                data: "kodeCus=" + id
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
                $('#detail-customer').modal('show');
            });
    });

    $('#tambah-customer').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });

    $('#update-customer').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>