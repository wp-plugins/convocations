<?php
if( !class_exists( 'Joueur_Admin_Edit_View' ) )
{
	class Joueur_Admin_Edit_View
	{
		public static function render( $joueur, $equipes ) {
			?>
			<div class="wrap">
				<h2>
					Modifier un joueur
				</h2>
				<div id="alert"></div>
				<form action="admin-post.php" method="POST">
					<?php foreach( $joueur as $info ) { ?>
						<table>
							<tbody>
								<tr>
									<td width="300"><label for="nom">Nom  : </label></td>
									<td width="300"><input name="nom" type="text" value="<?php echo $info->nom ?>" size="50" /></td>
								</tr>
							
								<tr>
									<td width="300"><label for="prenom">Prénom : </label></td>
									<td width="300"><input name="prenom" type="text" value="<?php echo $info->prenom ?>" size="50" /></td>
								</tr>
								
								<tr>
									<td width="300"><label for="poste">Poste : </label></td>
									<td width="300"><input name="poste" type="text" value="<?php echo $info->poste ?>" size="50" /></td>
								</tr>
								
								<td width="300"><label for="equipe">Equipe : </label></td>
								<td width="300">
									<select name="equipe" id="equipe">
										<option value=""></option>
										<?php foreach( $equipes as $equipe ) { ?>
											<?php if( $equipe->nom == $info->equipe ) { ?>
												<option value="<?php echo $info->equipe ?>" selected><?php echo $info->equipe ?></option>
											<?php } else { ?>
											<option value="<?php echo $equipe->nom ?>"><?php echo $equipe->nom ?></option>
											<?php } ?>
										<?php } ?>
										
									</select>
								</td>
								
								<tr>
									<td width="600" colspan="2"><input type="submit" value="Modifier" class="button-primary" style="min-width: 80px;" /></td>
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