<?php
/**
 * Template Name: 1 column (wide), no sidebar
 *
 * A custom page template without sidebar.
 *
 */

get_header(); ?>

    <div class="container">
        <div id="content" class="wide-column" role="main">

			<?php if ( have_posts() ) {
				while ( have_posts() ) : the_post(); ?>

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'live-it-up' ), 'after' => '</div>' ) ); ?>
							<?php edit_post_link( esc_html__( 'Edit', 'live-it-up' ), '<span class="edit-link">', '</span>' ); ?>
                        </div><!-- .entry-content -->
                        <div class="entry-footer"></div>
                    </div><!-- #post-## -->

					<?php comments_template( '', true ); ?>

				<?php endwhile;
			} ?>

        </div><!-- #content -->
    </div><!-- .container -->

<?php get_footer();
