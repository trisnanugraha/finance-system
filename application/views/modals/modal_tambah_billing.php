<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary ">
            <h3 class="modal-title">
                <center>Add New Billing</center>
            </h3>
        </div>

        <form id="form-tambah-billing" method="POST">
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label col-xs-3">Customer</label>
                    <div class="col-xs-8">
                        <select name="kodeCus" id="kodeCus" class="form-control select2 kodeCus" style="width: 100%">
                            <option selected disabled>Choose Customer</option>
                            <?php foreach ($dataCustomer as $cus) { ?>
                                <option value="<?php echo $cus->kodeCus ?>">
                                    <?php echo $cus->kodeCus . ' - ' . $cus->nama ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br>
                <br>

                <div class="form-group">
                    <label class="control-label col-xs-3">Period</label>
                    <div class="col-xs-8">
                        <select name="period" id="period" class="form-control select2 period" style="width: 100%">
                            <option selected disabled value="-99">Choose Period</option>
                            <?php foreach ($dataPeriod as $period) { ?>
                                <option value="<?php echo $period->id ?>">
                                    <?php echo date('d/m/Y', strtotime($period->periodStart)) . ' ~ ' . date('d/m/Y', strtotime($period->periodEnd)) ?>
                                </option>
                            <?php } ?>
                        </select>
                        <input name="hiddenAmount" id="hiddenAmount" type="hidden" />
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
</div