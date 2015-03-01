<?php
	function admin_equipes_panel(){
		global $inst_convocations;
		
		// If we try to save
		if( isset( $_GET['save'] ) && $_GET['save'] == 'true' ){
			// We initialize the variables
			$nom = '';
			$responsable = '';
			$telephone = '';
			$entrainement = '';
			
			if( isset( $_POST['nom'] ) ){ $nom = $_POST['nom']; }
			if( isset( $_POST['responsable'] ) ){ $responsable = $_POST['responsable']; }
			if( isset( $_POST['telephone'] ) ){ $telephone = $_POST['telephone']; }
			if( isset( $_POST['entrainement'] ) ){ $entrainement = $_POST['entrainement']; }
			
			// If we try to add a team
			if( ( isset( $_GET['action'] ) && $_GET['action'] == 'add' ) ){
				// We try to insert in database
				$insert = $inst_convocations->insert_equipe( $nom, $responsable, $telephone, $entrainement);
				
				// If the insertion has succeeded
				if( $insert ){
					// We add a convocation link to this team
					$inst_convocations->insert_convocation( $nom );
					
					// We retrieve all team and print the listing
					$equipes = $inst_convocations->get_all_equipes();
					affiche_admin_equipes( $equipes );
					
					// Then, we print a successful message
					echo '
						<script type="text/javascript">
							document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
							document.getElementById("alert").innerHTML = "L\'équipe a bien été ajoutée";
						</script>
						';
				} 
				else{
					// Else, we print the adding panel and an error message 
					affiche_add_equipe();
					echo '
						<script type="text/javascript">
							document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
							document.getElementById("alert").innerHTML = "Ce nom d\'équipe est déjà utilisé";
						</script>
						';
				}
			}
			// If we try to edit a team
			elseif( ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) ){
				// We initialize the variables
				$id = '';
				if( isset( $_POST['id'] ) ){ $id = $_POST['id']; }
				$old_name = $_POST['old_name'];
				
				// We update the team's database with the new informations
				$inst_convocations->update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement );
				
				// We retrieve all team and print the listing
				$equipes = $inst_convocations->get_all_equipes();
				affiche_admin_equipes( $equipes );
				
				// Then, we print a successful message
				echo '
					<script type="text/javascript">
						document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
						document.getElementById("alert").innerHTML = "L\'équipe a bien été modifé";
					</script>
					';
			}
			
			
		}
		// If we want to type a new team
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'add' ){
			affiche_add_equipe();
		}
		// If we want to edit an existing team
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ){
			$equipe = $inst_convocations->get_equipe( $_GET['id'] );
			affiche_edit_equipe( $equipe );
		}
		// If we want to delete a team
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'del' ){
			$id = $_GET['id'];
			$equipe = $_GET['equipe'];
			$inst_convocations->delete_equipe( $id );
			$inst_convocations->delete_convocation( $equipe );
			
			$equipes = $inst_convocations->get_all_equipes();
			affiche_admin_equipes( $equipes );
			echo '
				<script type="text/javascript">
					document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
					document.getElementById("alert").innerHTML = "L\'équipe a bien été supprimée";
				</script>
				';
		}
		else{
			$equipes = $inst_convocations->get_all_equipes();
			affiche_admin_equipes( $equipes );
		}
	}
	
	function affiche_admin_equipes( $equipes ){
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
					foreach( $equipes as $equipe ){
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
	
	function affiche_add_equipe(){
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
	
	function affiche_edit_equipe( $equipe ){
		$html = '';
		
		$html .= '<div class="wrap">';
		$html .= '
				<h2>
					Modifier l\'équipe
					<a class="add-new-h2" href="admin.php?page=admin-equipes&action=add">Ajouter</a>
				</h2>
				<form action="admin.php?page=admin-equipes&action=edit&save=true" method="POST">';
					foreach( $equipe as $info ){
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