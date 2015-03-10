<?php
if( ! class_exists( 'Convocation_Manager' ) ) {
	
	/**
	 * Class to interact with table Convocations in the database
	 */
	class Convocation_Manager {
		
		/**
		 * Constructor
		 */
		public function __construct() {	
		}
		
		/**
		 * Insert a new convocation in the database
		 * 
		 * @global $wpdb
		 * @param Convocation $convocation
		 * @return int $wpdb->insert_id
		 */
		public function insert( Convocation $convocation ) {
			global $wpdb;
			
			$wpdb->insert(
				CONVOCATIONS_TBL_CONVOCATIONS,
				array(
					'equipe' 	=>	$convocation->get_equipe(),
					'date' 		=>	date_i18n('Y-m-d')
				)
			);
			
			return $wpdb->insert_id;
		}
		
		/**
		 * Update a convocation in the database
		 *
		 * @param Convocation $convocation
		 */
		public function update( Convocation $convocation ){
			global $wpdb;
			
			// We update the informations of the convocation
			$wpdb->update(
				CONVOCATIONS_TBL_CONVOCATIONS,
				array(
					'equipadv'	=> $convocation->get_equipadv(),
					'date'		=> $convocation->get_date(),
					'domext'	=> $convocation->get_domext(),
					'lieurdv'	=> $convocation->get_lieurdv(),
					'heurerdv'	=> $convocation->get_heurerdv(),
					'heurematch'=> $convocation->get_heurematch()
				),
				array(
					'id' => $convocation->get_id()
				)
			);
		}
		
		/**
		 * Delete a convocation in the database
		 * 
		 * @param Convocation $convocation
		 */
		public function delete( Convocation $convocation ){
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'DELETE 
				FROM ' . CONVOCATIONS_TBL_CONVOCATIONS . ' 
				WHERE equipe = %s',
				array( $convocation->get_equipe() )
			);
			
			$wpdb->query( $sql );
		}
		
		/**
		 * Get a convocation from the database
		 * 
		 * @param int id ID of the convocation
		 * @return Object Convocation
		 */
		public function get_convocation( $id ){
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_CONVOCATIONS . ' 
				WHERE id = %d',
				array( $id )
			);
			
			$convocation = $wpdb->get_row( $sql, ARRAY_A );
			
			return new Convocation( $convocation );
		}
		
		/**
		 * Get a convocation from the database
		 * 
		 * @param int id ID of the convocation
		 * @return Object Convocation
		 */
		public function get_convocation_by_equipe( $equipe ){
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_CONVOCATIONS . ' 
				WHERE equipe = %s',
				array( $equipe )
			);
			
			$convocation = $wpdb->get_row( $sql, ARRAY_A );
			
			return new Convocation( $convocation );
		}
		
		/**
		 * Get all convocations from the database
		 * 
		 * @return array Objects Convocation
		 */
		public function get_convocations() {
			$convocations = array();
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_CONVOCATIONS . ' 
				ORDER BY equipe ASC', 
				array()
			);
			
			$results = $wpdb->get_results( $sql, ARRAY_A );
			
			foreach( $results as $convocation ){
				$convocations[] = new Convocation( $convocation );
			}
			
			return $convocations;
		}
	}
}