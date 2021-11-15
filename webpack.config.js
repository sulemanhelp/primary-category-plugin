const path = require( 'path' );

/**
 * WordPress dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		editor: './assets/js/src/block-editor.js',
	},
	output: {
		path: path.resolve( __dirname, 'dist/js' ),
		filename: '[name].js',
	},
};
