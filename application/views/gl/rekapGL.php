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
    <p class="text-align-right"><?= 'Tgl : ' . date("d-m-Y"); ?></p>
    <p style="font-size: 16pt; text-align: center;"><strong>BUKU BESAR</strong></p>
    <p style="text-align: center"><?= 'Untuk Bulan : ' . date('F', strtotime($date)); ?></p>
    <br>
    <br>

    <table>
        <tr>
            <td style="width: 5%; font-size: 9pt;" class="border-bottom padding"></td>
            <td style="width: 20%; font-size: 9pt;" class="border-bottom padding"></td>
            <td style="width: 30%; font-size: 9pt;" class="border-bottom padding"></td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding">SALDO AWAL</td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding"></td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding">MUTASI</td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding"></td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding">RUGI LABA</td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding"></td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding">NERACA</td>
            <td style="width: 15%; font-size: 9pt;" class="border-bottom padding"></td>
        </tr>
        <tr>
            <td style="font-size: 9pt;" class="border-bottom padding">NO</td>
            <td style="font-size: 9pt;" class="border-bottom padding">KODE REKENING</td>
            <td style="font-size: 9pt;" class="border-bottom padding">NAMA REKENING</td>
            <td style="font-size: 9pt;" class="border-bottom padding">DEBET</td>
            <td style="font-size: 9pt;" class="border-bottom padding">KREDIT</td>
            <td style="font-size: 9pt;" class="border-bottom padding">DEBET</td>
            <td style="font-size: 9pt;" class="border-bottom padding">KREDIT</td>
            <td style="font-size: 9pt;" class="border-bottom padding">DEBET</td>
            <td style="font-size: 9pt;" class="border-bottom padding">KREDIT</td>
            <td style="font-size: 9pt;" class="border-bottom padding">DEBET</td>
            <td style="font-size: 9pt;" class="border-bottom padding">KREDIT</td>
        </tr>
    </table>

    <?php
    $x = 1;
    $totalSD = 0;
    $totalSC = 0;
    $totalMD = 0;
    $totalMC = 0;
    $totalRD = 0;
    $totalRC = 0;
    $totalND = 0;
    $totalNC = 0;
    $totalRLD = 0;
    $totalRLC = 0;
    foreach ($dataGL as $gl) :
        if ($gl->jurnal_tipe == 1) { ?>
            <table>
                <tr>
                    <td style="width: 5%; font-size: 9pt;"><?= $x; ?></td>
                    <td style="width: 20%; font-size: 9pt;"><?= $gl->coa_id; ?></td>
                    <td style="width: 30%; font-size: 9pt;"><?= $gl->coa_name; ?></td>
                    <?php if (($gl->debitAwal - $gl->creditAwal) > 0) { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debitAwal - $gl->creditAwal);
                                                                $totalSD += ($gl->debitAwal - $gl->creditAwal); ?></td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } else if (($gl->debitAwal - $gl->creditAwal) < 0) { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money($gl->debitAwal - $gl->creditAwal) . ')';
                                                                $totalSD += ($gl->debitAwal - $gl->creditAwal); ?></td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } else { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } ?>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debit);
                                                            $totalMD += $gl->debit; ?></td>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->credit);
                                                            $totalMC += $gl->credit; ?></td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) > 0) { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit));
                                                                $totalND += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit); ?></td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } else if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) < 0) { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money(($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit)) . ')';
                                                                $totalND += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit); ?></td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } else { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } ?>
                </tr>
            </table>
        <?php } else if ($gl->jurnal_tipe == 4 && $gl->kode_soa != 272) { ?>
            <table>
                <tr>
                    <td style="width: 5%; font-size: 9pt;"><?= $x; ?></td>
                    <td style="width: 20%; font-size: 9pt;"><?= $gl->coa_id; ?></td>
                    <td style="width: 30%; font-size: 9pt;"><?= $gl->coa_name; ?></td>
                    <?php if (($gl->debitAwal - $gl->creditAwal) > 0) { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money($gl->debitAwal - $gl->creditAwal) . ')';
                                                                $totalSC += ($gl->debitAwal - $gl->creditAwal); ?></td>
                    <?php } else if (($gl->debitAwal - $gl->creditAwal) < 0) { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debitAwal - $gl->creditAwal);
                                                                $totalSC += ($gl->debitAwal - $gl->creditAwal); ?></td>
                    <?php } else { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } ?>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debit);
                                                            $totalMD += $gl->debit; ?></td>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->credit);
                                                            $totalMC += $gl->credit; ?></td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) > 0) { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money(($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit)) . ')';
                                                                $totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit); ?> </td>
                    <?php } else if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) < 0) { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit));
                                                                $totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit); ?> </td>
                    <?php } else { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } ?>
                </tr>
            </table>
        <?php } else if ($gl->jurnal_tipe == 4 && $gl->kode_soa == 272) { ?>
            <table>
                <tr>
                    <td style="width: 5%; font-size: 9pt;"><?= $x; ?></td>
                    <td style="width: 20%; font-size: 9pt;"><?= $gl->coa_id; ?></td>
                    <td style="width: 30%; font-size: 9pt;"><?= $gl->coa_name; ?></td>

                    <?php if (($gl->retainedBebanLast + $gl->retainedPendapatanLast) >= 0) { ?>
                        <?php if (($gl->debitAwal) - ($gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) > 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money($gl->debitAwal - $gl->creditAwal) + ($gl->retainedBebanLast + $gl->retainedPendapatanLast) . ')';
                                                                    $totalSC += ($gl->debitAwal - $gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast));
                                                                    $totalRLD += ($gl->debitAwal - $gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)); ?></td>
                        <?php } else if (($gl->debitAwal) - ($gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) < 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debitAwal - $gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast));
                                                                    $totalSC += ($gl->debitAwal - $gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast));
                                                                    $totalRLC += ($gl->debitAwal - $gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)); ?></td>
                        <?php } else { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <?php } ?>
                    <?php } else if (($gl->retainedBebanLast + $gl->retainedPendapatanLast) < 0) { ?>
                        <?php if (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal) > 0) { ?>
                            <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal));
                                                                    $totalSD += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal));
                                                                    $totalRLD += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal)); ?></td>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <?php } else if (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal) < 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - $gl->creditAwal);
                                                                    $totalSC += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - $gl->creditAwal);
                                                                    $totalRLC += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - $gl->creditAwal); ?></td>
                        <?php } else { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <?php } ?>
                    <?php } ?>

                    <?php if (($gl->retainedBeban + $gl->retainedPendapatan) > 0) { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->retainedBeban + $gl->retainedPendapatan);
                                                                // $totalMD += ($gl->retainedBeban + $gl->retainedPendapatan); 
                                                                ?></td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } else if (($gl->retainedBeban + $gl->retainedPendapatan) < 0) { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->retainedBeban + $gl->retainedPendapatan));
                                                                // $totalMC += ($gl->retainedBeban + $gl->retainedPendapatan); 
                                                                ?></td>
                    <?php } else { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debit);
                                                                $totalMD += $gl->debit; ?></td>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->credit);
                                                                $totalMC += $gl->credit; ?></td>
                    <?php } ?>

                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>

                    <?php if (($gl->retainedBeban + $gl->retainedPendapatan) > 0) { ?>
                        <?php if (($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan)) > 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money(($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan))) . ')';
                                                                    $totalNC += (($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan))); ?> </td>
                        <?php } else if (($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan)) < 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($totalRLD) - ($totalRLC + ($gl->retainedBeban + $gl->retainedPendapatan)));
                                                                    $totalNC += (($totalRLD) - ($totalRLC + ($gl->retainedBeban + $gl->retainedPendapatan)) * -1); ?> </td>
                        <?php } else { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <?php } ?>
                    <?php } else if (($gl->retainedBeban + $gl->retainedPendapatan) < 0) { ?>
                        <?php if (($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1) > 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money(($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1)) . ')';
                                                                    $totalNC += ($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1); ?> </td>
                        <?php } else if (($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1) < 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1));
                                                                    $totalNC += (($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC) * -1); ?> </td>
                        <?php } else { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) > 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money(($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit)) . ')';
                                                                    $totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit); ?> </td>
                        <?php } else if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) < 0) { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit));
                                                                    $totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit); ?> </td>
                        <?php } else { ?>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                            <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </table>
        <?php } else if ($gl->jurnal_tipe == 2) { ?>
            <table>
                <tr>
                    <td style="width: 5%; font-size: 9pt;"><?= $x; ?></td>
                    <td style="width: 20%; font-size: 9pt;"><?= $gl->coa_id; ?></td>
                    <td style="width: 30%; font-size: 9pt;"><?= $gl->coa_name; ?></td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debit);
                                                            $totalMD += $gl->debit; ?></td>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->credit);
                                                            $totalMC += $gl->credit; ?></td>
                    <?php if (($gl->debit - $gl->credit) > 0) { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->debit - $gl->credit));
                                                                $totalRD += ($gl->debit - $gl->credit); ?></td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } else if (($gl->debit - $gl->credit) < 0) { ?>
                        <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money(($gl->debit - $gl->credit)) . ')';
                                                                $totalRD += ($gl->debit - $gl->credit); ?> </td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } else { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } ?>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                </tr>
            </table>
        <?php } else if ($gl->jurnal_tipe == 3) { ?>
            <table>
                <tr>
                    <td style="width: 5%; font-size: 9pt;"><?= $x; ?></td>
                    <td style="width: 20%; font-size: 9pt;"><?= $gl->coa_id; ?></td>
                    <td style="width: 30%; font-size: 9pt;"><?= $gl->coa_name; ?></td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->debit);
                                                            $totalMD += $gl->debit; ?></td>
                    <td style="width: 15%; font-size: 9pt;"><?= saldo_money($gl->credit);
                                                            $totalMC += $gl->credit; ?></td>
                    <?php if (($gl->debit - $gl->credit) > 0) { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;"><?= '(' . saldo_money(($gl->debit - $gl->credit)) . ')';
                                                                $totalRC += ($gl->debit - $gl->credit); ?></td>
                    <?php } else if (($gl->debit - $gl->credit) < 0) { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;"><?= saldo_money(($gl->debit - $gl->credit));
                                                                $totalRC += ($gl->debit - $gl->credit); ?> </td>
                    <?php } else { ?>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                        <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <?php } ?>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                    <td style="width: 15%; font-size: 9pt;">0,00</td>
                </tr>
            </table>
        <?php } ?>
    <?php
        $x++;
    endforeach; ?>

    <table>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%; font-size: 9pt;" class="border-top padding"></td>
            <td style="width: 20%; font-size: 9pt;" class="border-top padding"></td>
            <td style="width: 30%; font-size: 9pt;" class="border-top padding">Saldo Rugi Laba</td>
            <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
            <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
            <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
            <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
            <?php if (($totalRC * -1) > $totalRD) { ?>
                <td style="width: 15%; font-size: 9pt;" class="border-top padding"><?= saldo_money(($totalRC * -1) - $totalRD) ?></td>
                <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
            <?php } else { ?>
                <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
                <td style="width: 15%; font-size: 9pt;" class="border-top padding"><?= saldo_money($totalRD - ($totalRC * -1)) ?></td>
            <?php } ?>
            <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
            <td style="width: 15%; font-size: 9pt;" class="border-top padding">0,00</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>TOTAL : </td>
            <td><?= saldo_money($totalSD) ?></td>
            <td><?= saldo_money($totalSC) ?></td>
            <td><?= saldo_money($totalMD) ?></td>
            <td><?= saldo_money($totalMC) ?></td>
            <?php if (($totalRC * -1) > $totalRD) { ?>
                <td><?= saldo_money($totalRD + (($totalRC * -1) - $totalRD)) ?></td>
                <td><?= saldo_money($totalRC)  ?></td>
            <?php } else { ?>
                <td><?= saldo_money($totalRD) ?></td>
                <td><?= saldo_money($totalRC + ($totalRD - ($totalRC)))  ?></td>
            <?php } ?>
            <td><?= saldo_money($totalND) ?></td>
            <td><?= saldo_money($totalNC) ?></td>
        </tr>

    </table>
</body>

</html>