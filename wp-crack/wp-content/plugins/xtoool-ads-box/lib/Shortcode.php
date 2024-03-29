<?php 
namespace Adsbx;

class Shortcode{
    public $obj = null;

    public function __construct($obj = null){
        $this->obj = $obj;
        $this->_addHooks();
    }

    private function _addHooks(){
        // [xt-ads-banner id="4444"]
        add_shortcode('xt-ads-banner', [$this, 'showBanner']);
    }

    public function showBanner($attr){
        if(! isset($attr['id'])){
            return '';
        }
        $id = intval($attr['id']);
        if(! $id){
            return '';
        }
        $sql = 'select * from ' . $this->obj->db->prefix . 'products_banner_blog where id = %d limit 1';
        $sql_pre = $this->obj->db->prepare($sql, $id);
        $temp = $this->obj->db->get_row($sql_pre, ARRAY_A);
        if(! $temp){
            return '';
        }
        ob_start();
		$this->_showBannerHtml($temp);
		$data = ob_get_clean();
		return $data;
    }

    public function xtplb_expanded_alowed_tags() {
        $my_allowed = wp_kses_allowed_html( 'post' );
        // iframe
        $my_allowed['iframe'] = array(
            'src'             => array(),
            'height'          => array(),
            'width'           => array(),
            'frameborder'     => array(),
            'allowfullscreen' => array(),
        );
        // form fields - input
        $my_allowed['input'] = array(
            'class' => array(),
            'id'    => array(),
            'name'  => array(),
            'value' => array(),
            'type'  => array(),
        );
        // select
        $my_allowed['select'] = array(
            'class'  => array(),
            'id'     => array(),
            'name'   => array(),
            'value'  => array(),
            'type'   => array(),
        );
        // select options
        $my_allowed['option'] = array(
            'selected' => array(),
            'value' => []
        );
        // style
        $my_allowed['style'] = array(
            'types' => array(),
        );
    
        return $my_allowed;
    }

    private function _showBannerHtml($data){
        $html = '
            <!-- Power Xtoool -->
            <div class="adsbx-banner">
                <div class="adsbx-banner-left">
                    <img src="' . esc_url($data['image_url']) . '">
                </div>
                <div class="adsbx-banner-right">
                    <h2 class="adsbx-banner-title">' . esc_html($data['title']) . '</h2>
                    <div class="adsbx-banner-price">
                        <span class="adsbx-price">$' . esc_html($data['price']) . '</span>
                        <span class="adsbx-regular-price">$' . esc_html($data['regular_price']) . '</span>
                    </div>
                    <div class="adsbx-banner-desc">
                        ' . wp_kses(str_replace(["\r\n", "\n"], ['<br/>', '<br/>'], $data['desc']), $this->xtplb_expanded_alowed_tags()) . '
                    </div>
                    <div class="adsbx-banner-action">
                        <a class="adsbx-btn adsbx-btn-primary" href="' . esc_html($data['shop_btn_link']) . '">' . esc_html($data['shop_btn_text']) . '</a>
                        <a class="adsbx-btn adsbx-btn-default" href="' . esc_html($data['sub_btn_link']) . '">' . esc_html($data['sub_btn_text']) . '</a>
                    </div>
                </div>
            </div>
            
            <style>
                .adsbx-btn{
                    height: 40px;
                    width: 120px;
                    display: inline-block;
                    text-align: center;
                    line-height: 2.7;
                }
                .adsbx-banner-action{
                    gap: 15px;
                    margin-top: 20px;
                }
                .adsbx-btn-primary{
                    background: #000;
                    color: #fff;
                    border: 2px solid #000;
                }
                .adsbx-btn-default{
                    background: none;
                    border: 2px solid #000;
                    color: #000;
                    flex: 1;
                }
                .adsbx-banner{
                    width: 60%;
                    display: flex;
                    margin: 0 auto;
                    background: #f9f9f9;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                .adsbx-banner-left{
                    width: 30%;
                }
                .adsbx-banner-price{
                    margin-bottom: 12px;
                }
                .adsbx-banner-right{
                    width: 70%;
                    padding: 20px;
                    padding-left: 40px;
                }
                .adsbx-banner-left img{
                    width: 100%;
                }
                .adsbx-banner-title{
                    font-size: 20px;
                    color: #000;
                    font-family: var(--heading-font-family);
                    line-height: 1;
                    margin-bottom: 10px;
                }
                .adsbx-price{
                    color: #e7004c;
                    font-size: 16px;
                    font-family: var(--heading-font-family);
                }
                .adsbx-regular-price{
                    color: #888;
                    margin-top: 10px;
                    text-decoration: line-through;
                    margin-left: 8px;
                }
                @media screen and (max-width: 768px){
                    .adsbx-banner{
                        width: 100%;
                        display: block;
                    }
                    .adsbx-banner-left{
                        width: 100%;
                    }
                    .adsbx-banner-right{
                        width: 100%;
                        padding-left: 20px;
                    }
                }
            </style>
        ';
        echo $html;
    }
}