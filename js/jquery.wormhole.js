jQuery(document).ready( function($) {

    // TODO: Disallow adding of current menu
    // TODO: Prevent clicking on front end top level menu item

    $('#add-nav-menu').click(function (e) {
        e.preventDefault();
        var context = $('#taxonomy-nav_menu');
        var spinner = $('.spinner', context);
        var menus = [];
        spinner.show();
        $('.categorychecklist li :checked', context).each( function() {
            menus.push( $(this).val() );
        } );
        $.post(
            ajaxurl,
            {
                action: mPressMenuWormhole.action,
                nonce: mPressMenuWormhole.nonce,
                menus: menus
            },
            function (response, textStatus) {
                if( 'success' === textStatus ) {
                    $('#menu-to-edit').append(response);
                    $('.categorychecklist li :checked', context).removeAttr('checked');
                    spinner.hide();
                }
            }
        );
    });

} );