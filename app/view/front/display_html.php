<?php
if( isset( $_POST['lequipe'] ) && $_POST['lequipe'] != '') {
	global $wpdb;
	
	$tablename = $wpdb->prefix . 'convocations_joueurs';
	$tablename2 = $wpdb->prefix . 'convocations';
	$sql_joueurs = $wpdb->prepare(
								'
								SELECT * 
								FROM ' .$tablename. ' 
								INNER JOIN '. $tablename2 .' ON '. $tablename2 .'.id = ' .$tablename. '.numconvocation 
								WHERE ' .$tablename. '.numconvocation = %d 
								ORDER BY ' .$tablename. '.nom ASC
								',
								$_POST['lequipe']
					);
	
	$joueurs = $wpdb->get_results($sql_joueurs);
	
	$html = '';
	
	if( count( $joueurs ) != 0 ){
		setlocale(LC_TIME, "fr_FR", "fr_FR@euro", "fr", "FR", "fra_fra", "fra");
		$html .= '<h2>'. $joueurs[0]->equipe .' - Match contre '. $joueurs[0]->equipadv .'</h2>';
		$html .= '<p>';
		$html .= 'Les joueurs de l\'équipe sont convoqués le ';
		$html .= '<strong>'. utf8_encode(strftime("%A %d %B %Y", strtotime($joueurs[0]->date))) .'</strong> ';
		$html .= 'à <strong>'. $joueurs[0]->heurerdv .'</strong><br /> ';
		$html .= 'Le lieu du rendez-vous est : '. $joueurs[0]->lieurdv .'<br />';
		$html .= 'Le match débutera à '. $joueurs[0]->heurematch .'';
		$html .= '</p>';
		$html .= '<h3>Liste des joueurs convoqués :</h3>';
		$html .= '<p>';
	
		foreach ( $joueurs as $joueur ) {
			$html .= $joueur->nom .' '. ucfirst(strtolower($joueur->prenom)) .'<br>';
		}
		
		$html .= '</p>';
		
		echo $html;
	}
	else {
		$html .= '<p>Aucun joueur n\'a été affecté à ce match pour le moment</p>';
		echo $html;
	}
	die();
}

function displayConvocations()
{
	global $wpdb;
	$tablename = $wpdb->prefix . 'convocations';
	$sql = '
			SELECT * 
			FROM ' . $tablename . '
			ORDER BY equipe ASC 
			';
	
	$sql = $wpdb->prepare($sql);
	
	$convocations = $wpdb->get_results($sql);
	
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#liste-convocations').change(function() {
				var equipe = $("#liste-convocations option:selected").val();
				if(equipe != 0) {
					$.post(this, {lequipe: equipe}, function(data) {
						$('#liste-joueurs').html(data).show(200);
					});
				}else {
					$('#liste-joueurs').html('Aucune équipe sélectionnée').show(200);
				}
				return false;
			});
		});
	</script>
	<?php if( count( $convocations ) == 0 ) { ?>
		<p>Aucune convocation pour le moment.</p>
	<?php } else { ?>
		<form method="" action="">
			<label for="liste-convocations">Sélectionnez une équipe pour voir la liste des joueurs convoqués : </label>
			<select name="liste-convocations" id="liste-convocations">
				<option value="0"></option>
				<?php foreach ( $convocations as $convocation ) { ?>
					<option value="<?php echo $convocation->id ?>"><?php echo $convocation->equipe ?></option>
				<?php } ?>
			</select>
		</form>
	<?php } ?>
	<div class="bordure" style="background: url('<?php bloginfo("template_url") ?>/images/flash-infos-li-bordure.gif') repeat-x; margin-top: 25px; ">&nbsp;</div>
	<div id="liste-joueurs">Aucune équipe sélectionnée</div>
<?php } ?>