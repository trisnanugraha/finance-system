<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Add New Charts Of Accounts</center></h3>
    </div>
    
    <form id="form-tambah-coa" method="POST">
      <div class="modal-body">
      <div class="form-group">
          <label class="control-label col-xs-3" >CoA Parent</label>
            <div class="col-xs-8">
                <select name="parent" class="form-control select2">
                <option selected disabled>Choose CoA Parent</option>
                    <?php
                    foreach ($dataCoa as $coa) {
                    ?>
                    <option value="<?php echo $coa->id_akun; ?>">
                        <?php echo $coa->coa_id . ' ~ '. $coa->coa_name; ?>
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
          <label class="control-label col-xs-3" >CoA ID</label>
            <div class="col-xs-8">
              <input name="coa_id" class="form-control" type="text" placeholder="CoA ID">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >CoA Name</label>
            <div class="col-xs-8">
              <input name="coa_name" class="form-control" type="text" placeholder="CoA Name">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Coa Account Type</label>
            <div class="col-xs-8">
              <input name="acc_type" class="form-control" type="text" placeholder="Bermutasi/Tidak Bermutasi">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >CoA Jurnal Type</label>
            <div class="col-xs-8">
                <select name="jurnal" class="form-control select2">
                <option selected disabled>Choose CoA Jurnal Type</option>
                    <?php
                    foreach ($dataType as $type) {
                    ?>
                    <option value="<?php echo $type->id; ?>">
                        <?php echo $type->name; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary">Add Data</button>
      </div>
    </form>
  </div>
</div>