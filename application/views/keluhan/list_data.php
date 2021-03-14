<?php
$no = 1;
foreach ($dataKeluhan as $keluhan) {
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $keluhan->kode_keluhan; ?></td>
    <td><?php echo $keluhan->username . ' ~ ' . $keluhan->nama; ?></td>
    <td><?php echo $keluhan->tanggal_keluhan; ?></td>
    <td><?php echo $keluhan->uraian; ?></td>
    <td><?php if ($keluhan->status == 0) {
          echo 'Belum Ditindak Lanjuti';
        } else if ($keluhan->status == 1) {
          echo 'Selesai Ditindak Lanjuti';
        } else {
          echo 'Pending';
        }
        ?>
    </td>
    <td class="text-center"><?php if ($keluhan->status == 0) {
                              echo '~';
                            } else if ($keluhan->status == 1) {
                              echo 'Penyebab : ' . $keluhan->penyebab . ' ~ Tindakan : ' . $keluhan->tindakan;
                            } else {
                              echo 'Penyebab : ' . $keluhan->penyebab . ' ~ Alasan Pending : ' . $keluhan->pending;
                            }
                            ?>
    </td>
    <td class="text-center" style="min-width:230px;">
      <button class="btn btn-info btn-sm detail-dataKeluhan" data-id="<?php echo $keluhan->kode_keluhan; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
    </td>
  </tr>
<?php
  $no++;
}
?>