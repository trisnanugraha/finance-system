<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New WR Bill</center>
      </h3>
    </div>

    <form id="form-tambah-workingRequest" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-3">WR Bill Code</label>
          <div class="col-xs-8">
            <input name="noInvoiceWR" id="noInvoiceWR" class="form-control" type="text" placeholder="IN-WR/20/01/001">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">No. WO</label>
          <div class="col-xs-8">
            <input name="noWO" id="noWO" class="form-control" type="text" placeholder="S.S.00001">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">No. WR</label>
          <div class="col-xs-8">
            <input name="noWR" id="noWR" class="form-control" type="text" placeholder="A.01000">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Customer</label>
          <div class="col-xs-8">
            <select name="idCustomer" class="form-control select2" id="idCustomer" style="width: 100%">
              <option selected disabled>Choose Customer</option>
              <?php
              foreach ($dataCustomer as $cus) {
              ?>
                <option value="<?php echo $cus->kodeCus; ?>">
                  <?php echo $cus->kodeCus . ' - ' . $cus->nama; ?>
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
          <label class="control-label col-xs-3">Tanggal</label>
          <div class="col-xs-8">
              <div class="input-group date">
                  <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </div>
                  <input name="tanggal" id="tanggal" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
              </div>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Keterangan</label>
            <div class="col-xs-8">
              <textarea name="keterangan" id="keterangan" class="form-control" type="text" placeholder="Penyemprotan Disinfektan..."></textarea>
            </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Total</label>
          <div class="col-xs-8">
            <input name="total" id="total" class="form-control" type="text" placeholder="1500000">
          </div>
        </div>
        <br>
        <br>

      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" id="save" class="btn btn-primary">Add Data</button>
      </div>
    </form>
  </div>
</div>