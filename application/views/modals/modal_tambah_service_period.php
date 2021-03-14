<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Service By Period</center>
      </h3>
    </div>

    <form id="form-tambah-service-period" method="POST">
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
                  <?php echo date('d/m/Y', strtotime($period->periodStart)) . ' ~ ' . date('d/m/Y', strtotime($period->end_periode)); ?>
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

        <div class="form-group">
            <label class="control-label col-xs-4">Sinking Fund Rates</label>
            <div class="col-xs-5">
              <input type="hidden" name="hiddenIdTarif" value=<?= $dataRates == null ? '' : $dataRates->id; ?> />

              <input type="hidden" name="hiddenSiningRates" value=<?= $dataRates == null ? '' : $dataRates->sinking; ?> />
              <span id="sinkingRate"><?= $dataRates == null ? "Not set" : rupiah($dataRates->sinking); ?></span>

              </select>
            </div>
          </div>
          <br>
          <br>

          <div class="form-group">
            <label class="control-label col-xs-4">Service Charge Rates</label>
            <div class="col-xs-5">
              <input type="hidden" name="hiddenIdTarif2" value=<?= $dataRates == null ? '' : $dataRates->id; ?> />

              <input type="hidden" name="hiddenServiceRates" value=<?= $dataRates == null ? '' : $dataRates->service; ?> />
              <span id="serviceRate"><?= $dataRates == null ? "Not set" : rupiah($dataRates->service); ?></span>

              </select>
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
