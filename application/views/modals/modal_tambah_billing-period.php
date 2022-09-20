<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary ">
            <h3 class="modal-title">
                <center>Add New Billing (Period)</center>
            </h3>
        </div>

        <form id="form-tambah-billing-period" method="POST">
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label col-xs-3">Period</label>
                    <div class="col-xs-8">
                        <select name="periodbill" id="periodbill" class="form-control select2 periodbill" style="width: 100%">
                            <option selected disabled>Choose Period</option>
                            <?php foreach ($dataPeriod as $period) : ?>
                                <option value="<?= $period->id ?>">
                                    <?= toDate2($period->periodStart) . " ~ " . toDate2($period->periodEnd) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <br><br>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Available</label>
                        <div class="col-xs-8">
                            <input id="availablebill" name="availablebill" class="form-control" type="text" readonly placeholder="Available Bill">
                        </div>
                    </div>
                    <br>
                    <br>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    <button type="submit" class="btn btn-primary">Add Data</button>
                </div>
        </form>
    </div>
</div>

<script>
    $('#periodbill').on("change", function() {
        var period = $("#periodbill").find(':selected').val()
        $.ajax({
            method: 'GET',
            url: '<?php echo base_url('Billing/countAvailableBillingPeriod') ?>',
            data: {
                period: period
            },
            dataType: 'json',
            success: function(result) {
                $("#availablebill").val(result.count + " Bills")
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError)
            }
        })

        $('#form-tambah-billing-period').submit(function(e) {
            var period = $("#periodbill").find(':selected').val()
            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Billing/prosesTambahByPeriod') ?>',
                    data: {
                        period: period
                    }
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data)

                    if (out.status == 'form') {
                        $('#add-billing-period').modal('hide')
                        $('.msg').html(out.msg)
                        effect_msg()
                        setInterval('location.reload()', 1000)
                    } else {
                        document.getElementById("form-tambah-billing").reset()
                        $('#add-billing-period').modal('hide')
                        $('.msg').html(out.msg)
                        effect_msg()
                        setInterval('location.reload()', 1000)
                    }
                })

            e.preventDefault()
        })
    })
</script>