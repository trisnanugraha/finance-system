<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once("./vendor/dompdf/dompdf/src/Autoloader.php");
use Dompdf\Dompdf;

class Pdf_setengah
{
    public function generate($html, $filename)
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 'format' => [215, 280],
            'margin_left' => 5,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 5,
            'margin_header' => 10,
            'margin_footer' => 5
        ]);
        $mpdf->shrink_tables_to_fit = 0;
        $mpdf->SetHTMLHeader(
            '<table width="100%">
                                <tr>
                                    <td style="width: 80%; font-size: 10pt;"><span>Bulding Management SCBD-Suites</span></td>
                                    <td width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%; font-size: 10pt;"><span>Jln Jendral Sudirman Kav. 52-53 Jakarta 12190</span></td>
                                </tr>
                            </table>'
        );
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename . ".pdf", \Mpdf\Output\Destination::INLINE);
    }
}
