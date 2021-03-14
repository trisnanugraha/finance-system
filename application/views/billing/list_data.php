<?php
$no = 1;
foreach ($dataBilling as $billing) {
?>
  <tr>
    <td><input type="checkbox" class="check_item" value="<?= $billing->id_billing ?>" /></td>
    <td><?php echo $billing->id_billing; ?></td>
    <td><?php echo date('d-M-Y', strtotime($billing->start_periode)) . "<br>" . date('d-M-Y', strtotime($billing->end_periode)); ?></td>
    <td><?php echo $billing->id_customer . "<br>". $billing->nama_customer; ?></td>
    <td><?php echo rupiah($billing->total_listrik); ?></td>
    <td><?php echo rupiah($billing->total_air); ?></td>
    <td><?php echo rupiah(round($billing->total_air + $billing->total_listrik + $billing->stamp + $billing->previous * 3 / 100)); ?></td>
    <td class="text-center">
      <button class="btn btn-info btn-sm print-dataBilling" data-id="<?php echo $billing->id_billing; ?>"><i class="glyphicon glyphicon-print"></i></button>
      <button class="btn btn-danger btn-sm konfirmasiHapus-billing" data-id="<?php echo $billing->id_billing; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
  $no++;
}
?>