=== mPress Menu Wormhole ===
Contributors: woodent
Donate link: https://www.paypal.me/wpscholar/15
Tags: menu, menus, navigation, nav, wormhole, nested menus, nested navigation
Requires at least: 3.2
Tested up to: 4.7.1
Stable tag: 1.1.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easily add a menu as a submenu to another menu.

== Description ==

The **mPress Menu Wormhole** plugin allows you to easily add a menu as a submenu to another menu.

= Why? =

Let's say you have a sidebar menu where you list a special collection of important pages on your site.  Now let's say you want those same items to appear in a submenu off of your main header navigation.  Now you have to manage the same collection of pages in two places.  The mPress Menu Wormhole plugin makes it easy to maintain a single menu and have the changes you make to the sidebar menu automatically take place in the header menu as well.

= How? =

Using this plugin is simple:

1. Install the plugin.
2. Activate the plugin.
3. Go to 'Appearance' -> 'Menus' in the WordPress admin menu.
4. You should see a box in the left column called 'Navigation Menus'.  If you don't see it, check the FAQ page for what you need to do.
5. Check box next to the menu you want to add and click the 'Add to Menu' button.
6. Move the new item where you want and click the 'Save Menu' button.

**IMPORTANT NOTE:** Please don't direct a wormhole into itself... it creates a black hole.  In other words, don't add a navigation menu to itself.  It creates an infinite loop that will crash the front end of your site.  No worries though, it is easily undone.  I do it just for fun sometimes.

= Features =

* Clean, well written code that won't bog down your site.

== Installation ==

= Prerequisites =
If you don't meet the below requirements, I highly recommend you upgrade your WordPress install or move to a web host
that supports a more recent version of PHP.

* Requires WordPress version 3.2 or greater
* Requires PHP version 5 or greater ( PHP version 5.2.4 is required to run WordPress version 3.2 )

= The Easy Way =

1. In your WordPress admin, go to 'Plugins' and then click on 'Add New'.
2. In the search box, type in 'mPress Menu Wormhole' and hit enter.  This plugin should be the first and likely the only result.
3. Click on the 'Install' link.
4. Once installed, click the 'Activate this plugin' link.

= The Hard Way =

1. Download the .zip file containing the plugin.
2. Upload the file into your `/wp-content/plugins/` directory and unzip
3. Find the plugin in the WordPress admin on the 'Plugins' page and click 'Activate'

== Frequently Asked Questions ==

= What if I can't see the 'Navigation Menus' box on the menu management screen in the admin? =

Scroll to the top of the page and click the 'Screen Options' button in the top right corner.  In the dropdown, make sure the 'Navigation Menus' option is checked.  Now you should see the 'Navigation Menus' box in the left column.

= Can I add a menu to itself? =

Right now, yes. This is a bad idea.  When a wormhole leads back into itself it creates a black hole.  Black holes are bad.  Basically, while all will seem fine and dandy in the admin, the front end of your site will be sucked into the black hole.  If this happens to you, just remove the menu from itself in the admin to break the infinite loop.  Consider yourself warned.

= Why did your plugin crash the front end of my site? =

Well, I tried to warn you.  It wasn't me... you should have read the instructions.  If you still honestly don't know why, please read the previous question you just skipped over.

== Changelog ==

= 1.1.1 =

* Allow a subset of HTML in nav menu menu item link text.
* Ensure that nav menu menu item links are not clickable if URL is not set.

= 1.1 =

* Added ability to set a URL for nav menu menu items.
* Updated code after security review.
* Tested in WordPress version 4.7.1

= 1.0 =

* Tested in WordPress version 4.5.2

= 0.1 =

* Initial commit

== Upgrade Notice ==

= 1.0 =

Plugin updated to reflect that it works with WordPress version 4.5.2

= 1.1 =

Added ability to set a URL for nav menu menu items. Security updates. Tested with WordPress version 4.7.1

= 1.1.1 =

* Allow a subset of HTML in nav menu menu item link text.
* Ensure that nav menu menu item links are not clickable if URL is not set.