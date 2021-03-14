<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Add New Bank Account</center></h3>
    </div>
    
    <form id="form-tambah-bank" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-3" >Bank ID</label>
            <div class="col-xs-8">
              <input name="id" class="form-control" type="text" placeholder="Bank ID">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Account</label>
            <div class="col-xs-8">
              <input name="rekening" class="form-control" type="text" placeholder="Account">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Name</label>
            <div class="col-xs-8">
              <input name="nama" class="form-control" type="text" placeholder="Name">
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