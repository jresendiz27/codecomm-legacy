<?php
	include "curpage.php";
	include "conectar.php";
	$vinculo = conectar();
	mysql_query ("SET NAMES 'utf8'");
	include "sesion.php";
	include "skin.php";
	include "welcome.php";
	include "categorias.php";
	$navegador = getenv("HTTP_USER_AGENT");
	function browser_info($agent=null) {
  // Declare known browsers to look for
  $known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape',
    'konqueror', 'gecko');

  // Clean up agent and build regex that matches phrases for known browsers
  // (e.g. "Firefox/2.0" or "MSIE 6.0" (This only matches the major and minor
  // version numbers.  E.g. "2.0.0.6" is parsed as simply "2.0"
  $agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
  $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';

  // Find all phrases (or return empty array if none found)
  //if (!preg_match_all($pattern, $agent, $matches)) return array();

  // Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
  // Opera 7,8 have a MSIE phrase), use the last one found (the right-most one
  // in the UA).  That's usually the most correct.
  $i = count($matches['browser'])-1;
  return $matches['browser'][$i].",".$matches['version'][$i];
}
//$navegador=get_browser();
$ua = explode(",",browser_info());
//echo $ua[0];
//echo "<br>";
//echo $ua[1];
	if (preg_match("/MSIE/i", "$navegador")&&intval($ua[1])<8) 
	{
	//echo "se cumple";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
	<meta name="description" content="Informatic Systems Developers IPN CECyT 9">
    <meta name="keywords" content="empresa,comunidad,insysdev,voca,9,voca9,batiz,cecyt 9,ipn,programacion,php,funcionabilidad,mision,vision,estrategias">
	<meta name="google-site-verification" content="3Ij9UhV90M5PhE5iJRiyKzpUNxVNWgh4LohzEbLbzCY" />
	<meta name="msvalidate.01" content="035C6528713A72960D2238C59576EFF8" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<? if(preg_match("/index/",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>CodeComm - Inicio</title>
		<? } if(preg_match("/verpost/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>CodeComm - 
		<?php
		$title;
		$url=$_SERVER['REQUEST_URI'];
		$url_array=explode("=",$url);
		$post_id=intval($url_array[1]);
		$vinculo=conectar();
		$result=mysql_query("SELECT nom_post FROM MPost WHERE id_post=$post_id",$vinculo);
		while($row=mysql_fetch_array($result))
			{
			$title=$row['nom_post'];
			}
		echo $title;
		?>		
		</title>
		<? } if(preg_match("/perfil/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>CodeComm - Perfil de
		<?php
		$url=$_SERVER['REQUEST_URI'];
		$url_array=explode("=",$url);
		$usernick=$url_array[1];
		echo $usernick;
		?>
		</title>
		<? } else if(isset($_GET['id'])){
		$iduser=intval($_GET['id']);
		$result=mysql_query("SELECT nick_user FROM MUsuario WHERE id_user=$iduser",$vinculo);
		if(mysql_num_rows($result)==1)
			{
			while($row=mysql_fetch_array($result))
				{
				echo htmlspecialchars($row['nick_user']);
				}
			}
		}?>
		
		<? if(preg_match("/msg/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>CodeComm - 
		<?php
		$url=$_SERVER['REQUEST_URI'];
		$url_array=explode("=",$url);
		$title=$url_array[1];
		if(preg_match("/new/i",$title))
		{
		$title="Nuevo Mensaje";
		echo $title;
		}
		if(preg_match("/inbox/i",$title))
		{
		$title="Mensajes Recibidos";
		echo $title;
		}
		if(preg_match("/send/i",$title))
		{
		$title="Mensajes Enviados";
		echo $title;
		}
		?>
		</title>
		<? } ?>
		<? if(preg_match("/useredit/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>Codecomm - Modificar informaci&oacute;n </title>	
		<? 
		}else{?>
		<title>Codecomm - InSysDev</title>
		<?}?>
		<link href="<?php echo $csstheme; ?>" media="screen" rel="StyleSheet" type="text/css">
		<link href="iex_classic.css" media="screen" rel="StyleSheet" type="text/css">
		<? if(isset($_SESSION["user"])) {
		$result=mysql_query("SELECT id_perfil FROM MUsuario WHERE nick_user='$_SESSION[user]'",$vinculo);
		if(mysql_num_rows>0)
		{
		while($row=mysql_fetch_array($result))
			{
			if(intval($row['id_perfil'])==1)//classic;crazy;coderadio
				{
				$profile="classic_profile.css";
				}
			else if(intval($row['id_perfil'])==2)
				{
				$profile="crazy_profile.css";
				}
			else
				{
				$profile="coderadio_profile.css";
				}
				
			}
		}
		?>
		<link href="<? echo $profile ;?>" media="screen" rel="StyleSheet" type="text/css">
		<?}?>
		<link rel="shortcut icon" href="cdcmm_ico.png"/>
		<script type = "text/javascript">
		function borra()
			{
			if (document.getElementById("comment").value=="Escribe un comentario...") 
				{
				document.getElementById("comment").value="";
				}
			}
		</script>
		<script type="text/javascript" src="scripts.js"></script>
	</head>
	<body>
		<?php echo $div;?>
		<center>
		<?php echo $br;?>
		<table width="800" height="120" border="0" class="tmain">
			<tr>
				<td colspan="10"><?php bienvenida($_SESSION['user']);?></td>
			</tr>
			<tr>
				<td colspan="10" class="header">
				</td>
			   
			
			</tr>
			<tr>
			<font size="6">
			<p class="iex_a">Al parecer tienes problemas con el diseño de la pagina, Codecomm te recomienda Firefox,Opera, Chrome o Safari como navegador web. <a href="http://www.mozilla.com/es-MX/?gclid=CJzY2uPHtqECFQ8bawod12re_A" target="_blank">¡Descarga Firefox aqui!</a></p>
			En su defecto, actualiza tu navegador a la version 8.<a href="http://www.microsoft.com/spain/windows/internet-explorer/" target="_blank">Internet Explorer 8.Click aqu&iacute;!</a>
			</font>
			</tr>
		</table>
        
<table width="800" border="0" align="center" class="general">
		<form action="index.php" method="post">
        <tr>
			<td valign = "top">
				<p class="acces"><a href="index.php" target="_self">Inicio</a></li><p>
			</td>	
			<td valign = "top">
				<p class="acces"><a href="#" >Comunidad</a></li><p>
			</td>
<?php if (!isset($_SESSION["user"])) { ?>
    
    <td colspan = 2 valign = "top" >
	<p class="access">&nbspUsuario&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="user" /></p>
    <p class="access">Contraseña&nbsp<input type="password" name="pass" /></p>
	<p class="access"><input type="submit" value="Acceder" name="login" /></p>
	</td>
    <td valign = "top">
	<p class="acces"><a href="registro.php">Registrate</a><p>
	</td>
<?php } else { ?>

  
	<td colspan = "3"  align = center  valign = "baseline">
	
	<table>
	<br>	
	<tr>
		<td valign = "baseline"><a href="index.php?theme=<?php echo $csstheme; ?>&close=1">Cerrar sesión</a></td>
		<td valign = "baseline"><a href="creacion.php">Crear post</a></td>
		<td valign = "baseline"><a href="perfil.php?nick=<?php echo $_SESSION["user"]; ?>">Mi Perfil</a></td>
	</tr>
	<tr>
		
		<td><br><a href="msg.php?data=new">Nuevo Mensaje</a></td>
		<td><br><a href="msg.php?data=inbox">Bandeja de entrada</a></td>
		<td><br><a href="msg.php?data=send">Enviados</a></td>
	</tr>
	</table>
  </td>
  

<?php } ?>
 
	<td width = "160" align = "left">
			<dl>
			<dt><a href="#">Temas</a></dt>
			<?php lista_skin_ex(); ?>
			</dl>
	</td>
	
	</tr>
	<tr>
	<?php lista_cat_ex(); ?>
	</tr>
	</form>
	</table>

	<table width="800" border="0" class="general" align="center"> 
    <tr>
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
	<meta name="description" content="Informatic Systems Developers IPN CECyT 9"/>
	<meta name="keywords" content="empresa,comunidad,insysdev,voca,9,voca9,batiz,cecyt 9,ipn,programacion,php,funcionabilidad,mision,vision,estrategias"/>
	<meta name="google-site-verification" content="3Ij9UhV90M5PhE5iJRiyKzpUNxVNWgh4LohzEbLbzCY" />
	<meta name="msvalidate.01" content="035C6528713A72960D2238C59576EFF8" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<? if(preg_match("/index/",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>CodeComm - Inicio</title>
		<? } if(preg_match("/verpost/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>CodeComm - 
		<?php
		$title;
		$url=$_SERVER['REQUEST_URI'];
		$url_array=explode("=",$url);
		$post_id=intval($url_array[1]);
		$vinculo=conectar();
		$result=mysql_query("SELECT nom_post FROM MPost WHERE id_post=$post_id",$vinculo);
		while($row=mysql_fetch_array($result))
			{
			$title=$row['nom_post'];
			}
		echo $title;
		?>		
		</title>
		<? } if(preg_match("/perfil/i",$_SERVER['REQUEST_URI'])!=0){
		$style="<!--hola-->";
		?>
		<title>CodeComm - Perfil de
		<?php
		if(isset($_GET['nick']))
		{
		$var="%".strtoupper($_GET['nick'])."%";/*"%".strtoupper($_GET['nick'])."%"*/
		$vinculo=conectar();
		$result=mysql_query("SELECT nick_user,id_perfil FROM MUsuario WHERE UPPER(nick_user) LIKE '$var'",$vinculo);
		if(mysql_num_rows($result)>0)
		{
		while($row=mysql_fetch_array($result))
			{
			$title=$row['nick_user'];
			if($row['id_perfil']==1)
					{
					$style="<link href=\"classic_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
				else if($row['id_perfil']==2)
					{
					$style="<link href=\"crazy_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
				else if($row['id_perfil']==3)
					{
					$style="<link href=\"coderadio_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
				else
					{
					$style="<link href=\"classic_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
			}
		echo $title;
		}
		}
		if(isset($_GET['id']))
		{
		$var=intval($_GET['id']);
		$vinculo=conectar();
		$result=mysql_query("SELECT nick_user,id_perfil FROM MUsuario WHERE id_user=$var",$vinculo);
		if(mysql_num_rows($result)>0)
		{
		while($row=mysql_fetch_array($result))
			{
			$title=$row['nick_user'];
			if($row['id_perfil']==1)
					{
					$style="<link href=\"classic_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
				else if($row['id_perfil']==2)
					{
					$style="<link href=\"crazy_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
				else if($row['id_perfil']==3)
					{
					$style="<link href=\"coderadio_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
				else
					{
					$style="<link href=\"classic_profile.css\" media=\"screen\" rel=\"StyleSheet\" type=\"text/css\">";
					}
			}
		echo $title;
		}
		else
		{
		echo "Chuck Norris";
		}
		}
		?>
		</title>
		<? 
		echo $style;
		} if(preg_match("/msg/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>CodeComm - 
		<?php
		$url=$_SERVER['REQUEST_URI'];
		$url_array=explode("=",$url);
		$title=$url_array[1];
		if(preg_match("/new/i",$title))
		{
		$title="Nuevo Mensaje";
		echo $title;
		}
		if(preg_match("/inbox/i",$title))
		{
		$title="Mensajes Recibidos";
		echo $title;
		}
		if(preg_match("/send/i",$title))
		{
		$title="Mensajes Enviados";
		echo $title;
		}
		?>
		</title>
		<? } ?>
		<? if(preg_match("/useredit/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>Codecomm - Modificar informaci&oacute;n </title>	
		<? }?>
		<? if(preg_match("/useredit/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>Codecomm - Modificar informaci&oacute;n </title>	
		<? }?>
		
		<? if(preg_match("/creacion/i",$_SERVER['REQUEST_URI'])!=0){ ?>
		<title>Codecomm - Crear Post </title>	
		<? }?>
		
		<? if(isset($_GET['cat'])){ ?>
		<title>CodeComm - 
		<?php
		$title;
		$url=intval($_GET['cat']);
		$vinculo=conectar();
		$result=mysql_query("SELECT nom_cat FROM CCategoria WHERE id_cat=$url",$vinculo);
		if(mysql_num_rows($result)>0)
		{
		while($row=mysql_fetch_array($result))
			{
			$title=$row['nom_cat'];
			}
			echo $title;
		}
		else
			{
			echo "InSysDev";
			}
		}?>		
		</title>
		
		
		<? if(isset($_GET['sub'])){ ?>
		<title>CodeComm - 
		<?php
		$title;
		$url=intval($_GET['sub']);
		$vinculo=conectar();
		$result=mysql_query("SELECT nom_sub FROM CSubcategoria WHERE id_sub=$url",$vinculo);
		if(mysql_num_rows($result)>0)
		{
		while($row=mysql_fetch_array($result))
			{
			$title=$row['nom_sub'];
			}
			echo $title;
		}
		else
			{
			echo "InSysDev";
			}
		?>	
		<? }else{?>
		<title>Codecomm - InSysDev</title>
		<?}?>		
		</title>
		
		
		<link href="<?php echo $csstheme ?>" media="screen" rel="StyleSheet" type="text/css">
		<link rel="shortcut icon" href="cdcmm_ico.png"/>
		<script type="text/javascript" src="scripts.js"></script>		
		<style TYPE="text/css"><!--
		.boton
		{
        font-size:10px;
        font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#638cb5;
        border:0px;
        width:80px;
        height:19px;
		}
		.field
		{
		font-family:Verdana,Helvetica;
		color:#000000;
		background:#9ACD32;
		height:19px;
		font-style:italic;
		}
		-->
		</style>
		<script type = "text/javascript">
		
	function muestraReloj() 
		{
  		var fechaHora = new Date();
		var horas = fechaHora.getHours();
  		var minutos = fechaHora.getMinutes();
  		var segundos = fechaHora.getSeconds();
 
 	 	if(horas < 10) { horas = '0' + horas; }
  		if(minutos < 10) { minutos = '0' + minutos; }
  		if(segundos < 10) { segundos = '0' + segundos; }
 
  		document.getElementById("date").innerHTML = horas+':'+minutos+':'+segundos;
		}


	window.onload = function() 
		{
  		setInterval(muestraReloj, 1000);
		}

		function borra()
			{
			if (document.fcomment.comment.value=="Escribe un comentario...") 
				{
				document.fcomment.comment.value="";
				}
			}
		function mostrar() {
		div = document.getElementById('login');
		//div.style.float ='left';
		//div.style.width ='250';
		//div.style.height ='400';
		div.style.display = 'inline';
		//div.style.position ='relative';
		}
	
		function cerrar() {
		div = document.getElementById('login');
		div.style.display='none';

		}
		</script>
	</head>
	<?if(preg_match("/creacion/i",$_SERVER['REQUEST_URI'])!=0){?>
	<body onload="focusito();setInterval(muestraReloj,1000);">
	<?} else if(preg_match("/verpost/i",$_SERVER['REQUEST_URI'])!=0){?>
	<body onload="setInterval(muestraReloj,1000);">
	<? } else { ?>
	<body>
	<? } ?>
		<?php echo $div;?>
		<center>
		<?php echo $br;?>
		<table width="800" height="120" border="0" class="tmain">
			<tr>
				<td colspan="9"><?php bienvenida($_SESSION['user']);?></td>
				<td><p id="date" align="center" class="date"></td>
			</tr>
			<tr>
				<td colspan="10" class="header" height="100">
					
				</td>
			</tr>
			
		</table>
		
	<br/>
		<table width="800" border="0" class="tmain">
			<tr>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="index.php" target="_self">Inicio</a></li>
					</ul>
					</div>
				</td>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="#" >Comunidad</a></li>
					</ul>
					</div>
				</td>
<?php if (!isset($_SESSION["user"])) { ?>
				<td height="37" class="tmenu">	
				<div class="menu">
				<ul>
				<li><a href="javascript:mostrar();">Accede</a></li>
				</ul>
				</div>
					<div class="login" id="login" style="display:none;clear:left;">	
							<center><a href="javascript:cerrar();" class="links"><img src="images/hide.gif" align="middle" width="20" height="10" border="0"/></a></center>
								<form action="index.php" method="post" onsubmit="javascript:cerrar();">
									<p class="access">Usuario</p> 
									<p align="center"><input type="text" name="user" value="user" /></p>
									<p class="access">Contraseña</p>
									<p align="center"><input type="password" name="pass" value="password" /></p>
									<hr/>
									<center><input name="login" type="submit" value="Acceder" /></center>
									<hr/>
									<p class="access" style="font-size:80%;"><a href="password.php">Recuperar contraseña</a></p>
									<p></p>
								</form>
					</div>
				</td>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="registro.php">Registrate</a></li>
					</ul>
					</div>
				</td>
<?php }  else { ?>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="perfil.php?nick=<?php echo htmlspecialchars($_SESSION["user"]) ?>"><?php echo htmlspecialchars($_SESSION["user"]); ?></a>
						<ul>
							<li><a href="perfil.php?nick=<?php echo htmlspecialchars($_SESSION["user"]); ?>">Perfil</a></li>
							<li><a href="creacion.php">Crear post</a></li>
							<li><a href="msg.php?data=new">Nuevo mensaje</a></li>
							<li><a href="msg.php?data=inbox">Bandeja de entrada</a></li>
							<li><a href="msg.php?data=send">Enviados</a></li>
							<li><a href="index.php?theme=<?php echo $csstheme; ?>&close=1">Cerrar sesión</a></li>
						</ul>
						</li>
					</ul>
					</div>
				</td>
<?php } ?>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="#">Temas</a>
							<ul>
								<?php lista_skin() ?>
							</ul>
						</li>
					</ul>
					</div>
				</td>
			</tr>
		</table>
		<table width="800" border="0" class="tmain">
			<tr>
				<?php lista_cat() ?>
			</tr>
		</table>
		<? if(preg_match("/buscar/i",$_SERVER['REQUEST_URI'])==0){?>
		<br/>
		<div align="center" style="width: 800px;">
		<table border="0" align="right">
				<tr>
				<td>
				<form action="buscar.php" method="get">
				<input type="text" maxlength="255" size="60" name="search" value="<?php echo $_GET["search"]; ?>" class="field"/>
				<input type="submit" value="buscar" class="boton"/>
				<input type="hidden" name="seek" value="seek"/>
				</form>
				</td>
				</tr>
				</table>
		</div>
		<br/>
		<? } ?>
		<table width="800" class="general" name="maintable" id="maintable"><tr>
<?php } ?>
