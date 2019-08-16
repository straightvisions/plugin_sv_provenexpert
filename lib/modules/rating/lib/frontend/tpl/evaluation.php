<?php
// Info vars
$latest_ratings          = array();

foreach ( get_object_vars( $ratings ) as $rating ) {
    if ( isset( $rating->feedback ) && round( $rating->ratingValue ) >= 4 ) {
        $latest_ratings[] = $rating;
    }
}

$cache_date			    = current_time( 'd.m.Y', true ); //@todo Replace with real cache date
$rating_text		    = $this->get_parent()->api->get_rating_text( $summary->ratingValue );
$customer_service_text  = $this->get_parent()->api->get_rating_text( $rating->ratings->category_5 );
$price_performance_text = $this->get_parent()->api->get_rating_text( $rating->ratings->category_6 );
$rating_stars		    = $this->get_parent()->api->get_rating_stars( $summary->ratingValue );
$rating_percentage 	    = $this->get_parent()->api->get_rating_percentage( $summary->ratingValue );
$icon_logo			    = $this->get_parent()->icon->get( 'logo_white' );
$icon_user				= $this->get_parent()->icon->get( 'user' );
?>

<div class="<?php echo $this->get_prefix() . ' ' . $this->get_prefix( 'evaluation' ); ?>">
    <div class="<?php echo $this->get_prefix( 'wrapper' ); ?>">
        <div class="<?php echo $this->get_prefix( 'header' ); ?>">
            <div class="<?php echo $this->get_prefix( 'logo' ); ?>">
				<a href="<?php echo $profile->profileUrl; ?>" target="_blank">
					<?php echo $icon_logo; ?>
				</a>
            </div>
            <div class="<?php echo $this->get_prefix( 'desc' ); ?>">
                <?php _e( 'Kundenbewertungen', 'sv_provenexpert' ); ?>
            </div>
			<div class="<?php echo $this->get_prefix( 'date' ); ?>">
				<?php echo $cache_date; ?>
			</div>
			<div class="<?php echo $this->get_prefix( 'more_info' ); ?>">
				<a href="<?php echo $profile->profileUrl; ?>" target="_blank">
					<?php _e( 'Mehr Info', 'sv_provenexpert' ); ?>
				</a>
			</div>
        </div>
        <div class="<?php echo $this->get_prefix( 'body' ); ?>">
			<?php // @todo Replace with original image ?>
            <div class="<?php echo $this->get_prefix( 'quality_badge' ); ?>">
				<a href="<?php echo $profile->profileUrl; ?>" target="_blank">
					<img src="https://www.provenexpert.com/images/de-de/widget/circle/widget.png?t=1565535425497" alt="Qualitätssiegel">
				</a>
            </div>
			<div class="<?php echo $this->get_prefix( 'stars_and_text' ); ?>">
				<div class="<?php echo $this->get_prefix( 'compare' ); ?>">
					<?php echo number_format( $summary->ratingValue, 2 ) . ' ' . __( 'von', 'sv_provenexpert' ) . ' 5';?>
				</div>
				<div class="<?php echo $this->get_prefix( 'stars' ); ?>">
					<?php echo $rating_stars; ?>
				</div>
				<div class="<?php echo $this->get_prefix( 'text' ); ?>">
					<?php echo $rating_text; ?>
				</div>
				<div class="<?php echo $this->get_prefix( 'reviews' ); ?>">
					<?php echo $summary->reviewCount . ' ' . __( 'Bewertungen', 'sv_provenexpert' ); ?>
				</div>
			</div>
			<div class="<?php echo $this->get_prefix( 'recommendation' ); ?>">
				<?php echo $icon_user; ?>
				<div><?php echo $rating_percentage . '%&nbsp;'; ?></div>
				<div><?php _e( 'Empfehlungen', 'sv_provenexpert' ); ?></div>
			</div>
        </div>
        <div class="<?php echo $this->get_prefix( 'footer' ); ?>">
			<div class="<?php echo $this->get_prefix( 'latest_comment' ); ?>">
				<div class="<?php echo $this->get_prefix( 'comment' ); ?>">
					<?php echo $latest_ratings[0]->feedback; ?>
				</div>
			</div>
        </div>
    </div>
</div>