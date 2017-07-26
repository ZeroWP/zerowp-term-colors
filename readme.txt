=== Plugin Name ===
Contributors: _smartik_
Donate link: https://paypal.me/zerowp
Tags: term, taxonomy, color, ui, interface
Requires at least: 4.7
Tested up to: 4.8
Stable tag: 1.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Provides an easy to use interface to assign colors to any term from any taxonomy.

== Description ==
Provides an easy to use interface to assign colors to any term from any taxonomy. Then you can use them on front-end using the built-in CSS class or just by calling `get_term_meta`.

== Frequently Asked Questions ==
= Do I have to place some code in my theme? =
No or maybe yes. You can use the plugin as it is, just to differentiate terms by color. However, if you want to display the colors on the front-end, you may need to use the CSS class, that is something like `.ztc-term-label-{ID}`, or directly `get_term_meta` to retrieve the meta value.

= I want to display the terms on front end how to do it? =
The easiest way is to use the built-in function that comes with this plugin:
```
ztc_colored_labels( $taxonomy, $post_id = false, $links = false, $limit = false );
```

== Changelog ==
= 1.0 =
* Initial release.

