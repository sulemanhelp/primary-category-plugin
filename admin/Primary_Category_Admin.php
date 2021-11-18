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
	 * Object of Primary_Category class.
	 *
	 * @var Primary_Category
	 */
	protected $main;

	/**
	 * Constructor.
	 *
	 * @param Primary_Category $main - Reference to main object.
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

		$asset_file = include( $this->main->dir() . '/dist/js/block-editor.asset.php' );
		global $post, $wp_taxonomies;
		$selected_id = isset( $post->ID ) ? get_post_meta( $post->ID, 'post_primary_category', true ) : 0;
		$selected_id = 0 !== $selected_id && empty( $selected_id ) ? 0 : $selected_id;

		// Register the script.
		wp_register_script(
			'gutenberg-primary-category-option-js',
			$this->main->asset_url( 'dist/js/block-editor.js' ),
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_enqueue_script( 'gutenberg-primary-category-option-js' );

		wp_localize_script(
			'gutenberg-primary-category-option-js',
			'categoryData',
			array(
				'selectedPrimaryCategory' => $selected_id,
				'categoryRestBase'        => $wp_taxonomies['category']->rest_base,
			)
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
