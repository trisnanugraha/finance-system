<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-4">
      <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-rates"><i class="glyphicon glyphicon-plus-sign"></i> Add New Rate Data</button>
    </div>

  </div>
  <!-- /.box-header -->
  <div class="box-body">

    <div id="current-rate">

    </div>

    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="text-align: center;">Rate ID</th>
          <th style="text-align: center; width: 120px;">Standing Charge</th>
          <th style="text-align: center; width: 100px;">Water</th>
          <th style="text-align: center; width: 100px;">Electricity</th>
          <th style="text-align: center; width: 100px;">Sinking Fund</th>
          <th style="text-align: center; width: 100px;">Service Charge</th>
          <th style="text-align: center; width: 120px;">Updated At</th>
          <th style="text-align: center; width: 50px;">Action</th>
        </tr>
      </thead>
      <tbody id="data-rates">

      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_tambah_rate; ?>
<?php show_my_confirm('konfirmasiHapus', 'hapus-dataRates', 'Delete This Data ?', 'Yes, Delete This Data'); ?>


<div id="tempat-modal"></div>