<?php
################################################################################
# @Name : procedure.php
# @Desc : display, edit and add procedure
# @call : /index.php
# @parameters : 
# @Author : Flox
# @Create : 03/09/2013
# @Update : 08/02/2017
# @Version : 3.1.17
################################################################################

//initialize variables 
if(!isset($_POST['addprocedure'])) $_POST['addprocedure'] = '';
if(!isset($_POST['save'])) $_POST['save'] = '';
if(!isset($_POST['modif'])) $_POST['modif'] = '';
if(!isset($_POST['return'])) $_POST['return'] = '';
if(!isset($_POST['subcat'])) $_POST['subcat'] = '';
if(!isset($_POST['name'])) $_POST['name'] = '';
if(!isset($_POST['category'])) $_POST['category'] = '';
	
if(!isset($_GET['procedure'])) $_GET['procedure'] = '';
if(!isset($_GET['edit'])) $_GET['edit'] = '';
if(!isset($_GET['delete_file'])) $_GET['delete_file'] = '';

//delete procedure
if ($_GET['action']=='delete' && $rright['procedure_delete']!=0)
{
	//disable ticket
	$db->exec("UPDATE tprocedures SET disable='1' WHERE id LIKE '$_GET[id]'");
	//display delete message
	echo '<div class="alert alert-block alert-danger"><center><i class="icon-remove red"></i>	'.T_('Procédure supprimée').'.</center></div>';
	//redirect
	$www = "./index.php?page=procedure";
	echo "<SCRIPT LANGUAGE='JavaScript'>
		<!--
		function redirect()
		{
		window.location='$www'
		}
		setTimeout('redirect()',$rparameters[time_display_msg]);
		-->
	</SCRIPT>";
}

//if delete procedure is submit
if ($_GET['delete_file'] && $rright['procedure_modify']!=0)
{
	//disable ticket
	if ($_GET['id']) {unlink('./upload/procedure/'.$_GET['id'].'/'.$_GET['delete_file'].'');}
	//display delete message
	echo '<div class="alert alert-block alert-danger"><center><i class="icon-remove red"></i>	'.T_('Fichier supprimé').'.</center></div>';
	//redirect
	$www = './index.php?page=procedure&action=edit&id='.$_GET['id'];
	echo "<SCRIPT LANGUAGE='JavaScript'>
		<!--
		function redirect()
		{
		window.location='$www'
		}
		setTimeout('redirect()',$rparameters[time_display_msg]);
		-->
	</SCRIPT>";
}

//if add procedure is submit
if ($_GET['action']=='add' && $rright['procedure_add']!=0)
{
	//Database modification
	if($_POST['save'])
	{
		//create procedure folder if not exist
		if (!file_exists('./upload/procedure')) {
			mkdir('./upload/procedure', 0777, true);
		}
		//escape special char and secure string before database insert
		$_POST['name']=strip_tags($db->quote($_POST['name']));
		$_POST['text'] = $db->quote($_POST['text']);
		
		$db->exec("INSERT INTO tprocedures (name,text,category,subcat) VALUES ($_POST[name],$_POST[text],'$_POST[category]','$_POST[subcat]')");
		
		//display action message
		echo '
			<div class="alert alert-block alert-success">
				<i class="icon-ok green"></i>
				'.T_('La procédure à été sauvegardée').'.
			</div>
		';
		
		 //redirect
		$www = "./index.php?page=procedure";
		echo "<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function redirect()
			{
			window.location='$www'
			}
			setTimeout('redirect()',$rparameters[time_display_msg]);
			-->
			</SCRIPT>";
	}
	//form to add a new procedure
	echo '
		<div class="page-header position-relative">
			<h1>
				<i class="icon-book"></i> '.T_('Ajout d\'une procédure').'
			</h1>
		</div>
		<fieldset>
			<div class="col-xs-12">
				<form method="POST" enctype="multipart/form-data" name="myform" id="myform" action="" onsubmit="loadVal();" >
					<label for="name">'.T_('Nom de la procédure').':</label>
					<input name="name" size="50px" type="text" value="'; echo $_POST['name']; echo '">
						<br />
					<br />
					<label for="category">'.T_('Catégorie').':</label>
					<select name="category" onchange="submit();">
					    ';
					    	$qcat = $db->query("SELECT * FROM tcategory ORDER BY name"); 
        					while ($rcat = $qcat->fetch())
        					{
        					    if($_POST['category'])
        					    {
        					        if($rcat['id']==$_POST['category']) {echo '<option selected value="'.$rcat['id'].'">'.$rcat['name'].'</option>';}
        					    } elseif ($row['category']==$rcat['id']) 
        					    {
        					        echo '<option selected value="'.$rcat['id'].'">'.$rcat['name'].'</option>';
        					    } 
        					    echo '<option value="'.$rcat['id'].'">'.$rcat['name'].'</option>';
        					}
							$query->closeCursor(); 
					    echo '
					</select>
					<br />
					<br />
					<label for="subcat">'.T_('Sous-catégorie').':</label>
					<select name="subcat">
					   ';
					    	if ($_POST['category'])
							{$qsubcat= $db->query("SELECT * FROM `tsubcat` WHERE cat LIKE '$_POST[category]' order by name ASC"); }
							else
							{$qsubcat= $db->query("SELECT * FROM `tsubcat` WHERE cat='1' order by name ASC");}
        					while ($rsubcat=$qsubcat->fetch())
        					{
        					    if($_POST['subcat'])
        					    {
            					    if ($rsubcat['id']==$_POST['subcat'])
            					    {
            					        echo '<option selected value="'.$rsubcat['id'].'">'.$rsubcat['name'].'</option>';
            					    }
        					    } elseif ($row['subcat']==$rsubcat['id']) {
        					        echo '<option selected value="'.$rsubcat['id'].'">'.$rsubcat['name'].'</option>';
        					    }
        					        echo '<option value="'.$rsubcat['id'].'">'.$rsubcat['name'].'</option>';
        					    
        					}
							$query->closeCursor();
					    echo '
					</select>
					<br /><br />
					<div id="editor" class="wysiwyg-editor"></div>
					<input type="hidden" name="text" />
					<div class="form-actions align-right clearfix">
						<button name="return" value="return" id="return" type="submit" class="btn btn-danger">
							<i class="icon-undo bigger-110"></i>
							'.T_('Retour').'
						</button>
						&nbsp;&nbsp;&nbsp;
						<button name="save" value="save" id="save" type="submit" class="btn btn-success">
							<i class="icon-save bigger-110"></i>
							'.T_('Sauvegarder').'
						</button>
					</div>
				</form>
			</div>
		</fieldset>			
	';
}
//if modif procedure
else if ($_GET['action']=='edit')
{
//Database modification
	if($_POST['modif'])
	{
		//create procedure folder if not exist
		if (!file_exists('./upload/procedure')) {
			mkdir('./upload/procedure', 0777, true);
		}
		
		//upload file in /upload/procedure directory
		if($_FILES['procedure_file']['name'])
		{
			$filename = $_FILES['procedure_file']['name'];
			//change special character in filename
			$a = array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'œ', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'š', 'ž', "'", " ", "/", "%", "?", ":", "!", "’", ",",">","<");
			$b = array("a", "a", "a", "a", "a", "a", "ae", "c", "e", "e", "e", "e", "i", "i", "i", "i", "n", "o", "o", "o", "o", "o", "o", "oe", "u", "u", "u", "u", "y", "y", "s", "z", "-", "-", "-", "-", "", "-", "", "-", "-", "", "");
			$file_rename = str_replace($a,$b,$_FILES['procedure_file']['name']);
			//secure upload excluding certain extension files
			$whitelist =  array('pdf','doc','docx','png','jpg','jpeg' ,'gif' ,'bmp');
			//black list exclusion for extension
			$blacklist =  array('php', 'php1', 'php2','php3' ,'php4' ,'php5', 'php6', 'php7', 'php8', 'php9', 'php10', 'js', 'htm', 'html', 'phtml', 'exe', 'jsp' ,'pht', 'shtml', 'asa', 'cer', 'asax', 'swf', 'xap', 'phphp', 'inc', 'htaccess', 'sh', 'py', 'pl', 'jsp', 'asp', 'cgi', 'json', 'svn', 'git', 'lock', 'yaml', 'com', 'bat', 'ps1', 'cmd', 'vb', 'hta', 'reg', 'ade', 'adp', 'app', 'asp', 'bas', 'bat', 'cer', 'chm', 'cmd', 'com', 'cpl', 'crt', 'csh', 'der', 'exe', 'fxp', 'gadget', 'hlp', 'hta', 'inf', 'ins', 'isp', 'its', 'js', 'jse', 'ksh', 'lnk', 'mad', 'maf', 'mag', 'mam', 'maq', 'mar', 'mas', 'mat', 'mau', 'mav', 'maw', 'mda', 'mdb', 'mde', 'mdt', 'mdw', 'mdz', 'msc', 'msh', 'msh1', 'msh2', 'mshxml', 'msh1xml', 'msh2xml', 'msi', 'msp', 'mst', 'ops', 'pcd', 'pif', 'plg', 'prf', 'prg', 'pst', 'reg', 'scf', 'scr', 'sct', 'shb', 'shs', 'ps1', 'ps1xml', 'ps2', 'ps2xml', 'psc1', 'psc2', 'tmp', 'url', 'vb', 'vbe', 'vbs', 'vsmacros', 'vsw', 'ws', 'wsc', 'wsf', 'wsh', 'xnk');
			//default value
			$blacklistedfile=0;
			$ext=explode('.',$filename);
			foreach ($ext as &$value) {
				$value=strtolower($value);
				if(in_array($value,$blacklist) ) {
					$blacklistedfile=1;
				} 
			}
			if(in_array(end($ext),$whitelist) && $blacklistedfile==0 ) {
				//create procedure directory if not exist
				if (!file_exists('./upload/procedure/'.$_GET['id'].'/')) {
					mkdir('./upload/procedure/'.$_GET['id'].'', 0777, true);
				}
				$dest_folder = './upload/procedure/'.$_GET['id'].'/';
				if (move_uploaded_file($_FILES['procedure_file']['tmp_name'], $dest_folder.$file_rename)   ) 
				{
				} else {
				echo T_('Erreur de transfert vérifier le chemin').' '.$dest_folder;
				}
			} else {
				echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Blocage de sécurité').':</strong> '.T_('Fichier interdit').'.<br></div>';
			}
		}
		
		//escape special char and secure string before database insert
		$_POST['name']=strip_tags($db->quote($_POST['name']));
		$_POST['text'] = $db->quote($_POST['text']);
	
		$db->query("UPDATE tprocedures SET name=$_POST[name], text=$_POST[text], category='$_POST[category]', subcat='$_POST[subcat]' WHERE id='$_GET[id]'");
		
		//display action message
		echo '
			<div class="alert alert-block alert-success">
				<i class="icon-ok green"></i>
				'.T_('La procédure').'
				<strong class="green">
					<small>'.$_GET['id'].'</small>
				</strong>
				'.T_('à été sauvegardée').'.
			</div>
		';
		
		 //redirect
		$www = "./index.php?page=procedure&id=$_GET[id]&action=edit&";
		echo "<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function redirect()
			{
			window.location='$www'
			}
			setTimeout('redirect()',$rparameters[time_display_msg]);
			-->
			</SCRIPT>";
	}
	if($_POST['return'])
	{
		//redirect
		$www = "./index.php?page=procedure";
		echo "<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function redirect()
			{
			window.location='$www'
			}
			setTimeout('redirect()',$rparameters[time_display_msg]);
			-->
			</SCRIPT>";
	}
	//SQL query
	$query = $db->query("SELECT * FROM tprocedures WHERE id='$_GET[id]'"); 
	$row=$query->fetch();
	
	//detect <br> for wysiwyg transition from 2.9 to 3.0
	$findbr=stripos($row['text'], '<br>');
	if ($findbr === false) {$text=nl2br($row['text']);} else {$text=$row['text'];}
	
	//form to modify an existing procedure
	echo '
		<div class="page-header position-relative">
			<h1>
				<i class="icon-book"></i> '.T_('Édition de la procédure').' n°'.$row['id'].': '.$row['name'].'
			</h1>
		</div>
		<fieldset>
			<div class="col-xs-12">
				<form method="POST" enctype="multipart/form-data" name="myform" id="myform" action="" onsubmit="loadVal();" >
					<label for="name">'.T_('Nom de la procédure').':</label>
					<input name="name" size="50px" type="text" value="'.$row['name'].'" '; if ($rright['procedure_modify']==0) {echo 'readonly="readonly"';} echo '>
					<br />
					<br />
					<label for="category">'.T_('Catégorie').':</label>
					<select name="category" onchange="submit();" '; if ($rright['procedure_modify']==0) {echo 'disabled="disabled"';} echo '>
					    ';
					       
					    	$qcat = $db->query("SELECT * FROM tcategory ORDER BY name"); 
        					while ($rcat=$qcat->fetch())
        					{
        					    if($_POST['category'])
        					    {
        					        if($rcat['id']==$_POST['category']) {echo '<option selected value="'.$rcat['id'].'">'.$rcat['name'].'</option>';}
        					    } elseif ($row['category']==$rcat['id']) 
        					    {
        					        echo '<option selected value="'.$rcat['id'].'">'.$rcat['name'].'</option>';
        					    } 
        					    echo '<option value="'.$rcat['id'].'">'.$rcat['name'].'</option>';
        					}
					    echo '
					</select>
					<br />
					<br />
					<label for="subcat">'.T_('Sous-catégorie').':</label>
					<select name="subcat" '; if ($rright['procedure_modify']==0) {echo 'disabled="disabled"';} echo '>
					   ';
							
					    	if ($_POST['category'])
							{$qsubcat= $db->query("SELECT * FROM `tsubcat` WHERE cat LIKE '$_POST[category]' order by name ASC"); }
							else
							{$qsubcat= $db->query("SELECT * FROM `tsubcat` WHERE cat LIKE '$row[category]' order by name ASC");}
        					while ($rsubcat=$qsubcat->fetch())
        					{
        					    if($_POST['subcat'])
        					    {
            					    if ($rsubcat['id']==$_POST['subcat'])
            					    {
            					        echo '<option selected value="'.$rsubcat['id'].'">'.$rsubcat['name'].'</option>';
            					    }
        					    } elseif ($row['subcat']==$rsubcat['id']) {
        					        echo '<option selected value="'.$rsubcat['id'].'">'.$rsubcat['name'].'</option>';
        					    }
        					        echo '<option value="'.$rsubcat['id'].'">'.$rsubcat['name'].'</option>';
        					    
        					}
					    echo '
					</select>
					<br /><br />
					';
					if($rright['procedure_modify']!=0) {
						echo '
						<label for="procedure_file">'.T_('Joindre un fichier').':</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
						<input name="procedure_file"  type="file" style="display:inline" />
						<br /><br />
						';
					}
					
					//listing of attach file
					if (file_exists('./upload/procedure/'.$_GET['id'].'/')) {	
						if ($handle = opendir('./upload/procedure/'.$_GET['id'].'/')) {
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									echo '
									<i class="icon-paperclip grey bigger-130"></i> 
									<a target="about_blank" title="'.T_('Télécharger le fichier').' '.$entry.'" href="./upload/procedure/'.$_GET['id'].'/'.$entry.'">'.$entry.'</a>
									';
									if($rright['procedure_modify']!=0) {echo '<a href="./index.php?page=procedure&id='.$_GET['id'].'&action=edit&delete_file='.$entry.'" title="'.T_('Supprimer').'"<i class="icon-trash red bigger-130"></i></a>';}
									echo '
									<br />
									';
								}
							}
							closedir($handle);
						}
					}
					echo '<br />';
					if ($rright['procedure_modify']==0) 
					{echo '<label for="procedure">'.T_('Procédure').':</label><br /><br />'.$text;} 
					else
					{echo '<div id="editor" class="wysiwyg-editor">'.$text.'</div>';}
					echo '
					<input type="hidden" name="text" />
					<div class="form-actions align-right clearfix">
						<button name="return" value="return" id="return" type="submit" class="btn btn-danger">
							<i class="icon-undo bigger-110"></i>
							'.T_('Retour').'
						</button>
						';
						if($rright['procedure_modify']!=0) {
							echo '
							&nbsp;&nbsp;&nbsp;
							<button name="modif" value="modif" id="modif" type="submit" class="btn btn-success">
								<i class="icon-save bigger-110"></i>
								'.T_('Sauvegarder').'
							</button>
							';
						}
						echo '
					</div>
				</form>
			</div>
		</fieldset>			
	';
}
//display list of procedure
else
{
	//SQL query
	$query = $db->query("SELECT count(*) FROM tprocedures WHERE disable=0"); 
	$row=$query->fetch();
	echo '
		<div class="page-header position-relative">
			<h1>
				<i class="icon-book"></i> 
				'.T_('Procédures').'
				<small>
					<i class="icon-double-angle-right"></i>
					&nbsp;'.T_('Nombre').': '.$row[0].' &nbsp;&nbsp;
				</small>
			</h1>
		</div>
		';

	//display add button
	if($rright['procedure_modify']!=0 && $rright['procedure_add']!=0) {
		echo '
		<form name="add" method="post" action="index.php?page=procedure&amp;action=add"  id="thisform">
			<button name= name="addprocedure" value="Ajouter" id="addprocedure" type="submit" class="btn btn-sm btn-success">
				<i class="icon-plus"></i> '.T_('Ajouter une procédure').'
			</button>
		</form>
		<div class="space-4"></div>
		';
	}
	//begin table
	echo '
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th><i class="icon-circle"></i> '.T_('Numéro').'</th>
					<th><i class="icon-sign-blank"></i> '.T_('Catégorie').'</th>
					<th><i class="icon-sitemap"></i> '.T_('Sous-catégorie').'</th>
					<th><i class="icon-tag"></i> '.T_('Nom de la procédure').'</th>
					<th><i class="icon-play"></i> '.T_('Actions').'</th>
				</tr>
			</thead>
			<tbody>
				';
					$masterquery = $db->query("SELECT * FROM tprocedures WHERE disable=0 ORDER by category,subcat ASC"); 
					while ($row=$masterquery->fetch())
					{
					   //get cat name
					   	$qcat=$db->query("SELECT name FROM tcategory WHERE id=$row[category]"); 
	                    $rcat=$qcat->fetch();;
	                    $qscat=$db->query("SELECT name FROM tsubcat WHERE id=$row[subcat]"); 
	                    $rscat=$qscat->fetch();;
						echo '
						<tr >	
							<td onclick="document.location=\'./index.php?page=procedure&amp;id='.$row['id'].'&amp;action=edit\'" >'.$row['id'].'</td>
							<td onclick="document.location=\'./index.php?page=procedure&amp;id='.$row['id'].'&amp;action=edit\'" >'.$rcat[0].'</td>
							<td onclick="document.location=\'./index.php?page=procedure&amp;id='.$row['id'].'&amp;action=edit\'" >'.$rscat[0].'</td>
							<td onclick="document.location=\'./index.php?page=procedure&amp;id='.$row['id'].'&amp;action=edit\'" >'.$row['name'].'</td>
							<td>
								<div class="hidden-phone visible-desktop btn-group">	
									';
									//display actions buttons if right is ok
									if($rright['procedure_modify']!=0) {
										echo '
										<button title="'.T_('Éditer').'" onclick=\'window.location.href="./index.php?page=procedure&amp;id='.$row['id'].'&amp;action=edit";\' class="btn btn-xs btn-warning">
											<i class="icon-edit bigger-120"></i>
										</button>
										';
									}
									if($rright['procedure_delete']!=0) {
										echo '
										<button title="'.T_('Supprimer').'" onclick=\'window.location.href="./index.php?page=procedure&amp;id='.$row['id'].'&amp;action=delete";\' class="btn btn-xs btn-danger">
											<i class="icon-trash bigger-120"></i>
										</button>
										';
									}
									echo '
								</div>
								
							</td>
						</tr>
						';
					}
				echo '
			</tbody>
		</table>
	';
}
include ('./wysiwyg.php');
?>