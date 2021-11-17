import { Component } from '@wordpress/element';
import { SelectControl } from '@wordpress/components';
import { withSelect, withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';
import { __ } from "@wordpress/i18n";
import styled from 'styled-components'

const Title = styled.strong`
  font-size: 1.2em;
  display: block;
  margin: 10px 0;
`;

class PrimaryCategorySelector extends Component {
	constructor() {
		super();

		this.state = {
			primaryCat: 0
		}
	}



	/**
	 * Get categories when component mounts.
	 *
	 */
	componentDidMount() {
		// Set the primary category id.
		this.setState( {
			primaryCat: this.props.SelectedPrimaryCategory,
		} );
	}


	/**
	 * onChange event handler for select tag.
	 *
	 * @param {Object} event Event object.
	 *
	 */
	onSelectChange( event ) {
		const postMeta = {};
		postMeta.post_primary_category = parseInt( event, 10 );

		// Update post meta for saving selected value.
		this.props.updateMeta( postMeta );

		// Update the state for primary category id.
		this.setState( { primaryCat: event } );
	}

	/**
	 * Renders the component.
	 *
	 * @return {Object} Render select category component
	 */
	render() {
		const { selectedCatIds, categories } = this.props;
		const catSelections = [];
		catSelections.push( { label: __( 'Select Primary Category', 'primary-category' ), value: -1 } );

		if ( categories ) {
			categories.forEach( ( cat ) => {
				if ( selectedCatIds.includes( cat.id ) ) {
					return catSelections.push( {label: cat.name, value: cat.id} );
				}
			} );
		}

		return (
			<SelectControl
				label={ <Title>{ __( 'Primary Category', 'primary-category' ) }</Title> }
				help={ __( 'Select a category to make it primary category.', 'primary-category' ) }
				options={ catSelections }
				value={ this.state.primaryCat }
				onChange={ this.onSelectChange.bind(this) }
			/>
		);
	}
}

export default compose( [
	withSelect( ( select, { CategoryRestBase } ) => {
		const { getEditedPostAttribute } = select( 'core/editor' );
		const { getEntityRecords } = select( 'core' );

		return {
			selectedCatIds: getEditedPostAttribute( CategoryRestBase ),
			meta: getEditedPostAttribute( 'meta' ),
			categories: getEntityRecords('taxonomy', 'category') // if categories are more then hundred then need to index them.
		}
	}),
	withDispatch( dispatch => {
		const { editPost } = dispatch( 'core/editor' );

		return {
			updateMeta ( postMeta ) {
				editPost( { meta: postMeta } );
			}
		}
	})
] )( PrimaryCategorySelector );
