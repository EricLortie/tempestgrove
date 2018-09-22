=== Sky Login Redirect ===
Contributors: skyminds
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DNSC3NVBWR66L
Tags: login, logout, redirect, redirection, sky login redirect
Requires at least: 3.0
Tested up to: 9.9
Stable tag: 1.9.2
License: GPLv2 or later

Redirects to the page you were reading just before logging in. Redirects to the homepage when you log out.

== Description ==

[Sky Login Redirect](https://www.skyminds.net/sky-login-redirect/ "Sky Login Redirect") redirects users to the page they were reading just before logging in.
In case that page is not defined, users are redirected to the homepage.

It also redirects user back to the homepage when they log out, instead of going to the login page again.

No configuration necessary. Everything works under the hood. Simply activate the plugin.

More information can be found on [Sky Login Redirect Homepage](https://www.skyminds.net/sky-login-redirect/ "Sky Login Redirect Homepage").

== Installation ==

Install and activate the plugin. You're done. No configuration necessary, it works under the hood.

== Changelog ==

= 1.9.2 =
* Dec 15th 2015
* Tweak: now using esc_url_raw() instead of esc_url() (thanks Bill Catherall for reporting)

= 1.9.1 =
* Dec 14th 2015
* Tweak: set priority for login_redirect filter
* Tweak: use add_query_arg() in custom logout function for consistency

= 1.9 =
* June 15th 2015
* Fix for the "undefined variable" (thanks nina9702 for reporting)
* Tweak: streamlined the referrer function


= 1.8 =
* April 24th 2015
* Added: additional string escaping.

= 1.7 =
* April 21st 2015
* Added: use of esc_url() to sanitize the output of add_query_arg() and improve security.
* Added: additional logo sizes.
* Confirmed compatibility with WordPress 4.2

= 1.6 =
* December 22nd 2014
* Added : plugin logo.
* Confirmed compatibility with WordPress 4.1

= 1.5 =
* May 30th 2014
* Added : links to the login page are now cleaner (no args in URI, except for admin pages).
* Added : new function so that logging out sends you back to the homepage.
* Added : more inline documentation.
* Added : plugin banner.
* Changed : refactored and cleaned up code.
* Changed : reference to wp-register.php changed to wp-signup.php
* Confirmed compatibility with WordPress 3.9

= 1.4.1 =
* New check : attempt to redirect to the referring page even if $redirect_to wasn't explicitly set.

= 1.3 =
* Fixed a regression (thanks Sharonq for reporting).
* Plugin partially rewritten.
* New check with is_ssl().

= 1.2 =
* Fix for the login loop that occured when using the password recovery and when logging straight from the login page (thanks zkagen and salatfresser for reporting).
* Ditch the use of HTTP_HOST for home_url().

= 1.1 =
* Added code to check if $redirect_to is set and make it take precedence.
* Changed plugin URL to its [home page](http://www.skyminds.net/wordpress-plugins/sky-login-redirect/ "Sky Login Redirect Homepage").

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.8 =
Additional string escaping.

= 1.7 =
Security release: use of esc_url() to sanitize the output of add_query_arg().

= 1.5 =
Leaner and cleaner version. New features : now redirects to the homepage when you log out and login URI are without arguments, except for the admin pages.
