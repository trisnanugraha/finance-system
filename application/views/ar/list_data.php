<?php foreach ($dataAR as $ar) { ?>
  <tr>
    <td><input type="checkbox" class="check_item" value="<?= $ar->id_ar ?>" /></td>
    <td><?php if ($ar->kode_soa == 21) {
          echo $ar->first_billing;
        } else if ($ar->kode_soa == 22) {
          echo $ar->first_service;
        }
        ?></td>
    <td><?php echo $ar->bukti_transaksi; ?></td>
    <td><?php echo $ar->coa_id; ?></td>
    <td><?php if ($ar->so == 0) {
          echo $ar->id_customer . "<br>" . $ar->nama_customer;
        } else if ($ar->so == 1) {
          echo $ar->id_owner . "<br>" . $ar->nama_owner;
        } else {
          echo $ar->id_customer . "<br>" . $ar->nama_customer;
        }
        ?></td>
    <td><?php echo $ar->keterangan; ?></td>
    <td><?php echo rupiah($ar->total); ?></td>
    <td><?php echo rupiah($ar->sisa); ?></td>
    <td><?php if ($ar->status == 1) {
          echo 'Paid Off';
        } else if ($ar->status == 0) {
          echo 'Not Paid Yet';
        } else if ($ar->status == 2) {
          echo 'Remaining Paid';
        }
        ?></td>
    <td class="text-center">
      <!-- <button class="btn btn-info btn-sm print-dataAR" data-id="<?php echo $ar->id_ar; ?>"><i class="glyphicon glyphicon-print"></i></button> -->
      <button class="btn btn-danger btn-sm konfirmasiHapus-ar" data-id="<?php echo $ar->id_ar; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php } ?>