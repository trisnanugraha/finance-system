<?php
  foreach ($dataService as $sc) {
    if ($sc->sinking_fund > 0 && $sc->service_charge > 0){
    ?>
    <tr>
      <td><input type="checkbox" class="check_item" value="<?=$sc->kode_tagihan_service?>" /></td>
      <td style="text-align: center;"><?php echo $sc->kode_tagihan_service; ?></td>
      <td><?php echo $sc->kode_owner . "<br>" . $sc->nama_owner; ?></td>
      <td><?php echo date('d/M/Y', strtotime($sc->periode_satu)) .'<br>'. date('d/M/Y', strtotime($sc->end_periode)); ?></td>
      <td><?php echo rupiah($sc->sinking_fund); ?></td>
      <td><?php echo rupiah($sc->service_charge); ?></td>
      <td><?php echo rupiah(round($sc->previous * 3 / 100)); ?></td>
      <td class="text-center" >
        <button class="btn btn-info btn-sm print-dataService" data-id="<?php echo $sc->kode_tagihan_service; ?>"><i class="glyphicon glyphicon-print"></i></button>
        <button class="btn btn-danger btn-sm konfirmasiHapus-service" data-id="<?php echo $sc->kode_tagihan_service; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
      </td>
    </tr>
    <?php
    }
  }
?>