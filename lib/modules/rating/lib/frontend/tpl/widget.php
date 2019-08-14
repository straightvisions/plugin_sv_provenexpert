<?php
$settings = false;

foreach ( $instance as $key => $setting ) {
	$settings .=  $key . '="' . $setting . '" ';
}

echo do_shortcode( '[sv_provenexpert is_widget="1" ' . $settings . ']' );