<?php
// Version: 2.0.18; Index

global $forum_copyright, $forum_version, $webmaster_email, $scripturl, $context, $boardurl;

// Locale (strftime, pspell_new) and spelling. (pspell_new, can be left as '' normally.)
// For more information see:
//   - http://www.php.net/function.pspell-new
//   - http://www.php.net/function.setlocale
// Again, SPELLING SHOULD BE '' 99% OF THE TIME!!  Please read this!
$txt['lang_locale'] = 'es_ES';
$txt['lang_dictionary'] = 'es';
$txt['lang_spelling'] = 'spanish';

// Ensure you remember to use uppercase for character set strings.
$txt['lang_character_set'] = 'ISO-8859-1';
// Character set and right to left?
$txt['lang_rtl'] = false;
// Capitalize day and month names?
$txt['lang_capitalize_dates'] = true;

$txt['days'] = array('Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado');
$txt['days_short'] = array('Dom', 'Lun', 'Mar', 'Mi�', 'Jue', 'Vie', 'S�b');
// Months must start with 1 => 'January'. (or translated, of course.)
$txt['months'] = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$txt['months_titles'] = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$txt['months_short'] = array(1 => 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');

$txt['time_am'] = 'am';
$txt['time_pm'] = 'pm';

$txt['newmessages0'] = 'es nuevo';
$txt['newmessages1'] = 'son nuevos';
$txt['newmessages3'] = 'Nuevo(s)';
$txt['newmessages4'] = ',';

$txt['admin'] = 'Administraci�n';
$txt['moderate'] = 'Moderar';

$txt['save'] = 'Guardar';

$txt['modify'] = 'Modificar';
$txt['forum_index'] = '%1$s - �ndice';
$txt['members'] = 'Usuarios';
$txt['board_name'] = 'Nombre del foro';
$txt['posts'] = 'Mensajes';

$txt['member_postcount'] = 'Mensajes';
$txt['no_subject'] = '(Sin asunto)';
$txt['view_profile'] = 'Ver Perfil';
$txt['guest_title'] = 'Visitante';
$txt['author'] = 'Autor';
$txt['on'] = 'en';
$txt['remove'] = 'Eliminar';
$txt['start_new_topic'] = 'Crear nuevo tema';

$txt['login'] = 'Ingresar';
// Use numeric entities in the below string.
$txt['username'] = 'Usuario';
$txt['password'] = 'Contrase�a';

$txt['username_no_exist'] = 'Nombre de usuario no existente.';
$txt['no_user_with_email'] = 'No hay usuarios asociados a este email.';

$txt['board_moderator'] = 'Moderador del Foro';
$txt['remove_topic'] = 'Eliminar Tema';
$txt['topics'] = 'Temas';
$txt['modify_msg'] = 'Modificar mensaje';
$txt['name'] = 'Nombre';
$txt['email'] = 'Email';
$txt['subject'] = 'Asunto';
$txt['message'] = 'Mensaje';
$txt['redirects'] = 'Redirecciones';
$txt['quick_modify'] = 'Modificaci�n R�pida';

$txt['choose_pass'] = 'Escoge contrase�a';
$txt['verify_pass'] = 'Verifica contrase�a';
$txt['position'] = 'Grupo';

$txt['profile_of'] = 'Ver perfil de';
$txt['total'] = 'Total';
$txt['posts_made'] = 'Mensajes';
$txt['website'] = 'Web';
$txt['register'] = 'Registrarse';
$txt['warning_status'] = 'Estado de Advertencia';
$txt['user_warn_watch'] = 'El usuario est� en la lista de vigilados';
$txt['user_warn_moderate'] = 'Cola de aprobaci�n de mensajes de usuarios';
$txt['user_warn_mute'] = 'El usuario tiene restringida la publicaci�n de mensajes';
$txt['warn_watch'] = 'Vigilado';
$txt['warn_moderate'] = 'Moderado';
$txt['warn_mute'] = 'Enmudecido';

$txt['message_index'] = '�ndice de Mensajes';
$txt['news'] = 'Noticias';
$txt['home'] = 'Inicio';

$txt['lock_unlock'] = 'Bloquear/Desbloquear Tema';
$txt['post'] = 'Publicar';
$txt['error_occured'] = '�Un error ha ocurrido!';
$txt['at'] = 'a las';
$txt['logout'] = 'Salir';
$txt['started_by'] = 'Iniciado por';
$txt['replies'] = 'Respuestas';
$txt['last_post'] = '�ltimo mensaje';
$txt['admin_login'] = 'Ingresar a Administraci�n';
// Use numeric entities in the below string.
$txt['topic'] = 'Tema';
$txt['help'] = 'Ayuda';
$txt['terms_and_policies'] = 'T�rminos y Normativa';
$txt['notify'] = 'Notificar';
$txt['unnotify'] = 'Cancelar Notificaci�n';
$txt['notify_request'] = '�Deseas una notificaci�n por email si alguien responde a este tema?';
// Use numeric entities in the below string.
$txt['regards_team'] = 'Saludos,' . "\n" . 'El equipo de ' . $context['forum_name'] . '.';
$txt['notify_replies'] = 'Notificar respuestas';
$txt['move_topic'] = 'Mover tema';
$txt['move_to'] = 'Mover a';
$txt['pages'] = 'P�ginas';
$txt['users_active'] = 'Usuarios activos en los �ltimos %1$d minutos';
$txt['personal_messages'] = 'Mensajes Privados';
$txt['reply_quote'] = 'Responder con cita';
$txt['reply'] = 'Responder';
$txt['reply_noun'] = 'Respuesta';
$txt['approve'] = 'Aprobar';
$txt['approve_all'] = 'aprobar todo';
$txt['awaiting_approval'] = 'Esperando Aprobaci�n';
$txt['attach_awaiting_approve'] = 'Adjuntos esperando aprobaci�n';
$txt['post_awaiting_approval'] = 'Nota: Este mensaje est� esperando la aprobaci�n de un moderador.';
$txt['there_are_unapproved_topics'] = 'Hay %1$s temas y %2$s mensajes esperando aprobaci�n en este foro. Pulsa <a href="%3$s">aqu�</a> para verlos todos.';

$txt['msg_alert_none'] = 'No tienes mensajes...';
$txt['msg_alert_you_have'] = 'tienes';
$txt['msg_alert_messages'] = 'mensajes';
$txt['remove_message'] = 'Eliminar este mensaje';

$txt['online_users'] = 'Usuarios en L�nea';
$txt['personal_message'] = 'Mensaje Privado';
$txt['jump_to'] = 'Ir a';
$txt['go'] = 'ir';
$txt['are_sure_remove_topic'] = '�Est�s seguro de borrar este tema?';
$txt['yes'] = 'S�';
$txt['no'] = 'No';

$txt['search_end_results'] = 'Fin de resultados';
$txt['search_on'] = 'en';

$txt['search'] = 'Buscar';
$txt['all'] = 'Todos';

$txt['back'] = 'Atr�s';
$txt['password_reminder'] = 'Contrase�a recordatorio';
$txt['topic_started'] = 'Mensaje iniciado por';
$txt['title'] = 'T�tulo';
$txt['post_by'] = 'Publicado por';
$txt['memberlist_searchable'] = 'Lista (con opci�n de b�squeda) de todos los usuarios registrados.';
$txt['welcome_member'] = 'Por favor, da la bienvenida a';
$txt['admin_center'] = 'Centro de Administraci�n SMF';
$txt['last_edit'] = '�ltima modificaci�n';
$txt['notify_deactivate'] = '�Deseas desactivar la notificaci�n en este tema?';

$txt['recent_posts'] = 'Mensajes recientes';

$txt['location'] = 'Ubicaci�n';
$txt['gender'] = 'Sexo';
$txt['date_registered'] = 'Fecha de registro';

$txt['recent_view'] = 'Ver los mensajes m�s recientes del foro.';
$txt['recent_updated'] = 'es el tema actualizado m�s recientemente';

$txt['male'] = 'Masculino';
$txt['female'] = 'Femenino';

$txt['error_invalid_characters_username'] = 'Car�cter inv�lido en el nombre de usuario.';

$txt['welcome_guest'] = 'Bienvenido(a), <strong>%1$s</strong>. Por favor, <a href="' . $scripturl . '?action=login">ingresa</a> o <a href="' . $scripturl . '?action=register">reg�strate</a>.';
$txt['login_or_register'] = 'Por favor <a href="' . $scripturl . '?action=login">ingresa</a> o <a href="' . $scripturl . '?action=register">reg�strate</a>.';
$txt['welcome_guest_activate'] = '
�Perdiste tu  <a href="' . $scripturl . '?action=activate">email de activaci�n</a>?';
$txt['hello_member'] = 'Hola,';
// Use numeric entities in the below string.
$txt['hello_guest'] = 'Bienvenido(a),';
$txt['welmsg_hey'] = 'Hola,';
$txt['welmsg_welcome'] = 'Bienvenido(a),';
$txt['welmsg_please'] = 'Por favor';
$txt['select_destination'] = 'Por favor selecciona un destino';

// Escape any single quotes in here twice.. 'it\'s' -> 'it\\\'s'.
$txt['posted_by'] = 'Publicado por';

$txt['icon_smiley'] = 'Sonrisa';
$txt['icon_angry'] = 'Enojado';
$txt['icon_cheesy'] = 'Cheesy';
$txt['icon_laugh'] = 'Risa';
$txt['icon_sad'] = 'Triste';
$txt['icon_wink'] = 'Gui�ar';
$txt['icon_grin'] = 'Sonreir';
$txt['icon_shocked'] = 'Impresionado';
$txt['icon_cool'] = 'Cool';
$txt['icon_huh'] = 'Huh';
$txt['icon_rolleyes'] = 'Girar ojos';
$txt['icon_tongue'] = 'Lengua';
$txt['icon_embarrassed'] = 'Avergonzado';
$txt['icon_lips'] = 'Labios sellados';
$txt['icon_undecided'] = 'Indeciso';
$txt['icon_kiss'] = 'Beso';
$txt['icon_cry'] = 'Llorar';

$txt['moderator'] = 'Moderador';
$txt['moderators'] = 'Moderadores';

$txt['mark_board_read'] = 'Marcar Temas como le�dos para este foro';
$txt['views'] = 'Vistas';
$txt['new'] = 'Nuevo';

$txt['view_all_members'] = 'Ver todos los usuarios';
$txt['view'] = 'Ver';

$txt['viewing_members'] = 'Viendo usuarios de %1$s a %2$s';
$txt['of_total_members'] = 'de %1$s usuarios totales';

$txt['forgot_your_password'] = '�Olvidaste tu contrase�a?';

$txt['date'] = 'Fecha';
// Use numeric entities in the below string.
$txt['from'] = 'De';
$txt['check_new_messages'] = 'Recibir Nuevos Mensajes';
$txt['to'] = 'Para';

$txt['board_topics'] = 'Temas';
$txt['members_title'] = 'Usuarios';
$txt['members_list'] = 'Lista de usuarios';
$txt['new_posts'] = 'Nuevos Mensajes';
$txt['old_posts'] = 'No hay nuevos Mensajes';
$txt['redirect_board'] = 'Foro Redirigido';

$txt['sendtopic_send'] = 'Enviar';
$txt['report_sent'] = 'Tu informe fue enviado con �xito.';

$txt['time_offset'] = 'Diferencia Horaria';
$txt['or'] = 'o';

$txt['no_matches'] = 'Lo siento, no se encontraron mensajes';

$txt['notification'] = 'Notificaci�n';

$txt['your_ban'] = 'Lo siento %1$s, tienes el acceso denegado a este foro!';
$txt['your_ban_expires'] = 'Tu bloqueo de acceso expira %1$s.';
$txt['your_ban_expires_never'] = 'Tu bloqueo de acceso es permanente.';
$txt['ban_continue_browse'] = 'Puedes continuar navegando por el foro como invitado.';

$txt['mark_as_read'] = 'Marcar TODOS los mensajes como le�dos';

$txt['hot_topics'] = 'Tema candente (M�s de %1$d respuestas)';
$txt['very_hot_topics'] = 'Tema muy candente (M�s de %1$d respuestas)';
$txt['locked_topic'] = 'Tema bloqueado';
$txt['normal_topic'] = 'Tema normal';
$txt['participation_caption'] = 'Temas en los que has publicado';

$txt['go_caps'] = 'IR';

$txt['print'] = 'Imprimir';
$txt['profile'] = 'Perfil';
$txt['topic_summary'] = 'Sumario de Temas';
$txt['not_applicable'] = 'N/D';
$txt['message_lowercase'] = 'mensaje';
$txt['name_in_use'] = 'Este nombre est� en uso por otro usuario.';

$txt['total_members'] = 'Total de Usuarios';
$txt['total_posts'] = 'Total de Mensajes';
$txt['total_topics'] = 'Total de Temas';

$txt['mins_logged_in'] = 'Duraci�n de la sesi�n en minutos';

$txt['preview'] = 'Previsualizar';
$txt['always_logged_in'] = 'Recordar siempre Usuario/Contrase�a';

$txt['logged'] = 'En l�nea';
// Use numeric entities in the below string.
$txt['ip'] = 'IP';

$txt['www'] = 'WWW';

$txt['by'] = 'por';

$txt['hours'] = 'horas';
$txt['days_word'] = 'd�as';

$txt['newest_member'] = ', nuestro usuario m�s reciente.';

$txt['search_for'] = 'Buscar por';

$txt['aim'] = 'AIM';
// In this string, please use +'s for spaces.
$txt['aim_default_message'] = '�Est�s.+ahi?';
$txt['aim_title'] = 'AOL Instant Messenger';
$txt['icq'] = 'ICQ';
$txt['icq_title'] = 'ICQ Messenger';
$txt['msn'] = 'MSN';
$txt['msn_title'] = 'MSN Messenger';
$txt['yim'] = 'YIM';
$txt['yim_title'] = 'Yahoo Instant Messenger';

$txt['maintain_mode_on'] = 'Recuerda, este foro est� en \'Modo de Mantenimiento\'.';

$txt['read'] = 'Le�do';
$txt['times'] = 'veces';

$txt['forum_stats'] = 'Estad�sticas SMF';
$txt['latest_member'] = '�ltimo usuario';
$txt['total_cats'] = 'Total de Categor�as';
$txt['latest_post'] = '�ltimo mensaje';

$txt['you_have'] = 'Tienes';
$txt['click'] = 'Haz clic';
$txt['here'] = 'aqu�';
$txt['to_view'] = 'para verlos.';

$txt['total_boards'] = 'Total de Foros';

$txt['print_page'] = 'Imprimir P�gina';

$txt['valid_email'] = 'Debe ser una direcci�n v�lida de email.';

$txt['geek'] = 'un mont�n';
$txt['info_center_title'] = '%1$s - Centro de Informaci�n';

$txt['send_topic'] = 'Enviar tema';

$txt['sendtopic_title'] = 'Enviar tema &quot;%1$s&quot; a un amigo.';
$txt['sendtopic_sender_name'] = 'Tu nombre';
$txt['sendtopic_sender_email'] = 'Tu direcci�n de email';
$txt['sendtopic_receiver_name'] = 'Nombre del destinatario';
$txt['sendtopic_receiver_email'] = 'Direcci�n email del destinatario';
$txt['sendtopic_comment'] = 'Agregar un comentario';

$txt['allow_user_email'] = 'Permitir a los usuarios enviarme emails';

$txt['check_all'] = 'Seleccionar todo';

// Use numeric entities in the below string.
$txt['database_error'] = 'Error en la Base de Datos';
$txt['try_again'] = 'Por favor intenta nuevamente.  Si esta pantalla aparece nuevamente, notifica del error a un administrador.';
$txt['file'] = 'Archivo';
$txt['line'] = 'L�nea';
// Use numeric entities in the below string.
$txt['tried_to_repair'] = 'SMF ha detectado errores en la base de datos, y los ha tratado de corregir autom�ticamente.  Si los problemas persisten, o sigues obteniendo estos correos, por favor, contacta con tu proveedor de alojamiento web.';
$txt['database_error_versions'] = '<strong>Nota:</strong> Parece que tu base de datos <em>puede</em> necesitar una actualizaci�n. La versi�n de los archivos de tu foro est�n en la versi�n %1$s, mientras que tu base de datos est� en la versi�n de SMF %2$s. Este error probablemente desaparecer� si ejecutas la �ltima versi�n de upgrade.php.';
$txt['template_parse_error'] = '�Error al analizar la Plantilla!';
$txt['template_parse_error_message'] = 'Parece que algo se ha estropeado en el foro con el sistema de temas.  Este problema puede que solamente sea temporal, por favor, regresa en unos momentos e intentalo nuevamente.  Si continuas viendo este mensaje, por favor contacta al administrador.<br /><br />Puedes intentar <a href="javascript:location.reload();">actualizar esta p�gina</a>.';
$txt['template_parse_error_details'] = 'Hubo un problema cargando el tema o archivo de idioma <tt><strong>%1$s</strong></tt>.  Por favor revisa la sintaxis e intenta nuevamente - recuerda, los ap�strofes (<tt>\'</tt>) por lo general deben tener una secuencia de escape con la diagonal invertida (<tt>\\</tt>).  Para ver informaci�n especifica del error del sitio de PHP intenta <a href="' . $boardurl . '%1$s">acceder al archivo directamente</a>.<br /><br />Puedes intentar <a href="javascript:location.reload();">actualizar esta p�gina</a> o <a href="' . $scripturl . '?theme=1">usar el tema de default</a>.';

$txt['today'] = '<strong>Hoy</strong> a las ';
$txt['yesterday'] = '<strong>Ayer</strong> a las ';
$txt['new_poll'] = 'Nueva encuesta';
$txt['poll_question'] = 'Pregunta';
$txt['poll_vote'] = 'Enviar voto';
$txt['poll_total_voters'] = 'Total de votos';
$txt['shortcuts'] = 'acceso r�pido: presiona alt+s para publicar o alt+p para previsualizar';
$txt['shortcuts_firefox'] = 'Atajos: Presiona shift+alt+s para enviar la entrada o shift+alt+p para pre-visualizarla.';
$txt['poll_results'] = 'Ver resultados';
$txt['poll_lock'] = 'Bloquear Encuesta';
$txt['poll_unlock'] = 'Desbloquear Encuesta';
$txt['poll_edit'] = 'Editar Encuesta';
$txt['poll'] = 'Encuesta';
$txt['one_day'] = '1 D�a';
$txt['one_week'] = '1 Semana';
$txt['one_month'] = '1 Mes';
$txt['forever'] = 'Siempre';
$txt['quick_login_dec'] = 'Ingresar con nombre de usuario, contrase�a y duraci�n de la sesi�n';
$txt['one_hour'] = '1 Hora';
$txt['moved'] = 'MOVIDO';
$txt['moved_why'] = 'Por favor introduce una breve descripci�n de<br />por qu� este tema se est� moviendo.';
$txt['board'] = 'Foro';
$txt['in'] = 'en';
$txt['sticky_topic'] = 'Tema fijado';

$txt['delete'] = 'Borrar';

$txt['your_pms'] = 'Tus Mensajes privados';

$txt['kilobyte'] = 'kB';

$txt['more_stats'] = '[M�s Estad�sticas]';

// Use numeric entities in the below three strings.
$txt['code'] = 'C�digo';
$txt['code_select'] = '[Seleccionar]';
$txt['quote_from'] = 'Cita de';
$txt['quote'] = 'Citar';

$txt['merge_to_topic_id'] = 'ID del tema de destino';
$txt['split'] = 'Dividir Tema';
$txt['merge'] = 'Combinar Temas';
$txt['subject_new_topic'] = 'Asunto para el nuevo tema';
$txt['split_this_post'] = 'S�lo dividir este mensaje.';
$txt['split_after_and_this_post'] = 'Dividir tema a partir de este mensaje (incluy�ndolo).';
$txt['select_split_posts'] = 'Selecciona los mensajes a dividir.';
$txt['new_topic'] = 'Nuevo Tema';
$txt['split_successful'] = 'El tema se ha dividido satisfactoriamente en dos temas.';
$txt['origin_topic'] = 'Tema de Origen';
$txt['please_select_split'] = 'Por favor selecciona qu� mensajes deseas dividir.';
$txt['merge_successful'] = 'Los temas han sido satisfactoriamente combinados.';
$txt['new_merged_topic'] = 'Nuevo Tema Combinado';
$txt['topic_to_merge'] = 'Tema a ser combinado';
$txt['target_board'] = 'Foro destino';
$txt['target_topic'] = 'Tema destino';
$txt['merge_confirm'] = '�Est�s seguro que deseas combinar';
$txt['with'] = 'con';
$txt['merge_desc'] = 'Esta funci�n combinar� los mensajes de dos temas en un tema. Los mensajes ser�n ordenados de acuerdo con la fecha en que se publicaron. Por lo tanto, el mensaje publicado m�s recientemente ser� el primer mensaje del tema combinado.';

$txt['set_sticky'] = 'Fijar tema';
$txt['set_nonsticky'] = 'Desfijar tema';
$txt['set_lock'] = 'Bloquear tema';
$txt['set_unlock'] = 'Desbloquear tema';

$txt['search_advanced'] = 'B�squeda Avanzada';

$txt['security_risk'] = 'RIESGO MAYOR DE SEGURIDAD:';
$txt['not_removed'] = 'No has borrado ';
$txt['not_removed_extra'] = '%1$s es un respaldo de %2$s que no fue generado por SMF. Este respaldo es accesible directamente y puede ser utilizado para obtener acceso no autorizado a tu foro. Debes eliminarlo inmediatamente.';

$txt['cache_writable_head'] = 'Aviso de Rendiento';
$txt['cache_writable'] = 'No se puede escribir en el directorio cach� - afectar� negativamente al rendimiento de tu foro.';

$txt['page_created'] = 'P�gina generada en ';
$txt['seconds_with'] = ' segundos con ';
$txt['queries'] = ' consultas.';

$txt['report_to_mod_func'] = 'Usa esta funci�n para informar a los moderadores y administradores de un mensaje abusivo, o publicado incorrectamente.<br /><em>Es importante mencionar que tu direcci�n de email ser� revelada a los moderadores si usas esta funci�n.</em>';

$txt['online'] = 'Conectado';
$txt['offline'] = 'Desconectado';
$txt['pm_online'] = 'Mensaje Privado (Conectado)';
$txt['pm_offline'] = 'Mensaje Privado (Desconectado)';
$txt['status'] = 'Estado';

$txt['go_up'] = 'Ir Arriba';
$txt['go_down'] = 'Ir Abajo';

$forum_copyright = '<a href="' . $scripturl . '?action=credits" title="Simple Machines Forum" target="_blank" class="new_win">%1$s</a> |
 <a href="http://www.simplemachines.org/about/smf/license.php" title="License" target="_blank" class="new_win">SMF &copy; 2020</a>, <a href="http://www.simplemachines.org" title="Simple Machines" target="_blank" class="new_win">Simple Machines</a>';

$txt['birthdays'] = 'Cumplea�os:';
$txt['events'] = 'Eventos:';
$txt['birthdays_upcoming'] = 'Pr�ximos cumplea�os:';
$txt['events_upcoming'] = 'Pr�ximos eventos:';
// Prompt for holidays in the calendar, leave blank to just display the holiday's name.
$txt['calendar_prompt'] = '';
$txt['calendar_month'] = 'Mes:';
$txt['calendar_year'] = 'A�o:';
$txt['calendar_day'] = 'D�a:';
$txt['calendar_event_title'] = 'T�tulo del Evento';
$txt['calendar_event_options'] = 'Opciones de Eventos';
$txt['calendar_post_in'] = 'Publicar en:';
$txt['calendar_edit'] = 'Editar evento';
$txt['event_delete_confirm'] = '�Borrar este evento?';
$txt['event_delete'] = 'Borrar evento';
$txt['calendar_post_event'] = 'Publicar evento';
$txt['calendar'] = 'Calendario';
$txt['calendar_link'] = 'Enlazar al calendario';
$txt['calendar_upcoming'] = 'Calendario de eventos pr�ximos';
$txt['calendar_today'] = 'Calendario de Hoy';
$txt['calendar_week'] = 'Semana';
$txt['calendar_week_title'] = 'Semana %1$d de %2$d ';
$txt['calendar_numb_days'] = 'N�mero de D�as:';
$txt['calendar_how_edit'] = '�c�mo editas esos eventos?';
$txt['calendar_link_event'] = 'Enlazar evento';
$txt['calendar_confirm_delete'] = '�Est�s seguro que deseas borrar este evento?';
$txt['calendar_linked_events'] = 'Eventos Vinculados';
$txt['calendar_click_all'] = 'Pulsa para verlos todos %1$s';

$txt['moveTopic1'] = 'Publicar un tema de redireccionamiento';
$txt['moveTopic2'] = 'Cambiar el t�tulo del tema';
$txt['moveTopic3'] = 'Nuevo asunto';
$txt['moveTopic4'] = 'Cambiar el asunto de cada mensaje';
$txt['move_topic_unapproved_js'] = '�Advertencia! Este tema a�n no ha sido aprobado.\\n\\nNo se recomienda que crees un tema de redirecci�n a menos que tengas la intenci�n de aprobar el mensaje inmediatamente despu�s de moverlo.';

$txt['theme_template_error'] = 'No se pudo cargar la plantilla \'%1$s\'.';
$txt['theme_language_error'] = 'No se pudo cargar el archivo de idioma \'%1$s\'.';

$txt['parent_boards'] = 'Subforos';

$txt['smtp_no_connect'] = 'No fue posible conectarse al servidor SMTP';
$txt['smtp_port_ssl'] = 'Puerto SMTP configurado incorrectamente; deber�a ser 465 en servidores SSL.';
$txt['smtp_bad_response'] = 'No se pudieron obterer los codigos de respuesta del servidor de mail';
$txt['smtp_error'] = 'Hubo problemas al enviar el mail. Error: ';
$txt['mail_send_unable'] = 'No se pudo enviar el email a la direcci�n \'%1$s\'';

$txt['mlist_search'] = 'Buscar usuarios por';
$txt['mlist_search_again'] = 'Buscar nuevamente';
$txt['mlist_search_email'] = 'Buscar por direcci�n de email';
$txt['mlist_search_messenger'] = 'Buscar por nick de messenger';
$txt['mlist_search_group'] = 'Buscar por grupo';
$txt['mlist_search_name'] = 'Buscar por nombre';
$txt['mlist_search_website'] = 'Buscar por sitio Web';
$txt['mlist_search_results'] = 'Buscar resultados por';
$txt['mlist_search_by'] = 'Buscar %1$s';
$txt['mlist_menu_view'] = 'Ver la lista de usuarios';

$txt['attach_downloaded'] = 'descargado';
$txt['attach_viewed'] = 'visto';
$txt['attach_times'] = 'veces';

$txt['settings'] = 'Configuraci�n';
$txt['never'] = 'Nunca';
$txt['more'] = 'm�s';

$txt['hostname'] = 'Nombre del servidor';
$txt['you_are_post_banned'] = 'Lo sentimos %1$s, tienes restringido el poder publicar mensajes o enviar mensajes privados en el foro.';
$txt['ban_reason'] = 'Raz�n';

$txt['tables_optimized'] = 'Tablas de la base de datos optimizadas';

$txt['add_poll'] = 'Agregar encuesta';
$txt['poll_options6'] = 'Solo puedes seleccionar hasta %1$s opciones.';
$txt['poll_remove'] = 'Eliminar encuesta';
$txt['poll_remove_warn'] = '�Est�s seguro que deseas eliminar esta encuesta del tema?';
$txt['poll_results_expire'] = 'Los resultados se mostrar�n una vez que la encuesta se haya cerrado';
$txt['poll_expires_on'] = 'La votaci�n se cierra';
$txt['poll_expired_on'] = 'Votaci�n cerrada';
$txt['poll_change_vote'] = 'Eliminar Voto';
$txt['poll_return_vote'] = 'Opciones de votaci�n';
$txt['poll_cannot_see'] = 'No puedes ver los resultados de la encuesta en este momento';

$txt['quick_mod_approve'] = 'Aprobar los seleccionados';
$txt['quick_mod_remove'] = 'Eliminar seleccionado(s)';
$txt['quick_mod_lock'] = 'Bloquear/desbloquear seleccionado(s)';
$txt['quick_mod_sticky'] = 'Fijar/soltar seleccionado(s)';
$txt['quick_mod_move'] = 'Mover seleccionado(s) a';
$txt['quick_mod_merge'] = 'Combinar seleccionado(s)';
$txt['quick_mod_markread'] = 'Marcar seleccionados como le�dos';
$txt['quick_mod_go'] = '�Ir!';
$txt['quickmod_confirm'] = '�Est�s seguro que deseas hacer esto?';

$txt['spell_check'] = 'Revisar Ortograf�a';

$txt['quick_reply'] = 'Respuesta r�pida';
$txt['quick_reply_desc'] = 'En la <em>Respuesta r�pida</em> puedes escribir un mensaje mientras ves un tema completo sin necesidad de abrir una nueva ventana. Puedes usar BBC y emoticonos como lo har�as en un mensaje normal.';
$txt['quick_reply_warning'] = '�Advertencia: el tema est� bloqueado! Solamente admins y moderadores pueden responder.';
$txt['quick_reply_verification'] = 'Tras enviar tu post ser�s dirigido a la p�gina de posts normal para verificar tu post %1$s.';
$txt['quick_reply_verification_guests'] = '(requerido para todos los invitados)';
$txt['quick_reply_verification_posts'] = '(requerido para todos los usuarios con menos de %1$d posts)';
$txt['wait_for_approval'] = 'Nota: este mensaje no se mostrar� hasta que sea aprobado por un moderador.';

$txt['notification_enable_board'] = '�Est�s seguro que deseas activar la notificaci�n de nuevos temas para este foro?';
$txt['notification_disable_board'] = '�Est�s seguro que deseas desactivar la notificaci�n de nuevos temas para este foro?';
$txt['notification_enable_topic'] = '�Est�s seguro que deseas activar la notificaci�n de nuevas respuestas para este tema?';
$txt['notification_disable_topic'] = '�Est�s seguro que deseas desactivar la notificaci�n de nuevas respuestas para este tema?';

$txt['report_to_mod'] = 'Reportar al moderador';
$txt['issue_warning_post'] = 'Emitir un aviso debido a este mensaje';

$txt['unread_topics_visit'] = 'Nuevos temas no le�dos';
$txt['unread_topics_visit_none'] = 'No se han encontrado temas no le�dos desde tu �ltima visita.  <a href="' . $scripturl . '?action=unread;all">Haz <i>clic</i> aqu� para intentar todos los temas no le�dos</a>.';
$txt['unread_topics_all'] = 'Todos los temas no le�dos';
$txt['unread_replies'] = 'Temas actualizados';

$txt['who_title'] = 'Qui�n est� en l�nea';
$txt['who_and'] = ' y ';
$txt['who_viewing_topic'] = ' est�n viendo este tema.';
$txt['who_viewing_board'] = ' est�n viendo este foro.';
$txt['who_member'] = 'Usuario';

// No longer used by default theme, but for backwards compat
$txt['powered_by_php'] = 'Impulsado por PHP';
$txt['powered_by_mysql'] = 'Impulsado por MySQL';
$txt['valid_css'] = '�CSS v�lido!';

// Current footer strings
$txt['valid_html'] = 'HTML 4.01 v�lido';
$txt['valid_xhtml'] = '�XHTML 1.0 v�lido!';
$txt['wap2'] = 'WAP2';
$txt['rss'] = 'RSS';
$txt['xhtml'] = 'XHTML';
$txt['html'] = 'HTML';

$txt['guest'] = 'Visitante';
$txt['guests'] = 'Visitantes';
$txt['user'] = 'Usuario';
$txt['users'] = 'Usuarios';
$txt['hidden'] = 'Oculto(s)';
$txt['buddy'] = 'Amigo';
$txt['buddies'] = 'Amigos';
$txt['most_online_ever'] = 'M�ximo en linea siempre';
$txt['most_online_today'] = 'M�ximo en linea hoy';

$txt['merge_select_target_board'] = 'Selecciona el foro destino del tema combinado';
$txt['merge_select_poll'] = 'Selecciona cual encuesta tendr� el tema combinado';
$txt['merge_topic_list'] = 'Selecciona los temas a combinar';
$txt['merge_select_subject'] = 'Selecciona el t�tulo del tema combinado';
$txt['merge_custom_subject'] = 'T�tulo personalizado';
$txt['merge_enforce_subject'] = 'Cambiar el t�tulo de todos los mensajes';
$txt['merge_include_notifications'] = '�Incluir notificaciones?';
$txt['merge_check'] = '�Combinar?';
$txt['merge_no_poll'] = 'Sin encuesta';

$txt['response_prefix'] = 'Re: ';
$txt['current_icon'] = 'Icono actual';
$txt['message_icon'] = 'Icono de mensaje';

$txt['smileys_current'] = 'Conjunto actual de Smileys';
$txt['smileys_none'] = 'Sin Smileys';
$txt['smileys_forum_board_default'] = 'Las que el foro est� utilizando por defecto';

$txt['search_results'] = 'Resultados de la b�squeda';
$txt['search_no_results'] = 'No se encontraron coincidencias';

$txt['totalTimeLogged1'] = 'Tiempo total en l�nea: ';
$txt['totalTimeLogged2'] = ' d�as, ';
$txt['totalTimeLogged3'] = ' horas y ';
$txt['totalTimeLogged4'] = ' minutos.';
$txt['totalTimeLogged5'] = 'd';
$txt['totalTimeLogged6'] = 'h';
$txt['totalTimeLogged7'] = 'm';

$txt['approve_thereis'] = 'Hay';
$txt['approve_thereare'] = 'Hay';
$txt['approve_member'] = 'un usuario';
$txt['approve_members'] = 'usuarios';
$txt['approve_members_waiting'] = 'esperando aprobaci�n.';

$txt['notifyboard_turnon'] = '�Deseas una notificaci�n por email cuando alguien publique un nuevo tema en este foro?';
$txt['notifyboard_turnoff'] = '�Est�s seguro que NO deseas recibir notificaciones de temas nuevos en este foro?';
$txt['notifyboard_subscribed'] = '%1$s se ha suscrito a las notificaciones de este foro.';
$txt['notifyboard_unsubscribed'] = '%1$s ha cancelado su suscripci�n a las notificaciones de este foro.';

$txt['notifytopic_subscribed'] = '%1$s se ha suscrito a las notificaciones de nuevas respuestas para este tema.';
$txt['notifytopic_unsubscribed'] = '%1$s ha cancelado su suscripci�n a las notificaciones de nuevas respuestas para este tema.';

$txt['notify_announcements'] = 'Permitir que los administradores me env�en notificaciones importantes por correo electr�nico';
$txt['notifyannouncements_prompt'] = '�Deseas recibir los boletines de noticias del foro, anuncios y otras notificaciones importantes por correo electr�nico?';
$txt['notifyannouncements_subscribed'] = '%1$s se ha suscrito al bolet�n de noticias del foro, anuncios y otras notificaciones importantes.';
$txt['notifyannouncements_unsubscribed'] = '%1$s ha cancelado su suscripci�n al bolet�n de noticias del foro, anuncios y otras notificaciones importantes.';

$txt['unsubscribe_announcements_plain'] = 'Usa el siguiente enlace para cancelar tu suscripci�n al bolet�n de noticias del foro, anuncios y otras notificaciones importantes:<br />%1$s ';
$txt['unsubscribe_announcements_html'] = '<span style="font-size:small"><a href="%1$s">Desuscribirse</a> del bolet�n de noticias del foro, anuncios y otras notificaciones importantes.</span> ';

$txt['activate_code'] = 'Tu c�digo de activaci�n es';

$txt['find_members'] = 'Buscar usuarios';
$txt['find_username'] = 'Nombre, nombre de usuario, o direcci�n de email';
$txt['find_buddies'] = '�Mostrar amigos solamente?';
$txt['find_wildcards'] = 'Comodines permitidos: *, ?';
$txt['find_no_results'] = 'No se encontraron resultados';
$txt['find_results'] = 'Resultados';
$txt['find_close'] = 'Cerrar';

$txt['unread_since_visit'] = 'Mostrar mensajes no le�dos desde la �ltima visita.';
$txt['show_unread_replies'] = 'Mostrar nuevas respuestas a tus mensajes.';

$txt['change_color'] = 'Cambiar Color';

$txt['quickmod_delete_selected'] = 'Borrar Seleccionados';

// In this string, don't use entities. (&amp;, etc.)
$txt['show_personal_messages'] = 'Has recibido uno o m�s mensajes privados.\\n�Deseas abrir una nueva ventana para verlo(s)?';

$txt['previous_next_back'] = '&laquo; anterior';
$txt['previous_next_forward'] = 'pr�ximo &raquo;';

$txt['movetopic_auto_board'] = '[FORO]';
$txt['movetopic_auto_topic'] = '[URL DEL TEMA]';
$txt['movetopic_default'] = 'El tema ha sido movido a ' . $txt['movetopic_auto_board'] . ".\n\n" . $txt['movetopic_auto_topic'];

$txt['upshrink_description'] = 'Encoger o expandir encabezado.';

$txt['mark_unread'] = 'Marcar como no le�dos';

$txt['ssi_not_direct'] = 'Por favor no accedas a SSI.php usando directamente la URL; mejor utiliza la ruta (%1$s) o agrega ?ssi_function=algun_valor.';
$txt['ssi_session_broken'] = '�SSI.php no pudo cargar una sesi�n!  Esto puede causar problemas con algunas funciones, tales como ingresar o salir - �Por favor, aseg�rate de que SSI.php est� inclu�do siempre al principio *antes de cualquier otro c�digo* en todos tus scripts!';

// Escape any single quotes in here twice.. 'it\'s' -> 'it\\\'s'.
$txt['preview_title'] = 'Previsualizar mensaje';
$txt['preview_fetch'] = 'Obteniendo la previsualizaci�n...';
$txt['preview_new'] = 'Mensaje Nuevo';
$txt['error_while_submitting'] = 'Hubo un error mientras se enviaba este mensaje.';
$txt['error_old_topic'] = 'Advertencia: No se ha publicado ninguna respuesta a este tema desde hace %1$d d�as como m�nimo.<br />A menos que est�s seguro de que quieres responder, por favor, considera el empezar un nuevo tema.';

$txt['split_selected_posts'] = 'Mensajes seleccionados';
$txt['split_selected_posts_desc'] = 'Los mensajes mostrados a continuaci�n formar�n un nuevo tema una vez divididos.';
$txt['split_reset_selection'] = 'reinicializar selecci�n';

$txt['modify_cancel'] = 'Cancelar';
$txt['mark_read_short'] = 'Marcar como leido';

$txt['pm_short'] = 'Mis mensajes';
$txt['pm_menu_read'] = 'Leer tus mensajes';
$txt['pm_menu_send'] = 'Enviar un mensaje';

$txt['hello_member_ndt'] = 'Hola';

$txt['unapproved_posts'] = 'Mensajes no aprobados (Temas: %1$d, Mensajes: %2$d)';

$txt['ajax_in_progress'] = 'Cargando...';

$txt['mod_reports_waiting'] = 'Actualmente hay %1$d informes de moderador abiertos.';

$txt['view_unread_category'] = 'Mensajes no le�dos';
$txt['verification'] = 'Verificaci�n';
$txt['visual_verification_description'] = 'Escribe las letras mostradas en la imagen';
$txt['visual_verification_sound'] = 'Escuchar el texto';
$txt['visual_verification_request_new'] = 'Solicitar otra imagen';

// Sub menu labels
$txt['summary'] = 'Resumen';
$txt['account'] = 'Configuraci�n de Cuenta';
$txt['forumprofile'] = 'Perfil del Foro';

$txt['modSettings_title'] = 'Caracter�sticas y Opciones';
$txt['package'] = 'Gestor de paquetes';
$txt['errlog'] = 'Log de Errores';
$txt['edit_permissions'] = 'Permisos';
$txt['mc_unapproved_attachments'] = 'Adjuntos no aprobados';
$txt['mc_unapproved_poststopics'] = 'Mensajes y Temas no aprobados';
$txt['mc_reported_posts'] = 'Mensajes Informados';
$txt['modlog_view'] = 'Log de Moderaci�n';
$txt['calendar_menu'] = 'Ver el Calendario';

//!!! Send email strings - should move?
$txt['send_email'] = 'Enviar Email';
$txt['send_email_disclosed'] = 'Ten en cuenta que ser� visible por el destinatario.';
$txt['send_email_subject'] = 'Asunto del Email';

$txt['ignoring_user'] = 'Est�s ignorando a este usuario.';
$txt['show_ignore_user_post'] = 'Mu�strame el mensaje.';

$txt['spider'] = 'Ara�a';
$txt['spiders'] = 'Ara�as';
$txt['openid'] = 'OpenID';

$txt['downloads'] = 'Descargas';
$txt['filesize'] = 'Tama�o';
$txt['subscribe_webslice'] = 'Suscribirse a Webslice';

// Restore topic
$txt['restore_topic'] = 'Restaurar Tema';
$txt['restore_message'] = 'Restaurar Mensaje';
$txt['quick_mod_restore'] = 'Restaurar Seleccionado';

// Editor prompt.
$txt['prompt_text_email'] = 'Por favor introduce la direcci�n de email.';
$txt['prompt_text_ftp'] = 'Por favor, introduce la direcci�n FTP';
$txt['prompt_text_url'] = 'Por favor, introduce la URL a la que quieres enlazar';
$txt['prompt_text_img'] = 'Introduce la direcci�n de la imagen';

// Escape any single quotes in here twice.. 'it\'s' -> 'it\\\'s'.
$txt['autosuggest_delete_item'] = 'Borrar elemento';

// Debug related - when $db_show_debug is true.
$txt['debug_templates'] = 'Plantillas:';
$txt['debug_subtemplates'] = 'Sub plantillas:';
$txt['debug_language_files'] = 'Archivos de idioma:';
$txt['debug_stylesheets'] = 'Hojas de estilo:';
$txt['debug_files_included'] = 'Archivos inclu�dos:';
$txt['debug_kb'] = 'KB.';
$txt['debug_show'] = 'mostrar';
$txt['debug_cache_hits'] = 'Cach� de resultados:';
$txt['debug_cache_seconds_bytes'] = '%1$ss - %2$s bytes';
$txt['debug_cache_seconds_bytes_total'] = '%1$ss para %2$s bytes';
$txt['debug_queries_used'] = 'Consultas utilizadas: %1$d. ';
$txt['debug_queries_used_and_warnings'] = 'Consultas utilizadas: %1$d, %2$d advertencias.';
$txt['debug_query_in_line'] = 'en <em>%1$s</em> linea <em>%2$s</em>,';
$txt['debug_query_which_took'] = 'se demor� %1$s segundos.';
$txt['debug_query_which_took_at'] = 'se demor� %1$s segundos en realizar %2$s peticiones.';
$txt['debug_show_queries'] = '[Mostrar Consultas]';
$txt['debug_hide_queries'] = '[Ocultar Consultas]';

?>