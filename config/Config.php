<?php
class Config
{
    public $env = 'local';

    public function __construct($env = null)
    {
        $this->env = $env;
        $this->set_env($this->env);
    }

    function set_env($env)
    {
        define('BASE_URL', $_SERVER['PHP_SELF']);
        define ('OFFLINE', 0);
        define ('ADMIN', 1);
        define ('USER', 2);
        error_reporting(-1);


        switch ($env) {
            case 'local':
                define('DB_HOST', 'localhost');
                define('DB_DATABASE', 'cb_dozbu');
                define('DB_USER', 'root');
                define('DB_PASS', 'admin');
                define('MAIL_TO', 'MStockenberg@googlemails.com');
                break;

            case 'live':
                define('DB_HOST', '');
                define('DB_USER', '');
                define('DB_PASS', '');
                define('DB_DATABASE', '');
                define('MAIL_TO', '');
                break;
        }
    }
}