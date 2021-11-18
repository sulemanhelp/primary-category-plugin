<?php
/**
 * Tests for Primary_Category_Public class.
 *
 * @package PrimaryCategory
 */

namespace Suleman\PrimaryCategory;

require dirname( __FILE__ ) . '/../../public/Primary_Category_Public.php';

use Mockery;
use WP_Mock;

/**
 * Tests for the Router class.
 */
class TestPrimary_Category_Public extends TestCase {

	/**
	 * Test render function without attributes.
	 *
	 * @covers \Suleman\PrimaryCategory\Primary_Category_Public::render()
	 */
	public function test_render_empty() {
		$wp_query = Mockery::mock( \WP_Query::class );

		$wp_query
			->shouldReceive( 'query' )
			->once()
			->with( Mockery::type( 'array' ) );

		$wp_query
			->shouldReceive( 'have_posts' )
			->once()
			->withNoArgs()
			->andReturn( false );

		$public_class = new Primary_Category_Public( Mockery::mock( Primary_Category::class ), $wp_query );
		$result       = $public_class->render(
			array(
				'postType'         => 'post',
				'selectedCategory' => 0,
			),
			''
		);
		$expected     = 'No post found';

		$this->assertEquals( $expected, $result );
	}

	/**
	 * Test render function with attributes.
	 *
	 * @covers \Suleman\PrimaryCategory\Primary_Category_Public::render()
	 */
	public function test_render_with_data() {

		$wp_query = Mockery::mock( \WP_Query::class );

		$wp_query
			->shouldReceive( 'query' )
			->once()
			->with( Mockery::type( 'array' ) );

		$wp_query
			->shouldReceive( 'have_posts' )
			->times( 5 )
			->withNoArgs()
			->andReturn( true, true, true, true, false );

		$wp_query
			->shouldReceive( 'the_post' )
			->times( 3 )
			->withNoArgs();

		WP_Mock::userFunction( 'get_the_permalink' )
			->times( 3 )
			->withNoArgs()
			->andReturn( 'https://example.com/someCatLink' );

		WP_Mock::userFunction( 'get_the_title' )
			->times()
			->withNoArgs()
			->andReturn( 'Some Cat title' );

		$expected  = sprintf( '<li><a href="%1$s" title="%2$s">%2$s</a></li>', 'https://example.com/someCatLink', 'Some Cat title' );
		$expected .= sprintf( '<li><a href="%1$s" title="%2$s">%2$s</a></li>', 'https://example.com/someCatLink', 'Some Cat title' );
		$expected .= sprintf( '<li><a href="%1$s" title="%2$s">%2$s</a></li>', 'https://example.com/someCatLink', 'Some Cat title' );
		$expected  = '<ul>' . $expected . '</ul>';

		$public_class = new Primary_Category_Public( Mockery::mock( Primary_Category::class ), $wp_query );
		$result       = $public_class->render(
			array(
				'postType'         => 'post',
				'selectedCategory' => 1,
			),
			''
		);

		$this->assertEquals( $expected, $result );
	}
}
