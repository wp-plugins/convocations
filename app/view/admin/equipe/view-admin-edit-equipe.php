<?php
if( !class_exists( 'Equipe_Admin_Edit_View' ) )
{
	class Equipe_Admin_Edit_View
	{
		public static function render( $equipe ) {
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Edit team', 'convocations' ); ?>
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-equipe.php&action=new"><?php _e( 'Add', 'convocations' ); ?></a>
				</h2>
				<?php if( isset( $_GET['message'] ) && $_GET['message'] == 1 ) { ?>
					<div id="message" class="updated below-h2">
						<p><?php _e( 'Updated', 'convocations' ); ?></p>
					</div>
				<?php } elseif( isset( $_GET['message'] ) && $_GET['message'] == 2 ) { ?>
					<div id="message" class="error below-h2">
						<p><?php _e( 'Some fields are missing. Please fill in all required fields to update the team.', 'convocations' ); ?></p>
					</div>
				<?php } ?>
				<div id="ajax-response"></div>
				<form id="editteam" class="validate" novalidate="novalidate" name="editteam" action="admin-post.php" method="POST">
					<input type="hidden" value="<?php echo $equipe->get_id(); ?>" name="id">
					<input type="hidden" value="edit_equipe" name="action">
					<table class="form-table">
						<tbody>
							<tr class="form-field form-required">
								<th scope="row"><label for="nom"><?php _e( 'Name', 'convocations' ); ?> <span class="description">(<?php _e( 'required', 'convocations' ); ?>)</span></label></td>
								<td><input id="nom" type="text" aria-required="true" value="<?php echo $equipe->get_nom(); ?>" name="nom"></td>
							</tr>
						
							<tr class="form-field">
								<th scope="row"><label for="responsable"><?php _e( 'Team manager(s)', 'convocations' ); ?></label></td>
								<td><input id="responsable" type="text" value="<?php echo $equipe->get_responsable(); ?>" name="responsable"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="telephone"><?php _e( 'Tel of the manager(s)', 'convocations' ); ?></label></td>
								<td><input id="telephone" type="text" value="<?php echo $equipe->get_telephone(); ?>" name="telephone"></td>
							</tr>
							
							<tr class="form-field">
								<th scope="row"><label for="entrainement"><?php _e( 'Training', 'convocations' ); ?></label></td>
								<td><input id="entrainement" type="text" value="<?php echo $equipe->get_entrainement(); ?>" name="entrainement"></td>
							</tr>
						</tbody>
					</table>
					<p class="submit">
						<input id="editteamsub" class="button button-primary" type="submit" value="<?php _e( 'Edit the team', 'convocations' ); ?>" name="editteam">
					</p>
				</form>
				</div>
			<?php
		}
	}
}