<?php
/**
 * @package    WordPress
 * @subpackage Fields_API
 */

/**
 * Fields API Dropdown Pages Control class.
 *
 * @see WP_Fields_API_Control
 */
class WP_Fields_API_Dropdown_Pages_Control extends WP_Fields_API_Select_Control {

	/**
	 * {@inheritdoc}
	 */
	public $type = 'dropdown-pages';

	/**
	 * @var array Arguments to send to get_pages
	 */
	public $get_args = array();

	/**
	 * @var string Placeholder text for choices
	 */
	public $placeholder_text = '';

	/**
	 * {@inheritdoc}
	 */
	public function choices() {

		$placeholder_text = $this->placeholder_text;

		if ( '' === $placeholder_text ) {
			$placeholder_text = __( '&mdash; Select &mdash;' );
		}

		$choices = array(
			'0' => $placeholder_text,
		);

		$args = $this->get_args;

		$pages = get_pages( $args );

		$choices = $this->get_page_choices_recurse( $choices, $pages );

		return $choices;

	}

	/**
	 * Recursively build choices array the full depth
	 *
	 * @param array     $choices List of choices.
	 * @param WP_Post[] $pages   List of pages.
	 * @param int       $depth   Current depth.
	 * @param int       $parent  Current parent page ID.
	 *
	 * @return array
	 */
	public function get_page_choices_recurse( $choices, $pages, $depth = 0, $parent = 0 ) {

		$pad = str_repeat( '&nbsp;', $depth * 3 );

		foreach ( $pages as $page ) {
			if ( $parent == $page->post_parent ) {
				$title = $page->post_title;

				if ( '' === $title ) {
					/* translators: %d: ID of a post */
					$title = sprintf( __( '#%d (no title)' ), $page->ID );
				}

				/**
				 * Filter the page title when creating an HTML drop-down list of pages.
				 *
				 * @since 3.1.0
				 *
				 * @param string $title Page title.
				 * @param object $page  Page data object.
				 */
				$title = apply_filters( 'list_pages', $title, $page );

				$choices[ $page->ID ] = $pad . $title;

				$choices = $this->get_page_choices_recurse( $choices, $pages, $depth + 1, $page->ID );
			}
		}

		return $choices;

	}

}