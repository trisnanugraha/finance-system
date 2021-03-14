<div class="col-md-12 well">

  <h3>
    <center>Working Request Bill Detail</center>
  </h3>

  <div class="box box-body">
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Customer
        <address>
          <strong><?= $dataWorkingRequest->kode_customer . ' - ' . $dataWorkingRequest->nama_customer; ?></strong><br>
          Unit : <?= $dataWorkingRequest->unit_customer; ?><br>
          <?= $dataWorkingRequest->alamat_customer; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Date
          <strong><?= date('d/M/Y', strtotime($dataWorkingRequest->tanggal)); ?></strong><br>
        Keterangan
          <strong><?= $dataWorkingRequest->keterangan; ?></strong><br>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Working Request Bill <br>#<?= $dataWorkingRequest->no_invoice_wr; ?></b><br>
        <br>
        <b>Total:</b> <?= rupiah($dataWorkingRequest->total); ?><br>
      </div>
      <!-- /.col -->
    </div>
  </div>

  <div class="text-right">
    <button class="btn btn-primary" data-dismiss="modal"> Close</button>
  </div>
</div>