<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Add New Customer Data</center></h3>
    </div>
    
    <form id="form-tambah-customer" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-3" >Customer ID</label>
            <div class="col-xs-8">
              <input name="kodeCus" class="form-control" type="text" placeholder="T-123">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Virtual Code</label>
            <div class="col-xs-8">
              <input name="kodeVir" class="form-control" type="text" placeholder="123456789">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Name</label>
            <div class="col-xs-8">
              <input name="nama" class="form-control" type="text" placeholder="James">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Unit</label>
            <div class="col-xs-8">
              <input name="unit" class="form-control" type="text" placeholder="123ABC">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Address</label>
            <div class="col-xs-8">
              <textarea name="alamat" class="form-control" type="text" placeholder="Jl. Arjuna Selatan..."></textarea>
            </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Description</label>
            <div class="col-xs-8">
                <select name="jenis" class="form-control select2">
                <option selected disabled>Choose Description</option>
                    <?php
                    foreach ($dataDescription as $desc) {
                    ?>
                    <option value="<?php echo $desc->id; ?>">
                        <?php echo $desc->jenis; ?>
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
          <label class="control-label col-xs-3">Owner</label>
          <div class="col-xs-8">
            <select name="owner" class="form-control select2" style="width: 100%">
              <option selected disabled>Choose Owner</option>
              <?php
              foreach ($dataOwner as $owner) {
              ?>
                <option value="<?php echo $owner->id; ?>">
                  <?php echo $owner->id . ' - ' . $owner->nama; ?>
                </option>
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
        <button type="submit" class="btn btn-primary">Add Data</button>
      </div>
    </form>
  </div>
</div>