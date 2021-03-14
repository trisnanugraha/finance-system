<?php
  $no = 1;
  foreach ($dataDescription as $desc) {
    ?>
    <tr>
    <td style="text-align: center;"><?php echo $no; ?></td>
      <td><?php echo $desc->jenis; ?></td>
      <td><?php echo $desc->tipe; ?></td>
      <td><?php echo $desc->sqm . ' m<sup>2</sup>'; ?></td>
      <td><?php echo $desc->kapasitas; ?></td>
      <td class="text-center">
        <button class="btn btn-warning btn-sm update-dataDescription" data-id="<?php echo $desc->id; ?>"><i class="glyphicon glyphicon-edit"></i></button>
        <!-- <button class="btn btn-info btn-sm detail-dataDeskripsi" data-id="<?php echo $desc->id; ?>"><i class="glyphicon glyphicon-info-sign"></i></button> -->
      </td>
    </tr>
    <?php
    $no++;
  }
?>