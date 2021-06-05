<?php
    require_once('sistema.controller.php');

    /*
    * Clase principal para servicios
    */
    class Servicio extends Sistema{
        var $id_servicio;
        var $servico;
        var $descripcion;
        var $fotografia;

        /*
        * Metodos que devuelven los atributos de la clase Servicio
        * @
        */
        function getIdServicio(){ return $this -> id_servicio; }
        function getServicio(){ return $this -> servico; }
        function getDescripcion(){ return $this -> descripcion; }
        function getFotografia(){ return $this -> fotografia; }

        function setIdServicio($id_serv){ $this -> id_servicio = $id_serv; }
        function setServicio($serv){ $this -> servicio = $serv; }
        function setDescripcion($desc){ $this -> descripcion = $desc; }
        function setFotografia($foto){ $this -> fotografia = $foto; }

        function create($servicio, $descripcion){
            $dbh = $this -> Connect();
            $foto = $this -> guardarFotografia();
            $sentencia = "INSERT INTO servicio(servicio, descripcion, fotografia)
                                        VALUES(:servicio, :descripcion, :fotografia)";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":servicio", $servicio, PDO::PARAM_STR);
            $stmt -> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt;
        }

        function update($id_servicio, $servicio, $descripcion){
            $dbh = $this -> Connect();
            $foto = $this -> guardarFotografia();
            if($foto){
                $sentencia = "UPDATE servicio SET servicio = :servicio, descripcion = :descripcion, 
                              fotografia = :fotografia WHERE id_servicio = :id_servicio";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
            }
            else{
                $sentencia = "UPDATE servicio SET servicio = :servicio, descripcion = :descripcion
                              WHERE id_servicio = :id_servicio";
                $stmt = $dbh -> prepare($sentencia);
            }
            $stmt -> bindParam(":servicio", $servicio, PDO::PARAM_STR);
            $stmt -> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt -> bindParam(":id_servicio", $id_servicio, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt;
        }

        function delete($id_servicio){
            $dbh = $this -> Connect();
            $stmt = $dbh -> prepare('DELETE FROM servicio WHERE id_servicio = :id_servicio');
            $stmt -> bindParam(":id_servicio", $id_servicio, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt;
        }

        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'s.servicio';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM servicio s WHERE s.servicio LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

        function readOne($id_servicio){
            $dbh = $this -> Connect();
            $this -> setIdServicio($id_servicio);
            $result = $dbh -> query('SELECT * FROM servicio WHERE id_servicio = ' . $this -> getIdServicio());
            $rows = $result -> fetchAll();
            return $rows;
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
            $sentencia = "SELECT COUNT(id_servicio) AS total FROM servicio";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>