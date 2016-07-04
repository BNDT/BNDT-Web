<?php if ( !is_front_page() ) : ?>
    
    <header class="entry-header">
        
        <?php if ( is_home() ) : ?>
            
            <?php echo ( get_theme_mod( 'freestore-blog-title' ) ) ? '<h1 class="entry-title">' . esc_html( get_theme_mod( 'freestore-blog-title', false ) ) . '</h1>' : '<h1 class="entry-title">' . __( 'Blog', 'freestore' ) . '</h1>'; ?>
            
        <?php else: ?>
            
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            
        <?php endif; ?>
        
        <?php if ( ! is_front_page() ) : ?>
    
	        <?php if ( function_exists( 'bcn_display' ) ) : ?>
		        <div class="breadcrumbs">
		            <?php bcn_display(); ?>
		        </div>
	        <?php endif; ?>
	        
	    <?php endif; ?>
        
    </header><!-- .entry-header -->

<?php endif; ?>