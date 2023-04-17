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
class Campaign_Plus_Api{
    use Campaign_Plus_Helper;

    private $plugin_name;
    private $version;

	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

    public function StoreDetailsfetch($compaign_key = array()){
        global $wpdb;
        try{
            $compaign_storeDetails = $this->Compaign_StoreDetails();
            $compaign_api_list = $this->Compaign_Apilist();

            $validate_key = array_merge($compaign_api_list['compaign_ping'], ['compaign_key' => $compaign_key['txt_compaign_key']]);
            $compaign_requestHandler = $this->Compaign_RequestHandler($validate_key);  
            
            if($compaign_requestHandler == 200){
                $check_store_status = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `campaign_plus_customers` WHERE store_domain = %s OR email = %s",$compaign_storeDetails['store_domain'],$compaign_storeDetails['admin_email'] ));
                if(@$check_store_status->id){
                   $response = $wpdb->query($wpdb->prepare("UPDATE `campaign_plus_customers` SET `api_status`='1' WHERE 1"));
                   $this->Compaign_Logs('Store activated succefully! ('.$check_store_status->store_domain.')' );
                   $return_res = array('status' => 1, 'message' => 'Store activated succesfully!');
                }else{
                    $store_data = array(
                        "name" => $compaign_storeDetails['store_domain'],
                        "type" => "SHOPIFY_PLUGIN"
                    );
                    $compaign_stores_data = array_merge($compaign_api_list['compaign_stores'], ['compaign_key' => $compaign_key['txt_compaign_key']]);
                    $compaign_stores_res = $this->Compaign_RequestHandler($compaign_stores_data, $store_data); 

                    if($compaign_stores_res['status'] == 1){
                        $txt_compaign_key = $compaign_key['txt_compaign_key'];
                        $compaign_key = base64_encode($txt_compaign_key);
                        $insertdata = $wpdb->query($wpdb->prepare("INSERT INTO `campaign_plus_customers` 
                        (`id`, `store_domain`, `email`, `compaign_key`,`compaign_store_id`,`api_status`) 
                        VALUES (%d, %s, %s, %s, %d, %s)", '', $compaign_storeDetails['store_domain'], $compaign_storeDetails['admin_email'], $compaign_key,$compaign_stores_res['id'], '1'
                        ));
                        $return_res =  array('status' => 1, 'message' => 'Store activated succesfully!');
                    }else{
                        $return_res = array('status' => 0, 'message' => $compaign_stores_res['message']);
                    }
                }
            }else{
                $return_res = array('status' => 0, 'message' => 'Incorrect api key provided!');
            }

            echo json_encode( $return_res);

        } catch( Exception $e ){
            echo "Somthing wrong, error" . $e->getMessage(); 
        } 
    }


    public function CreateGroup($params = array()){
        global $wpdb; 
        
        try{
            $compaign_api_list = $this->Compaign_Apilist();
            $compaign_storeDetails = $this->Compaign_StoreDetails();
            $compaign_key = base64_decode($compaign_storeDetails['compaign_key']);

            $store_data = array(
                'name' => $params['group_name']
             );
            $compaign_stores_data = array_merge($compaign_api_list['compaign_create_group'], ['compaign_key' => $compaign_key]);
            $compaign_stores_res = $this->Compaign_RequestHandler($compaign_stores_data, $store_data);
            if($compaign_stores_res['status'] == 1){

            $insertdata = $wpdb->query($wpdb->prepare("INSERT INTO `campaign_plus_groups` 
                (`id`, `group_name`, `campaign_group_id`, `compaign_store_id`,`api_status`) 
                VALUES (%d, %s, %d, %d,'%s')", '', $params['group_name'], $compaign_stores_res['id'], $compaign_storeDetails['compaign_store_id'], '1'
                ));

                if($insertdata){
                    $return_res = array('status' => 1, 'message' => $compaign_stores_res['message']);
                }else{
                    $return_res = array('status' => 0, 'message' => $compaign_stores_res['message']);
                }
            }else{
                $return_res = array('status' => 0, 'message' => $compaign_stores_res['message']);
            }

          echo json_encode( $return_res);
 
        } catch( Exception $e ){
            echo "Somthing wrong, error" . $e->getMessage(); 
        }
    }

    public function CampaignForceContactSyncFatch($params = array()){
        $all_users = get_users();
        foreach ($all_users as $user) {
            echo "<pre>"; print_r($user->data); 
        }
    }
}

?>

