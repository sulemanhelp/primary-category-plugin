<?php
/**
 * Plugin Name: Primary Category
 * Description: Add primary Category to post, page, or CPT.
 * Version: 1.0.0
 * Author: Suleman
 * Author URI: https://suleman-help.me
 * Text Domain: primary-category
 *
 * @package PrimaryCategory
 */

namespace Suleman\PrimaryCategory;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

// site-level auto-loading.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

$suleman_primary_category = new Primary_Category( __FILE__ );
