<?php
if( ! class_exists( 'Equipe' ) ) {
	
	class Equipe {
		
		private $_id;
		private $_nom;
		private $_reponsable;
		private $_telephone;
		private $_entrainement;

		/**
		 * Constructor
		 * @private
		 */
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
			
			if( $id >= 0 ){
				$this->_id = $id;
			}
		}
		
		public function set_nom( $nom ) {
			$this->_nom = sanitize_text_field( $nom );
		}
		
		public function set_responsable( $responsable ) {
			$this->_reponsable = sanitize_text_field( $responsable );
		}
		
		public function set_telephone( $telephone ) {
			$this->_telephone = sanitize_text_field( $telephone );
		}
		
		public function set_entrainement( $entrainement ) {
			$this->_entrainement = sanitize_text_field( $entrainement );
		}
		
		public function get_id() {
			return $this->_id;
		}
		
		public function get_nom() {
			return $this->_nom;
		}
		
		public function get_responsable() {
			return $this->_reponsable;
		}
		
		public function get_telephone() {
			return $this->_telephone;
		}
		
		public function get_entrainement() {
			return $this->_entrainement;
		}
	}
}