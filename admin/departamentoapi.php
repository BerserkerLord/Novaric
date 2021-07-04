<?php
    /*
     * Archivo php que sirve para redirigir o hacer una funcion del crud de
     * doctores en función a la "action" que exista en $_GET con API
     */
    include('controllers/departamentos.controller.php');
    $departamentos = New Departamento;
    $action = $_SERVER['REQUEST_METHOD'];
    
    /*
     * Switch que recibe variable $action para saber que evento o cosa se va
     * a accionar.
     */
    switch($action)
    {
        case 'DELETE':
            if(isset($_GET['id_departamento'])){
                $id_departamento = $_GET['id_departamento'];
                $departamentos -> deleteJSON($id_departamento);
            }
            break;
        case 'POST':
            if(isset($_GET['id_departamento'])){
                /*Update*/
                $id_departamento = $_GET['id_departamento'];
                if(isset($_POST['info'])){
                    $data = $_POST['info'];
                } else{
                    $data = @file_get_contents('php://input');
                }
                $departamentos -> updateJSON($id_departamento, $data);
            } else {
                /*Insert*/
                if(isset($_POST['info'])){
                    $data = $_POST['info'];
                } else{
                    $data = @file_get_contents('php://input');
                }
                $departamentos -> insertJSON($data);
            }
            break;
        default:
            if(isset($_GET['id_departamento'])){
                $id_departamento = $_GET['id_departamento'];
                $dato = $departamentos -> extractOne($id_departamento);
            } else {
                $dato = $departamentos -> extractAll();
            }
            print_r($dato);
    }
?>