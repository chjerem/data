<?php
################################################################################
# @Name : asset_list.php 
# @Description : display assets list
# @Call : /menu.php
# @Author : Flox
# @Create : 20/11/2014
# @Update : 03/05/2017
# @Version : 3.1.20
################################################################################

//initialize variables 
if(!isset($asc)) $asc = ''; 
if(!isset($img)) $img= ''; 
if(!isset($filter)) $filter=''; 
if(!isset($col)) $col=''; 

if(!isset($_GET['sn_internal'])) $_GET['sn_internal']= '';
if(!isset($_GET['ip'])) $_GET['ip']= '';
if(!isset($_GET['netbios'])) $_GET['netbios']= '';
if(!isset($_GET['user'])) $_GET['user']= '';
if(!isset($_GET['type'])) $_GET['type']= '';
if(!isset($_GET['state'])) $_GET['state']= '';
if(!isset($_GET['model'])) $_GET['model']= '';
if(!isset($_GET['description'])) $_GET['description']= '';
if(!isset($_GET['date_stock'])) $_GET['date_stock']= '';
if(!isset($_GET['date_end_warranty'])) $_GET['date_end_warranty']= '';
if(!isset($_GET['department'])) $_GET['department']= '';
if(!isset($_GET['location'])) $_GET['location']= '';
if(!isset($_GET['virtual'])) $_GET['virtual']= '';
if(!isset($_GET['order'])) $_GET['order']= '';
if(!isset($_GET['cursor'])) $_GET['cursor']= '';
if(!isset($_GET['way'])) $_GET['way']= '';
if(!isset($_GET['warranty'])) $_GET['warranty']= '';
if(!isset($_GET['date_end_warranty'])) $_GET['date_end_warranty']= '';

//get value is for filter case
if(!isset($_POST['sn_internal'])) $_POST['sn_internal']= $_GET['sn_internal'];
if(!isset($_POST['ip'])) $_POST['ip']= $_GET['ip'];
if(!isset($_POST['netbios'])) $_POST['netbios']= $_GET['netbios'];
if(!isset($_POST['user'])) $_POST['user']= $_GET['user'];
if(!isset($_POST['type'])) $_POST['type']= $_GET['type'];
if(!isset($_POST['state'])) $_POST['state']= $_GET['state'];
if(!isset($_POST['model'])) $_POST['model']= $_GET['model'];
if(!isset($_POST['description'])) $_POST['description']= $_GET['description'];
if(!isset($_POST['date_stock'])) $_POST['date_stock']= $_GET['date_stock'];
if(!isset($_POST['date_end_warranty'])) $_POST['date_end_warranty']= $_GET['date_end_warranty'];
if(!isset($_POST['department'])) $_POST['department']= $_GET['department'];
if(!isset($_POST['location'])) $_POST['location']= $_GET['location'];
if(!isset($_POST['virtual'])) $_POST['virtual']= $_GET['virtual'];

//default values
if($_GET['cursor']=='') $_GET['cursor']= '0'; 

if($_POST['sn_internal']=='') $_POST['sn_internal']= '%';
if($_POST['user']=='') $_POST['user']= '%';
if($_POST['type']=='') $_POST['type']= '%';
if($_POST['state']=='') $_POST['state']= '%';
if($_POST['model']=='') $_POST['model']= '%';
if($_POST['description']=='') $_POST['description']= '%';
if($_POST['date_stock']=='') $_POST['date_stock']= '%';
if($_POST['date_end_warranty']=='') $_POST['date_end_warranty']= '%';
if($_POST['department']=='') $_POST['department']= '%';
if($_POST['virtual']=='') $_POST['virtual']= '%';

if($_GET['sn_internal']=='') $_GET['sn_internal']= '%'; 
if($_GET['ip']=='') $_GET['ip']= '%'; 
if($_GET['netbios']=='') $_GET['netbios']= '%'; 
if($_GET['user']=='') $_GET['user']= '%';
if($_GET['type']=='') $_GET['type']= '%';
if($_GET['state']=='') $_GET['state']= '%'; 
if($_GET['model']=='') $_GET['model']= '%';
if($_GET['description']=='') $_GET['description']= '%';
if($_GET['date_stock']=='') $_GET['date_stock']= '%';
if($_GET['date_end_warranty']=='') $_GET['date_end_warranty']= '%';
if($_GET['department']=='') $_GET['department']= '%';
if($_GET['location']=='') $_GET['location']= '%';

//select auto order 
if ($_GET['order']=='' && $_GET['state']==''){$_GET['order']='tassets_state.order';}
if ($_GET['order']=='' && $_GET['state']!=1 && $_GET['warranty']!=1){$_GET['order']='tassets_iface.ip'; $_GET['way']='DESC';}
if ($_GET['order']=='' && $_GET['state']==1){$_GET['order']='tassets.type,tassets.manufacturer,tassets.model,tassets.sn_internal';}
if ($_GET['order']=='' && $_GET['warranty']==1){$_GET['order']='date_end_warranty'; $_GET['way']='ASC';}

//delete cursor value on select change
if($_POST['type']!=$_GET['type'] && $_GET['cursor']!=0) $_GET['cursor']='0';
if($_POST['model']!=$_GET['model'] && $_GET['cursor']!=0) $_GET['cursor']='0';

//restrict to view only asset department
if($rright['asset_list_department_only']!=0) {
	//get service from this user
	$query=$db->query("SELECT service_id FROM tusers_services WHERE user_id='$ruser[id]'");
	$rservice=$query->fetch();
	$query->closeCursor();
	$_POST['department']=$rservice['service_id'];
}

//restrict to view only active state
if($rright['side_asset_all_state']==0) {$_POST['state']=2;}

//convert order in number
if($_GET['order']=='sn_internal') $_GET['order']= 'ABS(sn_internal)'; 

if ($rparameters['debug']==1) echo "<b><u>DEBUG MODE:</u></b> <br /> assetkeywords $assetkeywords POST assetkeywords $_POST[assetkeywords] $assetkeywords POST type $_POST[type] GET type: $_GET[type] POST model $_POST[model] GET model: $_GET[model] POST state $_POST[state] GET state: $_GET[state] GET cursor: $_GET[cursor] GET order: $_GET[order] GET way: $_GET[way] <br />";

//page url to keep filters
$url_post_parameters="sn_internal=$_POST[sn_internal]&ip=$_POST[ip]&netbios=$_POST[netbios]&user=$_POST[user]&type=$_POST[type]&model=$_POST[model]&description=$_POST[description]&department=$_POST[department]&location=$_POST[location]&virtual=$_POST[virtual]&date_stock=$_POST[date_stock]&date_end_warranty=$_POST[date_end_warranty]&state=$_POST[state]&warranty=$_GET[warranty]&assetkeywords=$assetkeywords";

//load data to url filter
if( 
	($_POST['sn_internal']!='%' && $_POST['sn_internal']!='' && $_GET['sn_internal']!=$_POST['sn_internal']) ||
	($_POST['ip']!='%' && $_POST['ip']!='' && $_GET['ip']!=$_POST['ip']) ||
	($_POST['netbios']!='%' && $_POST['netbios']!='' && $_GET['netbios']!=$_POST['netbios']) ||
	($_POST['user']!='%' && $_POST['user']!='' && $_GET['user']!=$_POST['user'])  ||
	($_POST['type']!='%' && $_POST['type']!='' && $_GET['type']!=$_POST['type']) ||
	($_POST['model']!='%' && $_POST['model']!='' && $_GET['model']!=$_POST['model'])||
	($_POST['description']!='%' && $_POST['description']!='' && $_GET['description']!=$_POST['description'])||
	($_POST['department']!='%' && $_POST['department']!='' && $_GET['department']!=$_POST['department'])||
	($_POST['location']!='%' && $_POST['location']!='' && $_GET['location']!=$_POST['location'])||
	($_POST['virtual']!='%' && $_POST['virtual']!='' && $_GET['virtual']!=$_POST['virtual'])||
	($_POST['date_stock']!='%' && $_POST['date_stock']!='' && $_GET['date_stock']!=$_POST['date_stock'])||
	($_POST['date_end_warranty']!='%' && $_POST['date_end_warranty']!='' && $_GET['date_end_warranty']!=$_POST['date_end_warranty'])||
	($_POST['assetkeywords']!='%' && $_POST['assetkeywords']!='' && $_GET['assetkeywords']!=$_POST['assetkeywords'])||
	($_POST['state']!='%' && $_POST['state']!='' && $_GET['state']!=$_POST['state'])
)
{
	$url='index.php?page=asset_list&'.$url_post_parameters;
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

//date conversion for filter line
if ($_POST['date_stock']!='%')
{
	$date=$_POST['date_stock'];
	$find='/';
	$find= strpos($date, $find);
	if ($find!=false)
	{			
		$date=explode("/",$date);
		$_POST['date_stock']="$date[2]-$date[1]-$date[0]";
	}
}
if ($assetkeywords)
{
	include "./core/searchengine_asset.php";
} else {
	//secure string
	$_POST['description']=str_replace("'","",strip_tags($db->quote($_POST['description'])));
	$_POST['sn_internal']=str_replace("'","",strip_tags($db->quote($_POST['sn_internal'])));
	$_POST['ip']=str_replace("'","",strip_tags($db->quote($_POST['ip'])));
	$_POST['netbios']=str_replace("'","",strip_tags($db->quote($_POST['netbios'])));
	$_POST['location']=str_replace("'","",strip_tags($db->quote($_POST['location'])));
	$_POST['date_stock']=str_replace("'","",strip_tags($db->quote($_POST['date_stock'])));
	
	$from='tassets';
	$join='
	LEFT JOIN tassets_state ON tassets.state=tassets_state.id
	LEFT JOIN tusers ON tassets.user=tusers.id
	LEFT JOIN tassets_iface ON tassets.id=tassets_iface.asset_id
	';
	$where=" 
	tassets.sn_internal LIKE '$_POST[sn_internal]%'
	AND	tassets.user LIKE '$_POST[user]'
	AND	tassets.type LIKE '$_POST[type]'
	AND	tassets.model LIKE '$_POST[model]'
	AND	tassets.description LIKE '%$_POST[description]%'
	AND	tassets.date_stock LIKE '%$_POST[date_stock]%'
	AND	tassets.state LIKE '$_POST[state]'
	AND	tassets.department LIKE '$_POST[department]'
	AND	tassets.disable='0' 
	";
	//special case for asset_iface filter
	if ($_POST['ip']!='%' && $_POST['ip']!='') {$where.=" AND tassets_iface.ip LIKE '%$_POST[ip]%' ";} else {$where.=" AND (tassets_iface.ip LIKE '%$_POST[ip]%' OR tassets_iface.ip is null)";}
	if ($_POST['netbios']) {$where.=" AND (tassets_iface.netbios LIKE '%$_POST[netbios]%' OR tassets.netbios LIKE '%$_POST[netbios]%' )";} else {$where.=" AND (tassets_iface.netbios LIKE '%$_POST[netbios]%' OR tassets_iface.netbios is null)";}
	$where.=' AND (tassets_iface.disable=0 OR tassets_iface.disable is null)';
	}
if($rright['asset_list_col_location']!=0 && !$assetkeywords)
{
	$join.='LEFT JOIN tassets_location ON tassets.location=tassets_location.id';
	if ($_POST['location']){$where.=" AND tassets_location.name LIKE '%$_POST[location]%' ";} else {$where.=" AND (tassets_location.name LIKE '%$_POST[location]%' OR tassets_location.name is null)";}
}
if ($_GET['warranty']==1)
{
	if ($_POST['date_end_warranty']!='%')
	{
		if($_POST['date_end_warranty']>0) //case warranty will be expire
		{
			$limit_warranty=strtotime(date("Y-m-d", strtotime($today)) . " + $_POST[date_end_warranty] day");
			$limit_warranty=date('Y-m-d', $limit_warranty);
			$where.=" AND tassets.date_end_warranty BETWEEN '$today' AND '$limit_warranty'";
		}elseif($_POST['date_end_warranty']<0) //case warranty have already expire since month
		{
			$_POST['date_end_warranty']=str_replace('-','',$_POST['date_end_warranty']);
			$limit_warranty=strtotime(date("Y-m-d", strtotime($today)) . " - $_POST[date_end_warranty] day");
			$limit_warranty=date('Y-m-d', $limit_warranty);
			$where.=" AND tassets.date_end_warranty BETWEEN '$limit_warranty' AND '$today'";
		} elseif($_POST['date_end_warranty']==0) //case warranty have already expire since today
		{
			$where.=" AND tassets.date_end_warranty < '$today' AND tassets.date_end_warranty!='0000-00-00'";
		}
	} else {
		$where.=" AND tassets.date_end_warranty > '$today'";
	}
}
if ($rparameters['debug']==1)
{
	$where_debug=str_replace("AND", "AND <br />",$where);
	$where_debug=str_replace("OR", "OR <br />",$where_debug);
	$join_debug =str_replace("LEFT", "<br />LEFT",$join);
	echo "
	<b>SELECT DISTINCT</b> tassets.*<br />
	<b>FROM</b>	$from
	$join_debug <br />
	<b>WHERE</b><br />
	$where_debug<br />
	<b>ORDER BY</b> $_GET[order] $_GET[way] <b>LIMIT</b> $_GET[cursor],$rparameters[maxline]<br />
	";
}

$query=$db->query("SELECT COUNT(DISTINCT tassets.id) FROM $from $join WHERE $where");
$resultcount=$query->fetch();
$query->closeCursor();

$masterquery = $db->query("SELECT DISTINCT tassets.* FROM $from $join WHERE $where ORDER BY $_GET[order] $_GET[way] LIMIT $_GET[cursor],$rparameters[maxline]"); 

//auto launch asset if only one resultcount
if($resultcount[0]==1 && $assetkeywords!='')
{
	$findonlyone=$masterquery->fetch();
	echo 
		T_('Un seul équipement trouvé, ouverture de l\'équipement en cours...').'
		<SCRIPT LANGUAGE=\'JavaScript\'>
			<!--
			function redirect()
			{
				window.location=\'./index.php?page=asset&'.$url_post_parameters.'&id='.$findonlyone['id'].'\'
			}
			setTimeout(\'redirect()\');
			-->
		</SCRIPT>
	';
}
?>

<div class="page-header position-relative">
	<h1>
		<?php
		//display page title of asset lis
		if ($assetkeywords) {echo '<i class="icon-search"></i> '.T_("Recherche d'équipements:").' '.$assetkeywords;} else {echo '<i class="icon-desktop"></i> '.T_('Liste des équipements');}
		//modify title for department view only
		if ($rright['asset_list_department_only']!=0)
		{
			//get department name
			$query=$db->query("SELECT name FROM tservices WHERE id='$rservice[service_id]'");
			$row=$query->fetch();
			$query->closeCursor(); 
			echo T_(' du service').' '.$row[0];
		} 
		//display counter
		echo '
		<small>
			<i class="icon-double-angle-right"></i>
			&nbsp;'.T_('Nombre').': '.$resultcount[0].'</i>
		</small>
		';
		if ($assetkeywords)
		{
			//if virtual asset detected display new select box filter
			$query=$db->query("SELECT count(id) FROM tassets WHERE virtualization='1' AND disable='0'");
			$row=$query->fetch();
			$query->closeCursor();
			
			if($row[0]>0)
			{
				echo '|
				<form style="display: inline-block;" class="form-horizontal" name="virtual" id="virtual" method="post" action="" onsubmit="loadVal();" >
					<small>
						'.T_('Équipements').':
						<select onchange="submit()" name="virtual">
							<option ';if ($_POST['virtual']=='%') {echo 'selected'; } echo ' value="%" >'.T_('Physiques et virtuels').'</option>
							<option ';if ($_POST['virtual']=='0') {echo 'selected'; } echo ' value="0" >'.T_('Physiques').'</option>
							<option ';if ($_POST['virtual']=='1') {echo 'selected'; } echo ' value="1" >'.T_('Virtuels').'</option>
						</select>
						&nbsp;&nbsp;
						<input name="assetkeywords" type="hidden" value="'.$_POST['assetkeywords'].'" />
					</small>
				</form>
				';
			}
		}
		?>
	</h1>
</div>
<?php
	//display message if search result is null
	if($resultcount[0]==0 && $assetkeywords!="") echo '<div class="alert alert-danger"><i class="icon-remove"></i> Aucun équipement trouvé pour la recherche: <strong>'.$assetkeywords.'</strong></div>';
?>
<div class="row">
	<div class="col-xs-12">
		<div class="table-responsive">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<?php 
				//*********************** FIRST LIGN *********************** 
				if($_GET['way']=='ASC') $arrow_way='DESC'; else $arrow_way='ASC';
				//build page url link, from generate page links from searchengine_asset
				$url="./index.php?page=asset_list&amp;
				state=$_GET[state]&amp;
				ip=$_POST[ip]&amp;
				netbios=$_POST[netbios]&amp;
				user=$_GET[user]&amp;
				type=$_GET[type]&amp;
				model=$_GET[model]&amp;
				description=$_POST[description]&amp;
				department=$_GET[department]&amp;
				location=$_POST[location]&amp;
				virtual=$_POST[virtual]&amp;
				warranty=$_GET[warranty]&amp;
				date_end_warranty=$_GET[date_end_warranty]&amp;
				assetkeywords=$assetkeywords&amp;
				date_stock=$_POST[date_stock]";
				
				echo '
				<thead>
					<tr >
						<th '; if ($_GET['order']=='ABS(sn_internal)') echo 'class="active"'; echo ' >
							<center>
								<a title="'.T_('Identifiant de l\'équipement').'" href="'.$url.'&amp;order=sn_internal&amp;way='.$arrow_way.'">
									<i class="icon-tag"></i><br />
									'.T_('Numéro');
									//Display way arrows
									if ($_GET['order']=='ABS(sn_internal)'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									echo '
								</a>
							</center>
						</th>
						';
						if ($rparameters['asset_ip']==1)
						{
							echo '
							<th '; if ($_GET['order']=='ip') echo 'class="active"'; echo '>
								<center>
									<a title="'.T_('Adresse IP').'"  href="'.$url.'&amp;order=tassets_iface.ip&amp;way='.$arrow_way.'">
										<i class="icon-exchange"></i><br />
										'.T_('Adresse IP');
										//Display arrows
										if ($_GET['order']=='tassets_iface.ip'){
											if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
											if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
										}
										echo'
									</a>
								</center>
							</th>
							';
						}
						echo '
						<th '; if ($_GET['order']=='netbios') echo 'class="active"'; echo '>
							<center>
								<a title="'.T_("Nom de l'équipement").'"  href="'.$url.'&amp;order=netbios&amp;way='.$arrow_way.'">
									<i class="icon-desktop"></i><br />
									'.T_('Nom');
									//display arrows
									if ($_GET['order']=='netbios'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									echo '
								</a>
							</center>
						</th>
						';
						?>
						<th <?php if ($_GET['order']=='tusers.lastname') echo 'class="active"'; ?> >
							<center>
								<a title="<?php echo T_('Utilisateur'); ?>"  href="<?php echo $url; ?>&amp;order=tusers.lastname&amp;way=<?php echo $arrow_way; ?>">
									<i class="icon-male"></i><br />
									<?php 
									echo T_('Utilisateur'); 
									//Display arrows
									if ($_GET['order']=='user'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									?>
								</a>
							</center>
						</th>
						<th <?php if ($_GET['order']=='type') echo 'class="active"'; ?> >
							<center>
								<a title="Type" href="<?php echo $url; ?>&amp;order=type&amp;way=<?php echo $arrow_way; ?>">
									<i class="icon-sign-blank"></i><br />
									<?php
									echo T_('Type');
									//Display arrows
									if ($_GET['order']=='type'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									?>
								</a>
							</center>
						</th>
						<th <?php if ($_GET['order']=='model') echo 'class="active"'; ?> >
							<center>
								<a title="<?php echo T_('Modèle'); ?>"  href="<?php echo $url; ?>&amp;order=model&amp;way=<?php echo $arrow_way; ?>">
									<i class="icon-sitemap"></i><br />
									<?php
									echo T_('Modèle'); 
									//Display arrows
									if ($_GET['order']=='model'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									?>
								</a>
							</center>
						</th>
						<th <?php if ($_GET['order']=='description') echo 'class="active"'; ?> >
							<center>
								<a title="<?php echo T_('Description'); ?>"  href="<?php echo $url; ?>&amp;order=description&amp;way=<?php echo $arrow_way; ?>">
									<i class="icon-file-text-alt"></i><br />
									<?php
									echo T_('Description'); 
									//Display arrows
									if ($_GET['order']=='description'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									?>
								</a>
							</center>
						</th>
						<th <?php if ($_GET['order']=='department') echo 'class="active"'; ?> >
							<center>
								<a title="<?php echo T_('Service'); ?>"  href="<?php echo $url; ?>&amp;order=department&amp;way=<?php echo $arrow_way; ?>">
								<i class="icon-building"></i><br />
								<?php
								echo T_('Service');
								//Display arrows
								if ($_GET['order']=='department'){
									if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
									if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
								}
								?>
								</a>
							</center>
						</th>
						<?php
						if($rright['asset_list_col_location']!=0 && $_POST['virtual']!=1)
						{
							echo '
							<th ';if ($_GET['order']=='location') echo 'class="active"'; echo ' >
								<center>
									<a title="'.T_('Localisation').'" href="'.$url.'&amp;order=location&amp;way='.$arrow_way.'">
									<i class="icon-compass"></i><br />
									';
									echo T_('Localisation');
									//Display arrows
									if ($_GET['order']=='location'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									echo '
									</a>
								</center>
							</th>
							';
						}
						?>
						<th <?php if ($_GET['order']=='date_stock') echo 'class="active"'; ?> >
							<center>
								<a title="<?php echo T_('Date d\'achat'); ?>"  href="<?php echo $url; ?>&amp;order=date_stock&amp;way=<?php echo $arrow_way; ?>">
									<i class="icon-calendar"></i><br />
									<?php
									echo T_('Date achat');
									//Display arrows
									if ($_GET['order']=='date_stock'){
										if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
										if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
									}
									?>
								</a>
							</center>
						</th>
						<?php 
						if ($rparameters['asset_warranty']==1 && $_GET['warranty']==1)
						{
							echo '
							<th '; if ($_GET['order']=='date_end_warranty') echo 'class="active"'; echo ' >
								<center>
									<a title="'.T_('Date de fin de garantie').'"  href="'.$url.'&amp;order=date_end_warranty&amp;way='.$arrow_way.'">
										<i class="icon-calendar"></i><br />
										'.T_('Date fin garantie')				
										;
										//Display arrows
										if ($_GET['order']=='date_end_warranty'){
											if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
											if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
										}
										echo '
									</a>
								</center>
							</th>
							';
						}
						?>
						<th <?php if ($_GET['order']=='state') echo 'class="active"'; ?> >
							<center>
								<a title="<?php echo T_('État'); ?>" href="<?php echo $url; ?>&amp;order=state&amp;way=<?php echo $arrow_way; ?>">
								<i class="icon-adjust"></i><br />
								<?php
								echo T_('État');
								//Display arrows
								if ($_GET['order']=='state'){
									if ($_GET['way']=='ASC') {echo ' <i class="icon-sort-up"></i>';}
									if ($_GET['way']=='DESC') {echo ' <i class="icon-sort-down"></i>';}
								}
								?>
								</a>
							</center>
						</th>
					</tr>
					<?php // *********************************** FILTER LIGN ************************************** ?>
					<form name="filter" method="POST">
						<tr>
							<td>
								<center>
									<input name="sn_internal" style="width:100%" onchange="submit();" type="text" value="<?php if ($_POST['sn_internal']!='%')echo $_POST['sn_internal']; ?>" />
								</center>
							</td>
							<?php
								if ($rparameters['asset_ip']==1)
								{
									echo '
									<td>
										<center>
											<input name="ip" style="width:100%" onchange="submit();" type="text" value="'; if ($_POST['ip']!='%') {echo $_POST['ip'];} echo '" />
										</center>
									</td>
									';
								}
							?>
							<td>
								<center>
									<input name="netbios" style="width:100%" onchange="submit();" type="text" value="<?php if ($_POST['netbios']!='%')echo $_POST['netbios']; ?>" />
								</center>
							</td>
							<td align="center">
								<select name="user" style="width:80px" onchange="submit()">
									<option value="%"></option>
									<?php
									$query = $db->query("SELECT DISTINCT tusers.* FROM $from $join WHERE $where ORDER BY tusers.lastname");
									while ($row=$query->fetch())
									{
										if($row['id']==0) {$row['lastname']=T_($row['lastname']);}
										if ($_POST['user']==$row['id']) echo "<option selected value=\"$row[id]\">$row[lastname] $row[firstname]</option>"; else echo "<option value=\"$row[id]\">$row[lastname] $row[firstname]</option>";
									} 
									$query->closeCursor(); 
									?>
								</select>
							</td>
							<td align="center">
								<select name="type" style="width:100px" onchange="submit()">
									<option value="%"></option>
									<?php
									$query = $db->query("SELECT DISTINCT tassets_type.* FROM tassets_type,$from $join WHERE tassets_type.id=tassets.type AND $where ORDER BY tassets_type.name");
									while ($row=$query->fetch())
									{
										if ($_POST['type']==$row['id']) echo "<option selected value=\"$row[id]\">$row[name]</option>"; else echo "<option value=\"$row[id]\">$row[name]</option>";
									} 
									$query->closeCursor(); 
									?>
								</select>
							</td>
							<td align="center">
								<select style="width:90px" name="model" onchange="submit()">
									<option value="%"></option>
									<?php
									$query = $db->query("SELECT DISTINCT tassets_model.* FROM tassets_model, $from $join WHERE tassets_model.id=tassets.model AND tassets_model.type LIKE '$_GET[type]' AND $where ORDER BY tassets_model.name");
									while ($row=$query->fetch())
									{
										if ($_POST['model']==$row['id']) echo "<option selected value=\"$row[id]\">$row[name]</option>"; else echo "<option value=\"$row[id]\">$row[name]</option>";
									} 
									?>
								</select>
							</td>
							<td>
								<input name="description" style="width:100%" onchange="submit();" type="text"  value="<?php if ($_POST['description']!='%')echo $_POST['description']; ?>" />
							</td>
							<td align="center">
								<select style="width:45px" id="department" name="department" onchange="submit()">
									<option value="%"></option>
									<?php
									$query = $db->query("SELECT DISTINCT tservices.* FROM tservices, $from $join WHERE tservices.id=tassets.department AND $where ORDER BY tservices.name");
									while ($row=$query->fetch()){
										if ($_POST['department']==$row['id']) {echo "<option selected value=\"$row[id]\">$row[name]</option>";} else {echo "<option value=\"$row[id]\">$row[name]</option>";}
									} 
									$query->closeCursor();
									?>
								</select>
							</td>
							<?php 
							if($rright['asset_list_col_location']!=0 && $_POST['virtual']!=1)
							{
								echo '
								<td>
									<input name="location" onchange="submit();" style="width:70px" type="text"  value="';if ($_POST['location']!='%') {echo $_POST['location'];} echo '" />
								</td>
								';
							}
							?>
							<td>
								<input name="date_stock" onchange="submit();" style="width:82px" type="text"  value="<?php if ($_POST['date_stock']!='%') {echo $_POST['date_stock'];} ?>" />
							</td>
							<?php 
							if ($rparameters['asset_warranty']==1 && $_GET['warranty']==1)
							{
								echo '
								<td>
									<center>
										<select style="width:70px" id="date_end_warranty" name="date_end_warranty" onchange="submit()" >	
											<option '; if($_POST['date_end_warranty']=='%'){echo ' selected ';} echo 'value="%">'.T_('Tous').'</option>
											<option '; if($_POST['date_end_warranty']==31){echo ' selected ';} echo 'value="31">'.T_('Garanties prenant fin dans 1 mois').'</option>
											<option '; if($_POST['date_end_warranty']==62){echo ' selected ';} echo 'value="62">'.T_('Garanties prenant fin dans les 2 mois').'</option>
											<option '; if($_POST['date_end_warranty']==182){echo ' selected ';} echo 'value="182">'.T_('Garanties prenant fin dans les 6 mois').'</option>
											<option '; if($_POST['date_end_warranty']==365){echo ' selected ';} echo 'value="365">'.T_("Garanties prenant fin dans les 1 an ").'</option>
											<option '; if($_POST['date_end_warranty']==730){echo ' selected ';} echo 'value="730">'.T_('Garanties prenant fin dans les 2 ans').'</option>
											<option '; if($_POST['date_end_warranty']==1095){echo ' selected ';} echo 'value="1095">'.T_('Garanties prenant fin dans les 3 ans').'</option>
											<option></option>
											<option '; if($_POST['date_end_warranty']=='-31'){echo ' selected ';} echo 'value="-31">'.T_("Garanties ayant pris fin il y a moins d'1 mois").'</option>
											<option '; if($_POST['date_end_warranty']=='-62'){echo ' selected ';} echo 'value="-62">'.T_('Garanties ayant pris fin il y a moins de 2 mois').'</option>
											<option '; if($_POST['date_end_warranty']=='-182'){echo ' selected ';} echo 'value="-182">'.T_('Garanties ayant pris fin il y a moins 6 mois').'</option>
											<option '; if($_POST['date_end_warranty']=='-365'){echo ' selected ';} echo 'value="-365">'.T_('Garanties ayant pris fin il y a moins 1 an').'</option>
											<option '; if($_POST['date_end_warranty']=='-730'){echo ' selected ';} echo 'value="-730">'.T_('Garanties ayant pris fin il y a moins 2 ans').'</option>
											<option '; if($_POST['date_end_warranty']=='-1095'){echo ' selected ';} echo 'value="-1095">'.T_('Garanties ayant pris fin il y a moins 3 ans').'</option>
											<option></option>
											<option '; if($_POST['date_end_warranty']=='0'){echo ' selected ';} echo 'value="0">'.T_('Garanties expirées').'</option>
										</select>
									</center>	
								</td>
								';
							}
							?>
							<td align="center">
								<select style="width:50px" id="state" name="state" onchange="submit()" >	
									<option value="%"></option>
									<?php
										$query = $db->query("SELECT * FROM tassets_state ORDER BY `order`");
										while ($row=$query->fetch())  
										{
											if ($_POST['state']==$row['id']) {echo '<option selected value="'.$row['id'].'">'.T_($row['name']).'</option>';} else {echo '<option value="'.$row['id'].'">'.T_($row['name']).'</option>';}
										} 
									?>
								</select>
							</td>
						</tr>
					</form>
				</thead>
				<tbody>
				<form name="actionlist" method="POST">
					<?php
						while ($row=$masterquery->fetch())
						{ 
							//get user name
							$query=$db->query("SELECT * FROM tusers WHERE id=$row[user]"); 
							$ruser=$query->fetch();
							$query->closeCursor();
							
							//get type name
							$query=$db->query("SELECT * FROM tassets_type WHERE id=$row[type]"); 
							$rtype=$query->fetch();
							$query->closeCursor();
							
							//get model name
							$query=$db->query("SELECT * FROM tassets_model WHERE id=$row[model]"); 
							$rmodel=$query->fetch();
							$query->closeCursor();
							
							//get state name
							$query=$db->query("SELECT * FROM tassets_state WHERE id LIKE $row[state]"); 
							$rstate=$query->fetch();
							$query->closeCursor();
							
							//get department name
							$query=$db->query("SELECT * FROM tservices WHERE id LIKE $row[department]"); 
							$rdepartment=$query->fetch();
							$query->closeCursor();
							
							if($rright['asset_list_col_location']!=0 && $_POST['virtual']!=1)
							{
								//get location name
								$query=$db->query("SELECT name FROM tassets_location WHERE id LIKE $row[location]"); 
								$rlocation=$query->fetch();
								$query->closeCursor();
							}

							$rowdate= date_cnv($row['date_stock']);
							$rowdateendwarranty= date_cnv($row['date_end_warranty']);
							
							//if title is too long cut
							$description=$row['description'];
							if (strlen($description)>25)
							{
								$description=substr($description,0,25);
								$description=$description.'...';
							}
							
							//display asset edit link if right is ok
							if ($rright['asset_list_view_only']!=0)
							{$asset_link="./index.php?page=asset_list";}
							else
							{
								$asset_link='./index.php?page=asset&id='.$row['id'].'&'.$url_post_parameters.'&way='.$_GET['way'].'&order='.$_GET['order'].'&cursor='.$_GET['cursor'];
							}	
							
							//display each line 
							echo "
								<tr>
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<center>
										&nbsp<a href=\"$asset_link\">
												<span title=\"\" class=\"label\">
													$row[sn_internal]
												</span>
											</a>
										</center>
									</td>
									";
									if ($rparameters['asset_ip']==1)
									{
										echo "
										<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\" >
											<a class=\"td\" href=\"$asset_link\">
											";
											//find all ip address from iface table
											$query2 = $db->query("SELECT ip FROM `tassets_iface` WHERE asset_id=$row[id] AND ip!='' AND disable=0 ORDER BY ip ASC");
											while ($row2 = $query2->fetch()) {
												echo $row2['ip'].'<br />';
											} 
											$query2->closeCursor(); 
											echo "
											</a>
										</td>
										";
									}
									echo "
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<a class=\"td\" href=\"$asset_link\">
											$row[netbios]
										</a>
									</td>
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<a class=\"td\" href=\"$asset_link\">
											"; if($ruser['lastname']) {echo T_($ruser['lastname']);} else {echo $ruser['lastname'];} echo " $ruser[firstname]
										</a>
									</td>
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<a class=\"td\" href=\"$asset_link\">
											$rtype[name]
										</a>
									</td>
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<a class=\"td\" href=\"$asset_link\">
											$rmodel[name]
										</a>
									</td>
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<a title=\"$row[description]\" class=\"td\" title=\" \" href=\"$asset_link\">
											$description
										</a>
									</td>
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<a class=\"td\" href=\"$asset_link\" > 
											$rdepartment[name]
										</a>
									</td>
									";
									if($rright['asset_list_col_location']!=0 && $_POST['virtual']!=1)
									{
										echo '
										<td style="vertical-align:middle;" onclick="document.location=\''.$asset_link.'\'">
											<a class="td" href="'.$asset_link.'"> 
												'.$rlocation['name'].'
											</a>
										</td>
										';
									}
									echo "
									<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
										<center>
											<a class=\"td\" href=\"$asset_link\">
												$rowdate
											</a>
										</center>
									</td>
									";
									if($rparameters['asset_warranty'] && $_GET['warranty']==1)
									{
											echo "
										<td style=\"vertical-align:middle;\" onclick=\"document.location='$asset_link'\">
											<center>
												<a class=\"td\" href=\"$asset_link\">
													$rowdateendwarranty
												</a>
											</center>
										</td>
										";
									}
									echo '
									<td onclick="document.location=\''.$asset_link.'\'">
										<a class="td" href="'.$asset_link.'"> 
											<center>
												<span class="'.$rstate['display'].'">
													'.T_($rstate['name']).'
												</span>
											</center>
										</a>
									</td>
								</tr>
							';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
//multi-pages link
if  ($resultcount[0]>$rparameters['maxline'])
{
	//count number of page
	$total_page=ceil($resultcount[0]/$rparameters['maxline']);
	echo '
	<center>
		<ul class="pagination">';
			//display previous button if it's not the first page
			if ($_GET['cursor']!=0)
			{
				$cursor=$_GET['cursor']-$rparameters['maxline'];
				echo '<li class=""><a title="'.T_('Page précédente').'" href="'.$url.'&amp;order='.$_GET['order'].'&amp;way='.$_GET['way'].'&amp;cursor='.$cursor.'"><i class="icon-arrow-left"></i></a></li>&nbsp;&nbsp;&nbsp;';
			}
			//display first page
			if ($_GET['cursor']==0){$active='class="active"';} else	{$active='';}
			echo '<li '.$active.'><a title="'.T_('Première page').'" href="'.$url.'&amp;order='.$_GET['order'].'&amp;way='.$_GET['way'].'&amp;cursor=0">&nbsp;1&nbsp;</a></li>';
			//calculate current page
			$current_page=($_GET['cursor']/$rparameters['maxline'])+1;
			//calculate min and max page 
			if(($current_page-3)<3) {$min_page=2;} else {$min_page=$current_page-3;}
			if(($total_page-$current_page)>3) {$max_page=$current_page+4;} else {$max_page=$total_page;}
			//display all pages links
			for ($page = $min_page; $page <= $total_page; $page++) {
				//display start "..." page link
				if (($page==$min_page) && ($current_page>5)){echo '<li><a title="'.T_('Pages masqués').'" href="">&nbsp;...&nbsp;</a></li>';}
				//init cursor
				if ($page==1) {$cursor=0;}
				$selectcursor=$rparameters['maxline']*($page-1);
				if ($_GET['cursor']==$selectcursor){$active='class="active"';} else	{$active='';}
				$cursor=(-1+$page)*$rparameters['maxline'];
				//display page link
				if($page!=$max_page) echo '<li '.$active.'><a title="'.T_('Page').' '.$page.'" href="'.$url.'&amp;order='.$_GET['order'].'&amp;way='.$_GET['way'].'&amp;cursor='.$cursor.'">&nbsp;'.$page.'&nbsp;</a></li>';
				//display end "..." page link
				if (($page==($max_page-1)) && ($page!=$total_page-1)) {
					echo '<li><a title="'.T_('Pages masqués').'" href="">&nbsp;...&nbsp;</a></li>';
				}
				//cut if there are more than 3 pages
				if ($page==($current_page+4)) {
					$page=$total_page;
				} 
			}
			//display last page
			$cursor=($total_page-1)*$rparameters['maxline'];
			if ($_GET['cursor']==$selectcursor){$active='class="active"';} else	{$active='';}
			echo '<li '.$active.'><a title="'.T_('Dernière page').'" href="'.$url.'&amp;order='.$_GET['order'].'&amp;way='.$_GET['way'].'&amp;cursor='.$cursor.'">&nbsp;'.$total_page.'&nbsp;</a></li>';
			//display next button if it's not the last page
			if ($_GET['cursor']<($resultcount[0]-$rparameters['maxline']))
			{
				$cursor=$_GET['cursor']+$rparameters['maxline'];
				echo '&nbsp;&nbsp;&nbsp;<li class=""><a title="'.T_('Page suivante').'" href="'.$url.'&amp;order='.$_GET['order'].'&amp;way='.$_GET['way'].'&amp;cursor='.$cursor.'"><i class="icon-arrow-right"></i></a></li>';
			}
			echo '
		</ul>
	</center>
';
if($rparameters['debug']==1){echo "<br /><b><u>DEBUG MODE</u></b> [Multi-page links] _GET[cursor]=$_GET[cursor] | current_page=$current_page | total_page=$total_page | min_page=$min_page | max_page=$max_page";}
}

//////////////////////////////////////functions
//date conversion
function date_cnv ($date) 
{return substr($date,8,2) . "/" . substr($date,5,2) . "/" . substr($date,0,4);}
?>