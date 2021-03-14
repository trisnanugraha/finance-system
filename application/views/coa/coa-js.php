<script>
    window.onload = function(){
        tampilCoa();
    }
    
    function tampilCoa() {
        $.get('<?php echo base_url('Coa/tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-coa').html(data);
            refresh();
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