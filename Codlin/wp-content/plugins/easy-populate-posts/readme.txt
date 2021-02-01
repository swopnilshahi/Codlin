=== Easy Populate Posts ===
Contributors: Iulia Cazan
Author URI: https://profiles.wordpress.org/iulia-cazan
Tags: populate posts, random content, dummy content, demo content, helper plugin, random tags, random publish date, posts with images, generate taxonomy terms
Requires at least: not tested
Tested up to: 5.5
Stable tag: 3.5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JJA37EHZXWUTJ

== Description ==
Populate the sites with random content (configurable type, with tags, meta, terms, images, publish date, status, parent, sticky flag).

== Installation ==
* Upload `Easy Populate Posts` to the `/wp-content/plugins/` directory of your application
* Login as Admin
* Activate the plugin through the 'Plugins' menu in WordPress

== Hooks ==
admin_menu, register_activation_hook, register_deactivation_hook

== Screenshots ==
1. The plugin option.

== Frequently Asked Questions ==
None

== Changelog ==
= 3.5.2 =
* Tested up to 5.5
* Icon update

= 3.5.1 =
* Expose the registered post meta including the ACF fields
* Support for serialized post meta values

= 3.5 =
* Tested up to 5.4 version
* Added option for auto-increment numeric prefix
* Date input
* Minor changes to fix layout on small resolution
* New sample images
* Allow to specify attachments IDs (each one per line inside the images area) to be used as sample images

= 3.4 =
* Tested up to 5.2.2 version
* Removed unusable post types from generate options (oembed_cache, user_request, wp_block)
* Added two more post meta options (key and value pairs)
* Added the option to specify taxonomy terms by names, and these will be generated if not found
* New options grouping
* Status hints for non-specified publish date
* Translation added
* New assets samples

= 3.3 =
* Tested up to 5.2.1 version.
* New assets samples.
* Fix content wrap in settings page.

= 3.2 =
* Tested up to 4.9.8 version
* Added excerpt option (none, from content or random)

= 3.1 =
* Tested up to 4.9.6 version
* The option to use your custom images downloaded from URLs and optimization of the usage of the generated images, these are reused instead of creating multiple media files
* New sample images
* Preview of the tags attached to the generated posts
* Thumbnail preview

= 3.0 =
* Tested up to 4.8 version
* Add the option to cleanup the content generated when the plugin is deactivated (this will work for new content)

= 2.0 =
* Tested up to 4.5.2 version
* Cleanup
* Add sample images in the plugin
* Add AJAX execution
* Allow to set a post parent for the hierarchical types
* Allow to set a specific publish date
* Allow to set a specific post status
* Allow to set two taxonomy terms
* Allow to set three post meta
* Allow to set multiple term IDs separated by comma
* Reuse the sample images already generated

== Upgrade Notice ==
* Nothing yet

== License ==
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

== Version history ==
3.5.2 - Tested up to 5.5, icon update
3.5.1 - expose the registered post meta including the ACF fields, support for serialized post meta values
3.5 - Tested up to 5.4 version, auto-increment numeric prefix, date input, fix layout on small resolution, new sample images
3.4 - Tested up to 5.2.2 version, removed unusable post types, two more post meta options, the option to specify taxonomy terms by names (will be generated if not found), new options grouping, status hints, translation added, new assets samples
3.3 - Tested up to 5.2.1 version, new assets samples
3.2 - Tested up to 4.9.8 version, excerpts
3.1 - Tested up to 4.8 version, tags and image preview
3.0 - Tested up to 4.8 version, cleanup the content generated when the plugin is deactivated (this will work for new content)
2.0 - Post parent option, specific date, specific status
1.0 - Initial version.
