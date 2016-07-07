<ul class="product_list_widget">
    <?php
    foreach ((array) $comments as $comment) {

        $_product = wc_get_product($comment->comment_post_ID);

        $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));

        $rating_html = $_product->get_rating_html($rating);
        ?>
        <li>
            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                <?php
                echo $_product->get_image();
                echo $_product->get_title() . '</a>';
                echo $rating_html;
                printf('<span class="reviewer">' . _x('by %1$s', 'by comment author', 'woocommerce') . '</span>', get_comment_author($comment->comment_ID));
                ?>
        </li>
        <?php
    }
    ?>
</ul>