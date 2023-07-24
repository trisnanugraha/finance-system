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
    foreach ($dataBilling as $billing) : ?>
        <table>
            <tr>
                <td style="width: 55%"></td>
                <td style="width: 45%; padding-right:8%" class="border-top border-bottom border-right border-left">
                    Unit : <span id="unit-customer"><?= $billing->unit_customer; ?></span> <br><br>
                    <b>Mr / Mrs</b><br><br>
                    <span id="name"><?= strtoupper($billing->nama_customer); ?></span><br>
                    <span id="address"><?= strtoupper($billing->alamat_customer); ?></span><br>
                    <!-- <span id="city"><b>D / C Note Date</b></span> -->
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 55%"></td>
                <td style="width: 45%;">
                    <table>
                        <tr>
                            <td style="width:45%;" class="border-left border-top border-bottom"><b>D / C Note Date</b></td>
                            <td style="width:55%;" class="border-top border-bottom border-right"><span id="dc-date"><?= toDate($billing->d_c_note_date); ?></span></td>
                        </tr>
                        <tr>
                            <td style="width:45%;" class="border-left padding-top border-bottom"><b>D / C Note No</b></td>
                            <td style="width:55%;" class="border-right padding-top border-bottom"><span id="dc-no"><?= $billing->id_billing; ?></span></td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="2">
                    <table>
                        <tr style="text-align: center;">
                            <td style="width: 20%"><b>Previous Balance<br>(Rp)</b></td>
                            <td style="width: 20%"><b>Payment<br>(Rp)</b></td>
                            <td style="width: 20%"><b>Current Month Transaction<br>(Rp)</b></td>
                            <td style="width: 20%"><b>Amount To Be Paid<br>(Rp)</b></td>
                            <td style="width: 20%"><b>Payment Due Date<br>&nbsp;</b></td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="previous-balance-Rp"><?= money($billing->total); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="payment-Rp"><?= money($billing->last); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="current-month-transaction"><?= money($billing->total_air + $billing->total_listrik + $billing->stamp); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="amount-to-be-paid"><?= money($billing->total_air + $billing->total_listrik + $billing->stamp); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left border-right"><span id="payment-due-date"><?= toLongDate($billing->due_date); ?></span></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2">
                    <table>
                        <tr style="text-align: center">
                            <td style="width: 70%;" class="border padding"><b>Invoice Summary Electricity & Water</b></td>
                            <td style="width: 30%;" class="border-top border-right border-bottom padding text-align-center"><b>AMOUNT</b></td>
                        </tr>
                        <tr>
                            <td class="border-left" style="padding-top:5px;"><b>Previous Balance</b></td>
                            <td class="border-left border-right text-align-right" style="padding-top:5px;"><span id="previous-balance"><?= money($billing->total); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top"><b>Last Payment</b></td>
                            <td class="border-left border-bottom border-right text-align-right padding-top"><span id="last-payment"><?= money($billing->last); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left" style="padding-top:5px;"><b>Total Previous Balance</b></td>
                            <td class="border-left border-right text-align-right" style="padding-top:5px;"><span id="total-previous-balance"><?= money($billing->previous); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top"><b>Current Balance Period</b> <span id="period" style="margin-left: 25px"><?= date('d-M-Y', strtotime($billing->start_periode)) . ' TO ' .  date('d-M-Y', strtotime($billing->end_periode)); ?></span></td>
                            <td class="border-left border-right padding-top">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top"><b>Billing</b></td>
                            <td class="border-left border-right padding-top">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top">
                                <table>
                                    <tr>
                                        <td style="width:30%;"></td>
                                        <td style="width:70%;" class="padding-bottom">
                                            Electricity
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"></td>
                                        <td style="width:70%;">
                                            Water
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-left border-right padding-top border-bottom">
                                <table class="text-align-right">
                                    <tr>
                                        <td class="padding-bottom">
                                            <span id="total-electricity"><?= money($billing->total_listrik); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span id="total-water"><?= money($billing->total_air); ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="2" style="border:1px solid black"></td>
                        </tr> -->
                        <tr>
                            <td class="border-left padding-top"><b>Grand Total Electricity & Water</b></td>
                            <td class="border-left border-right padding-top text-align-right"><span id="grand-total"><?= money(($billing->total_air + $billing->total_listrik)); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left padding-top"><b>Stamp Duty</b></td>
                            <td class="border-left border-right padding-top text-align-right"><span id="stamp"><?= money($billing->stamp); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left padding-top"><b>Total Current Balanced</b></td>
                            <td class="border-left border-right padding-top text-align-right"><span id="total-current"><?= money($billing->total_air + $billing->total_listrik + $billing->stamp); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top"><b>Pinalty From The Previous Month</b></td>
                            <td class="border-left border-bottom border-right padding-top text-align-right"><span id="pinalty"><?= money(round($billing->previous * 3 / 100)); ?></span></td>
                        </tr>
                        <tr class="text-align-right">
                            <td class="border-left border-bottom padding-right" style="padding-top: 5px; padding-bottom:5px;"><b>TOTAL AMOUNT DUE</b></td>
                            <td class="border-left border-bottom border-right text-align-right" style="padding-top: 5px; padding-bottom:5px;"><span id="total-amount-due"><?= money(round($billing->total_air + $billing->total_listrik + $billing->stamp + $billing->previous * 3 / 100 + $billing->previous)); ?></span></td>
                        </tr>
                        <tr>
                            <td class="padding-top padding-left text-valign-top padding-bottom">In Word &nbsp;&nbsp;&nbsp;&nbsp;: <span id="in-word"><?= ucwords(number_to_words_rupiah(($billing->total_air + $billing->total_listrik + $billing->stamp + $billing->previous * 3 / 100 + $billing->previous))) ?></span></td>
                            <td class="padding-top padding-right text-align-center padding-bottom" style="padding-left: 3%; padding-right: 3%;">
                                Authorized Signature
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span id="authorized-sign"><?= strtoupper($signature->param1); ?></span>
                                <hr>
                                <span id="authorized-role"><?= ucwords($signature->param2); ?></span>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td class="border padding-left padding-right" colspan="2" style="padding-top: 5px; padding-bottom:5px;">
                                Please pay to your BCA Virtual Account with Beneficiary Name : <span id="virtual-account-name"><?= strtoupper($billing->nama_customer); ?></span>
                                <ol type="1">
<!--                                     <li>Through Automatic Teller Machine (ATM) of Bank Central Asia (BCA) by Choosing transfer menu to your BCA Virtual Account for <span id="virtual-account-number"><?= $billing->kode_virtual; ?></span></li>
                                    <li>Through transfer by cashform Bank Central Asia (BCA) to your BCA Virtual Account for <span id="virtual-account-number"><?= $billing->kode_virtual; ?></span></li> -->
                                    <li>Transfer to Account : PERHIMPUNAN PENGHUNI SCBD SUITES at ARTHA GRAHA A/C: 008-1-28286-2</li>
                                </ol>
                                <b>You will be charged <u>3%</u> from The Previous Bill if your payment exceeds the due date.</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top: 5px; padding-bottom:5px;" class="padding-left padding-right"></td>
                        </tr>
                        <tr>
                            <td class="border padding-left padding-right" colspan="2" style="padding-top: 5px; padding-bottom:5px;">For important operational building and for our service, please do the payment before due date.</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="page_break"></div>

        <br>
        <br>
        <br>
        <p style="font-size: 13pt; text-align: center;"><strong>CALCULATION UTILITIES CONSUMPTION</strong></p>
        <br>
        <br>
        <br>
        <?php if ($billing->mulai != $billing->akhir) { ?>
            Periode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="periode"><?= date('d/m/Y', strtotime($billing->start_periode)) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .  date('d/m/Y', strtotime($billing->end_periode)) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $billing->amount_days . '  Days'; ?></span>
            <br>
        <?php } else { ?>
            Periode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="periode"><?= date('d/m/Y', strtotime($billing->start_periode)) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .  date('d/m/Y', strtotime($billing->end_periode)) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30 Days"; ?></span>
            <br>
        <?php } ?>

        Due Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="due-date"><?= date('d/m/Y', strtotime($billing->due_date)); ?></span>
        <br>
        <br>
        <table>
            <tr>
                <td class="border-top border-left border-bottom">Invoice No : <span class="invoice-no"><?= $billing->id_billing; ?></span></td>
                <td class="border-top border-bottom">Tenant Unit : <span class="invoice-no"><?= $billing->unit_customer; ?></span></td>
                <td class="border-top border-right border-bottom">Tenant Name : <span class="customer-name"><?= $billing->nama_customer; ?></span></td>
            </tr>
        </table>

        <br>
        <table>
            <tr>
                <td colspan="9"><strong>WATER</strong></td>
            </tr>
            <tr>
                <td>Start Meter</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="start-meter-water"><?= $billing->start_meter_air; ?></span></td>
                            <td style="width: 50%">M<sup>3</sup></td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>End Meter</td>
                <td>:</td>
                <td class="border-bottom-no-padding">
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="end-meter-water"><?= $billing->end_meter_air; ?></span></td>
                            <td style="width: 50%">M<sup>3</sup></td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>Unit Consumption</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="consumption-water"><?= $billing->cons_air; ?></span></td>
                            <td style="width: 50%">M<sup>3</sup></td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>Consumption Charge</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="consumption-water"><?= $billing->cons_air; ?></span></td>
                            <td style="width: 50%">M<sup>3</sup></td>
                        </tr>
                    </table>
                </td>
                <td class="text-align-center">x</td>
                <td>Rp</td>
                <td><?= money($billing->tarif_air); ?></td>
                <td class="text-align-center">=</td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->consumption_air); ?></td>
            </tr>
            <tr>
                <td colspan="7">Standing Charge</td>
                <td class="border-bottom-no-padding">Rp</td>
                <td class="border-bottom-no-padding text-align-right"><?= money($billing->standing_charge); ?></td>
            </tr>
            <tr>
                <td colspan="7">&nbsp;</td>
                <td>Rp</td>
                <?php
                $tempAir = $billing->standing_charge + $billing->consumption_air;
                ?>
                <td class="text-align-right"><?= money($tempAir); ?></td>
            </tr>
            <tr>
                <td>Regional Operation Costs</td>
                <td>:</td>
                <td class="text-align-center">10.00%</td>
                <td class="text-align-center">x</td>
                <td>Rp</td>
                <td><?= money($tempAir); ?></td>
                <td class="text-align-center">=</td>
                <td class="border-bottom-no-padding">Rp</td>
                <td class="text-align-right border-bottom-no-padding"><?= money($billing->tax_area); ?></td>
            </tr>

            <tr>
                <td colspan="7">&nbsp;</td>
                <td>Rp</td>
                <?php
                $tempAir2 = $billing->tax_area + $tempAir;
                ?>
                <td class="text-align-right"><?= money($tempAir2); ?></td>
            </tr>

            <tr>
                <td>Operation Costs</td>
                <td>:</td>
                <td class="text-align-center">10.00%</td>
                <td class="text-align-center">x</td>
                <td>Rp</td>
                <td><?= money($tempAir2); ?></td>
                <td class="text-align-center">=</td>
                <td class="border-bottom-no-padding">Rp</td>
                <td class="text-align-right border-bottom-no-padding"><?= money($billing->tax) ?></td>
            </tr>
            <tr>
                <td colspan="7">Total</td>
                <td>Rp</td>
                <td class="text-align-right"><?php if ($billing->mulai != $billing->akhir) { ?><?= money($billing->prorate_air); ?><?php } else { ?><?= money($billing->total_air);
                                                                                                                                                } ?></td>
            </tr>

            <!-- <tr>
                <?php if ($billing->mulai != $billing->akhir) { ?>
                    <td>Prorate</td>
                    <td>:</td>
                    <td class="text-align-center">Rp <?= money($billing->prorate_air); ?></td>
                    <td class="text-align-center">x</td>
                    <td><?= $billing->amount_days; ?></td>
                    <td>/ 30</td>
                    <td class="text-align-center">=</td>
                    <td>Rp</td>
                    <td class="text-align-right"><?= money($billing->total_air) ?></td>
                <?php } else { ?>
                <?php } ?>
            </tr> -->

            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="9"><strong>ELECTRICITY</strong></td>
            </tr>

            <tr>
                <td>Electricity Capacity</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="electricity-capacity"><?= $billing->kapasitas; ?></span></td>
                            <td style="width: 50%">kVA</td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td>Electricity Tariff</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="electricity-tariff"><?= money($billing->tarif_listrik); ?></span></td>
                            <td style="width: 50%">kWH</td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td>Minimum Usage Hours</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="minimum-usage">40</span></td>
                            <td style="width: 50%">Usage Hours</td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="5">Minimum Electricity Usages (Electricity Capacity x Minimum Usage Hours)</td>
                <?php $minimumUsageHours = 40 * $billing->kapasitas; ?>
                <td class="text-align-right padding-right" colspan="2"><span class="minimum-usage"><?= money($minimumUsageHours); ?></span></td>
                <td colspan="2">Usage Hours</td>
            </tr>

            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>

            <tr>
                <td>Start Meter</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="start-meter-electricity"><?= $billing->start_meter_listrik; ?></span></td>
                            <td style="width: 50%">KWH</sup></td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>End Meter</td>
                <td>:</td>
                <td class="border-bottom-no-padding">
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="end-meter-electricity"><?= $billing->end_meter_listrik; ?></span></td>
                            <td style="width: 50%">KWH</sup></td>
                        </tr>
                    </table>
                </td>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>Unit Consumed</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="consumption-charge-electricity"><?= $billing->cons_listrik; ?></span></td>
                            <td style="width: 50%">KWH</td>
                        </tr>
                    </table>
                </td>
                <td colspan="6" class="padding-left">(Unit Consumed noted <span id="more-than-minimum"><strong><?= ($billing->cons_listrik > $minimumUsageHours) ? "more than" : "less than"; ?></strong></span> Min. Electricity Usages)</td>
            </tr>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr>
                <td>Consumption Charge</td>
                <td>:</td>
                <td>
                    <table>
                        <tr>
                            <td style="width: 50%" class="text-align-right padding-right"><span class="consumption-charge-electricity"><?= ($billing->cons_listrik > $minimumUsageHours) ? $billing->cons_listrik : $minimumUsageHours; ?></span></td>
                            <td style="width: 50%">KWH</td>
                        </tr>
                    </table>
                </td>
                <td class="text-align-center">x</td>
                <td>Rp</td>
                <td><?= money($billing->tarif_listrik); ?></td>
                <td class="text-align-center">=</td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->consumption_listrik); ?></td>
            </tr>
            <tr>
                <td>Retribution Charge (PPJU)</td>
                <td>:</td>
                <td class="text-align-center">3.00%</td>
                <td class="text-align-center">x</td>
                <td>Rp</td>
                <td><?= money($billing->consumption_listrik); ?></td>
                <td class="text-align-center">=</td>
                <td class="border-bottom-no-padding">Rp</td>
                <td class="text-align-right border-bottom-no-padding"><?= money($billing->ppju); ?></td>
            </tr>
            <tr>
                <td colspan="7">Total</td>
                <td>Rp</td>
                <td class="text-align-right"><?php if ($billing->mulai != $billing->akhir) { ?><?= money($billing->prorate_listrik); ?><?php } else { ?><?= money($billing->total_listrik);
                                                                                                                                                    } ?></td>
            </tr>

            <tr>
                <?php if ($billing->mulai != $billing->akhir) { ?>
                    <td>Prorate</td>
                    <td>:</td>
                    <td class="text-align-center">Rp <?= money($billing->prorate_listrik); ?></td>
                    <td class="text-align-center">x</td>
                    <td><?= $billing->amount_days; ?></td>
                    <td>/ 30</td>
                    <td class="text-align-center">=</td>
                    <td>Rp</td>
                    <td class="text-align-right"><?= money($billing->total_listrik) ?></td>
                <?php } else { ?>
                <?php } ?>
            </tr>

            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="7"><b>Grand Total Electricity & Water</b></td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->total_air + $billing->total_listrik) ?></td>
            </tr>
            <tr>
                <td colspan="7"><b>Stamp Duty</b></td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->stamp); ?></td>
            </tr>
            <!--             <tr>
                <td colspan="7"><b>Total Previous Balance</b></td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->previous); ?></td>
            </tr> -->
            <tr>
                <td colspan="7"><b>Total Current Balance</b></td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->total_air + $billing->total_listrik + $billing->stamp); ?></td>
                <!-- <td class="text-align-right"><?= money($billing->total_air + $billing->total_listrik + $billing->stamp + $billing->previous); ?></td> -->
            </tr>
            <!--             <tr>
                <td colspan="7"><b>Pinalty From The Previous Month</b></td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->previous * 3 / 100); ?></td>
            </tr> -->
            <!--             <tr>
                <td colspan="7"><b>Total Billing</b></td>
                <td>Rp</td>
                <td class="text-align-right"><?= money($billing->total_air + $billing->total_listrik + $billing->stamp + $billing->previous * 3 / 100 + $billing->previous); ?></td>
            </tr> -->
        </table>

        <?php $x++;

        if ($x < count($dataBilling)) {
            echo '<div class="page_break"></div>';
        } ?>

    <?php endforeach; ?>
</body>

</html>
