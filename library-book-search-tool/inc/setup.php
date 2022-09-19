<?php
/**
 * Initial Setup File for the plugin.
 *
 * @package library-book-search-tool.
 */

namespace Library\BookSearch;

use Library\BookSearch\Book;

/**
 * Plugin loader.
 *
 * @return void
 */
function setup() {
	new Book();
}
