<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mstockenberg
 * Date: 9/22/13
 * Time: 11:15 PM
 * To change this template use File | Settings | File Templates.
 */
include 'fpdf/fpdf.php';

class PDF extends FPDF{

    var $value = '';

    public function HeaderContent(){
        $this->image('./img/sae_logo.png', 165, 30, 33);
        $this->SetFont('Arial','',13);
        $this->Cell(1);
        $this->Ln(45);
        $this->Cell(0,20,''.utf8_decode($_POST['pdfDataPerson']['0']['name'][0].', '.$_POST['pdfDataPerson']['0']['name'][1]),0,0,'L');
        $this->Ln(6);
        $this->Cell(0,20,''.utf8_decode($_POST['pdfDataPerson']['0']['street']).'',0,0,'L');
        $this->Ln(6);
        $this->Cell(0,20,''.utf8_decode($_POST['pdfDataPerson']['0']['postcode'].' '.$_POST['pdfDataPerson']['0']['city']).'',0,0,'L');
        $this->Ln(26);
        $this->SetFont('Arial','',11);
        $this->Cell(0,10,'Hallo'.$_POST['pdfDataPerson']['0']['name'][1].',',0,0,'L');
        $this->Ln(8);
        $this->Cell(0,10,utf8_decode('hiermit schicke ich dir deine bisher geplanten Vorlesungstermine am SAE Institute Leipzig.'),0,0,'L');
        $this->Ln(5);
        $this->Cell(0,10,utf8_decode('Bitte überprüfe & bestätige die Daten und sende mir ein unterschriebenes Exemplar zurück.'),0,0,'L');
        $this->Ln(5);
        $this->Cell(0,10,utf8_decode('Bei Fragen und Problemen bin ich unter j.theiss@sae.edu oder 0341/30851622 zu erreichen.'),0,0,'L');
        $this->Ln(20);
        $this->BasicTable();
        $this->Ln(10);
        $this->Overview();
        $this->Ln(15);
        $this->SubtextDiploma();
        $this->SetFont('Arial', 'B', 12);
        // TODO Datum und Auftragsnummer anfügen
        // TODO Unterschrifenfeld anfügen
    }

    function BasicTable()
    {

        $header = array('Datum', 'Thema', 'Kurs', 'Block', 'Zeit', 'Dauer/h');
        $data = $_POST['pdfDataLectures'];
        //Header
        $this->SetFont('Arial','B',12);
        $this->Cell(22,7,$header[0],1,0,'C');
        $this->Cell(61,7,$header[1],1,0,'C');
        $this->Cell(46,7,$header[2],1,0,'C');
        $this->Cell(14,7,$header[3],1,0,'C');
        $this->Cell(21,7,$header[4],1,0,'C');
        $this->Cell(21,7,$header[5],1,0,'C');
        $this->Ln();
        //Data
        foreach($data as $row)
        {
            // TODO Multicell Dynamisch machen für mehr Content - siehe PDF
//            $x = $this->GetX();
//            $y = $this->GetY();
            //print($x.':'.$y); die();
            $this->SetFont('Arial','',10);
            $_POST['completeTime'] += $row['duration'];
            $this->Cell(22,6,$row['date'],1,0,'C');
            $this->SetFillColor(255, 0, 0);
            $this->Cell(61,6,utf8_decode($row['subject']),1,0,'C', 'F');
//            $this->SetXY($x + 83, $y);
            $this->Cell(46,6,utf8_decode($row['course']),1,0,'C');
            $this->Cell(14,6,$row['chapter'],1,0,'C');
            $this->Cell(21,6,$row['time'],1,0,'C');
            $this->Cell(21,6,$row['duration']/60,1,0,'C');
            $this->Ln();
        }
    }

    function Overview(){
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0,10,'Gesamtstundenzahl: '.$_POST['completeTime']/60 .'h      Stundensatz: '.chr(128).' '.$_POST['pdfDataPerson']['0']['mph'].'      Gesamthonorar: '.$_POST['pdfDataPerson']['0']['mph'] * $_POST['completeTime']/60 .' '.chr(128).'',0,0,'C');
    }

    function SubtextDiploma(){


        $this->SetFont('Arial','',11);
        $this->Cell(0,10,'Es gelten folgende Vorgaben:',0,0,'L');
        $this->SetLeftMargin(20);
        $this->Ln(8);
        $this->Cell(0,10,utf8_decode('- je 2,5 Stunden Vorlesung ist eine Pause von ca. 15 Minuten vorgesehen'),0,0,'L');
        $this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('- der Dozent muss zu jedem Vorlesungsthema entsprechende Prüfungsfragen freigeben bzw. zur Verfügung stellen' ), 0, 'L');
        $this->Ln(1);
        $this->MultiCell(0,5,utf8_decode('- der Dozent hat rechtzeitig (2 Wochen vorab) mit dem Fachbereichsleiter abzustimmen, welches Equipment/Material er benötigt'),0,'L');
        $this->Ln(1);
        $this->MultiCell(0,5,utf8_decode('- eventuelle Handouts/Kopiervolagen müssen 1 Woche im Voraus beim Fachbereichsleiter eingehen, um den rechtzeitigen Druck sicherzustellen'),0,'L');
        $this->Ln(1);
        $this->Cell(0,5,utf8_decode('- das Honorar berechnet sich aufgrund der tatsächlich gehaltenen Stunden'),0,0,'L');
        $this->getLastpage();
    }

    public function getLastpage(){
        $var = $this->PageNo();
        return $var;
    }

    public function getValue($param = null){
        $this->value = $param;
    }

    function Footer(){
            $date = explode('-', $_POST['pdfDataPerson']['0']['date']);
            if($this->PageNo() == $this->value){
                $this->setY(-45);
                $this->Cell(0,5,utf8_decode('Datum: '.$date[2].'.'.$date[1].'.'.$date[0]),0,0,'L');
                $this->Cell(0,5,utf8_decode('Auftragsnummer: '.$_POST['pdfDataPerson']['0']['date'].'_'.$_POST['pdfDataPerson']['0']['counter']),0,0,'R');
                $this->Ln(18);
                $this->Cell(40,10,utf8_decode('Dozent'),'T',0,'L');
                $this->SetLeftMargin(159);
                $this->Cell(40,10,utf8_decode('SAE GmbH'),'T',5,'R');
            }

    }
}

