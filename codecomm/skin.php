<?php
	if(isset($_GET["theme"])) {
		$thm = intval($_GET["theme"]);
	}
	else if (isset($_SESSION["user"])){
		$user = mysql_real_escape_string($_SESSION["user"]);
		$result = mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user)=UPPER('$user')",$vinculo);
		$fila = mysql_fetch_array($result);
		$id_user = $fila["id_user"];
		$result = mysql_query("SELECT * FROM CSkin NATURAL JOIN MUsuario WHERE id_user = $id_user");
		$fila = mysql_fetch_array($result);
		$thm = $fila["id_skin"];
	}
	else {
		$thm = intval($_SESSION["theme"]);
	}
	$br="<br>";
	$result = mysql_query("SELECT * FROM CSkin WHERE id_skin = $thm");
	$fila = mysql_fetch_array($result);
	if (!$fila) {
		$result = mysql_query("SELECT * FROM CSkin WHERE id_skin = 1");
		$fila = mysql_fetch_array($result);
	}
	$csstheme = $fila["css_skin"];
	
	$_SESSION["theme"] = $thm;
	
	if (isset($_SESSION["user"])) {
		$result = mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user)=UPPER('$user')",$vinculo);
		$fila = mysql_fetch_array($result);
		$id_user = $fila["id_user"];
		mysql_query("UPDATE MUsuario SET id_skin = $thm WHERE id_user = $id_user");
	}
	
	function lista_skin() {
		$result = mysql_query("SELECT * FROM CSkin");
		$curpage = curPageURL();
		if (preg_match("#\?#u", $curpage)) {
			$splitpage = preg_split("#\?#u", $curpage);
			$curpage = $splitpage[0]."?";
			$getarray = $_GET;
			unset($getarray["theme"]);
			$num = 0;
			foreach ($getarray as $getkey => $getelem) {
				if ($num == 0) {
					$curpage = $curpage.$getkey."=".$getelem;
				}
				else {
					$curpage = $curpage."&".$getkey."=".$getelem;
				}
				$num++;
			}
			if ($num == 0) {
				$curpage = $curpage."theme=";
			}
			else {
				$curpage = $curpage."&theme=";
			}
			unset($num);
		}
		else {
			$curpage = $curpage."?theme=";
		}
		while ($fila = mysql_fetch_array($result)) {
			echo "<li><a href=\"".htmlspecialchars($curpage.$fila["id_skin"], ENT_COMPAT, 'UTF-8')."\">".$fila["nom_skin"]."</a></li>";
		}
	}
	
	function lista_skin_ex() {
		$result = mysql_query("SELECT * FROM CSkin");
		$curpage = curPageURL();
		if (preg_match("#\?#u", $curpage)) {
			$splitpage = preg_split("#\?#u", $curpage);
			$curpage = $splitpage[0]."?";
			$getarray = $_GET;
			unset($getarray["theme"]);
			$num = 0;
			foreach ($getarray as $getkey => $getelem) {
				if ($num == 0) {
					$curpage = $curpage.$getkey."=".$getelem;
				}
				else {
					$curpage = $curpage."&".$getkey."=".$getelem;
				}
				$num++;
			}
			if ($num == 0) {
				$curpage = $curpage."theme=";
			}
			else {
				$curpage = $curpage."&theme=";
			}
			unset($num);
		}
		else {
			$curpage = $curpage."?theme=";
		}
		while ($fila = mysql_fetch_array($result)) {
			echo "<dd><a href=\"".$curpage.$fila["id_skin"]."\">".$fila["nom_skin"]."</a></dd>";
		}
	}
	
?>