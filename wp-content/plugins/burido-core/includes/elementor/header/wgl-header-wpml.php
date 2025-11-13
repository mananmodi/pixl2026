<?php
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Widget_Base, Controls_Manager};

/**
 * WPML widget for Header CPT
 *
 *
 * @category Class
 * @package burido-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class WGL_Header_Wpml extends Widget_Base
{
    public function get_name() {
        return 'wgl-header-wpml';
    }

    public function get_title() {
        return esc_html__('WPML Selector', 'burido-core' );
    }

    public function get_icon() {
        return 'wgl-header-wpml';
    }

    public function get_keywords() {
        return ['wpml', 'translation'];
    }

    public function get_categories() {
        return [ 'wgl-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'wgl-widgets',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_navigation_settings',
            [
                'label' => esc_html__( 'WPML Settings', 'burido-core' ),
            ]
        );

        $this->add_control(
            'wpml_height',
            array(
                'label' => esc_html__( 'WPML Height', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => 0,
                'step' => 1,
                'default' => 100,
                'description' => esc_html__( 'Enter value in pixels', 'burido-core' ),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'height: {{VALUE}}px;',
                ],
            )
        );

        $this->add_control(
            'wpml_align',
            array(
                'label' => esc_html__( 'Alignment', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'burido-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'burido-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'label_block' => false,
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'text-align: {{VALUE}};',
                ],
            )
        );

        $this->end_controls_section();
    }

    public function render(){
        if (class_exists('\SitePress')) {
            echo "<div class='sitepress_container'>";
                do_action('wpml_add_language_selector');
            echo "</div>";
        }
    }
}