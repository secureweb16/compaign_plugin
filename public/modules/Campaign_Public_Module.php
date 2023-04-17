 <?php
/**

 * Register all actions and filters for the plugin

 *

 * @link       http://securewebtechnologies.com/

 * @since      1.0.0

 *

 * @package    Custom_Plugin

 * @subpackage Custom_Plugin/includes

 */



/**

 * Register all actions and filters for the plugin.

 *

 * Maintain a list of all hooks that are registered throughout

 * the plugin

 *

 * @package    Custom_Plugin

 * @subpackage Custom_Plugin/includes

 * @author     

 */

class Campaign_Public_Module {
	use Campaign_Plus_Helper;

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

	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;

		$this->version = $version;

		    add_action( 'admin_menu', array( $this, 'admin_menu' ) );

	}

    public function admin_menu(){
        add_menu_page( "Dashboard", "Armaturenbrett","manage_options","campaign_plus_menus", array( $this, 'CampaignPlus_Dashboard' ), "dashicons-businessperson", "6");
        add_submenu_page( "campaign_plus_menus","Kontakte", "Kontakte", "manage_options", "campaign_plus_contact", array( $this, 'CampaignPlus_ContactSync' ));
        add_submenu_page( "campaign_plus_menus", "produkte_bestellungen", "Produkte & Bestellungen", "manage_options", "campaign_plus_products_orders", array( $this, 'CampaignPlus_ProductsOrderSync' ));
		add_submenu_page( "campaign_plus_menus","Settings", "Settings", "manage_options", "campaign_plus_settings", array( $this, 'CampaignPlus_Settings' ));
	}

 
    public function CampaignPlus_Dashboard(){
		require_once Campaign_Plus_BASEPATH . 'public/templates/dashboard.php'; 
    }
	

    public function CampaignPlus_ContactSync(){
		require_once Campaign_Plus_BASEPATH . 'public/templates/contact_sync.php'; 
    }

    public function CampaignPlus_ProductsOrderSync(){
		require_once Campaign_Plus_BASEPATH . 'public/templates/product_order_sync.php'; 
    }


	public function CampaignPlus_Settings(){
		require_once Campaign_Plus_BASEPATH . 'public/templates/settings.php'; 
    }



}