<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

get_header(); ?>

	<div class="container">
		<div id="content" role="main">

			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php esc_html_e( 'Not Found', 'live-it-up' ); ?></h1>
				<div class="entry-content">
					<p><?php esc_html_e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'live-it-up' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
				<div class="entry-footer"></div>
			</div><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- .container -->

<?php get_footer(); ?>