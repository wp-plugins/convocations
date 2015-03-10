<?php
if( ! class_exists( 'Joueur' ) ) {
	
	class Joueur {
		
		private $_id;
		private $_nom;
		private $_prenom;
		private $_poste;
		private $_equipe;
		private $_numconvocation;
		
		public function __construct( array $args ) {
			foreach( $args as $key => $value ) {
				$method = 'set_' . $key;
				if( method_exists( $this, $method ) ) {
					$this->$method( $value );
				}
			}
		}
		
		public function set_id( $id ) {
			$id = intval($id);
			
			if( $id >= 0 ) {
				$this->_id = $id;
			}
		}
		
		public function set_nom( $nom ) {
			$this->_nom = sanitize_text_field( $nom );
		}
		
		public function set_prenom( $prenom ) {
			$this->_prenom = sanitize_text_field( $prenom );
		}
		
		public function set_poste( $poste ) {
			$this->_poste = sanitize_text_field( $poste );
		}
		
		public function set_equipe( $equipe ) {
			$this->_equipe = sanitize_text_field( $equipe );
		}
		
		public function set_numconvocation( $numconvocation ) {
			$numconvocation = intval($numconvocation);
			
			if( $numconvocation >= 0 ) {
				$this->_numconvocation = $numconvocation;
			}
		}
		
		public function get_id() {
			return $this->_id;
		}
		
		public function get_nom() {
			return $this->_nom;
		}
		
		public function get_prenom() {
			return $this->_prenom;
		}
		
		public function get_poste() {
			return $this->_poste;
		}
		
		public function get_equipe() {
			return $this->_equipe;
		}
		
		public function get_numconvocation() {
			return $this->_numconvocation;
		}
	}
}