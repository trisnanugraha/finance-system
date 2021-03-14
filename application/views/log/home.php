<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <!-- <div class="box-header">
    <div class="col-md-3">
      <button class="form-control btn btn-success" data-toggle="modal" data-target="#print-keluhan"><i class="glyphicon glyphicon-print"></i> Print Data Keluhan</button>
    </div>
  </div> -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Type</th>
          <th>Description</th>
          <th>Log ID Act</th>
          <th>Time</th>
          <th>IP Address</th>
        </tr>
      </thead>
      <tbody id="data-log">

      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>