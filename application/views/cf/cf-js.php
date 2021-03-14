<script>
    $(function() {
        let startDate = "";

        window.onload = function() {
            tampilCF(startDate);
        }

        $("#filter").on("click", function() {
            startDate = $('#startDate').val();
            tampilCF(startDate);
        });

        function tampilCF(startDate) {
            $.ajax({
                url: "<?php echo base_url('CF/tampil'); ?>",
                data: {
                    startDate : startDate
                },
                type: "GET",
                datatype: "html",
                success: function(response) {
                    MyTable.fnDestroy();
                    $('#data-cf').html(response);
                    refresh();
                }
            });
        }

        $('#form-tambah-mtd').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('CF/tambahMTD'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilCF();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-tambah-mtd").reset();
                        $('#tambah-mtd').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-mtd').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        })

        $('#form-tambah-ytd').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('CF/tambahYTD'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilCF();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-tambah-ytd").reset();
                        $('#tambah-ytd').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-ytd').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        })
    });
</script>