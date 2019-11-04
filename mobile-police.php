<?php
/*
Plugin Name: Mobile Police
Plugin URI: http://laxusgee.com/products/mobile-police/
Description: Detects and redirects the browser for mobile device, including a widget and shortcode.
Version: 1.0.0
Author: Medunoye Laxus Gbenga
Author URI: http://laxusgee.com/
Text Domain: laxusgee_mobilepolice
License: GPL2
*/

class laxusgee_Mobilepolice{
    public function __construct(){
        register_activation_hook( __FILE__, array( $this,'activate') );
        register_deactivation_hook( __FILE__, array( $this,'deactivate') );
        do_action('laxusgee_mobilepolice_init');
        
        
        add_action('init', array($this, 'init'));
        add_action('admin_init', array($this,'admin_init'));
        add_action('admin_menu', array($this,'admin_menu'));
        add_action('widgets_init', array( $this, 'widgets_init' ));

        add_shortcode("mobilepolice", array( $this, 'laxusgee_mobilepolice_shortcode' ));
    }

    public function init(){}

    public function widgets_init(){
        register_widget( 'laxusgeeMobilepoliceWidget' );
        add_filter('widget_text', 'do_shortcode');
    }

    public function admin_init(){
        $this->register_settings();
    }

    public function admin_menu(){
        add_menu_page(
            'laxusgee_mobilepolice',
            'mobilepolice',
            'manage_options',
            'laxusgee_mobilepolice_options',
            array($this,'settings_page')
        );
    }

    public function settings_page(){
        include('settings.php');
    }

    public function register_settings(){
        register_setting( 'laxusgee_mobilepolice_options', 'laxusgee_mobilepolice_options' );

        add_settings_section(
            'laxusgee_mobilepolice_options_section',
            __( 'Settings', 'laxusgee_mobilepolice' ),
            array($this,'laxusgee_mobilepolice_settings_section_callback'),
            'laxusgee_mobilepolice_options'
        );

        add_settings_field(
            'laxusgee_mobilepolice_options_android',
            __( 'Android', 'laxusgee_mobilepolice' ),
            array($this,'laxusgee_mobilepolice_android_field_callback'),
            'laxusgee_mobilepolice_options',
            'laxusgee_mobilepolice_options_section'
        );

        add_settings_field(
            'laxusgee_mobilepolice_options_iphone',
            __( 'Iphone', 'laxusgee_mobilepolice' ),
            array($this,'laxusgee_mobilepolice_iphone_field_callback'),
            'laxusgee_mobilepolice_options',
            'laxusgee_mobilepolice_options_section'
        );

        add_settings_field(
            'laxusgee_mobilepolice_options_default',
            __( 'Default', 'laxusgee_mobilepolice' ),
            array($this,'laxusgee_mobilepolice_default_field_callback'),
            'laxusgee_mobilepolice_options',
            'laxusgee_mobilepolice_options_section'
        );

    }

    function laxusgee_mobilepolice_shortcode($atts){

        $ignore = explode(',', $atts['ignore']);

        $options = get_option( 'laxusgee_mobilepolice_options' );

        ?>
        <script type="text/javascript"> // <![CDATA[

            //iPhone Version:
            if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {
                <?php if(!in_array('iphone', $ignore))
                    echo 'window.location = "'.$options['iphone'].'"';
                ?>
            }
            //Android Version:
            else if(navigator.userAgent.match(/android/i)) {
                <?php if(!in_array('android', $ignore))
                    echo 'window.location = "'.$options['android'].'"';
                ?>
            }
            //Blackberry Version:
            else if(navigator.userAgent.match(/blackberry/i)) {
                <?php if(!in_array('blackberry', $ignore))
                echo 'window.location = "'.$options['blackberry'].'"';
                ?>
            }

            //Default:
            else{
                window.location = "<?= $options['default'] ?>";
            }
        </script>

        <?php
    }

    function laxusgee_mobilepolice_settings_section_callback(  ) {
        //echo __( 'Mobile Devices', 'laxusgee_mobilepolice' );
    }

    function laxusgee_mobilepolice_android_field_callback(  ) {
        $options = get_option( 'laxusgee_mobilepolice_options' );
        ?><input type='text' name='laxusgee_mobilepolice_options[android]' value='<?php echo $options['android']; ?>'><?php
    }

    function laxusgee_mobilepolice_iphone_field_callback(  ) {
        $options = get_option( 'laxusgee_mobilepolice_options' );
        ?><input type='text' name='laxusgee_mobilepolice_options[iphone]' value='<?php echo $options['iphone']; ?>'><?php
    }

    function laxusgee_mobilepolice_default_field_callback(  ) {
        $options = get_option( 'laxusgee_mobilepolice_options' );
        ?><input type='text' name='laxusgee_mobilepolice_options[default]' value='<?php echo $options['default']; ?>'><?php
    }

    public function set_default_options(){
        if(! get_option('laxusgee_mobilepolice_options')){
            $options = array(
                'android' => '',
                'iphone' => '',
                'default' => '#'
            );
            add_option('laxusgee_mobilepolice_options', $options);
        }
    }

    public function show($attr = null)
    {
        $out = "xxx";
        $out = apply_filters('laxusgee_mobilepolice_show',$out);
        echo $out;
    }
    
    public function activate(){
        $this->set_default_options();
        flush_rewrite_rules();
    }
    
    public function deactivate(){
        flush_rewrite_rules();
    }

}
include('widget.php');

$wpMobilePolice = new laxusgee_Mobilepolice();