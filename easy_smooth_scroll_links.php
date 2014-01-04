<?php
/*
Plugin Name: Easy Smooth Scroll Links
Plugin URI: http://www.jeriffcheng.com/wordpress-plugins/easy-smooth-scroll-links
Description: Adds smoth scrolling effect to links that link to other parts of the page,which are called "Page Anchors".
Version: 1.2
Author: Jeriff Cheng
Author URI: http://www.jeriffcheng.com/
*/

/*
Copyright 2011  Jeriff Cheng(Email:hschengyongtao@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
*/

//load required script
add_action('wp_enqueue_scripts', 'essl_script');
if ( ! function_exists('essl_script') ) {
	function essl_script() {
    ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
	$(function() {
	  $('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});
</script>
<?php
	}
}


//Visual Editor Button
if ( ! function_exists('enable_anchor_button') ) {
function enable_anchor_button($buttons) {
  $buttons[] = 'anchor';
  return $buttons;
}
add_filter("mce_buttons_2", "enable_anchor_button");
}


//Shortcode
if ( ! function_exists('essl_shortcode') ) {
function essl_shortcode( $atts, $content = null ) {
   return '<a name="' . $content . '">';
}
add_shortcode( 'anchor', 'essl_shortcode' );
}
