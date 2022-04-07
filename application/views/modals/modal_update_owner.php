<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Update Owner Data</center>
      </h3>
    </div>

    <form method="POST" id="form-update-owner" autocomplete="off">
      <div class="modal-body">
        <input type="hidden" name="id" value="<?php echo $dataOwner->id; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3">Owner ID</label>
          <div class="col-xs-8">
            <input class="form-control" type="text" disabled value="<?php echo $dataOwner->id; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Virtual Code</label>
          <div class="col-xs-8">
            <input name="kodeVir" class="form-control" type="text" placeholder="123456789" value="<?php echo $dataOwner->kodeVir; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Name</label>
          <div class="col-xs-8">
            <input name="nama" class="form-control" type="text" placeholder="Brandon" value="<?php echo $dataOwner->nama; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Unit</label>
          <div class="col-xs-8">
            <input name="unit" class="form-control" type="text" placeholder="123A" value="<?php echo $dataOwner->unit; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Address</label>
          <div class="col-xs-8">
            <input name="alamat" class="form-control" type="text" placeholder="Jl. Arjuna Utara..." value="<?php echo $dataOwner->alamat; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Description</label>
          <div class="col-xs-8">
            <select name="jenis" class="form-control select2">
              <?php
              foreach ($dataDescription as $desc) {
              ?>
                <option value="<?php echo $desc->id; ?>" <?php if ($desc->id == $dataOwner->id_deskripsi) {
                                                            echo "selected='selected'";
                                                          } ?>><?php echo $desc->jenis; ?></option>
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