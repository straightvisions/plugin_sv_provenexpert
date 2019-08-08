<?php
// Info vars
$cache_date			= current_time( 'd.m.Y', true ); //@todo Replace with real cache date
$rating_text		= $this->get_parent()->api->get_rating_text( $summary->ratingValue );
$rating_stars		= $this->get_parent()->api->get_rating_stars( $summary->ratingValue );
$rating_percentage 	= $this->get_parent()->api->get_rating_percentage( $summary->ratingValue );
$icon_logo			= $this->get_parent()->icon->get( 'logo' );

$latest_rating      = array( 'created' => 631152000 );

foreach ( get_object_vars( $ratings ) as $rating ) {
    if (
        isset( $rating->feedback )
        && round( $rating->ratingValue ) >= 4
        && $rating->created >= $latest_rating->created
    ) {
        $latest_rating = $rating;
    }
}
?>

<div class="<?php echo $this->get_prefix() . ' ' . $this->get_prefix( 'line' ); ?>">
	<div class="<?php echo $this->get_prefix( 'wrapper' ); ?>">
		<div class="<?php echo $this->get_prefix( 'logo' ); ?>">
			<?php echo $icon_logo; ?>
		</div>
		<div class="<?php echo $this->get_prefix( 'reviews' ); ?>">
			<?php echo $summary->reviewCount . ' ' . __( 'Kundenbewertungen', 'sv_provenexpert' ); ?>
		</div>
		<div class="<?php echo $this->get_prefix( 'stars_and_text' ); ?>">
			<div class="<?php echo $this->get_prefix( 'stars' ); ?>">
				<?php echo $rating_stars; ?>
			</div>
			<div class="<?php echo $this->get_prefix( 'text' ); ?>">
				<?php echo $rating_text; ?>
			</div>
		</div>
		<div class="<?php echo $this->get_prefix( 'recommendation' ); ?>">
			<strong><?php echo $rating_percentage . '%&nbsp;'; ?></strong>
			<?php _e( 'Empfehlungen', 'sv_provenexpert' ); ?>
		</div>
		<div class="<?php echo $this->get_prefix( 'last_comment' ); ?>">
			<div class="<?php echo $this->get_prefix( 'comment' ); ?>">
				<?php echo $latest_rating->feedback; ?>
			</div>
		</div>
		<div class="<?php echo $this->get_prefix( 'more_info' ); ?>">
			<a href="<?php echo $profile->profileUrl; ?>" target="_blank">
				<?php _e( 'Mehr Infos', 'sv_provenexpert' ); ?>
			</a>
		</div>
	</div>
</div>

