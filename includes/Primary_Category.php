<?php
/**
 * Primary Category class.
 *
 * @package PrimaryCategory
 */

namespace Suleman\PrimaryCategory;

/**
 * Primary Category init class. entry point for all functionality.
 *
 * @package PrimaryCategory
 */
class Primary_Category {
	/**
	 * Absolute path to the main plugin file.
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * Absolute path to the root directory of this plugin.
	 *
	 * @var string
	 */
	protected $dir;

	/**
	 * Plugin Admin class object.
	 *
	 * @var null|Primary_Category_Admin
	 */
	protected $admin = null;

	/**
	 * Plugin Public class object.
	 *
	 * @var null|Primary_Category_Public
	 */
	protected $public = null;

	/**
	 * Setup the plugin.
	 *
	 * @param string $plugin_file_path Absolute path to the main plugin file.
	 */
	public function __construct( $plugin_file_path ) {
		$this->file        = $plugin_file_path;
		$this->dir         = dirname( $plugin_file_path );

		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			require $this->dir . '/admin/Primary_Category_Admin.php';
			$this->admin = new Primary_Category_Admin( $this );
		}

		add_action( 'init', array( $this, 'init' ), 10, 1 );
	}

	/**
	 * Return the absolute path to the plugin directory.
	 *
	 * @return string
	 */
	public function dir() {
		return $this->dir;
	}

	/**
	 * Return the absolute path to the plugin file.
	 *
	 * @return string
	 */
	public function file() {
		return $this->file;
	}

	/**
	 *  Initialization.
	 */
	public function init() {
		$this->register_meta();
		$this->enqueue_block_js_assets();
		$this->register_block();
	}

	/**
	 * register over postmeta.
	 */
	protected function register_meta() {
		register_meta( 'post', 'post_primary_category', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'integer',
		) );
	}

	/**
	 * Get the public URL to the asset file.
	 *
	 * @param string $path_relative Path relative to this plugin directory root.
	 * @return string The URL to the asset.
	 */
	public function asset_url( $path_relative ) {
		return plugins_url( $path_relative, $this->file() );
	}

	/**
	* Enqueue private category block javascript
	*/
	public function enqueue_block_js_assets() {
		// automatically load dependencies and version.
		$asset_file = include( $this->dir() . '/dist/js/primary-category-posts.asset.php' );

		wp_register_script(
			'private-category-blocks-js',
			$this->asset_url( 'dist/js/primary-category-posts.js' ),
			$asset_file['dependencies'],
			$asset_file['version']
		);

		$this->localize_block_required_data();
	}

	/**
	 * Localize variables for primary category block
	 */
	public function localize_block_required_data() {
		wp_localize_script(
			'private-category-blocks-js',
			'categoryBlockData',
			array(
				'postTypesWithCategory' => $this->get_post_types(),
				//'allCategories' => $this->get_categories(),
			)
		);
	}

	/**
	 * Return CPT with 'Category' taxonomy.
	 *
	 * @return array
	 */
	public function get_post_types(){
		global $wp_taxonomies;
		$types = $wp_taxonomies['category']->object_type;
		$ret = array();

		foreach ( $types as $type ) {
			$type = get_post_type_object($type);
			$ret[] = array( 'label' => $type->label, 'value' => $type->name);
		}

		return $ret;
	}

	public function get_categories(){
		$categories = get_categories();
		$ret = array();
		foreach ( $categories as $category ) {
			$ret[] = array( 'label' => $category->name, 'value' => $category->term_id);
		}
	}

	/**
	 * Register block for gutenberg use.
	 */
	protected function register_block() {
		register_block_type(
			'gutenberg-private-category-blocks/primary-category',
			array(
				'api_version'     => 2,
				'editor_script'   => 'private-category-blocks-js',
				'attributes'      =>
					array(
						'selectedCategory' =>
							array(
								'type'    => 'integer',
								'default' => 0,
							),
						'postType' =>
							array(
								'type'    => 'string',
								'default' => 'post',
							),
					),
				'render_callback' =>
					array(
						$this,
						'render_callback',
					),
			)
		);
	}

	/**
	 * Render Block HTML for both editor and front-end
	 *
	 * @param array  $block_attributes Block attributes values.
	 * @param string $content Content.
	 *
	 * @return string
	 */
	public function render_callback( $block_attributes, $content ) {
		if ( $this->public === null ) {
			require $this->dir . '/public/Primary_Category_Public.php';
			$this->public = new Primary_Category_Public( $this );
		}
		return $this->public->render( $block_attributes, $content );
	}
}
