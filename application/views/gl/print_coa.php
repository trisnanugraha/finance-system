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
    foreach ($dataCoA as $coa) : ?>
        <p class="text-align-right"><?= 'Tgl : ' . date("d-m-Y"); ?></p>
        <p style="font-size: 16pt; text-align: center;"><strong>BUKU BESAR</strong></p>
        <p style="text-align: center"><?= 'Untuk Bulan : ' . date('F', strtotime($dateA)) . ' s/d ' . date('F Y', strtotime($dateB)); ?></p>
        KODE REKENING &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kode-rekening"><?= $coa->coa_id . "&nbsp;&nbsp;&nbsp;&nbsp;" .  $coa->coa_name; ?></span>
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

            <tr>
                <td></td>
                <td></td>
                <td>SALDO AWAL </td>
                <td>0,00</td>
                <td>0,00</td>
                <td>0,00</td>
            </tr>
            
                    
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>0,00</td>
                <td>0,00</td>
                <td>0,00</td>
            </tr>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>

            <tr>
                <td class="border-top border-bottom">TOTAL :</td>
                <td class="border-top border-bottom"></td>
                <td class="border-top border-bottom"></td>
                <td class="border-top border-bottom">0,00</td>
                <td class="border-top border-bottom">0,00</td>
                <td class="border-top border-bottom">0,00</td>
            </tr>

        </table>

        <?php $x++;

        if ($x < count($dataGL)) {
            echo '<div class="page_break"></div>';
        } ?>
    <?php endforeach; ?>
</body>

</html>