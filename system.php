<?php
################################################################################
# @Name : system.php
# @Description :  admin system
# @Call : ./admin.php, install/index.php
# @Parameters : 
# @Author : Flox
# @Create : 10/11/2013
# @Update : 27/04/2017
# @Version : 3.1.20
################################################################################

//initialize variables 
if(!isset($_GET['page'])) $_GET['page'] = '';

//for install call
if($_GET['page']=='admin') 
{
	require ('./connect.php');
} else {
	require ('../connect.php');
	//load parameters table
	$query=$db->query("SELECT * FROM tparameters");
	$rparameters=$query->fetch();
	$query->closeCursor(); 
}

//create private server key if not exist used to auto-installation URL
if($rparameters['server_private_key']=='') 
{
	$key=md5(uniqid());
	$db->exec("UPDATE tparameters SET server_private_key='$key' WHERE id=1");
}

//extract php info
ob_start();
phpinfo();
$phpinfo = array('phpinfo' => array());
if(preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER))
    foreach($matches as $match)
        if(strlen($match[1]))
            $phpinfo[$match[1]] = array();
        elseif(isset($match[3])){
			$ak=array_keys($phpinfo);
            $phpinfo[end($ak)][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
			}
        else
            {
			$ak=array_keys($phpinfo);
            $phpinfo[end($ak)][] = $match[2];
		}

//find PHP table informations, depends of PHP versions			
if (isset($phpinfo['Core'])!='') $vphp='Core';
elseif (isset($phpinfo['PHP Core'])!='') $vphp='PHP Core';
elseif (isset($phpinfo['HTTP Headers Information'])!='') $vphp='HTTP Headers Information'; 

//initialize variables 
if(!isset($_POST['Modifier'])) $_POST['Modifier'] = '';
if(!isset($phpinfo[$vphp]['file_uploads'][0])) $phpinfo[$vphp]['file_uploads'][0] = '';
if(!isset($phpinfo[$vphp]['memory_limit'][0])) $phpinfo[$vphp]['memory_limit'][0] = '';
if(!isset($phpinfo[$vphp]['upload_max_filesize'][0])) $phpinfo[$vphp]['upload_max_filesize'][0] = '';
if(!isset($phpinfo[$vphp]['max_execution_time'][0])) $phpinfo[$vphp]['max_execution_time'][0] = '';
if(!isset($phpinfo['date']['date.timezone'][0])) $phpinfo['date']['date.timezone'][0] = '';
if(!isset($i)) $i = '';
if(!isset($openssl)) $openssl = '';
if(!isset($rdb_name)) $rdb_name = '';
if(!isset($rdb_version)) $rdb_version = '';
if(!isset($ldap)) $ldap = '';
if(!isset($zip)) $zip = '';
if(!isset($imap)) $imap = '';
if(!isset($pdo_mysql)) $pdo_mysql = '';
if(!isset($ftp)) $ftp = '';

//get rdb database version 
if ($_GET['page']!='admin') {require('../connect.php');}
$query = $db->query("show variables");
while ($row = $query->fetch())
{
	if ($row[0]=="version") {
		$rdb_version=$row[1];
		if (strpos($rdb_version, 'MariaDB')) {$rdb_name='MariaDB';} else {$rdb_name='MySQL';}
	}
}

//check OS
$OS=$phpinfo['phpinfo']['System'];
$OS= explode(" ",$OS);
$OS=$OS[0];

//get components versions
if ($_GET['page']!='admin')
{
$phpmailer = file_get_contents('../components/PHPMailer/VERSION');
$phpgettext = file_get_contents('../components/php-gettext/VERSION');
$phpimap = file_get_contents('../components/PhpImap/VERSION');
$highcharts = file_get_contents('../components/Highcharts/VERSION');
$wol = file_get_contents('../components/wol/VERSION');
} else {
$phpmailer = file_get_contents('./components/PHPMailer/VERSION');
$phpgettext = file_get_contents('./components/php-gettext/VERSION');
$phpimap = file_get_contents('./components/PhpImap/VERSION');
$highcharts = file_get_contents('./components/Highcharts/VERSION');
$wol = file_get_contents('./components/wol/VERSION');	
}
?>
<div class="profile-user-info profile-user-info-striped">
	<div class="profile-info-row">
		<div class="profile-info-name">  <?php echo T_('Serveur'); ?>: </div>
		<div class="profile-info-value">
			<span id="username">
				&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/<?php echo $OS; ?>.png" style="border-style: none" alt="img" /> <?php echo "<b>OS:</b> {$phpinfo['phpinfo']['System']}<br />"; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/apache.png" style="border-style: none" alt="img" /> <?php $apache=$phpinfo['apache2handler']['Apache Version']; $apache=preg_split('[ ]', $apache); $apache=preg_split('[/]', $apache[0]); echo "<b>Apache:</b> $apache[1] <br />"; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/<?php echo $rdb_name.'.png'; ?>" style="border-style: none" alt="img" /> <?php echo '<b>'.$rdb_name.':</b> '.$rdb_version.' <i>('.T_('nom de la base').': '.$db_name.')</i><br />'; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/php.png" style="border-style: none" alt="img" /> <b>PHP:</b> <?php echo phpversion(); ?> <br />
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="green icon-time icon-large"></i> <b><?php echo T_('Horloge'); ?>:</b> <?php echo date('Y-m-d H:i:s'); ?><br />
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="green icon-key icon-large"></i> <b><?php echo T_('Clé privée'); ?>:</b> <?php echo $rparameters['server_private_key']; ?>
			</span>
		</div>
	</div>
	<div class="profile-info-row">
		<div class="profile-info-name">  <?php echo T_('Composants'); ?>: </div>
		<div class="profile-info-value">
			<span id="username">
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="green icon-puzzle-piece icon-large"></i> <b>PHPmailer:</b> <?php echo $phpmailer; ?><br />
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="green icon-puzzle-piece icon-large"></i> <b>PHPimap:</b> <?php echo $phpimap; ?><br />
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="green icon-puzzle-piece icon-large"></i> <b>PHPgettext:</b> <?php echo $phpgettext; ?><br />
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="green icon-puzzle-piece icon-large"></i> <b>Highcharts:</b> <?php echo $highcharts; ?><br />
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="green icon-puzzle-piece icon-large"></i> <b>WOL:</b> <?php echo $wol; ?><br />
			</span>
		</div>
	</div>
	<div class="profile-info-row">
		<div class="profile-info-name">  <?php echo T_('Paramètres PHP'); ?>: </div>
		<div class="profile-info-value">
			<span id="username">
				<?php
				if ($phpinfo[$vphp]['file_uploads'][0]=="On") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>file_uploads</b>: '.T_('Activé').'<br />'; else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-remove-sign icon-large red"></i> <b>file_uploads:</b> '.T_('Désactivé').' <i>('.T_('Le chargement de fichiers sera impossible').')</i><br />';
				if ($phpinfo[$vphp]['memory_limit'][0]>="512") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>memory_limit:</b> '.$phpinfo[$vphp]['memory_limit'][0].'<br />'; else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>memory_limit:</b> '.$phpinfo[$vphp]['memory_limit'][0].' '.T_('Il est conseillé d\'allouer plus de mémoire pour PHP valeur minimum 512M (éditer votre fichier php.ini)').'.<br />';
				if ($phpinfo[$vphp]['upload_max_filesize'][0]!="2M") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>upload_max_filesize:</b> '.$phpinfo[$vphp]['upload_max_filesize'][0].'<br />'; else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>upload_max_filesize: </b>'.$phpinfo[$vphp]['upload_max_filesize'][0].' <i> ('.T_('Il est préconisé d\'avoir une valeur supérieur ou égale à 10Mo, afin d\'attacher des pièces jointes volumineuses').')</i>.<br />';
				if ($phpinfo[$vphp]['post_max_size'][0]!="8M") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>post_max_size:</b> '.$phpinfo[$vphp]['post_max_size'][0].' <br />'; else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>post_max_size: </b>'.$phpinfo[$vphp]['post_max_size'][0].' <i> ('.T_('Il est préconisé d\'avoir une valeur supérieur ou égale à 10Mo, afin d\'attacher des pièces jointes volumineuses').')</i>.<br />';
				if ($phpinfo[$vphp]['max_execution_time'][0]>="240") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>max_execution_time:</b> '.$phpinfo[$vphp]['max_execution_time'][0].'s<br />'; else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>max_execution_time: </b>'.$phpinfo[$vphp]['max_execution_time'][0].'s <i>('.T_('Valeur conseillé 240s, modifier votre php.ini relancer apache et actualiser cette page').'.)</i><br />';
				if ($phpinfo['date']['date.timezone'][0]=="Europe/Paris") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>date.timezone:</b> '.$phpinfo['date']['date.timezone'][0].'<br />'; else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>date.timezone:</b> '.$phpinfo['date']['date.timezone'][0].' <i>('.T_('Il est préconisé de modifier la valeur date.timezone du fichier php.ini, et mettre "Europe/Paris" afin de ne pas avoir de problème d\'horloge').'.)</i><br />';
				?>
			</span>
		</div>
	</div>
	<div class="profile-info-row">
		<div class="profile-info-name">  <?php echo T_('Extensions PHP'); ?>: </div>
		<div class="profile-info-value">
			<span id="username">
				<?php
				$textension = get_loaded_extensions();
				$nblignes = count($textension);
				if(!isset($textension[$i])) $textension[$i] = '';
				for ($i;$i<$nblignes;$i++)
				{
					if ($textension[$i]=='openssl') $openssl="1";
					if ($textension[$i]=='zip') $zip="1";
					if ($textension[$i]=='imap') $imap="1";
					if ($textension[$i]=='ldap') $ldap="1";
					if ($textension[$i]=='pdo_mysql') $pdo_mysql="1";
					if ($textension[$i]=='ftp') $ftp="1";
				}
				if ($pdo_mysql=="1") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>php_pdo_mysql:</b> '.T_('Activée'); else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-remove-sign icon-large red"></i> <b>php_pdo_mysql</b> '.T_('Désactivée, l\'interconnexion de base de données ne pourra être disponible');
				echo "<br />";
				if ($openssl=="1") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>php_openssl:</b> '.T_('Activée'); else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>php_openssl</b> '.T_('Désactivée, si vous utilisé un serveur SMTP sécurisé les mails ne seront pas envoyés. (Installation Linux: apt-get install openssl)').'.';
				echo "<br />";
				if ($ldap=="1") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>php_ldap:</b> '.T_('Activée'); else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>php_ldap</b> '.T_('Désactivée, aucune synchronisation ni authentification via un serveur LDAP ne sera possible (Installation Linux: apt-get install php5-ldap, sous wamp copier libsasl.dll dans apache\bin)').'.';
				echo "<br />";
				if ($zip=="1") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>php_zip:</b> '.T_('Activée'); else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-remove-sign icon-large red"></i> <b>php_zip</b> '.T_('Désactivée, la fonction de mise à jour automatique ne sera pas possible').'.';
				echo "<br />";
				if ($imap=="1") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>php_imap:</b> '.T_('Activée'); else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-warning-sign icon-large orange"></i> <b>php_imap</b> '.T_('Désactivée, la fonction Mail2Ticket ne fonctionnera pas (Installation Linux: apt-get install php5-imap)').'.';
				echo "<br />";
				if ($ftp=="1") echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-ok-sign icon-large green"></i> <b>php_ftp:</b> '.T_('Activée'); else echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-remove-sign icon-large red"></i> <b>php_ftp</b> '.T_('Désactivée, aucune mise à jour du logiciel ne sera possible (dé-commenter la ligne extension=php_ftp votre php.ini)').'.';
				?>
			</span>
		</div>
	</div>
</div>