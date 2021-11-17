import { Component } from '@wordpress/element';
import { compose } from '@wordpress/compose';
import { SelectControl } from '@wordpress/components';
import { __ } from "@wordpress/i18n";
import { withSelect } from '@wordpress/data';

class AllCategories extends Component {

	/**
	 * Renders the component.
	 *
	 * @returns {ReactElement}
	 */
	render() {
		const { setAttributes, categories } = this.props;
		const { selectedCategory } = this.props.attributes;
		const categoriesList = [];
		console.log(selectedCategory);
		if ( categories ) {
			categories.map( ( category ) => {
				categoriesList.push( {
					'label': category.name,
					'value': category.id
				} );
			} );
		}
		return (
			<SelectControl
				label={ __('Select Category', 'primary-category') }
				help={ __('Select the primary category for posts you want to list.', 'primary-category') }
				options={ categoriesList }
				value={ selectedCategory }
				onChange={ (newval) => setAttributes({ selectedCategory: parseInt( newval, 10 ) }) }
			/>
		)
	}
}

export default compose( [
	withSelect( ( select ) => {
		const { getEntityRecords } = select( 'core' );
		return {
			categories: getEntityRecords('taxonomy', 'category') // if categories are more then hundred then need to index them.
		}
	} )
] )( AllCategories );
