<?php
/********************************************************
* Adk Portal                   
* Version: 2.0
* Official support: http://www.smfpersonal.net           
* Founder & Developer: Lucas-ruroken
* Project Manager: ^Heracles^ - Enik
* 2009-2011
* Smf Personal - Home of adkportal
/**********************************************************/

//Las noticias
function template_view()
{
	global  $scripturl, $context, $txt, $adkportal;
	
	echo'
		<div class="cat_bar">
			<h3 class="catbg">
				'.$txt['news_smfp'].'
			</h3>
		</div>
		<table class="adk_100">
			<tr>
				<td class="adk_70">
					<span class="clear upperframe"><span></span></span>
					<div class="roundframe">
					<div class="innerframe">
						<div class="adk_padding_2">
						<div class="adk_get_news"><div class="adk_get_news_2">',getAdkNews(),'</div>
						</div></div>
					</div>
					</div>
					<span class="lowerframe"><span></span></span>
				</td>
				<td class="adk_30">
					<span class="clear upperframe"><span></span></span>
					<div class="roundframe">
					<div class="innerframe">
						<div class="adk_padding_2">
							<div class="adk_get_news"><div class="adk_get_news_2">
							'.$txt['adk_yourversion'].': '.$context['adkportal']['your_version'].'<br />
							'.$txt['adk_currentversion'].': '.$context['adkportal']['style_version'].'
							</div>
						</div></div>
					</div>
					</div>
					<span class="lowerframe"><span></span></span>
				</td>
			</tr>
		</table>';
		
		ILoveAdkPortal();

}

//Ajustes principales
function template_adksettings()
{
	global  $scripturl, $context, $txt, $adkportal, $boardurl;
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=adkadmin;sa=adksavesettings">	
		<table cellpadding="8" cellspacing="1" border="0" class="tborder" width="100%">
			<tr class="catbg">
				<td colspan="2">
					<img class="adk_vertical_align" alt="" src="'.$boardurl.'/adkportal/images/computer.png" />&nbsp;'.$txt['opcion_adk'].'
				</td>
			</tr>
			<tr class="windowbg">
				<td class="adk_50">
					<strong>'.$txt['adkportal_activate'].'</strong>
					<div class="smalltext">'.$txt['adkportal_activate_2'].'</div>
				</td>
				<td>
					<select name="adk_enable">
						<option value="0"',$adkportal['adk_enable'] == 0 ? ' selected="selected"' : '' ,'>'.$txt['adk_desctivado'].'</option>
						<option value="1"',$adkportal['adk_enable'] == 1 ? ' selected="selected"' : '' ,'>'.$txt['activado'].'</option>
						<option value="2"',$adkportal['adk_enable'] == 2 ? ' selected="selected"' : '' ,'>'.$txt['adk_url_alone'].'</option>
					</select>
				</td>
			</tr>
			<tr class="windowbg2">
				<td class="adk_50">
					<strong>'.$txt['adk_url_asdsda'].'</strong>
					<div class="smalltext">'.$txt['adk_url_asdsda_2'].'</div>
				</td>
				<td>
					<input type="text" name="adk_stand_alone_url"  value="',!empty($adkportal['adk_stand_alone_url']) ? $adkportal['adk_stand_alone_url'] : '' ,'" />
				</td>
			</tr>
			<tr class="windowbg">
				<td class="adk_50">
					<strong>'.$txt['adk_hide_version'].'</strong>
					<div class="smalltext">'.$txt['adk_hide_version_2'].'</div>
				</td>
				<td>
					<input type="checkbox" name="adk_hide_version"',!empty($adkportal['adk_hide_version']) ? ' checked="checked"' : '' ,'" />
				</td>
			</tr>

			<tr class="windowbg2">
				<td class="adk_50">
					'.$txt['adk_change_title'].'
				</td>
				<td>
					<input type="text" name="change_title"  value="'.$adkportal['change_title'].'" />
				</td>
			</tr>
			<tr class="windowbg">			
				<td class="adk_50 adk_font_bold">
					'.$txt['cleft'].'
				</td>
				<td>
					<input type="checkbox" value="1" name="cleft"  ',getCheckbox('cleft'),' />
				</td>
			</tr>
			<tr class="windowbg2">
				<td class="adk_50 adk_font_bold">
					'.$txt['cright'].'
				</td>
				<td>
					<input type="checkbox" value="1" name="cright"  ',getCheckbox('cright'),' />
				</td>
			</tr>
			<tr class="windowbg">
				<td class="adk_50">
					'.$txt['enable_left_forum'].'
				</td>
				<td>
					<input type="checkbox" value="1" name="enable_left_forum"  ',getCheckbox('enable_left_forum'),' />
				</td>
			</tr>				
			<tr class="windowbg2">
				<td class="adk_50">
					'.$txt['enable_right_forum'].'
				</td>
				<td>
					<input type="checkbox" value="1" name="enable_right_forum"  ',getCheckbox('enable_right_forum'),' />
				</td>
			</tr>	
			
			<tr class="windowbg">
				<td class="adk_50">
					'.$txt['enable_top_forum'].'
				</td>
				<td>
					<input type="checkbox" value="1" name="enable_top_forum"  ',getCheckbox('enable_top_forum'),' />
				</td>
			</tr>
			<tr class="windowbg2">
				<td class="adk_50">
					'.$txt['enable_bottom_forum'].'
				</td>
				<td>
					<input type="checkbox" value="1" name="enable_bottom_forum"  ',getCheckbox('enable_bottom_forum'),' />
				</td>
			</tr>	
				
			<tr class="windowbg">
				<td class="adk_50">
					'.$txt['width_portal'].'
				</td>
				<td>
					'.$txt['left'].' <input type="text" size="2" name="wleft" value="',$adkportal['wleft'],'" />
					
					&nbsp;|&nbsp;
					'.$txt['derecha'].' <input type="text" size="2" name="wright" value="',$adkportal['wright'],'" />
				</td>
			</tr>
			<tr class="windowbg2">
				<td class="adk_50">
					<strong>'.$txt['adk_enable_wm'].'</strong>
					<div class="smalltext">'.$txt['adk_enable_wm2'].'
						<br /><a href="http://www.smfpersonal.net/imagen-themes/sw.JPG">Demo</a>
					</div>
				</td>
				<td>
					<input type="checkbox" name="enable_watermark" value="1" ',getCheckbox('enable_watermark'),!check_if_gd() ? ' onclick="return false;"' : '' ,' />
				</td>
			</tr>
			<tr class="windowbg">
				<td class="adk_50">
					<strong>'.$txt['adk_enable_related'].'</strong>
					<div class="smalltext">'.$txt['adk_enable_related2'].'</div>
				</td>
				<td>
					<input type="checkbox" name="enable_related_topics" value="1" ',getCheckbox('enable_related_topics'),' />
				</td>
			</tr>
			<tr class="windowbg2">
				<td class="adk_50">
					'.$txt['adk_format_blocks'].'
				</td>
				<td>
					<select name="title_in_blocks">
						<option value="1" ',analizar_selected_adk('title_in_blocks',1),'>'.$txt['adk_roundFrame'].' ('.$txt['adk_catbg'].')</option>
						<option value="2" ',analizar_selected_adk('title_in_blocks',2),'>'.$txt['adk_roundFrame'].' + '.$txt['title_InBlocks'].' ('.$txt['adk_catbg'].')</option>
						<option value="7" ',analizar_selected_adk('title_in_blocks',7),'>'.$txt['adk_roundFrame'].' ('.$txt['adk_titlebg'].')</option>
						<option value="8" ',analizar_selected_adk('title_in_blocks',8),'>'.$txt['adk_roundFrame'].' + '.$txt['title_InBlocks'].' ('.$txt['adk_titlebg'].')</option>
						<option value="5" ',analizar_selected_adk('title_in_blocks',5),'>'.$txt['adk_tables'].'</option>
						<option value="3" ',analizar_selected_adk('title_in_blocks',3),'>'.$txt['adk_windowbg'].'</option>
						<option value="4" ',analizar_selected_adk('title_in_blocks',4),'>'.$txt['adk_windowbg'].'  + '.$txt['title_InBlocks'].'</option>
						<option value="6" ',analizar_selected_adk('title_in_blocks',6),'>'.$txt['adk_todoenuno'].'</option>
					</select>
				</td>
			</tr>
			<tr class="windowbg">
				<td class="adk_50">
					'.$txt['enable_img_blocks'].'
				</td>
				<td>
					'.$txt['yes'].'<input type="radio" value="1" name="enable_img_blocks"  ',$adkportal['enable_img_blocks'] == 1 ? 'checked="checked"' : '' ,' /> '.$txt['no'].'<input type="radio" value="0" name="enable_img_blocks"  ',$adkportal['enable_img_blocks'] == 0 ? 'checked="checked"' : '' ,' />
				</td>
			</tr>
			<tr class="information">
				<td class="text_align_center" colspan="2">
					<input type="hidden" name="sc" value="', $context['session_id'], '" />
					<input class="button_submit" type="submit" value="'.$txt['save'].'" />
				</td>
			</tr>
		</table>
	</form>';	
	
	ILoveAdkPortal();
}

function template_view_icons()
{
	global $context, $txt, $boardurl, $scripturl;
	
	echo'
	<table cellpadding="8" cellspacing="1" border="0" class="tborder" style="width: 100%;">
		<tr>
			<td class="h3_padding" colspan="2"><div class="title_bar"><h3 class="titlebg">'.$txt['adk_manage_icons_2'].'
			<span style="float: right;">
				<img class="adk_padding_img" src="'.$boardurl.'/adkportal/images/blocks/disk.png" alt="" />&nbsp;<a href="'.$scripturl.'?action=admin;area=adkadmin;sa=manageicons;set=addicon;'.$context['session_var'].'='.$context['session_id'].'">'.$txt['adk_add_icon'].'</a>
			</span></h3></div>
			</td>
		</tr>
	</table>';
	
	echo'
		<table cellpadding="8" cellspacing="1" border="0" class="tborder adk_100">
			<tr>';
	$i = 0;			
	foreach ($context['load_icons'] AS $icon)
	{
		if($i == 2)
		{
			echo'</tr><tr>';
			$i = 0;
		}
		$class = $i == 0 ? 'windowbg' : 'windowbg2';
		$class2 = $i == 0 ? 'windowbg2' : 'windowbg';
		
		echo'
		<td class="'.$class.' adk_padding_5 adk_25" align="right"><img src="'.$boardurl.'/adkportal/images/blocks/'.$icon['icon'].'" alt="" />&nbsp;'.$icon['icon'].'</td>
		<td class="'.$class2.' adk_padding_5 adk_25" align="left">
			<a onclick="return confirm(\'', $txt['adk_delete'], '?\');" href="'.$scripturl.'?action=admin;area=adkadmin;sa=manageicons;set=deleteicon;id='.$icon['id'].';'.$context['session_var'].'='.$context['session_id'].'">
				<img src="'.$boardurl.'/adkportal/images/cancel.png" alt="'.$txt['borrar'].'" title="'.$txt['borrar'].'" />
			</a>
		</td>';
		$i++;
	}
	
	echo'
			</tr>
		</table>';
								
	ILoveAdkPortal();

}

function template_addicon()
{

	global $context, $scripturl, $txt;
	
	echo'
	<form enctype="multipart/form-data" action="'.$scripturl.'?action=admin;area=adkadmin;sa=manageicons;set=saveicon" method="post">
		<div class="cat_bar">
			<h3 class="catbg">
				'.$txt['adk_add_icon'].'
			</h3>
		</div>
		<div class="windowbg"><span class="topslice"><span></span></span>
			<div class="adk_padding_8 text_align_center">
				'.$txt['adk_select_a_icon'].'&nbsp;<input size="16" type="file" value="" name="file" /><br />
				<input type="hidden" name="sc" value="', $context['session_id'], '" />
				<input class="button_submit" type="submit" value="'.$txt['save'].'" />
			</div>
		<span class="botslice"><span></span></span></div>
	</form>';
	
	ILoveAdkPortal();

}

function template_preview_adkblock()
{
	global  $scripturl, $context, $txt, $boarddir, $boardurl, $adkportal;
	
	echo'<br />';
	
	$width = 100;
	
	if($context['adkportal']['blocks']['columna'] == 1)
		$width = $adkportal['wleft'];
	elseif($context['adkportal']['blocks']['columna'] == 3)
		$width = $adkportal['wright'];
	
	echo'<div style="width: '.$width.';">';
	
	adk_create_block($context['adkportal']['blocks'], false);
	
	echo'</div>';
	
	ILoveAdkPortal();

}
	
//Los bloques
function template_viewblocks()
{
	global  $scripturl, $context, $txt, $boarddir, $boardurl;

	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=savesettingsblocks">
		<div class="tborder smalltext">
			<div class="cat_bar">
				<h3 class="catbg">
					<img class="adk_vertical_align" alt="" src="'.$boardurl.'/adkportal/images/brick.png" />&nbsp;'.$txt['bloques'].'
				</h3>
			</div>
			<table cellpadding="8" cellspacing="1" border="0" class="tborder adk_100">
				<tr>
					<td class="h3_padding" colspan="6"><div class="title_bar"><h3 class="titlebg">'.$txt['left'].'</h3></div></td>
				</tr>
				<tr>
					<td class="titlebg adk_15 text_align_center">'. $txt['posicion']. '</td>
					<td class="titlebg adk_35 text_align_center">'. $txt['icon_bloque']. ' - '. $txt['nombre_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['tipo_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['columna']. '</td>
					<td class="titlebg adk_15 text_align_center">'. $txt['activado']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['adk_options']. '</td>
				</tr>';	
	
	$l = 0;
	if(!empty($context['left']))
	foreach ($context['left'] AS $poster)				
	{		
		$img = !empty($poster['img']) ? '<img src="'.$boardurl.'/adkportal/images/blocks/'.$poster['img'].'" alt="" align="top" />' : '&nbsp&nbsp&nbsp&nbsp';
		
		echo'
							
				<tr>
					<td class="windowbg adk_15" style="text-align: center;">
						<input type="text" size="2" name="ordenleft['.$l.']" value="'.$poster['orden'].'" style="text-align: center;" />
						<input type="hidden" name="idleft['.$l.']" value="'.$poster['id'].'" />
					</td>
					<td class="windowbg2 adk_35" valign="middle">', $img, '&nbsp;', $poster['name'], '</td>
					<td class="windowbg adk_10" style="text-align: center;">(',$poster['type'],')</td>
					<td class="windowbg2 adk_10" style="text-align: center;">
						<select name="columnaleft['.$l.']">
						<option value="1">'.$txt['left'].'</option>
						<option value="2">'.$txt['centro'].'</option>
						<option value="3">'.$txt['derecha'].'</option>
						<option value="4">'.$txt['adk_block_top'].'</option>
						<option value="5">'.$txt['adk_block_bottom'].'</option>
						</select>
					</td>
					<td class="windowbg adk_15" style="text-align: center;">'.$txt['yes'].'<input type="radio" value="1" name="activateleft['.$l.']" ', $poster['activate'] == 1 ? 'checked="checked"' : '' ,' /> | '.$txt['no'].'<input type="radio" value="0" name="activateleft['.$l.']" ', $poster['activate'] == 0 ? 'checked="checked"' : '' ,' />';
	echo'
					</td>
					<td class="windowbg2 adk_10" style="text-align: center;">';
						echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=editblocks;edit='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/b_edit.png" alt="'.$txt['editar'].'" title="'.$txt['editar'].'" /></a>&nbsp;';
						echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=previewblock;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/admin.png" alt="'.$txt['adk_demo'].'" title="'.$txt['adk_demo'].'" /></a>&nbsp;';
						echo'	
							<a onclick="return confirm(\'', $txt['adk_delete'], '?\');" href="'.$scripturl.'?action=admin;area=blocks;sa=deleteblocks;delete='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/cancel.png"  alt="'.$txt['borrar'].'" title="'.$txt['borrar'].'" /></a>';
						
						echo'	
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=permissions;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/users.png"  alt="'.$txt['adk_permissions_block'].'" title="'.$txt['adk_permissions_block'].'" /></a>';
						
		echo'
					</td>
				</tr> 
			';
						
		$l++;				
	}
		
	
	echo'	</table>
			<table cellpadding="8" cellspacing="1" border="0" class="tborder adk_100">
				<tr>
					<td class="h3_padding" colspan="6"><div class="title_bar"><h3 class="titlebg">'.$txt['centro'].'</h3></div></td>
				</tr>
				<tr>
					<td class="titlebg adk_15 text_align_center">'. $txt['posicion']. '</td>
					<td class="titlebg adk_35 text_align_center">'. $txt['icon_bloque']. ' - '. $txt['nombre_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['tipo_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['columna']. '</td>
					<td class="titlebg adk_15 text_align_center">'. $txt['activado']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['adk_options']. '</td>
				</tr>';	
					
	$c = 0;	
	if(!empty($context['center']))
	foreach ($context['center'] AS $poster)
	{
		$img = !empty($poster['img']) ? '<img src="'.$boardurl.'/adkportal/images/blocks/'.$poster['img'].'" alt="" align="top" />' : '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo'
				<tr>
					<td class="windowbg adk_15" style="text-align: center;">
						<input type="text" size="2" name="ordencenter['.$c.']" value="'.$poster['orden'].'" style="text-align: center;" />
						<input type="hidden" name="idcenter['.$c.']" value="'.$poster['id'].'" />
					</td>
					<td class="windowbg2 adk_35" valign="middle">', $img, '&nbsp;', $poster['name'], '</td>
					<td class="windowbg adk_10" style="text-align: center;">(',$poster['type'],')</td>
					<td class="windowbg2 adk_10" style="text-align: center;">
						<select name="columnacenter['.$c.']">
						<option value="2">'.$txt['centro'].'</option>
						<option value="1">'.$txt['left'].'</option>
						<option value="3">'.$txt['derecha'].'</option>
						<option value="4">'.$txt['adk_block_top'].'</option>
						<option value="5">'.$txt['adk_block_bottom'].'</option>
						</select>
					</td>
					<td class="windowbg adk_15" style="text-align: center;">'.$txt['yes'].'<input type="radio" value="1" name="activatecenter['.$c.']" ', $poster['activate'] == 1 ? 'checked="checked"' : '' ,' /> | '.$txt['no'].'<input type="radio" value="0" name="activatecenter['.$c.']" ', $poster['activate'] == 0 ? 'checked="checked"' : '' ,' />';
	echo'
					</td>
					<td class="windowbg2 adk_10" style="text-align: center;">';
							echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=editblocks;edit='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/b_edit.png" alt="'.$txt['editar'].'" title="'.$txt['editar'].'" /></a>&nbsp;';
						echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=previewblock;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/admin.png" alt="'.$txt['adk_demo'].'" title="'.$txt['adk_demo'].'" /></a>&nbsp;';
						echo'	
							<a onclick="return confirm(\'', $txt['adk_delete'], '?\');" href="'.$scripturl.'?action=admin;area=blocks;sa=deleteblocks;delete='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/cancel.png"  alt="'.$txt['borrar'].'" title="'.$txt['borrar'].'" /></a>';
						
						echo'	
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=permissions;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/users.png"  alt="'.$txt['adk_permissions_block'].'" title="'.$txt['adk_permissions_block'].'" /></a>';
		echo'
					</td>
				</tr>
			';
		$c++;
	}
					
	echo'
			</table>
			<table cellpadding="8" cellspacing="1" border="0" class="tborder adk_100">
				<tr>
					<td class="h3_padding" colspan="6"><div class="title_bar"><h3 class="titlebg">'.$txt['derecha'].'</h3></div></td>
				</tr>
				<tr>
					<td class="titlebg adk_15 text_align_center">'. $txt['posicion']. '</td>
					<td class="titlebg adk_35 text_align_center">'. $txt['icon_bloque']. ' - '. $txt['nombre_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['tipo_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['columna']. '</td>
					<td class="titlebg adk_15 text_align_center">'. $txt['activado']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['adk_options']. '</td>
				</tr>';	
					
	$r = 0;	
	if(!empty($context['right']))
	foreach ($context['right'] AS $poster)
	{
		$img = !empty($poster['img']) ? '<img src="'.$boardurl.'/adkportal/images/blocks/'.$poster['img'].'" alt="" align="top" />' : '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo'
						
				<tr>
					<td class="windowbg" width="15%" style="text-align: center;">
						<input type="text" size="2" name="ordenright['.$r.']" value="'.$poster['orden'].'" style="text-align: center;" />
						<input type="hidden" name="idright['.$r.']" value="'.$poster['id'].'" />
					</td>
					<td class="windowbg2 adk_35" valign="middle">', $img, '&nbsp;', $poster['name'], '</td>
					<td class="windowbg adk_10" style="text-align: center;">(',$poster['type'],')</td>
					<td class="windowbg2 adk_10" style="text-align: center;">
						<select name="columnaright['.$r.']">
						<option value="3">'.$txt['derecha'].'</option>
						<option value="2">'.$txt['centro'].'</option>
						<option value="1">'.$txt['left'].'</option>
						<option value="4">'.$txt['adk_block_top'].'</option>
						<option value="5">'.$txt['adk_block_bottom'].'</option>
						</select>
					</td>
					<td class="windowbg adk_15" style="text-align: center;">'.$txt['yes'].'<input type="radio" value="1" name="activateright['.$r.']" ', $poster['activate'] == 1 ? 'checked="checked"' : '' ,' /> | '.$txt['no'].'<input type="radio" value="0" name="activateright['.$r.']" ', $poster['activate'] == 0 ? 'checked="checked"' : '' ,' />';
	echo'
					</td>
					<td class="windowbg2 adk_10" style="text-align: center;">';
				
							echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=editblocks;edit='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/b_edit.png" alt="'.$txt['editar'].'" title="'.$txt['editar'].'" /></a>&nbsp;';
						echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=previewblock;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/admin.png" alt="'.$txt['adk_demo'].'" title="'.$txt['adk_demo'].'" /></a>&nbsp;';
						echo'	
							<a onclick="return confirm(\'', $txt['adk_delete'], '?\');" href="'.$scripturl.'?action=admin;area=blocks;sa=deleteblocks;delete='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/cancel.png"  alt="'.$txt['borrar'].'" title="'.$txt['borrar'].'" /></a>';
						
						echo'	
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=permissions;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/users.png"  alt="'.$txt['adk_permissions_block'].'" title="'.$txt['adk_permissions_block'].'" /></a>';
		echo'
					</td>
				</tr>
			';
		$r++;
	}		
	
	echo'	</table>
			<table cellpadding="8" cellspacing="1" border="0" class="tborder adk_100">
				<tr>
					<td class="h3_padding" colspan="6"><div class="title_bar"><h3 class="titlebg">'.$txt['adk_block_top'].'</h3></div></td>
				</tr>
				<tr>
					<td class="titlebg adk_15 text_align_center">'. $txt['posicion']. '</td>
					<td class="titlebg adk_35 text_align_center">'. $txt['icon_bloque']. ' - '. $txt['nombre_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['tipo_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['columna']. '</td>
					<td class="titlebg adk_15 text_align_center">'. $txt['activado']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['adk_options']. '</td>
				</tr>';	
					
	$t = 0;	
	if(!empty($context['top']))
	foreach ($context['top'] AS $poster)
	{
		$img = !empty($poster['img']) ? '<img src="'.$boardurl.'/adkportal/images/blocks/'.$poster['img'].'" alt="" align="top" />' : '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo'
					
				<tr>
					<td class="windowbg adk_15" style="text-align: center;">
						<input type="text" size="2" name="ordentop['.$t.']" value="'.$poster['orden'].'" style="text-align: center;" />
						<input type="hidden" name="idtop['.$t.']" value="'.$poster['id'].'" />
					</td>
					<td class="windowbg2 adk_35" valign="middle">', $img, '&nbsp;', $poster['name'], '</td>
					<td class="windowbg adk_10" style="text-align: center;">(',$poster['type'],')</td>
					<td class="windowbg2 adk_10" style="text-align: center;">
						<select name="columnatop['.$t.']">
						<option value="4">'.$txt['adk_block_top'].'</option>
						<option value="5">'.$txt['adk_block_bottom'].'</option>
						<option value="3">'.$txt['derecha'].'</option>
						<option value="2">'.$txt['centro'].'</option>
						<option value="1">'.$txt['left'].'</option>
						</select>
					</td>
					<td class="windowbg adk_15" style="text-align: center;">'.$txt['yes'].'<input type="radio" value="1" name="activatetop['.$t.']" ', $poster['activate'] == 1 ? 'checked="checked"' : '' ,' /> | '.$txt['no'].'<input type="radio" value="0" name="activatetop['.$t.']" ', $poster['activate'] == 0 ? 'checked="checked"' : '' ,' />';
	echo'
					</td>
					<td class="windowbg2 adk_10" style="text-align: center;">';
				
							echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=editblocks;edit='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/b_edit.png" alt="'.$txt['editar'].'" title="'.$txt['editar'].'" /></a>&nbsp;';
						echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=previewblock;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/admin.png" alt="'.$txt['adk_demo'].'" title="'.$txt['adk_demo'].'" /></a>&nbsp;';
						echo'	
							<a onclick="return confirm(\'', $txt['adk_delete'], '?\');" href="'.$scripturl.'?action=admin;area=blocks;sa=deleteblocks;delete='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/cancel.png"  alt="'.$txt['borrar'].'" title="'.$txt['borrar'].'" /></a>';
						
						echo'	
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=permissions;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/users.png"  alt="'.$txt['adk_permissions_block'].'" title="'.$txt['adk_permissions_block'].'" /></a>';
		echo'
					</td>
				</tr>
			';
		$t++;
	}
	
	
	echo'	</table>
			<table cellpadding="8" cellspacing="1" border="0" class="tborder adk_100">
				<tr>
					<td class="h3_padding" colspan="6"><div class="title_bar"><h3 class="titlebg">'.$txt['adk_block_bottom'].'</h3></div></td>
				</tr>
				<tr>
					<td class="titlebg adk_15 text_align_center">'. $txt['posicion']. '</td>
					<td class="titlebg adk_35 text_align_center">'. $txt['icon_bloque']. ' - '. $txt['nombre_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['tipo_bloque']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['columna']. '</td>
					<td class="titlebg adk_15 text_align_center">'. $txt['activado']. '</td>
					<td class="titlebg adk_10 text_align_center">'. $txt['adk_options']. '</td>
				</tr>';	
					
	$b = 0;	
	if(!empty($context['bottom']))
	foreach ($context['bottom'] AS $poster)
	{
		$img = !empty($poster['img']) ? '<img src="'.$boardurl.'/adkportal/images/blocks/'.$poster['img'].'" alt="" align="top" />' : '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo'
				<tr>
					<td class="windowbg adk_15" style="text-align: center;">
						<input type="text" size="2" name="ordenbottom['.$b.']" value="'.$poster['orden'].'" style="text-align: center;" />
						<input type="hidden" name="idbottom['.$b.']" value="'.$poster['id'].'" />
					</td>
					<td class="windowbg2 adk_35" valign="middle">', $img, '&nbsp;', $poster['name'], '</td>
					<td class="windowbg adk_10" style="text-align: center;">(',$poster['type'],')</td>
					<td class="windowbg2 adk_10" style="text-align: center;">
						<select name="columnabottom['.$b.']">
						<option value="5">'.$txt['adk_block_bottom'].'</option>
						<option value="4">'.$txt['adk_block_top'].'</option>
						<option value="3">'.$txt['derecha'].'</option>
						<option value="2">'.$txt['centro'].'</option>
						<option value="1">'.$txt['left'].'</option>
						</select>
					</td>
					<td class="windowbg adk_15" style="text-align: center;">'.$txt['yes'].'<input type="radio" value="1" name="activatebottom['.$b.']" ', $poster['activate'] == 1 ? 'checked="checked"' : '' ,' /> | '.$txt['no'].'<input type="radio" value="0" name="activatebottom['.$b.']" ', $poster['activate'] == 0 ? 'checked="checked"' : '' ,' />';
		echo'
					</td>
					<td class="windowbg2 adk_10" style="text-align: center;">';
				
							echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=editblocks;edit='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/b_edit.png" alt="'.$txt['editar'].'" title="'.$txt['editar'].'" /></a>&nbsp;';
						echo'
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=previewblock;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/admin.png" alt="'.$txt['adk_demo'].'" title="'.$txt['adk_demo'].'" /></a>&nbsp;';
						echo'	
							<a onclick="return confirm(\'', $txt['adk_delete'], '?\');" href="'.$scripturl.'?action=admin;area=blocks;sa=deleteblocks;delete='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/cancel.png"  alt="'.$txt['borrar'].'" title="'.$txt['borrar'].'" /></a>';
						
						echo'	
							<a href="'.$scripturl.'?action=admin;area=blocks;sa=permissions;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
							<img src="', $boardurl, '/adkportal/images/users.png"  alt="'.$txt['adk_permissions_block'].'" title="'.$txt['adk_permissions_block'].'" /></a>';
		echo'
					</td>
				</tr>
			';
		$b++;
	}
	
	
	echo'		</table>
				<table cellpadding="10" cellspacing="1" border="0" class="tborder" style="width: 100%;">	
					<tr>
						<td class="windowbg" style="text-align: center;" colspan="6">
							<input type="hidden" name="sc" value="', $context['session_id'], '" />
							<input class="button_submit" type="submit" value="'.$txt['save'].'" />
						</td>
					</tr>
				</table>
			</div>	
	</form>';
	
	ILoveAdkPortal();
				
}

function template_settings_blocks()
{
	global  $scripturl, $context, $txt, $adkportal, $boardurl;
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=savesettingsblocks2">
	<table cellpadding="8" cellspacing="1" border="0" class="tborder adk_100"> 
		<tr>
			<td style="width: 50%; padding-right: 7px;" valign="top">
				<table style="width: 100%;">
					<tr>
						<td colspan="2">
							<div class="cat_bar"><h4 class="catbg">'.$txt['aporte'].'</h4></div>
						</td>
					</tr>
					<tr class="windowbg">
						<td style="width: 50%;">
							'.$txt['cantidad_noticias'].'
						</td>
						<td>
							<input type="text" size="2" maxlength="2" name="adk_news" value="',$adkportal['adk_news'],'" />
						</td>
					</tr>
					<tr class="windowbg">
						<td style="width: 50%;">
							<strong>'.$txt['adk_add_twitter_facebook'].'</strong>
							<div class="smalltext">'.$txt['adk_add_twitter_facebook_2'].'</div>
						</td>
						<td>
							<input type="checkbox" name="adk_bookmarks_news"',!empty($adkportal['adk_bookmarks_news']) ? ' checked="checked"' : '' ,' />
						</td>
					</tr>
					
					<tr><td colspan="2"></td></tr>
					
					<tr>
						<td colspan="2">
							<div class="cat_bar"><h4 class="catbg">'.$txt['adk_block_top_poster'].'</h4></div>
						</td>
					</tr>
					<tr class="windowbg">
						<td style="width: 50%;">
							'.$txt['txt_top_poster'].'
						</td>
						<td>
							<input type="text" size="2" maxlength="2" name="top_poster"  value="',$adkportal['top_poster'],'" />
						</td>
					</tr>
					
					<tr><td colspan="2"></td></tr>
					
					<tr>
						<td colspan="2">
							<div class="cat_bar"><h4 class="catbg">'.$txt['adk_block_last_post'].'</h4></div>
						</td>
					</tr>
					<tr class="windowbg">
						<td style="width: 50%;">
							'.$txt['txt_ultimos_mensajes'].'
						</td>
						<td>
							<input type="text" size="2" maxlength="2" name="ultimos_mensajes" value="',$adkportal['ultimos_mensajes'],'" />
						</td>
					</tr>
					
					<tr><td colspan="2"></td></tr>
					
					<tr>
						<td colspan="2">
							<div class="cat_bar"><h4 class="catbg">'.$txt['adk_block_users_online'].'</h4></div>
						</td>
					</tr>
					<tr class="windowbg">
						<td style="width: 50%;">
							'.$txt['adk_nosenose'].'
						</td>
						<td style="width: 50%;">
							<input type="checkbox" name="no_avatar_who"',!empty($adkportal['no_avatar_who']) ? ' checked="checked"' : '' ,' />
						</td>
					</tr>
					
					
				</table>
			</td>
			<td style="width: 50%;" valign="top">
				<table style="width: 100%;">
					<tr>
						<td colspan="2">
							<div class="cat_bar"><h4 class="catbg">'.$txt['auto_news'].'</h4></div>
						</td>
					</tr>
					<tr class="windowbg">
						<td style="width: 30%;">
							'.$txt['auto_news_limit_body'].'
						</td>
						<td style="width: 70%;">
							<input type="text" size="2" name="auto_news_limit_body" value="',$adkportal['auto_news_limit_body'],'" />
						</td>
					</tr>				
					<tr class="windowbg2">
						<td style="width: 30%; font-weight: bold;">
							'.$txt['auto_news_limit_topics'].'
						</td>
						<td style="width: 70%;">
							<input type="text" size="2" name="auto_news_limit_topics" value="',$adkportal['auto_news_limit_topics'],'" />
						</td>
					</tr>

					<tr class="windowbg">
						<td style="width: 30%;">
							'.$txt['adk_autonews_boards'].'
						</td>';
				
						$id_boards = explode(',',$adkportal['auto_news_id_boards']);
				echo'
						<td style="width: 70%;">
							<select name="auto_news_id_boards[]" size="10" multiple="multiple" style="width: 88%;">';
							foreach ($context['jump_to'] as $category)
							{
								echo '
									<option disabled="disabled">----------------------------------------------------</option>
									<option disabled="disabled">', $category['name'], '</option>
									<option disabled="disabled">----------------------------------------------------</option>';
								foreach ($category['boards'] as $board)
									echo '
									<option value="' ,$board['id'], '" ' ,isset($id_boards) ? (in_array($board['id'], $id_boards) ? 'selected="selected"' : '') : '', '> ' . str_repeat('&nbsp;&nbsp;&nbsp; ', $board['child_level']) . '|--- ' . $board['name'] . '</option>';
							}
							echo'
							</select>
						</td>
					</tr>
					<tr class="windowbg">
						<td style="width: 50%;">
							<strong>'.$txt['adk_add_twitter_facebook'].'</strong>
							<div class="smalltext">'.$txt['adk_add_twitter_facebook_2'].'</div>
						</td>
						<td>
							<input type="checkbox" name="adk_bookmarks_autonews"',!empty($adkportal['adk_bookmarks_autonews']) ? ' checked="checked"' : '' ,' />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	<table style="width: 100%;">
		<tr class="information">
			<td colspan="2" align="center">
				<input type="submit" value="'.$txt['save'].'" class="button_submit" />
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
			</td>
		</tr>
	</table>
	</form>';
		
}
	
function template_the_new_custom_blocks()
{
	global $settings, $scripturl, $txt, $context, $boardurl;
	
	
	echo'
	<div class="cat_bar">
		<h3 class="catbg">
			<img style="vertical-align: middle;" src="'.$boardurl.'/adkportal/images/angel.gif" alt="" />
			&nbsp;'.$txt['adk_select_what_block'].'
		</h3>
	</div>
	<div class="windowbg information">
		'.$txt['adk_nose_select_what'].'
	</div>
	<table style="width: 100%;">
		<tr>';
	
	$i = 0;
	foreach($context['add_custom_blocks'] AS $act => $button)
	{
		if($i == 2)
		{
			echo'</tr><tr>';
			$i = 0;
		}
		
		
			
		echo'
			<td class="windowbg" style="padding: 5px; font-weight: bold; font-family: tahoma;">
				<img src="'.$boardurl.'/adkportal/images/'.$button['image'].'" style="vertical-align: middle;" alt="" />
				&nbsp;
				<a href="'.$scripturl.'?action=admin;area=blocks;sa=newblocks;set='.$act.';'.$context['session_var'].'='.$context['session_id'].'">
					'.$button['title'].'
				</a>
			</td>';
		$i++;
	}
	
	echo'
		</tr>
	</table>';
	
	ILoveAdkPortal();
	
}
		
function template_newblocks()
{
	CreateAddCustomBlocks('bbc');
	ILoveAdkPortal();
}

function template_newblocks_php()
{
	CreateAddCustomBlocks('php');
	ILoveAdkPortal();	
}

function template_newblocks_top_poster()
{
	CreateAddCustomBlocks('top_poster');
	ILoveAdkPortal();
}
function template_newblocks_auto_news()
{
	CreateAddCustomBlocks('auto_news');
	ILoveAdkPortal();
}
function template_newblocks_top_karma()
{
	CreateAddCustomBlocks('top_karma');
	ILoveAdkPortal();
}

function template_newblocks_staff()
{
	global $context, $txt, $scripturl, $boardurl;
	
	$the_txt = $txt['adk_staff'];
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=newblocks;set=staff_save">
	<table style="width: 100%;" cellspacing="0">
		<tr>
			<td>
				<div class="cat_bar"><h3 class="catbg"><img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/page.png" />&nbsp;'.$txt['adk_creating_bbc_block'].'</h3></div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="title_bar"><h3 class="titlebg">'.$txt['titulo'].'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				<input type="text" value="" name="titulo" />
			</td>
		</tr>
		<tr>
			<td>
				<div class="title_bar"><h3 class="titlebg">'.$the_txt.'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td>
			'.$txt['adk_staff_group'].'<br />';
			
			foreach($context['g'] AS $i => $v)
				echo'<input type="checkbox" value="'.$i.'" name="groups_allowed['.$i.']" /> '.$v.'<br />';
			
			echo'<i>'.$txt['check_all'].'</i> <input type="checkbox" onclick="invertAll(this, this.form, \'groups_allowed\');" /><br />
			<br />
			'.$txt['adk_ss_avatar'].': <input type="checkbox" name="avatar" />';
					
	echo'
			</td>
		</tr>
		<tr>
			<td>
				<div class="title_bar"><h3 class="titlebg">'.$txt['adk_downloads_settings'].'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td style="width: 100%;">
				<table style="width: 100%;">
					<tr class="smalltext">
						<td style="width: 50%;" valign="top">
							<input type="checkbox" name="empty_body" />&nbsp;'.$txt['adk_empty_style_block'].'<br />
							<input type="checkbox" name="empty_title" />&nbsp;'.$txt['adk_empty_title'].'<br />
							<input type="checkbox" name="empty_collapse" />&nbsp;'.$txt['adk_empty_collapse'].'
						</td>
						<td valign="top">
							'.$txt['activado'].'&nbsp;<input type="checkbox" name="enable" /><br />
							'.$txt['posicion'].'&nbsp;<input type="text" size="2" name="orden" value="1" /><br />
							'.$txt['columna'].'&nbsp;<select name="columna">
								<option value="1">'.$txt['left'].'</option>
								<option value="2">'.$txt['centro'].'</option>
								<option value="3">'.$txt['derecha'].'</option>
								<option value="4">'.$txt['adk_block_top'].'</option>
								<option value="5">'.$txt['adk_block_bottom'].'</option>
							</select><br />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<div class="title_bar"><h3 class="titlebg">'.$txt['icon_bloque'].'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				',openDirImages(),'
			</td>
		</tr>
		<tr class="windowbg information">
			<td align="center">
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
				<input type="submit" value="'.$txt['save'].'" />
			</td>
		</tr>
	</table>
	</form>';
}



//Editar bloques
function template_editblocks()
{
	global $context, $txt, $scripturl, $boardurl;
		
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=saveeditblocks">
	<table style="width: 100%;" cellspacing="0">
		<tr class="catbg">
			<td>
				<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/page.png" />&nbsp;'.$txt['adk_creating_bbc_block'].'
			</td>
		</tr>
		<tr class="titlebg">
			<td>
				'.$txt['titulo'].'
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				<input type="text" value="'.$context['edit']['title'].'" name="titulo" />
			</td>
		</tr>';
		if($context['edit']['type'] == 'include'){
			echo'
			<tr><td class="windowbg"><input type="hidden" name="descript" value="'.$context['edit']['new'].'" /></td></tr>';
		}
		elseif($context['edit']['type'] == 'php')
			echo'<tr><td class="windowbg"><textarea name="descript" rows="10" cols="80">'.$context['edit']['new'].'</textarea></td></tr>';
		else{
			echo'
			<tr class="titlebg">
				<td>
					'.$txt['adk_admin_pages_body'].'
				</td>
			</tr>
			<tr class="windowbg">
				<td>';
		
			if (!function_exists('getLanguages'))
			{
				// Showing BBC?
				if ($context['show_bbc'])
					template_control_richedit($context['post_box_name'], 'bbc');
				
			
				// What about smileys?
				if (!empty($context['smileys']['postform']))
					template_control_richedit($context['post_box_name'], 'smileys');
			
				// Show BBC buttons, smileys and textbox.
				template_control_richedit($context['post_box_name'], 'message');
			}
			else 
			{
				
				if ($context['show_bbc'])
					echo '
							<div id="bbcBox_message"></div>';
				
			
				// What about smileys?
				if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
					echo '
							<div id="smileyBox_message"></div>';
			
				
				echo '
							', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');
			}
		}
		
			
	echo'
			</td>
		</tr>
		<tr class="titlebg">
			<td>
				'.$txt['adk_downloads_settings'].'
			</td>
		</tr>
		<tr class="windowbg">
			<td style="width: 100%;">
				<table style="width: 100%;">
					<tr class="smalltext">
						<td style="width: 50%;" valign="top">
							<input type="checkbox" name="empty_body"',$context['edit']['empty_body'] == 1 ? ' checked="checked"' : '' ,' />&nbsp;'.$txt['adk_empty_style_block'].'<br />
							<input type="checkbox" name="empty_title"',$context['edit']['empty_title'] == 1 ? ' checked="checked"' : '' ,' />&nbsp;'.$txt['adk_empty_title'].'<br />
							<input type="checkbox" name="empty_collapse"',$context['edit']['empty_collapse'] == 1 ? ' checked="checked"' : '' ,' />&nbsp;'.$txt['adk_empty_collapse'].'
						</td>
						<td valign="top">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="titlebg">
			<td>
				'.$txt['icon_bloque'].'
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				',openDirImages($context['edit']['img']),'
			</td>
		</tr>
		<tr class="windowbg information">
			<td align="center">
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
				<input type="submit" value="'.$txt['save'].'" />
				<input type="hidden" name="id" value="'.$context['edit']['id'].'" />
				<input type="hidden" name="type_" value="'.$context['edit']['type'].'" />
			</td>
		</tr>
	</table>
	</form>';
	
	ILoveAdkPortal();
}	


function template_showeditnews()
{
	
	global  $scripturl, $context, $txt, $boardurl;

	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=showsaveeditnews">';
	
	echo'
		<table cellpadding="8" cellspacing="1" border="0" class="tborder" style="width: 100%;">
			<tr class="titlebg">
				<td colspan="2">
					<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/new.png" />&nbsp;'.$txt['datos_noticias'].'
				</td>
			</tr>	
			<tr class="windowbg">
				<td style="width: 20%;">
					'.$txt['autor'].'
				</td>
				<td>
					<input size="100" value="'.$context['edit']['autor'].'" type="text" name="autore" />
				</td>
			</tr>
			<tr class="windowbg2">
				<td>
					'.$txt['titulo_noticia'].'
				</td>
				<td>
					<input size="100" value="'.$context['edit']['title'].'" type="text" name="titlepage" />
				</td>
			</tr>
			<tr class="titlebg">
				<td colspan="2">
					'.$txt['aporte'].'
				</td>
			</tr>
			<tr class="windowbg">
				<td colspan="2">';
					if (!function_exists('getLanguages'))
					{
						// Showing BBC?
						if ($context['show_bbc'])
							template_control_richedit($context['post_box_name'], 'bbc');
						
					
						// What about smileys?
						if (!empty($context['smileys']['postform']))
							template_control_richedit($context['post_box_name'], 'smileys');
					
						// Show BBC buttons, smileys and textbox.
						template_control_richedit($context['post_box_name'], 'message');
					}
					else 
					{
						
						if ($context['show_bbc'])
							echo '
									<div id="bbcBox_message"></div>';
						
					
						// What about smileys?
						if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
							echo '
									<div id="smileyBox_message"></div>';
					
						
						echo '
									', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');
						}
	echo'
				</td>
			</tr>
			<tr class="windowbg information">
				<td align="center" colspan="2">
					<input type="hidden" name="id" value="'.$context['edit']['id'].'" />
					<input type="hidden" name="sc" value="', $context['session_id'], '" />
					<input class="button_submit" type="submit" name="cmdSubmit" value="'.$txt['save'].'" />
				</td>
			</tr>
		</table>
	</form>	';
	
	ILoveAdkPortal();
	
}

function template_createnews()
{
	global  $scripturl, $context, $txt, $boardurl;

	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=savecreatenews">
		<table cellpadding="8" cellspacing="1" border="0" class="tborder" style="width: 100%;">
			<tr class="titlebg">
				<td colspan="2">
					<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/new.png" />&nbsp;'.$txt['datos_noticias'].'
				</td>
			</tr>	
			<tr class="windowbg">
				<td style="width: 20%;">
					'.$txt['autor'].'
				</td>
				<td>
					<input size="100" type="text" name="autore" />
				</td>
			</tr>
			<tr class="windowbg2">
				<td>
					'.$txt['titulo_noticia'].'
				</td>
				<td>
					<input size="100" type="text" name="titlepage" />
				</td>
			</tr>
			<tr class="titlebg">
				<td colspan="2">
					'.$txt['aporte'].'
				</td>
			</tr>
			<tr class="windowbg">
				<td colspan="2">';
					if (!function_exists('getLanguages'))
					{
						// Showing BBC?
						if ($context['show_bbc'])
							template_control_richedit($context['post_box_name'], 'bbc');
						
					
						// What about smileys?
						if (!empty($context['smileys']['postform']))
							template_control_richedit($context['post_box_name'], 'smileys');
					
						// Show BBC buttons, smileys and textbox.
						template_control_richedit($context['post_box_name'], 'message');
					}
					else 
					{
						
						if ($context['show_bbc'])
							echo '
									<div id="bbcBox_message"></div>';
						
					
						// What about smileys?
						if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
							echo '
									<div id="smileyBox_message"></div>';
					
						
						echo '
									', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');
					}
	echo'
				</td>
			</tr>
			<tr class="windowbg information">
				<td align="center" colspan="2">
					<input type="hidden" name="sc" value="', $context['session_id'], '" />
					<input class="button_submit" type="submit" name="cmdSubmit" value="'.$txt['save'].'" />
				</td>
			</tr>
		</table>
	</form>';
	
	ILoveAdkPortal();
}	





function template_uploadblock()
{
	global $context, $scripturl, $txt;
	
	echo'
	<form enctype="multipart/form-data" action="'.$scripturl.'?action=admin;area=blocks;sa=saveuploadblock" method="post">
		<div class="cat_bar">
			<h3 class="catbg">
				'.$txt['adk_upload_yourBlock'].'
			</h3>
		</div>
		<div class="windowbg"><span class="topslice"><span></span></span>
			<div style="padding: 5px; text-align: center;">
			<table style="width: 100%;">
				<tr>
					<td style="width: 50%; text-align: left;"><strong>'.$txt['adk_select_your_block'].'</strong>
						<div class="smalltext">'.$txt['adk_upload_yourBlock_info'].'</div>
					</td>
					<td style="width: 50%; text-align: left;"><input size="16" type="file" value="" name="file" /><br /></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="'.$txt['save'].'" />
						<input type="hidden" name="sc" value="', $context['session_id'], '" />
					</td>
				</tr>
			</table>
			</div>
		<span class="botslice"><span></span></span></div>
	</form>';
	
	ILoveAdkPortal();

}

function template_permissions()
{
	global $scripturl, $txt, $context, $boardurl;
	
	echo'
	<script type="text/javascript">
		function cambia(src){
			document.getElementById("g_-1").style.display = "none";
			document.getElementById("g_-2").style.display = "none";
			';
			foreach($context['adk_groups'] AS $i => $v)
			echo'
			document.getElementById("g_'.$i.'").style.display = "none";
			';
	
	echo'	
			document.getElementById("g_" + src).style.display = "block";
		}
		function loadAll(){
			document.getElementById("g_-1").style.display = "block";
			document.getElementById("g_-2").style.display = "block";
			';
			foreach($context['adk_groups'] AS $i => $v)
			echo'
			document.getElementById("g_'.$i.'").style.display = "block";
			';
	
	echo'
		}
		function SelectAll(){
			document.form.getElementById("lu").input.checked = "checked";
		}
	</script>';	
		
	$p = explode(',',$context['block']['permissions']);
		
	
	echo'
	<form id="lu" method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=savepermissions">
	<div class="cat_bar">
		<h3 class="catbg">
			<img src="'.$boardurl.'/adkportal/images/users.png" style="vertical-align: middle;" alt="" />&nbsp;
			'.$context['block']['name'].'
		</h3>
	</div>
	<div class="information">
		'.$txt['adk_into_permissions_desc'].'
	</div>
	
	<div class="windowbg"><span class="topslice"><span></span></span>
		<div class="content">
			<strong>'.$txt['adk_into_permissions_select'].'</strong>
			<div align="center">
				<select name="groups" onchange="cambia(this.options[this.selectedIndex].value)">
					<option value="-1">'.$txt['adk_d_guests'].'</option>
					<option value="-2">'.$txt['adk_d_regulars_users'].'</option>';
	
	foreach($context['adk_groups'] AS $i => $v)
		echo'
					<option value="'.$i.'">'.$v.'</option>';
		
	echo'
				</select>';
	
	echo'
			</div>
			<br /><br />
			<div id="g_-1" style="display: block;">
				<input type="checkbox" name="adk[-1]" value="-1"',in_array(-1,$p) ? ' checked="checked"' : '' ,' />&nbsp;'.$txt['adk_d_guests'].'
			</div>
			<div id="g_-2" style="display: none;">
				<input type="checkbox" name="adk[-2]" value="-2"',in_array(-2,$p) ? ' checked="checked"' : '' ,' />&nbsp;'.$txt['adk_d_regulars_users'].'
			</div>';
	
	foreach($context['adk_groups'] AS $i => $v){
		echo'
			<div id="g_'.$i.'" style="display: none;">
				<input type="checkbox" name="adk['.$i.']" value="'.$i.'"',in_array($i,$p) ? ' checked="checked"' : '' ,' />&nbsp;'.$v.'
			</div>';
	}
	
	echo'
			<div align="right" class="smalltext">
				<a href="javascript:loadAll();">
					'.$txt['adk_into_permissions'].'
				</a>
			</div>
		</div>
	<span class="botslice"><span></span></span></div>
	
	<div class="windowbg"><span class="topslice"><span></span></span>
		<div class="content" align="center">
			<input type="hidden" value="'.$context['session_id'].'" name="sc" />
			<input type="hidden" value="'.$context['block']['id'].'" name="id" />
			<input type="submit" value="'.$txt['save'].'" class="button_submit" />
		</div>
	<span class="botslice"><span></span></span></div>
	</form>';
	
}

function template_shoutbox()
{
	global $context, $scripturl, $txt, $boardurl, $adkportal;
	
	$explode1 = explode(',',$adkportal['shout_allowed_groups_view']);
	$explode2 = explode(',',$adkportal['shout_allowed_groups']);
	
	//$id_group = 
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=shoutboxsave">
	<div class="title_bar" style="height: 28px;">
		<h3 class="titlebg">
		'.$txt['adk_shout'].'
		</h3>
	</div>
	<div class="windowbg2">
		<table style="width: 100%;">
			',isset($_REQUEST['done']) ? 
			'<tr>
				<td class="approvebg" colspan="2" style=" font-weight: bold;">
					'.$txt['adk_done__'].'
				</td>
			</tr>' : '' ,'
					
			<tr>
				<td style="width: 50%; font-weight: bold;">
					'.$txt['adk_title_shoutt'].'
				</td>
				<td style="width: 50%;">
					<input type="text" size="60" name="shout_title" value="'.$adkportal['shout_title'].'" />
				</td>
			</tr>
			
			<tr>
				<td style="width: 50%; font-weight: bold;">
					'.$txt['adk_shout_g_allowed_view'].'
				</td>
				<td style="width: 50%;">
					<select name="shout_allowed_groups_view[]" multiple="multiple" style="width: 88%;">
						<option value="-1"',in_array(-1,$explode1) ? ' selected="selected"': '' ,'>'.$txt['adk_guest'].'</option>
						<option value="0"',in_array(0,$explode1) ? ' selected="selected"': '' ,'>'.$txt['adk_d_regulars_users'].'</option>';
						
						if(!empty($context['memberadk']))
						foreach($context['memberadk'] AS $i => $v)
							echo'<option value="'.$i.'"',in_array($i,$explode1) ? ' selected="selected"': '' ,'>'.$v.'</option>';
	echo'
					</select>
						
				</td>
			</tr>
			
			<tr>
				<td style="width: 50%; font-weight: bold;">
					'.$txt['adk_shout_g_allowed_topost'].'
				</td>
				<td style="width: 50%;">
					<select name="shout_allowed_groups[]" multiple="multiple" style="width: 88%;">
						<option value="-1"',in_array(-1,$explode2) ? ' selected="selected"': '' ,'>'.$txt['adk_guest'].'</option>
						<option value="0"',in_array(0,$explode2) ? ' selected="selected"': '' ,'>'.$txt['adk_d_regulars_users'].'</option>';
						
						if(!empty($context['memberadk']))
						foreach($context['memberadk'] AS $i => $v)
							echo'<option value="'.$i.'"',in_array($i,$explode2) ? ' selected="selected"': '' ,'>'.$v.'</option>';
	echo'
					</select>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<input type="submit" class="button_submit" value="'.$txt['save'].'" />
					<br /><br />
					<a href="'. $scripturl .'?action=admin;area=blocks;sa=shoutboxdeleteall;'.$context['session_var'].'='.$context['session_id'].'"><input type="button" value="'.$txt['adk_delete_allshoutbox'].'" class="button_submit" /></a>
					<input type="hidden" name="sc" value="', $context['session_id'], '" />
				</td>
			</tr>
		</table>
	<span class="botslice"><span></span></span>
	</div>
	</form>';			
	
	ILoveAdkPortal();
	
}


function CreateAddCustomBlocks($type)
{
	global $context, $txt, $scripturl, $boardurl;
	
	$the_txt = $type == 'bbc' || $type == 'php' ? $txt['adk_admin_pages_body'] : $type == 'top_poster' || $type == 'top_karma' ? $txt['adk_limit_in_the_top_poster'] : $txt['adk_select_theuur_forums'];
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=newblocks;set='.$type.'_save">
	<table style="width: 100%;" cellspacing="0">
		<tr>
			<td>
				<div class="cat_bar"><h3 class="catbg"><img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/page.png" />&nbsp;'.$txt['adk_creating_bbc_block'].'</h3></div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="title_bar"><h3 class="titlebg">'.$txt['titulo'].'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				<input type="text" value="" name="titulo" />
			</td>
		</tr>
		<tr>
			<td>
				<div class="title_bar"><h3 class="titlebg">'.$the_txt.'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td>';
			if($type == 'auto_news')
			{

				echo'
				<select name="auto_news_id_boards[]" size="10" multiple="multiple" style="width: 88%;">';
					foreach ($context['jump_to'] as $category)
					{
						echo '
							<option disabled="disabled">----------------------------------------------------</option>
							<option disabled="disabled">', $category['name'], '</option>
							<option disabled="disabled">----------------------------------------------------</option>';
						foreach ($category['boards'] as $board)
							echo '
							<option value="' ,$board['id'], '"> ' . str_repeat('&nbsp;&nbsp;&nbsp; ', $board['child_level']) . '|--- ' . $board['name'] . '</option>';
					}
				echo'
				</select>
				<br />
				'.$txt['adk_limit_in_the_auto_news'].': <input type="text" name="int" value="" size="2" />';
			}
			elseif($type == 'bbc')
			{
				echo'<strong>HTML</strong> <input type="checkbox" name="html" /><br />';
				if (!function_exists('getLanguages'))
				{
					// Showing BBC?
					if ($context['show_bbc'])
						template_control_richedit($context['post_box_name'], 'bbc');
					
				
					// What about smileys?
					if (!empty($context['smileys']['postform']))
						template_control_richedit($context['post_box_name'], 'smileys');
				
					// Show BBC buttons, smileys and textbox.
					template_control_richedit($context['post_box_name'], 'message');
				}
				else 
				{
					
					if ($context['show_bbc'])
						echo '
								<div id="bbcBox_message"></div>';
					
				
					// What about smileys?
					if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
						echo '
								<div id="smileyBox_message"></div>';
				
					
					echo '
								', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');

				}
			}
			elseif($type == 'php')
				echo'<textarea name="descript" rows="10" cols="80"><?php</textarea>';
			elseif($type == 'top_poster' || $type = 'top_karma')
				echo'<input type="text" name="descript" value="" size="2" />';
			
			
	echo'
			</td>
		</tr>
		<tr>
			<td>
				<div class="title_bar"><h3 class="titlebg">'.$txt['adk_downloads_settings'].'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td style="width: 100%;">
				<table style="width: 100%;">
					<tr class="smalltext">
						<td style="width: 50%;" valign="top">
							<input type="checkbox" name="empty_body" />&nbsp;'.$txt['adk_empty_style_block'].'<br />
							<input type="checkbox" name="empty_title" />&nbsp;'.$txt['adk_empty_title'].'<br />
							<input type="checkbox" name="empty_collapse" />&nbsp;'.$txt['adk_empty_collapse'].'
						</td>
						<td valign="top">
							'.$txt['activado'].'&nbsp;<input type="checkbox" name="enable" /><br />
							'.$txt['posicion'].'&nbsp;<input type="text" size="2" name="orden" value="1" /><br />
							'.$txt['columna'].'&nbsp;<select name="columna">
								<option value="1">'.$txt['left'].'</option>
								<option value="2">'.$txt['centro'].'</option>
								<option value="3">'.$txt['derecha'].'</option>
								<option value="4">'.$txt['adk_block_top'].'</option>
								<option value="5">'.$txt['adk_block_bottom'].'</option>
							</select><br />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="titlebg">
			<td>
				'.$txt['icon_bloque'].'
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				',openDirImages(),'
			</td>
		</tr>
		<tr class="windowbg information">
			<td align="center">
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
				<input type="submit" value="'.$txt['save'].'" />
			</td>
		</tr>
	</table>
	</form>';
	
}

function template_multi_block()
{
	global $context, $txt, $scripturl, $boardurl;
	
	/*
	"<div id=\'block_" + id + "\'>(" + id + ")<input type=\'hidden\' value=\'" + id "\' name=\'blocks[" + id + "]\' /></div>"
	*/
	// Script
	echo'
	<script type="text/javascript"><!-- // --><![CDATA[
	function add_block(id){
		var capa = document.getElementById("blocks");
		var div = document.createElement("div");
		div.id = "block_" + id;
		div.innerHTML = id + \'<input type="hidden" value="\' + id + \'" name="block[\' + id + \']" /> <a href="#" style="cursor: pointer;" onClick="remove_block(\' + id + \')"><img alt="" src="',$boardurl,'/adkportal/images/x.gif" /></a>   \';
		capa.appendChild(div);
	}
	
	function remove_block(id)
	{
		var element = document.getElementById("block_" + id);
		element.parentNode.removeChild(element);
	}
	// ]]></script>';
	
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=blocks;sa=newblocks;set=multi_block_save">
		<div class="cat_bar">
			<h3 class="catbg">
				<img alt="" src="',$boardurl,'/adkportal/images/brick_add.png" style="vertical-align: middle;" /> ',$txt['adk_multi_block'],'
			</h3>
		</div>
		<div class="description">
			',$txt['adk_multi_block_description'],'
		</div>
		<div class="windowbg"><span class="topslice"><span></span></span>
			<div class="content">
				<div align="center">
					',$txt['adk_multi_block_select'],' <select name="blocks" onchange="add_block(this.options[this.selectedIndex].value)">';
		
	foreach($context['adk_blocks'] AS $id => $name)
		echo'
						<option value="',$id,'">(',$id,') ',$name,'</option>';
	
	echo'
					</select>
				</div><br />
				<hr />
				<strong>',$txt['adk_multi_block_selected'],'</strong>
				<div id="blocks" class="information">
				
				</div><br />
				<hr />
				<strong>',$txt['adk_settings'],'</strong><br /><br />
				',$txt['adk_second_info'],'&nbsp;<input type="text" name="name" /><br />
				'.$txt['activado'].'&nbsp;<input type="checkbox" name="enable" /><br />
				'.$txt['posicion'].'&nbsp;<input type="text" size="2" name="orden" value="1" /><br />
				'.$txt['columna'].'&nbsp;<select name="columna">
					<option value="1">'.$txt['left'].'</option>
					<option value="2">'.$txt['centro'].'</option>
					<option value="3">'.$txt['derecha'].'</option>
					<option value="4">'.$txt['adk_block_top'].'</option>
					<option value="5">'.$txt['adk_block_bottom'].'</option>
				</select><br />
				<div align="center">
					<input type="submit" class="button_submit" value="',$txt['save'],'" />
					<input type="hidden" name="sc" value="',$context['session_id'],'" />
				</div>
			</div>
		<span class="botslice"><span></span></span></div>
	</form>';
					
}

?>