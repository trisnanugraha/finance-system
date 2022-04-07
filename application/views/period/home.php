<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-period"><i class="glyphicon glyphicon-plus-sign"></i> Add New Period List</button>
    </div>
    <div class="col-md-4">
      <a href="<?php echo base_url('Period/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-export"></i> Export Data Excel</a>
    </div>
    <div class="col-md-4">
      <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-period"><i class="glyphicon glyphicon glyphicon-import"></i> Import Data Excel</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped" style="width: 100%;">
      <thead>
        <tr>
          <th style="text-align: center; width: 70px;">Period ID</th>
          <th style="text-align: center;">Start Period</th>
          <th style="text-align: center;">End Period</th>
          <th style="text-align: center;">Due Date</th>
          <th style="text-align: center; width: 100px;">Amount Days</th>
          <th style="text-align: center; width: 100px;">Action</th>
        </tr>
      </thead>
      <tbody id="data-period">

      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_tambah_period; ?>
<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js">

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataPeriod', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
$data['judul'] = 'Period Data';
$data['url'] = 'Period/import';
$data['link'] = 'assets/template_import/Period Template.xlsx';
$data['filename'] = 'Period Template.xlsx';
echo show_my_modal('modals/modal_import', 'import-period', $data);
?>