<?php

class laxusgeeMobilepoliceWidget extends WP_Widget{
    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct(
            'laxusgee_mobilepolice', // Base ID
            __( 'Mobile Arrest', 'laxusgee_mobilepolice' ), // Name
            array( 'description' => __( 'Mobile Arrest', 'laxusgee_mobilepolice' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {
        $wpOneLiners = new laxusgee_Mobilepolice();
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        $wpOneLiners->show($instance);
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $defaults = array( 'title' => '', 'display_as_link' => false );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'laxusgee_mobilepolice' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'display_as_link' ); ?>"><?php _e( 'Display as permalink', 'laxusgee_mobilepolice' );?></label>
            <input class="checkbox" type="checkbox" <?php checked( $instance['display_as_link'] ); ?> id="<?php echo $this->get_field_id( 'display_as_link' ); ?>" name="<?php echo $this->get_field_name( 'display_as_link' ); ?>" />
        </p>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['display_as_link'] = $new_instance['display_as_link'] == 'on';

        return $instance;
    }
}