<?php
if( ! class_exists( 'Convocations' ) ) {
	
	class Convocations {
		
		public function __construct() {
			
		}
		
		/**
		 * Insert a new convocation in the database
		 *
		 * @param nom Name of the convocation
		 */
		public function insert_convocation( $name ) {
			global $wpdb;
			
			$wpdb->insert(
				CONVOCATIONS_TBL_CONVOCATIONS,
				array(
						'equipe' 	=> $name,
						'date' 		=> date_i18n('Y-m-d')
				)
			);
		}
		
		public function update_convocation( $id, $equipadv, $date, $domext, $lieurdv, $heurerdv, $heurematch, $arrJoueurs ){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations';
			$wpdb->update(
				$table_name,
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
			
			$table_name = $wpdb->prefix . 'convocations_joueurs';
			$wpdb->update(
				$table_name,
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
						$table_name,
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
			
			$table_name = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare(
								'
								DELETE 
								FROM ' . $table_name . ' 
								WHERE equipe = %s
								',
								array( $the_equipe )
					);
			$wpdb->query($sql);
		}
		
		public function get_convocation( $the_convocation ){
			global $wpdb;
			$table_name = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare(
								'
								SELECT * 
								FROM ' . $table_name . ' 
								WHERE id = %d
								',
								array( $the_convocation )
					);
			
			$convocation = $wpdb->get_results($sql);
			
			return $convocation;
		}
		
		public function get_all_convocations(){
			global $wpdb;
			
			$table_name = $wpdb->prefix . 'convocations';
			$sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' ORDER BY equipe ASC', array() );
			$all_convocations = $wpdb->get_results($sql);
			
			return $all_convocations;
		}
	}
}