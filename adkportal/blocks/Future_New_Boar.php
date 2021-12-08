<?php
//Block Futures Perfom! by Share24hs.com

	global $context, $scripturl, $txt, $settings, $smcFunc, $boardurl, $adkportal;
	
	$array = explode(',',$adkportal['auto_news_id_boards']);
	$limit_body = $adkportal['auto_news_limit_body'];
	$limit_query = $adkportal['auto_news_limit_topics'];
	
	$sql = $smcFunc['db_query']('','
		SELECT m.id_board, b.id_board, b.name, m.id_topic, m.poster_time, m.id_member, m.poster_name,
		m.subject, m.body, m.icon, mg.online_color
		FROM {db_prefix}messages AS m
		LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = m.id_member)
		LEFT JOIN {db_prefix}boards AS b ON (m.id_board = b.id_board)
		LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = IF(mem.id_group = 0, mem.id_post_group, mem.id_group))
		WHERE m.id_board IN ('.implode(',',$array).') AND m.subject NOT LIKE "Re:%"
		ORDER BY m.id_topic DESC LIMIT {int:limit} ',
		array(
			'limit' => $limit_query,
		)
	);
								
	$topics = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$topics[] = array(
			'id_topic' => $row['id_topic'],
			'img' => '<img src="'.$settings['images_url'].'/post/'.$row['icon'].'.gif" alt="" />',
			'href' => $row['subject'],
			'time' => timeformat($row['poster_time']),
			'member' => '<a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'" style="color: '.$row['online_color'].';">'.$row['poster_name'].'</a>',
			'body' => $row['body'],
			'board' => '<a href="'.$scripturl.'?board='.$row['id_board'].'.0">'.$row['name'].'</a>'
		);
	}
	//$averiguar = $avatar2,1,4);
	$smcFunc['db_free_result']($sql);
	
	
	foreach($topics AS $topic)
	{
	
		 $images = preg_replace('/(.*)\[img\](.*)\[\/img\](.*)/',"$2",$topic['body']);  
		 $sinurl = preg_replace('/\[url=(.*)\[\/url\]/',"",$topic['body']); 
		 $sinbr = preg_replace('/<br \/><br \/>/',"  ",$sinurl);  
		 $body1 = preg_replace('/\[img\](.*)\[\/img\]/',"  ",$sinbr);
		 
		// Inicializamos las variables
		$tamano = 250; // tamao mximo
		$texto = substr($body1,0,$tamano);

		// <textarea name="a" cols="50" rows="5">'. $texto.'</textarea>
				echo'
         
				<span class="clear upperframe"><span></span></span>
					<div class="roundframe">
						<div class="innerframe" style="min-height: 1.2em;">	
			
							<table style="width: 100%;" border="0">
								<tr>
									<td colspan=3 rowspan=3><img src="',$images,'" width="130" height="145" alt="" /></td>
									<td width="85%" colspan=3><div style="margin-left:10px;"><a href="'.$scripturl.'?topic='.$topic['id_topic'].'.0">'.$topic['href'].'</a></div></td>
    
								</tr>
								<tr>
									<td height="74" colspan=6><div style="margin-left:10px;">'. $texto.'</div></td>
								</tr>
								<tr>
									<td colspan=6><div style="margin-left:10px;">', $txt['by'], ' '.$topic['member'].' | ',$topic['time'], '</div></td>
								</tr>
							</table>
            
					   </div>
					</div>
				<span class="lowerframe"><span></span></span>
				
           
';
}

			
?>