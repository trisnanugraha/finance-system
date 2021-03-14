<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-storageParking"><i class="glyphicon glyphicon-plus-sign"></i> Add New Storage/Parking Bill</button>
    </div>
    <div class="col-md-4">
        <a href="<?php echo base_url('StorageParking/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-export"></i> Export Excel Data</a>
    </div>
    <div class="col-md-4">
        <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-storageParking"><i class="glyphicon glyphicon glyphicon-import"></i> Import Excel Data</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <!-- <div class="row" style="padding: 0 20px 10px 20px;">
      <div class="col-md-4">
        <div class="form-group">
          <label for="owner" class="control-label">Owner</label>

          <select class="form-control" id="owner" name="owner">
            <option selected value="">-- All owner --</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="customer" class="control-label">Customer</label>

          <select class="form-control" id="customer" name="customer">
            <option selected value="">-- All customer --</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label hidden-xs">&nbsp;</label>
          <button id="filter" class="btn btn-success form-control">Filter</button>
        </div>
      </div>
    </div> -->
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="max-width:100px;">Storage/Parking Bill Code</th>
          <th>Customer</th>
          <th>Unit</th>
          <th>Date</th>
          <th>Total</th>
          <th>Type</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-storageParking">

      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataStorageParking', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Storage/Parking Data';
  $data['url'] = 'StorageParking/import';
  $data['link'] = 'assets/template_import/Storage-Parking Template.xlsx';
  $data['filename'] = 'Storage-Parking Template.xlsx';
  echo show_my_modal('modals/modal_import', 'import-storageParking', $data);
?>
<?php echo $modal_tambah_storageParking; ?>