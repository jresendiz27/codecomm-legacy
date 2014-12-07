<?php
/*
esta madre es para subir una img a un servidor xD
*/
$nombre1=$_FILES['imagen']['name'];
$tipo1=$_FILES['imagen']['type'];
$tamano=$_FILES['imagen']['size'];
//echo $imguser;
if(!isset($_POST['Upload']))
	{
	if (isset($_POST['Delete'])) {
		$userfolder = '/home/adonais/domains/insysdev.co.cc/public_html/codecomm/users/';
		chdir($userfolder);
		include "conectar.php";
		$vinculo = conectar();
		include("sesion.php");
		$imguser = $_SESSION["user"];
		$result = mysql_query("SELECT * FROM MUsuario WHERE nick_user='$imguser'");
		$fila = mysql_fetch_array($result);
		$actual = $fila["avatar_user"];
		if (file_exists($actual)) {
			unlink($actual);
		}
		mysql_query("UPDATE MUsuario SET avatar_user='' WHERE nick_user='$imguser'");
		header("Location: perfil.php?nick=".$imguser);
	}
	else {
		include("upload.php");
	}
	}
else
	{
	if($tamano>102400)
		{
		$uploaderr = "ERROR: Verifica que el tamaño del archivo sea menor a 100 Kb <br>";
		include("upload.php");
		exit();
		}
	else if(!ereg("image",$tipo1))
		{
		$uploaderr = "ERROR: El archivo no es una imagen válida, por favor verifica el formato e intenta de nuevo <br>";
		include("upload.php");
		exit();
		}
	else
		{//c:\da\\
		include "conectar.php";
		$vinculo = conectar();
		include("sesion.php");
		$imguser = $_SESSION["user"];
		$userfolder = '/home/adonais/domains/insysdev.co.cc/public_html/codecomm/users/';
		$destino= $userfolder.$_FILES['imagen']['name'];
		$temp_file=$_FILES['imagen']['tmp_name'];
		move_uploaded_file($temp_file,$destino);
		chdir($userfolder);
		$arr_img=explode(".",$nombre1);
		//echo $_FILES['imagen']['name'];
		//echo $arr_img[0]."esto es una mamada";
		//echo $arr_img[1];
		//echo $arr_img[2];
		//$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
		$final = str_replace($arr_img[0],$imguser,$nombre1);
		$result = mysql_query("SELECT * FROM MUsuario WHERE nick_user='$imguser'");
		$fila = mysql_fetch_array($result);
		$actual = $fila["avatar_user"];
		if (file_exists($actual)) {
			unlink($actual);
		}
		rename($nombre1,$final);
		mysql_query("UPDATE MUsuario SET avatar_user='$final' WHERE nick_user='$imguser'");
		header("Location: perfil.php?nick=".$imguser);
		//UPDATE MUsuario SET vernom_user = 0 WHERE id_user = $id
		}
		
	}
?>
