<?php
    require_once('sistema.controller.php');

   /*
    * Clase principal para departamentos
    */
    class Departamento extends Sistema
    {

       /*
        * Método para insertar un registro dedepartamentos a la base de datos Novaric
        * Params String @dep recibe el nombre del departamento
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function create($dep)
        {
            $dbh = $this->connect();
            try {
                $sentencia = "INSERT INTO departamento(departamento) VALUES(:departamento)";
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':departamento', $dep, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Departamento registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, el departamento ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

       /*
        * Método para obtener todos los departamentos
        * Return Array con todos los departamentos por cantidades
        */
        function read()
        {
            $dbh = $this->connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'d.departamento';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM departamento AS d  
                                    WHERE d.departamento LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM departamento AS d  
                                    WHERE d.departamento ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT * FROM departamento AS d  
                          WHERE d.departamento LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

       /*
        * Método para obtener todos los departamentos
        * Return Array con todos los departamentos
        */
        function readAll()
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT * FROM departamento AS d';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para obtener la informacion de un departamento
         * Params Integer @id_dep recibe el id de un proveedor
         * Return Array con la información de un departamento
         */
        function readOne($id_dep)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM departamento WHERE id_departamento = :id_departamento';
            $stmt = $dbh->prepare($sentencia);
            $stmt -> bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
            $stmt -> execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        /*
         * Metodo para actualizar el registro de un departamento
         * Params Integer @id_dep recibe el id del departamento
         *        String  @dep recibe el nombre del departamento
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function update($id_dep, $dep)
        {
            $dbh = $this->connect();
            try {
                $sentencia = 'UPDATE departamento SET departamento = :departamento WHERE id_departamento = :id_departamento';
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
                $stmt->bindParam(':departamento', $dep, PDO::PARAM_STR);
                $stmt->execute();
                $msg['msg'] = 'Departamento actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, el departamento ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de un departamento
         * Params Integer @id_dep recibe el id del departamento
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function delete($id_dep)
        {
            $dbh = $this->connect();
            try {
                $sentencia = 'DELETE FROM departamento WHERE id_departamento = :id_departamento';
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
                $stmt->execute();
                $msg['msg'] = 'Departamento eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, el departamento tiene puestos asociados.';
                $msg['status'] = 'danger';

            }
        }

       /*
        * Método para extrater total de departamentos
        * Return un entero que es la cantidad de departamentos
        */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_departamento) AS total FROM departamento";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>