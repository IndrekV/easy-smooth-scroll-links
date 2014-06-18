<?php
/*
Plugin Name: Easy Smooth Scroll Links Plus
Plugin URI: https://github.com/IndrekV/easy-smooth-scroll-links
Description: Create Page Anchors and add smooth scrolling effect to links.
Version: 1.5.0
Author: Jeriff Cheng, Indrek Vändrik
Author URI: https://github.com/IndrekV/
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

//Anchor Button to TinyMCE Editor
global $wp_version;
if ( $wp_version < 3.9 ) {
	if ( ! function_exists('enable_anchor_button') ) {
		function enable_anchor_button($buttons) {
		  $buttons[] = 'anchor';
		  return $buttons;
		}
	}
	add_filter("mce_buttons_2", "enable_anchor_button");
} else {
	add_action( 'init', 'anchor_button' );
	function anchor_button() {
		add_filter( "mce_external_plugins", "anchor_add_button" );
		add_filter( 'mce_buttons_2', 'anchor_register_button' );
	}
	function anchor_add_button( $plugin_array ) {
		$plugin_array['anchor'] = $dir = plugins_url( '/anchor/plugin.min.js', __FILE__ );
		return $plugin_array;
	}
	function anchor_register_button( $buttons ) {
		array_push( $buttons, 'anchor' );
		return $buttons;
	}
}


//Shortcode
if ( ! function_exists('esslp_shortcode') ) {
function esslp_shortcode( $atts, $content = null ) {
   return '<a name="' . $content . '">';
}
add_shortcode( 'anchor', 'esslp_shortcode' );
}


/* 
Registering Options Page
*/	
if(!class_exists('ESSLPPluginOptions')) :

// DEFINE PLUGIN ID
define('ESSLPPluginOptions_ID', 'public-plugin-options');
// DEFINE PLUGIN NICK
define('ESSLPPluginOptions_NICK', 'ESSLP Settings');

    class ESSLPPluginOptions
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
			register_setting(ESSLPPluginOptions_ID.'_options', 'esslp_speed');
			register_setting(ESSLPPluginOptions_ID.'_options', 'esslp_offset');
			register_setting(ESSLPPluginOptions_ID.'_options', 'esslp_hash');
		}
		/** function/method
		* Usage: hooking (registering) the plugin menu
		* Arg(0): null
		* Return: void
		*/
		public static function menu()
		{
			// Create menu tab
			add_options_page(ESSLPPluginOptions_NICK.' Plugin Options', ESSLPPluginOptions_NICK, 'manage_options', ESSLPPluginOptions_ID.'_options', array('ESSLPPluginOptions', 'options_page'));
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
			
			$plugin_id = ESSLPPluginOptions_ID;
			// display options page
			include(self::file_path('options.php'));
		}
		
    }

    // Add settings link on plugin page
	function esslp_plugin_action_links($links) { 
	  $settings_link = '<a href="options-general.php?page=esslp-plugin-options_options">Settings</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
	}

	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'esslp_plugin_action_links' );

	
	if ( is_admin() )
	{
		add_action('admin_init', array('ESSLPPluginOptions', 'register'));
		add_action('admin_menu', array('ESSLPPluginOptions', 'menu'));
		
	}
	
	if ( !is_admin() )
	{

		add_action( 'wp_enqueue_scripts', 'esslp_enqueue_jquery', 999 );
		add_action('wp_footer', 'esslp_script',100);
		
		function esslp_enqueue_jquery() {
			wp_deregister_script( 'jquery-easing' );
			wp_register_script( 'jquery-easing', '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js',array( 'jquery' ) );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script('jquery-easing');
		}
		function g($k,$d) {
		  if(strlen(get_option($k,$d))>0){
		    return get_option($k,$d);
		  }
		  return $d;
		}
		function esslp_script() {
?>	
			<script type="text/javascript">
				jQuery.noConflict();
				if($==null) _$=jQuery;
				(function(_$) {
				// More code using $ as alias to jQuery

					_$(function() {
					  _$('a[href*=#]:not([href=#])').click(function() {
						if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
							var hash = this.hash
						  var target = _$(hash);
						  target = target.length ? target : _$('[name=' + this.hash.slice(1) +']');
						  if (target.length) {
							_$('html,body').animate({
							  scrollTop: target.offset().top -<?php echo g('esslp_offset',20);?>   
							}, <?php echo g('esslp_speed',900);?>, function() {
								if(<?php echo g('esslp_hash',false);?>) location.hash = hash;
							});
							return false;
						  }
						}
					  });
					});
				})(jQuery);	
			</script>
<?php  }	
	}	
endif;

?>
