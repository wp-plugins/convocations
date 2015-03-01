<?php
if( ! class_exists( 'Convocations_Controller' ) ) {
	
	class Convocations_Controller {
		
		private $obj_convocations;
		
		public function __construct() {
			require_once (CONVOCATIONS_PATH.'class/class-convocations.php');
			
			$this->obj_convocations = new Convocations();
		}
		
		public function insert_convocation( $name ) {
			$this->inst_convocations->insert_convocation( $name );
		}
		
		public function update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs ) {
			
			$this->inst_convocations->update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs );
		}
		
		public function delete_convocation( $the_equipe ) {
			$this->inst_convocations->delete_convocation( $the_equipe );
		}
		
		public function get_convocation( $the_convocation ) {
			return $this->inst_convocations->get_convocation( $the_convocation );
		}
		
		public function get_all_convocations() {
			return $this->inst_convocations->get_all_convocations();
		}
	}

}