<?php
if( !class_exists( 'Equipe_Admin_Edit_View' ) )
{
	class Equipe_Admin_Edit_View
	{
		public static function render( $equipe ) {
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
					<?php _e( 'Edit team', 'convocations' ); ?>
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-equipe.php&action=new"><?php _e( 'Add', 'convocations' ); ?></a>
				</h2>
				<form action="admin-post.php" method="POST">
					<?php foreach( $equipe as $info ) { ?>
						<table>
							<tbody>
								<tr>
									<td width="300"><label for="nom"><?php _e( 'Name', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="nom" type="text" value="<?php echo $info->nom; ?>" size="50" /></td>
								</tr>
							
								<tr>
									<td width="300"><label for="responsable"><?php _e( 'Team manager(s)', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="responsable" type="text" value="<?php echo $info->responsable; ?>" size="50" /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="telephone"><?php _e( 'Tel of the manager(s)', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="telephone" type="text" value="<?php echo $info->telephone; ?>" size="50" /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="entrainement"><?php _e( 'Training', 'convocations' ); ?>:</label></td>
									<td width="450"><input name="entrainement" type="text" value="<?php echo $info->entrainement; ?>" size="50" /><br /></td>
								</tr>
								
								<tr>
									<td width="750" colspan="2"><input type="submit" value="Modifier" class="button-primary" style="min-width: 80px;" /></td>
								</tr>
							</tbody>
						</table>
						<input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
						<input name="old_name" type="hidden" value="<?php echo $info->nom ?>" />
						<input name="action" type="hidden" value="edit_equipe" />
					<?php } ?>
				</form>
				</div>
			<?php
		}
	}
}