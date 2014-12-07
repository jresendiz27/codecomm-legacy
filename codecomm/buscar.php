<?php
include ("conectar.php");
$vinculo = conectar();
function leercat() {
		$vinculo = conectar();
		$id_cat = intval($_POST["idcat"]);
		$result = mysql_query("SELECT * FROM CCategoria WHERE id_cat = $id_cat", $vinculo);
		if (!mysql_fetch_array($result)) {
			$id_cat = 1;
		}
		$result = mysql_query("SELECT * FROM CCategoria ORDER BY id_cat", $vinculo);
		while ($row = mysql_fetch_array($result)) {
			if ($row["id_cat"] == $id_cat) {
				print "<OPTION SELECTED=\"selected\" VALUE=\"".$row["id_cat"]."\">".$row["nom_cat"]."</OPTION>";
			}
			else {
				print "<OPTION VALUE=\"".$row["id_cat"]."\">".$row["nom_cat"]."</OPTION>";
			}
		}
	}
if(!isset($_GET['adv']))
{
?>
<? include "header.php";?>
<style type="text/css">
.formu
{
font-family:Arial,Helvetica,sans-serif;
color:#FF4500;
}
.formu a, .formu a:visited, .formu a:active
{
color:#7FFFD4;
background-color:#008B8B;
font-family:Arial,Helvetica,sans-serif;
}
.formu a:hover
{
color:#F0FFF0;
background-color:#008B8B;
font-family:Arial,Helvetica,sans-serif;
}
a:hover
{
font-family:Arial,Helvetica,sans-serif;
color:#20B2AA;
text-decoration:none;
}
a, a:visited
{
font-family:Arial,Helvetica,sans-serif;
color:#FF8C00;
text-decoration:none;
}
.rs a, .rs a:visited, .rs a:active
{
color:#008080;
font-family:Arial,Helvetica,sans-serif;
}
.rs a:hover
{
color:#FF8C00;
font-family:Arial,Helvetica,sans-serif;
}
</style>

<table class="formu" border="0">
<tr>
<td>
<center><img src="images/buscar.png" height="95" width="110"/></center>
</td>
<td>
<form action="buscar.php" method="get">
<input type="text" maxlength="255" size="60" name="search" value="<?php echo $_GET["search"]; ?>" class="field"/>
<input type="submit" value="buscar" class="boton"/>
<a href="buscar.php?adv=1" target="_self">Busqueda Avanzada</a>
<input type="hidden" name="seek" value="seek"/>
</form>
</td>
</tr>
</table>
<br/>
<br/>
<table class="rs" border="0" width="800">
<?
if (isset($_GET['search']))
	{
	/*
	DYDHZJFG-NSNVKQFH-QX8K0SKS-SQ7CCG7N-XFM4KF2C
	*/
	//*realizo la busqueda sencilla*/
	$vinculo=conectar();
	$rs=mysql_query("SELECT nom_post,tags_post,prior_post,nick_user, nom_sub, id_post FROM MPost NATURAL	Join MUsuario Natural Join CSubcategoria ORDER BY prior_post DESC",$vinculo);
	$sres = array();
	//mysql_real_escape_string
	while($rw = mysql_fetch_array($rs))
		{
		$srch=explode(" ",strtolower($_GET['search']));
		$tags=explode(",",$rw['tags_post']);
		$busk=array_intersect($srch,$tags);
		$con = 0;
		foreach ($srch as $src) {
			if (preg_match("#\b".preg_quote($src, "#")."\b#iu", $rw["nom_post"])) {
				$con++;
			}
		}
		if (sizeof($busk) > 0 || $con > 0) {
			$sres[sizeof($sres)] = "<tr><td><p align=\"justify\"><a href=\"verpost.php?id=".$rw['id_post']."\" target=\"_blank\">".$rw['nom_post']."</a></p></td></tr>";
		}
		}
	// Ordenar aqui $sres
	foreach ($sres as $sresi) {
		echo $sresi;
	}
	}
	
else if(isset($_GET['seek']))
	{
	echo "Parametros Incorrectos";
	die();
	}

}
else
{
?>
<? include "header.php";?>
<style type="text/css">
.formu
{
font-family:Arial,Helvetica,sans-serif;
color:#FF4500;
}
.formu a, .formu a:visited, .formu a:active
{
color:#7FFFD4;
background-color:#008B8B;
font-family:Arial,Helvetica,sans-serif;
}
.formu a:hover
{
color:#F0FFF0;
background-color:#008B8B;
font-family:Arial,Helvetica,sans-serif;
}
a:hover
{
font-family:Arial,Helvetica,sans-serif;
color:#20B2AA;
text-decoration:none;
}
a, a:visited
{
font-family:Arial,Helvetica,sans-serif;
color:#FF8C00;
text-decoration:none;
}
.rs a, .rs a:visited, .rs a:active
{
color:#008080;
font-family:Arial,Helvetica,sans-serif;
}
.rs a:hover
{
color:#FF8C00;
font-family:Arial,Helvetica,sans-serif;
}
</style>
<script src="ajax.js" type="text/javascript"></script>
<table  class="formu" border="0">
<tr><td>
<form action="buscar.php?adv=1" method="post">
<p>Nombre de post: <input type="text" maxlength="255" size="60" name="search" value="<?php echo $_POST["search"]; ?>" class="field"/></p>
<p>Seud&oacute;nimo del usuario: <input type="text" maxlength="255" size="60" name="user" value="<?php echo $_POST["user"]; ?>" class="field"/></p>
<p>Categorias: <select name="idcat" onChange="loadXMLDoc('subcat.php', 'idcat=' + this.value, 'GET', 'sublist')"><?php leercat() ?></select> <select name="sub" id="sublist"><?php include "subcat.php"; ?></select></p>
<input type="submit" value="buscar" name="seek" class="boton"/><p align="right"><a href="buscar.php" target="_self">Busqueda Simple</a></p>
</form>
</tr></td>
</table>
<br/>
<br/>
<table class="rs" border="0" width="800">
<?php
	if (isset($_POST["seek"])) {
	$vinculo = conectar();
	if (isset($_POST["user"]) && trim($_POST["user"]) != "") {
		$nick = "'%".$_POST["user"]."%'";
	}
	else {
		$nick = "nick_user";
	}
	if (isset($_POST["sub"]) && trim($_POST["sub"]) != "") {
		$sub = $_POST["sub"];
	}
	else {
		$sub= "id_sub";
	}
	$rs=mysql_query("SELECT nom_post, tags_post, prior_post, nick_user, nom_sub, id_post ".
		"FROM MPost NATURAL JOIN MUsuario NATURAL Join CSubcategoria ".
		"WHERE id_sub = $sub AND UPPER(nick_user) LIKE UPPER($nick) ".
		"ORDER BY prior_post DESC");
	$sres = array();
	//mysql_real_escape_string
	while($rw = mysql_fetch_array($rs))
		{
		$srch=explode(" ",strtolower($_POST['search']));
		$tags=explode(",",$rw['tags_post']);
		$busk=array_intersect($srch,$tags);
		$con = 0;
		foreach ($srch as $src) {
			if (preg_match("#\b".preg_quote($src, "#")."\b#iu", $rw["nom_post"])) {
				$con++;
			}
		}
		if (sizeof($busk) > 0 || $con > 0) {
			$sres[sizeof($sres)] = "<tr><td><p align=\"justify\"><a href=\"verpost.php?id=".$rw['id_post']."\" target=\"_blank\">".$rw['nom_post']."</a></p></td></tr>";
		}
		}
	// Ordenar aqui $sres
	foreach ($sres as $sresi) {
		echo $sresi;
	}
	}
} 
?>
<? include "foot.php";?>
</table>
</body>
</html>
