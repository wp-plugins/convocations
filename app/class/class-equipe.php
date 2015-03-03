<?php
if( ! class_exists( 'Equipe' ) ) {
	
	class Equipe {

		/**
		 * Constructor
		 * @private
		 */
		public function __construct() {
			
		}

		/**
		 * Insert a team in database
		 * @global type $wpdb
		 * @param type $nom
		 * @param type $responsable
		 * @param type $telephone
		 * @param type $entrainement
		 * @return boolean
		 */
		function insert_equipe( $nom, $responsable, $telephone, $entrainement ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE nom = %s', array( $nom ) );
			$equipe = $wpdb->get_results($sql);

			if ( 0 == count( $equipe ) ) {
				$wpdb->insert(
						$table_name,
						array(
							'nom'          => $nom,
							'responsable'  => $responsable,
							'telephone'    => $telephone,
							'entrainement' => $entrainement
						)
				);
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Update a team in database
		 * @global type $wpdb
		 * @param type $id
		 * @param type $old_name
		 * @param type $nom
		 * @param type $responsable
		 * @param type $telephone
		 * @param type $entrainement
		 */
		function update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'convocations_equipes';

			$wpdb->update(
					$table_name,
					array(
						'nom'          => $nom,
						'responsable'  => $responsable,
						'telephone'    => $telephone,
						'entrainement' => $entrainement
					),
					array(
						'id' => $id
					)
			);

			if ( $nom != $old_name ) {
				$table_name = $wpdb->prefix . 'convocations';
				$wpdb->update(
						$table_name,
						array(
							'equipe' => $nom
						),
						array(
							'equipe' => $old_name
						)
				);

				$table_name = $wpdb->prefix . 'convocations_joueurs';
				$wpdb->update(
						$table_name,
						array(
							'equipe' => $nom
						),
						array(
							'equipe' => $old_name
						)
				);
			}
		}

		/**
		 * Delete a team in database
		 * @global type $wpdb
		 * @param type $id
		 */
		function delete_equipe( $id ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare(
									'DELETE 
									FROM ' . $table_name . ' 
									WHERE id = %d',
									array( $id )
					);
			$wpdb->query($sql);
		}

		/**
		 * Get a team
		 * @global type $wpdb
		 * @param type $id
		 * @return type
		 */
		function get_equipe($id) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id = %d',  array( $id ) );
			$data_equipe = $wpdb->get_results($sql);

			return $data_equipe;
		}

		/**
		 * Get all teams
		 * @global type $wpdb
		 * @return type
		 */
		function get_all_equipes() {
			global $wpdb;

			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' ORDER BY nom ASC', array() );
			$all_equipes = $wpdb->get_results($sql);

			return $all_equipes;
		}
	}
}