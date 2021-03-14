<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-3">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-gl"><i class="glyphicon glyphicon-plus-sign"></i> Add New General Ledger</button>
    </div>
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-gl"><i class="glyphicon glyphicon-print"></i> Print General Ledger</button>
    </div>
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-report"><i class="glyphicon glyphicon-print"></i> Print Report</button>
    </div>
    <div class="col-md-3">
      <button type="button" name="delete_all" id="delete_all" class="form-control btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete All</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row" style="padding:0 20px 10px 20px;">
      <div class="col-md-3">
        <div class="form-group">
          <label for="akun" class="control-label">Charts of Accounts</label>

          <select class="form-control" id="akun" name="akun">
            <option selected value="">-- All akun --</option>
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
          <th style="min-width: 50px;">Tanggal</th>
          <th style="min-width: 70px;">Code</th>
          <th style="min-width: 70px;">CoA</th>
          <th style="min-width: 180px;">Keterangan</th>
          <th style="min-width: 100px;">Debit</th>
          <th style="min-width: 100px;">Kredit</th>
          <!-- <th style="min-width: 90px;">Selisih</th> -->
          <th style="text-align: center; min-width: 50px;">Action</th>
        </tr>
      </thead>
      <tbody id="data-gl">

      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_tambah_gl; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataGL', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
$data['judul'] = 'General Ledger Data';
$data['judul'] = 'Print General Ledger';
$data['url'] = 'GL/print';
echo show_my_modal('modals/modal_print_gl', 'print-gl', $data);
?>
<?php
$data['judul'] = 'General Ledger Data';
$data['judul'] = 'Print Report';
$data['url'] = 'GL/printReport';
echo show_my_modal('modals/modal_print_report', 'print-report', $data);
?>