<?php
/**
 * The Template for displaying all single posts.
 *
 *
 */

get_header(); ?>

<div class="container">
    <div id="content" role="main">

		<?php if ( have_posts() ) {
			while ( have_posts() ) : the_post(); ?>

                <!--<div id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'live-it-up' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'live-it-up' ) . '</span>' ); ?></div>
				</div>--><!-- #nav-above -->

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <div class="entry-meta">
						<?php live_it_up_posted_on(); ?>
                    </div><!-- .entry-meta -->

                    <div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'live-it-up' ), 'after' => '</div>' ) ); ?>
                    </div><!-- .entry-content -->

					<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
                        <div id="entry-author-info">
                            <div id="author-avatar">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'live_it_up_author_bio_avatar_size', 60 ) ); ?>
                            </div><!-- #author-avatar -->
                            <div id="author-description">
                                <h2><?php printf( esc_attr__( 'About %s', 'live-it-up' ), get_the_author() ); ?></h2>
								<?php the_author_meta( 'description' ); ?>
                                <div id="author-link">
                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
										<?php printf( esc_html__( 'View all posts by %s', 'live-it-up' ), get_the_author() ); ?>
                                    </a>
                                </div><!-- #author-link	-->
                            </div><!-- #author-description -->
                        </div><!-- #entry-author-info -->
					<?php endif; ?>

                    <div class="entry-utility">
						<?php live_it_up_posted_in(); ?>
						<?php edit_post_link( esc_html__( 'Edit', 'live-it-up' ), '<span class="edit-link">', '</span>' ); ?>
                    </div><!-- .entry-utility -->
                    <div class="entry-footer"></div>
                </div><!-- #post-## -->

                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'live-it-up' ) . '</span> %title' ); ?></div>
                    <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'live-it-up' ) . '</span>' ); ?></div>
                </div><!-- #nav-below -->

				<?php comments_template( '', true ); ?>

			<?php endwhile;
		} // end of the loop. ?>

    </div><!-- #content -->
</div><!-- .container -->

<?php get_sidebar(); ?>
<?php get_footer();
