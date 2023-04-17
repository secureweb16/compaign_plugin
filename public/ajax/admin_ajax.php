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
class Admin_Ajax extends Campaign_Plus_Api{   
   use Campaign_Plus_Helper; 
   use Campaign_Plus_Admin_Settings; 
    public function __construct() {         
        add_action( 'wp_ajax_campaign_admin_ajax_activate_store', array( $this, 'CampaignActivate') );
        add_action( 'wp_ajax_nopriv_campaign_admin_ajax_activate_store', array( $this, 'CampaignActivate') );

        add_action( 'wp_ajax_campaign_admin_ajax_create_group', array( $this, 'CampaignCreateGroup') );
        add_action( 'wp_ajax_nopriv_campaign_admin_ajax_create_group', array( $this, 'CampaignCreateGroup') );

        add_action( 'wp_ajax_campaign_admin_ajax_force_contact_sync', array( $this, 'CampaignForceContactSync') );
        add_action( 'wp_ajax_nopriv_campaign_admin_ajax_force_contact_sync', array( $this, 'CampaignForceContactSync') );

        add_action( 'wp_ajax_campaign_admin_settings_update', array( $this, 'CampaignSettingsUpdate') );
        add_action( 'wp_ajax_nopriv_campaign_admin_settings_update', array( $this, 'CampaignSettingsUpdate') );  
    }

    public function CampaignActivate(){
        try {
            $txt_compaign_key = sanitize_text_field($_POST['txt_compaign_key']);
            if($txt_compaign_key){
                $compaign_key = array('txt_compaign_key'=> $txt_compaign_key);
                echo $respo = $this->StoreDetailsfetch($compaign_key);
            }else{
                echo json_encode(array('status' => 0, 'message' => 'Compaign.plu Api key required!'));
            }
        } catch (\Throwable $th) {
            echo "Somthing wrong :  error" . $e->getMessage();
        }
        exit();  
    } 
    
    
    public function CampaignCreateGroup(){
        try {
            $txt_compaign_group_name = sanitize_text_field($_POST['group_name']);
            if($txt_compaign_group_name){
                $group_name = array('group_name'=> $txt_compaign_group_name);
                $respo = $this->CreateGroup($group_name);
            }else{
                echo json_encode(array('status' => 0, 'message' => 'Please provide the group Name!'));
            }
        } catch (\Throwable $th) {
            echo "Somthing wrong :  error" . $e->getMessage();
        }
        exit();
    } 


    public function CampaignForceContactSync(){
        try {
            $respo = $this->CampaignForceContactSyncFatch($group_name);
            echo "<pre>"; print_r($respo); die; 

        } catch (\Throwable $th) {
            echo "Somthing wrong :  error" . $e->getMessage();
        }
        exit();
    }



    public function CampaignSettingsUpdate(){
        try {
            unset($_POST['action']);
            if(count($_POST) > 0){
                $respo = $this->Compaign_UpdateSettings($_POST);
                echo "<pre>"; print_r($respo); die; 
                echo json_encode(array('status' => 1, 'message' => 'Setting updated sucessfully '));
            }else{
                echo json_encode(array('status' => 0, 'message' => 'Setting update process is failed, Please try again!'));
            }



        } catch (\Throwable $th) {
            echo "Somthing wrong :  error" . $e->getMessage();
        }
        exit();
    }

}

$plugin = new Admin_Ajax();