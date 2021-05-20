<?php
	$alignment = $script->get_parent()->get_setting( 'alignment' )->run_type()->get_data();
	
	switch ( $alignment ) {
		case 'left':
			$alignment = 'flex-start';
			break;
		case 'right':
			$alignment = 'flex-end';
			break;
	}
?>


.sv_provenexpert {
	align-items: <?php echo $alignment; ?>;
}