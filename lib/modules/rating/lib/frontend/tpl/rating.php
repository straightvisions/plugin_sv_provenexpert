<div class="<?php echo $this->get_prefix(); ?>">
	<div class="<?php echo $this->get_prefix( 'wrapper' ); ?>">
		<div class="<?php echo $this->get_prefix( 'header' ); ?>">
			<span class="<?php echo $this->get_prefix( 'company' ); ?>">
				<?php echo $profile->company; ?>
			</span>
			<div class="<?php echo $this->get_prefix( 'logo' ); ?>">
				<?php echo $this->icon_logo; ?>
			</div>
			<span class="<?php echo $this->get_prefix( 'desc' ); ?>">
				<?php _e( 'Kundenbewertungen', 'sv_provenexpert' ); ?>
			</span>
		</div>
		<div class="<?php echo $this->get_prefix( 'body' ); ?>">
			<div class="<?php echo $this->get_prefix( 'stars' ); ?>">
				<?php
				for( $i = 0; $i < $summary->ratingValue; $i++ ) {
					echo $this->icon_star;
				}
				?>
			</div>
			<span class="<?php echo $this->get_prefix( 'text' ); ?>">
				<?php
				switch ( round( $summary->ratingValue ) ) {
					case 1:
						_e( 'Mangelhaft', 'sv_provenexpert' );
						break;
					case 2:
						_e( 'Ausreichend', 'sv_provenexpert' );
						break;
					case 3:
						_e( 'Zufriedenstellend', 'sv_provenexpert' );
						break;
					case 4:
						_e( 'Gut', 'sv_provenexpert' );
						break;
					case 5:
						_e( 'Sehr Gut', 'sv_provenexpert' );
						break;
				}
				?>
			</span>
			<span class="<?php echo $this->get_prefix( 'recommendation' ); ?>">
				<strong><?php echo round( ( $summary->ratingValue / 5 ) * 100 ) . '%&nbsp;'; ?></strong>
				<?php _e( 'Empfehlungen', 'sv_provenexpert' ); ?>
			</span>
		</div>
		<div class="<?php echo $this->get_prefix( 'footer' ); ?>">
			<span class="<?php echo $this->get_prefix( 'reviews' ); ?>">
				<?php echo $summary->reviewCount . ' ' . __( 'Kundenbewertungen', 'sv_provenexpert' ); ?>
			</span>
			<div class="<?php echo $this->get_prefix( 'meta' ); ?>">
				<span class="<?php echo $this->get_prefix( 'date' ); ?>">
					<?php echo current_time( 'd.m.Y', true ); ?>
				</span>
				<span class="<?php echo $this->get_prefix( 'more_info' ); ?>">
					<a href="<?php echo $profile->profileUrl; ?>" target="_blank">
						<?php _e( 'Mehr Infos', 'sv_provenexpert' ); ?>
					</a>
				</span>
			</div>
		</div>
	</div>
</div>


