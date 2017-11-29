<?php
################################################################################
# @Name : /plugin/availability/print.php
# @Desc : print this page
# @call : /plugin/availability/index.php
# @parameters : category
# @Author : Flox
# @Create : 26/05/2015
# @Update : 22/12/2016
# @Version : 3.1.15
################################################################################

//define current language
//initialize variables
if(!isset($_SESSION['user_id'])) $_SESSION['user_id'] = '';


//get language from browser 
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if ($lang=='fr') {$_GET['lang'] = 'fr_FR';}
else {$_GET['lang'] = 'en_US';}

define('PROJECT_DIR', realpath('./'));
define('LOCALE_DIR', PROJECT_DIR .'/locale');
define('DEFAULT_LOCALE', '($_GET[lang]');
require_once('../../components/php-gettext/gettext.inc');
$encoding = 'UTF-8';
$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;
T_setlocale(LC_MESSAGES, $locale);
T_bindtextdomain($_GET['lang'], LOCALE_DIR);
T_bind_textdomain_codeset($_GET['lang'], $encoding);
T_textdomain($_GET['lang']);

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
	    
		<meta charset="UTF-8" />
		<title>GestSup | Gestion de Support</title>
		<link rel="shortcut icon" type="image/png" href="../..//images/favicon_ticket.png" />
		<meta name="description" content="gestsup" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	</head>
    <body onload="window.print();">
        <?php
            include("../../connect.php");
			$db->exec("SET NAMES 'utf8'"); 
			$year=$_GET['year'];
			//load parameters table
			$qparameters = $db->query("SELECT * FROM `tparameters`"); 
			$rparameters= $qparameters->fetch();
			//modify database encoding			
			include("index.php");
			// Close database access
			$db = null;
        ?>
    </body>
</html>