<script>

    window.onload = function(){
        tampilRates();
        tampilCurrentRates();
    }

    //Rates List
    function tampilRates() {
        $.get('<?php echo base_url('Rates/tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-rates').html(data);
            refresh();
        });
    }

    function tampilCurrentRates() {
        $.get('<?php echo base_url('Rates/tampilCurrentRate'); ?>', function(data) {
            $("#current-rate").html(data);

        });
    }

    $(document).on("click", ".update-dataRates", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Rates/update'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#tempat-modal').html(data);
                $('#update-rates').modal('show');
            });
    });

    $('#form-tambah-rates').submit(function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Rates/prosesTambah'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilRates();
                tampilCurrentRates();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-rates").reset();
                    $('#tambah-rates').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            });

        e.preventDefault();
    });

    $(document).on('submit', '#form-update-rates', function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Rates/prosesUpdate'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilRates();
                tampilCurrentRates();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-update-rates").reset();
                    $('#update-rates').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            })

        e.preventDefault();
    });

    $('#update-rates').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });

    var id_rate;
    $(document).on("click", ".konfirmasiHapus-rates", function() {

        id_rate = $(this).attr("data-id");
    });

    $(document).on("click", ".hapus-dataRates", function() {
        var id = id_rate;

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Rates/delete'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilCurrentRates();
                tampilRates();
                $('.msg').html(data);
                effect_msg();
            });
    });
</script>