<?php

/**
 * Class mPress_Menu_Wormhole_Walker_Nav_Menu_Edit
 */
class mPress_Menu_Wormhole_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {

	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param array $args Not used.
	 * @param int $id Not used.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		parent::start_el( $output, $item, $depth, $args, $id );

		ob_start();
		// See https://core.trac.wordpress.org/ticket/18584
		do_action( 'wp_nav_menu_item_custom_fields', $item->ID, $item, $depth, $args );
		$replace = ob_get_clean();

		$search = '<p class="description description-wide"';
		$replace .= '<p class="description description-wide"';

		$output = $this->str_replace_last( $search, $replace, $output );
	}

	function str_replace_last( $search, $replace, $str ) {
		if ( ( $pos = strrpos( $str, $search ) ) !== false ) {
			$search_length = strlen( $search );
			$str           = substr_replace( $str, $replace, $pos, $search_length );
		}

		return $str;
	}

}