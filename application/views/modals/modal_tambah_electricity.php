<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Electricity Bill</center>
      </h3>
    </div>

    <form id="form-tambah-electricity" method="POST" autocomplete="off">
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-3">Electricity Bill Code</label>
          <div class="col-xs-8">
            <input name="idListrik" id="idListrik" class="form-control" type="text" placeholder="IN20-0101">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Customer</label>
          <div class="col-xs-8">
            <select name="kodeCus" class="form-control select2" id="kodeCus" style="width: 100%">
              <option selected disabled>Choose Customer</option>
              <?php
              foreach ($dataCustomer as $cus) {
              ?>
                <option value="<?php echo $cus->kodeCus; ?>" data-capacity="<?= $cus->kapasitas; ?>" ?>
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
          <label class="control-label col-xs-3">Electricity Capacity</label>
          <div class="col-xs-3">
            <input type="hidden" name="hiddenCapacity" />

            <span id="electricityCapacity">-</span>
          </div>

          <label class="control-label col-xs-3">Electricity Rates</label>
          <div class="col-xs-3">
            <input type="hidden" name="hiddenIdTarif" value=<?= $dataRates == null ? '' : $dataRates->id; ?> />

            <input type="hidden" name="hiddenElectricityRate" value=<?= $dataRates == null ? '' : $dataRates->electric; ?> />
            <span id="electricityRate"><?= $dataRates == null ? "Not set" : rupiah($dataRates->electric); ?></span>

            </select>
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
          <label class="control-label col-xs-3">PPJU</label>
          <div class="col-xs-3">
            <input name="ppju" id="ppju" class="form-control perhitungan" type="text" placeholder="PPJU" readonly>
          </div>

          <label class="control-label col-xs-2">Total</label>
          <div class="col-xs-3">
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
    $("#cons").val(cons);

    var consumption = 0;
    var kapasitas = parseFloat($("#electricityCapacity").text())
    var tarifListrik = <?= $dataRates == null ? 0 : $dataRates->electric; ?>;
    var amount = $("#hiddenAmount").val()
    var akhir = $("#hiddenAkhir").val();
    var mulai = $("#hiddenMulai").val();

    if (akhir != mulai) {
      var temp = (40 * kapasitas * amount) / 30;
    } else {
      var temp = (40 * kapasitas * amount) / amount;
    }

    if (cons < temp) {
      consumption = temp * tarifListrik;
    } else {
      consumption = cons * tarifListrik;
    }
    $("#consumption").val(consumption)

    var ppju = consumption * 0.03;
    $("#ppju").val(ppju)

    var total = consumption + ppju;
    var prorate = (total * amount) / 30;
    if (akhir != mulai) {
      $("#total").val(total)
    } else {
      $("#total").val(total)
    }
  }

  $("#kodeCus").on("change", function() {
    var capacity = $(this).find(':selected').attr('data-capacity');
    $("#electricityCapacity").text(capacity);
    calculate();
  });

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