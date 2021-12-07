<?php
//var1 level
//var2 sis
//var3 cinta
function drib($var1,$var2,$var3){
	if($var1==0){
		return true;
	}else{
		switch ($var3){
			case 1:
				if($var2==1 || $var2==3){
					return true;
				}else{
					return false;
				}
			break;
			case 2:
				if($var2==2 || $var2==3){
					return true;
				}else{
					return false;
				}
			break;
			case 3:return false;break;
		}
	}
}
//var1=level
//var2=perf
function dribbut($var1,$var2){
	if($var1==0){
		return true;
	}else{
		switch ($var2){
			case 3:return true;break;
			case 4:return false;break;
		}
	}
}
function drjs($var1,$var2){
	if($var1==0){
		return true;
	}else{
		if($var2==1 || $var2==3){
			return true;
		}else{
			return false;
		}
	}
}
function lcok($var1){
	return $_SESSION[$var1];
}
?>