<?php
	if(isset($_POST['clear_cache'])) {
		delete_transient( 'sv_provenexpert' );
	}
?>
<h3 class="divider"><i class="fas fa-broom"></i> <?php _e('Clear the cache', $this->get_prefix()); ?></h3>
<p><?php _e('Click on the button, to clear the cache.', $this->get_prefix()); ?></p>
<form method="post">
	<button name="clear_cache" type="submit" class="sv_btn"><i class="fas fa-broom"></i> <?php _e('Clear cache', $this->get_prefix()); ?></button>
</form>

