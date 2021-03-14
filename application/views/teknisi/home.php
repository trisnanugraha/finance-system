<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
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
          <th>Keterangan</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-keluhan">

      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>