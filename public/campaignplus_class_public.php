<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public 
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/** 
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->CampaignPlus_ExecuteClasses();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function CampaignPlus_ExecuteClasses() {
		/* ------- TEMPLATE OBJECT CLASS -------- */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/modules/campaign_public_module.php';
		$Campaign_Public_Module = new Campaign_Public_Module($this->plugin_name, $this->version);

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/services/campaign_plus_api.php';
		$Campaign_Plus_Api = new Campaign_Plus_Api($this->plugin_name, $this->version);

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/ajax/admin_ajax.php';
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/campaignplus_public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	*/

	public function enqueue_scripts() {
		wp_enqueue_script( 'campaignplus_public-js', plugin_dir_url( __FILE__ ) . 'js/campaignplus_public.js', array( 'jquery' ), $this->version, false );
	}

}
