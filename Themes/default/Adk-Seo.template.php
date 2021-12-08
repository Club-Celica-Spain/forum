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

function template_htaccess()
{
	global $scripturl, $txt, $context, $boardurl, $adkportal;
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=adkseoadmin;sa=savehtaccess">
	',empty($context['htaccess_content']) ? '
		<div class="approvebg"><span class="topslice"><span></span></span>
		<div class="content">
			<table style="width: 100%;">
				<tr>
					<td>
						<img alt="" src="'.$boardurl.'/adkportal/images/stop.png" />
					</td>
					<td>
						<strong>'.$txt['seo_htaccess_info'].'</strong>
					</td>
				</tr>
			</table>
		</div>
		<span class="botslice"><span></span></span></div>' : '' ,'
	
	<div class="cat_bar"><h3 class="catbg">
		'.$txt['seo_create_htaccess'].'
	</h3></div>
	<div class="windowbg2"><span class="topslice"><span></span></span>
		<div class="content">
			<div class="smalltext">
				'.$txt['seo_htaccess_another_info'].':
				',parse_bbc('
					[quote]
					RewriteRule ^pages/(.*)\.html index.php?page=$1 [L]
					RewriteRule ^cat/([0-9]*)-(.*).html;(.*)$ index.php?action=downloads;cat=$1;$3 [L]
					RewriteRule ^cat/([0-9]*)-(.*).html$ index.php?action=downloads;cat=$1 [L]
					RewriteRule ^down/([0-9]*)-(.*)\.html$ index.php?action=downloads;sa=view;down=$1 [L]
					[/quote]
				'),'
				'.$txt['seo_htaccess_another_info2'].'
					
			
				
			</div>
		<hr />
			<div align="center">
				<textarea cols="80" rows="12" name="htaccess">'.$context['htaccess_content'].'</textarea><br />
				<hr />
				'.$txt['seo_use_path'].'<br />
				<input size="60" name="path" value="'.$adkportal['path_seo'].'" /><br />
				<input type="submit" class="button_submit" value="'.$txt['save'].'" />
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
			</div>
		</div>
	<span class="botslice"><span></span></span></div>
	</form>
	
		
		
		';

	ILoveAdkPortal();

}

function template_settings_seo()
{
	global $adkportal, $txt, $context, $scripturl;
	
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=adkseoadmin;sa=savesettings">
	<table style="width: 100%;" cellspacing="0">
		<tr class="catbg">
			<td colspan="2" style="padding: 5px;">
				'.$txt['adk_settings'].'
			</td>
		</tr>
		<tr class="windowbg2">
			<td style="width: 50%; font-weight: bold;">
				'.$txt['seo_enable_pages'].'
			</td>
			<td style="align: left; width: 50%;">
				'.$txt['yes'].'<input type="radio" value="1" name="enable_pages_seo"',$adkportal['enable_pages_seo'] == 1 ? ' checked="checked"' : '' ,' />
				'.$txt['no'].'<input type="radio" value="0" name="enable_pages_seo"',$adkportal['enable_pages_seo'] == 0 ? ' checked="checked"' : '' ,' />
			</td>
		</tr>
		
		<tr class="windowbg2">
			<td style="width: 50%; font-weight: bold;">
				'.$txt['seo_enable_downloads'].'
			</td>
			<td style="align: left; width: 50%;">
				'.$txt['yes'].'<input type="radio" value="1" name="enable_download_seo"',$adkportal['enable_download_seo'] == 1 ? ' checked="checked"' : '' ,' />
				'.$txt['no'].'<input type="radio" value="0" name="enable_download_seo"',$adkportal['enable_download_seo'] == 0 ? ' checked="checked"' : '' ,' />
			</td>
		</tr>
		<tr class="titlebg">
			<td align="center" colspan="2">
				<input type="submit" class="button_submit" value="'.$txt['save'].'" />
				<input type="hidden" name="sc" value="'.$context['session_id'].'" />
			</td>
		</tr>
	</table>
	</form>
	';
	
	ILoveAdkPortal();
				
}


function template_robots_seo()
{
	global $adkportal, $txt, $context, $scripturl;
	
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=adkseoadmin;sa=saverobots">
	<div class="cat_bar"><h3 class="catbg">
		'.$txt['seo_create_htaccess'].'
	</h3></div>
	<div class="windowbg2"><span class="topslice"><span></span></span>
		<div class="content">
		<div class="smalltext">
			'.$txt['adk_robots_info1'].'<br />
			<strong><a href="http://www.smfpersonal.net/robots.txt" target="_blank">Robots.txt</a></strong>
		</div>
		<hr />
		<div align="center">
			<textarea cols="80" rows="12" name="robots">'.$context['robots_dir'].'</textarea><br />
			<div class="smalltext">'.$txt['adk_robots_info2'].'</div>
			<input type="submit" value="'.$txt['save'].'" />
			<input type="hidden" name="sc" value="'.$context['session_id'].'" />
		</div>
		</div>
	<span class="botslice"><span></span></span></div>
	</form>';
	
	
	ILoveAdkPortal();
	
}

?>