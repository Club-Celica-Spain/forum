<?php

	//require_once("SSI.php");

	global $smcFunc, $scripturl, $boardurl;
	
	echo'
	<a onclick="javascript:views()" style="cursor: pointer;font-weight: bold;">Mas Vistos</a> |
	<a onclick="javascript:replies()" style="cursor: pointer;font-weight: bold;">Mas respondidos</a> |
	<a onclick="javascript:topics()" style="cursor: pointer;font-weight: bold;">Ultimos Temas</a> |
	<a onclick="javascript:msg()" style="cursor: pointer;font-weight: bold;">Ultimos Mensajes</a><hr />';
	
	$sql = $smcFunc['db_query']('','
		SELECT t.id_topic, m.subject, t.num_views, m.poster_name
		FROM {db_prefix}messages AS m
		INNER JOIN {db_prefix}topics AS t ON (t.id_first_msg = m.id_msg)
		ORDER BY num_views DESC LIMIT 10'
	);
	
	
	$views = '';
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$views .="<img src='$boardurl/adkportal/images/blocks/folder.png' alt='' />&nbsp;<a href='$scripturl?topic=".$row['id_topic'].".0'>".$row['subject']."</a><br />";
	}
	$smcFunc['db_free_result']($sql);
	
	$sql = $smcFunc['db_query']('','
		SELECT t.id_topic, m.subject, t.num_views
		FROM {db_prefix}messages AS m
		INNER JOIN {db_prefix}topics AS t ON (t.id_first_msg = m.id_msg)
		ORDER BY num_replies DESC LIMIT 10'
	);
	
	$replies = '';
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$replies .="<img src='$boardurl/adkportal/images/blocks/folder.png' alt='' />&nbsp;<a href='$scripturl?topic=".$row['id_topic'].".0'>".$row['subject']."</a><br />";
	}
	$smcFunc['db_free_result']($sql);
	
	$sql = $smcFunc['db_query']('','
		SELECT t.id_topic, m.subject, t.num_views
		FROM {db_prefix}messages AS m
		INNER JOIN {db_prefix}topics AS t ON (t.id_first_msg = m.id_msg)
		ORDER BY t.id_topic DESC LIMIT 10'
	);
	
	$topics = '';
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$topics .="<img src='$boardurl/adkportal/images/blocks/folder.png' alt='' />&nbsp;<a href='$scripturl?topic=".$row['id_topic'].".0'>".$row['subject']."</a><br />";
	}
	$smcFunc['db_free_result']($sql);
	
	$sql = $smcFunc['db_query']('','
		SELECT t.id_topic, m.subject, t.num_views
		FROM {db_prefix}messages AS m
		INNER JOIN {db_prefix}topics AS t ON (t.id_first_msg = m.id_msg)
		ORDER BY t.id_last_msg DESC LIMIT 10'
	);
	
	$msg = '';
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$msg .="<img src='$boardurl/adkportal/images/blocks/folder.png' alt='' />&nbsp;<a href='$scripturl?topic=".$row['id_topic'].".0'>".$row['subject']."</a><br />";
	}
	$smcFunc['db_free_result']($sql);
	
	echo
	'
	<script type="text/javascript">//<![CDATA[
		function views() {
			div = document.getElementById(\'previewform\')
			text = "'.$views.'" 
				   ;
			div.innerHTML = text;
		}
		function replies() {
			div = document.getElementById(\'previewform\')
			text = "'.$replies.'" 
				   ;
			div.innerHTML = text;
		}
		function topics() {
			div = document.getElementById(\'previewform\')
			text = "'.$topics.'" 
				   ;
			div.innerHTML = text;
		}
		function msg() {
			div = document.getElementById(\'previewform\')
			text = "'.$msg.'" 
				   ;
			div.innerHTML = text;
		}
		
		
		
					
		//]]></script>
	
	';
	
	echo'
		<table style="width: 100%;">
			<tr class="catbg">
				<td>
					Tema
				</td>
			</tr>
		</table>';
	
	
	echo
	'<div id="previewform">'.$views.'</div>
	
	<hr />
	
	<div class="smalltext" style="text-align: center;">Developed by <a href="http://www.animedk.net" target="_blank">lucas-ruroken</a> &amp; <a href="http://www.sharedownload.org" target="_blank">Share Download</a></div>';
	
	
	
	
	
	
	
	
	
	
?>