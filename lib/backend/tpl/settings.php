<?php
	if(current_user_can('activate_plugins')){
		$this->core->settings->get_settings_default();
?>
<div id="sv_settings">
	<div id="sv_header">
		<div id="sv_logo"><a href="https://straightvisions.com"><img src="<?php echo $GLOBALS['plugin_sv_proven_expert']->url; ?>lib/assets/img/logo.png" /></a></div>
		<div id="sv_logo_vendor"><a href="https://www.provenexpert.com/de/pa281/"><img src="<?php echo $GLOBALS['plugin_sv_proven_expert']->url; ?>lib/assets/img/logo_proven_expert.png" /></a></div>
	</div>
	<div id="sv_thankyou">
		<h2><?php _e('Review Stars', 'sv_proven_expert'); ?></h2>
		<p><?php _e('Fill out the API settings and add the widget or shortcode to your site. This will show review stars on your site and in Google SERPs.', 'sv_proven_expert'); ?></p>
		<h3><?php _e('Shortcode', 'sv_proven_expert'); ?></h3>
		<pre>[sv_proven_expert]</pre>
		<h3><?php _e('Test Status', 'sv_proven_expert'); ?></h3>
		<div id="sv_preview"><?php
			if(strlen($this->settings['basic']['API_ID']['value']) > 0 && strlen($this->settings['basic']['API_KEY']['value']) > 0){
				echo do_shortcode('[sv_proven_expert]');
			}
		?>
		</div>
		<p><a href="https://search.google.com/structured-data/testing-tool#url=<?php echo urlencode(get_home_url()); ?>">Google Structured Data Testing</a></p>
	</div>
	<form action="#" method="post" id="sv_global_settings">
		<?php
			echo '
			<div class="sv_setting sv_setting_'.$this->settings_default['basic']['API_ID']['type'].'">
				<div class="sv_setting_name">'.$this->settings_default['basic']['API_ID']['name'].'</div>
				<div class="sv_setting_desc">'.$this->settings_default['basic']['API_ID']['desc'].'</div>
				<div class="sv_setting_value"><input type="text" name="basic[API_ID][value]" value="'.$this->settings['basic']['API_ID']['value'].'" /></div>
			</div>';
			echo '
			<div class="sv_setting sv_setting_'.$this->settings_default['basic']['API_KEY']['type'].'">
				<div class="sv_setting_name">'.$this->settings_default['basic']['API_KEY']['name'].'</div>
				<div class="sv_setting_desc">'.$this->settings_default['basic']['API_KEY']['desc'].'</div>
				<div class="sv_setting_value"><input type="text" name="basic[API_KEY][value]" value="'.$this->settings['basic']['API_KEY']['value'].'" /></div>
			</div>';
		?>
		<input type="hidden" name="sv_proven_expert_settings" value="1" />
		<div style="clear:both;"><input type="submit" value="<?php echo _e('Save Settings', 'sv_proven_expert'); ?>" /></div>
	</form>
</div>
<?php
	}
?>