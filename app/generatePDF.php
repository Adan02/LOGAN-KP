<?php

namespace App;

use Codedge\Fpdf\Fpdf\Fpdf;

class generatePDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image(base_path('public\img\telkom.png'), 15, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // garis tebal
        $this->Ln(18);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(5);
        // $this->Cell(50);
        // $this->Cell(30, 10, 'BERITA ACARA KELUAR MASUK BARANG', 'C');
        // $this->SetLineWidth(1);
        // $this->Line(61, 36, 149, 36);
        // Line break5

    }
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}