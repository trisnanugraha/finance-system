<body>
    <?php
    $totalD = 0;
    $totalK = 0;
    foreach ($dataVoucher as $vou) :
        if ($vou->so != 3) {
            foreach ($dataBayar as $bayar) :
                $totalD += $bayar->debit;
                $totalK += $bayar->credit;
            endforeach;
        } else {
            foreach ($dataVendor as $vendor) :
                $totalD += $vendor->debit;
                $totalK += $vendor->credit;
            endforeach;
        } ?>
        <table>
            <tr>
                <td style="width: 13%;"></td>
                <td style="width: 50%;"></td>
                <td style="width: 12%;"></td>
                <td style="width: 5%;"></td>
                <td style="width: 15%;"></td>
                <td style="width: 15%;"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 9pt;  padding-left:10px;" class="border-left border-top border-bottom"></td>
                <td style="font-size: 9pt; " class="border-top border-bottom text-align-center"><b>JUMLAH</b></td>
                <td style="font-size: 9pt; " class="border-top border-bottom"></td>
                <td style="font-size: 9pt; " class="border-top border-bottom text-align-center"><span id="totalD"><?= money($totalD); ?></span></td>
                <td style="font-size: 9pt; " class="border-right border-top border-bottom text-align-center"><span id="totalK"><?= money($totalK); ?></span></td>
            </tr>
            <tr>
                <td colspan="4" style="font-size: 9pt;  padding-left:10px;" class="border-left border-right border-bottom"><b>PENJELASAN TRANSAKSI</b></td>
                <td colspan="2" style="font-size: 9pt; " class="border-right border-bottom text-align-center"><b>JUMLAH</b></td>
            </tr>
            <tr>
                <td colspan="4" style="font-size: 9pt;  padding-left:10px;" class="border-left border-right border-bottom"><b><span id="ket"><?= $vou->keterangan; ?></span></b></td>
                <td colspan="2" style="font-size: 9pt;  padding-right:15px;" class="border-right border-bottom text-align-right"><span id="total"> <?= money($vou->total) ?></span></td>
            </tr>
            <tr>
                <td style="font-size: 9pt;  padding-left:10px;" class="border-left border-bottom"><span id="total_bahasa"><b>terbilang : </b></td>
                <td colspan="3" style="font-size: 9pt;  padding-left:10px;" class="border-bottom"><span id="total_bahasa"><?= '#' . ucwords(number_to_words_rupiah(($vou->total))) . '#'; ?></span></td>
                <td colspan="2" style="font-size: 9pt; " class="border-right border-bottom text-align-center"></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan="2" style="width: 20%; font-size: 9pt;" class="border-right border-top border-bottom border-left text-align-center"><b>DISETUJUI</b></td>
                <td style="width: 20%; font-size: 9pt;" class="border-right border-top border-bottom text-align-center"><b>DIPERIKSA</b></td>
                <td style="width: 20%; font-size: 9pt;" class="border-right border-top border-bottom text-align-center"><b>DIBUAT</b></td>
                <td style="width: 20%; font-size: 9pt;" class="border-right border-top border-bottom text-align-center"><b>DITERIMA</b></td>
            </tr>
            <tr>
                <td style="font-size: 9pt;" class="border-right border-top border-bottom border-left text-align-center"><br><br><br><br></td>
                <td style="font-size: 9pt;" class="border-right border-bottom text-align-center"></td>
                <td style="font-size: 9pt;" class="border-right border-bottom text-align-center"></td>
                <td style="font-size: 9pt;" class="border-right border-bottom text-align-center"></td>
                <td style="font-size: 9pt;" class="border-right border-bottom text-align-center"></td>
            </tr>
        </table>
    <?php endforeach; ?>
</body>

</html>