<?php

class Session
{

    public function __construct()
    {
        session_start();
        session_name('LOGIN');
        $this->checkSession();
    }

    public function checkSession()
    {
        if (!isset($_SESSION['lastdone'])) {
            $_SESSION['lastdone'] = time();
        } elseif ($_REQUEST['action'] == 'logout' || $_SESSION['lastdone'] + 3600 < time()) {
            unset($_SESSION['status']);
            unset($_COOKIE['LOGGED_IN']);
            session_destroy();
        } else {
            $_SESSION['lastdone'] = time();
        }
    }

    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function unsetSession($key)
    {
        unset($_SESSION[$key]);
    }

}