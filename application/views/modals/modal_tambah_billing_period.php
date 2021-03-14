<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Billing By Period</center>
      </h3>
    </div>

    <form id="form-tambah-billing-period" method="POST">
      <div class="modal-body">

        <div class="form-group">
          <label class="control-label col-xs-3">Period</label>
          <div class="col-xs-8">
            <select name="period" id="period" class="form-control select2 period" style="width: 100%">
              <option selected disabled>Choose Period</option>
              <?php
              foreach ($dataPeriod as $period) {
              ?>
                <option value="<?php echo $period->id; ?>" data-due="<?= $period->dueDate; ?>">
                  <?php echo date('d/m/Y', strtotime($period->periodStart)) . ' ~ ' . date('d/m/Y', strtotime($period->periodEnd)); ?>
                </option>
              <?php
              }
              ?>
            </select>
            <!-- <input name="period" class="form-control" type="text" placeholder="Period"> -->
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
