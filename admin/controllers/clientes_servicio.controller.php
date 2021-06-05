<?php
    require_once('sistema.controller.php');
    class ClienteServicio extends Sistema{
        function create($rfc, $nombre, $apaterno, $amaterno, $email, $telefono, $domicilio){
            $dbh = $this -> Connect();
            $sentencia = "INSERT INTO cliente_servicio(rfc, nombre, apaterno, amaterno, email, telefono, domicilio)
                                                VALUES(:rfc, :nombre, :apaterno, :amaterno, :email, :telefono, :domicilio)";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
            $stmt -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt -> bindParam(":apaterno", $apaterno, PDO::PARAM_STR);
            $stmt -> bindParam(":amaterno", $amaterno, PDO::PARAM_STR);
            $stmt -> bindParam(":email", $email, PDO::PARAM_STR);
            $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt;
        }

        function update($rfc, $nombre, $apaterno, $amaterno, $email, $telefono, $domicilio){
            $dbh = $this -> Connect();
            $sentencia = "UPDATE cliente_servicio SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno, email = :email, telefono = :telefono,
                                      domicilio = :domicilio WHERE rfc = :rfc";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt -> bindParam(":apaterno", $apaterno, PDO::PARAM_STR);
            $stmt -> bindParam(":amaterno", $amaterno, PDO::PARAM_STR);
            $stmt -> bindParam(":email", $email, PDO::PARAM_STR);
            $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
            $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt;
        }

        function delete($rfc){
            $dbh = $this -> Connect();
            $stmt = $dbh -> prepare('DELETE FROM cliente_servicio WHERE rfc = :rfc');
            $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt;
        }

        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'cs.rfc';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM cliente_servicio cs WHERE cs.rfc LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
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
            $sentencia='SELECT * FROM cliente_servicio WHERE rfc = :rfc';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':rfc', $rfc, PDO::PARAM_STR);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(rfc) AS total FROM cliente_servicio";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>