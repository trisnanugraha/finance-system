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
                foreach ($dataBayar as $bayar) {
                  if ($bayar->id_voucher == $dataVoucher->id_voucher) { ?>
                    <tr>
                      <td style="width: 500px;">
                        <input name="ket[]" id="ket[]" class="form-control" type="text" value="<?php echo $bayar->keterangan; ?>">
                      </td>
                      <td style="width: 300px;">
                        <input type="hidden" name="idv[]" id="idv[]" value="<?= $bayar->id_bayar ?>">
                        <input type="hidden" name="idg[]" id="idg[]" value="<?php echo $bayar->id_gl; ?>">
                        <select name="coa[]" id="coa[]" class="form-control select2">
                          <?php foreach ($dataCoA as $CoA) { ?>
                            <option value="<?php echo $CoA->id_akun; ?>" 
                              <?php if ($CoA->id_akun == $bayar->kode_soa) {
                                echo "selected='selected'";
                              } ?>
                              > <?php echo $CoA->coa_id . ' - ' . $CoA->coa_name; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </td>
                      <td style="width: 150px;">
                        <input name="debit[]" id="debit[]" class="form-control" type="text" value="<?php echo $bayar->debit; ?>">
                      </td>
                      <td style="width: 150px;">
                        <input name="credit[]" id="credit[]" class="form-control" type="text" value="<?php echo $bayar->credit; ?>">
                      </td>
                      <td>
                        <!-- <a href="<?= base_url('Voucher/deleteVendor/'). $vendor->id_bayar. '/' . $vendor->id_gl ?>" class="btn btn-danger btn-xs">-</a> -->
                        -
                      </td>
                    </tr>
                <?php } } ?>
              </tbody>
              <!-- <tfoot id="tablefoot">
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
              </tfoot> -->
            </table>
          </div>

          <!-- <div class="form-group">
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
          <br> -->

          <!-- <div class="form-group container">
            <div class="row">
              <div class="col-md-2">
                <input type="text" class="btn btn-success" id="add" value="Add Data to Table">
              </div>
            </div>
          </div> -->

          <div class="form-group col-md-3 pull-right">
            <button type="submit" name="bayar" id="bayar" class="col-md-8 btn btn-primary">
              <i class="fa fa-money"></i> Update</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="modal-ar">
  <div class="modal-dialog modal-lg">
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
                  <td><?= date('d/M/Y', strtotime($ar->start_periode)); ?></td>
                  <td><?= $ar->id_customer ?><br><?= $ar->nama_customer ?></td>
                  <td class="text-center"><?= $ar->id_owner ?></td>
                  <td><?= $ar->coa_name ?></td>
                  <td><?= rupiah($ar->sisa) ?></td>
                  <td class="text-center">
                    <button class="btn btn-primary" id="arSelect" data-arId="<?= $ar->id_ar ?>" data-arBT="<?= $ar->bukti_transaksi ?>" data-arCode="<?= $ar->id_customer ?>" data-arPeriod="<?= $ar->id_periode ?>" data-arOwner="<?= $ar->id_owner ?>" data-arName="<?= $ar->coa_id ?>" data-arTotal="<?= $ar->sisa ?>"><i class="fa fa-check"></i>
                    </button>
                  </td>
                </tr>
              <?php } else if ($ar->status != 1 && $ar->so == 1) { ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= date('d/M/Y', strtotime($ar->start_periode)); ?></td>
                  <td><?= $ar->id_owner ?><br><?= $ar->nama_owner ?></td>
                  <td class="text-center"><?= $ar->id_owner ?></td>
                  <td><?= $ar->coa_name ?></td>
                  <td><?= rupiah($ar->sisa) ?></td>
                  <td class="text-center">
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
</div> -->

<!-- <script type="text/javascript">
  $(function() {
    $(".select2").select2();
  });
</script> -->

<!-- <script>
  $(document).ready(function() {
    var $tableBody = $('#tableBody');
    var $totalDebit = $('#totalDebit');
    var $totalKredit = $('#totalKredit');
    var $selisih = $('#selisih');
    var btn = $("#bayar");
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
  });
</script> -->



<!-- <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Update Voucher Data</center>
      </h3>
    </div>

    <form method="POST" id="form-update-voucher" autocomplete="off">
      <div class="modal-body">
        <input type="hidden" name="id" value="<?php echo $dataVoucher->id_voucher; ?>">
        <input type="hidden" name="idgl" value="<?php echo $dataVoucher->id_gl; ?>">
        <input type="hidden" name="idbayar" value="<?php echo $dataVoucher->id_bayar; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3">Voucher ID</label>
          <div class="col-xs-8">
            <input class="form-control" type="text" disabled value="<?php echo $dataVoucher->id_voucher; ?>">
          </div>
        </div>
        <br>
        <br>

        <input type="hidden" name="relasi" value="<?php echo $dataVoucher->id_voucher; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3">Nama Relasi</label>
          <div class="col-xs-8">
            <input class="form-control" type="text" disabled value="<?php echo $dataVoucher->relasi; ?>">
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
              foreach ($dataBayar as $bayar) {
                if ($bayar->id_voucher == $dataVoucher->id_voucher) { ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td>
                      <input type="hidden" name="idv[]" value="<?= $bayar->id_bayar ?>">
                      <input type="hidden" name="idg[]" value="<?php echo $bayar->id_gl; ?>">
                      <select name="coa[]" class="form-control select2">
                        <?php
                        foreach ($dataCoA as $CoA) { ?>
                          <option value="<?php echo $CoA->id_akun; ?>" <?php if ($CoA->id_akun == $bayar->kode_soa) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $CoA->coa_id . ' - ' . $CoA->coa_name; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input name="ket[]" class="form-control" type="text" value="<?php echo $bayar->keterangan; ?>">
                    </td>
                    <td>
                      <input name="debit[]" class="form-control" type="text" value="<?php echo $bayar->debit; ?>">
                    </td>
                    <td>
                      <input name="credit[]" class="form-control" type="text" value="<?php echo $bayar->credit; ?>">
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
            </tfoot> 
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div> -->