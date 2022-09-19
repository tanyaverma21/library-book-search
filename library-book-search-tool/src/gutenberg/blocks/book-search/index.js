/**
 * Internal dependencies.
 */
 import DisplayComponent from './DisplayComponent';

/**
* WordPress dependencies.
*/
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('library-book-search-tool/book-search-block', {
  title: __('Book Search', 'library-book-search-tool'),
  icon: 'search',
  attributes: {
    heading: {
      type: 'string',
      default: 'Book Search',
    },
  },
  className: 'search-block',
  edit: DisplayComponent,
  save: () => null,
});
