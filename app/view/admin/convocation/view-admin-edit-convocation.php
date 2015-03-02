<?php
if( !class_exists( 'Convocation_Admin_Edit_View' ) )
{
	class Convocation_Admin_Edit_View
	{
		public static function render( $convocation, $joueurs ) {
			?>
			<div class="wrap">
				<h2>
					Modifier la convocation
				</h2>
				<form action="admin-post.php" method="POST">
					<?php foreach ($convocation as $info) { ?>
						<table>
							<tbody>
								<tr>
									<td width="300"><label for="nom">Nom de l'équipe : </label></td>
									<td width="450"><input name="nom" type="text" value="<?php echo $info->equipe ?>" size="50" disabled/><span style="font-style: italic; ">&nbsp;(Ne peut être modifié)</span></td>
								</tr>
							
								<tr>
									<td width="300"><label for="equipadv">Nom de l'équipe adverse : </label></td>
									<td width="450"><input name="equipadv" type="text" value="<?php echo $info->equipadv ?>" size="50" /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="date">Date : </label></td>
									<td width="450"><input name="date" id="datepicker" type="text" value="<?php echo $info->date ?>" size="50" /><span style="font-style: italic; ">&nbsp;(Format : Année-Mois-Jour)</span></td>
								</tr>
								
								<tr>
									<td width="300"><label for="lieurdv">Lieu du RDV : </label></td>
									<td width="450"><input name="lieurdv" type="text" value="<?php echo $info->lieurdv ?>" size="50" /><br /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="domext">Domicile / Extérieur : </label></td>
									<td width="450">
										<select name="domext" id="domext">
											<option value=""></option>
											<?php if ($info->domext == "Domicile") { ?>
												<option value="Domicile" selected>Domicile</option>
												<option value="Extérieur">Extérieur</option>
											<?php } elseif ($info->domext == "Extérieur") { ?>
												<option value="Domicile">Domicile</option>
												<option value="Extérieur" selected>Extérieur</option>
											<?php } else { ?>
												<option value="Domicile">Domicile</option>
												<option value="Extérieur">Extérieur</option>
											<?php } ?>
										</select>
									</td>
								</tr>
								
								<tr>
									<td width="300"><label for="heurerdv">Heure du RDV : </label></td>
									<td width="450"><input name="heurerdv" type="time" value="<?php echo $info->heurerdv ?>" size="50" /><br /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="heurematch">Heure du match : </label></td>
									<td width="450"><input name="heurematch" type="time" value="<?php echo $info->heurematch ?>" size="50" /><br /></td>
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
							<tbody>
								<?php foreach ($joueurs as $joueur) { ?>
									<?php if ($joueur->numconvocation == $_GET['id']) { ?>
										<tr>
											<td><input name="selectionnes[]" type="checkbox"  value="<?php echo $joueur->id ?>" checked="checked" /></td>
											<td><?php echo $joueur->nom ?> <?php echo $joueur->prenom ?></td>
											<td><?php echo $joueur->equipe ?></td>
										</tr>
									<?php } else { ?>
										<tr>
											<td><input name="selectionnes[]" type="checkbox"  value="<?php echo $joueur->id ?>" /></td>
											<td><?php echo $joueur->nom ?> <?php echo $joueur->prenom ?></td>
											<td><?php echo $joueur->equipe ?></td>
										</tr>
									<?php } ?>
								<?php } ?>
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
						<input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
						<input name="action" type="hidden" value="edit_convocation" />
					<?php } ?>
					</form>
				</div>
			<?php
		}
	}
}