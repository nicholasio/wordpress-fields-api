<?php
/**
 * This is an integration of the Settings API with the Fields API.
 *
 * @package    WordPress
 * @subpackage Fields_API
 */

/**
 * Class WP_Fields_API_Settings_API
 */
class WP_Fields_API_Settings_API {

	public function __construct() {

		// Add hook
		add_action( 'admin_init', array( $this, 'register_settings' ) );

	}

	public function register_settings() {

		/**
		 * @var $wp_fields WP_Fields_API
		 */
		global $wp_fields;

		$sections = $wp_fields->get_sections( 'settings' );

		foreach ( $sections as $section ) {
			if ( ! $section->check_capabilities() ) {
				continue;
			}

			// Get Form
			$form = $section->get_form();

			if ( ! $form ) {
				continue;
			}

			$form_id = $form->id;
			$section_id = $section->id;
			$section_title = $section->label;

			if ( ! $section->display_label ) {
				$section_title = '';
			}

			// Get Setting Controls
			$controls = $section->get_controls();

			if ( $controls ) {
				$added_section = false;

				foreach ( $controls as $control ) {
					$field = $control->get_field();

					if ( empty( $field ) ) {
						continue;
					}

					if ( ! $control->check_capabilities() ) {
						continue;
					}

					if ( ! $added_section ) {
						add_settings_section(
							$section_id,
							$section_title,
							array( $section, 'render_description' ),
							$form_id
						);

						$added_section = true;
					}

					$sanitize_callback = array( $field, 'sanitize' );

					$field_id = $field->id;

					$settings_args = array(
						'fields_api' => true,
						'label_for'  => $field_id,
						'control'    => $control,
					);

					// Add Settings API field
					add_settings_field(
						$field_id,
						$control->label,
						array( $this, 'render_control' ),
						$form_id,
						$section_id,
						$settings_args
					);

					// Register Setting
					register_setting(
						$form_id,
						$field_id,
						$sanitize_callback
					);
				}
			}

		}

	}

	/**
	 * Render control for Settings API
	 *
	 * @param array $settings_args Settings args
	 */
	public function render_control( $settings_args ) {

		if ( empty( $settings_args['fields_api'] ) || empty( $settings_args['control'] ) ) {
			return;
		}

		/**
		 * @var $control WP_Fields_API_Control
		 */
		$control = $settings_args['control'];

		if ( ! $control->check_capabilities() ) {
			return;
		}

		$description = trim( $control->description );

		$control->maybe_render();

		if ( 0 < strlen( $description ) ) {
			?>
			<p class="description"><?php echo wp_kses_post( $description ); ?></p>
			<?php
		}

	}

}