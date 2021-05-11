=== Product Attributes Shortcode ===
Contributors: ninetyninew
Tags: product attributes shortcode, product attributes, product terms, product shortcode, attributes widget
Requires at least: 5.0
Tested up to: 5.7.1
Requires PHP: 7.0
Stable tag: 1.0.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Display a list of product attribute term links via shortcode in pages, posts, widgets, templates, etc.

== Description ==

This plugin allows you to add a shortcode to pages, posts, widgets, etc, this shortcode displays a list of links to all the terms for a specific product attribute.

We created this plugin because WooCommerce includes a "Filter products by attribute" widget, however this is a filterable list, so when a term is clicked the list is reduced based on the products currently filtered.

So for example, with this plugin if you have an attribute such as brand, you can display a list of all the brand links which isn't effected by filtering.

You can use it to create a list of term links for any product attribute.

We've used the shortcode in pages, posts, widgets and in templates.

**Requires WooCommerce**

**Note that the list will not contain links if your attribute does not have the "Enable Archives?" setting enabled (Products > Attributes > Click "Edit" under the attribute name)**

= Shortcode =

The shortcode is:

[wcpas_product_attributes attribute="x"]

**Replace x with your attribute name as shown on the WooCommerce edit attribute page.**

= Shortcode Options =

- attribute **REQUIRED** - (the name of your product attribute, use name as shown on the WooCommerce edit attribute page, default is empty)
- orderby **OPTIONAL** - Use any option from the orderby parameter [here](https://developer.wordpress.org/reference/classes/wp_term_query/__construct/), default is name
- order **OPTIONAL** (Use asc or desc, default asc)
- hide_empty **OPTIONAL** (Use 1 to hide empty terms, 0 to disable, default is 1)
- show_counts **OPTIONAL** (Use 1 to enable a count next to each term, 0 to disable, default is 0)

= Example Shortcode =

If you have a brand attribute:

[wcpas_product_attributes attribute="brand" orderby="name" order="asc" hide_empty="1" show_counts="1"]

== Installation ==

= Minimum requirements =

* WordPress 5.0 or greater
* PHP 7.0 or greater
* WooCommerce must be installed and activated, we recommend using the latest version

= Automatic installation =

To do an automatic install of this plugin log in to your WordPress dashboard, navigate to the Plugins menu, and click "Add New".
 
Search for "Product Attributes Shortcode" and click the install button, once done simply activate the plugin.

= Manual installation =

Manual installation method requires downloading the plugin and uploading it to your web server via an FTP application. See these [instructions on how to do this](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).

= Getting started =

Once you have installed and activated the plugin simply use the shortcode in pages, posts, widgets, templates, etc.

== Frequently Asked Questions ==

= Why aren't my list of terms linked? =

The list will not contain links if your attribute does not have the "Enable Archives?" setting enabled (Products > Attributes > Click "Edit" under the attribute name)

= Can I use it in a page/post/widget/etc? =

Yes, you can use the shortcode anywhere in WordPress where you can normally use shortcodes.

= How can I get it to work in a template? =

You will need to use the do_shortcode function. [See this link for a code snippet](https://css-tricks.com/snippets/wordpress/shortcode-in-a-template/) (you'll need to replace the shortcode with ours)

= How do I style it? =

You can custom CSS in your theme or via the customizer, each list is a <ul> with the class .wcpas-product-attributes, to target specific attribute lists we have also included an ID of #wcpas-product-attributes-[attribute].

== Changelog ==

= 1.0.0 - 2021-05-11 =

* Initial release