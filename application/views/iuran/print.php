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
    foreach ($dataIuran as $sc) : ?>
        <table>
            <tr>
                <td style="width: 55%"></td>
                <td style="width: 45%; padding-right:8%" class="border-top border-bottom border-right border-left">
                    Unit : <span id="unit-owner"><?= $sc->unit_owner; ?></span> <br><br>
                    <b>Mr / Mrs</b><br><br>
                    <span id="name"><?= strtoupper($sc->nama_owner); ?></span><br>
                    <span id="address"><?= strtoupper($sc->alamat_owner); ?></span><br>
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
                            <td style="width:55%;" class="border-top border-bottom border-right"><span id="dc-date"><?= toDate($sc->periodStart); ?></span></td>
                        </tr>
                        <tr>
                            <td style="width:45%;" class="border-left padding-top border-bottom"><b>D / C Note No</b></td>
                            <td style="width:55%;" class="border-right padding-top border-bottom"><span id="dc-no"><?= $sc->id_iuran; ?></span></td>
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
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="previous-balance-Rp"><?= money($sc->totalp); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="payment-Rp"><?= money($sc->last); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="current-month-transaction"><?= money($sc->sinking_fund + $sc->service_charge + $sc->stamp); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left"><span id="amount-to-be-paid"><?= money($sc->sinking_fund + $sc->service_charge + $sc->stamp); ?></span></td>
                            <td style="padding:4px;" class="border-top border-bottom border-left border-right"><span id="payment-due-date"><?= toLongDate($sc->dueDate); ?></span></td>
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
                            <td style="width: 70%;" class="border padding"><b>Invoice Summary Building Insurance</b></td>
                            <td style="width: 30%;" class="border-top border-right border-bottom padding text-align-center"><b>AMOUNT</b></td>
                        </tr>
                        <tr>
                            <td class="border-left" style="padding-top:5px;"><b>Previous Balance</b></td>
                            <td class="border-left border-right text-align-right" style="padding-top:5px;"><span id="previous-balance"><?= money($sc->totalp); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top"><b>Last Payment</b></td>
                            <td class="border-left border-bottom border-right text-align-right padding-top"><span id="last-payment"><?= money($sc->last); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left" style="padding-top:5px;"><b>Total Previous Balance</b></td>
                            <td class="border-left border-right text-align-right" style="padding-top:5px;"><span id="total-previous-balance"><?= money($sc->previous); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top"><b>Current Balance Period</b> <span id="period" style="margin-left: 25px"><?= date('d-M-Y', strtotime($sc->periodStart)) . ' to ' .  date('d-M-Y', strtotime($sc->periodEnd)); ?></span></td>
                            <td class="border-left border-right padding-top">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top">
                                <table>
                                    <tr>
                                        <td><b>Billing</b></td>
                                        <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                                        <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                                        <td class="" ><b>SQM</b></td>
                                    </tr>    
                                </table>
                            </td>
                            <td class="border-left border-right padding-top">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top">
                                <table>
                                    <tr>
                                        <td><b>Iuran Pengelolaan Kawasan</b></td>
                                        <td><?=$sc->sqm?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-left border-right padding-top border-bottom">
                                <table class="text-align-right">
                                    <tr>
                                        <td class="padding-bottom">
                                            <span id="total-electricity"><?= money($sc->service_charge); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span id="total-water"><?= money($sc->sinking_fund); ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="2" style="border:1px solid black"></td>
                        </tr> -->
                        <tr>
                            <td class="border-left padding-top"><b>Grand Total Iuran Pengelolaan Kawasan</b></td>
                            <td class="border-left border-right padding-top text-align-right"><span id="grand-total"><?= money($sc->total_iuran); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left padding-top"><b>Stamp Duty</b></td>
                            <td class="border-left border-right padding-top text-align-right"><span id="stamp"><?= money($sc->stamp); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left padding-top"><b>Total Current Balanced</b></td>
                            <td class="border-left border-right padding-top text-align-right"><span id="total-current"><?= money($sc->service_charge + $sc->sinking_fund + $sc->stamp); ?></span></td>
                        </tr>
                        <tr>
                            <td class="border-left border-bottom padding-top"><b>Pinalty From The Previous Period</b></td>
                            <td class="border-left border-bottom border-right padding-top text-align-right"><span id="pinalty"><?= money(round($sc->previous * 3 / 100)); ?></span></td>
                        </tr>
                        <tr class="text-align-right">
                            <td class="border-left border-bottom padding-right" style="padding-top: 5px; padding-bottom:5px;"><b>TOTAL AMOUNT DUE</b></td>
                            <td class="border-left border-bottom border-right text-align-right" style="padding-top: 5px; padding-bottom:5px;"><span id="total-amount-due"><?= money(round($sc->total_iuran + $sc->previous + $sc->previous * 3 / 100)); ?></span></td>
                        </tr>
                        <tr>
                            <td class="padding-top padding-left text-valign-top padding-bottom">In Word &nbsp;&nbsp;&nbsp;&nbsp;: <span id="in-word"><?= ucwords(number_to_words_rupiah(($sc->total_iuran + $sc->previous + $sc->previous * 3 / 100))) ?></span></td>
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
                                Please pay to yout BCA Virtual Account with Beneficiary Name : <span id="virtual-account-name"><?= strtoupper($sc->nama_owner); ?></span>
                                <ol type="1">
                                    <li>Through Automatic Teller Machine (ATM) of Bank Central Asia (BCA) by Choosing transfer menu to your BCA Virtual Account for <span id="virtual-account-number"><?= $sc->kode_virtual; ?></span></li>
                                    <li>Through transfer by cashform Bank Central Asia (BCA) to your BCA Virtual Account for <span id="virtual-account-number"><?= $sc->kode_virtual; ?></span></li>
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

        <?php $x++;

        if ($x < count($dataIuran)) {
            echo '<div class="page_break"></div>';
        } ?>

    <?php endforeach; ?>
</body>

</html>
