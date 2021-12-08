<?php
// Version: 1.1 RC2; ModSettings

$txt['smf3'] = 'Esta p&aacute;gina te permite cambiar la configuraci&oacute;n de  las caracter&iacute;sticas, mods, y opciones b&aacute;sicas de tu foro.  Por favor revisa la <a href="' . $scripturl . '?action=theme;sa=settings;th=' . $settings['theme_id'] . ';sesc=' . $context['session_id'] . '">configuraci&oacute;n del tema</a> para m&aacute;s opciones.  Haz <i>clic</i> en los iconos de ayuda para m&aacute;s informaci&oacute;n acerca de alguna opci&oacute;n.';

$txt['mods_cat_features'] = 'Caracter&iacute;sticas b&aacute;sicas';
$txt['pollMode'] = 'Modo Encuesta';
$txt['smf34'] = 'Desactivar Encuestas';
$txt['smf32'] = 'Activar Encuestas';
$txt['smf33'] = 'Mostrar Encuestas como temas';
$txt['allow_guestAccess'] = 'Permitir a los visitantes navegar en el foro';
$txt['userLanguage'] = 'Activar Idioma seleccionado por el usuario';
$txt['allow_editDisplayName'] = '&iquest;Permitirle a los usuarios modificar su nombre?';
$txt['allow_hideOnline'] = '&iquest;Permitirle a los usuarios NO administradores ocultarse?';
$txt['allow_hideEmail'] = 'Permitirle a los usuarios esconder su email del p&uacute;blico (excepto a administradores)';
$txt['guest_hideContacts'] = 'No revelar detalles de contacto de los usuarios a los visitantes';
$txt['titlesEnable'] = 'Activar T&iacute;tulos Personalizado';
$txt['enable_buddylist'] = 'Activar Listas de Amigos';
$txt['default_personalText'] = 'Texto Personal por defecto';
$txt['max_signatureLength'] = 'N&uacute;mero m&aacute;ximo de caracteres permitido en firmas<div class="smalltext">(0 para que no haya m&aacute;x)</div>';
$txt['number_format'] = 'Formato de n&uacute;meros por defecto';
$txt['time_format'] = 'Formato de Tiempo por defecto';
$txt['time_offset'] = 'Diferencia horaria global<div class="smalltext">(agregado a las opciones espec&iacute;ficas de los usuarios.)</div>';
$txt['failed_login_threshold'] = 'Tiempo de espera al fallar un ingreso';
$txt['lastActive'] = 'Tiempo despu&eacute;s de su &uacute;ltima acci&oacute;n durante el cual los usuarios aparecer&aacute;n en l&iacute;nea';
$txt['trackStats'] = 'Rastrear Estad&iacute;sticas';
$txt['hitStats'] = 'Rastrear Hits (deben estar activadas las estad.)';
$txt['enableCompressedOutput'] = 'Activar Compresi&oacute;n de Salida';
$txt['databaseSession_enable'] = 'Usar sesiones almacenadas en la base de datos';
$txt['databaseSession_loose'] = 'Permitirle a los navegadores regresar a las p&aacute;ginas en el cache';
$txt['databaseSession_lifetime'] = 'Segundos para que expire una sesi&oacute;n no utilizada';
$txt['enableErrorLogging'] = 'Activar log de errores';
$txt['cookieTime'] = 'Duraci&oacute;n por defecto de las cookies para el ingreso (en minutos)';
$txt['localCookies'] = 'Activar el almacenamiento local de cookies<div class="smalltext">(SSI no funcionar&aacute; a&uacute;n con esto activado.)</div>';
$txt['globalCookies'] = '&iquest;Usar cookies independientes de subdominio?<div class="smalltext">&iexcl;Advertencia: Hay que deshabilitar las cookies locales primero!</div>';
$txt['securityDisable'] = '&iquest;Desactivar la seguridad en la administraci&oacute;n?';
$txt['send_validation_onChange'] = 'Enviar por email nueva contrase&ntilde;a si el usuario cambia su direcci&oacute;n de email';
$txt['approveAccountDeletion'] = 'Requerir la aprobaci&oacute;n de un administrador cuando un usuario borre su cuenta';
$txt['autoOptDatabase'] = '&iquest;Optimizar tablas cada cuantos d&iacute;as?<div class="smalltext">(0 para desactivar)</div>';
$txt['autoOptMaxOnline'] = 'M&aacute;ximos usuarios en l&iacute;nea mientras se optimiza<div class="smalltext">(0 para que no haya m&aacute;x)</div>';
$txt['autoFixDatabase'] = 'Arreglar tablas con problemas autom&aacute;ticamente';
$txt['allow_disableAnnounce'] = 'Permitir a los usuarios desactivar el recibir notificaciones de \'Foros de Anuncios\'';
$txt['disallow_sendBody'] = '&iquest;No permitir enviar el texto del mensaje en las notificaciones?';
$txt['modlog_enabled'] = 'Guardar log de las acciones de moderaci&oacute;n';
$txt['queryless_urls'] = 'Mostrar URLs sin ?s<div class="smalltext"><b>&iexcl;S&oacute;lo Apache!</b></div>';
$txt['max_image_width'] = 'Ancho m&aacute;ximo de las im&aacute;genes en los mensajes (0 = desactivar)';
$txt['max_image_height'] = 'Altura m&aacute;xima de las im&aacute;genes en los mensajes (0 = desactivar)';
$txt['mail_type'] = 'Tipo de Correo';
$txt['mail_type_default'] = '(Predeterminado de PHP)';
$txt['smtp_host'] = 'Servidor SMTP';
$txt['smtp_port'] = 'Puerto SMTP';
$txt['smtp_username'] = 'Usuario SMTP';
$txt['smtp_password'] = 'Contrase&ntilde;a SMTP';
$txt['enableReportPM'] = 'Activar el aviso de mensajes privados';

$txt['max_pm_recipients'] = 'Maximo n&uacute;mero de destinatarios permitidos en un mensaje privado.<div class="smalltext">(0 para ilimitado, exceptuando admins)</div>';

$txt['mods_cat_layout'] = 'Dise&ntilde;o (Temas)';
$txt['compactTopicPagesEnable'] = 'Activar Mod de Tema Compacto';
$txt['smf235'] = 'N&uacute;mero de p&aacute;ginas contiguas a mostrar:';
$txt['smf236'] = 'para mostrar';
$txt['todayMod'] = 'Activar Mod de Hoy';
$txt['smf290'] = 'Desactivado';
$txt['smf291'] = 'S&oacute;lo Hoy';
$txt['smf292'] = 'Hoy y Ayer';
$txt['topbottomEnable'] = 'Activar botones Ir Arriba/Ir Abajo';
$txt['onlineEnable'] = 'Mostrar Conectado/Desconectado en mensajes y en MP';
$txt['enableVBStyleLogin'] = 'Activar ingreso estilo VB';
$txt['defaultMaxMembers'] = 'Usuarios por p&aacute;gina en la Lista Completa de Usuarios';
$txt['timeLoadPageEnable'] = 'Mostrar tiempo tomado para crear cada p&aacute;gina';
$txt['disableHostnameLookup'] = '&iquest;Desactivar la b&uacute;squeda de los nombres de los servidores?';
$txt['who_enabled'] = 'Activar Qui&eacute;n est&aacute; en l&iacute;nea';

$txt['smf293'] = 'Karma';
$txt['karmaMode'] = 'Modo de Karma';
$txt['smf64'] = 'Desactivar Karma|Activar Karma Total|Activar Karma Positivo/Negativo';
$txt['karmaMinPosts'] = 'Especifica el m&iacute;nimo n&uacute;mero de mensajes necesarios para modificar el karma';
$txt['karmaWaitTime'] = 'Especifica el tiempo de espera en horas';
$txt['karmaTimeRestrictAdmins'] = 'Restringir Administradores a esperar';
$txt['karmaLabel'] = 'Etiqueta del Karma';
$txt['karmaApplaudLabel'] = 'Etiqueta Karma para aplaudir';
$txt['karmaSmiteLabel'] = 'Etiqueta Karma para castigar';

$txt['caching_information'] = '<div align="center"><b><u>&iexcl;Importante! Lee esto antes de activar estas caracter&iacute;sticas.</b></u></div><br />
	SMF soporta el cach&eacute; utilizado con aceleradores. Los aceleradores actualmente soportados son:<br />
	<ul>
		<li>APC</li>
		<li>eAccelerator</li>
		<li>Turck MMCache</li>
		<li>Memcached</li>
		<li>Zend Platform/Performance Suite (No Zend Optimizer)</li>
	</ul>
	El cach&eacute; s&oacute;lo funcionar&aacute; en tu servidor si tienes PHP compilado con uno de los optimizadores de arriba, o si tienes el cach&eacute; de memoria
	disponible. <br /><br />
	SMF guarda en cach&eacute; a varios niveles. Cuanto mayor es el nivel de cach&eacute; activado m&aacute;s tiempo de CPU se utilizar&aacute;
	para obtener la informaci&oacute; en cach&eacute;. Si est&aacute; disponible el cach&eacute; en tu m&aacute;quina es recomendable que intentes guardar en cach&eacute; al nivel 1 primero.
	<br /><br />
	Ten en cuenta que si utilizas el cach&eacute; de memoria necesitas proporcionar detalles del servidor en las opciones de abajo. Deber&iacute;as introducirlo como lista separada por comas
	como se muestra en el ejemplo de abajo:<br />
	&quot;servidor1,servidor2,servidor3:puerto,servidor4&quot;<br /><br />
	Ten en cuenta que si no se especifica el puerto, SMF utilizar&aacute; el puerto 11211. SMF intentar&aacute; realizar un balanceo aleatorio entre los servidores.
	<br /><br />
	%s
	<hr />';

$txt['detected_no_caching'] = '<b style="color: red;">SMF no ha podido detectar un acelerador compatible en tu servidor.</b>';
$txt['detected_APC'] = '<b style="color: green">SMF ha detectado que tu servidor tiene instalado APC.';
$txt['detected_eAccelerator'] = '<b style="color: green">SMF ha detectado que tu servidor tiene instalado eAccelerator.';
$txt['detected_MMCache'] = '<b style="color: green">SMF ha detectado que tu servidor tiene instalado MMCache.';
$txt['detected_Zend'] = '<b style="color: green">SMF ha detectado que tu servidor tiene instalado Zend.';

$txt['cache_enable'] = 'Nivel de Cach&eacute;';
$txt['cache_off'] = 'Sin cach&eacute;';
$txt['cache_level1'] = 'Nivel 1 de Cach&eacute;';
$txt['cache_level2'] = 'Nivel 2 de Cach&eacute; (No Recomendado)';
$txt['cache_level3'] = 'Nivel 3 de Cach&eacute; (No Recomendado)';
$txt['cache_memcached'] = 'Opciones de Cach&eacute; de Memoria';

?>