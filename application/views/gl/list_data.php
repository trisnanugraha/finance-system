<?php
  foreach ($dataTotalGL as $tgl) {
    if ($tgl->so == 1) {
    ?>
    <tr>
      <td><input type="checkbox" class="check_item"/></td>
      <td><?php echo $tgl->tanggal_transaksi; ?></td>
      <td><?php echo $tgl->bukti_transaksi; ?></td>
      <td class="text-center">-</td>
      <td><?php echo 'TOTAL' ?></td>
      <td><?php echo rupiah($tgl->debit); ?></td>
      <td><?php echo rupiah($tgl->credit); ?></td>
      <!-- <td><?php echo rupiah($tgl->debit - $tgl->credit); ?></td> -->
      <td class="text-center">
        <button class="btn btn-warning btn-sm update-dataGL" data-id="<?php echo $tgl->id_gl; ?>"><i class="glyphicon glyphicon-edit"></i></button>
        <!-- <button class="btn btn-danger btn-sm konfirmasiHapus-gl" data-id="<?php echo $tgl->id_gl; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button> -->
      </td>
    </tr>
    <?php
    foreach ($dataGL as $gl) {
      if ($tgl->bukti_transaksi == $gl->bukti_transaksi) {
      ?>
        <tr>
          <td><input type="checkbox" class="check_item" value="<?=$gl->id_gl?>" /></td>
          <td><?php echo $gl->tanggal_transaksi; ?></td>
          <td><?php echo $gl->bukti_transaksi; ?></td>
          <td><?php echo $gl->coa_id; ?></td>
          <td><?php echo $gl->keterangan;?></td>
          <td><?php echo rupiah($gl->debit); ?></td>
          <td><?php echo rupiah($gl->credit); ?></td>
          <!-- <td><?php echo rupiah($gl->debit - $gl->credit); ?></td> -->
          <td class="text-center">
            <!-- <button class="btn btn-warning btn-sm update-dataGL" data-id="<?php echo $gl->id_gl; ?>"><i class="glyphicon glyphicon-edit"></i></button> -->
            <button class="btn btn-danger btn-sm konfirmasiHapus-gl" data-id="<?php echo $gl->id_gl; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
          </td>
        </tr>
    <?php
        }
      }
    ?>
  <?php
  }
}
?>