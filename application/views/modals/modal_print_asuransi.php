<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Print Multiple Asuransi</h3>

  <form id="form-tambah-tarif" target="_blank" action="<?= base_url('Asuransi/printMultiple') ?>" method="POST">
    <br>
    <div class="form-group">
      <label class="control-label col-xs-2">Period</label>
      <div class="col-xs-10">
        <select name="period" class="form-control select2 print-period" style="width: 100%">
          <option selected disabled>Choose Period</option>
        </select>
      </div>
    </div>
    <br>
    <br>

    <div class="form-group">
      <div class="col-md-12">
        <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print</button>
      </div>
    </div>
  </form>
</div>