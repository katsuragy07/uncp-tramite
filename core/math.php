<?php
/*
funciones de uso comun
*/

// crear id unico
function dev_porcentaje($cantidad,$porciento,$decimales){
	return number_format($cantidad*$porciento/100 ,$decimales);
}

?>