<?php
if( !class_exists( 'Joueur_Admin_Edit_View' ) ) {
	
	class Joueur_Admin_Edit_View {
		
		public static function render( $joueur, $equipes ) {
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Edit the player', 'convocations' ); ?>
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-joueur.php&action=new"><?php _e( 'Add', 'convocations' ); ?></a>
				</h2>
				<?php if( isset( $_GET['message'] ) && $_GET['message'] == 1 ) { ?>
					<div id="message" class="updated below-h2">
						<p><?php _e( 'Updated', 'convocations' ); ?></p>
					</div>
				<?php } elseif( isset( $_GET['message'] ) && $_GET['message'] == 2 ) { ?>
					<div id="message" class="error below-h2">
						<p><?php _e( 'Some fields are missing. Please fill in all required fields to update the player.', 'convocations' ); ?></p>
					</div>
				<?php } ?>
				<div id="ajax-response"></div>
				<form id="editplayer" class="validate" novalidate="novalidate" name="editplayer" action="admin-post.php" method="POST">
					<input type="hidden" value="<?php echo $joueur->get_id(); ?>" name="id">
					<input type="hidden" value="edit_joueur" name="action">
					<table class="form-table">
						<tbody>
							<tr class="form-field form-required">
								<th scope="row"><label for="nom"><?php _e( 'Lastname', 'convocations' ); ?> <span class="description">(<?php _e( 'required', 'convocations' ); ?>)</span></label></th>
								<td><input id="nom" type="text" aria-required="true" value="<?php echo $joueur->get_nom(); ?>" name="nom"></td>
							</tr>
						
							<tr class="form-field form-required">
								<th scope="row"><label for="prenom"><?php _e( 'Firstname', 'convocations' ); ?> <span class="description">(<?php _e( 'required', 'convocations' ); ?>)</span></label></th>
								<td><input id="prenom" type="text" aria-required="true" value="<?php echo $joueur->get_prenom(); ?>" name="prenom"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="poste"><?php _e( 'Position', 'convocations' ); ?></label></th>
								<td><input id="poste" type="text" value="<?php echo $joueur->get_poste(); ?>"name="poste"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="equipe"><?php _e( 'Team', 'convocations' ); ?></label></th>
								<td>
									<select id="equipe" name="equipe">
										<option value=""></option>
										<?php foreach( $equipes as $equipe ) { ?>
											<?php if( $equipe->get_nom() == $joueur->get_equipe() ) { ?>
												<option value="<?php echo $joueur->get_equipe(); ?>" selected="selected"><?php echo $joueur->get_equipe(); ?></option>
											<?php } else { ?>
												<option value="<?php echo $equipe->get_nom(); ?>"><?php echo $equipe->get_nom(); ?></option>
											<?php } ?>
										<?php } ?>
										
									</select>
								</td>
							</tr>
						</tbody>
					</table>
					<p class="submit">
						<input id="editplayersub" class="button button-primary" type="submit" value="<?php _e( 'Edit the player', 'convocations' ); ?>" name="editplayer">
					</p>
				</form>
				</div>
			<?php
		}
	}
}