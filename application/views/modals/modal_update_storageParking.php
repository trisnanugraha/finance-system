<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title"><center>Update Storage/Parking Bill</center></h3>
    </div>
    
    <form method="POST" id="form-update-storageParking">
      <div class="modal-body">
      <input type="hidden" name="noInvoice" value="<?php echo $dataStorageParking->no_invoice; ?>">
        <div class="form-group">
          <label class="control-label col-xs-3" >Storage/Parking Bill Code</label>
            <div class="col-xs-8">
              <input name="noInvoice" class="form-control" type="text" value="<?php echo $dataStorageParking->no_invoice; ?>" readonly>
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
                    <option value="<?php echo $cus->kodeCus; ?>" <?php if($cus->kodeCus == $dataStorageParking->id_customer){echo "selected='selected'";} ?>><?php echo $cus->kodeCus . ' - ' . $cus->nama; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <br>
        
        <div class="form-group">
          <label class="control-label col-xs-3" >Tanggal</label>
            <div class="col-xs-8">
              <input name="tanggal" class="form-control" type="date" value="<?php echo $dataStorageParking->tanggal; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Keterangan</label>
            <div class="col-xs-8">
              <input name="keterangan" class="form-control" type="text" placeholder="Keterangan" value="<?php echo $dataStorageParking->keterangan; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Jumlah Kendaraan</label>
            <div class="col-xs-8">
              <input name="jumlahKendaraan" class="form-control" type="text" placeholder="Jumlah Kendaraan" value="<?php echo $dataStorageParking->jumlah_kendaraan; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Harga Parkir</label>
            <div class="col-xs-8">
              <input name="hargaParkir" id="hargaParkir" class="form-control perhitungan" type="text" placeholder="Harga Parkir" value="<?php echo $dataStorageParking->harga_parkir; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Harga Gudang</label>
            <div class="col-xs-8">
              <input name="hargaGudang" id="hargaGudang" class="form-control perhitungan" type="text" placeholder="Harga Gudang" value="<?php echo $dataStorageParking->harga_gudang; ?>">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Total</label>
            <div class="col-xs-8">
              <input name="total" id="total" class="form-control perhitungan" type="text" placeholder="Total" value="<?php echo $dataStorageParking->total; ?>" readonly>
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
  $(function() {
    $(".select2").select2();
  });
</script>

<script type="text/javascript">
  function calculate() {
    var jmlKendaraan = parseFloat($("#jumlahKendaraan").val());
    var hargaParkir = parseFloat($("#hargaParkir").val());
    var hargaGudang = parseFloat($("#hargaGudang").val());
    var total = (jmlKendaraan * hargaParkir) + hargaGudang;
    $("#total").val(total);
  }

  $(".perhitungan").on("change paste keyup select", function() {
    calculate();
  });
</script>