<div class="col-md-12 well">

  <h3>
    <center>Detail Keluhan</center>
  </h3>

  <div class="box box-body">
    <div class="row invoice-info">
      <div class="col-sm-6 invoice-col">
        <div class="form-group">
          <label class="control-label col-xs-4">ID Keluhan</label>
          <div class="col-xs-8">
            <input name="id" class="form-control" value="<?= $dataKeluhan->kode_keluhan; ?>" type="text" readonly>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Tanggal Keluhan</label>
          <div class="col-xs-8">
            <input name="id" class="form-control" value="<?= date('d F Y', strtotime($dataKeluhan->tanggal_keluhan)); ?>" type="text" readonly>
          </div>
        </div>
        <br>
        <br>
      </div>

      <div class="col-sm-6 invoice-col">
        <div class="form-group">
          <label class="control-label col-xs-4">Pelapor</label>
          <div class="col-xs-8">
            <input name="id" class="form-control" value="<?= $dataKeluhan->username . ' ~ ' . $dataKeluhan->nama; ?>" type="text" readonly>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Tanggal Diselesaikan</label>
          <div class="col-xs-8">
            <input name="id" class="form-control" value="<?php if ($dataKeluhan->tanggal_selesai == NULL) { ?> <?= '-'; ?><?php
                                                                                                                        } else { ?><?= date('d F Y', strtotime($dataKeluhan->tanggal_selesai));
                                                                                                                                  } ?>" type="text" readonly>
          </div>
        </div>
        <br>
        <br>
      </div>

      <div class="col-sm-2 invoice-col">
      </div>

      <div class="col-sm-8 invoice-col">
        <?php if ($dataKeluhan->status !=  2) { ?>
          <div class="form-group">
            <label class="control-label">Uraian Keluhan</label>
          </div>
          <div class="from-group">
            <textarea class="form-control" type="text" readonly><?php echo $dataKeluhan->uraian; ?></textarea>
          </div>
          <br>

          <div class="form-group">
            <label class="control-label">Penyebab Keluhan</label>
          </div>
          <div class="from-group">
            <textarea class="form-control" type="text" readonly><?php echo $dataKeluhan->penyebab; ?></textarea>
          </div>
          <br>

          <div class="form-group">
            <label class="control-label">Tindakan Perbaikan Keluhan</label>
          </div>
          <div class="from-group">
            <textarea class="form-control" type="text" readonly><?php echo $dataKeluhan->tindakan; ?></textarea>
          </div>
          <br>
        <?php } else { ?>
          <div class="form-group">
            <label class="control-label">Uraian Keluhan</label>
          </div>
          <div class="from-group">
            <textarea class="form-control" type="text" readonly><?php echo $dataKeluhan->uraian; ?></textarea>
          </div>
          <br>

          <div class="form-group">
            <label class="control-label">Penyebab Keluhan</label>
          </div>
          <div class="from-group">
            <textarea class="form-control" type="text" readonly><?php echo $dataKeluhan->penyebab; ?></textarea>
          </div>
          <br>

          <div class="form-group">
            <label class="control-label">Alasan Pending Perbaikan Keluhan</label>
          </div>
          <div class="from-group">
            <textarea class="form-control" type="text" readonly><?php echo $dataKeluhan->pending; ?></textarea>
          </div>
        <?php } ?>
      </div>

      <div class="col-sm-2 invoice-col">
      </div>
    </div>

    <div class="text-right">
      <button class="btn btn-primary" data-dismiss="modal"> Close</button>
    </div>
  </div>
</div>