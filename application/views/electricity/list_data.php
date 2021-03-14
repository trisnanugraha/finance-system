<?php
foreach ($dataElectricity as $electricity) {
?>
  <tr>
    <td><?php echo $electricity->id_listrik; ?></td>
    <td><?php echo $electricity->id_customer . ' - ' . $electricity->nama_customer; ?></td>
    <td><?php echo $electricity->unit_customer; ?></td>
    <td><?php echo date('d/M/Y', strtotime($electricity->start_periode)) . ' ~ ' .  date('d/M/Y', strtotime($electricity->end_periode)); ?></td>
    <td><?php echo rupiah($electricity->total); ?></td>
    <td class="text-center">
      <button class="btn btn-info btn-sm detail-dataElectricity" data-id="<?php echo $electricity->id_listrik; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
      <button class="btn btn-danger btn-sm konfirmasiHapus-electricity" data-id="<?php echo $electricity->id_listrik; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
}
?>