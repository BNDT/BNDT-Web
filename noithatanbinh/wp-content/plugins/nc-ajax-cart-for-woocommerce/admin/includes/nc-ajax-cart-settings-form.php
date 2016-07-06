<?php

/**
 * Provide a admin area form view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.1
 *
 * @package    nc-ajax-cart-for-woocommerce
 * @subpackage nc-ajax-cart-for-woocommerce/admin/includes
 */
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}

global $pagenow; 
$plugin_name=$this->plugin_name;
?>
<div class="wrap ajax_cart">
	<h1><?php _e('NC Ajax Cart Settings',$plugin_name); ?></h1>
	<p class="description"><?php _e('Insert shortcode [nc_ajax_cart] on page or post to display ajax cart for woocommerce.',$plugin_name); ?></p>

	<form method="post" action="<?php admin_url( 'admin.php?page=nc_ajax_cart' ); ?>" enctype="multipart/form-data">
		<table class="form-table">

			<?php wp_nonce_field( "nc_ajax_cart_page" ); 

			if ( $pagenow == 'admin.php' && $_GET['page'] == 'nc_ajax_cart' ){ 

				$layout=$this->ajax_cart_settings['ajax_cart_layout'];
				$width=$this->ajax_cart_settings['ajax_cart_width'];
				$image=$this->ajax_cart_settings['ajax_cart_enable_image'];
				$radius=$this->ajax_cart_settings['ajax_cart_radius'];
				$padding=$this->ajax_cart_settings['ajax_cart_padding'];
				$item_name=$this->ajax_cart_settings['ajax_cart_item_name'];
				$plural_name=$this->ajax_cart_settings['ajax_cart_item_name_plural'];
				$font=$this->ajax_cart_settings['ajax_cart_icon_font'];
				$icon_color=$this->ajax_cart_settings['ajax_cart_icon_color'];
				$text_color=$this->ajax_cart_settings['ajax_cart_text_color'];
				$link_color=$this->ajax_cart_settings['ajax_cart_link_color'];
				$button_color=$this->ajax_cart_settings['ajax_cart_button_text_color'];
				$background_color=$this->ajax_cart_settings['ajax_cart_background_color'];
				?>

				<tr>
					<th><?php _e('Select layout',$plugin_name); ?></th>
					<td>
						<select name="ajax_cart_layout" >
							<option <?php echo ($layout=='default') ? " selected='selected'": "";?>value="default"><?php _e('Default',$plugin_name); ?></option>           								               		
							<option <?php echo ($layout=='custom') ? " selected='selected'": "";?>value="custom"><?php _e('Custom',$plugin_name); ?></option>
						</select>
					</td>
				</tr>

				<tr>
					<th><?php _e('Width',$plugin_name); ?></th>
					<td>

						<input type="text" name="ajax_cart_width" value="<?php echo !empty($width) ? $width : '';?>"/>px
						<p class="description" id="tagline-description"><?php _e('Default 200px',$plugin_name); ?></p>
					</td>
				</tr>
				<tr>
					<th><?php _e('Enable Image',$plugin_name); ?></th>
					<td>
						<select name="ajax_cart_enable_image" >
							<option <?php echo ($image=='1') ? " selected='selected'": "";?>value="1"><?php _e('Yes',$plugin_name); ?></option>           	<option <?php echo $image=='0' ? " selected='selected'": "";?>value="0"><?php _e('No',$plugin_name); ?></option>

						</select>
					</td>
				</tr>

				<tr>
					<th><?php _e('Border radius',$plugin_name); ?></th>

					<td>

						<div id="ajax_cart_slider"></div>


						<input type="hidden" id="ajax_cart_radius" class="form-control" name="ajax_cart_radius" value="<?php echo !empty($radius) ? $radius : ''; ?>">
						<span  id="ajax_cart_radius_label"><?php echo !empty($radius) ? $radius : ''  ?></span><span class="pixel">px</span>



					</td>
				</tr>


				<tr>
					<th><?php _e('Padding',$plugin_name); ?></th>
					<td>
						<div id="ajax_cart_slider2"></div>
						<input type="hidden" id="ajax_cart_padding" class="form-control" name="ajax_cart_padding" value="<?php echo !empty($padding) ? $padding : ''; ?>">
						<span id="ajax_cart_padding_label"><?php echo !empty($padding) ? $padding : '';  ?></span><span class="pixel">px</span>
					</td>
				</tr>
				<tr>
					<th><?php _e('Product item name',$plugin_name); ?></th>
					<td>
						<input type="text" name="ajax_cart_item_name" value="<?php echo !empty($item_name) ? $item_name : '';?>"/>
					</td>
				</tr>
			</tr>
			<tr>
				<th><?php _e('Product item name plural',$plugin_name); ?></th>

				<td>
					<input type="text" name="ajax_cart_item_name_plural" value="<?php echo !empty($plural_name) ? $plural_name : '';?>"/>
				</td>
			</tr>
		</tr>
		<tr>
			<th><?php _e('Cart icon',$plugin_name); ?></th>
			<td>
				<?php
				$font=!empty($font) ? $font : "";
				$icons=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3'); 
				echo '<div class="icon-container">';
				foreach($icons as $icon){
					$active= ($font==$icon) ? 'icon-active' : '';
					echo '<span  rel-id="'.$icon.'" class="icon-font '.$active.'">'.$icon.'	</span>';
				}
				echo '<div class="clear"></div></div">';
				echo '<input type="hidden" name="ajax_cart_icon_font"   value="'.$font.'">';
				?>       
			</td>
		</tr>


		<tr>
			<th><?php _e('Cart icon color',$plugin_name); ?></th>
			<td>
				<div id="colorSelector-i" class="colorSelector"><div></div></div>

				<input type="hidden" name="ajax_cart_icon_color" id="color-picker" value="<?php echo !empty($icon_color) ? $icon_color : '';?>"/>

			</td>
		</tr>
		<tr>
			<th><?php _e('Text color',$plugin_name); ?></th>
			<td>
				<div id="colorSelector-t" class="colorSelector"><div></div></div>

				<input type="hidden" name="ajax_cart_text_color" id="color-picker1" value="<?php echo !empty($text_color) ? $text_color : '';?>"/>

			</td>
		</tr>
		<tr>
			<th><?php _e('Link color',$plugin_name); ?></th>
			<td>
				<div id="colorSelector-l" class="colorSelector"><div></div></div>

				<input type="hidden" name="ajax_cart_link_color" id="color-picker2" value="<?php echo !empty($link_color) ? $link_color : '';?>"/>

			</td>
		</tr>
		<tr>
			<th><?php _e('Button text color',$plugin_name); ?></th>
			<td>
				<div id="colorSelector-btc" class="colorSelector"><div></div></div>

				<input type="hidden" name="ajax_cart_button_text_color" id="color-picker3" value="<?php echo !empty($button_color) ? $button_color : '';?>"/>

			</td>
		</tr>
		<tr>
			<th><?php _e('Background color',$plugin_name); ?></th>
			<td>
				<div id="colorSelector-dc" class="colorSelector"><div></div></div>

				<input type="hidden" name="ajax_cart_background_color" id="color-picker4" value="<?php echo !empty($background_color) ? $background_color : ''?>"/>

			</td>
		</tr>
		<?php

	}

	?>
</table>
<p class="submit">
	<input type="submit" class="button-primary" name="nc_ajax_cart_submit" value="<?php _e('Save Changes',$plugin_name) ?>" />
</p>
</form>



<script>
	jQuery(document).ready(function($) {

		$(".icon-font").click(function(){
			var icon=$(this).attr("rel-id");
			$('input:hidden[name="ajax_cart_icon_font"]').val( icon );
			$(".icon-font").removeClass("icon-active");
			$(this).addClass("icon-active");

		});

		$("#ajax_cart_slider").slider({
			range: "min",
			animate: true,
			value:<?php echo !empty($this->ajax_cart_settings['ajax_cart_radius']) ? $this->ajax_cart_settings['ajax_cart_radius'] : '1';  ?>,
			min: 10,
			max: 100,
			step: 1,
			slide: function(event, ui) {
                update(1,ui.value); //changed
            }
        });

		$("#ajax_cart_slider2").slider({
			range: "min",
			animate: true,
			value:<?php echo !empty($this->ajax_cart_settings['ajax_cart_padding']) ? $this->ajax_cart_settings['ajax_cart_padding'] : '1';  ?> ,
			min: 10,
			max: 100,
			step: 1,
			slide: function(event, ui) {
                update(2,ui.value); //changed
            }
        });
          //Added, set initial value.
          $("#ajax_cart_radius").val(<?php echo !empty($this->ajax_cart_settings['ajax_cart_radius']) ? $this->ajax_cart_settings['ajax_cart_radius'] : '0';  ?>);
          $("#ajax_cart_padding").val(<?php echo !empty($this->ajax_cart_settings['ajax_cart_padding']) ? $this->ajax_cart_settings['ajax_cart_padding'] : '0';  ?> );
          $("#ajax_cart_radius_label").text(0);
          $("#ajax_cart_padding_label").text(0);

          
          update();
      });

      //changed. now with parameter
      function update(slider,val) {
        //changed. Now, directly take value from ui.value. if not set (initial, will use current value.)
        var $radius = slider == 1 ? val:jQuery("#ajax_cart_radius").val();
        var $padding = slider == 2 ? val:jQuery("#ajax_cart_padding").val();

        /* commented
        $amount = $( "#slider" ).slider( "value" );
        $duration = $( "#slider2" ).slider( "value" );
        */
        jQuery( "#ajax_cart_radius" ).val($radius);
        jQuery( "#ajax_cart_radius_label" ).text($radius);
        jQuery( "#ajax_cart_padding" ).val($padding);
        jQuery( "#ajax_cart_padding_label" ).text($padding);

    }

</script>