<?php
foreach ($dataRates as $rates) {
  ?>
  <tr>
    <td style="text-align: center;"><?php echo $rates->id; ?></td>
    <td><?php echo rupiah($rates->charge); ?></td>
    <td><?php echo rupiah($rates->water); ?></td>
    <td><?php echo rupiah($rates->electric); ?></td>
    <td><?php echo rupiah($rates->sinking); ?></td>
    <td><?php echo rupiah($rates->service); ?></td>
    <td><?php echo dateFormat($rates->created_at); ?></td>
    <td class="text-center">
      <button class="btn btn-warning btn-sm update-dataRates" data-id="<?php echo $rates->id; ?>"><i class="glyphicon glyphicon-edit"></i></button>
      <button class="btn btn-danger btn-sm konfirmasiHapus-rates" data-id="<?php echo $rates->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
}
?>