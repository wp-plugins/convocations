<?php
if( ! class_exists( 'Convocation' ) ) {
	
	/**
	 * 
	 */
	class Convocation {
		
		/**
		 * Constructor
		 */
		public function __construct() {	
		}
		
		/**
		 * Insert a new convocation in the database
		 *
		 * @param name Name of the convocation
		 * @return int $wpdb->insert_id ID of the insertion in the database
		 */
		public function insert_convocation( $name ) {
			global $wpdb;
			
			$wpdb->insert(
				CONVOCATIONS_TBL_CONVOCATIONS,
				array(
					'equipe' 	=>	$name,
					'date' 		=>	date_i18n('Y-m-d')
				)
			);
			
			return $wpdb->insert_id;
		}
		
		/**
		 * Update a convocation in the database
		 *
		 * @param int id			ID of the convocation to update
		 * @param string equipadv	Name of the opposing team
		 * @param datetime date		Date of the convocation
		 * @param string domext		Home/Outside option of the convocation
		 * @param string lieurdv	Place of the appointment
		 * @param string heurerdv	Time of the appointment
		 * @param string heurematch	Time of the game
		 * @param array arrJoueurs	List of the players selected for the convocation
		 */
		public function update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs ){
			global $wpdb;
			
			$wpdb->update(
				CONVOCATIONS_TBL_CONVOCATIONS,
				array(
						'equipadv'	=> $equipadv,
						'date'		=> $date,
						'domext'	=> $domext,
						'lieurdv'	=> $lieurdv,
						'heurerdv'	=> $heurerdv,
						'heurematch'=> $heurematch
				),
				array(
						'id' => $id
				)
			);
			
			$wpdb->update(
				CONVOCATIONS_TBL_PLAYERS,
				array(
						'numconvocation'	=> '-1'
				),
				array(
						'numconvocation' => $id
				)
			);
			
			if(!empty($arrJoueurs)) {
				foreach ($arrJoueurs as $joueur) {
					$wpdb->update(
						CONVOCATIONS_TBL_PLAYERS,
						array(
								'numconvocation'	=> $id
						),
						array(
								'id' => $joueur
						)
					);
				}
			}
		}
		
		public function delete_convocation( $the_equipe ){
			global $wpdb;
			
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . CONVOCATIONS_TBL_CONVOCATIONS . ' 
								WHERE equipe = %s
								',
								array( $the_equipe )
					);
			$wpdb->query($sql);
		}
		
		public function get_convocation( $id ){
			global $wpdb;
			
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . CONVOCATIONS_TBL_CONVOCATIONS . ' 
								WHERE id = %d
								',
								array( $id )
					);
			
			$convocation = $wpdb->get_row($sql);
			
			return $convocation;
		}
		
		public function get_all_convocations(){
			global $wpdb;
			
			$sql = $wpdb->prepare(
								'SELECT * 
								FROM ' . CONVOCATIONS_TBL_CONVOCATIONS . ' 
								ORDER BY equipe ASC', 
								array()
					);
			
			$all_convocations = $wpdb->get_results($sql);
			
			return $all_convocations;
		}
	}
}