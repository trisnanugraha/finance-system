<?php
  $no = 1;
  foreach ($dataBank as $bank) {
    ?>
    <tr>
    <td><?php echo $no; ?></td>
      <td><?php echo $bank->id; ?></td>
      <td><?php echo $bank->rekening; ?></td>
      <td><?php echo $bank->nama; ?></td>
      <td class="text-center">
        <button class="btn btn-warning btn-sm update-dataBank" data-id="<?php echo $bank->id; ?>"><i class="glyphicon glyphicon-refresh"></i></button>
        <button class="btn btn-danger btn-sm konfirmasiHapus-bank" data-id="<?php echo $bank->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
        <!-- <button class="btn btn-info btn-sm detail-dataDeskripsi" data-id="<?php echo $desc->id; ?>"><i class="glyphicon glyphicon-info-sign"></i></button> -->
      </td>
    </tr>
    <?php
    $no++;
  }
?>