=== Plugin Name ===
Plugin Name: Simple Cookie Consent Message
Plugin URI:
Version: 1.0
Author: Tasty Digital
Tags: cookie law, cookies, eu law, implied consent
Requires at least: 2.7.0
Tested up to: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Adds a message to the top of the page stating that cookies are used and if they continue viewing the site then that counts as implied consent.

== Description ==

This WordPress plug-in is derived from an abandoned [plugin](https://wordpress.org/plugins/eu-cookie-law-consent/) by [Tim Trott](http://timtrott.co.uk/europe-cookie-law-plugin/)

It will create a fixed banner on the guest's browser that greets them with an editable message.

This plugin relies on implied cookie consent and you should ensure that this method is correct for your website. If you are relying on implied consent you need to be satisfied that your users understand that their actions will result in cookies being set. Without this understanding you do not have their informed consent. - http://www.ico.gov.uk/news/blog/2012/updated-ico-advice-guidance-e-privacy-directive-eu-cookie-law.aspx

For more information on the Cookie Law please visit http://www.ico.gov.uk/for_organisations/privacy_and_electronic_communications/the_guide/cookies.aspx

DISCLAIMER

Whilst every effort has been taken to ensure that this code remains up to date and conforms to the EU Cookie Law, the authors cannot and will not be held responsible if it is found to be inadequate in any way. The authors are NOT legal experts and nothing contained within constitutes legal advice.

It is your responsibility to ensure that implied consent is suitable for your site before using this code or plugin.

== Installation ==

This section describes how to install the plug-in and get it working.

1. Upload all files to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the text through the 'Settings' menu under 'Simple Cookie Message'



CHANGE LOG

1.0     (re-released from new repo with new name)
        Allows cookies to be set beyond 31st Dec 2020!
        Notice will keep re-appearing until 'I approve' button clicked
        Debug mode only kicks in for administrators if enabled

2.05	Updated support for IE11, added option to disable enqueing jQuery, fixed PHP errors, tested up to WP 4.4

2.02	Fixed compatibility with conflicting function names

2.01	Fixed bug hiding admin bar (test code remained)

2.00    Added responsive layout, new configuration manager, improved control over styling and more configuration options.

1.01	Fix for IE8 CSS
	Fixed broken PHP tag in code

1.00	Initial Release