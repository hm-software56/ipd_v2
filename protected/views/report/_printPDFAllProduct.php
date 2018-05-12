<?php

$pdf = new PDFHeadLandLandScape('L', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetMargins(10, 6, 6);
$pdf->SetAutoPageBreak(TRUE, 20);

$pdf->AddPage();
$pdf->SetXY(60, 40);


$pdf->SetFont('phetsarath ot', 'BU', 16);

$pdf->Cell(0, 15, Yii::t('app', 'Product List'), 0, false, 'C', 0, '', 0, false, 'M', 'M');

$pdf->Ln(5);


// Header of table
$pdf->SetFillColor(288, 231, 130);
$pdf->SetTextColor(0);
$pdf->SetFont('phetsarath ot', 'B', 12);

$h1 = 14;
$h2 = 7;
$col1 = 20;
$col2 = 25;
$col3 = 98;
$col4 = 40;
$col5_6 = 20;
$col7 = 18;
$col8 = 20;
$col9 = 22;
$col10 = 20;
$pdf->Cell($col1, $h1, Yii::t('app', 'No'), 1, 0, 'C', 1);
$pdf->Cell($col2, $h1, Yii::t('app', 'Product Code'), 1, 0, 'C', 1);
$pdf->Cell($col3, $h1, Yii::t('app', 'Product Description'), 1, 0, 'C', 1);
$pdf->Cell($col4, $h2, Yii::t('app', 'Quantity'), 1, 0, 'C', 1);
$pdf->Ln();
$pdf->SetXY(153, 52);
$pdf->Cell($col5_6, $h2, Yii::t('app', 'On Hand'), 1, 0, 'C', 1);
$pdf->Cell($col5_6, $h2, Yii::t('app', 'On Order'), 1, 0, 'C', 1);

$pdf->SetXY(193, 45);
$pdf->Cell($col7, $h1, Yii::t('app', 'Unit'), 1, 0, 'C', 1);

$pdf->Cell($col8, $h1, Yii::t('app', 'Internal Price'), 1, 0, 'C', 1);
$pdf->Cell($col8, $h1, Yii::t('app', 'Selling Price'), 1, 0, 'C', 1);
$pdf->Cell($col9, $h1, Yii::t('app', 'Amount Iinternal Price'), 1, 0, 'C', 1);
$pdf->Cell($col10, $h1, Yii::t('app', 'Amount Selling Price'), 1, 0, 'C', 1);

$pdf->Ln();
// Table Body
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);


$fill = 0;
$seq = 1;
$totalUnitPrice = 0;
$totalUnitPriceAmount = 0;
$totalListPrice=0;
$totalListPriceAmount = 0;
foreach ($models as $data) {
    $pdf->Cell($col1, $h2, $seq, 1, 0, 'C', 1);
    $pdf->Cell($col2, $h2, $data->product_code, 1, 0, 'C', 1);
    $pdf->Cell($col3, $h2, $data->product_description, 1, 0, 'L', 1);
    $pdf->Cell($col5_6, $h2, $data->quantity_on_hand, 1, 0, 'R', 1);
    $pdf->Cell($col5_6, $h2, $data->quantity_on_order, 1, 0, 'R', 1);
    $pdf->Cell($col7, $h2, $data->unitmeasure->unit_name, 1, 0, 'C', 1);
    $pdf->Cell($col8, $h2, $data->productInventory->unit_price, 1, 0, 'R', 1);
    $pdf->Cell($col8, $h2, $data->list_price, 1, 0, 'R', 1);

    //Internal Price
    $totalUnitPrice = ($totalUnitPrice + $data->productInventory->unit_price );
    $unitPriceAmount = ($data->quantity_on_hand * $data->productInventory->unit_price);
    $pdf->Cell($col9, $h2, $unitPriceAmount, 1, 0, 'R', 1);
    $totalUnitPriceAmount = ($totalUnitPriceAmount+$unitPriceAmount);
    
    //Selling Amount
    $totalListPrice = ($totalListPrice+ $data->list_price);
    $listpriceAmount = ($data->quantity_on_hand) * $data->list_price;
    $pdf->Cell($col10, $h2, $listpriceAmount, 1, 0, 'R', 1);
    $totalListPriceAmount = ($totalListPriceAmount + $listpriceAmount);
    //$totalListPrice = $totalListPrice + $data->list_price;
    $seq++;
    $pdf->Ln();
    $fill = !$fill;
}
$col_margin = $col1 + $col2 + $col3 + (2 * $col5_6) + $col7;
$pdf->Cell($col_margin, $h2, Yii::t('app', 'Total:'), 1, 0, 'C', 1);

$pdf->SetFillColor(288, 231, 130);
$pdf->SetTextColor(0);

$pdf->Cell($col8, $h2, $totalUnitPrice, 1, 0, 'R', 1);
$pdf->Cell($col8, $h2, $totalListPrice, 1, 0, 'R', 1);
$pdf->Cell($col9, $h2, $totalUnitPriceAmount, 1, 0, 'R', 1);
$pdf->Cell($col10, $h2, $totalListPriceAmount, 1, 0, 'R', 1);
$pdf->Ln(20);

$pdf->SetFont('phetsarath ot', 'BU', 14);


$pdf->SetX(200);
$pdf->Cell(0, 15, Yii::t('app', 'Reported By'), 0, false, 'L', 0, '', 0, false, 'M', 'M');



$pdf->Output();
?>

