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
    <?php
    $x = 0;
    $total = 0;
    foreach ($dataGL as $gl) : ?>
        <p class="text-align-right"><?= 'Tgl : ' . date("d-m-Y"); ?></p>
        <p style="font-size: 16pt; text-align: center;"><strong>BUKU BESAR</strong></p>
        <p style="text-align: center"><?= 'Untuk Bulan : ' . date('F', strtotime($dateA)) . ' s/d ' . date('F Y', strtotime($dateB)); ?></p>
        KODE REKENING &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kode-rekening"><?= $gl->coa_id . "&nbsp;&nbsp;&nbsp;&nbsp;" .  $gl->coa_name; ?></span>
        <br>
        <br>
        <table>
            <tr>
                <td style="width: 11%; font-size: 9pt;" class="border-bottom"><strong>TANGGAL</strong></td>
                <td style="width: 12%; font-size: 9pt;" class="border-bottom"><strong>NO.BUKTI</strong></td>
                <td style="width: 30%; font-size: 9pt;" class="border-bottom"><strong>URAIAN</strong></td>
                <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>DEBET</strong></td>
                <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>KREDIT</strong></td>
                <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>SALDO</strong></td>
            </tr>

            <?php
            $saldoD = 0;
            $defisit = 0;
            $surplus = 0;
            foreach ($dataSaldo as $saldo) {
                if ($saldo->kode_soa == $gl->kode_soa && $saldo->kode_soa != 272) { ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>SALDO AWAL </td>
                        <td>0,00</td>
                        <td>0,00</td>
                        <?php if ($saldo->saldoAwal != null && $saldo->saldoAwal < 0) { ?>
                            <td> <?= '(' . saldo_money($saldo->saldoAwal) . ')';
                                    $saldoD += $saldo->saldoAwal; ?> </td>
                        <?php } else if ($saldo->saldoAwal != null && $saldo->saldoAwal >= 0) { ?>
                            <td><?= money($saldo->saldoAwal);
                                $saldoD += $saldo->saldoAwal; ?> </td>
                        <?php } else { ?>
                            <td>0,00</td>
                            <?php $saldoD = 0; ?>
                        <?php } ?>
                    </tr>
                <?php } else if ($saldo->kode_soa == $gl->kode_soa && $saldo->kode_soa == 272) { ?>
                    <?php foreach ($dataSaldoSur as $saldosur) { ?>
                        <?php foreach ($dataGLSur as $glSur) {
                            if ($saldosur->monthsur < $glSur->month && $saldosur->saldoAwal < 0) {
                                $surplus = $saldosur->saldoAwal;
                                if ($glSur->monthStart > $glSur->month) {
                                    $surplus += $glSur->surplus;
                                } else {
                                    $surplus = $saldosur->saldoAwal;
                                }
                            } else {
                                $surplus = 0;
                            } ?>
                        <?php } ?>
                        <?php foreach ($dataGLDef as $glDef) {
                            if ($saldosur->monthsur < $glDef->month && $saldosur->saldoAwal > 0) {
                                $defisit = $saldosur->saldoAwal;
                                if ($glDef->monthStart > $glDef->month) {
                                    $defisit += $glDef->defisit;
                                } else {
                                    $defisit = $saldosur->saldoAwal;
                                }
                            } else {
                                $defisit = 0;
                            } ?>

                        <?php } ?>
                    <?php } ?>

                    <tr>
                        <td></td>
                        <td></td>
                        <td>SALDO AWAL </td>
                        <td>0,00</td>
                        <td>0,00</td>
                        <?php if ($saldo->saldoAwal != null && ($defisit + $surplus) < 0) { ?>
                            <td> <?= '(' . saldo_money(($defisit + $surplus)) . ')';
                                    $saldoD += ($defisit + $surplus); ?> </td>
                        <?php } else if ($saldo->saldoAwal != null && ($defisit + $surplus) >= 0) { ?>
                            <td><?= money(($defisit + $surplus));
                                $saldoD += ($defisit + $surplus); ?> </td>
                        <?php } else { ?>
                            <td>0,00</td>
                            <?php $saldoD = 0; ?>
                        <?php } ?>
                    </tr>
                <?php } else {
                } ?>
            <?php } ?>
            <?php $totalD = 0;
            $totalC = 0; ?>

            <?php if ($gl->kode_soa != 272) { ?>
                <?php foreach ($dataGLCus as $glCus) {
                    if ($glCus->kode_soa == $gl->kode_soa) { ?>
                        <tr>
                            <td><?= $glCus->tanggal_transaksi ?></td>
                            <td><?= $glCus->bukti_transaksi ?></td>
                            <td><?= $glCus->keterangan ?></td>
                            <td><?= money($glCus->debit) ?></td>
                            <td><?= money($glCus->credit) ?></td>

                            <?php $saldoD = $saldoD + ($glCus->debit - $glCus->credit); ?>

                            <?php if ($glCus->saldoAwal == null && $saldoD < 0) { ?>
                                <td><?= '(' . saldo_money($saldoD) . ')'; ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else if ($glCus->saldoAwal == null && $saldoD >= 0) { ?>
                                <td><?= money($saldoD); ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else if ($glCus->saldoAwal != null && $saldoD < 0) { ?>
                                <td><?= '(' . saldo_money($saldoD) . ')' ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else if ($glCus->saldoAwal != null && $saldoD >= 0) { ?>
                                <td><?= money($saldoD); ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else {
                            } ?>
                        </tr>
                    <?php } else {
                    } ?>
                <?php } ?>
            <?php } else if ($gl->kode_soa == 272) { ?>
                <?php foreach ($dataGLCus as $glCus) {
                    if ($glCus->kode_soa == $gl->kode_soa) { ?>
                        <tr>
                            <td><?= $glCus->tanggal_transaksi ?></td>
                            <td><?= $glCus->bukti_transaksi ?></td>
                            <td><?= $glCus->keterangan ?></td>
                            <td><?= money($glCus->debit) ?></td>
                            <td><?= money($glCus->credit) ?></td>

                            <?php $saldoD = $saldoD + ($glCus->debit - $glCus->credit); ?>

                            <?php if ($glCus->saldoAwal == null && $saldoD < 0) { ?>
                                <td><?= '(' . saldo_money($saldoD) . ')'; ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else if ($glCus->saldoAwal == null && $saldoD >= 0) { ?>
                                <td><?= money($saldoD); ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else if ($glCus->saldoAwal != null && $saldoD < 0) { ?>
                                <td><?= '(' . saldo_money($saldoD) . ')' ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else if ($glCus->saldoAwal != null && $saldoD >= 0) { ?>
                                <td><?= money($saldoD); ?></td>
                                <?php $total += ($glCus->debit - $glCus->credit);
                                $totalD += $glCus->debit;
                                $totalC += $glCus->credit; ?>
                            <?php } else {
                            } ?>
                        </tr>
                    <?php } else {
                    } ?>
                <?php } ?>
                <?php foreach ($dataGLSur as $glSur) : ?>
                    <?php foreach ($dataGLDef as $glDef) : ?>
                        <?php if ($glSur->month >= $glSur->monthStart && $glSur->month <= $glSur->monthEnd) { ?>
                            <?php if ($glSur->month == $glDef->month) { ?>
                                <tr>
                                    <td><?= $glSur->last_day; ?></td>
                                    <td></td>
                                    <td><?= 'Surplus/Defisit Month ' . date('F', strtotime($glSur->last_day)); ?></td>

                                    <?php if (($glDef->defisit + $glSur->surplus) < 0) { ?>
                                        <td>0,00</td>
                                        <td><?= saldo_money($glDef->defisit + $glSur->surplus) ?></td>

                                        <?php $saldoD = $saldoD + ($glDef->defisit + $glSur->surplus); ?>

                                        <?php if ($saldoD < 0) { ?>
                                            <td><?= '(' . saldo_money($saldoD) . ')'; ?></td>
                                            <?php $total += ($glDef->defisit + $glSur->surplus);
                                            $totalC += ($glDef->defisit + $glSur->surplus); ?>
                                        <?php } else if ($saldoD >= 0) { ?>
                                            <td><?= money($saldoD); ?></td>
                                            <?php $total += ($glDef->defisit + $glSur->surplus);
                                            $totalC += ($glDef->defisit + $glSur->surplus); ?>
                                        <?php } else { ?>
                                            <td>0,00</td>
                                        <?php } ?>

                                    <?php } else if (($glDef->defisit + $glSur->surplus) >= 0) { ?>
                                        <td><?= saldo_money($glDef->defisit + $glSur->surplus) ?></td>
                                        <td>0,00</td>

                                        <?php $saldoD = $saldoD + ($glDef->defisit + $glSur->surplus); ?>

                                        <?php if ($saldoD < 0) { ?>
                                            <td><?= '(' . saldo_money($saldoD) . ')'; ?></td>
                                            <?php $total += ($glDef->defisit + $glSur->surplusn);
                                            $totalD += ($glDef->defisit + $glSur->surplus); ?>
                                        <?php } else if ($saldoD >= 0) { ?>
                                            <td><?= money($saldoD); ?></td>
                                            <?php $total += ($glDef->defisit + $glSur->surplus);
                                            $totalD += ($glDef->defisit + $glSur->surplus); ?>
                                        <?php } else { ?>
                                            <td>0,00</td>
                                        <?php } ?>

                                    <?php } else {
                                    } ?>
                                </tr>
                            <?php } else {
                            } ?>
                        <?php } else {
                        } ?>
                    <?php endforeach ?>
                <?php endforeach; ?>
            <?php } else {
            } ?>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>

            <?php if ($gl->kode_soa != 272) { ?>
                <tr>
                    <td class="border-top border-bottom">TOTAL :</td>
                    <td class="border-top border-bottom"></td>
                    <td class="border-top border-bottom"></td>

                    <?php if ($totalD < 0) { ?>
                        <td class="border-top border-bottom"> <?= '(' . saldo_money($totalD) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="border-top border-bottom"> <?= saldo_money($totalD) ?> </td>
                    <?php } ?>

                    <?php if ($totalC < 0) { ?>
                        <td class="border-top border-bottom"> <?= '(' . saldo_money($totalC) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="border-top border-bottom"> <?= saldo_money($totalC) ?> </td>
                    <?php } ?>

                    <?php if ($saldoD < 0) { ?>
                        <td class="border-top border-bottom"> <?= '(' . saldo_money($saldoD) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="border-top border-bottom"> <?= saldo_money($saldoD) ?> </td>
                    <?php } ?>

                </tr>
            <?php } else if ($gl->kode_soa == 272) { ?>
                <tr>
                    <td class="border-top border-bottom">TOTAL :</td>
                    <td class="border-top border-bottom"></td>
                    <td class="border-top border-bottom"></td>

                    <?php if ($totalD < 0) { ?>
                        <td class="border-top border-bottom"> <?= '(' . saldo_money($totalD) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="border-top border-bottom"> <?= saldo_money($totalD) ?> </td>
                    <?php } ?>

                    <?php if ($totalC > 0) { ?>
                        <td class="border-top border-bottom"> <?= '(' . saldo_money($totalC) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="border-top border-bottom"> <?= saldo_money($totalC) ?> </td>
                    <?php } ?>

                    <?php if ($saldoD < 0) { ?>
                        <td class="border-top border-bottom"> <?= '(' . saldo_money($saldoD) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="border-top border-bottom"> <?= saldo_money($saldoD) ?> </td>
                    <?php } ?>

                </tr>
            <?php } else {
            } ?>


        </table>

        <?php $x++;

        if ($x < count($dataGL)) {
            echo '<div class="page_break"></div>';
        } ?>
    <?php endforeach; ?>
</body>

</html>