<?php
/**
 * The template for displaying all single books.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package library-book-search-tool
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
    $post_id = get_the_ID();
    $book_authors = wp_get_object_terms($post_id, 'author');
    $book_publishers = wp_get_object_terms($post_id, 'publisher');
    $price = get_post_meta($post_id, 'book_price', true);
    $rating = get_post_meta($post_id, 'book_rating', true); ?>
    <div class="book-details">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header alignwide">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <hr />
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php
                the_content();
                ?>
                <?php if (!empty($book_authors)): ?>
                    <div class="authors">
                        <h3><?php esc_html_e('Authors'); ?></h3>
                        <hr />
                        <ul><?php
                        foreach ($book_authors as $book_author) { ?>
                            <li><a href="<?php echo esc_url( get_term_link( $book_author->slug, 'author' ) ) ?>" ><?php echo esc_html( $book_author->name ) ?></a></li>
                        <?php } ?>
                        </ul>          
                    </div>
                <?php endif; ?>
                <?php if (!empty($book_publishers)): ?>
                    <div class="publishers">
                        <h3><?php esc_html_e('Publishers'); ?></h3>
                        <hr />
                        <ul><?php
                        foreach ($book_publishers as $book_publisher) { ?>
                            <li><a href="<?php echo esc_url( get_term_link( $book_publisher->slug, 'publisher' ) ) ?>" ><?php echo esc_html( $book_publisher->name ) ?></a></li>
                        <?php } ?>
                        </ul>          
                    </div>
                <?php endif; ?>
                <?php if (!empty($rating)): ?>
                    <div class="rating">
                        <h3><?php esc_html_e('Rating'); ?></h3>
                        <hr /><?php
                        for ($i=0; $i < 5; $i++) {
                            if ($i < (int)$rating): ?>
                                <span class="dashicons dashicons-star-filled"></span><?php
                            else: ?>
                                <span class="dashicons dashicons-star-empty"></span><?php
                            endif;
                        } ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($price)): ?>
                    <div class="price">
                        <h3><?php esc_html_e('Book Price'); ?></h3>
                        <hr />
                        <?php echo esc_html('$'.$price); ?>
                    </div>
                <?php endif; ?>
            </div><!-- .entry-content -->
        </article>
    </div><?php
    endwhile; // End of the loop.
get_footer();
