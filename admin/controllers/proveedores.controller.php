<?php
    require_once('sistema.controller.php');
    
    /*
    * Clase principal para razon_socials
    */
    class Proveedor extends Sistema{
        var $rfc;
        var $razon_social;
        var $domicilio;
        var $telefono;
    
        /*
        * Metodos que devuelven los atributos de la clase razon_social
        * @
        */
        function getRFC(){ return $this -> rfc; }
        function getRazon_social(){ return $this -> razon_social; }
        function getDomicilio(){ return $this -> domicilio; }
        function getTelefono(){ return $this -> telefono; }
    
        function setRFC($errefece){ $this -> rfc = $errefece; }
        function setRazon_social($r_z){ $this -> razon_social = $r_z; }
        function setDomicilio($dom){ $this -> domicilio = $dom; }
        function setTelefono($tel){ $this -> telefono = $tel; }
    
        function create($rfc, $razon_social, $domicilio, $telefono){
            $dbh = $this -> Connect();
            $sentencia = "INSERT INTO proveedor(rfc, razon_social, domicilio, telefono)
                                            VALUES(:rfc, :razon_social, :domicilio, :telefono)";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
            $stmt -> bindParam(":razon_social", $razon_social, PDO::PARAM_STR);
            $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
            $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt;
        }
    
        function update($rfc, $razon_social, $domicilio, $telefono){
            $dbh = $this -> Connect();
            $sentencia = "UPDATE proveedor SET razon_social = :razon_social, domicilio = :domicilio, telefono = :telefono
                                  WHERE rfc = :rfc";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":razon_social", $razon_social, PDO::PARAM_STR);
            $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
            $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt;
        }
    
        function delete($rfc){
            $dbh = $this -> Connect();
            $stmt = $dbh -> prepare('DELETE FROM proveedor WHERE rfc = :rfc');
            $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt;
        }

        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'p.razon_social';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM proveedor p WHERE p.razon_social LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

        function readOne($rfc)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM proveedor WHERE rfc = :rfc';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':rfc', $rfc, PDO::PARAM_STR);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(rfc) AS total FROM proveedor";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>