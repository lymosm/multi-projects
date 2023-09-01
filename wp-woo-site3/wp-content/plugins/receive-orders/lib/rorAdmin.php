<?php
class rorAdmin{
	public $ror_obj = null;
	public $obj = null;
	public function __construct($obj){
		$this->obj = $obj;
		$this->init();
	}

	public function init(){
		$this->_addHooks();
	}

	private function _addHooks(){
		add_action('wp_ajax_ajaxRorSettingSave', [$this, 'ajaxRorSettingSave']);
		add_action( 'woocommerce_order_edit_status', [$this, 'actionChangeOrderStatus'], 10, 2 );
	}

	public function actionChangeOrderStatus($order_id, $status = ''){
		if(! $order_id){
			return ;
		}

		$origin = $this->_getRelateByOrder($order_id);
		// $host = get_option($this->obj->host_key);
		$host = $origin['origin_host'];
		$api_key = get_option($this->obj->api_key);
		$url = $host . '/wp-json/post-orders/v1/update';
		
		// 'on-hold', 'pending', 'failed', 'cancelled' 'processing' : 'completed'
		$params = [
			'sslverify' => false,
			'body' => [
				'api_key' => $api_key,
				'order_id' => $order_id,
				'order_status' => $status
			]
			
		];

		$res = wp_remote_post($url, $params);

		if(is_wp_error($res)){
			echo "\n" . $res->get_error_message();
			exit;
		}
		if($res['response']['code'] != 200){
			return ;
		}
		$ret = json_decode($res['body'], true);
		if(isset($ret['status']) && $ret['status'] == 'success'){

		}

	}

	private function _getRelateByOrder($order_id){
		 
		$sql = 'select origin_product_id, origin_host, origin_product_image, origin_variation_id, origin_variation_name, origin_product_qty, origin_product_name, origin_product_post_name, origin_product_price from ' . $this->obj->db->prefix . 'receive_product where order_id = %d limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $order_id);
		$data = $this->obj->db->get_row($sql_pre, ARRAY_A);
		return $data;
	}

	/*
    * Admin Menu add function
    */
    public function registerMenu() {
    	
		add_menu_page(__( 'Receive Orders', 'ror' ), __( 'Receive Orders', 'ror' ), 'edit_posts', 'ror_setting', [$this, 'setting']);
		
	}

	public function ajaxRorSettingSave(){
		$post_key = trim(sanitize_text_field($_POST['ror_host']));
		$old = get_option($this->obj->host_key);
		if($old !== null){
			// update_option($this->obj->host_key, $post_key);
		}else{
			// add_option($this->obj->host_key, $post_key);
		}

		$api_key = trim(sanitize_text_field($_POST['ror_api_key']));
		$old = get_option($this->obj->api_key);
		if($old !== null){
			update_option($this->obj->api_key, $api_key);
		}else{
			add_option($this->obj->api_key, $api_key);
		}
		return wp_send_json(['status' => 1, 'data' => __('save success', 'por')]);
	}

	public function setting(){
		require_once ROR_DIR . '/view/rorList.php';
		$this->ror_obj = new rorList($this->obj);
		$this->ror_obj->list();
   	}

}