<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

require('./fpdf186/fpdf.php'); // Adjust this to the correct path to FPDF

class PDF extends FPDF {
    function Header() {
        $this->Image('logo11.png',10,6,25); // Adjust logo.png to the path of your logo file
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,'TEST REPORT',0,1,'C');
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

if (isset($_GET['reportId'])) {
    $reportId = intval($_GET['reportId']);

    $stmt = $con->prepare("SELECT tr.*, p.PatientName FROM testreport tr JOIN tblpatient p ON tr.`P-ID` = p.ID WHERE tr.ReportID = ?");
    $stmt->bind_param("i", $reportId);
    $stmt->execute();
    $result = $stmt->get_result();
    $reportDetails = $result->fetch_assoc();

    if ($reportDetails) {
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);

        // Header Section
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(0,10,'Report Details',0,1,'C');
        $pdf->Ln(5); // Space after the section title

        // Report Details Table
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(220,220,220); // Light gray background for the header
        // Define the column headers
        $header = ['Attribute', 'Value'];
        $w = [40, 150]; // Column widths
        for($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $pdf->Ln();
        // Data
        $pdf->SetFont('Arial','',12);
        $pdf->SetFillColor(245,245,245); // Alternating row color
        $pdf->SetTextColor(0);
        $fill = false;
        $details = [
            'REPORT ID' => $reportDetails['ReportID'],
            'PATIENT NAME' => $reportDetails['PatientName'],
            'PATIENT ID' => $reportDetails['P-ID'],
            'TEST TYPE' => $reportDetails['TestType'],
            'TEST DATE' => $reportDetails['TestDate'],
        ];
        foreach ($details as $key => $value) {
            $pdf->Cell($w[0],6,$key,'LR',0,'L',$fill);
            $pdf->Cell($w[1],6,$value,'LR',0,'L',$fill);
            $pdf->Ln();
            $fill = !$fill;
        }
        $pdf->Cell(array_sum($w),0,'','T');

        $pdf->Ln(10); // Space before the REPORT section

        // Report Notes
        $notes = $pdf->replaceBrTags($reportDetails['Notes']); // Preprocess Notes field
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(210,210,210);
        $pdf->Cell(0,10,'REPORT NOTES',0,1,'L',true);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(0,10,$notes);

        $pdf->Ln(10); // Space before the RESULT section

        // Result Section
        $resultText = $pdf->replaceBrTags($reportDetails['Result']); // Preprocess Result field
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'RESULT',0,1,'L',true);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(0,10,$resultText);

        $pdf->Output('D', 'TestReport_'.$reportId.'.pdf');
    } else {
        echo "<script>alert('No record found');</script>";
    }

    $stmt->close();
}
