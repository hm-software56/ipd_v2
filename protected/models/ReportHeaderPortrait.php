<?php

//Yii::import('application.extensions.giiplus.bootstrap.tcpdf.*');
Yii::import('application.extensions.tcpdf.*');

class ReportHeaderPortrait extends TCPDF {

    public $imageType;
    public $image_file;
    public $title;

    //Page header
    public function Header() {
        if (count($this->pages) === 1) { // Do this only on the first page
            // Logo
            $this->image_file = Yii::app()->basePath . '/../images/chevrolet.jpeg';
            $this->Image($this->image_file, 10, 10, 25, 25, $this->imageType, '', 'T', false, 300, '', false, false, 0, false, false, false);

             //Set font
            //$this->addTTFfont(K_PATH_FONTS.'phetsarathot.ttf');
            $this->SetFont('phetsarath ot', 'B', 16);
            $this->SetX(100);
            $this->title = Yii::t('app', 'CHEVROLET-LAO COMPANY Limited.');

            // Title
            $this->Cell(0, 15, $this->title, 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);

            // set font
            $this->SetFont('phetsarath ot', 'B', 12);
            $this->SetX(90);
            $this->Cell(0, 15, Yii::t('app', 'Unit 9, Nongduangneua Village, ASEAN Road(T2), Vientiane'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);
            $this->SetX(95);
            $this->Cell(0, 15, Yii::t('app', 'Tel:') . ' +(856) 21 921 888, 921 999, www.chevrolet-lao.com ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);

            //Draw Line
            $this->Line(10, 35, 195, 35);
        }
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('phetsarath ot', 'I', 10);
        $this->Cell(0, 10, Yii::t('app', 'Printed Date:') . ' ' . date('d/m/Y').'  '. Yii::t('app','Printed By:') .' ' .Yii::app()->user->name, 0, false, 'C');
        // Page number
        $this->Cell(0, 10, Yii::t('app', 'Page ') . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

