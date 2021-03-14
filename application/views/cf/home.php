<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-3">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-mtd"><i class="glyphicon glyphicon-plus-sign"></i> Add New MTD BUDGET</button>
    </div>
    <div class="col-md-3">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-ytd"><i class="glyphicon glyphicon-plus-sign"></i> Add New YTD BUDGET</button>
    </div>
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-cf"><i class="glyphicon glyphicon-print"></i> Print Cash Flow</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row" style="padding:0 20px 10px 20px;">
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
          <th>#</th>
          <th>COA NAME</th>
          <th>MTD BUDGET</th>
          <th>MTD ACTUAL</th>
          <th>YTD BUDGET</th>
          <th>YTD ACTUAL</th>
        </tr>
      </thead>
      <tbody id="data-cf">
        
      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_tambah_mtd; ?>
<?php echo $modal_tambah_ytd; ?>

<div id="tempat-modal"></div>
<?php
  $data['judul'] = 'Cash Flow Data';
  $data['judul'] = 'Print Cash Flow';
  $data['url'] = 'CF/print';
  echo show_my_modal('modals/modal_print_cf', 'print-cf', $data);
?>