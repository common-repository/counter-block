<?php
/**
 * Plugin Name:     Counter Block
 * Description:     Show off numbers or stats on your website using animated Counter block for Gutenberg.
 * Version:         1.0.0
 * Author:          Achal Jain
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     ib-counter
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function ideabox_counter_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "ideabox/counter" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'ideabox-counter-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);
	wp_set_script_translations( 'ideabox-counter-block-editor', 'counter' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'ideabox-counter-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'ideabox-counter-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	wp_register_script(
        'ideabox-jquery-numerator',
        plugins_url( 'assets/js/jquery-numerator.min.js', __FILE__ ),
        array( 'jquery'),
        $script_asset['version'],
        true
    );

    wp_register_script(
        'ideabox-counter-block',
        plugins_url( 'assets/js/counter.js', __FILE__ ),
        is_admin() ? array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api', 'wp-editor', 'ideabox-jquery-numerator' ) : array( 'ideabox-jquery-numerator' ),
		$script_asset['version'],
        true
    );

	register_block_type( 'ideabox/counter', array(
		'editor_script' => 'ideabox-counter-block-editor',
		'editor_style'  => 'ideabox-counter-block-editor',
		'style'         => 'ideabox-counter-block',
		'script'		=> 'ideabox-counter-block',
	) );
}
add_action( 'init', 'ideabox_counter_block_init' );
