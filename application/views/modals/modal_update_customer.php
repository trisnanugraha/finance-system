<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Customer Data</center></h3>
    </div>
    
    <form method="POST" id="form-update-customer">
      <div class="modal-body">
      <input type="hidden" name="kodeCus" value="<?php echo $dataCustomer->kodeCus; ?>">
      <div class="form-group">
          <label class="control-label col-xs-3" >Customer ID</label>
            <div class="col-xs-8">
              <input class="form-control" type="text" disabled value="<?php echo $dataCustomer->kodeCus; ?>">
            </div>
        </div>
        <br>
        <br>
       
        <div class="form-group">
          <label class="control-label col-xs-3" >Virtual Code</label>
            <div class="col-xs-8">
              <input name="kodeVir" class="form-control" type="text" placeholder="123456789" value="<?php echo $dataCustomer->kodeVir; ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Name</label>
            <div class="col-xs-8">
              <input name="nama" class="form-control" type="text" placeholder="James" value="<?php echo $dataCustomer->nama; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Unit</label>
            <div class="col-xs-8">
              <input name="unit" class="form-control" type="text" placeholder="123ABC" value="<?php echo $dataCustomer->unit; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Address</label>
            <div class="col-xs-8">
              <input name="alamat" class="form-control" type="text" placeholder="Jl. Arjuna Selatan..." value="<?php echo $dataCustomer->alamat; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Description</label>
            <div class="col-xs-8">
                <select name="jenis" class="form-control select2">
                <?php
                foreach ($dataDescription as $desc) {
                ?>
                <option value="<?php echo $desc->id; ?>" <?php if($desc->id == $dataCustomer->jenis){echo "selected='selected'";} ?>><?php echo $desc->jenis; ?></option>
                <?php
                }
                ?>
            </select>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Owner</label>
            <div class="col-xs-8">
                <select name="owner" class="form-control select2">
                <?php
                foreach ($dataOwner as $owner) {
                ?>
                <option value="<?php echo $owner->id; ?>" <?php if($owner->id == $dataCustomer->owner){echo "selected='selected'";} ?>><?php echo $owner->id . ' - ' . $owner->nama; ?></option>
                <?php
                }
                ?>
            </select>
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