<?php

/**
 * Create databse connection
 * Include in class files
 */

if($_SERVER['HTTP_HOST'] == 'localhost:8888'){
// Definieer de database waarden voor MAMP
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'oct');
}else{
// Definieer de database waarden voor NON MAMP
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'oct');
}

class DB_con
{
    public $connection;
    function __construct()
    {
        $this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($this->connection->connect_error) die('Database error -> ' . $this->connection->connect_error);
    }

    function ret_obj()
    {
        return $this->connection;
    }
}