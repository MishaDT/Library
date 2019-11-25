<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'library');

class DB_connect // Класс подключения к БД
{
    public $connection;

    function __construct() // Функция конструктор 
    {
        $this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($this->connection->connect_error)
            die('Ошибка подключения: ' . $this->connection->connect_error);
    }

    function ret_obj()
    {
        return $this->connection; // Вызов конструктора подключения
    }
}
