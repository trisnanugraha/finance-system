<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New MTD BUDGET</center></h3>
    </div>
    
    <form id="form-tambah-mtd" method="POST">   
        <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-4">MTD COA</label>
          <div class="col-xs-8">
            <select name="mtd_coa" id="mtd_coa" class="form-control select2">
              <option selected disabled>Choose CoA</option>
                  <?php
                  foreach ($dataCoA as $coa) {
                  ?>
                  <option value="<?php echo $coa->id_akun; ?>">
                      <?php echo $coa->coa_id . ' - ' . $coa->coa_name; ?>
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
          <label class="control-label col-xs-4">MTD MONTH</label>
            <div class="col-xs-8">
              <select name="mtd_month" id="mtd_month" class="form-control select2" style="width: 100%">
                <option selected disabled>Choose Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">MTD YEAR</label>
            <div class="col-xs-8">
              <input name="mtd_year" id="mtd_year" class="form-control" type="text" placeholder="MTD Year">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">MTD TOTAL</label>
            <div class="col-xs-8">
              <input name="mtd_total" id="mtd_total" class="form-control" type="text" placeholder="MTD Total">
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