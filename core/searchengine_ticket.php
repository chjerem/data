<?php
################################################################################
# @Name : searchengine_ticket.php
# @Description : search engine in database tickets
# @call : /dashboard.php
# @parameters : keywords
# @Author : Flox
# @Create : 12/01/2011
# @Update : 18/04/2017
# @Version : 3.1.20
################################################################################

//initialize session variables
if(!isset($_SESSION['user_id'])) $_SESSION['user_id'] = '';

//case when keywords contain '
$keywords = str_replace("'","\'",$keywords);

//keywords table space separation
$keyword=explode(" ",$keywords);

//count $keywords
$nbkeyword= sizeof($keyword);

//case meta state detect
if($_GET['state']=='meta'){$state="AND	(tincidents.state=1 OR tincidents.state=2 OR tincidents.state=6)";} else {$state='';}

$select= "DISTINCT tincidents.*";
$join='';

if ($nbkeyword==2)
{
	$from = "tincidents, tstates, tthreads";
	$where="
	tincidents.state=tstates.id AND
	tincidents.id=tthreads.ticket AND
	(
		tincidents.title LIKE '%$keyword[0]%' OR 
		tincidents.description LIKE '%$keyword[0]%' OR 
		tthreads.text LIKE '%$keyword[0]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[0]%' OR lastname LIKE '%$keyword[0]%') AND disable=0) 
	) AND (
		tincidents.title LIKE '%$keyword[1]%' OR 
		tincidents.description LIKE '%$keyword[1]%' OR 
		tthreads.text LIKE '%$keyword[1]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[1]%' OR lastname LIKE '%$keyword[1]%') AND disable=0)
	) AND (
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
		AND	tincidents.priority LIKE '$_POST[priority]'
		AND	tincidents.criticality LIKE '$_POST[criticality]'
		AND	tincidents.type LIKE '$_POST[type]'
		AND	tincidents.title LIKE '$_POST[title]'
	)
	$where_service
	$state
	AND tincidents.disable='0'
"; 
}
else if ($nbkeyword==3)
{
	$from = "tincidents, tstates, tthreads";
	$where="
	tincidents.state=tstates.id AND
	tincidents.id=tthreads.ticket AND
	(
		tincidents.title LIKE '%$keyword[0]%' OR 
		tincidents.description LIKE '%$keyword[0]%' OR 
		tthreads.text LIKE '%$keyword[0]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[0]%' OR lastname LIKE '%$keyword[0]%') AND disable=0) 
	) AND (
		tincidents.title LIKE '%$keyword[1]%' OR 
		tincidents.description LIKE '%$keyword[1]%' OR 
		tthreads.text LIKE '%$keyword[1]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[1]%' OR lastname LIKE '%$keyword[1]%') AND disable=0)
	) AND (
		tincidents.title LIKE '%$keyword[2]%' OR 
		tincidents.description LIKE '%$keyword[2]%' OR 
		tthreads.text LIKE '%$keyword[2]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[2]%' OR lastname LIKE '%$keyword[2]%') AND disable=0)
	) AND (
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
		AND	tincidents.priority LIKE '$_POST[priority]'
		AND	tincidents.criticality LIKE '$_POST[criticality]'
		AND	tincidents.type LIKE '$_POST[type]'
		AND	tincidents.title LIKE '$_POST[title]'
	)
	$where_service
	$state
	AND tincidents.disable='0'
"; 
} 
else if ($nbkeyword==4)
{
	$from = "tincidents, tstates, tthreads";
	$where="
	tincidents.state=tstates.id AND
	tincidents.id=tthreads.ticket AND
	(
		tincidents.title LIKE '%$keyword[0]%' OR 
		tincidents.description LIKE '%$keyword[0]%' OR 
		tthreads.text LIKE '%$keyword[0]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[0]%' OR lastname LIKE '%$keyword[0]%') AND disable=0) 
	) AND (
		tincidents.title LIKE '%$keyword[1]%' OR 
		tincidents.description LIKE '%$keyword[1]%' OR 
		tthreads.text LIKE '%$keyword[1]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[1]%' OR lastname LIKE '%$keyword[1]%') AND disable=0)
	) AND (
		tincidents.title LIKE '%$keyword[2]%' OR 
		tincidents.description LIKE '%$keyword[2]%' OR 
		tthreads.text LIKE '%$keyword[2]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[2]%' OR lastname LIKE '%$keyword[2]%') AND disable=0)
	) AND (
		tincidents.title LIKE '%$keyword[3]%' OR 
		tincidents.description LIKE '%$keyword[3]%' OR 
		tthreads.text LIKE '%$keyword[3]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[3]%' OR lastname LIKE '%$keyword[3]%') AND disable=0)
	) AND (
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
		AND	tincidents.priority LIKE '$_POST[priority]'
		AND	tincidents.criticality LIKE '$_POST[criticality]'
		AND	tincidents.type LIKE '$_POST[type]'
		AND	tincidents.title LIKE '$_POST[title]'
	)
	$where_service
	$state
	AND tincidents.disable='0'
"; 
} else if ($nbkeyword==5)
{
	$from = "tincidents, tstates, tthreads";
	$where="
	tincidents.state=tstates.id AND
	tincidents.id=tthreads.ticket AND
	(
		tincidents.title LIKE '%$keyword[0]%' OR 
		tincidents.description LIKE '%$keyword[0]%' OR 
		tthreads.text LIKE '%$keyword[0]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[0]%' OR lastname LIKE '%$keyword[0]%') AND disable=0) 
	) AND (
		tincidents.title LIKE '%$keyword[1]%' OR 
		tincidents.description LIKE '%$keyword[1]%' OR 
		tthreads.text LIKE '%$keyword[1]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[1]%' OR lastname LIKE '%$keyword[1]%') AND disable=0)
	) AND (
		tincidents.title LIKE '%$keyword[2]%' OR 
		tincidents.description LIKE '%$keyword[2]%' OR 
		tthreads.text LIKE '%$keyword[2]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[2]%' OR lastname LIKE '%$keyword[2]%') AND disable=0)
	) AND (
		tincidents.title LIKE '%$keyword[3]%' OR 
		tincidents.description LIKE '%$keyword[3]%' OR 
		tthreads.text LIKE '%$keyword[3]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[3]%' OR lastname LIKE '%$keyword[3]%') AND disable=0)
	) AND (
		tincidents.title LIKE '%$keyword[4]%' OR 
		tincidents.description LIKE '%$keyword[4]%' OR 
		tthreads.text LIKE '%$keyword[4]%' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[4]%' OR lastname LIKE '%$keyword[4]%') AND disable=0)
	) AND (
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
		AND	tincidents.priority LIKE '$_POST[priority]'
		AND	tincidents.criticality LIKE '$_POST[criticality]'
		AND	tincidents.type LIKE '$_POST[type]'
		AND	tincidents.title LIKE '$_POST[title]'
	)
	$where_service
	$state
	AND tincidents.disable='0'
"; 
}
else
{
	$from = "tincidents, tstates, tthreads, tsubcat, tcategory";
	$where="
	tincidents.state=tstates.id AND
	tincidents.id=tthreads.ticket AND
	tincidents.subcat=tsubcat.id AND
	tincidents.category=tcategory.id AND
	(
		tincidents.title LIKE '%$keyword[0]%' OR 
		tincidents.description LIKE '%$keyword[0]%' OR 
		tthreads.text LIKE '%$keyword[0]%' OR
		tsubcat.name LIKE '$keyword[0]' OR
		tcategory.name LIKE '$keyword[0]' OR
		tincidents.id = '$keyword[0]' OR
		tincidents.user LIKE (SELECT max(id) FROM tusers where (firstname LIKE '%$keyword[0]%' OR lastname LIKE '%$keyword[0]%') AND disable=0)
	) AND (
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
		AND	tincidents.priority LIKE '$_POST[priority]'
		AND	tincidents.criticality LIKE '$_POST[criticality]'
		AND	tincidents.type LIKE '$_POST[type]'
		AND	tincidents.title LIKE '$_POST[title]'
	)
	$where_service
	$state
	AND disable='0'
	"; 
}	
?>