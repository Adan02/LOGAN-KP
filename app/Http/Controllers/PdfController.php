<?php

namespace App\Http\Controllers;

use App\Models\Sfp;
use App\Models\Modul;
use App\Models\BKeluar;
use App\Models\Patchcord;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index() 
    {
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage("L", ['100', '100']);
        $this->fpdf->Text(10, 10, "Hello World!");       

        $this->fpdf->Output();

        exit;
    }

    public function makePDF($id){
        // dd($data);
        if(isset($data['Patchcord_ids'])){
            $Patchcord=Patchcord::whereIn('id', $data['Patchcord_ids'])
            ->orderByRaw("FIELD(id, " . implode(",", $data['Patchcord_ids']) . ")")
            ->get();
        }
        if(isset($data['SFP_ids'])){
            $SFP=Sfp::whereIn('id', $data['SFP_ids'])
            ->orderByRaw("FIELD(id, " . implode(",", $data['SFP_ids']) . ")")
            ->get();
        }
        if(isset($data['Modul_ids'])){
            $Modul=Modul::whereIn('id', $data['Modul_ids'])
            ->orderByRaw("FIELD(id, " . implode(",", $data['Modul_ids']) . ")")
            ->get();
        }

        $buatpdf = new FpdF();
        $buatpdf->AliasNbPages();
        $buatpdf->AddPage();
        $buatpdf->Ln(15);
        $buatpdf->SetFont('Arial', '', 11);
        $buatpdf->Cell(15);
        $buatpdf->Cell(0, 9, 'Kebutuhan        : '.$data->Kebutuhan);
        $buatpdf->Ln(7);
        $buatpdf->Cell(15);
        $buatpdf->Cell(0, 9, 'Dari                   : '.$data->instansi_pemberi);
        $buatpdf->Ln(7);
        $buatpdf->Cell(15);
        $buatpdf->Cell(0, 9, 'Kepada             : '.$data->instansi_penerima);
        $buatpdf->Ln(7);
        $buatpdf->Cell(15);
        //Tabel
        $buatpdf->Ln(5);
        $buatpdf->Cell(10);
        $buatpdf->cell(15,9,'Perangkat yang dimaksud dengan rincian sebagai berikut :');
        $buatpdf->Ln(8);
        $buatpdf->Cell(10);
        $buatpdf->SetFont('Arial','B',7);
        $buatpdf->Cell(10,9,'No',1,0,'C');
        $buatpdf->Cell(40,9,'Barang',1,0,'C');
        $buatpdf->Cell(40,9,'Hasil',1,0,'C');
        $i=1;
        if(isset($Patchcord)){
            foreach ($Patchcord as $key) {
                $buatpdf->SetFont('Arial','',7);
                $buatpdf->Ln(9);
                $buatpdf->Cell(10);
                $buatpdf->Cell(10,9,''.$i++.'',1,0,'C');
                $buatpdf->Cell(40,9,''.$key->jenis.','.$key->konektor,1,0,'C');
                $buatpdf->Cell(40,9,''.$data->hasil.'',1,0,'C');
            }
        }
        if(isset($SFP)){
            foreach ($SFP as $key) {
                $buatpdf->SetFont('Arial','',7);
                $buatpdf->Ln(9);
                $buatpdf->Cell(10);
                $buatpdf->Cell(10,9,''.$i++.'',1,0,'C');
                $buatpdf->Cell(40,9,''.$key->jenis.','.$key->vendor,1,0,'C');
                $buatpdf->Cell(40,9,''.$data->hasil.'',1,0,'C');
            }
        }
        if(isset($Modul)){
            foreach ($Modul as $key) {
                $buatpdf->SetFont('Arial','',7);
                $buatpdf->Ln(9);
                $buatpdf->Cell(10);
                $buatpdf->Cell(10,9,''.$i++.'',1,0,'C');
                $buatpdf->Cell(40,9,''.$key->vendor.','.$key->tipe_board,1,0,'C');
                $buatpdf->Cell(40,9,''.$data->hasil.'',1,0,'C');
            }
        }
        $buatpdf->Ln(10);
        $buatpdf->Cell(10);
        $buatpdf->SetFont('Arial','',11);
        $buatpdf->cell(15,9,'Demikian Berita Acara ini dibuat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.');
        $buatpdf->Ln(15);

        $buatpdf->SetFont('Arial','B',11);
        $buatpdf->cell(135);
        $buatpdf->cell(0,9,'Makassar,  '.Carbon::now()->startOfDay()->format('Y-m-d'));
        $buatpdf->Ln(10);
        $buatpdf->Cell(15);
        $buatpdf->SetFont('Arial','',11);
        $buatpdf->cell(15,9,'Yang Menerima,');
        $buatpdf->cell(105);
        $buatpdf->cell(0,9,'Yang Menyerahkan,');
        $buatpdf->Ln(30);
        $buatpdf->Cell(15);
        $buatpdf->SetFont('Arial','',11);
        $buatpdf->cell(15,9,'('.$data->nama_penerima.')');
        $buatpdf->cell(105);
        $buatpdf->cell(0,9,'('.$data->nama_pemberi.')');
        $buatpdf->Ln(5);
        $buatpdf->Cell(15);
        $buatpdf->SetFont('Arial','B',11);
        $buatpdf->cell(15,9,'NIK. ');
        $buatpdf->cell(105);
        $buatpdf->cell(0,9,'NIK. ');

        $buatpdf->Output();
    }
}
