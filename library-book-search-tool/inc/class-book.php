<?php
/**
 * Book Post type features in the back-end.
 *
 * @package library-book-search-tool
 */

namespace Library\BookSearch;

use Library\BookSearch\Book_Interface;

/**
 * Management of the 'book' post type and its taxonomies.
 *
 */
class Book implements Book_Interface {
    /**
     * Post slug for the 'book' custom post type.
     * @var POST_TYPE_SLUG.
     */
    const POST_TYPE_SLUG               = 'book';

    /**
     * Taxonomy slug for the 'author' taxonomy.
     * @var AUTHOR_TAXONOMY.
     */
	const AUTHOR_TAXONOMY     = 'author';

	/**
     * Taxonomy slug for the 'publisher' taxonomy.
     * @var PUBLISHER_TAXONOMY.
     */
	const PUBLISHER_TAXONOMY     = 'publisher';

	/**
	 * Add actions.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles_and_scripts' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_gutenberg_assets' ], 1 );
		add_action( 'init', [ $this, 'init' ] );
        add_filter( 'manage_' . self::POST_TYPE_SLUG . '_posts_columns', [ $this, 'set_custom_columns' ] );
        add_action( 'manage_' . self::POST_TYPE_SLUG . '_posts_custom_column', [ $this, 'add_custom_columns_content' ], 10, 2 );
		add_filter( 'template_include', [ $this, 'load_template' ], 35 );
	}

	/**
	 * Initalize function.
	 *
	 * @return void
	 */
	public function init() : void {
		$this->register_custom_post_type();
		$this->register_custom_post_type_taxonomies();
        $this->register_custom_post_type_meta();
	}

	/**
	 * Register the book post type.
	 *
	 * @return void
	 */
	public function register_custom_post_type() : void {
		register_post_type(
			self::POST_TYPE_SLUG,
			[
				'labels'             => [
					'name'          => __( 'Books', 'library-book-search-tool' ),
					'singular_name' => __( 'Book', 'library-book-search-tool' ),
					'search_items'  => __( 'Search Book', 'library-book-search-tool' ),
                    'all_items'         => __( 'All Books', 'library-book-search-tool' ),
                    'parent_item'       => __( 'Parent Book', 'library-book-search-tool' ),
                    'edit_item'         => __( 'Edit Book', 'library-book-search-tool' ),
                    'update_item'       => __( 'Update Book', 'library-book-search-tool' ),
                    'add_new_item'      => __( 'Add New Book', 'library-book-search-tool' ),
                    'new_item_name'     => __( 'New Book Name', 'library-book-search-tool' ),
                    'menu_name'         => __( 'Books', 'library-book-search-tool' ),
				],
				'public'             => true,
				'has_archive'        => true,
				'menu_icon'          => 'dashicons-welcome-write-blog',
				'supports'           => [ 'title', 'editor', 'custom-fields' ],
				'taxonomies'         => [ self::AUTHOR_TAXONOMY, self::PUBLISHER_TAXONOMY ],
				'show_in_rest'       => true,
				'publicly_queryable' => true,
				'rewrite'            => true,
			]
		);
	}

	/**
	 * Register the custom post type taxonomies.
	 *
	 * @return void
	 */
	public function register_custom_post_type_taxonomies() : void {
		register_taxonomy(
			self::AUTHOR_TAXONOMY,
			[ self::POST_TYPE_SLUG ],
			[
				'labels'            => [
					'name'          => __( 'Authors', 'library-book-search-tool' ),
					'singular_name' => __( 'Author', 'library-book-search-tool' ),
					'search_items'  => __( 'Search Author', 'library-book-search-tool' ),
                    'all_items'         => __( 'All Authors', 'library-book-search-tool' ),
                    'parent_item'       => __( 'Parent Author', 'library-book-search-tool' ),
                    'edit_item'         => __( 'Edit Author', 'library-book-search-tool' ),
                    'update_item'       => __( 'Update Author', 'library-book-search-tool' ),
                    'add_new_item'      => __( 'Add New Author', 'library-book-search-tool' ),
                    'new_item_name'     => __( 'New Author', 'library-book-search-tool' ),
                    'menu_name'         => __( 'Authors', 'library-book-search-tool' ),
				],
				'hierarchical'      => false,
				'query_var'         => true,
				'rewrite'           => true,
				'show_ui'           => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
				'show_admin_column' => true,
				'public'            => true,
				'show_in_menu'      => true,
				'show_in_rest'      => true,
			]
		);

        register_taxonomy(
			self::PUBLISHER_TAXONOMY,
			[ self::POST_TYPE_SLUG ],
			[
				'labels'            => [
					'name'          => __( 'Publishers', 'library-book-search-tool' ),
					'singular_name' => __( 'Publisher', 'library-book-search-tool' ),
					'search_items'  => __( 'Search Publisher', 'library-book-search-tool' ),
                    'all_items'         => __( 'All Publishers', 'library-book-search-tool' ),
                    'parent_item'       => __( 'Parent Publisher', 'library-book-search-tool' ),
                    'edit_item'         => __( 'Edit Publisher', 'library-book-search-tool' ),
                    'update_item'       => __( 'Update Publisher', 'library-book-search-tool' ),
                    'add_new_item'      => __( 'Add New Publisher', 'library-book-search-tool' ),
                    'new_item_name'     => __( 'New Publisher', 'library-book-search-tool' ),
                    'menu_name'         => __( 'Publishers', 'library-book-search-tool' ),
				],
				'hierarchical'      => false,
				'query_var'         => true,
				'rewrite'           => true,
				'show_ui'           => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
				'show_admin_column' => true,
				'public'            => true,
				'show_in_menu'      => true,
				'show_in_rest'      => true,
			]
		);
	}

    /**
	 * Enqueue scripts and styles for frontend book functionality.
	 *
	 * @return void
	 */
	public function enqueue_styles_and_scripts() : void {
        $plugin_name = basename( LIBRARY_BOOKSEARCH_DIR );
		$plugin_dir  = WP_CONTENT_DIR . '/plugins/' . $plugin_name;

		wp_register_script(
			'book-script',
			plugins_url( "{$plugin_name}/dist/scripts/" . LIBRARY_BOOKSEARCH_JS, $plugin_dir ),
			[ 'wp-i18n', 'wp-element', 'wp-components', 'wp-api-fetch', 'jquery' ],
			filemtime( LIBRARY_BOOKSEARCH_DIR . '/dist/scripts/' . LIBRARY_BOOKSEARCH_JS ),
			true
		);

		wp_localize_script(
			'book-script',
			'ajaxload_params',
			[
				'ajaxurl'          => site_url() . '/wp-admin/admin-ajax.php',
				'nonce'            => wp_create_nonce( 'ajax-load' ),
			]
		);

		wp_enqueue_script( 'book-script' );

		wp_enqueue_style(
			'book-styles',
			plugins_url( "{$plugin_name}/dist/styles/" . LIBRARY_BOOKSEARCH_CSS, $plugin_dir ),
			[],
			filemtime( LIBRARY_BOOKSEARCH_DIR . '/dist/styles/' . LIBRARY_BOOKSEARCH_CSS )
		);
    }

    /**
	 * Register meta for custom post type.
	 *
	 * @return void
	 */
	public function register_custom_post_type_meta() : void {
        register_post_meta(
			'book',
			'book_price',
			[
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => true,
				'default'      => '{}',
			]
		);

        register_post_meta(
			'book',
			'book_rating',
			[
				'type'         => 'number',
				'single'       => true,
				'show_in_rest' => true,
				'default'      => 0,
			]
		);
    }

    /**
	 * Enqueue gutenberg assets.
	 *
	 * @return void
	 */
	public function enqueue_gutenberg_assets() : void {
        $plugin_name = basename( LIBRARY_BOOKSEARCH_DIR );
		$plugin_dir  = WP_CONTENT_DIR . '/plugins/' . $plugin_name;

        wp_enqueue_script(
			'gutenberg_assets',
			plugins_url( "{$plugin_name}/dist/scripts/" . GUTENBERG_JS, $plugin_dir ),
			[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-data', 'wp-components', 'wp-edit-post', 'wp-editor' ],
			filemtime( LIBRARY_BOOKSEARCH_DIR . '/dist/scripts/' . GUTENBERG_JS ),
			false
		);

		wp_enqueue_style(
			'admin-styles',
			plugins_url( "{$plugin_name}/dist/styles/" . GUTENBERG_CSS, $plugin_dir ),
			[],
			filemtime( LIBRARY_BOOKSEARCH_DIR . '/dist/styles/' . GUTENBERG_CSS ),
			'all'
		);
    }

    /**
	 * Set Custom Columns for Post Grid.
	 *
	 * @return void
	 */
	public function set_custom_columns( $columns ) : array {
        $columns['price']         = __( 'Price', 'library-book-search-tool' );
		$columns['rating'] = __( 'Rating', 'library-book-search-tool' );
		return $columns;
    }

    /**
	 * Adds content for custom columns in Post Grid.
	 * @param array $column, Column Array.
     * @param int $post_id, post id.
	 * @return void
	 */
	public function add_custom_columns_content ( $column, $post_id ) : void {
		$post = get_post( $post_id );
        $rating = get_post_meta($post_id, 'book_rating', true);
        $price = get_post_meta($post_id, 'book_price', true);
		
		switch ( $column ) {
			case 'price':
				echo !empty($price) ? '$'.$price : '';
				break;
            case 'rating':
                if (!empty($rating)) {
                    for ($i=0; $i < 5; $i++) {
                        if ($i < (int)$rating)
                            echo '<span class="dashicons dashicons-star-filled"></span>' . PHP_EOL;
                        else
                            echo '<span class="dashicons dashicons-star-empty"></span>' . PHP_EOL;
                    }
                }
                break;
		}
	}

	/**
	 * Adds content for custom columns in Post Grid.
	 * @param string $template, Template Path.
	 * @return string.
	 */
	public function load_template ( $template ) : string {
		if (is_singular(self::POST_TYPE_SLUG)) {
			$template = LIBRARY_BOOKSEARCH_DIR.'/templates/single-book.php';
		}

		return $template;
	}
}
