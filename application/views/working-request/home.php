<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-workingRequest"><i class="glyphicon glyphicon-plus-sign"></i> Add New Working Request Bill</button>
    </div>
    <div class="col-md-4">
      <a href="<?php echo base_url('WorkingRequest/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-export"></i> Export Data Excel</a>
    </div>
    <div class="col-md-4">
      <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-workingRequest"><i class="glyphicon glyphicon glyphicon-import"></i> Import Data Excel</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <!-- <div class="row" style="padding: 0 20px 10px 20px;">
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
    </div> -->

    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="max-width:70px;">Working Request Bill Code</th>
          <th>Customer</th>
          <th>Date</th>
          <th>Total</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-workingRequest">

      </tbody>
    </table>
  </div>
</div>



<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataWorkingRequest', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Working Request Bills';
  $data['url'] = 'WorkingRequest/import';
  $data['link'] = 'assets/template_import/Working-Request Template.xlsx';
  $data['filename'] = 'Working-Request Template.xlsx';
  echo show_my_modal('modals/modal_import', 'import-workingRequest', $data);
?>
<?php echo $modal_tambah_workingRequest; ?>