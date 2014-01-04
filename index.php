<?php
/*
Plugin Name: Easy Smooth Scroll Links
Plugin URI: http://www.jeriffcheng.com/wordpress-plugins/easy-smooth-scroll-links
Description: Create Page Anchors and add smooth scrolling effect to links that link to Page Anchors. You can set scroll speed and offset value.
Version: 1.3.1
Author: Jeriff Cheng
Author URI: http://www.jeriffcheng.com/
*/

/*
Copyright 2014  Jeriff Cheng ( Email:hschengyongtao@gmail.com )

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


/* 
Registering Options Page
*/	
if(!class_exists('ESSLPluginOptions')) :

// DEFINE PLUGIN ID
define('ESSLPluginOptions_ID', 'essl-plugin-options');
// DEFINE PLUGIN NICK
define('ESSLPluginOptions_NICK', 'ESSL Settings');

    class ESSLPluginOptions
    {
		/** function/method
		* Usage: return absolute file path
		* Arg(1): string
		* Return: string
		*/
		public static function file_path($file)
		{
			return ABSPATH.'wp-content/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).$file;
		}
		/** function/method
		* Usage: hooking the plugin options/settings
		* Arg(0): null
		* Return: void
		*/
		public static function register()
		{
			register_setting(ESSLPluginOptions_ID.'_options', 'essl_speed');
			register_setting(ESSLPluginOptions_ID.'_options', 'essl_offset');
		}
		/** function/method
		* Usage: hooking (registering) the plugin menu
		* Arg(0): null
		* Return: void
		*/
		public static function menu()
		{
			// Create menu tab
			add_options_page(ESSLPluginOptions_NICK.' Plugin Options', ESSLPluginOptions_NICK, 'manage_options', ESSLPluginOptions_ID.'_options', array('ESSLPluginOptions', 'options_page'));
		}
		/** function/method
		* Usage: show options/settings form page
		* Arg(0): null
		* Return: void
		*/
		public static function options_page()
		{ 
			if (!current_user_can('manage_options')) 
			{
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			
			$plugin_id = ESSLPluginOptions_ID;
			// display options page
			include(self::file_path('options.php'));
		}
		
    }
	
	if ( is_admin() )
	{
		add_action('admin_init', array('ESSLPluginOptions', 'register'));
		add_action('admin_menu', array('ESSLPluginOptions', 'menu'));
		
	}
	
	if ( !is_admin() )
	{

		add_action( 'wp_enqueue_scripts', 'essl_enqueue_jquery', 999 );
		add_action('wp_footer', 'essl_script',100);
		
		function essl_enqueue_jquery() {
			wp_enqueue_script( 'jquery' );
		}
		function essl_script() {
					?>	<script type="text/javascript">
					jQuery.noConflict();
					(function( $ ) {
					$(function() {
					// More code using $ as alias to jQuery

						$(function() {
						  $('a[href*=#]:not([href=#])').click(function() {
							if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
							  var target = $(this.hash);
							  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
							  if (target.length) {
								$('html,body').animate({
								  scrollTop: target.offset().top -<?php echo  get_option('essl_offset',20);?>   
								}, <?php echo  get_option('essl_speed',900);?>);
								return false;
							  }
							}
						  });
						});

					});
					})(jQuery);	</script>
					<?php  }	
	}	
endif;

?>