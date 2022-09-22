<?php
/**
 * Save method for Book Search Block.
 *
 * @package library-book-search-tool
 */

if ( ! function_exists( 'register_book_search_block' ) ) {
	/**
	 * Register the block via php so it can be rendered with php.
	 */
	function register_book_search_block() { 
        register_block_type(
			'library-book-search-tool/book-search-block',
			[
				'render_callback' => 'render_book_search_block',
				'editor_script'   => 'gutenberg_assets',
                'attributes'      => [
                    'heading' => [
                        'type' => 'string',
                        'default' => __('Book Search', 'library-book-search-tool'),
                    ]
                ]
			]
		);
    }
}
add_action( 'init', 'register_book_search_block' );

if ( ! function_exists( 'render_book_search_block' ) ) {
	/**
	 * Register the block via php so it can be rendered with php.
     * @param Array $attributes, attributes array.
	 */
	function render_book_search_block( $attributes ) { 
        $html = '';
        $title = !empty($attributes['heading']) ? $attributes['heading'] : __('Book Search', 'library-book-search-tool');
        $authors = get_terms( 'author', [ 'hide_empty' => false ] );
        $publishers = get_terms( 'publisher', [ 'hide_empty' => false ] );
        $books = get_posts(
            [
                'post_type' => 'book',
                'post_status' => 'publish',
                'numberposts' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            ]
        );

        ob_start(); ?>
        <div class="search-wrapper">
            <div class="search-header">
                <h4><?php echo esc_html( $title ); ?></h4>
                <form method="post" class="search-form">
                    <table class="search-table">
                        <tr>
                            <td class="search-table-td">
                                <span><?php esc_html_e('Book Name', 'library-book-search-tool') ?></span>
                                <input type="text" name="book-name" placeholder="<?php esc_html_e('Book Name', 'library-book-search-tool') ?>" class="search-input-field" id="book-name" />
                            </td>
                            <td class="search-table-td">
                                <span><?php esc_html_e('Author', 'library-book-search-tool') ?></span>
                                <select name="book-author" placeholder="<?php esc_html_e('Author', 'library-book-search-tool') ?>" class="search-input-select" id="book-author">
                                    <option value=""><?php esc_html_e('All', 'library-book-search-tool') ?></option>
                                    <?php if (!empty($authors)): ?>
                                        <?php foreach ($authors as $author): ?>
                                            <option value="<?php echo esc_attr($author->term_id); ?>"><?php echo esc_html($author->name); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="search-table-td">
                                <span><?php esc_html_e('Publisher', 'library-book-search-tool') ?></span>
                                <select name="book-publisher" id="book-publisher" placeholder="<?php esc_html_e('Publisher', 'library-book-search-tool') ?>" class="search-input-select">
                                    <option value=""><?php esc_html_e('All', 'library-book-search-tool') ?></option>
                                    <?php if (!empty($publishers)): ?>
                                        <?php foreach ($publishers as $publisher): ?>
                                            <option value="<?php echo esc_attr($publisher->term_id); ?>"><?php echo esc_html($publisher->name); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </select>
                            </td>
                            <td class="search-table-td">
                                <span><?php esc_html_e('Rating', 'library-book-search-tool') ?></span>
                                <select name="book-rating" id="book-rating" placeholder="<?php esc_html_e('Rating', 'library-book-search-tool') ?>" class="search-input-select">
                                    <option value=""><?php esc_html_e('All', 'library-book-search-tool') ?></option>
                                    <?php for ($i=1; $i<=5; $i++): ?>
                                        <option value="<?php echo esc_attr($i) ?>"><?php echo esc_html($i) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="search-table-td td-range">
                                <span><?php esc_html_e('Price', 'library-book-search-tool') ?></span>
                                <input type="range" name="book-price" min="0" max="10000" value="10000" class="slider" id="price-range" class="search-input-field slider">
                                <span id="range-value"></span>
                            </td>
                        </tr>
                    </table>
                    <button type="submit" value="search-btn" class="search-btn"><?php esc_html_e('Search', 'library-book-search-tool') ?></button>
                </form>
            </div>
            <div class="search-results">
                <table>
                    <thead>
                        <tr>
                            <th><?php esc_html_e('No.', 'library-book-search-tool') ?></th>
                            <th><?php esc_html_e('Book Name', 'library-book-search-tool') ?></th>
                            <th><?php esc_html_e('Price', 'library-book-search-tool') ?></th>
                            <th><?php esc_html_e('Author', 'library-book-search-tool') ?></th>
                            <th><?php esc_html_e('Publisher', 'library-book-search-tool') ?></th>
                            <th><?php esc_html_e('Rating', 'library-book-search-tool') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($books)):
                            $count = 1;
                            foreach ($books as $book):
                                $post_id = $book->ID;
                                $book_authors = wp_get_object_terms($post_id, 'author');
                                $book_publishers = wp_get_object_terms($post_id, 'publisher');
                                $price = get_post_meta($post_id, 'book_price', true);
                                $rating = get_post_meta($post_id, 'book_rating', true);  ?>
                                <tr class="<?php echo $count <=10 ? esc_attr('show') : esc_attr('hide') ?>">
                                    <td><?php echo esc_html($count); ?></td>
                                    <td><a href="<?php echo esc_url(get_the_permalink($book->ID)); ?>"><?php echo esc_html($book->post_title); ?></a></td>
                                    <?php if (!empty($price)): ?>
                                        <td><?php echo esc_html('$'.$price); ?></td>
                                    <?php endif; ?>
                                    <?php if (!empty($book_authors)): ?>
                                        <td><?php
                                        foreach ($book_authors as $book_author) { ?>
                                            <a href="<?php echo esc_url( get_term_link( $book_author->slug, 'author' ) ) ?>" ><?php echo esc_html( $book_author->name ) ?></a>
                                        <?php } ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if (!empty($book_publishers)): ?>
                                        <td><?php
                                        foreach ($book_publishers as $book_publisher) { ?>
                                            <a href="<?php echo esc_url( get_term_link( $book_publisher->slug, 'publisher' ) ) ?>" ><?php echo esc_html( $book_publisher->name ) ?></a>
                                        <?php } ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if (!empty($rating)): ?>
                                        <td class="rating"><?php
                                            for ($i=0; $i < 5; $i++) {
                                                if ($i < (int)$rating): ?>
                                                    <span class="dashicons dashicons-star-filled"></span><?php
                                                else: ?>
                                                    <span class="dashicons dashicons-star-empty"></span><?php
                                                endif;
                                            } ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php $count++; endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if (count($books) > 10): ?>
                    <center><button type="button" id="load-more"><?php esc_html_e('Load More Books', 'library-book-search-tool') ?></button></center>
                <?php endif; ?>
            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }
}

if ( ! function_exists( 'search_books_ajax_handler' ) ) {
	/**
	 * Get filtred search results on page
	 *
	 * @return array
	 */
	function search_books_ajax_handler() {
        // Check nonce.
		if ( ! isset( $_POST['_ajaxnonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['_ajaxnonce'] ), 'ajax-load-event' ) ) {
			return false;
		}

        $postData = filter_input_array(INPUT_POST);
        if (empty($postData)) {
            return false;
        }

        $html = '';
        $book_name = filter_input(INPUT_POST, 'bookname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $book_author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_NUMBER_INT);
        $book_publisher = filter_input(INPUT_POST, 'publisher', FILTER_SANITIZE_NUMBER_INT);
        $book_rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
        $book_price = (int)filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);

        $args = process_args( $book_name, $book_author, $book_publisher, $book_rating, $book_price );
        add_filter( 'posts_where', 'title_filter', 10, 2 );
        $book_query = new WP_Query($args);
        remove_filter( 'posts_where', 'title_filter', 10, 2 );

        $count = 1;
        if (!empty($book_query->posts)) {
            foreach ($book_query->posts as $post) {
                $post_id = $post->ID;
                $authors = wp_get_object_terms($post_id, 'author');
                $publishers = wp_get_object_terms($post_id, 'publisher');
                $price = get_post_meta($post_id, 'book_price', true);
                $rating = get_post_meta($post_id, 'book_rating', true);
                $class = $count <=10 ? 'show' : 'hide';
                $html .= '<tr class="'. esc_attr($class) .'">';
                $html .= '<td>'.esc_html( $count ).'</td>';
                $html .= '<td><a href="'.esc_url( get_the_permalink($post_id) ).'">'.esc_html( get_the_title($post_id) ).'</a></td>';
                if (!empty($price)) {
                    $html .= '<td>$'.esc_html( $price ).'</td>';
                }
                
                if (!empty($authors)) {
                    $html .= '<td>';
                    foreach ($authors as $author) {
                        $html .= '<a href="'. esc_url( get_term_link( $author->slug, 'author' ) ) .'" >'.esc_html( $author->name ).'</a> ';
                    }
                    $html .= '</td>';
                }

                if (!empty($publishers)) {
                    $html .= '<td>';
                    foreach ($publishers as $publisher) {
                        $html .= '<a href="'. esc_url( get_term_link( $publisher->slug, 'publisher' ) ) .'" >'.esc_html( $publisher->name ).'</a> ';
                    }
                    $html .= '</td>';
                }

                if (!empty($rating)) {
                    $html .= '<td class="rating">';
                    for ($i=0; $i < 5; $i++) {
                        if ($i < (int)$rating)
                            $html .= '<span class="dashicons dashicons-star-filled"></span>' . PHP_EOL;
                        else
                            $html .= '<span class="dashicons dashicons-star-empty"></span>' . PHP_EOL;
                    }
                    $html .= '</td>';
                }

                $html .= '</tr>';

                $count++;
            }
        } else {
            $html .= 'No records found';
        }

        wp_send_json_success( $html );
    }
}
add_action( 'wp_ajax_search_books', 'search_books_ajax_handler' );
add_action( 'wp_ajax_nopriv_search_books', 'search_books_ajax_handler' );

if ( ! function_exists( 'title_filter' ) ) {
	/**
	 * Get filtred search results by title on page
	 * @param string $where, where condition.
     * @param WP_Query $wp_query, WP_Query object.
	 * @return string.
	 */
    function title_filter( $where, &$wp_query ) {
        global $wpdb;
        if ( $search_term = $wp_query->get( 'search_by_title' ) ) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
        }
        return $where;
    }
}

if ( ! function_exists( 'process_args' ) ) {
	/**
	 * Process args passed to search query.
	 * @param string $book_name, Book Name.
     * @param int $book_author, Book Author.
     * @param int $book_publisher, Book Publisher.
     * @param int $book_rating, Book Rating.
     * @param int $book_price, Book Price.
	 * @return array.
	 */
    function process_args( $book_name, $book_author, $book_publisher, $book_rating, $book_price ) {
        $args = [
            'post_type' => 'book',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ];

        if (!empty($book_name)) {
            $args['search_by_title'] = $book_name;
        }

        // tax query for author and publisher taxonomy.
        if (!empty($book_author) && !empty($book_publisher)) {
            $args['tax_query'] = [
                'relation' => 'AND',
                [
                    'taxonomy' => 'author',
                    'terms' => [(int)$book_author],
                    'field' => 'term_id',
                    'operator' => 'IN',
                ],
                [
                    'taxonomy' => 'publisher',
                    'terms' => [(int)$book_publisher],
                    'field' => 'term_id',
                    'operator' => 'IN',
                ],
            ];
        } else if (empty($book_author) && !empty($book_publisher)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'publisher',
                    'terms' => [(int)$book_publisher],
                    'field' => 'term_id',
                    'operator' => 'IN',
                ],
            ];
        } else if (!empty($book_author) && empty($book_publisher)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'author',
                    'terms' => [(int)$book_author],
                    'field' => 'term_id',
                    'operator' => 'IN',
                ],
            ];
        }

        // meta query for price and rating meta fields.
        if ($book_price !== '' && !empty($book_rating)) {
            $args['meta_query'] = [
                'relation' => 'AND',
                [
                    'key' => 'book_price',
			        'value' => $book_price,
                    'type'    => 'numeric',
                    'compare' => '<=',
                ],
                [
                    'key' => 'book_rating',
			        'value' => (int)$book_rating,
                    'type'    => 'numeric',
                    'compare' => '==',
                ],
            ];
        } else if ($book_price === '' && !empty($book_rating)) {
            $args['meta_query'] = [
                [
                    'key' => 'book_rating',
			        'value' => (int)$book_rating,
                    'type'    => 'numeric',
                    'compare' => '==',
                ],
            ];
        } else if ($book_price !== '' && empty($book_rating)) {
            $args['meta_query'] = [
                [
                    'key' => 'book_price',
			        'value' => $book_price,
                    'type'    => 'numeric',
                    'compare' => '<=',
                ],
            ];
        }

        return $args;
    }
}
