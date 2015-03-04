<?php
if( !class_exists( 'Joueur_Admin_View' ) )
{
	class Joueur_Admin_View
	{
		public static function render( $equipes, $joueurs ) {
			?>
			<div class="wrap">
				<h2>
					Gestion des joueurs
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-joueur.php&action=new">Ajouter</a>
				</h2>
				<form action="admin-post.php" method="GET" >
					<div class="tablenav top">
						<input type="hidden" name="action" value="filtrer" />
						<select name="filtre-equipe">
							<option value="toutes">Toutes les équipes</option>
							<?php foreach( $equipes as $equipe ){ ?>
								<?php if( isset( $_GET['filtre-equipe'] ) ) { ?>
									<?php if( $equipe->nom == $_GET['filtre-equipe'] ) { ?>
										<option value="<?php echo $equipe->nom ?>" selected><?php echo $equipe->nom ?></option>
									<?php } ?>
								<?php } else { ?>
									<option value="<?php echo $equipe->nom ?>"><?php echo $equipe->nom ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<input id="joueur-query-submit" class="button-secondary" type="submit" value="Filtrer" name="filter_action">
					</div>
				</form>
				<table class="wp-list-table widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column" width="25%">Nom</th>
							<th class="manage-column" width="25%">Prénom</th>
							<th class="manage-column" width="15%">Poste</th>
							<th class="manage-column" width="25%">Equipe</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach( $joueurs as $joueur ) { ?>
						<tr>
							<td><strong><a title="Modifier »" href="admin.php?page=convocations/app/controller/controller-joueur.php&id=<?php echo $joueur->id ?>&action=edit"><?php echo $joueur->nom ?></a></strong></td>
							<td><?php echo $joueur->prenom ?></td>
							<td><?php echo $joueur->poste ?></td>
							<td><?php echo $joueur->equipe ?></td>
						</tr>
					<?php }  ?>
					</tbody>
					<tfoot>
						<tr>
							<th class="manage-column" width="25%">Nom</th>
							<th class="manage-column" width="25%">Prénom</th>
							<th class="manage-column" width="15%">Poste</th>
							<th class="manage-column" width="25%">Equipe</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<?php
		}
	}
}