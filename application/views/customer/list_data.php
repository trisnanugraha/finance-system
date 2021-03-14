<?php
  $no = 1;
  foreach ($dataCustomer as $customer) {
    ?>
    <tr>
    <td style="text-align: center;"><?php echo $no; ?></td>
      <td style="text-align: center;"><?php echo $customer->kodeCus; ?></td>
      <td><?php echo $customer->kodeVir; ?></td>
      <td><?php echo $customer->nama; ?></td>
      <td style="text-align: center;"><?php echo $customer->unit; ?></td>
      <td style="text-align: center;"><?php echo $customer->owner; ?></td>
      <td class="text-center">
        <button class="btn btn-warning btn-sm update-dataCustomer" data-id="<?php echo $customer->kodeCus; ?>"><i class="glyphicon glyphicon-edit"></i></button>
        <button class="btn btn-info btn-sm detail-dataCustomer" data-id="<?php echo $customer->kodeCus; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
        <button class="btn btn-danger btn-sm konfirmasiHapus-customer" data-id="<?php echo $customer->kodeCus; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
      </td>
    </tr>
    <?php
    $no++;
  }
?>