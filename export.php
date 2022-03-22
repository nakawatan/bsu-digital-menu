<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = dirname(__FILE__, 1);
require($root.'/include/fpdf.php');

include_once $root.'/classes/voucher.php';

$obj = new Voucher();

if (isset($_REQUEST['series_id'])) {
    $obj->series_id = $_REQUEST['series_id'];
}
$list = $obj->get_records();
  
// New object created and constructor invoked
$pdf = new FPDF();
  
// Add new pages. By default no pages available.
$pdf->AddPage();
  
// Set font format and font-size
$pdf->SetFont('Times', 'B', 20);
  
// Framed rectangular area
$pdf->Cell(176, 5, 'Vouchers', 0, 0, 'C');
  
// Set it new line
$pdf->Ln();
  
// Set font format and font-size
$pdf->SetFont('Times', 'B', 12);
  
$x=0.0;
$rows=1;
$b=3;

$y = $pdf->GetY();
$width = 106.0;
$urlSize = 24.0;
$logoSize=35.0;
$qrSize=25.0;
$codeSize = 75.0;
foreach($list as $row) {
    if ($x %2 == 1) {
        $pdf->SetY($y);
        $pdf->SetX($width);
        // $pdf->Image($root.$row['qr_code_link'], 102, $pdf->GetY(), $logoSize, 0, false, "", 0, "");
    
        $pdf->SetFont("courier", "", $urlSize);
        
        $pdf->SetFont("courier", "B", $urlSize);
    
        $pdf->SetX($width);
        $pdf->Cell(21, 15, "", "TL", 0, "", false, 0, "");
        $pdf->Cell(79, 15, "Meal Voucher", "RT", 1, "L", false, 0, "");
    
        $pdf->SetFont("courier", "", $urlSize);
        $pdf->SetX($width);
        $pdf->Image($root.$row['qr_code_link'], 170, $pdf->GetY()+3, $qrSize, 0, false, "", 0, "");
        $pdf->Cell(30, 10, "", "L", 0, "", false, 0, "");
        $pdf->Cell(70, 10, "", "R", 1, "C", false, 0, "");
    
        // $pdf->SetFont("courier", "B", $codeSize);
        $pdf->SetX($width);
        $pdf->Cell(100, 5, "", "LR", 1, "C", false, 0, "");
        // pdf.SetX(width)
        $pdf->SetX($width);
        // pdf.CellFormat(30, 5, "", "L", 0, "", false, 0, "")
        $pdf->Cell(70, 5, "PHP ".$row['amount'], "L", 0, "C", false, 0, "");
        $pdf->Cell(30, 5, "", "R", 1, "C", false, 0, "");
        $pdf->SetX($width);
        // pdf.CellFormat(100, 35, table.Tag, "LRB", 1, "R", false, 0, "")
        $pdf->Cell(3, 25, "", "LB", 0, "C", false, 0, "");
    
        
        $pdf->Cell(97, 24, "", "R", 1, "C", false, 0, "");
        $pdf->SetX($width);
        $pdf->Cell(100, 1, "", "LRB", 1, "C", false, 0, "");
        
        $pdf->Ln(5);
    }else {
            $y = $pdf->GetY();
            $pdf->SetX(5);
			$pdf->SetFont("courier", "", $urlSize);
            
			// $pdf->Image($root.$row['qr_code_link'], 0, $pdf->GetY(), $logoSize, 0, false, "", 0, "");
            
			$pdf->SetFont("courier", "B", $urlSize);
			$pdf->Cell(21, 15, "", "LT", 0, "", false, 0, "");
			$pdf->Cell(79, 15, "Meal Voucher", "RT", 1, "L", false, 0, "");
            $pdf->SetX(5);

			$pdf->SetFont("courier", "", $urlSize);
			$pdf->Image($root.$row['qr_code_link'], 70, $pdf->GetY()+3, $qrSize, 0, false, "", 0, "");
            $pdf->SetX(5);
			$pdf->Cell(30, 10, "", "L", 0, "", false, 0, "");
			$pdf->Cell(70, 10, "", "R", 1, "C", false, 0, "");
            $pdf->SetX(5);
			$pdf->Cell(100, 5, "", "LR", 1, "C", false, 0, "");

            $pdf->SetX(5);
			$pdf->Cell(70, 5, "PHP ".$row['amount'], "L", 0, "C", false, 0, "");
            $pdf->Cell(30, 5, "", "R", 0, "C", false, 0, "");
            $pdf->SetX(5);
			$pdf->Cell(100, 5, "", "RR", 1, "C", false, 0, "");
            $pdf->SetX(5);

			$pdf->SetFont("courier", "B", $codeSize);

			$pdf->Cell(3, 25, "", "LB", 0, "C", false, 0, "");
            
			$pdf->Cell(97, 24, "", "R", 1, "C", false, 0, "");
            $pdf->SetX(5);

			$pdf->Cell(100, 1, "", "LRB", 1, "C", false, 0, "");
    }
    $x++;
    if ($x % 8 == 0) {
        $pdf->AddPage();
    }  

    
}
    
  
// Close document and sent to the browser
$pdf->Output();
  
?>