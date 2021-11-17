import { Component } from '@wordpress/element';
import PrimaryCategorySelector from "./category-selector";

class PrimaryCategory extends Component {
	/**
	 * Renders the component.
	 *
	 * @return {Object} Render taxonomies component.
	 */
	render() {
		const { ParentComponent } = this.props;
		// eslint-disable-next-line no-undef
		const { categoryRestBase, selectedPrimaryCategory} = categoryData;

		return (
			<>
				<ParentComponent { ...this.props } />
				<PrimaryCategorySelector CategoryRestBase={ categoryRestBase } SelectedPrimaryCategory={ selectedPrimaryCategory }  />
			</>
		);
	}
}

export default PrimaryCategory;
