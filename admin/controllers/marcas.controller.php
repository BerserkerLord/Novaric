<?php
    require_once('sistema.controller.php');
    class Marca extends Sistema
    {
        var $id_marca;
        var $marca;
        var $fotografia;

        function getIdMarca(){ return $this -> id_marca; }
        function getMarca(){ return $this -> marca; }
        function getFotografia(){ return $this -> fotografia; }

        function setIdMarca($id_mar){ $this -> id_marca = $id_mar; }
        function setMarca($mar){ $this -> marca = $mar; }
        function setFotografia($foto){ $this -> fotografia = $foto; }

        function create($mar)
        {
            $dbh = $this->connect();
            $foto = $this -> guardarFotografia();
            $sentencia = "INSERT INTO marca(marca, fotografia) VALUES(:marca, :fotografia)";
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':marca', $mar, PDO::PARAM_STR);
            $stmt->bindParam(':fotografia', $foto, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'m.marca';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM marca m WHERE m.marca LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function readOne($id_mar)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM marca WHERE id_marca = :id_marca';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function update($id_mar, $mar)
        {
            $dbh = $this->connect();
            $foto = $this -> guardarFotografia();
            if($foto){
                $sentencia = "UPDATE marca SET marca = :marca, fotografia = :fotografia WHERE id_marca = :id_marca";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
            }
            else{
                $sentencia = "UPDATE marca SET marca = :marca WHERE id_marca = :id_marca";
                $stmt = $dbh -> prepare($sentencia);
            }
            $stmt->bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
            $stmt->bindParam(':marca', $mar, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function delete($id_mar)
        {
            $dbh = $this->connect();
            $sentencia = 'DELETE FROM marca WHERE id_marca = :id_marca';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function guardarFotografia()
        {
            $archivo = $_FILES['fotografia'];
            $tipos = array('image/jpeg', 'image/png', 'image/gif');
            if ($archivo['error'] == 0) {
                if ($archivo['size'] <= 2097152) {
                    $a = explode('/', $archivo['type']);
                    $nueva_imagen = MD5(time()) . '.' . $a[1];
                    if (move_uploaded_file($archivo['tmp_name'], '../archivos/' . $nueva_imagen)) {
                        return $nueva_imagen;
                    }
                }
            }
        }

        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_marca) AS total FROM marca";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>