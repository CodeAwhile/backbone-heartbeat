<?php
/*
 * Plugin Name: Backbone Heartbeat Tests
 * Description: Basic plugin for testing Backbone and Heartbeat features in WordPress
 * Plugin URI: http://github.com/codeawhile/backbone-heartbeat/
 * Author: Will Anderson
 * Author URI: http://codeawhile.com/
 * Version: 0.1
 */

class Backbone_Heartbeat_Tests {
	public static function main() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'wp_print_scripts', array( __CLASS__, 'queue_scripts' ) );
		add_action( 'wp_ajax_backbone_heartbeat_get_data', array( __CLASS__, 'get_data' ) );
		add_action( 'heartbeat_received', array( __CLASS__, 'handle_heartbeat_tick' ), 10, 3 );
		add_action( 'heartbeat_nopriv_received', array( __CLASS__, 'handle_heartbeat_tick' ), 10, 3 );
	}

	public static function add_menu() {
		add_options_page( __( 'Backbone Heartbeat Tests' ), __( 'Backbone Heartbeat Tests' ), 'install_plugins', 'backbone-heartbeat-tests', array( __CLASS__, 'show_page' ) );
	}

	public static function show_page() {
	?>
	<div class="wrap">
		<h2><?php _e( 'Backbone Heartbeat Tests' ); ?></h2>
		<div id="backbone-heartbeat-tests-container"></div>
	</div>
	<?php
	}

	public static function queue_scripts() {
		wp_enqueue_script( 'backbone-heartbeat', plugins_url( 'js/backbone-heartbeat.js', __FILE__ ), array( 'backbone', 'jquery', 'underscore' ) );
	}

	public static function handle_heartbeat_tick( $response, $data, $screen_id ) {
		if ( !isset( $data['backbone-heartbeat-tests'] ) || 'settings_page_backbone-heartbeat-tests' != $screen_id ) {
			return $response;
		}
		return array_merge( $response, self::get_data() );
	}

	public static function get_data() {
		return array(
			'backbone-heartbeat-tests' => array(
				'random' => rand(),
				'time' => time()
			)
		);
	}
}

Backbone_Heartbeat_Tests::main();