<?php
// Info vars
$rating_stars		= $this->get_parent()->api->get_rating_stars( $summary->ratingValue );
?>

<div class="<?php echo $this->get_prefix() . ' ' . $this->get_prefix( 'simple' ); ?>">
    <div class="<?php echo $this->get_prefix( 'stars' ); ?>">
		<?php echo $rating_stars; ?>
    </div>
    <div class="<?php echo $this->get_prefix( 'reviews' ); ?>">
        <a href="<?php echo $profile->profileUrl; ?>" target="_blank">
		    <?php echo $summary->reviewCount . ' ' . __( 'Bewertungen', 'sv_provenexpert' ) . 'auf ProvenExpert.com'; ?>
        </a>
    </div>
</div>


