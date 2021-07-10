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
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':departamento', $dep, PDO::PARAM_STR);
                $stmt->execute();
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
            $busqueda = (isset($_GET['busqueda'])) ? $_GET['busqueda'] : '';
            $ordenamiento = (isset($_GET['ordenamiento'])) ? $_GET['ordenamiento'] : 'd.departamento';
            $limite = (isset($_GET['limite'])) ? $_GET['limite'] : '3';
            $desde = (isset($_GET['desde'])) ? $_GET['desde'] : '0';
            switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM departamento AS d  
                                  WHERE d.departamento LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM departamento AS d  
                                  WHERE d.departamento ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }
            /*$sentencia = 'SELECT * FROM departamento AS d
                          WHERE d.departamento LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde'*/;
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt->bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt->bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt->bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas = $stmt->fetchAll();
            return $filas;
        }

        /*
         * Método para obtener todos los departamentos
         * Return Array con todos los departamentos
         */
        function readAll()
        {
            $dbh = $this->connect();
            $sentencia = 'SELECT * FROM departamento AS d';
            $stmt = $dbh->prepare($sentencia);
            $stmt->execute();
            $filas = $stmt->fetchAll();
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
            $sentencia = 'SELECT * FROM departamento WHERE id_departamento = :id_departamento';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
            $stmt->execute();
            $filas = $stmt->fetchAll();
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
                $stmt = $dbh->prepare($sentencia);
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
            $dbh->beginTransaction();
            try {
                $sentencia = 'SELECT id_puesto FROM puesto WHERE id_departamento = :id_dep';
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                foreach ($rows as $key => $row):
                    $sentencia = 'SELECT rfc FROM empleado WHERE id_puesto = :id_puesto';
                    $stmt = $dbh->prepare($sentencia);
                    $stmt->bindParam(':id_puesto', $row['id_puesto'], PDO::PARAM_INT);
                    $stmt->execute();
                    $rows2 = $stmt->fetchAll();
                    foreach ($rows2 as $key2 => $row2) {
                        $sentencia = 'DELETE FROM empleado WHERE rfc = :rfc';
                        $stmt = $dbh->prepare($sentencia);
                        $stmt->bindParam(':rfc', $row2['rfc'], PDO::PARAM_STR);
                        $stmt->execute();
                    }
                endforeach;
                $sentencia = 'DELETE FROM puesto WHERE id_departamento = :id_dep';
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
                $stmt->execute();
                $sentencia = 'DELETE FROM departamento WHERE id_departamento = :id_departamento';
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
                $stmt->execute();
                $dbh->commit();
                $msg['msg'] = 'Departamento eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh->rollBack();
                $msg['msg'] = 'Error desconocido al eliminar, favor de contactar al desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Método para extrater total de departamentos
         * Return un entero que es la cantidad de departamentos
         */
        function total()
        {
            $dbh = $this->Connect();
            $sentencia = "SELECT COUNT(id_departamento) AS total FROM departamento";
            $stmt = $dbh->prepare($sentencia);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows[0]['total'];
        }

        //======================Manejo de formato JSON===================================

        /*
         * Método para insertar un registro de departamento
         * Params Array @data recibe los datos del departamento
         */
        function insertJSON($data)
        {
            $departamentos = json_decode($data, true);
            $dbh = $this->Connect();
            $departamento = $departamentos['departamento'];
            $info = array();
            try {
                $sentencia = "INSERT INTO departamento(departamento) VALUES(:departamento)";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(":departamento", $departamento, PDO::PARAM_STR);
                $stmt->execute();
                $info['status'] = 200;
                $info['mensaje'] = 'Departamento dado de alta';
                $this->printJSON($info);
            } catch (Exception $e) {
                $info['status'] = 405;
                $info['mensaje'] = 'Error al dar de alta, el departamento ya existe';
                $this->printJSON($info);
            }
            $info['status'] = 403;
            $info['mensaje'] = 'Error al dar de alta';
            $this->printJSON($info);
        }

        /*
        * Método para actualizar un registro de un departamento
        * Params Array   @data recibe los datos a actualizar del departamento
        *        Integer @id_departamento recibe los el id del departamento
        */
        function updateJSON($id_departamento, $data)
        {
            $departamentos = json_decode($data, true);
            $dbh = $this->Connect();
            $departamento = $departamentos['departamento'];
            $info = array();
            try {
                $sentencia = "UPDATE departamento SET departamento = :departamento WHERE id_departamento = :id_departamento";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(":departamento", $departamento, PDO::PARAM_STR);
                $stmt->bindParam(":id_departamento", $id_departamento, PDO::PARAM_INT);
                $stmt->execute();
                $info['status'] = 200;
                $info['mensaje'] = 'Departamento actualizado correctamente';
                $this->printJSON($info);
            } catch (Exception $e) {
                $info['status'] = 405;
                $info['mensaje'] = 'Error al dar actualizar, el departamento ya existe';
                $this->printJSON($info);
            }
            $info['status'] = 403;
            $info['mensaje'] = 'Error al dar actualizar';
            $this->printJSON($info);
        }

        /*
        * Metodo para obtener la informacion de un solo departamento
        * Params Integer @id recibe el id de un departamento
        * Return Array con la información del departamento
        */
        function extractOne($id_departamento)
        {
            $dbh = $this->Connect();
            $sentencia = 'SELECT departamento, id_departamento FROM departamento WHERE id_departamento = :id_departamento';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(":id_departamento", $id_departamento, PDO::PARAM_INT);
            $stmt->execute();
            $dato = $stmt->fetchAll();
            $departamento = array("id_departamento" => $dato[0]['id_departamento'],
                "departamento" => $dato[0]['departamento']);
            return $departamento;
        }

       /*
        * Método para obtener todos los pacientes
        * Return Array con los pacientes
        */
        function extractAll(){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM departamento';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $dato = $stmt -> fetchAll();
            $departamentos = array();
            foreach($dato as $key => $dat):
                $departamento = array("is_departamento" => $dat['id_departamento'],
                    "departamento" => $dat['departamento']);
                array_push($departamentos, $departamento);
            endforeach;
            return $departamentos;
        }

        /*
        * Metodo para elimina el registro de un departamento
        * Params Integer @id_departamento recibe el id de un departamento
        */
        function deleteJSON($id_departamento){
            $dbh = $this -> Connect();
            try {
                $query = "DELETE FROM departamento WHERE id_departamento = :id_departamento";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
                $stmt -> execute();
                $info['status'] = 200;
                $info['mensaje'] = 'Departamento eliminado';
                $this -> printJSON($info);
            } catch(Exception $e){
                $dbh -> rollBack();
                $info['status'] = 403;
                $info['mensaje'] = 'Error al eliminar el departamento';
                $this -> printJSON($info);
            }
            $dbh -> rollBack();
            $info['status'] = 403;
            $info['mensaje'] = 'Error al eliminar el departamento';
            $this -> printJSON($info);
        }
    }
?>