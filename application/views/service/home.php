<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-3">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-service"><i class="glyphicon glyphicon-plus-sign"></i> Add New Service</button>
    </div>
    <div class="col-md-3">
      <button class="form-control btn btn-primary" data-toggle="modal" id="tambah-service-period"><i class="glyphicon glyphicon-plus-sign"></i> Add New Service (Period)</button>
    </div>
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-multiple-service"><i class="glyphicon glyphicon-print"></i> Print Multiple</button>
    </div>
    <div class="col-md-3">
      <button type="button" name="delete_all" id="delete_all" class="form-control btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete All</button>
    </div>
  </div>
  <div class="box-body">
    <div class="row" style="padding:0 20px 10px 20px;">
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
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label hidden-xs">&nbsp;</label>
          <button id="filter" class="btn btn-primary form-control">Filter</button>
        </div>
      </div>
    </div>
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th><input type="checkbox" id="check_all"></th>
          <th style="text-align: center;">Service Charge ID</th>
          <th style="text-align: center;">Owner</th>
          <th style="text-align: center;">Period</th>
          <th style="text-align: center;">Shinking Fund</th>
          <th style="text-align: center;">Service Charge</th>
          <th style="text-align: center;">Penalty</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-service">

      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>

<?php
  show_my_confirm('konfirmasiHapus', 'hapus-dataService', 'Delete This Data ?', 'Yes, Delete This Data');
  $data['judul'] = 'Print Multiple Bills';
  $data['url'] = 'Service/printMultiple';
  echo show_my_modal('modals/modal_print_service', 'print-multiple-service', $data);
?>
<?php echo $modal_tambah_service; ?>