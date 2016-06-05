# mPress Menu Wormhole

## Description
The **mPress Menu Wormhole** plugin allows you to easily add a menu as a submenu to another menu.

### Why?

Let's say you have a sidebar menu where you list a special collection of important pages on your site.  Now let's say you want those same items to appear in a submenu off of your main header navigation.  Now you have to manage the same collection of pages in two places.  The mPress Menu Wormhole plugin makes it easy to maintain a single menu and have the changes you make to the sidebar menu automatically take place in the header menu as well.

https://wordpress.org/plugins/mpress-menu-wormhole/

## Contributors

### Pull Requests
All pull requests are welcome.  This plugin is relatively simple, so I'll probably be selective when it comes to features.  However, if you would like to submit a translation, this is the place to do it!

### SVN Access
If you have been granted access to SVN, this section details the processes for reliably checking out the code and committing your changes.

#### Prerequisites
- Install Node.js
- Run `npm install -g gulp`
- Run `npm install` from the project root

#### Checkout
- Run `gulp svn:checkout` from the project root

#### Check In
- Be sure that all version numbers in the code and readme have been updated.  Add changelog and upgrade notice entries.
- Tag the new version in Git
- Run `gulp project:build` from the project root.
- Run `gulp svn:addremove` from the SVN directory.
- Run `gulp svn:tag --v={version}` from the SVN directory
- Run `svn ci -m "{commit message}"` from the SVN root to commit changes