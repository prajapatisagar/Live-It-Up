<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 *
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <div id="nav-above" class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'live-it-up' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'live-it-up' ) ); ?></div>
    </div><!-- #nav-above -->
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
    <div id="post-0" class="post error404 not-found">
        <h1 class="entry-title"><?php esc_html_e( 'Not Found', 'live-it-up' ); ?></h1>
        <div class="entry-content">
            <p><?php esc_html_e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'live-it-up' ); ?></p>
			<?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </div><!-- #post-0 -->
<?php endif; ?>

<?php
/* Start the Loop.
 *
 * In Live it up we use the same loop in multiple contexts.
 * It is broken into three main parts: when we're displaying
 * posts that are in the gallery category, when we're displaying
 * posts in the asides category, and finally all other posts.
 *
 * Additionally, we sometimes check for whether we are on an
 * archive page, a search page, etc., allowing for small differences
 * in the loop on each template without actually duplicating
 * the rest of the loop that is shared.
 *
 * Without further ado, the loop:
 */ ?>
<?php while ( have_posts() ) : the_post(); ?>

	<?php /* How to display posts in the Gallery category. */ ?>

	<?php if ( in_category( _x( 'gallery', 'gallery category slug', 'live-it-up' ) ) ) : ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'live-it-up' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php the_title(); ?>
                </a>
            </h2>

            <div class="entry-meta">
				<?php live_it_up_posted_on(); ?>
            </div><!-- .entry-meta -->

            <div class="entry-content">
				<?php if ( post_password_required() ) : ?>
					<?php the_content(); ?>
				<?php else : ?>
					<?php
					$images            = get_children( array(
						'post_parent'    => $post->ID,
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'posts_per_page' => 10
					) );
					if ( $images ) :
						$total_images = count( $images );
						$image         = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
						?>
                        <div class="gallery-thumb">
                            <a class="size-thumbnail" href="<?php the_permalink(); ?>">
								<?php echo esc_html( $image_img_tag ); ?>
                            </a>
                        </div><!-- .gallery-thumb -->
                        <p>
                            <em>
								<?php printf( esc_html__( 'This gallery contains <a %1$s>%2$s photos</a>.', 'live-it-up' ), 'href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'live-it-up' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
									esc_html( $total_images )
								); ?>
                            </em>
                        </p>
					<?php endif; ?>
					<?php the_excerpt(); ?>
				<?php endif; ?>
            </div><!-- .entry-content -->
			<?php
			$get_term_link_url = get_term_link( 'gallery', 'gallery category slug' );
			?>
            <div class="entry-utility">
                <a href="<?php echo esc_url( $get_term_link_url ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'live-it-up' ); ?>"><?php esc_html_e( 'More Galleries', 'live-it-up' ); ?></a>
                <span class="meta-sep">|</span>
                <span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'live-it-up' ), esc_html__( '1 Comment', 'live-it-up' ), esc_html__( '% Comments', 'live-it-up' ) ); ?></span>
				<?php edit_post_link( esc_html__( 'Edit', 'live-it-up' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
            </div><!-- .entry-utility -->
        </div><!-- #post-## -->

		<?php /* How to display posts in the asides category */ ?>

	<?php elseif ( in_category( _x( 'asides', 'asides category slug', 'live-it-up' ) ) ) : ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
                <div class="entry-summary">
					<?php the_excerpt(); ?>
                </div><!-- .entry-summary -->
			<?php else : ?>
                <div class="entry-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'live-it-up' ) ); ?>
                </div><!-- .entry-content -->
			<?php endif; ?>

            <div class="entry-utility">
				<?php live_it_up_posted_on(); ?>
                <span class="meta-sep">|</span>
                <span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'live-it-up' ), esc_html__( '1 Comment', 'live-it-up' ), esc_html__( '% Comments', 'live-it-up' ) ); ?></span>
				<?php edit_post_link( esc_html__( 'Edit', 'live-it-up' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
            </div><!-- .entry-utility -->
        </div><!-- #post-## -->

		<?php /* How to display all other posts. */ ?>

	<?php else : ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'live-it-up' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

            <div class="entry-meta">
				<?php live_it_up_posted_on(); ?>
            </div><!-- .entry-meta -->

			<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
                <div class="entry-summary">
					<?php the_excerpt(); ?>
                </div><!-- .entry-summary -->
			<?php else : ?>
                <div class="entry-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'live-it-up' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'live-it-up' ), 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
			<?php endif; ?>

            <div class="entry-utility">
				<?php if ( count( get_the_category() ) ) : ?>
                    <span class="cat-links">
						<?php printf( esc_html__( '<span class="%1$s">Posted in</span> %2$s', 'live-it-up' ), 'entry-utility-prep entry-utility-prep-cat-links', esc_html( get_the_category_list( esc_html__( ', ', 'live-it-up' ) ) ) ); ?>
					</span>
                    <span class="meta-sep">|</span>
				<?php endif; ?>
				<?php
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ):
					?>
                    <span class="tag-links">
						<?php printf( esc_html__( '<span class="%1$s">Tagged</span> %2$s', 'live-it-up' ), 'entry-utility-prep entry-utility-prep-tag-links', esc_html( $tags_list ) ); ?>
					</span>
                    <span class="meta-sep">|</span>
				<?php endif; ?>
                <span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'live-it-up' ), esc_html__( '1 Comment', 'live-it-up' ), esc_html__( '% Comments', 'live-it-up' ) ); ?></span>
				<?php edit_post_link( esc_html__( 'Edit', 'live-it-up' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
            </div><!-- .entry-utility -->
            <div class="entry-footer"></div>
        </div><!-- #post-## -->

		<?php comments_template( '', true ); ?>

	<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <div id="nav-below" class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'live-it-up' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'live-it-up' ) ); ?></div>
    </div><!-- #nav-below -->
<?php endif; ?>
