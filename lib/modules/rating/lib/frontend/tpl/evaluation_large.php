<?php
// Info vars
$latest_rating          = new stdClass();
$latest_rating->created = 631152000;

foreach ( get_object_vars( $ratings ) as $rating ) {
    if (
        isset( $rating->feedback )
        && round( $rating->ratingValue ) >= 4
        && $rating->created >= $latest_rating->created
    ) {
        $latest_rating = $rating;
    }
}

$cache_date			    = current_time( 'd.m.Y', true ); //@todo Replace with real cache date
$rating_text		    = $this->get_parent()->api->get_rating_text( $summary->ratingValue );
$customer_service_text  = $this->get_parent()->api->get_rating_text( $rating->ratings->category_5 );
$price_performance_text = $this->get_parent()->api->get_rating_text( $rating->ratings->category_6 );
$rating_stars		    = $this->get_parent()->api->get_rating_stars( $summary->ratingValue );
$rating_percentage 	    = $this->get_parent()->api->get_rating_percentage( $summary->ratingValue );
$icon_logo			    = $this->get_parent()->icon->get( 'logo_white' );
$icon_check				= $this->get_parent()->icon->get( 'check' );
$icon_user				= $this->get_parent()->icon->get( 'user' );
?>

<div class="<?php echo $this->get_prefix() . ' ' . $this->get_prefix( 'evaluation_large' ); ?>">
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
        </div>
        <div class="<?php echo $this->get_prefix( 'body' ); ?>">
            <div class="<?php echo $this->get_prefix( 'avatar' ); ?>">
				<a href="<?php echo $profile->profileUrl; ?>" target="_blank">
                	<img src="<?php echo $profile->avatarUrl; ?>" alt="<?php echo $profile->company; ?>'s Avatar">
				</a>
            </div>
            <div class="<?php echo $this->get_prefix( 'info' ); ?>">
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
						<?php echo $summary->reviewCount . ' ' . __( 'Kundenbewertungen', 'sv_provenexpert' ); ?>
                    </div>
                </div>
                <div class="<?php echo $this->get_prefix( 'recommendation' ); ?>">
					<?php echo $icon_user; ?>
                    <div><?php echo $rating_percentage . '%&nbsp;'; ?></div>
                    <div><?php _e( 'Empfehlungen', 'sv_provenexpert' ); ?></div>
                </div>
                <div class="<?php echo $this->get_prefix( 'service' ); ?>">
                    <div class="<?php echo $this->get_prefix( 'customer_service' ); ?>">
						<?php echo $icon_check; ?>
                        <div>
							<div><?php _e( 'Kundenservice', 'sv_provenexpert' ); ?></div>
							<div><?php echo $customer_service_text . ' (' . number_format( $rating->ratings->category_5, 2 ) . ')'; ?></div>
						</div>
                    </div>
                    <div class="<?php echo $this->get_prefix( 'price_performance' ); ?>">
						<?php echo $icon_check; ?>
                        <div>
							<div><?php _e( 'Preis / Leistung', 'sv_provenexpert' ); ?></div>
							<div><?php echo $price_performance_text . ' (' . number_format( $rating->ratings->category_6, 2 ) . ')'; ?></div>
						</div>
                    </div>
                </div>
            </div>
            <div class="<?php echo $this->get_prefix( 'latest_comments' ); ?>">
                <?php
                    for ( $i = 0; $i < 3; $i++ ) {
                    ?>
                    <div class="
                    <?php
                        echo $this->get_prefix( 'comment' );
                        echo $i === 0 ? ' active' : '';
                    ?>
                    " data-rating="<?php echo $i + 1; ?>">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</div>
                    <?php
                    }
                ?>
            </div>
        </div>
        <div class="<?php echo $this->get_prefix( 'footer' ); ?>">
			<div class="<?php echo $this->get_prefix( 'title' ); ?>">
				<?php _e( 'Top-Kompetenzen:' ); ?>
			</div>
			<div class="<?php echo $this->get_prefix( 'competences' ); ?>">
				<div class="<?php echo $this->get_prefix( 'competence' ); ?>">
					<?php
					echo $icon_check;
					_e( 'Top-Kompetenz  1' );
					?>
				</div>
				<div class="<?php echo $this->get_prefix( 'competence' ); ?>">
					<?php
					echo $icon_check;
					_e( 'Top-Kompetenz  2' );
					?>
				</div>
				<div class="<?php echo $this->get_prefix( 'competence' ); ?>">
					<?php
					echo $icon_check;
					_e( 'Top-Kompetenz  3' );
					?>
				</div>
			</div>
			<div class="<?php echo $this->get_prefix( 'more_info' ); ?>">
				<a href="<?php echo $profile->profileUrl; ?>" target="_blank">
					<?php _e( 'Mehr Info', 'sv_provenexpert' ); ?>
				</a>
			</div>
        </div>
    </div>
</div>