<?php

class td_woo_products_block extends td_block {

    public function get_custom_css() {
        // $unique_block_class - the unique class that is on the block. use this to target the specific instance via css
        $unique_block_class = $this->block_uid;
        $unique_block_modal_class = $this->block_uid . '_m';

        $compiled_css = '';

        $raw_css =
            "<style>
            
                /* @general_style */
                .td_woo_products_block .tdw-block-inner {
                    display: flex;
                    flex-wrap: wrap;
                }
                .td_woo_products_block .td_woo_product_module {
                    margin: 0 0 40px;
                    padding-bottom: 0;
                }
                .td_woo_products_block .td-module-container {
                    display: flex;
                }
                .td_woo_products_block .td-image-container {
                    flex: 0 0 auto;
                    width: 100%;
                    position: relative;
                    margin-bottom: 14px;
                }
                .td_woo_products_block .td-module-thumb {
                    margin-bottom: 0;
                }
                .td_woo_products_block .td-image-wrap {
                    display: block;
                    position: relative;
                    padding-bottom: 100%;
                }
                .td_woo_products_block .td-thumb-css {
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    background-size: cover;
                    background-position: center center;
                }
                .td_woo_products_block .td-image-container img {
                    width: 100%;
                    display: block;
                }
                .td_woo_products_block .td_woo_product_module .onsale {
                    top: 0;
                    left: auto;
                    right: 0;
                    margin: 0;
                    padding: 10px;
                    min-width: 0;
                    min-height: 0;
                    background-color: #4db2ec;
                    color: #fff;
                    position: absolute;
                    font-size: 12px;
                    line-height: 1;
                    border: 0 solid #000;
                    border-radius: 0;
                }
                .td_woo_products_block .td-module-meta-info {
                    margin: 0;
                    border-width: 0;
                    border-style: solid;
                    border-color: #000;
                }
                .td_woo_products_block .td-module-title {
                    margin: 0 0 5px;
                    padding: 0;
                    font-family: 'Roboto', sans-serif;
                    font-size: 15px;
                    font-weight: 500;
                    line-height: 1.4;
                }
                body div.td_woo_products_block .star-rating {
                    float: none;
                    display: inline-block;
                    margin: 0 0 6px;
                    width: auto;
                    height: auto;
                    font-family: star;
                    overflow: hidden;
                    position: relative;
                    line-height: 1;
                    font-size: 1em;
                }
                body div.td_woo_products_block .star-rating:before,
                body div.td_woo_products_block .star-rating span:before {
                    position: relative;
                    top: 0;
                    left: 0;
                    font-size: 12px;
                }
                body div.td_woo_products_block .star-rating:before {
                    content: '\\73\\73\\73\\73\\73';
                    color: #d3ced2;
                    float: left;
                }
                body div.td_woo_products_block .star-rating span:before {
                    content: '\\53\\53\\53\\53\\53';
                }
                body div.td_woo_products_block .star-rating span {
                    padding-top: 0;
                    overflow: hidden;
                    float: left;
                    top: 0;
                    left: 0;
                    position: absolute;
                    font-size: 0;
                }
                div.td_woo_products_block div.td_woo_product_module .price {
                    display: block;
                    margin-bottom: 18px;
                    font-family: Verdana, Geneva, sans-serif;
                    font-size: 14px;
                    line-height: 1.7;
                    font-weight: 600;
                    color: #111;
                }
                div.td_woo_products_block div.td_woo_product_module .price del {
                    font-size: 0.75em !important;
                    color: #9d9d9d;
                }
                div.td_woo_products_block div.td_woo_product_module .price ins {
                    font-weight: inherit;
                    background: transparent;                
                }
                .td_woo_products_block .td_woo_product_module a.button {
                    background: none #222;
                    font-size: 11px;
                    padding: 10px;
                    text-shadow: none;
                    color: #fff;
                    border-width: 0;
                    border-style: solid;
                    border-color: #000;
                    border-radius: 0;
                    box-shadow: none;
                }
                .td_woo_products_block .td_woo_product_module a.button:hover {
                    background-color: #4db2ec;
                }
                .td_woo_products_block .td-next-prev-wrap,
                .td_woo_products_block .td-load-more-wrap {
                    margin-top: 40px;
                }
                .td_woo_products_block .td-next-prev-wrap a {
                    width: auto;
                    height: auto;
                    min-width: 25px;
                    min-height: 25px;
                }
                .td_woo_products_block.tdc-no-posts .td_block_inner:after {
                    content: 'No products' !important;
                    width: 100%;
                }
                .td_woo_products_block.tdc-no-posts.tdw-single-product-page-filter-upsells .td_block_inner:after {
                    content: 'No upsells' !important;
                }
                .td_woo_products_block.tdc-no-posts.tdw-single-product-page-filter-related .td_block_inner:after,
                .td_woo_products_block.tdc-no-posts.tdw-single-product-page-filter-related_tags .td_block_inner:after,
                .td_woo_products_block.tdc-no-posts.tdw-single-product-page-filter-related_categories .td_block_inner:after {
                    content: 'No related products' !important;
                }
                
                
                /* @modules_on_row */
				body .$unique_block_class .td_woo_product_module {
					width: @modules_on_row;
                }
				/* @all_space */
				body .$unique_block_class .td_woo_product_module {
					margin-bottom: @all_space;
                }
				/* @padding_desktop */
				body .$unique_block_class .td_woo_product_module:nth-last-child(@padding_desktop) {
				    margin-bottom: 0;
				}				    
				/* @padding */
				body .$unique_block_class .td_woo_product_module {
				    margin-bottom: @all_space !important;
				}
				body .$unique_block_class .td_woo_product_module:nth-last-child(@padding) {
					margin-bottom: 0 !important;
				}
				/* @gap */
				body .$unique_block_class .td_woo_product_module,
				.$unique_block_class.tdc-no-posts .td_block_inner:after {
					padding-left: @gap;
					padding-right: @gap;
				}
				body .$unique_block_class .tdw-block-inner {
					margin-left: -@gap;
					margin-right: -@gap;
				}
                
                
				/* @img_width */
				body .$unique_block_class .td-image-container {
				 	flex: 0 0 @img_width;
				 	width: @img_width;
			    }
				.ie10 .$unique_block_class .td-image-container,
				.ie11 .$unique_block_class .td-image-container {
				 	flex: 0 0 auto;
			    }
				/* @img_height */
				body .$unique_block_class .td-image-wrap {
					padding-bottom: @img_height;
				}
				/* @img_alignment */
				body .$unique_block_class .entry-thumb {
					background-position: center @img_alignment;
				}
				/* @module_direction */
				body .$unique_block_class .td-module-container {
					flex-direction: @module_direction;
                }
				/* @img_first */
				body .$unique_block_class .td-image-container {
					order: 1;
                }
				body .$unique_block_class .td-module-meta-info {
					order: 2;
                }
				/* @img_last */
				body .$unique_block_class .td-image-container {
					order: 2;
                }
				body .$unique_block_class .td-module-meta-info {
					order: 1;
                }
				/* @img_show */
				body .$unique_block_class .td-image-container {
					display: @img_show;
                }
				/* @img_space */
				body .$unique_block_class .td-image-container {
					margin-bottom: @img_space;
                }
				/* @img_radius */
				body .$unique_block_class .entry-thumb {
					border-radius: @img_radius;
                }
                
				/* @sale_margin */
				body .$unique_block_class .td_woo_product_module .onsale {
					margin: @sale_margin;
                }
				/* @sale_padding */
				body .$unique_block_class .td_woo_product_module .onsale {
					padding: @sale_padding;
                }
                /* @sale_border */
                body .$unique_block_class .td_woo_product_module .onsale {
                    border-width: @sale_border;
                } 
                /* @sale_border_style */
                body .$unique_block_class .td_woo_product_module .onsale {
                    border-style: @sale_border_style;
                }      
                /* @sale_radius */
                body .$unique_block_class .td_woo_product_module .onsale {
                    border-radius: @sale_radius;
                }
                
				/* @meta_info_align */
				body .$unique_block_class .td-module-meta-info {
				    display: flex;
				    flex-direction: column;
					justify-content: @meta_info_align;
				}
				/* @meta_width */
				body .$unique_block_class .td-module-meta-info {
					max-width: @meta_width;
				}
				/* @meta_margin */
				body .$unique_block_class .td-module-meta-info {
					margin: @meta_margin;
				}
				/* @meta_padding */
				body .$unique_block_class .td-module-meta-info {
					padding: @meta_padding;
				}
				/* @meta_info_border_size */
				body .$unique_block_class .td-module-meta-info {
					border-width: @meta_info_border_size;
				}
				/* @meta_info_border_style */
				body .$unique_block_class .td-module-meta-info {
					border-style: @meta_info_border_style;
				}
                
				/* @title_space */
				body .$unique_block_class .td-module-title {
					margin-bottom: @title_space;
                }
				/* @show_stars */
				html body div.$unique_block_class .star-rating {
					display: @show_stars;
                }
				/* @stars_size */
				html body div.$unique_block_class .star-rating:before,
                html body div.$unique_block_class .star-rating span:before {
					font-size: @stars_size;
                }
				/* @stars_space */
				html body div.$unique_block_class .star-rating {
					margin-bottom: @stars_space;
                }
				/* @price_space */
				body div.$unique_block_class div.td_woo_product_module .price {
					margin-bottom: @price_space;
                }
                
                /* @horiz_align_left */
				.$unique_block_class .td-module-meta-info {
					align-items: flex-start;
                }
				/* @horiz_align_center */
				.$unique_block_class .td-module-meta-info {
					align-items: center;
                }
				/* @horiz_align_right */
				.$unique_block_class .td-module-meta-info {
					align-items: flex-end;
                }
                
				/* @btn_padding */
				body .$unique_block_class .td_woo_product_module a.button {
					padding: @btn_padding;
                }
				/* @btn_border */
				body .$unique_block_class .td_woo_product_module a.button {
					border-width: @btn_border;
                }
				/* @btn_border_style */
				body .$unique_block_class .td_woo_product_module a.button {
					border-style: @btn_border_style;
                }
				/* @btn_radius */
				body .$unique_block_class .td_woo_product_module a.button {
					border-radius: @btn_radius;
                }
				/* @show_btn */
				body .$unique_block_class .td_woo_product_module a.button {
					display: @show_btn;
                }
				
				/* @pag_space */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap,
				.$unique_block_class .td-load-more-wrap {
					margin-top: @pag_space;
				}
				/* @pag_padding */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a,
				.$unique_block_class .td-load-more-wrap a {
					padding: @pag_padding;
				}
				.$unique_block_class .page-nav .pages {
				    padding-right: 0;
				}
				/* @pag_border_width */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a,
				.$unique_block_class .td-load-more-wrap a {
					border-width: @pag_border_width;
				}
				/* @pag_border_radius */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a,
				.$unique_block_class .td-load-more-wrap a {
					border-radius: @pag_border_radius;
				}
				/* @pag_icons_size */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a,
				.$unique_block_class .td-load-more-wrap a i {
					font-size: @pag_icons_size;
				}
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap .td-next-prev-icon-svg svg {
				    width: @pag_icons_size;
				    height: calc( @pag_icons_size + 1px );
				}
                
                
                
				/* @sale_txt_color */
				body .$unique_block_class .td_woo_product_module .onsale {
					color: @sale_txt_color;
                }
				/* @sale_txt_color_h */
				.body .$unique_block_class .td_woo_product_module:hover .onsale {
					color: @sale_txt_color_h;
                }
				/* @sale_bg_color */
				body .$unique_block_class .td_woo_product_module .onsale {
					background-color: @sale_bg_color;
                }
				/* @sale_bg_color_h */
				body .$unique_block_class .td_woo_product_module:hover .onsale {
					background-color: @sale_bg_color_h;
                }
                /* @sale_border_color */
                body .$unique_block_class .td_woo_product_module .onsale {
                    border-color: @sale_border_color;
                }
                /* @sale_border_color_h */
                body .$unique_block_class .td_woo_product_module:hover .onsale {
                    border-color: @sale_border_color_h;
                }
                
				/* @meta_bg */
				body .$unique_block_class .td-module-meta-info {
					background-color: @meta_bg;
                }
				/* @meta_border_color */
				body .$unique_block_class .td-module-meta-info {
					border-color: @meta_border_color;
                }
                
				/* @title_color */
				body .$unique_block_class .td-module-title a {
					color: @title_color;
                }
				/* @title_color_h */
				body .$unique_block_class .td_woo_product_module:hover .td-module-title a {
					color: @title_color_h;
                }
                            
                /* @stars_full_color */
                html body div.$unique_block_class .star-rating span:before {
                    color: @stars_full_color;
                }     
                /* @stars_empty_color */
                html body div.$unique_block_class .star-rating:before {
                    color: @stars_empty_color;
                }
                
				/* @price_color */
				body div.$unique_block_class div.td_woo_product_module .price {
					color: @price_color;
                }
				/* @sale_price_color */
				body div.$unique_block_class div.td_woo_product_module .price ins {
					color: @sale_price_color;
                }
				/* @old_price_color */
				body div.$unique_block_class div.td_woo_product_module .price del {
					color: @old_price_color;
                }
                
				/* @btn_txt_color */
				body .$unique_block_class .td_woo_product_module a.button {
					color: @btn_txt_color;
                }
				/* @btn_txt_color_h */
				body .$unique_block_class .td_woo_product_module a.button:hover {
					color: @btn_txt_color_h;
                }
				/* @btn_bg_color */
				body .$unique_block_class .td_woo_product_module a.button {
					background-color: @btn_bg_color;
                }
				/* @btn_bg_color_h */
				body .$unique_block_class .td_woo_product_module a.button:hover {
					background-color: @btn_bg_color_h;
                }
				/* @btn_border_color */
				body .$unique_block_class .td_woo_product_module a.button {
					border-color: @btn_border_color;
                }
				/* @btn_border_color_h */
				body .$unique_block_class .td_woo_product_module a.button:hover {
					border-color: @btn_border_color_h;
                }
                
				/* @pag_text */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a,
				.$unique_block_class .td-load-more-wrap a {
					color: @pag_text;
				}
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap .td-next-prev-icon-svg svg,
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap .td-next-prev-icon-svg svg * {
				    fill: @pag_text;
				}
				/* @pag_bg */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a,
				.$unique_block_class .td-load-more-wrap a {    
					background-color: @pag_bg;
				}
				/* @pag_border */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a,
				.$unique_block_class .td-load-more-wrap a {
					border-color: @pag_border;
				}
				/* @pag_h_text */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a:hover,
				.$unique_block_class .td-load-more-wrap a:hover {
					color: @pag_h_text;
				}
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a:hover .td-next-prev-icon-svg svg,
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a:hover .td-next-prev-icon-svg svg * {
				    fill: @pag_h_text;
				}
				/* @pag_h_bg */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a:hover,
				.$unique_block_class .td-load-more-wrap a:hover {    
					background-color: @pag_h_bg !important;
					border-color: @pag_h_bg !important;
				}
				/* @pag_h_border */
				.$unique_block_class.td_with_ajax_pagination .td-next-prev-wrap a:hover,
				.$unique_block_class .td-load-more-wrap a:hover {
					border-color: @pag_h_border !important;
				}
                
                
                /* @f_header */
				.$unique_block_class .td-block-title a,
				.$unique_block_class .td-block-title span {
					@f_header
				}
				/* @f_ajax */
				.$unique_block_class .td-subcat-list a,
				.$unique_block_class .td-subcat-dropdown span,
				.$unique_block_class .td-subcat-dropdown a {
					@f_ajax
				}
                /* @f_sale */
				body .$unique_block_class .td_woo_product_module .onsale {
					@f_sale
                }
				/* @f_title */
				body .$unique_block_class .td-module-title {
				    @f_title
                }
				/* @f_price */
				body div.$unique_block_class div.td_woo_product_module .price {
					@f_price
                }
				/* @f_old_price */
			    body div.$unique_block_class div.td_woo_product_module .price del {
					@f_old_price
                }
				/* @f_btn */
				body .$unique_block_class .td_woo_product_module a.button {
					@f_btn
                }
				/* @f_more */
				.$unique_block_class .td-load-more-wrap a {
					@f_more
				}
            
            </style>";

	    $td_css_res_compiler = new td_css_res_compiler( $raw_css );
	    $td_css_res_compiler->load_settings( __CLASS__ . '::cssMedia', $this->get_all_atts() );

		$compiled_css .= $td_css_res_compiler->compile_css();

		return $compiled_css;
    }

    static function cssMedia( $res_ctx ) {

        /*-- GENERAL-- */
        $res_ctx->load_settings_raw( 'general_style', 1 );



        // modules per row
        $modules_limit = $res_ctx->get_shortcode_att('limit');
        $modules_on_row = $res_ctx->get_shortcode_att('modules_on_row');
        if ( $modules_on_row == '' ) {
            $modules_on_row = '100%';
        }
        $res_ctx->load_settings_raw( 'modules_on_row', $modules_on_row );
        $modules_number = str_replace('%','',$modules_on_row);
        $modulo_posts = (int)$modules_limit % intval((100/intval($modules_number)));


        // space
        $space = $res_ctx->get_shortcode_att('all_space');
        $res_ctx->load_settings_raw( 'all_space', $space );
        if ( $space != '' ) {
            if( is_numeric( $space ) ) {
                $res_ctx->load_settings_raw( 'all_space', $space . 'px' );
            }
        } else {
            $res_ctx->load_settings_raw( 'all_space', '40px' );
        }

        // modules clearfix
        $padding = 'padding';
        if ( $res_ctx->is( 'all' ) ) {
            $padding = 'padding_desktop';
        }
        switch ($modulo_posts) {
            case '0':
                $res_ctx->load_settings_raw( $padding,  '-n+' . intval(100/intval($modules_number)));
                break;
            case '1':
                $res_ctx->load_settings_raw( $padding,  '1' );
                break;
            case '2':
                $res_ctx->load_settings_raw( $padding,  '-n+2' );
                break;
            case '3':
                $res_ctx->load_settings_raw( $padding,  '-n+3' );
                break;
            case '4':
                $res_ctx->load_settings_raw( $padding,  '-n+4' );
                break;
            case '5':
                $res_ctx->load_settings_raw( $padding,  '-n+5' );
                break;
            case '6':
                $res_ctx->load_settings_raw( $padding,  '-n+6' );
                break;
            case '7':
                $res_ctx->load_settings_raw( $padding,  '-n+7' );
                break;
            case '8':
                $res_ctx->load_settings_raw( $padding,  '-n+8' );
                break;
        }

        // gap
        $gap = $res_ctx->get_shortcode_att('gap');
        $res_ctx->load_settings_raw( 'gap', $gap );
        if ( $gap == '' ) {
            $res_ctx->load_settings_raw( 'gap', '15px');
        } else if ( is_numeric( $gap ) ) {
            $res_ctx->load_settings_raw( 'gap', $gap / 2 .'px' );
        }


        // image width
        $img_width = $res_ctx->get_shortcode_att('img_width');
        if ( is_numeric( $img_width ) ) {
            $res_ctx->load_settings_raw( 'img_width', $img_width . '%' );
        } else {
            $res_ctx->load_settings_raw( 'img_width', $img_width );
        }

        // image_height
        $img_height = $res_ctx->get_shortcode_att('img_height');
        if ( is_numeric( $img_height ) ) {
            $res_ctx->load_settings_raw( 'img_height', $img_height . '%' );
        } else {
            $res_ctx->load_settings_raw( 'img_height', $img_height );
        }

        //image alignment
        $res_ctx->load_settings_raw( 'img_alignment', $res_ctx->get_shortcode_att('img_alignment') . '%' );

        // image position
        $img_pos = $res_ctx->get_shortcode_att('img_pos');
        if( $img_pos == '' || $img_pos == 'normal' || $img_pos == 'hidden' ) {
            $res_ctx->load_settings_raw( 'module_direction', 'column' );
        } else {
            $res_ctx->load_settings_raw( 'module_direction', 'row' );
        }
        if( $img_pos == 'right' ) {
            $res_ctx->load_settings_raw( 'img_last', 1 );
        } else {
            $res_ctx->load_settings_raw( 'img_first', 1 );
        }
        if( $img_pos == 'hidden' ) {
            $res_ctx->load_settings_raw( 'img_show', 'none' );
        } else {
            $res_ctx->load_settings_raw( 'img_show', 'block' );
        }

        // image space
        $img_space = $res_ctx->get_shortcode_att('img_space');
        $res_ctx->load_settings_raw( 'img_space', $img_space );
        if ( $img_space != '' && is_numeric( $img_space ) ) {
            $res_ctx->load_settings_raw( 'img_space', $img_space . 'px' );
        }

        // image radius
        $img_radius = $res_ctx->get_shortcode_att('img_radius');
        $res_ctx->load_settings_raw( 'img_radius', $img_radius );
        if ( $img_radius != '' && is_numeric( $img_radius ) ) {
            $res_ctx->load_settings_raw( 'img_radius', $img_radius . 'px' );
        }


        // sale tag margin
        $sale_margin = $res_ctx->get_shortcode_att('sale_margin');
        $res_ctx->load_settings_raw( 'sale_margin', $sale_margin );
        if ( $sale_margin != '' && is_numeric( $sale_margin ) ) {
            $res_ctx->load_settings_raw( 'sale_margin', $sale_margin . 'px' );
        }

        // sale tag padding
        $sale_padding = $res_ctx->get_shortcode_att('sale_padding');
        $res_ctx->load_settings_raw( 'sale_padding', $sale_padding );
        if ( $sale_padding != '' && is_numeric( $sale_padding ) ) {
            $res_ctx->load_settings_raw( 'sale_padding', $sale_padding . 'px' );
        }

        // sale tag border size
        $sale_border = $res_ctx->get_shortcode_att( 'sale_border' );
        $res_ctx->load_settings_raw( 'sale_border', $sale_border );
        if( $sale_border != '' && is_numeric( $sale_border ) ) {
            $res_ctx->load_settings_raw( 'sale_border', $sale_border . 'px' );
        }
        // sale tag border style
        $res_ctx->load_settings_raw( 'sale_border_style', $res_ctx->get_shortcode_att( 'sale_border_style'  ) );
        // sale tag border radius
        $sale_radius = $res_ctx->get_shortcode_att( 'sale_radius' );
        $res_ctx->load_settings_raw( 'sale_radius', $sale_radius );
        if( $sale_radius != '' && is_numeric( $sale_radius ) ) {
            $res_ctx->load_settings_raw( 'sale_radius', $sale_radius . 'px' );
        }


        // meta info vertical align
        $meta_info_align = $res_ctx->get_shortcode_att('meta_info_align');
        $res_ctx->load_settings_raw( 'meta_info_align', $meta_info_align );

        // meta info horiz align
        $horiz_align = $res_ctx->get_shortcode_att('horiz_align');
        if( $horiz_align == 'content-horiz-left' ) {
            $res_ctx->load_settings_raw( 'horiz_align_left', 1 );
        } else if( $horiz_align == 'content-horiz-center' ) {
            $res_ctx->load_settings_raw( 'horiz_align_center', 1 );
        } else if( $horiz_align == 'content-horiz-right' ) {
            $res_ctx->load_settings_raw( 'horiz_align_right', 1 );
        }

        // meta info width
        $meta_info_width = $res_ctx->get_shortcode_att('meta_width');
        $res_ctx->load_settings_raw( 'meta_width', $meta_info_width );
        if( $meta_info_width != '' && is_numeric( $meta_info_width ) ) {
            $res_ctx->load_settings_raw( 'meta_width', $meta_info_width . 'px' );
        }

        // meta info margin
        $meta_margin = $res_ctx->get_shortcode_att('meta_margin');
        $res_ctx->load_settings_raw( 'meta_margin', $meta_margin );
        if ( is_numeric( $meta_margin ) ) {
            $res_ctx->load_settings_raw( 'meta_margin', $meta_margin . 'px' );
        }

        // meta info padding
        $meta_padding = $res_ctx->get_shortcode_att('meta_padding');
        $res_ctx->load_settings_raw( 'meta_padding', $meta_padding );
        if ( is_numeric( $meta_padding ) ) {
            $res_ctx->load_settings_raw( 'meta_padding', $meta_padding . 'px' );
        }

        // meta info border width
        $meta_info_border_size = $res_ctx->get_shortcode_att('meta_info_border_size');
        $res_ctx->load_settings_raw( 'meta_info_border_size', $meta_info_border_size );
        if ( is_numeric( $meta_info_border_size ) ) {
            $res_ctx->load_settings_raw( 'meta_info_border_size', $meta_info_border_size . 'px' );
        }

        // meta info border style
        $res_ctx->load_settings_raw( 'meta_info_border_style', $res_ctx->get_shortcode_att('meta_info_border_style') );


        // title space
        $title_space = $res_ctx->get_shortcode_att('title_space');
        $res_ctx->load_settings_raw( 'title_space', $title_space );
        if ( $title_space != '' && is_numeric( $title_space ) ) {
            $res_ctx->load_settings_raw( 'title_space', $title_space . 'px' );
        }

        // show stars
        $res_ctx->load_settings_raw( 'show_stars', $res_ctx->get_shortcode_att('show_stars') );

        // stars size
        $stars_size = $res_ctx->get_shortcode_att('stars_size');
        $res_ctx->load_settings_raw( 'stars_size', $stars_size );
        if ( $stars_size != '' && is_numeric( $stars_size ) ) {
            $res_ctx->load_settings_raw( 'stars_size', $stars_size . 'px' );
        }

        // stars space
        $stars_space = $res_ctx->get_shortcode_att('stars_space');
        $res_ctx->load_settings_raw( 'stars_space', $stars_space );
        if ( $stars_space != '' && is_numeric( $stars_space ) ) {
            $res_ctx->load_settings_raw( 'stars_space', $stars_space . 'px' );
        }

        // price space
        $price_space = $res_ctx->get_shortcode_att('price_space');
        $res_ctx->load_settings_raw( 'price_space', $price_space );
        if ( $price_space != '' && is_numeric( $price_space ) ) {
            $res_ctx->load_settings_raw( 'price_space', $price_space . 'px' );
        }

        // button padding
        $btn_padding = $res_ctx->get_shortcode_att('btn_padding');
        $res_ctx->load_settings_raw( 'btn_padding', $btn_padding );
        if ( $btn_padding != '' && is_numeric( $btn_padding ) ) {
            $res_ctx->load_settings_raw( 'btn_padding', $btn_padding . 'px' );
        }

        // button border size
        $btn_border = $res_ctx->get_shortcode_att('btn_border');
        $res_ctx->load_settings_raw( 'btn_border', $btn_border );
        if ( $btn_border != '' && is_numeric( $btn_border ) ) {
            $res_ctx->load_settings_raw( 'btn_border', $btn_border . 'px' );
        }

        // button border style
        $btn_border_style = $res_ctx->get_shortcode_att('btn_border_style');
        $res_ctx->load_settings_raw( 'btn_border_style', $btn_border_style );

        // button border radius
        $btn_radius = $res_ctx->get_shortcode_att('btn_radius');
        $res_ctx->load_settings_raw( 'btn_radius', $btn_radius );
        if ( $btn_radius != '' && is_numeric( $btn_radius ) ) {
            $res_ctx->load_settings_raw( 'btn_radius', $btn_radius . 'px' );
        }

        // show button
        $res_ctx->load_settings_raw( 'show_btn', $res_ctx->get_shortcode_att('show_btn') );

        // pagination space
        $pag_space = $res_ctx->get_shortcode_att('pag_space');
        $res_ctx->load_settings_raw( 'pag_space', $pag_space );
        if( $pag_space != '' && is_numeric( $pag_space ) ) {
            $res_ctx->load_settings_raw( 'pag_space', $pag_space . 'px' );
        }
        // pagination padding
        $pag_padding = $res_ctx->get_shortcode_att('pag_padding');
        $res_ctx->load_settings_raw( 'pag_padding', $pag_padding );
        if( $pag_padding != '' && is_numeric( $pag_padding ) ) {
            $res_ctx->load_settings_raw( 'pag_padding', $pag_padding . 'px' );
        }
        // pagination border width
        $pag_border_width = $res_ctx->get_shortcode_att('pag_border_width');
        $res_ctx->load_settings_raw( 'pag_border_width', $pag_border_width );
        if( $pag_border_width != '' && is_numeric( $pag_border_width ) ) {
            $res_ctx->load_settings_raw( 'pag_border_width', $pag_border_width . 'px' );
        }
        // pagination border radius
        $pag_border_radius = $res_ctx->get_shortcode_att('pag_border_radius');
        $res_ctx->load_settings_raw( 'pag_border_radius', $pag_border_radius );
        if( $pag_border_radius != '' && is_numeric( $pag_border_radius ) ) {
            $res_ctx->load_settings_raw( 'pag_border_radius', $pag_border_radius . 'px' );
        }
        // next/prev icons size
        $pag_icons_size = $res_ctx->get_shortcode_att('pag_icons_size');
        $res_ctx->load_settings_raw( 'pag_icons_size', $pag_icons_size );
        if( $pag_icons_size != '' && is_numeric( $pag_icons_size ) ) {
            $res_ctx->load_settings_raw( 'pag_icons_size', $pag_icons_size . 'px' );
        }


        /*-- COLORS -- */
        $res_ctx->load_settings_raw( 'sale_txt_color', $res_ctx->get_shortcode_att('sale_txt_color') );
        $res_ctx->load_settings_raw( 'sale_txt_color_h', $res_ctx->get_shortcode_att('sale_txt_color_h') );
        $res_ctx->load_settings_raw( 'sale_bg_color', $res_ctx->get_shortcode_att('sale_bg_color') );
        $res_ctx->load_settings_raw( 'sale_bg_color_h', $res_ctx->get_shortcode_att('sale_bg_color_h') );
        $res_ctx->load_settings_raw('sale_border_color', $res_ctx->get_shortcode_att( 'sale_border_color' ));
        $res_ctx->load_settings_raw('sale_border_color_h', $res_ctx->get_shortcode_att( 'sale_border_color_h' ));

        $res_ctx->load_settings_raw( 'meta_bg', $res_ctx->get_shortcode_att('meta_bg') );
        $res_ctx->load_settings_raw( 'meta_border_color', $res_ctx->get_shortcode_att('meta_border_color') );

        $res_ctx->load_settings_raw( 'title_color', $res_ctx->get_shortcode_att('title_color') );
        $res_ctx->load_settings_raw( 'title_color_h', $res_ctx->get_shortcode_att('title_color_h') );

        $res_ctx->load_settings_raw( 'stars_full_color', $res_ctx->get_shortcode_att( 'stars_full_color' ) );
        $res_ctx->load_settings_raw( 'stars_empty_color', $res_ctx->get_shortcode_att( 'stars_empty_color' ) );

        $res_ctx->load_settings_raw( 'price_color', $res_ctx->get_shortcode_att('price_color') );
        $res_ctx->load_settings_raw( 'sale_price_color', $res_ctx->get_shortcode_att('sale_price_color') );
        $res_ctx->load_settings_raw( 'old_price_color', $res_ctx->get_shortcode_att('old_price_color') );

        $res_ctx->load_settings_raw( 'btn_txt_color', $res_ctx->get_shortcode_att('btn_txt_color') );
        $res_ctx->load_settings_raw( 'btn_txt_color_h', $res_ctx->get_shortcode_att('btn_txt_color_h') );
        $res_ctx->load_settings_raw( 'btn_bg_color', $res_ctx->get_shortcode_att('btn_bg_color') );
        $res_ctx->load_settings_raw( 'btn_bg_color_h', $res_ctx->get_shortcode_att('btn_bg_color_h') );
        $res_ctx->load_settings_raw( 'btn_border_color', $res_ctx->get_shortcode_att('btn_border_color') );
        $res_ctx->load_settings_raw( 'btn_border_color_h', $res_ctx->get_shortcode_att('btn_border_color_h') );

        $res_ctx->load_settings_raw( 'pag_text', $res_ctx->get_shortcode_att('pag_text') );
        $res_ctx->load_settings_raw( 'pag_bg', $res_ctx->get_shortcode_att('pag_bg') );
        $res_ctx->load_settings_raw( 'pag_border', $res_ctx->get_shortcode_att('pag_border') );
        $res_ctx->load_settings_raw( 'pag_h_text', $res_ctx->get_shortcode_att('pag_h_text') );
        $res_ctx->load_settings_raw( 'pag_h_bg', $res_ctx->get_shortcode_att('pag_h_bg') );
        $res_ctx->load_settings_raw( 'pag_h_border', $res_ctx->get_shortcode_att('pag_h_border') );


        /*-- FONTS -- */
        $res_ctx->load_font_settings( 'f_header' );
        $res_ctx->load_font_settings( 'f_ajax' );
        $res_ctx->load_font_settings( 'f_sale' );
        $res_ctx->load_font_settings( 'f_title' );
        $res_ctx->load_font_settings( 'f_price' );
        $res_ctx->load_font_settings( 'f_old_price' );
        $res_ctx->load_font_settings( 'f_btn' );
        $res_ctx->load_font_settings( 'f_more' );

    }

	// set block type to products
	function __construct() {
		parent::set_products_block();
	}

    function render($atts, $content = null) {

	    global $td_woo_state_single_product_page;

	    switch( tdb_state_template::get_template_type() ) {

		    case 'woo_product':
			    $block_data = $td_woo_state_single_product_page->block->__invoke( $atts );

			    $atts['p_id'] = $block_data['p_id'];

			    $atts['p_cats_ids'] = $block_data['p_cats_ids'];
			    $atts['p_tags_slugs'] = $block_data['p_tags_slugs'];

			    $atts['p_upsells_ids'] = $block_data['upsells_ids'];

			    break;

		    case 'woo_archive':
		    case 'woo_search_archive':
		    case 'woo_shop_base':
		    default:
			    $block_data = array();
	    }

	    $single_product_page_filter = $atts['single_product_page_filter'] ?? '';

        parent::render($atts);

        $additional_classes = array();

        // TODO: temporary "no products" message. should be replaced with dummy data.
        if ( tdc_state::is_live_editor_ajax() || tdc_state::is_live_editor_iframe() ) {
            if ( empty( $this->td_query['ids'] ) ) {
                $additional_classes[] = 'tdc-no-posts';
            }
        }

        if ( !empty($single_product_page_filter) ) {
	        $additional_classes[] = 'tdw-single-product-page-filter-' . $single_product_page_filter;
        }

	    $buffy = '<div class="' . $this->get_block_classes( $additional_classes ) . ' td_flex_block" ' . $this->get_block_html_atts() . '>';

//        if ( !in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
//            if (td_util::tdc_is_live_editor_iframe() || td_util::tdc_is_live_editor_ajax()) {
//                $buffy .= td_util::get_block_error('Woo Product Block', 'Please install and activate Woocommerce plugin');
//                $buffy .= '</div>';
//            }
//            return $buffy;
//        }
		    //get the block js
		    $buffy .= $this->get_block_css();

		    //get the js for this block
		    $buffy .= $this->get_block_js();

            // block title wrap
            $buffy .= '<div class="td-block-title-wrap">';
	            // get block title
                $buffy .= $this->get_block_title();

	            // get the sub category filter for this block
	            $buffy .= $this->get_pull_down_filter();
            $buffy .= '</div>';

            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner tdw-block-inner">';
	            $buffy .= $this->inner( $this->td_query['ids'] ); // inner content of the block
            $buffy .= '</div>';

            // get the ajax pagination for this block
            $prev_icon = $this->get_icon_att('prev_tdicon');
            $next_icon = $this->get_icon_att('next_tdicon');
            $buffy .= $this->get_block_pagination($prev_icon, $next_icon);

        $buffy .= '</div>';

        return $buffy;
    }

    function inner($products_ids) {

        $buffy = '';
        $td_block_layout = new td_block_layout();

            if ( !empty( $products_ids ) ) {
                foreach ( $products_ids as $products_id ) {

                    $wp_post_product = get_post($products_id);

                    $td_woo_product_module = new td_woo_product_module( $wp_post_product, $this->get_all_atts() );
                    $buffy .= $td_woo_product_module->render();
                }
            }

            $buffy .= $td_block_layout->close_all_tags();

        return $buffy;
    }

    function js_tdc_callback_ajax() {
        $buffy = '';

        // add a new composer block - that one has the delete callback
        $buffy .= $this->js_tdc_get_composer_block();

        ob_start();

        ?>
        <script>

            // block subcategory ajax filters!
            var jquery_object_container = jQuery('.<?php printf( '%1$s', $this->block_uid ) ?>');
            if ( jquery_object_container.length) {
                var horizontal_jquery_obj = jquery_object_container.find('.td-subcat-list:first');

                if ( horizontal_jquery_obj.length) {

                    // make a new item
                    var pulldown_item_obj = new tdPullDown.item();
                    pulldown_item_obj.blockUid = jquery_object_container.data('td-block-uid'); // get the block UID
                    pulldown_item_obj.horizontal_jquery_obj = horizontal_jquery_obj;
                    pulldown_item_obj.vertical_jquery_obj = jquery_object_container.find('.td-subcat-dropdown:first');
                    pulldown_item_obj.horizontal_element_css_class = 'td-subcat-item';
                    pulldown_item_obj.container_jquery_obj = horizontal_jquery_obj.closest('.td-block-title-wrap');
                    pulldown_item_obj.excluded_jquery_elements = [pulldown_item_obj.container_jquery_obj.find('.td-pulldown-size')];

                    // add the item
                    tdPullDown.add_item(pulldown_item_obj);

                }
            }

        </script>
        <?php

        return $buffy . td_util::remove_script_tag( ob_get_clean() );
    }

}