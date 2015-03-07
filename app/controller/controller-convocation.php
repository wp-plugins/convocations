<?php
if( ! class_exists( 'Convocation_Controller' ) ) {
	
	/**
	 *
	 */
	class Convocation_Controller {
		
		/**
		 *
		 */
		private $obj_convocations;
		
		/**
		 *
		 */
		private $obj_joueurs;
		
		/**
		 *
		 */
		public function __construct() {
			require_once( CONVOCATIONS_APP_PATH.'class/class-convocation.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-joueur.php' );
			
			$this->obj_convocations = new Convocation();
			$this->obj_joueurs = new Joueur();
			
			add_action( 'admin_post_edit_convocation', array( &$this, 'admin_edit_convocation' ) );
		}
		
		/**
		 *
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
		 *
		 */
		public function render_admin_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/convocation/view-admin-convocation.php' );
			Convocation_Admin_View::render( $this->get_all_convocations() );
		}
		
		/**
		 *
		 */
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/convocation/view-admin-edit-convocation.php' );
			Convocation_Admin_Edit_View::render( $this->get_convocation( intval( $_GET['id'] ) ), $this->obj_joueurs->get_all_joueurs() );
		}
		
		/**
		 *
		 */
		public function admin_edit_convocation() {
			$error = array();
			
			foreach( $_POST as $key => $value ) {
				switch( $key ){
					case 'id':
						if( isset( $_POST['id'] ) && '' != $_POST['id'] ) {
							$id = intval( $_POST['id'] );
						}
						else {
							$error['id'] = __( 'ID missing', 'convocations' );
						}
						break;
					case 'equipadv':
						if( isset( $_POST['equipadv'] ) && '' != $_POST['equipadv'] ) {
							$equipadv = sanitize_text_field( $_POST['equipadv'] );
						}
						else {
							$error['equipadv'] = __( 'Oppositing team missing', 'convocations' );
						}
						break;
					case 'date':
						if( isset( $_POST['date'] ) && '' != $_POST['date'] ) {
							$date = sanitize_text_field( $_POST['date'] );
						}
						else {
							$error['date'] = __( 'Date missing', 'convocations' );
						}
						break;
					case 'domext':
						if( isset( $_POST['domext'] ) && '' != $_POST['domext'] ) {
							$domext = sanitize_text_field( $_POST['domext'] );
						}
						else {
							$error['domext'] = __( 'Home/Outside missing', 'convocations' );
						}
						break;
					case 'lieurdv':
						if( isset( $_POST['lieurdv'] ) && '' != $_POST['lieurdv'] ) {
							$lieurdv = sanitize_text_field( $_POST['lieurdv'] );
						}
						else {
							$error['lieurdv'] = __( 'Place of the appointment missing', 'convocations' );
						}
						break;
					case 'heurerdv':
						if( isset( $_POST['heurerdv'] ) && '' != $_POST['heurerdv'] ) {
							$heurerdv = sanitize_text_field( $_POST['heurerdv'] );
						}
						else {
							$error['heurerdv'] = __( 'Time of the appointment missing', 'convocations' );
						}
						break;
					case 'heurematch':
						if( isset( $_POST['heurematch'] ) && '' != $_POST['heurematch'] ) {
							$heurematch = sanitize_text_field( $_POST['heurematch'] );
						}
						else {
							$error['heurematch'] = __( 'Time of the game missing', 'convocations' );
						}
						break;
					case 'selectionnes':
						if( isset( $_POST['selectionnes'] ) ) {
							$arrJoueurs = $_POST['selectionnes'];
						}
						break;
				}
			}
			
			if( empty( $error ) ) {
				$this->update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs );
				$message = 1;
			}
			else {
				$message = 2;
			}
			
			if( form_is_validated ) {
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
		
		/**
		 *
		 */
		public function insert_convocation( $name ) {
			$this->obj_convocations->insert_convocation( $name );
		}
		
		/**
		 *
		 */
		public function update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs ) {
			$this->obj_convocations->update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs );
		}
		
		/**
		 *
		 */
		public function delete_convocation( $the_equipe ) {
			$this->obj_convocations->delete_convocation( $the_equipe );
		}
		
		/**
		 *
		 */
		public function get_convocation( $the_convocation ) {
			return $this->obj_convocations->get_convocation( $the_convocation );
		}
		
		/**
		 *
		 */
		public function get_all_convocations() {
			return $this->obj_convocations->get_all_convocations();
		}
	}

}