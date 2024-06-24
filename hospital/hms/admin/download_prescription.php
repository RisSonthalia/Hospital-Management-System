<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

require('./fpdf186/fpdf.php'); // Adjust this to the correct path to FPDF

class PDF extends FPDF {
    function Header() {
        $this->Image('logo11.png',10,6,25); 
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,'Prescription',0,1,'C');
        $this->Ln(20); // Space after the header
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Helper function to replace <br> tags with newlines
    function replaceBrTags($text) {
        $text = str_replace(array("<br>", "<br/>", "<br />"), "\n", $text);
        return $text;
    }
}

if (isset($_GET['prescId'])) {
    $prescid = intval($_GET['prescId']);

    $stmt = $con->prepare("SELECT pres.*, p.PatientName FROM tblmedicalhistory pres JOIN tblpatient p ON pres.PatientID = p.ID WHERE pres.ID = ?");
    $stmt->bind_param("i", $prescid);
    $stmt->execute();
    $result = $stmt->get_result();
    $prescDetails = $result->fetch_assoc();

    if ($prescDetails) {
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);

        // Table header
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Prescription Details',0,1,'C');
        $pdf->Ln(5); // Space after the title

        $pdf->SetFillColor(230,230,230); // Light gray background for the header row
        $pdf->Cell(50,10,'Attribute',1,0,'C',true);
        $pdf->Cell(130,10,'Value',1,1,'C',true);

        // Table rows
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,'Precription ID',1,0);
        $pdf->Cell(130,10,$prescDetails['ID'],1,1);
        
        $pdf->Cell(50,10,'Name',1,0);
        $pdf->Cell(130,10,$prescDetails['PatientName'],1,1);
        
        $pdf->Cell(50,10,'Blood Pressure',1,0);
        $pdf->Cell(130,10,$prescDetails['BloodPressure'],1,1);
        
        $pdf->Cell(50,10,'Blood Sugar',1,0);
        $pdf->Cell(130,10,$prescDetails['BloodSugar'],1,1);
        
        $pdf->Cell(50,10,'Weight',1,0);
        $pdf->Cell(130,10,$prescDetails['Weight'],1,1);
        
        $pdf->Cell(50,10,'Temperature',1,0);
        $pdf->Cell(130,10,$prescDetails['Temperature'],1,1);
        
        $pdf->Cell(50,10,'Date',1,0);
        $pdf->Cell(130,10,$prescDetails['CreationDate'],1,1);

        $pdf->Ln(10); // Space before the prescription section

        // Prescription notes
        $notes = $pdf->replaceBrTags($prescDetails['MedicalPres']); // Preprocess Notes field
        $pdf->SetFillColor(230,230,230);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Prescription Notes',0,1,'L',true);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(0,10,$notes);

        $pdf->Output('D', 'Prescription_'.$prescid.'.pdf');
    } else {
        echo "<script>alert('No record found');</script>";
    }

    $stmt->close();
}
