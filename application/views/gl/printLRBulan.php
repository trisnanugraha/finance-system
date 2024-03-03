<html lang="en">

<head>
    <title>Print</title>
    <style>
        table {
            width: 100%;
        }

        td.border {
            border: 1px solid black;
        }

        td.padding {
            padding: 5px 3px 5px 3px;
        }

        body {
            font-size: 9.5pt;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            display: flex;
            justify-content: center;
        }

        td.border-left {
            border-left: 1px solid black;
            padding-left: 5px;
        }

        td.border-right {
            border-right: 1px solid black;
            padding-right: 5px;
        }

        td.border-top {
            border-top: 1px solid black;
            padding-top: 5px;
        }

        td.border-bottom {
            border-bottom: 1px solid black;
            padding-bottom: 5px;
        }

        td.padding-top {
            padding-top: 5px;
        }

        td.padding-bottom {
            padding-bottom: 5px;
        }

        td.padding-right {
            padding-right: 5px;
        }

        td.padding-left {
            padding-left: 5px;
        }

        td.border-bottom-no-padding {
            border-bottom: 1px solid black;
        }

        td.border-top-no-padding {
            border-top: 1px solid black;
        }

        /* td {
                border: 1px solid black;
            }
            */
        table {
            border-collapse: collapse;
        }

        .text-align-right {
            text-align: right;
        }

        .text-align-center {
            text-align: center;
        }

        .text-valign-top {
            vertical-align: text-top;
        }

        div.page_break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="font-size: 13pt; text-align: center;"><span><strong>Building Management SCBD-Suites</strong></span></td>
        </tr>
        <tr>
            <td style="font-size: 13pt; text-align: center;"><span><strong>Surplus/Defisit Jan - Des</strong></span></td>
        </tr>
        <tr>
            <td><span id="bulan"><?= 'Bulan  : ' . date('F Y', strtotime($date)); ?></span></td>
        </tr>
        <tr>
            <td><span><?= 'Valuta : IDR Indonesian Rupiah'; ?></span></td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 11pt;"><span>KETERANGAN</span></td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
    </table>
    <?php
    $x = 0;
    $totalJanLR = 0;
    $totalFebLR = 0;
    $totalMarLR = 0;
    $totalAprLR = 0;
    $totalMeiLR = 0;
    $totalJunLR = 0;
    $totalJulLR = 0;
    $totalAugLR = 0;
    $totalSepLR = 0;
    $totalOctLR = 0;
    $totalNovLR = 0;
    $totalDesLR = 0;
    $totalLR = 0;
    foreach ($dataJurnal as $jt) : ?>
        <table>
            <tr>
                <td colspan="20" class="border-bottom-no-padding" style="font-size: 8pt"><strong><?= $jt->type_name; ?></strong></td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">January</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">February</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">March</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">April</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">May</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">June</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">July</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">August</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">September</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">October</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">November</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">December</td>
                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="text-align-center" style="font-size: 8pt">Total</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
            </tr>
            <?php
            $totalJan = 0;
            $totalFeb = 0;
            $totalMar = 0;
            $totalApr = 0;
            $totalMei = 0;
            $totalJun = 0;
            $totalJul = 0;
            $totalAug = 0;
            $totalSep = 0;
            $totalOct = 0;
            $totalNov = 0;
            $totalDes = 0;
            $total = 0;
            foreach ($dataCoA as $coa) {
                if ($jt->jurnal_tipe == $coa->jurnal_tipe) {
                    foreach ($dataGL as $gl) {
                        if ($gl->parent == $coa->parent) { ?>
                            <tr>
                                <td colspan="20" style="font-size: 8pt"><?= $gl->coa_id . ' - ' . $gl->coa_name ?></td>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoJanuari < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoJanuari) . ')'; ?></td>
                                    <?php $totalJan += $gl->saldoJanuari; ?>
                                <?php } else if ($gl->saldoJanuari >= 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoJanuari); ?></td>
                                    <?php $totalJan += $gl->saldoJanuari; ?>
                                <?php } else if ($gl->saldoJanuari < 0 && $coa->jurnal_tipe == 3) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoJanuari); ?></td>
                                    <?php $totalJan += $gl->saldoJanuari; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJanuari) . ')'; ?></td>
                                    <?php $totalJan += $gl->saldoJanuari; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoFebruari < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoFebruari) . ')'; ?></td>
                                    <?php $totalFeb += $gl->saldoFebruari; ?>
                                <?php } else if ($gl->saldoFebruari >= 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoFebruari); ?></td>
                                    <?php $totalFeb += $gl->saldoFebruari; ?>
                                <?php } else if ($gl->saldoFebruari < 0 && $coa->jurnal_tipe == 3) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoFebruari); ?></td>
                                    <?php $totalFeb += $gl->saldoFebruari; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoFebruari) . ')'; ?></td>
                                    <?php $totalFeb += $gl->saldoFebruari; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoMaret < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"> <?= '(' . saldo_money($gl->saldoMaret) . ')'; ?></td>
                                    <?php $totalMar += $gl->saldoMaret; ?>
                                <?php } else if ($gl->saldoMaret >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoMaret); ?></td>
                                    <?php $totalMar += $gl->saldoMaret; ?>
                                <?php } else if ($gl->saldoMaret < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoMaret); ?></td>
                                    <?php $totalMar += $gl->saldoMaret; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoMaret) . ')'; ?></td>
                                    <?php $totalMar += $gl->saldoMaret; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoApril < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"> <?= '(' . saldo_money($gl->saldoApril) . ')'; ?></td>
                                    <?php $totalApr += $gl->saldoApril; ?>
                                <?php } else if ($gl->saldoApril >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoApril); ?></td>
                                    <?php $totalApr += $gl->saldoApril; ?>
                                <?php } else if ($gl->saldoApril < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoApril); ?></td>
                                    <?php $totalApr += $gl->saldoApril; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoApril) . ')'; ?></td>
                                    <?php $totalApr += $gl->saldoApril; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoMei < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoMei) . ')'; ?></td>
                                    <?php $totalMei += $gl->saldoMei; ?>
                                <?php } else if ($gl->saldoMei >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoMei); ?></td>
                                    <?php $totalMei += $gl->saldoMei; ?>
                                <?php } else if ($gl->saldoMei < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoMei); ?></td>
                                    <?php $totalMei += $gl->saldoMei; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoMei) . ')'; ?></td>
                                    <?php $totalMei += $gl->saldoMei; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoJuni < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoJuni) . ')'; ?></td>
                                    <?php $totalJun += $gl->saldoJuni; ?>
                                <?php } else if ($gl->saldoJuni >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoJuni); ?></td>
                                    <?php $totalJun += $gl->saldoJuni; ?>
                                <?php } else if ($gl->saldoJuni < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoJuni); ?></td>
                                    <?php $totalJun += $gl->saldoJuni; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuni) . ')'; ?></td>
                                    <?php $totalJun += $gl->saldoJuni; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoJuli < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoJuli) . ')'; ?></td>
                                    <?php $totalJul += $gl->saldoJuli; ?>
                                <?php } else if ($gl->saldoJuli >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoJuli); ?></td>
                                    <?php $totalJul += $gl->saldoJuli; ?>
                                <?php } else if ($gl->saldoJuli < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoJuli); ?></td>
                                    <?php $totalJul += $gl->saldoJuli; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuli) . ')'; ?></td>
                                    <?php $totalJul += $gl->saldoJuli; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoAgustus < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoAgustus) . ')'; ?></td>
                                    <?php $totalAug += $gl->saldoAgustus; ?>
                                <?php } else if ($gl->saldoAgustus >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoAgustus); ?></td>
                                    <?php $totalAug += $gl->saldoAgustus; ?>
                                <?php } else if ($gl->saldoAgustus < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoAgustus); ?></td>
                                    <?php $totalAug += $gl->saldoAgustus; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoAgustus) . ')'; ?></td>
                                    <?php $totalAug += $gl->saldoAgustus; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoSeptember < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoSeptember) . ')'; ?></td>
                                    <?php $totalSep += $gl->saldoSeptember; ?>
                                <?php } else if ($gl->saldoSeptember >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoSeptember); ?></td>
                                    <?php $totalSep += $gl->saldoSeptember; ?>
                                <?php } else if ($gl->saldoSeptember < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoSeptember); ?></td>
                                    <?php $totalSep += $gl->saldoSeptember; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoSeptember) . ')'; ?></td>
                                    <?php $totalSep += $gl->saldoSeptember; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoOktober < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoOktober) . ')'; ?></td>
                                    <?php $totalOct += $gl->saldoOktober; ?>
                                <?php } else if ($gl->saldoOktober >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoOktober); ?></td>
                                    <?php $totalOct += $gl->saldoOktober; ?>
                                <?php } else if ($gl->saldoOktober < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoOktober); ?></td>
                                    <?php $totalOct += $gl->saldoOktober; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoOktober) . ')'; ?></td>
                                    <?php $totalOct += $gl->saldoOktober; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoNovember < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoNovember) . ')'; ?></td>
                                    <?php $totalNov += $gl->saldoNovember; ?>
                                <?php } else if ($gl->saldoNovember >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoNovember); ?></td>
                                    <?php $totalNov += $gl->saldoNovember; ?>
                                <?php } else if ($gl->saldoNovember < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoNovember); ?></td>
                                    <?php $totalNov += $gl->saldoNovember; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoNovember) . ')'; ?></td>
                                    <?php $totalNov += $gl->saldoNovember; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldoDesember < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldoDesember) . ')'; ?></td>
                                    <?php $totalDes += $gl->saldoDesember; ?>
                                <?php } else if ($gl->saldoDesember >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldoDesember); ?></td>
                                    <?php $totalDes += $gl->saldoDesember; ?>
                                <?php } else if ($gl->saldoDesember < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldoDesember); ?></td>
                                    <?php $totalDes += $gl->saldoDesember; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoDesember) . ')'; ?></td>
                                    <?php $totalDes += $gl->saldoDesember; ?>
                                <?php } ?>

                                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <?php if ($gl->saldo < 0 && $coa->jurnal_tipe == 2) { ?>
                                    <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                    <?php $total += $gl->saldo; ?></td>
                                <?php } else if ($gl->saldo >= 0 && $coa->jurnal_tipe == 2 && ) { ?>
                                    <td class="text-align-right"><?php echo saldo_money($gl->saldo); ?></td>
                                    <?php $total += $gl->saldo; ?>
                                <?php } else if ($gl->saldo < 0 && $coa->jurnal_tipe == 3 && ) { ?>
                                    <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                    <?php $total += $gl->saldo; ?>
                                <?php } else { ?>
                                    <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                     <?php $total += $gl->saldo; ?>
                                <?php } ?>
                            </tr>
            <?php
                        }
                    }
                }
            }
            ?>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="20" class="border-bottom border-top-no-padding"><?= 'TOTAL ' . $jt->type_name ?></td>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalJan < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJan) . ')'; ?></td>
                <?php } else if ($totalJan >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJan); ?></td>
                <?php } else if ($totalJan >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJan) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"> <?= saldo_money($totalJan); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalFeb < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalFeb) . ')'; ?></td>
                <?php } else if ($totalFeb >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"> <?= saldo_money($totalFeb); ?></td>
                <?php } else if ($totalFeb >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalFeb) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalFeb); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalMar < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMar) . ')'; ?></td>
                <?php } else if ($totalMar >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMar); ?></td>
                <?php } else if ($totalMar >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMar) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMar); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalApr < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalApr) . ')'; ?></td>
                <?php } else if ($totalApr >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalApr); ?></td>
                <?php } else if ($totalApr >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalApr) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalApr); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalMei < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMei) . ')'; ?></td>
                <?php } else if ($totalMei >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"> <?= saldo_money($totalMei); ?></td>
                <?php } else if ($totalMei >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMei) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMei); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalJun < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJun) . ')'; ?></td>
                <?php } else if ($totalJun >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJun); ?></td>
                <?php } else if ($totalJun >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJun) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJun); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalJul < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJul) . ')'; ?></td>
                <?php } else if ($totalJul >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJul); ?></td>
                <?php } else if ($totalJul >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"> <?= '(' . saldo_money($totalJul) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJul); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalAug < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAug) . ')'; ?></td>
                <?php } else if ($totalAug >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalAug); ?></td>
                <?php } else if ($totalAug >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAug) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalAug); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalSep < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalSep) . ')'; ?></td>
                <?php } else if ($totalSep >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalSep); ?></td>
                <?php } else if ($totalSep >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalSep) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalSep); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalOct < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalOct) . ')'; ?></td>
                <?php } else if ($totalOct >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"> <?= saldo_money($totalOct); ?></td>
                <?php } else if ($totalOct >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalOct) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalOct); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalNov < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalNov) . ')'; ?></td>
                <?php } else if ($totalNov >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalNov); ?></td>
                <?php } else if ($totalNov >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalNov) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalNov); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($totalDes < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalDes) . ')'; ?></td>
                <?php } else if ($totalDes >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalDes); ?></td>
                <?php } else if ($totalDes >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalDes) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalDes); ?></td>
                <?php } ?>

                <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php if ($total < 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($total) . ')'; ?></td>
                <?php } else if ($total >= 0 && $coa->jurnal_tipe == 1) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($total); ?></td>
                <?php } else if ($total >= 0 && $coa->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($total) . ')'; ?></td>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($total); ?></td>
                <?php } ?>
            </tr>

            <?php
            $totalJanLR += $totalJan;
            $totalFebLR += $totalFeb;
            $totalMarLR += $totalMar;
            $totalAprLR += $totalApr;
            $totalMeiLR += $totalMei;
            $totalJunLR += $totalJun;
            $totalJulLR += $totalJul;
            $totalAugLR += $totalAug;
            $totalSepLR += $totalSep;
            $totalOctLR += $totalOct;
            $totalNovLR += $totalNov;
            $totalDesLR += $totalDes;
            $totalLR += $total;
            ?>

            <tr>
                <td colspan="2">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
                <td class="text-align-right">&nbsp;&nbsp;</td>
                <td class="text-align-right">&nbsp;</td>
            </tr>
        </table>

        <?php $x++;

        if ($x < count($dataJurnal)) {
            echo '<div class="page_break"></div>';
        } ?>

    <?php endforeach; ?>
    <table>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="20" class="border-bottom border-top-no-padding">TOTAL Surplus/Defisit</td>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalJanLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJanLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJanLR) ?> </td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalFebLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalFebLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalFebLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalMarLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMarLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMarLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalAprLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAprLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalAprLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalMeiLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMeiLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMeiLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalJunLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJunLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJunLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalJulLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJulLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJulLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalAugLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAugLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"> <?= saldo_money($totalAugLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalSepLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"> <?= '(' . saldo_money($totalSepLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalSepLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalOctLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalOctLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalOctLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalNovLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalNovLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"> <?= saldo_money($totalNovLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalDesLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"> <?= '(' . saldo_money($totalDesLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalDesLR) ?></td>
            <?php } ?>

            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php if ($totalLR > 0) { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalLR) . ')' ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalLR) ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
            <td class="text-align-right">&nbsp;&nbsp;</td>
            <td class="text-align-right">&nbsp;</td>
        </tr>
    </table>
</body>

</html>