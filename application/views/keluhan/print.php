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
            <td style="font-size: 11pt; text-align: center;"><span><strong>Building Management SCBD-Suites</strong></span></td>
        </tr>
        <tr>
            <td style="font-size: 11pt; text-align: center;"><span><strong>Data Keluhan</strong></span></td>
        </tr>
        <tr>
            <td style="font-size: 11pt; text-align: center;"><span><strong><?= date('d F Y', strtotime($dateA)) . ' - ' .  date('d F Y', strtotime($dateB)); ?></strong></span></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 15%; font-size: 10pt; " class="border-left border-right border-top border-bottom text-align-center padding">Kode Keluhan</td>
            <td style="width: 15%; font-size: 10pt; " class="border-right border-top border-bottom text-align-center padding">Pelapor</td>
            <td style="width: 15%; font-size: 10pt; " class="border-right border-top border-bottom text-align-center padding">Status Keluhan</td>
            <td style="width: 30%; font-size: 10pt; " class="border-right border-top border-bottom text-align-center padding">Keluhan</td>
            <td style="width: 30%; font-size: 10pt; " class="border-right border-top border-bottom text-align-center padding">Penyebab Keluhan</td>
            <td style="width: 30%; font-size: 10pt; " class="border-right border-top border-bottom text-align-center padding">Tindakan Perbaikan</td>
        </tr>
        <?php foreach ($dataKeluhan as $keluhan) :
            if ($keluhan->status == 0) { ?>
                <tr>
                    <td style="font-size: 10pt; " class="border-left border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->kode_keluhan; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->nama; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= 'Belum Ditindak Lanjuti'; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->uraian; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->penyebab; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= '~'; ?></span></td>
                </tr>
            <?php } else if ($keluhan->status == 1) { ?>
                <tr>
                    <td style="font-size: 10pt; " class="border-left border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->kode_keluhan; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->nama; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= 'Selesai Ditindak Lanjuti'; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->uraian; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->penyebab; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->tindakan; ?></span></td>
                </tr>
            <?php } else { ?>

                <tr>
                    <td style="font-size: 10pt; " class="border-left border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->kode_keluhan; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->nama; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= 'Pending'; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->uraian; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->penyebab; ?></span></td>
                    <td style="font-size: 10pt; " class="border-right border-bottom text-align-center padding"><span id="id"><?= $keluhan->pending; ?></span></td>
                </tr>

            <?php } ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>
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
    </table>
</body>

</html>