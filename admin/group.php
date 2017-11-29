<?php
################################################################################
# @Name : group.php
# @Description : group management 
# @call : admin.php
# @parameters : 
# @Author : Flox
# @Create : 06/07/2013
# @Update : 17/04/2017
# @Version : 3.1.20
################################################################################

//initialize variables 
if(!isset($_POST['Modifier'])) $_POST['Modifier'] = '';
if(!isset($_POST['cancel'])) $_POST['cancel'] = '';
if(!isset($_POST['type'])) $_POST['type'] = '';
if(!isset($_POST['service'])) $_POST['service'] = '';
if(!isset($_POST['add'])) $_POST['add'] = '';
if(!isset($_GET['user'])) $_GET['user'] = '';
if(!isset($_GET['type'])) $_GET['type'] = ''; 

//default values
if($_GET['type']=='') $_GET['type']=0;

//display debug informations
if($rparameters['debug']==1) {
	echo '<u><b>DEBUG MODE:</b></u><br /> <b>VAR:</b> cnt_service='.$cnt_service;
	if($user_services) {echo ' user_services=';foreach($user_services as $value) {echo $value.' ';}}
}

//security check
if ($rright['admin']!=0 || ($rright['admin_groups']!=0 && $cnt_service!=0))
{
	//submit actions
	if($_POST['Modifier'])
	{
		//escape special char and secure string before database insert
		$_POST['name']=strip_tags($db->quote($_POST['name']));
		//update name
		$db->exec("UPDATE tgroups SET name=$_POST[name], type='$_POST[type]', service='$_POST[service]' WHERE id LIKE '$_GET[id]'");
		//add user
		if ($_POST['user']){$db->exec("INSERT INTO tgroups_assoc (`group`,`user`) VALUES ('$_GET[id]',$_POST[user])");}
	}

	if($_POST['add'])
	{
		//escape special char in sql query 
		$_POST['name']=strip_tags($db->quote($_POST['name']));
		//update name
		$db->exec("INSERT INTO tgroups (`name`,`type`,`service`) VALUES ($_POST[name],'$_POST[type]', '$_POST[service]')");
		//redirect
		$www = "./index.php?page=admin&subpage=group";
		echo '<script language="Javascript">
		<!--
		document.location.replace("'.$www.'");
		// -->
		</script>';
	}

	if($_POST['cancel']){
		//redirect to group list
		$www = "./index.php?page=admin&subpage=group";
		echo '<script language="Javascript">
		<!--
		document.location.replace("'.$www.'");
		// -->
		</script>';
	}

	//delete user in group
	if ($_GET['action']=="delete" && $_GET['user']!="")
	{
		$db->exec("DELETE FROM tgroups_assoc WHERE `group`='$_GET[id]' AND `user`='$_GET[user]'");
		//redirection vers la page d'accueil
		$www = "./index.php?page=admin&subpage=group&action=edit&id=$_GET[id]";
		echo '<script language="Javascript">
		<!--
		document.location.replace("'.$www.'");
		// -->
		</script>';
	}

	//delete group
	if ($_GET['action']=="delete" && $_GET['user']=="")
	{
		$db->exec("UPDATE tgroups SET disable='1' WHERE `id`='$_GET[id]'");
		//redirection vers la page d'accueil
		$www = "./index.php?page=admin&subpage=group";
		echo '<script language="Javascript">
		<!--
		document.location.replace("'.$www.'");
		// -->
		</script>';
	}


	//display head page
	//count group
	$query = $db->query("SELECT COUNT(*) FROM tgroups where disable='0'");
	$row = $query->fetch();
	$query->closeCursor(); 
	echo '
	<div class="page-header position-relative">
		<h1>
			<i class="icon-group"></i>  '.T_('Gestion des groupes').'
			<small>
				<i class="icon-double-angle-right"></i>
				&nbsp;'.T_('Nombre').': '.$row[0].'
			</small>
		</h1>
	</div>';


	//edit group
	if ($_GET['action']=='edit')
	{
		//Get group data
		$qgroup = $db->query("SELECT * FROM `tgroups` where id LIKE '$_GET[id]'"); 
		$rgroup = $qgroup->fetch();
		
		//display edit form
		echo '
			<div class="col-sm-5">
				<div class="widget-box">
					<div class="widget-header">
						<h4>'.T_('Édition d\'un groupe').':</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main no-padding">
							<form id="1" name="form" method="post"  action="">
								<fieldset>
									<label for="name">'.T_('Nom').':</label>
									<input name="name" type="text" value="'; if($rgroup['name']) echo "$rgroup[name]"; echo'" />
								</fieldset>
								';
								if ($rparameters['user_limit_service']==1 && ($rright['admin_groups']!=0 || $rright['admin']!=0))
								{
									//find current service associated with group
									$query = $db->query("SELECT service FROM tgroups WHERE id='$_GET[id]' and disable='0'"); 
									$row = $query->fetch();
									$query->closeCursor(); 
									if ($cnt_service<=1 && $rright['admin']==0) //not show select field, if there are only one service, send data in background
									{
										echo '<input type="hidden" name="service" value="'.$row[0].'" />'; 
									} elseif($cnt_service>1 || $rright['admin']!=0) { //display select box for service
										echo '
											<fieldset>
												<label for="service">'.T_('Service').'</label>
												<select name="service" id="form-field-select-1" >
												';
													if($rright['dashboard_service_only']!=0 && $rparameters['user_limit_service']==1) {
														//display only service associated with this user
														$query2 = $db->query("SELECT tservices.id,tservices.name FROM `tservices`,`tusers_services` WHERE tservices.id=tusers_services.service_id AND tusers_services.user_id='$_SESSION[user_id]' AND tservices.disable='0' ORDER BY tservices.name"); 
													} else {
														//display all services
														$query2 = $db->query("SELECT id,name FROM `tservices` WHERE disable='0' ORDER BY name"); 
													}
													while ($row2=$query2->fetch()) 
													{
														echo '
														<option '; if ($row['service']==$row2['id']) {echo 'selected';} echo ' value="'.$row2['id'].'">
															'.$row2['name'].'
														</option>';
													}
													$query2->closeCursor();
												echo '
												</select>
											</fieldset>
										';
									}
								}
								echo '
								<div class="radio">
									<label>
										<input value="0" '; if ($rgroup['type']=='0')echo "checked"; echo ' name="type" type="radio" class="ace">
										<span class="lbl"> '.T_('Groupe d\'utilisateurs').'</span>
									</label>
								</div>
								<div class="radio">
									<label>
										<input value="1" '; if ($rgroup['type']=='1')echo "checked"; echo ' name="type" type="radio" class="ace">
										<span class="lbl"> '.T_('Groupe de techniciens').'</span>
									</label>
								</div>
								<fieldset>
									<label for="user">'.T_('Ajout d\'un nouveau membre').':</label>
									<select name="user" >
										<option value=""></option>';
										//display technician or user list
										if($rgroup['type']=='1')
										{$query = $db->query("SELECT * FROM tusers WHERE disable=0 AND (profile=0 OR profile=4) ORDER BY lastname");}
										else
										{$query = $db->query("SELECT * FROM tusers WHERE disable=0 AND (profile!=0 AND profile!=4) ORDER BY lastname");}
										while ($row=$query->fetch()) 
										{
											echo "<option value=\"$row[id]\">$row[lastname] $row[firstname]</option>";
										} 
										$query->closeCursor(); 
									echo '
									</select>
								</fieldset>
								<fieldset>
								<label for="name">'.T_('Membres actuels').':</label><br />';
									//display current users in this group
									$quser = $db->query("SELECT tusers.firstname, tusers.lastname, tusers.id FROM `tusers`,tgroups_assoc WHERE tusers.id=tgroups_assoc.user AND tgroups_assoc.group=$_GET[id] AND tusers.disable=0");
									while ($ruser=$quser->fetch()) 
									{
										echo '<i class="icon-caret-right blue"></i> <a title="'.T_('Fiche Utilisateur').'" href="./index.php?page=admin&subpage=user&action=edit&userid='.$ruser[2].'" >'.$ruser[0].' '.$ruser[1].'</a> 
										<a title="'.T_('Enlever l\'utilisateur du groupe').'" href="./index.php?page=admin&amp;subpage=group&amp;id='.$_GET['id'].'&amp;user='.$ruser[2].'&amp;action=delete"><i class="icon-trash red bigger-120"></i></a><br />';
									}
									$quser->closeCursor(); 
									echo '
								</fieldset>
								<div class="form-actions center">
									<button name="Modifier" value="Modifier" id="Modifier" type="submit" class="btn btn-sm btn-success">
										<i class="icon-ok bigger-120"></i>
										'.T_('Modifier').'
									</button>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<button name="cancel" value="cancel" type="submit" class="btn btn-sm btn-danger" >
										<i class="icon-undo bigger-120"></i>
										'.T_('Retour').'
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		';
	//display add form
	} else if($_GET['action']=="add") {
		echo '
			<div class="col-sm-5">
				<div class="widget-box">
					<div class="widget-header">
						<h4>'.T_('Édition d\'un groupe').':</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main no-padding">
							<form id="1" name="form" method="post"  action="">
								<fieldset>
									<label for="name">'.T_('Nom').':</label>
									<input name="name" type="text" value="" />
								</fieldset>
								';
								if ($rparameters['user_limit_service']==1 && ($rright['admin_groups']!=0 || $rright['admin']!=0))
								{
									//find current service associated with group
									$query = $db->query("SELECT service FROM tgroups WHERE id='$_GET[id]' and disable='0'"); 
									$row = $query->fetch();
									$query->closeCursor(); 
								if ($cnt_service<=1 && $rright['admin']==0) //not show select field, if there are only one service, send data in background
									{
										echo '<input type="hidden" name="service" value="'.$user_services[0].'" />'; 
									} elseif($cnt_service>1 || $rright['admin']!=0) { //display select box for service
										echo '
											<fieldset>
												<label for="service">'.T_('Service').'</label>
												<select name="service" id="form-field-select-1" >
												';
													if($rright['dashboard_service_only']!=0 && $rparameters['user_limit_service']==1) {
														//display only service associated with this user
														$query2 = $db->query("SELECT tservices.id,tservices.name FROM `tservices`,`tusers_services` WHERE tservices.id=tusers_services.service_id AND tusers_services.user_id='$_SESSION[user_id]' AND tservices.disable='0' ORDER BY tservices.name"); 
													} else {
														//display all services
														$query2 = $db->query("SELECT id,name FROM `tservices` WHERE disable='0' ORDER BY name"); 
													}
													while ($row2=$query2->fetch()) 
													{
														echo '
														<option '; if ($row['service']==$row2['id']) {echo 'selected';} echo ' value="'.$row2['id'].'">
															'.$row2['name'].'
														</option>';
													}
													$query2->closeCursor();
												echo '
												</select>
											</fieldset>
										';
									}
								}
								echo '
								<div class="radio">
									<label>
										<input value="0" name="type" type="radio" class="ace">
										<span class="lbl"> '.T_('Groupe d\'utilisateur').'</span>
									</label>
								</div>
								<div class="radio">
									<label>
										<input value="1" name="type" type="radio" class="ace">
										<span class="lbl"> '.T_('Groupe de techniciens').'</span>
									</label>
								</div>
								<div class="form-actions center">
									<button name="add" value="add" id="add" type="submit"  class="btn btn-sm btn-success">
										<i class="icon-ok bigger-120"></i>
										'.T_('Ajouter').'
									</button>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<button name="cancel" value="cancel" type="submit" class="btn btn-sm btn-danger" >
										<i class="icon-reply bigger-120"></i>
										'.T_('Retour').'
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		';
	} else {
		//display group list
		echo'
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<p>
				<button onclick=\'window.location.href="index.php?page=admin&subpage=group&action=add";\' class="btn btn-sm btn-success">
					<i class="icon-plus"></i>'.T_('Ajouter un groupe').'
				</button>
			</p>
		</div>
		<br />';
		//display user table
		echo'
		<div class="col-sm-6">
			<div class="tabbable">
				<ul class="nav nav-tabs" id="myTab">';
					if($_GET['type']==0) {echo '<li class="active" >';} else {echo '<li>';} echo '
						<a  href="./index.php?page=admin&subpage=group&type=0">
							<i class="green icon-group bigger-110"></i>
							'.T_('Groupe d\'utilisateurs').'
						</a>
					</li>';
					if($_GET['type']==1) {echo '<li class="active" >';} else {echo '<li>';} echo '
						<a href="./index.php?page=admin&subpage=group&type=1">
							<i class="green icon-group bigger-110"></i>
							'.T_('Groupe de techniciens').'
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<table id="sample-table-1" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>'.T_('Nom').'</th>
								<th>'.T_('Membres').'</th>
								';
								if ($rparameters['user_limit_service']==1) {echo '<th>'.T_('Service').'</th>';}
								echo '
								<th>'.T_('Actions').'</th>
							</tr>
						</thead>
						<tbody>';
							//build each line
							$qgroup = $db->query("SELECT * FROM `tgroups` WHERE type=$_GET[type] AND disable='0' ORDER BY type,name ");
							while ($rgroup=$qgroup->fetch()) 
							{
								echo "
								<tr>
									<td onclick=\"document.location='./index.php?page=admin&amp;subpage=group&amp;action=edit&amp;id=$rgroup[id]'\">
										$rgroup[name]
									</td>
									<td onclick=\"document.location='./index.php?page=admin&amp;subpage=group&amp;action=edit&amp;id=$rgroup[id]'\">";
										$quser = $db->query("SELECT tusers.firstname, tusers.lastname FROM `tusers`,tgroups_assoc WHERE tusers.id=tgroups_assoc.user AND tgroups_assoc.group=$rgroup[id] AND tusers.disable=0");
										while ($ruser=$quser->fetch()) 
										{
											echo "$ruser[0] $ruser[1]<br />";
										}
										echo '
									</td>
									';
									//display associated service if parameter is enable
									if ($rparameters['user_limit_service']==1) { 
										//find value
										$query = $db->query("SELECT tservices.name FROM `tservices` WHERE id=(SELECT service FROM tgroups WHERE id='$rgroup[id]' AND disable='0')"); 
										$row = $query->fetch();
										$query->closeCursor(); 
										echo '<td>'.$row['name'].'</td>';
									}
									echo '
									<td>
										<button title="'.T_('Éditer').'" onclick=\'window.location.href="./index.php?page=admin&amp;subpage=group&amp;action=edit&amp;id='.$rgroup['id'].'";\' class="btn btn-xs btn-warning">
											<i class="icon-pencil bigger-120"></i>
										</button>
										<button title="'.T_('Supprimer').'" onclick=\'window.location.href="./index.php?page=admin&amp;subpage=group&amp;id='.$rgroup['id'].'&amp;action=delete";\' class="btn btn-xs btn-danger">
											<i class="icon-trash bigger-120"></i>
										</button>
									</td>
								</tr>';
							}
							$qgroup->closeCursor(); 
							echo '
						</tbody>
					</table>
				</div>
			</div>
		</div>
		';
	}
} else {
	echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Erreur').':</strong> '.T_("Vous n'avez pas le droit d'accès à ce menu, ou vous ne disposer d'aucun service associé, contacter votre administrateur").'.<br></div>';
}
?>