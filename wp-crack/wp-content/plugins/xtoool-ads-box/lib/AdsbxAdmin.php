<?php
namespace Adsbx;

class AdsbxAdmin{

    public $obj = null;

    public function __construct($obj = null){
        $this->obj = $obj;
        $this->_addHooks();
    }

    private function _addHooks(){
        add_action('wp_ajax_adsbx_save_ads', [$this, 'adsbx_save_ads']);
        add_action('wp_ajax_adsbx_ads_list', [$this, 'adsbx_ads_list']);
        add_action('wp_ajax_adsbx_delete_ads', [$this, 'adsbx_delete_ads']);
    }

    public function add_bannder_ad(){
        $id = intval(sanitize_text_field(isset($_GET['id']) ? $_GET['id'] : 0));
        $data = [];
        if($id){
            $sql = 'select * from ' . $this->obj->db->prefix . 'products_banner_blog where id = %d limit 1';
            $sql_pre = $this->obj->db->prepare($sql, $id);
            $data = $this->obj->db->get_row($sql_pre, ARRAY_A);
        }
        include_once XTPLB_DIR . '/template/add_ads.php';
    }

    public function bannder_ad_list(){
        include_once XTPLB_DIR . '/template/list_ads.php';
    }

    public function adsbx_delete_ads(){
        $code = 0;
        $msg = '';
        $data = '';
        $id = intval(sanitize_text_field($_POST['id']));
        if(! $id){
            $msg =  __('params error', 'xt-adsbx');
            return wp_send_json(
                [
                    'code'   => $code,
                    'msg'  => $msg,
                    'data' => $data
                ]
            );
        }
        $res = $this->obj->db->delete($this->obj->db->prefix . 'products_banner_blog', ['id' => $id]);
        if($res !== false){
            $code =  1;
        }else{
            $msg = __('delete failed', 'xt-adsbx');
        }
        return wp_send_json(
            [
                'code'   => $code,
                'msg'  => $msg,
                'data' => $data
            ]
        );
    }

    public function adsbx_ads_list(){
        $code = 0;
        $msg = '';
        $data = '';
        $where = '';
        $keyword = trim(addslashes(sanitize_text_field($_POST['keyword'])));
        if($keyword){
            $where .= ' and name like "%' . $keyword . '%"';
        }

        $pre = $this->obj->db->prefix;

        $sql_count = 'select count(*) as count from ' . $pre . 'products_banner_blog where 1=1 ' . $where;
        $count = $this->obj->db->get_var($sql_count);
        $sql = 'select * from ' . $pre . 'products_banner_blog where 1=1 ' . $where . ' order by id desc';
        $list = $this->obj->db->get_results($sql, ARRAY_A);

        return wp_send_json(
            [
                'code'   => $code,
                'msg'  => $msg,
                'count' => $count,
                'data' => $list
            ]
        );

    }

    public function adsbx_save_ads(){
        $code = 0;
        $msg = '';
        $data = '';
        $id = intval(sanitize_text_field($_POST['id']));
        $name = sanitize_text_field($_POST['name']);
        $image_url = sanitize_text_field($_POST['image_url']);
        $title = sanitize_text_field($_POST['title']);
        $desc = wp_unslash($_POST['desc']);
        $regular_price = sanitize_text_field($_POST['regular_price']);
        $price = sanitize_text_field($_POST['price']);
        $shop_btn_text = sanitize_text_field($_POST['shop_btn_text']);
        $shop_btn_link = sanitize_text_field($_POST['shop_btn_link']);
        $sub_btn_text = sanitize_text_field($_POST['sub_btn_text']);
        $sub_btn_link = sanitize_text_field($_POST['sub_btn_link']);

        $data = [
            'name' => $name,
            'image_url' => $image_url,
            'title' => $title,
            'desc' => $desc,
            'regular_price' => $regular_price,
            'price' => $price,
            'shop_btn_text' => $shop_btn_text,
            'shop_btn_link' => $shop_btn_link,
            'sub_btn_text' => $sub_btn_text,
            'sub_btn_link' => $sub_btn_link,
        ];
        $pre = $this->obj->db->prefix;
        $user_id = get_current_user_id();
        $date = date('Y-m-d H:i:s');
        if($id){
            
            $data['updated_by'] = $user_id;
            $data['updated_date'] = $date;
            $res = $this->obj->db->update($pre . 'products_banner_blog', $data, ['id' => $id]);
        }else{
            $data['added_by'] = $user_id;
            $data['added_date'] = $date;
            $res = $this->obj->db->insert($pre . 'products_banner_blog', $data);
        }
        if($res){
            $code = 1;
            $msg = 'Save Success';
        }

        return wp_send_json(
            [
                'code'   => $code,
                'msg'  => $msg,
                'data' => ''
            ]
        );

    }


}