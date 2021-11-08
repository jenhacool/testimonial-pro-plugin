<?php
/**
 * The Pro Loader Class
 *
 * @since      2.1.10
 * @package    Testimonial_Pro
 * @subpackage Testimonial_Pro/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */
class SP_TPRO_Loader {

	function __construct() {
		require_once SP_TPRO_PATH . 'admin/views/scripts.php';
		require_once SP_TPRO_PATH . 'admin/views/order.php';
		require_once SP_TPRO_PATH . 'admin/views/mce-button.php';
		require_once SP_TPRO_PATH . 'admin/views/vc-add-on.php';
		require_once SP_TPRO_PATH . 'admin/views/widget.php';
		require_once SP_TPRO_PATH . 'includes/resizer.php';
		require_once SP_TPRO_PATH . 'public/views/shortcoderender.php';
		require_once SP_TPRO_PATH . 'public/views/form.php';
		require_once SP_TPRO_PATH . 'public/views/old-form.php';
		require_once SP_TPRO_PATH . 'public/views/scripts.php';
		require_once SP_TPRO_PATH . 'includes/class-testimonial-pro-license.php';
		require_once SP_TPRO_PATH . 'admin/helper/class-testimonial-pro-cron.php';
	}

}

new SP_TPRO_Loader();
