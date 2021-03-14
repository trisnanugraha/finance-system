<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once("./vendor/dompdf/dompdf/src/Autoloader.php");
use Dompdf\Dompdf;

class Pdf_landscape
{
    public function generate($html, $filename)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [280, 215]]);
        $mpdf->shrink_tables_to_fit = 0;
        $mpdf->SetHTMLFooter(
            '<table width="100%">
                <tr>
                    <td width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename . ".pdf", I);
    }
}
