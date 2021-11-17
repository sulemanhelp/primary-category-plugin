import {InspectorControls, useBlockProps} from '@wordpress/block-editor';
import {PanelBody, PanelRow} from '@wordpress/components';
import {__} from "@wordpress/i18n";
import ServerSideRender from "@wordpress/server-side-render";
import PostTypesWithCategory from './priamry-category-block-list-posts';
import AllCategories from './primary-category-block-list-categories';


function Edit(props) {
	const blockProps = useBlockProps();
	// eslint-disable-next-line no-undef
	const postTypeOptions = categoryBlockData.postTypesWithCategory;
	const { attributes, name } = props;
	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody
					title={ __('Block Settings', 'primary-category') }
					initialOpen={ true }
				>
					<PanelRow>
						<PostTypesWithCategory postTypeOptions={ postTypeOptions } { ...props } />
					</PanelRow>
					<PanelRow>
						<AllCategories { ...props } />
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<ServerSideRender
				block={ name }
				attributes={ attributes }
			/>
		</div>
	);
}

export default Edit;
