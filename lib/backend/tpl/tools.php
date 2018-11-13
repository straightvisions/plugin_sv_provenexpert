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
<?php
static::$log->create->log( $this )
             ->set_title( 'Success Log 1' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 1 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Success Log 2' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 1 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Info Log 1' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 2 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Info Log 2' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 2 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Warning Log 1' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 3 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Warning Log 2' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 3 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Error Log 1' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 4 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Error Log 2' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 4 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Critical Log 1' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 5 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
static::$log->create->log( $this )
             ->set_title( 'Critical Log 2' )
             ->set_desc_public( 'Public Description' )
             ->set_desc_admin( 'Admin Description' )
             ->set_state( 5 )
             ->set_file_path( $this->get_path_lib( 'backend/tpl/tools.php' ) );
?>

