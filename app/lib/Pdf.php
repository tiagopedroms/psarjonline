<?php

namespace App\Lib;

use TCPDF;

class Pdf
{
    public static function fromHtml(string $title, string $html): void
    {
        $pdf = new TCPDF();
        $pdf->SetCreator('PSARJ Online');
        $pdf->SetAuthor('Paróquia Santo Agostinho e Santa Rita de Cássia');
        $pdf->SetTitle($title);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($title . '.pdf', 'I');
        exit;
    }
}
