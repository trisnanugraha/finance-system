<?php
foreach ($dataAsuransi as $i) {
?>
  <tr>
    <td><input type="checkbox" class="check_item" value="<?= $i->id_asuransi ?>" /></td>
    <td style="text-align: center;"><?php echo $i->id_asuransi; ?></td>
    <td><?php echo $i->kode_owner . "<br>" . $i->nama_owner; ?></td>
    <td><?php echo date('d/M/Y', strtotime($i->start_periode)) . '<br>' . date('d/M/Y', strtotime($i->end_periode)); ?></td>
    <td><?php echo rupiah($i->total_asuransi); ?></td>
    <td class="text-center">
      <button class="btn btn-info btn-sm print-dataAsuransi" data-id="<?php echo $i->id_asuransi; ?>"><i class="glyphicon glyphicon-print"></i></button>
      <button class="btn btn-danger btn-sm konfirmasiHapus-asuransi" data-id="<?php echo $i->id_asuransi; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
}
?>