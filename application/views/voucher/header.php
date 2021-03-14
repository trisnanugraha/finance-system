<body>
    <?php foreach ($dataVoucher as $vou) : ?>
        <table width="100%">
            <tr>
                <td style="width: 80%; font-size: 10pt;"><span>Bulding Management SCBD-Suites</span></td>
                <td width="33%" class="text-align-right">Page {PAGENO} of {nbpg}</td>
            </tr>
            <tr>
                <td style="font-size: 10pt;"><span>Jln Jendral Sudirman Kav. 52-53 Jakarta 12190</span></td>
            </tr>
        </table>
        <table>
            <?php if ($vou->tipe_giro == 1 || $vou->tipe_giro == 2) { ?>
                <tr>
                    <td class="text-align-center" style="font-size: 13pt;"><strong>BUKTI TRANSFER PENERIMAAN</strong></td>
                </tr>
                <?php } else { ?>
                <tr>
                    <td class="text-align-center" style="font-size: 13pt;"><strong>BUKTI TRANSFER PENGELUARAN</strong></td>
                </tr>
            <?php } ?>
        </table>
        <table>
            <tr style="text-align: center">
                <td style="width: 70%; font-size: 9pt;" class="border-left border-top"><b>KODE KAS/BANK : </b><?= $vou->coa_id . '&nbsp;&nbsp;&nbsp;&nbsp;' . $vou->coa_name . ' AG'; ?></td>
                <td style="width: 20%; font-size: 9pt;" class="border-right border-top"><b>NO.ARSIP : </b></td>
            </tr>
            <?php if ($vou->so == 1) { ?>
                <tr>
                    <td class="border-left" style=" font-size: 9pt;"><b>KODE RELASI : </b><?= $vou->id_customer; ?></td>
                    <td class="border-right" style=" font-size: 9pt;"><span id="tgl"><b>TANGGAL : </b><?= $vou->tanggal_voucher; ?></span></td>
                </tr>
                <tr>
                    <td class="border-left border-bottom" style=" font-size: 9pt;"><b>NAMA RELASI : </b><?= $vou->nama_customer; ?></td>
                    <td class="border-right border-bottom" style=" font-size: 9pt;"><span id="no_bukti"><b>No BUKTI : </b><?= $vou->id_voucher; ?></span></td>
                </tr>
            <?php } else if ($vou->so == 0) { ?>
                <tr>
                    <td class="border-left" style=" font-size: 9pt;"><b>KODE RELASI : </b><?= $vou->id_owner; ?></td>
                    <td class="border-right" style=" font-size: 9pt;"><span id="tgl"><b>TANGGAL : </b><?= $vou->tanggal_voucher; ?></span></td>
                </tr>
                <tr>
                    <td class="border-left border-bottom" style=" font-size: 9pt;"><b>NAMA RELASI : </b><?= $vou->nama_owner; ?></td>
                    <td class="border-right border-bottom" style=" font-size: 9pt;"><span id="no_bukti"><b>No BUKTI : </b><?= $vou->id_voucher; ?></span></td>
                </tr>
            <?php } else if ($vou->so == 2) { ?>
                <tr>
                    <td class="border-left" style=" font-size: 9pt;"><b>KODE RELASI : </b><?= 'UMUM'; ?></td>
                    <td class="border-right" style=" font-size: 9pt;"><span id="tgl"><b>TANGGAL : </b><?= $vou->tanggal_voucher; ?></span></td>
                </tr>
                <tr>
                    <td class="border-left border-bottom" style=" font-size: 9pt;"><b>NAMA RELASI : </b><?= ' '; ?></td>
                    <td class="border-right border-bottom" style=" font-size: 9pt;"><span id="no_bukti"><b>No BUKTI : </b><?= $vou->id_voucher; ?></span></td>
                </tr>
            <?php } else if ($vou->so == 3) { ?>
                <tr>
                    <td class="border-left" style=" font-size: 9pt;"><b>KODE RELASI : </b><?= 'VENDOR'; ?></td>
                    <td class="border-right" style=" font-size: 9pt;"><span id="tgl"><b>TANGGAL : </b><?= $vou->tanggal_voucher; ?></span></td>
                </tr>
                <tr>
                    <td class="border-left border-bottom" style=" font-size: 9pt;"><b>NAMA RELASI : </b><?= $vou->relasi; ?></td>
                    <td class="border-right border-bottom" style=" font-size: 9pt;"><span id="no_bukti"><b>No BUKTI : </b><?= $vou->id_voucher; ?></span></td>
                </tr>
            <?php } ?>
        </table>
        <table>
            <tr>
                <td rowspan="2" style="width: 13%; font-size: 9pt; " class="border-right border-bottom border-left text-align-center"><b>Kode Akun</b></td>
                <td rowspan="2" style="width: 50%; font-size: 9pt; " class="border-right border-bottom text-align-center"><b>Uraian</b></td>
                <td rowspan="2" style="width: 12%; font-size: 9pt; " class="border-right border-bottom text-align-center"><b>Kode Cash Flow</b></td>
                <td rowspan="2" style="width: 5%; font-size: 9pt; " class="border-right border-bottom text-align-center"><b>Vlt</b></td>
                <td colspan="2" style="font-size: 9pt; " class="border-right border-bottom text-align-center"><b>Jumlah</b></td>
            </tr>
            <tr>
                <td style="width: 15%; font-size: 9pt; " class="border-right border-bottom text-align-center"><b>DEBET</b></td>
                <td style="width: 15%; font-size: 9pt; " class="border-right border-bottom text-align-center"><b>KREDIT</b></td>
            </tr>
        </table>
    <?php endforeach; ?>
</body>

</html>