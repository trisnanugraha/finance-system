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
        <form id="form-bayar-ar" method="POST">
          <div class="form-group">
            <label class="control-label col-xs-3" style="padding-right: 0;">Voucher ID</label>
            <div class="col-xs-3">
              <input name="vouId" id="vouId" class="form-control" type="text" placeholder="Transaction Code">
            </div>

            <label class="control-label col-xs-2">Unit</label>
            <div class="col-xs-3" style="padding-right: 0;">
              <select name="vouUnit" id="vouUnit" class="form-control select2">
                <option selected disabled>Choose Unit</option>
                <?php
                foreach ($dataOwner as $owner) {
                ?>
                  <option value="<?php echo $owner->id; ?>">
                    <?php echo $owner->id; ?>
                  </option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>
          <br>
          <br>
          <br>

          <div class="form-group">
            <label class="control-label col-xs-3">Received From Customer/Owner</label>
            <div class="col-xs-3">
              <select name="receivedVou" id="receivedVou" class="form-control select2" style="width: 100%">
                <option value="0">Umum</option>
                <option value="1">Customer</option>
                <option value="2">Owner</option>
              </select>
            </div>

            <label class="control-label col-xs-2">Voucher Date</label>
            <div class="col-xs-3">
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
            <label class="control-label col-xs-3">Transaction Type</label>
            <div class="col-xs-3">
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

            <label class="control-label col-xs-2">Tipe Pembayaran</label>
            <div class="col-xs-3" style="padding-right: 0;">
              <select name="pemType" id="pemType" class="form-control select2" style="width: 100%">
                <option selected disabled>Choose Tipe Pembayaran</option>
                <?php
                foreach ($dataPemType as $pem) {
                ?>
                  <option value="<?php echo $pem->type_pembayaran_id; ?>">
                    <?php echo $pem->type_pembayaran_name; ?>
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
            <div>
              <label for="piutang" class="control-label col-xs-3">Piutang</label>
            </div>
            <div class="col-xs-8">
              <div class="row col-xs-12">
                <input type="hidden" name="coa" id="coa">
                <input type="text" name="piutang" id="piutang" class="form-control">
              </div>
              <div class="row col-xs-1">
                <span>
                  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-ar">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </div>
          </div>
          <br>
          <br>

          <div class="form-group">
            <label class="control-label col-xs-3">ID AR</label>
            <div class="col-xs-3">
              <input name="idAR" id="idAR" class="form-control" type="text" placeholder="ID AR" readonly>
            </div>

            <label class="control-label col-xs-2">Unit AR</label>
            <div class="col-xs-3" style="padding-right: 0;">
              <input name="unitAR" id="unitAR" class="form-control" type="text" placeholder="Unit AR" readonly>
            </div>
          </div>
          <br>
          <br>

          <div class="form-group">
            <label class="control-label col-xs-3">Periode AR</label>
            <div class="col-xs-3">
              <input name="periodAR" id="periodAR" class="form-control" type="text" placeholder="Periode AR" readonly>
            </div>

            <label class="control-label col-xs-2">Bukti Transaksi AR</label>
            <div class="col-xs-3" style="padding-right: 0;">
              <input name="buktiAR" id="buktiAR" class="form-control" type="text" placeholder="Bukti Transaksi AR" readonly>
            </div>
          </div>
          <br>
          <br>

          <div class="form-group">
            <label class="control-label col-xs-3">Total AR</label>
            <div class="col-xs-3">
              <input name="totalAR" id="totalAR" class="form-control" type="text" placeholder="Total AR" readonly>
            </div>

            <label class="control-label col-xs-2">Kode CoA AR</label>
            <div class="col-xs-3" style="padding-right: 0;">
              <input name="coaAR" id="coaAR" class="form-control" type="text" placeholder="Kode CoA AR" readonly>
            </div>
          </div>
          <br>
          <br>

          <div class="form-group">
            <label class="control-label col-xs-3">Keterangan</label>
            <div class="col-xs-8" style="padding-right: 0;">
              <textarea name="keterangan" id="keterangan" class="form-control" type="text" placeholder="Keterangan"></textarea>
            </div>
          </div>
          <br>
          <br>
          <br>

          <div class="form-group table-responsive col-xs-11" style="padding-right: 0;">
            <table class="table table-bordered" name="data_table" id="data_table">
              <thead>
                <tr class="bg-info" id="tableHead">
                  <th>Voucher ID</th>
                  <th>AR ID</th>
                  <th>Unit</th>
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
                  <td colspan="5">Total</td>
                  <td id=totalDebit></td>
                  <td id=totalKredit></td>
                  <td id=selisih></td>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="form-group row">
            <div class="col-xs-12">
              <div class="col-md-5">
                Transaction Akun :
                <select name="akun" id="akun" class="form-control select2">
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
                <input type="text" class="form-control" id="debit" name="debit" style="height: 34px;">
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
            <button type="submit" name="bayar" id="bayar" class="col-md-8 btn btn-success">
              <i class="fa fa-money"></i> Bayar</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-ar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title">
          <center>Pembayaran Piutang</center>
        </h3>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered table-striped" id="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Periode</th>
              <th>Code</th>
              <th>Unit</th>
              <th>Piutang</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($dataAR as $ar) {
              if ($ar->status != 1 && $ar->so == 0) { ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= $ar->start_periode ?></td>
                  <td><?= $ar->id_customer ?></td>
                  <td><?= $ar->id_owner ?></td>
                  <td><?= $ar->coa_name ?></td>
                  <td><?= rupiah($ar->sisa) ?></td>
                  <td>
                    <button class="btn btn-primary" id="arSelect" data-arId="<?= $ar->id_ar ?>" data-arBT="<?= $ar->bukti_transaksi ?>" data-arCode="<?= $ar->id_customer ?>" data-arPeriod="<?= $ar->id_periode ?>" data-arOwner="<?= $ar->id_owner ?>" data-arName="<?= $ar->coa_id ?>" data-arTotal="<?= $ar->sisa ?>"><i class="fa fa-check"></i>
                    </button>
                  </td>
                </tr>
              <?php } else if ($ar->status != 1 && $ar->so == 1) { ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= $ar->start_periode ?></td>
                  <td><?= $ar->id_owner ?></td>
                  <td><?= $ar->id_owner ?></td>
                  <td><?= $ar->coa_name ?></td>
                  <td><?= rupiah($ar->sisa) ?></td>
                  <td>
                    <button class="btn btn-primary" id="arSelect" data-arId="<?= $ar->id_ar ?>" data-arBT="<?= $ar->bukti_transaksi ?>" data-arCode="<?= $ar->id_owner ?>" data-arPeriod="<?= $ar->id_periode ?>" data-arOwner="<?= $ar->id_owner ?>" data-arName="<?= $ar->coa_id ?>" data-arTotal="<?= $ar->sisa ?>" data-arKet="<?= $ar->keterangan ?>"><i class="fa fa-check"></i>
                    </button>
                  </td>
                </tr>
            <?php }
              $no++;
            } ?>
          </tbody>
        </table>
      </div>
    </div>
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
      if ($("#idAR").val() == '') {
        var newid = id++;

        $tableBody.append('<tr valign="top" id ="' + newid + '">\n\
              <td width="100px" class="vouId' + newid + '">' + $("#vouId").val() + '</td>\n\
              <td width="100px" class="arId' + newid + '">' + 1 + '</td>\n\
              <td width="100px" class="unit' + newid + '">' + $("#vouUnit").val() + '</td>\n\
              <td width="100px" class="keterangan' + newid + '">' + $("#keterangan").val() + '</td>\n\
              <td width="100px" class="akun' + newid + '">' + $("#akun").val() + '</td>\n\
              <td width="100px" class="debit">' + $("#debit").val() + '</td>\n\
              <td width="100px" class="kredit">' + $("#kredit").val() + '</td>\n\
              <td><a href="javascript:void(0);" class="deleteRowButton btn btn-danger btn-xs" data-row="#' + newid + '">-</a></td>\n\ </tr>');

        $('#debit').val('');
        $('#kredit').val('');
        updateTotals();
      } else {
        var newid = id++;

        $tableBody.append('<tr valign="top" id ="' + newid + '">\n\
              <td width="100px" class="vouId' + newid + '">' + $("#vouId").val() + '</td>\n\
              <td width="100px" class="arId' + newid + '">' + $("#idAR").val() + '</td>\n\
              <td width="100px" class="unit' + newid + '">' + $("#unitAR").val() + '</td>\n\
              <td width="100px" class="keterangan' + newid + '">' + $("#keterangan").val() + '</td>\n\
              <td width="100px" class="akun' + newid + '">' + $("#akun").val() + '</td>\n\
              <td width="100px" class="debit">' + $("#debit").val() + '</td>\n\
              <td width="100px" class="kredit">' + $("#kredit").val() + '</td>\n\
              <td><a href="javascript:void(0);" class="deleteRowButton btn btn-danger btn-xs" data-row="#' + newid + '">-</a></td>\n\ </tr>');

        $('#debit').val('');
        $('#kredit').val('');
        updateTotals();
      }

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

    $(document).on('click', '#arSelect', function() {
      var arBT = $(this).attr('data-arBT');
      var arId = $(this).attr('data-arId');
      var arCode = $(this).attr('data-arCode');
      var arPeriod = $(this).attr('data-arPeriod');
      var arOwner = $(this).attr('data-arOwner');
      var arName = $(this).attr('data-arName');
      var arTotal = $(this).attr('data-arTotal');
      var pph = arTotal * 10 / 100;
      var total = arTotal - 6000 - pph;
      var vouUnit = $('#vouUnit').val();

      if (vouUnit != arOwner) {
        window.alert('Unit Must Be Same');
      } else {
        $('#idAR').val(arId);
        $('#unitAR').val(arOwner);
        $('#periodAR').val(arPeriod);
        $('#buktiAR').val(arBT);
        $('#coaAR').val(arName);
        $('#totalAR').val(arTotal);
        $('#modal-ar').modal('hide');
      }
    });

    // $('#bayar').click(function() {
    //   var lastRowId = $('#tableBody tr:last').attr("id");
    //   var arId = new Array();
    //   var vouId = new Array();
    //   var arOwner = new Array();
    //   var keterangan = new Array();
    //   var akun = new Array();
    //   var debit = new Array();
    //   var kredit = new Array();
    //   var date = $('#dateVoucher').val();
    //   var pemType = $('#pemType').val();
    //   var sendGiro = $('#giroVoucher').val();
    //   var relasi = $('#receivedVou').val();

    //   for (var i = 1; i <= lastRowId; i++) {
    //     arId.push($("#" + i + " .arId" + i));
    //     vouId.push($("#" + i + " .vouId" + i).html());
    //     arOwner.push($('#' + i + " .unit" + i).html());
    //     keterangan.push($('#' + i + " .keterangan" + i).html());
    //     akun.push($('#' + i + " .akun" + i).html());
    //     debit.push($('#' + i + " .debit").html());
    //     kredit.push($('#' + i + " .kredit").html());
    //   }

    //   var sendAR = JSON.stringify(arId);
    //   var sendVou = JSON.stringify(vouId);
    //   var sendKodeOwner = JSON.stringify(arOwner);
    //   var sendKet = JSON.stringify(keterangan);
    //   var sendAkun = JSON.stringify(akun);
    //   var sendDebit = JSON.stringify(debit);
    //   var sendKredit = JSON.stringify(kredit);

    //   console.log(lastRowId);
    //   console.log(sendAR);
    //   console.log(sendVou);
    //   console.log(sendKodeOwner);
    //   console.log(sendKet);
    //   console.log(sendAkun);
    //   console.log(sendDebit);
    //   console.log(sendKredit);
    //   console.log(date);
    //   console.log(pemType);
    //   console.log(sendGiro);
    //   console.log(relasi);

    //   $.ajax({
    //       type: 'POST',
    //       // url  : '<?php echo base_url('Voucher/AR'); ?>',
    //       data: {
    //         id: sendAR,
    //         bukti_transaksi: sendVou,
    //         kodeOwner: sendKodeOwner,
    //         keterangan: sendKet,
    //         akun: sendAkun,
    //         debit: sendDebit,
    //         credit: sendKredit,
    //         date: date,
    //         pemType: pemType,
    //         giro: sendGiro,
    //         relasi: relasi
    //       }
    //     })
    //     .done(function(data) {
    //       var out = jQuery.parseJSON(data);

    //       if (out.status == 'form') {
    //         $('.form-msg').html(out.msg);
    //         effect_msg_form();
    //         setInterval('location.reload()', 2000);
    //       } else {
    //         document.getElementById("form-bayar-ar").reset();
    //         $('.msg').html(out.msg);
    //         effect_msg();
    //         setInterval('location.reload()', 2000);
    //       }
    //     });
    // });
  });
</script>