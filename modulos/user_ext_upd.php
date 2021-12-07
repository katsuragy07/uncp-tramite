<?php
    require_once('../Connections/cn1.php');

    
        $id = $_POST['codigo'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $estado = $_POST['estado'];

        mysql_query("UPDATE vecino set nombre = '$nombre', apellidos = '$apellidos', email = '$email', Password = '$password', estatus = '$estado' WHERE id = $id");

        header("Location: user_ext_edit.php"); 

?>