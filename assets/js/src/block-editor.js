import wp from ''
import PrimaryCategory from './primary-category-option';

/**
 * Add component to Gutenberg post taxonomies component.
 */
function addPrimaryCategoryComponent( PostTaxonomiesComponent ) {
	console.log(PostTaxonomiesComponent);
	return ( props ) => {
		return (
			<PrimaryCategory TaxonomyComponent={ PostTaxonomiesComponent } { ...props } />
		);
	}
}

console.log(wp);
//if ( undefined !== wp && undefined !== wp.blocks ) {
	wp.hooks.addFilter( 'editor.PostTaxonomyType', 'primary-category-plugin', addPrimaryCategoryComponent );
//}
