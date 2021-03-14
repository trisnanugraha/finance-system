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
        ?></td>
    <td class="text-center" style="min-width:230px;">
      <button class="btn btn-info btn-sm detail-dataKeluhan" data-id="<?php echo $keluhan->kode_keluhan; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
      <button class="btn btn-danger btn-sm konfirmasiHapus-keluhan" data-id="<?php echo $keluhan->kode_keluhan; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
  $no++;
}
?>