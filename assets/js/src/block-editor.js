
import PrimaryCategory from './primary-category-option';

/**
 * Add component to Gutenberg post taxonomies component.
 */
function addPrimaryCategoryComponent( PostTaxonomiesComponent ) {
	return ( props ) => {

		if ( props.slug && 'category' === props.slug ) {
			return (
				<PrimaryCategory ParentComponent={ PostTaxonomiesComponent } { ...props } />
			);
		}

		return (
			<PostTaxonomiesComponent { ...props } />
		);

	}
}


if ( undefined !== wp && undefined !== wp.blocks ) {
	wp.hooks.addFilter( 'editor.PostTaxonomyType', 'primary-category-plugin', addPrimaryCategoryComponent );
}
