import { Component } from '@wordpress/element';
import { withSelect, withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';
import { __ } from "@wordpress/i18n";

class PrimaryCategorySelector extends Component {
	constructor() {
		super();

		this.state = {
			terms: null,
			primaryTermId: 0
		}
	}

	/**
	 * SPC selector onChange event handler.
	 *
	 * @param {object} event Event object.
	 */
	onSelectChange( event ) {
		const metaObj = {};
		metaObj.post_primary_category = parseInt( event.target.value, 10 );
		this.props.updateSPC( metaObj );
		this.setState( { primaryTermId: event.target.value } );
	}

	/**
	 * Renders the SPCPicker component.
	 *
	 * @returns {ReactElement}
	 */
	render() {
		const {
			primaryTaxonomy,
			selectedTermsIds
		} = this.props;

		return (
			<>
				<h4>
					{ __( 'Primary Category', 'simple-primary-category' ) }
				</h4>
				<select onChange={ this.onSelectChange.bind( this ) }>
					<option value="-1">
						{ __( 'Select Primary Category', 'simple-primary-category' ) }
					</option>
					{ this.state.terms && this.state.terms.map( term => {
						if ( selectedTermsIds.includes( term.id ) ) {
							if ( this.state.primaryTermId === term.id ) {
								return (
									<option value={term.id} selected>{term.name}</option>
								)
							}
							return (
								<option value={term.id}>{term.name}</option>
							)
						}
					}) }
				</select>
			</>
		);
	}
}

export default compose( [
	withSelect( ( select, { primaryTaxonomy } ) => {
		const { getEditedPostAttribute } = select( 'core/editor' );

		return {
			selectedTermsIds: getEditedPostAttribute( primaryTaxonomy.restBase ),
			meta: getEditedPostAttribute( 'meta' )
		}
	}),
	withDispatch( dispatch => {
		const { editPost } = dispatch( 'core/editor' );

		return {
			updateSPC( newMeta ) {
				editPost( { meta: newMeta } );
			}
		}
	})
] )( PrimaryCategorySelector );
