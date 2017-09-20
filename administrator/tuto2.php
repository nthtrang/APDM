<?php
require('fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
	//Logo
	$this->Image('header.jpg',0,0,40, 13 );
	//Arial bold 15
	$this->SetFont('Arial','B',10);
	//Move to the right
	//$this->SetXY(0,0);
//	$this->Cell(80);
	//Title
	$this->Text(80,5,'INTERNAL USE ONLY');
	//$this->SetXY(170,0);
	$this->SetFont('Arial','B',8);
	$this->Text(170,4,'Part Number: 600-244555-00');
	$this->Text(195,9,'REV: AA');
	$this->SetFont('Arial','B',8);
	$this->SetTextColor(250,0,0);
	$this->Text(70,12,'ASCENX TECHNOLOGIES CONFIDENTIAL');
	$this->SetXY(2,14);
	$this->Cell(205,0,'', 1);
	//Line break
	$this->Ln(2);
}

//Page footer
function Footer()
{
	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Page number
	$this->Cell(0,10,'ASCENX TECHNOLOGIES CONFIDENTIAL Page '.$this->PageNo().'/{nb}',0,0,'L');
	
}

//Colored table
function FancyTable($header,$data)
{
	//Colors, line width and bold font
	$this->SetFillColor(0,130,20);
	$this->SetTextColor(255);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	//Header
	$w=array(30,120,20,20);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	$this->Ln();
	//Color and font restoration
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Data
	$fill=false;
	$i=0;
	foreach($data as $row)
	{
		$this->Cell($w[0],8,$row[0],'LR',0,'L',$fill);
		$this->Cell($w[1],8,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[2],8,number_format($row[2]),'LR',0,'R',$fill);
		$this->Cell($w[3],8,number_format($row[3]),'LR',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
	/*   $i++;
		if ($i==29){
			$this->SetFillColor(0,130,20);
			$this->SetTextColor(255);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			for($i=0;$i<count($header);$i++) {
				$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
			}
			$this->Ln();
			$i=0;
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			$fill=false;
		}*/
	
	}
	$this->Cell(array_sum($w),0,'','T');
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Text(80,20,'Commodity Code');
$pdf->Ln(8);
$pdf->SetFont('Arial','',8);
$pdf->Text(10,29,'Username: lediemphuc@yahoo.com');
$pdf->Text(165,29,'Date Created: 24/10/2009');
$pdf->Ln(8);
$header=array('Commodity Code','Description','Status','Date Create');
$data[] = array("Austria", "Vienna", "83859", "83859");
$data[] = array("Austria", "Vienna", "83859", "83859");
$data[] = array("Austria", "Vienna", "83859", "83859");
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header,$data);
$pdf->Output('test.pdf', 'D');
?>
