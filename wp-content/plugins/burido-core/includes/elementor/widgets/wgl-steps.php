<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-steps.php`.
 */

namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Utils,
    Icons_Manager,
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Repeater,
    Group_Control_Image_Size,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography
};
use WGL_Extensions\Includes\WGL_Carousel_Settings;
use WGL_Extensions\WGL_Framework_Global_Variables as WGL_Globals;

class Wgl_Steps extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-steps';
    }

    public function get_title()
    {
        return esc_html__('WGL Steps', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-steps';
    }

    public function get_keywords()
    {
        return ['time', 'line', 'timeline', 'date', 'history', 'steps'];
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    public function get_script_depends()
    {
        return ['swiper', 'wgl-widgets'];
    }

    public function get_style_depends()
    {
        return [ 'swiper' ];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_steps_section',
            [
                'label' => esc_html__('General', 'burido-core'),
            ]
        );

        $this->add_control(
            'steps_columns',
            [
                'label' => esc_html__('Columns', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'default' => [ 'size' => 4 ],
                'tablet_default' => [ 'size' => 3 ],
                'mobile_default' => [ 'size' => 1 ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'burido-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'steps_icon_type',
            [
                'label' => esc_html__('Add Icon/Image', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'None', 'burido-core' ),
                        'icon' => 'eicon-ban',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'burido-core' ),
                        'icon' => 'far fa-image',
                    ]
                ],
                'default' => 'image',
            ]
        );

        $repeater->add_control(
            'steps_icon_thumbnail',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'condition' => ['steps_icon_type' => 'image'],
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $repeater->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => ['steps_icon_type' => 'image'],
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 20, 'max' => 400, 'step' => 1],
                ],
                'default' => ['size' => 150, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .steps-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'date',
            [
                'label' => esc_html__('Date', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'placeholder' => esc_html__('This is the date', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'default' => esc_html__('This is the heading', 'burido-core'),
                'placeholder' => esc_html__('This is the heading', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'invert',
            [
                'label' => esc_html__('Invert the Image and Content', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'tab_image_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .steps-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->start_controls_tabs( 'tabs_image' );
        $repeater->start_controls_tab(
            'image_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $repeater->add_control(
            'tab_image_bg_color_idle',
            [
                'label' => esc_html__('Image Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'tab_image_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Image Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tab_image_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} {{CURRENT_ITEM}} .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_image_shadow_item_idle',
                'label' => esc_html__('Image Box Shadow', 'burido-core'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .steps-image img',
            ]
        );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'image_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $repeater->add_control(
            'tab_image_bg_color_hover',
            [
                'label' => esc_html__('Image Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.steps-single-wrap:hover .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'tab_image_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Image Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tab_image_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} {{CURRENT_ITEM}}.steps-single-wrap:hover .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_image_shadow_item_hover',
                'label' => esc_html__('Image Box Shadow', 'burido-core'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.steps-single-wrap:hover .steps-image img',
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        $this->add_control(
            'items',
            [
                'label' => esc_html__('Layers', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'date' => esc_html__('1989', 'burido-core'),
                        'title' => esc_html__('First Heading', 'burido-core'),
                        'invert' => 'yes',
                    ],
                    [
                        'date' => esc_html__('1990', 'burido-core'),
                        'title' => esc_html__('Second Heading', 'burido-core'),
                    ],
                    [
                        'date' => esc_html__('1992', 'burido-core'),
                        'title' => esc_html__('Third Heading', 'burido-core'),
                        'invert' => 'yes',
                    ],
                    [
                        'date' => esc_html__('1995', 'burido-core'),
                        'title' => esc_html__('Fourth Heading', 'burido-core'),
                    ],
                    [
                        'date' => esc_html__('1998', 'burido-core'),
                        'title' => esc_html__('Fifth Heading', 'burido-core'),
                        'invert' => 'yes',
                    ]
                ],
                'title_field' => '{{title}}',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CAROUSEL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'carousel_section',
            [
                'label' => esc_html__('Carousel', 'burido-core'),
            ]
        );

        WGL_Carousel_Settings::add_general_controls($this,[
            'slider_alignment_v' => [ 'default' => 'center' ],
            'slider_container_padding' => [
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
            ],
            'animation_style_disable' => true,
        ]);
        WGL_Carousel_Settings::add_pagination_controls($this);
        WGL_Carousel_Settings::add_navigation_controls($this, [
            'use_navigation' => [
                'default' => 'yes',
            ],
            'navigation_position' => [ 'default' => 'nearby' ],
            'navigation_alignment_h' => [ 'default' => 'center' ],
            'navigation_alignment_v' => [ 'default' => 'flex-end' ],
            'navigation_margin' => [
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '-80',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '-40',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
            ],
        ]);
        WGL_Carousel_Settings::add_responsive_controls($this);

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'general_style_section',
            [
                'label' => esc_html__('General', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'line_size',
            [
                'label' => esc_html__('Line Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 50, 'step' => 1],
                ],
                'size_units' => ['px'],
                'default' => ['size' => 1, 'unit' => 'px'],
                'description' => esc_html__('Enter line height in pixels.', 'burido-core'),
                'selectors' => [
                    '{{WRAPPER}} .steps-dot-line::before, {{WRAPPER}} .steps-dot-line::after' => 'height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'line_color_1',
            [
                'label' => esc_html__('Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(0.15),
                'selectors' => [
                    '{{WRAPPER}} .steps-dot-line' => '--color-1: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'line_color_1-dynamic',
            [
                'label' => esc_html__('Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['line_color_1!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-dot-line' => '--color-1: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label' => esc_html__('Dot Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'default' => WGL_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'dot_color-dynamic',
            [
                'label' => esc_html__('Dot Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['dot_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_offset',
            [
                'label' => esc_html__('Dot Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 10, 'max' => 200, 'step' => 2],
                ],
                'size_units' => ['px'],
                'default' => ['size' => 68, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap' => 'grid-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_size',
            [
                'label' => esc_html__('Dot Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 5, 'max' => 50, 'step' => 1],
                ],
                'size_units' => ['px'],
                'default' => ['size' => 9, 'unit' => 'px'],
                'description' => esc_html__('Enter dot size in pixels.', 'burido-core'),
                'selectors' => [
                    '{{WRAPPER}} .steps-dot .dot' => '--dot-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> DATE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'date_style_section',
            [
                'label' => esc_html__('Date', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typo',
                'selector' => '{{WRAPPER}} .steps-date',
            ]
        );

        $this->add_control(
            'date_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '1',
                    'right' => '0',
                    'bottom' => '2',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'date_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'vw', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '13',
                    'bottom' => '0',
                    'left' => '13',
                    'unit' => '%',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('date_colors');
        $this->start_controls_tab(
            'date_colors_idle',
            [
                'label' => esc_html__('Idle', 'burido-core'),
            ]
        );
        $this->add_control(
            'date_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_h_font_color(0.16),
                'selectors' => [
                    '{{WRAPPER}} .steps-date' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'date_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['date_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-date' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'date_colors_hover',
            [
                'label' => esc_html__('Hover', 'burido-core'),
            ]
        );
        $this->add_control(
            'date_hover_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap:hover .steps-date' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'date_hover_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['date_hover_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-single-wrap:hover .steps-date' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .steps-title',
            ]
        );

        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '18',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'vw', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '9',
                    'bottom' => '0',
                    'left' => '9',
                    'unit' => '%',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('title_colors');

        $this->start_controls_tab(
            'title_colors_idle',
            [
                'label' => esc_html__('Idle', 'burido-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .steps-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_colors_hover',
            [
                'label' => esc_html__('Hover', 'burido-core'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap:hover .steps-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_hover_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_hover_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-single-wrap:hover .steps-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typo',
                'selector' => '{{WRAPPER}} .steps-text',
            ]
        );

        $this->add_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '14',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'vw', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '7',
                    'bottom' => '0',
                    'left' => '7',
                    'unit' => '%',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('content_colors');
        $this->start_controls_tab(
            'content_colors_idle',
            [
                'label' => esc_html__('Idle', 'burido-core'),
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .steps-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-content_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_bg_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-content_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .steps-content_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_shadow',
                'selector' => '{{WRAPPER}} .steps-content_wrap',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'content_colors_hover',
            [
                'label' => esc_html__('Hover', 'burido-core'),
            ]
        );

        $this->add_control(
            'content_hover_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap:hover .steps-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_hover_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_hover_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-single-wrap:hover .steps-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap:hover .steps-content_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_hover_bg_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_hover_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-single-wrap:hover .steps-content_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_hover_border',
                'selector' => '{{WRAPPER}} .steps-single-wrap:hover .steps-content_wrap',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_hover_shadow',
                'selector' => '{{WRAPPER}} .steps-single-wrap:hover .steps-content_wrap',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Image
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'image_style_section',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '22',
                    'right' => '0',
                    'bottom' => '22',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .steps-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'images_shadow',
                'selector' => '{{WRAPPER}} .steps-image img',
            ]
        );

        $this->start_controls_tabs( 'tabs_image' );
        $this->start_controls_tab(
            'image_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $this->add_control(
            'image_bg_color_idle',
            [
                'label' => esc_html__('Image Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Image Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'v_line_color_idle',
            [
                'label' => esc_html__('Vertical Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .dot::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'v_line_color_idle-dynamic',
            [
                'label' => esc_html__('Vertical Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['v_line_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dot::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'image_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'image_bg_color_hover',
            [
                'label' => esc_html__('Image Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap:hover .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Image Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-single-wrap:hover .steps-image img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'v_line_color_hover',
            [
                'label' => esc_html__('Vertical Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .steps-single-wrap:hover .dot::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'v_line_color_hover-dynamic',
            [
                'label' => esc_html__('Vertical Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['v_line_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .steps-single-wrap:hover .dot::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        // Allowed HTML tags
        $allowed_html = [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true,
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
            'p' => ['id' => true, 'class' => true, 'style' => true],
            'ul' => ['id' => true, 'class' => true, 'style' => true],
            'ol' => ['id' => true, 'class' => true, 'style' => true],
            'li' => ['id' => true, 'class' => true, 'style' => true],
        ];

        $this->add_render_attribute('steps', [
            'class' => [
                'wgl-steps',
            ],
        ]);

        ?>
    <div <?php echo $this->get_render_attribute_string('steps'); ?>>
        <div class="wgl-steps-wrap"><?php

            ob_start();
            foreach ($_s['items'] as $index => $item) {
                $_content = $_media = $_dot = '';

                $steps_wrap = $this->get_repeater_setting_key('steps_wrap', 'items', $index);
                $this->add_render_attribute(
                    $steps_wrap, [
                        'class' => [
                            'steps-single-wrap',
                            'elementor-repeater-item-' . $item['_id'],
                            $item['invert'] === 'yes' ? 'steps-single-invert' : '',
                            'swiper-slide',
                        ]
                    ]
                );

                $date = $this->get_repeater_setting_key('date', 'items', $index);
                $this->add_render_attribute( $date,
                    ['class' => 'steps-date']
                );

                $title = $this->get_repeater_setting_key('title', 'items', $index);
                $this->add_render_attribute( $title,
                    ['class' => 'steps-title']
                );

                if ($item['steps_icon_type'] !== '') {
                    if ($item['steps_icon_type'] === 'image' && !empty($item['steps_icon_thumbnail'])) {
                        if (!empty($item['steps_icon_thumbnail']['url'])) {
                            $this->add_render_attribute('thumbnail', 'src', $item['steps_icon_thumbnail']['url']);
                            $this->add_render_attribute('thumbnail', 'alt', Control_Media::get_image_alt($item['steps_icon_thumbnail']));
                            $this->add_render_attribute('thumbnail', 'title', Control_Media::get_image_title($item['steps_icon_thumbnail']));

                            $_media .= '<div class="steps-same_height steps-media steps-image">' . Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'steps_icon_thumbnail') . '</div>';
                        }
                    } else {
                        $_media .= '<div class="steps-same_height steps-media steps-empty"></div>';
                    }
                } else {
                    $_media .= '<div class="steps-same_height steps-media steps-empty"></div>';
                }
                // End Tab Icon/image

                $_dot .= '<div class="steps-dot">';
                    $_dot .= '<i class="steps-dot-line"></i>';
                    $_dot .= '<span class="dot"></span>';
                $_dot .= '</div>';

                $_content .= '<div class="steps-same_height steps-content_wrap">';
                if (!empty($item['date'])) {
                    $_content .= '<h4 ' . $this->get_render_attribute_string($date) . '>' . $item['date'] . '</h4>';
                }
                if (!empty($item['title'])) {
                    $_content .= '<h3 ' . $this->get_render_attribute_string($title) . '>' . $item['title'] . '</h3>';
                }
                if (!empty($item['content'])) {
                    $_content .= '<div class="steps-text">' . wp_kses($item['content'], $allowed_html) . '</div>';
                }
                $_content .= '</div>';

                echo '<div ' . $this->get_render_attribute_string($steps_wrap) . '>',
                    $_media,
                    $_dot,
                    $_content,
                '</div>';

            } // end foreach

            $content = ob_get_clean();

            echo $this->apply_carousel_settings($content);

            ?>
        </div>
        </div><?php
    }

    protected function apply_carousel_settings($content)
    {
        $_s = $this->get_settings_for_display();
        $_s['slides_per_row'] = $_s['steps_columns']['size'] ?? 4;

        return WGL_Carousel_Settings::init($_s, $content);
    }

    public function wpml_support_module() {
        add_filter( 'wpml_elementor_widgets_to_translate',  [$this, 'wpml_widgets_to_translate_filter']);
    }

    public function wpml_widgets_to_translate_filter( $widgets ){
        return \WGL_Extensions\Includes\WGL_WPML_Settings::get_translate(
            $this, $widgets
        );
    }
}
