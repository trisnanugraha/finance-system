<script>
    window.onload = function() {
        tampilLog();
    }

    function tampilLog() {
        $.get('<?php echo base_url('Log/Tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-log').html(data);
            refresh();
        });
    }
</script>