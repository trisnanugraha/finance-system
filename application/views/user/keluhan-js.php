<script>
    window.onload = function() {
        tampilKeluhan();
    }

    function tampilKeluhan() {
        $.get('<?php echo base_url('User/Tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-keluhan').html(data);
            refresh();
        });
    }

    var kode_keluhan;
    $(document).on("click", ".konfirmasiHapus-keluhan", function() {
        kode_keluhan = $(this).attr("data-id");
    });

    $(document).on("click", ".hapus-dataKeluhan", function() {
        var id = kode_keluhan;

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('User/delete'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilKeluhan();
                $('.msg').html(data);
                effect_msg();
            });
    });

    $(document).on("click", ".update-dataKeluhan", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('User/update'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#tempat-modal').html(data);
                $('#update-keluhan').modal('show');
            });
    });

    $(document).on('submit', '#form-update-keluhan', function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('User/prosesUpdate'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilKeluhan();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-update-keluhan").reset();
                    $('#update-keluhan').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $('#form-tambah-keluhan').submit(function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('User/prosesTambah'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilKeluhan();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-keluhan").reset();
                    $('#tambah-keluhan').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $(document).on("click", ".detail-dataKeluhan", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('User/detail'); ?>",
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
                $('#detail-keluhan').modal('show');
            })
    })

    $('#update-keluhan').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });

    $('#tambah-keluhan').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>