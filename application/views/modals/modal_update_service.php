<<<<<<< HEAD
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Service Charge</center></h3>
    </div>
    
    <form method="POST" id="form-update-service">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?php echo $dataService->id; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3" >Type</label>
            <div class="col-xs-8">
              <input class="form-control" type="text" readonly value="<?php echo ($dataService->tipe); ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >SQM</label>
            <div class="col-xs-8">
              <input name="sqm" class="form-control" type="text" value="<?php echo floatval($dataService->sqm); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Sinking Fund</label>
            <div class="col-xs-8">
              <input name="fund" class="form-control" type="text" value="<?php echo floatval($dataService->fund); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Service Charge</label>
            <div class="col-xs-8">
              <input name="charge" class="form-control" type="text" value="<?php echo floatval($dataService->charge); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Cycle</label>
            <div class="col-xs-8">
              <input name="cycle" class="form-control" type="text" value="<?php echo ($dataService->cycle); ?>">
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
=======
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Service Charge</center></h3>
    </div>
    
    <form method="POST" id="form-update-service">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?php echo $dataService->id; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3" >Type</label>
            <div class="col-xs-8">
              <input class="form-control" type="text" readonly value="<?php echo ($dataService->tipe); ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >SQM</label>
            <div class="col-xs-8">
              <input name="sqm" class="form-control" type="text" value="<?php echo floatval($dataService->sqm); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Sinking Fund</label>
            <div class="col-xs-8">
              <input name="fund" class="form-control" type="text" value="<?php echo floatval($dataService->fund); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Service Charge</label>
            <div class="col-xs-8">
              <input name="charge" class="form-control" type="text" value="<?php echo floatval($dataService->charge); ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Cycle</label>
            <div class="col-xs-8">
              <input name="cycle" class="form-control" type="text" value="<?php echo ($dataService->cycle); ?>">
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
>>>>>>> 7c969767479f811de5dbca0a287557647997c435
</div>