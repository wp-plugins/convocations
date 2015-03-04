<?php
if( ! class_exists( 'Convocations' ) ) {
	
	class Convocations {
		
		private $obj_convocation_controller;
		private $obj_joueur_controller;
		private $convocations_db_version;
		
		public function __construct() {
			load_plugin_textdomain( 'convocations', false, CONVOCATIONS_PATH .'languages/' );
			
			// Includes
			require_once( CONVOCATIONS_APP_PATH.'controller/controller-convocation.php' );
			require_once( CONVOCATIONS_APP_PATH.'controller/controller-equipe.php' );
			require_once( CONVOCATIONS_APP_PATH.'controller/controller-joueur.php' );
			
			// Define table name
			global $wpdb;
			define( 'CONVOCATIONS_TBL_CONVOCATIONS',	$wpdb->prefix . 'convocations' );
			define( 'CONVOCATIONS_TBL_TEAMS',			$wpdb->prefix . 'convocations_equipes' );
			define( 'CONVOCATIONS_TBL_PLAYERS',			$wpdb->prefix . 'convocations_joueurs' );
			
			if( is_admin() ){
				// Check for database update
				add_action( 'plugins_loaded', array( &$this, 'check_db_update' ) );
				
				// Add some js
				add_action( 'admin_init', array( &$this,'add_scripts' ) );
				
				// Add the administration menu
				add_action( 'admin_menu', array( &$this,'admin_menu_convocations' ) );
			}
			
			// Add some js in front
			add_action( 'wp_head', array( &$this, 'add_scripts' ) );
			
			// Add a shortcode to display Convocations in front-end
			add_shortcode( 'convocations', array( &$this, 'add_shortcode' ) );
			
			// Init objects
			$this->obj_convocation_controller = new Convocation_Controller();
			$this->obj_equipe_controller = new Equipe_Controller();
			$this->obj_joueur_controller = new Joueur_Controller();
			$this->convocations_db_version = '0.2';
		}
		
		/* INSTALL */
		
		public function activation() {
			$this->install_db();
			$this->set_capabilities();
		}
		
		public function install_db() {
			global $wpdb;
			$sql = '';
			$sql .= "CREATE TABLE ". CONVOCATIONS_TBL_CONVOCATIONS ." (";
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
			
			$sql .= "CREATE TABLE ". CONVOCATIONS_TBL_TEAMS ." (";
			$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,";
			$sql .= "`nom` text NOT NULL,";
			$sql .= "`responsable` text NOT NULL,";
			$sql .= "`telephone` text NOT NULL,";
			$sql .= "`entrainement` text NOT NULL,";
			$sql .= "PRIMARY KEY (`id`))";
			$sql .= "ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			
			$sql .= "CREATE TABLE ". CONVOCATIONS_TBL_PLAYERS ." (";
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
		
		public function set_capabilities() {
			// Add a capability for Administrator to managing Convocations
			$role = get_role( 'administrator' );
			$role->add_cap( 'manage_convocations' );
			
			// Add a role and a capability for managing Convocations
			add_role( 
				'responsable_equipe', __('Responsable d\'équipe', 'manage_convocations'),
				array(
					'read'                => 1,
					'manage_convocations' => 1
			));
		}
		
		/* UPDATE */
		
		public function update_db() {
			// Version 0.3
			// TO DO
		}
		
		public function check_db_update() {
			if( get_site_option( 'convocations_db_version' ) != $this->convocations_db_version ){
				$this->update_db();
				add_option( 'convocations_db_version', $this->convocations_db_version );
			}
		}
		
		/* INIT */
		
		public function add_scripts() {
			// JS
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core', array( 'jquery' ) );
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery', 'jquery-ui-core' ) );
			wp_register_script( 'convocations', CONVOCATIONS_LIBS_URL . 'js/convocations.js' );
			wp_enqueue_script( 'convocations' );
			
			// CSS
			wp_enqueue_style( 'jquery.ui.theme', CONVOCATIONS_LIBS_URL . '/css/jquery-ui-1.8.23.custom.css' );
		}
		
		public function admin_menu_convocations() {
			add_menu_page( __( 'Convocations', 'convocations' ), __( 'Convocations', 'convocations' ), 'manage_convocations', CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', array( &$this->obj_convocation_controller, 'render_admin_view' ), CONVOCATIONS_URL . 'images/convocations.png', 21);
			add_submenu_page( CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', __( 'Toutes les convocations', 'convocations' ), __( 'Toutes les convocations', 'convocations' ), 'manage_convocations',  CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', array( &$this->obj_convocation_controller, 'render_admin_view' ) );
			add_submenu_page( CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', __( 'Equipes', 'convocations' ), __( 'Equipes', 'convocations' ), 'manage_convocations',  CONVOCATIONS_APP_PATH.'controller/controller-equipe.php', array( &$this->obj_equipe_controller, 'render' ) );
			add_submenu_page( CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', __( 'Joueurs', 'convocations' ), __( 'Joueurs', 'convocations' ), 'manage_convocations',  CONVOCATIONS_APP_PATH.'controller/controller-joueur.php', array( &$this->obj_joueur_controller, 'render_admin_view' ) );
			// add_submenu_page(__FILE__ , 'Gestion des équipes', 'Gestion des équipes', 'manage_convocations', 'admin-equipes', 'admin_equipes_panel');
			// add_submenu_page(__FILE__ , 'Gestion des joueurs', 'Gestion des joueurs', 'manage_convocations', 'admin-joueurs', 'admin_joueurs_panel');
		}
		
		// public function ajax_convocations() {
			
			// global $wpdb;
				
			// $tablename = $wpdb->prefix . 'convocations_joueurs';
			// $tablename2 = $wpdb->prefix . 'convocations';
			// $sql_joueurs = $wpdb->prepare(
										// '
										// SELECT * 
										// FROM ' .$tablename. ' 
										// INNER JOIN '. $tablename2 .' ON '. $tablename2 .'.id = ' .$tablename. '.numconvocation 
										// WHERE ' .$tablename. '.numconvocation = %d 
										// ORDER BY ' .$tablename. '.nom ASC
										// ',
										// array( $_POST['lequipe'] )
								// );
				
			// $joueurs = $wpdb->get_results($sql_joueurs);
			
			// $html = '';
			
			// if( count( $joueurs ) != 0 ){
				// setlocale(LC_TIME, "fr_FR", "fr_FR@euro", "fr", "FR", "fra_fra", "fra");
				// $html .= '<h2>'. $joueurs[0]->equipe .' - Match contre '. $joueurs[0]->equipadv .'</h2>';
				// $html .= '<p>';
				// $html .= 'Les joueurs de l\'équipe sont convoqués le ';
				// $html .= '<strong>'. utf8_encode(strftime("%A %d %B %Y", strtotime($joueurs[0]->date))) .'</strong> ';
				// $html .= 'à <strong>'. $joueurs[0]->heurerdv .'</strong><br /> ';
				// $html .= 'Le lieu du rendez-vous est : '. $joueurs[0]->lieurdv .'<br />';
				// $html .= 'Le match débutera à '. $joueurs[0]->heurematch .'';
				// $html .= '</p>';
				// $html .= '<h3>Liste des joueurs convoqués :</h3>';
				// $html .= '<p>';
			
				// foreach ( $joueurs as $joueur ) {
					// $html .= $joueur->nom .' '. ucfirst(strtolower($joueur->prenom)) .'<br>';
				// }
				
				// $html .= '</p>';
				
				// echo $html;
			// }
			// else {
				// $html .= '<p>Aucun joueur n\'a été affecté à ce match pour le moment</p>';
				// echo $html;
			// }
			// die();
		// }
		
		// public function add_shortcode() {
			// return displayConvocations();
		// }
		
		// public function insert_equipe( $nom, $responsable, $telephone, $entrainement ){
			// $insert = $this->inst_equipe->insert_equipe( $nom, $responsable, $telephone, $entrainement );
			// return $insert;
		// }
		
		// public function update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement ){
			// $this->inst_equipe->update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement );
		// }
		
		// public function delete_equipe( $id ){
			// $this->inst_equipe->delete_equipe( $id );
		// }
		
		// public function get_equipe( $the_equipe_id ){
			// $equipe = $this->inst_equipe->get_equipe( $the_equipe_id );
			// return $equipe;
		// }
		
		// public function get_all_equipes(){
			// $all_equipes = $this->inst_equipe->get_all_equipes();
			// return $all_equipes;
		// }
	}
}
if ( class_exists( 'Convocations' ) ){
	$inst_convocations = new Convocations();
	register_activation_hook( __FILE__, array( &$inst_convocations, 'activation' ) );
	register_deactivation_hook( __FILE__, array( &$inst_convocations, 'deactivation' ) );
}