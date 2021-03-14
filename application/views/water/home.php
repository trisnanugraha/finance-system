<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-water"><i class="glyphicon glyphicon-plus-sign"></i> Add New Water Bill</button>
    </div>
    <div class="col-md-4">
      <a href="<?php echo base_url('Water/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-export"></i> Export Data Excel</a>
    </div>
    <div class="col-md-4">
      <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-water"><i class="glyphicon glyphicon glyphicon-import"></i> Import Data Excel</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row" style="padding: 0 20px 10px 20px;">
      <div class="col-md-3">
        <div class="form-group">
          <label for="owner" class="control-label">Owner</label>

          <select class="form-control" id="owner" name="owner">
            <option selected value="">-- All owner --</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="customer" class="control-label">Customer</label>

          <select class="form-control" id="customer" name="customer">
            <option selected value="">-- All customer --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row" style="padding: 0 20px 10px 20px;">
      <div class="col-md-3">
        <div class="form-group">
          <label for="startDate" class="control-label">Start Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="startDate" id="startDate" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="endDate" class="control-label">End Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="endDate" id="endDate" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label hidden-xs">&nbsp;</label>
          <button id="filter" class="btn btn-primary form-control">Filter</button>
        </div>
      </div>
    </div>

    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Water Bill Code</th>
          <th>Customer</th>
          <th>Unit</th>
          <th>Period</th>
          <th style="min-width:100px;">Total</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-water">

      </tbody>
    </table>
  </div>
</div>



<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataWater', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Water Bills';
  $data['url'] = 'Water/import';
  $data['link'] = 'assets/template_import/Water Template.xlsx';
  $data['filename'] = 'Water Template.xlsx';
  echo show_my_modal('modals/modal_import', 'import-water', $data);
?>
<?php echo $modal_tambah_water; ?>