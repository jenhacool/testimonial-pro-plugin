<?php
/**
 * This is to plugin help page.
 *
 * @package testimonial-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SP_TPRO_Help {

	/**
	 * @var SP_TPRO_Help instance of the class
	 *
	 * @since 2.0
	 */
	private static $_instance;

	/**
	 * @return SP_TPRO_Help
	 *
	 * @since 2.0
	 */
	public static function getInstance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * SP_TPRO_Help constructor.
	 *
	 * @since 2.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'help_page' ), 100 );
	}

	/**
	 * Add SubMenu Page
	 */
	function help_page() {
		add_submenu_page( 'edit.php?post_type=spt_testimonial', __( 'Testimonial Pro Help', 'testimonial-pro' ), __( 'Help', 'testimonial-pro' ), 'manage_options', 'tpro_help', array( $this, 'help_page_callback' ) );
	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		?>
		<div class="wrap about-wrap sp-tpro-help">
			<h1><?php _e( 'Welcome to Testimonial Pro!', 'testimonial-pro' ); ?></h1>
			<p class="about-text">
			<?php
			_e( 'Thank you for installing Testimonial Pro! You\'re now running the most popular Testimonial Premium plugin. This video playlist will help you get started with the plugin.', 'testimonial-pro' );
			?>
				</p>
			<div class="wp-badge"></div>

			<hr>

			<div class="headline-feature feature-video">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/OA7LgaZHwIY?list=PLoUb-7uG-5jM2sjscSqBVj07VXOqt0qHZ" frameborder="0" allowfullscreen></iframe>
			</div>

			<hr>

			<div class="feature-section three-col">
				<div class="col">
					<div class="sp-tpro-feature sp-tpro-text-center">
						<i class="sp-font fa fa-life-ring"></i>
						<h3>Need any Assistance?</h3>
						<p>Our Expert Support Team is always ready to help you out promptly.</p>
						<a href="https://shapedplugin.com/support/" target="_blank" class="button button-primary">Contact Support</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-tpro-feature sp-tpro-text-center">
						<i class="sp-font fa fa-file-text" aria-hidden="true"></i>
						<h3>Looking for Documentation?</h3>
						<p>We have detailed documentation on every aspect of Testimonial Pro.</p>
						<a href="https://docs.shapedplugin.com/docs/testimonial-pro/introduction/" target="_blank" class="button button-primary">Documentation</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-tpro-feature sp-tpro-text-center">
						<i class="sp-font fa fa-thumbs-up" aria-hidden="true"></i>
						<h3>Like This Plugin?</h3>
						<p>If you like Testimonial Pro, please leave us a 5 star rating.</p>
						<a href="https://shapedplugin.com/plugin/testimonial-pro/#reviews" target="_blank"
						   class="button button-primary">Rate the Plugin</a>
					</div>
				</div>
			</div>

			<hr>

			<div class="plugin-section">
				<div class="sp-plugin-section-title">
					<h2>Take your website beyond the typical with more premium plugins!</h2>
					<h4>Some more premium plugins are ready to make your website awesome.</h4>
				</div>
				<div class="three-col">
					<div class="col">
						<div class="sp-tpro-plugin">
							<img src="https://shapedplugin.com/wp-content/uploads/edd/2020/09/Post-Carousel-Pro-360x210.png"
								 alt="Smart Post Show Pro">
							<div class="sp-tpro-plugin-content">
								<h3>Smart Post Show Pro</h3>
								<p>Smart Post Show Pro allows you to filter and display posts (any custom post types), pages, taxonomy, custom taxonomy, custom field, in beautiful layouts anywhere in WordPress in just minutes, no coding required!</p>
								<a href="https://smartpostshow.com/" class="button">View Details</a>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="sp-tpro-plugin">
							<img src="https://shapedplugin.com/wp-content/uploads/edd/2018/11/WordPress-Carousel-Pro-360x210.png"
								 alt="WordPress Carousel Pro">
							<div class="sp-tpro-plugin-content">
								<h3>WordPress Carousel Pro</h3>
								<p>WordPress Carousel Pro is a carousel plugin for your WordPress website. You can easily create carousel using your regular media uploader. This plugin has nice combination in WP regular gallery.</p>
								<a href="https://shapedplugin.com/plugin/wordpress-carousel-pro/" class="button">View Details</a>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="sp-tpro-plugin">
							<img src="https://shapedplugin.com/wp-content/uploads/edd/2018/11/WooCommerce-Product-Slider-360x210.png"
								 alt="WooCommerce Product Slider Pro">
							<div class="sp-tpro-plugin-content">
								<h3>WooCommerce Product Slider Pro</h3>
								<p>WooCommerce Product Slider is an amazing product slider to slide your WooCommerce Products in a tidy and professional way. It allows you to create easily product slider.</p>
								<a href="https://shapedplugin.com/plugin/woocommerce-product-slider-pro/" class="button">View Details</a>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<?php
	}

}
