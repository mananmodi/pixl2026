<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-counter.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Text_Stroke,
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Icons
};

class WGL_Counter extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-counter';
    }

    public function get_title()
    {
        return esc_html__('WGL Counter', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-counter';
    }

    public function get_keywords()
    {
        return [ 'counter' ];
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    public function get_script_depends()
    {
        return ['jquery-appear'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_counter_content',
            ['label' => esc_html__('General', 'burido-core')]
        );

        WGL_Icons::init(
            $this,
            [
                'label' => esc_html__('Counter ', 'burido-core'),
                'output' => '',
                'section' => false,
                'default' => [
                    'media_type' => '',
                    'icon' => [
                        'library' => 'solid',
                        'value' => 'fas fa-icons'
                    ],
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'burido-core'),
                'type' => 'wgl-radio-image',
                'condition' => ['icon_type!' => ''],
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_def.png',
                    ],
                    'left' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_left.png',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_right.png',
                    ],
                ],
                'default' => 'left',
            ]
        );

        $this->add_control(
            'counter_title',
            [
                'label' => esc_html__('Title Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'label_block' => true,
                'default' => esc_html__('Counter Title', 'burido-core'),
            ]
        );

        $this->add_control(
            'title_block',
            [
                'label' => esc_html__('Title Full Width', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_top',
            [
                'label' => esc_html__('Title Position Top', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['title_block!' => ''],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'counter_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'start_value',
            [
                'label' => esc_html__('Start Value', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'min' => 0,
                'step' => 1,
                'default' => 0,
            ]
        );

        $this->add_control(
            'end_value',
            [
                'label' => esc_html__('End Value', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => 1,
                'step' => 1,
                'default' => 420,
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => esc_html__('Counter Prefix', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => esc_html__('Counter Suffix', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('ex: +', 'burido-core'),
            ]
        );

        $this->add_control(
            'slidesTransition',
            [
                'label' => esc_html__('Animation Speed', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => 100,
                'step' => 100,
                'default' => 1200,
            ]
        );

        $this->add_control(
            'thousand_sep',
            [
                'label' => esc_html__('Thousand Separator', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'burido-core'),
                    '.' => esc_html__('Dot', 'burido-core'),
                    ',' => esc_html__('Сomma', 'burido-core'),
                    ' ' => esc_html__('Space', 'burido-core'),
                ],
                'default' => '.',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
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
                    ]
                ],
                'default' => 'left',
                'prefix_class' => 'a%s',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> GENERAL
         */

        $this->start_controls_section(
            'counter_style_section',
            [
                'label' => esc_html__('General', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'counter_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'counter_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '8',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'counter_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('counter_color_tab');

        $this->start_controls_tab(
            'custom_counter_color_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'bg_counter_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'bg_counter_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_counter_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-counter' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_border',
                'label' => esc_html__('Border Type', 'burido-core'),
                'selector' => '{{WRAPPER}} .wgl-counter',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_shadow',
                'selector' => '{{WRAPPER}} .wgl-counter',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_counter_color_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'bg_counter_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-counter' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'bg_counter_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_counter_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}:hover .wgl-counter' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_border_hover',
                'label' => esc_html__('Border Type', 'burido-core'),
                'selector' => '{{WRAPPER}}:hover .wgl-counter',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_shadow_hover',
                'selector' => '{{WRAPPER}}:hover .wgl-counter',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> MEDIA
         */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type!' => ''],
            ]
        );
        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['icon_type' => 'font'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'primary_color-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['primary_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => ['icon_type' => 'font'],
                'range' => [
                    'px' => ['min' => 13, 'max' => 200],
                ],
                'default' => ['size' => 30],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_max_width',
            [
                'label' => esc_html__( 'Max Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [ 'icon_type' => 'image' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 768 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '17',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'counter_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_background',
                'label' => esc_html__('Background', 'burido-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .media-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_icon_border',
                'selector' => '{{WRAPPER}} .media-wrapper'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_icon_shadow',
                'selector' => '{{WRAPPER}} .media-wrapper',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> VALUE
         */

        $this->start_controls_section(
            'value_style_section',
            [
                'label' => esc_html__('Value', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'value_overflow',
            [
                'label' => esc_html__('Overflow', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Theme Default', 'burido-core'),
                    'overflow: visible;' => esc_html__('Visible', 'burido-core'),
                    'overflow: hidden;' => esc_html__('Hidden', 'burido-core'),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__value-wrap' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'value_offset',
            [
                'label' => esc_html__('Value Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__value-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'value_font_family',
            [
                'label' => esc_html__('Theme Font Family', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'burido-core'),
                    'header' => esc_html__('Headings Font', 'burido-core'),
                    'content' => esc_html__('Content Font', 'burido-core'),
                    'additional' => esc_html__('Additional Font', 'burido-core'),
                ],
                'default' => 'header',
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__value-wrap' => 'font-family: var(--burido-{{VALUE}}-font-family);',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_value',
                'selector' => '{{WRAPPER}} .wgl-counter__value-wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'value_on_bg_color',
                'selector' => '{{WRAPPER}} .wgl-counter__value-wrap',
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__value-wrap' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'value_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['value_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-counter__value-wrap' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> TITLE
         */

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html('‹h1›'),
                    'h2' => esc_html('‹h2›'),
                    'h3' => esc_html('‹h3›'),
                    'h4' => esc_html('‹h4›'),
                    'h5' => esc_html('‹h5›'),
                    'h6' => esc_html('‹h6›'),
                    'div' => esc_html('‹div›'),
                    'span' => esc_html('‹span›'),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'title_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-counter_title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_title' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-counter_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_divider',
            [
                'label' => esc_html__('Title Divider', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'title_divider_color',
            [
                'label' => esc_html__('Divider Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['title_divider!' => ''],
                'default' => WGL_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_divider' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_divider_color-dynamic',
            [
                'label' => esc_html__('Divider Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_divider!' => '',
                    'title_divider_color!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-counter_divider' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> PREFIX
         */

        $this->start_controls_section(
            'prefix_style_section',
            [
                'label' => esc_html__('Prefix', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['prefix!' => ''],
            ]
        );

        $this->add_responsive_control(
            'prefix_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__prefix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_prefix',
                'selector' => '{{WRAPPER}} .wgl-counter__prefix',
            ]
        );

        $this->add_control(
            'prefix_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__prefix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'prefix_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['prefix_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-counter__prefix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> SUFFIX
         */

        $this->start_controls_section(
            'suffix_style_section',
            [
                'label' => esc_html__('Suffix', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['suffix!' => ''],
            ]
        );

        $this->add_responsive_control(
            'suffix_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__suffix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_suffix',
                'selector' => '{{WRAPPER}} .wgl-counter__suffix',
            ]
        );

        $this->add_control(
            'suffix_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter__suffix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'suffix_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['suffix_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-counter__suffix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-counter_content',
            ]
        );
        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_content' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-counter_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        $kses_allowed_html = [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true,
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'i' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
            'p' => ['id' => true, 'class' => true, 'style' => true],
            'small' => ['id' => true, 'class' => true, 'style' => true],
            'ul' => ['id' => true, 'class' => true, 'style' => true],
            'ol' => ['id' => true, 'class' => true, 'style' => true],
            'li' => ['id' => true, 'class' => true, 'style' => true],
        ];

        $this->add_render_attribute(
            [
                'counter' => [
                    'class' => [
                        'wgl-counter',
                        $_s['title_block'] ? 'title-block' : 'title-inline',
                    ],
                ],
                'counter-wrap' => [
                    'class' => [
                        'wgl-counter_wrap',
                        $_s['layout'] ? 'wgl-layout-' . $_s['layout'] : '',
                    ],
                ],
                'counter_value' => [
                    'class' => 'wgl-counter__value',
                    'data-start-value' => $_s['start_value'] ?? 0,
                    'data-end-value' => $_s['end_value'] ?? 100,
                    'data-speed' => $_s['speed'] ?? 1200,
                    'data-sep' => $_s['thousand_sep'],
                ],
            ]
        );

        // Icon/Image
        ob_start();
        if (!empty($_s['icon_type'])) {
            $icons = new WGL_Icons;
            echo $icons->build($this, $_s, []);
        }
        $counter_media = ob_get_clean();

        // Title
        $counter_title = $_s['counter_title'] ? '<' . $_s['title_tag'] . ' class="wgl-counter_title">' . $_s['counter_title'] . '</' . $_s['title_tag'] . '>' : '';

        // Divider
        $counter_divider = $_s['title_divider'] ? '<div class="wgl-counter_divider"></div>' : '';

        $_s['prefix'] = !empty($_s['prefix']) ? $_s['prefix'] : '';

        // Render
        echo '<div ', $this->get_render_attribute_string('counter'), '>';
        echo '<div ', $this->get_render_attribute_string('counter-wrap'), '>';
        if ($_s['icon_type'] != '' && $counter_media) {
            echo '<div class="media-wrap">',
            $counter_media,
            '</div>';
        }

        echo '<div class="content-wrap">';

        // title top
        if (!empty($counter_title) && $_s['title_top']) {
            echo $counter_title , $counter_divider;
        }
        echo '<div class="wgl-counter__value-wrap"><div class="wgl-counter__value-inner">';

        if ($_s['prefix']) {
            echo '<span class="wgl-counter__prefix">', $_s['prefix'], '</span>';
        }
        if (!empty($_s['end_value'])) {
            echo '<div class="wgl-counter__placeholder-wrap">';

            echo '<span class="wgl-counter__placeholder">',
            preg_replace('/\B(?=(\d{3})+(?!\d))/',$_s['thousand_sep'],$_s['end_value']),
            '</span>';

            echo '<span ', $this->get_render_attribute_string('counter_value'), '>',
            $_s['start_value'],
            '</span>';
            echo '</div>';
        }
        if (!empty($_s['suffix'])) {
            echo '<span class="wgl-counter__suffix">',
            $_s['suffix'],
            '</span>';
        }
        echo '</div></div>';

        // title bottom
        if (!empty($counter_title) && !$_s['title_top']) {
            echo $counter_divider , $counter_title ;
        }

        if (!empty($_s['counter_content'])) {
            echo '<div class="wgl-counter_content">',wp_kses($_s['counter_content'], $kses_allowed_html),'</div>';
        }

        echo '</div>'; // content-wrap

        echo '</div>';
        echo '</div>';
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
