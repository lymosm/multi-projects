<?php
/*
Plugin Name: Xtoool Product Feed 
Plugin URI: https://www.xtoool.com/wordpress/product-feed/
Description: Manage all your product feed
Version: 1.0.0
Author: xtoool.com
Author URI: https://www.xtoool.com
Text Domain: xtoool.com
*/
namespace xtooolProductListForBlog;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class xtooolProductListForBlog{
    private static $instance = null;
    public $db;
    const XPF_VERSION = '1.0.0';
    const SUFFIX = '';

    public function __construct(){
        global $wpdb;
        $this->db = $wpdb;
        $this->init();        
    }

    public function init(){
        define('XPF_DIR', dirname(__FILE__));
		define('XPF_PATH', __FILE__);
		define('XPF_URL', plugins_url('', __FILE__));

        add_action('admin_menu', array(&$this, 'admin_menu') );
        add_action('wp_ajax_getProductData', [$this, 'getProductData']);   
        add_action('wp_ajax_deleteProduct', [$this, 'deleteProduct']);  
        add_action('wp_ajax_getProductListData', [$this, 'getProductListData']);    
        add_action('wp_ajax_deleteProductList', [$this, 'deleteProductList']); 
        register_activation_hook(__FILE__, [$this, 'activate']);


    }
    public function admin_menu()
    {
        add_menu_page( 'Xtoool Product Feed', 'Xtoool products', 'manage_options', 'product_list', [&$this, 'productList'] );
        add_submenu_page( 'product_list', 'Add products', 'Add products', 'manage_options', 'add_product', [&$this, 'addProduct'] );
        add_submenu_page( 'product_list', 'products List', 'products List', 'manage_options', 'products_list_show', [&$this, 'productsShowList'] );
        add_submenu_page( 'product_list', 'Add products List', 'Add products list', 'manage_options', 'add_products_list', [&$this, 'addProductsList'] );
    }

    public function activate(){
		$this->_createTable();
	}

	private function _createTable(){
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$sql = 'CREATE TABLE `' . $this->db->prefix . 'products_list_for_blog` (
            `list_id` int(11) NOT NULL AUTO_INCREMENT,
            `list_title` varchar(255) NOT NULL,
            `order` int(11) NOT NULL DEFAULT "0",
            `added_date` datetime DEFAULT NULL,
            PRIMARY KEY (`list_id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;';
		$ret = \dbDelta($sql);

        $sql2 = 'CREATE TABLE `' . $this->db->prefix . 'products_list_re_blog` (
            `product_id` int(11) NOT NULL,
            `list_id` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
		$ret2 = \dbDelta($sql2);

        $sql3 = 'CREATE TABLE `' . $this->db->prefix . 'products_for_blog` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `product_title` varchar(255) NOT NULL,
            `regular_price` decimal(10,2) DEFAULT NULL,
            `price` decimal(10,2) NOT NULL,
            `url` varchar(255) NOT NULL,
            `image_url` varchar(255) NOT NULL,
            `added_date` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;';
		$ret3 = \dbDelta($sql3);
	}

    public function productList(){
        wp_register_style( 'xpf-front-style', plugins_url( 'assets/lib/layui/css/layui.' . self::SUFFIX . 'css', XPF_PATH ), [], self::XPF_VERSION );
		wp_enqueue_style( 'xpf-front-style' );
        wp_enqueue_script( 'xpf-front-script', plugins_url( 'assets/lib/layui/layui.' . self::SUFFIX . 'js', XPF_PATH), [], self::XPF_VERSION, true );
        include_once 'tpl/admin.php';
    }
    public function addProduct(){
        if( wp_kses_post($_REQUEST['meted'])  == "add" ){
            $sql = 'insert into ' . $this->db->prefix . 'products_for_blog ( product_title, regular_price, price, image_url, url, added_date) ';
            $sql .= 'values (
                    "' . addslashes(wp_kses_post($_REQUEST['product_title'])) . '", 
                    ' . addslashes(wp_kses_post($_REQUEST['regular_price'])) . ', 
                    ' . addslashes(wp_kses_post($_REQUEST['price'])) . ', 
                    "' . addslashes(wp_kses_post($_REQUEST['image_url'])) . '", 
                    "' . addslashes(wp_kses_post($_REQUEST['url'])) . '", 
                    "' . date('Y-m-d H:i:s') . '")';
            $res = $this->db->query($this->db->prepare($sql));
            if( $res ){
                wp_redirect("/wp-admin/admin.php?page=product_list");exit;
            } else {
                echo "<script>alert('添加失败！')</script>";
                wp_redirect("/wp-admin/admin.php?page=add_product");exit;
            }
        } else {
            wp_register_style( 'xpf-front-style', plugins_url( 'assets/lib/layui/css/layui.' . self::SUFFIX . 'css', XPF_PATH ), [], self::XPF_VERSION );
		    wp_enqueue_style( 'xpf-front-style' );
            wp_enqueue_script( 'xpf-front-script', plugins_url( 'assets/lib/layui/layui.' . self::SUFFIX . 'js', XPF_PATH), [], self::XPF_VERSION, true );
            include_once 'tpl/add_product.php';
        }
    }
    public function productsShowList(){
        wp_register_style( 'xpf-front-style', plugins_url( 'assets/lib/layui/css/layui.' . self::SUFFIX . 'css', XPF_PATH ), [], self::XPF_VERSION );
		wp_enqueue_style( 'xpf-front-style' );
        wp_enqueue_script( 'xpf-front-script', plugins_url( 'assets/lib/layui/layui.' . self::SUFFIX . 'js', XPF_PATH), [], self::XPF_VERSION, true );
        include_once 'tpl/product_list_show.php';
    }
    public function getProductListData(){
        $ret = [
            'code' => 0,
            'data' => [],
            'msg' => ''
        ];
        $where = '';
        $keyword = wp_kses_post(trim($_POST['keyword']));
        if( $keyword ){
            $where .= ' and list_title like "%' . addslashes($keyword) . '%" ';
        }
        $page = intval(wp_kses_post($_POST['page']));
        $page = $page ? $page : 1;
        $page_size = wp_kses_post($_POST['limit']) ? intval(wp_kses_post($_POST['limit'])) : 20;
        
        $list = $this->getListData( $where, $page, $page_size );
        $sql_count = 'select count(*) as count from '.$this->db->prefix.'products_list_for_blog where 1=1 ' . $where;
        $count = $this->db->get_var($sql_count);

        $ret['data'] = $list;
        $ret['count'] = $count;
        $ret['sql'] = $sql;
         
        wp_send_json($ret);
    }
    public function addProductsList(){
        if( wp_kses_post($_REQUEST['meted'])  == "add" ){
            $products = explode('|',trim(wp_kses_post($_REQUEST['products'])));
            
            if( isset($_REQUEST['list_id']) && wp_kses_post($_REQUEST['list_id']) ){
                $sql = 'update ' . $this->db->prefix . 'products_list_for_blog set list_title = "' . addslashes(wp_kses_post($_REQUEST['list_title'])) . '",`order`='.addslashes(wp_kses_post($_REQUEST['order']));
                $res = $this->db->query($this->db->prepare($sql));

                $sql_d = 'delete from ' . $this->db->prefix . 'products_list_re_blog where list_id = ' . wp_kses_post($_REQUEST['list_id']);
                $res = $this->db->query($this->db->prepare($sql_d));

                $sql2 = 'insert into ' . $this->db->prefix . 'products_list_re_blog ( `product_id`, `list_id`) values ';
                for($i=0; $i < count($products); $i++){
                    $sql2 .= $i==0?'':',';
                    $sql2 .= '(' . $products[$i] . ', ' . wp_kses_post($_REQUEST['list_id']) . ')';
                }
                $res2 = $this->db->query($this->db->prepare($sql2));
                wp_redirect("/wp-admin/admin.php?page=products_list_show");exit;
            } else {
                $data_array = array(   
                    'list_title' => addslashes(wp_kses_post($_REQUEST['list_title'])),
                    'order'      => addslashes(wp_kses_post($_REQUEST['order'])),
                    'added_date' => date('Y-m-d H:i:s'),
                );  
                $this->db->insert($this->db->prefix . 'products_list_for_blog',$data_array);  
                $id = $this->db->insert_id;
                $sql2 = 'insert into ' . $this->db->prefix . 'products_list_re_blog ( `product_id`, `list_id`) values ';
                for($i=0; $i < count($products); $i++){
                    $sql2 .= $i==0?'':',';
                    $sql2 .= '(' . $products[$i] . ', ' . $id . ')';
                }
                $res2 = $this->db->query($this->db->prepare($sql2));
                if( $id ){
                    wp_redirect("/wp-admin/admin.php?page=products_list_show");exit;
                } else {
                    echo "<script>alert('添加列表失败！')</script>";
                    wp_redirect("/wp-admin/admin.php?page=add_products_list");exit;
                }
            }
        } else {
            $list_data = [];
            if( isset($_REQUEST['list_id']) && wp_kses_post($_REQUEST['list_id']) ){
                $sql = 'select lb.list_id,lb.list_title,lb.order,group_concat(p.product_title) as product_title,group_concat(p.id) as ids 
                        from '.$this->db->prefix.'products_list_for_blog lb 
                        left join '.$this->db->prefix.'products_list_re_blog lr on lb.list_id = lr.list_id
                        left join '.$this->db->prefix.'products_for_blog p on lr.product_id=p.id 
                        where lb.list_id=' . wp_kses_post($_REQUEST['list_id']);
                $list = $this->db->get_results($sql);
                if( !empty($list) ){
                    $list_data = $list[0];
                }
            }
            $sql = 'select id,product_title,url from '.$this->db->prefix.'products_for_blog order by product_title asc ';
            $products = $this->db->get_results($sql);
            wp_register_style( 'xpf-front-style', plugins_url( 'assets/lib/layui/css/layui.' . self::SUFFIX . 'css', XPF_PATH ), [], self::XPF_VERSION );
		    wp_enqueue_style( 'xpf-front-style' );
            wp_enqueue_script( 'xpf-front-script', plugins_url( 'assets/lib/layui/layui.' . self::SUFFIX . 'js', XPF_PATH), [], self::XPF_VERSION, true );
            include_once 'tpl/add_products_list.php';
        }
    }
    public function getProductData(){
        $ret = [
            'code' => 0,
            'data' => [],
            'msg' => ''
        ];
        $where = '';
        $keyword = trim(wp_kses_post($_POST['keyword']));
        if( $keyword ){
            $where .= ' and product_title like "%' . addslashes($keyword) . '%" ';
        }
        $page = intval(wp_kses_post($_POST['page']));
        $page = $page ? $page : 1;
        $page_size = wp_kses_post($_POST['limit']) ? intval(wp_kses_post($_POST['limit'])) : 20;
        
        $list = $this->getData( $where, $page, $page_size );
        $sql_count = 'select count(*) as count from '.$this->db->prefix.'products_for_blog where 1=1 ' . $where;
        $count = $this->db->get_var($sql_count);

        $ret['data'] = $list;
        $ret['count'] = $count;
        $ret['sql'] = $sql;
         
        wp_send_json($ret);
    }

    public function getData( $where, $page='', $page_size='' ){
        $fields = 'id,product_title,regular_price,price,image_url,url';
        $sql = 'select ' . $fields . ' from '.$this->db->prefix.'products_for_blog '; 
        $sql .= ' where 1=1 ' . $where . ' order by id desc ';
        if( !$page =='' || !$page_size=='' ){
            $sql .= 'limit ' . ($page - 1) * $page_size . ',' . $page_size;
        }
        $list = $this->db->get_results($sql);
        return $list;
    }
    public function getListData( $where, $page='', $page_size='' ){
        $sql = 'select lb.list_id,lb.list_title,group_concat(p.product_title) as product_title,group_concat(p.url) as product_url 
                from '.$this->db->prefix.'products_list_for_blog lb 
                left join '.$this->db->prefix.'products_list_re_blog lr on lb.list_id = lr.list_id
                left join '.$this->db->prefix.'products_for_blog p on lr.product_id=p.id 
                where 1=1 ' . $where . ' group by lb.list_id order by lb.order desc ';
        if( !$page =='' || !$page_size=='' ){
            $sql .= 'limit ' . ($page - 1) * $page_size . ',' . $page_size;
        }
        $list = $this->db->get_results($sql);
        return $list;
    }

    public function deleteProduct(){
        $product_id = intval(trim(wp_kses_post($_POST['id'])));
        $ret = [
            'code' => 0,
            'msg' => ''
        ];
        if( $product_id ){
            $update_status = $this->db->query($this->db->prepare('DELETE FROM ' . $this->db->prefix . 'products_for_blog WHERE id = '.$product_id));
            if($update_status){
                $ret['code'] = 1;
                $ret['msg'] = 'delete successful.';
            }
        }
        wp_send_json($ret);
    }
    
    public function deleteProductList(){
        $list_id = intval(trim(wp_kses_post($_POST['id'])));
        $ret = [
            'code' => 0,
            'msg' => ''
        ];
        if( $list_id ){
            $update_status = $this->db->query($this->db->prepare('DELETE FROM ' . $this->db->prefix . 'products_list_for_blog WHERE list_id = '.$list_id));
            if($update_status){
                $ret['code'] = 1;
                $ret['msg'] = 'delete successful.';
            }
        }
        wp_send_json($ret);
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }

}

xtooolProductListForBlog::getInstance();
