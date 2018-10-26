<?php
	if(!defined( 'WP_UNINSTALL_PLUGIN')){
		exit();
	}

	delete_option('sv_proven_expert');
	delete_option('widget_sv_proven_expert_widget');
	delete_transient('sv_proven_expert');
?>