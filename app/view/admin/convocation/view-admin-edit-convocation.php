<?php
if( !class_exists( 'Convocation_Admin_Edit_View' ) )
{
	class Convocation_Admin_Edit_View
	{
		public static function render( $convocation, $joueurs ) {
			if( 1 == $_GET['message'] ){
				?>
				<div class="updated">
					<p><?php _e( 'Updated', 'convocations' ); ?></p>
				</div>
				<?php
			}
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Edit convocation', 'convocations' ); ?>
				</h2>
				<form action="admin-post.php" method="POST">
					<?php foreach ($convocation as $info) { ?>
						<table>
							<tbody>
								<tr>
									<td width="300"><label for="nom"><?php _e( 'Team', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="nom" type="text" value="<?php echo $info->equipe; ?>" size="50" disabled/><span style="font-style: italic; ">&nbsp;(<?php _e( 'To change it, change the team name', 'convocations' ); ?>)</span></td>
								</tr>
							
								<tr>
									<td width="300"><label for="equipadv"><?php _e( 'Opposing team', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="equipadv" type="text" value="<?php echo $info->equipadv; ?>" size="50" /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="date"><?php _e( 'Date', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="date" id="datepicker" type="text" value="<?php echo $info->date; ?>" size="50" /><span style="font-style: italic; ">&nbsp;(<?php _e( 'Format : Year-Month-Day', 'convocations' ); ?>)</span></td>
								</tr>
								
								<tr>
									<td width="300"><label for="lieurdv"><?php _e( 'Place of appointment', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="lieurdv" type="text" value="<?php echo $info->lieurdv; ?>" size="50" /><br /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="domext"><?php _e( 'Home / Outside', 'convocations' ); ?>:</label></td>
									<td width="450">
										<select name="domext" id="domext">
											<option value=""></option>
											<?php if ($info->domext == "Domicile") { ?>
												<option value="Domicile" selected><?php _e( 'Home', 'convocations' ); ?></option>
												<option value="Extérieur"><?php _e( 'Outside', 'convocations' ); ?></option>
											<?php } elseif ($info->domext == "Extérieur") { ?>
												<option value="Domicile"><?php _e( 'Home', 'convocations' ); ?></option>
												<option value="Extérieur" selected><?php _e( 'Outside', 'convocations' ); ?></option>
											<?php } else { ?>
												<option value="Domicile"><?php _e( 'Home', 'convocations' ); ?></option>
												<option value="Extérieur"><?php _e( 'Outside', 'convocations' ); ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								
								<tr>
									<td width="300"><label for="heurerdv"><?php _e( 'Time of the appointment', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="heurerdv" type="time" value="<?php echo $info->heurerdv ?>" size="50" /><br /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="heurematch"><?php _e( 'Time of the game', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="heurematch" type="time" value="<?php echo $info->heurematch ?>" size="50" /><br /></td>
								</tr>
								
								<tr>
									<td width="750" colspan="2"><input type="submit" value="<?php _e( 'Save', 'convocations' ); ?>" class="button-primary" style="min-width: 80px;" /></td>
								</tr>
							</tbody>
						</table>
						<h3>
							<?php _e( 'Select players', 'convocations' ); ?>
						</h3>
						<table class="wp-list-table widefat fixed" cellspacing="0">
							<thead>
								<tr>
									<th class="manage-column" width="20%"><?php _e( 'Select', 'convocations' ); ?></th>
									<th class="manage-column" width="40%"><?php _e( 'Player', 'convocations' ); ?></th>
									<th class="manage-column" width="40%"><?php _e( 'Team', 'convocations' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($joueurs as $joueur) { ?>
									<tr>
									<?php if ($joueur->numconvocation == $_GET['id']) { ?>
										<td><input name="selectionnes[]" type="checkbox"  value="<?php echo $joueur->id; ?>" checked="checked" /></td>
									<?php } else { ?>
										<td><input name="selectionnes[]" type="checkbox"  value="<?php echo $joueur->id; ?>" /></td>
									<?php } ?>
										<td><?php echo $joueur->nom ?> <?php echo $joueur->prenom; ?></td>
										<td><?php echo $joueur->equipe ?></td>
									</tr>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<th class="manage-column" width="20%"><?php _e( 'Select', 'convocations' ); ?></th>
									<th class="manage-column" width="40%"><?php _e( 'Player', 'convocations' ); ?></th>
									<th class="manage-column" width="40%"><?php _e( 'Team', 'convocations' ); ?></th>
								</tr>
							</tfoot>
						</table>
						<br />
						<input type="submit" value="<?php _e( 'Save', 'convocations' ); ?>" class="button-primary" style="min-width: 80px;" />
						<input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
						<input name="action" type="hidden" value="edit_convocation" />
					<?php } ?>
					</form>
				</div>
			<?php
		}
	}
}