<?php
################################################################################
# @Name : ./core/asset.php 
# @Description : actions page for assets
# @call : ./asset.php
# @Author : Flox
# @Create : 28/10/2013
# @Update : 03/04/2017
# @Version : 3.1.19
################################################################################

//initialize variable
if(!isset($_POST['close'])) $_POST['close'] = '';
if(!isset($_POST['text'])) $_POST['text'] = '';
if(!isset($_POST['send'])) $_POST['send'] = '';
if(!isset($_POST['action'])) $_POST['action'] = '';
if(!isset($_POST['modify'])) $_POST['modify'] = '';
if(!isset($_POST['quit'])) $_POST['quit'] = '';
if(!isset($_POST['cancel'])) $_POST['cancel'] = '';
if(!isset($_POST['netbios_lan_new'])) $_POST['netbios_lan_new'] = '';
if(!isset($_POST['ip_lan_new'])) $_POST['ip_lan_new'] = '';
if(!isset($_POST['mac_lan_new'])) $_POST['mac_lan_new'] = '';
if(!isset($_POST['netbios_wifi_new'])) $_POST['netbios_wifi_new'] = '';
if(!isset($_POST['ip_wifi_new'])) $_POST['ip_wifi_new'] = '';
if(!isset($_POST['mac_wifi_new'])) $_POST['mac_wifi_new'] = '';
if(!isset($_POST['virtualization'])) $_POST['virtualization'] = '';

if(!isset($_GET['disable'])) $_GET['disable'] = '';
if(!isset($_GET['fromnew'])) $_GET['fromnew'] = '';	
if(!isset($_GET['state'])) $_GET['state'] = '';	
if(!isset($_GET['date_stock'])) $_GET['date_stock'] = '';	
if(!isset($_GET['department'])) $_GET['department'] = '';	
if(!isset($_GET['model'])) $_GET['model'] = '';	
if(!isset($_GET['virtualization'])) $_GET['virtualization'] = '';	
if(!isset($_GET['type'])) $_GET['type'] = '';	
if(!isset($_GET['user'])) $_GET['user'] = '';	
if(!isset($_GET['netbios'])) $_GET['netbios'] = '';	
if(!isset($_GET['ip'])) $_GET['ip'] = '';	
if(!isset($_GET['sn_internal'])) $_GET['sn_internal'] = '';	
if(!isset($_GET['description'])) $_GET['description'] = '';	
if(!isset($_GET['iptoping'])) $_GET['iptoping'] = '';	

if(!isset($error)) $error="0";

//display find and iface modalbox
if( preg_match( '/^findip.*/',$_GET['action'])) include('./asset_findip.php');

if($_GET['action']=='addiface' || $_GET['action']=='editiface') include('./asset_iface.php');

if ($rparameters['debug']==1) {echo "<b><u>DEBUG MODE:</u></b><br />";}

//use stock asset if exist
if($_POST['model']!='' && $_GET['action']=='new')
{
	$query=$db->query("SELECT * FROM tassets WHERE sn_internal=(SELECT MIN(sn_internal) FROM tassets WHERE state=1 AND model=$_POST[model] AND disable=0)");
	$row=$query->fetch();
	$query->closeCursor(); 
	if ($row[0])
	{
		//redirect
		echo "<SCRIPT LANGUAGE='JavaScript'>
					<!--
					function redirect()
					{
					window.location='./index.php?page=asset&id=$row[id]&fromnew=1&$url_get_parameters'
					}
					setTimeout('redirect()');
					-->
			</SCRIPT>";
	}
}

//find next asset number
if($_GET['action']=='new')
{
	$query=$db->query("SELECT MAX(CONVERT(sn_internal, SIGNED INTEGER)) FROM tassets");
	$row_sn_internal=$query->fetch();
	$query->closeCursor(); 
	$query=$db->query("SELECT MAX(id) FROM tassets");
	$row_id=$query->fetch();
	$query->closeCursor(); 
	$_POST['sn_internal'] =$row_sn_internal[0]+1;
	$_GET['id'] =$row_id[0]+1;
	
}

//action delete asset
if (($_GET['action']=="delete") && ($rright['asset_delete']!=0))
{
	//disable asset
	$db->exec('UPDATE tassets SET disable=1 WHERE id=\''.$_GET['id'].'\'');
	//display delete message
	echo '<div class="alert alert-block alert-success"><center><i class="icon-ok green"></i>	'.T_('Équipement supprimé').'.</center></div>';
	//redirect
	echo "<SCRIPT LANGUAGE='JavaScript'>
				<!--
				function redirect()
				{
				window.location='./index.php?page=asset_list&url_get_parameters'
				}
				setTimeout('redirect()',$rparameters[time_display_msg]);
				-->
		</SCRIPT>";
}

//master query
$globalquery = $db->query("SELECT * FROM tassets WHERE id LIKE '$_GET[id]'");
$globalrow=$globalquery->fetch();
$query->closeCursor();

//auto convert state if new asset
if ($globalrow['state']==1 && $_GET['fromnew']==1) {$globalrow['state']=2;}

//action ping this asset
if ($_GET['action']=="ping") 
{

	require('./core/ping.php');
	$time=$rparameters['time_display_msg']+2000;
	//redirect
	echo "<SCRIPT LANGUAGE='JavaScript'>
				<!--
				function redirect()
				{
				window.location='./index.php?page=asset&id=$_GET[id]&$url_get_parameters'
				}
				setTimeout('redirect()',$time);
				-->
		</SCRIPT>";
}

//action wake on lan this asset
if ($_GET['action']=="wol") 
{
	require('./core/wol.php');
	$time=$rparameters['time_display_msg']+2000;
	//redirect
	echo "<SCRIPT LANGUAGE='JavaScript'>
				<!--
				function redirect()
				{
				window.location='./index.php?page=asset&id=$_GET[id]&$url_get_parameters'
				}
				setTimeout('redirect()',$time);
				-->
		</SCRIPT>";
}

//delete selected interface
if($_GET['action']=='delete_iface') {
	//disable iface 
	$db->exec('UPDATE tassets_iface SET disable=1 WHERE id=\''.$_GET['iface'].'\'');
	//display delete message
	echo '<div class="alert alert-block alert-success"><center><i class="icon-ok green"></i>	'.T_('Interface supprimé').'.</center></div>';
	//redirect
	echo "<SCRIPT LANGUAGE='JavaScript'>
				<!--
				function redirect()
				{
				window.location='./index.php?page=asset&id=$_GET[id]&$url_get_parameters'
				}
				setTimeout('redirect()',$rparameters[time_display_msg]);
				-->
		</SCRIPT>";
} 


//convert posted date to SQL format, if yyyy-mm-dd is detected
if($_POST['date_stock'] && !strpos($_POST['date_stock'], "-"))
{
	$_POST['date_stock'] = DateTime::createFromFormat('d/m/Y', $_POST['date_stock']);
	$_POST['date_stock']=$_POST['date_stock']->format('Y-m-d');
}
if($_POST['date_install'] && !strpos($_POST['date_install'], "-"))
{
	$_POST['date_install'] = DateTime::createFromFormat('d/m/Y', $_POST['date_install']);
	$_POST['date_install']=$_POST['date_install']->format('Y-m-d');
}
if($_POST['date_end_warranty'] && !strpos($_POST['date_end_warranty'], "-"))
{
	$_POST['date_end_warranty'] = DateTime::createFromFormat('d/m/Y', $_POST['date_end_warranty']);
	$_POST['date_end_warranty']=$_POST['date_end_warranty']->format('Y-m-d');
}
if($_POST['date_standbye'] && !strpos($_POST['date_standbye'], "-"))
{
	$_POST['date_standbye'] = DateTime::createFromFormat('d/m/Y', $_POST['date_standbye']);
	$_POST['date_standbye']=$_POST['date_standbye']->format('Y-m-d');
}
if($_POST['date_recycle'] && !strpos($_POST['date_recycle'], "-"))
{
	$_POST['date_recycle'] = DateTime::createFromFormat('d/m/Y', $_POST['date_recycle']);
	$_POST['date_recycle']=$_POST['date_recycle']->format('Y-m-d');
}

//update ip send from searchip popup and save on iface
if($_GET['findip'] && $_GET['iface']) {
	
	$db->exec("UPDATE tassets_iface SET ip='$_GET[findip]' WHERE id='$_GET[iface]'");
}

//database inputs if submit
if($_POST['modify']||$_POST['quit']||$_POST['action']) 
{
	//escape special char and secure string before database insert
	$db_netbios=strip_tags($db->quote($_POST['netbios']));
	$db_sn_internal=strip_tags($db->quote($_POST['sn_internal']));
	$db_sn_manufacturer=strip_tags($db->quote($_POST['sn_manufacturer']));
	$db_description=strip_tags($db->quote($_POST['description']));
	$db_sn_indent=strip_tags($db->quote($_POST['sn_indent']));
	$db_socket=strip_tags($db->quote($_POST['socket']));
	$globalrow['sn_internal']=$db->quote($globalrow['sn_internal']);  //avoid database simple quote
	
	//auto insert date if change state on editing ticket
	if ($_GET['action']!='new')
	{
		if ($globalrow['state']!='2' && $_POST['state']=='2') {if (!$_POST['date_install']) {$_POST['date_install']=date('Y-m-d');} }
		if ($globalrow['state']!='3' && $_POST['state']=='3') {$_POST['date_standbye']=date('Y-m-d'); }
		if ($globalrow['state']!='4' && $_POST['state']=='4') {$_POST['date_recycle']=date('Y-m-d'); }
	}

	//check duplicate sn_internal
	$query = $db->query("SELECT * FROM tassets WHERE sn_internal LIKE $db_sn_internal AND sn_internal!='' AND state!='4' AND id!=$_GET[id] AND disable='0'");
	$row=$query->fetch();
	$query->closeCursor();
	if ($row[0]!='' && ($db_sn_internal!=$globalrow['sn_internal'])) {$error=T_('Un autre équipement possède déjà cet identifiant').'. (<a target="_blank" href="./index.php?page=asset&id='.$row['id'].'" >'.T_('Voir sa fiche').'</a>)';} 

	//check duplicate manufacturer
	$query = $db->query("SELECT * FROM tassets WHERE sn_manufacturer LIKE $db_sn_manufacturer AND sn_manufacturer!='' AND state!=4 AND id!=$_GET[id] AND disable=0");
	$row=$query->fetch();
	$query->closeCursor();
	if ($row[0]!='' && ($db_sn_manufacturer!=$globalrow['sn_manufacturer'])) {$error=T_('Un autre équipement possède déjà ce numéro de série fabriquant').' (<a target="_blank" href="./index.php?page=asset&id='.$row['id'].'" >'.T_('Voir sa fiche').'</a>).';} 
	
	//iface existing treatment
	$query = $db->query("SELECT * FROM tassets_iface WHERE asset_id='$_GET[id]' AND disable='0'");
	while ($row = $query->fetch()) 
	{
		//init post values
		if(!isset($iface_netbios)) $iface_netbios = '';
		if(!isset($iface_ip)) $iface_ip = '';
		if(!isset($iface_mac)) $iface_mac = '';
		
		if(!isset($_POST[$iface_netbios])) $_POST[$iface_netbios] = '';
		if(!isset($_POST[$iface_ip])) $_POST[$iface_ip] = '';
		if(!isset($_POST[$iface_mac])) $_POST[$iface_mac] = '';
		
		//get date from iface inputs
		$iface_netbios='netbios_'.$row['id'];
		$iface_netbios=$_POST[$iface_netbios];
		$iface_ip='ip_'.$row['id'];
		$iface_ip=$_POST[$iface_ip];
		$iface_mac='mac_'.$row['id'];
		$iface_mac=$_POST[$iface_mac];
		
		//check duplicate ip
		$query2 = $db->query("
		SELECT tassets_iface.* 
		FROM tassets_iface
		INNER JOIN tassets ON tassets.id=tassets_iface.asset_id
		INNER JOIN tassets_state ON tassets_state.id=tassets.state
		WHERE 
		tassets_state.block_ip_search=1 AND
		tassets_iface.ip='$iface_ip' AND
		tassets_iface.ip!='' AND
		tassets_iface.asset_id!='$globalrow[id]' AND
		tassets_iface.disable='0' AND
		tassets.disable='0'
		");
		$row2=$query2->fetch();
		$query2->closeCursor();
		if ($row2[0]!='') {$error=T_('Un autre équipement possède déjà cette l\'adresse IP').'. (<a target="_blank" href="./index.php?page=asset&id='.$row2['asset_id'].'" >'.T_('Voir sa fiche').'</a>)';} 
		
		//check duplicate mac
		$query2 = $db->query("SELECT * FROM tassets_iface WHERE mac='$iface_mac' AND mac!='' AND asset_id!='$globalrow[id]' AND disable='0'");
		$row2=$query2->fetch();
		$query2->closeCursor();
		if ($row2[0]!='') {$error=T_('Un autre équipement possède déjà cette adresse MAC').'. (<a target="_blank" href="./index.php?page=asset&id='.$row2['asset_id'].'" >'.T_('Voir sa fiche').'</a>)';} 
		
		//control number of digit of MAC address
		if ((strlen($iface_mac)!=12) && $iface_mac!='') {$error=T_('Les adresses MAC doivent contenir 12 caractères').' ('.strlen($iface_mac).' '.T_('caractères détectés').').';} 
		
		//control number of digit of IP address
		if ((strlen($iface_ip)<7) && $iface_ip!='') {$error=T_('Les adresses IP doivent contenir au moins 7 caractères').' ('.strlen($iface_ip).' '.T_('caractères détectés').').';} 
		
		//escape special char and secure string before database update
		$iface_netbios=strip_tags($db->quote($iface_netbios));
		$iface_ip=strip_tags($db->quote($iface_ip));
		$iface_mac=strip_tags($db->quote($iface_mac));
		
		//update tassets_iface table
		if($error=='0')
		{
			$query2 = "UPDATE tassets_iface SET netbios=$iface_netbios,ip=$iface_ip,mac=$iface_mac WHERE id LIKE '$row[id]'";
			if ($rparameters['debug']==1) {echo "QRY IFACE=$query2<br />";}
			$db->exec($query2);
		}	
	}
	$query->closeCursor();
	
	//check fields for new asset
	if($error=='0')
	{
		//find asset id to add iface
		if (!isset($globalrow['id'])) {
			$query = $db->query("SELECT MAX(id) FROM tassets WHERE disable='0'");
			$asset_id=$query->fetch();
			$query->closeCursor();
			$asset_id=$asset_id[0]+1;
		} else {$asset_id=$globalrow['id'];}
		
		if(($_POST['netbios_lan_new'] || $_POST['ip_lan_new'] || $_POST['mac_lan_new']) && $error=='0')
		{
			//escape special char and secure string before database insert
			$db_netbios_lan_new=strip_tags($db->quote($_POST['netbios_lan_new']));
			$db_ip_lan_new=strip_tags($db->quote($_POST['ip_lan_new']));
			$db_mac_lan_new=strip_tags($db->quote($_POST['mac_lan_new']));
			
			//check fields for new asset LAN IP
			$query = $db->query("
			SELECT tassets_iface.* 
			FROM tassets_iface
			INNER JOIN tassets ON tassets.id=tassets_iface.asset_id
			INNER JOIN tassets_state ON tassets_state.id=tassets.state
			WHERE 
			tassets_state.block_ip_search=1 AND
			tassets_iface.ip=$db_ip_lan_new AND
			tassets_iface.ip!='' AND
			tassets_iface.disable='0' AND
			tassets.disable='0'
			");
			$row=$query->fetch();
			$query->closeCursor();
			if ($row[0]!='') {$error=T_('Un autre équipement possède déjà  l\'adresse IP').': '.$db_ip_lan_new.'. (<a target="_blank" href="./index.php?page=asset&id='.$row['asset_id'].'" >'.T_('Voir sa fiche').'</a>)';} 
			
			//check fields for new asset LAN MAC
			$query = $db->query("SELECT * FROM tassets_iface WHERE mac=$db_mac_lan_new AND mac!='' AND disable='0'");
			$row=$query->fetch();
			$query->closeCursor();
			if ($row[0]!='') {$error=T_('Un autre équipement possède déjà  l\'adresse MAC').': '.$db_mac_lan_new.'. (<a target="_blank" href="./index.php?page=asset&id='.$row['asset_id'].'" >'.T_('Voir sa fiche').'</a>)';} 
			
			//control number of digit of LAN MAC address
			if ((strlen($_POST['mac_lan_new'])!=12) && $_POST['mac_lan_new']!='') {$error=T_('Les adresses MAC doivent contenir 12 caractères').' ('.strlen($_POST['mac_lan_new']).' '.T_('caractères détectés').').';} 
		
			//control number of digit of LAN IP address
			if ((strlen($_POST['ip_lan_new'])<7) && $_POST['ip_lan_new']!='') {$error=T_('Les adresses IP doivent contenir au moins 7 caractères').' ('.strlen($_POST['ip_lan_new']).' '.T_('caractères détectés').').';} 
		
		}
		if(($_POST['netbios_wifi_new'] || $_POST['ip_wifi_new'] || $_POST['mac_wifi_new']) && $error=='0')
		{
			//escape special char and secure string before database insert
			$db_netbios_wifi_new=strip_tags($db->quote($_POST['netbios_wifi_new']));
			$db_ip_wifi_new=strip_tags($db->quote($_POST['ip_wifi_new']));
			$db_mac_wifi_new=strip_tags($db->quote($_POST['mac_wifi_new']));
			
			//check fields for new asset WIFI IP
			$query = $db->query("
			SELECT tassets_iface.* 
			FROM tassets_iface
			INNER JOIN tassets ON tassets.id=tassets_iface.asset_id
			INNER JOIN tassets_state ON tassets_state.id=tassets.state
			WHERE 
			tassets_state.block_ip_search=1 AND
			tassets_iface.ip=$db_ip_wifi_new AND
			tassets_iface.ip!='' AND
			tassets_iface.disable='0' AND
			tassets.disable='0'
			");
			$row=$query->fetch();
			$query->closeCursor();
			if ($row[0]!='') {$error=T_('Un autre équipement possède déjà  l\'adresse IP').': '.$db_ip_wifi_new.'. (<a target="_blank" href="./index.php?page=asset&id='.$row['asset_id'].'" >'.T_('Voir sa fiche').'</a>)';} 
			
			//check fields for new asset WIFI MAC
			$query = $db->query("SELECT * FROM tassets_iface WHERE mac=$db_mac_wifi_new AND mac!='' AND disable='0'");
			$row=$query->fetch();
			$query->closeCursor();
			if ($row[0]!='') {$error=T_('Un autre équipement possède déjà  l\'adresse MAC').': '.$db_mac_wifi_new.'. (<a target="_blank" href="./index.php?page=asset&id='.$row['asset_id'].'" >'.T_('Voir sa fiche').'</a>)';} 
			
			//control number of digit of WIFI MAC address
			if ((strlen($_POST['mac_wifi_new'])!=12) && $_POST['mac_wifi_new']!='') {$error=T_('Les adresses MAC doivent contenir 12 caractères').' ('.strlen($_POST['mac_wifi_new']).' '.T_('caractères détectés').').';} 
		
			//control number of digit of WIFI IP address
			if ((strlen($_POST['ip_wifi_new'])<7) && $_POST['ip_wifi_new']!='') {$error=T_('Les adresses IP doivent contenir au moins 7 caractères').' ('.strlen($_POST['ip_wifi_new']).' '.T_('caractères détectés').').';} 
		}
	}
	
	//SQL insert for new asset
	if(($_POST['netbios_lan_new'] || $_POST['ip_lan_new'] || $_POST['mac_lan_new']) && $error=='0')
	{
		$query = "INSERT INTO tassets_iface (role_id,asset_id,netbios,ip,mac,disable) VALUES ('1',$asset_id,$db_netbios_lan_new,$db_ip_lan_new,$db_mac_lan_new,'0')";
		if ($rparameters['debug']==1) {echo "QRY NEW LAN IFACE= $query<br />";}
		$db->exec($query);
	}
	if(($_POST['netbios_wifi_new'] || $_POST['ip_wifi_new'] || $_POST['mac_wifi_new']) && $error=='0')
	{
		$query = "INSERT INTO tassets_iface (role_id,asset_id,netbios,ip,mac,disable) VALUES ('2',$asset_id,$db_netbios_wifi_new,$db_ip_wifi_new,$db_mac_wifi_new,'0')";
		if ($rparameters['debug']==1) {echo "QRY NEW WIFI IFACE= $query<br />";}
		$db->exec($query);
	}
	
	//SQL insert and update in tassets table
	if (($_GET['action']=='new') && ($error=="0"))
	{	
		//insert asset
		$db->exec("
		INSERT INTO tassets (
		sn_internal,
		sn_manufacturer,
		sn_indent,
		netbios,
		description,
		type,
		manufacturer,
		model,
		virtualization,
		user,
		state,
		department,
		date_install,
		date_end_warranty,
		date_stock,
		date_standbye,
		date_recycle,
		location,
		socket,
		technician,
		maintenance,
		disable
		) VALUES (
		$db_sn_internal,
		$db_sn_manufacturer,
		$db_sn_indent,
		$db_netbios,
		$db_description,
		'$_POST[type]',
		'$_POST[manufacturer]',
		'$_POST[model]',
		'$_POST[virtualization]',
		'$_POST[user]',
		'$_POST[state]',
		'$_POST[department]',
		'$_POST[date_install]',
		'$_POST[date_end_warranty]',
		'$_POST[date_stock]',
		'$_POST[date_standbye]',
		'$_POST[date_recycle]',
		'$_POST[location]',
		$db_socket,
		'$_POST[technician]',
		'$_POST[maintenance]',
		'0'
		)");
	    
	} elseif ($error=="0")  {
		//update asset
		$query = "UPDATE tassets SET 
		sn_internal=$db_sn_internal,
		sn_manufacturer=$db_sn_manufacturer,
		sn_indent=$db_sn_indent,
		netbios=$db_netbios,
		description=$db_description,
		type='$_POST[type]',
		manufacturer='$_POST[manufacturer]',
		model='$_POST[model]',
		virtualization='$_POST[virtualization]',
		user='$_POST[user]',
		state='$_POST[state]',
		department='$_POST[department]',
		date_install='$_POST[date_install]',
		date_end_warranty='$_POST[date_end_warranty]',
		date_stock='$_POST[date_stock]',
		date_standbye='$_POST[date_standbye]',
		date_recycle='$_POST[date_recycle]',
		location='$_POST[location]',
		socket=$db_socket,
		technician='$_POST[technician]',
		maintenance='$_POST[maintenance]',
		disable='$_GET[disable]'
		WHERE
		id LIKE '$_GET[id]'";
		if ($rparameters['debug']==1) {echo "QRY ASSET=$query<br />";}
		$db->exec($query);	
	}
	
	//display message
	if($error=="0")
	{
	    echo '<div class="alert alert-block alert-success"><center><i class="icon-ok green"></i>	'.T_('Équipement sauvegardé').'. </center></div>';
	} else {
	    //new page asset redirect
        echo '<div class="alert alert-danger"><i class="icon-remove"></i> <strong>'.T_('Erreur').':</strong> '.$error.' </div>';
	}
	
	//switch state for redirect new asset 
	if ($_GET['state']=='') {$_GET['state']='2';}
	
	//redirect to asset list with save & quit button
	if ($_POST['quit'] && ($error=="0"))
	{
		//redirect
		$www = "./index.php?page=asset_list&$url_get_parameters";
		echo '<script language="Javascript">
		<!--
		document.location.replace("'.$www.'");
		-->
		</script>';
	}
	
    if($error=="0")
    {
	//global redirect on asset edit page
    echo "<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function redirect()
			{
		    	window.location='./index.php?page=asset&action=$_POST[action]&id=$_GET[id]&$url_get_parameters'
			}
			setTimeout('redirect()',$rparameters[time_display_msg]);
			-->
		</SCRIPT>";
    }		
}
//redirect to asset list with cancel button
if($_POST['cancel']) 
{
echo '<div class="alert alert-block alert-danger"><center><i class="icon-remove red"></i>	'.T_('Annulation pas de modification').'.</center></div>';
echo "<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function redirect()
			{
		    	window.location='./index.php?page=asset_list&$url_get_parameters'
			}
			setTimeout('redirect()',$rparameters[time_display_msg]);
			-->
			</SCRIPT>";
}
?>