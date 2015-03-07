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
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-joueur.php&action=new">Ajouter</a>
				</h2>
				<form action="admin-post.php" method="GET" >
					<div class="tablenav top">
						<input type="hidden" name="action" value="filtrer" />
						<select name="filtre-equipe">
							<option value="toutes"><?php _e( 'All the teams', 'convocations' ); ?></option>
							<?php foreach( $equipes as $equipe ){ ?>
								<?php if( isset( $_GET['filtre-equipe'] ) ) { ?>
									<?php if( $equipe->nom == $_GET['filtre-equipe'] ) { ?>
										<option value="<?php echo $equipe->nom; ?>" selected><?php echo $equipe->nom; ?></option>
									<?php } ?>
								<?php } else { ?>
									<option value="<?php echo $equipe->nom; ?>"><?php echo $equipe->nom; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<input id="joueur-query-submit" class="button-secondary" type="submit" value="Filtrer" />
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
									<a class="row-title" title="<?php _e( 'Edit', 'convocations' ); ?> »" href="admin.php?page=convocations/app/controller/controller-joueur.php&id=<?php echo $joueur->id; ?>&action=edit"><?php echo $joueur->nom; ?></a>
								</strong>
								<div class="row-actions">
									<span class="edit">
										<a title="<?php _e( 'Edit this element', 'convocations' ); ?>" href="admin.php?page=convocations/app/controller/controller-joueur.php&id=<?php echo $joueur->id; ?>&action=edit"><?php _e( 'Edit', 'convocations' ); ?></a>
										|
									</span>
									<span class="delete">
										<a class="submitdelete" href="admin.php?page=convocations/app/controller/controller-joueur.php&action=delete&id=<?php echo $joueur->id; ?>" onclick="return showNotice.warn();"><?php _e( 'Delete', 'convocations' ); ?></a>
									</span>
								</div>
							</td>
							<td><?php echo $joueur->prenom; ?></td>
							<td><?php echo $joueur->poste; ?></td>
							<td><?php echo $joueur->equipe; ?></td>
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