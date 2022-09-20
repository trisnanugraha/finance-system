<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary ">
            <h3 class="modal-title">
                <center>Add New IPK</center>
            </h3>
        </div>

        <form id="form-tambah-iuran" method="POST">
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label col-xs-4">Period</label>
                    <div class="col-xs-8">
                        <select name="period" id="period" class="form-control select2 period" style="width: 100%">
                            <option selected disabled>Choose Period</option>
                            <?php foreach ($dataPeriod as $period) : ?>
                                <option value="<?= $period->id ?>">
                                    <?= date('d F Y', strtotime($period->first_day)) . ' ~ ' . date('d F Y', strtotime($period->last_day)) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <br>
                <br>

                <div class="form-group">
                    <label class="control-label col-xs-4">Total IPK</label>
                    <div class="col-xs-8">
                        <input name="total" id="total" class="form-control perhitungan" type="number" placeholder="100">
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
    $('#period').on("change", function() {
        var period = $("#period").find(':selected').val()
        $.ajax({
            method: 'GET',
            url: '<?php echo base_url('Iuran/countAvailablePeriod') ?>',
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
    })
</script>