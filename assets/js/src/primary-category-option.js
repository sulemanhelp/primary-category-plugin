import { Component } from '@wordpress/element';
import PrimaryCategorySelector from "./category-selector";

class PrimaryCategory extends Component {
	/**
	 * Renders the component.
	 *
	 * @returns {ReactElement}
	 */
	render() {
		const { ParentComponent } = this.props;
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
