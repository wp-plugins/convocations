<?php
	function adminConvocations()
	{
		global $inst_convocations; // Instance de la classe Convocation
		
		// Enregistrement des données de convocation
		if( isset( $_GET['save'] ) && $_GET['save']== 'true' )
		{
			// Dans le cas d'une modification
			if( (isset( $_GET['action'] ) && $_GET['action']== 'edit' ) )
			{
				$id 		= $_POST['id'];
				$equipadv 	= $_POST['equipadv'];
				$date 		= $_POST['date'];
				$domext 	= $_POST['domext'];
				$lieurdv 	= $_POST['lieurdv'];
				$heurerdv 	= $_POST['heurerdv'];
				$heurematch = $_POST['heurematch'];
				$arrJoueurs = $_POST['selectionnes'];
				
				$inst_convocations->updateConvocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs );
				
				$convocations = $inst_convocations->getAllConvocations();
				afficheAdminConvocations( $convocations );
				echo '
					<script type="text/javascript">
						document.getElementById("alert").style.cssText="background-color: #FFFFE0; border: 1px solid #E6DB55; margin: 10px 0; padding: 5px; font-size: 12px; border-radius: 3px 3px 3px 3px;";
						document.getElementById("alert").innerHTML = "La convocation a bien été modifée";
					</script>';
			}
		}
		// Modification des données de convocation
		elseif( isset( $_GET['action'] ) && $_GET['action'] == 'edit' )
		{
			$convocation = $inst_convocations->getConvocation( $_GET['id'] );
			$joueurs = $inst_convocations->getAllJoueurs();
			afficheEditConvocation( $convocation, $joueurs );
		}
		// Affichage du listing des convocations
		else
		{
			$convocations = $inst_convocations->getAllConvocations();
			afficheAdminConvocations( $convocations );
		}
	}
	
	/**
	 * Fonction qui affiche le listing des convocations dans le menu "Convocations"
	 * @param convocations Tableau contenant toutes les convocations et leurs données
	 */
	function afficheAdminConvocations( $convocations )
	{
		$html = '';
		
		$html .= '
		<div class="wrap">
			<h2>
				Gestion des convocations
			</h2>
			<div id="alert"></div>
			<table class="wp-list-table widefat fixed" cellspacing="0">
				<thead>
					<tr>
						<th class="manage-column" width="20%">Equipe</th>
						<th class="manage-column" width="20%">Equipe adverse</th>
						<th class="manage-column" width="10%">Date</th>
						<th class="manage-column" width="15%">Type</th>
						<th class="manage-column" width="15%">Lieu du RDV</th>
						<th class="manage-column" width="10%">Heure du RDV</th>
						<th class="manage-column" width="10%">Heure du match</th>
					</tr>
				</thead>
				<tbody>';
					foreach ( $convocations as $convocation )
					{
						$html .= '
						<tr>
							<td><strong><a title="Modifier »" href="admin.php?page=convocations/convocations.php&id='. $convocation->id .'&action=edit">'. $convocation->equipe .'</a></strong></td>
							<td>'. $convocation->equipadv .'</td>
							<td>'. $convocation->date .'</td>
							<td>'. $convocation->domext .'</td>
							<td>'. $convocation->lieurdv .'</td>
							<td>'. $convocation->heurerdv .'</td>
							<td>'. $convocation->heurematch .'</td>
						</tr>';
					}

					$html .= '
				</tbody>
				<tfoot>
					<tr>
						<th class="manage-column" width="20%">Equipe</th>
						<th class="manage-column" width="20%">Equipe adverse</th>
						<th class="manage-column" width="10%">Date</th>
						<th class="manage-column" width="15%">Type</th>
						<th class="manage-column" width="15%">Lieu du RDV</th>
						<th class="manage-column" width="10%">Heure du RDV</th>
						<th class="manage-column" width="10%">Heure du match</th>
					</tr>
				</tfoot>
			</table>
		</div>';
		
		echo $html;
	}
	
	/**
	 * Fonction qui affiche le panneau d'édition des convocations
	 * @param convocation Tableau contenant les données de la convocation à modifier
	 * @param joueurs Tableau comprenant tous les joueurs enregistrés en base
	 */
	function afficheEditConvocation( $convocation, $joueurs )
	{
		$html = '';
		
		$html .= '
		<div class="wrap">
			<h2>
				Modifier la convocation
			</h2>
			<form action="admin.php?page=convocations/convocations.php&action=edit&save=true" method="POST">';
				foreach ($convocation as $info)
				{
					$html .= '
					<table>
						<tbody>
							<tr>
								<td width="300"><label for="nom">Nom de l\'équipe : </label></td>
								<td width="450"><input name="nom" type="text" value="'. $info->equipe .'" size="50" disabled/><span style="font-style: italic; ">&nbsp;(Ne peut être modifié)</span></td>
							</tr>
						
							<tr>
								<td width="300"><label for="equipadv">Nom de l\'équipe adverse : </label></td>
								<td width="450"><input name="equipadv" type="text" value="'. $info->equipadv .'" size="50" /></td>
							</tr>
							
							<tr>
								<td width="300"><label for="date">Date : </label></td>
								<td width="450"><input name="date" id="datepicker" type="text" value="'. $info->date .'" size="50" /><span style="font-style: italic; ">&nbsp;(Format : Année-Mois-Jour)</span></td>
							</tr>
							
							<tr>
								<td width="300"><label for="lieurdv">Lieu du RDV : </label></td>
								<td width="450"><input name="lieurdv" type="text" value="'. $info->lieurdv .'" size="50" /><br /></td>
							</tr>
							
							<tr>
								<td width="300"><label for="domext">Domicile / Extérieur : </label></td>
								<td width="450">
									<select name="domext" id="domext">
										<option value=""></option>';
										if ($info->domext == "Domicile")
										{
											$html .= '<option value="Domicile" selected>Domicile</option>';
											$html .= '<option value="Extérieur">Extérieur</option>';
										}
										elseif ($info->domext == "Extérieur")
										{
											$html .= '<option value="Domicile">Domicile</option>';
											$html .= '<option value="Extérieur" selected>Extérieur</option>';
										}
										else
										{
											$html .= '<option value="Domicile">Domicile</option>';
											$html .= '<option value="Extérieur">Extérieur</option>';
										}
										$html .= '
									</select>
								</td>
							</tr>
							
							<tr>
								<td width="300"><label for="heurerdv">Heure du RDV : </label></td>
								<td width="450"><input name="heurerdv" type="time" value="'. $info->heurerdv .'" size="50" /><br /></td>
							</tr>
							
							<tr>
								<td width="300"><label for="heurematch">Heure du match : </label></td>
								<td width="450"><input name="heurematch" type="time" value="'. $info->heurematch .'" size="50" /><br /></td>
							</tr>
							
							<tr>
								<td width="750" colspan="2"><input type="submit" value="Modifier" class="button-primary" style="min-width: 80px;" /></td>
							</tr>
						</tbody>
					</table>
					<h3>
						Sélection des joueurs à associer à la convocation
					</h3>
					<table class="wp-list-table widefat fixed" cellspacing="0">
						<thead>
							<tr>
								<th class="manage-column" width="20%">Sélection</th>
								<th class="manage-column" width="40%">Joueur</th>
								<th class="manage-column" width="40%">Equipe</th>
							</tr>
						</thead>
						<tbody>';
							foreach ($joueurs as $joueur)
							{
								if ($joueur->numconvocation == $_GET['id'])
								{
									$html .= '
									<tr>
										<td><input name="selectionnes[]" type="checkbox"  value="'. $joueur->id . '" checked="checked" /></td>
										<td>'. $joueur->nom .' '. $joueur->prenom .'</td>
										<td>'. $joueur->equipe .'</td>
									</tr>';
								} 
								else
								{
									$html .= '
									<tr>
										<td><input name="selectionnes[]" type="checkbox"  value="'. $joueur->id . '" /></td>
										<td>'. $joueur->nom .' '. $joueur->prenom .'</td>
										<td>'. $joueur->equipe .'</td>
									</tr>';
								}
							}
							$html .= '
						</tbody>
						<tfoot>
							<tr>
								<th class="manage-column" width="20%">Sélection</th>
								<th class="manage-column" width="80%">Joueur</th>
								<th class="manage-column" width="40%">Equipe</th>
							</tr>
						</tfoot>
					</table>
					<br />
					<input type="submit" value="Modifier" class="button-primary" style="min-width: 80px;" />
					<input name="id" type="hidden" value="'. $_GET['id'] .'" />';
				}
				$html .= '
				</form>
				</div>';
		
		echo $html;
	}
?>