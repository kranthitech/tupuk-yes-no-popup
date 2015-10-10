<?php
/*
Plugin Name: Tupuk Yes No Popup
Description: Adds a well designed popup that makes an irresistible offer and asks a yes or no question
Author: Kranthi Kiran
Version: 0.1
*/
class TupukYesNoPopuplugin{

	private $tupuk_tag = "yes-no-popup";
	private $tupuk_label = "Yes No Popup";


	function __construct() {
		
		
		//hook to insert code on admin page
		add_action( 'admin_menu', array($this, 'plugin_admin_add_page') );
		

		//hook to insert code on blog page
		add_action( 'wp_footer', array($this, 'blog_page_code') );

		register_vendor_code();
		register_widget_code();

		// Add settings link on plugin page
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", array($this, 'your_plugin_settings_link') );


	}
	
	function blog_page_code(){
		include 'common/views/on-blog-page.php';
	}

	function plugin_admin_add_page() {
		add_options_page('Tupuk '.($this->tupuk_label).' Settings', 'Tupuk '.($this->tupuk_label), 'manage_options', 'tupuk_'.($this->tupuk_tag),  array($this, 'plugin_options_page'));
		add_action( 'admin_init', array($this, 'register_settings') ); //call register settings function
	}

	

	function your_plugin_settings_link($links) { 
	  $settings_link = '<a href="options-general.php?page=tupuk_settings">Settings</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
	}

	function plugin_options_page(){
		enque_admin_code();
		$tupuk_plugin_path = plugins_url( 'tupuk-'.($this->tupuk_tag));
		include 'widget/layouts.php';
		include 'common/views/admin-screen.php';
	}

	function register_widget_code(){
		//register the script that is common for all tupuk plugins
		wp_register_script( 'tupuk-client-core', plugins_url( 'tupuk-test/common/scripts/tupuk-client-core.js' ));
		wp_register_script( 'tupuk-admin-core', plugins_url( 'tupuk-test/common/scripts/tupuk-admin-core.js' ));
	}


	function register_vendor_code(){

		
		wp_register_script( 'tupuk-angular', plugins_url( 'tupuk-test/common/scripts/angular.min.js' ));
		wp_register_script( 'tupuk-angular-toggle-switch', plugins_url( 'tupuk-test/common/scripts/angular-toggle-switch.min.js' ));		
		wp_register_script( 'tupuk-bootstrap', plugins_url( 'tupuk-test/common/scripts/bootstrap.min.js'));
		wp_register_script( 'tupuk-angular-animate', plugins_url( 'tupuk-test/common/scripts/angular-animate.min.js' ));
		wp_register_script( 'tupuk-angular-ui-bootstrap', plugins_url( 'tupuk-test/common/scripts/ui-bootstrap-tpls-0.13.4.min.js'));
		wp_register_script( 'tupuk-angular-base64', plugins_url( 'tupuk-test/common/scripts/angular-base64.min.js'));
		wp_register_script( 'tupuk-angular-formly', plugins_url( 'tupuk-test/common/scripts/formly.min.js'));
		wp_register_script( 'tupuk-api-check', plugins_url( 'tupuk-test/common/scripts/api-check.min.js'));
		wp_register_script( 'tupuk-formly-bootstrap', plugins_url( 'tupuk-test/common/scripts/angular-formly-templates-bootstrap.min.js'));

		wp_register_style( 'tupuk-bootstrap', plugins_url( 'tupuk-test/common/styles/bootstrap.min.css'));
		wp_register_style( 'tupuk-angular-toggle-switch', plugins_url( 'tupuk-test/common/styles/angular-toggle-switch.css'));
	}

	function enque_admin_code(){
		wp_enqueue_style('tupuk-bootstrap');
		wp_enqueue_style('tupuk-angular-toggle-switch');
		wp_enqueue_script('tupuk-bootstrap');
		wp_enqueue_script('tupuk-angular');
		wp_enqueue_script('tupuk-angular-base64');
		wp_enqueue_script('tupuk-angular-animate');
		wp_enqueue_script('tupuk-api-check');
		wp_enqueue_script('tupuk-angular-formly');
		wp_enqueue_script('tupuk-formly-bootstrap');
		wp_enqueue_script('tupuk-angular-ui-bootstrap');
		wp_enqueue_script('tupuk-angular-toggle-switch');

		wp_enqueue_script('tupuk-admin-core');
	}
	function register_settings() {
		register_setting( 'tupuk-options', 'tupuk_settings' );
		register_setting( 'tupuk-options', 'tupuk_template' );
		register_setting( 'tupuk-options', 'tupuk_active' );
		register_setting( 'tupuk-options', 'tupuk_desktop_layout' );
	}
}

$tupuk_yes_no_popup_plugin = new TupukYesNoPopuplugin();
?>


