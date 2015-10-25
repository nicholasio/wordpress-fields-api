<?php
/**
 * This is an implementation for Fields API for Widgets
 * 
 * @package WordPress
 * @subpackage Fields_API
 */


function fields_api_generate_form( $_this, $return, $instance ) {

	global $wp_fields;

	$screen = $wp_fields->get_screen( 'widget', $_this->id_base );
	if ( $screen ) {
		$sections = $wp_fields->get_sections( 'widget', null, $screen->id );
		if ( !empty( $sections) ) {

			foreach( $sections as $section ) {

				$controls = $wp_fields->get_controls( 'widget', null, $section->id );
				if ( $controls ) {
					$content = $section->get_content();

					if ( $content ) :
						?>
						<h3><?php echo $content; ?></h3>
						<?php foreach( $controls as $control ) : ?>
							<p>
								<?php
									$control->render_content();
								?>
							</p>
						<?php endforeach; ?>
						<?php
					endif;
				}
			}
		}
	}


	if ( ! empty( $content) ) {
		$return = null;
	}

}

add_action( 'in_widget_form', 'fields_api_generate_form', 10, 3);

function fields_api_save_widget_data( $instance, $new_instance, $old_instance, $_this ) {
	//@TODO sanitize the data, the data should come within $new_instance
}

add_action( 'update_callback', 'fields_api_save_widget_data', 10, 4);
