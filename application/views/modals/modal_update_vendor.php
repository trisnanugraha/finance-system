<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Update Voucher Data</center>
      </h3>
    </div>

    <form method="POST" id="form-update-voucher">
      <div class="modal-body">
        <input type="hidden" name="id" value="<?php echo $dataVoucher->id_voucher; ?>">
        <input type="hidden" name="idgl" value="<?php echo $dataVoucher->id_gl; ?>">
        <input type="hidden" name="idvendor" value="<?php echo $dataVoucher->id_vendor; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3">Vendor ID</label>
          <div class="col-xs-8">
            <input class="form-control" type="text" disabled value="<?php echo $dataVoucher->id_voucher; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Nama Relasi</label>
          <div class="col-xs-8">
            <input name="relasi" class="form-control" type="text" value="<?php echo $dataVoucher->relasi; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Voucher Date</label>
          <div class="col-xs-8">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input name="vouDate" id="vouDate" type="text" class="form-control pull-right datepicker" value="<?php echo $dataVoucher->tanggal_voucher; ?>">
            </div>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Transaction Type</label>
          <div class="col-xs-8">
            <select name="giro" class="form-control select2">
              <?php
              foreach ($dataGiroType as $giro) {
              ?>
                <option value="<?php echo $giro->giro_type_id; ?>" <?php if ($giro->giro_type_id == $dataVoucher->tipe_giro) {
                                                                      echo "selected='selected'";
                                                                    } ?>><?php echo $giro->type_giro_name; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Keterangan</label>
          <div class="col-xs-8">
            <textarea name="keterangan" class="form-control select2" type="text"><?php echo $dataVoucher->keterangan; ?></textarea>
          </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group" hidden>
          <label class="control-label col-xs-3">Voucher Bank</label>
          <div class="col-xs-8">
            <select name="bank" class="form-control select2">
              <?php
              foreach ($dataBank as $bank) {
              ?>
                <option value="<?php echo $bank->id_akun; ?>" <?php if ($bank->id_akun == $dataVoucher->bank) {
                                                                echo "selected='selected'";
                                                              } ?>><?php echo $bank->coa_id . ' - ' . $bank->coa_name; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group" hidden>
          <label class="control-label col-xs-3">Total Voucher</label>
          <div class="col-xs-8">
            <input name="vouTotal" class="form-control" type="text" value="<?php echo $dataVoucher->total; ?>">
          </div>
        </div>

        <div class="form-group table-responsive">
          <table class="table table-bordered table-striped" name="data_table" id="data_table">
            <thead>
              <tr class="bg-info" id="tableHead">
                <td>No</td>
                <th>CoA</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($dataVendor as $vendor) {
                if ($vendor->id_voucher == $dataVoucher->id_voucher) { ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td>
                      <input type="hidden" name="idv[]" value="<?= $vendor->id_vendor ?>">
                      <input type="hidden" name="idg[]" value="<?php echo $vendor->id_gl; ?>">
                      <select name="coa[]" class="form-control select2">
                        <?php
                        foreach ($dataCoA as $CoA) { ?>
                          <option value="<?php echo $CoA->id_akun; ?>" <?php if ($CoA->id_akun == $vendor->kode_soa) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $CoA->coa_id . ' - ' . $CoA->coa_name; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input name="ket[]" class="form-control" type="text" value="<?php echo $vendor->keterangan; ?>">
                    </td>
                    <td>
                      <input name="debit[]" class="form-control" type="text" value="<?php echo $vendor->debit; ?>">
                    </td>
                    <td>
                      <input name="credit[]" class="form-control" type="text" value="<?php echo $vendor->credit; ?>">
                    </td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
            <!-- <tfoot>
              <tr>
                <td>Total</td>
                <td id=totalDebit></td>
                <td id=totalKredit></td>
                <td id=selisih></td>
              </tr>
            </tfoot> -->
          </table>
        </div>
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
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
  });
</script>