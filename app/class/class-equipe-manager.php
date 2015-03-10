<?php
if( ! class_exists( 'Equipe_Manager' ) ) {
	
	class Equipe_Manager {

		/**
		 * Constructor
		 */
		public function __construct() {
		}

		/**
		 * Insert a team in database
		 * 
		 * @global Object $wpdb
		 * @param Equipe $equipe
		 * @return boolean
		 */
		function insert( Equipe $equipe ) {
			global $wpdb;

			$sql = $wpdb->prepare('SELECT * FROM ' . CONVOCATIONS_TBL_TEAMS . ' WHERE nom = %s', array( $equipe->get_nom() ) );
			$result = $wpdb->get_results($sql);
			
			if ( empty( $result ) ) {
				$wpdb->insert(
					CONVOCATIONS_TBL_TEAMS,
					array(
						'nom'          => $equipe->get_nom(),
						'responsable'  => $equipe->get_responsable(),
						'telephone'    => $equipe->get_telephone(),
						'entrainement' => $equipe->get_entrainement()
					)
				);
				return $wpdb->insert_id;
			} else {
				return false;
			}
		}

		/**
		 * Update a team in database
		 * 
		 * @global type $wpdb
		 * @param Equipe $equipe
		 */
		function update( Equipe $equipe ) {
			global $wpdb;

			$wpdb->update(
				CONVOCATIONS_TBL_TEAMS,
				array(
					'nom'          => $equipe->get_nom(),
					'responsable'  => $equipe->get_responsable(),
					'telephone'    => $equipe->get_telephone(),
					'entrainement' => $equipe->get_entrainement()
				),
				array(
					'id' => $equipe->get_id()
				)
			);
		}

		/**
		 * Delete a team in database
		 * @global type $wpdb
		 * @param type $id
		 */
		function delete( Equipe $equipe ) {
			global $wpdb;

			$sql = $wpdb->prepare(
				'DELETE 
				FROM ' . CONVOCATIONS_TBL_TEAMS . ' 
				WHERE id = %d',
				array( $equipe->get_id() )
			);
			
			$wpdb->query( $sql );
		}

		/**
		 * Get a team
		 * @global type $wpdb
		 * @param type $id
		 * @return type
		 */
		function get_equipe( $id ) {
			global $wpdb;

			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_TEAMS . ' 
				WHERE id = %d',
				array( $id )
			);
			
			$equipe = $wpdb->get_row( $sql, ARRAY_A );

			return new Equipe( $equipe );
		}

		/**
		 * Get all teams
		 * @global type $wpdb
		 * @return type
		 */
		function get_equipes() {
			$equipes = array();
			global $wpdb;

			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_TEAMS . ' 
				ORDER BY nom ASC',
				array()
			);
			
			$results = $wpdb->get_results( $sql, ARRAY_A );
			
			foreach( $results as $equipe ){
				$equipes[] = new Equipe( $equipe );
			}
			
			return $equipes;
		}
	}
}