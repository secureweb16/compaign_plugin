<?php



/**

 * The admin-specific functionality of the plugin.

 *

 * @link       http://example.com

 * @since      1.0.0

 *

 * @package    Plugin_Name

 * @subpackage Plugin_Name/admin

 */



/**

 * The admin-specific functionality of the plugin.

 *

 * Defines the plugin name, version, and two examples hooks for how to

 * enqueue the admin-specific stylesheet and JavaScript.

 *

 * @package    Plugin_Name

 * @subpackage Plugin_Name/admin

 * @author     Your Name secureweb16@gmail.com

 */

class Plugin_Name_Admin {



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

	 * @param      string    $plugin_name       The name of this plugin.

	 * @param      string    $version    The version of this plugin.

	 */

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'campaignplus_admin-css', plugin_dir_url( __FILE__ ) . 'css/campaignplus_admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'campaignplus_toastr-css', plugin_dir_url( __FILE__ ) . 'css/toastr.css', array(), $this->version, 'all' );
	}


	public function enqueue_scripts() {
		wp_enqueue_script( 'campaignplus_ajax-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js', array('jquery') );
	    wp_enqueue_script( 'campaignplus_admin-js', plugin_dir_url( __FILE__ ) . 'js/campaignplus_admin.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( 'campaignplus_toastr-js', plugin_dir_url( __FILE__ ) . 'js/toastr.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'campaignplus_ajax-script', plugin_dir_url( __FILE__ ) . 'js/my-ajax-script.js', array('jquery') );
		wp_localize_script( 'campaignplus_ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
	}



}

