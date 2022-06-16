<script>
    window.onload = function() {
        tampilOwner();
    }
    
    var table = $('#table-owner').DataTable();
    
    function tampilOwner() {
        table.destroy();
        $(document).ready(function() {
            
			table = $('#table-owner').DataTable({
				"processing": true,
                "serverSide": true,
                "ordering": true,
                "order": [[ 0, 'asc' ]],
                "ajax":
                    {
                        "url": "<?php echo base_url('Owner/getAjax') ?>",
                        "type": "POST"
                    },
                "deferRender": true,
                "aLengthMenu": [[10, 25, 50, 100],[10, 25, 50, 100]],
                "columns": [
                    {"data" : "no"},
                    {"data" : "id"},
                    {"data" : "kodeVir"},
                    {"data" : "nama"},
                    {"data" : "unit"},
                    {"render" : function(data, type, row){
                        var html = "<button class='btn btn-warning btn-sm update-dataOwner' data-id="+ row.id +"><i class='glyphicon glyphicon-edit'></i></button> "
                        html += "<button class='btn btn-info btn-sm detail-dataOwner' data-id="+ row.id +"><i class='glyphicon glyphicon-info-sign'></i></button> "
                        html += "<button class='btn btn-danger btn-sm konfirmasiHapus-owner' data-toggle='modal' data-target='#konfirmasiHapus' data-id="+ row.id +"><i class='glyphicon glyphicon-trash'></i></button>"

                        return html
                    }}
                ],
                "columnDefs": [
                    { 
                        "targets": [0, 1, 2, 4, 5],
                        "className": 'text-center'
                    },
                    { 
                        "targets": [5], 
                        "orderable": false
                    }
                    ],
			});
		});
    }

    var id_own;
    $(document).on("click", ".konfirmasiHapus-owner", function() {
        id_own = $(this).attr("data-id");
    });

    $(document).on("click", ".hapus-dataOwner", function() {
        var id = id_own;

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Owner/delete'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilOwner();
                $('.msg').html(data);
                effect_msg();
            })
    })

    $(document).on("click", ".update-dataOwner", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Owner/update'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#tempat-modal').html(data);
                $('#update-owner').modal('show');
            })
    })

    $('#form-tambah-owner').submit(function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Owner/prosesTambah'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilOwner();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-owner").reset();
                    $('#tambah-owner').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            })

        e.preventDefault();
    });

    $(document).on('submit', '#form-update-owner', function(e) {
        var data = $(this).serialize();
        
        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Owner/prosesUpdate'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilOwner();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-update-owner").reset();
                    $('#update-owner').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            })

        e.preventDefault();
    });

    $(document).on("click", ".detail-dataOwner", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Owner/detail'); ?>",
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
                $('#detail-owner').modal('show');
            });
    });

    $('#tambah-owner').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });

    $('#update-owner').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>