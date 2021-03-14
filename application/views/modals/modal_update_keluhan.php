<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Update Keluhan Data</center>
      </h3>
    </div>

    <form method="POST" id="form-update-keluhan">
      <div class="modal-body">
        <input type="hidden" name="id" value="<?php echo $dataKeluhan->kode_keluhan; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3">ID Keluhan</label>
          <div class="col-xs-8">
            <input class="form-control select2" type="text" disabled value="<?php echo $dataKeluhan->kode_keluhan; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Pelapor</label>
          <div class="col-xs-8">
            <input name="pelapor" class="form-control select2" type="text" disabled value="<?php echo $dataKeluhan->username . ' ~ ' . $dataKeluhan->nama; ?>">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Tanggal Keluhan</label>
          <div class="col-xs-8">
            <input name="tgl_keluhan" id="tgl_keluhan" class="form-control select2 datepicker" disable value="<?= date('d M Y', strtotime($dataKeluhan->tanggal_keluhan)); ?>" type="text" readonly>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Uraian Keluhan</label>
          <div class="col-xs-8">
            <textarea name="uraian" class="form-control select2" type="text" readonly><?php echo $dataKeluhan->uraian; ?></textarea>
          </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Penyebab Keluhan</label>
          <div class="col-xs-8">
            <textarea name="penyebab" class="form-control select2" type="text" placeholder="Penyebab Keluhan"><?php echo $dataKeluhan->penyebab; ?></textarea>
          </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Tanggal Keluhan Ditindak Lanuti</label>
          <div class="col-xs-8">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input name="tanggal_selesai" id="tanggal_selesai" type="text" class="form-control pull-right datepicker" placeholder="Masukkan Tanggal Penyelesaian Keluhan">
            </div>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Tindakan Perbaikan Keluhan</label>
          <div class="col-xs-8">
            <textarea name="tindakan" class="form-control select2" type="text" placeholder="Tindakan Atas Keluhan"><?php echo $dataKeluhan->tindakan; ?></textarea>
          </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Status Keluhan</label>
          <div class="col-xs-8">
            <select name="status" class="form-control select2" style="width: 100%">
              <option selected disabled>Choose Report</option>
              <option value="0">Belum Ditindak Lanjuti</option>
              <option value="1">Selesai Ditindak Lanjuti</option>
              <option value="2">Pending</option>
            </select>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Alasan Pending Perbaikan Keluhan</label>
          <div class="col-xs-8">
            <textarea name="pending" class="form-control select2" type="text" placeholder="Alasan Pending Keluhan (Jika Status Menjadi Pending)"><?php echo $dataKeluhan->pending; ?></textarea>
          </div>
        </div>
        <br>
        <br>

      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
    var startDate = new Date();
    $("#tanggal_selesai").datepicker('setStartDate', startDate);
  });
</script>