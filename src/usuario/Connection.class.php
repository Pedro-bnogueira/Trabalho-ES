<?php
class Connection {
    private static $instance = null;
    public static function getInstance() {
        if (null === static::$instance) {
            new Connection();
            static::$instance = mysqli_connect("localhost", "root", "", "transporte_bd");
        }
        return static::$instance;
    }
    private function __construct()
    {   
    }
}
