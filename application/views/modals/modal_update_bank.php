<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Bank Account</center></h3>
    </div>
    
    <form method="POST" id="form-update-bank">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?php echo $dataBank->id; ?>">
      <div class="form-group">
          <label class="control-label col-xs-3" >Bank ID</label>
            <div class="col-xs-8">
              <input class="form-control" type="text" disabled value="<?php echo $dataBank->id; ?>">
            </div>
        </div>
        <br>
        <br>
       
        <div class="form-group">
          <label class="control-label col-xs-3" >Account</label>
            <div class="col-xs-8">
              <input name="rekening" class="form-control" type="text" value="<?php echo $dataBank->rekening; ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Name</label>
            <div class="col-xs-8">
              <input name="nama" class="form-control" type="text" value="<?php echo $dataBank->nama; ?>">
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