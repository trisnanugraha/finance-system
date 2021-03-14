<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">General Ledger</h3>
  <br>

  <form id="form-print-report" target="_blank" action="<?= base_url('GL/printReport') ?>" method="POST">
    <div class="modal-body">

      <div class="form-group">
        <label class="control-label col-xs-3">Report</label>
        <div class="col-xs-8">
          <select name="report" id="report" class="form-control select2" style="width: 100%">
            <option selected disabled>Choose Report</option>
            <option value="0">Neraca (Jan-Des)</option>
            <!-- <option value="12">Balance Sheet</option> -->
            <option value="1">Detail Neraca</option>
            <option value="3">Surplus/Defisit (Jan-Des)</option>
            <option value="2">Detail Surplus/Defisit - PDF</option>
            <option value="14">Detail Surplus/Defisit - EXCEL</option>
            <option value="11">Rekap General Ledger - PDF</option>
            <option value="13">Rekap General Ledger - EXCEL</option>
            <!-- <option value="4">Cash Flow</option> -->
            <option value="5">Detail Bank 0081282862</option>
            <option value="6">Detail Bank 0081282854</option>
            <option value="7">Detail Bank 0081282901</option>
            <option value="8">Detail Bank 0081282600</option>
            <option value="9">Detail BCA - BEJ</option>
            <option value="10">Detail Petty Cash</option>
          </select>
        </div>
      </div>
      <br>
      <br>

      <div class="form-group">
        <label class="control-label col-xs-3">Start Date</label>
        <div class="col-xs-8">
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input name="dateReport" id="dateReport" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
          </div>
        </div>
      </div>
      <br>
      <br>

    </div>
    <div class="form-group">
      <div class="col-md-12">
        <button type="submit" id="printReport" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print Report</button>
      </div>
    </div>
  </form>
</div>