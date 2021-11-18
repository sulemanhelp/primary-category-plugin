<?php
/**
 * Tests Case class.
 *
 * @package PrimaryCategory
 */

namespace Suleman\PrimaryCategory;

use Mockery;
use WP_Mock;

/**
 * Tests class extends.
 */
class TestCase extends WP_Mock\Tools\TestCase {

	use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

}
