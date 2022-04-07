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
    <table id="table-coa" class="table table-bordered table-striped" style="width: 100%;">
      <thead>
        <tr>
          <th style="max-width:50px;">CoA ID</th>
          <th style="max-width:150px;">Name</th>
          <th style="max-width:100px;">Type Jurnal</th>
          <th style="max-width:100px;">Account Type</th>
          <th style="text-align: center; max-width: 50px;">Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<?php echo $modal_tambah_coa; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataCoa', 'Delete This Data ?', 'Yes, Delete This Data'); ?>
<?php
  $data['judul'] = 'Charts Of Accounts';
?>