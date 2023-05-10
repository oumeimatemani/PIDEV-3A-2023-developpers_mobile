<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

class PdfService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html, $filename)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $output = $this->domPdf->output();

        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }


    public function generateBinaryPDF($html, $filename)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        file_put_contents($filename, $this->domPdf->output());
    }
}
