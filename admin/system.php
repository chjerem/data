<?php
################################################################################
# @Name : system.php
# @Desc :  admin system
# @call : admin.php
# @parameters : 
# @Author : Flox
# @Create : 12/01/2011
# @Update : 27/12/2016
# @Version : 3.1.15
################################################################################
?>
<div class="page-header position-relative">
	<h1>
		<i class="icon-desktop"></i>  <?php echo T_('État du système'); ?>
	</h1>
</div>
<?php include('./system.php'); ?>
<hr />
<center>
	<button onclick='window.open("./admin/phpinfos.php")' class="btn btn-primary">
		<i class="icon-cogs bigger-140"></i>
		 <?php echo T_('Tous les paramètres PHP'); ?>
	</button>
</center>
