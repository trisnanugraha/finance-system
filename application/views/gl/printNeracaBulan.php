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
            <td style="font-size: 13pt; text-align: center;"><span><strong>Detail Neraca</strong></span></td>
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
    foreach ($dataJurnal as $jt) :
        if ($jt->jurnal_tipe == 1) { ?>
            <table>
                <tr>
                    <td colspan="100" class="border-bottom-no-padding"><strong><?= $jt->type_name; ?></strong></td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">January</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">February</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">March</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">April</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">May</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">June</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">July</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">August</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">September</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">October</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">November</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">December</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">Total</td>
                </tr>
                <tr>
                    <td colspan="28">&nbsp;</td>
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
                                    <td colspan="100"><?= $gl->coa_id . ' - ' . $gl->coa_name ?></td>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoJanuari != NULL && $gl->saldoJanuari < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoJanuari) . ')'; ?></td>
                                        <?php $totalJan += $gl->saldoJanuari; ?>
                                    <?php } else if ($gl->saldoJanuari != NULL && $gl->saldoJanuari >= 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoJanuari); ?></td>
                                        <?php $totalJan += $gl->saldoJanuari; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalJan += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoFebruari != NULL && $gl->saldoFebruari < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoFebruari) . ')'; ?></td>
                                        <?php $totalFeb += $gl->saldoFebruari; ?>
                                    <?php } else if ($gl->saldoFebruari >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoFebruari != NULL) { ?>
                                        <td class="text-align-right"> <?php echo saldo_money($gl->saldoFebruari); ?></td>
                                        <?php $totalFeb += $gl->saldoFebruari; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                        <?php $totalFeb += 0; ?>
                                    <?php } ?></td>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoMaret != NULL && $gl->saldoMaret < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoMaret) . ')'; ?></td>
                                        <?php $totalMar += $gl->saldoMaret; ?>
                                    <?php } else if ($gl->saldoMaret >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoMaret != NULL) { ?>
                                        <td class="text-align-right"> <?php echo saldo_money($gl->saldoMaret); ?></td>
                                        <?php $totalMar += $gl->saldoMaret; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                        <?php $totalMar += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoApril != NULL && $gl->saldoApril < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoApril) . ')'; ?></td>
                                        <?php $totalApr += $gl->saldoApril; ?>
                                    <?php } else if ($gl->saldoApril >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoApril != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoApril); ?></td>
                                        <?php $totalApr += $gl->saldoApril; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalApr += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoMei != NULL && $gl->saldoMei < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoMei) . ')'; ?></td>
                                        <?php $totalMei += $gl->saldoMei; ?>
                                    <?php } else if ($gl->saldoMei >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoMei != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoMei); ?></td>
                                        <?php $totalMei += $gl->saldoMei; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalMei += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoJuni != NULL && $gl->saldoJuni < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoJuni) . ')'; ?></td>
                                        <?php $totalJun += $gl->saldoJuni; ?>
                                    <?php } else if ($gl->saldoJuni >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoJuni != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoJuni); ?></td>
                                        <?php $totalJun += $gl->saldoJuni; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalJun += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoJuli != NULL && $gl->saldoJuli < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoJuli) . ')'; ?></td>
                                        <?php $totalJul += $gl->saldoJuli; ?>
                                    <?php } else if ($gl->saldoJuli >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoJuli != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoJuli); ?></td>
                                        <?php $totalJul += $gl->saldoJuli; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalJul += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoAgustus != NULL && $gl->saldoAgustus < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoAgustus) . ')'; ?></td>
                                        <?php $totalAug += $gl->saldoAgustus; ?>
                                    <?php } else if ($gl->saldoAgustus >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoAgustus != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoAgustus); ?></td>
                                        <?php $totalAug += $gl->saldoAgustus; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                        <?php $totalAug += 0; ?>
                                    <?php } ?></td>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoSeptember != NULL && $gl->saldoSeptember < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoSeptember) . ')'; ?></td>
                                        <?php $totalSep += $gl->saldoSeptember; ?>
                                    <?php } else if ($gl->saldoSeptember >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoSeptember != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoSeptember); ?></td>
                                        <?php $totalSep += $gl->saldoSeptember; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalSep += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoOktober != NULL && $gl->saldoOktober < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoOktober) . ')'; ?></td>
                                        <?php $totalOct += $gl->saldoOktober; ?>
                                    <?php } else if ($gl->saldoOktober >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoOktober != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoOktober); ?></td>
                                        <?php $totalOct += $gl->saldoOktober; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalOct += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoNovember != NULL && $gl->saldoNovember < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoNovember) . ')'; ?></td>
                                        <?php $totalNov += $gl->saldoNovember; ?>
                                    <?php } else if ($gl->saldoNovember >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoNovember != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoNovember); ?></td>
                                        <?php $totalNov += $gl->saldoNovember; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalNov += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldoDesember != NULL && $gl->saldoDesember < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldoDesember) . ')'; ?></td>
                                        <?php $totalDes += $gl->saldoDesember; ?>
                                    <?php } else if ($gl->saldoDesember >= 0 && $coa->jurnal_tipe == 1 && $gl->saldoDesember != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldoDesember); ?></td>
                                        <?php $totalDes += $gl->saldoDesember; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $totalDes += 0; ?>
                                    <?php } ?>

                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <?php if ($gl->saldo != NULL && $gl->saldo < 0 && $coa->jurnal_tipe == 1) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                        $total += $gl->saldo; ?>
                                    <?php } else if ($gl->saldo >= 0 && $coa->jurnal_tipe == 1 && $gl->saldo != NULL) { ?>
                                        <td class="text-align-right"><?php echo saldo_money($gl->saldo); ?></td>
                                        <?php $total += $gl->saldo; ?>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?php echo '0,00'; ?></td>
                                        <?php $total += 0; ?>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>

                <tr>
                    <td colspan="30">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="100" class="border-bottom border-top-no-padding"><?= 'TOTAL ' . $jt->type_name ?></td>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalJan < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJan) . ')'; ?></td>
                    <?php } else if ($totalJan >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJan); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalFeb < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalFeb) . ')'; ?></td>
                    <?php } else if ($totalFeb >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalFeb); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalMar < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMar) . ')'; ?></td>
                    <?php } else if ($totalMar >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMar); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalApr < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalApr) . ')'; ?></td>
                    <?php } else if ($totalApr >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalApr); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalMei < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMei) . ')'; ?></td>
                    <?php } else if ($totalMei >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMei); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalJun < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJun) . ')'; ?></td>
                    <?php } else if ($totalJun >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJun); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalJul < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJul) . ')'; ?></td>
                    <?php } else if ($totalJul >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJul); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalAug < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAug) . ')'; ?></td>
                    <?php } else if ($totalAug >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalAug); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalSep < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalSep) . ')'; ?></td>
                    <?php } else if ($totalSep >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalSep); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalOct < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalOct) . ')'; ?></td>
                    <?php } else if ($totalOct >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalOct); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalNov < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalNov) . ')'; ?></td>
                    <?php } else if ($totalNov >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalNov); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalDes < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalDes) . ')'; ?></td>
                    <?php } else if ($totalDes >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalDes); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($total < 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($total) . ')'; ?></td>
                    <?php } else if ($total >= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($total); ?></td>
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

            <?php $x++;

            if ($x < count($dataJurnal)) {
                echo '<div class="page_break"></div>';
            } ?>

        <?php } else if ($jt->jurnal_tipe == 4) { ?>

            <table>
                <tr>
                    <td colspan="100" class="border-bottom-no-padding"><strong><?= $jt->type_name; ?></strong></td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">January</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">February</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">March</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">April</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">May</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">June</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">July</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">August</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">September</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">October</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">November</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">December</td>
                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="text-align-center">Total</td>
                </tr>
                <tr>
                    <td colspan="28">&nbsp;</td>
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
                ?>
                <?php foreach ($dataCoA as $coa) : ?>
                    <?php if ($coa->jurnal_tipe == 4) { ?>
                        <?php if ($coa->parent != 270) { ?>
                            <?php foreach ($dataGL as $gl) : ?>
                                <?php if ($gl->parent == $coa->parent) { ?>
                                    <tr>
                                        <td colspan="100"><?= $gl->coa_id . ' - ' . $gl->coa_name ?></td>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoJanuari != NULL && $gl->saldoJanuari < 0 && $coa->jurnal_tipe == 4) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoJanuari); ?></td>
                                            <?php $totalJan += $gl->saldoJanuari; ?>
                                        <?php } else if ($gl->saldoJanuari != NULL && $gl->saldoJanuari >= 0 && $coa->jurnal_tipe == 4) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJanuari) . ')'; ?></td>
                                            <?php $totalJan += $gl->saldoJanuari; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJan += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoFebruari < 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoFebruari); ?></td>
                                            <?php $totalFeb += $gl->saldoFebruari; ?>
                                        <?php } else if ($gl->saldoFebruari >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                            <td class="text-align-right"> <?php echo '(' . saldo_money($gl->saldoFebruari) . ')'; ?></td>
                                            <?php $totalFeb += $gl->saldoFebruari; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                            <?php $totalFeb += 0; ?>
                                        <?php } ?></td>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoMaret < 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoMaret); ?></td>
                                            <?php $totalMar += $gl->saldoMaret; ?>
                                        <?php } else if ($gl->saldoMaret >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                            <td class="text-align-right"> <?php echo '(' . saldo_money($gl->saldoMaret) . ')'; ?></td>
                                            <?php $totalMar += $gl->saldoMaret; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                            <?php $totalMar += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoApril < 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoApril); ?></td>
                                            <?php $totalApr += $gl->saldoApril; ?>
                                        <?php } else if ($gl->saldoApril >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoApril) . ')'; ?></td>
                                            <?php $totalApr += $gl->saldoApril; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalApr += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoMei < 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoMei); ?></td>
                                            <?php $totalMei += $gl->saldoMei; ?>
                                        <?php } else if ($gl->saldoMei >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoMei) . ')'; ?></td>
                                            <?php $totalMei += $gl->saldoMei; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalMei += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoJuni < 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoJuni); ?></td>
                                            <?php $totalJun += $gl->saldoJuni; ?>
                                        <?php } else if ($gl->saldoJuni >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuni) . ')'; ?></td>
                                            <?php $totalJun += $gl->saldoJuni; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJun += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoJuli < 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoJuli); ?></td>
                                            <?php $totalJul += $gl->saldoJuli; ?>
                                        <?php } else if ($gl->saldoJuli >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuli) . ')'; ?></td>
                                            <?php $totalJul += $gl->saldoJuli; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJul += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoAgustus < 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoAgustus); ?></td>
                                            <?php $totalAug += $gl->saldoAgustus; ?>
                                        <?php } else if ($gl->saldoAgustus >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoAgustus) . ')'; ?></td>
                                            <?php $totalAug += $gl->saldoAgustus; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                            <?php $totalAug += 0; ?>
                                        <?php } ?></td>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoSeptember < 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoSeptember); ?></td>
                                            <?php $totalSep += $gl->saldoSeptember; ?>
                                        <?php } else if ($gl->saldoSeptember >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoSeptember) . ')'; ?></td>
                                            <?php $totalSep += $gl->saldoSeptember; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalSep += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoOktober < 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoOktober); ?></td>
                                            <?php $totalOct += $gl->saldoOktober; ?>
                                        <?php } else if ($gl->saldoOktober >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoOktober) . ')'; ?></td>
                                            <?php $totalOct += $gl->saldoOktober; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalOct += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoNovember < 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoNovember); ?></td>
                                            <?php $totalNov += $gl->saldoNovember; ?>
                                        <?php } else if ($gl->saldoNovember >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoNovember) . ')'; ?></td>
                                            <?php $totalNov += $gl->saldoNovember; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalNov += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoDesember < 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoDesember); ?></td>
                                            <?php $totalDes += $gl->saldoDesember; ?>
                                        <?php } else if ($gl->saldoDesember >= 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoDesember) . ')'; ?></td>
                                            <?php $totalDes += $gl->saldoDesember; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalDes += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldo < 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $total += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo >= 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $total += $gl->saldo; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $total += 0; ?>
                                        <?php } ?>
                                    </tr>

                                <?php } ?>
                            <?php endforeach ?>
                        <?php } else if ($coa->parent == 270) { ?>
                            <?php foreach ($dataGL as $gl) : ?>
                                <?php if ($gl->kode_soa == 271) { ?>
                                    <tr>
                                        <td colspan="100"><?= $gl->coa_id . ' - ' . $gl->coa_name ?></td>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoJanuari != NULL && $gl->saldoJanuari < 0 && $coa->jurnal_tipe == 4) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoJanuari); ?></td>
                                            <?php $totalJan += $gl->saldoJanuari; ?>
                                        <?php } else if ($gl->saldoJanuari != NULL && $gl->saldoJanuari >= 0 && $coa->jurnal_tipe == 4) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJanuari) . ')'; ?></td>
                                            <?php $totalJan += $gl->saldoJanuari; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJan += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoFebruari <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoFebruari); ?></td>
                                            <?php $totalFeb += $gl->saldoFebruari; ?>
                                        <?php } else if ($gl->saldoFebruari > 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                            <td class="text-align-right"> <?php echo '(' . saldo_money($gl->saldoFebruari) . ')'; ?></td>
                                            <?php $totalFeb += $gl->saldoFebruari; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                            <?php $totalFeb += 0; ?>
                                        <?php } ?></td>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoMaret <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoMaret); ?></td>
                                            <?php $totalMar += $gl->saldoMaret; ?>
                                        <?php } else if ($gl->saldoMaret > 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoMaret) . ')'; ?></td>
                                            <?php $totalMar += $gl->saldoMaret; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalMar += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoApril <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoApril); ?></td>
                                            <?php $totalApr += $gl->saldoApril; ?>
                                        <?php } else if ($gl->saldoApril > 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoApril) . ')'; ?></td>
                                            <?php $totalApr += $gl->saldoApril; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalApr += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoMei <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoMei); ?></td>
                                            <?php $totalMei += $gl->saldoMei; ?>
                                        <?php } else if ($gl->saldoMei > 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoMei) . ')'; ?></td>
                                            <?php $totalMei += $gl->saldoMei; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalMei += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoJuni <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoJuni); ?></td>
                                            <?php $totalJun += $gl->saldoJuni; ?>
                                        <?php } else if ($gl->saldoJuni > 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuni) . ')'; ?></td>
                                            <?php $totalJun += $gl->saldoJuni; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJun += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoJuli <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoJuli); ?></td>
                                            <?php $totalJul += $gl->saldoJuli; ?>
                                        <?php } else if ($gl->saldoJuli > 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuli) . ')'; ?></td>
                                            <?php $totalJul += $gl->saldoJuli; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJul += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoAgustus <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoAgustus); ?></td>
                                            <?php $totalAug += $gl->saldoAgustus; ?>
                                        <?php } else if ($gl->saldoAgustus > 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoAgustus) . ')'; ?></td>
                                            <?php $totalAug += $gl->saldoAgustus; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"> <?php echo '0,00'; ?></td>
                                            <?php $totalAug += 0; ?>
                                        <?php } ?></td>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoSeptember <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoSeptember); ?></td>
                                            <?php $totalSep += $gl->saldoSeptember; ?>
                                        <?php } else if ($gl->saldoSeptember > 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoSeptember) . ')'; ?></td>
                                            <?php $totalSep += $gl->saldoSeptember; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalSep += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoOktober <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoOktober); ?></td>
                                            <?php $totalOct += $gl->saldoOktober; ?>
                                        <?php } else if ($gl->saldoOktober > 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoOktober) . ')'; ?></td>
                                            <?php $totalOct += $gl->saldoOktober; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalOct += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoNovember <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoNovember); ?></td>
                                            <?php $totalNov += $gl->saldoNovember; ?>
                                        <?php } else if ($gl->saldoNovember > 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoNovember) . ')'; ?></td>
                                            <?php $totalNov += $gl->saldoNovember; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalNov += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldoDesember <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoDesember); ?></td>
                                            <?php $totalDes += $gl->saldoDesember; ?>
                                        <?php } else if ($gl->saldoDesember > 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoDesember) . ')'; ?></td>
                                            <?php $totalDes += $gl->saldoDesember; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalDes += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if ($gl->saldo <= 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $total += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo > 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $total += $gl->saldo; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $total += 0; ?>
                                        <?php } ?>
                                    </tr>
                                <?php } else if ($gl->kode_soa == 272) { ?>
                                    <tr>
                                        <td colspan="100"><?= $gl->coa_id . ' - ' . $gl->coa_name ?></td>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbJan + $jt->rpJan) != NULL && ($jt->rbJan + $jt->rpJan) >= 0) { ?>
                                            <?php if ($gl->saldoJanuari != NULL && $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan) <= 0 && $coa->jurnal_tipe == 4) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoJanuari + ($jt->rbJan + $jt->rpJan)); ?></td>
                                                <?php $totalJan += $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan); ?>
                                            <?php } else if ($gl->saldoJanuari != NULL && $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan) > 0 && $coa->jurnal_tipe == 4) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJanuari + ($jt->rbJan + $jt->rpJan)) . ')'; ?></td>
                                                <?php $totalJan += $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbJan + $jt->rpJan)) . ')'; ?></td>
                                                <?php $totalJan += ($jt->rbJan + $jt->rpJan); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbJan + $jt->rpJan) != NULL && ($jt->rbJan + $jt->rpJan) < 0) { ?>
                                            <?php if ($gl->saldoJanuari != NULL && $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan) <= 0 && $coa->jurnal_tipe == 4) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoJanuari + ($jt->rbJan + $jt->rpJan)); ?></td>
                                                <?php $totalJan += $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan); ?>
                                            <?php } else if ($gl->saldoJanuari != NULL && $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan) > 0 && $coa->jurnal_tipe == 4) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJanuari + ($jt->rbJan + $jt->rpJan)) . ')'; ?></td>
                                                <?php $totalJan += $gl->saldoJanuari + ($jt->rbJan + $jt->rpJan); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbJan + $jt->rpJan)); ?></td>
                                                <?php $totalJan += ($jt->rbJan + $jt->rpJan); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJan += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbFeb + $jt->rpFeb) != NULL && ($jt->rbFeb + $jt->rpFeb) >= 0) { ?>
                                            <?php if ($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb)); ?></td>
                                                <?php $totalFeb += $gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb); ?>
                                            <?php } else if ($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                                <td class="text-align-right"> <?php echo '(' . saldo_money($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb)) . ')'; ?></td>
                                                <?php $totalFeb += $gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbFeb + $jt->rpFeb)) . ')'; ?></td>
                                                <?php $totalFeb += ($jt->rbFeb + $jt->rpFeb); ?>
                                            <?php } ?></td>
                                        <?php } else if (($jt->rbFeb + $jt->rpFeb) < 0 && ($jt->rbFeb + $jt->rpFeb) != NULL) { ?>
                                            <?php if ($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb)); ?></td>
                                                <?php $totalFeb += $gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb); ?>
                                            <?php } else if ($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoFebruari != NULL) { ?>
                                                <td class="text-align-right"> <?php echo '(' . saldo_money($gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb)) . ')'; ?></td>
                                                <?php $totalFeb += $gl->saldoFebruari + ($jt->rbFeb + $jt->rpFeb); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"> <?php echo saldo_money(($jt->rbFeb + $jt->rpFeb)); ?></td>
                                                <?php $totalFeb += ($jt->rbFeb + $jt->rpFeb); ?>
                                            <?php } ?></td>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalFeb += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbMar + $jt->rpMar) != NULL && ($jt->rbMar + $jt->rpMar) >= 0) { ?>
                                            <?php if ($gl->saldoMaret + ($jt->rbMar + $jt->rpMar) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoMaret + ($jt->rbMar + $jt->rpMar)); ?></td>
                                                <?php $totalMar += $gl->saldoMaret; ?>
                                            <?php } else if ($gl->saldoMaret + ($jt->rbMar + $jt->rpMar) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                                <td class="text-align-right"> <?php echo '(' . saldo_money($gl->saldoMaret + ($jt->rbMar + $jt->rpMar)) . ')'; ?></td>
                                                <?php $totalMar += $gl->saldoMaret + ($jt->rbMar + $jt->rpMar); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"> <?= '(' . saldo_money(($jt->rbMar + $jt->rpMar)) . ')'; ?></td>
                                                <?php $totalMar += ($jt->rbMar + $jt->rpMar); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbMar + $jt->rpMar) < 0 && ($jt->rbMar + $jt->rpMar) != NULL) { ?>
                                            <?php if ($gl->saldoMaret + ($jt->rbMar + $jt->rpMar) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoMaret + ($jt->rbMar + $jt->rpMar)); ?></td>
                                                <?php $totalMar += $gl->saldoMaret; ?>
                                            <?php } else if ($gl->saldoMaret + ($jt->rbMar + $jt->rpMar) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoMaret != NULL) { ?>
                                                <td class="text-align-right"> <?php echo '(' . saldo_money($gl->saldoMaret + ($jt->rbMar + $jt->rpMar)) . ')'; ?></td>
                                                <?php $totalMar += $gl->saldoMaret + ($jt->rbMar + $jt->rpMar); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"> <?php echo saldo_money(($jt->rbMar + $jt->rpMar)); ?></td>
                                                <?php $totalMar += ($jt->rbMar + $jt->rpMar); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalMar += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbApr + $jt->rpApr) != NULL && ($jt->rbApr + $jt->rpApr) >= 0) { ?>
                                            <?php if ($gl->saldoApril + ($jt->rbApr + $jt->rpApr) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoApril + ($jt->rbApr + $jt->rpApr)); ?></td>
                                                <?php $totalApr += $gl->saldoApril + ($jt->rbApr + $jt->rpApr); ?>
                                            <?php } else if ($gl->saldoApril + ($jt->rbApr + $jt->rpApr) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoApril + ($jt->rbApr + $jt->rpApr)) . ')'; ?></td>
                                                <?php $totalApr += $gl->saldoApril + ($jt->rbApr + $jt->rpApr); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbApr + $jt->rpApr)) . ')'; ?></td>
                                                <?php $totalApr += ($jt->rbApr + $jt->rpApr); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbApr + $jt->rpApr) < 0 && ($jt->rbApr + $jt->rpApr) != NULL) { ?>
                                            <?php if ($gl->saldoApril + ($jt->rbApr + $jt->rpApr) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoApril + ($jt->rbApr + $jt->rpApr)); ?></td>
                                                <?php $totalApr += $gl->saldoApril + ($jt->rbApr + $jt->rpApr); ?>
                                            <?php } else if ($gl->saldoApril + ($jt->rbApr + $jt->rpApr) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoApril != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoApril + ($jt->rbApr + $jt->rpApr)) . ')'; ?></td>
                                                <?php $totalApr += $gl->saldoApril + ($jt->rbApr + $jt->rpApr); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbApr + $jt->rpApr)); ?></td>
                                                <?php $totalApr += ($jt->rbApr + $jt->rpApr); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalApr += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbMei + $jt->rpMei) != NULL && ($jt->rbMei + $jt->rpMei) >= 0) { ?>
                                            <?php if ($gl->saldoMei + ($jt->rbMei + $jt->rpMei) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoMei + ($jt->rbMei + $jt->rpMei)); ?></td>
                                                <?php $totalMei += $gl->saldoMei + ($jt->rbMei + $jt->rpMei); ?>
                                            <?php } else if ($gl->saldoMei + ($jt->rbMei + $jt->rpMei) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoMei + ($jt->rbMei + $jt->rpMei)) . ')'; ?></td>
                                                <?php $totalMei += $gl->saldoMei + ($jt->rbMei + $jt->rpMei); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbMei + $jt->rpMei)) . ')'; ?></td>
                                                <?php $totalMei += ($jt->rbMei + $jt->rpMei); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbMei + $jt->rpMei) < 0 && ($jt->rbMei + $jt->rpMei) != NULL) { ?>
                                            <?php if ($gl->saldoMei + ($jt->rbMei + $jt->rpMei) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoMei + ($jt->rbMei + $jt->rpMei)); ?></td>
                                                <?php $totalMei += $gl->saldoMei + ($jt->rbMei + $jt->rpMei); ?>
                                            <?php } else if ($gl->saldoMei + ($jt->rbMei + $jt->rpMei) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoMei != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoMei + ($jt->rbMei + $jt->rpMei)) . ')'; ?></td>
                                                <?php $totalMei += $gl->saldoMei + ($jt->rbMei + $jt->rpMei); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbMei + $jt->rpMei)); ?></td>
                                                <?php $totalMei += ($jt->rbMei + $jt->rpMei); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalMei += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbJun + $jt->rpJun) != NULL && ($jt->rbJun + $jt->rpJun) >= 0) { ?>
                                            <?php if ($gl->saldoJuni + ($jt->rbJun + $jt->rpJun) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoJuni + ($jt->rbJun + $jt->rpJun)); ?></td>
                                                <?php $totalJun += $gl->saldoJuni + ($jt->rbJun + $jt->rpJun); ?>
                                            <?php } else if ($gl->saldoJuni + ($jt->rbJun + $jt->rpJun) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuni + ($jt->rbJun + $jt->rpJun)) . ')'; ?></td>
                                                <?php $totalJun += $gl->saldoJuni + ($jt->rbJun + $jt->rpJun); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbJun + $jt->rpJun)) . ')'; ?></td>
                                                <?php $totalJun += ($jt->rbJun + $jt->rpJun); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbJun + $jt->rpJun) < 0 && ($jt->rbJun + $jt->rpJun) != NULL) { ?>
                                            <?php if ($gl->saldoJuni + ($jt->rbJun + $jt->rpJun) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoJuni + ($jt->rbJun + $jt->rpJun)); ?></td>
                                                <?php $totalJun += $gl->saldoJuni + ($jt->rbJun + $jt->rpJun); ?>
                                            <?php } else if ($gl->saldoJuni + ($jt->rbJun + $jt->rpJun) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuni != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuni + ($jt->rbJun + $jt->rpJun)) . ')'; ?></td>
                                                <?php $totalJun += $gl->saldoJuni + ($jt->rbJun + $jt->rpJun); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbJun + $jt->rpJun)); ?></td>
                                                <?php $totalJun += ($jt->rbJun + $jt->rpJun); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo saldo_money($gl->saldoJuni); ?></td>
                                            <?php $totalJun += $gl->saldoJuni; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbJul + $jt->rpJul) != NULL && ($jt->rbJul + $jt->rpJul) >= 0) { ?>
                                            <?php if ($gl->saldoJuli + ($jt->rbJul + $jt->rpJul) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoJuli + ($jt->rbJul + $jt->rpJul)); ?></td>
                                                <?php $totalJul += $gl->saldoJuli + ($jt->rbJul + $jt->rpJul); ?>
                                            <?php } else if ($gl->saldoJuli + ($jt->rbJul + $jt->rpJul) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuli + ($jt->rbJul + $jt->rpJul)) . ')'; ?></td>
                                                <?php $totalJul += $gl->saldoJuli + ($jt->rbJul + $jt->rpJul); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbJul + $jt->rpJul)) . ')'; ?></td>
                                                <?php $totalJul += ($jt->rbJul + $jt->rpJul); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbJul + $jt->rpJul) < 0 && ($jt->rbJul + $jt->rpJul) != NULL) { ?>
                                            <?php if ($gl->saldoJuli + ($jt->rbJul + $jt->rpJul) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoJuli + ($jt->rbJul + $jt->rpJul)); ?></td>
                                                <?php $totalJul += $gl->saldoJuli + ($jt->rbJul + $jt->rpJul); ?>
                                            <?php } else if ($gl->saldoJuli + ($jt->rbJul + $jt->rpJul) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoJuli != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoJuli + ($jt->rbJul + $jt->rpJul)) . ')'; ?></td>
                                                <?php $totalJul += $gl->saldoJuli + ($jt->rbJul + $jt->rpJul); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbJul + $jt->rpJul)); ?></td>
                                                <?php $totalJul += ($jt->rbJul + $jt->rpJul); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalJul += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbAug + $jt->rpAug) != NULL && ($jt->rbAug + $jt->rpAug) >= 0) { ?>
                                            <?php if ($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug)); ?></td>
                                                <?php $totalAug += $gl->saldoAgustus + ($jt->rbAug + $jt->rpAug); ?>
                                            <?php } else if ($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug)) . ')'; ?></td>
                                                <?php $totalAug += $gl->saldoAgustus + ($jt->rbAug + $jt->rpAug); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbAug + $jt->rpAug)) . ')'; ?></td>
                                                <?php $totalAug += ($jt->rbAug + $jt->rpAug); ?>
                                            <?php } ?></td>
                                        <?php } else if (($jt->rbAug + $jt->rpAug) < 0 && ($jt->rbAug + $jt->rpAug) != NULL) { ?>
                                            <?php if ($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug)); ?></td>
                                                <?php $totalAug += $gl->saldoAgustus + ($jt->rbAug + $jt->rpAug); ?>
                                            <?php } else if ($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoAgustus != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoAgustus + ($jt->rbAug + $jt->rpAug)) . ')'; ?></td>
                                                <?php $totalAug += $gl->saldoAgustus + ($jt->rbAug + $jt->rpAug); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"> <?php echo saldo_money(($jt->rbAug + $jt->rpAug)); ?></td>
                                                <?php $totalAug += ($jt->rbAug + $jt->rpAug); ?>
                                            <?php } ?></td>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalAug += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbSep + $jt->rpSep) != NULL && ($jt->rbSep + $jt->rpSep) >= 0) { ?>
                                            <?php if ($gl->saldoSeptember + ($jt->rbSep + $jt->rpSep) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoSeptember  + ($jt->rbSep + $jt->rpSep)); ?></td>
                                                <?php $totalSep += $gl->saldoSeptember  + ($jt->rbSep + $jt->rpSep); ?>
                                            <?php } else if ($gl->saldoSeptember + ($jt->rbSep + $jt->rpSep) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoSeptember + ($jt->rbSep + $jt->rpSep)) . ')'; ?></td>
                                                <?php $totalSep += $gl->saldoSeptember + ($jt->rbSep + $jt->rpSep); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbSep + $jt->rpSep)) . ')'; ?></td>
                                                <?php $totalSep += ($jt->rbSep + $jt->rpSep); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbSep + $jt->rpSep) < 0 && ($jt->rbSep + $jt->rpSep) != NULL) { ?>
                                            <?php if ($gl->saldoSeptember + ($jt->rbSep + $jt->rpSep) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoSeptember  + ($jt->rbSep + $jt->rpSep)); ?></td>
                                                <?php $totalSep += $gl->saldoSeptember  + ($jt->rbSep + $jt->rpSep); ?>
                                            <?php } else if ($gl->saldoSeptember + ($jt->rbSep + $jt->rpSep) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoSeptember != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoSeptember + ($jt->rbSep + $jt->rpSep)) . ')'; ?></td>
                                                <?php $totalSep += $gl->saldoSeptember + ($jt->rbSep + $jt->rpSep); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbSep + $jt->rpSep)); ?></td>
                                                <?php $totalSep += ($jt->rbSep + $jt->rpSep); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalSep += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbOct + $jt->rpOct) != NULL && ($jt->rbOct + $jt->rpOct) >= 0) { ?>
                                            <?php if ($gl->saldoOktober + ($jt->rbOct + $jt->rpOct) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoOktober  + ($jt->rbOct + $jt->rpOct)); ?></td>
                                                <?php $totalOct += $gl->saldoOktober  + ($jt->rbOct + $jt->rpOct); ?>
                                            <?php } else if ($gl->saldoOktober  + ($jt->rbOct + $jt->rpOct) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoOktober  + ($jt->rbOct + $jt->rpOct)) . ')'; ?></td>
                                                <?php $totalOct += $gl->saldoOktober  + ($jt->rbOct + $jt->rpOct); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbOct + $jt->rpOct)) . ')'; ?></td>
                                                <?php $totalOct += ($jt->rbOct + $jt->rpOct); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbOct + $jt->rpOct) < 0 && ($jt->rbOct + $jt->rpOct) != NULL) { ?>
                                            <?php if ($gl->saldoOktober + ($jt->rbOct + $jt->rpOct) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoOktober  + ($jt->rbOct + $jt->rpOct)); ?></td>
                                                <?php $totalOct += $gl->saldoOktober  + ($jt->rbOct + $jt->rpOct); ?>
                                            <?php } else if ($gl->saldoOktober  + ($jt->rbOct + $jt->rpOct) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoOktober != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoOktober  + ($jt->rbOct + $jt->rpOct)) . ')'; ?></td>
                                                <?php $totalOct += $gl->saldoOktober  + ($jt->rbOct + $jt->rpOct); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbOct + $jt->rpOct)); ?></td>
                                                <?php $totalOct += ($jt->rbOct + $jt->rpOct); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalOct += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbNov + $jt->rpNov) != NULL && ($jt->rbNov + $jt->rpNov) >= 0) { ?>
                                            <?php if ($gl->saldoNovember + ($jt->rbNov + $jt->rpNov) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoNovember + ($jt->rbNov + $jt->rpNov)); ?></td>
                                                <?php $totalNov += $gl->saldoNovember + ($jt->rbNov + $jt->rpNov); ?>
                                            <?php } else if ($gl->saldoNovember + ($jt->rbNov + $jt->rpNov) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoNovember + ($jt->rbNov + $jt->rpNov)) . ')'; ?></td>
                                                <?php $totalNov += $gl->saldoNovember + ($jt->rbNov + $jt->rpNov); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbNov + $jt->rpNov)) . ')'; ?></td>
                                                <?php $totalNov += ($jt->rbNov + $jt->rpNov); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbNov + $jt->rpNov) < 0 && ($jt->rbNov + $jt->rpNov) != NULL) { ?>
                                            <?php if ($gl->saldoNovember + ($jt->rbNov + $jt->rpNov) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoNovember + ($jt->rbNov + $jt->rpNov)); ?></td>
                                                <?php $totalNov += $gl->saldoNovember + ($jt->rbNov + $jt->rpNov); ?>
                                            <?php } else if ($gl->saldoNovember + ($jt->rbNov + $jt->rpNov) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoNovember != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoNovember + ($jt->rbNov + $jt->rpNov)) . ')'; ?></td>
                                                <?php $totalNov += $gl->saldoNovember + ($jt->rbNov + $jt->rpNov); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbNov + $jt->rpNov)); ?></td>
                                                <?php $totalNov += ($jt->rbNov + $jt->rpNov); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalNov += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->rbDes + $jt->rpDes) != NULL && ($jt->rbDes + $jt->rpDes) >= 0) { ?>
                                            <?php if ($gl->saldoDesember + ($jt->rbDes + $jt->rpDes) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoDesember + ($jt->rbDes + $jt->rpDes)); ?></td>
                                                <?php $totalDes += $gl->saldoDesember + ($jt->rbDes + $jt->rpDes); ?>
                                            <?php } else if ($gl->saldoDesember + ($jt->rbDes + $jt->rpDes) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoDesember + ($jt->rbDes + $jt->rpDes)) . ')'; ?></td>
                                                <?php $totalDes += $gl->saldoDesember + ($jt->rbDes + $jt->rpDes); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->rbDes + $jt->rpDes)) . ')'; ?></td>
                                                <?php $totalDes += ($jt->rbDes + $jt->rpDes); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->rbDes + $jt->rpDes) < 0 && ($jt->rbDes + $jt->rpDes) != NULL) { ?>
                                            <?php if ($gl->saldoDesember + ($jt->rbDes + $jt->rpDes) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldoDesember + ($jt->rbDes + $jt->rpDes)); ?></td>
                                                <?php $totalDes += $gl->saldoDesember + ($jt->rbDes + $jt->rpDes); ?>
                                            <?php } else if ($gl->saldoDesember + ($jt->rbDes + $jt->rpDes) > 0 && $coa->jurnal_tipe == 4 && $gl->saldoDesember != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldoDesember + ($jt->rbDes + $jt->rpDes)) . ')'; ?></td>
                                                <?php $totalDes += $gl->saldoDesember + ($jt->rbDes + $jt->rpDes); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->rbDes + $jt->rpDes)); ?></td>
                                                <?php $totalDes += ($jt->rbDes + $jt->rpDes); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalDes += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php if (($jt->retainedBeban + $jt->retainedPendapatan) != NULL && ($jt->retainedBeban + $jt->retainedPendapatan) >= 0) { ?>
                                            <?php if ($gl->saldo + ($jt->retainedBeban + $jt->retainedPendapatan) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan)); ?></td>
                                                <?php $total += $gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan); ?>
                                            <?php } else if ($gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan) > 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan)) . ')'; ?></td>
                                                <?php $total += $gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?= '(' . saldo_money(($jt->retainedBeban + $jt->retainedPendapatan)) . ')'; ?></td>
                                                <?php $total += ($jt->retainedBeban + $jt->retainedPendapatan); ?>
                                            <?php } ?>
                                        <?php } else if (($jt->retainedBeban + $jt->retainedPendapatan) < 0 && ($jt->retainedBeban + $jt->retainedPendapatan) != NULL) { ?>
                                            <?php if ($gl->saldo + ($jt->retainedBeban + $jt->retainedPendapatan) <= 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                                <td class="text-align-right"><?= saldo_money($gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan)); ?></td>
                                                <?php $total += $gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan); ?>
                                            <?php } else if ($gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan) > 0 && $coa->jurnal_tipe == 4 && $gl->saldo != NULL) { ?>
                                                <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan)) . ')'; ?></td>
                                                <?php $total += $gl->saldo  + ($jt->retainedBeban + $jt->retainedPendapatan); ?>
                                            <?php } else { ?>
                                                <td class="text-align-right"><?php echo saldo_money(($jt->retainedBeban + $jt->retainedPendapatan)); ?></td>
                                                <?php $total += ($jt->retainedBeban + $jt->retainedPendapatan); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $total += 0; ?>
                                        <?php } ?>

                                    </tr>
                                <?php } ?>
                            <?php endforeach ?>
                        <?php } ?>
                    <?php } ?>
                <?php endforeach ?>
                <tr>
                    <td colspan="30">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="100" class="border-bottom border-top-no-padding"><?= 'TOTAL ' . $jt->type_name ?></td>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalJan > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJan) . ')'; ?></td>
                    <?php } else if ($totalJan <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJan); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalFeb > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalFeb) . ')'; ?></td>
                    <?php } else if ($totalFeb <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalFeb); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalMar > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMar) . ')'; ?></td>
                    <?php } else if ($totalMar <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMar); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalApr > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalApr) . ')'; ?></td>
                    <?php } else if ($totalApr <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalApr); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalMei > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalMei) . ')'; ?></td>
                    <?php } else if ($totalMei <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalMei); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalJun > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJun) . ')'; ?></td>
                    <?php } else if ($totalJun <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJun); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalJul > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalJul) . ')'; ?></td>
                    <?php } else if ($totalJul <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalJul); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalAug > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAug) . ')'; ?></td>
                    <?php } else if ($totalAug <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalAug); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalSep > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalSep) . ')'; ?></td>
                    <?php } else if ($totalSep <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalSep); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalOct > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalOct) . ')'; ?></td>
                    <?php } else if ($totalOct <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalOct); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalNov > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalNov) . ')'; ?></td>
                    <?php } else if ($totalNov <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalNov); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($totalDes > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalDes) . ')'; ?></td>
                    <?php } else if ($totalDes <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalDes); ?></td>
                    <?php } ?>

                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if ($total > 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($total) . ')'; ?></td>
                    <?php } else if ($total <= 0) { ?>
                        <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($total); ?></td>
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

            <?php $x++;

            if ($x < count($dataJurnal)) {
                echo '<div class="page_break"></div>';
            } ?>
        <?php } ?>
    <?php endforeach; ?>
</body>

</html>