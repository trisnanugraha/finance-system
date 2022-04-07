<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Voucher</center>
      </h3>
    </div>

    <form id="form-tambah-voucher" method="POST" autocomplete="off">
      <div class="modal-body">

        <div class="form-group">
          <label class="control-label col-xs-4">Voucher ID</label>
          <div class="col-xs-8">
            <input name="id" id="id" class="form-control" type="text" placeholder="Transaction Code">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Received From Customer/Owner</label>
          <div class="col-xs-8">
            <select name="receivedVou" id="receivedVou" class="form-control select2" style="width: 100%">
              <option value="0">Umum</option>
              <option value="1">Customer</option>
              <option value="2">Owner</option>
            </select>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Unit</label>
          <div class="col-xs-8">
            <select name="kodeOwner" id="kodeOwner" class="form-control select2">
              <option selected disabled>Choose Unit</option>
              <?php
              foreach ($dataOwner as $owner) {
              ?>
                <option value="<?php echo $owner->id; ?>">
                  <?php echo $owner->unit; ?>
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
          <label class="control-label col-xs-4">Voucher Date</label>
          <div class="col-xs-8">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input name="dateVoucher" id="dateVoucher" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
            </div>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Transaction Type</label>
          <div class="col-xs-8">
            <select name="giroVoucher" id="giroVoucher" class="form-control select2">
              <option selected disabled>Choose Transaction Type</option>
              <?php
              foreach ($dataGiroType as $giroType) {
              ?>
                <option value="<?php echo $giroType->giro_type_id; ?>">
                  <?php echo '[' . $giroType->giro_type_id . '] - ' . $giroType->type_giro_name; ?>
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
          <label class="control-label col-xs-4">Bank</label>
          <div class="col-xs-8">
            <select name="BankVoucher" id="BankVoucher" class="form-control select2">
              <option selected disabled>Choose Bank</option>
              <?php
              foreach ($dataBank as $bank) {
              ?>
                <option value="<?php echo $bank->coa_id; ?>">
                  <?php echo $bank->coa_id . ' - ' . $bank->coa_name; ?>
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
          <label class="control-label col-xs-4">Keterangan</label>
          <div class="col-xs-8">
            <textarea name="keteranganVoucher" id="keteranganVoucher" class="form-control" type="text" placeholder="Keterangan"></textarea>
          </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Total Voucher</label>
          <div class="col-xs-8">
            <input name="totalVoucher" id="totalVoucher" class="form-control" type="text" placeholder="Total Voucher">
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