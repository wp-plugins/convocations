<?php
if( !class_exists( 'Equipe_Admin_New_View' ) )
{
	class Equipe_Admin_New_View
	{
		public static function render() {
			?>
			<div class="wrap">
				<h2 id="add-new-team"><?php _e( 'Add team', 'convocations' ); ?></h2>
				<?php if( isset( $_GET['message'] ) && $_GET['message'] == 2 ) { ?>
					<div id="message" class="error below-h2">
						<p><?php _e( 'Some fields are missing. Please fill in all required fields to create the team.', 'convocations' ); ?></p>
					</div>
				<?php } ?>
				<div id="ajax-response"></div>
				<div id="ajax-response"></div>
				<p><?php _e( 'Create a new team', 'convocations' ); ?>.</p>
				<form id="addteam" class="validate" novalidate="novalidate" name="addteams" action="admin-post.php" method="POST">
					<input type="hidden" value="new_equipe" name="action">
					<table class="form-table">
						<tbody>
							<tr class="form-field form-required">
								<th scope="row"><label for="nom"><?php _e( 'Name', 'convocations' ); ?> <span class="description">(<?php _e( 'required', 'convocations' ); ?>)</span></label></th>
								<td><input id="nom" type="text" aria-required="true" value="" name="nom"></td>
							</tr>
						
							<tr class="form-field">
								<th scope="row"><label for="responsable"><?php _e( 'Team manager(s)', 'convocations' ); ?></label></th>
								<td><input id="responsable" type="text" value="" name="responsable"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="telephone"><?php _e( 'Tel of the manager(s)', 'convocations' ); ?></label></th>
								<td><input id="telephone" type="text" value="" name="telephone" type="text"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="entrainement"><?php _e( 'Training', 'convocations' ); ?></label></th>
								<td><input id="entrainement" type="text" value="" name="entrainement"></td>
							</tr>
						</tbody>
					</table>
					<p class="submit">
						<input id="addteamsub" class="button button-primary" type="submit" value="<?php _e( 'Add a team', 'convocations' ); ?>" name="addteam">
					</p>
				</form>
				</div>
			<?php
		}
	}
}