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
    $totalD = 0;
    $totalK = 0;
    foreach ($dataVoucher as $vou) : ?>

        <?php
        if ($vou->so != 3) {
            $x = 0;
            foreach ($dataBayar as $bayar) {
                if ($bayar->id_voucher == $vou->id_voucher) { ?>
                    <table>
                        <tr>
                            <td rowspan="2" style="width: 13%; font-size: 9pt; " class="border-left border-right border-right border-bottom-no-padding text-align-center"><span id="kode_coa"><?= $bayar->coa_id; ?></span></td>
                            <td style="width: 50%; ont-size: 9pt;" class="border-right padding-left"><span id="kode_name"><?= $bayar->coa_name; ?></span></td>
                            <td rowspan="2" style="width: 12%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center"><span id="kode_cash"><?php if ($bayar->cf == 1) { ?><?= $bayar->coa_id . 'A'; ?></span></td><?php } else { ?><?= $bayar->coa_id;
                                                                                                                                                                                                                                                            } ?></span></td>
                            <td rowspan="2" style="width: 5%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center">Rp</td>
                            <td rowspan="2" style="width: 15%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center"><span id="debit"><?= money($bayar->debit);
                                                                                                                                                                    $totalD += $bayar->debit; ?></span></td>
                            <td rowspan="2" style="width: 15%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center"><span id="kredit"><?= money($bayar->credit);
                                                                                                                                                                    $totalK += $bayar->credit; ?></span></td>
                        </tr>
                        <tr>
                            <td style="font-size: 9pt;" class="border-right padding-left border-bottom-no-padding"><span id="keterangan"><?= $bayar->keterangan; ?></span></td>
                        </tr>
                    </table>
                <?php } ?>

                <?php $x++;

                if ($x % 4 === 0) {
                    echo '<pagebreak />';
                } ?>

                <?php }
        } else {
            $x = 0;
            foreach ($dataVendor as $vendor) {
                if ($vendor->id_voucher == $vou->id_voucher) { ?>
                    <table>
                        <tr>
                            <td rowspan="2" style="width: 13%; font-size: 9pt; " class="border-left border-right border-bottom-no-padding text-align-center"><span id="kode_coa"><?= $vendor->coa_id; ?></span></td>
                            <td style="width: 50%; font-size: 9pt;" class="border-right padding-left"><span id="kode_name"><?= $vendor->coa_name; ?></span></td>
                            <td rowspan="2" style="width: 12%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center"><span id="kode_cash"><?php if ($vendor->cf == 1) { ?><?= $vendor->coa_id . 'A'; ?></span></td><?php } else { ?><?= $vendor->coa_id;
                                                                                                                                                                                                                                                            } ?></span></td>
                            <td rowspan="2" style="width: 5%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center">Rp</td>
                            <td rowspan="2" style="width: 15%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center"><span id="debit"><?php if ($vendor->debit > 0) { ?><?= money($vendor->debit);
                                                                                                                                                                                                    $totalD += $vendor->debit; ?></span></td><?php } else { ?> <?php } ?></span></td>
                        <td rowspan="2" style="width: 15%; font-size: 9pt; " class="border-right border-bottom-no-padding text-align-center"><span id="kredit"><?php if ($vendor->credit > 0) { ?><?= money($vendor->credit);
                                                                                                                                                                                                    $totalK += $vendor->credit; ?></span></td><?php } else { ?> <?php } ?></span></td>
                        </tr>
                        <tr>
                            <td style="font-size: 9pt;" class="border-right padding-left border-bottom-no-padding"><span id="keterangan"><?= $vendor->keterangan; ?></span></td>
                        </tr>
                    </table>
                <?php } ?>

                <?php $x++;

                if ($x % 4 === 0) {
                    echo '<pagebreak />';
                } ?>

        <?php }
        }
        ?>


    <?php endforeach; ?>
</body>

</html>