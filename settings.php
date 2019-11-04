<div class="wrap">
    <h2><?php _e( 'Mobilepolice', 'laxusgee_mobilepolice' );?></h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'laxusgee_mobilepolice_options' ); ?>
        <?php do_settings_sections( 'laxusgee_mobilepolice_options' );?>
        <?php submit_button(); ?>
    </form>
</div>