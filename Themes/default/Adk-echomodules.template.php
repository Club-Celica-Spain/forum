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

function template_load_pages_adkportal()
{
	global  $scripturl, $context, $txt, $adkportal, $boardurl;
	
	//cat_bar or titlebar?
	$cat = $context['page_view_content']['ctbg'] == 'catbg' ? 'cat' : 'title';
	
	echo'
		<table border="0" style="width:100%;" >
			<tr>';
			if(!empty($context['page_view_content']['enableleft']))
				echo'
				<td id="adk_left" valign="top" style="width:',$adkportal['wleft'],';">
					',columnleft(),'
				</td>';
	
	echo'
				<td valign="top">
					<table style="width:100%;" class="tborder">
						<tr>
							<td>
								<div class="'.$cat.'_bar">
									<h3 class="'.$context['page_view_content']['ctbg'].'">
									'.$context['page_view_content']['titlepage'].' || '.$txt['page_view_adk'].' '.$context['page_view_content']['view'].'
									</h3>
								</div>
								<div class="'.$context['page_view_content']['winbg'].'"><span class="topslice"><span></span></span>
									<div class="content">
										',analizar_type($context['page_view_content']['type'], $context['page_view_content']['body']),'
									</div>
								<span class="botslice"><span></span></span></div>
							</td>
						</tr>
					</table>
				</td>';

			if(!empty($context['page_view_content']['enableright']))
				echo'
				<td id="adk_right" valign="top" style="width:',$adkportal['wright'],';">
					',columnright(),'
				</td>	';
				
						
	echo'
			</tr>			
		</table>';
			
	ILoveAdkPortal();
}

function template_load_shout()
{
	global $scripturl, $context, $txt, $boardurl, $user_info;
	
	echo'
	<div class="smalltext">
			'.$txt['pages'].': '.$context['page_index'].'
	</div><br />
	<div class="title_bar">
		<h4 class="titlebg">
			<img class="adk_vertical" alt="" src="'.$boardurl.'/adkportal/images/time.png" />&nbsp;'.$txt['adk_shout'].'
		</h4>
	</div>
	<span class="upperframe"><span></span></span>
	<div class="roundframe">
		<table class="table_grid" cellspacing="0" style="width: 100%;">
			<thead>
				<tr class="catbg">
					<th scope="col" class="smalltext first_th">
						'.$txt['adk_message_shoutbox'].'
					</th>
					<th scope="col" class="smalltext" width="15%">
						', $txt['autor'] ,'
					</th>
					<th scope="col" class="smalltext',!$user_info['is_admin'] ? ' last_th' : '' ,'" width="15%">
						', $txt['adk_date'] ,'
					</th>
					',$user_info['is_admin'] ? '
					<th scope="col" class="smalltext last_th" width="20px">
						
					</th>' : '' ,'
				</tr>
			</thead>
			<tbody>';
	
	foreach($context['shouts'] AS $shout)
	{
		echo'
				<tr class="'.$shout['alternate'].' whos_viewing adk_padding_5">
					<td>
						'.$shout['message'].'
					</td>
					<td>
						'.$shout['user'].'
					</td>
					<td>
						'.$shout['date'].'
					</td>';
		
		if($user_info['is_admin'])
		echo'
					<td align="center">
						<a href="'.$scripturl.'?action=adk_shoutbox;del='.$shout['id'].'" onclick="return confirm(\'', $txt['remove_message'], '?\');">
							<img alt="" src="'.$boardurl.'/adkportal/images/cancel.png" />
						</a>
					</td>';
		echo'				
				
				</tr>';
	}
	
	echo'	
			</tbody>
		</table>
	</div>
	<span class="lowerframe"><span></span></span>
	<br />
	<div class="smalltext">
			'.$txt['pages'].': '.$context['page_index'].'
	</div>';
	
	ILoveAdkPortal();
	
}
	
function template_view_new()
{
	global $context, $scripturl, $txt, $boardurl;
	
	echo'
	<div class="cat_bar">
		<h3 class="catbg">
			<img src="'.$boardurl.'/adkportal/images/newmsg.png" alt="" style="vertical-align: middle;" />
			<span id="top_subject">'.$context['adk_new']['title'].'</span>
		</h3>
	</div>
	<div id="forumposts">
	<div class="windowbg">
	<span class="topslice"><span></span></span>
		<div class="post_wrapper">
			<div class="poster">
				<h4>'.$context['adk_new']['autor'].'</h4>
			</div>
			<div class="postarea">
				<div class="flow_hidden">
					<div class="keyinfo">
						<div class="messageicon">
								<div style="background: none repeat scroll 0% 0% transparent; padding: 3px; text-align: center;"><img src="'.$boardurl.'/adkportal/images/messages.png" alt="" style="margin: 0px; padding: 3px 0px;" /></div>
						</div>
						<h5 id="subject_1">
							<a href="'.$scripturl.'?action=addthistopic;view='.$context['adk_new']['id'].'" rel="nofollow">'.$context['adk_new']['title'].'</a>
						</h5>
						<div class="smalltext">« <strong> '.$txt['on'].':</strong> '.$context['adk_new']['time'].' »</div>
						<div id="msg_1_quick_mod"></div>
					</div>';
					if(allowedTo('adk_portal'))
					echo'
					<ul class="reset smalltext quickbuttons">
						<li class="modify_button"><a href="'.$scripturl.'?action=admin;area=blocks;sa=showeditnews;id='.$context['adk_new']['id'].';'.$context['session_var'].'='.$context['session_id'].'">Modify</a></li>
						<li class="remove_button"><a href="'.$scripturl.'?action=admin;area=blocks;sa=showdeletenews;del='.$context['adk_new']['id'].';'.$context['session_var'].'='.$context['session_id'].'" onclick="return confirm(\'', $txt['remove_message'], '?\');">'.$txt['adk_delete'].'</a></li>
					</ul>';
	echo'		</div>
				<div class="post">
					<div class="inner" id="msg_1">
						'.$context['adk_new']['body'].'
					</div>
				</div>
			</div>
		</div>
	<span class="botslice"><span></span></span>
	</div>
	</div>';

	ILoveAdkPortal();
	
}

function template_adk_credits()
{
	global $txt, $scripturl, $context, $boardurl, $settings;

	//A partir de aca el codigo de los creditos.
	echo'
		<div class="cat_bar">
			<h3 class="catbg">
				<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/award_star_gold_1.png" alt="" /> 
				'.$txt['Credits_01'].'
			</h3>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$txt['Credits_02'].'<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$txt['Credits_03'].'<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$txt['Credits_04'].'<br />
			</div>
			<span class="botslice"><span></span></span>
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/award_star_gold_1.png" alt="" /> 
				'.$txt['Credits_05'].'
			</h3>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$txt['Credits_06'].'<br /> 
				<br />&nbsp;&nbsp;<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/bullet_green.png" alt="" /> '.$txt['Credits_07'].'
				<br />&nbsp;&nbsp;<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/bullet_green.png" alt="" /> '.$txt['Credits_08'].'
				<br />&nbsp;&nbsp;<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/bullet_green.png" alt="" /> '.$txt['Credits_09'].'
				<br />&nbsp;&nbsp;<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/bullet_green.png" alt="" /> '.$txt['Credits_10'].'
			</div>
			<span class="botslice"><span></span></span>
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<img style="vertical-align: middle;" src="http://www.smfpersonal.net/famfamfam/award_star_gold_1.png" alt="" /> 
				'.$txt['Credits_11'].'
			</h3>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/user.png" alt="" /> '.$txt['Credits_12'].'
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.smfpersonal.net/profiles/lucasruroken-u1.html" target="_blank">'.$txt['Credits_13'].'</a>
				<br /><br /><img style="vertical-align: middle;" src="http://www.smfpersonal.net/famfamfam/user_red.png" alt="" /> '.$txt['Credits_14'].'
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.smfpersonal.net/profiles/heracles-u259.html" target="_blank">'.$txt['Credits_15'].'</a>
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.smfpersonal.net/profiles/enik-u417.html" target="_blank">'.$txt['Credits_16'].'</a>
				<br /><br /><img style="vertical-align: middle;" src="http://www.smfpersonal.net/famfamfam/user_green.png" alt="" /> '.$txt['Credits_17'].'
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.smfpersonal.net/profiles/prototype-u641" target="_blank">'.$txt['Credits_18'].'</a>
				<br /><br /><img style="vertical-align: middle;" src="http://www.smfpersonal.net/famfamfam/user_go.png" alt="" /> '.$txt['Credits_19'].'
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.smfpersonal.net/profiles/candidosa2-u60" target="_blank">'.$txt['Credits_20'].'</a>
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.smfpersonal.net/profiles/paules-u1520" target="_blank">'.$txt['Credits_21'].'</a>
				<br /><br /><img style="vertical-align: middle;" src="http://www.smfpersonal.net/famfamfam/group.png" alt="" /> <a href="http://www.smfpersonal.net/about.html" target="_blank">'.$txt['Credits_22'].'</a>
			</div>
			<span class="botslice"><span></span></span>
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/award_star_gold_1.png" alt="" /> 
				'.$txt['Credits_23'].'
			</h3>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/user_green.png" alt="" /> '.$txt['Credits_24'].'
				<br />&nbsp;&nbsp;<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/bullet_star.png" alt="" /><a href="http://www.smfpersonal.net/profiles/zutzu-u229.html" target="_blank">'.$txt['Credits_25'].'</a>
				<br />&nbsp;&nbsp;<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/bullet_star.png" alt="" /><a href="http://www.smfpersonal.net/profiles/Kenet-u85.html" target="_blank">'.$txt['Credits_26'].'</a>
				<br />&nbsp;&nbsp;<img style="vertical-align: middle;" src="',$boardurl,'/adkportal/images/bullet_star.png" alt="" /><a href="http://www.smfpersonal.net/profiles/Andres-u3.html" target="_blank">'.$txt['Credits_27'].'</a>
			</div>
			<span class="botslice"><span></span></span>
		</div>
	';
	
	ILoveAdkPortal();
}

function template_adk_contact()
{
	global $txt, $scripturl, $context, $boardurl, $user_info;
	
	//Alert
	echo'
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		function alert_info(){
			alert("',$txt['adk_form_select_admin_2'],'");
		}
	// ]]></script>';
	
	if(isset($_REQUEST['sended'])){
		echo'
		<div class="information">
			',$txt['adk_form_sendeded'],'
		</div>';
	}
	
	echo'
	<form method="post" action="'. $scripturl .'?action=contact;sa=send">
	<div class="cat_bar">
		<h3 class="catbg">
			<img alt="" src="',$boardurl,'/adkportal/images/messages.png" style="vertical-align: middle;" />&nbsp;',$txt['adk_form_contact'],'
		</h3>
	</div>
	<div>
		<span class="upperframe"><span></span></span>
		<div class="roundframe">
			<dl id="post_header">
				<dt><img alt="" src="',$boardurl,'/adkportal/images/agt.png" />&nbsp;',$txt['subject'],'</dt>
				<dd><input type="text" name="subject" value="" size="80" maxlength="80" class="input_text" /></dd>';
				
		echo'
				<dt><img alt="" src="',$boardurl,'/adkportal/images/user_suit.png" />&nbsp;',$txt['name'],'</dt>
				<dd><input type="text" name="name" value="" size="80" maxlength="80" class="input_text" /></dd>
				<dt><img alt="" src="',$boardurl,'/adkportal/images/postscript.png" />&nbsp;',$txt['email'],'</dt>
				<dd><input type="text" name="email" value="" size="80" maxlength="80" class="input_text" /></dd>
				<dt><img alt="" src="',$boardurl,'/adkportal/images/users.png" />&nbsp;',$txt['adk_form_select_admin'],'</dt>
				<dd><select name="admin">';
	
	foreach($context['members_admin'] AS $id_member => $name)
		echo'
						<option value="',$id_member,'">',$name,'</option>';
	
	echo'
						<option value="0">',$txt['adk_form_send_all'],'</option>
					</select>&nbsp;<a href="javascript:alert_info();"><img alt="" src="',$boardurl,'/adkportal/images/bullet_error.png" /></a></dd>';
	echo'
			</dl><br />';
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
	
	echo'<br />';
	echo '
					<div class="post_verification">
						<span>
							<strong>', $txt['verification'], ':</strong>
						</span>
						', template_control_verification($context['visual_verification_id'], 'all'), '
					</div>';
	echo'
	<br />
				<div align="center"><input type="submit" value="',$txt['save'],'" class="button_submit" /><input type="hidden" name="sc" value="',$context['session_id'],'" /></div>
			
		</div>
		<span class="lowerframe"><span></span></span>
	</div>
	</form>';
	
	ILoveAdkPortal();
}
?>