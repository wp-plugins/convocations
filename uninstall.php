<?php
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit();

	function convocations_delete_plugin(){
		global $wpdb;

		// Delete Plugin Settings
		delete_option('convocations_db_version');

		// Delete Tables
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . 'convocations');
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . 'convocations_equipes');
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . 'convocations_joueurs');
		
		// Remove Capabilities
		$role = get_role( 'administrator' );
		$role->remove_cap( 'manage_convocations' );
		
		remove_role( 'responsable_equipe' );
	}

	convocations_delete_plugin();
?>