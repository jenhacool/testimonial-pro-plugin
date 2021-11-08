<?php
if ( file_exists( SP_TPRO_PATH . 'class/order.php' ) ) {
	require_once SP_TPRO_PATH . 'class/order.php';
}

function sp_tpro_custom_order_class_load() {

	global $SP_TPRO_Order;
	$SP_TPRO_Order = new SP_TPRO_Order();
}
add_action( 'plugins_loaded', 'sp_tpro_custom_order_class_load' );

function init_sp_tpro_custom_order() {
	global $SP_TPRO_Order;
	if ( is_admin() ) {
		$SP_TPRO_Order->init();
	}
}
add_action( 'wp_loaded', 'init_sp_tpro_custom_order' );
