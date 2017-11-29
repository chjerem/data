<?php
################################################################################
# @Name : monitor.php
# @Description : display new ticket current ticket for monitoring screen
# @call : /stat.php
# @parameters : 
# @Author : Flox
# @Create : 15/02/2014
# @Update : 07/02/2017
# @Version : 3.1.17
################################################################################

//initialize variables 
if(!isset($_GET['user_id'])) $_GET['user_id'] = ''; 

//connexion script with database parameters
require "connect.php";

//get userid to find language
if(!$_GET['user_id']) {$_GET['user_id']=1;}
$_SESSION['user_id']=$_GET['user_id'];

//load user table
$quser=$db->query("SELECT * FROM tusers WHERE id=$_SESSION[user_id]");
$ruser=$quser->fetch();
$quser->closeCursor(); 

//define current language
require "localization.php";

//switch SQL MODE to allow empty values with lastest version of MySQL
$db->exec('SET sql_mode = ""');

$daydate=date('Y-m-d');

$query=$db->query("SELECT count(*) FROM `tincidents` WHERE date_create LIKE '$daydate%' AND disable='0'");
$nbday=$query->fetch();
$query->closeCursor(); 

$query=$db->query("SELECT count(*) FROM `tincidents` WHERE technician='0' and disable='0'");
$cnt5=$query->fetch();
$query->closeCursor(); 

$query=$db->query("SELECT count(*) FROM `tincidents` WHERE date_res LIKE '$daydate%' AND state=3 AND disable='0'");
$nbdayres=$query->fetch();
$query->closeCursor(); 

session_start();
//initialize variables
if(!isset($_SESSION['current_ticket'])) $_SESSION['current_ticket'] = '';

//ring for new ticket
if($_SESSION['current_ticket']<$cnt5[0]) {echo'<audio hidden="false" autoplay="true" src="./sounds/notify.ogg" controls="controls"></audio>';}

//update current counter
if($_SESSION['current_ticket']!=$cnt5[0]) {$_SESSION['current_ticket']=$cnt5[0];}

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
	    <?php header('x-ua-compatible: ie=edge'); //disable ie compatibility mode ?>
		<meta charset="UTF-8" />
		<title>GestSup | <?php echo T_('Gestion de Support'); ?></title>
		<link rel="shortcut icon" type="image/png" href="./images/favicon_ticket.png" />
		<meta name="description" content="gestsup" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="./template/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="./template/assets/css/font-awesome.min.css" />
		<link rel="stylesheet" href="./template/assets/css/ace-fonts.css" />
		<link rel="stylesheet" href="./template/assets/css/jquery-ui-1.10.3.full.min.css" />
		<link rel="stylesheet" href="./template/assets/css/ace.min.css" />
		<link rel="stylesheet" href="./template/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="./template/assets/css/ace-skins.min.css" />
		<script src="./template/assets/js/ace-extra.min.js"></script>
		<meta http-equiv="Refresh" content="60">
	</head>
	<body>
	    <?php
	    //generate color
	    if($cnt5[0]>0) $color='danger'; else $color='success';
	    
	    //add pluriel
	    if($cnt5[0]>1) $new=T_('Nouveaux'); else $new=T_('Nouveau');
	    if($nbday[0]>1) $open=T_('Ouverts'); else $open=T_('Ouvert');
	    if($nbdayres[0]>1) $res=T_('Résolus'); else $res=T_('Résolu');
	    
	    ?>
        <a href="#" class="btn btn-<?php echo $color; ?> btn-app radius-4">
            <?php echo $new; ?> <br /><br /><br />
			<i class="icon-ticket bigger-230"><br /><br /><?php echo $cnt5[0]; ?></i>
			<br />
        </a>
        <a href="#" class="btn btn-info btn-app radius-4">
            <?php echo $open; ?><br /><?php echo T_('du jour'); ?>
            <br /><br />
			<i class="icon-plus bigger-230"><br /><br /><?php echo $nbday[0]; ?></i>
			<br />
        </a>
         <a href="#" class="btn btn-purple btn-app radius-4">
            <?php echo $res; ?><br /><?php echo T_('du jour'); ?>
            <br /><br />
			<i class="icon-ok bigger-230"><br /><br /><?php echo $nbdayres[0]; ?></i>
			<br />
        </a>
        
    </body>
</html>
<?php
// Close database access
$db = null;
?>
