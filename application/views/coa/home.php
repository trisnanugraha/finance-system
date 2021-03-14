<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-coa"><i class="glyphicon glyphicon-plus-sign"></i> Add New Charts Of Accounts</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>CoA ID</th>
          <th style="max-width:100px;">Name</th>
          <th>Type Jurnal</th>
          <th>Account Type</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-coa">
      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_tambah_coa; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataCoa', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Charts Of Accounts';
?>