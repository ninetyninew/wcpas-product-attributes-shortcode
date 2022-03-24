<?php

/**
 * Plugin Name: Product Attributes Shortcode
 * Plugin URI: https://99w.co.uk
 * Description: Display a list of product attribute term links via shortcode in pages, posts, widgets, templates, etc.
 * Version: 1.3.0
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

function wcpas_product_attributes_translation() {

	load_plugin_textdomain( 'wcpas-product-attributes-shortcode', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}
add_action( 'init', 'wcpas_product_attributes_translation' );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

	function wcpas_product_attributes_shortcode( $atts ) {

		// Shortcode attributes

		$atts = shortcode_atts(
			array(
				'attribute'			=> '',
				'orderby'			=> 'name',
				'order'				=> 'asc',
				'hide_empty'		=> 1, // Must be 1 not true
				'show_counts'		=> 0, // Must be 0 not false
				'archive_links'		=> 0, // Must be 0 not false
				'min_price'			=> '',
				'max_price'			=> '',
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

							if ( $atts['archive_links'] == 0 ) {

								$href = get_permalink( wc_get_page_id( 'shop' ) ) . '?filter_' . $taxonomy->attribute_name . '=' . $term->slug;

								if ( '' !== $atts['min_price'] ) {

									$href .= '&min_price=' . $atts['min_price'];

								}

								if ( '' !== $atts['max_price'] ) {

									$href .= '&max_price=' . $atts['max_price'];

								}

								$output .= '<a href="' . $href . '">' . $term->name . '</a>';

							} else {

								if ( $taxonomy->attribute_public == 1 ) {

									$href = get_term_link( $term );
									$output .= '<a href="' . $href . '">' . $term->name . '</a>';

								} else {

									$output .= $term->name;

								}

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

		if ( current_user_can( 'edit_plugins' ) ) {
	
			?>
	
			<div class="notice notice-error">
				<p><strong><?php esc_html_e( 'Product Attributes Shortcode requires WooCommerce to be installed and activated.', 'wcpas-product-attributes-shortcode' ); ?></strong></p>
			</div>
	
			<?php
	
		}
	
	});

}
