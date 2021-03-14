<script>
    window.onload = function() {
        tampilDescription();
    }
    //Description
    function tampilDescription() {
        $.get('<?php echo base_url('Description/tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-description').html(data);
            refresh();
        });
    }

    var id_desc;
    $(document).on("click", ".update-dataDescription", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Description/update'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#tempat-modal').html(data);
                $('#update-description').modal('show');
            });
    });

    $(document).on('submit', '#form-update-description', function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Description/prosesUpdate'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilDescription();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-update-description").reset();
                    $('#update-description').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $('#update-description').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>