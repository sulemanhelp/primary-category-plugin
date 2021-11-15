import { Component, Fragment } from '@wordpress/element';
//import SPCPicker from './SpcPicker';

/**
 * SPC Init Component
 */
class PrimaryCategory extends Component {
	/**
	 * Renders the component.
	 *
	 * @returns {ReactElement}
	 */
	render() {
		const { slug, TaxonomyComponent } = this.props;
		/*const taxonomies = spcData.taxonomies;*/

		//if ( ! taxonomies.hasOwnProperty( slug ) ) {
			return (
				<Fragment>
					<TaxonomyComponent {...this.props} />
					<h2>Testing</h2>
				</Fragment>
			);
		//}

		/*return (
			<Fragment>
				<TaxonomyComponent {...this.props} />
				<SPCPicker primaryTaxonomy={ taxonomies[slug] } />
			</Fragment>
		);*/
	}
}

export default PrimaryCategory;
