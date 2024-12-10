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

    } elseif ($file_type == 'word') {
        $phpWord = new PhpWord();
        
        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'marginLeft' => 1200,
            'marginRight' => 1200,
            'marginTop' => 600,
            'marginBottom' => 600
        ]);

        $header = $section->addHeader();
        $header->addImage('../img/logo.png', 
            array(
                'width' => 50, 
                'height' => 50,
                'alignment' => 'center'
            )
        );
        
        $header->addText('Booking Details Report', 
            array('bold' => true, 'size' => 16), 
            array('alignment' => 'center')
        );
        $header->addText('Generated on: ' . date('Y-m-d H:i:s'), 
            array('italic' => true, 'size' => 10), 
            array('alignment' => 'center')
        );

        $tableStyle = array(
            'borderColor' => '68B2A0',
            'borderSize' => 1,
            'cellMargin' => 80,
            'alignment' => 'center'
        );

        $headerStyle = array(
            'bold' => true,
            'backgroundColor' => '2C6975',
            'color' => 'FFFFFF'
        );

        $table = $section->addTable($tableStyle);
        $table->addRow(400);
        $headers = array('No', 'DateTime', 'Package', 'Schedule', 'Email', 'Status');
        foreach ($headers as $header) {
            $table->addCell(2000)->addText($header, $headerStyle, array('alignment' => 'center'));
        }

        $rowNumber = 1;
        while ($row = mysqli_fetch_assoc($resultBooks)) {
            $table->addRow();
            
            // Alternate light colors for row numbers
            $cellStyle = array('bgColor' => ($rowNumber % 2 == 0) ? 'E6E6FA' : 'F0F8FF'); // Light lavender : Alice blue
            
            $cell = $table->addCell(2000, $cellStyle);
            $cell->addText($rowNumber, null, array('alignment' => 'center'));
            
            $table->addCell(2000)->addText(date('Y-m-d H:i', strtotime($row['Date'])), null, array('alignment' => 'center'));
            $table->addCell(2000)->addText($row['Destination'], null, array('alignment' => 'center'));
            $table->addCell(2000)->addText(date('Y-m-d', strtotime($row['schedule'])), null, array('alignment' => 'center'));
            $table->addCell(2000)->addText($row['Email'], null, array('alignment' => 'center'));
            $table->addCell(2000)->addText($row['Status'], null, array('alignment' => 'center'));
            $rowNumber++;
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=bookings_list.docx");
        $phpWord->save('php://output');

    } elseif ($file_type == 'excel') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getPageSetup()->setHorizontalCentered(true);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath('../img/logo.png');
        $drawing->setCoordinates('C1');
        $drawing->setHeight(50);
        $drawing->setOffsetX(100);
        $drawing->setWorksheet($sheet);

        $sheet->setCellValue('C1', 'Booking Details Report');
        $sheet->setCellValue('C2', 'Generated on: ' . date('Y-m-d H:i:s'));
        
        $sheet->mergeCells('C1:F1');
        $sheet->mergeCells('C2:F2');

        $sheet->getStyle('C1:F2')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('C1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('C2')->getFont()->setItalic(true);
        
        $headers = ['No', 'DateTime', 'Package', 'Schedule', 'Email', 'Status'];
        $col = 'B';
        $row = 4;
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $col++;
        }

        $headerRange = 'B4:G4';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '68B2A0']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        $row = 5;
        $rowNumber = 1;
        while ($data = mysqli_fetch_assoc($resultBooks)) {
            // Alternate light colors for row numbers
            $sheet->getStyle('B' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $rowNumber % 2 == 0 ? 'E6E6FA' : 'F0F8FF'] // Light lavender : Alice blue
                ]
            ]);
            
            $sheet->setCellValue('B' . $row, $rowNumber);
            $sheet->setCellValue('C' . $row, date('Y-m-d H:i', strtotime($data['Date'])));
            $sheet->setCellValue('D' . $row, $data['Destination']);
            $sheet->setCellValue('E' . $row, date('Y-m-d', strtotime($data['schedule'])));
            $sheet->setCellValue('F' . $row, $data['Email']);
            $sheet->setCellValue('G' . $row, $data['Status']);
            $rowNumber++;
            $row++;
        }

        foreach(range('B','G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle('B5:G' . ($row-1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ]);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="bookings_list.xlsx"');
        $writer->save('php://output');
    }
}
?>