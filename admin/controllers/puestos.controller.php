<?php
    require_once('sistema.controller.php');

   /*
    * Clase principal para puestos
    */
    class Puesto extends Sistema
    {
       /*
        * Método para insertar un registro de puestos a la base de datos Novaric
        * Params Integer @id_dep recibe el id del departamento al que pertenece el puesto
        *        String  @pu recibe el nombre del puesto
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function create($pu, $id_dep)
        {
            $dbh = $this->connect();
            try {
                $sentencia = "INSERT INTO puesto(puesto, id_departamento) VALUES(:puesto, :id_departamento)";
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':puesto', $pu, PDO::PARAM_STR);
                $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
                $stmt->execute();
                $msg['msg'] = 'Puesto registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, el puesto ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

       /*
        * Método para obtener todos los puestos
        * Return Array con todos los puestos por cantidades
        */
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'p.puesto';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM puesto p
                                    INNER JOIN departamento USING(id_departamento)
                                  WHERE p.puesto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = SELECT * FROM puesto p
                                    INNER JOIN departamento USING(id_departamento)
                                 WHERE p.puesto ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT * FROM puesto p 
                              INNER JOIN departamento USING(id_departamento)
                          WHERE p.puesto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

       /*
        * Método para obtener todos los puestos
        * Return Array con todos los puestos
        */
        function readAll()
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM puesto AS p INNER JOIN departamento USING(id_departamento)';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

       /*
        * Metodo para obtener la informacion de un puesto
        * Params Integer @rfc recibe el id del puesto
        * Return Array con la información de un puesto
        */
        function readOne($id_pu)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM puesto INNER JOIN departamento USING(id_departamento) 
                        WHERE id_puesto = :id_puesto';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

       /*
        * Método para actualizar un registro de un puesto en la base de datos Novaric
        * Params Integer @id_dep recibe el id del departamento al que pertenece el puesto
        *        String  @pu recibe el nombre del puesto
        *        Integer @id_pu recibe el id del puesto
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function update($id_pu, $pu, $id_dep)
        {
            $dbh = $this->connect();
            try {
                $sentencia = 'UPDATE puesto SET puesto = :puesto, id_departamento = :id_departamento WHERE id_puesto = :id_puesto';
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);
                $stmt->bindParam(':puesto', $pu, PDO::PARAM_STR);
                $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
                $stmt->execute();
                $msg['msg'] = 'Puesto actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, el puesto ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        function delete($id_pu)
        {
            $dbh = $this->connect();
            $dbh -> beginTransaction();
            try {
                $sentencia = 'DELETE FROM empleado WHERE id_puesto = :id_puesto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_puesto', $id_pu);
                $stmt-> execute();
                $sentencia = 'DELETE FROM puesto WHERE id_puesto = :id_puesto';
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);
                $stmt->execute();
                $dbh -> commit();
                $msg['msg'] = 'Puesto eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh -> rollBack();
                $msg['msg'] = 'Error al eliminar, el puesto tiene empleados asociados.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_puesto) AS total FROM puesto";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>