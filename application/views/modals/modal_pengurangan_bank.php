<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Voucher</center>
      </h3>
    </div>

    <form id="form-pengurangan-bank" method="POST" autocomplete="off">
      <div class="modal-body">

        <div class="form-group">
          <label class="control-label col-xs-4">Voucher ID</label>
          <div class="col-xs-8">
            <input name="code" id="code" class="form-control cekId" type="text" placeholder="Transaction Code">
            <small class="error_id" style="color: red"></small>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Nama Relasi</label>
          <div class="col-xs-8">
            <input name="relasiVendor" id="relasiVendor" class="form-control" type="text" placeholder="Nama Relasi">
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
              <input name="date" id="date" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
            </div>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Transaction Type</label>
          <div class="col-xs-8">
            <select name="giro" id="giro" class="form-control">
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
          <label class="control-label col-xs-4">Keterangan</label>
          <div class="col-xs-8">
            <textarea name="keterangan" id="keterangan" class="form-control" type="text" placeholder="Keterangan"></textarea>
          </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group table-responsive">
          <table class="table table-bordered table-striped" name="data_table" id="data_table">
            <thead>
              <tr class="bg-info" id="tableHead">
                <th>Voucher ID</th>
                <th>Relasi</th>
                <th>Keterangan</th>
                <th>CoA</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="tableBody" name="tableBody">
            </tbody>
            <tfoot id="tablefoot">
              <tr>
                <td colspan="4">Total</td>
                <td id=totalDebit></td>
                <td id=totalKredit></td>
                <td id=selisih></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <div class="form-group row">
          <div class="col-md-12">
            <div class="col-md-6">
              Transaction Akun :
              <select name="coa" id="coa" class="form-control select2" style="width: 100%;">
                <option selected disabled>Choose CoA</option>
                <?php
                foreach ($dataCoA as $coa) {
                ?>
                  <option value="<?php echo $coa->coa_id; ?>">
                    <?php echo $coa->coa_id . ' - ' . $coa->coa_name; ?>
                  </option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              Debit :
              <input type="text" class="form-control input-sm" id="debit" name="debit">
            </div>
            <div class="col-md-3">
              Kredit :
              <input type="text" class="form-control input-sm" id="kredit" name="kredit">
            </div>
          </div>
        </div>
        <br>

        <div class="form-group container">
          <div class="row">
            <div class="col-md-8">
              <input type="text" class="btn btn-success btn-sm" id="add" value="Add Data to Table">
            </div>
          </div>
        </div>
      </div>

  </div>
  <div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
    <button type="submit" id="save" class="btn btn-primary">Add Data</button>
  </div>
  </form>
</div>
</div>

<script>
  $(document).ready(function() {
    var $tableBody = $('#tableBody');
    var $totalDebit = $('#totalDebit');
    var $totalKredit = $('#totalKredit');
    var $selisih = $('#selisih');
    var id = 1;

    $('#add').click(function() {
      var newid = id++;

      $tableBody.append('<tr valign="top" id ="' + newid + '">\n\
            <td width="100px" class="code' + newid + '">' + $("#code").val() + '</td>\n\
            <td width="100px" class="relasiVendor' + newid + '">' + $("#relasiVendor").val() + '</td>\n\
            <td width="100px" class="keterangan' + newid + '">' + $("#keterangan").val() + '</td>\n\
            <td width="100px" class="coa' + newid + '">' + $("#coa").val() + '</td>\n\
            <td width="100px" class="debit">' + $("#debit").val() + '</td>\n\
            <td width="100px" class="kredit">' + $("#kredit").val() + '</td>\n\
            <td><a href="javascript:void(0);" class="deleteRowButton btn btn-danger btn-xs" data-row="#' + newid + '">-</a></td>\n\ </tr>');

      $('#debit').val('');
      $('#kredit').val('');
      updateTotals();
    });

    function deleteRow(rowId) {
      $(rowId).remove();
    }

    function updateTotals() {
      var newid = id++;
      var totalDebit = getColumnTotal('.debit');
      var totalKredit = getColumnTotal('.kredit');
      var selisih = (getColumnTotal('.debit') - getColumnTotal('.kredit'));
      $totalDebit.text((totalDebit));
      $totalKredit.text((totalKredit));
      $selisih.text((selisih));
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

    $('.cekId').keyup(function(e) {

      var IdVoucher = $('.cekId').val();

      $.ajax({
        type: "POST",
        url: '<?php echo base_url('Voucher/cekId'); ?>',
        data: {
          "cek_submit_btn": 1,
          "voucher_id": IdVoucher,
        },
        success: function(response) {
          $('.error_id').text(response);
        }

      });
    });

    $(function() {
      $(".select2").select2();
    });

  });
</script>