<?php
if( !class_exists( 'Joueur_Admin_Edit_View' ) )
{
	class Joueur_Admin_Edit_View
	{
		public static function render( $joueur, $equipes ) {
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
					<?php _e( 'Edit player', 'convocations' ); ?>
					<a class="add-new-h2" href="admin.php?page=convocations/app/controller/controller-joueur.php&action=new"><?php _e( 'Add', 'convocations' ); ?></a>
				</h2>
				<div id="alert"></div>
				<form action="admin-post.php" method="POST">
					<?php foreach( $joueur as $info ) { ?>
						<table>
							<tbody>
								<tr>
									<td width="300"><label for="nom"><?php _e( 'Lastname', 'convocations' ); ?>:</label></td>
									<td width="300"><input name="nom" type="text" value="<?php echo $info->nom; ?>" size="50" /></td>
								</tr>
							
								<tr>
									<td width="300"><label for="prenom"><?php _e( 'Firstname', 'convocations' ); ?>:</label></td>
									<td width="300"><input name="prenom" type="text" value="<?php echo $info->prenom; ?>" size="50" /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="poste"><?php _e( 'Position', 'convocations' ); ?>:</label></td>
									<td width="300"><input name="poste" type="text" value="<?php echo $info->poste; ?>" size="50" /></td>
								</tr>
								
								<td width="300"><label for="equipe"><?php _e( 'Team', 'convocations' ); ?>:</label></td>
								<td width="300">
									<select name="equipe" id="equipe">
										<option value=""></option>
										<?php foreach( $equipes as $equipe ) { ?>
											<?php if( $equipe->nom == $info->equipe ) { ?>
												<option value="<?php echo $info->equipe; ?>" selected><?php echo $info->equipe; ?></option>
											<?php } else { ?>
											<option value="<?php echo $equipe->nom; ?>"><?php echo $equipe->nom; ?></option>
											<?php } ?>
										<?php } ?>
										
									</select>
								</td>
								
								<tr>
									<td width="600" colspan="2"><input type="submit" value="<?php _e( 'Edit', 'convocations' ); ?>" class="button-primary" style="min-width: 80px;" /></td>
								</tr>
							</tbody>
						</table>
						<input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
						<input name="action" type="hidden" value="edit_joueur" />
					<?php } ?>
				</form>
				</div>
			<?php
		}
	}
}