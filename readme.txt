=== Swift Security Lite - Hide WordPress backend, Firewall===
Contributors: swte
Donate link: http://swiftsecurity.swte.ch
Tags: wordpress firewall, hide wp, hide wordpress, hide backend, hide admin, security
Requires at least: 3.5
Tested up to: 4.1.1
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Swift Security is an incredible WordPress security plugin, which turns your WordPress site into a secure, "bulletproof" website.

== Description ==

Did you know that about 170,000 WordPress sites were hacked in one single year?

Most of these (51%) were hacked because they used insecure or vulnerable templates and/or plugins, and 8% were hacked because of weak passwords.

Swift Security is an incredible WordPress security plugin, which turns your WordPress site into a secure, "bulletproof" website, without modification of any of your files or directory structure.

If you use our plugin you can:

* Hide the WordPress backend - By default the plugin changes the '/wp-admin' to '/administrator'
* Setup basic firewall which filters malicious requests (SQL injections, XSS attempts, file inclusion) in every GET requests
* Get email notifications from firewall

Features in PRO version:

* Totally hide the fact that you are using WordPress
* You can change any string in CSS/HTML/JavaScript files
* Custom URLs (admin, slug, etc)
* Custom meta generator tag
* CSS/JavaScript minifier
* Advanced firewall settings - You can set up a firewall which filters malicious requests (SQL injections, XSS attempts, file inclusion, malicious file uploads) in every commonly used user-defined values (GET or POST requests and in cookies)
* GEO/IP whitelist/ban
* Login IP filter
* Push notifications
* Run scheduled code scans - The Code Scanner module checks the basic setups which can be vulnerable, and checks all your files. The scanner is able to find malicious code snippets and the most common shells as well

The PRO version is available at http://swiftsecurity.swte.ch

== Installation ==

1. Upload 'Swift Security Lite' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Do I need to have any technical skills to use the plugin? =

Swift Security can be fine-tuned in its smallest details, however, to use the plugin you don't need any technical skills, you only have to activate the plugin. That's all. If there is a need for any custom settings, the plugin will help you with several messages (e.g. if the cache directory cannot be opened).

= If I deactivate the Hide WordPress module will everything return to normal? =

Yes, because Swift Security does not rename your directories and files, it only masks them, so if you deactivate the module or the plugin, everything will return to its original state.

= I have locked myself out of admin, I have forgotten my new login and admin URL. =

No problem. Rename the wp-content/plugins/SwiftSecurityLite directory for example to SwiftSecurity_x or delete the directory and delete the lines between ######BEGIN SwiftSecurity###### and ######END SwiftSecurity###### in the .htaccess file.
Following this, you can log in with your old admin URL (http://yoursite.com/wp-login.php or http://yoursite.com/wp-admin)
Next, install the plugin again and be careful to remember the login URL :)

= Is this plugin compatible with other security plugins? =

Swift Security is compatible with most security plugins, however, conflicts may occur when both plugins rename the admin URL or two firewalls are activated at once. Because the Swift Security plugin offers an integrated solution, there is no need (and it is not recommended) to be used with other firewalls or “hide WordPress'' plugins.

= Is this plugin compatible with cache plugins? =

Of course, but don't forget to clear the cache after activation or modifications.

= Is this plugin compatible with managed WordPress hosting? =

Officially the WPEngine and Godaddy hostings are supported, however, the plugin should work with all hosting providers.
If you notice any issues with any managed hostings, please contact us at support@swte.ch Please take it into account that these providers may use other cache solutions as well, and only WPEngine is handled automatically by Swift Security.

= I activated the Hide WordPress module, but I can still see the /wp-login.php and the /wp-admin pages. Why? =

If you're logged in, these pages are not hidden. Log out, close all browser windows and try again or simply try it in private (or incognito) mode or from a different device.

= Does the PRO version affect SEO? =

Yes and no.
You won't have any SEO problems if you're not going to change the content URLs (post, tag, category, author, feed), but if you decide to change them, it's probably not going to hurt you, however, these will be removed from Google's index eventually. But if you have a broken link pointing to a 404 then yes, you are leaking PR.
With a new WordPress site you will not have any problems when you change these URLs.

= Does the PRO version really hide the fact I'm using WordPress? =

Yes. Try it yourself at wpthemedetector.co.uk.

== Screenshots ==

1. /assets/screenshot-1.png
2. /assets/screenshot-2.png
3. /assets/screenshot-3.png
4. /assets/screenshot-4.png

== Changelog ==

= 1.2.4 =
* Initial release

