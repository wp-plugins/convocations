<?php
	class ConvocationsEquipe
	{
		/**
		 * Instance of the class ConvocationsEquipe
		 * @var ConvocationsEquipe
		 * @acces private
		 * @static
		 */
		private static $_instance_equipe = null;
		
		private function __construct()
		{
		
		}
		
		public static function get_instance()
		{
			if( is_null( self::$_instance_equipe ) )
			{
				self::$_instance_equipe = new ConvocationsEquipe();
			}
			return self::$_instance_equipe;
		}
		
		function insert_equipe( $nom, $responsable, $telephone, $entrainement )
		{
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $table_name . ' 
								WHERE nom = %s
								',
								$nom
					);
			$equipe = $wpdb->get_results($sql);
			
			if (count ($equipe) == 0){
				$wpdb->insert(
					$table_name,
					array(
							'nom' 			=> $nom,
							'responsable' 	=> $responsable,
							'telephone' 	=> $telephone,
							'entrainement' 	=> $entrainement
					)
				);
				
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function update_equipe( $id, $old_name, $nom, $responsable, $telephone, $entrainement )
		{
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_equipes';
			
			$wpdb->update(
				$table_name,
				array(
						'nom'			=> $nom,
						'responsable'	=> $responsable,
						'telephone'		=> $telephone,
						'entrainement'	=> $entrainement
				),
				array(
						'id' => $id
				)
			);
			
			if ( $nom != $old_name)
			{
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
			}
		}
		
		function delete_equipe( $equipe_id )
		{
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . $table_name . ' 
								WHERE id = %d
								',
								$equipe_id
					);
			$wpdb->query($sql);
		}
		
		function get_equipe( $the_equipe_id )
		{
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $table_name . ' 
								WHERE id = %d
								',
								$the_equipe_id
					);
			$equipe_object = $wpdb->get_results($sql);
			
			return $equipe_object;
		}
		
		function get_all_equipes()
		{
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations_equipes';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' ORDER BY nom ASC');
			$all_equipes = $wpdb->get_results($sql);
			
			return $all_equipes;
		}
	}
?>