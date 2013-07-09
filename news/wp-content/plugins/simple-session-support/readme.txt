=== Simple Session Support ===
Contributors: pkwooster
Donate link: http://devondev.com/wordpress/
Tags: development, session management
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.01

Provides support for the PHP session allowing data to be retained from one request to another.

== Description ==

This plugin adds PHP session support. Data can be passed from one request to the next.

Functions are provided to get and set items in the PHP session.

*Features for Developers*

* You can save data from one HTTP request to another.
* the simpleSessionSet($key, $value) function sets a session value
* the simpleSessionGet($key, $default) function gets a session value with a default value if the key is not found
* the session is started in the init action and destroyed in the login and logout actions

*Additional Features*

There are no additional features supported by Simple Session Suppoprt.  The code is simple, small and well documented, 
so you can use it as a starting point for your own plugins or themes.

== Installation ==

1. Use the Plugins, Add New menu in WordPress to install the plugin or upload the `simple-session-support` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.01 =
* make it cooperate with other plugins that use the session

= 1.0 =
* First release.

== Upgrade Notice ==
