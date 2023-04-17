<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Compaign_Plus_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		try{
			update_option( "plugin_status_campaign_plus", 'active' );
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		/* ------  CREATE TABLE FOR ACTIVATION COMPAIGN PLUS API ----- */
			$table_name = 'campaign_plus_customers'; 
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE $table_name (
			id int(10) NOT NULL AUTO_INCREMENT,
			store_domain varchar(55) NULL,
			email varchar(55) DEFAULT '' NULL,
			compaign_key varchar(300) NULL,
			compaign_store_id int(10) NULL,
			api_status ENUM('0', '1') DEFAULT '0',
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
			updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
			) $charset_collate;";
			dbDelta( $sql );

			/* ------  CREATE TABLE FOR ACTIVATION COMPAIGN PLUS API ----- */
			$table_name = 'campaign_plus_groups'; 
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE $table_name (
			id int(10) NOT NULL AUTO_INCREMENT,
			group_name varchar(55) NULL,
			campaign_group_id int(55) NULL,
			compaign_store_id int(55) NULL,
			api_status ENUM('0', '1') DEFAULT '0',
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
			updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
			) $charset_collate;";
			dbDelta( $sql );

		} catch( Exception $e ){
			echo "some error" . $e->getMessage();
		} 
	}

}
