<?php
/*
Plugin Name: Internship plugin

Description: Use shortcode [internshipplugin] 
Version: 1.0
Author: Mitra Sain

*/
//session_start();
/*add_action('init', function () {
    if (!session_id()) {
        session_start();
    }
}, 1);*/

// Start session and output buffering at the very first possible moment
add_action('init', function () {
    if (!ob_get_level()) {
        ob_start();
    }
    if (session_status() === PHP_SESSION_NONE) {
        session_start([
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax',
        ]);
    }
}, 0);



add_action('admin_menu', 'inttest_plugin_setup_menu_exp');
 
function inttest_plugin_setup_menu_exp(){
        add_menu_page( 'Int Careers ', 'Int Careers List ', 'manage_options', 'import-product-int', 'inttest_init_exp' );
        
}
function inttest_init_exp(){
	include('product_import.php');
} 

add_action('admin_menu', 'inttest_plugin_setup_menu1_exp');
 
function inttest_plugin_setup_menu1_exp(){
        add_menu_page( 'Applied Post for int', 'Applied Post for int', 'manage_options', 'applied-post-int', 'aptest_init1_int' );
        
}
function aptest_init1_int(){
	include('appliedpost.php');
} 
//ob_start();
//session_start();



function intfwds_form_activation_manager() {
}
register_activation_hook(__FILE__, 'intfwds_form_activation_manager');

function intfwds_form_deactivation_manager() {
}
register_deactivation_hook(__FILE__, 'intfwds_form_deactivation_manager');



add_action('wp_enqueue_scripts', 'intfwds_scripts_manager');
function intfwds_scripts_manager() {

  wp_enqueue_script('jquery');
	
  #wp_register_script('slidesjs_online', "https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js");
  #wp_enqueue_script('slidesjs_online');
  #wp_register_script('slidesjs_online1', "https://code.jquery.com/ui/1.12.1/jquery-ui.js");
  #wp_enqueue_script('slidesjs_online1');
  	
  #wp_register_script('slidesjs_core', plugins_url('js/custom.js', __FILE__),array("jquery"));
  #wp_enqueue_script('slidesjs_core');

}


add_action('wp_enqueue_scripts', 'intfwds_styles_manager');
function intfwds_styles_manager() {


  wp_register_style('cdn_example', "https://fonts.googleapis.com/css?family=Roboto:300,300italic,400,500,700%7cCourgette%7cRaleway:400,700,500%7cCourgette%7cLato:700");
  wp_enqueue_style('cdn_example');
  wp_register_style('cdn_example1', "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons");
  wp_enqueue_style('cdn_example1');
  
  wp_register_style('cdn_example2', "//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css");
  wp_enqueue_style('cdn_example2');
  
  /*wp_register_style('slidesjs_example', plugins_url('css/style.css', __FILE__));
  wp_enqueue_style('slidesjs_example');
  wp_register_style('slidesjs_example1', plugins_url('css/tmm_form_wizard_layout.css', __FILE__));
  wp_enqueue_style('slidesjs_example1');
  wp_register_style('slidesjs_fonts', plugins_url('css/grid.css', __FILE__));
  wp_enqueue_style('slidesjs_fonts');*/

}





add_shortcode("internshipplugin", "intfwds_manager");

function intfwds_manager() {
	if (session_status() === PHP_SESSION_NONE) { session_start(); }
	$plugins_url = plugins_url();
	//print_r($plugins_url);
	
//	print_r($_SESSION);
//	exit();
	
	
	 if(empty($_SESSION['second_stage']) && isset($_GET['msg'])!='success'){
       
      include('step1.php');
    }
    if(isset($_SESSION['second_stage']) && empty($_SESSION['second_three']) && isset($_GET['msg'])!='success'){
		
      include('step2.php');
    }
		if(isset($_GET['msg'])=='success'){
			
      include('step3.php');
   }
		
	
}


?>
