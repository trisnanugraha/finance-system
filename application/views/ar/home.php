<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="clo-md-6"></div>
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-ar"><i class="glyphicon glyphicon-print"></i> Print Kartu Piutang</button>
    </div>
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-aging"><i class="glyphicon glyphicon-print"></i> Print Aging Piutang</button>
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
          <th>Tanggal</th>
          <th>Code</th>
          <th>CoA</th>
          <th style="max-width: 150px;">Unit</th>
          <th>Keterangan</th>
          <th style="width: 90px;">Total Piutang</th>
          <th style="width: 90px;">Sisa Piutang</th>
          <th style="width: 80px;">Status</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-ar">

      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataAR', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Print Kartu Piutang';
  $data['url'] = 'AR/print';
  echo show_my_modal('modals/modal_print_ar', 'print-ar', $data);
?>

<?php
  $data['judul'] = 'Print Aging Piutang';
  $data['url'] = 'AR/print_aging';
  echo show_my_modal('modals/modal_print_aging', 'print-aging', $data);
?>