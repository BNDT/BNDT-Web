<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after
 */

?>

</div><!-- .site-content -->

<footer id="footer" role="contentinfo">

<?php 
	if(is_active_sidebar( 'zerif-sidebar-footer' ) || is_active_sidebar( 'zerif-sidebar-footer-2' ) || is_active_sidebar( 'zerif-sidebar-footer-3' )):
		echo '<div class="footer-widget-wrap"><div class="container">';
		if(is_active_sidebar( 'zerif-sidebar-footer' )):
			echo '<div class="footer-widget col-xs-12 col-sm-4">';
			dynamic_sidebar( 'zerif-sidebar-footer' );
			echo '</div>';
		endif;
		if(is_active_sidebar( 'zerif-sidebar-footer-2' )):
			echo '<div class="footer-widget col-xs-12 col-sm-4">';
			dynamic_sidebar( 'zerif-sidebar-footer-2' );
			echo '</div>';
		endif;
		if(is_active_sidebar( 'zerif-sidebar-footer-3' )):
			echo '<div class="footer-widget col-xs-12 col-sm-4">';
			dynamic_sidebar( 'zerif-sidebar-footer-3' );
			echo '</div>';
		endif;
		echo '</div></div>';
	endif;
?>

<div class="footer-widget-wrap">
	<div class="container">
		<div class="col-sm-4">
			<aside id="text-2" class="widget footer-widget-footer widget_text"><h1 class="widget-title">Thông tin liên hệ</h1>			
			<div class="textwidget"><div class="panel-body"><span style="font-size:14px;"><strong>CÔNG TY TNHH PHẲNG</strong></span><br />
				Địa chỉ: 53 Đường Số 23,Hiệp Bình Chánh,Thủ Đức,Hồ Chí Minh.<br />
				<span style="line-height: 20.8px;">Điện thoại:&nbsp;</span>(08) 225.171.91<br />
				<span style="line-height: 20.8px;">Hotline :&nbsp;</span><span style="line-height: 20.8px;">0907.975.779&nbsp;</span><span style="line-height: 20.8px;">&nbsp;&nbsp;</span><br />
				Email: kinhdoanh@quangcaophang.com<br />
				<a href="http://rankboostup.com/?refid=89951" target="_blank"><img alt="RankBoostup - Free Website Traffic Exchange" height="27" src="http://rankboostup.com/static/images/logo/referral-banner-green.png" width="201" pagespeed_url_hash="2681532011" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/></a><br />
				<img alt="" border="0" src="http://sstatic1.histats.com/0.gif?3163727&amp;101" pagespeed_url_hash="1484040098" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/><a class="dmca-badge" href="http://www.dmca.com/Protection/Status.aspx?ID=21b81dcb-6fc0-4b23-b310-58ec80f90847" title="DMCA.com Protection Status"><img alt="DMCA.com Protection Status" src="//images.dmca.com/Badges/dmca_protected_sml_120l.png?ID=21b81dcb-6fc0-4b23-b310-58ec80f90847" pagespeed_url_hash="3506320459" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/></a>
				</div>
			</div>
			</aside>
		</div>
		<div class="col-sm-4">
			<aside id="text-3" class="widget footer-widget-footer widget_text"><h1 class="widget-title">Thống kê</h1>
				<div class="textwidget">
					<ul class="nv-list-item">
						<li><em class="fa fa-bolt fa-lg">&nbsp;</em> Đang truy cập <span class="pull-right">26</span></li>
						<li><em class="fa fa-magic fa-lg">&nbsp;</em> Máy chủ tìm kiếm <span class="pull-right">22</span></li>
						<li><em class="fa fa-bullseye fa-lg">&nbsp;</em> Khách viếng thăm <span class="pull-right">4</span></li>
					</ul>
					<div><hr/></div>
					<ul class="nv-list-item">
						<li><em class="fa fa-filter fa-lg">&nbsp;</em> Hôm nay <span class="pull-right">544</span></li>
						<li><em class="fa fa-calendar-o fa-lg">&nbsp;</em> Tháng hiện tại <span class="pull-right">25,360</span></li>
						<li><em class="fa fa-bars fa-lg">&nbsp;</em> Tổng lượt truy cập <span class="pull-right">166,342</span></li>
					</ul>
				</div>
			</aside>
		</div>
		<div class="col-sm-4">
		<aside id="text-4" class="widget footer-widget-footer widget_text"><h1 class="widget-title">Xem Nhiều</h1>			
			<div class="textwidget">
				<ul class="listnews">
					<li class="clearfix"><a class="show" href="/bang-hieu-cac-loai/thi-cong-bien-hieu-chu-noi-mica-gia-re-68.html">Thi công biển hiệu chữ nổi mica giá rẻ</a></li>
					<li class="clearfix"><a class="show" href="/bang-hieu-cac-loai/gia-cong-bang-inox-an-mon-35.html">Gia công bảng inox ăn mòn</a></li>
					<li class="clearfix"><a class="show" href="/chu-noi-mica/chu-noi-mica-gia-re-tai-tp-hcm-51.html">Chữ nổi mica giá rẻ tại Tp.HCM</a></li>
					<li class="clearfix"><a class="show" href="/chu-noi-inox/gia-cong-chu-inox-long-vien-led-sang-mat-mica-25.html">Gia công chữ Inox lọng viền led sáng mặt mica</a></li>
				</ul>
			</div>
		</aside>
		</div>
	</div>
</div>
	<div class="container">
	<div class="col-xs-24 col-sm-24 col-md-12">
		<div class="pull-left"><span class="icon-hotline">HOTLINE: 0907.975.779 -</span>
		<span class="icon-email">EMAIL:</span><a href="mailto:kinhdoanh@quangcaophang.com">kinhdoanh@quangcaophang.com</a>
		</div>
	</div>
</div> <!-- / END CONTAINER -->

</footer> <!-- / END FOOOTER  -->


	</div><!-- mobile-bg-fix-whole-site -->
</div><!-- .mobile-bg-fix-wrap -->


<?php wp_footer(); ?>

</body>

</html>