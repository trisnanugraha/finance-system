<?php
$no=1;
  foreach ($dataReport as $report) {
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $report->noteId; ?></td>
      <td><?php echo $report->noteDate; ?></td>
      <td><?php echo $report->kodeCus; ?></td>
      <td><?php echo $report->grandTotal; ?></td>
      <td class="text-center" style="min-width:230px;">
        <button class="btn btn-warning btn-sm update-dataReport" data-id="<?php echo $report->noteId; ?>"><i class="glyphicon glyphicon-refresh"></i></button>
        <button class="btn btn-success btn-sm print-dataReport" data-id="<?php echo $report->noteId; ?>"><i class="glyphicon glyphicon-print"></i></button>
        <!-- <button class="btn btn-danger btn-sm konfirmasiHapus-water" data-id="<?php echo $water->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button> -->
      </td>
    </tr>
    <?php
    $no++;
  }
?>