<?php
/**
 * Template Name: mới nhất
 *
 */
get_header(); ?>

	<div id="primary" class="content-area content-area-full">
		<div class="row">
			<div class="box">
				<div class="title-bar col-xs-12">
					<span class="bar-header">Sản Phẩm Mới Nhất</span>
					<ul class="bar bar-item">
						<li><a href="<?php echo home_url()?>/xem-nhieu">Xem nhiều</a></li>
						<li><a href="<?php echo home_url()?>/mua-nhieu">Mua nhiều nhất</a></li>
						<li><a href="<?php echo home_url()?>/moi-nhat">Mới nhất</a></li>
						<li>
					<form class="woocommerce-ordering" method="get">
						<select name="orderby" class="orderby">
							<option value="order-menu_order">Thứ tự mặc định</option>
							<option value="<?php $currentUrl;?>order-popularity" >Thứ tự theo mức độ phổ biến</option>
							<option value="<?php $currentUrl;?>order-rating" >Thứ tự theo điểm đánh giá</option>
							<option value="<?php $currentUrl;?>order-date" >Thứ tự theo sản phẩm mới</option>
							<option value="order-price" >Thứ tự theo giá: thấp đến cao</option>
							<option value="<?php $currentUrl;?>order-price-desc" >Thứ tự theo giá: cao xuống thấp</option>
						</select>
					</form>
						</li>
					</ul>
					
				</div>    
				<div class="con-product">
				
					<?php if($_GET['orderby'] =="order-rating"){
							echo do_shortcode('[recent_products per_page="12" columns="4"]');
						}else {
							echo do_shortcode('[recent_products per_page="12" columns="4"]'); 
							//var_dump("string");
						}
					?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>