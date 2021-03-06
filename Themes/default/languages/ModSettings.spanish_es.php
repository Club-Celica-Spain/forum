<?php
// Version: 1.1.5; ModSettings

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
$txt['max_pm_recipients'] = 'Maximum number of recipients allowed in a personal message.<div class="smalltext">(0 for no limit, admin\'s are exempt)</div>';
$txt['pm_posts_verification'] = 'Post count under which users must enter code when sending personal messages.<div class="smalltext">(0 for no limit, admins are exempt)</div>';
$txt['pm_posts_per_hour'] = 'Number of personal messages a user may send in an hour.<div class="smalltext">(0 for no limit, moderators are exempt)</div>';

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

$txt['caching_information'] = '<div align="center"><b><u>Important! Read this first before enabling these features.</b></u></div><br />
	SMF supports caching through the use of accelerators. The currently supported accelerators include:<br />
	<ul>
		<li>APC</li>
		<li>eAccelerator</li>
		<li>Turck MMCache</li>
		<li>Memcached</li>
		<li>Zend Platform/Performance Suite (Not Zend Optimizer)</li>
	</ul>
	Caching will only work on your server if you have PHP compiled with one of the above optimizers, or have memcache
	available. <br /><br />
	SMF performs caching at a variety of levels. The higher the level of caching enabled the more CPU time will be spent
	retrieving cached information. If caching is available on your machine it is recommended that you try caching at level 1 first.
	<br /><br />
	Note that if you use memcached you need to provide the server details in the setting below. This should be entered as a comma separated list
	as shown in the example below:<br />
	&quot;server1,server2,server3:port,server4&quot;<br /><br />
	Note that if no port is specified SMF will use port 11211. SMF will attempt to perform rough/random load balancing across the servers.
	<br /><br />
	%s
	<hr />';

$txt['detected_no_caching'] = '<b style="color: red;">SMF has not been able to detect a compatible accelerator on your server.</b>';
$txt['detected_APC'] = '<b style="color: green">SMF has detected that your server has APC installed.';
$txt['detected_eAccelerator'] = '<b style="color: green">SMF has detected that your server has eAccelerator installed.';
$txt['detected_MMCache'] = '<b style="color: green">SMF has detected that your server has MMCache installed.';
$txt['detected_Zend'] = '<b style="color: green">SMF has detected that your server has Zend installed.';
$txt['detected_Memcached'] = '<b style="color: green">SMF has detected that your server has Memcached installed.';

$txt['cache_enable'] = 'Caching Level';
$txt['cache_off'] = 'No caching';
$txt['cache_level1'] = 'Level 1 Caching';
$txt['cache_level2'] = 'Level 2 Caching (Not Recommended)';
$txt['cache_level3'] = 'Level 3 Caching (Not Recommended)';
$txt['cache_memcached'] = 'Memcache settings';

?>