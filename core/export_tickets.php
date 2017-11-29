<?php
################################################################################
# @Name : ./core/export_tickets.php
# @Description : dump csv files of current query
# @call : /stat.php
# @parameters : 
# @Author : Flox
# @Create : 27/01/2014
# @Update : 19/04/2017
# @Version : 3.1.20 Patch 1
################################################################################

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

//initialize variables 
if(!isset($_GET['token'])) $_GET['token'] = 'XXX'; 

//database connection
require "../connect.php"; 

//get last token
$query = $db->query("SELECT token FROM `ttoken` WHERE action='export_ticket' ORDER BY id ");
$token=$query->fetch(); 
$query->closeCursor();

//delete token
$query = $db->query("DELETE FROM `ttoken` WHERE action='export_asset'");

//secure connect from authenticated user
if ($_GET['token'] && $token['token']==$_GET['token']) 
{
	//get current date
	$daydate=date('Y-m-d');

	// output headers so that the file is downloaded rather than displayed
	header("Content-Type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=\"$daydate-GestSup-export-tickets.csv\"");

	//load parameters table
	$qparameters = $db->query("SELECT * FROM `tparameters`"); 
	$rparameters= $qparameters->fetch();
	$qparameters->closeCursor();
	
	//load rights table
	$query=$db->query("SELECT * FROM trights WHERE profile=(SELECT profile FROM tusers WHERE id=$_GET[userid])");
	$rright=$query->fetch();
	$query->closeCursor();
	
	$where='';
	//case limit user service
	if ($rparameters['user_limit_service']==1 && $rright['admin']==0 && $_GET['service']=='%'){
		//get services associated with this user
		$query = $db->query("SELECT service_id FROM `tusers_services` WHERE user_id='$_GET[userid]'"); 
		$cnt_service=$query->rowCount();
		$row=$query->fetch();
		$query->closecursor();
		if($cnt_service==0) {$where_service.='';}
		elseif($cnt_service==1) {
			$where.="u_service='$row[service_id]' AND ";
		} else {
			$cnt2=0;
			$query = $db->query("SELECT service_id FROM `tusers_services` WHERE user_id='$_GET[userid]'");
			$where.='(';
			while ($row=$query->fetch())	
			{
				$cnt2++;
				$where.="u_service='$row[service_id]'";
				if ($cnt_service!=$cnt2) $where.=' OR '; 
			}
			$where.=') AND ';
			$query->closecursor();
		}
	}

	//create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	//avoid UTF8 encoding problem
	fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
	
	//output the column headings
	$select='';
	
	if ($rparameters['user_agency']==1 && $rparameters['user_advanced']==0)
	{
		fputcsv($output, array(T_('Numéro du ticket'), T_('Type'), T_('Technicien'), T_('Demandeur'), T_('Service'), T_('Agence'), T_('Date de première réponse'), T_('Créateur'), T_('Catégorie'), T_('Sous-catégorie'),T_('Titre'), T_('Temps passé'), T_('Date de création'),T_('Date de résolution estimé'), T_('Date de clôture'), T_('État'), T_('Priorité'), T_('Criticité')),";");
		$select.='u_agency,img2,';
		$where.="u_agency LIKE '$_GET[agency]' AND";
	} elseif($rparameters['user_advanced']==1 && $rparameters['user_agency']==0) 
	{	
		fputcsv($output, array(T_('Numéro du ticket'), T_('Type'), T_('Technicien'), T_('Demandeur'), T_('Service'), T_('Société'), T_('Créateur'), T_('Catégorie'), T_('Sous-catégorie'),T_('Titre'), T_('Temps passé'), T_('Date de création'),T_('Date de résolution estimé'), T_('Date de clôture'), T_('État'), T_('Priorité'), T_('Criticité')),";");
		$select.='img1,';
		$where.='';
	} else {
		fputcsv($output, array(T_('Numéro du ticket'), T_('Type'), T_('Technicien'), T_('Demandeur'), T_('Service'), T_('Créateur'), T_('Catégorie'), T_('Sous-catégorie'),T_('Titre'), T_('Temps passé'), T_('Date de création'),T_('Date de résolution estimé'), T_('Date de clôture'), T_('État'), T_('Priorité'), T_('Criticité')),";");
		$select='';
		$where='';
	}
	
	$query="
	SELECT id,type,technician,user,u_service, $select creator,category,subcat,title,time,date_create,date_hope,date_res,state,priority,criticality 
	FROM tincidents 
	WHERE
	technician LIKE '$_GET[technician]' AND
	u_service LIKE '$_GET[service]' AND
	type LIKE '$_GET[type]' AND
	criticality LIKE '$_GET[criticality]' AND
	category LIKE '$_GET[category]' AND
	date_create LIKE '%-$_GET[month]-%' AND
	date_create LIKE '$_GET[year]-%' AND
	$where
	disable=0
	";

	$query = $db->query($query);
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
	{
		
		//detect technician group to display group name instead of technician name
		if ($row['technician']==0)
		{
			//check if group exist on this ticket
			$query2=$db->query("SELECT * FROM tincidents WHERE id='$row[id]'");
			$row2=$query2->fetch();
			$query2->closeCursor(); 
			if ($row2['t_group']!='0')
			{
				//get group name
				$query2=$db->query("SELECT * FROM tgroups WHERE id='$row2[t_group]'");
				$row2=$query2->fetch();
				$query2->closeCursor(); 
				$row['technician']="$row2[name]";
			}
		} else {
			$querytech=$db->query("SELECT firstname,lastname FROM tusers WHERE id LIKE '$row[technician]' "); 
			$resulttech=$querytech->fetch();
			$querytech->closeCursor(); 
			$row['technician']="$resulttech[firstname] $resulttech[lastname]";
		}
		
		$querytype=$db->query("SELECT name FROM ttypes WHERE id LIKE $row[type]"); 
		$resulttype=$querytype->fetch();
		$querytype->closeCursor(); 
		$row['type']=$resulttype['name'];
		
		if ($rparameters['user_advanced']==1)
		{
			$querycompany=$db->query("SELECT name FROM tcompany,tusers WHERE tusers.company=tcompany.id and tusers.id LIKE '$row[user]'"); 
			$resultcompany=$querycompany->fetch();
			$querycompany->closeCursor(); 
			$row['img1']="$resultcompany[name]";
		}
		
		//detect user group to display group name instead of user name
		if ($row['user']=='')
		{
			//check if group exist on this ticket
			$query2=$db->query("SELECT * FROM tincidents WHERE id='$row[id]'");
			$row2=$query2->fetch();
			$query2->closeCursor(); 
			if ($row2['u_group']!='0')
			{
				//get group name
				$query2=$db->query("SELECT * FROM tgroups WHERE id='$row2[u_group]'");
				$row2=$query2->fetch();
				$query2->closeCursor(); 
				$row['user']="$row2[name]";
			}
		} else {
			$queryuser=$db->query("SELECT firstname,lastname FROM tusers WHERE id LIKE '$row[user]'"); 
			$resultuser=$queryuser->fetch();
			$queryuser->closeCursor(); 
			$row['user']="$resultuser[firstname] $resultuser[lastname]";
		}
		
		$queryservice=$db->query("SELECT name FROM tservices WHERE id LIKE '$row[u_service]'"); 
		$resultservice=$queryservice->fetch();
		$queryservice->closeCursor(); 
		$row['u_service']="$resultservice[name]";
		
		if($rparameters['user_agency']==1)
		{
			$queryagency=$db->query("SELECT name FROM tagencies WHERE id LIKE '$row[u_agency]'"); 
			$resultagency=$queryagency->fetch();
			$queryagency->closeCursor(); 
			$row['u_agency']="$resultagency[name]";
			//find date first answer
			$queryfirst=$db->query("SELECT MIN(date) FROM `tthreads` WHERE ticket='$row[id]' AND type='0'"); 
			$resultfirst=$queryfirst->fetch();
			$queryfirst->closeCursor(); 
			$row['img2']="$resultfirst[0]";
		}
		
		$querycreator=$db->query("SELECT firstname,lastname FROM tusers WHERE id LIKE '$row[creator]'"); 
		$resultcreator=$querycreator->fetch();
		$querycreator->closeCursor(); 
		$row['creator']="$resultcreator[firstname] $resultcreator[lastname]";
		
		$querycat=$db->query("SELECT * FROM tcategory WHERE id LIKE '$row[category]'"); 
		$resultcat=$querycat->fetch();
		$querycat->closeCursor(); 
		$row['category']=$resultcat['name'];
		
		$queryscat=$db->query("SELECT * FROM tsubcat WHERE id LIKE '$row[subcat]'"); 
		$resultscat=$queryscat->fetch();
		$queryscat->closeCursor(); 
		$row['subcat']=$resultscat['name'];
		
		$querystate=$db->query("SELECT * FROM tstates WHERE id LIKE $row[state]"); 
		$resultstate=$querystate->fetch();
		$querystate->closeCursor(); 
		$row['state']=$resultstate['name'];
		
		$querypriority=$db->query("SELECT * FROM tpriority WHERE id LIKE $row[priority]"); 
		$resultpriority=$querypriority->fetch();
		$querypriority->closeCursor(); 
		$row['priority']=$resultpriority['name'];

		$querycriticality=$db->query("SELECT * FROM tcriticality WHERE id LIKE $row[criticality]"); 
		$resultcriticality=$querycriticality->fetch();
		$querycriticality->closeCursor(); 
		$row['criticality']=$resultcriticality['name'];
		
		fputcsv($output, $row,';');
	}
} else {
	echo '<br /><br /><center><span style="font-size: x-large; color: red;"><b>'.T_('Accès à cette page interdite, contactez votre administrateur').'.</b></span></center>';		
}
$db = null;
?>