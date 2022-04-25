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
    <?php if ($dataCoA == 21) { ?>
        <p style="font-size: 13pt; text-align: center; text-decoration: underline;"><strong>DAFTAR UMUR PIUTANG LISTRIK DAN AIR</strong></p>
        <p class="text-align-right;"><?= 'Tgl : ' . date("d-m-Y"); ?></p>
        <p> <strong>UNTUK TANGGAL &nbsp;&nbsp; : &nbsp;&nbsp; <span class="year-pembukuan"><?= '' . date('d/F/Y', strtotime($dataDate)); ?></span></strong></p>
        <p> <strong>DARI TANGGAL FAKTUR &nbsp;&nbsp; : &nbsp;&nbsp; // &nbsp;&nbsp;&nbsp;&nbsp; S/D TANGGAL FAKTUR &nbsp;&nbsp; : &nbsp;&nbsp;<span class="year-pembukuan"><?= '31/' . date('F/Y', strtotime($dataDate)); ?></span></strong></p>
        <p> UNTUK PIUTANG YANG SUDAH JATUH TEMPO - Berdasarkan Tanggal Jatuh TEMPO</p>
        <br>
        <br>
    <?php } else if ($dataCoA == 22) { ?>
        <p style="font-size: 13pt; text-align: center; text-decoration: underline;"><strong>DAFTAR UMUR PIUTANG SERVICE CHARGE DAN SINKING FUND</strong></p>
        <p class="text-align-right;"><?= 'Tgl : ' . date("d-m-Y"); ?></p>
        <p> <strong>UNTUK TANGGAL &nbsp;&nbsp; : &nbsp;&nbsp; <span class="year-pembukuan"><?= '' . date('d/F/Y', strtotime($dataDate)); ?></span></strong></p>
        <p> <strong>DARI TANGGAL FAKTUR &nbsp;&nbsp; : &nbsp;&nbsp; // &nbsp;&nbsp;&nbsp;&nbsp; S/D TANGGAL FAKTUR &nbsp;&nbsp; : &nbsp;&nbsp;<span class="year-pembukuan"><?= '31/' . date('F/Y', strtotime($dataDate)); ?></span></strong></p>
        <p> UNTUK PIUTANG YANG SUDAH JATUH TEMPO - Berdasarkan Tanggal Jatuh TEMPO</p>
        <br>
        <br>
    <?php } ?>

    PERINCIAN PER TOTAL
    <br>
    <br>


    <table>
        <tr>
            <td style="width: 10%; font-size: 10pt;" class="border-bottom"><strong>KODE</strong></td>
            <td style="width: 25%; font-size: 10pt;" class="border-bottom"><strong>NAMA OWNER</strong></td>
            <td style="width: 5%; font-size: 10pt;" class="border-bottom"><strong>VLT</strong></td>
            <td style="width: 15%; font-size: 10pt;" class="text-align-right border-bottom"><strong>CURRENT</strong></td>
            <td style="width: 15%; font-size: 10pt;" class="text-align-right border-bottom"><strong>1 - 31 Hari</strong></td>
            <td style="width: 15%; font-size: 10pt;" class="text-align-right border-bottom"><strong>31 - 63 Hari</strong></td>
            <td style="width: 15%; font-size: 10pt;" class="text-align-right border-bottom"><strong>> 62 Hari</strong></td>
            <td style="width: 15%; font-size: 10pt;" class="text-align-right border-bottom"><strong>TOTAL</strong></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <?php

        $total = 0;
        $totalCA = 0;
        $totalOA = 0;
        $totalTA = 0;
        $totalLA = 0;
        foreach ($dataAR as $ar) :
            if ($ar->kode_soa == 22) {
                $total2 = 0;
                $totalC = 0;
                $totalO = 0;
                $totalT = 0;
                $totalL = 0;
                foreach ($dataARCus as $arCus) {
                    $tambah = 0;
                    foreach ($dataBayar as $bayar) {
                        if ($bayar->tanggal_bayar < $bayar->datekeluar) {
                            if ($bayar->id_owner == $ar->id_owner && $bayar->monthbayar > 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += ($bayar->total - $bayar->credit);
                                } else {
                                }
                            } else if ($bayar->id_owner == $ar->id_owner && $bayar->monthbayar <= 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += ($bayar->total - $bayar->credit);
                                } else {
                                }
                            }
                        } else if ($bayar->tanggal_bayar >= $bayar->datekeluar) {
                            if ($bayar->id_owner == $ar->id_owner && $bayar->monthbayar > 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            } else if ($bayar->id_owner == $ar->id_owner && $bayar->monthbayar <= 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            } else if ($bayar->id_owner == $ar->id_owner && $bayar->monthbayar <= 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 2) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            } else if ($bayar->id_owner == $ar->id_owner && $bayar->monthbayar > 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 2) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            }
                        }
                    }
                    if ($arCus->id_owner == $ar->id_owner) {
                        if ($arCus->selisih == 0 && $arCus->status == 0) {
                            $totalC += $arCus->sisa;
                        } else if ($arCus->selisih == 0 && $arCus->status == 1) {
                            $totalC += ($tambah);
                        } else if ($arCus->selisih == 0 && $arCus->status == 2) {
                            $totalC += ($arCus->sisa + $tambah);
                        } else if (($arCus->selisih == 1) && $arCus->status == 0) {
                            $totalO += $arCus->sisa;
                        } else if (($arCus->selisih == 1) && $arCus->status == 1) {
                            $totalO += ($tambah);
                        } else if (($arCus->selisih == 1) && $arCus->status == 2) {
                            $totalO += ($arCus->sisa + $tambah);
                        } else if (($arCus->selisih == 2) && $arCus->status == 0) {
                            $totalT += $arCus->sisa;
                        } else if (($arCus->selisih == 2) && $arCus->status == 1) {
                            $totalT += ($tambah);
                        } else if (($arCus->selisih == 2) && $arCus->status == 2) {
                            $totalT += ($arCus->sisa + $tambah);
                        } else if (($arCus->selisih > 2) && $arCus->status == 0) {
                            $totalL += $arCus->sisa;
                        } else if (($arCus->selisih > 2) && $arCus->status == 1) {
                            $totalL += ($tambah);
                        } else if (($arCus->selisih > 2) && $arCus->status == 2) {
                            $totalL += ($arCus->sisa + $tambah);
                        }
                    }
                }
                $total2 = $totalC + $totalO + $totalT + $totalL;
                $totalCA += $totalC;
                $totalOA += $totalO;
                $totalTA += $totalT;
                $totalLA += $totalL;
                $total += $total2;
        ?>
                <tr>
                    <td><?= $ar->id_owner ?></td>
                    <td><?= $ar->nama_owner ?></td>
                    <td>IDR</td>
                    <td class="text-align-right"><?= saldo_money($totalC) ?></td>
                    <td class="text-align-right"><?= saldo_money($totalO) ?></td>
                    <td class="text-align-right"><?= saldo_money($totalT) ?></td>
                    <td class="text-align-right"><?= saldo_money($totalL) ?></td>
                    <td class="text-align-right"><?= saldo_money($total2) ?></td>
                </tr>
            <?php } else if ($ar->kode_soa == 21) {
                $total2 = 0;
                $totalC = 0;
                $totalO = 0;
                $totalT = 0;
                $totalL = 0;
                foreach ($dataARCus as $arCus) {
                    $tambah = 0;
                    foreach ($dataBayar as $bayar) {
                        if ($bayar->tanggal_bayar < $bayar->datekeluar) {
                            if ($bayar->id_customer == $ar->id_customer && $bayar->monthbayar > 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += ($bayar->total - $bayar->credit);
                                } else {
                                }
                            } else if ($bayar->id_customer == $ar->id_customer && $bayar->monthbayar <= 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += ($bayar->total - $bayar->credit);
                                } else {
                                }
                            }
                        } else if ($bayar->tanggal_bayar >= $bayar->datekeluar) {
                            if ($bayar->id_customer == $ar->id_customer && $bayar->monthbayar > 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            } else if ($bayar->id_customer == $ar->id_customer && $bayar->monthbayar <= 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 1) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            } else if ($bayar->id_customer == $ar->id_customer && $bayar->monthbayar <= 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 2) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            } else if ($bayar->id_customer == $ar->id_customer && $bayar->monthbayar > 0 && $bayar->id_ar == $arCus->id_ar && $bayar->status == 2) {
                                if ($bayar->total < $bayar->credit) {
                                    $tambah += $bayar->total;
                                } else if ($bayar->total >= $bayar->credit) {
                                    $tambah += $bayar->credit;
                                } else {
                                }
                            }
                        }
                    }
                    if ($arCus->id_customer == $ar->id_customer) {
                        if ($arCus->selisih == 0 && $arCus->status == 0) {
                            $totalC += $arCus->sisa;
                        } else if ($arCus->selisih == 0 && $arCus->status == 1) {
                            $totalC += ($tambah);
                        } else if ($arCus->selisih == 0 && $arCus->status == 2) {
                            $totalC += ($arCus->sisa + $tambah);
                        } else if (($arCus->selisih == 1) && $arCus->status == 0) {
                            $totalO += $arCus->sisa;
                        } else if (($arCus->selisih == 1) && $arCus->status == 1) {
                            $totalO += ($tambah);
                        } else if (($arCus->selisih == 1) && $arCus->status == 2) {
                            $totalO += ($arCus->sisa + $tambah);
                        } else if (($arCus->selisih == 2) && $arCus->status == 0) {
                            $totalT += $arCus->sisa;
                        } else if (($arCus->selisih == 2) && $arCus->status == 1) {
                            $totalT += ($tambah);
                        } else if (($arCus->selisih == 2) && $arCus->status == 2) {
                            $totalT += ($arCus->sisa + $tambah);
                        } else if (($arCus->selisih > 2) && $arCus->status == 0) {
                            $totalL += $arCus->sisa;
                        } else if (($arCus->selisih > 2) && $arCus->status == 1) {
                            $totalL += ($tambah);
                        } else if (($arCus->selisih > 2) && $arCus->status == 2) {
                            $totalL += ($arCus->sisa + $tambah);
                        }
                    }
                }
                $total2 = $totalC + $totalO + $totalT + $totalL;
                $totalCA += $totalC;
                $totalOA += $totalO;
                $totalTA += $totalT;
                $totalLA += $totalL;
                $total += $total2;
            ?>
                <tr>
                    <td><?= $ar->id_customer ?></td>
                    <td><?= $ar->nama_customer ?></td>
                    <td><?php echo 'IDR'; ?></td>
                    <td class="text-align-right"><?= saldo_money($totalC) ?></td>
                    <td class="text-align-right"><?= saldo_money($totalO) ?></td>
                    <td class="text-align-right"><?= saldo_money($totalT) ?></td>
                    <td class="text-align-right"><?= saldo_money($totalL) ?></td>
                    <td class="text-align-right"><?= saldo_money($total2) ?></td>
                </tr>
        <?php
            }
        endforeach; ?>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
            <td class="border-top border-bottom">TOTAL :</td>
            <td class="border-top border-bottom"></td>
            <td class="border-top border-bottom"></td>

            <?php if ($totalCA != NULL) { ?>
                <td class="text-align-right border-top border-bottom"><?= saldo_money($totalCA) ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top border-bottom"><?php echo '0,00'; ?></td>
            <?php } ?>

            <?php if ($totalOA != NULL) { ?>
                <td class="text-align-right border-top border-bottom"><?= saldo_money($totalOA) ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top border-bottom"><?php echo '0,00'; ?></td>
            <?php } ?>

            <?php if ($totalTA != NULL) { ?>
                <td class="text-align-right border-top border-bottom"><?= saldo_money($totalTA) ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top border-bottom"><?php echo '0,00'; ?></td>
            <?php } ?>

            <?php if ($totalLA != NULL) { ?>
                <td class="text-align-right border-top border-bottom"><?= saldo_money($totalLA) ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top border-bottom"><?php echo '0,00'; ?></td>
            <?php } ?>

            <?php if ($total != NULL) { ?>
                <td class="text-align-right border-top border-bottom"><?= saldo_money($total) ?></td>
            <?php } else { ?>
                <td class="text-align-right border-top border-bottom"><?php echo '0,00'; ?></td>
            <?php } ?>
        </tr>
    </table>

</body>

</html>