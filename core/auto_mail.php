<?php
################################################################################
# @Name : /core/auto_mail.php
# @Description : page to send automail
# @Call : ./core/ticket.php
# @Parameters : ticket id destinataires
# @Author : Flox
# @Update : 02/05/2017
# @Version : 3.1.20
################################################################################

//initialize variables 
if(!isset($send)) $send = ''; 

if($rparameters['debug']==1) {echo "<b>AUTO MAIL DETECT</b><br>";}

//check if mail is already sent
$query = $db->query("SELECT * FROM tmails WHERE incident='$_GET[id]'");
$row = $query->fetch();
$query->closeCursor(); 

//case send mail to user where ticket open by technician.
if(($rparameters['mail_auto']==1) && ($row['open']=='') && ($_POST['modify'] || $_POST['quit']))
{
	//check if connect user is the technician and not user 
	if ($_SESSION['profile_id']!=2 && $_SESSION['profile_id']!=3)
	{
		//debug
		if($rparameters['debug']==1) {echo "MAIL: FROM tech TO user (Reason: mail_auto enable, and open detect by technician.) <br />";}
		//auto send open notification mail
		$send=1;
		include('./core/mail.php');
		//insert mail table
		$db->exec("INSERT INTO tmails (incident,open,close) VALUES ('$_GET[id]','1','0')");
	}
}

//case send mail to user where ticket close by technician.
if(($rparameters['mail_auto']==1) && ($_POST['state']=='3') && ($_POST['modify'] || $_POST['quit']))
{
	if ($row['open']=='1')
	{
		//check if is the first close mail
		if ($row['close']=='0')
		{
			//debug
			if($rparameters['debug']==1) {echo "MAIL: FROM tech TO user (Reason: mail_auto enable, and close detect by technician.)<br />";}
			$send=1;
			//auto send close notification mail
			include('./core/mail.php');
			//update mail table
			$db->exec("UPDATE tmails SET close='1' WHERE incident='$_GET[id]'");
		} else {
			//close mail already sent
		}
	} else {
		//close not sent because no open mail was sent
	}
}	

//case send mail to user where technician add thread in ticket.
if (($rparameters['mail_auto_user_modify']==1) && ($_POST['resolution']!='') && ($_POST['resolution']!='\'\'') &&  ($_POST['private']!=1))
{
	//check if user is the technician and not user
	if ($globalrow['user']!=$_SESSION['user_id'])
	{
		//debug
		if($rparameters['debug']==1) {echo "MAIL: FROM tech TO user (Reason: mail_auto_user_modify enable and technician add thread.<br> ";}
		$send=1;
		include('./core/mail.php');
	}
}

//send mail to admin where user open new ticket
if(($rparameters['mail_newticket']==1) && $_POST['send']) 
{
	//debug
	if($rparameters['debug']==1) {echo "MAIL: FROM user TO tech OR parameter_cc (Reason: mail_newticket enable and user open ticket.<br> ";}
	
	//find user name
	$userquery = $db->query("SELECT * FROM tusers WHERE id='$uid'");
	$userrow=$userquery->fetch();
	$query->closeCursor();
	
	////mail parameters
	if($rparameters['mail_from_adr']=='')
	{
		if ($userrow['mail']!='') $from=$userrow['mail']; else $from=$rparameters['mail_cc'];
	} else {
		$from=$rparameters['mail_from_adr'];
	}
	
	$to=$rparameters['mail_newticket_address'];
	$object=T_('Un nouveau ticket à été déclaré par ').$userrow['lastname'].' '.$userrow['firstname'].': '.$_POST['title'];
	$message = '
	'.T_('Le ticket').' n°'.$_GET['id'].' '.T_('à été déclaré par l\'utilisateur').' '.$userrow['lastname'].' '.$userrow['firstname'].'.<br />
	<br />
	<u>'.T_('Objet').':</u><br />
	'.$_POST['title'].'<br />		
	<br />	
	<u>'.T_('Description').':</u><br />
	'.$_POST['text'].'<br />
	<br />
	'.T_('Pour plus d\'informations vous pouvez consulter le ticket sur').' <a href="'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'">'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'</a>.
	';
	require('./core/message.php');
}

//send mail to admin where user add thread in ticket
if(($rparameters['mail_auto_tech_modify']==1) && $_POST['modify'] &&  (($_POST['resolution']!='') && ($_POST['resolution']!='\'\'')))
{
	//debug
	if($rparameters['debug']==1) {echo "MAIL: FROM user TO tech  (Reason: mail_auto_tech_modify enable and user add thread in ticket.)<br> ";}

	//check if current user add this thread
	if ($globalrow['user']==$_SESSION['user_id'])
	{
		//find user name
		$userquery = $db->query("SELECT * FROM tusers WHERE id='$uid'");
		$userrow=$userquery->fetch();
		$userquery->closeCursor();
		
		//get user mail
		if($rparameters['mail_from_adr']=='')
		{
			if ($userrow['mail']!='') $from=$userrow['mail']; else $from=$rparameters['mail_cc'];
		} else {
			$from=$rparameters['mail_from_adr'];
		}
		//get tech mail 
		$techquery = $db->query("SELECT * FROM tusers WHERE id='$globalrow[technician]'");
		$techrow=$techquery->fetch();
		$techquery->closeCursor();
		
		$to=$techrow['mail'];
		$object=T_('Votre ticket').' n°'.$_GET['id'].': '.$_POST['title'].' '.T_('à été modifié par').' '.$userrow['lastname'].' '.$userrow['firstname'];
		//remove single quote in post data
		$resolution = str_replace("'", "", $_POST['resolution']);
		$title = str_replace("'", "", $_POST['title']);
		$message = '
		'.T_('Le ticket').' n°'.$_GET['id'].' '.T_('à été modifié par l\'utilisateur').' '.$userrow['lastname'].' '.$userrow['firstname'].'.<br />
		<br />
		<u>'.T_('Objet').':</u><br />
		'.$title.'<br />		
		<br />	
		<u>'.T_('Ajout du commentaire').':</u><br />
		'.$resolution.'<br />
		<br />
		'.T_('Pour plus d\'informations vous pouvez consulter le ticket sur').' <a href="'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'">'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'</a>.
		';
		require('./core/message.php');
	}
}

//send mail to admin where user add thread in ticket
if(($rparameters['survey']==1) && ($_POST['modify'] || $_POST['quit']) && ($_POST['state']==$rparameters['survey_ticket_state']))
{
	//debug
	if($rparameters['debug']==1) {echo "MAIL: FROM tech TO user (Reason: survey enable and technician switch ticket in state $rparameters[survey_ticket_state].)<br> ";}
	
	//check if survey answer already exist for this ticket
	$query = $db->query("SELECT ticket_id FROM tsurvey_answers WHERE ticket_id='$_GET[id]'");
	$row=$query->fetch();
	$query->closeCursor();
	if(!$row)
	{
		//insert a token
		$token=uniqid(); 
		$db->exec("INSERT INTO ttoken (token,action,ticket_id) VALUES ('$token','survey','$_GET[id]')");

		//get user mail
		$query = $db->query("SELECT mail FROM tusers WHERE id=(SELECT user FROM tincidents WHERE id='$_GET[id]')");
		$usermail=$query->fetch();
		$query->closeCursor();
		
		//get tech mail 
		$query = $db->query("SELECT mail FROM tusers WHERE id=(SELECT technician FROM tincidents WHERE id='$_GET[id]')");
		$techmail=$query->fetch();
		$query->closeCursor();
		
		$from=$techmail['mail'];
		$to=$usermail['mail'];
		$object=T_("Sondage concernant votre ticket n°").$_GET['id'];
		$message=$rparameters['survey_mail_text'].'
		<br />
		<a href="'.$rparameters['server_url'].'/survey.php?token='.$token.'">'.T_('Répondre au sondage').'</a>
		';
		require('./core/message.php');
	}
}
?>