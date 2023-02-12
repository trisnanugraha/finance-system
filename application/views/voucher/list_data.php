<?php foreach ($dataVoucher as $vou) { ?>
    <tr class="bg-primary">
        <td class="text-center"><?php echo $vou->bukti_transaksi; ?></td>
        <td class="text-center">-</td>
        <td class="text-center">
            <?php if ($vou->so == 1) {
                echo 'Customer : ' . $vou->id_customer . ' (Unit : ' . $vou->unit_customer . ')';
            } else if ($vou->so == 0) {
                echo 'Owner : ' . $vou->id_owner . ' (Unit : ' . $vou->unit_owner . ')';
            } else if ($vou->so == 2) {
                echo 'Umum (Unit : ' . $vou->unit_owner . ')';
            } else if ($vou->so == 3) {
                echo $vou->relasi;
            } else {
                echo 'Owner : ' . $vou->id_owner . ' (Unit : ' . $vou->unit_owner . ')';
            } ?>
        </td>
        <td><?php echo $vou->coa_id . ' - ' . $vou->coa_name; ?></td>
        <td class="text-center"><?php echo $vou->tanggal_voucher; ?></td>
        <td><?php echo $vou->keterangan; ?></td>
        <td style="width: 120px;"><?php echo rupiah($vou->total); ?></td>
        <td class="text-center" style="width: 150px;">
            <button class="btn btn-warning btn-xs print-dataVoucher" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
            <button class="btn btn-success btn-xs print-dataBayar" data-id="<?php echo $vou->id_voucher; ?>"><i class="glyphicon glyphicon-print"></i></button>
            <a href="<?= base_url('Voucher/update/'). $vou->id_voucher ?>" class="btn btn-warning btn-xs update-dataVoucher"><i class="glyphicon glyphicon-edit"></i></a>
            <button class="btn btn-danger btn-xs konfirmasiHapus-voucher" data-id="<?php echo $vou->id_voucher; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
        </td>
    </tr>
    <?php
    if ($vou->so != 3) {
        foreach ($dataBayar as $bayar) {
            if ($bayar->id_voucher == $vou->id_voucher) { ?>
                <tr class="bg-info">
                    <td class="text-center"><?php echo $bayar->id_voucher; ?></td>
                    <td class="text-center">
                        <?php if ($bayar->kode_soa == 21 || $bayar->kode_soa == 22 || $bayar->kode_soa == 24 ||$bayar->kode_soa == 25) {
                            echo $bayar->bukti_transaksi;
                        } else {
                            echo '-';
                        } ?>
                    </td>
                    <td class="text-center">
                        <?php if ($bayar->kode_soa == 22) {
                            echo 'AR SCSF Unit : ' . $vou->unit_owner;
                        } else if ($bayar->kode_soa == 21) {
                            echo 'AR LA Unit : ' . $vou->unit_customer;
                        } else if ($bayar->kode_soa == 24) {
                            echo 'AR IPK Unit : ' . $vou->unit_owner;
                        } else if ($bayar->kode_soa == 25) {
                            echo 'AR Asuransi Unit : ' . $vou->unit_owner;
                        } else {
                            echo 'AR Other Unit : ' . $vou->unit_owner;
                        } ?>
                    </td>
                    <td><?php echo $bayar->coa_id . ' - ' . $bayar->coa_name; ?></td>
                    <td class="text-center"><?php echo $bayar->tanggal_bayar; ?></td>
                    <td><?php echo $bayar->keterangan; ?></td>
                    <?php if ($bayar->debit != 0) { ?>
                        <td style="width: 120px;"><?php echo rupiah($bayar->debit); ?></td>
                    <?php } else if ($bayar->credit != 0) { ?>
                        <td style="width: 120px;"><?php echo rupiah($bayar->credit); ?></td>
                    <?php } else { ?>
                        <td style="width: 120px;"><?php echo rupiah($bayar->debit + $bayar->credit); ?></td>
                    <?php } ?>
                    <td class="text-center"></td>
                </tr>
            <?php
            }
        }
    } else {
        foreach ($dataVendor as $vendor) {
            if ($vendor->id_voucher == $vou->id_voucher) { ?>
                <tr class="bg-info">
                    <td class="text-center"><?php echo $vendor->id_voucher; ?></td>
                    <td class="text-center">-</td>
                    <td class="text-center"><?php echo $vou->relasi; ?></td>
                    <td><?php echo $vendor->coa_id . ' - ' . $vendor->coa_name; ?></td>
                    <td class="text-center"><?php echo $vendor->tanggal_transaksi; ?></td>
                    <td><?php echo $vendor->keterangan; ?></td>
                    <?php if ($vendor->debit != 0) { ?>
                        <td style="width: 120px;"><?php echo rupiah($vendor->debit); ?></td>
                    <?php } else if ($vendor->credit != 0) { ?>
                        <td style="width: 120px;"><?php echo rupiah($vendor->credit); ?></td>
                    <?php } else { ?>
                        <td style="width: 120px;"><?php echo rupiah($vendor->debit + $vendor->credit); ?></td>
                    <?php } ?>
                    <td class="text-center"></td>
                </tr>
    <?php   }
        }
    } ?>
<?php } ?>