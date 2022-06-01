<?php

namespace Rehub\Gutenberg\Blocks;

defined( 'ABSPATH' ) OR exit;

class TaxArchive extends Basic {
	protected $name = 'tax-archive';

	protected function __construct() {
		parent::__construct();
	}

	static $fonts = array();

	protected $attributes = array(
		'taxonomy' => array(
			'type' => 'string',
			'default' => 'category',
		),
		'child_of' => array(
			'type' => 'array',
			'default' => null
		),
		'include' => array(
			'type' => 'array',
			'default' => null
		),
		'type' => array(
			'type' => 'string',
			'default' => 'storegrid',
		),
		'classcol' => array(
			'type' => 'string',
			'default' => 'col_wrap_three'
		),
		'limit' => array(
			'type' => 'string',
			'default' => '',
		),
		'imageheight' => array(
			'type' => 'string',
			'default' => '50',
		),
		'classitem' => array(
			'type' => 'string',
			'default' => '',
		),
		'anchor_before' => array(
			'type' => 'number',
			'default' => '',
		),
		'anchor_after' => array(
			'type' => 'string',
			'default' => '',
		),
		'wrapclass' => array(
			'type' => 'string',
			'default' => 'no_padding_wrap',
		),
		'rows' => array(
			'type' => 'string',
			'default' => '1',
		),
		'random' => array(
			'type' => 'string',
			'default' => '',
		),
		'show_images' => array(
			'type' => 'string',
			'default' => '1',
		),
		'hide_empty' => array(
			'type' => 'string',
			'default' => '1',
		),
		'showcount' => array(
			'type' => 'string',
			'default' => '',
		),
		'leftimage' => array(
			'type' => 'string',
			'default' => '',
		),
		'originalimg' => array(
			'type' => 'string',
			'default' => '',
		),
	);

	protected function render( $settings = array(), $inner_content = '' ) {

		if ( !empty( $settings['child_of'] ) ) {
			$settings['child_of'] = get_term_by( 'slug', $settings['child_of']['id'], $settings['taxonomy'] )->term_id;
		}

		if ( !empty( $settings['include'] ) ) {
			$this->normalize_terms( $settings );
		}

		$output = str_replace( "{{ content }}", wpsm_tax_archive_shortcode( $settings ), $inner_content );
		
		echo $output;
	}
}