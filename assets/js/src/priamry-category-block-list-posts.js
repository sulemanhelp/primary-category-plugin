import { Component } from '@wordpress/element';
import { SelectControl } from '@wordpress/components';
import {__} from "@wordpress/i18n";

class PostTypesWithCategory extends Component {

	/**
	 * Renders the component.
	 *
	 * @returns {ReactElement}
	 */
	render() {
		const { postTypeOptions, setAttributes } = this.props;
		const { postType } = this.props.attributes;
		return (
			<SelectControl
				label={ __('Select Post Type', 'primary-category') }
				help={ __('Select the post type you want to list.', 'primary-category') }
				options={ postTypeOptions }
				value={ postType }
				onChange={ (newval) => setAttributes({ postType: newval }) }
			/>
		)
	}
}

export default PostTypesWithCategory;
