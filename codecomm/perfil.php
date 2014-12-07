<?php 
include ("header.php");
$vinculo=conectar();
if (isset($_GET['nick']) || isset($_GET['id'])) {
	if (isset($_GET['id'])) {
		$id_user = intval($_GET['id']);
		$result = mysql_query("select * from MUsuario NATURAL JOIN CPais NATURAL JOIN CDominio where id_user ='$id_user'",$vinculo);
	}
	else if (isset($_GET['nick'])) {
		$nickuser = "%".strtoupper($_GET['nick'])."%";
		$result = mysql_query("select * from MUsuario NATURAL JOIN CPais NATURAL JOIN CDominio where UPPER(nick_user) LIKE '$nickuser'",$vinculo);
	}
	if(mysql_num_rows($result)==1)
		{
	    /*CREATE TABLE `musuario` (
		`id_user` int(11) NOT NULL auto_increment,
		`nom_user` varchar(100) NOT NULL,
		`ap_user` varchar(200) NOT NULL,
		`nick_user` varchar(20) NOT NULL,
		`nac_user` date default NULL,
		`email_user` varchar(254) NOT NULL,
		`id_dom` int(11) default NULL,
		`id_pais` char(2) NOT NULL,
		`pass_user` varchar(20) NOT NULL,
		`id_tipo` int(11) NOT NULL,
		`bans_user` tinyint(4) NOT NULL,
		`fecban_user` datetime default NULL,
		`id_skin` int(11) NOT NULL,
		`avatar_user` varchar(255) default NULL,
		`vernom_user` tinyint(1) NOT NULL,
		`vernac_user` tinyint(1) NOT NULL,
		`veremail_user` tinyint(1) NOT NULL,
		PRIMARY KEY  (`id_user`),
		UNIQUE KEY `nick_user` (`nick_user`),
		KEY `id_dom` (`id_dom`),
		KEY `id_pais` (`id_pais`),
		KEY `id_tipo` (`id_tipo`),
		KEY `id_skin` (`id_skin`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;*/
		
		//$result2=("",$vinculo); para realizar los cambios al perfil
		$name;
		$fnac;
		$email;
		$tipo;
		$pais;
		$tema;		
			while($row=mysql_fetch_array($result))
				{
				$tema=intval($row['id_perfil']);
				if($tema==1)
					{
					$style="<link href=\"classic_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					$tema="classic";
					}
				else if($tema==2)
					{
					$style="<link href=\"crazy_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					$tema="crazy";
					}
				else if($tema==3)
					{
					$style="<link href=\"coderadio_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					$tema="coderadio";
					}
				else
					{
					$style="<link href=\"classic_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					$tema="classic";
					}
				$nickuser = $row['nick_user'];
				$id = $row['id_user'];
				// procedo a las validaciones
				if ($_SESSION['user'] == $nickuser) {
					$show = intval($_GET['show']);
					$hide = intval($_GET['hide']);
					if ($hide == 1) {
						mysql_query ("UPDATE MUsuario SET vernom_user = 0 WHERE id_user = $id");
						$row['vernom_user'] = 0;
					}
					else if ($hide == 2) {
						mysql_query ("UPDATE MUsuario SET vernac_user = 0 WHERE id_user = $id");
						$row['vernac_user'] = 0;
					}
					else if ($hide == 3) {
						mysql_query ("UPDATE MUsuario SET veremail_user = 0 WHERE id_user = $id");
						$row['veremail_user'] = 0;
					}
					if ($show == 1) {
						mysql_query ("UPDATE MUsuario SET vernom_user = 1 WHERE id_user = $id");
						$row['vernom_user'] = 1;
					}
					else if ($show == 2) {
						mysql_query ("UPDATE MUsuario SET vernac_user = 1 WHERE id_user = $id");
						$row['vernac_user'] = 1;
					}
					else if ($show == 3) {
						mysql_query ("UPDATE MUsuario SET veremail_user = 1 WHERE id_user = $id");
						$row['veremail_user'] = 1;
					}
					if($row['vernom_user']==0)
						{
						$nombre="<a href=\"perfil.php?nick=".$nickuser."&show=1\" target=\"_self\">Mostrar</a>";
						}
					else
						{
						$nombre=$row['nom_user']." ".$row['ap_user']."<br><a href=\"perfil.php?nick=".$nickuser."&hide=1\">Ocultar</a>";
						}
					if($row['vernac_user']==0)
						{
						$fnac="<a href=\"perfil.php?nick=".$nickuser."&show=2\" target=\"_self\">Mostrar</a>";
						}
					else
						{
						$fnac=$row['nac_user']."<br><a href=\"perfil.php?nick=".$nickuser."&hide=2\">Ocultar</a>";
						}
					if($row['veremail_user']==0)
						{
						$email="<a href=\"perfil.php?nick=".$nickuser."&show=3\" target=\"_self\">Mostrar</a>";
						}
					else
						{
						$email=$row['email_user']."@hotmail.com"."<br><a href=\"perfil.php?nick=".$nickuser."&hide=3\">Ocultar</a>";
						}
					}
				else 
					{
					if($row['vernom_user']==0)
						{
						$nombre="Secreto";
						}
					else
						{
						$nombre=htmlentities($row['nom_user'], ENT_COMPAT, 'UTF-8')." ".$row['ap_user'];
						}
					if($row['vernac_user']==0)
						{
						$fnac="Secreto";
						}
					else
						{
						$fnac=$row['nac_user'];
						}
					if($row['veremail_user']==0)
						{
						$email="Secreto";
						}
					else
						{
						$email=htmlspecialchars($row['email_user']).$row['nom_dom'];
						}
					}
				
				//tipo de usuario
				if($row['id_tipo']==1)//general
					{
					$tipo="General";
					}
				else if($row['id_tipo']==2)//moderador
					{
					$tipo="Moderador";
					}
				else if($row['id_tipo']==3)//Baneador
					{
					$tipo="Modo Dios";
					}
				else
					{
					$tipo="Cosa";
					}
				if($row['avatar_user']==""||$row['avatar_user']==null||$row['avatar_user']=="null")
					{
					$avatar="default.gif";
					}
				else
					{
					$avatar="users/".$row['avatar_user'];
					}
				$size = getimagesize($avatar);
				if ($size[0] > $size[1]) {
					$mult = 100 / $size[0];
				}
				else {
					$mult = 100 / $size[1];
				}
				$pais = $row['nom_pais'];
				$bancant = intval($row["bans_user"]);
				$fecban = $row['fecban_user'];
				$tipootro = $row['id_tipo'];
				}
			if ((!isset($_POST["ban"]) && !isset($_POST["unban"])) || ($tipo_user != 3 && $tipo_user != 2)) {
		?>
    <td align="center">
<?php
				if (strcmp($_SESSION["user"], $nickuser) == 0) {
?>
	</tr>
	<tr>
		<td colspan="2" align="center">
		</td>
<?php
				}
				if (($tipootro != 3) && ($tipo_user == 3 || $tipo_user == 2) && (strcmp($_SESSION["user"], $nickuser) != 0)) {
					if (strcmp($fecban, "") != 0) {
						date_default_timezone_set("UTC");
						$fecha = date("Y-m-d H:i:s");
						$fechadiv1 = preg_split("#[ :\-]#", $fecban);
						$fechadiv2 = preg_split("#[ :\-]#", $fecha);
						$tiempo1 = mktime ($fechadiv1[3], $fechadiv1[4], $fechadiv1[5], $fechadiv1[1], $fechadiv1[2], $fechadiv1[0]);
						$tiempo2 = mktime ($fechadiv2[3], $fechadiv2[4], $fechadiv2[5], $fechadiv2[1], $fechadiv2[2], $fechadiv2[0]);
						if (($tiempo2 - $tiempo1) > (60*60*24*28)) {
					?></tr><tr><td colspan="2" align="center"><form action="perfil.php?nick=<?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8'); ?>" method="post"><input type="submit" value="Banear" name="ban"></form></td>
<?php
						}
						else {
						?></tr><tr><td colspan="2" align="center">Usuario Baneado... <form action="perfil.php?nick=<?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8'); ?>" method="post"><input type="submit" value="Remover Ban" name="unban"></form></td>
<?php
						}
					}
					else {
					?><center><form action="perfil.php?nick=<?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8'); ?>" method="post"><input type="submit" value="Banear" name="ban"></form></center>
<?php
					}
				} ?>
  </tr>
  <tr>
	<td colspan="2">
	</td>
  </tr>
</table>
<?php
			} else if (isset($_POST["ban"]) && (($tipo_user == 3) || ($tipo_user == 2)) && ($tipootro != 3)) {
					$bancant = $bancant + 1;
					date_default_timezone_set("UTC");
					$fecha = date("Y-m-d H:i:s");
					if (strcmp($fecban, "") != 0) {
						$fechadiv1 = preg_split("#[ :\-]#", $fecban);
						$fechadiv2 = preg_split("#[ :\-]#", $fecha);
						$tiempo1 = mktime ($fechadiv1[3], $fechadiv1[4], $fechadiv1[5], $fechadiv1[1], $fechadiv1[2], $fechadiv1[0]);
						$tiempo2 = mktime ($fechadiv2[3], $fechadiv2[4], $fechadiv2[5], $fechadiv2[1], $fechadiv2[2], $fechadiv2[0]);
						if (($tiempo2 - $tiempo1) > (60*60*24*28)) {
							mysql_query ("UPDATE MUsuario SET fecban_user = '$fecha', bans_user = $bancant WHERE id_user = $id", $vinculo);
							if ($bancant > 3) {
								mysql_query ("UPDATE MUsuario SET id_tipo = 3 WHERE id_user = $ciertoid", $vinculo);
							}
						}
					}
					else {
						mysql_query ("UPDATE MUsuario SET fecban_user = '$fecha', bans_user = $bancant WHERE id_user = $id", $vinculo);
						if ($bancant > 3) {
							mysql_query ("UPDATE MUsuario SET id_tipo = 3 WHERE id_user = $ciertoid", $vinculo);
						}
					}
					$fecban = $fecha;
			?>
			<td>Baneado</td></tr></table>
<?php 
			} else if (isset($_POST["unban"]) && (($tipo_user == 3) || ($tipo_user == 2))) {
				$bancant = $bancant - 1;
				if ($bancant < 0) {
					$bancant = 0;
				}
				mysql_query ("UPDATE MUsuario SET fecban_user = null, bans_user = $bancant WHERE id_user = $id", $vinculo);
				$fecban = "";
			?>
			<td>Ban removido</td></tr></table>
<?php
			}
		} else { ?>
<td>Error: No existe usuario </td></tr></table>
<?php
		}
	} else { ?>
<td>Error. Nada seleccionado </td></tr></table>
<?php } ?>

<!--

huevos a todos

-->
<?if(($_GET['nick']=="pepo27")||($_GET['nick']=="pepo")) { ?>
<script language="JavaScript1.2">
hex=0;
hex1=0;
hex2=255;
function fadetext(){ 
if(hex<256) { //If color is not black yet
hex+=1; // increase color darkness
hex1+=1;
hex2-=1;
/*
rgb(0,0,255)  azul
rgb(255,0,0)  rojo
*/
document.getElementById("sample").style.color="rgb("+hex+","+0+","+hex2+")";
setTimeout("fadetext()",20); 
}
else
{
hex=0;
hex1=0;
hex2=255;
}
}
window.onload = function()
 {
 setInterval(fadetext, 1000);
 setInterval(muestraReloj, 1000);
 } 
</script>
<? } ?>
<table width="800" height="935" border="0" class="<?echo $tema;?>">
	<tr>
	<td colspan="3"><p class="<? echo $tema."1"; ?>" id="sample">Perfil de <?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8');?></p></td>
	</tr>
  <tr>
    <td width="234" height="233" align="center"><img src="<?php echo $avatar; ?>" width="<?php echo $size[0] * $mult; ?>" height="<?php echo $size[1] * $mult; ?>" /></td>
    <td colspan="2">
	<center>
      <table height="177" border="0" class="<? echo $tema."info"; ?>">
          <tr>
            <td width="89">Nombre</td>
            <td width="295"><?php echo $nombre;?></td>
          </tr>
          <tr>
            <td>Nick</td>
            <td><?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8');?></td>
          </tr>
          <tr>
            <td>Tipo</td>
            <td><?php echo htmlspecialchars($tipo, ENT_COMPAT, 'UTF-8');?></td>
          </tr>
          <tr>
            <td>Mail</td>
            <td><?php echo $email;?></td>
          </tr>
          <tr>
            <td>Pa&iacute;s</td>
            <td><?php echo $pais?></td>
          </tr>
          <tr>
            <td>Naci&oacute;</td>
            <td><?php echo $fnac;?></td>
          </tr>
          <tr>
            <td colspan="2">
			<? if (strcmp($_SESSION["user"], $nickuser) == 0){?>
			<table border="0" width="300" class="<? echo $tema."1";?>"><tr><td><a href="useredit.php">Editar perfil</a></td><td><a href="subir.php">Subir avatar</a></td></tr></table>
			<?}?>
			</td>
          </tr>
          <tr>
            <td colspan="2">
			
			<?php
				if (($tipootro != 3) && ($tipo_user == 3 || $tipo_user == 2) && (strcmp($_SESSION["user"], $nickuser) != 0)) {
					if (strcmp($fecban, "") != 0) {
						date_default_timezone_set("UTC");
						$fecha = date("Y-m-d H:i:s");
						$fechadiv1 = preg_split("#[ :\-]#", $fecban);
						$fechadiv2 = preg_split("#[ :\-]#", $fecha);
						$tiempo1 = mktime ($fechadiv1[3], $fechadiv1[4], $fechadiv1[5], $fechadiv1[1], $fechadiv1[2], $fechadiv1[0]);
						$tiempo2 = mktime ($fechadiv2[3], $fechadiv2[4], $fechadiv2[5], $fechadiv2[1], $fechadiv2[2], $fechadiv2[0]);
						if (($tiempo2 - $tiempo1) > (60*60*24*28)) {
					?><form action="perfil.php?nick=<?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8'); ?>" method="post"><input type="submit" value="Banear" name="ban"></form>
<?php
						}
						else {
						?>Usuario Baneado... <form action="perfil.php?nick=<?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8'); ?>" method="post"><input type="submit" value="Remover Ban" name="unban"></form>
<?php
						}
					}
					else {
					?><center><form action="perfil.php?nick=<?php echo htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8'); ?>" method="post"><input type="submit" value="Banear" name="ban"></form></center>
<?php
					}
				} ?>
			
			</td>
          </tr>
        </table>
    </center></td>
  </tr>
  <tr>
    <td height="40" align="center"><p class="<? echo $tema."header";?>">Post</p></td>
    <td align="center"><p class="<? echo $tema."header";?>">Favoritos</p></td>
    <td align="center"><p class="<? echo $tema."header";?>">Amigos</p></td>
  </tr>
  <tr>
    <td height="398" width="265">
	<table class="<? echo $tema."content"; ?>">
<?php
	$pagepost = 0;
	$pagefav = 0;
	if (isset($_GET["pagepost"])) {
		$pagepost = intval($_GET["pagepost"]);
	}
	if ($pagepost > 0) {
		$limitpost = $pagepost * 10;
	}
	else {
		$limitpost = 10;
		$pagepost = 1;
	}
	$pagefav = 0;
	if (isset($_GET["pagefav"])) {
		$pagefav = intval($_GET["pagefav"]);
	}
	if ($pagefav > 0) {
		$limitfav = $pagefav * 10;
	}
	else {
		$limitfav = 10;
		$pagefav = 1;
	}
	$result = mysql_query("select * from MUsuario NATURAL JOIN MPost WHERE UPPER(nick_user) ='$nickuser' ORDER BY fec_post DESC LIMIT $limitpost",$vinculo);
	if (mysql_num_rows($result) > 0) {
		while ($fila = mysql_fetch_array($result)) {
			echo "<tr><td><a href=\"verpost.php?id=".$fila["id_post"]."\">".htmlspecialchars($fila["nom_post"], ENT_COMPAT, 'UTF-8')."</a></td></tr>";
		}
		if ($limitpost < mysql_num_rows($result)) {
			echo "<tr><td><a href=\"perfil.php?nick=".htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8')."&pagepost=".($pagepost + 1)."&pagefav=".$pagefav."\">Ver más +</a></td></tr>";
		}
	}
	else {
		echo "<tr><td>No ha creado ningun post</td></tr>";
	}
?>
		</table>
	</td>
    <td width="265">
	<table class="<? echo $tema."content"; ?>">
<?php
	$remfav = 0;
	if (isset($_GET["remfav"])) {
		$remfav = intval($_GET["remfav"]);
	}
	if ($remfav > 0) {
		if (isset($_SESSION["user"])) {
			mysql_query("DELETE FROM MFavorito WHERE id_user = '$id_my_user' AND id_fav = '$remfav'");
		}
	}	
	$result = mysql_query("SELECT * FROM MUsuario INNER JOIN MFavorito ON MUsuario.id_user = MFavorito.id_user INNER JOIN MPost ON MFavorito.id_post = MPost.id_post WHERE UPPER(MUsuario.nick_user) = '$nickuser' ORDER BY MPost.nom_post LIMIT $limitfav",$vinculo);
	echo mysql_error();
	if (mysql_num_rows($result) > 0) {
		$filaarray = array();
		while ($fila = mysql_fetch_array($result)) {
			$filaarray[count($filaarray)] = array($fila);
		}
		unset($fila);
		foreach ($filaarray as $fila) {
			$id_fav = $fila[0]["id_fav"];
			echo "<tr><td><a href=\"verpost.php?id=".$fila[0]["id_post"]."\">".htmlspecialchars($fila[0]["nom_post"], ENT_COMPAT, 'UTF-8')."</a></td>";
			if (isset($_SESSION["user"])) {
				$result1 = mysql_query("SELECT * FROM MFavorito WHERE id_user = '$id_my_user' AND id_fav = '$id_fav' LIMIT 1",$vinculo);
				if (mysql_num_rows($result1) == 1) {
					echo "<td style=\"font-size:80%\"><a href=\"perfil.php?nick=".htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8')."&remfav=".$id_fav."\">Remover</a></td></tr>";
				}
			}
		}
		if ($limitfav < mysql_num_rows($result)) {
			echo "<tr><td><a href=\"perfil.php?nick=".htmlspecialchars($nickuser, ENT_COMPAT, 'UTF-8')."&pagepost=".$pagepost."&pagefav=".($pagefav + 1)."\">Ver más +</a></td></tr>";
		}
	}
	else {
		echo "<tr><td>No tiene favoritos</td></tr>";
	}
?>
		</table>
	</td>
    <td>Amigos[en desarrollo]</td>
  </tr>
  <tr>
    <td height="148" colspan="3" class="<? echo $tema."comments"; ?>">muestra comentarios[en desarrollo] </td>
  </tr>
  <tr>
    <td colspan="3">comentarios[en desarrollo]</td>
  </tr>
</table>
<?php include "foot.php" ?>
