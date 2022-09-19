=== Library Book Search Tool ===
Tags: comments, spam
Requires at least: 4.5
Tested up to: 6.0.2
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Plugin for library book search management.
== Description ==

Plugin to manage library book search based on various available filters.

1. On plugin activation, a custom post type gets registered in the system, named as 'Book'.
2. Two custom taxonomies get registered, Authors and Publishers, for Book CPT.
3. A gutenberg block gets registered, 'Book Search' which will exhibit ajax search functionality for books.
4. Two meta fields get registered in gutenberg editor, Price and Rating, for Book CPT.
5. The Book CPT works on a custom overridden template, consisting of all the information related to its author, publisher, rating and price. 

== Installation ==

1. Upload `library-book-search-tool` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a WP Page in the WP Admin and edit it and add the gutenberg block 'Book Search' to the page.
4. Save/Publish the page.
5. View the page's frontend to check the ajax search functionality.

== Supported Packages ==
1. Composer-based.
2. Webpack-based.

== Changelog ==

= 1.0 =
* Newest version.
