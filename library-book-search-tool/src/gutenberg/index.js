/**
 * Import all Gutenberg blocks and settings in this file.
 * Make sure the entry point in `webpack.config.js` for Gutenberg bundle is enabled.
 */

// Import the Gutenberg specific stylesheet.
import '../styles/gutenberg.scss';

// Import the Gutenberg block Book Search.
import './blocks/book-search';

// Import the Price Document Settings for Book CPT.
import './document-settings/Price';

// Import the Rating Document Settings for Book CPT.
import './document-settings/Rating';