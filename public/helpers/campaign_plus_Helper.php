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
trait Campaign_Plus_Helper{

    function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	} 

	function Compaign_Apilist(){
            try{
               $compaign_api_list = array();
               $compaign_api_list['compaign_ping']['url'] = CAMPAIGN_API_BASE_URL .'/ping';
               $compaign_api_list['compaign_ping']['type'] = 'GET';

               $compaign_api_list['compaign_stores']['url'] = CAMPAIGN_API_BASE_URL .'/stores';
               $compaign_api_list['compaign_stores']['type'] = 'POST';

               $compaign_api_list['compaign_create_group']['url'] = CAMPAIGN_API_BASE_URL .'/recipient_groups';
               $compaign_api_list['compaign_create_group']['type'] = 'POST';

               $compaign_api_list['compaign_group_list']['url'] = CAMPAIGN_API_BASE_URL .'/recipient_groups';
               $compaign_api_list['compaign_group_list']['type'] = 'GET';

               return $compaign_api_list;
            } catch( Exception $e ){
                echo "Somthing wrong :  error" . $e->getMessage();
            } 
        }
    
    
    function Compaign_RequestHandler($params = array(), $post_data = array()){
        try{
            if(count($params)> 0){
                switch($params['type']){
                    case 'GET':
                        $reponse = $this->Compaign_GetData($params);
                    break;

                    case 'POST':
                        $reponse = $this->Compaign_PostData($params, $post_data);
                    break;
        
                    case 'CHECK':
                        $reponse = 'Opps';
                    break;  
                }
                return $reponse;
            }else{
                throw new Exception('Request is not valid!',404);    
            }
        } catch( Exception $e ){
            echo "Somthing wrong :  error" . $e->getMessage();
        } 
        
    }


	public function Compaign_GetData($params = array()){
        try{
            $args = array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => $params['compaign_key']
                )
            );
            $res = wp_remote_get( $params['url'], $args );
            $response_code = wp_remote_retrieve_response_code( $res );
            return $response_code;
        } catch( Exception $e ){
            echo "Somthing wrong :  error" . $e->getMessage();
        } 
    }


    function Compaign_PostData($params,$post_data){
        try{
            $args = array(
                'body'        => json_encode($post_data),
                'headers'     => array('Content-Type' => 'application/json', 'Authorization' => $params['compaign_key']),
            );
            $response = wp_remote_post($params['url'], $args );
            $res_body = wp_remote_retrieve_body($response);
            $res_code = wp_remote_retrieve_response_code( $response );
            $res_arr = json_decode($res_body);
            if($res_code == 200 || $res_code == 201){
                return array('status' => 1, 'id'=> $res_arr->id, 'message' => 'The request was processed successfully!');
            }else if($res_code == 400){
                return array('status' => 0, 'message' => 'Detected duplicate entry!');
            }else if($res_code == 401){
                return array('status' => 0, 'message' => 'Not authorized to do perform the action');
            }else{
                return array('status' => 0, 'message' => 'Somthing wrong!');
            }
        } catch( Exception $e ){
            echo "Somthing wrong :  error" . $e->getMessage();
        } 

    }


    function Compaign_StoreDetails($params = array()){
        try{
            global $wpdb;
            $email = get_option('admin_email');
            $domain_name = $_SERVER['SERVER_NAME'];
            $check_store_status = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `campaign_plus_customers` WHERE store_domain = %s OR email = %s",$domain_name,$email));

            $store_details = array('admin_email' => $email, 'store_domain' => $domain_name);
            if(@$check_store_status->id){
                $check_store_status = (array) $check_store_status; 
                $store_details = array_merge($check_store_status,$store_details);
            }
            return $store_details;
        } catch( Exception $e ){
            echo "Somthing wrong :  error" . $e->getMessage();
        } 
        
    }


	function Compaign_Logs($event){
		$path = Campaign_Plus_BASEPATH . 'public/storage/logs/compaign_log.log';
		$myfile = fopen($path, "a") or die("Unable to open file!");
		fwrite($myfile,print_r("\n=========================== ".date('d-m-Y h:i:s')." ============================"."\n",1));
		fwrite($myfile,  print_r("/***** ".$event."  *****/",true));
		fclose($myfile);
	  }


  

}

?>


