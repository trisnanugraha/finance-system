<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-3">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-keluhan"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Keluhan Baru</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Keluhan ID</th>
          <th>Pelapor</th>
          <th>Tanggal Keluhan</th>
          <th>Uraian Keluhan</th>
          <th>Status Keluhan</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-keluhan">

      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>

<?php echo $modal_tambah_keluhan; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataKeluhan', 'Delete This Data ?', 'Yes, Delete This Data'); ?>