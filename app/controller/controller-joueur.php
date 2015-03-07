<?php
if( ! class_exists( 'Joueur_Controller' ) ) {
	
	/**
	 *
	 */
	class Joueur_Controller {
		
		/**
		 *
		 */
		private $obj_joueurs;
		
		/**
		 *
		 */
		private $obj_equipes;
		
		/**
		 *
		 */
		public function __construct() {
			require_once( CONVOCATIONS_APP_PATH.'class/class-joueur.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-equipe.php' );
			
			$this->obj_joueurs = new Joueur();
			$this->obj_equipes = new Equipe();
			
			add_action( 'admin_post_new_joueur', array( &$this, 'admin_new_joueur' ) );
			add_action( 'admin_post_edit_joueur', array( &$this, 'admin_edit_joueur' ) );
			add_action( 'admin_post_filtrer', array( &$this, 'admin_filtrer' ) );
		}
		
		/**
		 *
		 */
		public function render() {
			if( isset( $_GET['action'] ) && 'new' == $_GET['action'] ) {
				$this->render_admin_new_view();
			}
			elseif( isset( $_GET['action'] ) && 'edit' == $_GET['action'] ) {
				$this->render_admin_edit_view();
			}
			elseif( isset( $_GET['action'] ) && $_GET['action'] == 'delete' ) {
				$this->delete_joueur( $_GET['id'] );
				$this->render_admin_view();
			}
			else {
				$this->render_admin_view();
			}
		}
		
		/**
		 *
		 */
		public function render_admin_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-joueur.php' );
			if( isset( $_GET['filtre-equipe'] ) && !empty( $_GET['filtre-equipe'] ) && 'toutes' != $_GET['filtre-equipe'] ){
				$joueurs = $this->obj_joueurs->get_joueurs_by_equipe( $_GET['filtre-equipe'] );
			} else {
				$joueurs = $this->get_all_joueurs();
			}
			Joueur_Admin_View::render( $this->obj_equipes->get_all_equipes(), $joueurs );
		}
		
		/**
		 *
		 */
		public function render_admin_new_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-new-joueur.php' );
			Joueur_Admin_New_View::render( $this->obj_equipes->get_all_equipes() );
		}
		
		/**
		 *
		 */
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-edit-joueur.php' );
			Joueur_Admin_Edit_View::render( $this->obj_joueurs->get_joueur( $_GET['id'] ), $this->obj_equipes->get_all_equipes() );
		}
		
		/**
		 *
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
		 *
		 */
		public function admin_new_joueur() {
			$nom	=	$_POST['nom'];
			$prenom	=	$_POST['prenom'];
			$poste	=	$_POST['poste'];
			$equipe	=	$_POST['equipe'];
			
			$insert_id = $this->insert_joueur( $nom, $prenom, $poste, $equipe );
			
			if( false != $insert_id ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-joueur.php',
							'id'		=>	intval( $insert_id ),
							'action'	=>	'edit',
							'message'	=>	'1'
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		/**
		 *
		 */
		public function admin_edit_joueur() {
			$id = $_POST['id'];
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$poste = $_POST['poste'];
			$equipe = $_POST['equipe'];
			
			$results = $this->update_joueur( $id, $nom, $prenom, $poste, $equipe );
			
			if( false != $results || 0 == $results ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'		=>	'convocations/app/controller/controller-joueur.php',
							'id'		=>	intval( $_POST['id'] ),
							'action'	=>	'edit',
							'message'	=>	'1'
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		/**
		 *
		 */
		public function insert_joueur( $nom, $prenom, $poste, $equipe ) {
			$insert = $this->obj_joueurs->insert_joueur( $nom, $prenom, $poste, $equipe );
			return $insert;
		}
		
		/**
		 *
		 */
		public function update_joueur( $id, $nom, $prenom, $poste, $equipe ) {
			return $this->obj_joueurs->update_joueur( $id, $nom, $prenom, $poste, $equipe );
		}
		
		/**
		 *
		 */
		public function delete_joueur( $the_joueur_id ) {
			return $this->obj_joueurs->delete_joueur( $the_joueur_id );
		}
		
		/**
		 *
		 */
		public function get_joueur( $the_joueur_id ) {
			return $this->obj_joueurs->get_joueur( $the_joueur_id );
		}
		
		/**
		 *
		 */
		public function get_joueurs_by_equipe( $the_equipe ) {
			return $this->obj_joueurs->get_joueurs_by_equipe( $the_equipe );
		}
		
		/**
		 *
		 */
		public function get_all_joueurs() {
			return $this->obj_joueurs->get_all_joueurs();
		}
	}

}