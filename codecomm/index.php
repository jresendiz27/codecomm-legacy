<?php
	include ("header.php");
	include ("postlib.php");
?>
		<td valign="top" align="center" colspan="2">
			<br>
			<p class="advice">ADVERTENCIA: CodeComm se encuentra actualmente puliendo los &uacute;ltimos detalles. A pesar de que se asegura su completa funcionalidad, todav&iacute;a pueden existir varios bichos. Gracias por su comprensi&oacute;n.</p>
			<br></tr>
		<tr><td align="center">
			<table class="post" width="359">
			<tr>
			<td class="postheader" colspan="2"><br/>Noticias Codecomm<br/><br/></td></tr>
			<tr><td width="50" height="300" rowspan="5" class="recentlynews"></td></tr>
<?php
	$result = mysql_query("SELECT * FROM MPost WHERE id_sub = 2 ORDER BY fec_post DESC", $vinculo);
	$num = 0;
	while (($fila = mysql_fetch_array($result)) && ($num < 3)) {
		print "<tr><td><br/><br/><a href=\"verpost.php?id=".$fila["id_post"]."\">".htmlspecialchars($fila["nom_post"], ENT_COMPAT, 'UTF-8')."</a></td></tr>";
		if ($num == 0) {
			print "<tr><td><span style=\"font-size: 85%;display: block; overflow: hidden;\">"
				.preg_replace("#&aacute;([\w\W]*?)&eacute;#u", "<$1>" , preg_replace("#<[\w\W]*#u", "", preg_replace("#<([\w\W]*?)>#u", "&aacute;$1&eacute;", substr(replacebb(true, true, "", $fila["cuerpo_post"]), 0, 200))))
				."... <br/><br/><a href=\"verpost.php?id=".$fila["id_post"]."\">Mas+</a></span></td></tr>";
		}
		$num++;
	}
?>
			</table>
		</td>
		<td align="center"><img src="images/code_news.png" width="204" height="243" align="middle"/></td>
		<tr>
		<td align="center"><img src="images/new_post.png" width="204" height="243" align="middle"/></td>
		<td valign="top" align="center">
			<br/>
			<br/>
			<table class="post" width="350">
			<tr>
			<td class="postheader" colspan="3"><br/>Posts Recientes<br/><br/></td></tr>
			<tr><td width="50" rowspan="12" class="recently" height="300"></td></tr>
<?php
	$result = mysql_query("SELECT * FROM MPost NATURAL JOIN MUsuario NATURAL JOIN CSubcategoria ORDER BY fec_post DESC LIMIT 0,5", $vinculo);
	while ($fila = mysql_fetch_array($result)) {?>
		<tr><td colspan="2" style="text-align:justify;">
		<img src="images/icons/<? echo $fila['id_cat'];?>.gif" width="14" height="14"/><a href="verpost.php?id=<? echo $fila["id_post"];?>"><?echo htmlspecialchars($fila["nom_post"], ENT_COMPAT, 'UTF-8'); ?></a></td></tr><tr><td width="50%" align="right"></td><td><img src="images/classic/1.gif" width="15" height="13"/><a href="perfil.php?id=<? echo $fila['id_user'];?>"><?echo htmlspecialchars($fila["nick_user"]); ?></a></td></tr>		
	<?php } ?>			
			</table>
			<br/>
		<br>
		</td>
	</tr>
	
	<tr>
		<td align="center">
		<br/>
		<br/>
		<table class="post" width = "359">
		<tr>
			<td class="postheader" colspan="3"><br/>Novatos<br/><br/></td></tr>
			<tr><td width="50" rowspan="12" class="noobs" height="300"></td></tr>	
		<?php
		$result = mysql_query("SELECT * FROM MUsuario ORDER BY id_user DESC LIMIT 0,5", $vinculo);
		while($fila = mysql_fetch_array($result))
			{
		print "<tr><td><br/><img src=\"images/classic/1.gif\" width=\"15\" height=\"13\"/><a href=\"perfil.php?nick=".htmlspecialchars($fila["nick_user"])."\">".$fila["nick_user"]."</a></li><br/></td></tr>";
			}
			mysql_free_result($result);
		?>
		</table>
		<br>
		</td>
		<td align="center"><img src="images/novatos.png" align="middle" width="320" height="245"/></td>
		</tr>
	<tr rowspan="2" class="nose" width="800"> 
	<td colspan="2" class="nose"height="100">
	<table width="700" align="center" style="text-align:center;">
	<tr>
	<td colspan="5"><p style="color:#fff;text-decoration:none;font-size:12px;">P&aacute;ginas Amigas</p></td>
	</tr>
	<tr>
	<td><a class="amigos" href="http://www.google.com.mx" target="_blank">Google M&eacute;xico</a></td>
	<td><a class="amigos" href="http://mx.yahoo.com" target="_blank">Yahoo! M&eacute;xico</a></td>
	<td><a class="amigos" href="http://www.taringa.net" target="_blank">Taringa!</a></td>
	<td><a class="amigos" href="http://www.mediafire.com" target="_blank">Mediafire</a></td>
	<td><a class="amigos" href="http://mx.youtube.com" target="_blank">Youtube M&eacute;xico</a></td>
	</tr>
	</table></td>
	</tr>
	</table>
	<?php include ("foot.php");?>
