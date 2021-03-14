<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Add New Rate Data</center></h3>
    </div>
    
    <form method="POST" id="form-tambah-rates">
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-3" >Standing Charge</label>
            <div class="col-xs-8">
              <input name="charge" class="form-control" type="text" placeholder="10000">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Water</label>
            <div class="col-xs-8">
              <input name="water" class="form-control" type="text" placeholder="12500">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Electricity</label>
            <div class="col-xs-8">
              <input name="electric" class="form-control" type="text" placeholder="1400.25">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Sinking fund</label>
            <div class="col-xs-8">
              <input name="sinking" class="form-control" type="text" placeholder="3000">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Service Charge</label>
            <div class="col-xs-8">
              <input name="service" class="form-control" type="text" placeholder="35000">
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