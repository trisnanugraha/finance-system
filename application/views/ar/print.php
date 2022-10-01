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
    <p style="font-size: 13pt; text-align: center;"><strong>KARTU PIUTANG</strong></p>
    <p class="text-align-right;"><?= 'Tgl : ' . date("d-m-Y"); ?></p>
    Bulan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="periode-range"><?= date('F', strtotime($dataDateA)) . "&nbsp;-&nbsp;" .  date('F Y', strtotime($dataDateB)); ?></span>
    <br>
    Tgl Pembukuan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="year-pembukuan"><?= '' . date('d/m/Y', strtotime($dataDateB)); ?></span>
    <br>
    SORT PER KODE CUSTOMER
    <br>
    Range Kode Customer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="customer-range"><?= $dataCusA->unit . "&nbsp;-&nbsp;" .  $dataCusB->unit; ?></span>
    <br>
    <br>

    <?php
    $total = 0;
    $totalD = 0;
    $totalC = 0;
    foreach ($dataAR as $ar) :
        if ($ar->kode_soa == 22) { ?>
            <table>
                <tr>
                    <td>Kode CUST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="owner-id"><?= $ar->id_owner . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $ar->nama_owner; ?></span></td>
                </tr>
                <tr>
                    <td>Valuta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>IDR</span></td>
                </tr>
                <tr>
                    <td>Uang Muka &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>0,00</span></td>
                </tr>
                <tr>
                    <td>Giro Mundur &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>0,00</span></td>
                </tr>
            </table>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>TANGGAL</strong></td>
                    <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>NO.BUKTI</strong></td>
                    <td style="width: 34%; font-size: 9pt;" class="border-bottom"><strong>KETERANGAN</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>DEBET</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>KREDIT</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>SALDO</strong></td>
                </tr>
                <?php $saldoA = 0; ?>
                <?php foreach ($dataSaldo as $saldo) : ?>
                    <?php if ($saldo->id_owner == $ar->id_owner) { ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>SALDO AWAL</td>
                            <td class="text-align-right">-</td>
                            <td class="text-align-right">-</td>
                            <td class="text-align-right"><?= saldo_money($saldo->saldo); ?>
                                <?php $saldoA += $saldo->saldo; ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php endforeach ?>
                <?php $debit = 0;
                $credit = 0; ?>
                <?php foreach ($dataARCus as $arCus) : ?>
                    <?php if ($arCus->id_bayar != NULL && $arCus->id_owner == $ar->id_owner) { ?>
                        <tr>
                            <td><?= $arCus->arTgl ?></td>
                            <td><?= $arCus->arBT ?></td>
                            <td><?= $arCus->arKet ?></td>
                            <td class="text-align-right"><?= saldo_money($arCus->arTotal); ?>
                                <?php $debit += $arCus->arTotal; ?>
                            </td>
                            <td class="text-align-right"><?= '0,00' ?></td>
                            <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                        </tr>
                        <?php foreach ($dataBayarCus as $bayarCus) : ?>
                            <?php if ($bayarCus->id_ar == $arCus->id_ar) { ?>
                                <tr>
                                    <td><?= $bayarCus->pemTgl ?></td>
                                    <td><?= $arCus->pemBT ?></td>
                                    <td><?= $bayarCus->pemKet ?></td>
                                    <td class="text-align-right"><?= '0,00' ?></td>
                                    <td class="text-align-right"><?= saldo_money($bayarCus->pemTotal); ?>
                                        <?php $credit += $bayarCus->pemTotal; ?>
                                    </td>

                                    <?php if ($saldoA + $debit - $credit < 0) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($saldoA + $debit - $credit) . ')' ?></td>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php endforeach ?>
                    <?php } else if ($arCus->id_bayar != NULL && $arCus->id_owner != $ar->id_owner) { ?>
                    <?php } else if ($arCus->id_bayar == NULL && $arCus->id_owner == $ar->id_owner) { ?>
                        <tr>
                            <td><?= $arCus->arTgl ?></td>
                            <td><?= $arCus->arBT ?></td>
                            <td><?= $arCus->arKet ?></td>
                            <td class="text-align-right"><?= saldo_money($arCus->arTotal); ?>
                                <?php $debit += $arCus->arTotal; ?>
                            </td>
                            <td class="text-align-right"><?= '0,00'; ?>
                                <?php $credit += $arCus->pemTotal; ?>
                            </td>
                            <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                        </tr>
                    <?php } else if ($arCus->id_bayar != NULL && $arCus->id_owner != $ar->id_owner) { ?>
                    <?php } ?>
                <?php endforeach ?>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="border-top border-bottom">TOTAl PER CUSTOMER :</td>
                    <td class="text-align-right border-top border-bottom"><?= saldo_money($debit) ?></td>
                    <td class="text-align-right border-top border-bottom"><?= saldo_money($credit) ?></td>
                    <td class="text-align-right border-top border-bottom"><?php if ($saldoA + $debit - $credit < 0) { ?> <?= '(' . saldo_money($saldoA + $debit - $credit) . ')' ?> </td> <?php } else { ?> <?= saldo_money($saldoA + $debit - $credit) ?></td> <?php } ?>
                <?php $totalD += $debit;
                $totalC += $credit;
                $total += ($saldoA + $debit - $credit); ?>
                </tr>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
            </table>
        <?php
        } else if ($ar->kode_soa == 21) { ?>
            <table>
                <tr>
                    <td>Kode CUST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="owner-id"><?= $ar->id_customer . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $ar->nama_customer; ?></span></td>
                </tr>
                <tr>
                    <td>Valuta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>IDR</span></td>
                </tr>
                <tr>
                    <td>Uang Muka &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>0,00</span></td>
                </tr>
                <tr>
                    <td>Giro Mundur &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>0,00</span></td>
                </tr>
            </table>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>TANGGAL</strong></td>
                    <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>NO.BUKTI</strong></td>
                    <td style="width: 34%; font-size: 9pt;" class="border-bottom"><strong>KETERANGAN</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>DEBET</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>KREDIT</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>SALDO</strong></td>
                </tr>
                <?php $saldoA = 0; ?>
                <?php foreach ($dataSaldo as $saldo) : ?>
                    <?php if ($saldo->id_customer == $ar->id_customer) { ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>SALDO AWAL</td>
                            <td class="text-align-right">-</td>
                            <td class="text-align-right">-</td>
                            <td class="text-align-right"><?= saldo_money($saldo->saldo); ?>
                                <?php $saldoA += $saldo->saldo; ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php endforeach ?>
                <?php $debit = 0;
                $credit = 0; ?>
                <?php foreach ($dataARCus as $arCus) : ?>
                    <?php if ($arCus->id_bayar != NULL && $arCus->id_customer == $ar->id_customer) { ?>
                        <tr>
                            <td><?= $arCus->arTgl ?></td>
                            <td><?= $arCus->arBT ?></td>
                            <td><?= $arCus->arKet ?></td>
                            <td class="text-align-right"><?= saldo_money($arCus->arTotal); ?>
                                <?php $debit += $arCus->arTotal; ?>
                            </td>
                            <td class="text-align-right"><?= '0,00' ?></td>
                            <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                        </tr>
                        <?php foreach ($dataBayarCus as $bayarCus) : ?>
                            <?php if ($bayarCus->id_ar == $arCus->id_ar) { ?>
                                <tr>
                                    <td><?= $bayarCus->pemTgl ?></td>
                                    <td><?= $arCus->pemBT ?></td>
                                    <td><?= $bayarCus->pemKet ?></td>
                                    <td class="text-align-right"><?= '0,00' ?></td>
                                    <td class="text-align-right"><?= saldo_money($bayarCus->pemTotal); ?>
                                        <?php $credit += $bayarCus->pemTotal; ?>
                                    </td>

                                    <?php if ($saldoA + $debit - $credit < 0) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($saldoA + $debit - $credit) . ')' ?></td>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php endforeach ?>
                    <?php } else if ($arCus->id_bayar != NULL && $arCus->id_customer != $ar->id_customer) { ?>
                    <?php } else if ($arCus->id_bayar == NULL && $arCus->id_customer == $ar->id_customer) { ?>
                        <tr>
                            <td><?= $arCus->arTgl ?></td>
                            <td><?= $arCus->arBT ?></td>
                            <td><?= $arCus->arKet ?></td>
                            <td class="text-align-right"><?= saldo_money($arCus->arTotal); ?>
                                <?php $debit += $arCus->arTotal; ?>
                            </td>
                            <td class="text-align-right"><?= '0,00'; ?>
                                <?php $credit += $arCus->pemTotal; ?>
                            </td>
                            <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                        </tr>
                    <?php } else if ($arCus->id_bayar != NULL && $arCus->id_customer != $ar->id_customer) { ?>
                    <?php } ?>
                <?php endforeach ?>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="border-top border-bottom">TOTAl PER CUSTOMER :</td>
                    <td class="text-align-right border-top border-bottom"><?= saldo_money($debit) ?></td>
                    <td class="text-align-right border-top border-bottom"><?= saldo_money($credit) ?></td>

                    <?php if ($saldoA + $debit - $credit < 0) { ?>
                        <td class="text-align-right border-top border-bottom"><?= '(' . saldo_money($saldoA + $debit - $credit) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="text-align-right border-top border-bottom"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                    <?php } ?>

                    <?php $totalD += $debit;
                    $totalC += $credit;
                    $total += ($saldoA + $debit - $credit); ?>
                </tr>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
            </table>
        <?php } else if ($ar->kode_soa == 24) { ?>
            <table>
                <tr>
                    <td>Kode CUST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="owner-id"><?= $ar->id_customer . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $ar->nama_customer; ?></span></td>
                </tr>
                <tr>
                    <td>Valuta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>IDR</span></td>
                </tr>
                <tr>
                    <td>Uang Muka &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>0,00</span></td>
                </tr>
                <tr>
                    <td>Giro Mundur &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>0,00</span></td>
                </tr>
            </table>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>TANGGAL</strong></td>
                    <td style="width: 15%; font-size: 9pt;" class="border-bottom"><strong>NO.BUKTI</strong></td>
                    <td style="width: 34%; font-size: 9pt;" class="border-bottom"><strong>KETERANGAN</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>DEBET</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>KREDIT</strong></td>
                    <td style="width: 13%; font-size: 9pt;" class="text-align-right border-bottom"><strong>SALDO</strong></td>
                </tr>
                <?php $saldoA = 0; ?>
                <?php foreach ($dataSaldo as $saldo) : ?>
                    <?php if ($saldo->id_customer == $ar->id_customer) { ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>SALDO AWAL</td>
                            <td class="text-align-right">-</td>
                            <td class="text-align-right">-</td>
                            <td class="text-align-right"><?= saldo_money($saldo->saldo); ?>
                                <?php $saldoA += $saldo->saldo; ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php endforeach ?>
                <?php $debit = 0;
                $credit = 0; ?>
                <?php foreach ($dataARCus as $arCus) : ?>
                    <?php if ($arCus->id_bayar != NULL && $arCus->id_customer == $ar->id_customer) { ?>
                        <tr>
                            <td><?= $arCus->arTgl ?></td>
                            <td><?= $arCus->arBT ?></td>
                            <td><?= $arCus->arKet ?></td>
                            <td class="text-align-right"><?= saldo_money($arCus->arTotal); ?>
                                <?php $debit += $arCus->arTotal; ?>
                            </td>
                            <td class="text-align-right"><?= '0,00' ?></td>
                            <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                        </tr>
                        <?php foreach ($dataBayarCus as $bayarCus) : ?>
                            <?php if ($bayarCus->id_ar == $arCus->id_ar) { ?>
                                <tr>
                                    <td><?= $bayarCus->pemTgl ?></td>
                                    <td><?= $arCus->pemBT ?></td>
                                    <td><?= $bayarCus->pemKet ?></td>
                                    <td class="text-align-right"><?= '0,00' ?></td>
                                    <td class="text-align-right"><?= saldo_money($bayarCus->pemTotal); ?>
                                        <?php $credit += $bayarCus->pemTotal; ?>
                                    </td>

                                    <?php if ($saldoA + $debit - $credit < 0) { ?>
                                        <td class="text-align-right"><?= '(' . saldo_money($saldoA + $debit - $credit) . ')' ?></td>
                                    <?php } else { ?>
                                        <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php endforeach ?>
                    <?php } else if ($arCus->id_bayar != NULL && $arCus->id_customer != $ar->id_customer) { ?>
                    <?php } else if ($arCus->id_bayar == NULL && $arCus->id_customer == $ar->id_customer) { ?>
                        <tr>
                            <td><?= $arCus->arTgl ?></td>
                            <td><?= $arCus->arBT ?></td>
                            <td><?= $arCus->arKet ?></td>
                            <td class="text-align-right"><?= saldo_money($arCus->arTotal); ?>
                                <?php $debit += $arCus->arTotal; ?>
                            </td>
                            <td class="text-align-right"><?= '0,00'; ?>
                                <?php $credit += $arCus->pemTotal; ?>
                            </td>
                            <td class="text-align-right"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                        </tr>
                    <?php } else if ($arCus->id_bayar != NULL && $arCus->id_customer != $ar->id_customer) { ?>
                    <?php } ?>
                <?php endforeach ?>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="border-top border-bottom">TOTAl PER CUSTOMER :</td>
                    <td class="text-align-right border-top border-bottom"><?= saldo_money($debit) ?></td>
                    <td class="text-align-right border-top border-bottom"><?= saldo_money($credit) ?></td>

                    <?php if ($saldoA + $debit - $credit < 0) { ?>
                        <td class="text-align-right border-top border-bottom"><?= '(' . saldo_money($saldoA + $debit - $credit) . ')' ?> </td>
                    <?php } else { ?>
                        <td class="text-align-right border-top border-bottom"><?= saldo_money($saldoA + $debit - $credit) ?></td>
                    <?php } ?>

                    <?php $totalD += $debit;
                    $totalC += $credit;
                    $total += ($saldoA + $debit - $credit); ?>
                </tr>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
            </table>
        <?php } ?>
    <?php endforeach; ?>
    <table>
        <tr>
            <td style="width: 15%; font-size: 9pt;" class="border-top border-bottom">TOTAL :</td>
            <td style="width: 15%; font-size: 9pt;" class="border-top border-bottom"></td>
            <td style="width: 35%; font-size: 9pt;" class="border-top border-bottom"></td>

            <?php if ($totalD < 0) { ?>
                <td style="width: 15%; font-size: 9pt;" class="text-align-right border-top border-bottom"><?= '(' . saldo_money($totalD) . ')' ?> </td>
            <?php } else { ?>
                <td style="width: 15%; font-size: 9pt;" class="text-align-right border-top border-bottom"><?= saldo_money($totalD) ?></td>
            <?php } ?>

            <?php if ($totalC < 0) { ?>
                <td style="width: 15%; font-size: 9pt;" class="text-align-right border-top border-bottom"><?= '(' . saldo_money($totalC) . ')' ?> </td>
            <?php } else { ?>
                <td style="width: 15%; font-size: 9pt;" class="text-align-right border-top border-bottom"><?= saldo_money($totalC) ?></td>
            <?php } ?>

            <?php if ($total < 0) { ?>
                <td style="width: 15%; font-size: 9pt;" class="text-align-right border-top border-bottom"><?= '(' . saldo_money($total) . ')' ?> </td>
            <?php } else { ?>
                <td style="width: 15%; font-size: 9pt;" class="text-align-right border-top border-bottom"><?= saldo_money($total) ?></td>
            <?php } ?>
        </tr>
    </table>

</body>

</html>