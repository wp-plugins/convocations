<?php
if( ! class_exists( 'Convocation' ) ) {
	
	/**
	 * Class to interact with table Convocations in the database
	 */
	class Convocation {
		
		private $_id;
		private $_equipe;
		private $_equipadv;
		private $_date;
		private $_domext;
		private $_lieurdv;
		private $_heurerdv;
		private $_heurematch;
		
		/**
		 * Constructor
		 */
		public function __construct( array $args ) {
			foreach( $args as $key => $value ) {
				$method = 'set_' . $key;
				if( method_exists( $this, $method ) ) {
					$this->$method( $value );
				}
			}
		}
		
		public function get_id() {
			return $this->_id;
		}
		
		public function get_equipe() {
			return $this->_equipe;
		}
		
		public function get_equipadv() {
			return $this->_equipadv;
		}
		
		public function get_date() {
			return $this->_date;
		}
		
		public function get_domext() {
			return $this->_domext;
		}
		
		public function get_lieurdv() {
			return $this->_lieurdv;
		}
		
		public function get_heurerdv() {
			return $this->_heurerdv;
		}
		
		public function get_heurematch() {
			return $this->_heurematch;
		}
		
		public function set_id( $id ) {
			$id = intval($id);
			
			if( $id >= 0 ){
				$this->_id = $id;
			}
		}
		
		public function set_equipe( $equipe ) {
			$this->_equipe = sanitize_text_field( $equipe );
		}
		
		public function set_equipadv( $equipeadv ) {
			$this->_equipadv = sanitize_text_field( $equipeadv );
		}
		
		public function set_date( $date ) {
			if ( preg_match( "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date ) ) {
				$this->_date = $date;
			}
		}
		
		public function set_domext( $domext ) {
			$this->_domext = sanitize_text_field( $domext );
		}
		
		public function set_lieurdv( $lieurdv ) {
			$this->_lieurdv = sanitize_text_field( $lieurdv );
		}
		
		public function set_heurerdv( $heurerdv ) {
			if ( preg_match( "/^(2[0-3]|[01][0-9]):[0-5][0-9]$/", $heurerdv ) ) {
				$this->_heurerdv = $heurerdv;
			}
		}
		
		public function set_heurematch( $heurematch ) {
			if ( preg_match( "/^(2[0-3]|[01][0-9]):[0-5][0-9]$/", $heurematch ) ) {
				$this->_heurematch = $heurematch;
			}
		}
	}
}