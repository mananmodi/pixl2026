<?php
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{
    Group_Control_Border,
    Widget_Base,
    Controls_Manager
};
use WGL_Extensions\Includes\WGL_Cursor;

/**
 * Mobile menu button widget for Header CPT
 *
 *
 * @package burido-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class WGL_Header_Mobile_Menu_Button extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-header-mobile_menu_buttton';
    }

    public function get_title()
    {
        return esc_html__('WGL Mobile Menu Button', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-header-mobile_menu_button';
    }

    public function get_keywords() {
        return ['link', 'button', 'mobile', 'menu', 'panel'];
    }

    public function get_categories()
    {
        return ['wgl-header-modules'];
    }

    public function get_script_depends() {
        return [ 'wgl-widgets' ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_side_panel_settings',
            ['label' => esc_html__('Mobile Button', 'burido-core')]
        );

        $this->add_responsive_control(
            'sp_line_width',
            [
                'label' => esc_html__('Line Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 200],
                    '%' => ['min' => 1, 'max' => 100],
                ],
                'selectors' => [
				    '{{WRAPPER}} .hamburger-box .hamburger-inner,
                     {{WRAPPER}} .hamburger-box .hamburger-inner span' => 'width: {{SIZE}}{{UNIT}};',
			    ],
            ]
        );

        $this->add_responsive_control(
            'sp_width',
            [
                'label' => esc_html__('Button Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 30, 'max' => 200],
                    '%' => ['min' => 5, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .hamburger-box' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sp_height',
            [
                'label' => esc_html__('Button Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 30, 'max' => 250],
                    '%' => ['min' => 5, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .hamburger-box' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['sp_width!' => 0],
                'options' => [
                    'margin-right' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'margin' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'margin-left' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}' => '{{VALUE}}: auto;',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .hamburger-box',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hamburger-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'sp_color_tabs',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_color_idle',
            ['label' => esc_html__('Idle' , 'burido-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .hamburger-box' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .hamburger-box' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_bg_idle',
            [
                'label' => esc_html__('Item Background', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .hamburger-box' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'item_bg_idle-dynamic',
            [
                'label' => esc_html__('Item Background - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'item_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .hamburger-box' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_color_hover',
            ['label' => esc_html__('Hover' , 'burido-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .hamburger-box' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}:hover .hamburger-box' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_bg_hover',
            [
                'label' => esc_html__('Item Background', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .hamburger-box' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'item_bg_hover-dynamic',
            [
                'label' => esc_html__('Item Background - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'item_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}:hover .hamburger-box' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * GENERAL -> CURSOR
         */

        WGL_Cursor::init(
            $this,
            [
                'section' => true,
            ]
        );
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        if (isset($_s['cursor_tooltip']) && '' != $_s['cursor_tooltip']) {
            add_filter( 'wgl/burido_module_cursor', function () { return true; });
        }

        $cursor = new WGL_Cursor;
        $cursor_data = $cursor->build($this, $_s);

        $this->add_render_attribute('button', [
            'class' => [
                'hamburger-box',
                ( isset($_s['cursor_tooltip']) && !empty($_s['cursor_tooltip']) ? ' wgl-cursor-text' : '' )
            ],
            'title' => esc_attr__('Open', 'burido-core')
        ]);

        echo'<div class="mobile-hamburger-toggle mobile-hamburger-module">',
                '<div ', $this->get_render_attribute_string('button'), $cursor_data, '>',
                    '<span class="hamburger-inner">',
                        '<span></span>',
                        '<span></span>',
                        '<span></span>',
                    '</span>',
                '</div>',
            '</div>';


    }
}