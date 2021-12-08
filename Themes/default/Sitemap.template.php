<?php
// Version 1.2.2; Sitemap

function template_Begin() {
	global $scripturl, $mbname, $txt;

	echo '<div class="tborder"><table class="bordercolor" border="0" cellpadding="4" cellspacing="1" width="100%" align="center">
	   <tbody><tr>
	      <td class="catbg3" colspan="2" align="center" height="18" width="100%"><a href="', $scripturl, '">', $mbname, ' - ', $txt['sitemap'], '</a></td>
	         </tr>
	   <tr><td class="windowbg2">';
}

function template_Boards() {
	global $context, $scripturl, $txt, $modSettings, $settings;

	template_Begin();
	
	if (!empty($modSettings['sitemap_collapsible'])) {// 
		echo '<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
menus_array = new Array (', $context['sitemap']['collapsible'], ');
menus_status_array = new Array ();// remembers state of switches
img_close = \'', $settings['images_url'], '/collapse.gif\';
img_open = \'', $settings['images_url'], '/expand.gif\';

function showHideSwitch (theid) {
  if (document.getElementById) {
    var switch_id = document.getElementById(theid);
    var imgid = theid+\'Button\';
    var button_id = document.getElementById(imgid);
    if (menus_status_array[theid] != \'show\') {
      button_id.setAttribute (\'src\', img_close);
      switch_id.className = \'showSwitch\';
	  menus_status_array[theid] = \'show\';
    }else{
      button_id.setAttribute (\'src\', img_open);
      switch_id.className = \'hideSwitch\';
	  menus_status_array[theid] = \'hide\';
    }
  }
}
// ]]></script>
';
	}

	echo '
		<table width="100%">
			<tr>
				<td width="13"></td>
				<td width="20%"><strong>', $txt['smf82'], '</strong></td>
				<td width="65%"><strong>', $txt[70], '</strong></td>
				<td width="40" align="center"><strong>', $txt[64], '</strong></td>
				<td width="50" align="center"><strong>', $txt[21], '</strong></td>
			</tr>
		</table>';


	if(isset($context['sitemap']['board']))
		// Setup a switch to use for collapsible sub-boards
		$switch = false;
		foreach($context['sitemap']['board'] as $board) {
			if ($board['level'] == 0 && $switch) {
				$switch = false;
				echo '
		</div>';
			}
			
			echo '
		<table width="100%">
			<tr', !empty($modSettings['sitemap_collapsible']) && $board['has_children'] ? ' id="tr_parent' . $board['id'] . '" onclick="showHideSwitch(\'parent' . $board['id'] . '\')"' : '', '>
				<td width="13">', !empty($modSettings['sitemap_collapsible']) && $board['has_children'] ? '<img src="' . $settings['images_url'] . '/expand.gif" alt="" name="parent' . $board['id'] . 'Button" id="parent' . $board['id'] . 'Button" />' : '', '</td>
				<td width="20%"><a href="', $scripturl, '?board=', $board['id'], '.0">',$board['name'],'</a></td>
				<td width="65%">', $board['description'], '</td>
				<td align="center" width="40">', $board['numt'], '</div></td>
				<td align="center" width="50">', $board['nump'], '</td>
			</tr>
		</table>';
			
			if (!empty($modSettings['sitemap_collapsible']) && $board['has_children']) {
				$switch = true;
				echo '
		<div class="hideSwitch" id="parent', $board['id'], '">';
			continue;
			}			
		}
		if ($switch)
			echo '
		</div>';

	template_End();
}

function template_Topics() {
	global $context, $scripturl, $txt;

	template_Begin();

	echo '<table width="100%">
			<tr>
				<td><strong>', $txt[118], '</strong></td>
				<td><strong>', $txt[109], '</strong></td>
				<td width="40" align="center"><strong>', $txt[301], '</strong></td>
				<td width="50" align="center"><strong>', $txt[110], '</strong></td>
			</tr>';

	$i = 1;
	if (isset($context['sitemap']['topic']))
		foreach ($context['sitemap']['topic'] as $topic) {
			echo '
			<tr>
				<td>', $i, '. [<a href="', $topic['board_href'], '">', $topic['board_name'], '</a>]&nbsp;<a href="', $topic['href'] ,'">', $topic['subject'], '</a></td>
				<td>', $topic['poster'], '</td>
				<td align="center">', $topic['views'], '</td>
				<td align="center">', $topic['replies'], '</td>
			</tr>';
			$i++;
		}
	echo '
		</table>';

	template_End();

}

function template_End() {
	global $scripturl, $modSettings, $txt, $context;

	echo '
		  <ul>';
	echo '
			<li><a href="',$scripturl,'?action=sitemap">', $txt['sitemap_boards'], '</a></li>';
	echo '
			<li>', $txt[64], ': ', $context['page_index'], '</li>';
	if(!empty($modSettings['sitemap_xml']) || $context['user']['is_admin'])
		echo '
			<li>', getXMLLink(), '</li>';
	echo '
		  </ul>';
	echo '
	</td></tr></tbody></table></div>';
}

function template_XMLDisplay() {
	global $context, $scripturl, $modSettings;

	// Test to see if Joomla!/Mambo is here...
	if (defined('_VALID_MOS' )) {
		global $mosConfig_live_site, $Itemid, $mosConfig_sef;
		$myurl = ($mosConfig_sef=='1' ? '' : $mosConfig_live_site. '/') . 'index.php?option=com_smf&amp;Itemid=' . $Itemid;
		$mark = '&amp;';
	}
	// And if its not here, create our own function...
	else {
		$myurl = $scripturl;
		$mark = '?';
		function sefReltoAbs($string) {
			global $modSettings, $scripturl;
			if (!empty($modSettings['pretty_enable_filters']) ||
				empty($modSettings['queryless_urls']) || 
				$string == $scripturl)
				return $string;
			$string = str_replace('?board=', '/board,', $string);
			$string = str_replace('?topic=', '/topic,', $string);
			$string = $string . '.html';
			return $string;
		}
	}


	echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.google.com/schemas/sitemap/0.84">';

	echo '
	<url>
		<loc>', sefReltoAbs($myurl), '</loc>
		<lastmod>', $context['sitemap']['main']['time'], '</lastmod>
		<changefreq>always</changefreq>
		<priority>1.0</priority>
	</url>';

	if (isset($context['sitemap']['board']))
	foreach ($context['sitemap']['board'] as $board)
		echo '
	<url>
		<loc>', sefReltoAbs($myurl . $mark . 'board=' . $board['id']), '</loc>
		<lastmod>', $board['time'], '</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
	</url>';

	if (isset($context['sitemap']['topic']))
	foreach ($context['sitemap']['topic'] as $topic)
		echo '
	<url>
		<loc>', sefReltoAbs($myurl . $mark . 'topic=' . $topic['id']), '</loc>
		<lastmod>', $topic['time'], '</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
	</url>';


	echo '
</urlset>';

}

function getXMLLink() {
	if (defined( '_VALID_MOS' )) {
		global $mosConfig_live_site, $Itemid;
		$retVal = '<script language="JavaScript" type="text/javascript"><!--  // --><![CDATA[
';
		$retVal .= 'document.write("<a href=\'' . $mosConfig_live_site . '/index.php?option=com_smf&amp;Itemid=' . $Itemid . '&amp;action=sitemap;xml\'>XML</a>")
';
		$retVal .= '// ]]></script>';

		return $retVal;
	}
	else {
		global $scripturl;
		return '<a href="' . $scripturl . '?action=sitemap;xml">XML</a>';
	}
}
?>