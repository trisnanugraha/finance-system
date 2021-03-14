<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Water Bill</center>
      </h3>
    </div>

    <form id="form-tambah-water" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-3">Water Bill Code</label>
          <div class="col-xs-8">
            <input name="idWater" id="idWater" class="form-control" type="text" placeholder="IN20-0101">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Customer</label>
          <div class="col-xs-8">
            <select name="kodeCus" id="kodeCus" class="form-control select2" style="width: 100%">
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
          <label class="control-label col-xs-3">Water Rates</label>
          <div class="col-xs-3">
            <input type="hidden" name="hiddenIdTarif" value=<?= $dataRates == null ? '' : $dataRates->id; ?> />

            <input type="hidden" name="hiddenWaterRate" value=<?= $dataRates == null ? '' : $dataRates->water; ?> />
            <span id="waterRate"><?= $dataRates == null ? "Not set" : rupiah($dataRates->water); ?></span>
          </div>
          <label class="control-label col-xs-3">Standing Charge</label>
          <div class="col-xs-3">
            <input type="hidden" name="hiddenStandingCharge" value=<?= $dataRates == null ? '' : $dataRates->charge; ?> />
            <span id="standingCharge"><?= $dataRates == null ? "Not set" : rupiah($dataRates->charge); ?></span>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Period</label>
          <div class="col-xs-8">
            <select name="period" id="period" class="form-control select2 period" style="width: 100%">
              <option selected disabled value="-99">Choose Period</option>
              <?php
              foreach ($dataPeriod as $period) {
              ?>
                <option value="<?php echo $period->id; ?>" data-due="<?= $period->dueDate; ?>" data-amount="<?= $period->amount; ?>" data-mulai="<?= $period->mulai; ?>" data-akhir="<?= $period->akhir; ?>">
                  <?php echo date('d/m/Y', strtotime($period->periodStart)) . ' ~ ' . date('d/m/Y', strtotime($period->periodEnd)); ?>
                </option>
              <?php
              }
              ?>
            </select>
            <input name="hiddenAmount" id="hiddenAmount" type="hidden" />
            <input name="hiddenMulai" id="hiddenMulai" type="hidden" />
            <input name="hiddenAkhir" id="hiddenAkhir" type="hidden" />
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Due Date</label>
          <div class="col-xs-8">
            <input name="dueDate" id="dueDate" class="form-control" readonly type="text" placeholder="Due Date">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Start Meter</label>
          <div class="col-xs-3">
            <input name="startMeter" id="startMeter" class="form-control perhitungan" type="text" placeholder="100">
          </div>
          <label class="control-label col-xs-2">End Meter</label>
          <div class="col-xs-3">
            <input name="endMeter" id="endMeter" class="form-control perhitungan" type="text" placeholder="150">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Cons</label>
          <div class="col-xs-3">
            <input name="cons" id="cons" class="form-control perhitungan" type="text" placeholder="Cons" readonly>
          </div>
          <label class="control-label col-xs-2">Consumption</label>
          <div class="col-xs-3">
            <input name="consumption" id="consumption" class="form-control perhitungan" type="text" placeholder="Consumption" readonly>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Tax Area</label>
          <div class="col-xs-3">
            <input name="taxArea" id="taxArea" class="form-control perhitungan" type="text" placeholder="Tax Area" readonly>
          </div>
          <label class="control-label col-xs-2">Tax</label>
          <div class="col-xs-3">
            <input name="tax" id="tax" class="form-control perhitungan" type="text" placeholder="Tax" readonly>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Total</label>
          <div class="col-xs-8">
            <input name="total" id="total" class="form-control perhitungan" type="text" placeholder="Total" readonly>
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

<script type="text/javascript">
  $(function() {
    $(".select2").select2();
  });
</script>

<script type="text/javascript">
  function calculate() {
    var start = parseFloat($("#startMeter").val());
    var end = parseFloat($("#endMeter").val());
    var cons = end - start;
    var amount = $("#hiddenAmount").val();
    var akhir = $("#hiddenAkhir").val();
    var mulai = $("#hiddenMulai").val();

    $("#cons").val(cons);

    var rates = <?= $dataRates == null ? 0 : $dataRates->water; ?>;

    var consumption = rates * cons;
    $("#consumption").val(consumption);

    var charge = <?= $dataRates == null ? 0 : $dataRates->charge; ?>;

    var temp = consumption + charge;
    var taxArea = (temp * 10) / 100;
    $("#taxArea").val(taxArea);

    var jml = temp + taxArea;

    var tax = (jml * 10) / 100;
    $("#tax").val(tax);

    var total = jml + tax;
    if (akhir != mulai) {
      $("#total").val(total)
    } else {
      $("#total").val(total)
    }

  }

  $("#period").on('change', function() {
    var duedate = $(this).find(':selected').attr('data-due');
    $("#dueDate").val(moment(duedate, 'YYYY/MM/DD').format('DD/MM/YYYY'));
    $('#hiddenAmount').val($(this).find(':selected').attr('data-amount'));
    $('#hiddenAkhir').val($(this).find(':selected').attr('data-akhir'));
    $('#hiddenMulai').val($(this).find(':selected').attr('data-mulai'));
    calculate();
  });

  $(".perhitungan").on("change paste keyup select", function() {
    calculate();
  });
</script>