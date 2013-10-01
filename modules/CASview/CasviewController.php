<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mstockenberg
 * Date: 8/22/13
 * Time: 7:18 PM
 * To change this template use File | Settings | File Templates.
 */

class CasviewController extends Controller
{


    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
        $this->request = array_merge($_GET, $_POST);

    }


    public function run()
    {
        if ($this->request['delete']) {
            $this->model->deleteLecture($this->request['delete']);
            header('Location: ' . BASE_URL . '?p=casview');
            exit();
        }

        if (isset($this->request['csvSubmit'])) {
            $this->model->updateLectures();
            header('Location: ' . BASE_URL . '?p=casview');
            exit();
        }

        if (isset($this->request['deleteAll'])) {
            $this->model->truncateTable('lectures');
            header('Location: ' . BASE_URL . '?p=casview');
            exit();
        }

        $this->view->setTemplate('tpl-casview');
        $csvData = $this->model->getLectures();
        $this->view->csvData = $csvData;
        return $this->view;

    }
}