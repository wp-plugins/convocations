<?php
if( !class_exists( 'Equipe_Admin_View' ) )
{
	class Equipe_Admin_View
	{
		public static function render( $equipes ) {
			?>
			<div class="wrap">
				<h2>
					Gestion des équipes
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-equipe.php&action=new">Ajouter</a>
				</h2>
				<table class="wp-list-table widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column" width="25%">Nom</th>
							<th class="manage-column" width="25%">Responsable</th>
							<th class="manage-column" width="25%">Téléphone</th>
							<th class="manage-column" width="25%">Entraînement</th>
						</tr>
					</thead>
					<tbody id="the-list">
						<?php $i = 0; ?>
						<?php foreach( $equipes as $equipe ) { ?>
						<tr <?php if($i%2 == 0){ ?>class="alternate"<?php } ?>>
							<td>
								<strong>
									<a class="row-title" title="Modifier »" href="admin.php?page=convocations/app/controller/controller-equipe.php&id=<?php echo $equipe->id ?>&action=edit"><?php echo $equipe->nom ?></a>
								</strong>
								<div class="row-actions">
									<span class="edit">
										<a title="Modifier cet élément" href="admin.php?page=convocations/app/controller/controller-equipe.php&id=<?php echo $equipe->id ?>&action=edit">Modifier</a>
										|
									</span>
									<span class="delete">
										<a class="submitdelete" href="admin.php?page=convocations/app/controller/controller-equipe.php&action=delete&id=<?php echo $equipe->id ?>&equipe=<?php echo $equipe->nom ?>" onclick="return showNotice.warn();">Supprimer définitivement</a>
									</span>
								</div>
							</td>
							<td><?php echo $equipe->responsable ?></td>
							<td><?php echo $equipe->telephone ?></td>
							<td><?php echo $equipe->entrainement ?></td>
						</tr>
							<?php $i++; ?>
					<?php }  ?>
					</tbody>
					<tfoot>
						<tr>
							<th class="manage-column" width="25%">Nom</th>
							<th class="manage-column" width="25%">Responsable</th>
							<th class="manage-column" width="25%">Téléphone</th>
							<th class="manage-column" width="25%">Entraînement</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<?php
		}
	}
}