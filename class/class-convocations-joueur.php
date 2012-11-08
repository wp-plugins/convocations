<?php
	class Convocations_Joueur{
		/**
		 * Instance of the class Convocations_Joueur
		 * @var ConvocationsJoueur
		 * @access private
		 * @static
		 */
		private static $_instance_joueur = null;
		
		private function __construct()
		{
		
		}
		
		public static function get_instance(){
			if( is_null( self::$_instance_joueur ) )
			{
				self::$_instance_joueur = new Convocations_Joueur();
			}
			return self::$_instance_joueur;
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
								$nom, $prenom
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
				
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function update_joueur( $id, $nom, $prenom, $poste, $equipe ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$wpdb->update(
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
								$id
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
								$the_joueur_id
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
								$the_equipe
					);
			$joueurs_equipe = $wpdb->get_results($sql);
			
			return $joueurs_equipe;
		}
		
		function get_all_joueurs(){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' ORDER BY nom ASC');
			$all_joueurs = $wpdb->get_results($sql);
			
			return $all_joueurs;
		}
	}
?>