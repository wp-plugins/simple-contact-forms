<?php
class scf_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'scf_widget', 

            // Widget name will appear in UI
            __('Simple Contact Forms', 'scf_enquiry_form'), 

            // Widget description
            array( 'description' => __( 'Plugin Widget', 'scf_enquiry_form' ), ) 
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {

        $title = apply_filters( 'Simple Contact Forms', $instance['form_title'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if ( ! empty( $title ) )
            $title = '<h2>'. $title . '</h2>';

        // This is where you run the code and display the output
        $options = array(
            'button'        => $instance['button'] ? true : false,
            'form_title'    => $instance['form_title'],
            'btn_text'      => $instance['button_text'],
            'form_collapse' => $instance['form_collapse'] ? true : false,
            'email_subject' => $instance['email_subject'],
        );
        simple_contact_form($options);
        
        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {

        $title = isset( $instance[ 'form_title' ] ) ? $instance[ 'form_title' ] : __( 'Enquire now!', 'scf_enquiry_form' );
        $button = isset( $instance[ 'button' ] ) ? $instance[ 'button' ] : false;
        $button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : __( 'Get in touch!', 'scf_enquiry_form' );
        $form_collapse = isset( $instance[ 'form_collapse' ] ) ? $instance[ 'form_collapse' ] : false;
        $email_subject = isset( $instance[ 'email_subject' ] ) ? $instance[ 'email_subject' ] : __( 'Website Enquiry', 'scf_enquiry_form' );

        // Widget admin form
        ?>
            <script>
            showHideBtn = function(ev) {

                if( ev.checked == true ) {
                    document.getElementById('button_settings').style.display = 'block';
                } else if( ev.checked == false ) {
                    document.getElementById('button_settings').style.display = 'none';
                }

            }
            </script>
            <p>
                <label for="<?php echo $this->get_field_id( 'form_title' ); ?>"><?php _e( 'Form Title:' ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'form_title' ); ?>" name="<?php echo $this->get_field_name( 'form_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e( 'Include button?:' ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" onchange="showHideBtn(this)" type="checkbox" <?php checked($button, 'on'); ?> />
            </p>
            <div id="button_settings" style="display: <?= $button ? 'block' : 'none' ?>;">
                <p>
                    <label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text:' ); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'form_collapse' ); ?>"><?php _e( 'Collapse form?:' ); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id( 'form_collapse' ); ?>" name="<?php echo $this->get_field_name( 'form_collapse' ); ?>" type="checkbox" <?php checked($form_collapse, 'on'); ?> />
                </p>
            </div>
            <p>
                <label for="<?php echo $this->get_field_id( 'email_subject' ); ?>"><?php _e( 'Email Subject:' ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'email_subject' ); ?>" name="<?php echo $this->get_field_name( 'email_subject' ); ?>" type="text" value="<?php echo esc_attr( $email_subject ); ?>" />
            </p>
        <?php 
    }
	
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['form_title'] = ( ! empty( $new_instance['form_title'] ) ) ? strip_tags( $new_instance['form_title'] ) : '';
        $instance['button'] = $new_instance['button'];
        $instance['button_text'] = $new_instance['button_text'];
        $instance['form_collapse'] = $new_instance['form_collapse'];
        $instance['email_subject'] = $new_instance['email_subject'];
        return $instance;

    }

} // Class scf_widget ends here

register_widget( 'scf_widget' );
