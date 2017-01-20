<ul id="nav_menuchecklist-pop" class="categorychecklist">

	<?php foreach ( wp_get_nav_menus() as $menu ): ?>
        <li>
            <label>
                <input type="checkbox"
                       class="menu-item-checkbox"
                       name="nav_menu[]"
                       value="<?php echo esc_attr( $menu->term_id ); ?>"/>
				<?php echo esc_html( $menu->name ); ?>
            </label>
        </li>
	<?php endforeach; ?>

</ul>

<p class="button-controls">

    <span class="add-to-menu">

        <input type="submit"
               id="add-nav-menu"
               class="button-secondary submit-add-to-menu right"
               value="<?php esc_attr_e( 'Add to Menu', 'mpress-menu-wormhole' ); ?>"/>

        <span class="spinner"></span>

    </span>

</p>