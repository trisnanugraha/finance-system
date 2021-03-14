<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Aging Piutang</h3>
  <br>

  <form id="form-print-aging" target="_blank" action="<?= base_url('AR/print_aging') ?>" method="POST">
    <div class="modal-body">

      <div class="form-group">
        <label class="control-label col-xs-4">Jenis Piutang</label>
        <div class="col-xs-8">
          <select name="CoA" id="CoA" class="form-control select2" style="width: 100%">
            <option selected disabled>Choose Piutang</option>
            <?php
            foreach ($dataCoaAR as $CoA) {
            ?>
              <option value="<?php echo $CoA->id_akun; ?>">
                <?php echo $CoA->coa_id . ' - ' . $CoA->coa_name; ?>
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
        <label class="control-label col-xs-4">Date</label>
        <div class="col-xs-8">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="date" id="date" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
            </div>
        </div>
      </div>
      <br>
      <br>

    </div>
    <div class="form-group">
      <div class="col-md-12">
        <button type="submit" id="print" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print Aging Piutang</button>
      </div>
    </div>
  </form>
</div>

<!-- <script>
$(document).ready(function(){

    $('#print').click(function(){

      var kodeCus = $('#kodeCus').val();
      var year = $('#year').val();
      var monthA = $('#monthA').val();
      var monthB = $('#monthB').val();

      console.log(kodeCus);

      $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('AR/print'); ?>',
        data : {
            kodeCus : kodeCus,
            year : year, 
            monthA : monthA, 
            monthB : monthB
          }
      });

    });
});
</script> -->