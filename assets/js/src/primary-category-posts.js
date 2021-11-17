import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import Edit from './primary-category-edit-function';



registerBlockType( 'gutenberg-private-category-blocks/primary-category', {
	apiVersion: 2,
	title: __('Posts with private categories', 'primary-category'),
	icon: 'editor-ul',
	category: 'widgets',
	attributes: {
		selectedCategory: {
			type: 'integer',
			default: 0
		},
		postType: {
			type: 'string',
			default: 'post'
		},
	},

	edit: Edit,
} );
