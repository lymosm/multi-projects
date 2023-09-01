<?php
/**
 * Plugin Name: receive cart data
 * Plugin URI: /
 * Author: lymos
 * Author URI: /
 * Description: receive cart data
 * Version: 1.0.1
 * License: GNU Public License
 */
class rorClass{

	public $wol_obj = null;
	public $front_obj = null;
	public $admin_obj = null;
	const SUFFIX = '';
	public $db;
	const ROR_VERSION = '1.0.1';
	public $host_key = 'ror_host';
	public $api_key = 'ror_api_key';

	public function __construct(){
		$this->_init();
	}

	private function _init(){
		global $wpdb;
		$this->db = $wpdb;
		$this->_initPath();
		$this->_requireFile();
		$this->_addHooks();
		$this->_initScript();
	}

	private function _addHooks(){
		
		add_action('admin_menu', array($this->admin_obj, 'registerMenu' ), 99);
		/*
		add_action('wp_ajax_ajaxrorBackupDb', [$this->admin_obj, 'ajaxrorBackupDb']);
		add_action('wp_ajax_ajaxrorBackupFile', [$this->admin_obj, 'ajaxrorBackupFile']);
		*/
		register_activation_hook(__FILE__, [$this, 'activate']);
		
	}

	public function activate(){
		$this->_createTable();
	}

	private function _createTable(){
		global $wpdb;

		// $sql0 = 'delete from `' . $wpdb->prefix . 'receive_product`';
		// $wpdb->query($sql0);

		//$sql3 = 'alter TABLE `' . $wpdb->prefix . 'receive_product` drop index `origin_session_key`';
		//$wpdb->query($sql3);

		//$sql4 = 'alter TABLE `' . $wpdb->prefix . 'receive_product` add column `cookie` varchar(1000) not null default ""';
		//$wpdb->query($sql4);

		// $sql = 'alter TABLE `' . $wpdb->prefix . 'receive_product` add column `origin_host` varchar(255) not null default ""';
		
		$sql = 'CREATE TABLE `' . $wpdb->prefix . 'receive_product` ' . '
(
	`id` int(11) not null auto_increment,
	`origin_session_key` varchar(255) not null default "",
	`origin_product_id` int(11) not null default 0,
	`origin_variation_id` int(11) not null default 0,
	`origin_variation_name` varchar(255) not null default "",
	`origin_product_name` varchar(255) not null default "",
	`origin_product_image` varchar(255) not null default "",
	`origin_product_post_name` varchar(255) not null default "",
	`origin_product_price` varchar(255) not null default "",
	`origin_product_qty` varchar(255) not null default "",
	`origin_host` varchar(255) not null default "",
	`cookie` varchar(1000) not null default "",
	
	`target_session_key` varchar(60) not null default "",
	`target_product_id` int(11) not null default 0,
	`target_product_name` varchar(255) not null default "",
	`target_variation_id` int(11) not null default 0,
	`target_variation_name` varchar(255) not null default "",
	`order_id` int(11) not null default 0,

	`status` tinyint(1) not null default 0,
	`added_by` int(11) not null default 0,
	`added_date` datetime default null,
	primary key(`id`)
)ENGINE=InnoDB CHARSET=utf8mb4 collate=utf8mb4_unicode_ci;';

		$wpdb->query($sql);

		/*
		$sql2 = 'CREATE TABLE `' . $wpdb->prefix . 'receive_order` ' . '
(
	`id` int(11) not null auto_increment,
	`order_id` int(11) not null default 0,
	`added_by` int(11) not null default 0,
	`added_date` datetime default null,
	primary key(`id`),
	unique key(order_id)
)ENGINE=InnoDB CHARSET=utf8mb4 collate=utf8mb4_unicode_ci;';
		$wpdb->query($sql2);
		*/

		// $sql3 = 'alter TABLE `' . $wpdb->prefix . 'receive_product` add column `origin_product_image` varchar(255) not null default ""';
		// $wpdb->query($sql3);
	}


	private function _initPath(){
		define('ROR_DIR', dirname(__FILE__));
		define('ROR_PATH', __FILE__);
		define('ROR_URL', plugins_url('', __FILE__));
	}

	private function _initScript(){
		if(is_admin()){
			add_action('admin_enqueue_scripts', [$this, 'adminScript']);
		}else{
			add_action('wp_enqueue_scripts', [$this, 'frontScript']);
		}
	}

	public function frontScript(){
		// wp_register_style( 'ror-front-style', plugins_url( 'assets/css/wolFront' . self::SUFFIX . '.css', ROR_PATH ), [], self::ROR_VERSION );
        // wp_enqueue_style( 'ror-front-style' );
		// wp_enqueue_script( 'ror-front-script', plugins_url( 'assets/js/wolFront' . self::SUFFIX . '.js', ROR_PATH), [], self::ROR_VERSION, true );

	}

	private function _requireFile(){
		if(is_admin()){
			$this->_requireAdminFile();
    	}else{
			$this->_requireFrontFile();
    	}
	}

	private function _requireAdminFile(){
    	require_once ROR_DIR . '/lib/rorAdmin.php';
    	$this->admin_obj = new rorAdmin($this);
    }

	private function _requireFrontFile(){
		require_once ROR_DIR . '/lib/rorFront.php';
    	$this->front_obj = new rorFront($this);
	}

	public function adminScript(){
		wp_register_style( 'ror-admin-style', plugins_url( 'assets/css/rorAdmin' . self::SUFFIX . '.css', ROR_PATH ), [], self::ROR_VERSION );
        wp_enqueue_style( 'ror-admin-style' );
		wp_enqueue_script( 'ror-admin-js', plugins_url( 'assets/js/rorAdmin' . self::SUFFIX . '.js', ROR_PATH), [], self::ROR_VERSION, true );
	}
}
new rorClass;
