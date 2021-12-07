<?php
session_start();
  session_destroy();
header('Location: validar/index.html');
die();
?>