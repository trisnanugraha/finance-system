<div class="row" style="padding-left:20px;">
    <div class="col-sm-2">
        Current Rate
        <address>
            <strong>Standing Charge</strong><br>
            <span id="currentStandingCharge"><?php echo $current_rate == null ? "Not set" : rupiah($current_rate->charge); ?></span>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-2">
        <br>
        <address>
            <strong>Water</strong><br>
            <span id="currentWaterRate"><?php  echo $current_rate == null ? "Not set" : rupiah($current_rate->water); ?></span>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-2">
        <br>
        <address>
            <strong>Electricity</strong><br>
            <span id="currentElectricRate"><?php  echo $current_rate == null ? "Not set" : rupiah($current_rate->electric); ?></span>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-2">
        <br>
        <address>
            <strong>Sinking Fund</strong><br>
            <span id="currentSinkingRate"><?php  echo $current_rate == null ? "Not set" : rupiah($current_rate->sinking); ?></span>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-2">
        <br>
        <address>
            <strong>Service Charge</strong><br>
            <span id="currentServiceRate"><?php  echo $current_rate == null ? "Not set" : rupiah($current_rate->service); ?></span>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-2">
        <br>
        <address>
            <strong>Updated At</strong><br>
            <span id="currentUpdatedRate"><?php  echo $current_rate == null ? "Not set" : dateFormat($current_rate->created_at); ?></span>
        </address>
    </div>

</div>