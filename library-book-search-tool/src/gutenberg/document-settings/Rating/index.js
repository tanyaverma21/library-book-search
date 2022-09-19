/**
 * Render file for the meta 'book_rating'.
 */
 import Rating from './Rating'; 
 const { registerPlugin } = wp.plugins;
 /**
  * Registers 'book-search-rating' plugin in the Posts Settings Sidebar.
  */
 wp.domReady(() => {
   registerPlugin('book-search-rating', {
     render: Rating,
     icon: '',
   });
 });
 