<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mstockenberg
 * Date: 8/22/13
 * Time: 7:18 PM
 * To change this template use File | Settings | File Templates.
 */

class LoginController extends Controller
{
    protected $view;
    protected $user;
    protected $password;
    protected $session;

    public function __construct($session)
    {
        $this->view = new View();
        $this->request = array_merge($_GET, $_POST);
        $this->session = new Session();
        $this->check_user($this->request['username'], $this->request['password']);
    }

    public function check_user($user, $password)
    {
        if (isset($this->request['loginSubmit'])) {
            if (empty($user) || empty($password)) {
                // TODO Fehlermeldung raushauen
            } else {
                $model = new Model();
                $users = $model->getValidUser();
                switch ($users[0]['id']) {
                    case '1':
                        $this->session->setSession('status', 'admin');
                        setcookie('LOGGED_IN', true);
                        header('Location: ' . BASE_URL . '?p=upload');
                        exit();
                }
            }
        }
    }

    public function run()
    {
        $this->view->setTemplate('tpl-login');
        $this->view->content = 'test';
        return $this->view;

    }
}