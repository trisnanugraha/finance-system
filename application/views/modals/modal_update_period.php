<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary ">
            <h3 class="modal-title">
                <center>Update Period</center>
            </h3>
        </div>

        <form method="POST" id="form-update-period">
            <div class="modal-body">
                <input type="hidden" name="id" value="<?php echo $dataPeriod->id; ?>">
                <div class="form-group">
                    <label class="control-label col-xs-3">Period Range</label>
                    <div class="col-xs-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="hidden" name="hiddenPeriodStart" id="periodStart" value="<?php echo $dataPeriod->periodStart; ?>" />
                            <input type="hidden" name="hiddenPeriodEnd" id="periodEnd" value="<?php echo $dataPeriod->periodEnd; ?>" />
                            <input type="text" name="periodRange" class="form-control pull-right" id="periodRange">
                        </div>
                    </div>
                </div>
                <br>
                <br>

                <div class="form-group">
                    <label class="control-label col-xs-3">Due Date</label>
                    <div class="col-xs-8">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="hidden" name="hiddenPeriodDue" id="periodDueDate" value="<?php echo $dataPeriod->dueDate; ?>" />
                            <input name="dueDate" id="dueDate" type="text" class="form-control pull-right">
                        </div>
                    </div>
                </div>
                <br>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>