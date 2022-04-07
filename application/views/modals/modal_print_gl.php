<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">General Ledger</h3>
  <br>

  <form id="form-print-gl" target="_blank" action="<?= base_url('GL/print') ?>" method="POST">
    <div class="modal-body">

      <div class="form-group">
        <label class="control-label col-xs-4">Kode Akun Start</label>
        <div class="col-xs-8">
          <select name="coaPrintA" id="coaPrintA" class="form-control select2" style="width: 100%">
            <option selected disabled>Choose CoA</option>
            <?php
            foreach ($dataCoaPrint as $coa) {
            ?>
              <option value="<?php echo $coa->id_akun; ?>">
                <?php echo $coa->coa_id . ' - ' . $coa->coa_name; ?>
              </option>
            <?php
            }
            ?>
          </select>
        </div>
      </div>
      <br>
      <br>

      <div class="form-group">
        <label class="control-label col-xs-4">Kode Akun End</label>
        <div class="col-xs-8">
          <select name="coaPrintB" id="coaPrintB" class="form-control select2" style="width: 100%">
            <option selected disabled>Choose CoA</option>
            <?php
            foreach ($dataCoaPrint as $coa) {
            ?>
              <option value="<?php echo $coa->id_akun; ?>">
                <?php echo $coa->coa_id . ' - ' . $coa->coa_name; ?>
              </option>
            <?php
            }
            ?>
          </select>
        </div>
      </div>
      <br>
      <br>

      <div class="form-group">
        <label class="control-label col-xs-4">Start Date</label>
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
        <label class="control-label col-xs-4">End Date</label>
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

      <div class="form-group">
        <label class="control-label col-xs-4">Report Saldo Awal</label>
        <div class="col-xs-8">
          <select name="report" id="report" class="form-control" style="width: 100%">
            <option selected disabled>Choose Report Saldo Awal</option>
            <option value="0">Dengan Saldo Awal</option>
            <option value="1">Tanpa Saldo Awal</option>
          </select>
        </div>
      </div>
      <br>
      <br>

    </div>
    <div class="form-group">
      <div class="col-md-12">
        <button type="submit" id="print" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print General Ledger</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  $(function() {
    $(".select2").select2();
  });
</script>