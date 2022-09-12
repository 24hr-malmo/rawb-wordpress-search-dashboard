<?php

/*
Plugin Name: RAWB Search Dashboard
Plugin URI: http://24hr.se
Description: Dashboard for the search services
Version: 0.1.1
Author: Camilo Tapia <camilo.tapia@24hr.se>
*/

// don't load directly
if ( !defined( 'ABSPATH' ) ) {

    die( '-1' );

} else {

    $dir = dirname( __FILE__ );

    $plugin_info = get_file_data(__FILE__, array( 'Version' => 'Version') );
    define('RAWB_SERACH_DASHBOARD_VERSION', $plugin_info['Version']);

    require_once( $dir . '/lib/search-dashboard.php' );

    add_action( 'init', function() {

        // Init or use instance of the manager.
        $dir = dirname( __FILE__ );
        $api_token = getenv('API_TOKEN');

        if(class_exists( 'RAWBSearchDashoard' )){
            global $RAWBSearchDashboard;
            $draft_live_sync = new RAWBSearchDashoard($dir, RAWB_SERACH_DASHBOARD_VERSION, $api_token);
        }


    });

}

