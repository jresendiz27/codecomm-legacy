<?php
	$con = mysql_connect("localhost","root","pass");
	
	if (!$con)
	{
	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db("comentarios", $con);

	$sql="INSERT INTO comentario (comment, nick)
	VALUES('$_POST[comment]', 'prueba')";

	if (!mysql_query($sql,$con))
	{
	die('Error: ' . mysql_error());
	}
	
	mysql_close($con)
?>
<?php include ("comentario.php");?>