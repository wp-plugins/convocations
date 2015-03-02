<?php
if( !class_exists( 'Convocation_Admin_View' ) )
{
	class Convocation_Admin_View
	{
		public static function render( $convocations ) {
			?>
			<div class="wrap">
				<h2>
					Gestion des convocations
				</h2>
				<div id="alert"></div>
				<table class="wp-list-table widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column" width="20%">Equipe</th>
							<th class="manage-column" width="20%">Equipe adverse</th>
							<th class="manage-column" width="10%">Date</th>
							<th class="manage-column" width="15%">Type</th>
							<th class="manage-column" width="15%">Lieu du RDV</th>
							<th class="manage-column" width="10%">Heure du RDV</th>
							<th class="manage-column" width="10%">Heure du match</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $convocations as $convocation ) { ?>
							<tr>
								<td><strong><a title="Modifier »" href="admin.php?page=convocations/app/controller/controller-convocation.php&id=<?php echo $convocation->id ?>&action=edit"><?php echo $convocation->equipe ?></a></strong></td>
								<td><?php echo $convocation->equipadv ?></td>
								<td><?php echo $convocation->date ?></td>
								<td><?php echo $convocation->domext ?></td>
								<td><?php echo $convocation->lieurdv ?></td>
								<td><?php echo $convocation->heurerdv ?></td>
								<td><?php echo $convocation->heurematch ?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<th class="manage-column" width="20%">Equipe</th>
							<th class="manage-column" width="20%">Equipe adverse</th>
							<th class="manage-column" width="10%">Date</th>
							<th class="manage-column" width="15%">Type</th>
							<th class="manage-column" width="15%">Lieu du RDV</th>
							<th class="manage-column" width="10%">Heure du RDV</th>
							<th class="manage-column" width="10%">Heure du match</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<?php
		}
	}
}