<?php
require '../vendor/autoload.php';
require '../fpdf/fpdf.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$conn = mysqli_connect("localhost", "root", "", "sql_db");

if (isset($_POST['download'])) {
    $file_type = $_POST['file_type'];
    $query = "SELECT * FROM booking";
    $resultBooks = mysqli_query($conn, $query);

    if ($file_type == 'pdf') {
        class PDF extends FPDF {
            function Header() {
                $pageWidth = $this->GetPageWidth();
                $logoWidth = 30;
                $logoX = ($pageWidth - $logoWidth) / 2;
                $this->Image('../img/logo.png', $logoX, 6, $logoWidth);
                
                $this->SetY(40);
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(0, 10, 'Booking Details Report', 0, 1, 'C');
                $this->SetFont('Arial', 'I', 12);
                $this->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'C');
                $this->Ln(10);
            }

            function Footer() {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
            }
        }

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', 'B', 12);

        $widths = array(15, 40, 60, 40, 70, 30);
        $totalWidth = array_sum($widths);
        $pageWidth = $pdf->GetPageWidth();
        $leftMargin = ($pageWidth - $totalWidth) / 2;
        $pdf->SetLeftMargin($leftMargin);

        // Table header
        $pdf->SetFillColor(44, 105, 117);
        $pdf->SetTextColor(255, 255, 255);
        $headers = array('No', 'DateTime', 'Package', 'Schedule', 'Email', 'Status');
        for($i = 0; $i < count($headers); $i++) {
            $pdf->Cell($widths[$i], 12, $headers[$i], 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Reset text color for data
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 11);
        
        $rowNumber = 1;
        while ($row = mysqli_fetch_assoc($resultBooks)) {
            // Alternate light colors for row numbers
            if ($rowNumber % 2 == 0) {
                $pdf->SetFillColor(230, 230, 250); // Light lavender
            } else {
                $pdf->SetFillColor(240, 248, 255); // Alice blue
            }
            
            $pdf->Cell($widths[0], 10, $rowNumber, 1, 0, 'C', true); // Row number with fill color
            // Reset fill color for other cells
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell($widths[1], 10, date('Y-m-d H:i', strtotime($row['Date'])), 1, 0, 'C', false);
            $pdf->Cell($widths[2], 10, $row['Destination'], 1, 0, 'C', false);
            $pdf->Cell($widths[3], 10, date('Y-m-d', strtotime($row['schedule'])), 1, 0, 'C', false);
            $pdf->Cell($widths[4], 10, $row['Email'], 1, 0, 'C', false);
            $pdf->Cell($widths[5], 10, $row['Status'], 1, 0, 'C', false);
            $pdf->Ln();
            $rowNumber++;
        }

        $pdf->Output('D', 'bookings_list.pdf');

    }
}
?>
