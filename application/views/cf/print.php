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
    <p style="font-size: 13pt;"><strong>Building Management SCBD-Suites</strong></p>
    <p style="font-size: 12pt;"><strong>Laporan Cash Flow</strong></p>
    <br>
    <br>
    <p><?= 'Per ' . date('d-m-Y', strtotime($date));?></p>
    <br>
    
    <p><b>KETERANGAN</b></p>
    
    <?php
        $totalMB = 0;
        $totalMA = 0;
        $totalYB = 0;
        $totalYA = 0;
        $totalSMB = 0;
        $totalSMA = 0;
        $totalSYB = 0;
        $totalSYA = 0;
        foreach ($dataJurnal as $jt) : ?>
                    <table>
                        <tr>
                            <td colspan="2"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong>MTD BUDGET</strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong>MTD ACTUAL</strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong>YTD BUDGET</strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong>YTD ACTUAL</strong></td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding"><strong><?= 'PENERIMAAN'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <?php 
                            $totalPDMB = 0;
                            $totalPDMA = 0;
                            $totalPDYB = 0;
                            $totalPDYA = 0;
                            foreach ($dataPendapatan as $pd) {
                                if($pd->cash == 1 && $pd->jurnal_tipe == 1 && $pd->ytd_actual < 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= $pd->coa_name; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_budget != NULL && $pd->mtd_budget < 0) { ?><?= '('. saldo_money($pd->mtd_budget)  . ')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else if($pd->mtd_budget != NULL && $pd->mtd_budget >= 0) { echo '('. saldo_money($pd->mtd_budget) .')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else{echo '0,00'; $totalPDMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_actual != NULL && $pd->mtd_actual < 0) { ?><?= saldo_money($pd->mtd_actual); $totalPDMA -= $pd->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_budget != NULL && $pd->ytd_budget < 0) { ?><?= '('. saldo_money($pd->ytd_budget) . ')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else if($pd->ytd_budget != NULL && $pd->ytd_budget >= 0) { echo '('. saldo_money($pd->ytd_budget) .')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else{echo '0,00'; $totalPDYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= saldo_money($pd->ytd_actual); $totalPDYA -= $pd->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                } else if($pd->cash == 1 && $pd->jurnal_tipe == 2 && $pd->ytd_actual < 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= $pd->coa_name; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_budget != NULL && $pd->mtd_budget < 0) { ?><?= '('. saldo_money($pd->mtd_budget)  . ')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else if($pd->mtd_budget != NULL && $pd->mtd_budget >= 0) { echo '('. saldo_money($pd->mtd_budget) .')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else{echo '0,00'; $totalPDMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_actual != NULL && $pd->mtd_actual < 0) { ?><?= saldo_money($pd->mtd_actual); $totalPDMA -= $pd->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_budget != NULL && $pd->ytd_budget < 0) { ?><?= '('. saldo_money($pd->ytd_budget) . ')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else if($pd->ytd_budget != NULL && $pd->ytd_budget >= 0) { echo '('. saldo_money($pd->ytd_budget) .')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else{echo '0,00'; $totalPDYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= saldo_money($pd->ytd_actual); $totalPDYA -= $pd->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                } else if($pd->cash == 1 && $pd->jurnal_tipe == 3 && $pd->ytd_actual < 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= $pd->coa_name; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_budget != NULL && $pd->mtd_budget < 0) { ?><?= '('. saldo_money($pd->mtd_budget)  . ')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else if($pd->mtd_budget != NULL && $pd->mtd_budget >= 0) { echo '('. saldo_money($pd->mtd_budget) .')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else{echo '0,00'; $totalPDMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_actual != NULL && $pd->mtd_actual < 0) { ?><?= saldo_money($pd->mtd_actual); $totalPDMA -= $pd->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_budget != NULL && $pd->ytd_budget < 0) { ?><?= '('. saldo_money($pd->ytd_budget) . ')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else if($pd->ytd_budget != NULL && $pd->ytd_budget >= 0) { echo '('. saldo_money($pd->ytd_budget) .')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else{echo '0,00'; $totalPDYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= saldo_money($pd->ytd_actual); $totalPDYA -= $pd->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                } else if($pd->cash == 1 && $pd->jurnal_tipe == 4 && $pd->ytd_actual < 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= $pd->coa_name; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_budget != NULL && $pd->mtd_budget < 0) { ?><?= '('. saldo_money($pd->mtd_budget)  . ')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else if($pd->mtd_budget != NULL && $pd->mtd_budget >= 0) { echo '('. saldo_money($pd->mtd_budget) .')'; $totalPDMB += $pd->mtd_budget;?></td><?php }else{echo '0,00'; $totalPDMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->mtd_actual != NULL && $pd->mtd_actual < 0) { ?><?= saldo_money($pd->mtd_actual); $totalPDMA -= $pd->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_budget != NULL && $pd->ytd_budget < 0) { ?><?= '('. saldo_money($pd->ytd_budget) . ')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else if($pd->ytd_budget != NULL && $pd->ytd_budget >= 0) { echo '('. saldo_money($pd->ytd_budget) .')'; $totalPDYB += $pd->ytd_budget;?></td><?php }else{echo '0,00'; $totalPDYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pd->ytd_actual != NULL && $pd->ytd_actual < 0) { ?><?= saldo_money($pd->ytd_actual); $totalPDYA -= $pd->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                }
                            } ?>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding border-top-no-padding"><strong><?= 'TOTAL PENERIMAAN'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPDMB < 0) { ?> <?= '('. saldo_money($totalPDMB) . ')'; $totalMB += $totalPDMB;?></td> <?php } else if ($totalPDMB >= 0) { ?> <?= '('. saldo_money($totalPDMB) .')'; $totalMB += $totalPDMB;?></td> <?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPDMA > 0) { ?> <?= saldo_money($totalPDMA);?></td> <?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPDYB < 0) { ?> <?= '('. saldo_money($totalPDYB) . ')'; $totalYB += $totalPDYB;?></td> <?php } else if ($totalPDYB >= 0) { ?> <?= '('. saldo_money($totalPDYB) .')'; $totalYB += $totalPDYB;?></td> <?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPDYA > 0) { ?> <?= saldo_money($totalPDYA);?></td> <?php } else{ } ?>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding"><strong><?= 'PENGELUARAN'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <?php
                            $totalPGMB = 0;
                            $totalPGMA = 0;
                            $totalPGYB = 0;
                            $totalPGYA = 0;
                            foreach ($dataPengeluaran as $pg) { 
                                if($pg->cash == 1 && $pg->jurnal_tipe == 1 && $pg->ytd_actual > 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?> <?= $pg->parent; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_budget != NULL && $pg->mtd_budget < 0) { ?><?= '('. saldo_money($pg->mtd_budget)  . ')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else if($pg->mtd_budget != NULL && $pg->mtd_budget >= 0) { echo '('. saldo_money($pg->mtd_budget) .')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else{echo '0,00'; $totalPGMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_actual != NULL && $pg->mtd_actual > 0) { ?><?= saldo_money($pg->mtd_actual); $totalPGMA += $pg->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_budget != NULL && $pg->ytd_budget < 0) { ?><?= '('. saldo_money($pg->ytd_budget) . ')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else if($pg->ytd_budget != NULL && $pg->ytd_budget >= 0) { echo '('. saldo_money($pg->ytd_budget) .')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else{echo '0,00'; $totalPGYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?><?= saldo_money($pg->ytd_actual); $totalPGYA += $pg->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                } else if($pg->cash == 1 && $pg->jurnal_tipe == 2 && $pg->ytd_actual > 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?> <?= $pg->parent; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_budget != NULL && $pg->mtd_budget < 0) { ?><?= '('. saldo_money($pg->mtd_budget)  . ')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else if($pg->mtd_budget != NULL && $pg->mtd_budget >= 0) { echo '('. saldo_money($pg->mtd_budget) .')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else{echo '0,00'; $totalPGMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_actual != NULL && $pg->mtd_actual > 0) { ?><?= saldo_money($pg->mtd_actual); $totalPGMA += $pg->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_budget != NULL && $pg->ytd_budget < 0) { ?><?= '('. saldo_money($pg->ytd_budget) . ')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else if($pg->ytd_budget != NULL && $pg->ytd_budget >= 0) { echo '('. saldo_money($pg->ytd_budget) .')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else{echo '0,00'; $totalPGYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?><?= saldo_money($pg->ytd_actual); $totalPGYA += $pg->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                } else if($pg->cash == 1 && $pg->jurnal_tipe == 3 && $pg->ytd_actual > 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?><?= $pg->parent; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_budget != NULL && $pg->mtd_budget < 0) { ?><?= '('. saldo_money($pg->mtd_budget)  . ')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else if($pg->mtd_budget != NULL && $pg->mtd_budget >= 0) { echo '('. saldo_money($pg->mtd_budget) .')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else{echo '0,00'; $totalPGMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_actual != NULL && $pg->mtd_actual > 0) { ?><?= saldo_money($pg->mtd_actual); $totalPGMA += $pg->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_budget != NULL && $pg->ytd_budget < 0) { ?><?= '('. saldo_money($pg->ytd_budget) . ')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else if($pg->ytd_budget != NULL && $pg->ytd_budget >= 0) { echo '('. saldo_money($pg->ytd_budget) .')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else{echo '0,00'; $totalPGYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?><?= saldo_money($pg->ytd_actual); $totalPGYA += $pg->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                } else if($pg->cash == 1 && $pg->jurnal_tipe == 4 && $pg->ytd_actual > 0) { ?>
                                    <tr>
                                        <td colspan="2"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?><?= $pg->parent; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_budget != NULL && $pg->mtd_budget < 0) { ?><?= '('. saldo_money($pg->mtd_budget)  . ')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else if($pg->mtd_budget != NULL && $pg->mtd_budget >= 0) { echo '('. saldo_money($pg->mtd_budget) .')'; $totalPGMB += $pg->mtd_budget;?></td><?php }else{echo '0,00'; $totalPGMB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->mtd_actual != NULL && $pg->mtd_actual > 0) { ?><?= saldo_money($pg->mtd_actual); $totalPGMA += $pg->mtd_actual; } else{ } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_budget != NULL && $pg->ytd_budget < 0) { ?><?= '('. saldo_money($pg->ytd_budget) . ')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else if($pg->ytd_budget != NULL && $pg->ytd_budget >= 0) { echo '('. saldo_money($pg->ytd_budget) .')'; $totalPGYB += $pg->ytd_budget;?></td><?php }else{echo '0,00'; $totalPGYB += 0; } ?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;</td>
                                        <td class="text-align-right"><?php if($pg->ytd_actual != NULL && $pg->ytd_actual > 0) { ?><?= saldo_money($pg->ytd_actual); $totalPGYA += $pg->ytd_actual; } else{ } ?></td>
                                    </tr>
                                <?php 
                                }
                            } ?>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding border-top-no-padding"><strong><?= 'TOTAL PENGELUARAN'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPGMB < 0) { ?> <?= '('. saldo_money($totalPGMB) . ')'; $totalMB += $totalPGMB;?></td> <?php } else if ($totalPGMB >= 0) { ?> <?= '('. saldo_money($totalPGMB) .')'; $totalMB += $totalPGMB;?></td> <?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPGMA > 0) { ?> <?= saldo_money($totalPGMA);?></td> <?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPGYB < 0) { ?> <?= '('. saldo_money($totalPGYB) . ')'; $totalYB += $totalPGYB;?></td> <?php } else if ($totalPGYB >= 0) { ?> <?= '('. saldo_money($totalPGYB) .')'; $totalYB += $totalPGYB;?></td> <?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalPGYA > 0) { ?> <?= saldo_money($totalPGYA);?></td> <?php } ?>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                            <?php $totalMA = $totalPDMA - $totalPGMA; $totalYA = $totalPDYA - $totalPGYA;?>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding border-top-no-padding"><strong><?= 'TOTAL PENERIMAAN - PENGELUARAN'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalMB < 0) { ?> <?= '('. saldo_money($totalMB) . ')'; $totalSMB += $totalMB;?></td> <?php } else if ($totalMB >= 0) { ?> <?= '('. saldo_money($totalMB) . ')'; $totalSMB += $totalMB;?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalMA < 0) { ?> <?= '('. saldo_money($totalMA) . ')'; $totalSMA += $totalMA;?></td> <?php } else if ($totalMA >= 0) { ?> <?= saldo_money($totalMA); $totalSMA += $totalMA;?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalYB < 0) { ?> <?= '('. saldo_money($totalYB) . ')'; $totalSYB += $totalYB;?></td> <?php } else if ($totalYB >= 0) { ?> <?= '('. saldo_money($totalYB) . ')'; $totalSYB += $totalYB;?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalYA < 0) { ?> <?= '('. saldo_money($totalYA) . ')'; $totalSYA += $totalYA;?></td> <?php } else if ($totalYA >= 0) { ?> <?= saldo_money($totalYA); $totalSYA += $totalYA;?></td><?php } ?>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding"><strong><?= 'SALDO AWAL'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right"><strong></strong></td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <?php
                            $totalSAMB = 0;
                            $totalSAMA = 0;
                            $totalSKYB = 0;
                            $totalSKYA = 0;
                            foreach ($dataSaldo as $sa) { ?>
                                <tr>
                                    <td colspan="2"><?= $sa->coa_name; ?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right"><?php if($sa->mtd_budget != NULL && $sa->mtd_budget < 0) { ?><?= '('. saldo_money($sa->mtd_budget) . ')' ; $totalSAMB += $sa->mtd_budget;?></td><?php }else if($sa->mtd_budget != NULL && $sa->mtd_budget > 0) { echo '('. saldo_money($sa->mtd_budget) . ')' ; $totalSAMB += $sa->mtd_budget;?></td><?php }else{echo '0,00'; $totalSAMB += 0; } ?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;</td>
                                    <td class="text-align-right"><?php if($sa->mtd_actual_last != NULL && $sa->mtd_actual_last < 0) { ?><?= '('. saldo_money($sa->mtd_actual_last) . ')' ; $totalSAMA += $sa->mtd_actual_last;?></td><?php }else if($sa->mtd_actual_last != NULL && $sa->mtd_actual_last >= 0) { echo saldo_money($sa->mtd_actual_last) ; $totalSAMA += $sa->mtd_actual_last;?></td><?php }else{echo '0,00'; $totalSAMA += 0; } ?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;</td>
                                    <td class="text-align-right"><?php if($sa->ytd_budget != NULL && $sa->ytd_budget < 0) { ?><?= '('. saldo_money($sa->ytd_budget) . ')' ; $totalSKYB += $sa->ytd_budget;?></td><?php }else if($sa->ytd_budget != NULL && $sa->ytd_budget > 0) { echo '('. saldo_money($sa->ytd_budget) . ')' ; $totalSKYB += $sa->ytd_budget;?></td><?php }else{echo '0,00'; $totalSKYB += 0; } ?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;</td>
                                    <td class="text-align-right"><?php if($sa->ytd_actual_last != NULL && $sa->ytd_actual_last < 0) { ?><?= '('. saldo_money($sa->ytd_actual_last) . ')' ; $totalSKYA += $sa->ytd_actual_last;?></td><?php }else if($sa->ytd_actual_last != NULL && $sa->ytd_actual_last >= 0) { echo saldo_money($sa->ytd_actual_last) ; $totalSKYA += $sa->ytd_actual_last;?></td><?php }else{echo '0,00'; $totalSKYA += 0; } ?></td>
                                </tr>
                            <?php } ?>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding border-top-no-padding"><strong><?= 'TOTAL Saldo Awal Kas/Bank'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSAMB < 0) { ?> <?= '('. saldo_money($totalSAMB) . ')';?></td> <?php } else if ($totalSAMB >= 0) { ?> <?= '('. saldo_money($totalSAMB) .')';?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSAMA < 0) { ?> <?= '('. saldo_money($totalSAMA) . ')';?></td> <?php } else if ($totalSAMA >= 0) { ?> <?= saldo_money($totalSAMA);?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSKYB < 0) { ?> <?= '('. saldo_money($totalSKYB) . ')';?></td> <?php } else if ($totalSKYB >= 0) { ?> <?= '('. saldo_money($totalSKYB) .')';?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSKYA < 0) { ?> <?= '('. saldo_money($totalSKYA) . ')';?></td> <?php } else if ($totalSKYA >= 0) { ?> <?= saldo_money($totalSKYA);?></td><?php } ?>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                        <?php $totalSMA =  $totalSAMA + $totalPDMA - $totalPGMA; $totalSYA = $totalSKYA + $totalPDYA - $totalPGYA; $totalSMB = $totalSAMB + $totalPDMB - $totalPGMB; $totalSYB = $totalSKYB + $totalPDYB - $totalPGYB; ?>
                        <tr>
                            <td colspan="2" class="border-bottom-no-padding border-top-no-padding"><strong><?= 'TOTAL AKHIR'; ?></strong></td>
                            <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSMB < 0) { ?> <?= '('. saldo_money($totalSMB) . ')';?></td> <?php } else if ($totalSMB >= 0) { ?> <?= '('. saldo_money($totalSMB) . ')';?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSMA < 0) { ?> <?= '('. saldo_money($totalSMA) . ')';?></td> <?php } else if ($totalSMA >= 0) { ?> <?= saldo_money($totalSMA);?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSYB < 0) { ?> <?= '('. saldo_money($totalSYB) . ')';?></td> <?php } else if ($totalSYB >= 0) { ?> <?= '('. saldo_money($totalSMB) . ')';?></td><?php } ?>
                            <td class="text-align-right">&nbsp;&nbsp;</td>
                            <td class="text-align-right border-bottom-no-padding border-top-no-padding"><?php if ($totalSYA < 0) { ?> <?= '('. saldo_money($totalSYA) . ')';?></td> <?php } else if ($totalSYA >= 0) { ?> <?= saldo_money($totalSYA);?></td><?php } ?>
                        </tr>
                </table>
    <?php endforeach; ?>
</body>

</html>
