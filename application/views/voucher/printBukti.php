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
    foreach ($dataVoucher as $vou) : ?>
        <table>
            <tr>
                <td style="width: 70%"><b style="font-size: 11pt">Building Management SCBD Suites</b></td>
                <td style="width : 30%;"></td>
            </tr>
            <tr>
                <td><b style="font-size: 11pt">Jln Jendral Sudirman Kav. 52-53 Jakarta 12190</b></td>
                <td></td>
            </tr>
            <tr>
                <td><b style="font-size: 11pt">Jakarta</b></td>
                <td></td>
            </tr>
            <?php if($vou->so != 3){ ?>
                <tr>
                    <td></td>
                    <td style="padding-right:1%"><b style="font-size: 11pt">OFFICIAL RECEIPT</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td><span>BUKTI TRANSFER PENERIMAAN</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>NO  :  </b><span id="bukti"><?= strtoupper($vou->bukti_transaksi); ?></span></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td></td>
                    <td style="padding-right:1%"><b style="font-size: 11pt">OFFICIAL RECEIPT</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td><span>BUKTI TRANSFER PENGELUARAN</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>NO  :  </b><span id="bukti"><?= strtoupper($vou->bukti_transaksi); ?></span></td>
                </tr>
            <?php } ?>
            <tr>
               <td colspan="2" class="border-bottom-no-padding"></td>
            </tr>
        </table>
        <table>
            <?php 
                if($vou->so == 1) { 
                    ?>
                        <tr>
                            <td style="width: 20%"><b>Received From </b></td>
                            <td style="width: 1%"></td>
                            <td style="width: 40%"><span id="nama_customer"><?= strtoupper($vou->nama_customer); ?></span></td>
                            <td style="width: 9%"></td>
                            <td style="width: 30%"><b>DATE : </b><span id="tanggal_transaksi_cus"><?= date('d-m-Y', strtotime($vou->tanggal_voucher)); ?></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><span id="alamat_customer"><?= strtoupper($vou->alamat_customer); ?></span></td>
                            <td></td>
                            <td><b>Customer Code : </b><span id="kode_customer"><?= strtoupper($vou->id_customer); ?></span></td>
                        </tr>
                    <?php 
                } else if ($vou->so == 0) { 
                    ?>
                        <tr>
                            <td style="width: 20%"><b>Received From </b></td>
                            <td style="width: 1%"></td>
                            <td style="width: 40%"><span id="nama_owner"><?= strtoupper($vou->nama_owner); ?></span></td>
                            <td style="width: 9%"></td>
                            <td style="width: 30%"><b>DATE : </b><span id="tanggal_transaksi_own"><?= date('d-m-Y', strtotime($vou->tanggal_voucher)); ?></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><span id="alamat_owner"><?= strtoupper($vou->alamat_owner); ?></span></td>
                            <td></td>
                            <td><b>Owner Code : </b><span id="kode_owner"><?= strtoupper($vou->id_owner); ?></span></td>
                        </tr>
                    <?php 
                } else if ($vou->so == 2) { 
                    ?>
                        <tr>
                            <td style="width: 20%"><b>Received From </b></td>
                            <td style="width: 1%"></td>
                            <td style="width: 40%"><span id="nama_owner"><?= strtoupper($vou->nama_owner); ?></span></td>
                            <td style="width: 9%"></td>
                            <td style="width: 30%"><b>DATE : </b><span id="tanggal_transaksi_own"><?= date('d-m-Y', strtotime($vou->tanggal_voucher)); ?></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><span id="alamat_owner"><?= strtoupper($vou->alamat_owner); ?></span></td>
                            <td></td>
                            <td><b>Owner Code : </b><span id="kode_owner"><?= strtoupper($vou->id_owner); ?></span></td>
                        </tr>
                    <?php 
                } else { 
                    ?>
                        <tr>
                            <td style="width: 20%"><b>Received From </b></td>
                            <td style="width: 1%"></td>
                            <td style="width: 40%"><span id="nama"><?= $vou->relasi ?></span></td>
                            <td style="width: 9%"></td>
                            <td style="width: 30%"><b>DATE : </b><span id="tanggal_transaksi"><?= date('d-m-Y', strtotime($vou->tanggal_voucher)); ?></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><span id="alamat"><?= "-" ?></span></td>
                            <td></td>
                            <td><b>Code : </b><span id="kode"><?= "Vendor" ?></span></td>
                        </tr>
                    <?php
                }
            ?>
            
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <?php if($vou->so != 3) { ?>
                <tr>
                    <td><b>The Sum </b></td>
                    <td></td>
                    <td><span id="in-word"><?= '#'. ucwords(number_to_words_rupiah(($vou->total))) . '#' ?></span></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td><b>The Sum </b></td>
                    <td></td>
                    <td><span id="in-word"><?= '#'. ucwords(number_to_words_rupiah(($vou->total))) . '#' ?></span></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>
            
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <tr>
                <td><b>Being Payment </b></td>
                <td></td>
                <td><?= $vou->keterangan ?></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>

            <?php if($vou->so != 3 ) {?>
                <tr>
                    <td><b>IDR </b></td>
                    <td></td>
                    <td><span id="in-word"><?= money($vou->total) ?></span></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php }else {?>
                <tr>
                    <td><b>IDR </b></td>
                    <td></td>
                    <td><span id="in-word"><?= money($vou->total) ?></span></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>

            <?php if($vou->so != 3){ ?> 
                <tr>
                    <td><b>Cheque No </b></td>
                    <td></td>
                    <td> <?= 'AG' . $vou->unit_customer . '%;'?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td><b>Cheque No </b></td>
                    <td></td>
                    <td> <?= 'AGVendor%;'?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-align-right"><b>SA</b></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-align-right"><b>Jakarta</b></td>
                <td></td>
            </tr>
            
        </table>
    <?php endforeach; ?>
</body>

</html>
