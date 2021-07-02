<?php
    class Sistema
    {
        //Para PostgresSQL
        /*var $dsn = "pgsql:host=localhost;port=5432;dbname=hospital";
        var $user = "hospital";
        var $pass = "123456";
        var $engine = "postgresql";*/

        //Para MariaDB
        var $dsn = "mysql:host=localhost;dbname=novaric";
        var $user = "admin_novaric";
        var $pass = "123456";
        var $engine = "mariadb";

        function getEngine(){ return $this -> engine; }

        function Connect(){
            $dbh = new PDO($this -> dsn, $this -> user, $this -> pass);
            return $dbh;
        }
    }
?>