<div class="col-md-12 well">

  <h3>
    <center>Storage/Parking Bill Detail</center>
  </h3>

  <div class="box box-body">
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Customer
        <address>
          <strong><?= $dataStorageParking->kode_customer . ' - ' . $dataStorageParking->nama_customer; ?></strong><br>
          Unit : <?= $dataStorageParking->unit_customer; ?><br>
          <?= $dataStorageParking->alamat_customer; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Date
        <address>
          <strong><?= date('d/M/Y', strtotime($dataStorageParking->tanggal)); ?></strong><br>
        </address>
        Keterangan
        <address>
          <strong><?= $dataStorageParking->keterangan; ?></strong><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Storage/Parking Bill <br>#<?= $dataStorageParking->no_invoice; ?></b><br>
        <br>
        <b>Jumlah Kendaraan :</b> <?= $dataStorageParking->jumlah_kendaraan; ?><br>
        <b>Harga Parkir :</b> <?= rupiah($dataStorageParking->harga_parkir); ?><br>
        <b>Harga Gudang :</b> <?= rupiah($dataStorageParking->harga_gudang); ?><br>
        <b>Total:</b> <?= rupiah($dataStorageParking->total); ?><br>
      </div>
      <!-- /.col -->
    </div>
  </div>

  <div class="text-right">
    <button class="btn btn-primary" data-dismiss="modal"> Close</button>
  </div>
</div>
</div>