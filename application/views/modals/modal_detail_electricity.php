<div class="col-md-12 well">

  <h3>
    <center>Electricity Bill Detail</center>
  </h3>

  <div class="box box-body">
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Customer
        <address>
          <strong><?= $dataElectricity->id_customer . ' - ' . $dataElectricity->nama_customer; ?></strong><br>
          Unit : <?= $dataElectricity->unit_customer; ?><br>
          <?= $dataElectricity->alamat_customer; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Period
        <address>
          <strong><?= date('d/M/Y', strtotime($dataElectricity->start_periode)) . ' ~ ' . date('d/M/Y', strtotime($dataElectricity->end_periode)); ?></strong><br>
          <b>Due Date: </b> <?= date('d/M/Y', strtotime($dataElectricity->due_date)); ?><br>
          <b>Start Meter: </b> <?= floatval($dataElectricity->start_meter); ?><br>
          <b>End Meter: </b> <?= floatval($dataElectricity->end_meter); ?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Electricity Bill #<?= $dataElectricity->id_listrik; ?></b><br>
        <br>
        <b>Electricity Capacity:</b> <?= $dataElectricity->kapasitas; ?><br>
        <b>Cons:</b> <?= floatval($dataElectricity->cons); ?><br>
        <b>Consumption:</b> <?= rupiah($dataElectricity->consumption); ?><br>
        <b>PPJU:</b> <?= rupiah($dataElectricity->ppju); ?><br>
        <b>Total:</b> <?= rupiah($dataElectricity->total); ?><br>
      </div>
      <!-- /.col -->
    </div>
  </div>

  <div class="text-right">
    <button class="btn btn-primary" data-dismiss="modal"> Close</button>
  </div>
</div>
</div>