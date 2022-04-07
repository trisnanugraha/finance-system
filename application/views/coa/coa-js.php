<script>
    window.onload = function(){
        tampilCoa();
    }
    
    var table = $('#table-coa').DataTable();
    
    function tampilCoa() {
        table.destroy();
        $(document).ready(function() {
            
			table = $('#table-coa').DataTable({
				"processing": true,
                "serverSide": true,
                "ordering": true,
                "order": [[ 0, 'asc' ]],
                "ajax":
                    {
                        "url": "<?php echo base_url('Coa/getAjax') ?>",
                        "type": "POST"
                    },
                "deferRender": true,
                "aLengthMenu": [[10, 25, 50, 100],[10, 25, 50, 100]],
                "columns": [
                    {"data" : "coaID"},
                    {"data" : "coaName"},
                    {"data" : "coaType"},
                    {"data" : "accType"},
                    {"render" : function(data, type, row){
                        var html = "<button class='btn btn-danger btn-sm konfirmasiHapus-coa' data-id="+row.coa_id+" data-toggle='modal' data-target='#konfirmasiHapus'><i class='glyphicon glyphicon-trash'></i></button>"
                        return html
                    }}
                ],
                "columnDefs": [
                    { 
                        "targets": [0, 2, 3, 4],
                        "className": 'text-center'
                    },
                    { 
                        "targets": [4], 
                        "orderable": false
                    }
                    ],
			});
		});
    }

    var id_akun;

    $(document).on("click", ".konfirmasiHapus-coa", function() {
        id_akun = $(this).attr("data-id");
    });

    $(document).on("click", ".hapus-dataCoa", function() {
        var id = id_akun;

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Coa/delete'); ?>",
                data: "id_akun=" + id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilCoa();
                $('.msg').html(data);
                effect_msg();
            });
    });

    $('#form-tambah-coa').submit(function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Coa/prosesTambah'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilCoa();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-coa").reset();
                    $('#tambah-coa').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $('#tambah-coa').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>