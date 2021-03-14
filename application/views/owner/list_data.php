<?php
  $no = 1;
  foreach ($dataOwner as $own) {
    ?>
    <tr>
    <td style="text-align: center;"><?php echo $no; ?></td>
      <td style="text-align: center;"><?php echo $own->id; ?></td>
      <td style="text-align: center;"><?php echo $own->kodeVir; ?></td>
      <td><?php echo $own->nama; ?></td>
      <td style="text-align: center;"><?php echo $own->unit; ?></td>
      <!-- <td><?php echo $own->kodeCus; ?></td> -->
      <td class="text-center" style="min-width:230px;">
        <button class="btn btn-warning btn-sm update-dataOwner" data-id="<?php echo $own->id; ?>"><i class="glyphicon glyphicon-edit"></i></button>
        <button class="btn btn-info btn-sm detail-dataOwner" data-id="<?php echo $own->id; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
        <button class="btn btn-danger btn-sm konfirmasiHapus-owner" data-id="<?php echo $own->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
      </td>
    </tr>
    <?php
    $no++;
  }
?>