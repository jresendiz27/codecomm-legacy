<?php

$opt=$_GET["data"];
include ("header.php");
if (isset($_SESSION["user"])) {
if($opt=="new")
	{
	include ("new.php");
	}
else if($opt=="inbox")
	{
	include ("inbox.php");
	}
else if($opt=="send")
	{
	include("sent.php");
	}
/*else if($opt="dump")
	{
	include("dump.php");
	}
else if($opt=="friends")
	{
	include ("friends.php");
	}
else if($opt=="help")
	{
	include ("help.html");
	}*/
else
	{
	echo "<table width=\"800\" class=\"general\"><tr><td><h2>Mensajes</h2><p>La opción seleccionada es incorrecta</p></td></tr></table>";
	}
}
else {
	include "motivar.php";
?>
<?php include "foot.php" ?>
<?php } ?>