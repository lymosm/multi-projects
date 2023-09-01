<?php
class porFront{
	public $obj = null;
	public $session_key;
	public function __construct($obj){
		$this->obj = $obj;
		$this->init();
	}

	public function init(){
		$this->_addHooks();
	}

	private function _addHooks(){
		add_filter( 'woocommerce_get_checkout_url', [$this, 'filterCheckoutUrl'], 10, 1 );
		add_action( 'wp_loaded', [$this, 'checkoutFinish']);
		add_action( 'woocommerce_add_to_cart', [$this, 'actionAddCart']);
	}

	public function actionAddCart($cart_item_key, $product_id = 0, $quantity = 0, $variation_id = 0, $variation = '', $cart_item_data = []){
		$key = 'por-' . $this->_getSessionKey();
		$val = json_encode($_COOKIE);
		$old = get_option($key);
		if($old !== null){
			update_option($key, $val);
		}else{
			add_option($key, $val);
		}
	}

	public function checkoutFinish(){
		if(! isset($_GET['ror_key']) || ! isset($_GET['ror_state'])){
			return ;
		}

		$session_key = trim($_GET['ror_key']);
		$callback_id = intval($_GET['ror_state']);
		if(! $session_key || ! $callback_id){
			return ;
		}
		$sql = 'select data, remote_order_status, local_order_id, remote_order_id from ' . $this->obj->db->prefix . 'por_order_callback where session_key = %s and status = 1 and id = %d limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $session_key, $callback_id);
		$temps = $this->obj->db->get_row($sql_pre, ARRAY_A);

		$remote_order_status = $temps['remote_order_status'];
		$data = $temps['data'];

		if(! $data){
			return ;
		}

		$checkout = WC()->checkout();
		/*
		Array
(
    [terms] => 0
    [createaccount] => 0
    [payment_method] => paypal
    [shipping_method] => Array
        (
            [0] => flat_rate:41
        )

    [ship_to_different_address] => 
    [woocommerce_checkout_update_totals] => 
    [billing_first_name] => fudu
    [billing_last_name] => ueueue
    [billing_country] => US
    [billing_state] => AL
    [billing_postcode] => 12345
    [billing_address_1] => 5555
    [billing_address_2] => 5555
    [billing_city] => 5555
    [billing_phone] => 555555
    [billing_email] => 555@34.com
    [order_comments] => 
    [shipping_first_name] => fudu
    [shipping_last_name] => ueueue
    [shipping_country] => US
    [shipping_state] => AL
    [shipping_postcode] => 12345
    [shipping_address_1] => 5555
    [shipping_address_2] => 5555
    [shipping_city] => 5555
    [language_code] => en
)

*/
		$temp = json_decode($data, true);
		$post_data = [];
		foreach($temp as $key => $rs){
			if(in_array($key, ['shipping_total', 'shipping_tax', 'shipping_method'])){
				// continue;
				$post_data[$key] = $rs;
			}
			foreach($rs as $k => $v){
				$post_data[$key . '_' . $k] = $v;
			}
		}
		error_log(print_r($temps, true) . "\r\n", 3, '/Volumes/dev/www/debug.log');
		error_log(print_r($post_data, true) . "\r\n", 3, '/Volumes/dev/www/debug.log');
		// wp_woocommerce_session_ed17d480cbbf24400ee208d2a1b288e1	t_36862253f91b43597383611f160d5f%7C%7C1687356084%7C%7C1687352484%7C%7Ce90d62a431ae572368ac50adb55aa97b	lo.wpp.com	/	6/21/2023, 10:01:24 PM	157 B	✓	✓	
		/*
		Array
(
    [woocommerce_cart_hash] => d962a1181cae72dc20ec029f16bb61ff
    [woocommerce_items_in_cart] => 1
    [LUMISESESSID] => 4JIFLFAGEH1D8ZQOAWTY
    [wp_woocommerce_session_ed17d480cbbf24400ee208d2a1b288e1] => t_325705b6875610226bba82a50d06d9||1687357303||1687353703||28fa905274b72323f36b73694e794e73
)
*/
		if(isset($_GET['por_c']) && ! $_COOKIE){

			$c = base64_decode($_GET['por_c']);
			$c_arr = json_decode($c, true);
			if($c_arr){
				$_COOKIE = $c_arr;
			}

		}

		WC()->initialize_session();
		// WC()->initialize_cart();
		$this_session_key = $this->_getSessionKey();
		error_log(print_r('init', true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/my-debug.log');
		error_log(print_r(date('Y-m-d H:i:s'), true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/my-debug.log');
		error_log(print_r($this_session_key, true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/my-debug.log');
		error_log(print_r(WC()->cart, true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/my-debug.log');
		error_log(print_r($_COOKIE, true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/my-debug.log');
		error_log(print_r($_SERVER, true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/my-debug.log');
		error_log(print_r($c_arr, true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/my-debug.log');

		add_action( 'woocommerce_checkout_create_order', [$this, 'beforeCreataOrder'], 10, 2  );

		if($temps['local_order_id']){
			$order_id = $temps['local_order_id'];
		}else{
			
			$order_id = $checkout->create_order($post_data);
		}
		

		if(! $order_id){
			return ;
		}
		$order    = wc_get_order( $order_id );

		if ( is_wp_error( $order_id ) ) {
			throw new Exception( $order_id->get_error_message() );
		}

		$sql_local = 'update ' . $this->obj->db->prefix . 'por_order_callback set local_order_id = %d where session_key = %s and status = 1 and id = %d ';
		$sql_local_pre = $this->obj->db->prepare($sql_local, $order_id, $session_key, $callback_id);
		$this->obj->db->query($sql_local_pre);

		$order->update_status($remote_order_status);

		if(in_array($remote_order_status, ['on-hold', 'processing', 'completed'])){
			$order->payment_complete();
			remove_filter( 'woocommerce_get_checkout_url', [$this, 'filterCheckoutUrl'], 10);
			$redirect = $order->get_checkout_order_received_url();
			$redirect = str_replace('cart&', '', $redirect);
			WC()->cart->empty_cart();
			wp_redirect($redirect);
		}
        
		exit;

	}

	public function beforeCreataOrder($order, $data){
		error_log(print_r($data, true) . "\r\n", 3, '/Volumes/dev/www/debug.log');
		if(isset($data['shipping_total'])){
			//$order->set_shipping_total($data['shipping_total']);

			//unset($data['shipping_total']);
		}

		if(isset($data['shipping_tax'])){
			//$order->set_shipping_tax($data['shipping_tax']);
			//unset($data['shipping_tax']);
		}

	}

	public function filterCheckoutUrl($url){
		$target_url = get_option($this->obj->host_key);
		if(! $target_url){
			return $url;
		}
		return $target_url . '/checkout/?cart=' . $this->_getSessionKey();
	}

	private function _getSessionKey(){
		if($this->session_key){
			return $this->session_key;
		}
		$session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
		$wc_session    = new $session_class();
		$cookie = $wc_session->get_session_cookie();
		if(! $cookie){
			return '';
		}
		$this->session_key = $cookie[0];
		return $this->session_key;
	}

	public function getCart($data){
		$id = trim($data['id']);
		if(! $id){
			return new WP_Error( 'no_id', 'Invalid Params', array( 'status' => 404 ) );
		}
		$sql = 'select session_value from ' . $this->obj->db->prefix . 'woocommerce_sessions where session_key = %s limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $id);
		$val = $this->obj->db->get_var($sql_pre);
		if(! $val){
			return new WP_Error( 'no_result', 'Invalid Results', array( 'status' => 404 ) );
		}
		$temp = unserialize($val);
		$cart = unserialize($temp['cart']);
		$products = [];
		$images = [];
		foreach($cart as $rs){
			$products[$rs['product_id']] = get_post($rs['product_id']);
			$pro = wc_get_product($rs['product_id']);
			$image_id = $pro->get_image_id();
			$image_url = wp_get_attachment_image_url($image_id, 'full');
			$images[$rs['product_id']] = $image_url;
		}

		$data = [
			'status' => 'success',
			'data' => $val,
			'products' => $products,
			'images' => $images
		];

		// Create the response object
		$response = new WP_REST_Response( $data );

		return $response;

	}

	public function updateOrder($data = []){
		$order_id = intval($data['order_id']);
		$api_key = trim($data['api_key']);
		$order_status = trim($data['order_status']);
		if(! $order_id || ! $api_key || ! $order_status){
			return new WP_Error( 'no_id', 'Invalid Params', array( 'status' => 404 ) );
		}
		if(get_option($this->obj->api_key) != $api_key){
			return new WP_Error( 'api_error', 'Invalid Request', array( 'status' => 404 ) );
		}
		$sql = 'select local_order_id from ' . $this->obj->db->prefix . 'por_order_callback where remote_order_id = %d limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $order_id);
		$local_order_id = $this->obj->db->get_var($sql_pre);
		if(! $local_order_id){
			return new WP_Error( 'api_error', 'Invalid Order Id', array( 'status' => 404 ) );
		}
		$order = wc_get_order($local_order_id);
		$ret = $order->set_status($order_status);
		$order->save();
		if($ret === false){
			$res = [
				'status' => 'failed',
				'data' => ''
			];
		}else{
			$res = [
				'status' => 'success',
				'data' => $ret
			];
		}
		$response = new WP_REST_Response( $res );

		return $response;

	}

	/**
	 * 跨诚音乐科技
	 */
	public function createOrder($data = []){
		

		$key = trim($data['session_key']);
		$api_key = trim($data['api_key']);
		$remote_order_id = intval($data['remote_order_id']);
		$remote_order_status = trim($data['remote_order_status']);
		if(! $key || ! $api_key || ! $remote_order_id || ! $remote_order_status){
			return new WP_Error( 'no_id', 'Invalid Params', array( 'status' => 404 ) );
		}
		if(get_option($this->obj->api_key) != $api_key){
			return new WP_Error( 'api_error', 'Invalid Request', array( 'status' => 404 ) );
		}
		$sql = 'select session_value from ' . $this->obj->db->prefix . 'woocommerce_sessions where session_key = %s limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $key);
		$val = $this->obj->db->get_var($sql_pre);

		if(! $val){
			 return new WP_Error( 'no_result', 'Invalid Results', array( 'status' => 404 ) );
		}
		$checkout = WC()->checkout();
		$post_data = json_encode($data['data']);
		// $order_id = $checkout->create_order($post_data);

		// 过程：标记已经付款，返回成功，再跳转checkout 挈带标识，生成订单，完成。
		$sql_ex = 'select id from ' . $this->obj->db->prefix . 'por_order_callback where session_key = %s and remote_order_id = %d limit 1';
		$sql_ex_pre = $this->obj->db->prepare($sql_ex, $key, $remote_order_id);
		$oid = $this->obj->db->get_var($sql_ex_pre);
		$insert_id = 0;
		if(! $oid){
			
			$data = [
				'session_key' => $key,
				'status' => 1,
				'remote_order_id' => $remote_order_id,
				'remote_order_status' => $remote_order_status,
				'data' => $post_data,
				'added_date' => date('Y-m-d H:i:s')
			];
			$ret = $this->obj->db->insert($this->obj->db->prefix . 'por_order_callback', $data);
			$insert_id = $this->obj->db->insert_id;
		}else{
			$insert_id = $oid;
			$data = [
				'remote_order_status' => $remote_order_status,
				'data' => $post_data,
			];
			$ret = $this->obj->db->update($this->obj->db->prefix . 'por_order_callback', $data, ['id' => $oid]);
			
		}
		$zkey = 'por-' . $key;
		$cookies = get_option($zkey);
		
		if($ret === false){
			$res = [
				'status' => 'failed',
				'data' => ''
			];
		}else{
			$res = [
				'status' => 'success',
				'data' => $insert_id,
				'cookie' => $cookies
			];
		}

		

		// Create the response object
		$response = new WP_REST_Response( $res );

		return $response;

	}



}