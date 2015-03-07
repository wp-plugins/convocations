<?php
function displayConvocations( $convocations )
{
	?>
	<?php if( count( $convocations ) == 0 ) { ?>
		<p>Aucune convocation pour le moment.</p>
	<?php } else { ?>
		<form id="select-convocation" method="" action="">
			<label for="liste-convocations">Sélectionnez une équipe pour voir la liste des joueurs convoqués : </label>
			<select name="liste-convocations" id="liste-convocations">
				<option value="0"></option>
				<?php foreach ( $convocations as $convocation ) { ?>
					<option value="<?php echo $convocation->id ?>"><?php echo $convocation->equipe ?></option>
				<?php } ?>
			</select>
		</form>
	<?php } ?>
	<div id="liste-joueurs">Aucune équipe sélectionnée</div>
<?php } ?>