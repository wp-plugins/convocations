<?php
	/**
	* Fonction gérant l'affichage des différents panels de l'administration des équipes
	* @global inst_convocations
	*/
	function adminEquipes() {
		global $inst_convocations;
		
		// Si on passe en mode "Sauvegarde"
		if( isset( $_GET['save'] ) && $_GET['save'] == 'true' ) {
			$nom = '';
			$responsable = '';
			$telephone = '';
			$entrainement = '';
			
			if( isset( $_POST['nom'] ) ){ $nom = $_POST['nom']; }
			if( isset( $_POST['responsable'] ) ){ $responsable = $_POST['responsable']; }
			if( isset( $_POST['telephone'] ) ){ $telephone = $_POST['telephone']; }
			if( isset( $_POST['entrainement'] ) ){ $entrainement = $_POST['entrainement']; }
			
			// Si on ajoute une nouvelle équipe
			if( ( isset( $_GET['action'] ) && $_GET['action'] == 'add' ) ){
				$insert = $inst_convocations->insertEquipe($nom, $responsable, $telephone, $entrainement);
				
				// Si l'insertion des données à réussi, on retourne au listing des équipes et on affiche un message de succès
				if( $insert ) {
					$equipes = $inst_convocations->getAllEquipes();
					afficheAdminEquipes( $equipes );
					echo '
						<script type="text/javascript">
							document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
							document.getElementById("alert").innerHTML = "L\'équipe a bien été ajoutée";
						</script>
						';
				} 
				// Sinon on affiche une erreur
				else {
					afficheAddEquipe();
					echo '
						<script type="text/javascript">
							document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
							document.getElementById("alert").innerHTML = "Ce nom d\'équipe est déjà utilisé";
						</script>
						';
				}
			}
			
			// Si on édite une équipe existante
			if( ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) ){
				$id = '';
				if( isset( $_POST['id'] ) ){ $id = $_POST['id']; }
				$old_name = $_POST['old_name'];
				
				$inst_convocations->updateEquipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement );
				
				$equipes = $inst_convocations->getAllEquipes();
				afficheAdminEquipes( $equipes );
				echo '
					<script type="text/javascript">
						document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
						document.getElementById("alert").innerHTML = "L\'équipe a bien été modifé";
					</script>
					';
			}
			
			
		}
		// Si on veut procéder à l'ajout d'une équipe
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'add' ) {
			afficheAddEquipe();
		}
		// Si on veut procéder à la modification d'une équipe
		elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' )  {
			$equipe = $inst_convocations->getEquipe( $_GET['id'] );
			afficheEditEquipe( $equipe );
		}
		// Si on veut procéder à la suppression d'une équipe
		elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'del' ) {
			$id = $_GET['id'];
			$equipe = $_GET['equipe'];
			$inst_convocations->deleteEquipe( $id );
			$inst_convocations->deleteConvocation( $equipe );
			
			$equipes = $inst_convocations->getAllEquipes();
			afficheAdminEquipes( $equipes );
			echo '
				<script type="text/javascript">
					document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
					document.getElementById("alert").innerHTML = "L\'équipe a bien été supprimée";
				</script>
				';
		}
		else {
			$equipes = $inst_convocations->getAllEquipes();
			afficheAdminEquipes( $equipes );
		}
	}
	
	/*
	* Fonction d'affichage du listing des équipes
	*/
	function afficheAdminEquipes( $equipes ) {
		$html = '';
		
		$html .= '<div class="wrap">';
		$html .= '
				<h2>
					Gestion des équipes
					<a class="add-new-h2" href="admin.php?page=admin-equipes&action=add">Ajouter</a>
				</h2>
				<div id="alert"></div>
				<table class="wp-list-table widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column" width="25%">Nom</th>
							<th class="manage-column" width="25%">Responsable</th>
							<th class="manage-column" width="20%">Téléphone</th>
							<th class="manage-column" width="20%">Entraînement</th>
							<th class="manage-column" width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
					';
					foreach ( $equipes as $equipe ) {
						$html .= '
								<tr>
									<td><strong><a title="Modifier »" href="admin.php?page=admin-equipes&id='. $equipe->id .'&action=edit">'. $equipe->nom .'</a></strong></td>
									<td>'. $equipe->responsable .'</td>
									<td>'. $equipe->telephone .'</td>
									<td>'. $equipe->entrainement .'</td>
									<td><a href="admin.php?page=admin-equipes&id='. $equipe->id .'&equipe='. $equipe->nom .'&action=del"><img src ="'. CONVOCATIONS_URL .'/images/remove.png" alt="Effacer l\'équipe" /></a></td>
								</tr>';
					}
		
					$html .= '
							</tbody>
							<tfoot>
								<tr>
									<th class="manage-column" width="25%">Nom</th>
									<th class="manage-column" width="25%">Responsable</th>
									<th class="manage-column" width="20%">Téléphone</th>
									<th class="manage-column" width="20%">Entraînement</th>
									<th class="manage-column" width="10%">Actions</th>
								</tr>
							</tfoot>
						</table>
					</div>';
		
		echo $html;
	}
	
	/*
	* Fonction d'affichage de l'ajout d'une équipe
	*/
	function afficheAddEquipe () {
		$html = '';
		
		$html .= '<div class="wrap">';
		$html .= '
				<h2>
					Ajouter une équipe
				</h2>
				<div id="alert"></div>
				<form action="admin.php?page=admin-equipes&action=add&save=true" method="POST">
					<table>
						<tbody>
							<tr>
								<td width="300"><label for="nom">Nom de l\'équipe : </label></td>
								<td width="300"><input name="nom" type="text" value="" size="50" /></td>
							</tr>
						
							<tr>
								<td width="300"><label for="responsable">Nom du(des) responsable(s) de l\'équipe : </label></td>
								<td width="300"><input name="responsable" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="300"><label for="telephone">Numéro(s) du(des) responsable(s) de l\'équipe : </label></td>
								<td width="300"><input name="telephone" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="300"><label for="entrainement">Entrainement : </label></td>
								<td width="300"><input name="entrainement" type="text" value="" size="50" /><br /></td>
							</tr>
							
							<tr>
								<td width="600" colspan="2"><input type="submit" value="Ajouter" class="button-primary" style="min-width: 80px;" /></td>
							</tr>
						</tbody>
					</table>
				</form>
				</div>';
		
		echo $html;
	}
	
	/*
	* Fonction d'affichage de l'édition d'une équipe
	*/
	function afficheEditEquipe ($equipe) {
		$html = '';
		
		$html .= '<div class="wrap">';
		$html .= '
				<h2>
					Modifier l\'équipe
					<a class="add-new-h2" href="admin.php?page=admin-equipes&action=add">Ajouter</a>
				</h2>
				<form action="admin.php?page=admin-equipes&action=edit&save=true" method="POST">';
					foreach ($equipe as $info) {
						$html .= '
								<table>
									<tbody>
										<tr>
											<td width="300"><label for="nom">Nom de l\'équipe : </label></td>
											<td width="450"><input name="nom" type="text" value="'. $info->nom .'" size="50" /></td>
										</tr>
									
										<tr>
											<td width="300"><label for="responsable">Nom du(des) responsable(s) de l\'équipe : </label></td>
											<td width="450"><input name="responsable" type="text" value="'. $info->responsable .'" size="50" /></td>
										</tr>
										
										<tr>
											<td width="300"><label for="telephone">Numéro(s) du(des) responsable(s) de l\'équipe : </label></td>
											<td width="450"><input name="telephone" type="text" value="'. $info->telephone .'" size="50" /></td>
										</tr>
										
										<tr>
											<td width="300"><label for="entrainement">Entrainement : </label></td>
											<td width="450"><input name="entrainement" type="text" value="'. $info->entrainement .'" size="50" /><br /></td>
										</tr>
										
										<tr>
											<td width="750" colspan="2"><input type="submit" value="Modifier" class="button-primary" style="min-width: 80px;" /></td>
										</tr>
									</tbody>
								</table>
								<input name="id" type="hidden" value="'. $_GET['id'] .'" />
								<input name="old_name" type="hidden" value="'. $info->nom .'" />
								';
					}
					$html .= '
				</form>
				</div>';
		
		echo $html;
	}
?>