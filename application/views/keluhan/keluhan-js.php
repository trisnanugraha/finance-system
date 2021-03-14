<script>
    window.onload = function() {
        tampilKeluhan();
    }

    function tampilKeluhan() {
        $.get('<?php echo base_url('Keluhan/Tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-keluhan').html(data);
            refresh();
        });
    }

    $(document).on("click", ".detail-dataKeluhan", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Keluhan/detail'); ?>",
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
    });
</script>