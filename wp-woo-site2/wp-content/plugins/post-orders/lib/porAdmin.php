<?php
class porAdmin{
	public $obj = null;
	public $por_obj = null;
	public function __construct($obj){
		$this->obj = $obj;
		$this->init();
	}

	public function init(){
		$this->_addHooks();
	}

	private function _addHooks(){
		add_action('wp_ajax_ajaxPorApiKey', [$this, 'ajaxPorApiKey']);
		add_action('wp_ajax_ajaxPorSettingSave', [$this, 'ajaxPorSettingSave']);
	}

	public function ajaxPorSettingSave(){
		$post_key = trim(sanitize_text_field($_POST['por_host']));
		$old = get_option($this->obj->host_key);
		if($old !== null){
			update_option($this->obj->host_key, $post_key);
		}else{
			add_option($this->obj->host_key, $post_key);
		}

		$api_key = trim(sanitize_text_field($_POST['por_api_key']));
		$old = get_option($this->obj->api_key);
		if($old !== null){
			update_option($this->obj->api_key, $api_key);
		}else{
			add_option($this->obj->api_key, $api_key);
		}
		return wp_send_json(['status' => 1, 'data' => __('save success', 'por')]);
	}

	public function ajaxPorApiKey(){
		echo md5(uniqid());
		exit;
	}
   
	/*
    * Admin Menu add function
    */
    public function registerMenu() {
    	
		add_menu_page(__( 'Post Orders', 'por' ), __( 'Post Orders', 'por' ), 'edit_posts', 'por_setting', [$this, 'setting']);
		
	}

	public function setting(){
		require_once POR_DIR . '/view/porList.php';
		$this->por_obj = new porList($this->obj);
		$this->por_obj->list();
   	}

}