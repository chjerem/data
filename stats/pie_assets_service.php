<?php
################################################################################
# @Name : pie_assets_service.php
# @Description : Display Statistics 
# @call : /stat.php
# @parameters : 
# @Author : Flox
# @Create : 13/02/2016
# @Update : 05/04/2017
# @Version : 3.1.19
################################################################################

//array declaration
$values = array();
$xnom = array();

//display title
$libchart=T_("Répartition du nombre d\'équipements par services");
$unit=T_('Équipements');

//query
$query1 = "
SELECT tservices.name as service, COUNT(*) as nb
FROM tassets, tservices
WHERE 
tservices.id=tassets.department AND
tassets.disable='0' AND
tassets.type LIKE '$_POST[type]' AND
tassets.department LIKE '$_POST[service]' AND
tassets.model LIKE '$_POST[model]' AND
tassets.date_install LIKE '%-$_POST[month]-%' AND
tassets.date_install LIKE '$_POST[year]-%' AND
tassets.technician LIKE '$_POST[tech]'
GROUP BY tservices.name 
ORDER BY nb
DESC ";
$query = $db->query($query1);
while ($row=$query->fetch()) 
{
	$name=substr($row[0],0,35);
	$name=str_replace("'","\'",$name); 
	array_push($values, $row[1]);
	array_push($xnom, $name);
}
$query->closecursor(); 
$container='container101';
include('./stat_pie.php');
echo "<div id=\"$container\"></div>";
if ($rparameters['debug']==1)echo $query1;
?>