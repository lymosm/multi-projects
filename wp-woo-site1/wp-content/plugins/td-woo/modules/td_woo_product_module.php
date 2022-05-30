<?php

class td_woo_product_module extends td_module {

	var $product;

    function __construct( $post, $module_atts = array() ) {
        // run the parent constructor
        parent::__construct($post, $module_atts );
	    $this->product = wc_get_product($this->post->ID);
    }

    function render() {

        ob_start();
        $image_size = $this->get_shortcode_att('img_size');
        if (empty($image_size)) {
            $image_size = 'td_696x0';
        }
        $image_hide = $this->get_shortcode_att('hide_image');
	    $link = apply_filters( 'woocommerce_loop_product_link', get_permalink( $this->product->get_id() ), $this->product );
	    $average_rating = $this->product->get_average_rating();

        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <div class="td-module-container">

                <?php if( $image_hide == '' ) { ?>
                    <div class="td-image-container">
                        <?php echo $this->get_image( $image_size, true ); ?>
                        <?php echo $this->get_sale_badge(); ?>
                    </div>
                <?php } ?>

                <div class="td-module-meta-info">
                    <h3 class="td-module-title"><a href="<?php echo esc_url( $link ) ?>" class="product-link"><?php echo $this->product->get_title() ?></a></h3>

                    <?php
                        if( $average_rating ) { ?>
                            <div class="star-rating" title="<?php echo sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average_rating) ?>">
                                <span style="width:<?php echo ( ( $average_rating / 5 ) * 100 ) ?>%">
                                    <strong itemprop="ratingValue" class="rating"><?php echo $average_rating ?></strong>
                                    <?php echo __( 'out of 5', 'woocommerce' ) ?>
                                </span>
                            </div>
                        <?php }
                    ?>

                    <span class="price">
                        <?php echo $this->product->get_price_html(); ?>
                    </span>

                    <div class="read-more">
                        <?php echo $this->add_to_cart(); ?>
                    </div>
                </div>

            </div>
        </div>

        <?php return ob_get_clean();
    }

    function add_to_cart( $args = array() ) {

	    $defaults = array(
		    'quantity'   => 1,
		    'class'      => implode(
			    ' ',
			    array_filter(
				    array(
					    'button',
					    'product_type_' . $this->product->get_type(),
					    $this->product->is_purchasable() && $this->product->is_in_stock() ? 'add_to_cart_button' : '',
					    $this->product->supports( 'ajax_add_to_cart' ) && $this->product->is_purchasable() && $this->product->is_in_stock() ? 'ajax_add_to_cart' : '',
				    )
			    )
		    ),
		    'attributes' => array(
			    'data-product_id'  => $this->product->get_id(),
			    'data-product_sku' => $this->product->get_sku(),
			    'aria-label'       => $this->product->add_to_cart_description(),
			    'rel'              => 'nofollow',
		    ),
	    );

	    $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $this->product );

	    if ( isset( $args['attributes']['aria-label'] ) ) {
		    $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
	    }

	    return apply_filters(
		    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
		    sprintf(
			    '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
			    esc_url( $this->product->add_to_cart_url() ),
			    esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			    esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
			    isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
			    esc_html( $this->product->add_to_cart_text() )
		    ),
		    $this->product,
		    $args
	    );

    }

    function get_sale_badge() {

        $product = $this->product;
	    $post = $this->post;

	    if ( $product->is_on_sale() ) {
	        return apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );

        }

	    return  '';
    }
}