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
				<div id="alert"></div>
				<table class="wp-list-table widefat fixed">
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
					<tbody id="the-list">
						<?php $i = 0; ?>
						<?php foreach ( $convocations as $convocation ) { ?>
							<tr <?php if($i%2 == 0){ ?>class="alternate"<?php } ?>>
								<td class="column-title">
									<strong>
										<a class="row-title" title="Modifier »" href="admin.php?page=convocations/app/controller/controller-convocation.php&id=<?php echo $convocation->id ?>&action=edit"><?php echo $convocation->equipe ?></a>
									</strong>
									<div class="row-actions">
										<span class="edit">
											<a title="Modifier cet élément" href="admin.php?page=convocations/app/controller/controller-convocation.php&id=<?php echo $convocation->id ?>&action=edit">Modifier</a>
										</span>
									</div>
								</td>
								<td><?php echo $convocation->equipadv ?></td>
								<td><?php echo $convocation->date ?></td>
								<td><?php echo $convocation->domext ?></td>
								<td><?php echo $convocation->lieurdv ?></td>
								<td><?php echo $convocation->heurerdv ?></td>
								<td><?php echo $convocation->heurematch ?></td>
							</tr>
							<?php $i++; ?>
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