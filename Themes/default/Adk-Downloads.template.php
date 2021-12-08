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

function template_adk_search_not()
{
	global $txt;
	
	//Menu Buttons
	download_bar_buttons('search');
	
	echo'
	<div class="windowbg">
		<span class="topslice"><span></span></span>
		<div class="content" align="center">
			'.$txt['search_no_results'].'
		</div>
		<span class="botslice"><span></span></span>
	</div>';
	copy_adk_wii();
}

function template_adk_search_results()
{
	global $scripturl, $txt, $context, $boardurl;
	
	//Menu Buttons
	download_bar_buttons('search');
	
	echo'
	<div class="cat_bar">
		<h3 class="catbg">
			<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/search.png" />
			'.$txt['find_results'].'
		</h3>
	</div>
	<table style="width: 100%;">
		<tr>';
	
	$i = 0;
	
	foreach($context['downloads'] AS $down)
	{
		if($i == 2){
			echo'</tr><tr>';
			$i = 0;
		}
		
		echo'
		<td class="adk_50">
			<div class="information">
				<img class="adk_vertical" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_category_title'].'</strong> <a href="'.$scripturl.'?action=downloads;sa=view;down='.$down['id'].'">'.$down['title'].'</a><br />
				<img class="adk_vertical" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_member_post'].':</strong> <a href="'.$scripturl.'?action=profile;u='.$down['id_member'].'">'.$down['name'].'</a>
			</div>
		</td>';
		
		$i++;
	}
	
	echo'
		</tr>
	</table>';
	copy_adk_wii();

}	

function template_adk_search()
{
	global $context, $txt, $scripturl;
	
	//Menu Buttons
	download_bar_buttons('search');
	
	echo'
	<div class="cat_bar">
		<h3 class="catbg">
			'.$txt['adk_buscar'].' - '.$txt['downloads'].'
		</h3>
	</div>';
	
	echo'
	<form method="post" enctype="multipart/form-data" action="',$scripturl,'?action=downloads;sa=search2">
	<span class="upperframe"><span></span></span>
	<div class="roundframe">
		<div align="center">
			'.$txt['search_for'].': <input type="text" value="" name="search" />
			<br /><br />
			<input type="hidden" value="'.$context['session_id'].'" name="sc" />
			<input type="submit" value="',$txt['save'],'" class="button_submit " />
		</div>
	</div>
	<span class="lowerframe"><span></span></span>
	</form>';
	
	copy_adk_wii();
}

function template_main()
{
	global $context, $txt, $scripturl, $modSettings,$boardurl, $boarddir, $user_info;
	
	//The Download bar buttons
	download_bar_buttons();
	
	echo'
	<div class="title_bar"><h3 class="titlebg">
		<img src="'.$boardurl.'/adkportal/images/rotate.png" alt="" class="adk_vertical" />	'.$txt['adk_descargas_title'].'
	</h3></div>';

	echo'
	<div class="cat_bar"><h4 class="catbg">
		<img src="'.$boardurl.'/adkportal/images/arrow.png" class="adk_vertical" alt="'.$txt['adk_all_cat'].'" title="'.$txt['adk_all_cat'].'" />&nbsp;'.$txt['adk_all_cat'].'
	</h4></div>';
	
	echo'
	<div id="boardindex_table">
		<table class="table_list" cellspacing="1">
			<tbody>
				<tr class="titlebg">
					<td>&nbsp;</td>
					<td>'.$txt['adk_category'].'</td>
					<td align="center">'.$txt['downloads'].'</td>
					<td>'.$txt['adk_last_updated'].'</td>
					',allowedTo('adk_downloads_manage') ? '<td>&nbsp;</td>' : '' ,'
				</tr>
			</tbody>';	
			
	foreach($context['all_cat'] AS $cat)
	{	
		if($cat['view'] == '0')
		continue;
		
		if(!empty($context['all_parent'][$cat['id_cat']]))
			$sub_children = implode(', ',$context['all_parent'][$cat['id_cat']]);
		
		echo'
			<tbody class="content">';
			
		echo'
				<tr class="windowbg">
					<td align="center">';
		
		if(!empty($cat['image']))
			$image = str_replace($boarddir,$boardurl,$cat['image']);
		
		$caturl = $scripturl.'?action=downloads;cat='.$cat['id_cat'];
		
		if(!empty($image))
		echo'
					<img src="'.$image.'" alt="'.$cat['title'].'" />';
		
		echo'	
					</td>
					<td class="adk_40">';
		
		echo'
						<a class="subject adk_bold" href="'.$caturl.'">'.$cat['title'].'</a> 
						<br />
						<div class="smalltext">'.$cat['description'].'</div>
						',!empty($context['all_parent'][$cat['id_cat']]) ? '
						<br /><div class="smalltext windowbg2">'.$txt['adk_sub_cat_cat'].': '.$sub_children.'</div>' : '' ,'
					</td>
					<td align="center" class="adk_10">
						('.$cat['total'].')
					</td>
					<td class="smalltext adk_40">';
					if(!empty($cat['post']['id']))
					{
						$avatar = !empty($cat['post']['avatar']) ? $cat['post']['avatar'] : '<img style="width: 50px; height: 50px;" alt="" src="'.$boardurl.'/adkportal/images/noavatar.jpg" />';
						
						echo'
						<table class="adk_100">
							<tr>
								<td valign="top">
									'.$avatar.'
								</td>
								<td valign="top" class="adk_align_left">
									<img class="adk_vertical" alt="" src="'.$boardurl.'/adkportal/images/newmsg.png" />&nbsp;
									<strong>'.$cat['post']['file'].'</strong> '.$txt['by'].' '.$cat['post']['member'].'<br />
									'.$txt['on'].' '.$cat['post']['date'].'
								</td>
							</tr>
						</table>';
					}
						
		
		echo'
					</td>';
		
		if(allowedTo('adk_downloads_manage'))
			echo'
					<td valign="middle" class="adk_align_center">
						<a href="',$scripturl,'?action=downloads;sa=up;id='.$cat['id_cat'].'">
							<img alt="" src="',$boardurl,'/adkportal/images/colapse.gif" />
						</a>
						<a href="',$scripturl,'?action=downloads;sa=down;id='.$cat['id_cat'].'">
							<img alt="" src="',$boardurl,'/adkportal/images/expand.gif" />
						</a>
					</td>';
		
		echo'
				</tr>
			</tbody>
		';
			
			
				
	}	echo'
		</table>
	</div>
	<br />
	<br />';				
			echo'
	<table class="adk_100 adk_float_right">
		<tr>
			<td class="adk_50" valign="top">
				<span class="upperframe"><span></span></span>
					<div class="roundframe">
						<div class="cat_bar">
							<h4 class="catbg">
								'.$txt['adk_ultimos_anadidos'].'
							</h4>
						</div>
						<div class="my_back"></div>';
						
						if(!empty($context['last_downloads']))
							echo'
									<ul>
										',implode("",$context['last_downloads']),'
									</ul>';
						else
							echo'
								<ul><li>',$txt['adk_text_none'],'</li></ul>';
	echo'
						<div class="height_1"></div>
					</div>
				<span class="lowerframe"><span></span></span>
			</td>
			<td class="adk_50" valign="top">
				<span class="upperframe"><span></span></span>
					<div class="roundframe">
						<div class="cat_bar">
							<h4 class="catbg">
								'.$txt['adk_mods_populares'].'
							</h4>
						</div>
						<div class="my_back"></div>';
		
						if(!empty($context['downloads_popular']))
							echo'
									<ul>
										',implode("",$context['downloads_popular']),'
									</ul>';
						else
							echo'
								<ul><li>',$txt['adk_text_none'],'</li></ul>';
	echo'
						<div class="height_1"></div>
					</div>
				<span class="lowerframe"><span></span></span>
			</td>
		</tr>
	</table>';
	
	copy_adk_wii();
}


function template_view_download_files()
{
	global $context, $txt, $scripturl, $modSettings,$boardurl, $boarddir, $user_info;
	
	if(!empty($context['all_cat']))
	{
		echo'
		<div class="cat_bar"><h3 class="catbg">
			'.$context['adk_download_title'].' - '.$txt['adk_sub_sub_sub'].'
		</h3></div>
		';

		
		echo'
		<div id="boardindex_table">
			<table class="table_list" cellspacing="1">
				<tbody>
					<tr class="titlebg">
						<td>&nbsp;</td>
						<td>'.$txt['adk_category'].'</td>
						<td align="center">'.$txt['downloads'].'</td>
						<td>'.$txt['adk_last_updated'].'</td>
						',allowedTo('adk_downloads_manage') ? '<td>&nbsp;</td>' : '' ,'
					</tr>
				</tbody>';	
				
		foreach($context['all_cat'] AS $cat)
		{	
			if($cat['view'] == '0')
			continue;
			
			echo'
				<tbody class="content">';
				
			echo'
					<tr class="windowbg">
						<td align="center">';
			
			if(!empty($cat['image']))
				$image = str_replace($boarddir,$boardurl,$cat['image']);
			
			$caturl = $scripturl.'?action=downloads;cat='.$cat['id_cat'];
			
			if(!empty($image))
			echo'
						<img src="'.$image.'" alt="'.$cat['title'].'" />';
			
			echo'	
						</td>
						<td class="adk_40">';
			
			echo'
							<a class="subject" href="'.$caturl.'" style="font-weight: bold;">'.$cat['title'].'</a> 
							<br />
							<div class="smalltext">'.$cat['description'].'</div>
						</td>
						<td align="center" class="adk_10">
							('.$cat['total'].')
						</td>
						<td class="adk_40 smalltext">';
						if(!empty($cat['post']['id']))
						{
							$avatar = !empty($cat['post']['avatar']) ? $cat['post']['avatar'] : '<img style="width: 50px; height: 50px;" alt="" src="'.$boardurl.'/adkportal/images/noavatar.jpg" />';
							
							echo'
							<table class="adk_100">
								<tr>
									<td valign="top">
										'.$avatar.'
									</td>
									<td valign="top" align="left">
										<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/newmsg.png" />&nbsp;
										<strong>'.$cat['post']['file'].'</strong> '.$txt['by'].' '.$cat['post']['member'].'<br />
										'.$txt['on'].' '.$cat['post']['date'].'
									</td>
								</tr>
							</table>';
						}
							
			
			echo'
						</td>';
		
		if(allowedTo('adk_downloads_manage'))
			echo'
					<td valign="middle" align="center">
						<a href="',$scripturl,'?action=downloads;sa=up;id='.$cat['id_cat'].'">
							<img alt="" src="',$boardurl,'/adkportal/images/colapse.gif" />
						</a>
						<a href="',$scripturl,'?action=downloads;sa=down;id='.$cat['id_cat'].'">
							<img alt="" src="',$boardurl,'/adkportal/images/expand.gif" />
						</a>
					</td>';
		
		echo'
		
					</tr>
				</tbody>
			';
				
				
					
		}	echo'</table></div><br />';	
	
	}
	//The Menu Buttons
	if(allowedTo('adk_downloads_add'))
		$context['adk_downloads_add'] = true;
	if($context['user']['is_logged'])
		$context['adk_user_is_logged'] = true;
	
	$menu_buttons = array(
		'addnewfile' => array(
			'test' => 'adk_downloads_add', 
			'text' => 'adk_add_newdownload', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?action=downloads;sa=addnewfile;category='.$context['cat_id'],
			'active' => true
		),
		'viewstats' => array(
			'test' => 'adk_downloads_add', 
			'text' => 'adk_view_stats', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?action=downloads;sa=viewstats',
		),
		'myprofile' => array(
			'test' => 'adk_user_is_logged', 
			'text' => 'adk_myprofile', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?action=downloads;sa=myprofile;u='.$user_info['id'],
		)
	);
	
	echo'
	<table class="adk_100">
		<tr>
			<td align="left">
				<div align="left" class="smalltext">'.$txt['adk_gotopage'].': '.$context['page_index'].'</div>
			</td>
			<td align="right">
				',template_button_strip($menu_buttons,'right'),'
			</td>
		</tr>
	</table>';
	
	echo'
	<table class="table_grid" style="width: 100%;" cellspacing="1">
		<thead>
		<tr class="catbg">
			<th width="4%" scope="col" class="first_th" style="text-align: center;">
				&nbsp;
			</th>
			<th scope="col" align="center">
				'.$txt['adk_second_info'].'
			</th>
			<th scope="col" align="center" width="11%">
				'.$txt['adk_vistas'].'
			</th>
			<th scope="col" align="center" width="11%">
				'.$txt['adk_total_descargas'].'
			</th>
			<th scope="col" class="last_th" align="center" width="20%">
				'.$txt['adk_submitedd_on'].'
			</th>
		</tr>
		</thead>';
	
	$i = 0;
	foreach($context['listFiles'] AS $file)
	{
		$class = 'windowbg';
		$class_2 = 'windowbg2';
		
		echo'
		<tbody>
		<tr>
			<td class="'.$class.'" align="center">
				<img src="'.$boardurl.'/adkportal/images/folder.png" alt="" />
			</td>
			<td class="'.$class_2.'">
				'.$file['file'].'
				<div class="smalltext">'.$txt['by'].': '.$file['member'].'</div>
			</td>
			<td class="'.$class.' smalltext" align="center">
				'.$txt['page_view_adk'].' '.$file['views'].'
			</td>
			<td class="'.$class_2.' smalltext" align="center">
				'.$txt['adk_total_descargas'].': '.$file['total'].'
			</td>
			<td class="'.$class.' smalltext" align="center">
				'.$file['date'].'
			</td>
		</tr>
		</tbody>
		';
				
			
	}		
	echo'
	</table>';
	echo'
	<table style="width: 100%;">
		<tr>
			<td align="left">
				<div align="left" class="smalltext">'.$txt['adk_gotopage'].': '.$context['page_index'].'</div>
			</td>
			<td align="right">
				',template_button_strip($menu_buttons,'right'),'
			</td>
		</tr>
	</table>';
	
	copy_adk_wii();			
			
}

function template_adk_view_file()
{
	global $context, $txt, $scripturl, $modSettings, $user_info, $boardurl, $settings;
	
	$width_ = 100;
	
	if($context['adkDownloadInformation']['approved'] == 0)
		echo'
		<div class="approvebg">
			<span class="topslice"><span></span></span>
				<div class="warning_box">
					<strong>'.$txt['adk_atencion_unnapproved'].'</strong>  
				</div>
			<span class="botslice"><span></span></span>
		</div>';
	
	if($context['adkDownloadInformation']['approved'] == 1)
	{
		$newtxt = $scripturl.'?action=downloads;sa=unapprovedownload;id='.$context['adkDownloadInformation']['id_file'].';sesc='.$context['session_id'];
		$newtxt_2 = 'adk_unapprove';
	}
	else
	{
		$newtxt = $scripturl.'?action=downloads;sa=approvedownload;id='.$context['adkDownloadInformation']['id_file'].';sesc='.$context['session_id'];
		$newtxt_2 = 'adk_approve';
	}
	$report = '[<a href="'.$scripturl.'?action=downloads;sa=reportdownload;id='.$context['adkDownloadInformation']['id_file'].'">'.$txt['adk_report'].'</a>] ';
	
	
	if(allowedTo('adk_downloads_manage') || $user_info['id'] == $context['adkDownloadInformation']['id_member'])
		$context['you_can_edit_and_download'] = true;
	if(allowedTo('adk_downloads_manage'))
		$context['adk_downloads_manage'] = true;
	if(!empty($context['adkDownloadInformation']['id_topic']))
		$context['view_topic_you_can'] = true;
	
	//Adk Portal 2.0 RC6 Compatible
	$txt['adk_my_body'] = isset($txt['adk_my_body']) ? $txt['adk_my_body'] : 'Description';
	
	$menu_buttons = array(
		'view_topic' => array(
			'test' => 'view_topic_you_can', 
			'text' => 'adk_comment', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?topic='.$context['adkDownloadInformation']['id_topic'].'.0',
			'active' => true
		),
		'edit' => array(
			'test' => 'you_can_edit_and_download', 
			'text' => 'adk_edit_general', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?action=downloads;sa=editdownload;id='.$context['adkDownloadInformation']['id_file'].';sesc='.$context['session_id'],
		),
		'delete' => array(
			'test' => 'you_can_edit_and_download', 
			'text' => 'adk_delete', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?action=downloads;sa=deletedownload;id='.$context['adkDownloadInformation']['id_file'].';sesc='.$context['session_id'],
			'custom' => 'onclick="return confirm(\''. $txt['remove_message']. '?\');"',
		),
		'approve' => array(
			'test' => 'adk_downloads_manage', 
			'text' => $newtxt_2, 
			'image' => '', 
			'lang' => true,
			'url' => $newtxt
		),
	);
	
	echo'
	<div class="pagesection">
		',template_button_strip($menu_buttons,'right'),'
	</div>';
	
	$nav = array(
		'body' => array(
			'text' => 'adk_my_body',
			'image' => '',
			'lang' => true,
			'url' => '#" onmouseover="DownloadSection(\'body\')" id="body_2',
			'active' => true,
		),
		'poster' => array(
			'text' => 'adk_member_post',
			'image' => '',
			'lang' => true,
			'url' => '#" onmouseover="DownloadSection(\'poster\')" id="poster_2',
		),
		'files' => array(
			'text' => 'adk_another_txt',
			'image' => '',
			'lang' => true,
			'url' => '#" onmouseover="DownloadSection(\'files\')" id="files_2',
		),
	);

	
	echo'
	<div class="cat_bar"><h3 class="catbg">
		<img src="'.$boardurl.'/adkportal/images/page_white_copy.png" style="vertical-align: middle;" alt="" />&nbsp;'.$context['adkDownloadInformation']['file_title'].'
	</h3></div>';

	//;)
	echo'
	<div class="download_section">
		<div class="pagesection">
			',template_button_strip($nav,'right'),'
		</div>
	</div>';
	
	echo'
	<div style="display: block;" id="body">
		<div class="windowbg">
		<span class="topslice"><span></span></span>
			<div class="content">
				<div style="padding: 3px;" class="smalltext">
					<table style="width: 100%;">
						<tr>
							<td style="width: 50%;">
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_category_title'].'</strong> <a href="'.$scripturl.'?action=downloads;sa=view;down='.$context['adkDownloadInformation']['id_file'].'">'.$context['adkDownloadInformation']['file_title'].'</a><br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_nose_cat'].': </strong>'.$context['adkDownloadInformation']['cat'].'  <a href="'.$scripturl.'?action=downloads;cat='.$context['adkDownloadInformation']['id_cat'].'"><img alt="" src="'.$boardurl.'/adkportal/images/xmag.png" /></a><br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_date'].': </strong>'.$context['adkDownloadInformation']['date'].'<br />
							</td>
							<td style="width: 50%;">
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_total_descargas'].': </strong>'.$context['adkDownloadInformation']['totaldownloads'].'<br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_vistas'].': </strong> '.$context['adkDownloadInformation']['views'].'
								',!empty($context['adkDownloadInformation']['lastdownload']) ? '<br /><img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_last_download'].': </strong>'.$context['adkDownloadInformation']['lastdownload'] : '' ,' 	
							</td>
						</tr>
					</table>
				</div>
			</div>
		<span class="botslice"><span></span></span>
		</div>
		<div style="height: 3px;"></div>
		<div class="windowbg">
		<span class="topslice"><span></span></span>
			<div class="content">
				',!empty($context['adkDownloadInformation']['image']) ? '<div style="float: right;"><img src="'.$context['adkDownloadInformation']['image'].'" alt="" /></div>' : '' ,'
				'.$context['adkDownloadInformation']['description'].'
			</div>
		<span class="botslice"><span></span></span>
		</div>
	</div>
	
	
	<div id="poster" style="display: none;">
		<div class="windowbg">
		<span class="topslice"><span></span></span>
			<div class="content smalltext">
				<table width="100%" cellpadding="5" cellspacing="1">
					<tr>
						<td align="left" valign="top" width="33%" style="overflow: hidden;">			
							<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/user_suit.png" />&nbsp;<a href="'.$scripturl.'?action=profile;u='.$context['member']['id'].'"><strong>'. $context['member']['name'] .'</strong></a> <a href="'.$scripturl.'?action=downloads;sa=myprofile;u='.$context['adkDownloadInformation']['id_member'].'"><img alt="" src="'.$boardurl.'/adkportal/images/xmag.png" /></a><br />';
										
							// Show the member's primary group (like 'Administrator') if they have one.
							if (isset($context['member']['group']) && $context['member']['group'] != '')
								echo '
									<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/users.png" />&nbsp;'. $context['member']['group'] .'<br />';

							// Show the post group if and only if they have no other group or the option is on, and they are in a post group.
							if ((empty($settings['hide_post_group']) || $context['member']['group'] == '') && $context['member']['post_group'] != '')
								echo '
									<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/users.png" />&nbsp;'. $context['member']['post_group'] .'<br />';
								echo '
									'. $context['member']['group_stars'] .'<br />';

							
							// Show online and offline buttons?
							if (!empty($modSettings['onlineEnable']))
								echo 
									($settings['use_image_buttons'] ? '<img src="' . $context['member']['online']['image_href'] . '" alt="' . $context['member']['online']['text'] . '" border="0" style="margin-top: 2px;" />' : $context['member']['online']['text']) .' | ';
						
						
						echo'
							</td>
							<td align="left" valign="top" width="33%" style="overflow: hidden;">';
							// Show the member's gender icon?
							if (!empty($settings['show_gender']) && $context['member']['gender']['image'] != '')
								echo '
									'. $txt['gender'] .': '. $context['member']['gender']['image'] .' | ';
				
							// Show how many posts they have made.
							echo '
									<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/newmsg.png" />&nbsp;'. $txt['member_postcount'] .': '. $context['member']['posts'] .'<br />';

							// Show the member's custom title, if they have one.
							if (isset($context['member']['title']) && $context['member']['title'] != '')
								echo '
									'. $context['member']['title'] .'<br />';
					
							// Show their personal text?
							if (!empty($settings['show_blurb']) && $context['member']['blurb'] != '')
								echo '
									'. $context['member']['blurb'] .'';
						
						
						echo '
						</td>
						<td align="left" valign="top" width="33%" style="overflow: hidden;">			
						';
												
							// Show avatars, images, etc.?
							if (!empty($settings['show_user_images']))
								echo '
									<div style="overflow: auto; width: 100%;">'. (!empty($context['member']['avatar']['image']) ? $context['member']['avatar']['image'] : '<img src="" alt="" border="0" />') .'</div>';
									
							// This shows the popular messaging icons.
							echo '
								'. $context['member']['icq']['link'] .'
								'. $context['member']['msn']['link'] .'
								'. $context['member']['aim']['link'] .'
								'. $context['member']['yim']['link'] .'<br />';
						
						// Show the profile, website, email address, and personal message buttons.
						if ($settings['show_profile_buttons'])
						{
							// Show the profile button
							echo '
									<a href="'. $context['member']['href'] .'">'. ($settings['use_image_buttons'] ? '<img src="' . $settings['images_url'] . '/icons/profile_sm.gif" alt="" title="" border="0" />' : '') .'</a>';
			
							// Don't show an icon if they haven't specified a website.
							if ($context['member']['website']['url'] != '')
								echo '
									<a href="'. $context['member']['website']['url'] .'" title="' . $context['member']['website']['title'] . '" target="_blank">'. ($settings['use_image_buttons'] ? '<img src="' . $settings['images_url'] . '/www_sm.gif" alt="" border="0" />' : '') .'</a>';

							// Don't show the email address if they want it hidden and is guest.							
							if (empty($context['member']['hide_email']))					
								echo '							
									<a href="mailto:'. $context['member']['email'] .'">'. ($settings['use_image_buttons'] ? '<img src="' . $settings['images_url'] . '/email_sm.gif" alt="" title="" border="0" />' : '') .'</a>';						

							//Send PM button
								echo '
									<a href="'. $scripturl .'?action=pm;sa=send;u='. $context['member']['id'] .'" title="'. $context['member']['online']['label'] .'">'. ($settings['use_image_buttons'] ? '<img src="' . $settings['images_url'] . '/im_' . ($context['member']['online']['is_online'] ? 'on' : 'off') . '.gif" alt="' . $context['member']['online']['label'] . '" border="0" />' : $context['member']['online']['label']) .'</a>';
							
						}	
		echo '						
						</td>
					</tr>
				</table>
			</div>
		<span class="botslice"><span></span></span>
		</div>
		<div style="height: 3px;"></div>';
		
		if(!empty($context['member']['signature']))
		echo'
		<div class="windowbg">
		<span class="topslice"><span></span></span>
			<div class="content">
				',$context['member']['signature'],'
			</div>
		<span class="botslice"><span></span></span>
		</div>';
	echo'
	</div>
	
	<div style="display: none;" id="files">
		<div class="windowbg">
		<span class="topslice"><span></span></span>
			<div class="content">
				<table style="width: 100%;">
					<tr>
						<td style="width: 50%;">',implode('</td><td style="width: 50%;">',$context['load_attachments']),'</td>
					</tr>
				</table>	
			</div>
		<span class="botslice"><span></span></span>
		</div>
	</div>
	';
	
	/*
	
	<span class="clear upperframe"><span></span></span>
		<div class="roundframe">
			<table style="width: 100%;">
				<tr>
					<td style="width: 70;" class="smalltext" valign="top">
						<div class="title_bar">
							<h4 class="titlebg">
								'.$txt['adk_need_last_info'].'
							</h4>
						</div>
						<div class="information">
							<div style="padding: 3px;">
								',!empty($context['adkDownloadInformation']['avatar']) ? '<div style="float: right;">'.$context['adkDownloadInformation']['avatar'].'</div>' : '' ,'
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_category_title'].'</strong> <a href="'.$scripturl.'?action=downloads;sa=view;down='.$context['adkDownloadInformation']['id_file'].'">'.$context['adkDownloadInformation']['file_title'].'</a><br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_member_post'].':</strong> '.$context['adkDownloadInformation']['member'].' <a href="'.$scripturl.'?action=downloads;sa=myprofile;u='.$context['adkDownloadInformation']['id_member'].'"><img alt="" src="'.$boardurl.'/adkportal/images/xmag.png" /></a><br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_nose_cat'].': </strong>'.$context['adkDownloadInformation']['cat'].'  <a href="'.$scripturl.'?action=downloads;cat='.$context['adkDownloadInformation']['id_cat'].'"><img alt="" src="'.$boardurl.'/adkportal/images/xmag.png" /></a><br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_date'].': </strong>'.$context['adkDownloadInformation']['date'].'<br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_total_descargas'].': </strong>'.$context['adkDownloadInformation']['totaldownloads'].'<br />
								<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_vistas'].': </strong> '.$context['adkDownloadInformation']['views'].'
								',!empty($context['adkDownloadInformation']['lastdownload']) ? '<br /><img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/menu.png" />&nbsp;<strong>'.$txt['adk_last_download'].': </strong>'.$context['adkDownloadInformation']['lastdownload'] : '' ,' 	
							</div>
						</div>
					</td>
					<td style="width: 30%;" valign="top" class="smalltext">
						<div class="title_bar">
							<h4 class="titlebg">
								'.$txt['adk_view_archives'].' - '.$txt['adk_total_descargas'].'
							</h4>
						</div>
						<div class="information">
						',!empty($context['load_attachments']) ?
								'<ul><li>'.implode('</li><li>',$context['load_attachments']).'</li></ul>' : '' 
						,!empty($context['adkDownloadInformation']['image']) ?
							'<img style="max-width: 160px;" alt="" src="'.$context['adkDownloadInformation']['image'].'" />' : '' 
						,'
						</div>
					</td>
				</tr>
			</table>
		</div>
	<span class="lowerframe"><span></span></span>
	';
	
	echo'
	<div class="pagesection">
		',template_button_strip($menu_buttons,'right'),'
	</div>';
	
	/*
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="'.$boardurl.'/adkportal/js/download_system.js"></script>
		<div class="windowbg"><span class="topslice"><span></span></span>
			<div style="padding: 2px;">
			<td style="width: 45%;" valign="top">
				<div class="windowbg"><span class="topslice"><span></span></span>
					<div style="padding: 2px;">
						<table style="width: 100%; padding-top: 0px;">
							<tr>
								<td style="width: '.$width_.'%;" valign="top" class="smalltext">
									
								</td>
							</tr>
							<tr>
								<td style="width: '.$width_.'%;" valign="top" class="smalltext">
									<div style="padding: 3px;" class="titlebg">
									<strong style="font-size: 1.4em; font-family: tahoma;">
										'.$txt['adk_view_archives'].' - '.$txt['adk_total_descargas'].'
									</strong></div>
									<div class="windowbg2">
										<div style="padding: 3px;">
											',!empty($context['load_attachments']) ?
												'<ul><li>'.implode('</li><li>',$context['load_attachments']).'</li></ul>' : '' 
											,'
										</div>
									</div>
								</td>
							</tr>';
								if()
									echo'
									<tr>
									<td style="width: '.$width_.'%;" valign="top" class="smalltext">
									<div style="padding: 3px;" class="titlebg">
									<strong style="font-size: 1.4em; font-family: tahoma;">
										'.$txt['adk_screen_view'].'
									</strong></div>
									<div class="windowbg2">
										<div style="padding: 3px;" align="center">
											<img style="max-width: 160px;" alt="" src="'.$context['adkDownloadInformation']['image'].'" />
										</div>
									</div>
									</td>
									</tr>';
				echo'
							
						</table>
					</div>
				<span class="botslice"><span></span></span></div>
			</td>
		</tr>
	</table>';
	*/
	
	copy_adk_wii();
}

function template_download_my_profile()
{
	global $context, $txt, $scripturl, $boardurl, $user_info;
	
	//Menu Buttons
	download_bar_buttons('myprofile');
	
	echo'
	<div class="title_bar"><h3 class="titlebg">
		'.$txt['adk_total_descargas'].'
	</h3></div>';
	
	echo'
	<table style="width: 100%;" cellspacing="0">
		<tr>
			<td colspan="2">
				<div class="cat_bar">
					<h3 class="catbg">
						'.$txt['adk_second_info'].'
					</h3>
				</div>
			</td>
		</tr>
	</table>';
	
	$i = 0;
	foreach($context['listFiles'] AS $file)
	{	
		if($i == 0){
			$class = '';
			$i++;
		}
		else{
			$class = '2';
			$i = 0;
		}
		
		if($file['approved'] != 0)
			echo'
			<div class="windowbg'.$class.'"><span class="topslice"><span></span></span>
				<div style="padding: 3px;">
				<table style="width: 100%;" cellspacing="0">
					<tr>
						
						<td style="width: 50%;" valign="top" class="smalltext">
							<img src="'.$boardurl.'/adkportal/images/menu.png" alt="" />&nbsp;<strong>'.$txt['adk_second_title'].':</strong> '.$file['file'].'<br />
							<img src="'.$boardurl.'/adkportal/images/menu.png" alt="" />&nbsp;<strong>'.$txt['adk_member_post'].':</strong> '.$file['member'].'<br />
							<img src="'.$boardurl.'/adkportal/images/menu.png" alt="" />&nbsp;<strong>'.$txt['adk_vistas'].':</strong> '.$file['views'].'<br />
							<img src="'.$boardurl.'/adkportal/images/menu.png" alt="" />&nbsp;<strong>'.$txt['adk_total_descargas'].':</strong> '.$file['total'].'<br />
							<img src="'.$boardurl.'/adkportal/images/menu.png" alt="" />&nbsp;<strong>'.$txt['adk_date'].':</strong> '.$file['date'].'
							
						</td>
						<td style="width: 50%;" align="center">
							<strong>
								<a href="'.$scripturl.'?action=downloads;sa=view;down='.$file['id_file'].'">
									'.$txt['adk_ver_descarga'] .'
								</a>
							</strong>
						</td>
					</tr>
				</table>
				</div>
			<span class="botslice"><span></span></span></div>
			';
			
			elseif($file['approved'] == 0 && !allowedTo('adk_downloads_manage') || $user_info['id'] == $file['id_member'])
			echo'
			<div class="approvebg"><span class="topslice"><span></span></span>
				<div style="padding: 3px;">
				<table style="width: 100%;" cellspacing="0">
					<tr>
						
						<td valign="top">
							<strong>'.$txt['adk_second_title'].':</strong> '.$file['file'].'<br />
							<strong>'.$txt['adk_member_post'].':</strong> '.$file['member'].'<br />
							<strong>'.$txt['adk_vistas'].':</strong> '.$file['views'].'<br />
							<strong>'.$txt['adk_total_descargas'].':</strong> '.$file['total'].'<br />
							<strong>'.$txt['adk_date'].':</strong> '.$file['date'].'
							
						</td>
						<td style="text-align: center;">
							<strong>
								<a href="'.$scripturl.'?action=downloads;sa=view;down='.$file['id_file'].'">
									'.$txt['adk_ver_descarga'] .'
								</a>
							</strong>
						</td>
					</tr>
				</table>
				</div>
			<span class="botslice"><span></span></span></div>';
		
		
				
	}
		
	copy_adk_wii();
}



function template_add_a_new_download()
{
	global $context, $txt, $scripturl, $modSettings, $adkportal;
	
	$category = $context['id_cat_'];
	
	//Multi Files
	echo'
	<script type="text/javascript"><!-- // --><![CDATA[
		var allowed_attachments = '.$adkportal['download_max_attach_download'].';
		function addAttachment()
		{
			allowed_attachments = allowed_attachments - 1;
			if (allowed_attachments <= 0)
				return alert("'.$txt['adk_not_add_more'].'");

			setOuterHTML(document.getElementById("moreAttachments"), \'<br /><input type="file" size="60" name="download[]" class="input_file" /><dd class="smalltext" id="moreAttachments"><a href="#" onclick="addAttachment(); return false;">(m&aacute;s archivos)<\' + \'/a><\' + \'/dd>\');
			return true;
		}
	// ]]></script>';
	
	
	
	echo'
	<form method="post" enctype="multipart/form-data" action="' . $scripturl . '?action=downloads;sa=addnewfile2">
		<div class="tborder">
			<table cellspacing="0" style="width: 100%;">
				<tr>
					<td colspan="2" align="center">
						<div class="title_bar">
							<h3 class="titlebg">
								'.$txt['adk_add_newdownload'].' '.$context['cat_title'].'
							</h3>
						</div>
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_category_title'].'</strong>
					</td>
					<td style="text-align: left;">
						<input type="text" size="50" name="title" value="" />
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_category_description'].'</strong>
					</td>
					<td style="text-align: left;">
						<table>';
	
	if (!function_exists('getLanguages'))
	{
		// Showing BBC?
		if ($context['show_bbc'])
		{
			echo '
								<tr class="windowbg2">
	
									<td colspan="2" align="center">
										', template_control_richedit($context['post_box_name'], 'bbc'), '
									</td>
								</tr>';
		}
	
		// What about smileys?
		if (!empty($context['smileys']['postform']))
			echo '
								<tr class="windowbg2">
	
									<td colspan="2" align="center">
										', template_control_richedit($context['post_box_name'], 'smileys'), '
									</td>
								</tr>';
	
		// Show BBC buttons, smileys and textbox.
		echo '
								<tr class="windowbg2">
	
									<td colspan="2" align="center">
										', template_control_richedit($context['post_box_name'], 'message'), '
									</td>
								</tr>';
	}
	else 
	{
		echo '
								<tr class="windowbg2">
		<td>';
			// Showing BBC?
		if ($context['show_bbc'])
		{
			echo '
					<div id="bbcBox_message"></div>';
		}
	
		// What about smileys?
		if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
			echo '
					<div id="smileyBox_message"></div>';
	
		// Show BBC buttons, smileys and textbox.
		echo '
					', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');

		
		echo '</td></tr>';
	}

		
		echo '
						</table>
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_screen_url_a'].'</strong>
					</td>
					<td style="text-align: left;">
						<input type="file" size="60" name="screen" class="input_file" />
					</td>
				</tr>
				<tr class="windowbg2">
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_attachments'].'</strong>
					</td>
					<td style="text-align: left;">
						<input type="file" size="60" name="download[]" class="input_file" />
						<dl>
							<dd class="smalltext" id="moreAttachments">
								<a href="#" onclick="addAttachment(); return false;">
									'.$txt['adk_add_more_atacchs'].'
								</a>
							</dd>
						</dl>
					</td>
				</tr>
				
				<tr class="windowbg2">
					<td align="center" colspan="2">
						<input type="submit" value="'.$txt['save'].'" class="button_submit" />
						<input type="hidden" name="sc" value="'.$context['session_id'].'" />
						<input type="hidden" name="id_cat" value="'.$category.'" />
					</td>
				</tr>
				
				
			
				
			</table>
		</div>
	</form>';
					
					
	copy_adk_wii();			

}


function template_edit_a_download()
{
	global $context, $txt, $scripturl, $modSettings;
	global $adkportal;
	
	$category = $context['important_info']['id_cat'];
	$rest = $adkportal['download_max_attach_download'] - $context['important_info']['rest'];
	
	//Multi Files
	echo'
	<script type="text/javascript"><!-- // --><![CDATA[
		var allowed_attachments = '.$rest.';
		function addAttachment()
		{
			allowed_attachments = allowed_attachments - 1;
			if (allowed_attachments <= 0)
				return alert("'.$txt['adk_not_add_more'].'");

			setOuterHTML(document.getElementById("moreAttachments"), \'<br /><input type="file" size="60" name="download[]" class="input_file" /><dd class="smalltext" id="moreAttachments"><a href="#" onclick="addAttachment(); return false;">(m&aacute;s archivos)<\' + \'/a><\' + \'/dd>\');
			return true;
		}
	// ]]></script>';
	
	
	
	echo'
	<form method="post" enctype="multipart/form-data" action="',$scripturl,'?action=downloads;sa=saveeditdownload">
		<div class="tborder">
			<table cellspacing="0" style="width: 100%;">
				<tr>
					<td colspan="2" align="center">
						<div class="cat_bar"><h3 class="catbg">'.$txt['adk_edit_general'].' '.$context['important_info']['title'].'</h3></div>
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_category_title'].'</strong>
					</td>
					<td style="text-align: left;">
						<input type="text" size="50" name="title" value="'.$context['important_info']['title'].'" />
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						'.$txt['adk_nose_cat'].'
					</td>
					<td style="text-align: left;">
						<select name="cat">';
	foreach($context['downloads_cat'] AS $cat)
		echo'				<option value="'.$cat['id'].'"',$cat['id'] == $context['important_info']['id_cat'] ? ' selected="selected"' : '' ,'>'.$cat['title'].'</option>';
	
	echo'
						</select>
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_category_description'].'</strong>
					</td>
					<td style="text-align: left;">
						<table>';
	
	if (!function_exists('getLanguages'))
	{
		// Showing BBC?
		if ($context['show_bbc'])
		{
			echo '
								<tr class="windowbg2">
	
									<td colspan="2" align="center">
										', template_control_richedit($context['post_box_name'], 'bbc'), '
									</td>
								</tr>';
		}
	
		// What about smileys?
		if (!empty($context['smileys']['postform']))
			echo '
								<tr class="windowbg2">
	
									<td colspan="2" align="center">
										', template_control_richedit($context['post_box_name'], 'smileys'), '
									</td>
								</tr>';
	
		// Show BBC buttons, smileys and textbox.
		echo '
								<tr class="windowbg2">
	
									<td colspan="2" align="center">
										', template_control_richedit($context['post_box_name'], 'message'), '
									</td>
								</tr>';
	}
	else 
	{
		echo '
								<tr class="windowbg2">
		<td>';
			// Showing BBC?
		if ($context['show_bbc'])
		{
			echo '
					<div id="bbcBox_message"></div>';
		}
	
		// What about smileys?
		if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
			echo '
					<div id="smileyBox_message"></div>';
	
		// Show BBC buttons, smileys and textbox.
		echo '
					', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');

		
		echo '</td></tr>';
	}

		
		echo '
						</table>
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_screen_url_a'].'</strong>
					</td>
					<td style="text-align: left;">
						<input type="file" size="60" name="screen" class="input_file" />
						',!empty($context['important_info']['image']) ? '
						<br />
						<input type="checkbox" name="screen2" value="'.$context['important_info']['image'].'" checked="checked" />
						<strong>
							<a href="'.$context['important_info']['image'].'">
								'.$context['important_info']['image'].'
							</a>
						</strong>' : '' ,'
					</td>
				</tr>
				<tr class="windowbg2">
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr class="windowbg2">
					<td style="text-align: right;">
						<strong>'.$txt['adk_attachments'].'</strong>
					</td>
					<td style="text-align: left;">
						',$context['important_info']['rest'] < 4 ? '<input type="file" size="60" name="download[]" class="input_file" />' : '' ,'
						<dl>
							<dd class="smalltext" id="moreAttachments">
								<a href="#" onclick="addAttachment(); return false;">
									'.$txt['adk_add_more_atacchs'].'
								</a>
							</dd>
						</dl>
						<br />
						',!empty($context['load_attachs']) ? implode('<br />',$context['load_attachs']) : '','
					</td>
				</tr>
				
				<tr class="windowbg2">
					<td align="center" colspan="2">
						<input type="submit" value="'.$txt['save'].'" class="button_submit" />
						<input type="hidden" name="sc" value="'.$context['session_id'].'" />
						<input type="hidden" name="id_file" value="'.$context['important_info']['id_file'].'" />
						<input type="hidden" name="id_member" value="'.$context['important_info']['id_member'].'" />
						<input type="hidden" name="ex_id_cat" value="'.$context['important_info']['id_cat'].'" />
						
					</td>
				</tr>
				
				
			
				
			</table>
		</div>
	</form>';
					
					
	copy_adk_wii();			

}

function template_view_stats()
{
	global $context, $scripturl, $txt, $settings;
	
	download_bar_buttons('viewstats');
	
	echo'
	<div class="cat_bar"><h3 class="catbg">
		'.$txt['adk_view_stats'].'
	</h3></div>
	<table style="width: 100%;">
		<tr>
			<td style="width: 50%;">
				<div class="title_bar"><h4 class="titlebg">
					'.$txt['adk_ultimos_anadidos'].'
				</h4></div>
				<div class="windowbg2" style="height; 10em;">
					<span class="topslice"><span></span></span>
						<ul>
							',implode("",$context['last_downloads']),'
						</ul>
					<span class="botslice"><span></span></span>
				</div>
			</td>
			<td style="width: 50%;">
				<div class="title_bar"><h4 class="titlebg">
					'.$txt['adk_most_viewed'].'
				</h4></div>
				<div class="windowbg2" style="height; 10em;">
					<span class="topslice"><span></span></span>
						<ul>
							',implode("",$context['most_viewed']),'
						</ul>
					<span class="botslice"><span></span></span>
				</div>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="width: 100%;">
				<div class="title_bar"><h4 class="titlebg">
					'.$txt['adk_most_download'].'
				</h4></div>
				<div class="windowbg2" style="height; 10em;">
					<span class="topslice"><span></span></span>
						<ul>
							',implode("",$context['most_downloads']),'
						</ul>
					<span class="botslice"><span></span></span>
				</div>
			</td>
		</tr>
	</table>';
		
	copy_adk_wii();
		
}	
				
	







function template_downloadssettings()
{
	global $context, $txt, $scripturl, $modSettings, $adkportal;
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=adkdownloads;sa=savesettings">
	<div class="tborder">
		<div style="padding: 8px;" class="titlebg">
			'.$txt['adk_downloads_settings'].' - Extreme Download System
		</div>
			<table cellspacing="1" width="100%;">
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_enable_downloads'].'
						
					</td>
					<td style="width: 50%;" align="left">
						'.$txt['adk_yes'].' <input type="radio" value="1" name="download_enable" ',downloads_verify_checked('download_enable',1),' /> '.$txt['adk_no'].' <input type="radio" value="0" name="download_enable" ',downloads_verify_checked('download_enable',0),' />
					</td>
				</tr>
				
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_downloads_maxfilesize'].' 
						
					</td>
					<td style="width: 50%;" align="left">
						<input type="text" size="10" value="'.$adkportal['download_max_filesize'].'" name="download_max_filesize"  /> (Bytes)
					</td>
				</tr>
				
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_images_maxfilesize'].' 
						
					</td>
					<td style="width: 50%;" align="left">
						<input type="text" size="10" value="'.$adkportal['download_images_size'].'" name="download_images_size"  /> (Bytes)
					</td>
				</tr>
				
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_files_perpage'].' 
						
					</td>
					<td style="width: 50%;" align="left">
						<input type="text" size="10" value="'.$adkportal['download_set_files_per_page'].'" name="download_set_files_per_page"  />
					</td>
				</tr>
				
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_sendPmApprove'].' 
						
					</td>
					<td style="width: 50%;" align="left">
						'.$txt['adk_yes'].' <input type="radio" value="1" name="download_enable_sendpmApprove" ',downloads_verify_checked('download_enable_sendpmApprove',1),' /> '.$txt['adk_no'].' <input type="radio" value="0" name="download_enable_sendpmApprove" ',downloads_verify_checked('download_enable_sendpmApprove',0),' />
					</td>
				</tr>
				
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_sendPmApprove_body'].' 
						
					</td>
					<td style="width: 50%;" align="left">
						<textarea name="download_sendpm_body" rows="6" cols="40">'.$adkportal['download_sendpm_body'].'</textarea>
					</td>
				</tr>
				
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_sendPmApprove_ID'].' 
						
					</td>
					<td style="width: 50%;" align="left">
						<input type="text" size="10" value="'.$adkportal['download_sendpm_userId'].'" name="download_sendpm_userId"  />
					</td>
				</tr>
				
				<tr class="windowbg">
					<td style="width: 50%;">
						'.$txt['adk_max_attachs'].' 
						
					</td>
					<td style="width: 50%;" align="left">
						<input type="text" size="10" value="'.$adkportal['download_max_attach_download'].'" name="download_max_attach_download"  />
					</td>
				</tr>
				<tr class="windowbg" align="center">
					<td colspan="2">
						<input type="submit" value="'.$txt['save'].'" class="button_submit" />
						<input type="hidden" name="sc" value="'.$context['session_id'].'" />
					</td>
				</tr>
			</table>
		
	</div>
	</form>
				';

	ILoveAdkPortal();

}

function template_add_category()
{
	global $scripturl, $txt, $context, $settings, $modSettings, $boarddir;
	
	echo '
	<form method="post" enctype="multipart/form-data" name="catform" id="catform" action="' . $scripturl . '?action=admin;area=adkdownloads;sa=savecategory">
	<div class="tborder">
	<table border="0" cellpadding="0" cellspacing="1" width="100%">
		<tr>
			<td width="50%" colspan="2"  align="center">
				<div class="cat_bar"><h3 class="catbg"><b>', $txt['adk_addcategory'], '</b></h3></div>
			</td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg2" align="right"><span>
				<b>' . $txt['adk_category_title'] .'</b>&nbsp;</span>
			</td>
			<td width="72%"  class="windowbg2">
				<input type="text" name="title" size="64" maxlength="100" />
			</td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg" align="right"><span>
				<b>' . $txt['adk_category_subforo'] .'</b>&nbsp;</span>
			</td>
			<td width="72%"  class="windowbg">
				<select name="parent">
					<option value="0">',$txt['adk_text_none'],'</option>';
    foreach ($context['downloads_cat'] as $i => $category)
		echo '
					<option value="' . $category['ID_CAT']  . '" ' . (($context['cat_parent'] == $category['ID_CAT']) ? ' selected="selected"' : '') .'>' . $category['title'] . '</option>';

	echo'
				</select>
			</td>
		</tr>
		<tr>
			<td width="28%"  valign="top" class="windowbg2" align="right">
				<span><b>' .$txt['adk_category_description'] . '</b>&nbsp;</span><div class="smalltext">'. $txt['adk_downloads_text_bbcsupport'] .'</div>
			</td>
			<td width="72%"  class="windowbg2">
				<textarea rows="6" name="description" cols="54"></textarea>';
	echo '
			</td>
		</tr>
 
		<tr>
			<td width="28%"  class="windowbg" align="right">
				<span><b>' . $txt['adk_upload_icon_category'] . '</b>&nbsp;</span>
			</td>
			<td width="72%"  class="windowbg">';

	// Warn the user if the category image path is not writable
	if (!is_writable($boarddir . '/Adk-downloads/catimgs'))
		echo '
				<b style="color: red;">' . $txt['adk_catimgerror_writable']  . $boarddir . '/Adk-downloads/catimgs</b>';

	echo '
				<input type="file" size="48" name="picture" /></td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg2" align="right">
				<span><b>' .   $txt['adk_downloads_txt_sortby']  . '</b>&nbsp;</span>
				<div class="smalltext">'.$txt['adk_info_asc_desc1'].'</div>
			</td>
			<td style="padding-left: 5px;" width="72%"  class="windowbg2">
				<select name="sortby">
					<option value="date">',$txt['adk_date'],'</option>
					<option value="title">',$txt['adk_title'],'</option>
					<option value="mostview">',$txt['adk_mostview'],'</option>
					<option value="mostdowns">',$txt['adk_mostdownload'],'</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="28%" class="windowbg" align="right">
				<span><b>' .   $txt['adk_download_txt_otder'] . '</b>&nbsp;</span>
				<div class="smalltext">'.$txt['adk_info_asc_desc2'].'</div>
			</td>
			<td style="padding-left: 5px;" width="72%" class="windowbg">
				<select name="orderby">
					<option value="desc">',$txt['adk_desc'],'</option>
					<option value="asc">',$txt['adk_asc'],'</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg2" align="right">
				<span><b>' . $txt['adk_foro_board_name'] . '</b></span>
				<div class="smalltext">' . $txt['adk_post_info_2'] . '</div>
			</td>
			<td style="padding-left: 5px;" width="72%"  class="windowbg2">
				<select name="boardselect">';
	
	foreach ($context['downloads_boards'] as $key => $option)
		 echo '
					<option value="' . $key . '">' . $option . '</option>';

	echo '
				</select>
			</td>
		</tr>
		<tr>
			<td class="windowbg" align="right">
				<b>' . $txt['adk_lock_toopic'] . '</b>
			</td>
			<td style="padding-left: 5px;" class="windowbg" align="left">
				'.$txt['adk_yes'].'<input type="radio" value="1" name="locktopic" /> '.$txt['adk_no'].'
				<input type="radio" value="0" name="locktopic" checked="checked" />
			</td>
		</tr>
		<tr>
			<td width="28%" colspan="2"  align="center" class="windowbg2">
				<input type="submit" value="', $txt['save'], '" name="submit" />
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
			</td>
		</tr>
	</table>
	</div>
	</form>';


	ILoveAdkPortal();
}

function template_all_categories()
{
	global $context, $txt, $scripturl, $boardurl;
	
	echo'
	<div class="tborder">
		<div class="cat_bar">
			<h3 class="catbg">
				<img alt="" src="',$boardurl,'/adkportal/images/package.png" style="vertical-align: middle;" />&nbsp;'.$txt['adk_all_categories_title'].'
			</h3>
		</div>
		<div style="padding: 5px;">
			';
	
	$i = 1;
	
	echo'
	<table width="100%" cellspacing="1">';
	
	foreach($context['all_categories'] AS $cat)
	{
		//Change class
		if(($i % 2) == 0){
			$class = '2';
		}
		else 
			$class = '';
		
			
		
		echo'
			
				<tr class="windowbg',$class,'">
					<td style="width: 55%;" align="left">
						<a href="'.$scripturl.'?action=downloads;cat='.$cat['id_cat'].'">
							<strong>'.$cat['title'].'</strong>
						</a>
					</td>
					<td style="width: 15%;" align="center">
						<a onclick="return confirm(\'', $txt['remove_message'], '?\');" title="'.$txt['adk_delete'].'" href="'.$scripturl.'?action=admin;area=adkdownloads;sa=deletecategory;id='.$cat['id_cat'].';sesc='.$context['session_id'].'">
							<img alt="'.$txt['adk_delete'].'" src="',$boardurl,'/adkportal/images/cancel.png" />
						</a>
					</td>
					<td style="width: 15%;" align="center">
						<a title="'.$txt['adk_edit'].'" href="'.$scripturl.'?action=admin;area=adkdownloads;sa=editcategory;id='.$cat['id_cat'].';sesc='.$context['session_id'].'">
							<img alt="'.$txt['adk_edit'].'" src="',$boardurl,'/adkportal/images/b_edit.png" />
						</a>
					</td>
					<td style="width: 15%;" align="center">
						<a title="'.$txt['adk_permisos'].'" href="'.$scripturl.'?action=admin;area=adkdownloads;sa=permisoscategory;id='.$cat['id_cat'].';sesc='.$context['session_id'].'">
							<img alt="'.$txt['adk_permisos'].'" src="',$boardurl,'/adkportal/images/messages.png" />
						</a>&nbsp;
					</td>
				</tr>';
		
		$i++;
	}
	
	echo'
		</table>
		</div>
	</div>';
				
			
		

	ILoveAdkPortal();


}

function template_edit_category()
{
	global $scripturl, $txt, $context, $settings, $modSettings, $boarddir;
	
	echo '
	<form method="post" enctype="multipart/form-data" name="catform" id="catform" action="' . $scripturl . '?action=admin;area=adkdownloads;sa=saveeditcategory">
	<div class="tborder">
	<table border="0" cellpadding="0" cellspacing="1" width="100%">
		<tr>
			<td width="50%" colspan="2"  align="center">
				<div class="cat_bar"><h3 class="catbg"><b>', $txt['adk_addcategory'], '</b></h3></div>
			</td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg2" align="right"><span>
				<b>' . $txt['adk_category_title'] .'</b>&nbsp;</span>
			</td>
			<td width="72%"  class="windowbg2">
				<input type="text" name="title" value="'.$context['adk_cat']['title'].'" size="64" maxlength="100" />
			</td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg" align="right"><span>
				<b>' . $txt['adk_category_subforo'] .'</b>&nbsp;</span>
			</td>
			<td width="72%"  class="windowbg">
				<select name="parent">
					<option value="0">',$txt['adk_text_none'],'</option>';
    foreach ($context['downloads_cat'] as $i => $category)
		echo '
					<option value="' . $category['ID_CAT']  . '" ' . (($context['adk_cat']['id_parent'] == $category['ID_CAT']) ? ' selected="selected"' : '') .'>' . $category['title'] . '</option>';

	echo'
				</select>
			</td>
		</tr>
		<tr>
			<td width="28%"  valign="top" class="windowbg2" align="right">
				<span><b>' .$txt['adk_category_description'] . '</b>&nbsp;</span><div class="smalltext">'. $txt['adk_downloads_text_bbcsupport'] .'</div>
			</td>
			<td width="72%"  class="windowbg2">
				<textarea rows="6" name="description" cols="54">'.$context['adk_cat']['description'].'</textarea>';
	echo '
			</td>
		</tr>
 
		<tr>
			<td width="28%"  class="windowbg" align="right">
				<span><b>' . $txt['adk_upload_icon_category'] . '</b>&nbsp;</span>
			</td>
			<td width="72%"  class="windowbg">';

	// Warn the user if the category image path is not writable
	if (!is_writable($boarddir . '/Adk-downloads/catimgs'))
		echo '
				<b style="color: red;">' . $txt['adk_catimgerror_writable']  . $boarddir . '/Adk-downloads/catimgs</b>';

	echo '<input type="hidden" name="picture2" value="'.$context['adk_cat']['image2'].'" />
				<input type="file" size="48" name="picture" /></td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg2" align="right">
				<span><b>' .   $txt['adk_downloads_txt_sortby']  . '</b>&nbsp;</span>
				<div class="smalltext">'.$txt['adk_info_asc_desc1'].'</div>
			</td>
			<td style="padding-left: 5px;" width="72%"  class="windowbg2">
				<select name="sortby">
					<option value="date" ',$context['adk_cat']['sortby'] == 'id_file' ? 'selected="selected"' : '' ,'>',$txt['adk_date'],'</option>
					<option value="title" ',$context['adk_cat']['sortby'] == 'title' ? 'selected="selected"' : '' ,'>',$txt['adk_title'],'</option>
					<option value="mostview" ',$context['adk_cat']['sortby'] == 'views' ? 'selected="selected"' : '' ,'>',$txt['adk_mostview'],'</option>
					<option value="mostdowns" ',$context['adk_cat']['sortby'] == 'totaldownloads' ? 'selected="selected"' : '' ,'>',$txt['adk_mostdownload'],'</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="28%" class="windowbg" align="right">
				<span><b>' .   $txt['adk_download_txt_otder'] . '</b>&nbsp;</span>
				<div class="smalltext">'.$txt['adk_info_asc_desc2'].'</div>
			</td>
			<td style="padding-left: 5px;" width="72%" class="windowbg">
				<select name="orderby">
					<option value="desc" ',$context['adk_cat']['orderby'] == 'DESC' ? 'selected="selected"' : '' ,'>',$txt['adk_desc'],'</option>
					<option value="asc" ',$context['adk_cat']['orderby'] == 'ASC' ? 'selected="selected"' : '' ,'>',$txt['adk_asc'],'</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="28%"  class="windowbg2" align="right">
				<span><b>' . $txt['adk_foro_board_name'] . '</b></span>
				<div class="smalltext">' . $txt['adk_post_info_2'] . '</div>
			</td>
			<td style="padding-left: 5px;" width="72%"  class="windowbg2">
				<select name="boardselect">';
	
	foreach ($context['downloads_boards'] as $key => $option)
	{
		echo '
					<option value="' . $key . '" ',verfy_select_board($key,$context['adk_cat']['id_board']),'>' . $option . '</option>';
	}
	
	echo '
				</select>
			</td>
		</tr>
		<tr>
			<td class="windowbg" align="right">
				<b>' . $txt['adk_lock_toopic'] . '</b>
			</td>
			<td style="padding-left: 5px;" class="windowbg" align="left">
				'.$txt['adk_yes'].'<input type="radio" value="1" name="locktopic" ',$context['adk_cat']['locktopic'] == 1 ? 'checked="checked"' : '' ,'/> '.$txt['adk_no'].'
				<input type="radio" value="0" name="locktopic" ',$context['adk_cat']['locktopic'] == 0 ? 'checked="checked"' : '' ,'/>
			</td>
		</tr>
		<tr>
			<td width="28%" colspan="2"  align="center" class="windowbg2">
				<input type="submit" value="', $txt['save'], '" name="submit" />
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
				<input type="hidden" name="id_cat" value="'.$context['adk_cat']['id_cat'].'" />
			</td>
		</tr>
	</table>
	</div>
	</form>';

	ILoveAdkPortal();

}

function template_permission_category()
{
	global $context, $txt, $scripturl;
	
	echo '
	<table border="0" width="100%" cellspacing="0" align="center" cellpadding="4" class="tborder">
		<tr class="titlebg">
			<td>
				' .$txt['adk_advanced_permission_cat'].'
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				<form method="post" action="' . $scripturl . '?action=admin;area=adkdownloads;sa=permisossavecategory">
					<table class="tborder" style="text-align: left;">
						<tr class="titlebg">
							<td colspan="2">'  . $txt['adk_select_membergroup'] . '</td>
						</tr>
						<tr>
							<td align="right">&nbsp;</td>
								<td>
									<select name="groupname">
										<option value="-1">' . $txt['adk_d_guests'] . '</option>
										<option value="0">' . $txt['adk_d_regulars_users'] . '</option>';
	foreach ($context['groups'] as $group)
									echo '<option value="', $group['ID_GROUP'], '">', $group['group_name'], '</option>';

							echo '</select>
								</td>
						</tr>
						<tr class="windowbg2">
							<td>
								<input type="checkbox" name="view" checked="checked" />
							</td>
							<td>
								<b>' . $txt['adk_denied_view'] .'</b>
							</td>
						</tr>
						<tr class="windowbg2">
							<td>
								<input type="checkbox" name="add" checked="checked" />
							</td>
							<td>
								<b>' . $txt['adk_denied_addfile'] .'</b>
							</td>
						</tr>
						<tr class="windowbg2">
							<td align="center" colspan="2">
								<input type="hidden" name="cat" value="' . $context['downloads_cat'] . '" />
								<input type="submit" value="' . $txt['save'] . '" />
								<input type="hidden" name="sc" value="'.$context['session_id'].'" />
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				<table cellspacing="0" cellpadding="10" border="0" align="center" width="100%" class="tborder">
					<tr class="catbg">
						<td></td>
						<td>' .  $txt['adk_denied_view']  . '</td>
						<td>' .  $txt['adk_denied_addfile']  . '</td>
						<td>'. $txt['adk_delete'].' </td>
					</tr>';

	// Show the member groups
	foreach ($context['downloads_membergroups'] as $i => $row)
	{

				echo '<tr class="windowbg2">';
				echo '<td>', $row['group_name'], '</td>';
				echo '<td>' . ($row['view'] ? $txt['adk_access'] : $txt['adk_denied']) . '</td>';
				echo '<td>' . ($row['addfile'] ? $txt['adk_access'] : $txt['adk_denied']) . '</td>';
				echo'<td><a href="'.$scripturl.'?action=admin;area=adkdownloads;sa=permisosdeltecategory;id_cat='.$row['ID_CAT'].';id_group='.$row['ID_GROUP'].';sesc='.$context['session_id'].'">'.$txt['adk_delete'].'</a></td>';
				echo '</tr>';

	}

	// Show Regular members
	foreach ($context['downloads_reggroup'] as $i => $row)
	{

				echo '<tr class="windowbg2">';
				echo '<td>', $txt['adk_d_regulars_users'], '</td>';
				echo '<td>' . ($row['view'] ? $txt['adk_access'] : $txt['adk_denied']) . '</td>';
				echo '<td>' . ($row['addfile'] ? $txt['adk_access'] : $txt['adk_denied']) . '</td>';
				echo'<td><a href="'.$scripturl.'?action=admin;area=adkdownloads;sa=permisosdeltecategory;id_cat='.$row['ID_CAT'].';id_group=0;sesc='.$context['session_id'].'">'.$txt['adk_delete'].'</a></td>';
				echo '</tr>';
	}

	// Show Guests
	foreach ($context['downloads_guestgroup'] as $i => $row)
	{

				echo '<tr class="windowbg2">';
				echo '<td>', $txt['adk_d_guests'], '</td>';
				echo '<td>' . ($row['view'] ? $txt['adk_access'] : $txt['adk_denied']) . '</td>';
				echo '<td>' . ($row['addfile'] ? $txt['adk_access'] : $txt['adk_denied']) . '</td>';
				echo'<td><a href="'.$scripturl.'?action=admin;area=adkdownloads;sa=permisosdeltecategory;id_cat='.$row['id_cat'].';id_group=-1;sesc='.$context['session_id'].'">'.$txt['adk_delete'].'</a></td>';
				echo '</tr>';
	}


		echo '


				</table>
			</td>
		</tr>
	</table>';
	ILoveAdkPortal();
}

function template_approve_d()
{
	global $txt, $scripturl, $context;
	
	echo'
		<div class="cat_bar"><h3 class="catbg">
			'.$txt['adk_approve_admin'].'
		</h3></div>';
	
	foreach($context['unapproved'] AS $file)
		echo'
		<table class="windowbg2" cellspacing="0" style="width: 100%;">
			<tr>
				<td style="width: 50%; text-align: right; padding-right: 8px;">
					<a href="'.$scripturl.'?action=downloads;sa=view;down='.$file['id'].'">'.$file['title'].'</a>
				</td>
				<td style="width: 50%; text-align: left; padding-left: 8px; font-weight: bold;">
					<a href="'.$scripturl.'?action=downloads;sa=approvedownload;id='.$file['id'].';return=admin;sesc='.$context['session_id'].'">'.$txt['adk_approve'].'</a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr />
				</td>
			</tr>
		</table>
	';
	
	ILoveAdkPortal();
}



function copy_adk_wii()
{
	echo'<br />
	',base64_decode('PGRpdiBjbGFzcz0ic21hbGx0ZXh0IiBhbGlnbj0iY2VudGVyIj4NCgkJPGEgaHJlZj0iaHR0cDovL3d3dy5zbWZwZXJzb25hbC5uZXQiIHRhcmdldD0iX2JsYW5rIj4NCgkJCUV4dHJlbWUgRG93bmxvYWQgU3lzdGVtPC9hPiBieSA8YSBocmVmPSJodHRwOi8vY3VzdG9tLnNpbXBsZW1hY2hpbmVzLm9yZy9tb2RzL2luZGV4LnBocD9tb2Q9MjI1NSIgdGFyZ2V0PSJfYmxhbmsiPkFkayBQb3J0YWw8L2E+DQoJPC9kaXY+');


}

?>