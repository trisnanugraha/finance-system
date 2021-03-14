<?php
  $no = 1;
  foreach ($dataCF as $cf) {
    ?>
    <tr>
    <td><?php echo $no; ?></td>
      <td><?php echo $cf->coa_id . ' - ' . $cf->coa_name; ?></td>
      <td>
        <?php if($cf->jurnal_tipe == 1 && $cf->mtd_budget != NULL && $cf->mtd_budget > 0){
          echo '(' . saldo($cf->mtd_budget) . ')';
        }else if($cf->jurnal_tipe == 3  && $cf->mtd_budget != NULL && $cf->mtd_budget > 0){
          echo '(' . saldo($cf->mtd_budget) . ')';
        }else if($cf->jurnal_tipe == 2 && $cf->mtd_budget != NULL && $cf->mtd_budget > 0){
          echo '(' . saldo($cf->mtd_budget) . ')';
        }else if($cf->jurnal_tipe == 4 && $cf->mtd_budget != NULL && $cf->mtd_budget > 0){
          echo '(' . saldo($cf->mtd_budget) . ')';
        }else{
          echo '0,00';
        }
      ?></td>
      <td>
        <?php if($cf->jurnal_tipe == 1 && $cf->mtd_actual != NULL && $cf->mtd_actual >= 0){ 
          echo saldo($cf->mtd_actual * - 1);
        }else if($cf->jurnal_tipe == 1 && $cf->mtd_actual != NULL && $cf->mtd_actual < 0){
          echo saldo($cf->mtd_actual * - 1);
        }else if($cf->jurnal_tipe == 3 && $cf->mtd_actual != NULL && $cf->mtd_actual >= 0){
          echo saldo($cf->mtd_actual * - 1);
        }else if($cf->jurnal_tipe == 3 && $cf->mtd_actual != NULL && $cf->mtd_actual < 0){
          echo saldo($cf->mtd_actual * - 1);
        }else if($cf->jurnal_tipe == 2 && $cf->mtd_actual != NULL && $cf->mtd_actual >= 0){ 
          echo saldo($cf->mtd_actual * - 1);
        }else if($cf->jurnal_tipe == 2 && $cf->mtd_actual != NULL && $cf->mtd_actual < 0){
          echo saldo($cf->mtd_actual * - 1);
        }else if($cf->jurnal_tipe == 4 && $cf->mtd_actual != NULL && $cf->mtd_actual >= 0){
          echo saldo($cf->mtd_actual * - 1);
        }else if($cf->jurnal_tipe == 4 && $cf->mtd_actual != NULL && $cf->mtd_actual < 0){
          echo saldo($cf->mtd_actual * - 1);
        }else{
          echo '0,00';
        }
      ?></td>
      <td>
      <?php if($cf->jurnal_tipe == 1 && $cf->ytd_budget != NULL && $cf->ytd_budget > 0){
          echo '(' . saldo($cf->ytd_budget) . ')';
        }else if($cf->jurnal_tipe == 3 && $cf->ytd_budget != NULL && $cf->ytd_budget > 0){
          echo '(' . saldo($cf->ytd_budget) . ')';
        }else if($cf->jurnal_tipe == 2 && $cf->ytd_budget != NULL && $cf->ytd_budget > 0){
          echo '(' . saldo($cf->ytd_budget) . ')';
        }else if($cf->jurnal_tipe == 4 && $cf->ytd_budget != NULL && $cf->ytd_budget > 0){
          echo '(' . saldo($cf->ytd_budget) . ')';
        }else{
          echo '0,00';
        }
      ?></td>
      <td>
        <?php if($cf->jurnal_tipe == 1 && $cf->ytd_actual != NULL && $cf->ytd_actual >= 0){ 
          echo saldo($cf->ytd_actual * - 1);
        }else if($cf->jurnal_tipe == 1 && $cf->ytd_actual != NULL && $cf->ytd_actual < 0){
          echo saldo($cf->ytd_actual * - 1);
        }else if($cf->jurnal_tipe == 3 && $cf->ytd_actual != NULL && $cf->ytd_actual >= 0){
          echo saldo($cf->ytd_actual * - 1);
        }else if($cf->jurnal_tipe == 3 && $cf->ytd_actual != NULL && $cf->ytd_actual < 0){
          echo saldo($cf->ytd_actual * - 1);
        }else if($cf->jurnal_tipe == 2 && $cf->ytd_actual != NULL && $cf->ytd_actual >= 0){ 
          echo saldo($cf->ytd_actual);
        }else if($cf->jurnal_tipe == 2 && $cf->ytd_actual != NULL && $cf->ytd_actual < 0){
          echo saldo($cf->ytd_actual);
        }else if($cf->jurnal_tipe == 4&& $cf->ytd_actual != NULL && $cf->ytd_actual >= 0){
          echo saldo($cf->ytd_actual);
        }else if($cf->jurnal_tipe == 4 && $cf->ytd_actual != NULL && $cf->ytd_actual < 0){
          echo saldo($cf->ytd_actual);
        }else{
          echo '0,00';
        }
      ?></td>
    </tr>
    <?php
    $no++;
  }
?>