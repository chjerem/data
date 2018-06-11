<?php
################################################################################
# @Name : kanban.php
# @Desc : Affiche les tickets sous forme de kanban
# @call : /menu.php
# @parameters : 
# @Author : Boris MA
# @Create : 20/04/2017
# @Update : 20/04/2017
# @Version : 1.0
# @VersionGestsupValidée : 3.1.15
################################################################################

//initialize variables 
if(!isset($asc)) $asc = ''; 
if(!isset($img)) $img= '';   
if(!isset($from)) $from=''; 
if(!isset($filter)) $filter=''; 
if(!isset($col)) $col=''; 
if(!isset($view)) $view=''; 
if(!isset($nkeyword)) $nkeyword=''; 
if(!isset($rowlastname)) $rowlastname=''; 
if(!isset($resultcriticality['color'])) $resultcriticality['color']= ''; 
if(!isset($displayusername)) $displayusername= ''; 
if(!isset($displaytechname)) $displaytechname= ''; 
if(!isset($u_group)) $u_group= ''; 
if(!isset($t_group)) $t_group= ''; 
if(!isset($techread)) $techread= '';  
if(!isset($start_page)) $start_page= '';  
if(!isset($cursor)) $cursor= '';  
if(!isset($type)) $type= '';  
if(!isset($demandeur)) $demandeur= '';  

if(!isset($_GET['ticket'])) $_GET['ticket']= '';
if(!isset($_GET['technician'])) $_GET['technician']= ''; 
if(!isset($_GET['u_group'])) $_GET['u_group']= ''; 
if(!isset($_GET['t_group'])) $_GET['t_group']= ''; 
if(!isset($_GET['category'])) $_GET['category']= ''; 
if(!isset($_GET['subcat'])) $_GET['subcat']= ''; 
if(!isset($_GET['place'])) $_GET['place']= ''; 
if(!isset($_GET['cursor'])) $_GET['cursor']= ''; 
if(!isset($_GET['searchengine'])) $_GET['searchengine'] = ''; 
if(!isset($_GET['user'])) $_GET['user'] = ''; 
if(!isset($_GET['date_create'])) $_GET['date_create'] = ''; 
if(!isset($_GET['date_res'])) $_GET['date_res'] = ''; 
if(!isset($_GET['date_hope'])) $_GET['date_hope'] = ''; 
if(!isset($_GET['state'])) $_GET['state'] = ''; 
if(!isset($_GET['priority'])) $_GET['priority'] = ''; 
if(!isset($_GET['title'])) $_GET['title'] = ''; 
if(!isset($_GET['criticality'])) $_GET['criticality'] = ''; 
if(!isset($_GET['place'])) $_GET['place'] = ''; 
if(!isset($_GET['way'])) $_GET['way'] = ''; 
if(!isset($_GET['order'])) $_GET['order'] = ''; 
if(!isset($_GET['techread'])) $_GET['techread'] = ''; 
if(!isset($_GET['companyview'])) $_GET['companyview'] = ''; 
if(!isset($_GET['techgroup'])) $_GET['techgroup'] = ''; 

//get value is for filter case
if(!isset($_POST['date'])) $_POST['date']= '';
if(!isset($_POST['selectrow'])) $_POST['selectrow']= '';
if(!isset($_POST['ticket'])) $_POST['ticket']= $_GET['ticket'];
if(!isset($_POST['technician'])) $_POST['technician']= $_GET['technician'];
if(!isset($_POST['title'])) $_POST['title']= $_GET['title'];
if(!isset($_POST['ticket'])) $_POST['ticket']= '';
if(!isset($_POST['userid'])) $_POST['userid']= '';	
if(!isset($_POST['user'])) $_POST['user']= $_GET['user'];
if(!isset($_POST['category'])) $_POST['category']= $_GET['category'];
if(!isset($_POST['subcat'])) $_POST['subcat']= $_GET['subcat'];
if(!isset($_POST['place'])) $_POST['place']= $_GET['place'];
if(!isset($_POST['date_create'])) $_POST['date_create'] =$_GET['date_create']; 
if(!isset($_POST['date_hope'])) $_POST['date_hope'] =$_GET['date_hope']; 
if(!isset($_POST['date_res'])) $_POST['date_res'] =$_GET['date_res']; 
if(!isset($_POST['state'])) $_POST['state']= $_GET['state'];
if(!isset($_POST['priority'])) $_POST['priority']=$_GET['priority'];
if(!isset($_POST['criticality'])) $_POST['criticality']=$_GET['criticality']; 
if(!isset($_POST['place'])) $_POST['place']=$_GET['place']; 
if(!isset($_POST['u_group'])) $_POST['u_group']=$_GET['u_group']; 
if(!isset($_POST['t_group'])) $_POST['t_group']=$_GET['t_group']; 
if(!isset($_POST['type'])) $_POST['type']=$_GET['type']; 
if(!isset($_POST['demandeur'])) $_POST['demandeur']=$_GET['demandeur']; 

//default values
if ($techread=='') $techread='%';
if ($state=='')$state='%';
if($_GET['way']=='') $_GET['way']='DESC';	
if($_GET['category']=='') $_GET['category']= '%'; 
if($_GET['t_group']=='') $_GET['t_group']= '%'; 
if($_GET['u_group']=='') $_GET['u_group']= '%'; 
if($_GET['subcat']=='') $_GET['subcat']= '%';
if($_GET['place']=='') $_GET['place']= '%';
if($_GET['cursor']=='') $_GET['cursor']='0'; 
if($_GET['techread']=='') $_GET['techread']='%';
if($_POST['criticality']=='') $_POST['criticality']= '%'; 
if($_POST['priority']=='') $_POST['priority']='%';
if($_POST['state']=='') {$_POST['state']='%'; }
if($_POST['type']=='') {$_POST['type']='%'; }
if($_POST['demandeur']=='') {$_POST['demandeur']='%'; }

//avoid page 2 bug when technician switch
if (($_POST['technician']!=$_GET['technician']) && ($_GET['cursor']!=0)) {$_GET['cursor']=0;} 

//default values check user profil parameters

//if admin user
if($_SESSION['profile_id']==0 || $_SESSION['profile_id']==4)
{
	if($_POST['technician']=='') $_POST['technician']= $_GET['userid'];
	if($_POST['user']=='') $_POST['user']= '%'; 	
} else {
	if($_POST['user']=='') $_POST['user']= $_GET['userid'];
	if($_POST['technician']=='') $_POST['technician']= '%';
}

if ($_GET['date_create']=='current') 
{
	$_POST['date_create']=date("Y-m-d") ;
	$_POST['date_res']=date("Y-m-d") ;
} else {
	if($_POST['date_create']=='') $_POST['date_create']= '%'; 
	if($_POST['date_res']=='') $_POST['date_res']= '%'; 
}

if($_POST['title']=='') $_POST['title']= '%'; 
if($_POST['ticket']=='') $_POST['ticket']= '%'; 
if($_POST['userid']=='') $_POST['userid']= '%'; 
if($_POST['category']=='') $_POST['category']= '%'; 
if($_POST['subcat']=='') $_POST['subcat']= '%';
if($_POST['place']=='') $_POST['place']= '%';

//technician and technician group separate
if(substr($_POST['technician'], 0, 1) =='G') 
{
 	$t_group = explode("_", $_POST['technician']);
	$t_group=$t_group[1];
	$_GET['t_group']=$t_group;
	$_POST['technician']='%';
}
//user and user group separate
if(substr($_POST['user'], 0, 1) =='G') 
{
 	$u_group = explode("_", $_POST['user']);
	$u_group=$u_group[1];
	$_GET['u_group']=$u_group;
	$_POST['user']='%';
}
//special case to filter technician group is send
if (($rright['side_your_tech_group']!=0) && ($_GET['techgroup']!=0))
{
	$_POST['technician']="%";
}

//select order 
if (($filter=='on' || $_GET['order']=='')){
    if($ruser['dashboard_ticket_order']) 
	{
		$_GET['order']=$ruser['dashboard_ticket_order'];
		$_GET['way']='ASC';
	} else {
		//modify order to resolv date for state 3 and 4 
		if(preg_match("#tstates.number, tincidents.date_hope#i", "'.$rparameters[order].'") && (($_GET['state']==3) || ($_GET['state']==4)))
		{
			$_GET['order']='tincidents.date_res';
			$_GET['way']='DESC';
		} else {
			$_GET['order']=$rparameters['order'];
		}
	}
}
elseif ($_GET['order']=='')
{$_GET['order']='priority';}

//meta state generation
if($_GET['state']=='meta')
{
    $state="AND	(tincidents.state LIKE 1 OR tincidents.state LIKE 2 OR tincidents.state LIKE 6)";  
    //change order in this case
    if ($_GET['order']=='tstates.number, tincidents.priority, tincidents.criticality, tincidents.date_create') {$_GET['order']='tincidents.priority, tincidents.criticality, tincidents.date_create';}
    if ($_GET['order']=='tstates.number, tincidents.priority, tincidents.criticality, tincidents.date_hope') {$_GET['order']='tincidents.priority, tincidents.criticality, tincidents.date_hope';}
    if ($_GET['order']=='tstates.number, tincidents.date_hope, tincidents.priority, tincidents.criticality') {$_GET['order']='tincidents.date_hope, tincidents.priority, tincidents.criticality';}
    if ($_GET['order']=='tstates.number, tincidents.date_hope, tincidents.criticality, tincidents.priority') {$_GET['order']='tincidents.date_hope, tincidents.criticality, tincidents.priority';}
    if ($_GET['order']=='tstates.number, tincidents.criticality, tincidents.date_hope, tincidents.priority') {$_GET['order']='tincidents.criticality, tincidents.date_hope, tincidents.priority';}
} else {
    $state='AND	tincidents.state LIKE \''.$_POST['state'].'\'';
}

//load in url parameter of filter, for using back button of browser on ticket page
if(($_POST['ticket']!='%' && $_GET['ticket']=='%') || ($_POST['technician']!='%' && $_GET['technician']=='%')|| ($_POST['user']!='%' && $_GET['user']=='%')|| ($_POST['category']!='%' && $_GET['category']=='%')|| ($_POST['subcat']!='%' && $_GET['subcat']=='%')|| ($_POST['title']!='%' && $_GET['title']=='%')|| ($_POST['priority']!='%' && $_GET['priority']=='%')|| ($_POST['criticality']!='%' && $_GET['criticality']=='%')|| ($_POST['place']!='%' && $_GET['place']=='%'))
{
	$url="index.php?page=dashboard&userid=$_GET[userid]&state=$_GET[state]&viewid=$_GET[viewid]&ticket=$_POST[ticket]&technician=$_POST[technician]&user=$_POST[user]&category=$_POST[category]&subcat=$_POST[subcat]&title=$_POST[title]&date_create=$_POST[date_create]&priority=$_POST[priority]&criticality=$_POST[criticality]&place=$_POST[place]&companyview=$_GET[companyview]";
	//redirect
	echo "<SCRIPT LANGUAGE='JavaScript'>
				<!--
				function redirect()
				{
				window.location='$url'
				}
				setTimeout('redirect()',0);
				-->
		</SCRIPT>";
}

///// SQL QUERY
		//Date conversion for filter line
		if ($_POST['date_create']!='%')
		{
			$date_create=$_POST['date_create'];
			$find='/';
			$find= strpos($date_create, $find);
			if ($find!=false)
			{			
				$date_create=explode("/",$date_create);
				$_POST['date_create']="$date_create[2]-$date_create[1]-$date_create[0]";
			}
		}
		if ($_POST['date_hope']!='%')
		{
			$date_hope=$_POST['date_hope'];
			$find='/';
			$find= strpos($date_hope, $find);
			if ($find!=false)
			{			
				$date_hope=explode("/",$date_hope);
				$_POST['date_hope']="$date_hope[2]-$date_hope[1]-$date_hope[0]";
			}
		}
		if ($_POST['date_res']!='%')
		{
			$date_res=$_POST['date_res'];
			$find='/';
			$find= strpos($date_res, $find);
			if ($find!=false)
			{			
				$date_res=explode("/",$date_res);
				$_POST['date_res']="$date_res[2]-$date_res[1]-$date_res[0]";
			}
		}
		if ($keywords)
		{
			include "./core/searchengine_ticket.php";
		} else {
			//build SQL query
			$select= "DISTINCT tincidents.*";
			$from="tincidents";
			$join='LEFT JOIN tstates ON tincidents.state=tstates.id ';
			$where="
			tincidents.user LIKE '$_POST[user]'
			AND	tincidents.disable='0'
			AND	tincidents.u_group LIKE '$_GET[u_group]'
			AND	tincidents.technician LIKE '$_POST[technician]'
			AND	tincidents.t_group LIKE '$_GET[t_group]'
			AND	tincidents.techread LIKE '$_GET[techread]'
			AND	tincidents.category LIKE '$_POST[category]'
			AND	tincidents.subcat LIKE '$_POST[subcat]'
			AND	tincidents.id LIKE '$_POST[ticket]'
			AND	tincidents.user LIKE '$_POST[userid]'
			AND tincidents.date_hope LIKE '$_POST[date_hope]%'
			AND	tincidents.type LIKE '$_POST[priority]'
			AND	tincidents.criticality LIKE '$_POST[criticality]'
			AND	tincidents.type LIKE '$_POST[type]'
			AND	tincidents.user LIKE '$_POST[demandeur]'
			AND	tincidents.title LIKE '%$_POST[title]%'
			$state
			";
			//special case to filter query when company view is selected
			if (($rparameters['user_company_view']==1) && ($rright['side_company']!=0) && ($_GET['companyview']==1))
			{
				$join.='LEFT JOIN tusers ON tincidents.user=tusers.id ';
				$where.="AND tusers.company='$ruser[company]' ";
			}
			//special case to filter query when place view is selected
			if($rparameters['ticket_places']==1){$where.="AND tincidents.place LIKE '%$_POST[place]%' ";}
			//special case to filter query when for today tickets
			if ($_GET['date_create']=='current')
			{
				$where.="AND (tincidents.date_create LIKE '$_POST[date_create]%' OR tincidents.date_res LIKE '$_POST[date_create]%')";
			} else {
				$where.="AND tincidents.date_create LIKE '$_POST[date_create]%' AND tincidents.date_res LIKE '$_POST[date_res]%'";
			}
			//special case to filter technician group is send
			if (($rright['side_your_tech_group']!=0) && ($_GET['techgroup']!=0))
			{
				$where.="AND tincidents.t_group='$_GET[techgroup]' ";
			}
		}
		
		if ($rparameters['debug']==1)
		{
			$where_debug=str_replace("AND", "AND <br />",$where);
			$where_debug=str_replace("OR", "OR <br />",$where_debug);
			$join_debug =str_replace("LEFT", "<br />LEFT",$join);
			echo "
			<b><u>DEBUG MODE:</u></b><br />
			<b>SELECT</b> $select<br />
			<b>FROM</b> $from
			$join_debug<br />
			<b>WHERE</b> <br />
			$where_debug<br />
			<b>ORDER BY</b> $_GET[order] $_GET[way]<br />
			<b>LIMIT</b> $_GET[cursor],	$rparameters[maxline]<br />
			";
		}
			
		//count current query
		$query_count="SELECT COUNT(DISTINCT tincidents.id) FROM $from $join WHERE $where";
		$query=$db->query("$query_count");
        $resultcount=$query->fetch();
        $query->closeCursor(); 
		
		$masterquery = $db->query("
		SELECT $select
		FROM $from
		$join
		WHERE $where
		ORDER BY $_GET[order] $_GET[way]
		LIMIT $_GET[cursor],
		$rparameters[maxline]
		"); 
		
?>

<div class="page-header position-relative">
	<h1>
		<i class="icon-table"></i>  Kanban 
		<div class="pull-right">
			<div style="font-size:14px;">
				Code couleur des tickets :
				
				
				<div style="background:#ffffaa; height:10px; width:10px; display:inline-block;
				    box-shadow: 0px 1px 1px 1px ##c3c3c3; margin-left:8px;"></div> Normal
				<div style="background:#ffbfbf; height:10px; width:10px; display:inline-block;
				    box-shadow: 0px 1px 1px 1px ##c3c3c3; margin-left:8px;"></div> Critique
				<div style="background:#c5d0dc; height:10px; width:10px; display:inline-block;
				    box-shadow: 0px 1px 1px 1px ##c3c3c3; margin-left:8px;"></div> Ancien (>14j)
				
			</div>
		</div>
	</h1>
</div>
<?php
	//display message if search result is null
	if($resultcount[0]==0 && $keywords!="") echo '<div class="alert alert-danger"><i class="icon-remove"></i> Aucun ticket trouvé pour la recherche: <strong>'.$keywords.'</strong></div>';
?>
<div class="row">
	<div class="col-xs-12">
		<div class="table-responsive">
		
		
		
			<table id="sample-table-1" class="table table-striped table-hover">
				<thead>
					<form name="filter" method="POST"><center>
						<small>Filtres globaux :</small>

						<?php
							//Filtre TECHNICIEN
							if ($_SESSION['profile_id']!=0 || $_SESSION['profile_id']!=4 || $_GET['userid']=='%')
							{
								echo '
									<select style="width:auto" name="technician" onchange="submit()" >
										<option value="%">Tous les techniciens</option>';
										//tech list
										$query = $db->query("SELECT tusers.id,tusers.lastname,tusers.firstname FROM tusers WHERE (profile='0' or profile='4') and disable='0' ORDER BY lastname");
										while ($row = $query->fetch())
										{
											$cutfname=substr($row['firstname'], 0, 1);
											if ($_POST['technician']==$row['id']) echo "<option selected value=\"$row[id]\">$cutfname. $row[lastname]</option>"; else echo "<option value=\"$row[id]\">$cutfname. $row[lastname]</option>";
										} 
										//tech group list
										$query = $db->query("SELECT * FROM tgroups WHERE disable='0' AND type='1' ORDER BY name");
										while ($row = $query->fetch())
										{
											if ($t_group==$row['id'] || $_GET['t_group']==$row['id']) echo "<option selected value=\"G_$row[id]\">$row[name]</option>"; else echo "<option value=\"G_$row[id]\">$row[name]</option>";
										} 
									echo "
									</select>";
							}
						?>
						
						<!-- Filtre TYPE -->
						<select style="width:auto" name="type" onchange="submit()" >
							<option value="%">Tous les types</option>
							<?php
								$query = $db->query("SELECT ttypes.id,ttypes.name FROM ttypes ORDER BY name");
								while ($row=$query->fetch()) 
								{
									if($row['id']==0) {$row['name']=T_($row['name']);} //translate only none database value
									if ($_POST['type']==$row['id']) 
									{echo '<option selected value="'.$row['id'].'">'.$row['name'].'</option>';}
									else 
									{echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';}
								} 
							?>
						</select>
						
						<!-- Filtre DEMANDEUR -->
						<small>&nbsp; Demandeur (tickets internes service) :</small>
						<select style="width:auto" name="demandeur" onchange="submit()" >
							<option value="%">Tous les demandeurs</option>
							<?php
								$query = $db->query("SELECT tusers.id,tusers.firstname,tusers.lastname FROM tusers WHERE tusers.profile <> 2 ORDER BY tusers.lastname");
								while ($row=$query->fetch())
								{
									
									$cutfname=substr($row['firstname'], 0, 1);
									if ($_POST['demandeur']==$row['id']) 
									{echo '<option selected value="'.$row['id'].'">'.$cutfname.". ".$row['lastname'].'</option>';}
									else 
									{echo '<option value="'.$row['id'].'">'.$cutfname.". ".$row['lastname'].'</option>';}
								}
							?>
						</select>
						</center><input name="filter" type="hidden" value="on" />
					</form>
				</thead>
		
					
<?php
	//********************************************************************
	// Fonction permettant de générer les post-it dans le kanban
	//********************************************************************
	function GenererPostIt($db,$sql){
		
		try {
		$query = $db->query($sql);
		while ($row=$query->fetch())
		{
			if($row['criticality'] == 1){
				$postit_couleur = '#ffbfbf'; //Post-it rouge
			}
			else if(strtotime($row['date_create']) < (strtotime(date("Y-m-d H:i:s")) - (3600 * 24 * 13))){ $postit_couleur = '#c5d0dc';} //Post-it gris
			else {$postit_couleur = '#ffffaa';} //Post-it jaune
			
			//display attach file icon if exist
			if(!isset($row['img1'])) $row['img1']= '';
			if($row['img1']!='') {$attach= "<i title=\"$row[img1]\" class=\"icon-paper-clip\"></i> ";} else {$attach='';}
			
			?>
				<div class="postit" style="
					cursor:pointer;
					display:block;
					width:120px;
					height:100px;
					border:solid 0px #eeeeee;
					-moz-box-shadow: 0px 2px 3px 0px #737373;
					-webkit-box-shadow: 0px 2px 3px 0px #737373;
					-o-box-shadow: 0px 2px 3px 0px #737373;
					box-shadow: 0px 2px 3px 0px #737373;
					margin-left: 10px;
					margin-bottom: 10px;
					padding: 3px;
					font-size: 12px;
					float:left;
					overflow:hidden;
					background-color:<?php echo $postit_couleur; ?>;"
					>
				<a href="index.php?page=ticket&id=<?php echo $row['id']; ?>" style="color:#000; display:block; width:100%; height:100%">
					#<?php echo $row['id']." ".$attach; ?>
					<br />
					<?php echo $row['title']; ?>
				</a>
				</div>
			<?php
		}
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}
	//Compter le nombre de tickets
		//1. Attente PEC
		//2. En cours
		//3. Résolu
		//4. Rejeté
		//5. Non attribué
		//6. Attente retour
	
	//********************************************************************
	// Requêtes SQL
	//********************************************************************
	
		$SQL_Nouveaux = "SELECT * FROM tincidents WHERE disable='0' AND technician = '0' ORDER BY ID DESC";
		
		if($_POST['technician']!="%"){
			$filtre_technicien = "AND technician = ".$_POST['technician'];
		}
		if($_POST['type']!="%"){
			$filtre_type = "AND type = ".$_POST['type'];
		}
		if($_POST['demandeur']!="%"){
			$filtre_type = "AND user = ".$_POST['demandeur'];
		}

		$SQL_AttentePec = "SELECT * FROM tincidents WHERE disable='0' AND state = '1' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
		$SQL_EnCours = "SELECT * FROM tincidents WHERE disable='0' AND state = '2' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
		$SQL_AttenteRetour = "SELECT * FROM tincidents WHERE disable='0' AND state = '6' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
		$SQL_Resolus = "SELECT * FROM tincidents WHERE disable='0' AND state = '3' ".$filtre_technicien." ".$filtre_type." AND DATE(date_res) > (NOW() - INTERVAL 7 DAY) ORDER BY ID DESC";

			
		// Nombre de ticket Nouveaux
		$query_count="SELECT COUNT(DISTINCT tincidents.id) FROM tincidents WHERE disable='0' AND technician = '0' ORDER BY ID DESC";
		$query=$db->query("$query_count");
        $resultcountNouveaux=$query->fetch();
        $query->closeCursor();
		// Nombre de ticket AttentePEC
		$query_count="SELECT COUNT(DISTINCT tincidents.id) FROM tincidents WHERE disable='0' AND state = '1' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
		$query=$db->query("$query_count");
        $resultcountAttentePEC=$query->fetch();
        $query->closeCursor(); 
		// Nombre de ticket EnCours
		$query_count="SELECT COUNT(DISTINCT tincidents.id) FROM tincidents WHERE disable='0' AND state = '2' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
		$query=$db->query("$query_count");
        $resultcountEnCours=$query->fetch();
        $query->closeCursor(); 
		// Nombre de ticket AttenteRetour
		$query_count="SELECT COUNT(DISTINCT tincidents.id) FROM tincidents WHERE disable='0' AND state = '6' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
		$query=$db->query("$query_count");
        $resultcountAttenteRetour=$query->fetch();
        $query->closeCursor(); 
		// Nombre de ticket Resolus
		$query_count="SELECT COUNT(DISTINCT tincidents.id) FROM tincidents WHERE disable='0' AND state = '3' ".$filtre_technicien." ".$filtre_type." AND DATE(date_res) > (NOW() - INTERVAL 7 DAY) ORDER BY ID DESC";
		$query=$db->query("$query_count");
        $resultcountResolus=$query->fetch();
        $query->closeCursor(); 
	
	
	
	
?>

				
			</table>
			<table id="sample-table-1" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="width:100%" class=""><center>
						<a title="" href="#"><i class="icon-tag"></i> Non affect&eacute; (<?php echo $resultcountNouveaux[0]; ?>)</a> <i class="icon-warning-sign red bigger-130"></i>
						</center></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><!-- Nouveaux -->
							<?php GenererPostIt($db,$SQL_Nouveaux); ?>
						</td>
					</tr>
				</tbody>
			</table>
			
			
			
			
			
			
			<table id="sample-table-1" class="table table-striped table-bordered">
				<?php
				if($_POST['technician']!="%"){
					//Si on affiche un seul technicien
				?>
				<thead>
					<tr>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> Attente PEC (<?php echo $resultcountAttentePEC[0]; ?>) </a></center></th>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> En cours (<?php echo $resultcountEnCours[0]; ?>) </a></center></th>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> Attente Retour (<?php echo $resultcountAttenteRetour[0]; ?>) </a></center></th>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> Résolus (< 7 j) (<?php echo $resultcountResolus[0]; ?>) </a></center></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><!-- Attente PEC -->
							<?php GenererPostIt($db,$SQL_AttentePec); ?>
						</td>
						<td><!-- En cours -->
							<?php GenererPostIt($db,$SQL_EnCours); ?>
						</td>
						<td><!-- Attente retour -->
							<?php GenererPostIt($db,$SQL_AttenteRetour); ?>
						</td>
						<td><!-- Résolus -->
							<?php GenererPostIt($db,$SQL_Resolus); ?>
						</td>
					</tr>
				</tbody>
				<?php
				} else {
				//Si on affiche tous les techniciens
				
				
				?>
				<thead>
					<tr>
						<th style="width:6%" class="">Tech</th>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> Attente PEC (<?php echo $resultcountAttentePEC[0]; ?>) </a></center></th>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> En cours (<?php echo $resultcountEnCours[0]; ?>) </a></center></th>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> Attente Retour (<?php echo $resultcountAttenteRetour[0]; ?>) </a></center></th>
						<th style="width:25%" class=""><center><a title="" href="#"><i class="icon-tag"></i> Résolus (< 7 j) (<?php echo $resultcountResolus[0]; ?>) </a></center></th>
					</tr>
				</thead>
				<tbody>
				<?php
				
					if($_POST['type']!="%"){
						$filtre_type = "AND type = ".$_POST['type'];
					}
					if($_POST['demandeur']!="%"){
						$filtre_type = "AND user = ".$_POST['demandeur'];
					}
					
					//Pour chaque technicien, on affiche une ligne
					$SQL_liste_techniciens = "SELECT * FROM tusers WHERE disable='0' AND profile != '2' ORDER BY ID ASC";
					$query = $db->query($SQL_liste_techniciens);
					while ($row=$query->fetch())
					{
						
						$filtre_technicien = "AND technician = ".$row['id'];
						
						$SQL_AttentePec = "SELECT * FROM tincidents WHERE disable='0' AND state = '1' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
						$SQL_EnCours = "SELECT * FROM tincidents WHERE disable='0' AND state = '2' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
						$SQL_AttenteRetour = "SELECT * FROM tincidents WHERE disable='0' AND state = '6' ".$filtre_technicien." ".$filtre_type." ORDER BY ID DESC";
						$SQL_Resolus = "SELECT * FROM tincidents WHERE disable='0' AND state = '3'
							".$filtre_technicien." ".$filtre_type."
							AND DATE(date_res) > (NOW() - INTERVAL 7 DAY) ORDER BY ID DESC";

						$cutfname=substr($row['firstname'], 0, 1);
					
					?>
					<tr>
						<td><?php echo $cutfname.". ".$row['lastname']; ?></td>
						<td><!-- Attente PEC -->
							<?php GenererPostIt($db,$SQL_AttentePec); ?>
						</td>
						<td><!-- En cours -->
							<?php GenererPostIt($db,$SQL_EnCours); ?>
						</td>
						<td><!-- Attente retour -->
							<?php GenererPostIt($db,$SQL_AttenteRetour); ?>
						</td>
						<td><!-- Résolus -->
							<?php GenererPostIt($db,$SQL_Resolus); ?>
						</td>
					</tr>
					<?php
					}
					?>
				</tbody>
				<?php } ?>
			</table>

			
			
			
			
		</div>
	</div>
</div>


</form>

<?php
echo '</div>';
//////////////////////////////////////functions
//date conversion
function date_cnv ($date) 
{return substr($date,8,2) . "/" . substr($date,5,2) . "/" . substr($date,0,4);}

?>