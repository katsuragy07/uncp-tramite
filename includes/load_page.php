<?php

if(!$_POST['page']) die("0");

$page = (int)$_POST['page'];

if(file_exists('../includes/pidx_'.$page.'.php'))
include('../includes/pidx_'.$page.'.php');

else echo 'No se encontro!';
?>
