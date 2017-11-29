<?php
################################################################################
# @Name : ./core/export_survey.php
# @Description : dump csv files of survey
# @call : /stat.php
# @parameters : 
# @Author : Flox
# @Create : 01/05/2017
# @Update : 02/05/2017
# @Version : 3.1.20
################################################################################

//initialize variables 
if(!isset($_GET['token'])) $_GET['token'] = ''; 

//locales
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if ($lang=='fr') {$_GET['lang'] = 'fr_FR';}
else {$_GET['lang'] = 'en_US';}

define('PROJECT_DIR', realpath('../'));
define('LOCALE_DIR', PROJECT_DIR .'/locale');
define('DEFAULT_LOCALE', '($_GET[lang]');
require_once('../components/php-gettext/gettext.inc');
$encoding = 'UTF-8';
$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;
T_setlocale(LC_MESSAGES, $locale);
T_bindtextdomain($_GET['lang'], LOCALE_DIR);
T_bind_textdomain_codeset($_GET['lang'], $encoding);
T_textdomain($_GET['lang']);

//database connection
require "../connect.php"; 

//get last token
$query = $db->query("SELECT token FROM `ttoken` WHERE action='export_survey' ORDER BY id DESC");
$token=$query->fetch(); 
$query->closeCursor();

//delete token
$query = $db->query("DELETE FROM `ttoken` WHERE action='export_survey' ");

//secure connect from authenticated user
if ($_GET['token'] && $token['token']==$_GET['token'])
{
	//get current date
	$daydate=date('Y-m-d');

	//output headers so that the file is downloaded rather than displayed
	header("Content-Type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=\"$daydate-GestSup-export-survey.csv\"");
	
	//load parameters table
	$qparameters = $db->query("SELECT * FROM `tparameters`"); 
	$rparameters= $qparameters->fetch();
	$qparameters->closeCursor();

	//create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	$col_title=array();
	array_push($col_title,T_('Date'));
	array_push($col_title,T_('N° Ticket'));
	array_push($col_title,T_('Titre ticket'));
	array_push($col_title,T_('Utilisateur'));
	$query = $db->query("SELECT text FROM tsurvey_questions ORDER BY number");
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
	{
		array_push($col_title,$row['text']);
	}
	
	//output the column headings
	fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
	fputcsv($output, $col_title,";");
	
	//get each ticket
	$query = $db->query("SELECT distinct(ticket_id) FROM tsurvey_answers ORDER BY ticket_id DESC");
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
	{	
		$outputrow=array();
		//get validate date
		$query2 = $db->query("SELECT MAX(date) FROM tsurvey_answers WHERE ticket_id='$row[ticket_id]'");
		$date= $query2->fetch();
		$query2->closeCursor();
		
		//count number of questions for this ticket
		$query2 = $db->query("SELECT count(id) FROM tsurvey_answers WHERE ticket_id='$row[ticket_id]'");
		$count= $query2->fetch();
		$query2->closeCursor();
		
		//get firstname and lastname of user attached with this ticket
		$query2 = $db->query("SELECT firstname,lastname FROM tusers WHERE id=(SELECT user FROM tincidents WHERE id='$row[ticket_id]')");
		$user= $query2->fetch();
		$query2->closeCursor();
		
		//get title of this ticket
		$query2 = $db->query("SELECT title FROM tincidents WHERE id='$row[ticket_id]'");
		$title= $query2->fetch();
		$query2->closeCursor();
		
		//for each ticket
		array_push($outputrow,$date[0]);
		array_push($outputrow,$row['ticket_id']);
		array_push($outputrow,$title[0]);
		array_push($outputrow,"$user[firstname] $user[lastname]");
		for($i=1;$i<=$count[0];$i++)
		{
			//get answer data for question $i
			$query2 = $db->query("SELECT answer FROM tsurvey_answers WHERE ticket_id='$row[ticket_id]' AND question_id=(SELECT id FROM tsurvey_questions WHERE number='$i')");
			$answer= $query2->fetch();
			$query2->closeCursor();
			$col=$i+2;
			array_push($outputrow,$answer[0]);
		}
		fputcsv($output,$outputrow,';');
	}
	
	
} else {
	echo '<br /><br /><center><span style="font-size: x-large; color: red;"><b>'.T_('Accès à cette page interdite, contactez votre administrateur').'.</b></span></center>';	
}
$db = null;
?>