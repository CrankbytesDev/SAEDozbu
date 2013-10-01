<?php
/* CHECK und ausführende Prüfungen alles ohne Daten mit Prüfung */

class ApplicationController extends Controller
{
    protected $view;
    protected $request;
    protected $session;


    public function __construct()
    {
        $this->view = new View();
        $this->request = array_merge($_GET, $_POST);
        $this->session = new Session();
    }

    public function run()
    {
        $this->view->setTemplate('tpl-index');
        $module = (isset($this->request['p'])) ? $this->request['p'] : 'login';
        switch ($module) {
            case 'login':
                $mod_login = new LoginController($this->session);
                $this->view->siteContent = $mod_login->run();
                $this->view->path = 'Login';
                break;

            case 'upload':
                $mod_upload = new UploadController();
                $this->view->siteContent = $mod_upload->run();
                $this->view->path = 'Upload';
                break;

            case 'booking':
                $mod_booking = new BookingController();
                $this->view->siteContent = $mod_booking->run();
                $this->view->path = 'Booking';
                break;

            case 'settings':
                $mod_settings = new SettingsController();
                $this->view->siteContent = $mod_settings->run();
                $this->view->path = 'Settings';
                break;

            case 'casview':
                $mod_casview = new CasviewController();
                $this->view->siteContent = $mod_casview->run();
                $this->view->path = 'CASview';
                break;
        }
        return $this->view->parse();
    }
}