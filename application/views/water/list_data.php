<?php
  foreach ($dataWater as $water) {
    if($water->total > 0){
    ?>
    <tr>
      <td><?php echo $water->kode_tagihan_air; ?></td>
      <td><?php echo $water->kode_customer . ' - ' . $water->nama_customer; ?></td>
      <td><?php echo $water->unit_customer;?></td>
      <td><?php echo date('d/M/Y', strtotime($water->start_periode)) . ' ~ ' .  date('d/M/Y', strtotime($water->end_periode)); ?></td>
      <td><?php echo rupiah($water->total); ?></td>
      <td class="text-center" >
        <button class="btn btn-info btn-sm detail-dataWater" data-id="<?php echo $water->kode_tagihan_air; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
        <button class="btn btn-danger btn-sm konfirmasiHapus-water" data-id="<?php echo $water->kode_tagihan_air; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
      </td>
    </tr>
    <?php
    }
  }
?>