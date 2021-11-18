<?php
/**
 * Front-End functionality class.
 *
 * @package PrimaryCategory
 */

namespace Suleman\PrimaryCategory;

/**
 * Public class for all front end side functionality control.
 *
 * @package PrimaryCategory
 */
class Primary_Category_Public {

	/**
	 * Object of Primary_Category class.
	 *
	 * @var Primary_Category
	 */
	protected $main;

	/**
	 * Object of WP_Query class.
	 *
	 * @var WP_Query
	 */
	protected $query;

	/**
	 * Constructor.
	 *
	 * @param Primary_Category $main Reference to parent object.
	 */
	public function __construct( $main, $wp_query = null ) {
		$this->main = $main;
		$this->query = $wp_query ? $wp_query : new \WP_Query();
	}

	/**
	 * Render Block HTML.
	 *
	 * @param array  $attributes Block attributes values.
	 * @param string $content Content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {

		$args = array(
			'post_type'              => $attributes['postType'],
			'meta_query'             => array(
				array(
					'key'   => 'post_primary_category',
					'value' => $attributes['selectedCategory'],
				),
			),
			'update_post_term_cache' => false,
			'no_found_rows'          => false,    // Not loading pagination in exercise.
		);

		$this->query->query( $args );
		$ret   = '';

		if ( $this->query->have_posts() ) :
			while ( $this->query->have_posts() ) :
				$this->query->the_post();
				$ret .= sprintf( '<li><a href="%1$s" title="%2$s">%2$s</a></li>', get_the_permalink(), get_the_title() );
			endwhile;
		endif;

		if ( ! empty( $ret ) ) {
			$ret = '<ul>' . $ret . '</ul>';
		} else {
			$ret = 'No post found';
		}

		return $ret;
	}
}
