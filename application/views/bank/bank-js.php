<script>
    window.onload = function() {
        tampilBank();
    }
    //Bank
    function tampilBank() {
        $.get('<?php echo base_url('Bank/tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-bank').html(data);
            refresh();
        });
    }

    var id_bank;
    $(document).on("click", ".konfirmasiHapus-bank", function() {
        id_bank = $(this).attr("data-id");
    });

    $(document).on("click", ".hapus-dataBank", function() {
        var id = id_bank;

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Bank/delete'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilBank();
                $('.msg').html(data);
                effect_msg();
            });
    });

    $(document).on("click", ".update-dataBank", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Bank/update'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#tempat-modal').html(data);
                $('#update-bank').modal('show');
            });
    });

    $(document).on('submit', '#form-update-bank', function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Bank/prosesUpdate'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilBank();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-update-bank").reset();
                    $('#update-bank').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $('#form-tambah-bank').submit(function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Bank/prosesTambah'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilBank();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-bank").reset();
                    $('#tambah-bank').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $('#update-bank').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });

    $('#tambah-bank').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>