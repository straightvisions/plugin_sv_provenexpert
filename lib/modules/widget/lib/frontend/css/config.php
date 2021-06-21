<?php
	$alignment = $script->get_parent()->get_setting( 'alignment' )->get_data();

	$alignment_css = false;
	switch ( $alignment ) {
		case 'left':
			$alignment_css = 'flex-start';
			break;
		case 'right':
			$alignment_css = 'flex-end';
			break;
	}

	if($alignment_css){
		echo '
			.sv_provenexpert {
				align-items: test'.$alignment_css.';
			}
		';
	}