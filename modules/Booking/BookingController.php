<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mstockenberg
 * Date: 8/22/13
 * Time: 7:18 PM
 * To change this template use File | Settings | File Templates.
 */

include './libraries/PDF.php';
class BookingController extends Controller
{


    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
        $this->request = array_merge($_GET, $_POST);
        $this->pdf = new PDF();

    }

    public function generatePDFIndex(){
        $data = $this->model->getLecturer();
        // TODO greift sobald eine pdf generiert wurde. Der Counter wird hochgesetzt und bei einem neuem Tag resettet
        foreach($data as $k => $v){
            if($v['date'] != date("Y-m-d")){
                $index = 1;
            }elseif(isset($this->request['correct'])){
                $index = $v['counter'];
            }
            else{
                $index = $v['counter'] += 1;
            }
            return $index;

        }
    }

    // TODO JavaScript Confirm losjagen in allen Links

    public function run()
    {

        if ($this->request['pdfSubmit'] || isset($this->request['getPDF']) || isset($this->request['pdfPreview'])){
            if(isset($this->request['pdfSubmit'])){
                $this->model->updateIndex($this->request['lecturerSelect']);
            }
            $this->model->getMeAPDFPost();
            $this->pdf_2 = new PDF;
            $this->pdf_2->AliasNbPages();
            $this->pdf_2->AddPage();
            $this->pdf_2->HeaderContent();
            $lp = $this->pdf_2->getLastpage();

	        $this->pdf = new PDF;
            $this->pdf->AliasNbPages();
            $this->pdf->AddPage();
	        $this->pdf->HeaderContent();
            $this->pdf->getValue($lp);
            $this->pdf->output();
            // TODO Unterscheiden ob BA oder Diploma Dozent
        }

        if ($this->request['delete']) {
            $this->model->deleteLecture($this->request['delete']);
            header('Location: ' . BASE_URL . '?p=booking');
            exit();
        }

        if (isset($this->request['bookingSubmit'])) {
            $this->model->updateLecturesFromBooking();
            header('Location: ' . BASE_URL . '?p=booking&lecturerSelect='.$this->request['lecturerSelect']);
            exit();
        }

        $this->view->setTemplate('tpl-booking');
        $this->view->lecturer = $this->model->getLecturer();
        if(isset($this->request['lecturerSubmit'])){
            if(isset($this->request['lecturerSelect']) && $this->request['lecturerSelect'] !== false){
                $this->view->lecturesOfLecturers = $this->model->getLectureOfLecturer();
                header('Location: '.BASE_URL.'?p=booking&lecturerSelect='.$this->request['lecturerSelect']);
                exit();
            }
        }elseif(isset($this->request['lecturerSelect'])){
            $this->view->lecturesOfLecturers = $this->model->getLectureOfLecturer();
        }
        return $this->view;

    }
}