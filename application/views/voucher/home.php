<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="row">
      <div class="col-md-4">
        <a href="<?= base_url('Voucher/indexBayar') ?>" class="form-control btn btn-primary"><i class="fa fa-tasks"></i> Payment of Account Receivable</a>
      </div>
      <div class="col-md-4">
        <a href="<?= base_url('Voucher/indexBayarDeposit') ?>" class="form-control btn btn-primary"><i class="fa fa-tasks"></i> Payment of Account Receivable With Defosit Fund</a>
      </div>
      <div class="col-md-3">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#pengurangan-bank"><i class="glyphicon glyphicon-plus-sign"></i> Add New Voucher Bank Reduction</button>
      </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
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
      <div><label class="control-label" style="padding:0 0 20px 20px;">*Table Color Information (Light Blue: Transaction History and Dark Blue: Voucher List)</label></div>
      <table id="list-data" class="table table-bordered">
        <thead>
          <tr>
            <th>ID Voucher</th>
            <th>ID Piutang</th>
            <th>Relasi</th>
            <th>Bank</th>
            <th>Tanggal Pembayaran</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th style="text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody id="data-voucher">

        </tbody>
      </table>
    </div>
  </div>

  <!-- <?php echo $modal_tambah_voucher; ?> -->
  <?php echo $modal_pengurangan_bank; ?>

  <div id="tempat-modal"></div>
  <?php show_my_confirm('konfirmasiHapusBayar', 'hapus-dataBayar', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
  <?php show_my_confirm('konfirmasiHapus', 'hapus-dataVoucher', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
  <?php
  $data['judul'] = 'Voucher Data';
  ?>