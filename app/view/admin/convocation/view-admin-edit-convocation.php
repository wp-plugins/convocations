<?php
if( !class_exists( 'Convocation_Admin_Edit_View' ) ) {
	
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
			elseif( 2 == $_GET['message'] ) {
				?>
				<div class="error">
					<p><?php _e( 'Some fields are missing. Please fill in all fields to update the convocation.', 'convocations' ); ?></p>
				</div>
				<?php
			}
			?>
			<div class="wrap">
				<h2><?php _e( 'Edit convocation', 'convocations' ); ?></h2>
				<div id="ajax-response"></div>
				<form id="editconvocation" class="validate" novalidate="novalidate" name="editconvocation" action="admin-post.php" method="POST">
					<input type="hidden" value="<?php echo $convocation->get_id(); ?>" name="id">
					<input type="hidden" value="edit_convocation" name="action">
					<table class="form-table">
						<tbody>
							<tr class="form-field">
								<th scope="row"><label for="nom"><?php _e( 'Team', 'convocations' ); ?>:</label></td>
								<td><input id="nom" type="text" value="<?php echo $convocation->get_equipe(); ?>" name="nom" disabled="disabled"><span class="description">(<?php _e( 'To change it, change the team name', 'convocations' ); ?>)</span></td>
							</tr>
						
							<tr class="form-field">
								<th scope="row"><label for="equipadv"><?php _e( 'Opposing team', 'convocations' ); ?>:</label></td>
								<td><input id="equipeadv" type="text" name="equipadv" type="text" value="<?php echo $convocation->get_equipadv(); ?>" size="50" /></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="date"><?php _e( 'Date', 'convocations' ); ?>:</label></td>
								<td><input id="datepicker" type="text" value="<?php echo $convocation->get_date(); ?>" name="date"><span class="description">(<?php _e( 'Format : Year-Month-Day', 'convocations' ); ?>)</span></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="lieurdv"><?php _e( 'Place of appointment', 'convocations' ); ?>:</label></td>
								<td><input id="lieurdv" type="text" value="<?php echo $convocation->get_lieurdv(); ?>" name="lieurdv"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="domext"><?php _e( 'Home / Outside', 'convocations' ); ?>:</label></td>
								<td>
									<select id="domext" name="domext">
										<option value=""></option>
										<?php if ($convocation->get_domext() == "Domicile") { ?>
											<option value="Domicile" selected="selected"><?php _e( 'Home', 'convocations' ); ?></option>
											<option value="Extérieur"><?php _e( 'Outside', 'convocations' ); ?></option>
										<?php } elseif ($convocation->get_domext() == "Extérieur") { ?>
											<option value="Domicile"><?php _e( 'Home', 'convocations' ); ?></option>
											<option value="Extérieur" selected="selected""><?php _e( 'Outside', 'convocations' ); ?></option>
										<?php } else { ?>
											<option value="Domicile"><?php _e( 'Home', 'convocations' ); ?></option>
											<option value="Extérieur"><?php _e( 'Outside', 'convocations' ); ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="heurerdv"><?php _e( 'Time of the appointment', 'convocations' ); ?>:</label></td>
								<td><input id="heurerdv" type="time" value="<?php echo $convocation->get_heurerdv(); ?>" name="heurerdv"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="heurematch"><?php _e( 'Time of the game', 'convocations' ); ?>:</label></td>
								<td><input id="heuremacth" type="time" value="<?php echo $convocation->get_heurematch(); ?>" name="heurematch"></td>
							</tr>
						</tbody>
					</table>
					<h3>
						<?php _e( 'Select players', 'convocations' ); ?>
					</h3>
					<table class="wp-list-table widefat fixed" cellspacing="0">
						<thead>
							<tr class="form-field">
								<th class="manage-column" width="20%"><?php _e( 'Select', 'convocations' ); ?></th>
								<th class="manage-column" width="40%"><?php _e( 'Player', 'convocations' ); ?></th>
								<th class="manage-column" width="40%"><?php _e( 'Team', 'convocations' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($joueurs as $joueur) { ?>
								<tr>
								<?php if ($joueur->get_numconvocation() == $_GET['id']) { ?>
									<td><input name="selectionnes[]" type="checkbox"  value="<?php echo $joueur->get_id(); ?>" checked="checked" /></td>
								<?php } else { ?>
									<td><input name="selectionnes[]" type="checkbox"  value="<?php echo $joueur->get_id(); ?>" /></td>
								<?php } ?>
									<td><?php echo $joueur->get_nom(); ?> <?php echo $joueur->get_prenom(); ?></td>
									<td><?php echo $joueur->get_equipe(); ?></td>
								</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr class="form-field">
								<th class="manage-column" width="20%"><?php _e( 'Select', 'convocations' ); ?></th>
								<th class="manage-column" width="40%"><?php _e( 'Player', 'convocations' ); ?></th>
								<th class="manage-column" width="40%"><?php _e( 'Team', 'convocations' ); ?></th>
							</tr>
						</tfoot>
					</table>
					
					<input type="submit" value="<?php _e( 'Save', 'convocations' ); ?>" class="button-primary" style="min-width: 80px;" />
					
				</form>
			</div>
			<?php
		}
	}
}