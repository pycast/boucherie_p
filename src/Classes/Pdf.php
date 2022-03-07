<?php

namespace App\Classes;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Times New Roman');

        $this->dompdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html, $pdfname) {
        $this->dompdf->loadHtml($html);

        $this->dompdf->render();

        $this->dompdf->stream($pdfname . ".pdf", [
            'Attachement' => false
        ]);
    }

    public function generateBinaryPdf($html) {
        $this->dompdf->loadHtml($html);

        $this->dompdf->render();

        $this->dompdf->output();
    }
}