<?php
class rorFront{
	public $obj = null;
	public $session_key = '';
	public function __construct($obj){
		$this->obj = $obj;
		$this->init();
	}

	public function init(){
		$this->_addHooks();
	}

	private function _addHooks(){
		add_action( 'wp_loaded', [$this, 'getCheckoutData'], 0);
		add_filter( 'woocommerce_cart_item_name', [$this, 'filterCartItemName'], 10, 3 );
		add_action( 'woocommerce_payment_complete', [$this, 'paymentComplete']);
		
		add_filter('raw_woocommerce_price', [$this, 'filterProductPrice'], 10, 2);
		add_filter('woocommerce_cart_item_price', [$this, 'updateCartPrice'], 99, 3);
		add_filter('woocommerce_cart_item_subtotal', [$this, 'updateCartItemTotal'], 99, 3);
		add_filter('woocommerce_cart_subtotal', [$this, 'filterCartSubtotal'], 99, 3);
		add_filter('woocommerce_cart_get_total', [$this, 'filterCartTotalVal'], 99, 1);

		add_filter( 'woocommerce_order_get_items',  [$this, 'filterOrderItems'], 10, 3);

		// add_filter( 'woocommerce_order_get_total', [$this, 'filterTotal'], 10, 2);
		add_filter( 'woocommerce_get_return_url', [$this, 'filterReturnUrl'], 10, 2 );
		add_filter( 'woocommerce_get_checkout_order_received_url', [$this, 'filterReturnOrderUrl'], 10, 2 );

		add_action( 'woocommerce_checkout_update_order_meta', [$this, 'afterCreateOrder'], 10, 2);
		// add_action( 'woocommerce_after_order_object_save', [$this, 'orderSave']);

		add_filter( 'woocommerce_cart_item_thumbnail', [$this, 'filterCartImage'], 10, 3 );
		// add_filter( 'woocommerce_cart_item_permalink', [$this, 'filterCartProductLink'], 10, 3 );

		add_action( 'woocommerce_checkout_order_created', [$this, 'afterCreateOrder2']);

		// add_action( 'woocommerce_before_order_object_save', [$this,  'beforeOrderSave']);
// do_action( 'woocommerce_after_' . $this->object_type . '_object_save', $this, $this->data_store );

 		add_action( 'woocommerce_order_status_changed', [$this, 'statusChanged'], 10, 4 );

		add_filter( 'ppcp_ditch_items_breakdown', [$this, 'filterPPC'], 10, 2 );

		add_filter( 'woocommerce_cart_get_subtotal', [$this, 'filterSubtotal'] );


		// add_filter( 'woocommerce_order_amount_item_subtotal', [$this, 'filterItemsubtotal'], 10, 5  );
		//add_filter( 'woocommerce_order_amount_item_total', [$this, 'filterItemtotal'], 10, 5 );
		//add_filter( 'woocommerce_order_amount_line_total', [$this, 'filterLinetotal'], 10, 5 );
		//add_filter( 'woocommerce_order_amount_line_subtotal', [$this, 'filterLinesubtotal'], 10, 5  );
		
		add_filter( 'woocommerce_get_cart_contents', [$this, 'filterGetcartContent'], 9999);


		add_action( 'wp_loaded', [$this, 'checkRedirectOrigin'], 9999999);

		// add_action( 'wp_loaded', [$this, 'paymentComplete']); // debug
		// WC()->cart->empty_cart();
	}

	public function filterGetcartContent($arr){
		foreach($arr as & $rs){
			$origin = $this->_getRelateProduct($rs['product_id']);

			if(! $origin){
				continue;
			}
			$rs['line_subtotal'] = $origin['origin_product_price'] * $origin['origin_product_qty'];
			$rs['line_total'] = $origin['origin_product_price'] * $origin['origin_product_qty'];
		}
		return $arr;
	}

	public function filterItemsubtotal($subtotal, $obj, $item, $inc_tax, $round){

		return $subtotal;
	}

	public function filterItemtotal($subtotal, $obj, $item, $inc_tax, $round){

		return $subtotal;
	}

	public function filterLinetotal($subtotal, $obj, $item, $inc_tax, $round){

		return $subtotal;
	}

	public function filterLinesubtotal($subtotal, $obj, $item, $inc_tax, $round){

		return $subtotal;
	}

	public function filterSubtotal($cart_subtotal){
		$cart = WC()->cart->cart_contents;

		$total = 0;
		foreach($cart as $rs){
			$origin = $this->_getRelateProduct($rs['product_id']);

			if(! $origin){
				return $cart_subtotal;
			}
			$total += $origin['origin_product_price'] * $origin['origin_product_qty'];
		}
		return round($total, 2);
	}

	public function filterPPC($ditch, $obj = null){
		return false;
	}

	public function filterReturnOrderUrl($return_url, $obj){

		if(! $obj){
			return $return_url;
		}

		if(! method_exists($obj, 'get_id')){
			return $return_url;
		}
		$order_id = $obj->get_id();
		
		$sql = 'select origin_session_key from ' . $this->obj->db->prefix . 'receive_product where order_id = %d limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $order_id);
		$price = $this->obj->db->get_var($sql_pre);

		if($price){
			if(strpos($return_url, 'por_callback') === false){
				$return_url .= '&por_callback=' . $price;
			}
			
		}

		return $return_url;
	}

	public function statusChanged($order_id, $from, $to, $obj = null){

		if($from == $to){
			return ;
		}

		$origin = $this->_getRelateByOrder($order_id);
		if(! $origin){
			return ;
		}
		// $host = get_option($this->obj->host_key);
		$host = $origin['origin_host'];
		if(! $host){
			return ;
		}
		$api_key = get_option($this->obj->api_key);
		$url = $host . '/wp-json/post-orders/v1/update';


		// 'on-hold', 'pending', 'failed', 'cancelled' 'processing' : 'completed'
		$params = [
			'sslverify' => false,
			'body' => [
				'api_key' => $api_key,
				'order_id' => $order_id,
				'order_status' => $to
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

	public function beforeOrderSave($obj, $data = []){


	}

	public function afterCreateOrder2($order){
		$order_id = $order->get_id();
		$status = $order->get_status();
		
		$this->paymentComplete($order_id, true);
	
	}
	

	public function filterCartProductLink($link, $cart_item, $cart_item_ke){
		$origin = $this->_getRelateProduct($cart_item['product_id']);
		if(! $origin){
			return $link;
		}
		// return get_option($this->obj->host_key) . '/product/' . $origin['origin_product_post_name'];
		return $origin['origin_host'] . '/product/' . $origin['origin_product_post_name'];
	}

	public function filterCartImage($img, $cart_item, $cart_item_ke){
		$origin = $this->_getRelateProduct($cart_item['product_id']);
		if(! $origin){
			return $img;
		}
		return '<img width="1" height="1" src="' . $origin['origin_product_image'] . '" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wvs-archive-product-image" alt="">';
	}

	public function checkRedirectOrigin($ori_session_key = '', $order_id = 0){

		if(isset($_GET['wc-ajax']) && $_GET['wc-ajax'] == 'wc_stripe_verify_intent'){
			return ;
		}

		if(isset($_GET['redirect_to']) && $_GET['redirect_to']){
			return ;
		}
		
		if(! $ori_session_key){
			if(! isset($_GET['por_callback'])){
				return ;
			}
			$ori_session_key = trim($_GET['por_callback']);
		}
		if(! $ori_session_key){
			return ;
		}

		if(! $order_id){
			preg_match('/\/order-received\/(\d+)\//', $_SERVER['REQUEST_URI'], $matchs);
			if(! isset($matchs[1])){
				return ;
			}
			$order_id = intval($matchs[1]);
		}

		if(! $order_id){
			return ;
		}

		$order = wc_get_order($order_id);

		/*
		$is_paid = $order->is_paid();
		if(! $is_paid){
			$status = $order->get_status();
			if($status != 'on-hold'){
				return ;
			}
			
		}
		*/
		$origin = $this->_getRelateByOrder($order_id);

		$shipping = $order->get_address('shipping');
		$billing = $order->get_address();
		// $host = get_option($this->obj->host_key);
		$host = $origin['origin_host'];
		$api_key = get_option($this->obj->api_key);
		$url = $host . '/wp-json/post-orders/v1/create';
		if(! isset($shipping['email']) || ! $shipping['email']){
			$shipping = $billing;
		}else if(! $billing['email']){
			$billing = $shipping;
		}
		// 'on-hold', 'pending', 'failed', 'cancelled' 'processing' : 'completed'
		$params = [
			'sslverify' => false,
			'body' => [
				'session_key' => $ori_session_key,
				'api_key' => $api_key,
				'remote_order_id' => $order_id,
				'remote_order_status' => $order->get_status(),
				'data' => [
					'shipping' => $shipping,
					'billing' => $billing
				]
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
			$sql_update = 'update ' . $this->obj->db->prefix . 'receive_product set status = 1 where origin_session_key = %s and origin_host = %s';
			$sql_pre = $this->obj->db->prepare($sql_update, $ori_session_key, $origin['origin_host']);
			$this->obj->db->query($sql_pre);
			// $redirect_url = get_option($this->obj->host_key) . '/checkout/?ror_key=' . $ori_session_key;
			$host = $origin['origin_host'];
			$redirect_url = $host . '/checkout/?ror_key=' . $ori_session_key . '&ror_state=' . $ret['data'];
			
			wc_empty_cart();
			if ( ! wp_doing_ajax() ) {
				/*
				wp_safe_redirect(
					apply_filters( 'woocommerce_checkout_no_payment_needed_redirect', $order->get_checkout_order_received_url(), $order )
				);
				*/
				wp_redirect($redirect_url);
				exit;
			}
	
			wp_send_json(
				array(
					'result'   => 'success',
					'redirect' => $redirect_url
				)
			);
			exit;
		}else{
			return ;
		}


	}

	public function orderSave($obj, $data){
		


	}

	public function afterCreateOrder($order_id, $data = []){

		$session_key = $this->_getSessionKey();
		if(! $session_key){
			return ;
		}
		$sql = 'select origin_host from ' . $this->obj->db->prefix . 'receive_product where target_session_key = %s and status = 0 order by id desc limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $session_key);
		$data = $this->obj->db->get_row($sql_pre, ARRAY_A);

		if(! isset($data['origin_host'])){
			return ;
		}
		$meta = get_post_meta($order_id, 'por_host', true);
		if($meta === false || $meta === null){
			add_post_meta($order_id, 'por_host', $data['origin_host'], true);
		}else{
			update_post_meta($order_id, 'por_host', $data['origin_host']);
		}
		

		$sql_update = 'update ' . $this->obj->db->prefix . 'receive_product set order_id = ' . $order_id . ' where target_session_key = %s and status = 0 and origin_host = %s';
		$sql_pre = $this->obj->db->prepare($sql_update, $session_key, $data['origin_host']);

		$this->obj->db->query($sql_pre);
	}

	public function filterReturnUrl($return_url, $obj){
		if(! $obj){
			return $return_url;
		}

		if(! method_exists($obj, 'get_id')){
			return $return_url;
		}
		$order_id = $obj->get_id();
		
		$sql = 'select origin_session_key from ' . $this->obj->db->prefix . 'receive_product where order_id = %d limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $order_id);
		$price = $this->obj->db->get_var($sql_pre);

		if($price){
			if(strpos($return_url, 'por_callback') === false){
				$return_url .= '&por_callback=' . $price;
			}
		}

		return $return_url;
	}

	public function filterTotal($val, $obj){
		$order_id = $obj->get_id();
		$lines = $obj->get_items( 'line_item' );
		if(count($lines) > 1){
			return $val;
		}
		foreach($lines as $rs){
			$product_id = $rs->get_product_id();
			if(! $product_id){
				continue;
			}
			$sql = 'select origin_product_price from ' . $this->obj->db->prefix . 'receive_product where order_id = %d and target_product_id = %d limit 1';
			$sql_pre = $this->obj->db->prepare($sql, $order_id, $product_id);
			$price = $this->obj->db->get_var($sql_pre);
			if($price){
				return $price;
			}
		}


		return $val;
	}

	public function filterOrderItems($items, $obj, $types){
		if(! $items){
			return $items;
		}
		

		foreach($items as $id => $rs){
			if(method_exists($rs, 'set_subtotal')){
				/*
				$rs->set_subtotal(89);
				$rs->set_total(89);
				*/
			}
			
		}

		// error_reporting(E_ALL);
		// ini_set('display_errors', 'On');
		return $items;
	}

	public function filterCartTotalVal($value){
		$cart = WC()->cart->cart_contents;
		$total = 0;
		foreach($cart as $rs){
			$origin = $this->_getRelateProduct($rs['product_id']);
			if(! $origin){
				return $value;
			}
			$total += $origin['origin_product_price'] * $origin['origin_product_qty'];
		}
		// $packages                = WC()->shipping()->get_packages();
		// $chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
		$cost = WC()->cart->get_shipping_total();
		$discount = WC()->cart->get_discount_total();

		return round($total + $cost - $discount, 2);
	}

	public function filterCartSubtotal($cart_subtotal, $compound, $obj){
		$cart = $obj->cart_contents;
		$total = 0;
		foreach($cart as $rs){
			$origin = $this->_getRelateProduct($rs['product_id']);
			if(! $origin){
				return $cart_subtotal;
			}
			$total += $origin['origin_product_price'] * $origin['origin_product_qty'];
		}
		return wc_price(round($total, 2));
	}

	public function updateCartItemTotal($total, $cart_item, $cart_item_key){
		$origin = $this->_getRelateProduct($cart_item['product_id']);
		if(! $origin){
			return $total;
		}
		return wc_price(round($origin['origin_product_price'] * $origin['origin_product_qty'], 2));
	}

	public function updateCartPrice($price, $cart_item, $cart_item_key){
		$origin = $this->_getRelateProduct($cart_item['product_id']);
		if(! $origin){
			return $price;
		}
		return wc_price( $origin['origin_product_price']);
	}

	public function filterProductPrice($price, $original_price){
		return $price;
	}

	public function paymentComplete($order_id = null, $other = false){
		if(isset($_GET['wc-ajax']) && $_GET['wc-ajax'] == 'wc_stripe_verify_intent'){
			return ;
		}

		if(isset($_GET['redirect_to']) && $_GET['redirect_to']){
			return ;
		}
		$session_key = $this->_getSessionKey();
		if(! $session_key){
			return ;
		}

		$meta_host = get_post_meta($order_id, 'por_host', true);

		$sql = 'select origin_session_key, origin_host, cookie from ' . $this->obj->db->prefix . 'receive_product where status = 0 and target_session_key = %s and order_id = %d and origin_host = %s order by id desc limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $session_key, $order_id, $meta_host); // limit order id
		$ori_session_data = $this->obj->db->get_row($sql_pre, ARRAY_A);

		if(! $ori_session_data){
			return ;
		}

		// $cookie = $ori_session_data['cookie'];
		$ori_session_key = $ori_session_data['origin_session_key'];
		$host = $ori_session_data['origin_host'];
		if(! $ori_session_data){
			return ;
		}
		if(! trim($host)){
			// return ;
		}

		// $ori_session_key = '3bef5176a1aaa8de31935b2fbd45e654'; // debug
		// $order_id = 577255; // debug
		$order = wc_get_order($order_id);
		$shipping = $order->get_address('shipping');
		$billing = $order->get_address();
		$shipping_method = $order->get_shipping_method();
		$shipping_methods = $order->get_shipping_methods();
		$shipping_total = $order->get_shipping_total();
		$shipping_tax = $order->get_shipping_tax();
		$discount_total = $order->get_discount_total();
		$note = $order->get_customer_note();
		// $notes = $order->get_customer_order_notes();


		// $host = get_option($this->obj->host_key);
		$api_key = get_option($this->obj->api_key);
		$url = $host . '/wp-json/post-orders/v1/create';
		// $shipping no email
		if(! isset($shipping['email']) || ! $shipping['email']){
			// $shipping = $billing;
		} 
		/*
		if(! isset($billing['email']) || ! $billing['email']){
			$billing = $shipping;
		}
		*/
		$params = [
			'sslverify' => false,
			'body' => [
				'session_key' => $ori_session_key,
				'api_key' => $api_key,
				
				'remote_order_id' => $order_id,
				'remote_order_status' => $order->get_status(),
				'data' => [
					'shipping' => $shipping,
					'billing' => $billing,
					'shipping_method' => $shipping_method,
					'shipping_methods' => $shipping_methods,
					'shipping_total' => $shipping_total,
					'shipping_tax' => $shipping_tax,
					'discount_total' => $discount_total,
					'note' => $note
				]
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
			$remote_order_status = $order->get_status();
			if(in_array($remote_order_status, ['on-hold', 'processing', 'completed'])){
				$status_n = 1;
			}else{
				$status_n = 0;
			}
			$sql_update = 'update ' . $this->obj->db->prefix . 'receive_product set status = %d, order_id = ' . $order_id . ', cookie = %s where target_session_key = %s and status = 0 and origin_host = %s';
			$sql_pre = $this->obj->db->prepare($sql_update, $status_n, $ret['cookie'], $session_key, $meta_host );

			$this->obj->db->query($sql_pre);
			// $redirect_url = get_option($this->obj->host_key) . '/checkout/?ror_key=' . $ori_session_key;
			$redirect_url = $host . '/checkout/?ror_key=' . $ori_session_key . '&ror_state=' . $ret['data'];
			if($other){

				if ( ! wp_doing_ajax() ) {
					echo '<iframe src="' . $redirect_url . '"></iframe>';
				}else{
					$args_remote = [
						'sslverify' => false,
					];

					// wp_remote_get($redirect_url, $args_remote);
					$this->httpGet($redirect_url, $ret['cookie'], $host);
				}
				// exit; // debug
				return ; 
			}
			wc_empty_cart();
			if ( ! wp_doing_ajax() ) {
				/*
				wp_safe_redirect(
					apply_filters( 'woocommerce_checkout_no_payment_needed_redirect', $order->get_checkout_order_received_url(), $order )
				);
				*/
				wp_redirect($redirect_url);
				exit;
			}

			/*
			wp_send_json(
			array(
				'result'   => 'success',
				'redirect' => apply_filters( 'woocommerce_checkout_no_payment_needed_redirect', $order->get_checkout_order_received_url(), $order ),
			)
		);
		*/
	
			wp_send_json(
				array(
					'result'   => 'success',
					'redirect' => $redirect_url
				)
			);
			exit;
		}else{
			return ;
		}

	}

	public function httpGet($url, $cookie, $host){
		$ip_long = array(
			array('607649792', '608174079'), //36.56.0.0-36.63.255.255
			array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
			array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
			array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
			array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
			array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
			array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
			array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
			array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
			array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
			);
		$rand_key = mt_rand(0, 9);
		$ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
		// $header = array("Connection: Keep-Alive", "Host: " . $host, "Accept: text/html, application/xhtml+xml, */*", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3","User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)",'CLIENT-IP:'.$ip,'X-FORWARDED-FOR:'.$ip);
		$header = array("Connection: Keep-Alive", "Accept: text/html, application/xhtml+xml, */*", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3","User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)",'CLIENT-IP:'.$ip,'X-FORWARDED-FOR:'.$ip);

		$ch = curl_init();
		$cookie_sss = base64_encode($cookie);
		$cookie_arr = json_decode($cookie, true);
		$cookie_str = '';
		foreach($cookie_arr as $k => $v){
			$cookie_str .= $k . '=' . $v . ';';
		}

		$url .= '&por_c=' . $cookie_sss;

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
  		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie_str);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_POST, true);
		// curl_setopt($ch, CURLOPT_REFERER, $host);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $cookie_arr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		$info = curl_getinfo($ch);

		curl_close($ch);
	}

	private function _getRelateProduct($product_id){
		 
		$sql = 'select origin_product_id, origin_host, origin_product_image, origin_variation_id, origin_variation_name, origin_product_qty, origin_product_name, origin_product_post_name, origin_product_price from ' . $this->obj->db->prefix . 'receive_product where status = 0 and target_session_key = %s and target_product_id = %d limit 1';
		$session_key = $this->_getSessionKey();
		$sql_pre = $this->obj->db->prepare($sql, $session_key, $product_id);
		$data = $this->obj->db->get_row($sql_pre, ARRAY_A);
		return $data;
	}

	private function _getRelateByOrder($order_id){
		 
		$sql = 'select origin_product_id, origin_host, origin_product_image, origin_variation_id, origin_variation_name, origin_product_qty, origin_product_name, origin_product_post_name, origin_product_price from ' . $this->obj->db->prefix . 'receive_product where order_id = %d order by id desc limit 1';
		$sql_pre = $this->obj->db->prepare($sql, $order_id);
		$data = $this->obj->db->get_row($sql_pre, ARRAY_A);
		return $data;
	}

	public function filterCartItemName($name, $cart_item, $cart_item_key){
		

		$product_id = $cart_item['product_id'];
		$sql = 'select origin_product_id, origin_variation_id, origin_variation_name, origin_product_name, origin_product_post_name, origin_product_price from ' . $this->obj->db->prefix . 'receive_product where status = 0 and target_session_key = %s and target_product_id = %d limit 1';
		$session_key = $this->_getSessionKey();
		$sql_pre = $this->obj->db->prepare($sql, $session_key, $product_id);
		$data = $this->obj->db->get_row($sql_pre, ARRAY_A);
		if(isset($data['origin_product_name']) && $data['origin_product_name']){
			return $data['origin_product_name'];
		}

		return $name;
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

	public function getCheckoutData(){

		if(! isset($_GET['cart'])){
			return ;
		}
		$id = trim($_GET['cart']);
		if(! $id){
			return ;
		}
		$referer = $_SERVER['HTTP_REFERER'];
		if(! $referer){
			return ;
		}
		$info = parse_url($referer);
		if(! $info || ! $info['host']){
			return ;
		}
		$host = $info['scheme'] . '://' . $info['host'];

		// $host = get_option($this->obj->host_key);
		$url = $host . '/wp-json/post-orders/v1/cart/' . $id;


		$res = wp_remote_get($url, array('sslverify' => false));
		// error_log(print_r($url, true) . "\r\n", 3, ABSPATH . '/wp-content/uploads/aaa-debug.log');

		if(is_wp_error($res)){
			echo "\n" . $res->get_error_message();
			exit;
		}
		if($res['response']['code'] != 200){
			return ;
		}
		
		// $id = $host . '-' . $id;

		$session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
		$wc_session    = new $session_class();
		$cookie = $wc_session->get_session_cookie();
		$target_session_key = '';
		if($cookie){
			$target_session_key = trim($cookie[0]);
		}
		
		$session_obj = WC()->session;

		
		if(! $target_session_key){
			WC()->initialize_session();
			do_action( 'woocommerce_set_cart_cookies', true );
			WC()->session->save_data();
			$target_session_key = WC()->session->get_customer_unique_id();
			
		}
		
		
		// WC()->initialize_cart();
		$ret = json_decode($res['body'], true);

		if(isset($ret['status']) && $ret['status'] == 'success'){
			$data = unserialize($ret['data']);
			$cart = unserialize($data['cart']);
			$products = $ret['products'];
			$images = $ret['images'];
			
			$error = false;
			foreach($cart as $key => $rs){
				$insert_data = [];
				$product = $products[$rs['product_id']];
				$image = isset($images[$rs['product_id']]) ? $images[$rs['product_id']] : '';
				$insert_data['origin_session_key'] = $id;
				$insert_data['origin_product_image'] = $image;
				$insert_data['origin_product_id'] = $rs['product_id'];
				$insert_data['origin_variation_id'] = $rs['variation_id'] ? $rs['variation_id'] : 0;
				/*
				[variation] => Array
                (
                    [attribute_len] => Mine
                    [attribute_phon] => Phsie
                )
*/
				$insert_data['origin_variation_name'] = end($rs['variation']);
				$insert_data['origin_product_name'] = $product['post_title'];
				$insert_data['origin_product_post_name'] = $product['post_name'];
				$insert_data['origin_product_price'] = round($rs['line_subtotal'] / $rs['quantity'], 2);
				$insert_data['origin_product_qty'] = $rs['quantity'];
				$insert_data['origin_host'] = $host;

				$target_product = $this->_getOneProduct();
				$insert_data['target_session_key'] = $target_session_key;
				$insert_data['target_product_id'] = intval($target_product['ID']);
				$insert_data['target_product_name'] = $target_product['post_title'];
				$insert_data['target_variation_id'] = intval($target_product['v_id']);
				$insert_data['target_variation_name'] = $target_product['v_post_title'] ? $target_product['v_post_title'] : '';

				$sql_ex = 'select id from ' . $this->obj->db->prefix . 'receive_product where origin_session_key = %s and origin_product_id = %d and origin_variation_id = %d and status = 0 and origin_host = %s';
				$sql_ex_pre = $this->obj->db->prepare($sql_ex, $id, $rs['product_id'], $insert_data['origin_variation_id'], $host);
				$oid = $this->obj->db->get_var($sql_ex_pre);
				if($oid){
					$insert_ret = $this->obj->db->update($this->obj->db->prefix . 'receive_product', $insert_data, ['id' => $oid]);
				}else{
					$insert_data['added_date'] = date('Y-m-d H:i:s');
					$insert_ret = $this->obj->db->insert($this->obj->db->prefix . 'receive_product', $insert_data);
				}
				/*
				if($insert_ret === false){
					$error = true;
					continue;
				}else{
					$error = false;
				}
				*/

				$rs['product_id'] = $target_product['ID'];
				$rs['variation_id'] = $target_product['v_id'];

				$product_new = wc_get_product( $target_product['v_id'] ? $target_product['v_id'] : $target_product['ID'] );
				$data_hash = wc_get_cart_item_data_hash( $product_new );
				$rs['key'] = $data_hash;
				$rs['data_hash'] = $data_hash;

				foreach($rs['variation'] as $attr => & $attr_val){
					// $attr_val = $target_product['v_post_title'];
				}
				unset($cart[$key]);
				$cart[$data_hash] = $rs;

			}

			if(! $error){

				$sql = 'update ' . $this->obj->db->prefix . 'woocommerce_sessions set session_value = %s where session_key = %s';
				$data['cart'] = $cart;
				$new_data = serialize($data);

				// $sql_pre = $this->obj->db->prepare($sql, $new_data, $target_session_key);
				// $this->obj->db->query($sql_pre);

				$session_expiration = time() + intval( apply_filters( 'wc_session_expiration', 60 * 60 * 48 ) ); // 48 Hours.


				/*
				$this->obj->db->query(
					$this->obj->db->prepare(
						"INSERT INTO {$this->obj->db->prefix}woocommerce_sessions (`session_key`, `session_value`, `session_expiry`) VALUES (%s, %s, %d)
						ON DUPLICATE KEY UPDATE `session_value` = VALUES(`session_value`), `session_expiry` = VALUES(`session_expiry`)",
						$target_session_key,
						$new_data,
						$session_expiration
					)
				);
				*/
				$session_obj->set('cart', $cart);
			}	
			


			
		}
	}

	private function _getOneProduct(){
		$sql = 'select a.post_title, a.post_name, a.ID, b.ID as v_id, b.post_title as v_post_title from ' . $this->obj->db->prefix . 'posts as a
		left join ' . $this->obj->db->prefix . 'posts as b on a.ID = b.post_parent and b.post_type = "product_variation" where a.post_type = "product" and a.post_status = "publish" order by rand() limit 1';
		$ret = $this->obj->db->get_row($sql, ARRAY_A);
		return $ret;
	}

}