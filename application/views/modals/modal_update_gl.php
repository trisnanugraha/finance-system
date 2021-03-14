<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Update General Ledger</center></h3>
    </div>
    
    <form id="form-update-gl" method="POST">
      <div class="modal-body">
        <input type="hidden" name="id" value="<?php echo $dataGL->id_gl; ?>">
        <div class="form-group">
          <label class="control-label col-xs-4">Transaction Code</label>
          <div class="col-xs-8">
            <input name="code" id="code" class="form-control" type="text" value="<?php echo $dataGL->bukti_transaksi; ?>" disabled>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
            <label class="control-label col-xs-4">Transaction Date</label>
            <div class="col-xs-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="date" id="date" type="text" class="form-control pull-right datepicker" value="<?php echo $dataGL->tanggal_transaksi; ?>">
                </div>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group table-responsive">
          <table class="table table-bordered table-striped" name="data_table" id="data_table">
            <thead>
              <tr class="bg-info" id="tableHead">
                <th>No</th>
                <th>CoA</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($dataBTGL as $bt) {
                if ($dataGL->bukti_transaksi == $bt->bukti_transaksi) { ?>
                  <tr>
                    <td>
                      <?= $no++ ?>
                    </td>
                    <td>
                      <input type="hidden" name="idg[]" value="<?= $bt->id_gl ?>">
                      <select name="coa[]" class="form-control select2">
                      <?php
                        foreach ($dataCoA as $CoA) { ?>
                          <option value="<?php echo $CoA->id_akun; ?>" <?php if ($CoA->id_akun == $bt->kode_soa) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $CoA->coa_id . ' - ' . $CoA->coa_name; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input name="ket[]" class="form-control" type="text" value="<?php echo $bt->keterangan; ?>">
                    </td>
                    <td>
                      <input name="debit[]" class="form-control" type="text" value="<?php echo $bt->debit; ?>">
                    </td>
                    <td>
                      <input name="credit[]" class="form-control" type="text" value="<?php echo $bt->credit; ?>">
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