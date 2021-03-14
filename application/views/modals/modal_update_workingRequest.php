<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Working Request Bill</center></h3>
    </div>
    
    <form method="POST" id="form-update-workingRequest">
      <div class="modal-body">
      <input type="hidden" name="noInvoiceWR" value="<?php echo $dataWorkingRequest->no_invoice_wr; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3" >Working Request Bill Code</label>
            <div class="col-xs-8">
              <input name="noInvoiceWR" class="form-control" type="text" value="<?php echo $dataWorkingRequest->no_invoice_wr; ?>" readonly>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >No WO</label>
            <div class="col-xs-8">
              <input name="noWO" class="form-control" type="text" placeholder="No WO" value="<?php echo $dataWorkingRequest->no_wo; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >No WR</label>
            <div class="col-xs-8">
              <input name="noWR" class="form-control" type="text" placeholder="No WR" value="<?php echo $dataWorkingRequest->no_wr; ?>">
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Customer ID</label>
            <div class="col-xs-8">
                <select name="idCustomer" class="form-control select2" style="width: 100%">
                    <?php
                    foreach ($dataCustomer as $cus) {
                    ?>
                    <option value="<?php echo $cus->kodeCus; ?>" <?php if($cus->kodeCus == $dataWorkingRequest->id_customer){echo "selected='selected'";} ?>><?php echo $cus->kodeCus . ' - ' . $cus->nama; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Tanggal</label>
            <div class="col-xs-8">
              <input name="tanggal" class="form-control" type="date" value="<?php echo $dataWorkingRequest->tanggal; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Keterangan</label>
            <div class="col-xs-8">
              <input name="keterangan" class="form-control" type="text" placeholder="Keterangan" value="<?php echo $dataWorkingRequest->keterangan; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Total</label>
            <div class="col-xs-8">
              <input name="total" id="total" class="form-control" type="text" placeholder="Total" value="<?php echo $dataWorkingRequest->total; ?>">
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

<script type="text/javascript">
  $(function() {
    $(".select2").select2();
  });
</script>