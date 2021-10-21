<?php

namespace Elementor;

use Elementor\Core\Base\Document;
use ElementorPro\Base\Base_Widget;
use ElementorPro\Modules\QueryControl\Module as QueryControlModule;
use ElementorPro\Plugin;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Napusti
}


class BPMegaMenu_Widget_Megamenu extends Widget_Base
{


    public function get_name()
    {
        return 'bpmegamenu-widget-megamenu';
    }

    public function get_title()
    {
        return esc_html__('Mega Menu', 'bpmegamenu');
    }

    public function get_icon()
    {
        return 'fa fa-filter';
    }

    public function get_categories()
    {
        return ['general', 'navigation', 'menu'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_template',
            [
                'label' => __('Sadrzaj', 'bpmegamenu'),
            ]
        );

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Ikona', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

        $repeater->add_control(
            'title',
            [
                'label' => __('Prvi naslov', 'bpmegamenu'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Upisi', 'bpmegamenu'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'sub_title',
            [
                'label' => __('Podnaslov', 'bpmegamenu'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Upisi', 'bpmegamenu'),
                'label_block' => true,
            ]
        );

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://tvoj-link.com', 'plugin-domain' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$document_types = Plugin::elementor()->documents->get_document_types( [
			'show_in_library' => true,
		] );

		$repeater->add_control(
			'template_id',
			[
				'label' => __( 'Izaberi templejt iz elementora.', 'elementor-pro' ),
				'type' => QueryControlModule::QUERY_CONTROL_ID,
				'label_block' => true,
				'autocomplete' => [
					'object' => QueryControlModule::QUERY_OBJECT_LIBRARY_TEMPLATE,
					'query' => [
						'meta_query' => [
							[
								'key' => Document::TYPE_META_KEY,
								'value' => array_keys( $document_types ),
								'compare' => 'IN',
							],
						],
					],
				],
			]
		);

        $this->add_control(
            'menu',
            [
                'label' => __('Menu', 'bpmegamenu'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );


        $repeater_language = new \Elementor\Repeater();

        $repeater_language->add_control(
            'title',
            [
                'label' => __('Naslov', 'bpmegamenu'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Upisi', 'bpmegamenu'),
                'label_block' => true,
            ]
        );

		$repeater_language->add_control(
			'image',
			[
				'label' => __( 'Odaberi sliku', 'elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater_language->add_control(
			'link',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://tvoj-link.com', 'plugin-domain' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

        $this->add_control(
            'language',
            [
                'label' => __('Jezik ako ima', 'bpmegamenu'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_language->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();

        $custom_logo_id = get_theme_mod( 'custom_logo' );

		if ( $custom_logo_id ) {
			$site_logo_url = wp_get_attachment_image_src( $custom_logo_id, 'full' )[0];
		}

        ?>
            <header class="bpmenu-header">
                <div class="bpmenu-container">
                    <div class="bpmenu-row">
                        <div class="bpmenu-logo">
                            <img src="<?php echo $site_logo_url; ?>">
                        </div>
                        <a href="#" class="bpmenu-burger"><span></span><span></span><span></span></a>
                        <div class="bpmenu-menu">
                            <a href="#" class="bpmenu-mobile-close"></a>
                            <?php
                                if ($settings['menu']) {
                                    ?>
                                        <ul class="bpmenu-menu-list">
                                            <?php
                                                foreach ($settings['menu'] as $item) {
                                                    if($item['link']['url'] != ""){
                                                        $target = $item['link']['is_external'] ? ' target="_blank"' : '';
                                                        $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
                                                        ?>
                                                            <li><a class="bpmenu-menu-item" href="<?php echo $item['link']['url']; ?>" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo $item["title"]; ?></a></li>
                                                        <?php
                                                    }else{
                                                        $template_id = $item['template_id'];
                                                        ?>
                                                            <li class="bpmenu-has-submenu">
                                                                <a href="#" class="bpmenu-menu-item"><?php echo $item["title"]; ?></a>
                                                                <div class="bpmenu-sub-menu" id="bpmenu-sub-menu-<?php echo $template_id; ?>">
                                                                    <?php
                                                                        echo Plugin::elementor()->frontend->get_builder_content_for_display( $template_id );
                                                                    ?>
                                                                </div>
                                                            </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </ul>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </header>
        <?php
    }

    public function render_plain_content()
    {
    }
}
