<?php 

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'library');

    class DB_connect
    {
        public $connection;

        function __construct()
        {
            $this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

            if ($this->connection->connect_error)
                die ('Ошибка подключения: '. $this->connection->connect_error);
        
        }

        function ret_obj()
        {
            return $this->connection;
        }

    }