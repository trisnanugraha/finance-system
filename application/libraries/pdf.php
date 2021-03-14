<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once("./vendor/dompdf/dompdf/src/Autoloader.php");
use Dompdf\Dompdf;

class Pdf
{
    public function generate($html, $filename)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215, 280]]);
        $mpdf->shrink_tables_to_fit = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename . ".pdf", I);
    }
}
