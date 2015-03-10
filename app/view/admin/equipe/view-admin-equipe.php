<?php
if( !class_exists( 'Equipe_Admin_View' ) )
{
	class Equipe_Admin_View
	{
		public static function render( $equipes ) {
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Manage teams', 'convocations' ); ?>
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-equipe.php&action=new"><?php _e( 'Add', 'convocations' ); ?></a>
				</h2>
				<?php if( isset( $_GET['deleted'] ) && $_GET['deleted'] == 1 ) { ?>
					<div id="message" class="updated below-h2">
						<p><?php _e( 'The team has been deleted.', 'convocations' ) ?></p>
					</div>
				<?php } ?>
				<table class="wp-list-table widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column" width="25%"><?php _e( 'Name', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Team manager(s)', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Tel of the manager(s)', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Training', 'convocations' ); ?></th>
						</tr>
					</thead>
					<tbody id="the-list">
						<?php $i = 0; ?>
						<?php foreach( $equipes as $equipe ) { ?>
							<tr <?php if($i%2 == 0){ ?>class="alternate"<?php } ?>>
								<td>
									<strong>
										<a class="row-title" title="<?php _e( 'Edit', 'convocations' ); ?> »" href="admin.php?page=convocations/app/controller/controller-equipe.php&id=<?php echo $equipe->get_id(); ?>&action=edit"><?php echo $equipe->get_nom(); ?></a>
									</strong>
									<div class="row-actions">
										<span class="edit">
											<a title="<?php _e( 'Edit this element', 'convocations' ); ?>" href="admin.php?page=convocations/app/controller/controller-equipe.php&id=<?php echo $equipe->get_id(); ?>&action=edit"><?php _e( 'Edit', 'convocations' ); ?></a>
											|
										</span>
										<span class="delete">
											<a class="submitdelete" href="admin.php?page=convocations/app/controller/controller-equipe.php&action=delete&id=<?php echo $equipe->get_id(); ?>&equipe=<?php echo $equipe->get_nom(); ?>" onclick="return showNotice.warn();"><?php _e( 'Delete', 'convocations' ); ?></a>
										</span>
									</div>
								</td>
								<td><?php echo $equipe->get_responsable(); ?></td>
								<td><?php echo $equipe->get_telephone(); ?></td>
								<td><?php echo $equipe->get_entrainement(); ?></td>
							</tr>
							<?php $i++; ?>
						<?php }  ?>
					</tbody>
					<tfoot>
						<tr>
							<th class="manage-column" width="25%"><?php _e( 'Name', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Team manager(s)', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Tel of the manager(s)', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Training', 'convocations' ); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<?php
		}
	}
}