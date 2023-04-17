<?php 

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name 
 * @subpackage Plugin_Name/public/partials
 */
trait Campaign_Plus_Admin_Settings{

    function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	} 

	function Compaign_UpdateSettings($params = array()){
            try{
               
                $admin_setting = get_option('CompaignAdminSettings');
                if($admin_setting == '' && count($params) > 1){
                    echo "IF"; 
                    echo $data = serialize($params);
                    $admin_setting = update_option('CompaignAdminSettings',$data, true);
                    if($admin_setting){
                     $response = array('status' => 1, 'message' => 'Setting updated sucessfully ');
                    }else{
                     $response = array('status' => 0, 'message' => 'Setting update process is failed, Please try again !');
                    }
                }else{
                    echo "Else"; 
                    $admin_setting = update_option('CompaignAdminSettings',$data);
                }

                echo json_encode($response);

            } catch( Exception $e ){
                echo "Somthing wrong :  error" . $e->getMessage();
            } 
        }
    
}

?>


