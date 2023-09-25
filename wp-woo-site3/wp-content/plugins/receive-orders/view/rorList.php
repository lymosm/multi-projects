<?php
class rorList{

	public $obj = null;

	public function __construct($obj){
		$this->obj = $obj;
	}


	public function list(){
		$host_val = get_option($this->obj->host_key);
		$api_key = get_option($this->obj->api_key);
		include_once(ROR_DIR . '/templates/setting.php');
    }
}