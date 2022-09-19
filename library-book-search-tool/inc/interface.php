<?php
/**
 * Book Post type methods and variables in the back-end.
 *
 * @package library-book-search-tool
 */

namespace Library\BookSearch;

/**
 * Management of the 'book' post type and its taxonomies.
 *
 */
interface Book_Interface {
    /**
	 * Register the book post type.
	 *
	 * @return void
	 */
	public function register_custom_post_type() : void;

    /**
	 * Register the book post type taxonomies.
	 *
	 * @return void
	 */
	public function register_custom_post_type_taxonomies() : void;

    /**
	 * Enqueue js and css for the plugin.
	 *
	 * @return void
	 */
	public function enqueue_styles_and_scripts() : void;

    /**
	 * Initalize function.
	 *
	 * @return void
	 */
	public function init() : void;

    /**
	 * Register meta for custom post type.
	 *
	 * @return void
	 */
	public function register_custom_post_type_meta() : void;

    /**
	 * Enqueue gutenberg assets.
	 *
	 * @return void
	 */
	public function enqueue_gutenberg_assets() : void;

    /**
	 * Set Custom Columns for Post Grid.
	 * @param array $columns, Post Grid columns.
	 * @return array
	 */
	public function set_custom_columns( $columns ) : array;

    /**
	 * Adds content for custom columns in Post Grid.
	 * @param array $column, Column Array.
     * @param int $post_id, post id.
	 * @return void
	 */
	public function add_custom_columns_content( $column, $post_id ) : void;
}