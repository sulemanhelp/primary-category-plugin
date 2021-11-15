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
		//$this->register_hooks();
	}
}
