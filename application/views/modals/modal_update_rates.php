<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Rates List</center></h3>
    </div>
    
    <form method="POST" id="form-update-rates">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?php echo $dataRates->id; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3" >Standing Charge</label>
            <div class="col-xs-8">
              <input name="charge" class="form-control" type="text" placeholder="10000" value="<?php echo floatval($dataRates->charge); ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Water</label>
            <div class="col-xs-8">
              <input name="water" class="form-control" type="text" placeholder="12500" value="<?php echo floatval($dataRates->water); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Electricity</label>
            <div class="col-xs-8">
              <input name="electric" class="form-control" type="text" placeholder="1400.25" value="<?php echo floatval($dataRates->electric); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Sinking Fund</label>
            <div class="col-xs-8">
              <input name="sinking" class="form-control" type="text" placeholder="3000" value="<?php echo floatval($dataRates->sinking); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Service Charge</label>
            <div class="col-xs-8">
              <input name="service" class="form-control" type="text" placeholder="35000" value="<?php echo floatval($dataRates->service); ?>">
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