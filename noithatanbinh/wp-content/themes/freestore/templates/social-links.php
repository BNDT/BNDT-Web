<?php
if( get_theme_mod( 'freestore-social-email', false ) ) :
    echo '<a href="' . esc_url( 'mailto:' . antispambot( get_theme_mod( 'freestore-social-email' ), 1 ) ) . '" title="' . __( 'Send Us an Email', 'freestore' ) . '" class="header-social-icon social-email"><i class="fa fa-envelope-o"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-skype', false ) ) :
    echo '<a href="skype:' . esc_html( get_theme_mod( 'freestore-social-skype' ) ) . '?userinfo" title="' . __( 'Contact Us on Skype', 'freestore' ) . '" class="header-social-icon social-skype"><i class="fa fa-skype"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-facebook', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-facebook' ) ) . '" target="_blank" title="' . __( 'Find Us on Facebook', 'freestore' ) . '" class="header-social-icon social-facebook"><i class="fa fa-facebook"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-twitter', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-twitter' ) ) . '" target="_blank" title="' . __( 'Follow Us on Twitter', 'freestore' ) . '" class="header-social-icon social-twitter"><i class="fa fa-twitter"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-google-plus', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-google-plus' ) ) . '" target="_blank" title="' . __( 'Find Us on Google Plus', 'freestore' ) . '" class="header-social-icon social-gplus"><i class="fa fa-google-plus"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-youtube', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-youtube' ) ) . '" target="_blank" title="' . __( 'View our YouTube Channel', 'freestore' ) . '" class="header-social-icon social-youtube"><i class="fa fa-youtube"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-instagram', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-instagram' ) ) . '" target="_blank" title="' . __( 'Follow Us on Instagram', 'freestore' ) . '" class="header-social-icon social-instagram"><i class="fa fa-instagram"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-pinterest', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-pinterest' ) ) . '" target="_blank" title="' . __( 'Pin Us on Pinterest', 'freestore' ) . '" class="header-social-icon social-pinterest"><i class="fa fa-pinterest"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-linkedin', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-linkedin' ) ) . '" target="_blank" title="' . __( 'Find Us on LinkedIn', 'freestore' ) . '" class="header-social-icon social-linkedin"><i class="fa fa-linkedin"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-tumblr', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-tumblr' ) ) . '" target="_blank" title="' . __( 'Find Us on Tumblr', 'freestore' ) . '" class="header-social-icon social-tumblr"><i class="fa fa-tumblr"></i></a>';
endif;

if( get_theme_mod( 'freestore-social-flickr', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'freestore-social-flickr' ) ) . '" target="_blank" title="' . __( 'Find Us on Flickr', 'freestore' ) . '" class="header-social-icon social-flickr"><i class="fa fa-flickr"></i></a>';
endif;
