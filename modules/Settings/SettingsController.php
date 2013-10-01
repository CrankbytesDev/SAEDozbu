<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mstockenberg
 * Date: 8/22/13
 * Time: 7:18 PM
 * To change this template use File | Settings | File Templates.
 */

class SettingsController extends Controller
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
            $this->model->deleteLecturer($this->request['delete']);
            header('Location: ' . BASE_URL . '?p=settings');
            exit();
        }

        if (isset($this->request['lecturerSubmit'])) {
            if (!empty($this->request['name']) && !empty($this->request['street'])) {
                $this->model->addNewLecturer();
                header('Location: ' . BASE_URL . '?p=settings');
                exit();
            } elseif (empty($this->request['name']) || empty($this->request['street']) || empty($this->request['postcode'])) {
                $this->model->updateLecturers();
                header('Location: ' . BASE_URL . '?p=settings');
                exit();
            }
        }

        $this->view->setTemplate('tpl-settings');
        $this->view->instructors = $this->model->getLecturer();
        return $this->view;
    }
}