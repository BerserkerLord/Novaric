<?php
    class Sistema
    {
        var $dsn = "mysql:host=localhost;dbname=novaric";
        var $user = "admin_novaric";
        var $pass = "123456";

        function Connect(){
            $dbh = new PDO($this -> dsn, $this -> user, $this -> pass);
            return $dbh;
        }
    }
?>