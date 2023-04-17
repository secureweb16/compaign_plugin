<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.campaign.plus
 * @since             1.0.0 
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Campaign.Plus E-Mail-Marketing
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Synchronize contacts, products and orders with the email marketing software Campaign.Plus.
 * Version:           1.0.0
 * Author:            Secure Web Technologies
 * Author URI:        http://securewebtechnologies.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       compaing_plus
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} 
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );
define( 'Campaign_Plus_BASEPATH', plugin_dir_path( __FILE__ ) );
define( 'Campaign_Plus_BASEURL', plugin_dir_url( __FILE__ ) );
define('BASE_URL', get_bloginfo('url'));

define('CAMPAIGN_API_BASE_URL', 'https://api.campaign.plus');
define('DISABLE_WP_CRON', false);
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/campaignplus_class_activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/campaignplus_class_activator.php';
	Compaign_Plus_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/campaignplus_class_deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/campaignplus_class_deactivator.php';
	Compaign_Plus_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path( __FILE__ ) . 'includes/campaignplus_admin_class.php';

require plugin_dir_path( __FILE__ ) . 'public/helpers/campaign_plus_helper.php';
require plugin_dir_path( __FILE__ ) . 'public/helpers/admin_settings.php';

require plugin_dir_path( __FILE__ ) . 'public/scheduler/compaignplus_sheduler.php';


add_filter( 'compaign_cron_schedules', 'compaign_every_minute_schedule' );
function compaign_every_minute_schedule( $schedules ) {
	$schedules['everyminute'] = array(
		'interval' => 60,
		'display'  => __( 'Compaing Every Minute', 'gca-core' ),
	);
	return $schedules;
}

add_action( 'compaign_every_minute_event', 'custom_every_minute_cronjob' );
function custom_every_minute_cronjob() {
	$Campaign_Plus_Scheduler = new Campaign_Plus_Scheduler();
	$Campaign_Plus_Scheduler->CompaignScheduler();
}

if ( ! wp_next_scheduled( 'compaign_every_minute_event' ) ) {
	wp_schedule_event( time(), 'everyminute', 'compaign_every_minute_event' );
}



add_action( 'woocommerce_review_order_before_submit', 'my_custom_checkout_field' );
function my_custom_checkout_field() {
    echo '<div id="my_custom_checkout_field">';

    woocommerce_form_field( 'campaignplus_newlatter_status', array( 
        'type'      => 'checkbox',
        'class'     => array('input-checkbox'),
        'label'     => __('Campaign.Plus new letter subscribe'),
    ),  WC()->checkout->get_value( 'campaignplus_newlatter_status' ) );
    echo '</div>';
}

add_action( 'woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta', 10, 1 );
function custom_checkout_field_update_order_meta( $order_id ) {

    if ( ! empty( $_POST['campaignplus_newlatter_status'] ) )
        update_post_meta( $order_id, 'campaignplus_newlatter_status', $_POST['campaignplus_newlatter_status'] );
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_compaignplus_checkbox', 10, 1 );
function display_compaignplus_checkbox( $order ){
    $campaignplus_newlatter_status = get_post_meta( $order->get_id(), 'campaignplus_newlatter_status', true );
    if( $my_field_name == 1 )
        echo '<p><strong>My custom field: </strong> <span style="color:red;">Is enabled</span></p>';
}

function run_plugin_name() {

	$plugin = new Plugin_Name();
	$plugin->run();

}
run_plugin_name();
