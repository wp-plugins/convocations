<?php
if( !class_exists( 'Joueur_Admin_New_View' ) ) {
	
	class Joueur_Admin_New_View {
		
		public static function render( $equipes ) {
			?>
			<div class="wrap">
				<h2 id="add-new-player"><?php _e( 'Add a player', 'convocations' ); ?></h2>
				<?php if( isset( $_GET['message'] ) && $_GET['message'] == 2 ) { ?>
					<div id="message" class="error below-h2">
						<p><?php _e( 'Some fields are missing. Please fill in all required fields to create the player.', 'convocations' ); ?></p>
					</div>
				<?php } ?>
				<div id="ajax-response"></div>
				<p><?php _e( 'Create a new player', 'convocations' ); ?>.</p>
				<form id="addplayer" class="validate" novalidate="novalidate" name="addplayer" action="admin-post.php" method="POST">
					<input type="hidden" value="new_joueur" name="action">
					<table class="form-table">
						<tbody>
							<tr class="form-field form-required">
								<th scope="row"><label for="nom"><?php _e( 'Name', 'convocations' ); ?> <span class="description">(<?php _e( 'required', 'convocations' ); ?>)</span></label></th>
								<td><input id="nom" type="text" aria-required="true" value="" name="nom"></td>
							</tr>
						
							<tr class="form-field form-required">
								<th scope="row"><label for="prenom"><?php _e( 'Firstname', 'convocations' ); ?> <span class="description">(<?php _e( 'required', 'convocations' ); ?>)</span></label></th>
								<td><input id="prenom" type="text" aria-required="true" value="" name="prenom"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="poste"><?php _e( 'Position', 'convocations' ); ?>:</label></th>
								<td><input id="poste" type="text" value="" name="poste"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="equipe"><?php _e( 'Team', 'convocations' ); ?>:</label></th>
								<td>
									<select id="equipe" name="equipe">
										<option value=""></option>
										<?php foreach( $equipes as $equipe ) { ?>
											<option value="<?php echo $equipe->get_nom(); ?>"><?php echo $equipe->get_nom(); ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
					<p class="submit">
						<input id="addplayersub" class="button button-primary" type="submit" value="<?php _e( 'Add a player', 'convocations' ); ?>" name="addplayer">
					</p>
				</form>
				</div>
			<?php
		}
	}
}