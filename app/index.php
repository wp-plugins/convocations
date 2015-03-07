<?php
if( ! class_exists( 'Convocations' ) ) {
	
	class Convocations {
		
		private $obj_convocation_controller;
		private $obj_joueur_controller;
		private $convocations_db_version;
		
		public function __construct() {
			load_plugin_textdomain( 'convocations', false, CONVOCATIONS_DIR .'/languages/' );
			
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
			add_action( 'wp_head',array( &$this, 'pluginname_ajaxurl' ) );
			
			// Add a shortcode to display Convocations in front-end
			add_shortcode( 'convocations', array( &$this, 'add_shortcode' ) );
			
			add_action( 'wp_ajax_displayNext', array( &$this, 'display_next' ) );
			add_action( 'wp_ajax_nopriv_displayNext', array( &$this, 'display_next' ) );
			
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
				'responsable_equipe', __('Team manager', 'convocations'),
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
		
		public function pluginname_ajaxurl() {
			?>
			<script type="text/javascript">
				var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			</script>
			<?php
		}
		
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
			add_submenu_page( CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', __( 'All convocations', 'convocations' ), __( 'All convocations', 'convocations' ), 'manage_convocations',  CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', array( &$this->obj_convocation_controller, 'render_admin_view' ) );
			add_submenu_page( CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', __( 'Teams', 'convocations' ), __( 'Teams', 'convocations' ), 'manage_convocations',  CONVOCATIONS_APP_PATH.'controller/controller-equipe.php', array( &$this->obj_equipe_controller, 'render' ) );
			add_submenu_page( CONVOCATIONS_APP_PATH.'controller/controller-convocation.php', __( 'Players', 'convocations' ), __( 'Players', 'convocations' ), 'manage_convocations',  CONVOCATIONS_APP_PATH.'controller/controller-joueur.php', array( &$this->obj_joueur_controller, 'render' ) );
		}
		
		public function add_shortcode() {
			require_once( CONVOCATIONS_APP_PATH . 'view/front/display_html.php' );
			return displayConvocations( $this->obj_convocation_controller->get_all_convocations() );
		}
		
		public function display_next() {
			$convocation = $this->obj_convocation_controller->get_convocation($_POST['value']);
			$joueurs = $this->obj_joueur_controller->get_joueurs_by_equipe($convocation->equipe);
			
			$html = '';
			
			if( count( $joueurs ) != 0 ){
				setlocale(LC_TIME, "fr_FR", "fr_FR@euro", "fr", "FR", "fra_fra", "fra");
				$html .= '<h2>'. $convocation->equipe .' - Match contre '. $convocation->equipadv .'</h2>';
				$html .= '<p>';
				$html .= 'Les joueurs de l\'équipe sont convoqués le ';
				$html .= '<strong>'. utf8_encode(strftime("%A %d %B %Y", strtotime($convocation->date))) .'</strong> ';
				$html .= 'à <strong>'. $convocation->heurerdv .'</strong><br /> ';
				$html .= 'Le lieu du rendez-vous est : '. $convocation->lieurdv .'<br />';
				$html .= 'Le match débutera à '. $convocation->heurematch .'';
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
	}
}
if ( class_exists( 'Convocations' ) ){
	$inst_convocations = new Convocations();
	register_activation_hook( __FILE__, array( &$inst_convocations, 'activation' ) );
	register_deactivation_hook( __FILE__, array( &$inst_convocations, 'deactivation' ) );
}