<?php
################################################################################
# @Name : login.php
# @Description : Login page for enter credentials and redirect to register page
# @Call : index.php
# @Parameters : 
# @Author : Flox
# @Create : 07/03/2010
# @Update : 05/05/2017
# @Version : 3.1.21
################################################################################

//initialize variables 
if(!isset($state)) $state = ''; 
if(!isset($userid)) $userid = ''; 
if(!isset($techread)) $techread = '';
if(!isset($findnom)) $findnom = '';
if(!isset($profile)) $profile = '';
if(!isset($newpassword)) $newpassword = '';
if(!isset($salt)) $salt= '';
if(!isset($dcgen)) $dcgen= '';
if(!isset($ldap_type)) $ldap_type= '';
if(!isset($message)) $message= '';
if(!isset($_SESSION['user_id'])) $_SESSION['user_id'] = '';
if(!isset($_SESSION['login'])) $_SESSION['login'] = ''; 
if(!isset($_GET['page'])) $_GET['page'] = ''; 
if(!isset($_GET['state'])) $_GET['state'] = ''; 
if(!isset($_GET['techread'])) $_GET['techread'] = ''; 
if(!isset($_GET['userid'])) $_GET['userid'] = ''; 
if(!isset($_GET['id'])) $_GET['id'] = '';

//default values
if($_GET['state']=='') $_GET['state'] = '%';

//actions on submit
if (isset($_POST['submit'])) {
	$login = (isset($_POST['login'])) ? $_POST['login'] : '';
	$pass =  (isset($_POST['pass']))  ? $_POST['pass']  : '';

	$query = $db->query("SELECT * FROM `tusers` WHERE 1");
	while ($row = $query->fetch()) {
			//uppercase login converter
		$login = strtoupper($login);
		$nom = strtoupper($row['login']);

			//double (OR) test for encrypted password transition
		if ($nom == $login && ($row['password']==$pass || $row['password']==md5($row['salt'] . md5($pass))) && $row['password']!='' && $row['disable']==0) {
			$findnom=$row['login'];
			$findpwd=$row['password'];
			$user_id=$row['id'];
			$profile=$row['profile'];
			$findsalt=$row['salt'];

			//update no encrypted password to encrypted password
			if($row['password']==$pass) {
					//password conversion
					$salt = substr(md5(uniqid(rand(), true)), 0, 5); // Generate a random key
					$newpassword=md5($salt . md5($row['password'])); // store in md5, md5 password + salt
					//update password
					$db->exec("UPDATE tusers SET password='$newpassword', salt='$salt' WHERE id LIKE '$user_id'");
				}
			}	
		}
		if ($findnom != "") {	
			$_SESSION['login'] = "$findnom";
			$_SESSION['user_id'] = "$user_id";
			
			//update last time connection
			$db->exec("UPDATE tusers SET last_login='$datetime' WHERE id LIKE '$user_id'");
			
			echo '<i class="icon-spinner icon-spin"></i>Chargement...';
			
			//user pref default redirection state
			$query=$db->query("SELECT * FROM `tusers` WHERE id=$_SESSION[user_id]");
			$ruser=$query->fetch();
			$query->closeCursor(); 
			if($ruser['default_ticket_state']) $redirectstate=$ruser['default_ticket_state']; else $redirectstate=1;
			
			//select page to redirect for email link case
			if($_GET['id']) {
				$www='./index.php?page=ticket&id='.$_GET['id'].'';
			} else {
				if($redirectstate=='meta_all')
				{
					$www="./index.php?page=dashboard&userid=%&state=meta";
				} else {
					$www="./index.php?page=dashboard&userid=$user_id&state=$redirectstate";
				}
			}
			//web redirection
			echo "<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function redirect()
			{
				window.location='$www'
			}
			setTimeout('redirect()');
		-->
	</SCRIPT>";
} else if (($rparameters['ldap'])=='1' && ($rparameters['ldap_auth']=='1')) {
			/////////// if Gestsup user is not found and LDAP is enable search in LDAP///////////
			// LDAP connect
	$ldap=ldap_connect($rparameters['ldap_server'],$rparameters['ldap_port']) or die("Impossible de se connecter au serveur LDAP.");
	ldap_set_option($ldap, LDAP_OPT_NETWORK_TIMEOUT, 1);
	ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
	$domain=$rparameters['ldap_domain'];
	if ($rparameters['ldap_type']==0) {
		@$ldapbind = ldap_bind($ldap, "$login@$domain", $pass);
	} else {
				//generate DC Chain from domain parameter
		$dcpart=explode(".",$domain);
		$i=0;
		while($i<count($dcpart)) {
			$dcgen="$dcgen,dc=$dcpart[$i]";
			$i++;
		}
		$ldapbind = ldap_bind($ldap, "uid=$login,$rparameters[ldap_url]$dcgen", $pass);	
	}

	if ($ldapbind && $pass!='') {
		$_SESSION['login'] = "$login";

		$query=$db->query("SELECT id FROM tusers where login='$login' AND disable=0");
		$r=$query->fetch();
		$query->closeCursor(); 
		$_SESSION['user_id'] = "$r[0]";
		if($r['0']=='') {
					//if error with login or password 
			$message= '<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">
				<i class="icon-remove"></i>
			</button>
			<strong>
				<i class="icon-remove"></i>
				'.T_('Erreur').'
			</strong>
			'.T_('Votre compte est inexistant dans ce logiciel.').'
			<br>
		</div>';
		$www = "./index.php";
		session_destroy();
					//web redirection to login page
		echo "<SCRIPT LANGUAGE='JavaScript'>
		<!--
		function redirect()
		{
			window.location='$www'
		}
		setTimeout('redirect()',$rparameters[time_display_msg]+1000);
	-->
</SCRIPT>";
} else {			
					//update last time connection
	$db->exec("UPDATE tusers SET last_login='$datetime' WHERE id LIKE '$r[0]'");

					//user pref default redirection state
	$query=$db->query("SELECT * FROM `tusers` WHERE id=$_SESSION[user_id]");
	$ruser=$query->fetch();
	$query->closeCursor();

					//modify redirection to default stat or custom state
	if($ruser['default_ticket_state']) {$redirectstate=$ruser['default_ticket_state'];} else {$redirectstate=1;}

					//select page to redirect for email link case
	if($_GET['id']) {
		$www = './index.php?page=ticket&id='.$_GET['id'].'&userid='.$_SESSION['user_id'];
	} else {
		if($redirectstate=='meta_all')
		{
			$www = "./index.php?page=dashboard&userid=%&state=meta";
		} else {
			$www = "./index.php?page=dashboard&userid=$_SESSION[user_id]&state=$redirectstate";
		}
	}
					//web redirection
	echo "<SCRIPT LANGUAGE='JavaScript'>
	<!--
	function redirect()
	{
		window.location='$www'
	}
	setTimeout('redirect()');
-->
</SCRIPT>";
}
} else {
				// if error with login or password 
	$message= '<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">
		<i class="icon-remove"></i>
	</button>
	<strong>
		<i class="icon-remove"></i>
		'.T_('Erreur').':
	</strong>
	'.T_('Votre nom d\'utilisateur ou mot de passe, n\'est pas correct.').'
</div>';
$www = "./index.php";
session_destroy();
				//web redirection to login page
echo "<SCRIPT LANGUAGE='JavaScript'>
<!--
	function redirect()
	{
		window.location='$www'
	}
	setTimeout('redirect()',$rparameters[time_display_msg]+1000);
-->
</SCRIPT>";
}
}
else
{
			// if error with login or password 
	$message= '<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">
		<i class="icon-remove"></i>
	</button>
	<strong>
		<i class="icon-remove"></i>
		'.T_('Erreur').'
	</strong>
	'.T_('Votre nom d\'utilisateur ou mot de passe, n\'est pas correct.').'
	<br>
</div>';
$www = "./index.php";
session_destroy();
			//web redirection to login page
echo "<SCRIPT LANGUAGE='JavaScript'>
<!--
	function redirect()
	{
		window.location='$www'
	}
	setTimeout('redirect()',$rparameters[time_display_msg]+1000);
-->
</SCRIPT>";
}
}; 
	// if user isn't connected then display authentication else display dashboard
if ($_SESSION['login']=='') 
{
	if($rparameters['ldap_auth']==1) 
	{
		if ($rparameters['ldap_type']==0) $ldap_type='Windows'; else $ldap_type='OpenLDAP';
		$info='<i title="'.T_('Vous pouvez utiliser votre identifiant et mot de passe').' '.$ldap_type.'" class="icon-question-sign smaller-80"></i>';
	} else { $info='';}
	echo '
	<body class="login-layout">
		<br />
		<br />
		<br />
		<br />
		<div class="main-container">
			<div class="main-content" >
				<div class="row"  >
					<div class="col-sm-10 col-sm-offset-1" >
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-ticket green"></i>
									<span title="'.T_('Version').' '.$rparameters['version'].'" class="white">GestSup</span>
								</h1>
								<h4 class="blue">';if (isset($rparameters['company'])) echo $rparameters['company']; echo' </h4>
								';
								//re-size logo if height superior 40px
								if ($rparameters['logo']!='' && file_exists("./upload/logo/$rparameters[logo]")) 
								{
									$size = getimagesize("./upload/logo/$rparameters[logo]");
									$width=$size[0];
									if ($width>300) {$logo_width='width="300"';} else {$logo_width='';}
								} else {$logo_width=''; }
								//display logo if image file exist
								if (file_exists("./upload/logo/$rparameters[logo]"))
								{
									echo '<img style="border-style: none" alt="logo" '.$logo_width.' src="./upload/logo/'; if ($rparameters['logo']=='') echo 'logo.png'; else echo $rparameters['logo'];  echo '" />';
								}
								echo '
							</div>
							<br />
							'.$message.'
							<div class="space-6"></div>
							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-lock green"></i>
												'.T_('Saisissez vos identifiants').'
												'.$info.'
											</h4>
											
											<div class="space-6"></div>
											<form id="conn" method="post" action="">	
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input class="form-control" type="text" id="login" name="login" class="span12" placeholder="'.T_('Nom d\'utilisateur').'" />
															<i class="icon-user"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input class="form-control" type="password" id="pass" name="pass" class="span12" placeholder="'.T_('Mot de passe').'" />
															<i class="icon-lock"></i>
														</span>
													</label>
													<div class="space"></div>
													<div class="clearfix">
														<button onclick="submit()" type="submit" id="submit" name="submit" class="pull-right btn btn-sm btn-primary">
															<i class="icon-ok"></i>
															'.T_('Connexion').'
														</button>
													</div>
													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!--/widget-main-->
										';
										if ($rparameters['user_register']==1)
										{
											echo '
											<div class="toolbar clearfix">
												<div>
													<a href="#" class="forgot-password-link" style="color:#CF7;" data-toggle="modal" data-target="#forgot_password">
														Mot de passe oublié ?
													</a>
												</div>
												<div>
													<a href="./register.php"  class="user-signup-link">
														'.T_('S\'enregistrer').'
														<i class="icon-arrow-right"></i>
													</a>
												</div>
												</div';
											}
											echo '	
										</div><!--/widget-body-->
									</div><!--/login-box-->
								</div><!--/position-relative-->
							</div>
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div>
				<span style="position: absolute; bottom: 0; right: 0;"><a title="'.T_('Ouvre un nouvel onglet vers le site gestsup.fr').'" target="_blank" href="https://gestsup.fr">GestSup.fr</a></span>
			</div><!--/.main-container-->
			'; ?>
			<div class="modal fade" id="forgot_password" role="dialog" >
				<div class="modal-dialog" style="left: 0%;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Réinitialisation mot de passe</h4>
						</div>
						<div class="modal-body">
							<?php

							function chaine_aleatoire($nb_car, $chaine = 'AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbn123456789') {
								$nb_lettres = strlen($chaine) - 1;
								$generation = '';
								for($i=0; $i < $nb_car; $i++) {
									$pos = mt_rand(0, $nb_lettres);
									$car = $chaine[$pos];
									$generation .= $car;
								}
								return $generation;
							}

							$password = chaine_aleatoire(10);
        if (isset($_REQUEST['email']))  { //if "email" variable is filled out, send email

        $query=$db->query("SELECT * FROM `tusers` WHERE mail='$_REQUEST[email]'");
        $ruser=$query->fetch();
        $query->closeCursor(); 

        $userId = $ruser['id'];
        
        $salt = substr(md5(uniqid(rand(), true)), 0, 5); // Generate a random key
        $newpassword=md5($salt . md5($password)); // store in md5, md5 password + salt
        
        $db->exec("UPDATE tusers SET password='$newpassword', salt='$salt',`chgpwd` = '1'  WHERE id LIKE '$userId'"); //update password
        $email = $_REQUEST['email'];
        $subject = "RÃ©initialisation mot de passe DATA";
        $comment = "Bonjour ".$ruser['firstname'].",\n\nVotre mot de passe a ete reinitialisÃ©.\nVous pouvez vous connecter a DATA avec vos login et mot de passe suivant: \n   - Login : ".$ruser["login"]."\n   - Mot de passe : ".$password."\n   - URL : http://10.198.134.33:84/Data/index.php\n\nUne fois connectÃ© une pop-up vous demandera de modifier votre mot de passe. \n\nCordialement, \n\nL'Ã©quipe DATA\n\n\nlien vers la documentation : http://10.198.134.33:84/doc/notice.pdf" ;
        mail($email, utf8_decode($subject), utf8_decode($comment), "From: ecssfrance.webanalyse@orange.com"); //send email
    }
    ?>
    <form method="post">
    	<input name="email" type="mail" size="50" class="pd5" placeholder="Entrez votre adresse mail" />
    	<div class="clear mgb10"></div>
    	<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
    	<input type="submit" class="pull-right btn btn-sm btn-primary" value="Envoyer"/>
    </form>
</div>
</div>
</div>   
</div>
<?php
echo '
<script type="text/JavaScript">
	document.getElementById("login").focus();
</script>
';
}
?>