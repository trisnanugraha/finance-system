<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-3" style="padding: 0;">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-report"><i class="glyphicon glyphicon-plus-sign"></i> Add New Report Data</button>
    </div>
    <div class="col-md-3">
        <a href="<?php echo base_url('Water/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-print"></i> Print All</a>
    </div>
    <div class="col-md-3">
        <a href="<?php echo base_url('Customer/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Excel Data</a>
    </div>
    <div class="col-md-3">
        <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-customer"><i class="glyphicon glyphicon glyphicon-floppy-open"></i> Import Excel Data</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>D/C Note</th>
          <th>D/C Note Date</th>
          <th>Customer Code</th>
          <th>Grand Total</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-report">
        
      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_tambah_report; ?>

<div id="tempat-modal"></div>