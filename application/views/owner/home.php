<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-owner"><i class="glyphicon glyphicon-plus-sign"></i> Add New Owner Data</button>
    </div>
    <div class="col-md-4">
        <a href="<?php echo base_url('Owner/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-export"></i> Export Excel Data</a>
    </div>
    <div class="col-md-4">
        <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-owner"><i class="glyphicon glyphicon glyphicon-import"></i> Import Excel Data</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="table-owner" class="table table-bordered table-striped" style="width: 100%;">
      <thead>
        <tr>
          <th style="text-align: center; min-width:80px;">No.</th>
          <th style="text-align: center; width: 100px;">Owner ID</th>
          <th style="text-align: center; width: 120px;">Virtual Code</th>
          <th style="text-align: center; min-width: 200px;">Name</th>
          <th style="text-align: center; width: 100px;">Unit</th>
          <th style="text-align: center; width: 150px;">Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<?php echo $modal_tambah_owner; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataOwner', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Owner Data';
  $data['url'] = 'Owner/import';
  $data['link'] = 'assets/template_import/Owner Template.xlsx';
  $data['filename'] = 'Owner Template.xlsx';
  echo show_my_modal('modals/modal_import', 'import-owner', $data);
?>