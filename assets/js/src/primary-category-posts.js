import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

function Edit(props) {
	const blockProps = useBlockProps();
	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody
					title={ __('Block Settings', 'primary-category') }
					initialOpen={ true }
				>
					<PanelRow>
						<h1>test</h1>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<ServerSideRender
				block="gutenberg-private-category-blocks/private-category"
				attributes={ props.attributes }
			/>
		</div>
	);
}

registerBlockType( 'gutenberg-private-category-blocks/private-category', {
	apiVersion: 2,
	title: __('Posts with private categories', 'primary-category'),
	icon: 'editor-ul',
	category: 'widgets',
	attributes: {
		category: {
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


export function add( to, howMuch ) {
	return to + howMuch;
}
