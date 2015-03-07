<?php
if( ! class_exists( 'Joueur' ) ) {
	
	class Joueur {
		
		public function __construct()
		{
		
		}
		
		function insert_joueur( $nom, $prenom, $poste, $equipe ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $table_name . ' 
								WHERE nom = %s
								AND prenom = %s
								',
								array( $nom, $prenom )
					);
			$joueur = $wpdb->get_results($sql);
			
			if (count ($joueur) == 0){
				$wpdb->insert(
					$table_name,
					array(
							'nom' 		=> $nom,
							'prenom' 	=> $prenom,
							'poste' 	=> $poste,
							'equipe' 	=> $equipe
					)
				);
				
				return $wpdb->insert_id;
			}
			else
			{
				return false;
			}
		}
		
		function update_joueur( $id, $nom, $prenom, $poste, $equipe ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$results = $wpdb->update(
				$table_name,
				array(
						'nom'		=> $nom,
						'prenom'	=> $prenom,
						'poste'		=> $poste,
						'equipe'	=> $equipe
				),
				array(
						'id' => $id
				)
			);
			
			return $results;
		}
		
		function delete_joueur( $id ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . $table_name . ' 
								WHERE id = %d
								',
								array( $id )
					);
			$wpdb->query($sql);
		}
		
		function get_joueur( $the_joueur_id ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $table_name . ' 
								WHERE id = %d
								',
								array( $the_joueur_id )
					);
			$joueur = $wpdb->get_results($sql);
			return $joueur;
		}
		
		function get_joueurs_by_equipe($the_equipe){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $table_name . ' 
								WHERE equipe = %s 
								ORDER BY nom ASC
								',
								array( $the_equipe )
					);
			$joueurs_equipe = $wpdb->get_results($sql);
			
			return $joueurs_equipe;
		}
		
		function get_all_joueurs(){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' ORDER BY nom ASC', array());
			$all_joueurs = $wpdb->get_results($sql);
			
			return $all_joueurs;
		}
	}
}