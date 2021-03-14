<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary ">
      <h3 class="modal-title">
        <center>Add New Storage/Parking Bill</center>
      </h3>
    </div>

    <form id="form-tambah-storageParking" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-xs-3">Storage/Parking Bill Code</label>
          <div class="col-xs-8">
            <input name="noInvoice" id="noInvoice" class="form-control" type="text" placeholder="IN-STRG/2020/01/001">
          </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3">Type</label>
          <div class="col-xs-8">
            <select name="type" class="form-control select2" id="type" style="width: 100%">
              <option selected disabled>Choose Type</option>
              <?php
              foreach ($dataType as $type) {
              ?>
                <option value="<?php echo $type->id_type_sp; ?>">
                  <?php echo $type->nama_type ?>
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
          <label class="control-label col-xs-3">Customer</label>
          <div class="col-xs-8">
            <select name="kodeCus" class="form-control select2" id="kodeCus" style="width: 100%">
              <option selected disabled>Choose Customer</option>
              <?php
              foreach ($dataCustomer as $cus) {
              ?>
                <option value="<?php echo $cus->kodeCus; ?>">
                  <?php echo $cus->kodeCus . ' - ' . $cus->nama; ?>
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
            <label class="control-label col-xs-3">Tanggal</label>
            <div class="col-xs-8">
                <input name="tanggal" id="tanggal" type="date" value="<?= date('Y-m-d'); ?>" class="form-control pull-right">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Keterangan</label>
            <div class="col-xs-8">
              <textarea name="keterangan" id="keterangan" class="form-control" type="text" placeholder="Rental Storage Room - January 2020"></textarea>
            </div>
        </div>
        <br>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Jumlah Kendaraan</label>
            <div class="col-xs-8">
              <input name="jumlahKendaraan" id="jumlahKendaraan" class="form-control perhitungan" type="text" placeholder="1">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Harga Parkir</label>
            <div class="col-xs-8">
              <input name="hargaParkir" id="hargaParkir" class="form-control perhitungan" type="text" placeholder="10000">
            </div>
        </div>
        <br>
        <br>

        <div class="form-group">
          <label class="control-label col-xs-3" >Harga Gudang</label>
            <div class="col-xs-8">
              <input name="hargaGudang" id="hargaGudang" class="form-control perhitungan" type="text" placeholder="100000">
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
        <br>

      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" id="save" class="btn btn-primary">Add Data</button>
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