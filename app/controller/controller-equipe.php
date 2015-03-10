<?php
if( ! class_exists( 'Equipe_Controller' ) ) {
	
	class Equipe_Controller {
		
		private $_obj_equipe_manager;
		private $_obj_convocation_manager;
		
		public function __construct() {
			require_once( CONVOCATIONS_APP_PATH.'class/class-equipe.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-equipe-manager.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-convocation-manager.php' );
			
			$this->_obj_equipe_manager = new Equipe_Manager();
			$this->_obj_convocation_manager = new Convocation_Manager();
			
			add_action(	'admin_post_new_equipe',	array( &$this, 'admin_new_equipe' ) );
			add_action(	'admin_post_edit_equipe',	array( &$this, 'admin_edit_equipe' ) );
		}
		
		public function render() {
			if( isset( $_GET['action'] ) && 'new' == $_GET['action'] ) {
				$this->render_admin_new_view();
			}
			elseif( isset( $_GET['action'] ) && 'edit' == $_GET['action'] ) {
				$this->render_admin_edit_view();
			}
			elseif( isset( $_GET['action'] ) && $_GET['action'] == 'delete' ) {
				// Delete the team
				$equipe = $this->_obj_equipe_manager->get_equipe( intval( $_GET['id'] ) );
				$this->_obj_equipe_manager->delete( $equipe );
				
				// Delete the convocation corresponding to this team
				$convocation = $this->_obj_convocation_manager->get_convocation_by_equipe( $_GET['equipe'] );
				$this->_obj_convocation_manager->delete( $convocation );
				
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-equipe.php',
							'deleted'	=>	1
						),
						admin_url( 'admin.php' )
					)
				);
			}
			else {
				$this->render_admin_view();
			}
		}
		
		public function render_admin_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/equipe/view-admin-equipe.php' );
			Equipe_Admin_View::render( $this->_obj_equipe_manager->get_equipes() );
		}
		
		public function render_admin_new_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/equipe/view-admin-new-equipe.php' );
			Equipe_Admin_New_View::render();
		}
		
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/equipe/view-admin-edit-equipe.php' );
			Equipe_Admin_Edit_View::render( $this->_obj_equipe_manager->get_equipe( $_GET['id'] ) );
		}
		
		public function admin_filtrer() {
			
		}
		
		public function admin_new_equipe() {
			$error = array();
			$args = array();
			$args2 = array();
			
			foreach( $_POST as $key => $value ) {
				switch( $key ){
					case 'nom':
						if( isset( $_POST['nom'] ) && '' != $_POST['nom'] ) {
							$args['nom'] = $_POST['nom'];
							$args2['equipe'] = $_POST['nom'];
						}
						else {
							$error['nom'] = __( 'Name missing', 'convocations' );
						}
						break;
					case 'responsable':
						if( isset( $_POST['responsable'] ) && '' != $_POST['responsable'] ) {
							$args['responsable'] = $_POST['responsable'];
						}
						break;
					case 'telephone':
						if( isset( $_POST['telephone'] ) && '' != $_POST['telephone'] ) {
							$args['telephone'] = $_POST['telephone'];
						}
						break;
					case 'entrainement':
						if( isset( $_POST['entrainement'] ) && '' != $_POST['entrainement'] ) {
							$args['entrainement'] = $_POST['entrainement'];
						}
						break;
				}
			}
			
			if( empty( $error ) ) {
				$equipe = new Equipe( $args );
				$return = $this->_obj_equipe_manager->insert( $equipe );
				$convocation = new Convocation( $args2 );
				$this->_obj_convocation_manager->insert( $convocation );
				$message = 1;
			}
			else {
				$message = 2;
			}
			
			if( form_is_validated ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-equipe.php',
							'id'		=>	intval( $return ),
							'action'	=>	'edit',
							'message'	=>	$message
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		public function admin_edit_equipe() {
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
					case 'responsable':
						if( isset( $_POST['responsable'] ) && '' != $_POST['responsable'] ) {
							$args['responsable'] = $_POST['responsable'];
						}
						break;
					case 'telephone':
						if( isset( $_POST['telephone'] ) && '' != $_POST['telephone'] ) {
							$args['telephone'] = $_POST['telephone'];
						}
						break;
					case 'entrainement':
						if( isset( $_POST['entrainement'] ) && '' != $_POST['entrainement'] ) {
							$args['entrainement'] = $_POST['entrainement'];
						}
						break;
				}
			}
			
			if( empty( $error ) ) {
				$equipe = new Equipe( $args );
				$return = $this->_obj_equipe_manager->update( $equipe );
				$message = 1;
			}
			else {
				$message = 2;
			}
			
			if( form_is_validated ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-equipe.php',
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