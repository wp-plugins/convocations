<?php
if( ! class_exists( 'Equipe_Controller' ) ) {
	
	class Equipe_Controller {
		
		private $obj_convocations;
		private $obj_equipes;
		
		public function __construct() {
			require_once( CONVOCATIONS_APP_PATH.'class/class-convocation.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-equipe.php' );
			
			$this->obj_convocations = new Convocation();
			$this->obj_equipes = new Equipe();
			
			add_action( 'admin_post_new_equipe', array( &$this, 'admin_new_equipe' ) );
			add_action( 'admin_post_edit_equipe', array( &$this, 'admin_edit_equipe' ) );
		}
		
		public function render() {
			if( isset( $_GET['action'] ) && $_GET['action'] == 'new' ) {
				$this->render_admin_new_view();
			}
			elseif( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
				$this->render_admin_edit_view();
			}
			elseif( isset( $_GET['action'] ) && $_GET['action'] == 'delete' ) {
				$this->obj_equipes->delete_equipe( $_GET['id'] );
				$this->obj_convocations->delete_convocation( $_GET['equipe'] );
				$this->render_admin_view();
			}
			else {
				$this->render_admin_view();
			}
		}
		
		public function render_admin_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/equipe/view-admin-equipe.php' );
			Equipe_Admin_View::render( $this->obj_equipes->get_all_equipes() );
		}
		public function render_admin_new_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/equipe/view-admin-new-equipe.php' );
			Equipe_Admin_New_View::render();
		}
		
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/equipe/view-admin-edit-equipe.php' );
			Equipe_Admin_Edit_View::render( $this->obj_equipes->get_equipe( $_GET['id'] ) );
		}
		
		public function admin_filtrer() {
			
		}
		
		public function admin_new_equipe() {
			$nom = $_POST['nom'];
			$responsable = $_POST['responsable'];
			$telephone = $_POST['telephone'];
			$entrainement = $_POST['entrainement'];
			
			$insert_id = $this->obj_equipes->insert_equipe( $nom, $responsable, $telephone, $entrainement);
			
			if( false != $insert_id ) {
				$this->obj_convocations->insert_convocation( $nom );
			}
			
			if( form_is_validated ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-equipe.php',
							'id'		=>	intval( $insert_id ),
							'action'	=>	'edit',
							'message'	=>	'1'
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		public function admin_edit_equipe() {
			$id = $_POST['id'];
			$nom = $_POST['nom'];
			$responsable = $_POST['responsable'];
			$telephone = $_POST['telephone'];
			$entrainement = $_POST['entrainement'];
			$old_name = $_POST['old_name'];
			
			$this->obj_equipes->update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement );
			
			if( form_is_validated ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-equipe.php',
							'id'		=>	intval( $_POST['id'] ),
							'action'	=>	'edit',
							'message'	=>	'1'
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
	}

}