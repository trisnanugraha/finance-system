<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-6">
      <button class="form-control btn btn-default btn-primary" data-toggle="modal" data-target="#tambah-bank"><i class="glyphicon glyphicon-plus-sign"></i> Add New Bank Account</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Bank ID</th>
          <th>Account</th>
          <th>Name</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-bank">

      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>

<?php echo $modal_tambah_bank; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataBank', 'Delete This Data ?', 'Yes, Delete This Data'); ?>