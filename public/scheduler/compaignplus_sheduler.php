<?php
class Campaign_Plus_Scheduler{
    use Campaign_Plus_Helper;
	public function __construct() {

	}

    public function CompaignScheduler($compaign_key = array()){
        global $wpdb;
        try{
            $argc = [
                'post_title' => "Everyminute".date( 'Y-m-d H:i:s', time() ),
            ];
            wp_insert_post($argc);
            //update_option( 'custom_crone_run_at', date( 'Y-m-d H:i:s', time() ) );

        } catch( Exception $e ){
            echo "Somthing wrong, error" . $e->getMessage(); 
        } 
    }


}

?>

