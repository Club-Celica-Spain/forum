<?php
// Version: 1.1 RC2; PersonalMessage

$txt[143] = '&Iacute;ndice de mensajes personales';
$txt[148] = 'Enviar mensaje';
$txt[150] = 'Para';
$txt[1502] = 'Bcc';
$txt[316] = 'Bandeja de Entrada';
$txt[320] = 'Bandeja de Salida';
$txt[321] = 'Nuevo Mensaje';
$txt[411] = 'Borrar Mensajes';
// Don't translate "PMBOX" in this string.
$txt[412] = 'Borrar todos los mensajes de tu PMBOX';
$txt[413] = '¿Estás seguro que deseas borrar todos los mensajes?';
$txt[535] = 'Destinatario';
// Don't translate the word "SUBJECT" here, as it is used to format the message - use numeric entities as well.
$txt[561] = 'Nuevo Mensaje Personal: SUBJECT';
// Don't translate SENDER or MESSAGE in this language string; they are replaced with the corresponding text - use numeric entities too.
$txt[562] = 'Acaban de enviarte un mensaje personal de parte de SENDER en ' . $context['forum_name'] . '.' . "\n\n" . 'MUY IMPORTANTE: RECUERDA, ESTO ES SOLAMENTE UNA NOTIFICACI&OACUTE;N. POR FAVOR, NO RESPONDAS A ESTE EMAIL.' . "\n\n" . 'El mensaje que te enviaron fue:' . "\n\n" . 'MESSAGE';
$txt[748] = '(m&uacute;ltiples destinatarios como \'nombreusuario1, nombreusuario2\')';
// Use numeric entities in the below string.
$txt['instant_reply'] = 'Responder a este mensaje personal aqu&iacute;:';

$txt['smf249'] = '¿Deseas borrar todos los Mensajes Instant&aacute;neos seleccionados?';

$txt['sent_to'] = 'Enviado a';
$txt['reply_to_all'] = 'Responder a Todos';

$txt['pm_capacity'] = 'Capacidad';
$txt['pm_currently_using'] = '%s mensajes, %s%% lleno.';

$txt['pm_error_user_not_found'] = 'No se pudo encontrar al usuario \'%s\'.';
$txt['pm_error_ignored_by_user'] = 'El usuario \'%s\' ha bloqueado tu mensaje personal.';
$txt['pm_error_data_limit_reached'] = 'El mensaje personal no se pudo enviar a \'%s\' deb&iacute;do a que excediste el l&iacute;mite de mensajes personales.';
$txt['pm_successfully_sent'] = 'El mensaje personal se envi&oacute; satisfactoriamente a \'%s\'.';
$txt['pm_too_many_recipients'] = 'Usted no puede enviar un mensaje personal a m&aacute;s %d recipiente(s).';
$txt['pm_send_report'] = 'Enviar reporte';
$txt['pm_save_outbox'] = 'Guardar una copia en mi buz&oacute;n de salida';
$txt['pm_undisclosed_recipients'] = 'Destinatario(s) sin revelar';

$txt['pm_read'] = 'Leer';
$txt['pm_replied'] = 'Responder a';

$txt['pm_prune'] = 'Purgar Mensajes';
$txt['pm_prune_desc1'] = 'Borrar todos tus mensajes personales m&aacute;s antiguos de ';
$txt['pm_prune_desc2'] = 'd&iacute;as.';
$txt['pm_prune_warning'] = '¿Estás seguro que deseas borrar tus mensajes personales?';

$txt['pm_actions_title'] = 'Acciones adicionales';
$txt['pm_actions_delete_selected'] = 'Borrar seleccionados';
$txt['pm_actions_filter_by_label'] = 'Filtrar por etiqueta';
$txt['pm_actions_go'] = 'Ir';

$txt['pm_apply'] = 'Aplicar';
$txt['pm_manage_labels'] = 'Administrar Etiquetas';
$txt['pm_labels_delete'] = '¿Estás seguro que deseas borrar las etiquetas seleccionadas?';
$txt['pm_labels_desc'] = 'Aqu&iacute; puedes agregar, editar y borrar etiquetas utilizadas en el centro de mensajes personales.';
$txt['pm_label_add_new'] = 'Agregar nueva etiqueta';
$txt['pm_label_name'] = 'Nombre de la etiqueta';
$txt['pm_labels_no_exist'] = '¡No tienes ninguna etiqueta dada de alta!';

$txt['pm_current_label'] = 'Etiqueta';
$txt['pm_msg_label_title'] = 'Etiquetar Mensaje';
$txt['pm_msg_label_apply'] = 'Agregar etiqueta';
$txt['pm_msg_label_remove'] = 'Eliminar etiqueta';
$txt['pm_msg_label_inbox'] = 'Bandeja de Entrada';
$txt['pm_sel_label_title'] = 'Etiquetar seleccionados';
$txt['labels_too_many'] = '&iexcl;Lo sentimos, %s mensajes ya tienen el n&uacute;mero m&aacute;ximo de etiquetas permitido!';

$txt['pm_labels'] = 'Etiquetas';
$txt['pm_messages'] = 'Mensajes';
$txt['pm_preferences'] = 'Configuraci&oacute;n';

$txt['pm_is_replied_to'] = 'Haz reenviado o respondido a este mensaje.';

// Reporting messages.
$txt['pm_report_to_admin'] = 'Reportar a un administrador';
$txt['pm_report_title'] = 'Reportar mensajes personales';
$txt['pm_report_desc'] = 'Desde esta p&aacute;gina usted puede reportar mensajes personales que has recivido a administradores. Porfavor sea seguro de incluir una descripci&oacute;n o por qu&eacute; est&aacute;s reportando el mensaje; el mensaje se enviar&aacute; con el contenido del mensaje reportado.';
$txt['pm_report_admins'] = 'Enviar mensaje reportado a un administrador';
$txt['pm_report_all_admins'] = 'Enviar a todos los administradores del foro';
$txt['pm_report_reason'] = 'Raz&oacute;n por la cual est&aacute;s reportando el mensaje';
$txt['pm_report_message'] = 'Reportar Mensaje';

// Important - The following strings should use numeric entities.
$txt['pm_report_pm_subject'] = '[REPORTADO] ';
// In the below string, do not translate "{REPORTER}" or "{SENDER}".
$txt['pm_report_pm_user_sent'] = '{REPORTER} ha reportado un mensaje personal, enviado por {SENDER}, por las siguentes razones:';
$txt['pm_report_pm_other_recipients'] = 'Otros recipientes de este mensaje encluidos:';
$txt['pm_report_pm_hidden'] = '%d recipiente(s) oculto(s)';
$txt['pm_report_pm_unedited_below'] = 'Lo siguiente es el contenido del mensaje original que fue reportado:';
$txt['pm_report_pm_sent'] = 'Enviado:';

$txt['pm_report_done'] = 'Gracias por enviar este reporte. Esto lo leer&aacute;n los administradores muy pronto';
$txt['pm_report_return'] = 'Regresar a la Bandeja de Entrada';

$txt['pm_search_title'] = 'Buscar mensajes personales';
$txt['pm_search_bar_title'] = 'Buscar mensajes';
$txt['pm_search_text'] = 'Buscar por';
$txt['pm_search_go'] = 'Buscar';
$txt['pm_search_advanced'] = 'B&uacute;squeda avanzada';
$txt['pm_search_user'] = 'por usuario';
$txt['pm_search_match_all'] = 'Coincidir todas las palabras';
$txt['pm_search_match_any'] = 'Coincidir cualquier palabra';
$txt['pm_search_options'] = 'Opciones';
$txt['pm_search_post_age'] = 'Edad';
$txt['pm_search_show_complete'] = 'Mostrar el mensaje completo en los resultadosS.';
$txt['pm_search_subject_only'] = 'Buscar por asunto y autor solamente.';
$txt['pm_search_between'] = 'Entre';
$txt['pm_search_between_and'] = 'y';
$txt['pm_search_between_days'] = 'd&iacute;as';
$txt['pm_search_order'] = 'Ordenar resultados por';
$txt['pm_search_choose_label'] = 'Escojer etiquetas para buscar o buscar todo';

$txt['pm_search_results'] = 'Resultados de la B&uacute;squeda';
$txt['pm_search_none_found'] = 'No se encontr&oacute; resultados';

$txt['pm_search_orderby_relevant_first'] = 'M&aacute;s relevante primero';
$txt['pm_search_orderby_recent_first'] = 'M&aacute;s reciente primero';
$txt['pm_search_orderby_old_first'] = 'Antiguos primero';

?>