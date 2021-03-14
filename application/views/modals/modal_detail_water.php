<div class="col-md-12 well">

  <h3>
    <center>Water Bill Detail</center>
  </h3>

  <div class="box box-body">
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Customer
        <address>
          <strong><?= $dataWater->kode_customer . ' - ' . $dataWater->nama_customer; ?></strong><br>
          Unit : <?= $dataWater->unit_customer; ?><br>
          <?= $dataWater->alamat_customer; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Period
        <address>
          <strong><?= date('d/M/Y', strtotime($dataWater->start_periode)) . ' ~ ' . date('d/M/Y', strtotime($dataWater->end_periode)); ?></strong><br>
          <b>Due Date: </b> <?= date('d/M/Y', strtotime($dataWater->due_date)); ?><br>
          <b>Start Meter: </b> <?= floatval($dataWater->start_meter); ?><br>
          <b>End Meter: </b> <?= floatval($dataWater->end_meter); ?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Water Bill #<?= $dataWater->kode_tagihan_air; ?></b><br>
        <br>
        <b>Cons:</b> <?= floatval($dataWater->cons); ?><br>
        <b>Consumption:</b> <?= rupiah($dataWater->consumption); ?><br>
        <b>Tax Area:</b> <?= rupiah($dataWater->tax_area); ?><br>
        <b>Tax:</b> <?= rupiah($dataWater->tax); ?><br>
        <b>Total:</b> <?= rupiah($dataWater->total); ?><br>
      </div>
      <!-- /.col -->
    </div>
  </div>

  <div class="text-right">
    <button class="btn btn-primary" data-dismiss="modal"> Close</button>
  </div>
</div>
</div>