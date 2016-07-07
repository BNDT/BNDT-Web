<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package FreeStore
 */
?>
		<div class="clearboth"></div>
	</div><!-- #content -->
	
	<div class="clearboth"></div>
	<div class="container" style="margin-bottom:10px">
	<div class="fb-like" data-href="https://www.facebook.com/sieuthinoithatanbinh/?pnref=lhc" data-width="1000" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	</div>
	<?php get_template_part( '/templates/footers/footer-centered' ); ?>
	<?php echo ( get_theme_mod( 'freestore-site-layout' ) == 'freestore-site-boxed' ) ? '</div>' : ''; ?>
</div><!-- #page -->


<?php wp_footer(); ?>



</body>
</html>
