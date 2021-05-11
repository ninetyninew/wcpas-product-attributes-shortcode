<?php

/**
 * Plugin Name: Product Attributes Shortcode
 * Plugin URI: https://99w.co.uk
 * Description: Display a list of product attribute term links via shortcode in pages, posts, widgets, templates, etc.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Author: 99w
 * Author URI: https://profiles.wordpress.org/ninetyninew/
 * Text Domain: wcpas-product-attributes-shortcode
 * Domain Path: /languages
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

load_plugin_textdomain( 'wcpas-product-attributes-shortcode', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Ensures is_plugin_active() can be used here

if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) { // If WooCommerce is active, works for standalone and multisite network

	function wcpas_product_attributes_shortcode( $atts ) {

		// Shortcode attributes

		$atts = shortcode_atts(
			array(
				'attribute'		=> '',
				'orderby'		=> 'name',
				'order'			=> 'asc',
				'hide_empty'	=> 1, // must be 1 not true
				'show_counts'	=> 0, // must be 0 not false
			),
			$atts,
			'wcpas_product_attributes'
		);

		// Start output

		$output = '';

		// Get attribute taxonomies

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( !empty( $attribute_taxonomies ) ) {

			// Loop taxonomies

			foreach( $attribute_taxonomies as $taxonomy ) {

				// If attribute matches shortcode parameter

				if ( $atts['attribute'] == $taxonomy->attribute_name ) {

					// Set taxonomy id correctly so it can be used for get_terms() lookup

					$taxonomy_id = 'pa_' . $taxonomy->attribute_name;

					// Get terms

					$terms = get_terms(
						array(
							'taxonomy'		=> $taxonomy_id,
							'orderby'		=> $atts['orderby'],
							'order'			=> $atts['order'],
							'hide_empty'	=> $atts['hide_empty'],
						)
					);

					// If terms exist

					if ( !empty( $terms ) ) {

						// Output the list

						$output .= '<ul class="wcpas-product-attributes" id="wcpas-product-attributes-' . $taxonomy_id . '">';

						foreach( $terms as $term ) {

							$output .= '<li>';

							if ( $taxonomy->attribute_public == 1 ) {

								$output .= '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';

							} else {

								$output .= $term->name;

							}

							if ( $atts['show_counts'] == 1 ) {

								$output .= ' ' . __( '(', 'wcpas-product-attributes-shortcode' ) . $term->count . __( ')', 'wcpas-product-attributes-shortcode' );

							}

							$output .= '</li>';

						}

						$output .= '</ul>';

					}

				}

			}

		}

		return $output;

	}

	add_shortcode( 'wcpas_product_attributes', 'wcpas_product_attributes_shortcode' );

} else {

	add_action( 'admin_notices', function() {

		// Error notice displayed to users who can edit plugins if WooCommerce is not active

		if ( current_user_can( 'edit_plugins' ) ) { ?>

			<div class="notice notice-error">
				<p><?php _e( 'Product Attributes Shortcode cannot be used as WooCommerce is not active, to use Product Attributes Shortcode activate WooCommerce.', 'wcpas-product-attributes-shortcode' ); ?></p>
			</div>

		<?php }

	} );

}