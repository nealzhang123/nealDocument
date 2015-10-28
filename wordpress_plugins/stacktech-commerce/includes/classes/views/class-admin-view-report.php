<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Plugin1_Admin_View_Report extends Stacktech_Plugin1_View {

    public static function output() {
		$products = Stacktech_Plugin1_Data::get_products();
		self::load_view('html-admin-report.php');
    }
}


