<?php
/**
 * Template Name: xem nhiều
 *
 */
get_header(); ?>

	<div id="primary" class="content-area content-area-full">
		<div class="row">
			<div class="box">
				<div class="title-bar col-xs-12">
					<span class="bar-header">Sản Phẩm Được Xem Nhiều</span>
					<ul class="bar bar-item">
						<li><a href="<?php echo home_url()?>/xem-nhieu">Xem nhiều</a></li>
						<li><a href="<?php echo home_url()?>/mua-nhieu">Mua nhiều nhất</a></li>
						<li><a href="<?php echo home_url()?>/moi-nhat">Mới nhất</a></li>
						
					</ul>
				</div>    
				<div class="con-product">
					<?php echo do_shortcode('[recent_products per_page="30" columns="4"]'); ?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>