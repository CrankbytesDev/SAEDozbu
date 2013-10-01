<?php
class Database
{

    public static $db;

    public static function getInstance()
    {
        if (!self::$db) {
            self::$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';', DB_USER, DB_PASS,
                array(
                    PDO::ATTR_PERSISTENT         => true,
                    #PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_WARNING,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                )
            );
        }
        return self::$db;
    }

}