<?php
if( !class_exists( 'Joueur_Admin_View' ) )
{
	class Joueur_Admin_View
	{
		public static function render( $equipes, $joueurs ) {
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Manage players', 'convocations' ); ?>
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-joueur.php&action=new"><?php _e( 'Add', 'convocations' ); ?></a>
				</h2>
				<?php if( isset( $_GET['deleted'] ) && $_GET['deleted'] == 1 ) { ?>
					<div id="message" class="updated below-h2">
						<p><?php _e( 'The player has been deleted.', 'convocations' ) ?></p>
					</div>
				<?php } ?>
				<form action="admin-post.php" method="GET" >
					<div class="tablenav top">
						<input type="hidden" value="filtrer" name="action">
						<select name="filtre-equipe">
							<option value="toutes"><?php _e( 'All the teams', 'convocations' ); ?></option>
							<?php foreach( $equipes as $equipe ){ ?>
								<?php if( $equipe->get_nom() == $_GET['filtre-equipe'] ) { ?>
									<option value="<?php echo $equipe->get_nom(); ?>" selected="selected"><?php echo $equipe->get_nom(); ?></option>
								<?php } else { ?>
									<option value="<?php echo $equipe->get_nom(); ?>"><?php echo $equipe->get_nom(); ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<input id="joueur-query-submit" class="button-secondary" type="submit" value="<?php _e( 'Filter', 'convocations' ); ?>" />
					</div>
				</form>
				<table class="wp-list-table widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column" width="25%"><?php _e( 'Lastname', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Firstname', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Position', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Team', 'convocations' ); ?></th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php $i = 0; ?>
					<?php foreach( $joueurs as $joueur ) { ?>
						<tr <?php if($i%2 == 0){ ?>class="alternate"<?php } ?>>
							<td>
								<strong>
									<a class="row-title" title="<?php _e( 'Edit', 'convocations' ); ?> »" href="admin.php?page=convocations/app/controller/controller-joueur.php&id=<?php echo $joueur->get_id(); ?>&action=edit"><?php echo $joueur->get_nom(); ?></a>
								</strong>
								<div class="row-actions">
									<span class="edit">
										<a title="<?php _e( 'Edit this element', 'convocations' ); ?>" href="admin.php?page=convocations/app/controller/controller-joueur.php&id=<?php echo $joueur->get_id(); ?>&action=edit"><?php _e( 'Edit', 'convocations' ); ?></a>
										|
									</span>
									<span class="delete">
										<a class="submitdelete" href="admin.php?page=convocations/app/controller/controller-joueur.php&action=delete&id=<?php echo $joueur->get_id(); ?>" onclick="return showNotice.warn();"><?php _e( 'Delete', 'convocations' ); ?></a>
									</span>
								</div>
							</td>
							<td><?php echo $joueur->get_prenom(); ?></td>
							<td><?php echo $joueur->get_poste(); ?></td>
							<td><?php echo $joueur->get_equipe(); ?></td>
						</tr>
						<?php $i++; ?>
					<?php }  ?>
					</tbody>
					<tfoot>
						<tr>
							<th class="manage-column" width="25%"><?php _e( 'Lastname', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Firstname', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Position', 'convocations' ); ?></th>
							<th class="manage-column" width="25%"><?php _e( 'Team', 'convocations' ); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<?php
		}
	}
}