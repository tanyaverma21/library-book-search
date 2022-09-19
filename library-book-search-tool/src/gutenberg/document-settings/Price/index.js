/**
 * Render file for the meta 'book_price'.
 */
import Price from './Price'; 
const { registerPlugin } = wp.plugins;
/**
 * Registers 'book-search-price' plugin in the Posts Settings Sidebar.
 */
wp.domReady(() => {
  registerPlugin('book-search-price', {
    render: Price,
    icon: '',
  });
});
