<?php
class Example_Widget extends WP_Widgets_Fields_API {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'my_widget',
            'description' => 'My Widget is awesome',
        );
        parent::__construct( 'my_widget', 'My Widget', $widget_ops );
    }

    public function fields( $wp_fields ) {
        // Object type: User
        $object_type = 'widget';
        // Object name: n/a
        $object_name = $this->id_base;
        // Form: User Edit Profile
        $form_id = $this->id_base;
        //////////////////////
        // Section: Address //
        //////////////////////
        $section_id   = 'address';
        $section_args = array(
            'title' => __( 'Address', 'my-text-domain' ), // @todo Update text domain
            'form'  => $form_id,
        );
        $wp_fields->add_section( $object_type, $section_id, $object_name, $section_args );
        // Address Line 1
        $field_id   = 'address_1';
        $field_args = array(
            'control' => array(
                'type'    => 'text',
                'section' => $section_id,
                'label'   => __( 'Address 1', 'my-text-domain' ), // @todo Update text domain
            ),
        );
        $wp_fields->add_field( $object_type, $field_id, $object_name, $field_args );
        // Address Line 2
        $field_id   = 'address_2';
        $field_args = array(
            'control' => array(
                'type'    => 'text',
                'section' => $section_id,
                'label'   => __( 'Address 2', 'my-text-domain' ), // @todo Update text domain
            ),
        );
        $wp_fields->add_field( $object_type, $field_id, $object_name, $field_args );
        // City
        $field_id   = 'address_city';
        $field_args = array(
            'control' => array(
                'type'    => 'text',
                'section' => $section_id,
                'label'   => __( 'City', 'my-text-domain' ), // @todo Update text domain
            ),
        );
        $wp_fields->add_field( $object_type, $field_id, $object_name, $field_args );
        // State / Region
        $field_id   = 'address_state';
        $field_args = array(
            'control' => array(
                'type'    => 'text',
                'section' => $section_id,
                'label'   => __( 'State / Region', 'my-text-domain' ), // @todo Update text domain
                // You could use 'select' type instead and then
                // pass in all states in 'choices' option with array( 'TX' => 'Texas' )
            ),
        );
        $wp_fields->add_field( $object_type, $field_id, $object_name, $field_args );
        // Zip / Postal Code
        $field_id   = 'address_zip';
        $field_args = array(
            'control' => array(
                'type'    => 'text',
                'section' => $section_id,
                'label'   => __( 'Zip / Postal Code', 'my-text-domain' ), // @todo Update text domain
            ),
        );
        $wp_fields->add_field( $object_type, $field_id, $object_name, $field_args );
        // Zip / Postal Code
        $field_id   = 'address_country';
        $field_args = array(
            'control' => array(
                'type'    => 'select',
                'section' => $section_id,
                'label'   => __( 'Country', 'my-text-domain' ), // @todo Update text domain
                'choices' => array(
                    'US' => 'United States',
                    'CA' => 'Canada',
                    // Add more here as needed, or use 'text' type instead for freeform
                ),
            ),
        );
        $wp_fields->add_field( $object_type, $field_id, $object_name, $field_args );
    }
    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget
    }
}

add_action( 'widgets_init', function() {
    register_widget( 'Example_Widget' );
} );