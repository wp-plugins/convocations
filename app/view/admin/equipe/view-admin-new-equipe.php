<?php
if( !class_exists( 'Equipe_Admin_New_View' ) )
{
	class Equipe_Admin_New_View
	{
		public static function render() {
			?>
			<div class="wrap">
				<h2>
					Ajouter une équipe
				</h2>
				<form action="admin-post.php" method="POST">
					<input name="action" type="hidden" value="new_equipe" />
					<table>
						<tbody>
							<tr>
								<td width="40%"><label for="nom">Nom de l'équipe : </label></td>
								<td width="60%"><input name="nom" type="text" value="" size="50" /></td>
							</tr>
						
							<tr>
								<td width="40%"><label for="responsable">Nom du(des) responsable(s) de l'équipe : </label></td>
								<td width="60%"><input name="responsable" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="40%"><label for="telephone">Numéro(s) du(des) responsable(s) de l'équipe : </label></td>
								<td width="60%"><input name="telephone" type="text" value="" size="50" /></td>
							</tr>
							
							<tr>
								<td width="40%"><label for="entrainement">Entrainement : </label></td>
								<td width="60%"><input name="entrainement" type="text" value="" size="50" /><br /></td>
							</tr>
							
							<tr>
								<td width="600" colspan="2"><input type="submit" value="Ajouter" class="button-primary" style="min-width: 80px;" /></td>
							</tr>
						</tbody>
					</table>
				</form>
				</div>
			<?php
		}
	}
}