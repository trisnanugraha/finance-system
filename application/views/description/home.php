<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="text-align: center; width: 50px;">No.</th>
          <th style="text-align: center;">Group</th>
          <th style="text-align: center;">Type</th>
          <th style="text-align: center; width: 150px;"">Spacius Room</th>
          <th style="text-align: center; width: 150px;">Electricity Capacity</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-description">
        
      </tbody>
    </table>
  </div>
</div>

<div id="tempat-modal"></div>