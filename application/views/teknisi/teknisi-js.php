<script>
    window.onload = function() {
        tampilKeluhan();
    }

    function tampilKeluhan() {
        $.get('<?php echo base_url('Teknisi/Tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-keluhan').html(data);
            refresh();
        });
    }

    $(document).on("click", ".update-dataKeluhan", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Teknisi/update'); ?>",
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
                url: '<?php echo base_url('Teknisi/prosesUpdate'); ?>',
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

    $('#update-keluhan').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>