<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 *
 */
?>
	<div class="main-content-end"></div>
	
	</div><!-- #main -->

	<div id="footer" role="contentinfo">
		<div id="colophon">

			<div id="site-info">

				<?php echo '&copy; '.date_i18n(__('Y','live-it-up')); ?>
                <span class="sep"> | </span>
				<?php printf( esc_html__( 'Live it up WordPress Theme ','live-it-up')); ?>
                <span class="sep"> | </span>
				<?php printf( esc_html__( 'By Sagar Prajapati', 'live-it-up' )); ?>
				
			</div><!-- #site-info -->
			
		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
