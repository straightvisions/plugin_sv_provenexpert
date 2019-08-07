<?php
if ( current_user_can( 'activate_plugins' ) ) {
	?>
	<div class="sv_section_description"><?php echo $module->get_section_desc(); ?></div>
	<div class="sv_setting_flex">
		<?php
		echo $module->get_setting( 'api_id' )->run_type()->form();
		echo $module->get_setting( 'api_key' )->run_type()->form();
		?>
	</div>
	<?php
	$api_id 	= $module->get_setting( 'api_id' )->run_type()->get_data();
	$api_key 	= $module->get_setting( 'api_key' )->run_type()->get_data();
	
	if ( ! empty( $api_id ) && ! empty( $api_key ) ) {
		$request_url 		= $module->get_request_url( 'rating', 'get' );
		$request_args 		= array(
			'method' 	=> 'POST',
			'headers' 	=> array(
				'Authorization' => 'Basic ' . base64_encode( $api_id . ':' . $api_key ),
			),
		);
		
		$remote_get = $module->get_root()::$remote_get->create( $module )
													  ->set_request_url( $request_url )
													  ->set_args( $request_args );
		
		$response_data = json_decode( $remote_get->get_response_body() );
		
		if ( isset( $response_data->status ) && $response_data->status === 'success' ) {
			echo 'Sie wurden ' . count( get_object_vars( $response_data->ratings ) ) . ' mal bewertet.<br><br>';
			
			foreach ( $response_data->ratings as $rating ) {
				$user = empty( $rating->user->name ) ? 'Unbekannt' : $rating->user->name;
				
				echo '<strong>' . $user . '</strong> hat Sie mit <strong>' . $rating->ratingValue . '</strong> Sternen bewertet.<br>';
			}
		}
	}
}