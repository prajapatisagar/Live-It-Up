<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * 
 */

get_header(); ?>

		<div class="container">
			<div id="content" role="main">

                <?php
                    /* Queue the first post, that way we know
                     * what date we're dealing with (if that is the case).
                     *
                     * We reset this later so we can run the loop
                     * properly with a call to rewind_posts().
                     */
                    if ( have_posts() )
                        the_post();

                    the_archive_title( '<h1 class="page-title">', '</h1>' );

                    /* Run the loop for the archives page to output the posts.
                     * If you want to overload this in a child theme then include a file
                     * called loop-archives.php and that will be used instead.
                     */
                     get_template_part( 'loop', 'archive' );
                ?>

			</div><!-- #content -->
		</div><!-- .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
