<?php
if( !class_exists( 'Joueur_Admin_New_View' ) )
{
	class Joueur_Admin_New_View
	{
		public static function render( $equipes ) {
			?>
			<div class="wrap">
				<h2>
					<?php _e( 'Add player', 'convocations' ); ?>
				</h2>
				<div id="alert"></div>
				<form action="admin-post.php" method="POST">
					<table>
						<tbody>
							<tr>
								<td width="40%"><label for="nom"><?php _e( 'Name', 'convocations' ); ?>:</label></td>
								<td width="60%"><input name="nom" type="text" value="" size="50" /></td>
							</tr>
						
							<tr>
								<td width="40%"><label for="prenom"><?php _e( 'Firstname', 'convocations' ); ?>:</label></td>
								<td width="60%"><input name="prenom" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="40%"><label for="poste"><?php _e( 'Position', 'convocations' ); ?>:</label></td>
								<td width="60%"><input name="poste" type="text" value="" size="50" /></td>
							</tr>
							
							<td width="40%"><label for="equipe"><?php _e( 'Team', 'convocations' ); ?>:</label></td>
							<td width="60%">
								<select name="equipe" id="equipe">
									<option value=""></option>
									<?php foreach( $equipes as $equipe ) { ?>
										<option value="<?php echo $equipe->nom; ?>"><?php echo $equipe->nom; ?></option>
									<?php } ?>
									
								</select>
							</td>
							<tr>
								<td width="600" colspan="2"><input type="submit" value="<?php _e( 'Add', 'convocations' ); ?>" class="button-primary" style="min-width: 80px;" /></td>
							</tr>
						</tbody>
					</table>
					<input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
					<input name="action" type="hidden" value="new_joueur" />
				</form>
				</div>
			<?php
		}
	}
}