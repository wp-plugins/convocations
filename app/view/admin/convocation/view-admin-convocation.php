<?php
if( !class_exists( 'Convocation_Admin_View' ) )
{
	class Convocation_Admin_View
	{
		public static function render( $convocations ) {
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Manage convocations', 'convocations' ); ?>
				</h2>
				<?php if( empty( $convocations ) ) { ?>
					<div class="updated">
						<p><?php _e( 'Add a team first', 'convocations' ); ?> <a href="admin.php?page=convocations/app/controller/controller-equipe.php&action=new"><?php _e( 'here', 'convocations' ); ?></a></p>
					</div>
				<?php } ?>
				<table class="wp-list-table widefat fixed">
					<thead>
						<tr>
							<th class="manage-column" width="20%"><?php _e( 'Team', 'convocations' ); ?></th>
							<th class="manage-column" width="20%"><?php _e( 'Opposing team', 'convocations' ); ?></th>
							<th class="manage-column" width="10%"><?php _e( 'Date', 'convocations' ); ?></th>
							<th class="manage-column" width="15%"><?php _e( 'Home/Outside', 'convocations' ); ?> </th>
							<th class="manage-column" width="15%"><?php _e( 'Place', 'convocations' ); ?></th>
							<th class="manage-column" width="10%"><?php _e( 'Time', 'convocations' ); ?></th>
							<th class="manage-column" width="10%"><?php _e( 'Time of the game', 'convocations' ); ?></th>
						</tr>
					</thead>
					<tbody id="the-list">
						<?php $i = 0; ?>
						<?php foreach ( $convocations as $convocation ) { ?>
							<tr <?php if($i%2 == 0){ ?>class="alternate"<?php } ?>>
								<td class="column-title">
									<strong>
										<a class="row-title" title="<?php _e( 'Edit', 'convocations' ); ?> »" href="admin.php?page=convocations/app/controller/controller-convocation.php&id=<?php echo $convocation->get_id(); ?>&action=edit"><?php echo $convocation->get_equipe(); ?></a>
									</strong>
									<div class="row-actions">
										<span class="edit">
											<a title="<?php _e( 'Edit this element', 'convocations' ); ?>" href="admin.php?page=convocations/app/controller/controller-convocation.php&id=<?php echo $convocation->get_id(); ?>&action=edit"><?php _e( 'Edit', 'convocations' ); ?></a>
										</span>
									</div>
								</td>
								<td><?php echo $convocation->get_equipadv(); ?></td>
								<td><?php echo $convocation->get_date(); ?></td>
								<td><?php echo $convocation->get_domext(); ?></td>
								<td><?php echo $convocation->get_lieurdv(); ?></td>
								<td><?php echo $convocation->get_heurerdv(); ?></td>
								<td><?php echo $convocation->get_heurematch(); ?></td>
							</tr>
							<?php $i++; ?>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<th class="manage-column" width="20%"><?php _e( 'Team', 'convocations' ); ?></th>
							<th class="manage-column" width="20%"><?php _e( 'Opposing team', 'convocations' ); ?></th>
							<th class="manage-column" width="10%"><?php _e( 'Date', 'convocations' ); ?></th>
							<th class="manage-column" width="15%"><?php _e( 'Home/Outside', 'convocations' ); ?> </th>
							<th class="manage-column" width="15%"><?php _e( 'Place', 'convocations' ); ?></th>
							<th class="manage-column" width="10%"><?php _e( 'Time', 'convocations' ); ?></th>
							<th class="manage-column" width="10%"><?php _e( 'Time of the game', 'convocations' ); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<?php
		}
	}
}