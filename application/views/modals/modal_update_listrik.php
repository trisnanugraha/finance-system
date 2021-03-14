<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Update Tagihan Listrik</h3>
      <form method="POST" id="form-update-listrik">
        <input type="hidden" name="id" value="<?php echo $dataListrik->id; ?>">

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-briefcase"></i>
          </span>
          <select name="tenantId" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataTenant as $tenant) {
              ?>
              <option value="<?php echo $tenant->id; ?>" <?php if($tenant->id == $dataListrik->nama){echo "selected='selected'";} ?>><?php echo $tenant->nama; ?></option>
              <?php
            }
            ?>
          </select>
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Start Meter" name="meterStart" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->meterStart; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="End Meter" name="meterEnd" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->meterEnd; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-home"></i>
          </span>
          <select name="tarifId" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataTarif as $tarif) {
              ?>
              <option value="<?php echo $tarif->id; ?>" <?php if($tarif->id == $dataListrik->tarifListrik){echo "selected='selected'";} ?>><?php echo $tarif->listrik; ?></option>
              <?php
            }
            ?>
          </select>
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Capacity" name="capacity" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->capacity; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Cons" name="cons" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->meterStart; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Consumption" name="consumption" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->meterEnd; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="PPJU" name="ppju" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->meterEnd; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Amount Days" name="amount" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->amount; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Total" name="total" aria-describedby="sizing-addon2" value="<?php echo $dataListrik->total; ?>">
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-home"></i>
          </span>
          <select name="periodStart" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataPeriode as $periode) {
              ?>
              <option value="<?php echo $periode->id; ?>" <?php if($periode->id == $dataListrik->periodStart){echo "selected='selected'";} ?>><?php echo $periode->periodeStart; ?></option>
              <?php
            }
            ?>
          </select>
        </div>

        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-home"></i>
          </span>
          <select name="periodEnd" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataPeriode as $periode) {
              ?>
              <option value="<?php echo $periode->id; ?>" <?php if($periode->id == $dataListrik->periodEnd){echo "selected='selected'";} ?>><?php echo $periode->periodeEnd; ?></option>
              <?php
            }
            ?>
          </select>
        </div>
        
        <div class="form-group">
          <div class="col-md-12">
              <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Update Data</button>
          </div>
        </div>
      </form>
</div>

<script type="text/javascript">
$(function () {
    $(".select2").select2();
});
</script>