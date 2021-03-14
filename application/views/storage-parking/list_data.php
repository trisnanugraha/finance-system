<?php
foreach ($dataStorageParking as $sp) {
?>
  <tr>
    <td><?php echo $sp->no_invoice; ?></td>
    <td><?php echo $sp->kode_customer . ' - ' . $sp->nama_customer; ?></td>
    <td><?php echo $sp->unit_customer; ?></td>
    <td><?php echo date('d/M/Y', strtotime($sp->tanggal)); ?></td>
    <td><?php echo rupiah($sp->total); ?></td>
    <td><?php echo $sp->nama_type; ?></td>
    <td class="text-center">
      <!-- <button class="btn btn-warning btn-sm update-dataStorageParking" data-id="<?php echo $sp->no_invoice; ?>"><i class="glyphicon glyphicon-edit"></i></button> -->
      <button class="btn btn-info btn-sm detail-dataStorageParking" data-id="<?php echo $sp->no_invoice; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
      <button class="btn btn-danger btn-sm konfirmasiHapus-storageParking" data-id="<?php echo $sp->no_invoice; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
}
?>