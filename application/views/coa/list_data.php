<?php
foreach ($dataCoa as $coa) {
?>
  <tr>
    <td><?php echo $coa->coa_id; ?></td>
    <td><?php echo $coa->coa_name; ?></td>
    <td><?php echo $coa->type_name; ?></td>
    <td><?php echo $coa->acc_type; ?></td>
    <td class="text-center">
      <button class="btn btn-danger btn-sm konfirmasiHapus-coa" data-id="<?php echo $coa->id_akun; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
  </tr>
<?php
}
?>