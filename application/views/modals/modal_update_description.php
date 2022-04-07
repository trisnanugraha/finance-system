<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Description Data</center></h3>
    </div>
    
    <form method="POST" id="form-update-description" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $dataDescription->id; ?>">  
      <div class="modal-body">
       
        <div class="form-group">
          <label class="control-label col-xs-3" >Group</label>
            <div class="col-xs-8">
              <input name="jenis" class="form-control" type="text" placeholder="SCBD Area" value="<?php echo $dataDescription->jenis; ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Type</label>
            <div class="col-xs-8">
              <input name="tipe" class="form-control" type="text" placeholder="Single Bed Room" value="<?php echo $dataDescription->tipe; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Spacius Room</label>
            <div class="col-xs-8">
              <input name="sqm" class="form-control" type="text" placeholder="100" value="<?php echo $dataDescription->sqm; ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Electricity Capacity</label>
            <div class="col-xs-8">
              <input name="kapasitas" class="form-control" type="text" placeholder="35" value="<?php echo $dataDescription->kapasitas; ?>">
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