<?php

class DbConnect {
    private $conn = null;

    function __construct($conn_info) {
        if ($conn_info['conn_type'] == 'test') {
            $this->test_db_connect();
            return true;
        } else {
            return false;
        }
    }

    function test_db_connect() {
        $this->db_connect('localhost', 'root', 'root');
    }

    function db_connect($host, $user, $password) {
        $mysqli = new mysqli($host, $user, $password);
        if ($mysqli->connect_errno) {
            $error_message = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            throw new Exception($error_message);
        }
        say($mysqli->host_info);
        $this->conn = $mysqli;
    }

    function db_query($sql) {
        say('EXECUTE QUERY: ' . $sql);
        $result = $this->conn->query($sql);
        $result_string = $result ? 'SUCCESS' : 'FAILURE';
        say('QUERY RETURN VALUE: ' . $result_string);
    }

    function does_db_exist($db_name) {
        return in_array($db_name, $this->get_db_names());
    }

    function get_db_names() {
        $databases = mysqli_query($this->conn, 'SHOW DATABASES');
        $db_names = [];
        foreach($databases as $db)
        {
            array_push($db_names, $db['Database']);
        }
        return $db_names;
    }

}