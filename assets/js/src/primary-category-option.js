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
		const categories = categoryData.categories;

		if ( categories.length > 0 ) {
			return (
				<>
					<ParentComponent { ...this.props } />
					<PrimaryCategorySelector Categories={ categories } />
				</>
			);
		}

		return (
			<ParentComponent { ...this.props } />
		);
	}
}

export default PrimaryCategory;
