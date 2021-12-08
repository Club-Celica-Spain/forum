<?php
// Version: 1.1; Modifications


$txt['youtube'] = 'YouTube';
$txt['youtube_invalid'] = '#Link de YouTube Inválido#';

$txt['youtube'] = 'YouTube';
$txt['youtube_invalid'] = '#Link de YouTube Inválido#';

// Hack's Park Shoutbox -->
$txt['sba_title'] = 'Shoutbox';
$txt['sba_link'] = 'Shoutbox Admin';

$txt['permissiongroup_shoutbox'] = 'Shoutbox';
$txt['permissiongroup_simple_shoutbox'] = 'Shoutbox';
$txt['permissionname_shoutbox_view'] = 'View Shoutbox';
$txt['permissionname_shoutbox_post'] = 'Post messages in Shoutbox';
$txt['permissiongroup_shoutbox_panel'] = 'Shoutbox Moderation Panel';
$txt['permissiongroup_simple_shoutbox_panel'] = 'Shoutbox Moderation Panel';
$txt['permissionname_shoutbox_edit'] = 'Edit messages in Shoutbox';
$txt['permissionname_shoutbox_delete'] = 'Delete messages in Shoutbox';
$txt['permissionname_shoutbox_prune'] = 'Empty Shoutbox';
$txt['permissionname_shoutbox_ban'] = 'Ban users in Shoutbox';
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
// noHACE NADA
$txt['scheduled_task_email_inactive'] = 'Auto Email Inactive Users';
$txt['scheduled_task_desc_email_inactive'] = 'Sends out a reminder to members inactive for 21 days. <a href="' . $scripturl. '?action=admin;area=modsettings;sa=aeiou">Settings.</a>';
$txt['aeiou'] = 'Email Inactive';
$txt['aeiou_title'] = 'Auto Email Inactive Ordinary Users';
$txt['aeiou_status'] = 'AEIOU is {STATUS}. Configure it on the {PAGE} page.';
$txt['aeiou_mail_status'] = 'Mail queue is {STATUS}. This can cause performance problems.<br />Enable it on the {PAGE} page.';
$txt['aeiou_enabled'] = 'enabled';
$txt['aeiou_disabled'] = 'DISABLED';
$txt['aeiou_settings'] = 'Settings';
$txt['aeiou_initial_subject'] = 'Initial Email Subject';
$txt['aeiou_initial_message'] = 'Initial Email Message';
$txt['aeiou_final_subject'] = 'Final Email Subject';
$txt['aeiou_final_message'] = 'Final Email Message';
$txt['aeiou_email_desc1'] = 'Text-Only (No html, no bbcode)';
$txt['aeiou_email_desc2'] = 'Allowed Variables';
$txt['aeiou_email_desc3'] = '$username, $displayname, $forum, $link, $lostpassword';
$txt['aeiou_last_emailed'] = 'Last 10 Inactive Users Emailed';
$txt['aeiou_never'] = 'Never';
$txt['aeiou_initial'] = 'Initial Email';
$txt['aeiou_final'] = 'Final Email';
$txt['aeiou_default_subject'] = 'Hola $displayname';
$txt['aeiou_default_message'] = 'Hola $displayname, te echamos de menos en $forum.
Por que no te pasas y nos echas un vistazo de nuevo!

$link

Tu usuario es $username.
Si has olvidado la contraseña, puedes recuperarla a través de este enlace $lostpassword
Un saludo
$forum Staff';
?>