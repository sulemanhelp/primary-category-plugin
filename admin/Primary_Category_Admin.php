<?php
/**
 * Admin functionality class.
 *
 * @package PrimaryCategory
 */

namespace Suleman\PrimaryCategory;

/**
 * Admin class for all wp-admin side functionality control.
 *
 * @package PrimaryCategory
 */
class Primary_Category_Admin {

	/**
	 * object of Primary_Category class.
	 *
	 * @var Primary_Category
	 */
	protected $main;

	/**
	 * Constructor.
	 */
	public function __construct( $main ) {
		$this->main = $main;
		$this->register_hooks();
	}

	/**
	 * Register Hooks.
	 */
	public function register_hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ), 10, 1 );
		add_action( 'save_post', array( $this, 'save_term' ), 10, 2 );
	}

	/**
	 * Enqueue Script.
	 *
	 * @param string $hook_suffix - Page hook suffix.
	 */
	public function enqueue_script( $hook_suffix ) {

		// Get current screen to determine the gutenberg editor.
		$screen = get_current_screen();

		if ( ! $this->is_post_edit( $hook_suffix ) || ( ! isset( $screen->is_block_editor ) || ! $screen->is_block_editor ) ) {
			return;
		}

		$post_categories = get_categories();

		if ( empty( $post_categories ) ) {
			return;
		}

		$asset_file = include( $this->main->dir() . '/dist/js/editor.asset.php' );
		global $post;
		$selectedId = isset( $post->ID ) ? get_post_meta( $post->ID, 'post_primary_category', true ) : -1;
		$selectedId = $selectedId !== 0 && empty( $selectedId ) ? -1 : $selectedId;

		// Register the script
		wp_register_script(
			'gutenberg-primary-category-option-js',
			$this->main->asset_url( 'dist/js/editor.js' ),
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_enqueue_script( 'gutenberg-primary-category-option-js' );

		wp_localize_script(
			'gutenberg-primary-category-option-js',
			'categoryData',
			array(
				'categories' => array_map( array( $this, 'get_categories_js' ), $post_categories ),
				'selectedPrimaryCategory' => $selectedId,
			)
		);
	}

	/**
	 * Convert category data for JS in array.
	 *
	 * @param WP_Taxonomy $cat - WP Taxonomy object.
	 * @return array
	 */
	public function get_categories_js( $cat ) {
		return array(
			'id'   => $cat->term_id,
			'name' => $cat->name,
		);
	}

	/**
	 * Returns true if the current page is post edit page.
	 *
	 * @param string $hook_suffix - Page hook suffix.
	 * @return boolean
	 */
	public function is_post_edit( $hook_suffix = '' ) {
		if ( '' === $hook_suffix ) {
			global $pagenow;
			$hook_suffix = $pagenow;
		}

		return 'post-new.php' === $hook_suffix || 'post.php' === $hook_suffix;
	}
}
