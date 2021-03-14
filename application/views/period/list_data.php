<?php
$no = 1;
foreach ($dataPeriod as $period) {
  ?>
  <tr>
    <td style="text-align: center;"><?php echo $period->id; ?></td>
    <td style="text-align: center;"><?php echo date('d/M/Y', strtotime($period->periodStart)); ?></td>
    <td style="text-align: center;"><?php echo date('d/M/Y', strtotime($period->periodEnd)); ?></td>
    <td style="text-align: center;"><?php echo date('d/M/Y', strtotime($period->dueDate)); ?></td>
    <td style="text-align: center;"><?php echo $period->amount; ?></td>
    <td class="text-center">
      <button class="btn btn-warning btn-sm update-dataPeriod" data-id="<?php echo $period->id; ?>"><i class="glyphicon glyphicon-edit"></i></button>
      <!-- <button class="btn btn-info btn-sm detail-period" data-id="<?php echo $period->id; ?>"><i class="glyphicon glyphicon-info-sign"></i></button> -->
      <button class="btn btn-danger btn-sm konfirmasiHapus-period" data-id="<?php echo $period->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
  $no++;
}
?>
