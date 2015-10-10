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
	private $tupuk_plugin_path;

	function __construct() {
		
		$this->tupuk_plugin_path = plugins_url( 'tupuk-'.($this->tupuk_tag));
		//register third party and own scripts to be included
		$this->register_vendor_code();
		$this->register_widget_code();
		
		//hook to insert code on admin page
		add_action( 'admin_menu', array($this, 'setup_admin_page') );
		
		//hook to insert code on blog page
		add_action( 'wp_footer', array($this, 'blog_page_code') );

		// Add settings link on plugin page
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", array($this, 'your_plugin_settings_link') );

	}
	
	function blog_page_code(){ 
		
		include 'common/views/on-blog-page.php';
	}

	function setup_admin_page() {
		add_options_page('Tupuk '.($this->tupuk_label).' Settings', 'Tupuk '.($this->tupuk_label), 'manage_options', 'tupuk-'.($this->tupuk_tag),  array($this, 'add_admin_page'));
		add_action( 'admin_init', array($this, 'register_settings') ); //call register settings function
	}

	function add_admin_page(){
		$this->enque_admin_code();

		include 'widget/layouts.php';
		include 'common/views/admin-screen.php';

	}
	

	function your_plugin_settings_link($links) { 
	  $settings_link = '<a href="options-general.php?page=tupuk-'.($this->tupuk_tag).'">Settings</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
	}

	

	function register_widget_code(){
		//register the script that is common for all tupuk plugins
		wp_register_script( 'client-core', plugins_url( 'tupuk-'.($this->tupuk_tag).'/common/scripts/client-core.js' ));
		wp_register_script( 'admin-core', plugins_url( 'tupuk-'.($this->tupuk_tag).'/common/scripts/admin-core.js' ));
	}


	function register_vendor_code(){

		
		wp_register_script( 'tupuk-angular', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/angular.min.js' ));
		wp_register_script( 'tupuk-angular-toggle-switch', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/angular-toggle-switch.min.js' ));		
		wp_register_script( 'tupuk-bootstrap', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/bootstrap.min.js'));
		wp_register_script( 'tupuk-angular-animate', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/angular-animate.min.js' ));
		wp_register_script( 'tupuk-angular-ui-bootstrap', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/ui-bootstrap-tpls-0.13.4.min.js'));
		wp_register_script( 'tupuk-angular-base64', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/angular-base64.min.js'));
		wp_register_script( 'tupuk-angular-formly', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/formly.min.js'));
		wp_register_script( 'tupuk-api-check', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/api-check.min.js'));
		wp_register_script( 'tupuk-formly-bootstrap', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/scripts/angular-formly-templates-bootstrap.min.js'));

		wp_register_style( 'tupuk-bootstrap', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/styles/bootstrap.min.css'));
		wp_register_style( 'tupuk-angular-toggle-switch', plugins_url( 'tupuk-'.($this->tupuk_tag).'/vendor/styles/angular-toggle-switch.css'));
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

		wp_enqueue_script('admin-core');
	}
	function register_settings() {
		register_setting( 'tupuk-'.($this->tupuk_tag).'-options', 'tupuk_settings' );
		register_setting( 'tupuk-'.($this->tupuk_tag).'-options', 'tupuk_template' );
		register_setting( 'tupuk-'.($this->tupuk_tag).'-options', 'tupuk_active' );
		register_setting( 'tupuk-'.($this->tupuk_tag).'-options', 'tupuk_desktop_layout' );
	}

	function get_current_layout(){
		$decoded_settings = json_decode(base64_decode(get_option('tupuk_settings')));
		return $decoded_settings->layout;
	}

	function get_current_template(){
		//return the current 
		$layout = $this->get_current_layout();

		$encoded_templates = get_option("tupuk_template");
		

		$decoded_templates = json_decode(base64_decode($encoded_templates), true);
		
		$encoded_template = $decoded_templates[$layout];
		//return ($layout).'-BLAH';
		return base64_decode($encoded_template);
	}

	function get_container_css_path(){
		return ($this->tupuk_plugin_path)."/common/styles/container.css";
	}

	function get_layout_css_path(){
		return ($this->tupuk_plugin_path)."/widget/layouts/".($this->get_current_layout())."/".($this->get_current_layout())."-style.css";
	}
}

$tupuk_yes_no_popup_plugin = new TupukYesNoPopuplugin();
?>


