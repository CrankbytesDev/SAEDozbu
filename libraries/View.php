<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mstockenberg
 * Date: 8/22/13
 * Time: 6:58 PM
 * To change this template use File | Settings | File Templates.
 */

class View
{

    private $template;
    private $data;

    public function __construct()
    {
        $this->data = array();
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return null;
        }
    }

    public function setTemplate($tplName)
    {
        $this->template = $tplName;
    }

    public function parse()
    {
        $arrModulesFolders = scan('modules/');
        foreach ($arrModulesFolders as $folder) {
            if (substr($folder, 0, 1) == '.') {
                continue;
            }

            $file = 'modules/' . $folder . '/templates/' . $this->template . '.php';

            if (file_exists($file)) {
                ob_start();
                include $file;
                $output = ob_get_contents();
                ob_end_clean();
            }
        }
        return $output;
    }
}