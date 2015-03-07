<?php
if( !class_exists( 'Equipe_Admin_New_View' ) )
{
	class Equipe_Admin_New_View
	{
		public static function render() {
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Add team', 'convocations' ); ?>
				</h2>
				<form action="admin-post.php" method="POST">
					<input name="action" type="hidden" value="new_equipe" />
					<table>
						<tbody>
							<tr>
								<td width="40%"><label for="nom"><?php _e( 'Name', 'convocations' ); ?>:</label></td>
								<td width="60%"><input name="nom" type="text" value="" size="50" /></td>
							</tr>
						
							<tr>
								<td width="40%"><label for="responsable"><?php _e( 'Team manager(s)', 'convocations' ); ?>:</label></td>
								<td width="60%"><input name="responsable" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="40%"><label for="telephone"><?php _e( 'Tel of the manager(s)', 'convocations' ); ?>:</label></td>
								<td width="60%"><input name="telephone" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="40%"><label for="entrainement"><?php _e( 'Training', 'convocations' ); ?>:</label></td>
								<td width="60%"><input name="entrainement" type="text" value="" size="50" /><br /></td>
							</tr>
							
							<tr>
								<td width="100%" colspan="2"><input type="submit" value="<?php _e( 'Add', 'convocations' ); ?>" class="button-primary" style="min-width: 80px;" /></td>
							</tr>
						</tbody>
					</table>
				</form>
				</div>
			<?php
		}
	}
}