<?php
################################################################################
# @Name : ./core/export_assets.php
# @Description : dump csv files of all assets
# @call : /stat.php
# @parameters : 
# @Author : Flox
# @Create : 11/02/2016
# @Update : 01/05/2017
# @Version : 3.1.20
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
$query = $db->query("SELECT token FROM `ttoken` WHERE action='export_asset' ORDER BY id ");
$token=$query->fetch(); 
$query->closeCursor();

//delete token
$query = $db->query("DELETE FROM `ttoken` WHERE action='export_asset'");

//secure connect from authenticated user
if ($_GET['token'] && $token['token']==$_GET['token']) 
{
	//get current date
	$daydate=date('Y-m-d');

	//output headers so that the file is downloaded rather than displayed

	header("Content-Type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=\"$daydate-GestSup-export-asset.csv\"");
	
	//load parameters table
	$qparameters = $db->query("SELECT * FROM `tparameters`"); 
	$rparameters= $qparameters->fetch();
	$qparameters->closeCursor();

	//create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	//output the column headings
	fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
	fputcsv($output, array(T_('Numéro de l\'équipement'), T_('Numéro de série constructeur'), T_('Numéro de commande'), T_('Nom'),  T_('Nom NetBIOS'), T_('IP'),  T_('MAC'), T_('Description'), T_('Type'), T_('Fabriquant'), T_('Modèle'),T_('Utilisateur'), T_('État'), T_('Service'), T_('Localisation'), T_('Date installation'), T_('Date fin de garantie'), T_('Date stock'), T_('Date de Standbye'), T_('Date de recyclage'), T_('Date du dernier ping'), T_('Numéro de prise'), T_('Technicien'), T_('Service de maintenance')),";");

	$query="
		SELECT sn_internal,sn_manufacturer,sn_indent,netbios,1,2,3,description,type,manufacturer,model,user,state,department,location,date_install,date_end_warranty,date_stock,date_standbye,date_recycle,date_last_ping,socket,technician,maintenance,id
		FROM tassets 
		WHERE
		technician LIKE '$_GET[technician]' AND
		department LIKE '$_GET[service]' AND
		date_install LIKE '%-$_GET[month]-%' AND
		date_install LIKE '$_GET[year]-%' AND
		disable=0
	";
	//fetch the data
	$query = $db->query($query);

	//loop over the rows, outputting them
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
	{
		//get data
		$query2=$db->query("SELECT name FROM tassets_type WHERE id LIKE '$row[type]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['type']="$row2[0]";
		
		$query2=$db->query("SELECT name FROM tassets_manufacturer WHERE id LIKE '$row[manufacturer]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['manufacturer']="$row2[0]";
		
		$query2=$db->query("SELECT name FROM tassets_model WHERE id LIKE '$row[model]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['model']="$row2[0]";
		
		$query2=$db->query("SELECT firstname, lastname FROM tusers WHERE id LIKE '$row[user]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['user']="$row2[0] $row2[1]";	
		
		$query2=$db->query("SELECT name FROM tassets_state WHERE id LIKE '$row[state]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['state']="$row2[0]";	
		
		$query2=$db->query("SELECT name FROM tservices WHERE id LIKE '$row[department]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['department']="$row2[0]";
		
		$query2=$db->query("SELECT name FROM tassets_location WHERE id LIKE '$row[location]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['location']="$row2[0]";
		
		$query2=$db->query("SELECT firstname, lastname FROM tusers WHERE id LIKE '$row[technician]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['technician']="$row2[0] $row2[1]";	
		
		$query2=$db->query("SELECT name FROM tservices WHERE id LIKE '$row[maintenance]' "); 
		$row2=$query2->fetch();
		$query2->closeCursor(); 
		$row['maintenance']="$row2[0]";
		
		//get netbios from iface
		$row[1]='';
		$query2=$db->query("SELECT netbios FROM tassets_iface WHERE asset_id='$row[id]' AND disable='0'"); 
		while ($row2=$query2->fetch())
		{
			if($row2['netbios']) {$row[1].=$row2['netbios'].'   ';}
		}
		$query2->closeCursor();
		//get ip from iface
		$row[2]='';
		$query2=$db->query("SELECT ip FROM tassets_iface WHERE asset_id='$row[id]' AND disable='0'"); 
		while ($row2=$query2->fetch())
		{
			if($row2['ip']) {$row[2].=$row2['ip'].'   ';}
		}
		$query2->closeCursor(); 
		
		//get mac from iface
		$row[3]='';
		$query2=$db->query("SELECT mac FROM tassets_iface WHERE asset_id='$row[id]' AND disable='0'"); 
		while ($row2=$query2->fetch())
		{
			if($row2['mac']) {$row[3].=$row2['mac'].'   ';}
		}
		$row['id']='';
		fputcsv($output, $row,';');
	}
} else {
	echo '<br /><br /><center><span style="font-size: x-large; color: red;"><b>'.T_('Accès à cette page interdite, contactez votre administrateur').'.</b></span></center>';	
}
$db = null;
?>