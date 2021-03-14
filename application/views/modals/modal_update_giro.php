<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Update Giro Data</center></h3>
    </div>
    
    <form id="form-update-giro" method="POST">   
        <div class="modal-body">

        <input type="hidden" name="idGiro" value="<?php echo $dataGiro->idGiro; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3" >Giro ID</label>
            <div class="col-xs-8">
              <input class="form-control" type="text" disabled value="<?php echo $dataGiro->idGiro; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Customer ID</label>
            <div class="col-xs-8">
                <select name="kodeCus" class="form-control select2" style="width: 100%">
                    <?php
                    foreach ($dataCustomer as $cus) {
                    ?>
                    <option value="<?php echo $cus->kodeCus; ?>" <?php if($cus->kodeCus == $dataGiro->kodeCus){echo "selected='selected'";} ?>><?php echo $cus->kodeCus; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Voucher ID</label>
            <div class="col-xs-8">
                <select name="idVou" class="form-control select2" style="width: 100%">
                    <?php
                    foreach ($dataVoucher as $vou) {
                    ?>
                    <option value="<?php echo $vou->idVou; ?>" <?php if($vou->idVou == $dataGiro->idVou){echo "selected='selected'";} ?>><?php echo $vou->idVou; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Jumlah Giro</label>
            <div class="col-xs-8">
              <input name="ket" class="form-control" type="text" placeholder="Keterangan" value="<?php echo $dataGiro->jumlah; ?>">
            </div>
        </div>
        <br>
        <br>
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="vouchermit" class="btn btn-primary">Add Data</button>
      </div>
    </form>
  </div>
</div>