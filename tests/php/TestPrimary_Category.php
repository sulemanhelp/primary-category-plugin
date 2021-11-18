<?php
/**
 * Tests for Primary_Category class.
 *
 * @package PrimaryCategory
 */

namespace Suleman\PrimaryCategory;

use WP_Mock;

/**
 * Test the WordPress plugin abstraction.
 */
class TestPrimary_Category extends TestCase {

	/**
	 * Test the plugin setup.
	 *
	 * @covers \Suleman\PrimaryCategory\Primary_Category::__construct()
	 * @covers \Suleman\PrimaryCategory\Primary_Category::file()
	 * @covers \Suleman\PrimaryCategory\Primary_Category::dir()
	 * @covers \Suleman\PrimaryCategory\Primary_Category::asset_url()
	 */
	public function test_plugin_init() {
		WP_Mock::userFunction( 'is_admin' )
			->once()
			->withNoArgs()
			->andReturn( false );

		WP_Mock::userFunction( 'plugins_url' )
			->once()
			->with( '/some/assets.php', '/absolute/path/to/plugin.php' )
			->andReturn( '/absolute/path/to/some/assets.php' );

		$plugin = new Primary_Category( '/absolute/path/to/plugin.php' );

		$this->assertEquals( '/absolute/path/to/plugin.php', $plugin->file() );
		$this->assertEquals( '/absolute/path/to', $plugin->dir() );
		$this->assertEquals( '/absolute/path/to/some/assets.php', $plugin->asset_url( '/some/assets.php' ) );
	}

	/**
	 * Test get_post_types function to see if we get correct return value format.
	 *
	 * @covers \Suleman\PrimaryCategory\Primary_Category::get_post_types()
	 */
	public function test_get_post_types() {
		$data        = new \stdClass();
		$data->label = 'Posts';
		$data->name  = 'post';

		global $wp_taxonomies;
		$wp_taxonomies = array(
			'category' => new \stdClass(),
		);

		$wp_taxonomies['category']->object_type = array( 'post' );

		WP_Mock::userFunction( 'get_post_type_object' )
			->once()
			->with( 'post' )
			->andReturn( $data );

		WP_Mock::userFunction( 'is_admin' )
			->once()
			->withNoArgs()
			->andReturn( false );

		$expect = array(
			array(
				'label' => 'Posts',
				'value' => 'post',
			),
		);

		$primary_cat = new Primary_Category( '/absolute/path/to/plugin.php' );
		$result      = $primary_cat->get_post_types();

		$this->assertEquals( $expect, $result );
	}

}
