<?php
	print
			$form_encabezado.
			$form_nombre.$form_nombre_medio.$form_nombre_final.
			$form_apellidos.$form_apellidos_medio.$form_apellidos_final.
			$form_email."\"><select name=\"dominio\">\n".lista_dominio($vinculo, $fila)."</select>\n".$form_email_medio.$form_email_final.
			$form_pais.lista_pais($vinculo, $fila).$form_pais_medio.$form_pais_final.
			$form_tema.$form_tema_final.
			$form_actualpass.$form_actualpass_final.$form_contrasena.$form_contrasena_final.
			$form_confirmacion.$form_confirmacion_final.
			$form_enviar;
?>