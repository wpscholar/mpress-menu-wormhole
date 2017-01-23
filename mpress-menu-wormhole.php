<?php
/*
 * Plugin Name: mPress Menu Wormhole
 * Plugin URI: https://wpscholar.com/wordpress-plugins/mpress-menu-wormhole/
 * Description: Easily add an existing menu within another WordPress menu.
 * Author: Micah Wood
 * Author URI: https://wpscholar.com
 * Version: 1.0
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright 2013-2017 by Micah Wood - All rights reserved.
 */

/**
 * Class mPress_Menu_Wormhole
 */
class mPress_Menu_Wormhole {

	public static $instance;

	protected static $action = 'add_wormhole';

	private function __construct() {
		self::$instance = $this;
		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'wp_update_nav_menu_item', array( $this, 'wp_update_nav_menu_item' ), 10, 3 );
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'wp_edit_nav_menu_walker' ) );
		} else {
			add_action( 'wp_nav_menu_objects', array( $this, 'wp_nav_menu_objects' ) );
			add_filter( 'walker_nav_menu_start_el', array( $this, 'walker_nav_menu_start_el' ), 10, 4 );
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			add_action( 'wp_ajax_' . self::$action, array( $this, 'do_ajax' ) );
		}
	}

	public static function get_instance() {
		return isset( self::$instance ) ? self::$instance : new self();
	}

	function admin_init() {
		global $pagenow;
		if ( 'nav-menus.php' === $pagenow ) {
			$title = __( 'Navigation Menus', 'mpress-menu-wormhole' );
			add_meta_box( 'taxonomy-nav_menu', $title, array( $this, 'show_metabox' ), 'nav-menus', 'side', 'low' );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		}
	}

	function show_metabox() {
		include( dirname( __FILE__ ) . '/views/view-metabox.php' );
	}

	function admin_enqueue_scripts() {
		$prefix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script(
			'mpress-menu-wormhole',
			plugins_url( "js/jquery.wormhole{$prefix}.js", __FILE__ ),
			array( 'jquery' )
		);
		wp_localize_script(
			'mpress-menu-wormhole',
			'mPressMenuWormhole',
			array(
				'action' => self::$action,
				'nonce'  => wp_create_nonce( self::$action )
			)
		);
	}

	public function do_ajax() {
		if ( check_ajax_referer( self::$action, 'nonce' ) && current_user_can( 'edit_theme_options' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/nav-menu.php' );
			$menu_ids = filter_input( INPUT_POST, 'menus', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
			if ( ! empty( $menu_ids ) ) {
				$item_ids   = array();
				$menu_items = array();
				foreach ( $menu_ids as $menu_id ) {
					$menu_id = absint( $menu_id );
					if ( is_nav_menu( $menu_id ) ) {
						$menu           = wp_get_nav_menu_object( $menu_id );
						$menu_item_data = array(
							'menu-item-title'     => $menu->name,
							'menu-item-type'      => 'taxonomy',
							'menu-item-url'       => '#',
							'menu-item-object'    => 'nav_menu',
							'menu-item-object-id' => $menu->term_id,
						);
						$menu_item      = wp_update_nav_menu_item( 0, 0, $menu_item_data );
						if ( ! is_wp_error( $menu_item ) ) {
							$item_ids[] = $menu_item;
						}
					}
				}
				foreach ( $item_ids as $menu_item_id ) {
					$menu_obj = get_post( $menu_item_id );
					if ( ! empty( $menu_obj->ID ) ) {
						$menu_obj        = wp_setup_nav_menu_item( $menu_obj );
						$menu_obj->label = $menu_obj->title; // don't show "(pending)" in ajax-added items
						$menu_items[]    = $menu_obj;
					}
				}
				if ( $menu_items ) {
					$class = apply_filters( 'wp_edit_nav_menu_walker', 'Walker_Nav_Menu_Edit', 0 );
					$args  = array( 'walker' => new $class );
					echo walk_nav_menu_tree( $menu_items, 0, (object) $args );
				}
			}
		} else {
			die( '-1' );
		}
		exit;
	}

	function walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
		if ( 'taxonomy' === $item->type && 'nav_menu' === $item->object ) {
			if ( $menu = wp_get_nav_menu_object( $item->object_id ) ) {
				global $wp_filter;
				$filters = isset( $wp_filter['wp_nav_menu_args'] ) ? $wp_filter['wp_nav_menu_args'] : false;
				remove_all_filters( 'wp_nav_menu_args' );

				$url = get_post_meta( $item->ID, '_menu_item_url', true );
				if ( ! empty( $url ) ) {
					$url = esc_url( $url );
				} else {
					// Prevents default redirection on click
					$url = 'javascript:';
				}
				$item_output = "<a class='mpress-nested-menu-link' href='{$url}'>{$item->title}</a>";
				$item_output .= wp_nav_menu(
					array(
						'menu'        => $menu->term_id,
						'container'   => false,
						'menu_id'     => $args->menu_id,
						'menu_class'  => 'sub-menu mpress-nested-sub-menu',
						'echo'        => false,
						'before'      => $args->before,
						'after'       => $args->after,
						'link_before' => $args->link_before,
						'link_after'  => $args->link_after,
						'items_wrap'  => $args->items_wrap,
						'depth'       => $args->depth,
						'walker'      => $args->walker,
					)
				);
				if ( $filters ) {
					$wp_filter['wp_nav_menu_args'] = $filters;
				}
			}
		}

		return $item_output;
	}

	public function wp_nav_menu_objects( $menu_items ) {
		foreach ( $menu_items as $index => $menu_item ) {
			if ( 'nav_menu_item' === $menu_item->post_type && 'nav_menu' === $menu_item->object && 'taxonomy' === $menu_item->type ) {
			    $menu = wp_get_nav_menu_object( $menu_item->object_id );
				$menu_items[ $index ]->classes[] = 'mpress-nested-menu';
				if ( $menu && ! empty( $menu->slug ) ) {
					$menu_items[ $index ]->classes[] = 'mpress-nested-menu-' . $menu->slug;
				}
			}
		}

		return $menu_items;
	}

	/**
	 * Overrides the admin nav menu walker
	 *
	 * @return string
	 */
	function wp_edit_nav_menu_walker() {
		require_once plugin_dir_path( __FILE__ ) . 'inc/walker-nav-menu-edit.php';
		add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, 'render_menu_item_edit_fields' ), 10, 2 );

		// We override walker on the default priority of 10
		return 'mPress_Menu_Wormhole_Walker_Nav_Menu_Edit';
	}

	/**
	 * Saves our menu item URL
	 *
	 * @param $menu_id
	 * @param $menu_item_id
	 * @param $args
	 */
	public function wp_update_nav_menu_item( $menu_id, $menu_item_id, $args ) {
		if ( 'nav_menu' === $args['menu-item-object'] && 'taxonomy' === $args['menu-item-type'] ) {
			if ( isset( $_POST['menu-item-url'] ) && isset( $_POST['menu-item-url'][ $menu_item_id ] ) ) {
				$url = esc_url_raw( $_POST['menu-item-url'][ $menu_item_id ] );
				update_post_meta( $menu_item_id, '_menu_item_url', $url );
			}
		}
	}

	/**
	 * Render our custom menu item edit fields
	 *
	 * @param int $item_id
	 * @param object $item
	 */
	public static function render_menu_item_edit_fields( $item_id, $item ) {
		if ( 'nav_menu' === $item->object && 'taxonomy' === $item->type ) {
			$url = get_post_meta( $item_id, '_menu_item_url', true );
			?>
            <p class="field-url description description-wide">
                <label>
                    URL<br>
                    <input type="text" class="widefat code edit-menu-item-url"
                           name="menu-item-url[<?php echo esc_attr( $item->ID ); ?>]"
                           value="<?php echo esc_url( $url ); ?>">
                </label>
            </p>
			<?php
		}
	}

}

add_action( 'plugins_loaded', array( 'mPress_Menu_Wormhole', 'get_instance' ) );