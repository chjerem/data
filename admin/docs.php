<?php
if(!isset($_GET['tab'])) $_GET['tab'] = '';
?>
<div class="page-header position-relative">
	<h1><i class="icon-book"></i>  <?php echo T_('Gestion de la documentation'); ?></h1>
</div>
<div class="col-sm-12">
	<div class="tabbable">
		<ul class="nav nav-tabs" id="myTab">
			<li <?php echo $_GET['tab']!="list" ? 'class="active"' : ''; ?>><a href="./index.php?page=admin&subpage=docs&tab=add">Ajouter un document</a></li>
			<li <?php echo $_GET['tab']=="list" ? 'class="active"' : ''; ?>><a href="./index.php?page=admin&subpage=docs&tab=list">Lister les documents</a></li>
		</ul>
		<div class="tab-content">
			<div id="add" <?php echo $_GET['tab']!="list" ? 'class="active tab-pane"' : 'class="tab-pane"'; ?>>
				<form>
					<div class="form-group">
						<label for="name">Nom du document</label>
						<input type="text" name="name" id="name" class="form-control" placeholder="Entrez le nom du document">
					</div>
					<div class="form-group">
						<label for="desc">Description du document</label>
						<textarea class="form-control" id="desc" rows="3" name="desc" placeholder="Entrez la description du document"></textarea>
					</div>
					<div class="form-group">
						<label for="file">Fichier à ajouter</label>
						<input type="file" class="form-control-file" id="file" name="file">
					</div>
				</form>
			</div>
			<div id="list" <?php echo $_GET['tab']=="list" ? 'class="active tab-pane"' : 'class="tab-pane"'; ?>>
			Base de données à faire, puis à remplir, puis à afficher ici
			</div>
		</div>
	</div>
</div>