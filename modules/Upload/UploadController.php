<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mstockenberg
 * Date: 8/22/13
 * Time: 7:18 PM
 * To change this template use File | Settings | File Templates.
 */

class UploadController extends Controller
{

    var $filename = '';
    var $dir = '';
    var $path = '';

    public function __construct()
    {
        $this->request = array_merge($_GET, $_POST);
        $this->view = new View();
        $this->xml_upload();
        $this->arrStatus = array();
        $this->model = new Model();
        $this->path = '';
//      $this->fileHelper = new FileHelper();
    }

    public function generateFilename()
    {
        // TODO genauen Dateinamen bestimmen, und returnen
        // TODO Helpershit
        return true;
    }

    public function checkExtension($filename)
    {
        $extValid = array('xml', 'csv');
        $ext = substr($filename, -3);
        if (!in_array($ext, $extValid)) {
            $this->arrStatus['error'] = 'Datei hat falsche Endung';
            return false;
        } else {
            if ($ext == 'xml') {
                $this->request['form'] = 'xml_upload';
            }
            if ($ext == 'csv') {
                $this->request['form'] = 'csv_upload';
            }
            return true;
        }
    }

    public function xml_upload()
    {
        if (isset($this->request['uploadSubmit'])) {

            if (empty($_FILES['upload']['tmp_name'])) {
                $this->arrStatus['error'] = 'Datei auswählen';
            }
            if ($_FILES['upload']['size'] > 0.5 * 1024 * 1024) {
                $this->arrStatus['error'] = 'Datei ist zu Groß für den Upload, maximale Größe: 0.5MB';
            }
            if (empty($this->arrStatus['error'])) {
                $this->dir = './uploads/';
                if ($this->checkExtension($_FILES['upload']['name']) === true) {
                    $this->path = substr($_FILES['upload']['name'], -3);
                    $uploadStatus = move_uploaded_file($_FILES['upload']['tmp_name'], $this->dir . $this->path . '/' . $_FILES['upload']['name']);
                    if (isset($uploadStatus)) {
                        $model = new Model();
                        $this->arrStatus['success'] = 'Alles Prima';
                        if ($this->request['form'] == 'xml_upload') {
                            $xml = simplexml_load_file('./uploads/xml/' . $_FILES['upload']['name']);
                            $model->setLecturersFromXMLToDb($xml);
                            unlink('./uploads/xml/' . $_FILES['upload']['name']);
                            header('Location: ' . BASE_URL . '?p=settings');
                            exit();
                        } elseif ($this->request['form'] == 'csv_upload') {
                            $csv = $model->csvToArray('./uploads/csv/' . $_FILES['upload']['name']);
                            $model->csvToDatabase($csv);
                            unlink('./uploads/csv/' . $_FILES['upload']['name']);
                            header('Location: ' . BASE_URL . '?p=casview');
                            exit();
                        }
                        // TODO was denn signatur hochgeladen wurde
                    } else {
                        $this->arrStatus['error'] = 'Fehler beim Hochladen';
                    }
                }
            }
        }
    }

    public function run()
    {
        $this->view->setTemplate('tpl-upload');
        return $this->view;
    }

}