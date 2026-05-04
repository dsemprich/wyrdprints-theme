<?php
/**
 * WyrdPrints Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wyrdprints_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'site-icon' );

	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'wyrdprints_setup' );

function wyrdprints_favicon_fallback() {
	if ( has_site_icon() ) {
		return;
	}

	$favicon_url = get_theme_file_uri( 'assets/images/logo.png' );

	echo '<link rel="icon" href="' . esc_url( $favicon_url ) . '" type="image/png">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $favicon_url ) . '">' . "\n";
}
add_action( 'wp_head', 'wyrdprints_favicon_fallback' );

function wyrdprints_enqueue_styles() {
	wp_enqueue_style(
		'wyrdprints-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'wyrdprints_enqueue_styles' );

/** Gallery */
add_action('woocommerce_after_shop_loop_item_title', function() {
	if (!is_page('galerie')) return;

	global $product;

	if ($product && $product->get_sku()) {
		$sku = esc_attr($product->get_sku());

		echo '<span class="product-sku-copy" data-sku="' . $sku . '" role="button" tabindex="0">
			Artikelnummer: <strong>' . esc_html($product->get_sku()) . '</strong>
		</span>';
	}
}, 15);

add_action('wp_footer', function() {
	if (!is_page('galerie')) return;
	?>
	<script>
	document.addEventListener('click', function(e) {
		const skuEl = e.target.closest('.product-sku-copy');
		if (!skuEl) return;

		e.preventDefault();
		e.stopImmediatePropagation();

		const sku = skuEl.getAttribute('data-sku');

		function copied() {
			const oldText = skuEl.innerHTML;
			skuEl.innerHTML = 'Artikelnummer kopiert ✓';

			setTimeout(function() {
				skuEl.innerHTML = oldText;
			}, 1200);
		}

		if (navigator.clipboard && window.isSecureContext) {
			navigator.clipboard.writeText(sku).then(copied);
		} else {
			const textarea = document.createElement('textarea');
			textarea.value = sku;
			textarea.style.position = 'fixed';
			textarea.style.left = '-9999px';
			document.body.appendChild(textarea);
			textarea.focus();
			textarea.select();

			try {
				document.execCommand('copy');
				copied();
			} catch (err) {
				console.log('Kopieren fehlgeschlagen', err);
			}

			document.body.removeChild(textarea);
		}
	}, true);
	</script>
	<?php
});