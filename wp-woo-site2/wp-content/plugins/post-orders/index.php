<?php
/**
 * Plugin Name: post cart data
 * Plugin URI: /
 * Author: lymos
 * Author URI: /
 * Description: post cart data
 * Version: 1.0.1
 * License: GNU Public License
 */
class porClass{

	public $wol_obj = null;
	public $front_obj = null;
	public $admin_obj = null;
	const SUFFIX = '';
	const POR_VERSION = '1.0.1';
	public $host_key = 'por_host';
	public $api_key = 'por_api_key';
	public $db;

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
		add_action('wp_ajax_ajaxLybpBackupDb', [$this->admin_obj, 'ajaxLybpBackupDb']);
		add_action('wp_ajax_ajaxLybpBackupFile', [$this->admin_obj, 'ajaxLybpBackupFile']);
		*/
		register_activation_hook(__FILE__, [$this, 'activate']);
		
		add_action( 'rest_api_init', function () {

			register_rest_route( 'post-orders/v1', '/cart/(?P<id>.*)', array(
			  'methods' => 'GET',
			  'callback' => [$this->front_obj, 'getCart'],
			  // 'permission_callback' => '__return_true',
			) );

			register_rest_route( 'post-orders/v1', '/create', array(
				'methods' => 'POST',
				'callback' => [$this->front_obj, 'createOrder'],
				// 'permission_callback' => '__return_true',
			  ) );

			  register_rest_route( 'post-orders/v1', '/update', array(
				'methods' => 'POST',
				'callback' => [$this->front_obj, 'updateOrder'],
				// 'permission_callback' => '__return_true',
			  ) );
		  } );
	}

	public function activate(){
		$this->_createTable();
	}

	private function _createTable(){
		global $wpdb;

		//$sql0 = 'delete from `' . $wpdb->prefix . 'por_order_callback`';
		//$wpdb->query($sql0);

		//$sql3 = 'alter TABLE `' . $wpdb->prefix . 'por_order_callback` drop index `session_key`';
		// $wpdb->query($sql3);
		//$sql4 = 'alter TABLE `' . $wpdb->prefix . 'por_order_callback` add column `local_order_id` int(11) not null default 0';
		//$wpdb->query($sql4);

		//$sql5 = 'alter TABLE `' . $wpdb->prefix . 'por_order_callback` add column `remote_order_id` int(11) not null default 0';
		//$wpdb->query($sql5);
		//$sql6 = 'alter TABLE `' . $wpdb->prefix . 'por_order_callback` add column `remote_order_status` varchar(60) not null default ""';
		//$wpdb->query($sql6);


		$sql = 'CREATE TABLE `' . $wpdb->prefix . 'por_order_callback` ' . '
(
	`id` int(11) not null auto_increment,
	`session_key` varchar(60) not null default "",
	`data` text default null,
	`status` tinyint(1) not null default 0 comment "0.default 1.paid",
	`local_order_id` int(11) not null default 0,
	`remote_order_id` int(11) not null default 0,
	`remote_order_status` varchar(60) not null default "",
	`added_by` int(11) not null default 0,
	`added_date` datetime default null,
	primary key(`id`)
	
)ENGINE=InnoDB CHARSET=utf8mb4 collate=utf8mb4_unicode_ci;';
		$wpdb->query($sql);

		
	}


	private function _initPath(){
		define('POR_DIR', dirname(__FILE__));
		define('POR_PATH', __FILE__);
		define('POR_URL', plugins_url('', __FILE__));
	}

	private function _initScript(){
		if(is_admin()){
			add_action('admin_enqueue_scripts', [$this, 'adminScript']);
		}else{
			add_action('wp_enqueue_scripts', [$this, 'frontScript']);
		}
	}

	public function frontScript(){
		// wp_register_style( 'por-front-style', plugins_url( 'assets/css/wolFront' . self::SUFFIX . '.css', POR_PATH ), [], self::POR_VERSION );
        // wp_enqueue_style( 'por-front-style' );
		// wp_enqueue_script( 'por-front-script', plugins_url( 'assets/js/wolFront' . self::SUFFIX . '.js', POR_PATH), [], self::POR_VERSION, true );

	}

	private function _requireFile(){
		if(is_admin()){
			$this->_requireAdminFile();
    	}else{
			$this->_requireFrontFile();
    	}
	}

	private function _requireAdminFile(){
    	require_once POR_DIR . '/lib/porAdmin.php';
    	$this->admin_obj = new porAdmin($this);
    }

	private function _requireFrontFile(){
		require_once POR_DIR . '/lib/porFront.php';
    	$this->front_obj = new porFront($this);
	}

	public function adminScript(){
		wp_register_style( 'por-admin-style', plugins_url( 'assets/css/porAdmin' . self::SUFFIX . '.css', POR_PATH ), [], self::POR_VERSION );
        wp_enqueue_style( 'por-admin-style' );
		wp_enqueue_script( 'por-admin-js', plugins_url( 'assets/js/porAdmin' . self::SUFFIX . '.js', POR_PATH), [], self::POR_VERSION, true );
	}
}
new porClass;
