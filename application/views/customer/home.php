<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-customer"><i class="glyphicon glyphicon-plus-sign"></i> Add New Customer Data</button>
    </div>
    <div class="col-md-4">
        <a href="<?php echo base_url('Customer/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-export"></i> Export Excel Data</a>
    </div>
    <div class="col-md-4">
        <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-customer"><i class="glyphicon glyphicon glyphicon-import"></i> Import Excel Data</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="text-align: center;">No.</th>
          <th style="text-align: center;">Customer ID</th>
          <th style="text-align: center;">Virtual Code</th>
          <th style="text-align: center; width: 220px;">Name</th>
          <th style="text-align: center;">Unit</th>
          <th style="text-align: center;">Owner ID</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-customer">
        
      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_tambah_customer; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataCustomer', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Customer Data';
  $data['url'] = 'Customer/import';
  $data['link'] = 'assets/template_import/Customer Template.xlsx';
  $data['filename'] = 'Customer Template.xlsx';
  echo show_my_modal('modals/modal_import', 'import-customer', $data);
?>