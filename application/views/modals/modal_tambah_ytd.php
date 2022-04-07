<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New YTD BUDGET</center></h3>
    </div>
    
    <form id="form-tambah-ytd" method="POST" autocomplete="off">   
        <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-4">YTD COA</label>
          <div class="col-xs-8">
            <select name="ytd_coa" id="ytd_coa" class="form-control select2" style="width: 100%;">
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
          <label class="control-label col-xs-4">YTD YEAR</label>
            <div class="col-xs-8">
              <input name="ytd_year" id="ytd_year" class="form-control" type="text" placeholder="YTD Year">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">YTD TOTAL</label>
            <div class="col-xs-8">
              <input name="ytd_total" id="ytd_total" class="form-control" type="text" placeholder="YTD Total">
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

<script type="text/javascript">
  $(function() {
    $(".select2").select2();
  });
</script>