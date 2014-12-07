<?php
$mail=$_POST['mail_user'];
$pass="";
$nuser="";
$nombre="";
$cuerpo="";
$encabezado="";
$send="";

session_start();
if (isset($_SESSION["user"])) {
	header("Location: index.php");
}

if($mail!=""||$mail!=null||$mail!=0)
{
$mail_user=explode("@",$mail);
include "conectar.php";
$vinculo=conectar();
$rslt=mysql_query("select nick_user, pass_user from MUsuario NATURAL JOIN CDominio where email_user = '$mail_user[0]' AND nom_dom = '@$mail_user[1]'",$vinculo);
if(mysql_num_rows($rslt)==1)
{
$var="";
while($rows=mysql_fetch_array($rslt))
	{
	$id = $rows['id_user'];
	$pass = "dummy";
	$nuser = $rows['nick_user'];
	$encpass = hash("sha256", "enc".strtoupper($nuser).$pass);
	$nombre = $rows['nom_user'];
	$cuerpo="Buen dia ".$nombre."!\n\nAl parecer has olvidado tu contraseña...\nno te preocupes te la recuperamos!!!\n\nUsuario: ".$nuser."\n\nContrasena: ".$pass."\n\nRecuerda cambiarla tan pronto entres a la página.\n\nTe esperamos pronto en nuestra comunidad!\n\n\n\nhttp://www.insysdev.co.cc/codecomm/";
	$asunto="Codecomm: Password";

	}

	if(!$correo=mail($mail,$asunto,$cuerpo))
		{
		$send="Mensaje No Enviado...Intenta mas tarde...";
		}
	else
		{
		$send="Mensaje Enviado...";
		mysql_query ("UPDATE MUsuario SET pass_user = '$encpass' WHERE id_user = '$id'");
		}
	
}
else
{
$var="Direccion de correo invalida";
}
//mail(direccion ,asunto,mensaje,encabezados);

}
//esta cosa es para mandar el correo a los k perdieron su contraseña :s
include("header.php");
?>
<td>
<div align="center">
<form method="post" action="password.php">
<center>
<?php 
if($var!="")
	{	
		echo "Direccion de correo erronea.";
	}
echo $send; 

?>
<p>Para poder recuperar tu contraseña es necesario que cheques tu correo.</p>
<p><b>Si no anotaste un correo válido al momento de inscribirte, tu cuenta no podrá ser recuperada</b></p>
<p>Anota tu correo electronico:<input type="text" id="mail_user" name="mail_user"/></p>
<p><input type="submit" value="mandar"/></p>
</center>
</form>
</div>
</tr></td></table>
<?php 
include("foot.php");
?>
