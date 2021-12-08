<?php
// Version: 1.1 RC2; Modifications

$txt['youtube'] = 'YouTube';
$txt['youtube_invalid'] = '#Link de YouTube Inválido#';

$txt['youtube'] = 'YouTube';
$txt['youtube_invalid'] = '#Link de YouTube Inválido#';


// Custom Permissions mod.
$txt['permissiongroup_custom'] = 'Custom Permissions';
$txt['permissions_custom_desc'] = 'Use this area to create and maintain custom permissions. Permission names should be alpha-numeric. Underscores are allowed. The description is what appears in the permission listings. Click on the permission name to enable that premission for select member groups. To edit, re-input the permisssion name and add a new description';
$txt['custom_permissions'] = 'Custom Permissions';
$txt['custom_permission_name'] = 'Permission name';
$txt['custom_permission_usage'] = 'Usage';
$txt['custom_permission_desc'] = 'Permission description';
$txt['custom_permission_manage_title'] = 'Manage Custom Permissions';
$txt['custom_permission_enable_title'] = 'Enable Custom Permissions';
$txt['custom_permission_enable_message'] = 'Here you can enable permissions for each member group. To return to this page, Select the permission name on the main page.';
$txt['custom_permission_new'] = 'Add or modify custom permissions';
$txt['custom_permission_add'] = 'Submit';
$txt['custom_permission_edit'] = 'Edit';
$txt['custom_permission_warning'] = '<hr width="50%" /><span class="error">Warning! This is a non-guest permission.</span><br />Do not enable this permission for guests.';
$txt['custom_permission_select'] = 'Check or alter existing permissions for each member group.';

$txt['custom_permission_error_1'] = 'You must input something into both fields. The permission name field should be alpha-numeric.';
$txt['custom_permission_error_2'] = 'The permission name should be alpha-numeric and longer than 4 characters. Underscores "_" are allowed.';
$txt['custom_permission_error_3'] = 'Custom permission name can not be the same as an existing permission name';
// End custom permissions mod.
// Hack's Park Shoutbox -->
$txt['sba_title'] = 'Shoutbox';
$txt['sba_link'] = 'Shoutbox';

$txt['permissiongroup_shoutbox'] = 'Shoutbox';
$txt['permissionname_shoutbox_view'] = 'Ver Shoutbox';
$txt['permissionname_shoutbox_post'] = 'Escribir mensajes en Shoutbox';
$txt['permissiongroup_shoutbox_panel'] = 'Shoutbox Panel de Moderacion';
$txt['permissionname_shoutbox_edit'] = 'Editar mensajes en Shoutbox';
$txt['permissionname_shoutbox_delete'] = 'Eliminar mensajes en Shoutbox';
$txt['permissionname_shoutbox_prune'] = 'Vaciar Shoutbox';
$txt['permissionname_shoutbox_ban'] = 'Banear usuarios en Shoutbox';
// <-- Hack's Park Shoutbox
// --- Begin added code - nCode Image Resizer ---
$txt['ncode_imageresizer_warning_small'] = 'Has click en esta barra para ver la imagen en su tama&ntilde;o original.';
$txt['ncode_imageresizer_warning_filesize'] = 'Esta imagen ha sido redimensionada. Has click en la barra para verla en su tama&ntilde;o original (%1$sx%2$s px y pesa %3$sKB).';
$txt['ncode_imageresizer_warning_no_filesize'] = 'Esta imagen ha sido redimensionada. Has click en la barra para verla en su tama&ntilde;o original (%1$sx%2$s px).';
$txt['ncode_imageresizer_warning_fullsize'] = 'Has click en la barra para ver la imagen en peque&ntilde;o.';
$txt['ncode_imageresizer_mode'] = 'Redimensionar Imagenes';
$txt['ncode_imageresizer_original'] = 'Mantener el tama&ntilde;o original';
$txt['ncode_imageresizer_enlarge_same'] = 'Aumentar sobre la misma ventana';
$txt['ncode_imageresizer_open_same'] = 'Abrir en la misma ventana';
$txt['ncode_imageresizer_open_new'] = 'Abrir en una nueva ventana';
$txt['ncode_imageresizer_max_width'] = 'Anchura m&aacute;xima';
$txt['ncode_imageresizer_max_height'] = 'Peso m&aacute;ximo<br /><span class="smalltext">Dejar en blanco para que no haya peso m&aacute;ximo.</span>';
// --- End added code ---
$txt['display_facebook_like'] 		= 'Activar icono de Megusta?';
$txt['display_facebook_like_desc'] 	= 'Activa esta opcion si deseas que se muestre el boton en los posts';
$txt['display_facebook_like_all'] 	= 'Mostrar el icono de Megusta en todos los posts?';
$txt['display_facebook_like_all_desc'] 	= 'Enabling this will Display the Facebook Like Icon within all posts. Note Display Facebook Like Icon has to be enabled';

$txt['aeiou'] = 'AEIOU';
$txt['aeiou_title'] = 'Auto Email Inactive Ordinary Users';
$txt['aeiou_enable'] = 'Enable Automatic Emailing Of Inactive Users';
$txt['aeiou_email_desc1'] = 'Text-Only (No html, no bbcode)';
$txt['aeiou_email_desc2'] = 'Allowed Variables';
$txt['aeiou_email_desc3'] = '$username, $displayname, $forum, $link, $lostpassword';
$txt['aeiou_initial_subject'] = 'Initial Email Subject';
$txt['aeiou_initial_message'] = 'Initial Email Message';
$txt['aeiou_final_subject'] = 'Final Email Subject';
$txt['aeiou_final_message'] = 'Final Email Message';
$txt['aeiou_delete'] = 'Auto Delete Members (Except Admins)';
$txt['aeiou_delete_desc'] = 'After being sent an initial and final email AND has not returned within a further 21 days (Minimum 63 days total)';
$txt['aeiou_underposts'] = 'Delete Member Post Threshold';
$txt['aeiou_underposts_desc'] = 'With a postcount less than or equal to.';
$txt['aeiou_warning'] = 'It is NOT Recommended To Change Settings Below';
$txt['aeiou_warning2'] = 'Mail is sent in small chunks with hourly/daily limits to ensure your IMPORTANT mail all gets through.';
$txt['aeiou_warning3'] = '(such as Activation Emails, Notifications, Emails, Announcements, Newsletters)';
$txt['aeiou_warning4'] = 'Try reducing the amounts if your emails are not being received.';
$txt['aeiou_hour_max'] = 'Max Emails Per Hour';
$txt['aeiou_hour_max_desc'] = 'Based on a hosts limit of 100 per hour';
$txt['aeiou_day_max'] = 'Max Emails Per Day';
$txt['aeiou_day_max_desc'] = 'Based on a hosts limit of 1000 per day';
$txt['aeiou_chunksize'] = 'Send x emails at a time';
$txt['aeiou_chunksize_desc'] = 'With a min 5 minute interval';
$txt['aeiou_active'] = 'Active';
$txt['aeiou_reactivated'] = 'Re-Activated';
$txt['aeiou_reachedhourlylimit'] = 'Reached Hourly Limit';
$txt['aeiou_reacheddailylimit'] = 'Reached Daily Limit';
$txt['aeiou_nofurtheremails'] = 'No Further Emails To Send';
$txt['aeiou_stopped'] = 'Stopped';
$txt['aeiou_last_ran'] = 'Last Ran';
$txt['aeiou_starts_again'] = 'Will Start Again';
$txt['aeiou_sent_day'] = 'Emails Sent Today';
$txt['aeiou_sent_hour'] = 'Emails Sent This Hour';
$txt['aeiou_awaiting_total'] = 'Total Emails Awaiting To Be Sent';
$txt['aeiou_awaiting_initial_email'] = 'No. of Initial Emails';
$txt['aeiou_awaiting_final_email'] = 'No. of Final Emails';
$txt['aeiou_awaiting_deletion'] = 'Users Awaiting Deletion';
$txt['aeiou_disabled'] = '(Disabled)';
$txt['aeiou_none'] = 'None';
$txt['aeiou_never'] = 'Never';
$txt['aeiou_status'] = 'Status';
$txt['aeiou_max'] = 'Max';
$txt['aeiou_initial'] = 'Initial Email';
$txt['aeiou_final'] = 'Final Email';
$txt['aeiou_last10emailed'] = 'Last 10 Inactive Users Emailed';
$txt['aeiou_default_subject'] = 'Hey $displayname';
$txt['aeiou_default_message'] = 'Hey $displayname, we have missed you at $forum.
Since its been a while, we thought we would send you a personal invitation to return.

$link

Your login username is $username.
If you have forgotten your password you can request it at $lostpassword

Regards
$forum staff';
?>