<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../css/int.css" rel="Stylesheet" type="text/css" />
    <style>
    #wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

    <script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div style="padding: 1em;">
    <h1 style="padding: 0 0 10px 0;border-bottom: 1px solid gray;">Usuarios Externos de Mesa de Partes</h1>
    </div>
        <div class="row p-4">
            <div class="col-md-4">
                <form action="user_ext_edit.php" method="POST">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Ingrese email" autofocus>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-info btn-block" name="buscar" value="Buscar">
                </form>
            </div>
        </div>
        <?php
        if(isset($_POST['buscar'])){
            $email = $_POST['email'];
            $registros = mysql_query("SELECT * FROM vecino WHERE email = '$email'");
            if(mysql_num_rows($registros)==1){
            $registro = mysql_fetch_array($registros)?>
                <div class="row p-4">
                    <div class="col-md-4">
                    <form action="user_ext_upd.php" method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email:</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $registro['email']; ?>" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" value="<?php echo $registro['Password']; ?>" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" id="formGroupExampleInput" value="<?php echo $registro['nombre']; ?>" placeholder="Ingrese nombre">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Apellidos:</label>
                        <input type="text" name="apellidos" class="form-control" id="formGroupExampleInput" value="<?php echo $registro['apellidos']; ?>" placeholder="Ingrese apellidos">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Estado de la cuenta:</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" value="<?php if ($registro['estatus']==1){echo "Activo";}else{echo "No activo";}; ?>" disabled>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Cambiar estado de cuenta:</label>
                        <select class="custom-select custom-select-lg mb-3" name="estado" >
                            <option value="1">Activo</option>
                            <option value="0">No activo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="codigo" class="form-control" id="formGroupExampleInput" value="<?php echo $registro['id']; ?>">
                    </div>
                    <br>
                    <input type="submit" class="btn btn-success btn-block" name="update" value="Actualizar">
                    <a class="btn btn-warning btn-block" href="user_ext_edit.php">Cancelar</a>
                    </form>
                    </div>
                </div>
                
            <?php
            } else { ?>
                <div class="row p-4">
                    <div class="col-md-4">
                    <?php echo "¡Correo no encontrado!"; ?>
                
                    </div>
                </div>
            <?php }

        }
        
        ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
</body>
</html>