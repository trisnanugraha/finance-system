<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary ">
            <h3 class="modal-title">
                <center>Add New Data Period</center>
            </h3>
        </div>

        <form method="POST" id="form-tambah-period">
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-xs-3">Period Range</label>
                    <div class="col-xs-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="hidden" name="hiddenPeriodStart" id="tambahPeriodStart" value="<?= date('Y/m/d'); ?>"/>
                            <input type="hidden" name="hiddenPeriodEnd" id="tambahPeriodEnd" value="<?php $due = new DateTime('+1day'); echo $due->format('Y/m/d'); ?>"/>
                            <input type="text" name="tambahPeriodRange" class="form-control pull-right" id="tambahPeriodRange" autocomplete="off">
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
                            <input type="hidden" name="hiddenPeriodDue" id="tambahPeriodDueDate" value="<?php $due = new DateTime('+1day'); echo $due->format('Y/m/d'); ?>"/>
                            <input name="tambahDueDate" id="tambahDueDate" type="text" class="form-control pull-right">
                        </div>
                    </div>
                </div>
                <br>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                <button type="submit" class="btn btn-primary">Add Data</button>
            </div>
        </form>
    </div>
</div>