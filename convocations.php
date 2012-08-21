<?php
/*
Plugin Name: Convocations
Description: Convocations est un plugin pour le clubs sportifs souhaitant gérer et afficher sur leur site la liste des joueurs convoqués à un match.
Version: 0.1
Author: JC
Author URI: http://www.breizh-seo.com/
*/

if(!class_exists("Convocations"))
{
	class Convocations
	{
		/** 
		 * Constructeur
		 */
		function __construct()
		{
			define('CONVOCATIONS_URL', WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
		}
		
		/** 
		 * Ajout du menu dans l'administration
		 */
		function adminMenu()
		{
			add_menu_page('Convocations', 'Convocations', 'manage_options', __FILE__, 'adminConvocations', '', 21);
			add_submenu_page(__FILE__ , 'Gestion des équipes', 'Gestion des équipes', 'manage_options', 'admin-equipes', 'adminEquipes');
			add_submenu_page(__FILE__ , 'Gestion des joueurs', 'Gestion des joueurs', 'manage_options', 'admin-joueurs', 'adminJoueurs');
		}
		
		function addScripts()
		{
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery', 'jquery-ui-core' ) );
			wp_enqueue_style( 'jquery.ui.theme', CONVOCATIONS_URL . '/css/jquery-ui-1.8.23.custom.css' );
		}
		
		function adminFooter()
		{
			echo '
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery("#datepicker").datepicker({
						dateFormat: "yy-mm-dd",
						dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
						dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
						dayNamesShort : ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
						monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
						monthNamesMin: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
						monthNamesShort: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
						changeYear: true,
						yearRange: "c-10:c+10"
						});						
					});
				</script>
			';
		}
		
		/** 
		 * Activation du plugin convocations 
		 * @global wpdb $wpdb 
		 */
		function activation()
		{
			global $wpdb;
		 
			$tableName = $wpdb->prefix . 'convocations';
			$sql = "CREATE TABLE IF NOT EXISTS `" . $tableName . "` (";
			$sql .= "`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,";
			$sql .= "`equipe` TEXT NOT NULL ,";
			$sql .= "`equipadv` TEXT NOT NULL ,";
			$sql .= "`date` DATE NOT NULL ,";
			$sql .= "`domext` TEXT NOT NULL ,";
			$sql .= "`lieurdv` TEXT NOT NULL ,";
			$sql .= "`heurerdv` TEXT NOT NULL ,";
			$sql .= "`heurematch` TEXT NOT NULL) ";
			$sql .= "CHARACTER SET utf8 ,";
			$sql .= " COLLATE utf8_general_ci;";
			
			$tableName = $wpdb->prefix . 'convocations_equipes';
			$sql2 = "CREATE TABLE IF NOT EXISTS `" . $tableName . "` (";
			$sql2 .= "`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,";
			$sql2 .= "`nom` TEXT NOT NULL ,";
			$sql2 .= "`responsable` TEXT NOT NULL ,";
			$sql2 .= "`telephone` TEXT NOT NULL ,";
			$sql2 .= "`entrainement` INT NOT NULL) ";
			$sql2 .= "CHARACTER SET utf8 ,";
			$sql2 .= " COLLATE utf8_general_ci;";
			
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$sql3 = "CREATE TABLE IF NOT EXISTS `" . $tableName . "` (";
			$sql3 .= "`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,";
			$sql3 .= "`nom` TEXT NOT NULL ,";
			$sql3 .= "`prenom` TEXT NOT NULL ,";
			$sql3 .= "`poste` TEXT NOT NULL ,";
			$sql3 .= "`equipe` TEXT NOT NULL ,";
			$sql3 .= "`etat` INT NOT NULL ,";
			$sql3 .= "`numconvocation` INT NOT NULL) ";
			$sql3 .= "CHARACTER SET utf8 ,";
			$sql3 .= "COLLATE utf8_general_ci;";
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			dbDelta($sql2);
			dbDelta($sql3);
			
			// Définie la version des tables (en vue d'une mise à jour par exemple)
			add_option('convocations_db_version', '0.1');
		}
		
		/* GETTER */
		
		/**
		 * On récupère les éléments de la convocation en fonction de l'id passé en paramètre
		 * @param theConvocation Identifiant de la convocation à récupérer
		 * @return un tableau contenant les éléments d'une convocation
		 */
		function getConvocation( $theConvocation )
		{
			global $wpdb;
			$tableName = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $tableName . ' 
								WHERE id = %d
								',
								$theConvocation
					);
			
			$convocation = $wpdb->get_results($sql);
			
			return $convocation;
		}
		
		/**
		 * On récupère toutes les convocations enregistrées en base
		 */
		function getAllConvocations()
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare('SELECT * FROM ' . $tableName . ' ORDER BY equipe ASC');
			$allConvocations = $wpdb->get_results($sql);
			
			return $allConvocations;
		}
		
		/**
		 * On récupère les éléments de l'équipe en fonction de l'id passé en paramètre
		 */
		function getEquipe( $theEquipe )
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $tableName . ' 
								WHERE id = %d
								',
								$theEquipe
					);
			$equipe = $wpdb->get_results($sql);
			
			return $equipe;
		}
		
		/**
		 * On récupère toutes les équipes enregistrées en base
		 */
		function getAllEquipes()
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare('SELECT * FROM ' . $tableName . ' ORDER BY nom ASC');
			$allEquipes = $wpdb->get_results($sql);
			
			return $allEquipes;
		}
		
		/**
		 * On récupère les éléments du joueur en fonction de l'id passé en paramètre
		 */
		function getJoueur( $theJoueur )
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $tableName . ' 
								WHERE id = %d
								',
								$theJoueur
					);
			$joueur = $wpdb->get_results($sql);
			
			return $joueur;
		}
		
		/**
		 * On récupère les joueurs appartenant à l'équipe passée en paramètre
		 */
		function getJoueursByEquipe( $theEquipe )
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $tableName . ' 
								WHERE equipe = %s 
								ORDER BY nom ASC
								',
								$theEquipe
					);
			$joueursEquipe = $wpdb->get_results($sql);
			
			return $joueursEquipe;
		}
		
		/**
		 * On récupère tous les joueurs enregistrés en base
		 */
		function getAllJoueurs()
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare('SELECT * FROM ' . $tableName . ' ORDER BY nom ASC');
			$allJoueurs = $wpdb->get_results($sql);
			
			return $allJoueurs;
		}
		
		/* GESTION DES CONVOCATIONS */
		
		/**
		 * On met à jour la convocation
		 * @param id Identifiant de la convocation à mettre à jour
		 * @param equipadv Nom de l'équipe adverse
		 * @param date Date de la convocation
		 * @param domext Lieu de la rencontre
		 * @param lieurdv Lieu du RDV
		 * @param heurerdv Heure du RDV
		 * @param heurematch Heure du match
		 * @param arrJoueurs Tableau des joueurs à convoquer
		 */
		function updateConvocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs )
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations';
			$wpdb->update(
				$tableName,
				array(
						'equipadv'	=> $equipadv,
						'date'		=> $date,
						'domext'	=> $domext,
						'lieurdv'	=> $lieurdv,
						'heurerdv'	=> $heurerdv,
						'heurematch'=> $heurematch
				),
				array(
						'id' => $id
				)
			);
			
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$wpdb->update(
				$tableName,
				array(
						'numconvocation'	=> '-1'
				),
				array(
						'numconvocation' => $id
				)
			);
			
			if(!empty($arrJoueurs)) {
				foreach ($arrJoueurs as $joueur) {
					$wpdb->update(
						$tableName,
						array(
								'numconvocation'	=> $id
						),
						array(
								'id' => $joueur
						)
					);
				}
			}
		}
		
		/**
		 * Fonction permettant d'effacer la convocation associée à une équipe lors de la suppression de cette équipe
		 * @param theEquipe Equipe liant la convocation
		 */
		function deleteConvocation( $theEquipe ) {
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . $tableName . ' 
								WHERE equipe = %s
								',
								$theEquipe
					);
			$wpdb->query($sql);
		}
		
		/* GESTION DES EQUIPES */
		
		/**
		 * Fonction permettant de créer une équipe en base
		 * @param nom Nom de l'équipe à insérer
		 * @param responsable Nom(s) du(des) responsable(s) de l'équipe
		 * @param telephone Numéro(s) de téléphone du(des) responsable(s) de l'équipe
		 * @param entrainement Infos sur les jours et heures d'entrainement de l'équipe
		 * @return un booleen égale à TRUE si l'insertion a été effectuée, FALSE sinon
		 */
		function insertEquipe( $nom, $responsable, $telephone, $entrainement ) {
			global $wpdb;
			
			// On vérifie qu'une équipe avec le même non n'existe pas déjà
			$tableName = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $tableName . ' 
								WHERE nom = %s"
								',
								$nom
					);
			$equipe = $wpdb->get_results($sql);
			
			// S'il n'en existe pas, on la créer
			if (count ($equipe) == 0){
				$wpdb->insert(
					$tableName,
					array(
							'nom' 			=> $nom,
							'responsable' 	=> $responsable,
							'telephone' 	=> $telephone,
							'entrainement' 	=> $entrainement
					)
				);
				
				// et on ajoute la convocation qui sera liée à cette équipe
				$tableName = $wpdb->prefix . 'convocations';
				$wpdb->insert(
					$tableName,
					array(
							'equipe' => $nom
					)
				);
				
				return true;
			}
			// Sinon on retourne false
			else
			{
				return false;
			}
		}
		
		/**
		 * Fonction permettant de mettre à jour une équipe en base
		 * @param $id Identifiant de l'équipe à mettre à jour
		 * @param old_name Ancien nom de l'équipe
		 * @param nom Nouveau nom de l'équipe
		 * @param responsable Nouveau Nom(s) du(des) responsable(s) de l'équipe
		 * @param telephone Nouveau Numéro(s) de téléphone du(des) responsable(s) de l'équipe
		 * @param entrainement Nouvelles Infos sur les jours et heures d'entrainement de l'équipe
		 */
		function updateEquipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement )
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_equipes';
			
			$wpdb->update(
				$tableName,
				array(
						'nom'			=> $nom,
						'responsable'	=> $responsable,
						'telephone'		=> $telephone,
						'entrainement'	=> $entrainement
				),
				array(
						'id' => $id
				)
			);
			
			// Si le nom à enregistrer est différent de l'ancien nom, on met à jour la convocation liée
			if ( $nom != $old_name) {
				$tableName = $wpdb->prefix . 'convocations';
				
				$wpdb->update(
					$tableName,
					array(
							'equipe' => $nom
					),
					array(
							'equipe' => $old_name
					)
				);
			}
		}
		
		/**
		 * Fonction permettant de supprimer une équipe en base
		 * @param $id Identifiant de l'équipe à supprimer
		 */
		function deleteEquipe( $id )
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . $tableName . ' 
								WHERE id = %d
								',
								$id
					);
			$wpdb->query($sql);
		}
		
		/* GESTION DES JOUEURS */
		
		/**
		 * Fonction permettant de créer une équipe en base
		 * @param $nom Nom du joueur
		 * @param $prenom Prénom du joueur
		 * @param $poste Poste occupé par le joueur
		 * @param $equipe Equipe du joueur
		 * @return un booleen égale à TRUE si l'insertion a été effectuée, FALSE sinon
		 */
		function insertJoueur( $nom, $prenom, $poste, $equipe )
		{
			global $wpdb;
			
			// On vérifie qu'un joueur avec les mêmes nom et prénom n'existe pas déjà
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $tableName . ' 
								WHERE nom = %s
								AND prenom = %s
								',
								$nom, $prenom
					);
			$joueur = $wpdb->get_results($sql);
			
			// S'il n'en existe pas, on le créer
			if (count ($joueur) == 0){
				$wpdb->insert(
					$tableName,
					array(
							'nom' 		=> $nom,
							'prenom' 	=> $prenom,
							'poste' 	=> $poste,
							'equipe' 	=> $equipe
					)
				);
				
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 * Fonction permettant de mettre à jour un joueur en base
		 * @param $id Identifiant du joueur à mettre à jour
		 * @param $nom Nom du joueur
		 * @param $prenom Prénom du joueur
		 * @param $poste Poste occupé par le joueur
		 * @param $equipe Equipe du joueur
		 */
		function updateJoueur( $id, $nom, $prenom, $poste, $equipe ) {
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$wpdb->update(
				$tableName,
				array(
						'nom'		=> $nom,
						'prenom'	=> $prenom,
						'poste'		=> $poste,
						'equipe'	=> $equipe
				),
				array(
						'id' => $id
				)
			);
		}
		
		/**
		 * Fonction permettant de supprimer un joueur en base
		 * @param $id Identifiant du joueur à supprimer
		 */
		function deleteJoueur( $id ) {
			global $wpdb;
			
			$tableName = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . $tableName . ' 
								WHERE id = %d
								',
								$id
					);
			$wpdb->query($sql);
		}
	}
}

if ( class_exists( 'Convocations' ) )
{
	$inst_convocations = new Convocations();
}

if (isset($inst_convocations))
{
	require_once (ABSPATH.'wp-content/plugins/convocations/front/display_html.php');
	require_once (ABSPATH.'wp-content/plugins/convocations/admin/convocations_panel.php');
	require_once (ABSPATH.'wp-content/plugins/convocations/admin/equipes_panel.php');
	require_once (ABSPATH.'wp-content/plugins/convocations/admin/joueurs_panel.php');
	
	register_activation_hook( __FILE__, array( &$inst_convocations, 'activation' ) );
	
	if( is_admin() )
	{		
		// Enregistrement du menu dans l'administration
		add_action( 'admin_menu', array( &$inst_convocations,'adminMenu' ) );
		// Ajout des scripts
		add_action( 'admin_init', array( &$inst_convocations,'addScripts' ) );
		add_action( 'admin_footer', array( &$inst_convocations,'adminFooter' ) );
	}
}

?>