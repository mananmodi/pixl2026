<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-tabs.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Frontend,
    Group_Control_Box_Shadow,
    Widget_Base,
    Utils,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Control_Media,
    Group_Control_Image_Size,
    Icons_Manager,
    Repeater,
    Group_Control_Background};
use WGL_Extensions\{
    Includes\WGL_Elementor_Helper,
    WGL_Framework_Global_Variables as WGL_Globals
};

class WGL_Tabs extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-tabs';
    }

    public function get_title()
    {
        return esc_html__('WGL Tabs', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-tabs';
    }

    public function get_keywords()
    {
        return [ 'tabs', 'text' ];
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    protected function register_controls() {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            [ 'label' => esc_html__( 'General', 'burido-core' ) ]
        );

        $this->add_responsive_control(
            'tabs_tab_align',
            [
                'label' => esc_html__( 'Title Alignment', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'burido-core' ),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'burido-core' ),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'space_between' => [
                        'title' => esc_html__( 'Space Between', 'burido-core' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    'space_evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'burido-core' ),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'space_around' => [
                        'title' => esc_html__( 'Space Around', 'burido-core' ),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Equal Width', 'burido-core' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'tabs_tab_width',
            [
                'label' => esc_html__( 'Title Wrapper Full Width', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_headings' => 'width: 100%;',
                ],
            ]
        );

        $this->add_control(
            'tabs_tab_lavalamp_enabled',
            [
                'label' => esc_html__( 'Use Lavalamp Animation', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'tabs_tab_divider_enabled',
            [
                'label' => esc_html__( 'Use Divider', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_content',
            [ 'label' => esc_html__( 'Content', 'burido-core' ) ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'tabs_tab_title',
            [
                'label' => esc_html__( 'Tab Title', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'default' => esc_html__( 'Tab Title', 'burido-core' ),
            ]
        );

        $repeater->add_control(
            'tabs_tab_icon_type',
            [
                'label' => esc_html__( 'Add Icon/Image', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'None', 'burido-core' ),
                        'icon' => 'eicon-ban',
                    ],
                    'font' => [
                        'title' => esc_html__( 'Icon', 'burido-core' ),
                        'icon' => 'fa fa-smile',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'burido-core' ),
                        'icon' => 'far fa-image',
                    ]
                ],
                'default' => '',
            ]
        );
        $repeater->add_control(
            'tabs_tab_icon_fontawesome',
            [
                'label' => esc_html__( 'Icon', 'burido-core' ),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'condition' => [
                    'tabs_tab_icon_type' => 'font',
                ],
                'description' => esc_html__( 'Select icon from Fontawesome library.', 'burido-core' ),
            ]
        );
        $repeater->add_control(
            'tabs_tab_icon_thumbnail',
            [
                'label' => esc_html__( 'Image', 'burido-core' ),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'condition' => [
                    'tabs_tab_icon_type' => 'image',
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'tabs_content_type',
            [
                'label' => esc_html__( 'Content Type', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => esc_html__( 'Content', 'burido-core' ),
                    'template' => esc_html__( 'Saved Templates', 'burido-core' ),
                ],
                'default' => 'content',
            ]
        );
        $repeater->add_control(
            'tabs_content_templates',
            [
                'label' => esc_html__( 'Choose Template', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => WGL_Elementor_Helper::get_instance()->get_elementor_templates(),
                'condition' => [
                    'tabs_content_type' => 'template',
                ],
            ]
        );
        $repeater->add_control(
            'tabs_content',
            [
                'label' => esc_html__( 'Tab Content', 'burido-core' ),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'burido-core' ),
                'condition' => [
                    'tabs_content_type' => 'content',
                ],
            ]
        );

        $this->add_control(
            'tabs_tab',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [ 'tabs_tab_title' => esc_html__( 'Tab Title 1', 'burido-core' ) ],
                    [ 'tabs_tab_title' => esc_html__( 'Tab Title 2', 'burido-core' ) ],
                    [ 'tabs_tab_title' => esc_html__( 'Tab Title 3', 'burido-core' ) ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{tabs_tab_title}}',
            ]
        );

        $this->end_controls_section();

        /** STYLE -> HEADINGS SECTION */

        $this->start_controls_section(
            'style_headings_section',
            [
                'label' => esc_html__( 'Headings Section', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'headings_section_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_headings' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'headings_section_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_headings' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'headings_section_border',
                'fields_options' => [
                    'border' => [ 'default' => '' ],
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                        'default' => [
                            'top' => '0',
                            'right' => '0',
                            'bottom' => '1',
                            'left' => '0',
                        ]
                    ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .wgl-tabs_headings',
            ]
        );

        $this->add_responsive_control(
            'headings_section_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_headings' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'headings_section_bg',
                'selector' => '{{WRAPPER}} .wgl-tabs_headings',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__( 'Title', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tabs_title_typo',
                'selector' => '{{WRAPPER}} .wgl-tabs_title',
            ]
        );

        $this->add_control(
            'tabs_title_tag',
            [
                'label' => esc_html__( 'Title HTML Tag', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html( '‹h1›' ),
                    'h2' => esc_html( '‹h2›' ),
                    'h3' => esc_html( '‹h3›' ),
                    'h4' => esc_html( '‹h4›' ),
                    'h5' => esc_html( '‹h5›' ),
                    'h6' => esc_html( '‹h6›' ),
                    'div' => esc_html( '‹div›' ),
                ],
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '6',
                    'right' => '0',
                    'bottom' => '6',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_gap',
            [
                'label' => esc_html__( 'Gap', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'em', 'vw', 'custom' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 22,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'selector' => '{{WRAPPER}} .wgl-tabs_header',
            ]
        );

        $this->add_responsive_control(
            'title_width',
            [
                'label' => esc_html__( 'Title Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'render_type' => 'template',
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_min_width',
            [
                'label' => esc_html__( 'Title Min Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'render_type' => 'template',
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_header_tabs' );
        $this->start_controls_tab(
            'tabs_header_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__( 'Title Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_idle-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_color_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_border_border!' => ['', 'none'],
                    'title_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            't_title_border_radius_idle',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_header_hover',
            [ 'label' => esc_html__( 'Hover', 'burido-core' ) ]
        );
        $this->add_control(
            't_title_color_hover',
            [
                'label' => esc_html__( 'Title Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_color_hover-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['t_title_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_bg_color_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['t_title_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_border_border!' => ['', 'none'],
                    'title_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            't_title_border_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            't_header_active',
            [ 'label' => esc_html__( 'Active', 'burido-core' ) ]
        );
        $this->add_control(
            't_title_color_active',
            [
                'label' => esc_html__( 'Title Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_color_active-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['t_title_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_bg_color_active',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_bg_color_active-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['t_title_bg_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_active',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_active-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_border_border!' => ['', 'none'],
                    'title_border_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header.active' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            't_title_border_radius_active',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'default' => [
                    'size' => 26,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_icon:not(.wgl-tabs_icon-image)' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_icon_position',
            [
                'label' => esc_html__( 'Icon/Image Position', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'column-reverse' => [
                        'title' => esc_html__( 'Top', 'burido-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'row' => [
                        'title' => esc_html__( 'Right', 'burido-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column' => [
                        'title' => esc_html__( 'Bottom', 'burido-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__( 'Left', 'burido-core' ),
                        'icon' => 'eicon-h-align-left',
                    ]
                ],
                'default' => 'column-reverse',
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_icon_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_icon_tabs' );
        $this->start_controls_tab(
            'tabs_icon_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'tabs_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_icon_color-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tabs_icon_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_icon' => 'color: {{VALUE}};',
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_icon_hover',
            [ 'label' => esc_html__( 'Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'tabs_icon_color_hover',
            [
                'label' => esc_html__( 'Icon Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover .wgl-tabs_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-tabs_header:hover .wgl-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tabs_icon_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header:hover .wgl-tabs_icon' => 'color: {{VALUE}};',
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header:hover .wgl-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_icon_active',
            [ 'label' => esc_html__( 'Active', 'burido-core' ) ]
        );
        $this->add_control(
            'tabs_icon_color_active',
            [
                'label' => esc_html__( 'Icon Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active .wgl-tabs_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-tabs_header.active .wgl-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_icon_color_active-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tabs_icon_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header.active .wgl-tabs_icon' => 'color: {{VALUE}};',
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header.active .wgl-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> LAVALAMP
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_lavalamp',
            [
                'label' => esc_html__( 'Lavalamp', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'tabs_tab_lavalamp_enabled' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'tabs_lavalamp_width',
            [
                'label' => esc_html__( 'Lavalamp Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'render_type' => 'template',
                'range' => [
                    'px' => [ 'min' => 4, 'max' => 100 ],
                ],
                'condition' => [ 'tabs_tab_lavalamp_enabled' => 'yes' ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .lavalamp-object::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_lavalamp_height',
            [
                'label' => esc_html__( 'Lavalamp Height', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'render_type' => 'template',
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 50 ],
                ],
                'condition' => ['tabs_tab_lavalamp_enabled' => 'yes'],
                'default' => [ 'size' => 1, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .lavalamp-object::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_lavalamp_margin',
            [
                'label' => esc_html__( 'Lavalamp Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['bottom', 'left'],
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => [ 'tabs_tab_lavalamp_enabled' => 'yes' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .lavalamp-object' => 'margin: auto auto {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_lavalamp_radius',
            [
                'label' => esc_html__( 'Lavalamp Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => [ 'tabs_tab_lavalamp_enabled' => 'yes' ],
                'selectors' => [
                    '{{WRAPPER}} .lavalamp-object::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_lavalamp_align',
            [
                'label' => esc_html__( 'Lavalamp Alignment', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
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
                'default' => 'center',
                'condition' => [ 'tabs_tab_lavalamp_enabled' => 'yes' ],
                'selectors' => [
                    '{{WRAPPER}} .lavalamp-object' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tabs_lavalamp_color_active',
            [
                'label' => esc_html__( 'Lavalamp Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'tabs_tab_lavalamp_enabled' => 'yes' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs.has-lavalamp .lavalamp-object::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_lavalamp_color_active-dynamic',
            [
                'label' => esc_html__('Lavalamp Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tabs_lavalamp_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs.has-lavalamp .lavalamp-object::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_lavalamp_z_index',
            [
                'label' => esc_html__('Z-Index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .lavalamp-object' => 'z-index: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> DIVIDER
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_divider',
            [
                'label' => esc_html__( 'Divider', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'tabs_tab_divider_enabled' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'tabs_title_divider_height',
            [
                'label' => esc_html__( 'Divider Height', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 100 ],
                ],
                'default' => [ 'size' => 3 ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_title_divider_width',
            [
                'label' => esc_html__( 'Divider Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    '%' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_title_divider_align',
            [
                'label' => esc_html__( 'Divider Alignment', 'burido-core' ),
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
                ],
                'selectors_dictionary' => [
                    'left' => 'left: 0;',
                    'center' => 'left: auto; right: auto',
                    'right' => 'left: auto; right: 0;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header::after' => ' {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tabs_title_divider_border_radius',
            [
                'label' => esc_html__('Circle Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_title_divider_border',
                'render_type' => 'template',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .wgl-tabs_header::after',
            ]
        );

        $this->start_controls_tabs( 'tabs_header_divider' );
        $this->start_controls_tab(
            'tabs_header_divider_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            't_title_divider_color_idle',
            [
                'label' => esc_html__( 'Divider Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_color_idle-dynamic',
            [
                'label' => esc_html__('Divider Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['t_title_divider_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'tabs_title_divider_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header::after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'tabs_title_divider_border_border!' => ['', 'none'],
                    't_title_divider_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header::after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 't_title_divider_shadow_idle',
                'selector' => '{{WRAPPER}} .wgl-tabs_header::after',
            ]
        );
        $this->add_responsive_control(
            'tabs_title_divider_offset_idle',
            [
                'label' => esc_html__('Divider Offet Top', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [ 'px' => ['min' => -100, 'max' => 100] ],
                'default' => ['size' => -15],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header::after' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_header_divider_hover',
            [ 'label' => esc_html__( 'Hover', 'burido-core' ) ]
        );
        $this->add_control(
            't_title_divider_color_hover',
            [
                'label' => esc_html__( 'Divider Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_color_hover-dynamic',
            [
                'label' => esc_html__('Divider Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['t_title_divider_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header:hover::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'tabs_title_divider_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover::after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'tabs_title_divider_border_border!' => ['', 'none'],
                    't_title_divider_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header:hover::after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 't_title_divider_shadow_hover',
                'selector' => '{{WRAPPER}} .wgl-tabs_header:hover::after',
            ]
        );
        $this->add_responsive_control(
            'tabs_title_divider_offset_hover',
            [
                'label' => esc_html__('Divider Offet Top', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [ 'px' => ['min' => -100, 'max' => 100] ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header:hover::after' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_header_divider_active',
            [ 'label' => esc_html__( 'Active', 'burido-core' ) ]
        );
        $this->add_control(
            't_title_divider_color_active',
            [
                'label' => esc_html__( 'Divider Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_color_active-dynamic',
            [
                'label' => esc_html__('Divider Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['t_title_divider_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header.active::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_border_color_active',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'tabs_title_divider_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active::after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            't_title_divider_border_color_active-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'tabs_title_divider_border_border!' => ['', 'none'],
                    't_title_divider_border_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_header.active::after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 't_title_divider_shadow_active',
                'selector' => '{{WRAPPER}} .wgl-tabs_header.active::after',
            ]
        );
        $this->add_responsive_control(
            'tabs_title_divider_offset_active',
            [
                'label' => esc_html__('Divider Offet Top', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [ 'px' => ['min' => -100, 'max' => 100] ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_header.active::after' => 'transform: translateY({{SIZE}}{{UNIT}});',
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
            'section_style_content',
            [
                'label' => esc_html__( 'Content', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tabs_content_typo',
                'selector' => '{{WRAPPER}} .wgl-tabs_content',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '24',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_content_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_content_color',
            [
                'label' => esc_html__( 'Content Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_content_color-dynamic',
            [
                'label' => esc_html__('Content Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tabs_content_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_content_bg_color',
            [
                'label' => esc_html__( 'Content Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_content_bg_color-dynamic',
            [
                'label' => esc_html__('Content Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['tabs_content_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-tabs_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_content_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-tabs_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_content_border',
                'selector' => '{{WRAPPER}} .wgl-tabs_content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $_s = $this->get_settings_for_display();
        $id_int = substr( $this->get_id_int(), 0, 3 );

        $this->add_render_attribute(
            'tabs',
            [
                'class' => [
                    'wgl-tabs',
                    'wgl-tabs_swiper-wrapper',

                    (!empty($_s['tabs_tab_align']) ? 'tabs_align-'.$_s['tabs_tab_align'] : ''),
                    (!empty($_s['tabs_tab_align_tablet']) ? 'tabs_align-tablet-'.$_s['tabs_tab_align_tablet'] : ''),
                    (!empty($_s['tabs_tab_align_mobile']) ? 'tabs_align-mobile-'.$_s['tabs_tab_align_mobile'] : ''),

                    (!empty($_s['tabs_tab_divider_enabled']) ? 'has-divider' : ''),
                    (!empty($_s['tabs_tab_lavalamp_enabled']) ? 'has-lavalamp' : ''),
                    (!empty($_s['tabs_lavalamp_align']) ? 'tabs_lavalamp_align-'.$_s['tabs_lavalamp_align'] : ''),
                ],
            ]
        );

        ?><div <?php echo $this->get_render_attribute_string( 'tabs' ); ?>>
            <div class="wgl-tabs_headings-wrap swiper">
                <div class="wgl-tabs_headings swiper-wrapper"><?php

                    foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

                    $tab_count = $index + 1;
                    $tab_title_key = $this->get_repeater_setting_key( 'tabs_tab_title', 'tabs_tab', $index );
                    $this->add_render_attribute(
                        $tab_title_key,
                        [
                            'data-tab-id' => 'wgl-tab_' . $id_int . $tab_count,
                            'class' => [
                                'wgl-tabs_header',
                                'swiper-slide',
                            ],
                        ]
                    );


                    ?><<?php echo $_s[ 'tabs_title_tag' ]. ' ' . $this->get_render_attribute_string( $tab_title_key ); ?>>
                    <span class="wgl-tabs_title"><?php echo $item[ 'tabs_tab_title' ] ?></span>

                    <?php
                    // Tab Icon/image
                    if ( $item[ 'tabs_tab_icon_type' ] != '' ) {
                        if ( $item[ 'tabs_tab_icon_type' ] == 'font' && (!empty( $item[ 'tabs_tab_icon_fontawesome' ] )) ) {

                            $icon_font = $item[ 'tabs_tab_icon_fontawesome' ];
                            $icon_out = '';
                            // add icon migration
                            $migrated = isset( $item['__fa4_migrated'][$item[ 'tabs_tab_icon_fontawesome' ]] );
                            $is_new = Icons_Manager::is_migration_allowed();
                            if ( $is_new || $migrated ) {
                                ob_start();
                                Icons_Manager::render_icon( $item[ 'tabs_tab_icon_fontawesome' ], [ 'aria-hidden' => 'true' ] );
                                $icon_out .= ob_get_clean();
                            } else {
                                $icon_out .= '<i class="icon '.esc_attr($icon_font).'"></i>';
                            }

                            ?><span class="wgl-tabs_icon"><?php echo $icon_out; ?></span><?php
                        }
                        if ($item['tabs_tab_icon_type'] == 'image' && !empty($item['tabs_tab_icon_thumbnail'])) {
                            if (!empty($item['tabs_tab_icon_thumbnail']['url'])) {

                                $this->add_render_attribute(
                                    'thumbnail', [
                                    'src' => $item['tabs_tab_icon_thumbnail']['url'],
                                    'alt' => Control_Media::get_image_alt($item['tabs_tab_icon_thumbnail']),
                                    'title' => Control_Media::get_image_title($item['tabs_tab_icon_thumbnail']),
                                ] );
                                ?>
                                <span class="wgl-tabs_icon wgl-tabs_icon-image"><?php
                                echo Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'tabs_tab_icon_thumbnail'); ?>
                                </span><?php
                            }
                        }
                    }
                    // End Tab Icon/image
                    ?>

                </<?php echo $_s[ 'tabs_title_tag' ]; ?>><?php

                endforeach;
            ?></div>
        </div>

        <div class="wgl-tabs_content-wrap"><?php
            foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

                $tab_count = $index + 1;
                $tab_content_key = $this->get_repeater_setting_key( 'tab_content', 'tabs_tab', $index );
                $this->add_render_attribute(
                    $tab_content_key,
                    [
                        'data-tab-id' => 'wgl-tab_' . $id_int . $tab_count,
                        'class' => [ 'wgl-tabs_content' ],
                    ]
                );

                ?>
                <div <?php echo $this->get_render_attribute_string( $tab_content_key ); ?>>
                    <?php
                    if ( $item[ 'tabs_content_type' ] == 'content' ) {
                        echo do_shortcode( $item[ 'tabs_content' ] );
                    } else if ( $item[ 'tabs_content_type' ] == 'template' ) {
                        $id = $item[ 'tabs_content_templates' ];
                        $wgl_frontend = new Frontend;
                        echo $wgl_frontend->get_builder_content_for_display( $id );
                    }
                    ?>
                </div>

            <?php endforeach; ?>
        </div>
        </div><!-- .wgl-tabs -->
        <?php

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