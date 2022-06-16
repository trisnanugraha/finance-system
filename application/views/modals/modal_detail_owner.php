<div class="col-md-12 well">

  <h3>
    <center>Owner Data Detail</center>
  </h3>

  <div class="box box-body">
    <table id="tabel-detail" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Owner ID</th>
          <th>Virtual Code</th>
          <th>Name</th>
          <th>Unit</th>
          <th>Status</th>
          <th>Address</th>
          <th>Group</th>
          <th>Type</th>
          <th>Electricity Capacity</th>
        </tr>
      </thead>
      <tbody id="data-owner">
        <?php
        foreach ($dataOwner as $own) {
        ?>
          <tr>
            <td><?php echo $own->id; ?></td>
            <td><?php echo $own->kodeVir; ?></td>
            <td><?php echo $own->nama; ?></td>
            <td><?php echo $own->unit; ?></td>
            <td class="text-center">
              <?php if ($own->isActive == 1) { ?>
                <?php echo "Aktif"; ?>
              <?php } else { ?>
                <?php echo "Non Aktif"; ?>
              <?php } ?>
            </td>
            <td><?php echo $own->alamat; ?></td>
            <td><?php echo $own->jenis; ?></td>
            <td><?php echo $own->tipe; ?></td>
            <td><?php echo $own->kapasitas; ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="text-right">
    <button class="btn btn-primary" data-dismiss="modal"> Close</button>
  </div>
</div>
</div>