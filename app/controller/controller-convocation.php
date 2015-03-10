<?php
if( ! class_exists( 'Convocation_Controller' ) ) {
	
	/**
	 * Controller for the class Convocation
	 */
	class Convocation_Controller {
		
		/**
		 * Instance of class Convocation
		 */
		private $_obj_convocation_manager;
		
		/**
		 * Instance of class Joueur
		 */
		private $_obj_joueur_manager;
		
		/**
		 * Constructor
		 */
		public function __construct() {
			$this->_obj_convocation_manager = new Convocation_Manager();
			$this->_obj_joueur_manager = new Joueur_Manager();
			
			add_action( 'admin_post_edit_convocation', array( &$this, 'admin_edit_convocation' ) );
		}
		
		/**
		 * Main function to display Convocations Panel in the administration
		 */
		public function render() {
			if( isset( $_GET['action'] ) && 'edit' == $_GET['action'] && isset( $_GET['id'] ) ) {
				$this->render_admin_edit_view();
			}
			else {
				$this->render_admin_view();
			}
		}
		
		/**
		 * Display the list of convocations in the adminstration
		 */
		public function render_admin_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/convocation/view-admin-convocation.php' );
			Convocation_Admin_View::render( $this->_obj_convocation_manager->get_convocations() );
		}
		
		/**
		 * Display the panel to edit a convocation in the administration
		 */
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/convocation/view-admin-edit-convocation.php' );
			Convocation_Admin_Edit_View::render( $this->_obj_convocation_manager->get_convocation( intval( $_GET['id'] ) ), $this->_obj_joueur_manager->get_joueurs() );
		}
		
		/**
		 * Callback function when a convocation is edit
		 */
		public function admin_edit_convocation() {
			$error = array();
			$args = array();
			$args2 = array();
			
			foreach( $_POST as $key => $value ) {
				switch( $key ){
					case 'id':
						if( isset( $_POST['id'] ) && '' != $_POST['id'] ) {
							$args['id'] = $_POST['id'];
							$numconvocation = $_POST['id'];
						}
						else {
							$error['id'] = __( 'ID missing', 'convocations' );
						}
						break;
					case 'equipadv':
						if( isset( $_POST['equipadv'] ) && '' != $_POST['equipadv'] ) {
							$args['equipadv'] = $_POST['equipadv'];
						}
						break;
					case 'date':
						if( isset( $_POST['date'] ) && '' != $_POST['date'] ) {
							$args['date'] = $_POST['date'];
						}
						else {
							$error['date'] = __( 'Date missing', 'convocations' );
						}
						break;
					case 'domext':
						if( isset( $_POST['domext'] ) && '' != $_POST['domext'] ) {
							$args['domext'] = $_POST['domext'];
						}
						break;
					case 'lieurdv':
						if( isset( $_POST['lieurdv'] ) && '' != $_POST['lieurdv'] ) {
							$args['lieurdv'] = $_POST['lieurdv'];
						}
						break;
					case 'heurerdv':
						if( isset( $_POST['heurerdv'] ) && '' != $_POST['heurerdv'] ) {
							$args['heurerdv'] = $_POST['heurerdv'];
						}
						break;
					case 'heurematch':
						if( isset( $_POST['heurematch'] ) && '' != $_POST['heurematch'] ) {
							$args['heurematch'] = $_POST['heurematch'];
						}
						break;
					case 'selectionnes':
						if( isset( $_POST['selectionnes'] ) ) {
							$arr_joueurs = $_POST['selectionnes'];
						}
						break;
				}
			}
			
			if( empty( $error ) ) {
				// Update convocation
				$convocation = new Convocation( $args );
				$return = $this->_obj_convocation_manager->update( $convocation );
				
				// Remove players from convocation
				$joueurs = $this->_obj_joueur_manager->get_joueurs_by_numconvocation( $numconvocation );
				if( !empty( $joueurs ) ){
					foreach( $joueurs as $joueur ) {
						$joueur = $this->_obj_joueur_manager->get_joueur( $joueur->get_id() );
						$joueur->set_numconvocation( 0 );
						$this->_obj_joueur_manager->update( $joueur );
					}
				}
				
				// Add players to the convocation
				if( !empty( $arr_joueurs ) ) {
					foreach( $arr_joueurs as $id_joueur ){
						$joueur = $this->_obj_joueur_manager->get_joueur( $id_joueur );
						$joueur->set_numconvocation( $numconvocation );
						$this->_obj_joueur_manager->update( $joueur );
					}
				}
				$message = 1;
			}
			else {
				$message = 2;
			}
			
			if( $return >= 0 ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-convocation.php',
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