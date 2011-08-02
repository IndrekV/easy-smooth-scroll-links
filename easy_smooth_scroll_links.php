<?php
/*
Plugin Name: Easy Smooth Scroll Links
Plugin URI: http://www.92app.com/wordpress-plugins/easy-smooth-scroll-links
Description:Adds smoth scrolling effect to links that link to other parts of the page,which are called "Page Anchors".Extremely useful for setting up a menu which can send you to different section of a post.
Version: 1.0
Author: Jeriff Cheng
Author URI: http://www.92app.com/
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

//add anchor button to visual editor
if ( ! function_exists('enable_anchor_button') ) {
function enable_anchor_button($buttons) {
  $buttons[] = 'anchor';
  return $buttons;
}
add_filter("mce_buttons_2", "enable_anchor_button");
}

//add required js
if ( ! function_exists('add_smooth_scroll_links_js') ) {
function add_smooth_scroll_links_js() {
         ?>
		 <script type="text/javascript" src="<?php echo get_option('siteurl') . '/' . PLUGINDIR . '/' . dirname(plugin_basename (__FILE__))?>/easy_smooth_scroll_links.js"></script>
         <?php
		 }
add_action(wp_footer,add_smooth_scroll_links_js,20);
}