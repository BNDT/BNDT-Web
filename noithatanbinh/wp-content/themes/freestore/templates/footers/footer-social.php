<footer id="colophon" class="site-footer site-footer-social" role="contentinfo">
	
	<div class="site-footer-icons">
        <div class="site-container">
        	
        	<?php if ( ! get_theme_mod( 'freestore-footer-hide-social' ) ) : ?>
	            
	            <?php
				if( get_theme_mod( 'freestore-social-email', false ) ) :
				    echo '<a href="' . esc_url( 'mailto:' . antispambot( get_theme_mod( 'freestore-social-email' ), 1 ) ) . '" title="' . __( 'Send Us an Email', 'freestore' ) . '" class="footer-social-icon footer-social-email"><i class="fa fa-envelope-o"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-skype', false ) ) :
				    echo '<a href="skype:' . esc_html( get_theme_mod( 'freestore-social-skype' ) ) . '?userinfo" title="' . __( 'Contact Us on Skype', 'freestore' ) . '" class="footer-social-icon footer-social-skype"><i class="fa fa-skype"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-facebook', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-facebook' ) ) . '" target="_blank" title="' . __( 'Find Us on Facebook', 'freestore' ) . '" class="footer-social-icon footer-social-facebook"><i class="fa fa-facebook"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-twitter', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-twitter' ) ) . '" target="_blank" title="' . __( 'Follow Us on Twitter', 'freestore' ) . '" class="footer-social-icon footer-social-twitter"><i class="fa fa-twitter"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-google-plus', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-google-plus' ) ) . '" target="_blank" title="' . __( 'Find Us on Google Plus', 'freestore' ) . '" class="footer-social-icon footer-social-gplus"><i class="fa fa-google-plus"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-youtube', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-youtube' ) ) . '" target="_blank" title="' . __( 'View our YouTube Channel', 'freestore' ) . '" class="footer-social-icon footer-social-youtube"><i class="fa fa-youtube"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-vimeo', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-vimeo' ) ) . '" target="_blank" title="' . __( 'View our Vimeo Channel', 'freestore' ) . '" class="footer-social-icon footer-social-vimeo"><i class="fa fa-vimeo"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-instagram', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-instagram' ) ) . '" target="_blank" title="' . __( 'Follow Us on Instagram', 'freestore' ) . '" class="footer-social-icon footer-social-instagram"><i class="fa fa-instagram"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-pinterest', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-pinterest' ) ) . '" target="_blank" title="' . __( 'Pin Us on Pinterest', 'freestore' ) . '" class="footer-social-icon footer-social-pinterest"><i class="fa fa-pinterest"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-linkedin', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-linkedin' ) ) . '" target="_blank" title="' . __( 'Find Us on LinkedIn', 'freestore' ) . '" class="footer-social-icon footer-social-linkedin"><i class="fa fa-linkedin"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-tumblr', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-tumblr' ) ) . '" target="_blank" title="' . __( 'Find Us on Tumblr', 'freestore' ) . '" class="footer-social-icon footer-social-tumblr"><i class="fa fa-tumblr"></i></a>';
				endif;

				if( get_theme_mod( 'freestore-social-flickr', false ) ) :
				    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-flickr' ) ) . '" target="_blank" title="' . __( 'Find Us on Flickr', 'freestore' ) . '" class="footer-social-icon footer-social-flickr"><i class="fa fa-flickr"></i></a>';
				endif; ?>
			
			<?php endif; ?>
			
			<?php if ( get_theme_mod( 'freestore-website-site-add' ) ) : ?>
	        	<div class="site-footer-social-ad">
	        		<i class="fa fa-map-marker"></i> <?php echo wp_kses_post( get_theme_mod( 'freestore-website-site-add', false ) ) ?>
	        	</div>
	        <?php endif; ?>
			
			<?php if ( get_theme_mod( 'freestore-website-txt-copy' ) ) : ?>
				<div class="site-footer-social-copy">
					<?php echo wp_kses_post( get_theme_mod( 'freestore-website-txt-copy', false ) ) ?>
				</div>
			<?php endif; ?>
            
            <div class="clearboth"></div>
        </div>
    </div>
    
</footer>

<?php if ( get_theme_mod( 'freestore-footer-bottombar', false ) == 0 ) : ?>
	
	<div class="site-footer-bottom-bar">
	
		<div class="site-container">
			
	        <?php wp_nav_menu( array( 'theme_location' => 'footer-bar','container' => false, 'fallback_cb' => false, 'depth'  => 1 ) ); ?>
                
	    </div>
		
        <div class="clearboth"></div>
	</div>
	
<?php endif; ?>