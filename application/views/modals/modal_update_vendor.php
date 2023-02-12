<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-xs-2 pull-right">
      <a href="<?= base_url('Voucher/Index') ?>" class="form-control btn btn-warning"> <i class="fa fa-undo"></i> Back To Voucher</a>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
        <form id="form-update-voucher" method="POST" autocomplete="off">
          <div class="form-group">
          <input type="hidden" name="id" id="id" value="<?php echo $dataVoucher->id_voucher; ?>">
            <label class="control-label col-xs-3" style="padding-right: 0;">Voucher ID</label>
            <div class="col-xs-3">
              <input class="form-control" type="text" disabled value="<?php echo $dataVoucher->id_voucher; ?>">
            </div>

            <label class="control-label col-xs-2">Relasi</label>
            <div class="col-xs-3">
              <input name="relasi" id="relasi" class="form-control" type="text" value="<?php echo $dataVoucher->relasi; ?>">
            </div>
          </div>
          <br>
          <br>
          <br>

          <div class="form-group">
            <label class="control-label col-xs-3">Voucher Date</label>
            <div class="col-xs-3">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input name="vouDate" id="vouDate" type="text" class="form-control pull-right datepicker" value="<?php echo $dataVoucher->tanggal_voucher; ?>">
              </div>
            </div>


            <label class="control-label col-xs-2">Transaction Type</label>
            <div class="col-xs-3">
              <select name="giro" id="giro" class="form-control select2">
                <?php foreach ($dataGiroType as $giro) { ?>
                  <option value="<?php echo $giro->giro_type_id; ?>" 
                    <?php if ($giro->giro_type_id == $dataVoucher->tipe_giro) {
                      echo "selected='selected'";
                    } ?>><?php echo $giro->type_giro_name; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <br>

          <div class="form-group table-responsive col-xs-11" style="padding-right: 0;">
            <table class="table table-bordered" name="data_table" id="data_table">
              <thead>
                <tr class="bg-info" id="tableHead">
                  <th style="width: 500px;">Keterangan</th>
                  <th style="width: 300px;">CoA</th>
                  <th style="width: 150px;">Debit</th>
                  <th style="width: 150px;">Kredit</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tableBody" name="tableBody">
                <?php
                foreach ($dataVendor as $vendor) {
                  if ($vendor->id_voucher == $dataVoucher->id_voucher) { ?>
                    <tr>
                      <td style="width: 500px;">
                        <input name="ket[]" id="ket[]" class="form-control" type="text" value="<?php echo $vendor->keterangan; ?>">
                      </td>
                      <td style="width: 300px;">
                        <input type="hidden" name="idv[]" id="idv[]" value="<?= $vendor->id_vendor ?>">
                        <input type="hidden" name="idg[]" id="idg[]" value="<?php echo $vendor->id_gl; ?>">
                        <select name="coa[]" id="coa[]" class="form-control select2">
                          <?php foreach ($dataCoA as $CoA) { ?>
                            <option value="<?php echo $CoA->id_akun; ?>" 
                              <?php if ($CoA->id_akun == $vendor->kode_soa) {
                                echo "selected='selected'";
                              } ?>
                              > <?php echo $CoA->coa_id . ' - ' . $CoA->coa_name; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </td>
                      <td style="width: 150px;">
                        <input name="debit[]" id="debit[]" class="form-control" type="text" value="<?php echo $vendor->debit; ?>">
                      </td>
                      <td style="width: 150px;">
                        <input name="credit[]" id="credit[]" class="form-control" type="text" value="<?php echo $vendor->credit; ?>">
                      </td>
                      <td>
                        <!-- <a href="<?= base_url('Voucher/deleteVendor/'). $vendor->id_vendor. '/' . $vendor->id_gl ?>" class="btn btn-danger btn-xs">-</a> -->
                        -
                      </td>
                    </tr>
                <?php } } ?>
              </tbody>
              <tfoot id="tablefoot">
                <?php
                  $debit = 0;
                  $credit = 0;
                  foreach ($dataVendor as $vendor) {
                    if ($vendor->id_voucher == $dataVoucher->id_voucher) { 
                      $debit = $vendor->debit + $debit;
                      $credit = $vendor->credit + $credit;
                      ?>
                  <?php } } ?>
                  <tr>
                    <td colspan="2">Total</td>
                    <td id=totalDebit style="width: 150px;">
                      <input id="fristDebit" name="fristDebit" class="form-control fristDebit" type="text" value="<?php echo $debit; ?>">
                    </td>
                    <td id=totalKredit style="width: 150px;">
                      <input id="fristCredit" name="fristCredit" class="form-control fristCredit" type="text" value="<?php echo $credit; ?>">
                    </td>
                    <td id=selisih>
                      <input id="fristSelisih" name="selisih" class="form-control fristSelisih" type="text" value="<?php echo $debit - $credit; ?>">
                    </td>
                  </tr>
              </tfoot>
            </table>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-3">Keterangan</label>
            <div class="col-xs-8" style="padding-right: 0;">
              <textarea name="keterangan" id="keterangan" class="form-control" type="text" placeholder="Keterangan"></textarea>
            </div>
          </div>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>

          <div class="form-group row">
            <div class="col-xs-12">
              <div class="col-md-5">
                Transaction Akun :
                <select name="akun" id="akun" class="form-control select2">
                  <option selected disabled>Choose CoA</option>
                  <?php
                  foreach ($dataCoA as $coa) {
                  ?>
                    <option value="<?php echo $coa->coa_id ?>">
                      <?php echo $coa->coa_id . ' - ' . $coa->coa_name; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-3">
                Debit :
                <input type="text" class="form-control" id="debit2" name="debit2" style="height: 34px;">
              </div>
              <div class="col-md-3">
                Kredit :
                <input type="text" class="form-control" id="kredit" name="kredit" style="height: 34px;">
              </div>
            </div>
          </div>
          <br>

          <div class="form-group container">
            <div class="row">
              <div class="col-md-2">
                <input type="text" class="btn btn-success" id="add" value="Add Data to Table">
              </div>
            </div>
          </div>

          <div class="form-group col-md-3 pull-right">
            <button type="submit" name="bayar" id="bayar" class="col-md-8 btn btn-primary" disabled>
              <i class="fa fa-money"></i> Update</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var $fristDebit = $('#fristDebit').val();
    var $fristCredit = $('#fristCredit').val();
    var $fristSelisih = $('#fristDebit').val() - $('#fristCredit').val();
    var $tableBody = $('#tableBody');
    var $totalDebit = $('#totalDebit');
    var $totalKredit = $('#totalKredit');
    var $selisih = $('#selisih');
    var btn = $("#bayar");
    var id = 1;

    if($fristSelisih >= 0){
        btn.prop('disabled', false);
    }

    $('#add').click(function() {
      var newid = id++;

      $tableBody.append('<tr valign="top" id ="' + newid + '">\n\
            <td width="500px" class="keterangan' + newid + '">' + $("#keterangan").val() + '</td>\n\
            <td width="300px" class="akun' + newid + '">' + $("#akun").val() + '</td>\n\
            <td width="150px" class="debit2">' + $("#debit2").val() + '</td>\n\
            <td width="150px" class="kredit">' + $("#kredit").val() + '</td>\n\
            <td><a href="javascript:void(0);" class="deleteRowButton btn btn-danger btn-xs" data-row="#' + newid + '">-</a></td>\n\ </tr>');

      $("#akun").val('1');
      $('#keterangan').val('');
      $('#debit2').val('');
      $('#kredit').val('');
      updateTotals();
    });

    function deleteRow(rowId) {
      $(rowId).remove();
    }

    function updateTotals() {
      var newid = id++;
      var totalDebit = getColumnTotal('.debit2');
      totalDebit = parseInt($fristDebit) + totalDebit;
      var totalKredit = getColumnTotal('.kredit');
      totalKredit = totalKredit + parseInt($fristCredit);
      var selisih = (getColumnTotal('.debit2') - getColumnTotal('.kredit'));
      $totalDebit.text((totalDebit));
      $totalKredit.text((totalKredit));
      $selisih.text((selisih));

  
      if (selisih >= 0) {
        btn.prop('disabled', false);
      } else {
        btn.prop('disabled', true);
        Swal.fire({
          icon: 'warning',
          title: 'Total Saldo Tidak Balance!',
          allowOutsideClick: false,
          allowEscapeKey: false,
        })
      }
      
    }

    function getSubtotal(quantity, price) {
      return (quantity * price).toFixed(2);
    }

    function getColumnTotal(selector) {
      return Array.from($(selector)).reduce(sumReducer, 0);
    }

    function sumReducer(total, cell) {
      return total += parseInt(cell.innerHTML, 10);
    }

    $tableBody.on('click', '.deleteRowButton', function(event) {
      deleteRow($(event.target).data('row'));
      updateTotals();
    });
  });
</script>