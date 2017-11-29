<?php
################################################################################
# @Name : parameters.php
# @Description : admin parameters
# @Call : /admin.php
# @Parameters : 
# @Author : Flox
# @Create : 12/01/2011
# @Update : 02/05/2017
# @Version : 3.1.20
################################################################################

//initialize variables 
if(!isset($extensionFichier)) $extensionFichier = '';
if(!isset($id_)) $id_ = '';
if(!isset($logo)) $logo = '';
if(!isset($filename)) $filename = '';
if(!isset($file_rename)) $file_rename = '';
if(!isset($mail_auto)) $mail_auto = '';
if(!isset($user_advanced)) $user_advanced= '';
if(!isset($mail_auth)) $mail_auth= '';
if(!isset($mail_secure)) $mail_secure= '';
if(!isset($nomorigine)) $nomorigine = '';
if(!isset($action)) $action = '';
if(!isset($_POST['submit_general'])) $_POST['submit_general'] = '';
if(!isset($_POST['ticket_type'])) $_POST['ticket_type'] = '';
if(!isset($_POST['ticket_increment_number'])) $_POST['ticket_increment_number'] = '';
if(!isset($_POST['submit_connector'])) $_POST['submit_connector'] = '';
if(!isset($_POST['submit_function'])) $_POST['submit_function'] = '';
if(!isset($_POST['mail_username'])) $_POST['mail_username'] = '';
if(!isset($_POST['mail_password'])) $_POST['mail_password'] = '';
if(!isset($_POST['mail_secure'])) $_POST['mail_secure'] = '';
if(!isset($_POST['user_advanced'])) $_POST['user_advanced'] = '';
if(!isset($_POST['user_register'])) $_POST['user_register'] = '';
if(!isset($_POST['user_limit_ticket'])) $_POST['user_limit_ticket'] = '';
if(!isset($_POST['company_limit_ticket'])) $_POST['company_limit_ticket'] = '';
if(!isset($_POST['user_company_view'])) $_POST['user_company_view'] = '';
if(!isset($_POST['user_agency'])) $_POST['user_agency'] = '';
if(!isset($_POST['user_limit_service'])) $_POST['user_limit_service'] = '';
if(!isset($_POST['mail'])) $_POST['mail']= '';
if(!isset($_POST['mail_auth'])) $_POST['mail_auth']= '';
if(!isset($_POST['mail_auto'])) $_POST['mail_auto']= '';
if(!isset($_POST['mail_auto_tech_modify'])) $_POST['mail_auto_tech_modify']= '';
if(!isset($_POST['mail_auto_user_modify'])) $_POST['mail_auto_user_modify']= '';
if(!isset($_POST['mail_newticket'])) $_POST['mail_newticket']= '';
if(!isset($_POST['mail_newticket_address'])) $_POST['mail_newticket_address']= '';
if(!isset($_POST['mail_link'])) $_POST['mail_link']= '';
if(!isset($_POST['mail_smtp'])) $_POST['mail_smtp']= '';
if(!isset($_POST['mail_smtp_class'])) $_POST['mail_smtp_class']= '';
if(!isset($_POST['mail_port'])) $_POST['mail_port']= '';
if(!isset($_POST['mail_ssl_check'])) $_POST['mail_ssl_check']= '';
if(!isset($_POST['mail_order'])) $_POST['mail_order']= '';
if(!isset($_POST['ldap'])) $_POST['ldap']= '';
if(!isset($_POST['ldap_auth'])) $_POST['ldap_auth']= '';
if(!isset($_POST['ldap_type'])) $_POST['ldap_type']= '';
if(!isset($_POST['ldap_service'])) $_POST['ldap_service']= '';
if(!isset($_POST['ldap_service_url'])) $_POST['ldap_service_url']= '';
if(!isset($_POST['ldap_agency'])) $_POST['ldap_agency']= '';
if(!isset($_POST['ldap_agency_url'])) $_POST['ldap_agency_url']= '';
if(!isset($_POST['from_agency'])) $_POST['from_agency']= '';
if(!isset($_POST['dest_agency'])) $_POST['dest_agency']= '';
if(!isset($_POST['ldap_server'])) $_POST['ldap_server']= '';
if(!isset($_POST['ldap_server_url'])) $_POST['ldap_server_url']= '';
if(!isset($_POST['ldap_port'])) $_POST['ldap_port']= '';
if(!isset($_POST['ldap_domain'])) $_POST['ldap_domain']= '';
if(!isset($_POST['ldap_url'])) $_POST['ldap_url']= '';
if(!isset($_POST['ldap_user'])) $_POST['ldap_user']= '';
if(!isset($_POST['ldap_password'])) $_POST['ldap_password']= '';
if(!isset($_POST['test_ldap'])) $_POST['test_ldap']= '';
if(!isset($_POST['planning'])) $_POST['planning']= '';
if(!isset($_POST['debug'])) $_POST['debug']= '';
if(!isset($_POST['notify'])) $_POST['notify']= '';
if(!isset($_POST['imap'])) $_POST['imap']= '';
if(!isset($_POST['imap_server'])) $_POST['imap_server']= '';
if(!isset($_POST['imap_port'])) $_POST['imap_port']= '';
if(!isset($_POST['imap_user'])) $_POST['imap_user']= '';
if(!isset($_POST['imap_password'])) $_POST['imap_password']= '';
if(!isset($_POST['imap_blacklist'])) $_POST['imap_blacklist']= '';
if(!isset($_POST['imap_post_treatment'])) $_POST['imap_post_treatment']= '';
if(!isset($_POST['imap_post_treatment_folder'])) $_POST['imap_post_treatment_folder']= '';
if(!isset($_POST['imap_mailbox_service'])) $_POST['imap_mailbox_service']= '';
if(!isset($_POST['mailbox_service'])) $_POST['mailbox_service']= '';
if(!isset($_POST['mailbox_service_id'])) $_POST['mailbox_service_id']= '';
if(!isset($_POST['inbox'])) $_POST['inbox']= '';
if(!isset($_POST['procedure'])) $_POST['procedure']= '';
if(!isset($_POST['survey'])) $_POST['survey']= '';
if(!isset($_POST['survey_mail_text'])) $_POST['survey_mail_text']= '';
if(!isset($_POST['survey_ticket_state'])) $_POST['survey_ticket_state']= '';
if(!isset($_POST['survey_auto_close_ticket'])) $_POST['survey_auto_close_ticket']= '';
if(!isset($_POST['ticket_places'])) $_POST['ticket_places']= '';
if(!isset($_POST['availability'])) $_POST['availability']= '';
if(!isset($_POST['asset'])) $_POST['asset']= '';
if(!isset($_POST['asset_ip'])) $_POST['asset_ip']= '';
if(!isset($_POST['asset_warranty'])) $_POST['asset_warranty']= '';
if(!isset($_POST['availability_all_cat'])) $_POST['availability_all_cat']= '';
if(!isset($_POST['category'])) $_POST['category']= '';
if(!isset($_POST['depcategory'])) $_POST['depcategory']= '';
if(!isset($_POST['meta_state'])) $_POST['meta_state']= '';
if(!isset($_POST['availability_dep'])) $_POST['availability_dep']= '';
if(!isset($_POST['availability_condition_type'])) $_POST['availability_condition_type']= $rparameters['availability_condition_type'];
if(!isset($_POST['availability_condition_value'])) $_POST['availability_condition_value']= $rparameters['availability_condition_type'];
if(!isset($_GET['action'])) $_GET['action']= '';
if(!isset($_GET['tab'])) $_GET['tab']= '';
if(!isset($_GET['ldaptest'])) $_GET['ldaptest']= '';
if(!isset($_GET['deleteavailability'])) $_GET['deleteavailability']= '';
if(!isset($_GET['deleteavailabilitydep'])) $_GET['deleteavailabilitydep']= '';
if(!isset($_GET['delete_imap_service'])) $_GET['delete_imap_service']= '';
if(!isset($_GET['deletequestion'])) $_GET['deletequestion']= '';
if(!isset($_FILES['logo']['name'])) $_FILES['logo']['name'] = '';
if(!isset($_FILES['asset_import']['name'])) $_FILES['asset_import']['name'] = '';

//delete logo file
if($_GET['action']=="deletelogo")
{
	$db->exec("UPDATE tparameters SET logo=''");
	$www = "./index.php?page=admin&subpage=parameters";
	echo '<script language="Javascript">
	<!--
	document.location.replace("'.$www.'");
	// -->
	</script>'; 
}
//generate token for dump survey
if($rparameters['survey']==1)
{
	$token=uniqid(); 
	$db->exec("DELETE FROM ttoken WHERE action='export_survey'");
	$db->exec("INSERT INTO ttoken (token,action) VALUES ('$token','export_survey')");
}
	
if($_POST['submit_general'])
{
	//modify ticket increment number if specify
	if ($_POST['ticket_increment_number'])
	{
		$db->exec("ALTER TABLE `tincidents` auto_increment = $_POST[ticket_increment_number];");
	}
	
	//upload logo file
	if($_FILES['logo']['name'])
	{
	    $filename = $_FILES['logo']['name'];
		//change special character in filename
		$a = array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'œ', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'š', 'ž', "'", " ", "/", "%", "?", ":", "!", "’", ",",">","<");
		$b = array("a", "a", "a", "a", "a", "a", "ae", "c", "e", "e", "e", "e", "i", "i", "i", "i", "n", "o", "o", "o", "o", "o", "o", "oe", "u", "u", "u", "u", "y", "y", "s", "z", "-", "-", "-", "-", "", "-", "", "-", "-", "", "");
		$file_rename = str_replace($a,$b,$_FILES['logo']['name']);
	    //secure upload excluding certain extension files
	    $whitelist =  array('png','jpg','jpeg' ,'gif' ,'bmp');
		//black list exclusion for extension
		$blacklist =  array('php', 'php1', 'php2','php3' ,'php4' ,'php5', 'php6', 'php7', 'php8', 'php9', 'php10', 'js', 'htm', 'html', 'phtml', 'exe', 'jsp' ,'pht', 'shtml', 'asa', 'cer', 'asax', 'swf', 'xap', 'phphp', 'inc', 'htaccess', 'sh', 'py', 'pl', 'jsp', 'asp', 'cgi', 'json', 'svn', 'git', 'lock', 'yaml', 'com', 'bat', 'ps1', 'cmd', 'vb', 'hta', 'reg', 'ade', 'adp', 'app', 'asp', 'bas', 'bat', 'cer', 'chm', 'cmd', 'com', 'cpl', 'crt', 'csh', 'der', 'exe', 'fxp', 'gadget', 'hlp', 'hta', 'inf', 'ins', 'isp', 'its', 'js', 'jse', 'ksh', 'lnk', 'mad', 'maf', 'mag', 'mam', 'maq', 'mar', 'mas', 'mat', 'mau', 'mav', 'maw', 'mda', 'mdb', 'mde', 'mdt', 'mdw', 'mdz', 'msc', 'msh', 'msh1', 'msh2', 'mshxml', 'msh1xml', 'msh2xml', 'msi', 'msp', 'mst', 'ops', 'pcd', 'pif', 'plg', 'prf', 'prg', 'pst', 'reg', 'scf', 'scr', 'sct', 'shb', 'shs', 'ps1', 'ps1xml', 'ps2', 'ps2xml', 'psc1', 'psc2', 'tmp', 'url', 'vb', 'vbe', 'vbs', 'vsmacros', 'vsw', 'ws', 'wsc', 'wsf', 'wsh', 'xnk');
		//default value
		$blacklistedfile=0;
        $ext=explode('.',$filename);
		foreach ($ext as &$value) {
			$value=strtolower($value);
			if(in_array($value,$blacklist) ) {
				$blacklistedfile=1;
			} 
		}
        if(in_array(end($ext),$whitelist) && $blacklistedfile==0 ) {
            $repertoireDestination = "./upload/logo/";
    		if (move_uploaded_file($_FILES['logo']['tmp_name'], $repertoireDestination.$file_rename)   ) 
    		{
    		} else {
    		echo T_('Erreur de transfert vérifier le chemin').' '.$repertoireDestination;
    		}
        } else {
            echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Blocage de sécurité').':</strong> '.T_('Fichier interdit').'.<br></div>';
            $file_rename='logo.png';
        }
	} else {$file_rename=$rparameters['logo'];}

	//escape special char and secure string before database insert
	$_POST['company']=strip_tags($db->quote($_POST['company']));
	$_POST['mail_from_name']=strip_tags($db->quote($_POST['mail_from_name']));
	$_POST['mail_txt']=$db->quote($_POST['mail_txt']); 
	$_POST['mail_txt']=str_replace('<script>','',$_POST['mail_txt']);
	$_POST['mail_txt']=str_replace('</script>','',$_POST['mail_txt']);
	$_POST['server_url']=strip_tags($db->quote($_POST['server_url']));
	$_POST['mail_cc']=strip_tags($db->quote($_POST['mail_cc']));
	$_POST['mail_from_adr']=strip_tags($db->quote($_POST['mail_from_adr']));
	$_POST['mail_color_title']=strip_tags($db->quote($_POST['mail_color_title']));
	$_POST['mail_color_bg']=strip_tags($db->quote($_POST['mail_color_bg']));
	$_POST['mail_color_text']=strip_tags($db->quote($_POST['mail_color_text']));
	
	//update general tab
	$query = "UPDATE tparameters SET 
	company=$_POST[company],
	server_url=$_POST[server_url],
	maxline='$_POST[maxline]',
	mail_txt=$_POST[mail_txt],
	mail_cc=$_POST[mail_cc],
	mail_from_name=$_POST[mail_from_name],
	mail_from_adr=$_POST[mail_from_adr],
	mail_color_title=$_POST[mail_color_title],
	mail_color_bg=$_POST[mail_color_bg],
	mail_color_text=$_POST[mail_color_text],
	mail_link='$_POST[mail_link]',
	mail_order='$_POST[mail_order]',
	logo='$file_rename',
	time_display_msg='$_POST[time_display_msg]',
	auto_refresh='$_POST[auto_refresh]',
	notify='$_POST[notify]',
	user_advanced='$_POST[user_advanced]',
	user_register='$_POST[user_register]',
	user_agency='$_POST[user_agency]',
	user_limit_service='$_POST[user_limit_service]',
	company_limit_ticket='$_POST[company_limit_ticket]',
	user_limit_ticket='$_POST[user_limit_ticket]',
	user_company_view='$_POST[user_company_view]',
	mail_auto='$_POST[mail_auto]',
	mail_auto_tech_modify='$_POST[mail_auto_tech_modify]',
	mail_auto_user_modify='$_POST[mail_auto_user_modify]',
	mail_newticket='$_POST[mail_newticket]',
	mail_newticket_address='$_POST[mail_newticket_address]',
	debug='$_POST[debug]',
	`order`='$_POST[order]',
	`ticket_places`='$_POST[ticket_places]',
	`ticket_type`='$_POST[ticket_type]',
	`meta_state`='$_POST[meta_state]'
	WHERE
	id='1'
	";
	$db->exec($query);
	//web redirect
	$www = "./index.php?page=admin&subpage=parameters&tab=general";
		echo '<script language="Javascript">
		<!--
		document.location.replace("'.$www.'");
		// -->
		</script>'; 
}
if($_POST['submit_connector'] || $_POST['test_ldap'])
{
	//escape special char and secure string before database insert
	$_POST['mail_smtp']=strip_tags($db->quote($_POST['mail_smtp']));
	$_POST['mail_username']=strip_tags($db->quote($_POST['mail_username']));
	$_POST['ldap_server']=strip_tags($db->quote($_POST['ldap_server']));
	$_POST['ldap_user']=strip_tags($db->quote($_POST['ldap_user']));
	$_POST['ldap_domain']=strip_tags($db->quote($_POST['ldap_domain']));
	$_POST['ldap_url']=strip_tags($db->quote($_POST['ldap_url']));
	$_POST['imap_server']=strip_tags($db->quote($_POST['imap_server']));
	$_POST['imap_user']=strip_tags($db->quote($_POST['imap_user']));
	$_POST['imap_blacklist']=strip_tags($db->quote($_POST['imap_blacklist']));
	$_POST['ldap_service_url']=strip_tags($db->quote($_POST['ldap_service_url']));
	$_POST['ldap_agency_url']=strip_tags($db->quote($_POST['ldap_agency_url']));
	
	//update connector tab
	$query = "UPDATE tparameters SET 
	mail='$_POST[mail]',
	mail_smtp=$_POST[mail_smtp],
	mail_smtp_class='$_POST[mail_smtp_class]',
	mail_port='$_POST[mail_port]',
	mail_ssl_check='$_POST[mail_ssl_check]',
	mail_secure='$_POST[mail_secure]',
	mail_auth='$_POST[mail_auth]',
	mail_username=$_POST[mail_username],
	mail_password='$_POST[mail_password]',
	ldap='$_POST[ldap]',
	ldap_auth='$_POST[ldap_auth]',
	ldap_type='$_POST[ldap_type]',
	ldap_service='$_POST[ldap_service]',
	ldap_service_url=$_POST[ldap_service_url],
	ldap_agency='$_POST[ldap_agency]',
	ldap_agency_url=$_POST[ldap_agency_url],
	ldap_server=$_POST[ldap_server],
	ldap_port='$_POST[ldap_port]',
	ldap_user=$_POST[ldap_user],
	ldap_password='$_POST[ldap_password]',
	ldap_domain=$_POST[ldap_domain],
	ldap_url=$_POST[ldap_url],
	imap='$_POST[imap]',
	imap_server=$_POST[imap_server],
	imap_port='$_POST[imap_port]',
	imap_user=$_POST[imap_user],
	imap_password='$_POST[imap_password]',
	imap_blacklist=$_POST[imap_blacklist],
	imap_post_treatment='$_POST[imap_post_treatment]',
	imap_post_treatment_folder='$_POST[imap_post_treatment_folder]',
	imap_mailbox_service='$_POST[imap_mailbox_service]',
	imap_inbox='$_POST[inbox]'
	WHERE
	id='1'
	";
	$db->exec($query);
	
	//move ticket from agency to another if detected
	if ($rparameters['user_agency']==1 && $_POST['from_agency'] && $_POST['dest_agency'])
	{
		$db->exec("UPDATE tincidents SET u_agency='$_POST[dest_agency]' WHERE u_agency='$_POST[from_agency]'");
	}
	
	//update imap multi mailbox service parameters
	if ($rparameters['imap_mailbox_service']==1)
	{
		//add new association
		if($_POST['mailbox_service'] && $_POST['mailbox_password'] && $_POST['mailbox_service_id'])
		{
			//escape special char and secure string before database insert
			$_POST['mailbox_service']=strip_tags($db->quote($_POST['mailbox_service']));
			$db->exec("INSERT INTO tparameters_imap_multi_mailbox (mail,password,service_id) VALUES ($_POST[mailbox_service],'$_POST[mailbox_password]','$_POST[mailbox_service_id]')");
		}
	}
	
	//web redirect
	$www = './index.php?page=admin&subpage=parameters&tab=connector&ldaptest='.$_POST['test_ldap'].'';
	echo '<script language="Javascript">
	<!--
	document.location.replace("'.$www.'");
	// -->
	</script>'; 

}
if($_POST['submit_function'])
{
	//upload assets file
	if($_FILES['asset_import']['name'])
	{
		//create asset folder if not exist
		if (!file_exists('./upload/asset')) {
			mkdir('./upload/asset', 0777, true);
		}
		
	    $filename = $_FILES['asset_import']['name'];
		//change special character in filename
		$a = array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'œ', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'š', 'ž', "'", " ", "/", "%", "?", ":", "!", "’", ",",">","<");
		$b = array("a", "a", "a", "a", "a", "a", "ae", "c", "e", "e", "e", "e", "i", "i", "i", "i", "n", "o", "o", "o", "o", "o", "o", "oe", "u", "u", "u", "u", "y", "y", "s", "z", "-", "-", "-", "-", "", "-", "", "-", "-", "", "");
		$file_rename = str_replace($a,$b,$_FILES['asset_import']['name']);
	    //secure upload excluding certain extension files
	    $whitelist =  array('csv');
		//black list exclusion for extension
		$blacklist =  array('php', 'php1', 'php2','php3' ,'php4' ,'php5', 'php6', 'php7', 'php8', 'php9', 'php10', 'js', 'htm', 'html', 'phtml', 'exe', 'jsp' ,'pht', 'shtml', 'asa', 'cer', 'asax', 'swf', 'xap', 'phphp', 'inc', 'htaccess', 'sh', 'py', 'pl', 'jsp', 'asp', 'cgi', 'json', 'svn', 'git', 'lock', 'yaml', 'com', 'bat', 'ps1', 'cmd', 'vb', 'hta', 'reg', 'ade', 'adp', 'app', 'asp', 'bas', 'bat', 'cer', 'chm', 'cmd', 'com', 'cpl', 'crt', 'csh', 'der', 'exe', 'fxp', 'gadget', 'hlp', 'hta', 'inf', 'ins', 'isp', 'its', 'js', 'jse', 'ksh', 'lnk', 'mad', 'maf', 'mag', 'mam', 'maq', 'mar', 'mas', 'mat', 'mau', 'mav', 'maw', 'mda', 'mdb', 'mde', 'mdt', 'mdw', 'mdz', 'msc', 'msh', 'msh1', 'msh2', 'mshxml', 'msh1xml', 'msh2xml', 'msi', 'msp', 'mst', 'ops', 'pcd', 'pif', 'plg', 'prf', 'prg', 'pst', 'reg', 'scf', 'scr', 'sct', 'shb', 'shs', 'ps1', 'ps1xml', 'ps2', 'ps2xml', 'psc1', 'psc2', 'tmp', 'url', 'vb', 'vbe', 'vbs', 'vsmacros', 'vsw', 'ws', 'wsc', 'wsf', 'wsh', 'xnk');
		//default value
		$blacklistedfile=0;
        $ext=explode('.',$filename);
		foreach ($ext as &$value) {
			$value=strtolower($value);
			if(in_array($value,$blacklist) ) {
				$blacklistedfile=1;
			} 
		}
        if(in_array(end($ext),$whitelist) && $blacklistedfile==0 ) {
            $dest_folder = "./upload/asset/";
    		if (move_uploaded_file($_FILES['asset_import']['tmp_name'], $dest_folder.$file_rename)) 
    		{
				//launch import treatment
				require('./core/import_assets.php');
    		} else {
			echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Erreur').':</strong> '.T_('Erreur de transfert vérifier le chemin').' ('.$dest_folder.')<br></div>';
    		}
        } else {
            echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Blocage de sécurité').':</strong> '.T_('Fichier interdit').'.<br></div>';
        }
	}
	
	//action on survey questions
	if ($rparameters['survey']==1)
	{
		//update current question
		$query = $db->query("SELECT id FROM `tsurvey_questions` WHERE disable='0'");
		while ($row=$query->fetch())
		{
			//define var
			if(!isset($_POST['survey_question_select_1_'.$row['id']])) $_POST['survey_question_select_1_'.$row['id']]= '';
			if(!isset($_POST['survey_question_select_2_'.$row['id']])) $_POST['survey_question_select_2_'.$row['id']]= '';
			if(!isset($_POST['survey_question_select_3_'.$row['id']])) $_POST['survey_question_select_3_'.$row['id']]= '';
			if(!isset($_POST['survey_question_select_4_'.$row['id']])) $_POST['survey_question_select_4_'.$row['id']]= '';
			if(!isset($_POST['survey_question_select_5_'.$row['id']])) $_POST['survey_question_select_5_'.$row['id']]= '';
			if(!isset($_POST['survey_question_scale_'.$row['id']])) $_POST['survey_question_scale_'.$row['id']]= '';
			
			//get data from each question and secure it
			$question_number=strip_tags($db->quote($_POST['survey_question_number_'.$row['id']]));
			$question_type=strip_tags($db->quote($_POST['survey_question_type_'.$row['id']]));
			$question_text=strip_tags($db->quote($_POST['survey_question_text_'.$row['id']]));
			$question_scale=strip_tags($db->quote($_POST['survey_question_scale_'.$row['id']]));
			$question_select_1=strip_tags($db->quote($_POST['survey_question_select_1_'.$row['id']]));
			$question_select_2=strip_tags($db->quote($_POST['survey_question_select_2_'.$row['id']]));
			$question_select_3=strip_tags($db->quote($_POST['survey_question_select_3_'.$row['id']]));
			$question_select_4=strip_tags($db->quote($_POST['survey_question_select_4_'.$row['id']]));
			$question_select_5=strip_tags($db->quote($_POST['survey_question_select_5_'.$row['id']]));
			
			$db->exec("UPDATE tsurvey_questions SET number=$question_number, type=$question_type, text=$question_text, scale=$question_scale, select_1=$question_select_1, select_2=$question_select_2, select_3=$question_select_3, select_4=$question_select_4, select_5=$question_select_5 WHERE id=$row[id]");
		}
		
		//insert new question
		if($_POST['survey_new_question_number'])
		{
			//escape special char and secure string before database insert
			$_POST['survey_new_question_text']=strip_tags($db->quote($_POST['survey_new_question_text']));
			$db->exec("INSERT INTO tsurvey_questions (number, type, text) VALUES ('$_POST[survey_new_question_number]','$_POST[survey_new_question_type]',$_POST[survey_new_question_text])");
		}
	}
	//escape special char and secure string before database insert
	$_POST['survey_mail_text']=$db->quote($_POST['survey_mail_text']);
	$_POST['survey_mail_text']=str_replace('<script>','',$_POST['survey_mail_text']);
	$_POST['survey_mail_text']=str_replace('</script>','',$_POST['survey_mail_text']);
	
	//update function tab
	$query = "UPDATE tparameters SET 
	`planning`='$_POST[planning]',
	`procedure`='$_POST[procedure]',
	`survey`='$_POST[survey]',
	`survey_mail_text`=$_POST[survey_mail_text],
	`survey_ticket_state`='$_POST[survey_ticket_state]',
	`survey_auto_close_ticket`='$_POST[survey_auto_close_ticket]',
	`asset`='$_POST[asset]',
	`asset_ip`='$_POST[asset_ip]',
	`asset_warranty`='$_POST[asset_warranty]',
	`availability`='$_POST[availability]',
	`availability_all_cat`='$_POST[availability_all_cat]',
	`availability_condition_type`='$_POST[availability_condition_type]',
	`availability_condition_value`='$_POST[availability_condition_value]',
	`availability_dep`='$_POST[availability_dep]'
	WHERE
	id='1'
	";
	$db->exec($query);
	//add cat to availability list
	if($_POST['category']!=0)
	{
        $db->exec("INSERT INTO tavailability (category,subcat) VALUES ('$_POST[category]', '$_POST[subcat]')");
	}
	//add dependency cat to availability list
	if($_POST['depcategory']!=0)
	{
        $db->exec("INSERT INTO tavailability_dep (category,subcat) VALUES ('$_POST[depcategory]', '$_POST[depsubcat]')");
	}
	//find input name for target values
	$queryyears = $db->query("SELECT DISTINCT YEAR(date_create) FROM tincidents");
	while ($rowyear=$queryyears->fetch())
	{
		$querysubcat = $db->query("SELECT * FROM `tavailability`");
	    while ($rowsubcat=$querysubcat->fetch())
	    {
	    	$inputname="target_$rowyear[0]_$rowsubcat[subcat]";
			if(!isset($_POST[$inputname])) $_POST[$inputname] = '';
	    	if($_POST[$inputname]) {
	    		//check existing values
				$check= $db->query("SELECT * FROM `tavailability_target` WHERE year='$rowyear[0]' AND subcat='$rowsubcat[subcat]'"); 
				$check= $check->fetch();
	    		if ($check[0])
	    		{
	    			$db->exec("UPDATE tavailability_target SET target=$_POST[$inputname] WHERE year=$rowyear[0] AND subcat=$rowsubcat[subcat]");
	    		} else {
	    			$db->exec("INSERT INTO tavailability_target (year,subcat,target) VALUES ('$rowyear[0]', '$rowsubcat[subcat]', '$_POST[$inputname]')");
	    		}
	    	}
	    }
		$querysubcat->closecursor();
	}
	$queryyears->closecursor();
	
	//web redirect
	$www = "./index.php?page=admin&subpage=parameters&tab=function";
		echo '<script language="Javascript">
		<!--
		document.location.replace("'.$www.'");
		// -->
		</script>'; 
	
}
//delete question from survey
if($rparameters['survey']==1 && $_GET['deletequestion'] && $rright['admin']!=0)
{
	$db->exec("DELETE FROM tsurvey_questions WHERE id='$_GET[deletequestion]' ");
}
//remove cat from availability list
if ($_GET['deleteavailability']!='')
{
    $db->exec("DELETE FROM tavailability WHERE id = '$_GET[deleteavailability]'");
}
//remove dep cat from availability dependancy list
if ($_GET['deleteavailabilitydep']!='')
{
    $db->exec("DELETE FROM tavailability_dep WHERE id = '$_GET[deleteavailabilitydep]'");
}

//delete association
if($rparameters['imap_mailbox_service']==1 && $_GET['delete_imap_service'])
{
	$db->exec("DELETE FROM tparameters_imap_multi_mailbox WHERE id='$_GET[delete_imap_service]'");
}

//clean old files
$test_file=file_exists('./fileupload.php' );
if ($test_file==1)
{
	unlink('./fileupload.php');
}
//detect install directory to display warning
$test_install_file=file_exists('./install/index.php' );
if ($test_install_file==1)
{
	echo '
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="warning">
			<i class="icon-remove"></i>
		</button>
		<strong>
			<i class="icon-warning-sign"></i>
			'.T_('Attention').':
		</strong>
		'.T_('Le dossier d\'installation est toujours présent sur votre serveur, pour des raisons de sécurité veuillez supprimer le répertoire "./install" .').'
		<br>
	</div>
	';
}
?>
<!-- /////////////////////////////////////////////////////////////// general tab /////////////////////////////////////////////////////////////// -->
<div class="page-header position-relative">
	<h1>
		<i class="icon-cog"></i> <?php echo T_('Paramètres de l\'application'); ?>
	</h1>
</div>
<div class="col-sm-12">	
	<div class="tabbable">
		<ul class="nav nav-tabs" id="myTab">
			<li <?php if ($_GET['tab']=='general' || $_GET['tab']=='') echo 'class="active"'; ?>>
				<a href="./index.php?page=admin&subpage=parameters&tab=general">
					<i class="green icon-wrench bigger-110"></i>
					<?php echo T_('Général'); ?>
				</a>
			</li>
			<li <?php if ($_GET['tab']=='connector') echo 'class="active"'; ?>>
				<a href="./index.php?page=admin&subpage=parameters&tab=connector">
					<i class="blue icon-link bigger-110"></i>
					<?php echo T_('Connecteurs'); ?>
				</a>
			</li>
			<li <?php if ($_GET['tab']=='function') echo 'class="active"'; ?>>
				<a href="./index.php?page=admin&subpage=parameters&tab=function">
					<i class="orange icon-puzzle-piece bigger-110"></i>
					<?php echo T_('Fonctions'); ?>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="general" class="tab-pane <?php if ($_GET['tab']=='general' || $_GET['tab']=='') echo 'active'; ?>">
				<form enctype="multipart/form-data" method="post" action="">
					<div class="profile-user-info profile-user-info-striped">
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-building"></i>
								<?php echo T_('Société'); ?>:
							</div>
							<div class="profile-info-value">
								<div class="control-group">	
									<label for="company"><?php echo T_('Nom de l\'entreprise'); ?>: </label>
									<input type="text" name="company" value="<?php echo $rparameters['company']; ?>" placeholder="Company">
									<div class="space-4"></div>
									<label for="logo"><?php echo T_('Logo'); ?>: </label>
									<?php
										if ($rparameters['logo']!="")
										{
											echo '
												<img src="./upload/logo/'.$rparameters['logo'].'" />	
												<a title="'.T_('Supprimer ce logo').'" href="./index.php?page=admin&subpage=parameters&tab=general&action=deletelogo">
    											    <i class="icon-trash red bigger-160"></i>
    											</a>
											';
										} else {
											echo "<input type=\"file\" id=\"logo\" name=\"logo\" />";
										}
									?>
								</div>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name">
								<i class="icon-hdd"></i>
								<?php echo T_('Serveur'); ?>: 
							</div>
							<div class="profile-info-value">
								<span id="username">
									<label for="server_url"><?php echo T_('URL d\'accès au serveur'); ?>: </label>
										<input type="text" name="server_url" value="<?php echo $rparameters['server_url']; ?>">
										<i title="<?php echo T_('URL de l\'accès au serveur pour vos utilisateurs, utilisé dans l\'envoi de mail (exemple: https://gestsup en LAN ou https://support.masociete.com sur Internet)'); ?>" class="icon-question-sign blue bigger-110"></i>
								</span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name">
								<i class="icon-desktop"></i>
								<?php echo T_('Affichage'); ?>: 
							</div>
							<div class="profile-info-value">
								<span id="username">
									<label for="maxline"><?php echo T_('Nombre de ligne par page'); ?>: </label>
									<input type="text" size="2" name="maxline" value="<?php echo $rparameters['maxline']; ?>">
									<i title="<?php echo T_('Si cette valeur est trop grande cela peut ralentir l\'application'); ?>" class="icon-question-sign blue bigger-110"></i>
									<div class="space-4"></div>
									<label for="time_display_msg"><?php echo T_('Temps d\'affichage des messages d\'actions'); ?> :</label>
									<input name="time_display_msg" type="text" value="<?php echo $rparameters['time_display_msg']; ?>" size="4" /> ms<br />
									<label for="auto_refresh"><?php echo T_('Actualisation automatique'); ?> :</label>
									<input name="auto_refresh" type="text" value="<?php echo $rparameters['auto_refresh']; ?>" size="3" /> s 
									<i title="<?php echo T_('Si la valeur est à 0, alors l\'actualisation automatique est désactivée. Attention, cette fonction peut faire clignoter l\'écran selon les navigateurs'); ?>." class="icon-question-sign blue bigger-110"></i><br />
								   <div class="space-4"></div>
								   <label><i class="icon-caret-right blue"></i> <a target="about_blank" href="./monitor.php?user_id=<?php echo $_SESSION['user_id']; ?>"><?php echo T_('Écran de supervision'); ?></a></label>
								</span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name">
								<i class="icon-ticket"></i>
								<?php echo T_('Tickets'); ?>: 
							</div>
							<div class="profile-info-value">
								<span id="username">
									<label for="ticket_increment_number"><?php echo T_("Numéro d'incrémentation"); ?>: </label>
									<input type="text" size="6" name="ticket_increment_number" value="">
									<i title="<?php echo T_("Permet d'initialiser le compteur de ticket à une valeur souhaitée. Attention vous ne pourrez plus redéfinir le compteur à une valeur inférieur"); ?>" class="icon-question-sign blue bigger-110"></i>
									<div class="space-4"></div>
									<label for="order"><?php echo T_('Ordre de trie'); ?> :</label>
									<select class="textfield" id="order" name="order" >
										<option <?php if ($rparameters['order']=='tstates.number, tincidents.priority, tincidents.criticality, tincidents.date_create') echo "selected "; ?> value="tstates.number, tincidents.priority, tincidents.criticality, tincidents.date_create"><?php echo T_('État > Priorité > Criticité > Date de création'); ?></option>
										<option <?php if ($rparameters['order']=='tstates.number, tincidents.priority, tincidents.criticality, tincidents.date_hope') echo "selected "; ?> value="tstates.number, tincidents.priority, tincidents.criticality, tincidents.date_hope"><?php echo T_('État > Priorité > Criticité > Date de résolution estimé'); ?></option>
										<option <?php if ($rparameters['order']=='tstates.number, tincidents.date_hope, tincidents.priority, tincidents.criticality') echo "selected "; ?> value="tstates.number, tincidents.date_hope, tincidents.priority, tincidents.criticality"><?php echo T_('État > Date de résolution estimé > Priorité > Criticité'); ?></option>
										<option <?php if ($rparameters['order']=='tstates.number, tincidents.date_hope, tincidents.criticality, tincidents.priority') echo "selected "; ?> value="tstates.number, tincidents.date_hope, tincidents.criticality, tincidents.priority"><?php echo T_('État > Date de résolution estimé > Criticité > Priorité'); ?></option>
										<option <?php if ($rparameters['order']=='tstates.number, tincidents.criticality, tincidents.date_hope, tincidents.priority') echo "selected "; ?> value="tstates.number, tincidents.criticality, tincidents.date_hope, tincidents.priority"><?php echo T_('État > Criticité > Date de résolution estimé > Priorité'); ?></option>
										<option <?php if ($rparameters['order']=='id') echo "selected "; ?>  value="id"><?php echo T_('Numéro de ticket'); ?></option>
									</select>
									<i title="<?php echo T_('Détermine l\'ordre de classement des tickets dans la liste des tickets'); ?>." class="icon-question-sign blue bigger-110"></i><br />
									<div class="space-4"></div>
									<label>
										<input type="checkbox" <?php if ($rparameters['meta_state']==1) {echo "checked";}  ?> name="meta_state" class="ace" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Gestion du méta état "a traiter"'); ?></span>
										<i title="<?php echo T_('Permet d\'afficher un nouvel état regroupant les états en attente de PEC, en cours, et en attente de retour'); ?>." class="icon-question-sign blue bigger-110"></i></label>
								   </label>
								   <div class="space-4"></div>
									<label>
										<input type="checkbox" <?php if ($rparameters['ticket_places']==1) {echo "checked";}  ?> name="ticket_places" class="ace" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Gestion des lieux'); ?></span>
										<i title="<?php echo T_('Permet un rattachement du ticket à une localité, une liste des lieux est éditable dans la section liste, un nouveau champ sera disponible sur le ticket'); ?>." class="icon-question-sign blue bigger-110"></i>
									</label>
									<div class="space-4"></div>
									<label>
										<input type="checkbox" <?php if ($rparameters['ticket_type']==1) {echo "checked";} ?> name="ticket_type" class="ace" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Gestion des types'); ?></span>
										<i title="<?php echo T_('Permet de définir un type à un ticket (ex: Demande, Incident...), ajoute une ligne sur le ticket, la liste des types est administrable dans Administration > Liste'); ?>" class="icon-question-sign blue bigger-110"></i>
									</label>
								</span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name">
								<i class="icon-volume-up"></i>
								<?php echo T_('Son'); ?>: 
							</div>
							<div class="profile-info-value">
								<span id="username">
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['notify']==1) echo "checked"; ?> name="notify" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Activer la notification sonore pour les nouvelles demandes'); ?></span>
										<i title="<?php echo T_('Active l\'avertisseur sonore pour le technicien si un utilisateur déclare un ticket (fonctionne uniquement sur Chrome, Firefox et Safari)'); ?>" class="icon-question-sign blue bigger-110"></i>
									</label>
								</span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name">
								<i class="icon-user"></i>
								<?php echo T_('Utilisateurs'); ?>: 
							</div>
							<div class="profile-info-value">
								<span id="username">
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['user_advanced']==1) echo "checked"; ?> name="user_advanced" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Utiliser les propriétés utilisateur avancées'); ?></span>
										<i title="<?php echo T_('Ajoute des champs supplémentaire aux propriétés utilisateurs, Société, FAX, Adresses...'); ?>" class="icon-question-sign blue bigger-110"></i>
									</label>
									<br />
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['user_register']==1) echo "checked"; ?> name="user_register" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Les utilisateurs peuvent s\'enregistrer'); ?></span>
										<i title="<?php echo T_('Ajoute un bouton sur la page de connexion, permettant la création de nouveaux utilisateurs'); ?>." class="icon-question-sign blue bigger-110"></i>
									</label>
									<br />
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['user_limit_ticket']==1) echo "checked"; ?> name="user_limit_ticket" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Limite de tickets par utilisateur'); ?></span>
										<i title="<?php echo T_('Permet de limiter le nombre de tickets qu\'un utilisateur peut ouvrir pour un période donnée, les paramètres se trouvent sur la fiche de l\'utilisateur. Si aucun paramètres n\'est définit la limitation ne sera pas active. Si la limite de ticket est atteinte alors la création de ticket est bloqué pour l\'utilisateur'); ?>." class="icon-question-sign blue bigger-110"></i>
										<br />
									</label>
									<br />
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['company_limit_ticket']==1) echo "checked"; ?> name="company_limit_ticket" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Limite de tickets par Société'); ?></span>
										<i title="<?php echo T_('Permet de limiter le nombre de tickets qu\'une société peut ouvrir pour un période donnée, les paramètres se trouvent Administration > Listes > Société . Si aucun paramètres n\'est définit la limitation ne sera pas active. Si la limite de ticket est atteinte alors la création de ticket est bloqué pour l\'ensemble des utilisateurs associés à cette société'); ?>." class="icon-question-sign blue bigger-110"></i>
										<br />
									</label>
									<br />
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['user_company_view']==1) echo "checked"; ?> name="user_company_view" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Les utilisateurs peuvent voir tous les tickets de leur société'); ?></span>
										<i title="<?php echo T_("Ajoute une nouvelle vue pour les utilisateurs, afin de visualiser tous les tickets déclarés par l'ensemble des utilisateurs associés à une société. (Le droit side_company est nécessaire pour disposer de l'accès, le droit de modification de société user_profil_company est à désactiver pour les utilisateurs)"); ?>.)" class="icon-question-sign blue bigger-110"></i>
										<br />
									</label>
									<br />
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['user_agency']==1) echo "checked"; ?> name="user_agency" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Les utilisateurs appartiennent à des agences'); ?></span>
										<i title="<?php echo T_('Ajoute une nouvelle liste dans Administration > Liste > Agence'); ?>.)" class="icon-question-sign blue bigger-110"></i>
										<br />
									</label><br />
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['user_limit_service']==1) echo "checked"; ?> name="user_limit_service" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Les utilisateurs ne voient que les tickets de leurs services'); ?></span>
										<i title="<?php echo T_('Permet de cloisonner la liste de tickets ainsi que les catégories, un droit additionnel est nécessaire dashboard_service_only'); ?>.)" class="icon-question-sign blue bigger-110"></i>
										<br />
									</label>
								</span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name">
								<i class="icon-envelope"></i>
								<?php echo T_('Messages'); ?>: 
							</div>
							<div class="profile-info-value">
								<span id="username">
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['mail_auto']==1) echo "checked"; ?> name="mail_auto" value="1" />
										<span class="lbl">&nbsp;<?php echo T_('Envoi de mail automatique à l\'utilisateur lors de l\'ouverture ou fermeture d\'un ticket par un technicien'); ?></span>
									</label>
									<br />
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['mail_auto_user_modify']==1) echo "checked"; ?> name="mail_auto_user_modify" value="1" />
										<span class="lbl">&nbsp;<?php echo T_('Envoi de mail automatique à l\'utilisateur lors de l\'ajout ou la modification de la résolution d\'un ticket par un technicien'); ?></span>
									</label>
									<br />
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['mail_auto_tech_modify']==1) echo "checked"; ?> name="mail_auto_tech_modify" value="1" />
										<span class="lbl">&nbsp;<?php echo T_('Envoi de mail automatique au technicien lors de la modification d\'un ticket par un utilisateur'); ?></span>
									</label>
									<br />
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['mail_newticket']==1) echo "checked"; ?> name="mail_newticket" value="1" />
										<span class="lbl">&nbsp;<?php echo T_('Envoi de mail automatique à l\'administrateur lors de l\'ouverture d\'un ticket par un utilisateur'); ?></span>
									</label>
									<?php 
										if ($rparameters['mail_newticket']=='1') 
										{
											echo '
											<div class="space-4"></div>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.T_('Adresse Mail').': <input name="mail_newticket_address" type="" value="'.$rparameters['mail_newticket_address'].'" size="30" />
											<div class="space-4"></div>
											';
										}
									?>
									<div class="space-4"></div>
									<i class="icon-caret-right blue"></i> <?php echo T_('Texte début du mail'); ?>: <input name="mail_txt" type="text" value="<?php echo $rparameters['mail_txt']; ?>" size="80" />
									<i title="<?php echo T_('Vous pouvez utiliser du code HTML (Exemple: <br />, <b></b>...)'); ?>" class="icon-question-sign blue bigger-110"></i>
									<div class="space-4"></div>
									<i class="icon-caret-right blue"></i> <?php echo T_('Adresse en copie'); ?>: <input name="mail_cc" type="text" value="<?php echo $rparameters['mail_cc']; ?>" size="30" /><br />
									<div class="space-4"></div>
									<i class="icon-caret-right blue"></i> <?php echo T_('Intitulé de l\'émetteur'); ?>: <input name="mail_from_name" type="text" value="<?php echo $rparameters['mail_from_name']; ?>" size="30" /><br />
									<div class="space-4"></div>
									<i class="icon-caret-right blue"></i> <?php echo T_('Adresse de l\'émetteur'); ?>: <input name="mail_from_adr" type="text" value="<?php echo $rparameters['mail_from_adr']; ?>" size="30" />
									<i title="<?php echo T_('Adresse d\'envoi de tous les messages de l\'application, si ce paramètre est vide les messages seront envoyés avec l\'adresse mail de l\'utilisateur connecté. Certains serveurs SMTP peuvent exiger que l\'émetteur soit le même que le compte de connexion'); ?>. " class="icon-question-sign blue bigger-110"></i><br />
									<div class="space-4"></div>
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['mail_link']==1) echo "checked"; ?> name="mail_link" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Intégrer un lien vers GestSup'); ?></span>
									</label>
									<div class="space-4"></div>
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['mail_order']==1) echo "checked"; ?> name="mail_order" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Ordre antéchronologique dans les éléments de résolution'); ?></span>
										<i title="<?php echo T_("Permet d'inverser le sens du fil de suivi de la résolution les éléments les plus récents seront en premier"); ?>. " class="icon-question-sign blue bigger-110"></i><br />
									</label>
									<div class="space-4"></div>
									<i class="icon-caret-right blue"></i> <?php echo T_('Couleur du titre'); ?>: #<input  style="background-color: <?php echo "#$rparameters[mail_color_title]"; ?>;" name="mail_color_title" type="text" value="<?php echo $rparameters['mail_color_title']; ?>" size="6" /><br />
									<div class="space-4"></div>
									<i class="icon-caret-right blue"></i> <?php echo T_('Couleur du fond'); ?>: #<input  style="background-color: <?php echo "#$rparameters[mail_color_bg]"; ?>;" name="mail_color_bg" type="text" value="<?php echo $rparameters['mail_color_bg']; ?>" size="6" /><br />
									<div class="space-4"></div>
									<i class="icon-caret-right blue"></i> <?php echo T_('Couleur du texte'); ?>: #<input  style="background-color: <?php echo "#$rparameters[mail_color_text]"; ?>;" name="mail_color_text" type="text" value="<?php echo $rparameters['mail_color_text']; ?>" size="6" /><br />			
								</span>
							</div>						
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name">
								<i class="icon-bug"></i>
								<?php echo T_('Debug'); ?>: 
							</div>
							<div class="profile-info-value">
								<span id="username">
									<label> 
										<input class="ace" type="checkbox" <?php if ($rparameters['debug']==1) echo "checked"; ?> name="debug" value="1">
										<span class="lbl">&nbsp;<?php echo T_('Activer le mode de débogage'); ?></span>
										<i title="<?php echo T_('Active le mode débogage afin d\'afficher les éléments de résolution de problèmes'); ?>." class="icon-question-sign blue bigger-110"></i>
									</label>
								</span>
							</div>
						</div>
						<br />
						<br />
						<center>
							<button name="submit_general" id="submit_general" value="submit_general" type="submit" class="btn btn-primary">
								<i class="icon-ok bigger-120"></i>
								<?php echo T_('Valider'); ?>
							</button>
						</center>
						<div class="space-4"></div>
					</div>
				</form>
			</div>
			<!-- /////////////////////////////////////////////////////////////// connectors part /////////////////////////////////////////////////////////////// -->
			<div id="connector" class="tab-pane <?php if ($_GET['tab']=='connector') echo 'active'; ?>">
				<form enctype="multipart/form-data" method="post" action="">
					<div class="profile-user-info profile-user-info-striped">
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-envelope"></i>
								&nbsp;SMTP:
							</div>
							<div class="profile-info-value">
								<label>
									<input class="ace" type="checkbox" <?php if ($rparameters['mail']==1) echo "checked"; ?> name="mail" value="1">
									<span class="lbl">&nbsp<?php echo T_('Activer la liaison SMTP'); ?>
									<i title="<?php echo T_('Connecteur permettant l\'envoi de mails depuis GestSup vers un serveur de messagerie, afin que les mails puissent être envoyés'); ?>." class="icon-question-sign blue"></i>
								</label>
								<div class="space-4"></div>
								<?php
								if ($rparameters['mail']==1) 
								{
									echo '
									<div class="space-4"></div>
									<label for="mail_smtp"><i class="icon-caret-right blue"></i> '.T_('Serveur SMTP').':</label>
									<input name="mail_smtp" type="text" value="'.$rparameters['mail_smtp'].'" size="20" />
									<i title="'.T_('Adresse IP ou Nom de votre serveur de messagerie (Exemple: 192.168.0.1 ou SRVMSG ou smtp.free.fr ou auth.smtp.1and1.fr ou SSL0.OVH.NET)').'" class="icon-question-sign blue bigger-110"></i>
									<div class="space-4"></div>
									<label for="mail_port"><i class="icon-caret-right blue"></i> '.T_('Port SMTP').':</label>
									<select class="textfield" id="mail_port" name="mail_port" >
										<option ';if ($rparameters['mail_port']==25) echo "selected "; echo' value="25">25</option>
										<option ';if ($rparameters['mail_port']==465) echo "selected "; echo' value="465">465 (SSL)</option>
										<option ';if ($rparameters['mail_port']==587) echo "selected "; echo' value="587">587 (TLS)</option>
									</select>
									<i title="'.T_('Port du serveur de messagerie par défaut le port 25 est utilisé, pour les connexions sécurisées les ports 465 et 587 sont utilisés. (exemple: OVH port 587 1&1 port 587)').'" class="icon-question-sign blue bigger-110"></i>
									<div class="space-4"></div>
									<label for="mail_ssl_check"><i class="icon-caret-right blue"></i> '.T_('Vérification SSL').':</label>
									<select class="textfield" id="mail_ssl_check" name="mail_ssl_check" >
										<option ';if ($rparameters['mail_ssl_check']==1) echo "selected "; echo' value="1">'.T_('Activée').'</option>
										<option ';if ($rparameters['mail_ssl_check']==0) echo "selected "; echo' value="0">'.T_('Désactivée').'</option>
									</select>
									<i title="'.T_('Désactivation de la verification du certificat serveur et autorise les certificats auto-signés').'" class="icon-question-sign blue bigger-110"></i>
									<div class="space-4"></div>
									<label for="mail_secure"><i class="icon-caret-right blue"></i> '.T_('Préfixe SMTP').':</label>
									<select class="textfield" id="mail_secure" name="mail_secure" >
										<option ';if ($rparameters['mail_secure']==0) echo "selected "; echo' value="0">'.T_('Aucun').'</option>
										<option ';if ($rparameters['mail_secure']=='SSL') echo "selected "; echo' value="SSL">ssl//</option>
										<option ';if ($rparameters['mail_secure']=='TLS') echo "selected "; echo' value="TLS">tls//</option>
									</select>
									 ';
									    if ($rparameters['mail_secure']=='SSL' || $rparameters['mail_secure']=='TLS') {echo'<i>('.T_('l\'extension php_openssl devra être activée').')</i>';} else {echo'<i title="Si votre serveur de messagerie est sécurisé avec SSL ou TLS (Exemple: Gmail utilise TLS, 1&1 aucun, OVH aucun)."  class="icon-question-sign blue bigger-110"></i>';} 
									 echo '
									<div class="space-4"></div>
									<label for="mail_smtp_class"><i class="icon-caret-right blue"></i> '.T_('Classe SMTP').' :</label>
									<select class="textfield" id="mail_smtp_class" name="mail_smtp_class" >
										<option ';if ($rparameters['mail_smtp_class']=='IsSMTP()') echo "selected "; echo' value="IsSMTP()">IsSMTP ('.T_('Défaut').')</option>
										<option ';if ($rparameters['mail_smtp_class']=='IsSendMail()') echo "selected "; echo' value="IsSendMail()">IsSendMail</option>
									</select>
									<i title="'.T_('Classe PHPMailer, par défaut utiliser isSMTP(), certains hébergements n\'autorisent que le isSendMail() (exemple: 1&1 utilise isSendMail() )').'" class="icon-question-sign blue bigger-110"></i>
									<div class="space-4"></div>
									<label>
										<input class="ace" type="checkbox"'; if ($rparameters['mail_auth']==1) {echo "checked";}  echo ' name="mail_auth" value="1">
										<span class="lbl">&nbsp;'.T_('Serveur SMTP Authentifié').'</span>
										<i title="'.T_('Cochez cette case si votre serveur de messagerie nécessite un identifiant et mot de passe pour envoyer des messages. (exemple: 1&1 exige un SMTP authentifié)').'" class="icon-question-sign blue bigger-110"></i>
									</label>
									';
									if ($rparameters['mail_auth']==1) 
									{
									echo '
										<div class="space-4"></div>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.T_('Utilisateur').': <input name="mail_username" type="text" value="'.$rparameters['mail_username'].'" size="30" />
										<div class="space-4"></div>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.T_('Mot de passe').': <input name="mail_password" type="password" value="'.$rparameters['mail_password'].'" size="30" />
										';
									}
								}
								?>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-book"></i>
								&nbsp;LDAP:
							</div>
							<div class="profile-info-value">
								<div class="control-group">	
									<label>
										<input class="ace" type="checkbox" <?php if ($rparameters['ldap']==1) echo "checked"; ?> name="ldap" value="1">
										<span class="lbl">&nbsp<?php echo T_('Activer la liaison LDAP'); ?> </span>	
										<i title="<?php echo T_('Connecteur permettant la synchronisation entre l\'annuaire d\'entreprise (Active Directory ou OpenLDAP) et GestSup'); ?>" class="icon-question-sign blue"></i>
									</label>
									<?php if ($rparameters['ldap']=='1') 
									{
										echo '
										<div class="space-4"></div>
										<label>
											<input class="ace" type="checkbox"'; if ($rparameters['ldap_auth']==1) echo "checked"; echo ' name="ldap_auth" value="1">
											<span class="lbl">&nbsp;'.T_("Activer l'authentification GestSup avec LDAP").'
											<i title="'.T_('Active l\'authentification des utilisateurs dans Gestsup, avec les identifiants présents dans l\'annuaire LDAP. Cela ne désactive pas l\'authentification avec la base utilisateurs de GestSup').'." class="icon-question-sign blue "></i>
										</label>
										<div class="space-4"></div>
										<label>
											<input class="ace" type="checkbox"'; if ($rparameters['ldap_service']==1) echo "checked"; echo ' name="ldap_service" value="1">
											<span class="lbl">&nbsp;'.T_("Activer la synchronisation des groupes LDAP de services").'
											<i title="'.T_("Permet de synchroniser des groupes LDAP de service: création, renommage, désactivation de services GestSup, création utilisateurs GestSup membres du groupe LDAP et association entre les deux. (Tous les utilisateurs doivent appartenir à un groupe)").'." class="icon-question-sign blue "></i>
										</label>
										<div class="space-4"></div>
										';
										if ($rparameters['ldap_service']==1 )
										{
											echo '
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											'.T_("Emplacement des groupes de service").':
											<input name="ldap_service_url" type="text" value="'.$rparameters['ldap_service_url'].'" size="50" />
											<i title="'.T_('Emplacement des groupes de service dans l\'annuaire LDAP. (exemple: ou=service, ou=utilisateurs) Attention il ne doit pas être suffixé du domaine').'." class="icon-question-sign blue bigger-110"></i> <br />
											<div class="space-4"></div>
											';
										}
										if ($rparameters['user_agency']==1)
										{
											echo '
											<label>
												<input class="ace" type="checkbox"'; if ($rparameters['ldap_agency']==1) echo "checked"; echo ' name="ldap_agency" value="1">
												<span class="lbl">&nbsp;'.T_("Activer la synchronisation des groupes LDAP d'agences").'
												<i title="'.T_("Permet de synchroniser des groupes LDAP d'agence: création, renommage, désactivation d'agences GestSup, création utilisateurs GestSup membres du groupe LDAP et association entre les deux. (Tous les utilisateurs doivent appartenir à un groupe)").'." class="icon-question-sign blue "></i>
											</label>
											<div class="space-4"></div>
											';
											if ($rparameters['ldap_agency']==1 )
											{
												echo '
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												'.T_("Emplacement des groupes d'agence").':
												<input name="ldap_agency_url" type="text" value="'.$rparameters['ldap_agency_url'].'" size="50" />
												<i title="'.T_('Emplacement des groupes d\'agences dans l\'annuaire LDAP. (exemple: ou=groupe_agence, ou=utilisateurs) Attention il ne doit pas être suffixé du domaine').'." class="icon-question-sign blue bigger-110"></i> <br />
												<div class="space-4"></div>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												'.T_("Déplacer les tickets associés à l'agence").':
												<select id="from_agency" name="from_agency" />
													';
													$query = $db->query("SELECT id, name FROM `tagencies` ");
													while ($row=$query->fetch())	
													{
														echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
													}
													echo'
												</select>
												'.T_("vers l'agence").':
												<select id="dest_agency" name="dest_agency" />
												';
													$query = $db->query("SELECT id, name FROM `tagencies` ");
													while ($row=$query->fetch())	
													{
														echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
													}
													echo'
												</select>
												<div class="space-4"></div>
												';
											}
										}
										echo '
										'.T_('Type de serveur LDAP').': 
										<select id="ldap_type" name="ldap_type" >
											<option ';if ($rparameters['ldap_type']==0) echo "selected "; echo ' value="0">Active Directory</option>
											<option ';if ($rparameters['ldap_type']==1) echo "selected "; echo ' value="1">OpenLDAP</option>
										</select>
										<i title="'.T_('Sélectionner si votre serveur d\'annuaire est Windows Active Directory ou OpenLDAP').'." class="icon-question-sign blue bigger-110"></i><br />
										<div class="space-4"></div>
										'.T_('Nom du serveur LDAP').':
										<input name="ldap_server" type="text" value="'.$rparameters['ldap_server'].'" size="20" />
										<i title="'.T_('Adresse IP ou nom netbios du serveur d\'annuaire, sans suffixe DNS (Exemple: 192.168.0.1 ou SVRAD)').'. " class="icon-question-sign blue bigger-110"></i><br />
										<div class="space-4"></div>
										'.T_('Port LDAP').': 
										<select id="ldap_port" name="ldap_port" >
											<option ';if ($rparameters['ldap_port']==389) echo "selected "; echo ' value="389">389</option>
											<option ';if ($rparameters['ldap_port']==636) echo "selected "; echo ' value="636">636</option>
										</select>
										<i title="'.T_('Le port par défaut est 389 si vous utilisez un serveur LDAPS (sécurisé) le port est 636').'." class="icon-question-sign blue bigger-110"></i> <br />
										<div class="space-4"></div>
										'.T_('Domaine').':
										<input name="ldap_domain" type="text" value="'.$rparameters['ldap_domain'].'" size="20" />
										<i title="'.T_('Nom du domaine FQDN (Exemple: exemple.local)').'." class="icon-question-sign blue bigger-110"></i> <br />
										<div class="space-4"></div>
										'.T_('Emplacement des utilisateurs').':
										<input name="ldap_url" type="text" value="'.$rparameters['ldap_url'].'" size="80" />
										<i title="'.T_('Emplacement dans l\'annuaire des utilisateurs. Par défaut pour Active Directory cn=users, si vous utilisez plusieurs unités d\'organisation séparer avec un point virgule (ou=France,ou=utilisateurs;ou=Belgique,ou=utilisateurs) Attention il ne doit pas être suffixé du domaine').'." class="icon-question-sign blue bigger-110"></i> <br />
										<div class="space-4"></div>
										Utilisateur: <input name="ldap_user" type="text" value="'.$rparameters['ldap_user'].'" size="20" />
										<i title="'.T_('Utilisateur présent dans l\'annuaire LDAP, pour OpenLDAP l\'utilisateur doit être à la racine et de type CN').'" class="icon-question-sign blue bigger-110"></i> <br />
										<div class="space-4"></div>
										'.T_('Mot de passe').':
										<input name="ldap_password" type="password" value="'.$rparameters['ldap_password'].'" size="20" /><br />
										<br />
										<button name="test_ldap" value="1" type="submit" class="btn btn-xs btn-info">
											<i class="icon-refresh bigger-120"></i>
											'.T_('Test du connecteur LDAP').'
										</button>
										<br /><br />
										';
										//check LDAP parameters
										if($_GET['ldaptest']==1) {
										include('./core/ldap.php');
										echo "&nbsp;&nbsp;$ldap_connection<br />";
										} 
									}
									?>
								</div>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-download-alt"></i>
								&nbsp;IMAP:
							</div>
							<div class="profile-info-value">
								<label>
									<input class="ace" type="checkbox" <?php if ($rparameters['imap']==1) echo "checked"; ?> name="imap" value="1">
									<span class="lbl">&nbsp<?php echo T_('Activer la liaison IMAP'); ?>
									<i title="<?php echo T_('Connecteur permettant de créer des tickets automatiquement en interrogeant une boite mail. Une fois le mail converti en ticket le message passe en lu dans la boite de messagerie. Attention une tâche planifiée doit être crée afin d\'interroger de manière régulière la boite mail (cf FAQ)'); ?>" class="icon-question-sign blue"></i>
								</label>
								<div class="space-4"></div>
								<?php
								if ($rparameters['imap']=='1') 
								{
									echo '
										'.T_('Serveur de Messagerie').' POP/IMAP: 
										<input name="imap_server" type="text" value="'.$rparameters['imap_server'].'" size="20" />
										<i title="'.T_('Adresse IP ou nom netbios ou nom FQDN du serveur POP ou IMAP de messagerie (ex: imap.free.fr, imap.gmail.com)').'" class="icon-question-sign blue bigger-110"></i>
										<div class="space-4"></div>
										'.T_('Protocole').' : 
										<select id="imap_port" name="imap_port" >
											<option ';if ($rparameters['imap_port']=='143') {echo "selected ";} echo ' value="143">IMAP (port: 143)</option>
											<option ';if ($rparameters['imap_port']=="110/pop3") {echo "selected ";} echo ' value="110/pop3">POP (port: 110)</option>
											<option ';if ($rparameters['imap_port']=="993/imap/ssl/novalidate-cert") {echo "selected ";} echo ' value="993/imap/ssl/novalidate-cert">IMAP sécurisé (port: 993)</option>
											<option ';if ($rparameters['imap_port']=="993/pop/ssl") {echo "selected ";} echo ' value="993/pop/ssl">POP sécurisé (port: 993)</option>
										</select>
										<i title="'.T_('Protocole utilisé sur le serveur POP ou IMAP sécurisé ou non (ex: pour free.fr sélectionner IMAP, pour gmail utiliser IMAP sécurisé)').'" class="icon-question-sign blue bigger-120"></i>
										<div class="space-4"></div>
										'.T_('Dossier racine').' : 
										<select id="inbox" name="inbox" >
											<option ';if ($rparameters['imap_inbox']=='INBOX') {echo "selected ";} echo ' value="INBOX">INBOX</option>
											<option ';if ($rparameters['imap_inbox']=='') {echo "selected ";} echo ' value="">'.T_('Aucun').'</option>
										</select>
										<i title="'.T_('Dossier racine ou se trouve les messages entrants (par défaut INBOX, pour gmail INBOX)').'" class="icon-question-sign blue bigger-110"></i>
										<div class="space-4"></div>
										'.T_('Adresse de messagerie').': 
											<input name="imap_user" type="text" value="'.$rparameters['imap_user'].'" size="25" />
											<i title="'.T_('Adresse de la boite de messagerie à relever').'." class="icon-question-sign blue bigger-110"></i>
											<div class="space-4"></div>
											'.T_('Mot de passe').': 
											<input name="imap_password" type="password" value="'.$rparameters['imap_password'].'" size="20" /><br />
											<div class="space-4"></div>
										<label>
											<input class="ace" type="checkbox" '; if ($rparameters['imap_mailbox_service']==1) {echo "checked";} echo ' name="imap_mailbox_service" value="1">
											<span class="lbl">&nbsp'.T_('Activer le multi BAL par service').'
											<i title="'.T_("Permet de relever plusieurs boites aux lettres et d'associer les tickets crées à des services GestSup").'" class="icon-question-sign blue"></i>
										</label>
										<div class="space-4"></div>
										';
										//display parameters of imap_mailbox_service
										if ($rparameters['imap_mailbox_service']==1)
										{
											echo "<ul>";
											//display all existing association
											$query = $db->query("SELECT id,mail,service_id FROM tparameters_imap_multi_mailbox");
											while ($row = $query->fetch()) 
											{
												//get service name do display
												$query2=$db->query("SELECT name FROM tservices WHERE id='$row[service_id]'");
												$row2=$query2->fetch();
												$query2->closeCursor();
												echo '<li>'.$row['mail'].' > '.$row2['name'].' <a href="./index.php?page=admin&subpage=parameters&tab=connector&delete_imap_service='.$row['id'].'"><i title="'.T_("Supprimer l'association").'" class="icon-trash red bigger-130"></i></a></li>';
											}
											$query->closeCursor(); 
											echo "</ul>";
											//inputs for new association
											echo '&nbsp;&nbsp;&nbsp;
											'.T_('Adresse mail').':<input name="mailbox_service" type="text" value="" size="20" />
											'.T_('Mot de passe').':<input name="mailbox_password" type="password" value="" size="20" />
											'.T_('Service').'
											<select id="mailbox_service_id" name="mailbox_service_id" >
												';
												$query = $db->query("SELECT id,name FROM tservices WHERE disable='0'");
												while ($row = $query->fetch()) 
												{
													echo'<option value="'.$row['id'].'">'.$row['name'].'</option>';
												}
												$query->closeCursor(); 
												echo '
											</select>
											<div class="space-4"></div>
											';
										}
										echo '
										'.T_('Adresses à exclure').': 
										<input name="imap_blacklist" type="text" value="'.$rparameters['imap_blacklist'].'" size="60" />
										<i title="'.T_("Permet d'ajouter des adresses mail et/ou des domaines à exclure de la récupération des messages. Le séparateur est le point virgule exemple: john.doe@example.com;example2.com;outlook").'." class="icon-question-sign blue bigger-110"></i>
										<div class="space-4"></div>
										'.T_('Action post traitement').' : 
										<select id="imap_post_treatment" name="imap_post_treatment" >
											<option ';if ($rparameters['imap_post_treatment']=='move') {echo "selected ";} echo ' value="move">Déplacer le mail dans un repertoire</option>
											<option ';if ($rparameters['imap_post_treatment']=='delete') {echo "selected ";} echo ' value="delete">Supprimer le mail</option>
											<option ';if ($rparameters['imap_post_treatment']=='') {echo "selected ";} echo ' value="">'.T_('Passer en lu le mail').'</option>
										</select>
										<i title="'.T_('Permet de spécifier une action sur le mail de la boite aux lettre, une fois le mail convertit en ticket').'" class="icon-question-sign blue bigger-110"></i>
										';
										if ($rparameters['imap_post_treatment']=='move') {echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.T_('Répertoire').': <input name="imap_post_treatment_folder" type="text" value="'.$rparameters['imap_post_treatment_folder'].'"  /> <i title="'.T_('Permet de spécifier un répertoire de la messagerie dans lequel le mail sera déplacé exemple: INBOX/vu').'" class="icon-question-sign blue bigger-110"></i>';}
										echo'
										<div class="space-4"></div>
										<button name="test_imap" OnClick="window.open(\'./mail2ticket.php\')"  value="test_imap" type="submit" class="btn btn-xs btn-info">
											<i class="icon-download-alt bigger-120"></i>
											'.T_("Lancer l'import des mails").'
										</button>
									';
								}
								?>
								<br />
								<br />
								<center>
									<button name="submit_connector" id="submit_connector" value="submit_connector" type="submit" class="btn btn-primary">
										<i class="icon-ok bigger-120"></i>
										<?php echo T_('Valider'); ?>
									</button>
								</center>
								<div class="space-4"></div>
							</div>
						</div>
					</div>	
				</form>
			</div>
			<!-- /////////////////////////////////////////////////////////////// functions tab /////////////////////////////////////////////////////////////// -->
			<div id="function" class="tab-pane <?php if ($_GET['tab']=='function') echo 'active'; ?>">
				<form enctype="multipart/form-data" method="POST" action="">
					<div class="profile-user-info profile-user-info-striped">
					    <?php include('./plugins/availability/admin/parameters.php') ?>
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-calendar"></i>
								<?php echo T_('Calendrier'); ?>:
							</div>
							<div class="profile-info-value">
								<label>
									<input class="ace" type="checkbox" <?php if ($rparameters['planning']==1) echo "checked"; ?> name="planning" value="1">
									<span class="lbl">&nbsp;<?php echo T_('Activer la fonction Calendrier'); ?></span>
									<i title="<?php echo T_('Active la gestion de planning, nouvel onglet et gestion dans les tickets'); ?>" class="icon-question-sign blue"></i>
								</label>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-desktop"></i>
								<?php echo T_('Équipement'); ?>:
							</div>
							<div class="profile-info-value">
								<label>
									<input class="ace" type="checkbox" <?php if ($rparameters['asset']==1) echo "checked"; ?> name="asset" value="1" />
									<span class="lbl">&nbsp;<?php echo T_('Activer la fonction gestion des équipements'); ?></span>
									<i title="<?php echo T_('Active la gestion des équipements, affiche un nouvel item dans le menu de gauche'); ?>." class="icon-question-sign blue"></i>
								</label>	
								<?php
								if ($rparameters['asset']==1)
								{
									echo'
									<div class="space-4"></div>
									&nbsp; &nbsp; &nbsp;<i class="icon-circle green"></i>
									'.T_('Gestion des adresses IP').':&nbsp;
									<label for="asset_ip">
											<input type="radio" class="ace" value="1" name="asset_ip"'; if ($rparameters['asset_ip']==1) {{echo "checked";}} echo '> <span class="lbl"> '.T_('Oui').' </span>
											<input type="radio" class="ace" value="0" name="asset_ip"'; if ($rparameters['asset_ip']==0) echo "checked"; echo '  > <span class="lbl"> '.T_('Non').' </span>
									</label>
									<i title="'.T_('Permet d\'afficher dans la listes des équipements une colonne adresse IP, active les également des champs additionnels sur les fiches des équipements').'" class="icon-question-sign blue"></i>
									<div class="space-4"></div>
									&nbsp; &nbsp; &nbsp;<i class="icon-circle green"></i>
									'.T_('Gestion des garanties').':&nbsp;
									<label for="asset_warranty">
											<input type="radio" class="ace" value="1" name="asset_warranty"'; if ($rparameters['asset_warranty']==1) {{echo "checked";}} echo '> <span class="lbl"> '.T_('Oui').' </span>
											<input type="radio" class="ace" value="0" name="asset_warranty"'; if ($rparameters['asset_warranty']==0) echo "checked"; echo '  > <span class="lbl"> '.T_('Non').' </span>
									</label>
									<i title="'.T_('Affiche un nouvel item dans le menu des équipements, permettant de visualiser les équipements en fin de garantie').'" class="icon-question-sign blue"></i>
									<div class="space-4"></div>
									&nbsp; &nbsp; &nbsp;<i class="icon-circle green"></i>
									'.T_('Importer des équipements').':&nbsp;
									<input style="display:inline" type="file" id="asset_import" name="asset_import" />
									<a title="'.T_('Télécharger le modèle CSV pour ensuite pouvoir lancer l\'import').'" href="./download/tassets_template.csv">'.T_('Modèle').'</a>
									<i title="'.T_('Permet d\'importer des équipements en lot depuis un fichier CSV').'" class="icon-question-sign blue"></i>
									';
								}
								?>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-book"></i>
								<?php echo T_('Procédure'); ?>:
							</div>
							<div class="profile-info-value">
								<label>
									<input class="ace" type="checkbox" <?php if ($rparameters['procedure']==1) echo "checked"; ?> name="procedure" value="1" /> 
									<span class="lbl">&nbsp;<?php echo T_('Activer la fonction').' '.('procédure'); ?></span>
									<i title="<?php echo T_('Active la gestion des procédures'); ?>" class="icon-question-sign blue"></i>
								</label>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> 
								<i class="icon-check"></i>
								<?php echo T_('Sondage'); ?>:
							</div>
							<div class="profile-info-value">
								<label>
									<input class="ace" type="checkbox" <?php if ($rparameters['survey']==1) echo "checked"; ?> name="survey" value="1" /> 
									<span class="lbl">&nbsp;<?php echo T_('Activer la fonction').' '.('sondage'); ?></span>
									<i title="<?php echo T_("Active la gestion d'un sondage utilisateur, permettant à un utilisateur de remplir un questionnaire de satisfaction sur un ticket "); ?>" class="icon-question-sign blue"></i>
								</label>
								<?php
								if ($rparameters['survey']==1)
								{
									echo'
									<div class="space-4"></div>
									&nbsp; &nbsp; &nbsp;<i class="icon-circle green"></i>
									'.T_("Envoyer un mail avec un lien vers le sondage à l'utilisateur lorsque le ticket passe dans l'état").':&nbsp;
									<select name="survey_ticket_state">
										';
									$query = $db->query("SELECT id,name FROM `tstates` ORDER by number");
									while ($row=$query->fetch())
									{
										if ($rparameters['survey_ticket_state']==$row['id']) {$selected='selected';} else {$selected='';}
										echo '<option value="'.$row['id'].'" '.$selected.' >'.$row['name'].'</option>';
									}
									$query->closecursor();
										echo '
									</select>
									<i title="'.T_("Envoi un mail en destination de l'utilisateur lorsque le ticket passe dans l'état sélectionné, exemple état attente retour client").'" class="icon-question-sign blue"></i>
									<div class="space-4"></div>
									&nbsp; &nbsp; &nbsp;<i class="icon-circle green"></i>
									'.T_("Texte du mail envoyé à l'utilisateur pour le sondage").':<i title="'.T_("Modifie l'état du ticket en résolu si l'utilisateur à remplit et validé le sondage").'" class="icon-question-sign blue"></i><br />
									&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<textarea cols="60" rows="3" name="survey_mail_text">'.$rparameters['survey_mail_text'].'</textarea>
									<div class="space-4"></div>&nbsp; &nbsp; &nbsp;<i class="icon-circle green"></i>
									'.T_("Clôturer automatiquement le ticket lorsque le sondage a été validé par l'utilisateur").':&nbsp;
									<label for="survey_auto_close_ticket">
											<input type="radio" class="ace" value="1" name="survey_auto_close_ticket"'; if ($rparameters['survey_auto_close_ticket']==1) {{echo "checked";}} echo '> <span class="lbl"> '.T_('Oui').' </span>
											<input type="radio" class="ace" value="0" name="survey_auto_close_ticket"'; if ($rparameters['survey_auto_close_ticket']==0) echo "checked"; echo '  > <span class="lbl"> '.T_('Non').' </span>
									</label>
									<i title="'.T_("Modifie l'état du ticket en résolu si l'utilisateur à remplit et validé le sondage").'" class="icon-question-sign blue"></i>
									<div class="space-4"></div>
									&nbsp; &nbsp; &nbsp;<i class="icon-circle green"></i>
									'.T_('Listes des questions du sondage').':<br />';
									$query = $db->query("SELECT * FROM `tsurvey_questions` ORDER by number");
									while ($row=$query->fetch())
									{
										echo '<div class="space-4"></div>';
										echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										echo '<input type="text" name="survey_question_number_'.$row['id'].'" size="1" value="'.$row['number'].'"></input>&nbsp;&nbsp;';
										echo '<input type="text" name="survey_question_text_'.$row['id'].'" size="50" value="'.$row['text'].'" ></input>&nbsp;&nbsp;';
										echo 'Type:&nbsp;';
										echo '
											<select name="survey_question_type_'.$row['id'].'" style="width:80px;" >
												<option '; if ($row['type']==1) {echo 'selected';} echo ' value="1">'.T_('Oui/Non').'</option>
												<option '; if ($row['type']==2) {echo 'selected';} echo ' value="2">'.T_('Texte').'</option>
												<option '; if ($row['type']==3) {echo 'selected';} echo ' value="3">'.T_('Liste déroulante').'</option>
												<option '; if ($row['type']==4) {echo 'selected';} echo ' value="4">'.T_('Échelle').'</option>
											</select>
										';
										//display scale size filed if selected
										if($row['type']==4) {echo '&nbsp;&nbsp;Valeur maximum: <input type="text" size="2" name="survey_question_scale_'.$row['id'].'" value="'.$row['scale'].'" />';}
										if($row['type']==3) {
										echo '&nbsp;&nbsp;Choix:&nbsp;
											<input type="text" size="5" name="survey_question_select_1_'.$row['id'].'" value="'.$row['select_1'].'" />
											<input type="text" size="5" name="survey_question_select_2_'.$row['id'].'" value="'.$row['select_2'].'" />
											<input type="text" size="5" name="survey_question_select_3_'.$row['id'].'" value="'.$row['select_3'].'" />
											<input type="text" size="5" name="survey_question_select_4_'.$row['id'].'" value="'.$row['select_4'].'" />
											<input type="text" size="5" name="survey_question_select_5_'.$row['id'].'" value="'.$row['select_5'].'" />
										';
										}
										echo '&nbsp;&nbsp;<a href="./index.php?page=admin&subpage=parameters&tab=function&deletequestion='.$row['id'].'"><i class="icon-trash red bigger-130" title="'.T_('Supprimer la question').'"></i></a>';
										echo '<br />';
									}
									$query->closecursor();
									//display fields for new question
									echo '
										<div class="space-4"></div>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input placeholder="N°" type="text" name="survey_new_question_number" size="1" ></input>&nbsp;
										<input placeholder="'.T_('Texte de la nouvelle question').'" type="text" name="survey_new_question_text" size="50" ></input>&nbsp;
										Type:&nbsp;
										<select name="survey_new_question_type" style="width:80px;">
											<option value="1">'.T_('Oui/Non').'</option>
											<option value="2">'.T_('Texte').'</option>
											<option value="3">'.T_('Liste déroulante').'</option>
											<option value="4">'.T_('Échelle').'</option>
										</select>
									';
									//display export button
									echo '
									<br />
									<br />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button title="'.T_("Télécharger les résultats du sondage au format CSV").'" name="dump_survey" OnClick="window.open(\'./core/export_survey.php?token='.$token.'\')"  value="test_imap" type="submit" class="btn btn-xs btn-info">
											<i class="icon-download-alt bigger-120"></i>
											'.T_("Exporter les résultats").'
										</button>
									<br />
									<br />
									';
								}
								?>
							</div>
								
							<div class="space-4"></div>
							<div class="space-4"></div>
							<div class="space-4"></div>
							<center>
								<button name="submit_function" id="submit_function" value="submit_function" type="submit" class="btn btn-primary">
									<i class="icon-ok bigger-120"></i>
									<?php echo T_('Valider'); ?>
								</button>
							</center>
							<br />
						</div>
					</div>
					<div class="space-4"></div>
				</form>				
			</div>
		</div>
	</div>
</div>