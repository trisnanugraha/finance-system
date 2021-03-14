<script>
    window.onload = function() {
        tampilPeriod();
    }
    //Period
    function tampilPeriod() {
        $.get('<?php echo base_url('Period/tampil'); ?>', function(data) {
            MyTable.fnDestroy();
            $('#data-period').html(data);
            refresh();
            var hiddenPeriodStart = $("#tambahPeriodStart");
            var hiddenPeriodEnd = $("#tambahPeriodEnd");
            var hiddenPeriodDue = $("#tambahPeriodDueDate");
            var startPeriod = moment(hiddenPeriodStart.val()).format('DD/MM/YYYY');
            var endPeriod = moment(hiddenPeriodEnd.val()).format('DD/MM/YYYY');
            var duePeriod = moment(hiddenPeriodDue.val()).format('DD/MM/YYYY');
            var duePicker = $('#tambahDueDate').datepicker({
                startDate: endPeriod,
                format: 'dd/mm/yyyy',
                autoclose: true
            }).on('changeDate', function(selected) {
                hiddenPeriodDue.val(moment(selected.date.valueOf()).format('YYYY/MM/DD'));

            });

            $('#tambahPeriodRange').daterangepicker({
                startDate: startPeriod,
                endDate: endPeriod,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function(start, end, label) {
                hiddenPeriodStart.val(moment(start).format('YYYY/MM/DD'));

                hiddenPeriodEnd.val(moment(end).format('YYYY/MM/DD'));

                if (duePicker.val().length > 0) {
                    var due = duePicker.val();
                    if (moment(end).isAfter(moment(due, 'DD/MM/YYYY'))) {
                        duePicker.datepicker("update", '');
                    }
                }

                duePicker.datepicker("setStartDate", moment(end).format('DD/MM/YYYY'));
            });
            duePicker.datepicker("update", duePeriod);
        });
    }

    var id_period;
    $(document).on("click", ".konfirmasiHapus-period", function() {
        id_period = $(this).attr("data-id");
    });

    $(document).on("click", ".hapus-dataPeriod", function() {
        var id = id_period;

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Period/delete'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilPeriod();
                $('.msg').html(data);
                effect_msg();
            })
    })

    $(document).on("click", ".update-dataPeriod", function() {
        var id = $(this).attr("data-id");

        $.ajax({
                method: "POST",
                url: "<?php echo base_url('Period/update'); ?>",
                data: "id=" + id
            })
            .done(function(data) {
                $('#tempat-modal').html(data);

                $('#update-period').modal('show');
                var hiddenPeriodStart = $("#periodStart");
                var hiddenPeriodEnd = $("#periodEnd");
                var hiddenPeriodDue = $("#periodDueDate");
                var startPeriod = moment(hiddenPeriodStart.val()).format('DD/MM/YYYY');
                var endPeriod = moment(hiddenPeriodEnd.val()).format('DD/MM/YYYY');
                var duePeriod = moment(hiddenPeriodDue.val()).format('DD/MM/YYYY');
                var duePicker = $('#dueDate').datepicker({
                    startDate: endPeriod,
                    format: 'dd/mm/yyyy',
                    autoclose: true
                }).on('changeDate', function(selected) {
                    hiddenPeriodDue.val(moment(selected.date.valueOf()).format('YYYY/MM/DD'));

                });

                $('#periodRange').daterangepicker({
                    startDate: startPeriod,
                    endDate: endPeriod,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                }, function(start, end, label) {
                    hiddenPeriodStart.val(moment(start).format('YYYY/MM/DD'));

                    hiddenPeriodEnd.val(moment(end).format('YYYY/MM/DD'));

                    if (duePicker.val().length > 0) {
                        var due = duePicker.val();
                        if (moment(end).isAfter(moment(due, 'DD/MM/YYYY'))) {
                            duePicker.datepicker("update", '');
                        }
                    }

                    duePicker.datepicker("setStartDate", moment(end).format('DD/MM/YYYY'));
                });
                duePicker.datepicker("update", duePeriod);
            });
    });

    $(document).on('submit', '#form-tambah-period', function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Period/prosesTambah'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilPeriod();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-period").reset();
                    $('#tambah-period').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            })

        e.preventDefault();
    });

    $(document).on('submit', '#form-update-period', function(e) {
        var data = $(this).serialize();

        $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Period/prosesUpdate'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilPeriod();
                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-update-period").reset();
                    $('#update-period').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                }
            })

        e.preventDefault();
    });

    $('#tambah-period').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });

    $('#update-period').on('hidden.bs.modal', function() {
        $('.form-msg').html('');
    });
</script>