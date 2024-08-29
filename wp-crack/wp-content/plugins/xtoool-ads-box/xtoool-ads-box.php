<?php
/*
Plugin Name: Xtoool Ads Box
Plugin URI: https://www.xtoool.com/wordpress/
Description: Xtoool Ads Box helps you create High-converting product bars to engage customers and grow sales.
Version: 1.0.11
Author: xtoool.com
Author URI: https://www.xtoool.com
Text Domain: xtoool.com
License: GPLv2 or later

============================================================================================================
This software is provided "as is" and any express or implied warranties, including, but not limited to, the
implied warranties of merchantibility and fitness for a particular purpose are disclaimed. In no event shall
the copyright owner or contributors be liable for any direct, indirect, incidental, special, exemplary, or
consequential damages(including, but not limited to, procurement of substitute goods or services; loss of
use, data, or profits; or business interruption) however caused and on any theory of liability, whether in
contract, strict liability, or tort(including negligence or otherwise) arising in any way out of the use of
this software, even if advised of the possibility of such damage.

For full license details see license.txt
============================================================================================================
*/
namespace plbProductListForBlog;

use Adsbx\AdsbxAdmin;
use Adsbx\Shortcode;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define('XTPLB_DIR', dirname(__FILE__));
define('XTPLB_PATH', __FILE__);
define('XTPLB_URL', plugins_url('', __FILE__));
define('XTPLB_BASE', plugin_basename(XTPLB_PATH));
define('ADSBX_PLUGIN_NAME', basename(XTPLB_DIR) . '/xtoool-ads-box.php');

class plbProductListForBlog{
    private static $instance = null;
    public $db;
    const XTPLB_VERSION = '1.0.11';
    public $AdsbxAdmin_obj = null;

    public function __construct(){
        global $wpdb;
        $this->db = $wpdb;
        $this->init();        
    }

    public function init(){
        add_action('admin_menu', array(&$this, 'admin_menu') );
        add_action('wp_ajax_getProductData', [$this, 'getProductData']);   
        add_action('wp_ajax_deleteProduct', [$this, 'deleteProduct']);  
        add_action('wp_ajax_getProductListData', [$this, 'getProductListData']);    
        add_action('wp_ajax_deleteProductList', [$this, 'deleteProductList']); 
		add_shortcode('plb_products_list', [$this, 'productListShowinBlog']);

        register_activation_hook(XTPLB_PATH, [$this, 'activate']);
        add_action( 'upgrader_process_complete', [$this, 'my_upgrate_function'], 10, 2);

        // test hook
        // do_action('upgrader_process_complete', null, ['action' => 'update', 'type' => 'plugin', 'plugins' => ['xtoool-ads-box/xtoool-ads-box.php']]);

        $this->_initScript();

        require_once 'lib/AdsbxAdmin.php';
        require_once 'lib/Shortcode.php';
        $this->AdsbxAdmin_obj = new AdsbxAdmin($this);
        new Shortcode($this);
    }

    public function my_upgrate_function( $upgrader_object, $options ) {

        if ($options['action'] !== 'update' || $options['type'] !== 'plugin') {
            return;
        }

        if (! in_array(ADSBX_PLUGIN_NAME, $options['plugins'] ?? [])) {
            return;
        }

        if($this->_checkUpdate()){
            $this->_update_1_0_7();
        }

    }

    private function _checkUpdate(){
        if(str_replace('.', '', self::XTPLB_VERSION) <= 109){
            return true;
        }else{
            return false;
        }
    }

    private function _update_1_0_3(){
        global $wpdb;
        $sql4 = 'CREATE TABLE if not exists `' . $wpdb->prefix . 'products_banner_blog` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL default "",
  `image_url` varchar(255) NOT NULL default "",
  `regular_price` varchar(25) NOT NULL default "",
  `price` varchar(25) NOT NULL default "",
  `title` varchar(255) NOT NULL default "",
  `desc` text default null,
  `shop_btn_text` varchar(255) NOT NULL default "",
  `shop_btn_link` varchar(1000) NOT NULL default "",
  `sub_btn_text` varchar(255) NOT NULL default "",
  `sub_btn_link` varchar(1000) NOT NULL default "",
  `added_by` int(11) not null default 0,
  `added_date` datetime default null,
  `updated_by` int(11) not null default 0,
  `updated_date` datetime default null,
  
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;';
		$wpdb->query($sql4);
    }

    private function _update_1_0_7(){
        $this->_update_1_0_3();

        global $wpdb;
        $sql4 = 'CREATE TABLE if not exists `' . $wpdb->prefix . 'xtl_custom_ads` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL default "",
  `shotcode` varchar(255) NOT NULL default "",
  `code` varchar(255) NOT NULL default "",
  `content` text default null,
  `added_by` int(11) not null default 0,
  `added_date` datetime default null,
  `updated_by` int(11) not null default 0,
  `updated_date` datetime default null,
  
  PRIMARY KEY (`id`),
  unique key(shotcode),
  unique key(`code`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;';
		$wpdb->query($sql4);
    }

    public function activate(){
		
		$this->_createTable();
	}

	private function _createTable(){
        global $wpdb;
		$sql = 'CREATE TABLE if not exists `' . $wpdb->prefix . 'products_for_blog` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
  `product_title` varchar(255) NOT NULL,
  `regular_price` decimal(10, 2) DEFAULT NULL,
  `price` decimal(10, 2) NOT NULL,
  `url` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;';
		$wpdb->query($sql);

        $sql2 = 'CREATE TABLE if not exists `' . $wpdb->prefix . 'products_list_for_blog` (
			`list_id` int(11) NOT NULL AUTO_INCREMENT,
  `list_title` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT "0",
  `added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;';
		$wpdb->query($sql2);

        $sql3 = 'CREATE TABLE if not exists `' . $wpdb->prefix . 'products_list_re_blog` (
			`product_id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;';
		$wpdb->query($sql3);


        $sql4 = 'CREATE TABLE if not exists `' . $wpdb->prefix . 'products_banner_blog` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL default "",
  `image_url` varchar(255) NOT NULL default "",
  `regular_price` varchar(25) NOT NULL default "",
  `price` varchar(25) NOT NULL default "",
  `title` varchar(255) NOT NULL default "",
  `desc` text default null,
  `shop_btn_text` varchar(255) NOT NULL default "",
  `shop_btn_link` varchar(1000) NOT NULL default "",
  `sub_btn_text` varchar(255) NOT NULL default "",
  `sub_btn_link` varchar(1000) NOT NULL default "",
  `added_by` int(11) not null default 0,
  `added_date` datetime default null,
  `updated_by` int(11) not null default 0,
  `updated_date` datetime default null,
  
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;';
		$wpdb->query($sql4);
		
	}

    private function _initScript(){
		if(is_admin()){
			add_action('admin_enqueue_scripts', [$this, 'adminScript']);
		}else{
			add_action('wp_enqueue_scripts', [$this, 'frontScript']);
		}
	}


    public function adminScript(){
		wp_register_style( 'layui-style', plugins_url( 'assets/lib/layui/css/layui.css', XTPLB_PATH ), [], self::XTPLB_VERSION );
        wp_enqueue_style( 'layui-style' );
		wp_enqueue_script( 'layui-js', plugins_url( 'assets/lib/layui/layui.js', XTPLB_PATH), [], self::XTPLB_VERSION, true );
	}

    public function frontScript(){
		wp_register_style( 'layui-style', plugins_url( 'assets/lib/layui/css/layui.css', XTPLB_PATH ), [], self::XTPLB_VERSION );
        wp_enqueue_style( 'layui-style' );
		wp_enqueue_script( 'layui-js', plugins_url( 'assets/lib/layui/layui.js', XTPLB_PATH), ['jquery'], self::XTPLB_VERSION, true );
	}

    public function productListShowinBlog( $content = null ){
        wp_register_style( 'swiper-bundle-style', plugins_url( 'assets/lib/swiper/swiper-bundle.min.css', XTPLB_PATH ), [], self::XTPLB_VERSION );
        wp_register_style( 'swiper-style', plugins_url( 'assets/lib/swiper/swiper.min.css', XTPLB_PATH ), [], self::XTPLB_VERSION );
        wp_enqueue_style( 'swiper-style' );
        wp_enqueue_style( 'swiper-bundle-style' );
		wp_enqueue_script( 'swiper-js', plugins_url( 'assets/lib/swiper/swiper.min.js', XTPLB_PATH), ['jquery'], self::XTPLB_VERSION, true );
        wp_enqueue_script( 'swiper-bundle-js', plugins_url( 'assets/lib/swiper/swiper-bundle.min.js', XTPLB_PATH), ['jquery'], self::XTPLB_VERSION, true );
        // [plb_products_list list_id="16"]
        // 匹配出 list_id
        $list_id = sanitize_text_field($content['id']);
        if( !$list_id ) return;
        global $wpdb;
        $sql = 'select lb.list_id,lb.list_title,
                group_concat(p.product_title) as product_title,
                group_concat(p.url) as product_url,
                group_concat(CONCAT_WS(",", IFNULL(p.image_url,""))) as image_urls,
                group_concat(CONCAT_WS(",", IFNULL(p.regular_price,"0"))) as regular_prices,
                group_concat(CONCAT_WS(",", IFNULL(p.price,"0"))) as prices 
                from '.$wpdb->prefix.'products_list_for_blog lb 
                left join '.$wpdb->prefix.'products_list_re_blog lr on lb.list_id = lr.list_id
                left join '.$wpdb->prefix.'products_for_blog p on lr.product_id=p.id 
                where lb.list_id = %d';
            $sql_pre = $wpdb->prepare($sql, $list_id);
        $list = $wpdb->get_results($sql_pre);
        $html = '';
        if( !empty($list) ){
    
            $rand = round(10000,99999);
            $html = '<div class="plb_blog_page_products">
            <h2 class="plb_blog_page_products_show">'. $list[0]->list_title .'</h2>
            <div class="plb_products_list_slide_without_price swiper swiper-container_'. $rand .'">
            <div class="plb_blog_page_products_show swiper-wrapper">';
            $product_titles = explode(',',$list[0]->product_title);
            $product_urls   = explode(',',$list[0]->product_url);
            $regular_prices = explode(',',$list[0]->regular_prices);
            $prices         = explode(',',$list[0]->prices);
            $image_urls     = explode(',',$list[0]->image_urls);
    
            for( $i=0; $i<count($product_titles);$i++ ){
                $html .= '<dd class="plb-item swiper-slide '.count($product_titles).'">
                            <a href="'. $product_urls[$i]  .'" target="_blank"><img src="'. $image_urls[$i] .'" ></a>
                            <div>
                                <div class="product_title"><a href="'. $product_urls[$i]  .'" target="_blank">'. $product_titles[$i] .'</a></div>
                                <div class="product_prices">
                                    <span class="sale_price">$'. $prices[$i] .'</span>';
                        if( $regular_prices[$i] > 0 ){
                        $html .= '<span class="regular_prices">$'. $regular_prices[$i] .'</span>';
                        }
                        $html .= '</div>
                            </div>
                        </dd>';
            }
            $html .= '</div>';
            $html .= '<!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-next_'. $rand .'"></div>
                <div class="swiper-button-prev swiper-button-prev_'. $rand .'"></div>
                <!-- Add Pagination -->
                <div class="swiper-pagination swiper-pagination_'. $rand .'"></div>';
    
            $html .= '</div>
            </div>
    
            <style>
                .plb_blog_page_products{
                    margin:0 auto;
                    display:block;
                    background:#f3f3f3;
                    padding: 0 15px;
                    margin-bottom: 20px;
                }
                div.swiper-button-next, div.swiper-button-prev{
                    background-image: none;
                }
                .plb-item{
                    text-align: center;
                }
                .plb_products_list_slide_without_price {
                    width: 100%;
                    overflow-x: hidden;
                    overflow-y: hidden;
                    position: relative;
                }
                .plb_blog_page_products_show{width:100%;padding:10px 0 15px;}
                h2.plb_blog_page_products_show {font-weight: bold;
                    color: #000;
                    font-size: 18px;
                    margin: 0;
                    line-height: 40px;
                    padding-bottom: 0;
                    }
                .plb_blog_page_products_show dd{display: block;margin:0;padding:10px;background:#fff;}
                .plb_blog_page_products_show dd img{width:60%;margin: 0 auto;}
                .plb_blog_page_products_show dd .product_title{height: 50px;overflow: hidden;padding-top: 10px;line-height: 20px;}
                .plb_blog_page_products_show dd .product_title a{font-size:14px;color:#000;font-weight: 600;}
                .plb_blog_page_products_show dd .product_prices{line-height:35px;font-size:14px;font-weight: 600;}
                .plb_blog_page_products_show dd .product_prices .regular_prices{color: #aaa;text-decoration: line-through;}
                .plb_blog_page_products_show dd .product_prices .sale_price{color:#00a19f;padding-right:15px;}
                @media only screen and (max-width: 768px){
                    .plb_blog_page_products_show dd{width:calc(33% - 10px);}
                    .plb_blog_page_products_show dd img{width:100%;}
                    .product_prices span{
                        display: block;
                        text-align: center;
                        
                    }
                    .plb_blog_page_products_show dd .product_prices .sale_price{
                        padding-right: 0;
                    }
                }
                .swiper-button-prev, .swiper-button-next{
                    color: #000!important;
                    background: #e5e5e5;
                    width: 25px!important;
                    height: 25px!important;
                    border-radius: 50%;
                }
                .swiper-button-prev:after, .swiper-button-next:after {
                    font-size: 14px!important;
                }
            </style>
            <script>
            console.log(window);
                if( jQuery(window).width() <= 768 ){
                    var num = 3;
                } else {
                    var num = 4;
                }
                jQuery(function(){
                var swiper = new Swiper(".swiper-container_'. $rand .'", {
                    slidesPerView: num,
                    spaceBetween: 10,
                    slidesPerGroup: num,
                    loop: false,
                    loopFillGroupWithBlank: true,
                    pagination: {
                    el: ".swiper-pagination_'. $rand .'",
                    clickable: true,
                    },
                    navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                    },
                });
            });
            </script>';
        }
        return $html;
    }
    public function admin_menu()
    {
        add_menu_page( 'Xtoool Ads Box', 'Xtoool Ads Box', 'manage_options', 'product_list', [&$this, 'productList'] );
        add_submenu_page( 'product_list', 'Add Banner Ad', 'Add Banner Ad', 'manage_options', 'add_bannder_ad', [$this->AdsbxAdmin_obj, 'add_bannder_ad'] );
        add_submenu_page( 'product_list', 'Banner Ad List', 'Banner Ad List', 'manage_options', 'bannder_ad_list', [$this->AdsbxAdmin_obj, 'bannder_ad_list'] );
        add_submenu_page( 'product_list', 'Add product', 'Add product', 'manage_options', 'add_product', [&$this, 'addProduct'] );
        add_submenu_page( 'product_list', 'products List', 'products List', 'manage_options', 'products_list_show', [&$this, 'productsShowList'] );
        add_submenu_page( 'product_list', 'Add products List', 'Add products list', 'manage_options', 'add_products_list', [&$this, 'addProductsList'] );
        add_submenu_page( 'product_list', 'Custom Ad', 'Custom Ad', 'manage_options', 'custom_list', [$this->AdsbxAdmin_obj, 'custom_list'] );
        add_submenu_page( 'product_list', 'Add Custom Ad', 'Add Custom Ad', 'manage_options', 'add_custom_ad', [$this->AdsbxAdmin_obj, 'add_custom_ad'] );
    }

    public function productList(){
        include_once 'tpl/admin.php';
    }
    public function addProduct(){
        remove_action( 'admin_notices', 'update_nag', 3 );
        if(isset($_REQUEST['meted']) && sanitize_text_field($_REQUEST['meted'])  == 'add' ){
            $data = [
                'id' => sanitize_text_field($_REQUEST['id']),
                'product_title' => sanitize_text_field($_POST['product_title']),
                'regular_price' => sanitize_text_field($_POST['regular_price']),
                'price' => sanitize_text_field($_POST['price']),
                'image_url' => sanitize_text_field($_POST['image_url']),
                'url' => sanitize_text_field($_POST['url'])
            ];
            if( isset($_REQUEST['id']) && $_REQUEST['id'] ){
                $sql = 'update ' . $this->db->prefix . 'products_for_blog set product_title = "' . addslashes($data['product_title']) . '",
                `regular_price`='.addslashes($data['regular_price']).',
                price = "' . addslashes($data['price']) . '",
                image_url = "' . addslashes($data['image_url']) . '",
                url = "' . addslashes($data['url']) . '",
                added_date= "' . date('Y-m-d H:i:s') . '" where id= %d';
                $sql_pre = $this->db->prepare($sql, sanitize_text_field($_REQUEST['id']));
                $res = $this->db->query($sql_pre);
                if( $res ){
                    echo '<script>location.href="/wp-admin/admin.php?page=product_list"</script>';
                } else {
                    echo "<script>alert('update failed!')</script>";
                    echo '<script>location.href="/wp-admin/admin.php?page=add_product"</script>';
                }
                exit;
            } else {
                $data['regular_price'] = isset($data['regular_price']) ? addslashes($data['regular_price']) : 0;
                $data['price'] = isset($data['price']) ? addslashes($data['price']) : 0;
                $data['image_url'] = isset($data['image_url']) ? addslashes($data['image_url']) : 0;
                $data['url'] = isset($data['url']) ? addslashes($data['url']) : 0;
                $data['product_title'] = isset($data['product_title']) ? addslashes($data['product_title']) : 0;
                $sql = 'insert into ' . $this->db->prefix . 'products_for_blog ( product_title, regular_price, price, image_url, url, added_date) ';
                $sql .= 'values (%s, %s, %s, %s, %s, %s)';

                $sql_pre = $this->db->prepare($sql, $data['product_title'], $data['regular_price'], $data['price'], $data['image_url'], $data['url'], date('Y-m-d H:i:s'));
                $res = $this->db->query($sql_pre);
                
                if( $res ){
                    echo '<script>location.href="/wp-admin/admin.php?page=product_list"</script>';
                } else {
                    echo "<script>alert('added failed')</script>";
                    echo '<script>location.href="/wp-admin/admin.php?page=add_product"</script>';
                }
                exit;
            }
        } else {
            if( isset($_REQUEST['id']) && $_REQUEST['id'] ){
                $sql = 'select * from '.$this->db->prefix.'products_for_blog where id = %d';
                $sql_pre = $this->db->prepare($sql, sanitize_text_field($_REQUEST['id']));
                $product = $this->db->get_results($sql_pre, ARRAY_A);
                if( !empty($product) ){
                    $product = $product[0];
                }
            } else {
                $product = [];
            }
            
            include_once 'tpl/add_product.php';
        }
    }
    public function productsShowList(){
        include_once 'tpl/product_list_show.php';
    }
    public function getProductListData(){
        $ret = [
            'code' => 0,
            'data' => [],
            'msg' => ''
        ];
        $where = '';
        $keyword = trim(sanitize_text_field($_POST['keyword']));
        if( $keyword ){
            $where .= ' and list_title like "%%s%" ';
        }
        $page = intval(sanitize_text_field($_POST['page']));
        $page = $page ? $page : 1;
        $page_size = sanitize_text_field($_POST['limit']) ? intval(sanitize_text_field($_POST['limit'])) : 20;
        
        $list = $this->getListData( $where, $page, $page_size );
        $sql_count = 'select count(*) as count from '.$this->db->prefix.'products_list_for_blog where 1=1 ' . $where;
        $sql_pre = $this->db->prepare($sql_count, $keyword);
        $count = $this->db->get_var($sql_pre);

        $ret['data'] = $list;
        $ret['count'] = $count;
        $ret['sql'] = $sql_count;
         
        wp_send_json($ret);
    }
    public function addProductsList(){
        if(isset($_REQUEST['meted']) && sanitize_text_field($_REQUEST['meted'])  == "add" ){
            $data = [
                'list_id' => sanitize_text_field($_REQUEST['list_id']),
                'products' => sanitize_text_field($_POST['products']),
                'list_title' => sanitize_text_field($_POST['list_title']),
                'order' => sanitize_text_field($_POST['order']),
            ];
            $products = explode('|',trim($data['products']));


            if( isset($_REQUEST['list_id']) && $_REQUEST['list_id'] ){
                $sql = 'update ' . $this->db->prefix . 'products_list_for_blog set list_title = %s,
                `order`=%d where list_id = %d';
                $sql_pre = $this->db->prepare($sql, $data['list_title'], $data['order'], sanitize_text_field($_REQUEST['list_id']));
                $res = $this->db->query($sql_pre);

                $sql_d = 'delete from ' . $this->db->prefix . 'products_list_re_blog where list_id = %d';
                $sql_pre = $this->db->prepare($sql_d, sanitize_text_field($_REQUEST['list_id']));
                $res = $this->db->query($sql_pre);

                $sql2 = 'insert into ' . $this->db->prefix . 'products_list_re_blog ( `product_id`, `list_id`) values ';
                for($i=0; $i < count($products); $i++){
                    $sql2 .= $i==0?'':',';
                    $sql2 .= '(' . $products[$i] . ', ' . sanitize_text_field($_REQUEST['list_id']) . ')';
                }
                $res2 = $this->db->query($sql2);
                echo '<script>location.href="/wp-admin/admin.php?page=products_list_show"</script>';
                exit;
            } else {
                $data_array = array(   
                    'list_title' => addslashes($data['list_title']),
                    'order'      => addslashes($data['order']),
                    'added_date' => date('Y-m-d H:i:s'),
                );  
                $this->db->insert($this->db->prefix . 'products_list_for_blog',$data_array);  
                $id = $this->db->insert_id;
                $sql2 = 'insert into ' . $this->db->prefix . 'products_list_re_blog ( `product_id`, `list_id`) values ';
                for($i=0; $i < count($products); $i++){
                    $sql2 .= $i==0?'':',';
                    $sql2 .= '(' . $products[$i] . ', ' . $id . ')';
                }
                $res2 = $this->db->query($sql2);
                if( $id ){
                    echo '<script>location.href="/wp-admin/admin.php?page=products_list_show"</script>';
                } else {
                    echo "<script>alert('add list failed！')</script>";
                    echo '<script>location.href="/wp-admin/admin.php?page=add_products_list"</script>';

                }
                exit;
            }
        } else {
            $list_data = [];
            if( isset($_REQUEST['list_id']) && $_REQUEST['list_id'] ){
                $sql = 'select lb.list_id,lb.list_title,lb.order,group_concat(p.product_title) as product_title,group_concat(p.id) as ids 
                        from '.$this->db->prefix.'products_list_for_blog lb 
                        left join '.$this->db->prefix.'products_list_re_blog lr on lb.list_id = lr.list_id
                        left join '.$this->db->prefix.'products_for_blog p on lr.product_id=p.id 
                        where lb.list_id= %d';
                $sql_pre = $this->db->prepare($sql, sanitize_text_field($_REQUEST['list_id']));
                $list = $this->db->get_results($sql_pre);
                if( !empty($list) ){
                    $list_data = $list[0];
                }
            }
            $sql = 'select id,product_title,url from '.$this->db->prefix.'products_for_blog order by product_title asc ';
            $products = $this->db->get_results($sql);
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
        $keyword = trim(sanitize_text_field($_POST['keyword']));
        if( $keyword ){
            $where .= ' and product_title like "%%s%" ';
        }
        $page = intval(sanitize_text_field($_POST['page']));
        $page = $page ? $page : 1;
        $page_size =isset($_POST['limit']) ? intval(sanitize_text_field($_POST['limit'])) : 20;
        
        $list = $this->getData( $where, $page, $page_size );
        $sql_count = 'select count(*) as count from '.$this->db->prefix.'products_for_blog where 1=1 ' . $where;
        $sql_pre = $this->db->prepare($sql_count, $keyword);
        $count = $this->db->get_var($sql_pre);

        $ret['data'] = $list;
        $ret['count'] = $count;
        $ret['sql'] = $sql_count;
         
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
        $product_id = intval(trim(sanitize_text_field($_POST['id'])));
        $ret = [
            'code' => 0,
            'msg' => ''
        ];
        if( $product_id ){
            $sql = 'DELETE FROM ' . $this->db->prefix . 'products_for_blog WHERE id = %d';
            $sql_pre = $this->db->prepare($sql, $product_id);

            $update_status = $this->db->query($sql_pre);
            if($update_status){
                $ret['code'] = 1;
                $ret['msg'] = 'delete successful.';
            }
        }
        wp_send_json($ret);
    }

    public function deleteProductList(){
        $list_id = intval(trim(sanitize_text_field($_POST['id'])));
        $ret = [
            'code' => 0,
            'msg' => ''
        ];
        if( $list_id ){
            $sql = 'DELETE FROM ' . $this->db->prefix . 'products_list_for_blog WHERE list_id = %d';
            $sql_pre = $this->db->prepare($sql, $list_id);
            $update_status = $this->db->query($sql_pre);
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

plbProductListForBlog::getInstance();
