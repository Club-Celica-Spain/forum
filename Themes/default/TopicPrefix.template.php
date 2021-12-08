<?php
/**********************************************************************************
* TopicPrefix.template.php                                                                                                                      *
***********************************************************************************
*                                                                                                                                                                  *
* SMF Topic Prefix Mod                                                                                                                          *
* Copyright (c) 2008-2009 by NIBOGO. All rights reserved.                                                                        *
* Powered by www.mundo-se.com                                                                                                             *
* Created by NIBOGO for Simplemachines.org                                                                                     *
*                                                                                                                                                                   *
**********************************************************************************/

function template_prefix_add()
{
	global $context, $txt, $scripturl, $settings;
	
	echo '
	<form method="post" name="addga" id="addga" action="', $scripturl, '?action=prefix;sa=addverify" accept-charset="', $context['character_set'], '" onsubmit="submitonce(this);">
		<div class="tborder">
		<table border="0" width="100%" cellspacing="1" cellpadding="4" class="bordercolor">
			<tr class="catbg">
				<td colspan="2">'.$txt['prefix_add'].'</td>
			</tr>
			<tr class="windowbg2">
				<td width="15%"><b>'.$txt['prefix_title'].':</b></td>
				<td width="85%"><input type="text" name="prefix" size="20" /></td>
			</tr>
			<tr class="windowbg2">
			<td width="15%"><b>'.$txt['prefix_boards'].':</b></td>
			<td width="85%">
			<select name="boards[]" size="15" multiple="multiple" style="width: 55%;">
									<option value="0">' .$txt['prefix_all']. '</option>';
							foreach ($context['jump_to'] as $category)
							{
								echo '
									<option disabled="disabled">----------------------------------------------------</option>
									<option disabled="disabled">', $category['name'], '</option>
									<option disabled="disabled">----------------------------------------------------</option>';
								foreach ($category['boards'] as $board)
									echo '
									<option value="' ,$board['id'], '" ' ,isset($context['preview_boards']) ? (in_array($board['id'], $context['preview_boards']) ? 'selected="selected"' : '') : '', '> ' . str_repeat('&nbsp;&nbsp;&nbsp; ', $board['child_level']) . '|--- ' . $board['name'] . '</option>';
							}
	echo '
								</select>
			</td></tr>
			<tr>
	    <td width="15%" class="windowbg2"><b>', $txt['prefix_permissions'],':</b></td>
	    <td width="85%" class="windowbg2">
	    <input type="checkbox" name="groups[-1]" value="-1" />',$txt['membergroups_guests'],'<br />
	    <input type="checkbox" name="groups[0]" value="0" />', $txt['membergroups_members'],'<br />';
	
		foreach ($context['groups'] as $group)
				echo '<input type="checkbox" name="groups[', $group['id_group'], ']" value="', $group['id_group'], '" />', $group['group_name'], '<br />';
							
	echo '    
	    </td>
	  </tr> 	  
	   <tr>
	    <td colspan="2" class="windowbg2" align="center">
	    <input type="hidden" name="sc" value="', $context['session_id'], '" />      	
		<input type="submit" name="addprefix" value="',$txt['prefix_add'],'" /></td>
	  </tr> 
		</table></div></form>	
	';
}

function template_prefix_edit()
{
	global $context, $txt, $scripturl, $board_info, $board, $selected_boards;
	
	echo ' 
	<form method="post" name="editga" id="editga" action="', $scripturl, '?action=prefix;sa=editverify;pid='.$_REQUEST['pid'].'" accept-charset="', $context['character_set'], '" onsubmit="submitonce(this);">
	<div class="tborder">
		<table border="0" width="100%" cellspacing="1" cellpadding="4" class="bordercolor">
			<tr class="catbg">
				<td colspan="2">'.$txt['prefix_edit'].'</td>
			</tr>			
			<tr class="windowbg2">
				<td width="15%"><b>'.$txt['prefix_title'].':</b></td>
				<td width="85%"><input type="text" name="prefix" size="25" value="',$context['prefix_edit_info']['prefix'], '" /></td>
			</tr>
			<tr class="windowbg2">
			<td width="15%"><b>'.$txt['prefix_boards'].':</b></td>
			<td width="85%">
			<select name="boards[]" size="15" multiple="multiple" style="width: 55%;">
									<option value="0" ' ,($context['prefix_edit_info']['id_boards'] == '0' && $context['prefix_edit_info']['id_boards'] !== '') ? 'selected="selected"' : '', '>' .$txt['prefix_all']. '</option>';
							foreach ($context['jump_to'] as $category)
							{
								echo '
									<option disabled="disabled">----------------------------------------------------</option>
									<option disabled="disabled">', $category['name'], '</option>
									<option disabled="disabled">----------------------------------------------------</option>';
								foreach ($category['boards'] as $board)
									echo '
									<option value="' ,$board['id'], '" ' ,(isset($selected_boards[$board['id']])) ? 'selected="selected"' : '', ' > ' . str_repeat('&nbsp;&nbsp;&nbsp; ', $board['child_level']) . '|--- ' . $board['name'] . '</option>';
							}
	echo '
								</select>
			</td></tr>
		<tr>
	    <td width="15%" class="windowbg2"><b>', $txt['prefix_permissions'],':</b>&nbsp;</td>
	    <td width="85%" class="windowbg2">';
	
		$permissionsGroups = explode(',',$context['prefix_edit_info']['permissions']);
	
		echo '
	    <input type="checkbox" name="groups[-1]" value="-1" ', ((in_array(-1,$permissionsGroups) == true) ? ' checked="checked" ' : ''), ' />',$txt['membergroups_guests'],'<br />
	    <input type="checkbox" name="groups[0]" value="0" ', ((in_array(0,$permissionsGroups) == true) ? ' checked="checked" ' : ''), ' />',$txt['membergroups_members'],'<br />';
	
		foreach ($context['groups'] as $group)
				echo '<input type="checkbox" name="groups[', $group['id_group'], ']" value="', $group['id_group'], '" ', ((in_array($group['id_group'],$permissionsGroups) == true) ? ' checked="checked" ' : ''), ' />', $group['group_name'], '<br />';
							
	echo '    
	    </td>
	  </tr>			
	   <tr>
	    <td colspan="2" class="windowbg2" align="center">
	   <input type="hidden" name="sc" value="', $context['session_id'], '" />	
	    <input type="hidden" name="p" value="', $context['prefix_edit_info']['id_prefix'],'" />
	    <input type="submit" name="prefixpage" value="', $txt['prefix_edit'], '" /></td>
	  </tr> 		
		
		</table></div></form>';
}

function template_admin_prefix()
{
       global $context, $txt, $scripturl, $settings, $smcFunc;
	   
        echo '
	<table cellspacing="0" cellpadding="10" border="0" align="center" width="85%" class="tborder">
				<tr class="titlebg">
					<td>',$txt['prefix_title'] ,'</td>					
					<td align="right">',$txt['prefix_permissions'],'</td>	
                    <td align="right">',$txt['prefix_boards'],'</td>
					<td align="right">',$txt['prefix_options'],'</td>
				</tr>';
				
				$windowclass = "windowbg";
				if (!empty($context['prefix'])){
				foreach($context['prefix']  as $prefix)
				{
					echo '
					<tr class="',$windowclass,'">					  
						<td align="left">',$prefix['prefix'], '</td>
						<td align="right"><ul>';
						$prefix_groups = explode(',', $prefix['permissions']);
						echo' ', ((in_array(-1,$prefix_groups) == true) ? '<li>'.$txt['membergroups_guests'].'</li>' : ''), '
	                    ', ((in_array(0,$prefix_groups) == true) ? '<li>'.$txt['membergroups_members'].'</li>' : ''), ' ';
						foreach ($context['groups'] as $group){
				        if (in_array($group['id_group'],$prefix_groups) == true) 
						echo' <li>'.$group['group_name'].'</li>';
						}
						echo'</ul></td><td align="right">
						',($prefix['id_boards'] == '0') ? $txt['prefix_all'] : $prefix['id_boards'], '
						</td><td align="right"><a href="',$scripturl,'?action=prefix;sa=edit;pid=',$prefix['id_prefix'],'" title="'.$txt['prefix_edit'].'"><img src="'.$settings['images_url'].'/buttons/modify.gif" alt="',$txt['prefix_edit'], '" /></a>
						<a href="'.$scripturl.'?action=prefix;sa=deleteverify;pid=',$prefix['id_prefix'],'" onclick="return confirm(\''.$txt['prefix_remove_verify'].'\')" title="'.$txt['prefix_remove'].'"><img src="'.$settings['images_url'].'/buttons/delete.gif" alt="',$txt['prefix_remove'], '" /></a>
						</td>
					</tr>';
					
					// Alternate the style class
					if ($windowclass == "windowbg")
						$windowclass = "windowbg2";
					else 
						$windowclass = "windowbg";					
				}
				}
				else
				echo '<tr class="',$windowclass,'">
				<td align="center" colspan="6">'.$txt['prefix_nothing'].'</td>
				</tr>';

				echo '
				</table>';  
}

function template_prefix_version()
{
	global $context, $txt, $modSettings;
	
	// Load the Mod Version
	$prefix_version = '1.2';

	echo '
	<table border="0" cellpadding="5" cellspacing="0" align="center" width="50%" class="tborder">
      <tr class="titlebg">
         <td colspan="2">'.$txt['prefix_version'].'</td>
      </tr>
	   <tr> 
      <td class="windowbg">
		<p>', $txt['prefix_current_version'], ': '.$prefix_version.'</p>
		<p>', $txt['prefix_latest_version'], ': <b><script language="JavaScript" type="text/javascript" src="http://www.smfpacks.com/versions/prefix_version.js"></script></b></p>
		<p>', $txt['prefix_smf_version'], ': ' . $modSettings["smfVersion"] . '</p>
		<p><a href="http://custom.simplemachines.org/mods/index.php?mod=1752">'.$txt['prefix_download'].'</a></p>
	  </td></tr>
	  <tr> 
      <td class="windowbg">
		<p><b>Developer &amp; Creator:</b> NIBOGO</p>
		<p><b>Translators:</b> Spanish/Spanish Latin (NIBOGO)</p>
		<p>Has the Topic Prefix Mod helped you? Then support the developer:</p>		
		<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="nibogo2@gmail.com" />
<input type="hidden" name="item_name" value="Donate Topic Prefix" />
<input type="hidden" name="currency_code" value="USD" />
<input type="image" src="http://www.paypal.com/es_XC/i/btn/btn_donate_LG.gif" name="submit" alt="Make Donation to Topic Prefix Mod" />
</form>
	  </td></tr>
	  </table>';
}
?>