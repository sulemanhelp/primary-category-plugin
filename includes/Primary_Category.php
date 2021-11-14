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
		$this->init();
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
	 *  Initialize Classes.
	 */
	protected function init() {

		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			require $this->dir . '/admin/Primary_Category_Admin.php';
			$this->admin = new Primary_Category_Admin();
		} else {
			require $this->dir . '/admin/Primary_Category_Public.php';
			$this->public = new Primary_Category_Public();
		}
	}
}
