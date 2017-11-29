<?php
################################################################################
# @Name : ./core/import_asset.php
# @Description : import asset from a csv file
# @call : /admin/parameters.php
# @parameters : filename $_FILE[asset_import][name]
# @Author : Flox
# @Create : 20/01/2017
# @Update : 27/03/2017
# @Version : 3.1.19
################################################################################

if ($rparameters['debug']==1) {echo "<u><b>DEBUG:</b></u><br />";}

//test if file exist
$filename = "./upload/asset/$file_rename";
if (file_exists($filename)) {
	//read file
	$file = fopen($filename, 'r');
	$i=0;
	while (($line = fgetcsv($file)) !== FALSE) {
		$i++;
		if ($i!=1) //don't show first line
		{
			$line[0]=utf8_encode($line[0]);
			$read_line=explode(";",$line[0]);
			//put data to var
			$sn_internal=strip_tags($db->quote($read_line[0]));
			$netbios=strip_tags($db->quote($read_line[1]));
			$sn_manufacturer=strip_tags($db->quote($read_line[2]));
			$sn_indent=strip_tags($db->quote($read_line[3]));
			$ip=strip_tags($db->quote($read_line[4]));
			$mac=strip_tags($db->quote($read_line[5]));
			$description=strip_tags($db->quote($read_line[6]));
			$type=strip_tags($db->quote($read_line[7]));
			$manufacturer=strip_tags($db->quote($read_line[8]));
			$model=strip_tags($db->quote($read_line[9]));
			$user=strip_tags($read_line[10]);
			$state=strip_tags($db->quote($read_line[11]));
			$department=strip_tags($db->quote($read_line[12]));
			$location=strip_tags($db->quote($read_line[13]));
			$date_install=$read_line[14];
			$date_end_warranty=$read_line[15];
			$date_stock=$read_line[16];
			$date_standbye=$read_line[17];
			$date_recycle=$read_line[18];
			$date_last_ping=$read_line[19];
			$socket=strip_tags($db->quote($read_line[20]));
			$technician=strip_tags($read_line[21]);
			$maintenance=strip_tags($db->quote($read_line[22]));
			
			//convert date to SQL format
			$date_install = DateTime::createFromFormat('d/m/Y', $date_install);
			$date_install=$date_install->format('Y-m-d');
			$date_end_warranty = DateTime::createFromFormat('d/m/Y', $date_end_warranty);
			$date_end_warranty=$date_end_warranty->format('Y-m-d');
			$date_stock = DateTime::createFromFormat('d/m/Y', $date_stock);
			$date_stock=$date_stock->format('Y-m-d');
			$date_standbye = DateTime::createFromFormat('d/m/Y', $date_standbye);
			$date_standbye=$date_standbye->format('Y-m-d');
			$date_recycle = DateTime::createFromFormat('d/m/Y', $date_recycle);
			$date_recycle=$date_recycle->format('Y-m-d');
			$date_last_ping = DateTime::createFromFormat('d/m/Y', $date_last_ping);
			$date_last_ping=$date_last_ping->format('Y-m-d');
			
			//get id value or create row in specific tables
			//type
			$find_type=0;
			$query = $db->query("SELECT id,name FROM `tassets_type`");
			while ($row=$query->fetch()){if ($type=="'$row[name]'") $find_type=$row['id'];}
			if($find_type==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create type $type: not found in GestSup database.<br />";}
				$db->exec("INSERT INTO `tassets_type` (`name`) VALUES ($type)");
				$type=$db->lastInsertId();
			} else {$type=$find_type;}
			//manufacturer
			$find_manufacturer=0;
			$query = $db->query("SELECT id,name FROM `tassets_manufacturer`");
			while ($row=$query->fetch()){if ($manufacturer=="'$row[name]'") $find_manufacturer=$row['id'];}
			if($find_manufacturer==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create manufacturer $manufacturer: not found in GestSup database.<br />";}
				$db->exec("INSERT INTO `tassets_manufacturer` (`name`) VALUES ($manufacturer)");
				$manufacturer=$db->lastInsertId();
			} else {$manufacturer=$find_manufacturer;}
			//model
			$find_model=0;
			$query = $db->query("SELECT id,name FROM `tassets_model`");
			while ($row=$query->fetch()){if ($model=="'$row[name]'") $find_model=$row['id'];}
			if($find_model==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create model $model: not found in GestSup database.<br />";}
				$db->exec("INSERT INTO `tassets_model` (`name`,`manufacturer`,`type`) VALUES ($model,$manufacturer,$type)");
				$model=$db->lastInsertId();
			} else {$model=$find_model;}
			//user
			$find_user=0;
			$csv_user=explode(" ", $user);
			if(!isset($csv_user[0])) $csv_user[0] = '';
			if(!isset($csv_user[1])) $csv_user[1] = '';
			$csv_firstname=$csv_user[0];
			$csv_lastname=$csv_user[1];
			$query = $db->query("SELECT id,firstname,lastname FROM `tusers` WHERE disable='0'");
			while ($row=$query->fetch()){if ($csv_firstname==$row['firstname'] && $csv_lastname==$row['lastname']) $find_user=$row['id'];}
			if($find_user==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create user $user: not found in GestSup database.<br />";}
				$csv_firstname=$db->quote($csv_firstname);
				$csv_lastname=$db->quote($csv_lastname);
				$db->exec("INSERT INTO `tusers` (`firstname`,`lastname`,`profile`) VALUES ($csv_firstname,$csv_lastname,'2')");
				$user=$db->lastInsertId();
			} else {$user=$find_user;}
			//state
			$find_state=0;
			$query = $db->query("SELECT id,name FROM `tassets_state`");
			while ($row=$query->fetch()){if ($state=="'$row[name]'") $find_state=$row['id'];}
			if($find_state==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create state $state: not found in GestSup database.<br />";}
				$db->exec("INSERT INTO `tassets_state` (`name`) VALUES ($state)");
				$state=$db->lastInsertId();
			} else {$state=$find_state;}
			//department
			$find_department=0;
			$query = $db->query("SELECT id,name FROM `tservices` WHERE disable='0'");
			while ($row=$query->fetch()){if ($department=="'$row[name]'") $find_department=$row['id'];}
			if($find_department==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create department $department: not found in GestSup database.<br />";}
				$db->exec("INSERT INTO `tservices` (`name`) VALUES ($department)");
				$department=$db->lastInsertId();
			} else {$department=$find_department;}
			//location
			$find_location=0;
			$query = $db->query("SELECT id,name FROM `tassets_location` WHERE disable='0'");
			while ($row=$query->fetch()){if ($location=="'$row[name]'") $find_location=$row['id'];}
			if($find_location==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create location $location: not found in GestSup database.<br />";}
				$db->exec("INSERT INTO `tassets_location` (`name`) VALUES ($location)");
				$location=$db->lastInsertId();
			} else {$location=$find_location;}
			//technician
			$find_technician=0;
			$csv_technician=explode(" ", $technician);
			if(!isset($csv_technician[0])) $csv_technician[0] = '';
			if(!isset($csv_technician[1])) $csv_technician[1] = '';
			$csv_firstname=$csv_technician[0];
			$csv_lastname=$csv_technician[1];
			$query = $db->query("SELECT id,firstname,lastname FROM `tusers` WHERE disable='0'");
			while ($row=$query->fetch()){if ($csv_firstname==$row['firstname'] && $csv_lastname==$row['lastname']) $find_technician=$row['id'];}
			if($find_technician==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create technician $technician: not found in GestSup database.<br />";}
				$csv_firstname=$db->quote($csv_firstname);
				$csv_lastname=$db->quote($csv_lastname);
				$db->exec("INSERT INTO `tusers` (`firstname`,`lastname`,`profile`) VALUES ($csv_firstname,$csv_lastname, '0')");
				$technician=$db->lastInsertId();
			} else {$technician=$find_technician;}
			//maintenance
			$find_maintenance=0;
			$query = $db->query("SELECT id,name FROM `tservices` WHERE disable='0'");
			while ($row=$query->fetch()){if ($maintenance=="'$row[name]'") $find_maintenance=$row['id'];}
			if($find_maintenance==0) //create if not find in current table
			{
				if ($rparameters['debug']==1) {echo "create maintenance $maintenance: not found in GestSup database.<br />";}
				$db->exec("INSERT INTO `tservices` (`name`) VALUES ($maintenance)");
				$maintenance=$db->lastInsertId();
			} else {$maintenance=$find_maintenance;}
			
			$query="INSERT INTO tassets 
			(sn_internal,netbios,sn_manufacturer,sn_indent,description,type,manufacturer,model,user,state,department,location,date_install,date_end_warranty,date_stock,date_standbye,date_recycle,date_last_ping,socket,technician,maintenance)
			VALUES
			($sn_internal, $netbios, $sn_manufacturer, $sn_indent, $description, $type, $manufacturer, $model, $user, $state, $department, $location, '$date_install', '$date_end_warranty', '$date_stock', '$date_standbye', '$date_recycle', '$date_last_ping', $socket, $technician, $maintenance)";
			if ($rparameters['debug']==1) {echo "$query";}
			$db->exec("$query");
			$last_asset=$db->lastInsertId();
			
			//iface
			if ($ip)
			{
				if ($rparameters['debug']==1) {echo "create iface with IP: $ip <br />";}
				$db->exec("INSERT INTO `tassets_iface` (`role_id`,`asset_id`,`netbios`,`ip`,`mac`,`disable`) VALUES ('1',$last_asset, $netbios,$ip,$mac,'0')");
				$maintenance=$db->lastInsertId();
			}
		}
	}
	fclose($file);
	$i=$i-1;
	//delete import file
	unlink($filename);
	echo '<div class="alert alert-block alert-success"><center><i class="icon-ok green"></i> '.T_('Import de').' '.$i.' '.T_('équipements effectué avec succès.').' </center></div>';
} else {
	echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Erreur').':</strong> '.T_('Le fichier d\'import des équipements n\'existe pas').'.<br></div>';
}
?>