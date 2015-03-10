<?php
if( ! class_exists( 'Joueur_Manager' ) ) {
	
	class Joueur_Manager {
		
		public function __construct() {
		}
		
		public function insert( Joueur $joueur ) {
			global $wpdb;
			
			$sql = $wpdb->prepare( 'SELECT * FROM ' . CONVOCATIONS_TBL_PLAYERS . ' WHERE nom = %s AND prenom = %s',	array( $nom, $prenom ) );
			$result = $wpdb->get_results($sql);
			
			if ( empty( $result ) ) {
				$wpdb->insert(
					CONVOCATIONS_TBL_PLAYERS,
					array(
						'nom' 		=> $joueur->get_nom(),
						'prenom' 	=> $joueur->get_prenom(),
						'poste' 	=> $joueur->get_poste(),
						'equipe' 	=> $joueur->get_equipe()
					)
				);
				return $wpdb->insert_id;
			} else {
				return false;
			}
		}
		
		public function update( Joueur $joueur ) {
			global $wpdb;
			
			$results = $wpdb->update(
				CONVOCATIONS_TBL_PLAYERS,
				array(
					'nom' 				=> $joueur->get_nom(),
					'prenom' 			=> $joueur->get_prenom(),
					'poste' 			=> $joueur->get_poste(),
					'equipe' 			=> $joueur->get_equipe(),
					'numconvocation'	=> $joueur->get_numconvocation()
				),
				array(
					'id' => $joueur->get_id()
				)
			);
			
			return $results;
		}
		
		public function delete( Joueur $joueur ) {
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'DELETE 
				FROM ' . CONVOCATIONS_TBL_PLAYERS . ' 
				WHERE id = %d',
				array( $joueur->get_id() )
			);
			$wpdb->query( $sql );
		}
		
		public function get_joueur( $id ) {
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_PLAYERS . ' 
				WHERE id = %d',
				array( $id )
			);
			$joueur = $wpdb->get_row( $sql, ARRAY_A );
			return new Joueur( $joueur );
		}
		
		public function get_joueurs_by_equipe( $equipe ) {
			$joueurs = array();
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_PLAYERS . ' 
				WHERE equipe = %s 
				ORDER BY nom ASC
				',
				array( $equipe )
			);
			$results = $wpdb->get_results( $sql, ARRAY_A );
			foreach( $results as $joueur ) {
				$joueurs[] = new Joueur( $joueur );
			}
			
			return $joueurs;
		}
		
		public function get_joueurs_by_numconvocation( $numconvocation ) {
			$joueurs = array();
			global $wpdb;
			
			$sql = $wpdb->prepare(
				'SELECT * 
				FROM ' . CONVOCATIONS_TBL_PLAYERS . ' 
				WHERE numconvocation = %d 
				ORDER BY nom ASC
				',
				array( $numconvocation )
			);
			$results = $wpdb->get_results( $sql, ARRAY_A );
			foreach( $results as $joueur ) {
				$joueurs[] = new Joueur( $joueur );
			}
			
			return $joueurs;
		}
		
		public function get_joueurs() {
			$joueurs = array();
			global $wpdb;
			
			$sql = $wpdb->prepare('SELECT * FROM ' . CONVOCATIONS_TBL_PLAYERS . ' ORDER BY nom ASC', array());
			$results = $wpdb->get_results( $sql, ARRAY_A );
			foreach( $results as $joueur ) {
				$joueurs[] = new Joueur( $joueur );
			}
			
			return $joueurs;
		}
	}
}