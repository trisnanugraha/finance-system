<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Tanggal Jatuh Tempo</th>
          <th>Keterangan Tagihan</th>
          <th>Total Tagihan</th>
          <th>Status Tagihan</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($dataAR as $ar) { ?>
          <tr class="bg-info">
            <td><?php echo $no; ?></td>
            <td><?php echo $ar->due_date; ?></td>
            <td><?php echo 'Code Invoice (' . $ar->bukti_transaksi . ') ~ Tagihan Untuk : ' . $ar->coa_name; ?></td>
            <td><?php echo rupiah($ar->sisa); ?></td>
            <td><?php if ($ar->status == 1) {
                  echo 'Paid Off';
                } else if ($ar->status == 0) {
                  echo 'Not Paid Yet';
                } else if ($ar->status == 2) {
                  echo 'Remaining Paid';
                }
                ?>
            </td>
          </tr>
        <?php $no++;
        } ?>

      </tbody>
    </table>
  </div>
</div>