<?php
  foreach ($dataWorkingRequest as $wr) {
?>
    <tr>
      <td><?php echo $wr->no_invoice_wr; ?></td>
      <td><?php echo $wr->kode_customer . ' - ' . $wr->nama_customer; ?></td>
      <td><?php echo date('d/M/Y', strtotime($wr->tanggal)); ?></td>
      <td><?php echo rupiah($wr->total); ?></td>
      <td class="text-center" >
        <!-- <button class="btn btn-warning btn-sm update-dataWorkingRequest" data-id="<?php echo $wr->no_invoice_wr; ?>"><i class="glyphicon glyphicon-edit"></i></button> -->
        <button class="btn btn-info btn-sm detail-dataWorkingRequest" data-id="<?php echo $wr->no_invoice_wr; ?>"><i class="glyphicon glyphicon-info-sign"></i></button>
        <button class="btn btn-danger btn-sm konfirmasiHapus-workingRequest" data-id="<?php echo $wr->no_invoice_wr; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
      </td>
    </tr>
    <?php
    }
?>