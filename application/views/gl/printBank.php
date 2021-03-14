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
        $total = 0;
        foreach ($dataGL as $gl) : ?>
            <p style="font-size: 13pt;">Bulding Management SCBD-Suites</p>
            <p style="font-size: 13pt;">Jln Jendral Sudirman Kav. 52-53 Jakarta 12190</p>
            <p class="text-align-right"><?= 'Tgl : ' . date("d-m-Y");?></p>
            <p class="border-bottom-no-padding" style="font-size: 12pt;"><strong>Laporan Bank Harian</strong></p>
            <p><?= 'HARI TGL : ' . date('01-m-Y', strtotime($date)) . ' s.d ' . date('t-m-Y', strtotime($date)); ?></p>
            <table>
                <tr>
                    <td><?= 'KODE BANK &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .  $coa->coa_id  . '&nbsp;&nbsp;&nbsp;&nbsp;' . $coa->coa_name ?></td>
                </tr>
                <tr>
                    <td><?php if($gl->saldoAwal != null && $gl->saldoAwal < 0){?><?= 'SALDO AWAL &nbsp;&nbsp;&nbsp;&nbsp; IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . '('. saldo_money($gl->saldoAwal) . ')'; $saldoD = $gl->saldoAwal;?></td><?php }else if ($gl->saldoAwal != null && $gl->saldoAwal >= 0){ ?><?= 'SALDO AWAL &nbsp;&nbsp;&nbsp;&nbsp; IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . saldo_money($gl->saldoAwal); $saldoD = $gl->saldoAwal; ?></td><?php }else{echo 'SALDO AWAL &nbsp;&nbsp;&nbsp;&nbsp; IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 00,00'; $saldoD = 0; } ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="border-bottom padding"><strong>TANGGAL</strong></td>
                    <td>&nbsp;</td>
                    <td class="border-bottom padding"><strong>NO.BUKTI</strong></td>
                    <td class="border-bottom padding"><strong>NO.ARSIP</strong></td>
                    <td class="border-bottom padding"><strong>KETERANGAN</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="border-bottom padding text-align-right"><strong>DEBET</strong></td>
                    <td>&nbsp;</td>
                    <td class="border-bottom padding text-align-right"><strong>KREDIT</strong></td>
                    <td>&nbsp;</td>
                    <td class="border-bottom padding text-align-right"><strong>SALDO</strong></td>
                </tr>
                <?php 
                    $totalD = 0;
                    $totalC = 0;
                    foreach($dataGLTgl AS $glT) {
                        if($gl->tanggal_transaksi == $glT->tanggal_transaksi){
                            foreach($dataGLCus AS $glCus){
                                if($glCus->kode_soa == $glT->kode_soa){ ?>
                                <tr>
                                    <td><?=$glCus->tanggal_transaksi?></td>
                                    <td>&nbsp;</td>
                                    <td><?=$glCus->bukti_transaksi?></td>
                                    <td></td>
                                    <td><?=$glCus->keterangan?></td>
                                    <td>&nbsp;</td>
                                    <td class="text-align-right"><?=money($glCus->debit)?></td>
                                    <td>&nbsp;</td>
                                    <td class="text-align-right"><?=money($glCus->credit)?></td>
                                    <td>&nbsp;</td>
                                    <td class="text-align-right"><?php $saldoD = $saldoD + ($glCus->debit - $glCus->credit);if ($glCus->saldoAwal == null &&  $saldoD < 0) { ?> <?= '(' . saldo_money($saldoD) . ')';?> </td><?php $total += ($glCus->debit - $glCus->credit); ?> <?php $totalD += $glCus->debit;?><?php $totalC += $glCus->credit; ?> <?php } else if ($glCus->saldoAwal == null && $saldoD >= 0){ ?> <?= money($saldoD); ?> </td> <?php $total += ($glCus->debit - $glCus->credit); ?> <?php $totalD += $glCus->debit; ?> <?php $totalC += $glCus->credit; ?> <?php } else if($glCus->saldoAwal != null && $saldoD < 0) { ?> <?= '(' . saldo_money($saldoD) . ')' ?> </td> <?php $totalD += $glCus->debit; ?> <?php $totalC += $glCus->credit; ?> <?php } else if ($glCus->saldoAwal != null && $saldoD >= 0) { ?> <?= money($saldoD); ?> </td> <?php $total += ($glCus->debit - $glCus->credit); ?> <?php $totalD += $glCus->debit; ?> <?php $totalC += $glCus->credit; ?> <?php } ?>
                                </tr>
                                <?php $total = $glCus->saldo;?>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
    <?php endforeach; ?>
            <tr>
                <td class="border-top border-bottom">TOTAL :</td>
                <td>&nbsp;</td>
                <td class="border-top border-bottom">&nbsp;</td>
                <td class="border-top border-bottom">&nbsp;</td>
                <td class="border-top border-bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;</td>
                <td class="border-top border-bottom text-align-right"><?php if ($totalD < 0) { ?> <?= '(' . saldo_money($totalD) . ')'?></td> <?php } else { ?> <?= saldo_money($totalD)?></td> <?php } ?>
                <td>&nbsp;</td>
                <td class="border-top border-bottom text-align-right"><?php if ($totalC < 0) { ?> <?= '(' . saldo_money($totalC) . ')'?></td> <?php } else { ?> <?= saldo_money($totalC)?></td> <?php } ?>
                <td>&nbsp;</td>
                <td class="border-top border-bottom text-align-right"><?php if ($saldoD < 0) { ?> <?= '(' . saldo_money($saldoD) . ')'?></td> <?php } else { ?> <?= saldo_money($saldoD)?></td> <?php } ?>
            </tr>
            
        </table>

        
</body>

</html>
