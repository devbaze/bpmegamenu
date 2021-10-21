<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // napusti ako
}

final class BPMegaMenu_Elementor_MegaMenu_Extension {


    const MINIMUM_ELEMENTOR_VERSION = '2.7.0';
    const MINIMUM_PHP_VERSION = '5.6';

    private static $_instance = null;

    public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			return;
		}

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			return;
		}

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
	}

	private function include_widgets_files() {

		require_once __DIR__ . '/widget-mega-menu.php';
	}

	public function init_widgets() {

		$this->include_widgets_files();

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\BPMegaMenu_Widget_Megamenu() );
	}


}

BPMegaMenu_Elementor_MegaMenu_Extension::instance();
