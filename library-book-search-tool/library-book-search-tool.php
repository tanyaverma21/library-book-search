<?php
/**
 * Plugin Name:     Library Book Search Tool
 * Plugin URI:      https://github.com/tanyaverma21/wordpress
 * Description:     Plugin to manage and search library books available in the system with various filters given.
 * Author:          Tanya Verma
 * Author URI:      https://profiles.wordpress.org/tanyaverma
 * Text Domain:     library-book-search-tool
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         library-book-search-tool
 */

namespace Library\BookSearch;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LIBRARY_BOOKSEARCH_DIR' ) ) {
	define( 'LIBRARY_BOOKSEARCH_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
}

require_once LIBRARY_BOOKSEARCH_DIR . '/vendor/autoload.php';
add_action( 'plugins_loaded', __NAMESPACE__ . '\\setup' );

// require gutenberg blocks loader file.
require_once LIBRARY_BOOKSEARCH_DIR . '/inc/gutenberg/blocks/book-search-block.php';
