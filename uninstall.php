<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_transient( 'sv_provenexpert' );
