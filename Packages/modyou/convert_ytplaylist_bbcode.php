<?php
/********************************************************************************
* convert_ytplaylist_bbcode,php										*
*********************************************************************************
* For SMF: Simple Machines Forum										*
* MYSQL USERS ONLY												*
* ==============================================================================	*
Converts [ytplaylist] bbcode to [youtube] format.
Since I've discontinued my [ytplaylist] mod as I've merged/added support in [youtube] mod
*********************************************************************************
Script based on a script by Matt Zuba (aka SlammedDime)
********************************************************************************/

@set_magic_quotes_runtime(0);
error_reporting(E_ALL);
if (@ini_get('session.save_handler') == 'user')
	@ini_set('session.save_handler', 'files');
@session_start();

// PHP6 doesn't have this /5.3 produces a warning
if(!function_exists('get_magic_quotes_gpc'))
{
    function get_magic_quotes_gpc()
    {
        return 0;
    }
}

if (@get_magic_quotes_gpc() == 1)
{
	foreach ($_POST as $k => $v)
		$_POST[$k] = stripslashes($v);
}

if (isset($_GET['paths']))
	step3();

show_header();

if (isset($_POST['path']))
	step2();
else
	step1();

show_footer();

function step1($error_message = '')
{
	if (file_exists(dirname(__FILE__) . '/Settings.php'))
		include_once(dirname(__FILE__) . '/Settings.php');
	else {
		echo '
					<div class="error_message">
						Settings.php was not found.  Please ensure this file is in your root SMF directory.
					</div>';
		return false;
	}

	if ($error_message != '')
		echo '
					<div class="error_message">
						', $error_message, '
					</div>';

	if (!$maintenance)
		echo '
					<div class="error_message">
						Your board must be in maintenance mode before beginning this process.
					</div>';
	else
		echo '
				<div class="panel">
					<form action="', $_SERVER['PHP_SELF'], '?step=2" method="post">
						<h2>MySQL connection details</h2>
						<h3>Ensure your database details below are correct (these are pulled from Settings.php, so they should be).</h3>

						<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 2ex;">
							<tr>
								<td width="20%" valign="top" class="textbox"><label for="db_server">MySQL server name:</label></td>
								<td>
									<input type="text" name="db_server" id="db_server" value="', $db_server, '" size="30" /><br />
									<div style="font-size: smaller; margin-bottom: 2ex;">This is nearly always localhost - so if you don\'t know, try localhost.</div>
								</td>
							</tr><tr>
								<td valign="top" class="textbox"><label for="db_user">MySQL username:</label></td>
								<td>
									<input type="text" name="db_user" id="db_user" value="', $db_user, '" size="30" /><br />
									<div style="font-size: smaller; margin-bottom: 2ex;">Fill in the username you need to connect to your MySQL database here.<br />If you don\'t know what it is, try the username of your ftp account, most of the time they are the same.</div>
								</td>
							</tr><tr>
								<td valign="top" class="textbox"><label for="db_passwd">MySQL password:</label></td>
								<td>
									<input type="password" name="db_passwd" id="db_passwd" value="', $db_passwd, '" size="30" /><br />
									<div style="font-size: smaller; margin-bottom: 2ex;">Here, put the password you need to connect to your MySQL database.<br />If you don\'t know this, you should try the password to your ftp account.</div>
								</td>
							</tr><tr>
								<td valign="top" class="textbox"><label for="db_name">MySQL database name:</label></td>
								<td>
									<input type="text" name="db_name" id="db_name" value="', empty($db_name) ? 'smf' : $db_name, '" size="30" /><br />
									<div style="font-size: smaller; margin-bottom: 2ex;">Fill in the name of the database you want to use.</div>
								</td>
							</tr>
						</table>

						<div align="right" style="margin: 1ex;"><input type="hidden" name="path" value="1" /><input type="hidden" name="db_prefix" value="', $db_prefix, '" /><input type="submit" value="Proceed" /></div>
					</form>
				</div>';

	return true;
}

function step2()
{
	$starttime = get_time();
	
	$db_connection = @mysql_connect($_POST['db_server'], $_POST['db_user'], $_POST['db_passwd']);
	if (!$db_connection)
		return step1('Cannot connect to the MySQL database server with the supplied data.  If you are not sure about what to type in, please contact your host.<br /><br /><tt>' . mysql_error() . '</tt>');

	if (!mysql_select_db($_POST['db_name'], $db_connection))
		return step1(sprintf('This tool was unable to access the &quot;<i>%s</i>&quot; database.  With some hosts, you have to create the database in your administration panel before SMF can use it.  Some also add prefixes - like your username - to your database names.', $_POST['db_name']));

	// This is going to *burn* memory...
	if (@ini_get('memory_limit') < 128)
		@ini_set('memory_limit', '128M');
	@set_time_limit(600);
	
	// Find out how many there were
	if(empty($_GET['total']))
	{
		$query = mysql_query("
			SELECT count(*) as line
			FROM ". $_POST['db_prefix'] ."messages
			WHERE body LIKE '%[ytplaylist%'
		");
		list($total) = mysql_fetch_row($query);
	}
	else
		$total = (int) $_GET['total'];
	
	// Fine out how many we've done
	$done = isset($_GET['done']) ? (int) $_GET['done'] : 0 ;
	
	// How many rows (messages) do we have to go through? First check to see if we have this...
	// Pull the messages...500 at a time
	$query = mysql_query("
		SELECT ID_MSG as id, body
		FROM ". $_POST['db_prefix'] ."messages
		WHERE body LIKE '%[ytplaylist%'
		LIMIT 500");
	$rows = @mysql_num_rows($query);
	(int) $rows;
	if($rows == 0)
		return step1('Congrats, there are no instances of [ytplaylist] bbcode in your messages table of the database<br /><b>For Security Reasons please delete this script now.</b>	And don\'t forget to take your forum out of Maintenance Mode');
		
	$updated_messages = array();
	// Lets do our stuff here
	$timeout = ini_get('default_socket_timeout');
	@ini_set('default_socket_timeout',3);
	while ($result = mysql_fetch_assoc($query)) {
		// No str_ireplace in PHP4
		if (@version_compare(PHP_VERSION, '5.0.0') == -1)
		{
			$result['body'] = preg_replace('~\[ytplaylist~i', '[youtube', $result['body']);
			$result['body'] = preg_replace('~\[/ytplaylist\]~i', '[/youtube]', $result['body']);
		}
		else
		{
			$result['body'] = str_ireplace('[ytplaylist', '[youtube', $result['body']);
			$result['body'] = str_ireplace('[/ytplaylist]', '[/youtube]', $result['body']);
		}
		// Re-escape the content
		$result['body'] = addslashes($result['body']);

		$updated_messages[] = $result;
	}
		
	// How many records are we actually going to update in the database?
	$done = $done + $rows;
	
	$failures = array();
	foreach ($updated_messages as $message) {
		$sql = "
			UPDATE {$_POST['db_prefix']}messages
			SET `body` = '$message[body]'
			WHERE `ID_MSG` = $message[id]
			LIMIT 1";

		if(!mysql_query($sql)) {
			$error_message = mysql_error($db_connection);
			$failures[$message['id']] = $error_message;
		}

	}
	
	$time = round(get_time() - $starttime + 5 + (!empty($_POST['time']) ? $_POST['time'] : 0),3);
	

	// More to do?
	if ($done < $total)
		// We're not done
		nextLine($total, $done, $rows, $failures, $time);
	
	// Looks like we are done, w00t!
		
	if (!empty($failures))
	{
		echo '
				<div class="error_message">
					<div style="color: red;">Some of the queries were not executed properly.  Technical information about the queries:</div>
					<div style="margin: 2.5ex;">';

		foreach ($failures as $line => $fail)
			echo '
						<b>Message #', $line, ':</b> ', nl2br(htmlspecialchars($fail)), '<br />';

		echo '
					</div>
				</div>';
	}

	echo '
				<div class="panel">
					<h2>Conversion complete!</h2>

					Congratulations!  All instances of [ytplaylist] bbcode have been successfully converted to [youtube].<br />
					<br />
					Stats:<br />
					&nbsp;&nbsp;', $total, ' messages updated<br />
					&nbsp;&nbsp;Overall, the script took ', $time, ' seconds to execute.<br />';
	if($total > 0)
		echo '
					&nbsp;&nbsp;About ', $time/$total, ' seconds per message<br />';
					
		echo '<br /><b>For Security Reasons please delete this script once its completed. And don\'t forget to take your forum out of Maintenance Mode</b>';

	return false;
}

function show_header()
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Convert [ytplaylist] BBCode Tool</title>
		<style type="text/css">
			body
			{
				font-family: Verdana, sans-serif;
				background-color: #D4D4D4;
				margin: 0;
			}
			body, td
			{
				font-size: 10pt;
			}
			div#header
			{
				background: url(Themes/default/images/titlebg.jpg) #E9F0F6 repeat-x;
				padding: 22px 4% 12px 4%;
				font-family: Georgia, serif;
				font-size: x-large;
				border-bottom: 1px solid black;
				height: 40px;
			}
			div#content
			{
				padding: 20px 30px;
			}
			div.error_message
			{
				border: 2px dashed red;
				background-color: #E1E1E1;
				margin: 1ex 4ex;
				padding: 1.5ex;
			}
			div.panel
			{
				border: 1px solid gray;
				background-color: #F0F0F0;
				margin: 1ex 0;
				padding: 1.2ex;
			}
			div.panel h2
			{
				margin: 0;
				margin-bottom: 0.5ex;
				padding-bottom: 3px;
				border-bottom: 1px dashed black;
				font-size: 14pt;
				font-weight: normal;
			}
			div.panel h3
			{
				margin: 0;
				margin-bottom: 2ex;
				font-size: 10pt;
				font-weight: normal;
			}
			form
			{
				margin: 0;
			}
			td.textbox
			{
				padding-top: 2px;
				font-weight: bold;
				white-space: nowrap;
				padding-right: 2ex;
			}
		</style>
	</head>
	<body>
		<div id="header">
			', file_exists(dirname(__FILE__) . '/Themes/default/images/smflogo.gif') ? '<a href="http://www.simplemachines.org/" target="_blank"><img src="Themes/default/images/smflogo.gif" style="float: right;" alt="Simple Machines" border="0" /></a>
			' : '', '<div title="Convert [ytplaylist] BBCode Tool">Convert [ytplaylist] BBCode Tool</div>
		</div>
		<div id="content">';
}

function show_footer()
{
	echo '
		</div>
	</body>
</html>';
}

function nextLine($total, $done, $max, $failures, $time)
{

	@set_time_limit(300);

	$_GET['total'] = $total;
	$_GET['done'] = $done;
	$_GET['time'] = $time;

	$query_string = '';
	foreach ($_GET as $k => $v)
		$query_string .= '&amp;' . $k . '=' . $v;
	if (strlen($query_string) != 0)
		$query_string = '?' . substr($query_string, 5);

	$percentage = round(($done * 100) / $_GET['total']);

	if (!empty($failures))
	{
		echo '
				<div class="error_message">
					<div style="color: red;">Some of the queries were not executed properly.  Technical information about the queries:</div>
					<div style="margin: 2.5ex;">';

		foreach ($failures as $line => $fail)
			echo '
						<b>Line #', $line + 1, ':</b> ', nl2br(htmlspecialchars($fail)), '<br />';

		echo '
					</div>
				</div>';
	}

	echo '
		<div class="panel">
			<h2>Not quite done yet! (approximately ', $percentage, '%)</h2>
			<h3>
				This tool has been paused to avoid overloading your server.  Don\'t worry, nothing\'s wrong - simply click the <label for="continue">continue button</label> below to keep going.
			</h3>

			<div style="font-size: 8pt; width: 60%; height: 1.2em; margin: auto; border: 1px solid black; background-color: white; padding: 1px; position: relative;">
				<div style="width: 100%; z-index: 2; color: black; position: absolute; text-align: center; font-weight: bold;">', $percentage, '%</div>
				<div style="width: ', $percentage, '%; height: 1.2em; z-index: 1; background-color: #6279ff;">&nbsp;</div>
			</div>

			<p>Please note that this percentage, regrettably, is not terribly accurate, and is only an approximation of progress.</p>

			<form action="', $_SERVER['PHP_SELF'], $query_string, '" method="post" name="autoSubmit">
				<input type="hidden" name="db_server" value="', $_POST['db_server'], '" />
				<input type="hidden" name="db_user" value="', $_POST['db_user'], '" />
				<input type="hidden" name="db_passwd" value="', $_POST['db_passwd'], '" />
				<input type="hidden" name="db_name" value="', $_POST['db_name'], '" />
				<input type="hidden" name="db_prefix" value="', $_POST['db_prefix'], '" />
				<input type="hidden" name="path" value="', $_POST['path'], '" />
				<input type="hidden" name="total" value="', $total, '" />
				<input type="hidden" name="time" value="', $time, '" />

				<div align="right" style="margin: 1ex;"><input name="b" type="submit" value="Continue" /></div>
			</form>
			<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
				window.onload = doAutoSubmit;
				var countdown = 5;

				function doAutoSubmit()
				{
					if (countdown == 0) {
						document.autoSubmit.b.disabled = true;
						document.autoSubmit.submit();
					}
					else if (countdown == -1)
						return;

					document.autoSubmit.b.value = "Continue (" + countdown + ")";
					countdown--;

					setTimeout("doAutoSubmit();", 1000);
				}
			// ]]></script>
		</div>';

	show_footer();
	exit;
}
function get_time() {
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	return $mtime;
}
?>