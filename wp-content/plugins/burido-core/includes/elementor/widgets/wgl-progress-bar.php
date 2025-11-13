<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-progress-bar.php`.
 */
namespace WGL_Extensions\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use Elementor\{Group_Control_Background,
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow};
use WGL_Extensions\WGL_Framework_Global_Variables as WGL_Globals;

class WGL_Progress_Bar extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-progress-bar';
    }

    public function get_title()
    {
        return esc_html__( 'WGL Progress Bar', 'burido-core' );
    }

    public function get_icon()
    {
        return 'wgl-progress-bar';
    }

    public function get_keywords()
    {
        return [ 'progress', 'bar' ];
    }

    public function get_categories()
    {
        return [ 'wgl-modules' ];
    }

    public function get_script_depends()
    {
        return [
            'jquery-appear'
        ];
    }

    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'content_general',
            [ 'label' => esc_html__( 'General', 'burido-core' ) ]
        );

        $this->add_control(
            'title_text',
            [
                'label' => esc_html__( 'Title', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__( 'ex: Progress Bar Title', 'burido-core' ),
                'default' => esc_html__( 'Progress Bar Title', 'burido-core' ),
            ]
        );

        $this->add_control(
            'value_progress',
            [
                'label' => esc_html__( 'Progress Value', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => 0,
                'placeholder' => 60,
                'default' => 60,
            ]
        );

        $this->add_control(
            'value_maximum',
            [
                'label' => esc_html__( 'Maximum Value', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => 1,
                'placeholder' => 100,
                'default' => 100,
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

        $this->add_control(
            'units_text',
            [
                'label' => esc_html__( 'Units', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'placeholder' => esc_attr__( 'ex: %, px, points, etc.', 'burido-core' ),
                'default' => esc_html__( '%', 'burido-core' ),
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-progress-bar.init .content__value' => 'transition: {{VALUE}}ms;',
                ],
            ]
        );

        $this->add_control(
            'value_position',
            [
                'label' => esc_html__( 'Value Position', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'separator' => 'before',
                'options' => [
                    'fixed' => esc_html__( 'Top Fixed', 'burido-core' ),
                    'dynamic' => esc_html__( 'Top Dynamic', 'burido-core' ),
                    'dynamic_middle' => esc_html__( 'Middle Dynamic', 'burido-core' ),
                    'aside' => esc_html__( 'Aside', 'burido-core' ),
                ],
                'default' => 'dynamic_middle',
            ]
        );

        $this->add_control(
            'units_position',
            [
                'label' => esc_html__( 'Units Position', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '-1' => esc_html__( 'Before', 'burido-core' ),
                    '1' => esc_html__( 'After', 'burido-core' ),
                ],
                'condition' => [ 'units_text!' => '' ],
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} .placeholder__unit,
                     {{WRAPPER}} .value__unit' => 'order: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'condition' => [ 'value_position' => 'fixed' ],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'burido-core' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                ],
                'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .progress__content' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> CONTAINER */

        $this->start_controls_section(
            'style_container',
            [
                'label' => esc_html__( 'Container', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'container_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-progress-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-progress-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-progress-bar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_bg',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-progress-bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_bg-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['container_bg!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-progress-bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> TITLE */

        $this->start_controls_section(
            'style_title',
            [
                'label' => esc_html__( 'Title', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'title_text!' => '' ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .progress__content, {{WRAPPER}} .progress__value',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'HTML Tag', 'burido-core' ),
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
            'title_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '12',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .content__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .content__label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .content__label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .content__label' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .content__label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .content__label' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_bg!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .content__label' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> VALUE */

        $this->start_controls_section(
            'style_value',
            [
                'label' => esc_html__( 'Value', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'value_typography',
                'selector' => '{{WRAPPER}} .content__value',
            ]
        );

        $this->add_responsive_control(
            'value_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '-1',
                    'left' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'value_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .content__value,
                     {{WRAPPER}} .value__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'value_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .content__value' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'value_width',
            [
                'label' => esc_html__('Value Wrapper Width (px)', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'condition' => [ 'value_position' => 'dynamic_middle' ],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 100, 'step' => 1 ],
                ],
                'default' => [ 'size' => 42, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .progress__bar' => 'max-width: calc(100% - {{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .wgl-progress-bar.init .content__value' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .content__value' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'value_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['value_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .content__value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'value_bg',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .content__value' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'value_bg-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['value_bg!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .content__value' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> UNITS */

        $this->start_controls_section(
            'style_units',
            [
                'label' => esc_html__( 'Units', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'units_text!' => '' ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'units_typography',
                'selector' => '{{WRAPPER}} .value__unit',
            ]
        );

        $this->add_responsive_control(
            'units_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'horizontal',
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .value__unit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'units_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .value__unit' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'units_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['units_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .value__unit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> PROGRESS BAR */

        $this->start_controls_section(
            'style_bar',
            [
                'label' => esc_html__( 'Bar', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_empty_height',
            [
                'label' => esc_html__( 'Empty Bar Height', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 30 ],
                ],
                'default' => [ 'size' => 3 ],
                'condition' => [ 'value_position!' => 'dynamic_middle' ],
                'selectors' => [
                    '{{WRAPPER}} .progress__bar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'bar_empty_bg',
                'label' => esc_html__('Background', 'burido-core'),
                'types' => [ 'classic', 'gradient' ],
                'dynamic' => ['active' => true],
                'condition' => [ 'value_position!' => 'dynamic_middle' ],
                'fields_options' => [
                    'background' => [ 'default' => 'classic' ],
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .bar__empty',
            ]
        );

        $this->add_control(
            'bar_filled_height',
            [
                'label' => esc_html__( 'Filled Bar Height', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'label_block' => true,
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 30 ],
                ],
                'default' => [ 'size' => 3 ],
                'selectors' => [
                    '{{WRAPPER}} .bar__filled,
                     {{WRAPPER}} .layout-dynamic_middle .progress__bar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_filled_offset',
            [
                'label' => esc_html__( 'Filled Bar Vertical Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'range' => [
                    'px' => [ 'min' => -15, 'max' => 15, 'step' => 0.5 ],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .bar__filled' => 'transform: translateY({{SIZE}}{{UNIT}}); top: 0;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'bar_filled_bg',
                'label' => esc_html__('Background', 'burido-core'),
                'types' => [ 'classic', 'gradient' ],
                'dynamic' => ['active' => true],
                'fields_options' => [
                    'background' => [ 'default' => 'classic' ],
                    'color' => [
                        'label' => esc_html__( 'Background Color', 'burido-core' ),
                        'default' => WGL_Globals::get_primary_color(),
                    ],
                    'image' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .bar__filled',
            ]
        );

        $this->add_responsive_control(
            'bar_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'allowed_dimensions' => 'vertical',
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '12',
                    'right' => '0',
                    'bottom' => '8',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress__bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bar_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .progress__bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'bar_border',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                        'selectors' => [ '{{SELECTOR}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
                    ],
                    'color' => [
                        'label' => esc_html__( 'Border Color', 'burido-core' ),
                    ],
                ],
                'selector' => '{{WRAPPER}} .bar__empty',
            ]
        );

        $this->add_control(
            'bar_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .bar__empty,
                     {{WRAPPER}} .bar__filled' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'bar_shadow',
                'selector' => '{{WRAPPER}} .bar__empty',
            ]
        );

        $this->add_control(
            'bar_transition_duration',
            [
                'label' => esc_html__( 'Animation Duratiom', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'label_block' => true,
                'size_units' => [ 's', 'ms' ],
                'range' => [
                    's' => [ 'min' => 0.1, 'max' => 4, 'step' => 0.1 ],
                    'ms' => [ 'min' => 100, 'max' => 4000 ],
                ],
                'default' => [ 'unit' => 's' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-progress-bar' => 'transition: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $pos = $this->get_settings_for_display( 'value_position' );
        $this->add_render_attribute( 'wrapper', 'class', [
            'wgl-progress-bar',
            'layout-' . $pos
        ] );

        echo '<div ', $this->get_render_attribute_string( 'wrapper' ), '>';

        if ( 'aside' === $pos ) {
            $this->render_aside_layout();
        } else if ( 'dynamic_middle' === $pos ) {
            $this->render_dynamic_middle_layout();
        } else {
            $this->render_default_layout();
        }

        echo '</div>';
    }

    protected function render_default_layout()
    {

        $title_tag = $this->get_settings_for_display( 'title_tag' );

        echo '<'. esc_attr( $title_tag ). ' class="progress__content">'.
            $this->render_title().
            $this->render_default_value().
        '</'. esc_attr( $title_tag ). '>';

        $this->render_bar();
    }

    protected function render_dynamic_middle_layout()
    {

        $title_tag = $this->get_settings_for_display( 'title_tag' );

        echo '<'. esc_attr( $title_tag ). ' class="progress__content">'.
            $this->render_title().
        '</'. esc_attr( $title_tag ). '>';

        $this->render_bar();
    }

    protected function render_aside_layout()
    {
        $title_tag = $this->get_settings_for_display( 'title_tag' );

        echo '<div class="aside__wrapper">';

            echo '<'. esc_attr( $title_tag ). ' class="progress__content">'.
                $this->render_title().
            '</'. esc_attr( $title_tag ). '>';

            $this->render_bar();

        echo '</div>';

        $this->render_aside_value();
    }

    protected function render_bar()
    {
        $_s = $this->get_settings_for_display();
        $value_progress = 0 === $_s['value_progress'] ? 0 : ( $_s['value_progress'] ?: 50 );
        $value_maximum = $_s['value_maximum'] ?: 100;
        $this->add_render_attribute( 'bar-filled', [
            'class' => 'bar__filled',
            'data-value' => esc_attr( $value_progress ),
            'data-max-value' => esc_attr( $value_maximum ),
            'data-sep' => $_s['thousand_sep'],
            'data-speed' => $_s['speed'] ?? '1200',
        ] );

        ?><div class="progress__bar">
            <div class="bar__empty"></div>
            <div <?php echo $this->get_render_attribute_string( 'bar-filled' ); ?>><?php

                if ('dynamic_middle' === $_s['value_position']){
                    echo '<'. esc_attr( $_s['title_tag'] ). ' class="progress__value">'.
                        $this->render_default_value().
                        '</'. esc_attr( $_s['title_tag'] ). '>';
                }

                ?></div>
        </div><?php
    }

    protected function render_title()
    {
        $title_text = $this->get_settings_for_display( 'title_text' );

        $kses_allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
                'rel' => true, 'target' => true
            ],
            'br' => ['class' => true, 'style' => true],
            'em' => ['class' => true, 'style' => true],
            'strong' => ['class' => true, 'style' => true],
            'span' => ['class' => true, 'style' => true],
            'p' => ['class' => true, 'style' => true]
        ];

        if ( empty( $title_text ) ) {
            // Bailout.
            return;
        }

        return '<span class="content__label">'.
            wp_kses($title_text, $kses_allowed_html).
        '</span>';
    }

    protected function render_default_value()
    {
        $_s = $this->get_settings_for_display();

        return '<span class="content__value">'.
            '<span class="value__digit">0</span>'.
            ( $_s['units_text'] ? '<span class="value__unit">' . esc_html( $_s['units_text'] ) . '</span>' : '' ).
        '</span>';
    }

    protected function render_aside_value()
    {
        $_s = $this->get_settings_for_display();
        $units = $_s['units_text'];
        $title_tag = $_s['title_tag'];
        $value_progress = 0 === $_s['value_progress'] ? 0 : ( $_s['value_progress'] ?: 50 );

        echo '<'. esc_attr( $title_tag ). ' class="progress__value"><span class="content__value">',
            '<span class="placeholder__digit">', esc_html( $value_progress ), '</span>',
            ( $units ? '<span class="placeholder__unit">' . esc_html( $units ) . '</span>' : '' ),

            '<div class="value__wrapper">',
                '<span class="value__digit">0</span>',
                ( $units ? '<span class="value__unit">' . esc_html( $units ) . '</span>' : '' ),
            '</div>',
        '</span></'. esc_attr( $title_tag ). '>';
    }

    public function wpml_support_module()
    {
        add_filter( 'wpml_elementor_widgets_to_translate',  [ $this, 'wpml_widgets_to_translate_filter' ] );
    }

    public function wpml_widgets_to_translate_filter( $widgets )
    {
        return \WGL_Extensions\Includes\WGL_WPML_Settings::get_translate(
            $this, $widgets
        );
    }
}
