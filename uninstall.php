<?php
	if(!defined( 'WP_UNINSTALL_PLUGIN')){
		exit();
	}

	delete_option( 'sv_provenexpert' );
	delete_option( 'widget_sv_provenexpert_widget' );
	delete_transient( 'sv_provenexpert' );
?>