<?php
	function admin_joueurs_panel(){
		global $inst_convocations;
		
		if( isset( $_GET['save'] ) && $_GET['save'] == 'true' ){
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$poste = $_POST['poste'];
			$equipe = $_POST['equipe'];
			
			if( ( isset( $_GET['action'] ) && $_GET['action'] == 'add' ) ){
				$insert = $inst_convocations->insert_joueur( $nom, $prenom, $poste, $equipe );
				
				if( $insert ) {
					$equipes = $inst_convocations->get_all_equipes();
					$joueurs = $inst_convocations->get_all_joueurs();
					affiche_admin_joueurs( $equipes, $joueurs );
					echo '
						<script type="text/javascript">
							document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
							document.getElementById("alert").innerHTML = "Le joueur a bien été ajouté";
						</script>
						';
				}
				else{
					$joueurs = $inst_convocations->get_all_joueurs();
					affiche_add_joueur( $joueurs );
					echo '
						<script type="text/javascript">
							document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
							document.getElementById("alert").innerHTML = "Ce joueur existe déjà";
						</script>
						';
				}
			}
			elseif( ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) ){
				$id = $_POST['id'];
				
				$inst_convocations->update_joueur( $id, $nom, $prenom, $poste, $equipe );
				
				$equipes = $inst_convocations->get_all_equipes();
				$joueurs = $inst_convocations->get_all_joueurs();
				affiche_admin_joueurs( $equipes, $joueurs );
				echo '
					<script type="text/javascript">
						document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
						document.getElementById("alert").innerHTML = "Le joueur a bien été modifé";
					</script>
					';
			}
		}
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'add' ){
			$equipes = $inst_convocations->get_all_equipes();
			affiche_add_joueur( $equipes );
		}
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ){
			$equipes = $inst_convocations->get_all_equipes();
			$joueur = $inst_convocations->get_joueur( $_GET['id'] );
			affiche_edit_joueur( $joueur, $equipes );
		}
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'del' ){
			$id = $_GET['id'];
			$inst_convocations->delete_joueur( $id );
			
			$equipes = $inst_convocations->get_all_equipes();
			$joueurs = $inst_convocations->get_all_joueurs();
			affiche_admin_joueurs( $equipes, $joueurs );
			echo '
				<script type="text/javascript">
					document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
					document.getElementById("alert").innerHTML = "Le joueur a bien été supprimée";
				</script>
				';
		}
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'filtrer' && isset( $_GET['filtre-equipe'] ) && $_GET['filtre-equipe'] != 'toutes' ){
			$equipes = $inst_convocations->get_all_equipes();
			$joueurs = $inst_convocations->get_joueurs_by_equipe( $_GET['filtre-equipe'] );
			affiche_admin_joueurs( $equipes, $joueurs );
		}
		else{
			$equipes = $inst_convocations->get_all_equipes();
			$joueurs = $inst_convocations->get_all_joueurs();
			affiche_admin_joueurs( $equipes, $joueurs );
		}
	}
	
	function affiche_admin_joueurs( $equipes, $joueurs ){
		$html = '';
		
		$html .= '<div class="wrap">';
		$html .= '
				<h2>
					Gestion des joueurs
					<a class="add-new-h2" href="admin.php?page=admin-joueurs&action=add">Ajouter</a>
				</h2>
				<div id="alert"></div>
				<form id="joueurs-filter" method="get" action="">
					<div class="tablenav top">
						<input type="hidden" name="page" value="admin-joueurs" />
						<input type="hidden" name="action" value="filtrer" />
						<select name="filtre-equipe">
							<option value="toutes">Toutes les équipes</option>';
							foreach( $equipes as $equipe ){
								if( isset( $_GET['filtre-equipe'] ) ){
									if( $equipe->nom == $_GET['filtre-equipe'] ){
										$html .= '<option value="'. $equipe->nom .'" selected>'. $equipe->nom .'</option>';
									}
								}
								else{
									$html .= '<option value="'. $equipe->nom .'">'. $equipe->nom .'</option>';
								}
							}
							$html .= '
						</select>
						<input id="joueur-query-submit" class="button-secondary" type="submit" value="Filtrer" name="">
					</div>
				</form>
				<table class="wp-list-table widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column" width="25%">Nom</th>
							<th class="manage-column" width="25%">Prénom</th>
							<th class="manage-column" width="15%">Poste</th>
							<th class="manage-column" width="25%">Equipe</th>
							<th class="manage-column" width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>';
					foreach( $joueurs as $joueur ){
						$html .= '
							<tr>
								<td><strong><a title="Modifier »" href="admin.php?page=admin-joueurs&id='. $joueur->id .'&action=edit">'. $joueur->nom .'</a></strong></td>
								<td>'. $joueur->prenom .'</td>
								<td>'. $joueur->poste .'</td>
								<td>'. $joueur->equipe .'</td>
								<td><a href="admin.php?page=admin-joueurs&id='. $joueur->id .'&action=del" title="Effacer le joueur"><img src ="'. CONVOCATIONS_URL .'/images/remove.png" alt="Effacer le joueur" /></a></td>
							</tr>';
					}
					$html .= '
							</tbody>
							<tfoot>
								<tr>
									<th class="manage-column" width="25%">Nom</th>
									<th class="manage-column" width="25%">Prénom</th>
									<th class="manage-column" width="15%">Poste</th>
									<th class="manage-column" width="25%">Equipe</th>
									<th class="manage-column" width="10%">Actions</th>
								</tr>
							</tfoot>
							</table>
							</div>';
		echo $html;
	}
	
	function affiche_add_joueur( $equipes ){
		$html = '';
		
		$html .= '<div class="wrap">';
		$html .= '
				<h2>
					Ajouter un joueur
				</h2>
				<div id="alert"></div>
				<form action="admin.php?page=admin-joueurs&action=add&save=true" method="POST">
					<table>
						<tbody>
							<tr>
								<td width="300"><label for="nom">Nom  : </label></td>
								<td width="300"><input name="nom" type="text" value="" size="50" /></td>
							</tr>
						
							<tr>
								<td width="300"><label for="prenom">Prénom : </label></td>
								<td width="300"><input name="prenom" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="300"><label for="poste">Poste : </label></td>
								<td width="300"><input name="poste" type="text" value="" size="50" /></td>
							</tr>
							
							<td width="300"><label for="equipe">Equipe : </label></td>
							<td width="300">
								<select name="equipe" id="equipe">
									<option value=""></option>';
									foreach( $equipes as $equipe ){
										$html .= '<option value="'. $equipe->nom .'">'. $equipe->nom .'</option>';
									}
									$html .= '
								</select>
							</td>
							
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
	* Fonction d'affichage de l'édition d'un joueur
	*/
	function affiche_edit_joueur( $joueur, $equipes ){
		$html = '';
		
		$html .= '<div class="wrap">';
		$html .= '
				<h2>
					Modifier un joueur
				</h2>
				<div id="alert"></div>
				<form action="admin.php?page=admin-joueurs&action=edit&save=true" method="POST">';
					foreach( $joueur as $info ){
						$html .= '
								<table>
									<tbody>
										<tr>
											<td width="300"><label for="nom">Nom  : </label></td>
											<td width="300"><input name="nom" type="text" value="'. $info->nom .'" size="50" /></td>
										</tr>
									
										<tr>
											<td width="300"><label for="prenom">Prénom : </label></td>
											<td width="300"><input name="prenom" type="text" value="'. $info->prenom .'" size="50" /></td>
										</tr>
										
										<tr>
											<td width="300"><label for="poste">Poste : </label></td>
											<td width="300"><input name="poste" type="text" value="'. $info->poste .'" size="50" /></td>
										</tr>
										
										<td width="300"><label for="equipe">Equipe : </label></td>
										<td width="300">
											<select name="equipe" id="equipe">';
												foreach( $equipes as $equipe ){
													if( $equipe->nom == $info->equipe ){
														$html .= '<option value="'. $info->equipe .'" selected>'. $info->equipe .'</option>';
													}
													else{
													$html .= '<option value="'. $equipe->nom .'">'. $equipe->nom .'</option>';
													}
												}
												$html .= '
											</select>
										</td>
										
										<tr>
											<td width="600" colspan="2"><input type="submit" value="Modifier" class="button-primary" style="min-width: 80px;" /></td>
										</tr>
									</tbody>
								</table>
								<input name="id" type="hidden" value="'. $_GET['id'] .'" />
								';
					}
					$html .= '
				</form>
				</div>';
		
		echo $html;
	}
?>