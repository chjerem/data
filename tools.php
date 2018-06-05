<?php
################################################################################
# @Name : tools.php
# @Description : tools page
# @Call : /index.php
# @Parameters : 
# @Author : jchoux & tlenoir
# @Create : 05/06/2018
# @Update : 05/06/2018
# @Version : 1
################################################################################

// initialize variables 
if(!isset($_GET['subpage'])) $_GET['subpage'] = '';
if(!isset($_GET['profileid'])) $_GET['profileid'] = '';

//default settings
if ($_GET['subpage']=='profile' && $_GET['profileid']=='') $_GET['profileid']=0;

echo 'Merci de naviguer correctement à travers les menus du site ;-)';
?>