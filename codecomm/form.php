<?php
	print
			$form_encabezado.
			$form_nombre.$form_nombre_medio.$form_nombre_final.
			$form_apellidos.$form_apellidos_medio.$form_apellidos_final.
			$form_fecha.$form_fecha_final.
			$form_email."\"><select name=\"dominio\">\n".lista_dominio($vinculo)."</select>\n".$form_email_medio.$form_email_final.
			$form_pais.lista_pais($vinculo).$form_pais_medio.$form_pais_final.
			$form_usuario.$form_usuario_medio.$form_usuario_final.
			$form_contrasena.$form_contrasena_final.
			$form_confirmacion.$form_confirmacion_final.
			$form_captcha.$form_captcha_final.
			$form_terminos.$form_terminos_final.
			$form_enviar;
?>