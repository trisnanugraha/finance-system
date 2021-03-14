<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once("./vendor/dompdf/dompdf/src/Autoloader.php");
use Dompdf\Dompdf;

class Pdf_setengah2
{
    public function generate($html, $filename)
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 'format' => [215, 140],
            'margin_left' => 5,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 5,
            'margin_header' => 10,
            'margin_footer' => 5
        ]);
        $mpdf->shrink_tables_to_fit = 0;
        $mpdf->SetHTMLHeader(
            '<table width="100%">
                                <tr>
                                    <td align="right">Page {PAGENO} of {nbpg}</td>
                                </tr>
                            </table>'
        );
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename . ".pdf", I);
    }
}
