<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-keluhan"><i class="glyphicon glyphicon-print"></i> Print Data Keluhan</button>
    </div>
  </div>
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

<?php
$data['judul'] = 'Data Keluhan';
$data['judul'] = 'Print Data Keluhan';
$data['url'] = 'Keluhan/print';
echo show_my_modal('modals/modal_print_keluhan', 'print-keluhan', $data);
?>