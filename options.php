<div class="wrap">
	
    <?php screen_icon(); ?>
    
	<form action="options.php" method="post" id="<?php echo $plugin_id; ?>_options_form" name="<?php echo $plugin_id; ?>_options_form">
    
	<?php settings_fields($plugin_id.'_options'); ?>
    
    <h2>Easy Smooth Scroll Links Plus &raquo; Settings</h2>
    <table class="widefat">
		<thead>
		   <tr>
			 <th><a target="_blank" href="https://github.com/IndrekV/easy-smooth-scroll-links">FAQs</a> - <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/easy-smooth-scroll-links?filter=5#postform">Rate it</a> - <a target="_blank" href="http://wordpress.org/support/plugin/easy-smooth-scroll-links">Support Forum</a>    ---- Suggestions? <a target="_blank" href="http://www.jeriffcheng.com/contact">Contact Me</a></th>
		   </tr>
		</thead>

		<tbody>
		   <tr>
			 <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">
                 <label for="esslp_speed">
                     <p>Scroll Speed ( smaller number, faster, default is 900 )</p>
                     <p><input type="text" name="esslp_speed" value="<?php echo get_option('esslp_speed'); ?>" /></p>
                 </label>
             </td>
		   </tr>
		   <tr>
			 <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">
                 <label for="esslp_offset">
                     <p>Offset ( default is 20 )</p>
                     <p><input type="text" name="esslp_offset" value="<?php echo get_option('esslp_offset'); ?>" /></p>
                 </label>
             </td>
		   </tr>
       <tr>
       <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">
                 <label for="esslp_hash">
                     <p>Show hash in address bar</p>
                     <p>
                      <select name="esslp_hash">
                        <option value="false" <?php if (get_option('esslp_hash')=="false") echo 'selected="selected"'; ?>>false</option>
                        <option value="true" <?php if (get_option('esslp_hash')=="true") echo 'selected="selected"'; ?>>true</option>
                      </select>
                    </p>
                 </label>
             </td>
       </tr>
		</tbody>

		<tfoot>
		   <tr>
			 <th><input type="submit" name="submit" value="Save Settings" class="button button-primary" /></th>
		   </tr>
		</tfoot>
	</table>
    
	</form>
    
</div>