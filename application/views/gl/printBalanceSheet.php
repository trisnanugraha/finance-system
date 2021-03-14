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
            <td style="font-size: 13pt; text-align: center;"><span><strong>Building Management SCBD - Suites</strong></span></td>
        </tr>
        <tr>
            <td  style="font-size: 13pt; text-align: center;"><span><strong>Balance Sheet</strong></span></td>
        </tr>
        <tr>
            <td><strong><span id="bulan"><?= 'Bulan&nbsp;&nbsp;&nbsp;&nbsp;: ' . date('F Y', strtotime($date));?></span></strong></td>
        </tr>
        <tr>
            <td><strong><span><?= 'Cabang&nbsp;: 0&nbsp;&nbsp;KONSOLIDASI';?></span></strong></td>
        </tr>
        <tr>
            <td><strong><span><?= 'Valuta&nbsp;&nbsp;&nbsp;: IDR Indonesian Rupiah';?></strong></span></td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td><span>KETERANGAN</span></td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
    </table>
    <?php
        $totalNeracaC = 0;
        $totalNeracaL = 0;
        $totalNeracaV = 0;
        foreach ($dataJurnal as $jt) : ?>
                <table border="1">
                    <tr>
                        <td colspan="2" class="border-bottom-no-padding"></td>
                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-align-right"><strong>Current Month</strong></td>
                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-align-right"><strong>Last Month</strong></td>
                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-align-right"><strong>Varian</strong></td>
                    </tr>
                    <tr>
                        <td><p style="font-size: 12pt;"><b><?= $jt->type_name;?></b></p></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="border-bottom-no-padding"><strong>CURRENT ASSETS</strong></td>
                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                        <?php
                            $totalACP = 0;
                            $totalALP = 0;
                            $totalAVP = 0;
                            $totalCR = 0;
                            $totalLR = 0;
                            $totalVR = 0;
                            foreach ($dataCoA as $coa) {
                                

                                if($jt->jurnal_tipe == $coa->jurnal_tipe) { ?>
                                    <?php
                                        $totalCP = 0;
                                        $totalLP = 0;
                                        $totalVP = 0;
                                        $data = array("1", "7", "15", "20", "55");
                                        $counter = 0;
                                        foreach($dataGL as $gl){
                                            if($gl->parent == $coa->parent && $gl->parent == $data[$counter]){ ?>
                                                <!-- <tr>
                                                    <td colspan="2"><?= $gl->coa_name; ?></td>
                                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td class="text-align-right"><?php if($gl->saldo < 0 && $coa->jurnal_tipe == 1) { ?><?= '('. saldo_money($gl->saldo) . ')' ; $totalCP += $gl->saldo;?></td><?php }else if($gl->saldo >= 0 && $coa->jurnal_tipe == 1) { echo saldo_money($gl->saldo) ; $totalCP += $gl->saldo;?></td><?php }else if($gl->saldo < 0 && $coa->jurnal_tipe == 4) { ?><?= saldo_money($gl->saldo); $totalCP += $gl->saldo;?></td><?php }else if($gl->saldo >= 0 && $coa->jurnal_tipe == 4) { echo '(' . saldo_money($gl->saldo) . ')' ; $totalCP += $gl->saldo;?></td><?php }else{echo '0,00'; $totalCP += 0; } ?></td>
                                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td class="text-align-right"><?php if($gl->saldoLast != null && $gl->saldoLast < 0 && $coa->jurnal_tipe == 1 ) { ?><?= '('. saldo_money($gl->saldoLast) . ')' ; $totalLP += $gl->saldoLast;?></td><?php }else if ($gl->saldoLast != null && $gl->saldoLast >= 0 && $coa->jurnal_tipe == 1){ ?><?= saldo_money($gl->saldoLast); $totalLP += $gl->saldoLast;?></td><?php }else if ($gl->saldoLast != null && $gl->saldoLast >= 0 && $coa->jurnal_tipe == 4 ) { ?><?= '('. saldo_money($gl->saldoLast) . ')' ; $totalLP += $gl->saldoLast; ?></td><?php }else if ($gl->saldoLast != null && $gl->saldoLast < 0 && $coa->jurnal_tipe == 4){ ?><?= saldo_money($gl->saldoLast); $totalLP += $gl->saldoLast;?></td><?php }else{echo '0,00'; $totalLP += 0; } ?></td>
                                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td class="text-align-right"><?php if($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) < 0 && $coa->jurnal_tipe == 1) { ?><?= '('. saldo_money($gl->saldo - $gl->saldoLast) . ')' ; $totalVP += ($gl->saldo - $gl->saldoLast); ?></td><?php }else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) >= 0 && $coa->jurnal_tipe == 1){ ?><?= saldo_money($gl->saldo - $gl->saldoLast); $totalVP += ($gl->saldo - $gl->saldoLast);?></td><?php }else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) >= 0 && $coa->jurnal_tipe == 4) { ?><?= '('. saldo_money($gl->saldo - $gl->saldoLast) . ')' ; $totalVP += ($gl->saldo - $gl->saldoLast); ?></td><?php }else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) < 0 && $coa->jurnal_tipe == 4){ ?><?= saldo_money($gl->saldo - $gl->saldoLast); $totalVP += ($gl->saldo - $gl->saldoLast);?></td><?php }else if($gl->saldoLast == null && $gl->saldo < 0 && $coa->jurnal_tipe == 1) { ?><?= '(' . saldo_money($gl->saldo) . ')'; $totalVP += $gl->saldo;?></td><?php }else if($gl->saldoLast == null && $gl->saldo >= 0 && $coa->jurnal_tipe == 1) { ?><?= saldo_money($gl->saldo); $totalVP += $gl->saldo; ?></td><?php }else if($gl->saldoLast == null && $gl->saldo < 0 && $coa->jurnal_tipe == 4) { ?><?= saldo_money($gl->saldo); $totalVP += $gl->saldo; ?></td><?php }else if($gl->saldoLast == null && $gl->saldo >= 0 && $coa->jurnal_tipe == 4) { ?><?= '(' . saldo_money($gl->saldo) . ')'; $totalVP += $gl->saldo; ?></td><?php }else{echo '0,00'; $totalVP += 0; } ?></td>
                                                </tr> -->
                                               
                                            <?php
                                           $counter++;}
                                           }
                                        }
                                         
                                    ?>
                                    <tr>
                                    <td colspan="2"><?=$coa->parent_name?></td>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right border-top-no-padding"><?php if ($totalCP < 0 && $coa->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalCP) . ')'; $totalACP += $totalCP;?></td> <?php } else if ($totalCP >= 0 && $coa->jurnal_tipe == 1) { ?> <?= saldo_money($totalCP); $totalACP += $totalCP;?></td> <?php } else if ($totalCP >= 0 && $coa->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalCP) . ')'; $totalACP += $totalCP;?></td> <?php } else { ?> <?= saldo_money($totalCP); $totalACP += $totalCP;?></td> <?php } ?>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right border-top-no-padding"><?php if ($totalLP < 0 && $coa->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalLP) . ')'; $totalALP += $totalLP;?></td> <?php } else if ($totalLP >= 0 && $coa->jurnal_tipe == 1) { ?> <?= saldo_money($totalLP); $totalALP += $totalLP;?></td> <?php } else if ($totalLP >= 0 && $coa->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalLP) . ')'; $totalALP += $totalLP;?></td> <?php } else { ?> <?= saldo_money($totalLP); $totalALP += $totalLP;?></td> <?php } ?>
                                        <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="text-align-right border-top-no-padding"><?php if ($totalVP < 0 && $coa->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalVP) . ')'; $totalAVP += $totalVP;?></td> <?php } else if ($totalVP >= 0 && $coa->jurnal_tipe == 1) { ?> <?= saldo_money($totalVP); $totalAVP += $totalVP;?></td> <?php } else if ($totalVP >= 0 && $coa->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalVP) . ')'; $totalAVP += $totalVP;?></td> <?php } else { ?> <?= saldo_money($totalVP); $totalAVP += $totalVP;?></td> <?php } ?>
                                        
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="9">&nbsp;</td>
                                    </tr> -->
                                    <?php
                                }
                            }
                            if($jt->jurnal_tipe == 4){ ?>
                                <tr>
                                    <td colspan="2" class="border-bottom-no-padding"><strong><?= 'RETAINED EARNING'?></strong></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right"></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right"></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right"></td>
                                </tr>
                                <tr>
                                    <td colspan="9">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?= 'Surplus/Defisit Current Year'?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right"><?php if(($jt->retainedBeban + $jt->retainedPendapatan)  >= 0) { ?><?= '('. saldo_money(($jt->retainedBeban + $jt->retainedPendapatan) ) . ')' ; $totalCR += ($jt->retainedBeban + $jt->retainedPendapatan) ;?></td><?php }else if(($jt->retainedBeban + $jt->retainedPendapatan)  < 0) { echo saldo_money(($jt->retainedBeban + $jt->retainedPendapatan) ) ; $totalCR += ($jt->retainedBeban + $jt->retainedPendapatan) ;?></td><?php }else{echo '0,00'; $totalCR += 0; } ?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right"><?php if(($jt->retainedBebanLast + $jt->retainedPendapatanLast) != null && ($jt->retainedBebanLast + $jt->retainedPendapatanLast) >= 0) { ?><?= '('. saldo_money(($jt->retainedBebanLast + $jt->retainedPendapatanLast)) . ')' ; $totalLR += ($jt->retainedBebanLast + $jt->retainedPendapatanLast);?></td><?php }else if (($jt->retainedBebanLast + $jt->retainedPendapatanLast) != null && ($jt->retainedBebanLast + $jt->retainedPendapatanLast) < 0){ ?><?= saldo_money(($jt->retainedBebanLast + $jt->retainedPendapatanLast)); $totalLR += ($jt->retainedBebanLast + $jt->retainedPendapatanLast);?></td><?php }else{echo '0,00'; $totalLR += 0; } ?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right"><?php if(($jt->retainedBebanLast + $jt->retainedPendapatanLast) != null && (($jt->retainedBeban + $jt->retainedPendapatan)  - ($jt->retainedBebanLast + $jt->retainedPendapatanLast)) >= 0) { ?><?= '('. saldo_money(($jt->retainedBeban + $jt->retainedPendapatan)  - ($jt->retainedBebanLast + $jt->retainedPendapatanLast)) . ')' ; $totalVR += (($jt->retainedBeban + $jt->retainedPendapatan)  - ($jt->retainedBebanLast + $jt->retainedPendapatanLast)); ?></td><?php }else if (($jt->retainedBebanLast + $jt->retainedPendapatanLast) != null && (($jt->retainedBeban + $jt->retainedPendapatan)  - ($jt->retainedBebanLast + $jt->retainedPendapatanLast)) >= 0 && $coa->jurnal_tipe == 1){ ?><?= saldo_money(($jt->retainedBeban + $jt->retainedPendapatan)  - ($jt->retainedBebanLast + $jt->retainedPendapatanLast)); $totalVR += (($jt->retainedBeban + $jt->retainedPendapatan)  - ($jt->retainedBebanLast + $jt->retainedPendapatanLast));?></td><?php }else if(($jt->retainedBebanLast + $jt->retainedPendapatanLast) == null && ($jt->retainedBeban + $jt->retainedPendapatan)  >= 0) { ?><?= '(' . saldo_money(($jt->retainedBeban + $jt->retainedPendapatan) ) . ')'; $totalVR += ($jt->retainedBeban + $jt->retainedPendapatan) ;?></td><?php }else if(($jt->retainedBebanLast + $jt->retainedPendapatanLast) == null && ($jt->retainedBeban + $jt->retainedPendapatan)  < 0) { ?><?= saldo_money(($jt->retainedBeban + $jt->retainedPendapatan) ); $totalVR += ($jt->retainedBeban + $jt->retainedPendapatan) ; ?></td><?php }else{echo '0,00'; $totalVR += 0; } ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?= 'TOTAL RETAINED EARNING'?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding"><?php if ($totalCR >=0) { ?> <?= '('. saldo_money($totalCR) . ')'; $totalACP += $totalCR;?></td> <?php } else if ($totalCR < 0) { ?> <?= saldo_money($totalCR); $totalACP += $totalCR;?></td><?php } ?>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding"><?php if ($totalLR >= 0) { ?> <?= '('. saldo_money($totalLR) . ')'; $totalALP += $totalLR;?></td> <?php } else if ($totalLR < 0) { ?> <?= saldo_money($totalLR); $totalALP += $totalLR;?></td><?php } ?>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding"><?php if ($totalVR >= 0) { ?> <?= '('. saldo_money($totalVR) . ')'; $totalAVP += $totalVR;?></td> <?php } else if ($totalVR < 0) { ?> <?= saldo_money($totalVR); $totalAVP += $totalVR;?></td><?php } ?>
                                </tr>
                                <tr>
                                    <td colspan="9">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-bottom border-top-no-padding"><?= 'TOTAL ' . $jt->type_name?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding border-bottom"><?php if ($totalACP < 0 && $jt->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalACP) . ')'; $totalNeracaC += $totalACP;?></td> <?php } else if ($totalACP >= 0 && $jt->jurnal_tipe == 1) { ?> <?= saldo_money($totalACP); $totalNeracaC += $totalACP;?></td> <?php } else if ($totalACP >= 0 && $jt->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalACP) . ')'; $totalNeracaC += $totalACP;?></td> <?php } else { ?> <?= saldo_money($totalACP); $totalNeracaV += $totalACP;?></td> <?php } ?>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding border-bottom"><?php if ($totalALP < 0 && $jt->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalALP) . ')'; $totalNeracaL += $totalALP;?></td> <?php } else if ($totalALP >= 0 && $jt->jurnal_tipe == 1) { ?> <?= saldo_money($totalALP); $totalNeracaL += $totalALP;?></td> <?php } else if ($totalALP >= 0 && $jt->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalALP) . ')'; $totalNeracaL += $totalALP;?></td> <?php } else { ?> <?= saldo_money($totalALP); $totalNeracaL += $totalALP;?></td> <?php } ?>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding border-bottom"><?php if ($totalAVP < 0 && $jt->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalAVP) . ')'; $totalNeracaV += $totalAVP;?></td> <?php } else if ($totalAVP >= 0 && $jt->jurnal_tipe == 1) { ?> <?= saldo_money($totalAVP); $totalNeracaV += $totalAVP;?></td> <?php } else if ($totalAVP >= 0 && $jt->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalAVP) . ')'; $totalNeracaV += $totalAVP;?></td> <?php } else { ?> <?= saldo_money($totalAVP); $totalNeracaV += $totalAVP;?></td> <?php } ?>
                                </tr>
                            <?php
                            }else{ ?>
                                <tr>
                                    <td colspan="2" class="border-bottom border-top-no-padding"><?= 'TOTAL ' . $jt->type_name?></td>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding border-bottom"><?php if ($totalACP < 0 && $jt->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalACP) . ')'; $totalNeracaC += $totalACP;?></td> <?php } else if ($totalACP >= 0 && $jt->jurnal_tipe == 1) { ?> <?= saldo_money($totalACP); $totalNeracaC += $totalACP;?></td> <?php } else if ($totalACP >= 0 && $jt->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalACP) . ')'; $totalNeracaC += $totalACP;?></td> <?php } else { ?> <?= saldo_money($totalACP); $totalNeracaV += $totalACP;?></td> <?php } ?>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding border-bottom"><?php if ($totalALP < 0 && $jt->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalALP) . ')'; $totalNeracaL += $totalALP;?></td> <?php } else if ($totalALP >= 0 && $jt->jurnal_tipe == 1) { ?> <?= saldo_money($totalALP); $totalNeracaL += $totalALP;?></td> <?php } else if ($totalALP >= 0 && $jt->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalALP) . ')'; $totalNeracaL += $totalALP;?></td> <?php } else { ?> <?= saldo_money($totalALP); $totalNeracaL += $totalALP;?></td> <?php } ?>
                                    <td class="text-align-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-align-right border-top-no-padding border-bottom"><?php if ($totalAVP < 0 && $jt->jurnal_tipe == 1) { ?> <?= '('. saldo_money($totalAVP) . ')'; $totalNeracaV += $totalAVP;?></td> <?php } else if ($totalAVP >= 0 && $jt->jurnal_tipe == 1) { ?> <?= saldo_money($totalAVP); $totalNeracaV += $totalAVP;?></td> <?php } else if ($totalAVP >= 0 && $jt->jurnal_tipe == 4) { ?> <?= '('. saldo_money($totalAVP) . ')'; $totalNeracaV += $totalAVP;?></td> <?php } else { ?> <?= saldo_money($totalAVP); $totalNeracaV += $totalAVP;?></td> <?php } ?>
                                </tr>   
                        <?php } ?>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                </table>
    <?php endforeach; ?>
</body>

</html>
