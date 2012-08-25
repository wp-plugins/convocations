<?php
if( isset( $_POST['lequipe'] ) && $_POST['lequipe'] != '') {
	global $wpdb;
	$table_name = $wpdb->prefix . 'convocations_joueurs';
	$table_name2 = $wpdb->prefix . 'convocations';
	
	$sql_joueurs = '
			SELECT * 
			FROM ' .$table_name. ' 
			INNER JOIN '. $table_name2 .' ON '. $table_name2 .'.id = ' .$table_name. '.numconvocation 
			WHERE ' .$table_name. '.numconvocation = '.$_POST['lequipe'].' 
			ORDER BY ' .$table_name. '.nom ASC 
			';
	$sql_joueurs = $wpdb->prepare($sql_joueurs);
	
	$joueurs = $wpdb->get_results($sql_joueurs);
	
	setlocale(LC_TIME, "fr_FR", "fr_FR@euro", "fr", "FR", "fra_fra", "fra");
	$html = '<p>';
	$html .= 'Les joueurs de l\'équipe '. $joueurs[0]->equipe .' sont convoqués le ';
	$html .= '<strong>'. utf8_encode(strftime("%A %d %B %Y", strtotime($joueurs[0]->date))) .'</strong> ';
	$html .= 'à <strong>'. $joueurs[0]->heurerdv .'</strong><br />';
	$html .= 'Le lieu du rendez-vous est : '. $joueurs[0]->lieurdv .'<br />';
	$html .= 'Le match débutera à '. $joueurs[0]->heurematch .'';
	$html .= '</p>';
	$html .= '<h2>Liste des joueurs convoqués :</h2>';
	$html .= '<p>';
	
	if( count( $joueurs ) != 0 ) {
		
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
	
	$html = '';
	
	$html .= '
	<script type="text/javascript">
		function charge_joueurs() {
			var select = document.getElementById("liste-convocations");
			var choice = select.selectedIndex
			var equipe = select.options[choice].value;
			
			if(equipe != 0) {
				jQuery.post("", {lequipe: equipe}, function(data) {
					document.getElementById("liste-joueurs").innerHTML = data;
				});
			}
			else {
				document.getElementById("liste-joueurs").innerHTML = "Aucune équipe sélectionnée";
			}
		}
	</script>';
	if( count( $convocations ) == 0 ) {
		$html .= '<p>Aucune convocation pour le moment.</p>';
	} else {
		$html .= '
		<form method="" action="">
			<label for="liste-convocations">Sélectionnez une équipe pour voir la liste des joueurs convoqués : </label>
			<select name="liste-convocations" id="liste-convocations" onChange="charge_joueurs();">
				<option value="0"></option>';
				
				foreach ( $convocations as $convocation ) {
					$html .= '<option value="'. $convocation->id .'">'. $convocation->equipe .'</option>';
				}
			$html .= '	
			</select>
		</form>';
	}
	$html .= '
	<div class="bordure" style="background: url(\''. get_bloginfo("template_url") .'/images/flash-infos-li-bordure.gif\') repeat-x; margin-top: 25px; ">&nbsp;</div>
	<div id="liste-joueurs">Aucune équipe sélectionnée</div>';
	
	echo $html;
}