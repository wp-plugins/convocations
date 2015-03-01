<?php
if( ! class_exists( 'Convocation_Controller' ) ) {
	
	class Convocation_Controller {
		
		private $obj_convocations;
		private $obj_joueurs;
		
		public function __construct() {
			require_once( CONVOCATIONS_APP_PATH.'class/class-convocation.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-joueur.php' );
			
			$this->obj_convocations = new Convocation();
			$this->obj_joueurs = new Joueur();
			
			add_action( 'admin_post_edit_convocation', array( &$this, 'admin_edit_convocation' ) );
		}
		
		public function render_admin_view() {
			if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
				$this->render_admin_edit_view();
			}
			else {
				require_once( CONVOCATIONS_APP_PATH.'view/admin/convocation/view-admin-convocation.php' );
				Convocation_Admin_View::render( $this->get_all_convocations() );
			}
		}
		
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/convocation/view-admin-edit-convocation.php' );
			Convocation_Admin_Edit_View::render( $this->get_convocation( $_GET['id'] ), $this->obj_joueurs->get_all_joueurs() );
		}
		
		public function admin_edit_convocation() {
			$id 		= $_POST['id'];
			$equipadv 	= $_POST['equipadv'];
			$date 		= $_POST['date'];
			$domext 	= $_POST['domext'];
			$lieurdv 	= $_POST['lieurdv'];
			$heurerdv 	= $_POST['heurerdv'];
			$heurematch = $_POST['heurematch'];
			$arrJoueurs = $_POST['selectionnes'];
			
			$this->update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs );
			
			if( form_is_validated ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'	=>	'convocations/app/controller/controller-convocation.php',
							'action'=>	'edit',
							'id'	=>	'1',
							'save'	=>	'true'
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		public function insert_convocation( $name ) {
			$this->obj_convocations->insert_convocation( $name );
		}
		
		public function update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs ) {
			
			$this->obj_convocations->update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs );
		}
		
		public function delete_convocation( $the_equipe ) {
			$this->obj_convocations->delete_convocation( $the_equipe );
		}
		
		public function get_convocation( $the_convocation ) {
			return $this->obj_convocations->get_convocation( $the_convocation );
		}
		
		public function get_all_convocations() {
			return $this->obj_convocations->get_all_convocations();
		}
	}

}