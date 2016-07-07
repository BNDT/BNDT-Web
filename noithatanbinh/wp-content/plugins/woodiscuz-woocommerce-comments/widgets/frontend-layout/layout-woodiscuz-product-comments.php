<ul class="product_list_widget">
    <?php
    foreach ((array) $comments as $comment) {

        $_product = wc_get_product($comment->comment_post_ID);
        ?>
        <li>
            <a href="<?php echo esc_url(get_permalink($comment->comment_ID)).'#wpc-comment-'. $comment->comment_ID;?>">
                <?php
                echo $_product->get_image(). '</a>';
                printf( _x( '%1$s on %2$s', 'widgets' ),
			  '<span class="comment-author-link">' . get_comment_author_link($comment->comment_ID) . '</span>',
		          '<a href="' . esc_url( get_permalink( $comment->comment_post_ID ) ) . '#wpc-comment-'.$comment->comment_ID.'">' . get_the_title( $comment->comment_post_ID ) . '</a>'
				);
                ?>
        </li>
        <?php
    }
    ?>
</ul>