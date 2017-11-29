<?php
################################################################################
# @Name : line_ASset.php
# @Description : Display Statistics
# @call : /stat.php
# @parameters : 
# @Author : Flox
# @Create : 26/01/2016
# @Update : 21/04/2017
# @Version : 3.1.20
################################################################################

$user_id=$_SESSION['user_id'];

//count create period
$query=$db->query("SELECT count(*) FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]' AND department LIKE '$_POST[service]' AND date_install LIKE '$_POST[year]-$_POST[month]-%' AND disable='0'");
$row=$query->fetch();
$count=$row[0];
$query->closeCursor(); 

//count recycled period
$query=$db->query("SELECT count(*) FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]' AND department LIKE '$_POST[service]' AND date_recycle LIKE '$_POST[year]-$_POST[month]-%' AND disable='0'");
$row=$query->fetch();
$count2=$row[0];
$query->closeCursor(); 

//count total 
$query=$db->query("SELECT count(*) FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]' AND department LIKE '$_POST[service]' AND disable='0'");
$row=$query->fetch();
$count4=$row[0];
$query->closeCursor();

//query for year selection
if (($_POST['month'] == '%') && ($_POST['year']!=='%'))
{
    $values1 = array();
    $values2 = array();
    $xnom1 = array();
    $xnom2 = array();
	$libchart=T_("Évolution des équipements installés et recyclés sur").' '.$_POST['year'];
	$query1=$db->query("SELECT month(date_install) AS x,count(*) AS y FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND department LIKE '$_POST[service]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]'  AND date_install LIKE '$_POST[year]-$_POST[month]-%' AND disable='0' GROUP BY x ");
	$query2=$db->query("SELECT month(date_recycle) AS x,count(*) AS y FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND department LIKE '$_POST[service]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]' AND date_recycle NOT LIKE '0000-00-00 00:00:00' AND date_recycle LIKE '$_POST[year]-$_POST[month]-%' AND disable='0' GROUP BY x ");
	
	//push data in table
	while($data = $query1->fetch())
	{
		array_push($values1 ,$data['y']);
		array_push($xnom1 ,$data['x']);
	}
	$query1->closeCursor(); 
	while($data = $query2->fetch())
	{
		array_push($values2 ,$data['y']);
		array_push($xnom2 ,$data['x']);
	}
	$query2->closeCursor(); 
}
//query for month selection
else if ($_POST['month']!='%')
{
	
    $values1 = array();
    $values2 = array();
    $xnom1 = array();
    $xnom2 = array();
	$monthm=$_POST['month'];
	if($_POST['year']=='%') {$postyear=T_('de toutes les années');} else {$postyear=$_POST['year'];}
	$libchart=T_('Évolution des équipements installés et recyclés pour le mois de').' '.$mois[$monthm].' '.$postyear;
	$query1=$db->query("SELECT day(date_install) AS x,count(*) AS y FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND department LIKE '$_POST[service]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]'  AND date_install LIKE '$_POST[year]-$_POST[month]-%' AND disable='0' GROUP BY x ");
	$query2=$db->query("SELECT day(date_recycle) AS x,count(*) AS y FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND department LIKE '$_POST[service]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]'  AND date_recycle LIKE '$_POST[year]-$_POST[month]-%' AND disable='0' GROUP BY x ");

	//push data in table
	while($data = $query1->fetch())
	{
    	array_push($values1 ,$data['y']);
    	array_push($xnom1 ,$jour[$data['x']]);
	}
	$query1->closeCursor(); 
	while($data = $query2->fetch())
	{
    	array_push($values2 ,$data['y']);
    	array_push($xnom2 ,$jour[$data['x']]);
	}
	$query2->closeCursor(); 
}
//query for all years selection
else if ($_POST['year']=='%')
{
    $values1 = array();
    $values2 = array();
    $xnom1 = array();
    $xnom2 = array();
	$libchart=T_('Évolution des équipements installés et recyclés sur toutes les années');
	$query1=$db->query("SELECT YEAR(date_install) AS x,count(*) AS y FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND department LIKE '$_POST[service]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]' AND date_install LIKE '$_POST[year]-$_POST[month]-%' AND disable='0' GROUP BY x ");
	$query2=$db->query("SELECT YEAR(date_recycle) AS x,count(*) AS y FROM `tassets` WHERE technician LIKE '$_POST[tech]' AND department LIKE '$_POST[service]' AND type LIKE '$_POST[type]' AND type LIKE '$_POST[type]' AND date_recycle NOT LIKE '0000-00-00' AND date_recycle LIKE '$_POST[year]-$_POST[month]-%' AND disable='0' GROUP BY x ");
	// push data in table
	while($data = $query1->fetch())
	{
		array_push($values1 ,$data['y']); array_push($xnom1 ,$data['x']);	
	}	
	$query1->closeCursor(); 
	while($data = $query2->fetch())
	{
		array_push($values2 ,$data['y']); array_push($xnom2 ,$data['x']);
	}
	$query2->closeCursor(); 
}

if ($count!=0) 
{
	$liby=T_("Nombre d\'équipements");
	$container="container20";		
	include('./stat_line.php');
	echo '<div id="'.$container.'" style="min-width: 400px; height: 400px; margin: 0 auto"></div>';
}
else {echo '<div clASs="alert alert-danger"><strong><i clASs="icon-remove"></i> '.T_('Erreur').':</strong> '.T_('Aucun équipement installé ou recyclé dans la plage indiqué').'.</div>';}

//display query on debug mode
if($rparameters['debug']==1)
{
    print_r($values1);echo "<br />";
    for($i=0;$i<sizeof($values1);$i++) 
    { 
		$lASt=sizeof($values1)-1;
		if ($i!=$lASt) echo '['.$xnom1[$i].','.$values1[$i].'],'; else echo '['.$xnom1[$i].','.$values1[$i].']';
    } 
    echo "<br />";
    print_r($values2);echo "<br />";
    for($i=0;$i<sizeof($values2);$i++) 
    { 
		$lASt=sizeof($values2)-1;
		if ($i!=$lASt) echo '['.$xnom2[$i].','.$values2[$i].'],'; else echo '['.$xnom2[$i].','.$values2[$i].']';
    } 
}
?>	