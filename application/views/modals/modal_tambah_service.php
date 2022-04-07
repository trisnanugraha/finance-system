<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Service Bill</center>
      </h3>
    </div>

    <form id="form-tambah-service" method="POST">
      <div class="modal-body">

        <div class="form-group">
          <label class="control-label col-xs-4">Owner</label>
          <div class="col-xs-8">
            <select name="kodeOwner" id="kodeOwner" class="form-control select2 kodeOwner" style="width: 100%">
              <option selected disabled>Choose Owner</option>
              <?php
              foreach ($dataOwner as $owner) {
              ?>
                <option value="<?php echo $owner->id; ?>" data-luas="<?= $owner->sqm; ?>"? >
                  <?php echo $owner->id . ' - ' . $owner->nama; ?>
                </option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Spacious Room</label>
          <div class="col-xs-3">
            <input type="hidden" name="hiddenLuas"/>

            <span id="luas">-</span>
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

        <div class="form-group">
          <label class="control-label col-xs-4">Period</label>
          <div class="col-xs-8">
            <select name="period" id="period" class="form-control select2 period" style="width: 100%">
              <option selected disabled value="-99">Choose Period</option>
              <?php
              foreach ($dataPeriod as $period) {
              ?>
                <option value="<?php echo $period->id; ?>">
                  <?php echo date('d/m/Y', strtotime($period->start_periode)) . ' ~ ' . date('d/m/Y', strtotime($period->end_periode)); ?>
                </option>
              <?php
              }
              ?>
            </select>
            <input name="hiddenAmount" id="hiddenAmount" type="hidden" />
          </div>
        </div>
        <br>
        <br>

      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" id="save" class="btn btn-primary">Add Data</button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $(".select2").select2();
  });
</script>

<script>
$(document).ready(function(){
    $('#save').click(function(){
      var sendPeriod = $('#period').val();
      var sendKodeOwner = $('#kodeOwner').val();
      var sendTarif = <?= $dataRates == null ? '' : $dataRates->id; ?>;
      
        $.ajax({
            type : 'POST',
            url  : '<?php echo base_url('GL/service'); ?>',
            data : {period : sendPeriod, kodeOwner : sendKodeOwner, tarif : sendTarif},
            success : function(data){
            }
        });

        $.ajax({
            type : 'POST',
            url  : '<?php echo base_url('AR/service'); ?>',
            data : { period : sendPeriod, kodeOwner : sendKodeOwner, tarif : sendTarif},
            success : function(data){
            }
        });
    });
});
</script>

<script type="text/javascript">
  $("#kodeOwner").on("change", function() {
    var luas = $(this).find(':selected').attr('data-luas');
    $("#luas").text(luas);
  });
</script>