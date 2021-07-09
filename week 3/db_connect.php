<?php

// database connection class
class db_connect {
    private $hostname;
    private $username;
    private $password;
    private $database;

    protected $connect;
    protected $error;

    public function __construct($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect() {
        $this->connect = @mysqli_connect($this->hostname, $this->username, $this->password, $this->database);

        if ($this->connect === false) {
            return "Error Connecting: <b><i>" . mysqli_connect_error() . "</i></b>";
        }
    } 
}

?>