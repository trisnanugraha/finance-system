<script>
    $(function() {

        window.onload = function() {
            tampilStorageParking();
        }

        //StorageParking Bills
        function tampilStorageParking() {
                $.get('<?php echo base_url('StorageParking/tampil'); ?>', function(data) {
                MyTable.fnDestroy();
                $('#data-storageParking').html(data);
                refresh();
            });
        }

        var id_storageParking;
        $(document).on("click", ".konfirmasiHapus-storageParking", function() {
            id_storageParking = $(this).attr("data-id");
        });

        $(document).on("click", ".hapus-dataStorageParking", function() {
            var id = id_storageParking;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('StorageParking/delete'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilStorageParking();
                    $('.msg').html(data);
                    effect_msg();
                })
        });

        $(document).on("click", ".update-dataStorageParking", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('StorageParking/update'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#update-storageParking').modal('show');
                })
        })

        $(document).on("click", ".detail-dataStorageParking", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('StorageParking/detail'); ?>",
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
                    $('#detail-storageParking').modal('show');
                })
        })

        $('#form-tambah-storageParking').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('StorageParking/prosesTambah'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilStorageParking();

                    if (out.status == 'form') {
                        $('#tambah-storageParking').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    } else {
                        document.getElementById("form-tambah-storageParking").reset();
                        $('#tambah-storageParking').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $(document).on('submit', '#form-update-storageParking', function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('StorageParking/prosesUpdate'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilStorageParking();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-update-storageParking").reset();
                        $('#update-storageParking').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-storageParking').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        })
        
        $('#update-wr').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });
    });
</script>