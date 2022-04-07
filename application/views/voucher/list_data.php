<?php
foreach ($dataVoucher as $vou) {
?>
  <tr class="bg-primary">
    <td><?php echo $vou->bukti_transaksi; ?></td>
    <td class="text-center">-</td>
    <td><?php if ($vou->so == 1) {
          echo 'Customer : ' . $vou->id_customer . ' (Unit : ' . $vou->unit_customer . ')';
        } else if ($vou->so == 0) {
          echo 'Owner : ' . $vou->id_owner . ' (Unit : ' . $vou->unit_owner . ')';
        } else if ($vou->so == 2) {
          echo 'Umum (Unit : ' . $vou->unit_owner . ')';
        } else if ($vou->so == 3) {
          echo $vou->relasi;
        } else {
          echo 'Owner : ' . $vou->id_owner . ' (Unit : ' . $vou->unit_owner . ')';
        }
        ?></td>
    <td><?php echo $vou->coa_id . ' - ' . $vou->coa_name; ?></td>
    <td><?php echo $vou->tanggal_voucher; ?></td>
    <td><?php echo $vou->keterangan; ?></td>
    <td><?php echo rupiah($vou->total); ?></td>
    <td class="text-center">
<!--       <?php if ($vou->tanggal_voucher < date("Y-m")) { ?>
        <button class="btn btn-warning btn-xs print-dataVoucher" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
        <button class="btn btn-success btn-xs print-dataBayar" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
      <?php } else { ?>
        <button class="btn btn-warning btn-xs print-dataVoucher" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
        <button class="btn btn-success btn-xs print-dataBayar" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
        <button class="btn btn-warning btn-xs update-dataVoucher" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-edit"></i></button>
        <button class="btn btn-danger btn-xs konfirmasiHapus-voucher" data-id="<?php echo $vou->id_voucher; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
      <?php } ?> -->
        <button class="btn btn-warning btn-xs print-dataVoucher" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
        <button class="btn btn-success btn-xs print-dataBayar" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
        <button class="btn btn-warning btn-xs update-dataVoucher" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-edit"></i></button>
        <button class="btn btn-danger btn-xs konfirmasiHapus-voucher" data-id="<?php echo $vou->id_voucher; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
  <?php
  if ($vou->so != 3) {
    foreach ($dataBayar as $bayar) {
      if ($bayar->id_voucher == $vou->id_voucher) {
  ?>
        <tr class="bg-info">
          <td><?php echo $bayar->id_voucher; ?></td>
          <td class="text-center"><?php if ($bayar->kode_soa == 22) {
                                    echo $bayar->bukti_transaksi;
                                  } else if ($bayar->kode_soa == 21) {
                                    echo $bayar->bukti_transaksi;
                                  } else {
                                    echo '-';
                                  }
                                  ?></td>
          <td><?php if ($bayar->kode_soa == 22) {
                echo 'AR SCSF Unit : ' . $vou->unit_customer;
              } else if ($bayar->kode_soa == 21) {
                echo 'AR LA Unit : ' . $vou->unit_owner;
              } else {
                echo 'AR Other Unit : ' . $vou->unit_owner;
              }
              ?></td>
          <td><?php echo $bayar->coa_id . ' - ' . $bayar->coa_name; ?></td>
          <td><?php echo $bayar->tanggal_bayar; ?></td>
          <td><?php echo $bayar->keterangan; ?></td>
          <td><?php echo rupiah($bayar->debit + $bayar->credit); ?></td>
          <td class="text-center"></td>
        </tr>
      <?php
      }
    }
  } else {
    foreach ($dataVendor as $vendor) {
      if ($vendor->id_voucher == $vou->id_voucher) {
      ?>
        <tr class="bg-info">
          <td><?php echo $vendor->id_voucher; ?></td>
          <td class="text-center">-</td>
          <td><?php echo $vou->relasi; ?></td>
          <td><?php echo $vendor->coa_id . ' - ' . $vendor->coa_name; ?></td>
          <td><?php echo $vendor->tanggal_transaksi; ?></td>
          <td><?php echo $vendor->keterangan; ?></td>
          <td><?php echo saldo($vendor->total); ?></td>
          <td class="text-center"></td>
        </tr>
  <?php
      }
    }
  }
  ?>
<?php
}
?>
