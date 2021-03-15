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
            <td style="font-size: 13pt; text-align: center;"><span><strong>Surplus/Defisit Detail</strong></span></td>
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
            <td><span>keterangan</span></td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
    </table>
    <?php
    $x = 0;
    $totalNeracaC = 0;
    $totalNeracaL = 0;
    $totalNeracaV = 0;
    ?>
    <?php foreach ($dataJurnal as $jt) : ?>
        <table>
            <tr>
                <td>
                    <p style="font-size: 12pt;"><b><?= $jt->type_name; ?></b></p>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 40%; font-size: 9pt;" class="border-bottom-no-padding"><strong><?= $jt->type_name; ?></strong></td>
                <td style="width: 5%; font-size: 9pt;" class="text-align-right"></td>
                <td style="width: 17%; font-size: 9pt;" class="text-align-right"><strong>Current Month</strong></td>
                <td style="width: 2%; font-size: 9pt;" class="text-align-right"></td>
                <td style="width: 17%; font-size: 9pt;" class="text-align-right"><strong>Last Month</strong></td>
                <td style="width: 2%; font-size: 9pt;" class="text-align-right"></td>
                <td style="width: 17%; font-size: 9pt;" class="text-align-right"><strong>Varian</strong></td>
            </tr>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
            <?php
            $totalACP = 0;
            $totalALP = 0;
            $totalAVP = 0;
            ?>
            <?php foreach ($dataCoA as $coa) : ?>
                <?php if ($jt->jurnal_tipe == $coa->jurnal_tipe) { ?>
                    <tr>
                        <td class="border-bottom-no-padding"><strong><?= $coa->parent_name; ?></strong></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <?php
                    $totalCP = 0;
                    $totalLP = 0;
                    $totalVP = 0;
                    ?>
                    <?php foreach ($dataGL as $gl) : ?>
                        <?php if ($gl->month != 1) { ?>
                            <?php if ($gl->parent == $coa->parent) { ?>
                                <?php if ($gl->saldo == NULL && $gl->saldoLast == NULL) { ?>
                                <?php } else { ?>
                                    <tr>
                                        <td><?= $gl->coa_name; ?></td>

                                        <td class="text-align-right"></td>
                                        <?php if ($gl->saldo < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?php echo saldo_money($gl->saldo); ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo <= 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalCP += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right"></td>
                                        <?php if ($gl->saldoLast != null && $gl->saldoLast < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldoLast) . ')'; ?></td>
                                            <?php $totalLP += $gl->saldoLast; ?>
                                        <?php } else if ($gl->saldoLast != null && $gl->saldoLast >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoLast); ?></td>
                                            <?php $totalLP += $gl->saldoLast; ?>
                                        <?php } else if ($gl->saldoLast != null && $gl->saldoLast > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldoLast) . ')'; ?></td>
                                            <?php $totalLP += $gl->saldoLast; ?>
                                        <?php } else if ($gl->saldoLast != null && $gl->saldoLast <= 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"> <?= saldo_money($gl->saldoLast); ?></td>
                                            <?php $totalLP += $gl->saldoLast; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalLP += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right"></td>
                                        <?php if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo - $gl->saldoLast) . ')'; ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast); ?>
                                        <?php } else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo - $gl->saldoLast); ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast); ?>
                                        <?php } else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo - $gl->saldoLast) . ')'; ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast); ?>
                                        <?php } else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) <= 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo - $gl->saldoLast); ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast); ?>
                                        <?php } else if ($gl->saldoLast == null && $gl->saldo < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldoLast == null && $gl->saldo >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldoLast == null && $gl->saldo < 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldoLast == null && $gl->saldo > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalVP += 0; ?>
                                        <?php } ?>

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } else if ($gl->month == 1) { ?>
                            <?php if ($gl->parent == $coa->parent) { ?>
                                <?php if ($gl->saldo == NULL && $gl->saldoLast12 == NULL) { ?>
                                <?php } else { ?>
                                    <tr>
                                        <td><?= $gl->coa_name; ?></td>

                                        <td class="text-align-right"></td>
                                        <?php if ($gl->saldo != null && $gl->saldo < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo != null && $gl->saldo >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?php echo saldo_money($gl->saldo); ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo != null && $gl->saldo <= 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo != null && $gl->saldo > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?php echo '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalCP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldo == null) { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalCP += 0; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalCP += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right"></td>
                                        <?php if ($gl->saldoLast12 != null && $gl->saldoLast12 < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldoLast12) . ')'; ?></td>
                                            <?php $totalLP += $gl->saldoLast12; ?>
                                        <?php } else if ($gl->saldoLast12 != null && $gl->saldoLast12 >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldoLast12); ?></td>
                                            <?php $totalLP += $gl->saldoLast12; ?>
                                        <?php } else if ($gl->saldoLast12 != null && $gl->saldoLast12 > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldoLast12) . ')'; ?></td>
                                            <?php $totalLP += $gl->saldoLast12; ?>
                                        <?php } else if ($gl->saldoLast12 != null && $gl->saldoLast12 <= 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"> <?= saldo_money($gl->saldoLast12); ?></td>
                                            <?php $totalLP += $gl->saldoLast12; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalLP += 0; ?>
                                        <?php } ?>

                                        <td class="text-align-right"></td>
                                        <?php if ($gl->saldoLast12 != null && ($gl->saldo - $gl->saldoLast12) < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo - $gl->saldoLast12) . ')'; ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast12); ?>
                                        <?php } else if ($gl->saldoLast12 != null && ($gl->saldo - $gl->saldoLast12) >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo - $gl->saldoLast12); ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast12); ?>
                                        <?php } else if ($gl->saldoLast12 != null && ($gl->saldo - $gl->saldoLast12) > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo - $gl->saldoLast12) . ')'; ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast12); ?>
                                        <?php } else if ($gl->saldoLast12 != null && ($gl->saldo - $gl->saldoLast12) <= 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo - $gl->saldoLast12); ?></td>
                                            <?php $totalVP += ($gl->saldo - $gl->saldoLast12); ?>
                                        <?php } else if ($gl->saldoLast12 == null && $gl->saldo < 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldoLast12 == null && $gl->saldo >= 0 && $coa->jurnal_tipe == 2) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldoLast12 == null && $gl->saldo < 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= saldo_money($gl->saldo); ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else if ($gl->saldoLast12 == null && $gl->saldo > 0 && $coa->jurnal_tipe == 3) { ?>
                                            <td class="text-align-right"><?= '(' . saldo_money($gl->saldo) . ')'; ?></td>
                                            <?php $totalVP += $gl->saldo; ?>
                                        <?php } else { ?>
                                            <td class="text-align-right"><?php echo '0,00'; ?></td>
                                            <?php $totalVP += 0; ?>
                                        <?php } ?>

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                    <?php endforeach ?>
                    <tr>
                        <td><?= 'TOTAL ' . $coa->parent_name ?></td>
                        <td class="text-align-right"></td>
                        <?php if ($totalCP < 0 && $coa->jurnal_tipe == 2) { ?>
                            <td class="text-align-right border-top-no-padding"><?= '(' . saldo_money($totalCP) . ')'; ?></td>
                            <?php $totalACP += $totalCP; ?>
                        <?php } else if ($totalCP >= 0 && $coa->jurnal_tipe == 2) { ?>
                            <td class="text-align-right border-top-no-padding"><?= saldo_money($totalCP); ?></td>
                            <?php $totalACP += $totalCP; ?>
                        <?php } else if ($totalCP >= 0 && $coa->jurnal_tipe == 3) { ?>
                            <td class="text-align-right border-top-no-padding"> <?= '(' . saldo_money($totalCP) . ')'; ?></td>
                            <?php $totalACP += $totalCP; ?>
                        <?php } else { ?>
                            <td class="text-align-right border-top-no-padding"><?= saldo_money($totalCP); ?></td>
                            <?php $totalACP += $totalCP; ?>
                        <?php } ?>

                        <td class="text-align-right"></td>
                        <?php if ($totalLP < 0 && $coa->jurnal_tipe == 2) { ?>
                            <td class="text-align-right border-top-no-padding"><?= '(' . saldo_money($totalLP) . ')'; ?></td>
                            <?php $totalALP += $totalLP; ?>
                        <?php } else if ($totalLP >= 0 && $coa->jurnal_tipe == 2) { ?>
                            <td class="text-align-right border-top-no-padding"><?= saldo_money($totalLP); ?></td>
                            <?php $totalALP += $totalLP; ?>
                        <?php } else if ($totalLP >= 0 && $coa->jurnal_tipe == 3) { ?>
                            <td class="text-align-right border-top-no-padding"><?= '(' . saldo_money($totalLP) . ')'; ?></td>
                            <?php $totalALP += $totalLP; ?>
                        <?php } else { ?>
                            <td class="text-align-right border-top-no-padding"><?= saldo_money($totalLP); ?></td>
                            <?php $totalALP += $totalLP; ?>
                        <?php } ?>

                        <td class="text-align-right"></td>
                        <?php if ($totalVP < 0 && $coa->jurnal_tipe == 2) { ?>
                            <td class="text-align-right border-top-no-padding"><?= '(' . saldo_money($totalVP) . ')'; ?></td>
                            <?php $totalAVP += $totalVP; ?>
                        <?php } else if ($totalVP >= 0 && $coa->jurnal_tipe == 2) { ?>
                            <td class="text-align-right border-top-no-padding"><?= saldo_money($totalVP); ?></td>
                            <?php $totalAVP += $totalVP; ?>
                        <?php } else if ($totalVP >= 0 && $coa->jurnal_tipe == 3) { ?>
                            <td class="text-align-right border-top-no-padding"><?= '(' . saldo_money($totalVP) . ')'; ?></td>
                            <?php $totalAVP += $totalVP; ?>
                        <?php } else { ?>
                            <td class="text-align-right border-top-no-padding"><?= saldo_money($totalVP); ?></td>
                            <?php $totalAVP += $totalVP; ?>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                <?php } ?>
            <?php endforeach ?>
            <tr>
                <td class="border-bottom border-top-no-padding"><?= 'TOTAL ' . $jt->type_name ?></td>
                <td class="text-align-right"></td>
                <?php if ($totalACP < 0 && $jt->jurnal_tipe == 2) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalACP) . ')'; ?></td>
                    <?php $totalNeracaC += $totalACP; ?>
                <?php } else if ($totalACP >= 0 && $jt->jurnal_tipe == 2) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalACP); ?></td>
                    <?php $totalNeracaC += $totalACP; ?>
                <?php } else if ($totalACP >= 0 && $jt->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"> <?= '(' . saldo_money($totalACP) . ')'; ?></td>
                    <?php $totalNeracaC += $totalACP; ?>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalACP); ?></td>
                    <?php $totalNeracaC += $totalACP; ?>
                <?php } ?>

                <td class="text-align-right"></td>
                <?php if ($totalALP < 0 && $jt->jurnal_tipe == 2) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalALP) . ')'; ?></td>
                    <?php $totalNeracaL += $totalALP; ?>
                <?php } else if ($totalALP >= 0 && $jt->jurnal_tipe == 2) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"> <?= saldo_money($totalALP); ?></td>
                    <?php $totalNeracaL += $totalALP; ?>
                <?php } else if ($totalALP >= 0 && $jt->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalALP) . ')'; ?></td>
                    <?php $totalNeracaL += $totalALP; ?>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalALP); ?></td>
                    <?php $totalNeracaL += $totalALP; ?>
                <?php } ?>

                <td class="text-align-right"></td>
                <?php if ($totalAVP < 0 && $jt->jurnal_tipe == 2) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAVP) . ')'; ?></td>
                    <?php $totalNeracaV += $totalAVP; ?>
                <?php } else if ($totalAVP >= 0 && $jt->jurnal_tipe == 2) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalAVP); ?></td>
                    <?php $totalNeracaV += $totalAVP; ?>
                <?php } else if ($totalAVP >= 0 && $jt->jurnal_tipe == 3) { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= '(' . saldo_money($totalAVP) . ')'; ?></td>
                    <?php $totalNeracaV += $totalAVP; ?>
                <?php } else { ?>
                    <td class="text-align-right border-top-no-padding border-bottom"><?= saldo_money($totalAVP); ?></td>
                    <?php $totalNeracaV += $totalAVP; ?>
                <?php } ?>
            </tr>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
        </table>

        <?php $x++; ?>

        <?php if ($x < count($dataJurnal)) { ?>
            <?php echo '<div class="page_break"></div>'; ?>
        <?php } ?>

    <?php endforeach; ?>
    <table>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 40%; font-size: 9pt;" class="border-top-no-padding">TOTAL Surplus/Defisit</td>
            <td style="width: 5%; font-size: 9pt;" class="text-align-right"></td>
            <?php if ($totalNeracaC > 0) { ?>
                <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= '(' . saldo_money($totalNeracaC) . ')'; ?></td>
            <?php } else { ?>
                <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= saldo_money($totalNeracaC); ?></td>
            <?php } ?>

            <td style="width: 2%; font-size: 9pt;" class="text-align-right"></td>
            <?php if ($totalNeracaL > 0) { ?>
                <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= '(' . saldo_money($totalNeracaL) . ')'; ?></td>
            <?php } else { ?>
                <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= saldo_money($totalNeracaL); ?></td>
            <?php } ?>

            <td style="width: 2%; font-size: 9pt;" class="text-align-right"></td>
            <?php if ($totalNeracaC > 0 && $totalNeracaL > 0) { ?>
                <?php if (($totalNeracaC - $totalNeracaL) > 0) { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= '(' . saldo_money(($totalNeracaC - $totalNeracaL)) . ')'; ?></td>
                <?php } else { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= saldo_money(($totalNeracaC - $totalNeracaL)); ?></td>
                <?php } ?>
            <?php } else if ($totalNeracaC > 0 && $totalNeracaL < 0) { ?>
                <?php if (($totalNeracaC + $totalNeracaL) > 0) { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= '(' . saldo_money(($totalNeracaC + $totalNeracaL)) . ')'; ?></td>
                <?php } else { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= saldo_money(($totalNeracaC + $totalNeracaL)); ?></td>
                <?php } ?>
            <?php } else if ($totalNeracaC < 0 && $totalNeracaL > 0) { ?>
                <?php if (($totalNeracaC + $totalNeracaL) > 0) { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= '(' . saldo_money(($totalNeracaC + $totalNeracaL)) . ')'; ?></td>
                <?php } else { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= saldo_money(($totalNeracaC + $totalNeracaL)); ?></td>
                <?php } ?>
            <?php } else if ($totalNeracaC < 0 && $totalNeracaL < 0) { ?>
                <?php if (($totalNeracaC - $totalNeracaL) > 0) { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= '(' . saldo_money(($totalNeracaC - $totalNeracaL)) . ')'; ?></td>
                <?php } else { ?>
                    <td style="width: 17%; font-size: 9pt;" class="text-align-right border-top-no-padding"><?= saldo_money(($totalNeracaC - $totalNeracaL)); ?></td>
                <?php } ?>
            <?php } else { ?>
            <?php } ?>

        </tr>
    </table>
</body>

</html>