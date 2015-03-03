<?php
if( ! class_exists( 'Joueur_Controller' ) ) {
	
	class Joueur_Controller {
		
		private $obj_joueurs;
		private $obj_equipes;
		
		public function __construct() {
			require_once( CONVOCATIONS_APP_PATH.'class/class-joueur.php' );
			require_once( CONVOCATIONS_APP_PATH.'class/class-equipe.php' );
			
			$this->obj_joueurs = new Joueur();
			$this->obj_equipes = new Equipe();
			
			add_action( 'admin_post_edit_joueur', array( &$this, 'admin_edit_joueur' ) );
			add_action( 'admin_post_filtrer', array( &$this, 'admin_filtrer' ) );
		}
		
		public function render_admin_view() {
			if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
				$this->render_admin_edit_view();
			}
			else {
				require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-joueur.php' );
				Joueur_Admin_View::render( $this->obj_equipes->get_all_equipes(), $this->get_all_joueurs() );
			}
		}
		
		public function render_admin_edit_view() {
			require_once( CONVOCATIONS_APP_PATH.'view/admin/joueur/view-admin-edit-joueur.php' );
			Joueur_Admin_Edit_View::render( $this->obj_joueurs->get_joueur( $_GET['id'] ), $this->obj_equipes->get_all_equipes() );
		}
		
		public function admin_filtrer() {
			
		}
		
		public function admin_edit_joueur() {
			$id = $_POST['id'];
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$poste = $_POST['poste'];
			$equipe = $_POST['equipe'];
			
			$this->update_joueur( $id, $nom, $prenom, $poste, $equipe );
			
			if( form_is_validated ) {
				wp_redirect(
					add_query_arg(
						array(
							'page'	=>	'convocations/app/controller/controller-joueur.php',
							'action'=>	'edit',
							'id'	=>	'1',
							'save'	=>	'true'
						),
						admin_url( 'admin.php' )
					)
				);
			}
		}
		
		public function insert_joueur( $nom, $prenom, $poste, $equipe ){
			$insert = $this->obj_joueurs->insert_joueur( $nom, $prenom, $poste, $equipe );
			return $insert;
		}
		
		public function update_joueur( $id, $nom, $prenom, $poste, $equipe ){
			$this->obj_joueurs->update_joueur( $id, $nom, $prenom, $poste, $equipe );
		}
		
		public function delete_joueur( $the_joueur_id ){
			$this->obj_joueurs->delete_joueur( $the_joueur_id );
		}
		
		public function get_joueur( $the_joueur_id ){
			$joueur = $this->obj_joueurs->get_joueur( $the_joueur_id );
			return $joueur;
		}
		
		public function get_joueurs_by_equipe( $the_equipe ){
			$joueurs_by_equipe = $this->obj_joueurs->get_joueurs_by_equipe( $the_equipe );
			return $joueurs_by_equipe;
		}
		
		public function get_all_joueurs(){
			$all_joueurs = $this->obj_joueurs->get_all_joueurs();
			return $all_joueurs;
		}
	}

}