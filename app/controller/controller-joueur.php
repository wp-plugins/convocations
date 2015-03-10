<?php
if( ! class_exists( 'Joueur_Controller' ) ) {
	
	/**
	 * Controller for class Joueur_Manager and Joueur
	 */
	class Joueur_Controller {
		
		/**
		 * Instance of class Joueur_Manager
		 */
		private $_obj_joueur_manager;
		
		/**
		 * Instance of class Joueur
		 */
		private $_obj_equipes_manager;
		
		/**
		 * Constructor
		 */
		public function __construct() {
			require_once( CONVOCATIONS_APP_PATH.'class/class-joueur.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-joueur-manager.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-equipe-manager.php' );
			
			$this->_obj_joueur_manager = new Joueur_Manager();
			$this->_obj_equipes_manager = new Equipe_Manager();
			
			add_action( 'admin_post_new_joueur', array( &$this, 'admin_new_joueur' ) );
			add_action( 'admin_post_edit_joueur', array( &$this, 'admin_edit_joueur' ) );
			add_action( 'admin_post_filtrer', array( &$this, 'admin_filtrer' ) );
		}
		
		/**
		 * Dispatches the display according to the request
		 */
		public function render() {
			// Add a player
			if( isset( $_GET['action'] ) && 'new' == $_GET['action'] ) {
				$this->render_admin_new_view();
			}
			// Edit an existing player
			elseif( isset( $_GET['action'] ) && 'edit' == $_GET['action'] ) {
				$this->render_admin_edit_view();
			}
			// Delete a player
			elseif( isset( $_GET['action'] ) && 'delete' == $_GET['action'] ) {
				$joueur = $this->_obj_joueur_manager->get_joueur( intval( $_GET['id'] ) ) ;
				$this->_obj_joueur_manager->delete( $joueur );
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-joueur.php',
							'deleted'	=>	1
						),
						admin_url( 'admin.php' )
					)
				);
			}
			// Listing of all players
			else {
				$this->render_admin_view();
			}
		}
		
		/**
		 * Panel to list all players in the administration
		 */
		public function render_admin_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-joueur.php' );
			if( isset( $_GET['filtre-equipe'] ) && !empty( $_GET['filtre-equipe'] ) && 'toutes' != $_GET['filtre-equipe'] ){
				$joueurs = $this->_obj_joueur_manager->get_joueurs_by_equipe( $_GET['filtre-equipe'] );
			} else {
				$joueurs = $this->_obj_joueur_manager->get_joueurs();
			}
			Joueur_Admin_View::render( $this->_obj_equipes_manager->get_equipes(), $joueurs );
		}
		
		/**
		 * Panel to add a player
		 */
		public function render_admin_new_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-new-joueur.php' );
			Joueur_Admin_New_View::render( $this->_obj_equipes_manager->get_equipes() );
		}
		
		/**
		 * Panel to edit a player
		 */
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-edit-joueur.php' );
			Joueur_Admin_Edit_View::render( $this->_obj_joueur_manager->get_joueur( intval( $_GET['id'] ) ), $this->_obj_equipes_manager->get_equipes() );
		}
		
		/**
		 * Callback function to filter teams
		 */
		public function admin_filtrer() {
			if( isset( $_GET['filtre-equipe'] ) && !empty( $_GET['filtre-equipe'] ) ){
				wp_redirect(
					add_query_arg(
						array(
							'page'			=>	'convocations/app/controller/controller-joueur.php',
							'filtre-equipe'	=>	str_replace(" ", "+", $_GET['filtre-equipe'])
						),
						admin_url( 'admin.php' )
					)
				);
			} else {
				wp_redirect(
					add_query_arg(
						array(
							'page'	=>	'convocations/app/controller/controller-joueur.php'
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		/**
		 * Callback function to add a player in the database
		 */
		public function admin_new_joueur() {
			$error = array();
			$args = array();
			$return = false;
			
			foreach( $_POST as $key => $value ) {
				switch( $key ){
					case 'nom':
						if( isset( $_POST['nom'] ) && '' != $_POST['nom'] ) {
							$args['nom'] = $_POST['nom'];
						}
						else {
							$error['nom'] = __( 'Name missing', 'convocations' );
						}
						break;
					case 'prenom':
						if( isset( $_POST['prenom'] ) && '' != $_POST['prenom'] ) {
							$args['prenom'] = $_POST['prenom'];
						}
						else {
							$error['prenom'] = __( 'Firstname missing', 'convocations' );
						}
						break;
					case 'poste':
						if( isset( $_POST['poste'] ) && '' != $_POST['poste'] ) {
							$args['poste'] = $_POST['poste'];
						}
						break;
					case 'equipe':
						if( isset( $_POST['equipe'] ) && '' != $_POST['equipe'] ) {
							$args['equipe'] = $_POST['equipe'];
						}
						break;
				}
			}
			
			if( empty( $error ) ) {
				$joueur = new Joueur( $args );
				$return = $this->_obj_joueur_manager->insert( $joueur );
				if( $return != false ) {
					wp_redirect(
						add_query_arg(
							array(
								'page'		=>	'convocations/app/controller/controller-joueur.php',
								'id'		=>	intval( $return ),
								'action'	=>	'edit',
								'message'	=>	1
							),
							admin_url( 'admin.php' )
						)
					);
				}
			}
			else {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-joueur.php',
							'action'	=>	'new',
							'message'	=>	2
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		/**
		 * Callback function to edit a player from the database
		 */
		public function admin_edit_joueur() {
			$error = array();
			$args = array();
			
			foreach( $_POST as $key => $value ) {
				switch( $key ){
					case 'id':
						if( isset( $_POST['id'] ) && '' != $_POST['id'] ) {
							$args['id'] = $_POST['id'];
						}
						else {
							$error['id'] = __( 'ID missing', 'convocations' );
						}
						break;
					case 'nom':
						if( isset( $_POST['nom'] ) && '' != $_POST['nom'] ) {
							$args['nom'] = $_POST['nom'];
						}
						else {
							$error['nom'] = __( 'Name missing', 'convocations' );
						}
						break;
					case 'prenom':
						if( isset( $_POST['prenom'] ) && '' != $_POST['prenom'] ) {
							$args['prenom'] = $_POST['prenom'];
						}
						else {
							$error['prenom'] = __( 'Firstname missing', 'convocations' );
						}
						break;
					case 'poste':
						if( isset( $_POST['poste'] ) && '' != $_POST['poste'] ) {
							$args['poste'] = $_POST['poste'];
						}
						break;
					case 'equipe':
						if( isset( $_POST['equipe'] ) && '' != $_POST['equipe'] ) {
							$args['equipe'] = $_POST['equipe'];
						}
						break;
				}
			}
			
			if( empty( $error ) ) {
				$joueur = new Joueur( $args );
				$return = $this->_obj_joueur_manager->update( $joueur );
				$message = 1;
			}
			else {
				$message = 2;
			}
			
			if( form_is_validated ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-joueur.php',
							'id'		=>	intval( $_POST['id'] ),
							'action'	=>	'edit',
							'message'	=>	$message
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
	}

}