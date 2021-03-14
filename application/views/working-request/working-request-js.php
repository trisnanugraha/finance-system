<script>
    $(function() {

        window.onload = function() {
            tampilWorkingRequest();
        }

        //Working Request Bills
        function tampilWorkingRequest() {
            $.get('<?php echo base_url('WorkingRequest/tampil'); ?>', function(data) {
                MyTable.fnDestroy();
                $('#data-workingRequest').html(data);
                refresh();
            });
        }

        var id_workingRequest;
        $(document).on("click", ".konfirmasiHapus-workingRequest", function() {
            id_workingRequest = $(this).attr("data-id");
        });

        $(document).on("click", ".hapus-dataWorkingRequest", function() {
            var id = id_workingRequest;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('WorkingRequest/delete'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilWorkingRequest();
                    $('.msg').html(data);
                    effect_msg();
                })
        });

        $(document).on("click", ".update-dataWorkingRequest", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('WorkingRequest/update'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#update-workingRequest').modal('show');
                })
        })

        $(document).on("click", ".detail-dataWorkingRequest", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('WorkingRequest/detail'); ?>",
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
                    $('#detail-workingRequest').modal('show');
                })
        })

        $('#form-tambah-workingRequest').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('WorkingRequest/prosesTambah'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilWorkingRequest();

                    if (out.status == 'form') {
                        $('#tambah-workingRequest').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    } else {
                        document.getElementById("form-tambah-workingRequest").reset();
                        $('#tambah-workingRequest').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $(document).on('submit', '#form-update-workingRequest', function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('WorkingRequest/prosesUpdate'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilWorkingRequest();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-update-workingRequest").reset();
                        $('#update-workingRequest').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-workingRequest').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        })

        $('#update-workingRequest').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });
    });
</script>