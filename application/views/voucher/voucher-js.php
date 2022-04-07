<script>
    $(function() {
        let startDate = "";
        let endDate = "";

        window.onload = function() {
            tampilVoucher(startDate, endDate);
        }

        $('#filter').on("click", function() {
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            tampilVoucher(startDate, endDate);
            console.log(startDate);
            console.log(endDate);
        });

        function tampilVoucher(startDate, endDate) {
            $.ajax({
                url: "<?php echo base_url('Voucher/Tampil') ?>",
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                type: "GET",
                datatype: "html",
                success: function(response) {
                    MyTable.fnDestroy();
                    $("#data-voucher").html(response);
                    refresh();
                }
            })
        }

        var id_vou;
        $(document).on("click", ".konfirmasiHapus-voucher", function() {
            id_vou = $(this).attr("data-id");
        });

        $(document).on("click", ".hapus-dataVoucher", function() {
            var id = id_vou;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Voucher/delete'); ?>",
                    data: "idVou=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilVoucher();
                    $('.msg').html(data);
                    effect_msg();
                });
        });

        $(document).on("click", ".print-dataVoucher", function() {
            var id = $(this).attr("data-id");
            var go_to_url = '<?php echo base_url('Voucher/print_received/'); ?>' + id;
            window.open(go_to_url, '_blank');
        });

        $(document).on("click", ".print-dataBayar", function() {
            var id = $(this).attr("data-id");
            var go_to_url = '<?php echo base_url('Voucher/print_bayar/'); ?>' + id;
            window.open(go_to_url, '_blank');
        });

        var id_bayar;
        $(document).on("click", ".konfirmasiHapus-bayar", function() {
            id_bayar = $(this).attr("data-id-bayar");
        });

        $(document).on("click", ".hapus-dataBayar", function() {
            var id = id_bayar;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Voucher/deleteBayar'); ?>",
                    data: "idBayar=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapusBayar').modal('hide');
                    tampilVoucher();
                    $('.msg').html(data);
                    effect_msg();
                });
        });

        $('#form-tambah-voucher').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Voucher/Tambah'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilVoucher();

                    if (out.status == 'form') {
                        $('#tambah-voucher').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    } else {
                        document.getElementById("form-tambah-voucher").reset();
                        $('#tambah-voucher').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#form-pengurangan-bank').submit(function(e) {
            var lastRowId = $('#tableBody tr:last').attr("id");
            var code = new Array();
            var relasiVendor = new Array();
            var keterangan = new Array();
            var akun = new Array();
            var debit = new Array();
            var kredit = new Array();
            var sendDate = $('#date').val();
            var sendGiro = $('#giro').val();

            for (var i = 1; i <= lastRowId; i++) {
                code.push($("#" + i + " .code" + i).html());
                relasiVendor.push($('#' + i + " .relasiVendor" + i).html());
                keterangan.push($('#' + i + " .keterangan" + i).html());
                akun.push($('#' + i + " .coa" + i).html());
                debit.push($('#' + i + " .debit").html());
                kredit.push($('#' + i + " .kredit").html());
            }

            var sendCode = JSON.stringify(code);
            var sendRelasi = JSON.stringify(relasiVendor);
            var sendKeterangan = JSON.stringify(keterangan);
            var sendAkun = JSON.stringify(akun);
            var sendDebit = JSON.stringify(debit);
            var sendKredit = JSON.stringify(kredit);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('Voucher/prosesTambah'); ?>',
                data: {
                    code: sendCode,
                    date: sendDate,
                    relasi: sendRelasi,
                    keterangan: sendKeterangan,
                    akun: sendAkun,
                    debit: sendDebit,
                    kredit: sendKredit,
                    giro: sendGiro,
                    date: sendDate
                }
            }).done(function(data) {
                var out = jQuery.parseJSON(data);

                tampilVoucher();
                if (out.status == 'form') {
                    $('#pengurangan-bank').modal('hide');
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                    $('#data_table').remove();
                    setInterval('location.reload()', 1000);
                } else {
                    document.getElementById("form-pengurangan-bank").reset();
                    $('#pengurangan-bank').modal('hide');
                    $('.msg').html(out.msg);
                    effect_msg();
                    $('#data_table').remove();
                    setInterval('location.reload()', 1000);
                }
            });
            e.preventDefault();
        });

        $('#form-bayar-ar').submit(function(e) {
            var lastRowId = $('#tableBody tr:last').attr("id");
            var arId = new Array();
            var vouId = new Array();
            var arOwner = new Array();
            var keterangan = new Array();
            var akun = new Array();
            var debit = new Array();
            var kredit = new Array();
            if ($('#periodAR').val() == '') {
                var arPeriod = 1;
            } else {
                var arPeriod = $('#periodAR').val();
            }
            var date = $('#dateVoucher').val();
            var pemType = $('#pemType').val();
            var sendGiro = $('#giroVoucher').val();
            var relasi = $('#receivedVou').val();

            for (var i = 1; i <= lastRowId; i++) {
                arId.push($("#" + i + " .arId" + i).html());
                vouId.push($("#" + i + " .vouId" + i).html());
                arOwner.push($('#' + i + " .unit" + i).html());
                keterangan.push($('#' + i + " .keterangan" + i).html());
                akun.push($('#' + i + " .akun" + i).html());
                debit.push($('#' + i + " .debit").html());
                kredit.push($('#' + i + " .kredit").html());
            }

            var sendAR = JSON.stringify(arId);
            var sendVou = JSON.stringify(vouId);
            var sendKodeOwner = JSON.stringify(arOwner);
            var sendKet = JSON.stringify(keterangan);
            var sendAkun = JSON.stringify(akun);
            var sendDebit = JSON.stringify(debit);
            var sendKredit = JSON.stringify(kredit);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('Voucher/AR'); ?>',
                data: {
                    id: sendAR,
                    bukti_transaksi: sendVou,
                    kodeOwner: sendKodeOwner,
                    keterangan: sendKet,
                    akun: sendAkun,
                    debit: sendDebit,
                    credit: sendKredit,
                    date: date,
                    period: arPeriod,
                    pemType: pemType,
                    giro: sendGiro,
                    relasi: relasi
                }
            }).done(function(data) {
                var out = jQuery.parseJSON(data);

                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                    $('#data_table').remove();
                    // setInterval('location.reload()', 1000);
                } else {
                    document.getElementById("form-bayar-ar").reset();
                    $('.msg').html(out.msg);
                    effect_msg();
                    $('#data_table').remove();
                    // setInterval('location.reload()', 1000);
                }
            });

            e.preventDefault();

        });

        $('#form-bayar-ar-titipan').submit(function(e) {
            var lastRowId = $('#tableBody tr:last').attr("id");
            var arId = new Array();
            var vouId = new Array();
            var arOwner = new Array();
            var keterangan = new Array();
            var akun = new Array();
            var debit = new Array();
            var kredit = new Array();
            var arPeriod = $('#periodAR').val();
            var date = $('#dateVoucher').val();
            var dtId = $('#dtTitipan').val();
            var pemType = $('#pemType').val();
            var sendGiro = $('#giroVoucher').val();
            var relasi = $('#relasiDT').val();
            var so = $('#soDT').val();
            var total = $('#totalDT').val();

            for (var i = 1; i <= lastRowId; i++) {
                arId.push($("#" + i + " .arId" + i).html());
                vouId.push($("#" + i + " .vouId" + i).html());
                arOwner.push($('#' + i + " .unit" + i).html());
                keterangan.push($('#' + i + " .keterangan" + i).html());
                akun.push($('#' + i + " .akun" + i).html());
                debit.push($('#' + i + " .debit").html());
                kredit.push($('#' + i + " .kredit").html());
            }

            var sendAR = JSON.stringify(arId);
            var sendVou = JSON.stringify(vouId);
            var sendKodeOwner = JSON.stringify(arOwner);
            var sendKet = JSON.stringify(keterangan);
            var sendAkun = JSON.stringify(akun);
            var sendDebit = JSON.stringify(debit);
            var sendKredit = JSON.stringify(kredit);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('Voucher/ART'); ?>',
                data: {
                    id: sendAR,
                    bukti_transaksi: sendVou,
                    idt: dtId,
                    kodeOwner: sendKodeOwner,
                    keterangan: sendKet,
                    akun: sendAkun,
                    debit: sendDebit,
                    credit: sendKredit,
                    date: date,
                    period: arPeriod,
                    pemType: pemType,
                    giro: sendGiro,
                    relasi: relasi,
                    so: so,
                    total: total
                }
            }).done(function(data) {
                var out = jQuery.parseJSON(data);

                if (out.status == 'form') {
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                    $('#data_table').remove();
                    setInterval('location.reload()', 1000);
                } else {
                    document.getElementById("form-bayar-ar-titipan").reset();
                    $('.msg').html(out.msg);
                    effect_msg();
                    $('#data_table').remove();
                    setInterval('location.reload()', 1000);
                }
            });

            e.preventDefault();

        });

        $(document).on("click", ".update-dataVoucher", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Voucher/update'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#update-voucher').modal('show');
                });
        })

        $(document).on('submit', '#form-update-voucher', function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Voucher/prosesUpdate'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilVoucher();
                    if (out.status == 'form') {
                        $('.form-msg').html(out.msg);
                        effect_msg_form();
                    } else {
                        document.getElementById("form-update-voucher").reset();
                        $('#update-voucher').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-voucher').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });

        $('#pengurangan-bank').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });

        $('#bayar-ar').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });

    });
</script>