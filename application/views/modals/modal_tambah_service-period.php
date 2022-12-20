<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary ">
            <h3 class="modal-title">
                <center>Add New Service (Period)</center>
            </h3>
        </div>

        <form id="form-tambah-service-period" method="POST">
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label col-xs-4">Period</label>
                    <div class="col-xs-8">
                        <select name="periodbill" id="periodbill" class="form-control select2 periodbill" style="width: 100%">
                            <option selected disabled>Choose Period</option>
                            <?php foreach ($dataPeriod as $period) : ?>
                                <option value="<?= $period->id ?>">
                                    <?= date('F Y', strtotime($period->first_day)) . ' ~ ' . date('F Y', strtotime($period->last_day)) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <br>
                <br>

                <div class="form-group">
                    <label class="control-label col-xs-4">Sinking Fund Rates</label>
                    <div class="col-xs-3">
                        <input type="hidden" name="hiddenIdTarif" value=<?= $dataRates == null ? '' : $dataRates->id ?> />

                        <input type="hidden" name="hiddenSiningRates" value=<?= $dataRates == null ? '' : $dataRates->sinking ?> />
                        <span id="sinkingRate"><?= $dataRates == null ? "Not set" : rupiah($dataRates->sinking) ?></span>

                        </select>
                    </div>
                </div>
                <br>
                <br>

                <div class="form-group">
                    <label class="control-label col-xs-4">Service Charge Rates</label>
                    <div class="col-xs-3">
                        <input type="hidden" name="hiddenIdTarif2" value=<?= $dataRates == null ? '' : $dataRates->id ?> />

                        <input type="hidden" name="hiddenServiceRates" value=<?= $dataRates == null ? '' : $dataRates->service ?> />
                        <span id="serviceRate"><?= $dataRates == null ? "Not set" : rupiah($dataRates->service) ?></span>

                        </select>
                    </div>
                </div>
                <br>
                <br>

                <div class="form-group">
                    <label class="control-label col-xs-4">Available</label>
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
            url: '<?php echo base_url('Service/countAvailableServicePeriod') ?>',
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

        $('#form-tambah-service-period').submit(function(e) {
            var period = $("#periodbill").find(':selected').val();
            var tarif = <?= $dataRates == null ? '' : $dataRates->id ?>;
            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Service/prosesTambahByPeriod') ?>',
                    data: {
                        period: period,
                        tarif: tarif
                    }
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data)

                    if (out.status == 'form') {
                        $('#add-service-period').modal('hide')
                        $('.msg').html(out.msg)
                        effect_msg()
                        setInterval('location.reload()', 1000)
                    } else {
                        document.getElementById("form-tambah-service").reset()
                        $('#add-service-period').modal('hide')
                        $('.msg').html(out.msg)
                        effect_msg()
                        setInterval('location.reload()', 1000)
                    }
                })

            e.preventDefault()
        })
    })
</script>
