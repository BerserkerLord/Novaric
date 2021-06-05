<?php
    include("sistema.controller.php");
    class Empleado extends Sistema{
        var $rfc;
        var $nombre;
        var $apaterno;
        var $amaterno;
        var $direccion;
        var $usuario;
        var $correo;
        var $contrasenia;
        var $fotografia;
        var $puesto;

        function getRFC(){ return $this -> rfc; }
        function getNombre(){ return $this -> nombre; }
        function getApaterno(){ return $this -> apaterno; }
        function getAmaterno(){ return $this -> amaterno; }
        function getDirecion(){ return $this -> direccion; }
        function getUsuario(){ return $this -> usuario; }
        function getCorreo(){  return $this -> correo; }
        function getContrasenia(){ return $this -> contrasenia; }
        function getFotografia(){ return $this -> fotografia; }
        function getPuesto(){ return $this -> puesto; }

        function setRFC($errefece){ $this -> rfc = $errefece; }
        function setNombre($nom){ $this -> nombre= $nom; }
        function setApaterno($apa){ $this -> apaterno = $apa; }
        function setAmaterno($ama){ $this -> amaterno = $ama; }
        function setDireccion($dir){ $this -> direccion = $dir; }
        function setUsuario($usu){ $this -> usuario = $usu; }
        function setCorreo($corr){ $this -> correo = $corr; }
        function setContrasenia($con){ $this -> contrasenia = $con; }
        function setFotografia($foto){ $this -> fotografia = $foto; }
        function setIdPuesto($pu){ $this -> puesto = $pu; }

        function create($errefece, $nom, $apa, $ama, $dir, $usu, $corr, $con, $id_pu)
        {
            $dbh = $this->connect();
            $foto = $this -> guardarFotografia();
            $sentencia = "INSERT INTO empleado(rfc, nombre, apaterno, amaterno, direccion, usuario, correo, contrasenia, fotografia, id_puesto) 
                          VALUES(:rfc, :nombre, :apaterno, :amaterno, :direccion, :usuario, :correo, :contrasenia, :fotografia, :id_puesto)";
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':apaterno', $apa, PDO::PARAM_STR);
            $stmt->bindParam(':amaterno', $ama, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $dir, PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $usu, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $corr, PDO::PARAM_STR);
            $stmt->bindParam(':contrasenia', $con, PDO::PARAM_STR);
            $stmt->bindParam(':fotografia', $foto, PDO::PARAM_STR);
            $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);;
            $resultado = $stmt->execute();
            return $resultado;
        }

        function read()
        {
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'e.nombre';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $dbh = $this->connect();
            $sentencia = 'SELECT * FROM empleado e
                              INNER JOIN puesto USING(id_puesto)
                          WHERE e.rfc LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function readOne($errefece)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM empleado INNER JOIN puesto USING(id_puesto) WHERE rfc = :rfc';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function update($errefece, $nom, $apa, $ama, $dir, $usu, $corr, $con, $id_pu)
        {
            $dbh = $this->connect();
            $foto = $this -> guardarFotografia();
            if($foto){
                $sentencia = 'UPDATE empleado SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno,
                          direccion = :direccion, usuario = :usuario, correo = :correo, contrasenia = :contrasenia,
                          fotografia = :fotografia, id_puesto = :id_puesto WHERE rfc = :rfc';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
            }
            else{
                $sentencia = 'UPDATE empleado SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno,
                          direccion = :direccion, usuario = :usuario, correo = :correo, contrasenia = :contrasenia,
                          id_puesto = :id_puesto WHERE rfc = :rfc';
                $stmt = $dbh -> prepare($sentencia);
            }
            $stmt->bindParam(':nombre', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':apaterno', $apa, PDO::PARAM_STR);
            $stmt->bindParam(':amaterno', $ama, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $dir, PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $usu, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $corr, PDO::PARAM_STR);
            $stmt->bindParam(':contrasenia', $con, PDO::PARAM_STR);
            $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);;
            $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function delete($errefece)
        {
            $dbh = $this->connect();
            $sentencia = 'DELETE FROM empleado WHERE rfc = :rfc';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
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
            $sentencia = "SELECT COUNT(rfc) AS total FROM empleado";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>