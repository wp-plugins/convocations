<?php
/*
Plugin Name: Convocations
Plugin URI: http://wordpress.org/extend/plugins/convocations/
Description: Convocations plugin is for sports associations such as football clubs, handball clubs, basket-ball clubs, ... which allows you to manage the notifications of your teams and of your players to matches.
Version: 0.3
Author: JC
Author URI: http://www.breizh-seo.com/
*/

if(!class_exists( 'Convocations' )){
	class Convocations{
		private $inst_equipe;
		private $inst_joueur;
		private $convocations_db_version;
		
		function __construct()
		{
			// Define the function for activation and deactivation
			register_activation_hook( __FILE__, array( &$this, 'install' ) );
			register_deactivation_hook( __FILE__, array( &$this, 'deactivation' ) );
			
			// Define the path of plugin
			define('CONVOCATIONS_VERSION', '0.3');
			define('CONVOCATIONS_FILE', basename(__FILE__));
			define('CONVOCATIONS_PATH', plugin_dir_path(__FILE__));
			define('CONVOCATIONS_URL', plugin_dir_url( __FILE__ ));
			
			require_once (CONVOCATIONS_PATH.'includes/convocations_panel.inc.php');
			require_once (CONVOCATIONS_PATH.'includes/equipes_panel.inc.php');
			require_once (CONVOCATIONS_PATH.'includes/joueurs_panel.inc.php');
			require_once (CONVOCATIONS_PATH.'class/ConvocationsEquipe.class.php');
			require_once (CONVOCATIONS_PATH.'class/ConvocationsJoueur.class.php');
			require_once (CONVOCATIONS_PATH.'front/display_html.php');
			
			$this->inst_equipe = ConvocationsEquipe::get_instance();
			$this->inst_joueur = ConvocationsJoueur::get_instance();
			$this->convocations_db_version = 0.1;
		}
		
		function install(){
			$this->install_db();
		}
		
		function deactivation(){
		}
		
		function install_db(){
			global $wpdb;
			$sql = '';
			$table_name = $wpdb->prefix . 'convocations';
			$sql .= "CREATE TABLE `$table_name` (";
			$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,";
			$sql .= "`equipe` text NOT NULL,";
			$sql .= "`equipadv` text NOT NULL,";
			$sql .= "`date` date NOT NULL,";
			$sql .= "`domext` text NOT NULL,";
			$sql .= "`lieurdv` text NOT NULL,";
			$sql .= "`heurerdv` text NOT NULL,";
			$sql .= "`heurematch` text NOT NULL,";
			$sql .= "PRIMARY KEY (`id`))";
			$sql .= "ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			
			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql .= "CREATE TABLE `$table_name` (";
			$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,";
			$sql .= "`nom` text NOT NULL,";
			$sql .= "`responsable` text NOT NULL,";
			$sql .= "`telephone` text NOT NULL,";
			$sql .= "`entrainement` text NOT NULL,";
			$sql .= "PRIMARY KEY (`id`))";
			$sql .= "ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$sql .= "CREATE TABLE `$table_name` (";
			$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,";
			$sql .= "`nom` text NOT NULL,";
			$sql .= "`prenom` text NOT NULL,";
			$sql .= "`poste` text NOT NULL,";
			$sql .= "`equipe` text NOT NULL,";
			$sql .= "`etat` int(11) NOT NULL,";
			$sql .= "`numconvocation` int(11) NOT NULL,";
			$sql .= "PRIMARY KEY (`id`))";
			$sql .= "ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			update_option( 'convocations_db_version', $this->convocations_db_version );
		}
		
		function init()
		{
			if( is_admin() ){
				// Check for database update
				add_action( 'plugins_loaded', array( &$this, 'check_db_update' ) );
				
				// Add some js
				add_action( 'admin_init', array( &$this,'add_scripts' ) );
				
				// Add the administration menu
				add_action( 'admin_menu', array( &$this,'admin_menu_convocations' ) );
				
				// Add some code on the administration footer
				add_action( 'admin_footer', array( &$this,'admin_footer' ) );
			}
			
			// Add a shortcode to display Convocations in front-end
			add_shortcode( 'convocations', array( &$this,'add_shortcode' ) );
		}
		
		function add_scripts()
		{
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery', 'jquery-ui-core' ) );
			
			wp_enqueue_style( 'jquery.ui.theme', CONVOCATIONS_URL . '/css/jquery-ui-1.8.23.custom.css' );
		}
		
		function admin_menu_convocations(){
			add_menu_page('Convocations', 'Convocations', 'manage_options', __FILE__, 'admin_convocations_panel', CONVOCATIONS_URL . '/images/convocations.png', 21);
			add_submenu_page(__FILE__ , 'Gestion des équipes', 'Gestion des équipes', 'manage_options', 'admin-equipes', 'admin_equipes_panel');
			add_submenu_page(__FILE__ , 'Gestion des joueurs', 'Gestion des joueurs', 'manage_options', 'admin-joueurs', 'admin_joueurs_panel');
		}
		
		function admin_footer()
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
		
		function add_shortcode(){
			return displayConvocations();
		}
		
		function check_db_update(){
			if( get_site_option( 'convocations_db_version' ) != $this->convocations_db_version ){
				$this->install_db();
			}
		}
		
		function insert_convocation( $nom ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations';
			$wpdb->insert(
				$table_name,
				array(
						'equipe' 	=> $nom,
						'date' 		=> date_i18n('Y-m-d')
				)
			);
		}
		
		function update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations';
			$wpdb->update(
				$table_name,
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
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$wpdb->update(
				$table_name,
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
						$table_name,
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
		
		function delete_convocation( $the_equipe ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . $table_name . ' 
								WHERE equipe = %s
								',
								$the_equipe
					);
			$wpdb->query($sql);
		}
		
		function get_convocation( $the_convocation ){
			global $wpdb;
			$table_name = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $table_name . ' 
								WHERE id = %d
								',
								$the_convocation
					);
			
			$convocation = $wpdb->get_results($sql);
			
			return $convocation;
		}
		
		function get_all_convocations(){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' ORDER BY equipe ASC');
			$all_convocations = $wpdb->get_results($sql);
			
			return $all_convocations;
		}
		
		function insert_equipe( $nom, $responsable, $telephone, $entrainement ){
			$insert = $this->inst_equipe->insert_equipe( $nom, $responsable, $telephone, $entrainement );
			return $insert;
		}
		
		function update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement ){
			$this->inst_equipe->update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement );
		}
		
		function delete_equipe( $id ){
			$this->inst_equipe->delete_equipe( $id );
		}
		
		function get_equipe( $the_equipe_id ){
			$equipe = $this->inst_equipe->get_equipe( $the_equipe_id );
			return $equipe;
		}
		
		function get_all_equipes(){
			$all_equipes = $this->inst_equipe->get_all_equipes();
			return $all_equipes;
		}
		
		function insert_joueur( $nom, $prenom, $poste, $equipe ){
			$insert = $this->inst_joueur->insert_joueur( $nom, $prenom, $poste, $equipe );
			return $insert;
		}
		
		function update_joueur( $id, $nom, $prenom, $poste, $equipe ){
			$this->inst_joueur->update_joueur( $id, $nom, $prenom, $poste, $equipe );
		}
		
		function delete_joueur( $the_joueur_id ){
			$this->inst_joueur->delete_joueur( $the_joueur_id );
		}
		
		function get_joueur(){
			$this->inst_joueur->get_joueur();
		}
		
		function get_joueurs_by_equipe( $the_equipe ){
			$joueurs_by_equipe = $this->inst_joueur->get_joueurs_by_equipe( $the_equipe );
			return $joueurs_by_equipe;
		}
		
		function get_all_joueurs(){
			$all_joueurs = $this->inst_joueur->get_all_joueurs();
			return $all_joueurs;
		}
	}
}
if ( class_exists( 'Convocations' ) ){
	$inst_convocations = new Convocations();
	$inst_convocations->init();
}
?>