<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Print Keluhan</h3>
  <br>

  <form id="form-print-keluhan" target="_blank" action="<?= base_url('Keluhan/print') ?>" method="POST">
    <div class="modal-body">

      <div class="form-group">
        <label class="control-label col-xs-4">Tanggal Awal</label>
        <div class="col-xs-8">
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input name="dateA" id="dateA" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
          </div>
        </div>
      </div>
      <br>
      <br>

      <div class="form-group">
        <label class="control-label col-xs-4">Tanggal Akhir</label>
        <div class="col-xs-8">
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input name="dateB" id="dateB" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
          </div>
        </div>
      </div>
      <br>
      <br>

    </div>
    <div class="form-group">
      <div class="col-md-12">
        <button type="submit" id="print" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print Data Keluhan</button>
      </div>
    </div>
  </form>
</div>