<div class="col-md-12 well">

    <h3><center>Customer Data Detail</center></h3>
    
    <div class="box box-body">
      <table id="tabel-detail" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Customer ID</th>
            <th>Virtual Code</th>
            <th>Name</th>
            <th>Unit</th>
            <th>Address</th>
            <th>Group</th>
            <th>Type</th>
            <th>Electricity Capacity</th>
            <th>Owner ID</th>
          </tr>
        </thead>
        <tbody id="data-customer">
        <?php
            foreach ($dataCustomer as $cus) {
              ?>
              <tr>
                <td><?php echo $cus->kodeCus; ?></td>
                <td><?php echo $cus->kodeVir; ?></td>
                <td><?php echo $cus->nama; ?></td>
                <td><?php echo $cus->unit; ?></td>
                <td><?php echo $cus->alamat; ?></td>
                <td><?php echo $cus->jenis; ?></td>
                <td><?php echo $cus->tipe; ?></td>
                <td><?php echo $cus->kapasitas; ?></td>
                <td><?php echo $cus->owner; ?></td>
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