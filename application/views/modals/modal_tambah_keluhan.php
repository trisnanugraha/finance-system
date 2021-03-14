<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Keluah Data</center>
      </h3>
    </div>

    <form id="form-tambah-keluhan" method="POST">
      <div class="modal-body">

        <div class="form-group">
          <label class="control-label col-xs-4">Tanggal Keluhan</label>
          <div class="col-xs-8">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input name="date" id="date" type="text" class="form-control pull-right datepicker" placeholder="Masukkan Tanggal Keluhan">
            </div>
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-4">Uraian Keluhan</label>
          <div class="col-xs-8">
            <textarea name="uraian" id="uraian" class="form-control" type="text" placeholder="Uraian Keluhan"></textarea>
          </div>
        </div>
        <br>
        <br>
        <br>

      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary">Add Data</button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
    var startDate = new Date();
    $("#date").datepicker('setStartDate', startDate);
  });
</script>