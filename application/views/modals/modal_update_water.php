<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Water Bill</center></h3>
    </div>
    
    <form method="POST" id="form-update-water">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?php echo $dataWater->id; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3" >Water Bill Code</label>
            <div class="col-xs-8">
              <input name="id" class="form-control" type="text" value="<?php echo $dataWater->id; ?>" readonly>
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
                    <option value="<?php echo $cus->kodeCus; ?>" <?php if($cus->kodeCus == $dataWater->kodeCus){echo "selected='selected'";} ?>><?php echo $cus->kodeCus; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Water Rates</label>
            <div class="col-xs-8">
                <select id="tarifAir" class="form-control select2 perhitungan" style="width: 100%">
                <?php
                    foreach ($dataRates as $rates) {
                    ?>
                    <option value="<?php echo $rates->water; ?>" <?php if($rates->id == $dataWater->tarifAir){echo "selected='selected'";} ?>><?php echo $rates->water; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Standing Charge</label>
            <div class="col-xs-8">
                <select name="charge" id="charge" class="form-control select2 perhitungan" style="width: 100%">
                <?php
                    foreach ($dataRates as $rates) {
                    ?>
                    <option value="<?php echo $rates->charge; ?>" <?php if($rates->id == $dataWater->tarifAir){echo "selected='selected'";} ?>><?php echo $rates->charge; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Period Start</label>
            <div class="col-xs-8">
              <input name="periodStart" class="form-control" type="text" placeholder="Period Start" value="<?php echo $dataWater->periodStart; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Period End</label>
            <div class="col-xs-8">
              <input name="periodEnd" class="form-control" type="text" placeholder="Period End" value="<?php echo $dataWater->periodEnd; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Due Date</label>
            <div class="col-xs-8">
              <input name="dueDate" class="form-control" type="text" placeholder="Due Date" value="<?php echo $dataWater->dueDate; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Start Meter</label>
            <div class="col-xs-8">
              <input name="startMeter" id="startMeter" class="form-control perhitungan" type="text" placeholder="Start Meter" value="<?php echo $dataWater->startMeter; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >End Meter</label>
            <div class="col-xs-8">
              <input name="endMeter" id="endMeter"class="form-control perhitungan" type="text" placeholder="End Meter" value="<?php echo $dataWater->endMeter; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Cons</label>
            <div class="col-xs-8">
              <input name="cons" id="cons" class="form-control perhitungan" type="text" placeholder="Cons" readonly>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Consumption</label>
            <div class="col-xs-8">
              <input name="consumption" id="consumption" class="form-control perhitungan" type="text" placeholder="Consumption" readonly>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Tax Area</label>
            <div class="col-xs-8">
              <input name="taxArea" id="taxArea" class="form-control perhitungan" type="text" placeholder="Tax Area" readonly>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Tax</label>
            <div class="col-xs-8">
              <input name="tax" id="tax" class="form-control perhitungan" type="text" placeholder="Tax" readonly>
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Total</label>
            <div class="col-xs-8">
              <input name="total" id="total" class="form-control perhitungan" type="text" placeholder="Total" readonly>
            </div>
        </div>
        <br>
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
$(function () {
    $(".select2").select2();
});
</script>

<script type ="text/javascript">
	$(".perhitungan").keyup(function(){
			var start = parseFloat($("#startMeter").val())
			var end = parseFloat($("#endMeter").val())
			var cons = end - start;
      $("#cons").attr("value",cons)
      
      var rates = parseFloat($("#tarifAir").val())
			var consumption = rates * cons;
      $("#consumption").attr("value",consumption)
      
      var charge = parseFloat($("#charge").val())
      var temp = consumption + charge;
      var taxArea = (temp * 10)/100;
      $("#taxArea").attr("value",taxArea)

      var jml = temp + taxArea;

      var tax = (jml * 10)/100;
      $("#tax").attr("value",tax)

      var total = jml + tax;
      $("#total").attr("value",total)
      
      });
	</script>