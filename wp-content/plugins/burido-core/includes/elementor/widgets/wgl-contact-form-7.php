<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-contact-form-7.php`.
 */
namespace WGL_Extensions\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WGL_Extensions\Includes\WGL_Elementor_Helper;
use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background
};

class WGL_Contact_Form_7 extends Widget_Base
{
    protected $forms;

    public function get_name()
    {
        return 'wgl-contact-form-7';
    }

    public function get_title()
    {
        return esc_html__( 'WGL Contact Form 7', 'burido-core' );
    }

    public function get_icon()
    {
        return 'wgl-contact-form-7';
    }

    public function get_keywords() {
        return ['contact', 'form', '7', 'WPCF7'];
    }

    public function get_categories()
    {
        return [ 'wgl-modules' ];
    }

    protected function get_availbale_forms($id = false)
    {
        if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
            return [];
        }

        $forms = \WPCF7_ContactForm::find( [
            'orderby' => 'title',
            'order' => 'ASC',
        ] );

        if ( empty( $forms ) ) {
            return [];
        }

        $result = [];

        foreach ( $forms as $item ) {
            $key = sprintf( '%1$s::%2$s', $item->name(), $item->title() );
            $result[ $key ] = $item->title();
            $this->forms[$item->name()] = $item->id();
        }

        return $result;
    }

    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'section_content_general',
            [
                'label' => esc_html__( 'General', 'burido-core' ),
            ]
        );

        $avaliable_forms = $this->get_availbale_forms();

        $active_form = '';

        if ( ! empty( $avaliable_forms ) ) {
            $active_form = array_keys( $avaliable_forms )[ 0 ];
        }

        $this->add_control(
            'form_shortcode',
            [
                'label' => esc_html__( 'Select Form', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => $active_form,
                'options' => $avaliable_forms,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'general_typo',
                'selector' => '{{WRAPPER}} .wpcf7-form',
            ]
        );

        $this->add_control(
            'general_color',
            [
                'label' => esc_html__( 'Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'general_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'general_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-form' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'additional_color',
            [
                'label' => esc_html__( 'Additional Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} input[type="radio"] + label::before,
                     {{WRAPPER}} input[type="radio"] + span::before,
                     {{WRAPPER}} input[type="checkbox"] + label::before,
                     {{WRAPPER}} input[type="checkbox"] + span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'additional_color-dynamic',
            [
                'label' => esc_html__('Additional Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'additional_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} input[type="radio"] + label::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="radio"] + span::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="checkbox"] + label::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="checkbox"] + span::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
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
                    ]
                ],
                'prefix_class' => 'a%s',
                'default' => 'left',
            ]
        );

        $this->add_control(
            'form_inline',
            [
                'label' => esc_html__( 'Form Inline', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control-wrap,
                     {{WRAPPER}} .wpcf7-form-control.wpcf7-submit' => 'display: inline-block; vertical-align: top;',

                    '{{WRAPPER}} .wpcf7-form-control-wrap + br' => 'display: none;',
                ]
            ]
        );

        $this->add_responsive_control(
            'form_inline_width',
            [
                'label' => esc_html__( 'Inputs Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [ 'form_inline!' => '' ],
                'size_units' => [ 'px', '%', 'vw', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 200, 'max' => 600 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control-wrap' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**  STYLE -> INPUTS */

        $this->start_controls_section(
            'style_inputs',
            [ 'label' => esc_html__( 'Inputs', 'burido-core' ) ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'inputs_typography',
                'selector' => '{{WRAPPER}} input[type="text"],'
                            . '{{WRAPPER}} input[type="url"],'
                            . '{{WRAPPER}} input[type="search"],'
                            . '{{WRAPPER}} input[type="email"],'
                            . '{{WRAPPER}} input[type="password"],'
                            . '{{WRAPPER}} input[type="tel"],'
                            . '{{WRAPPER}} input[type="time"],'
                            . '{{WRAPPER}} input[type="number"],'
                            . '{{WRAPPER}} input[type="date"],'
                            . '{{WRAPPER}} select,'
                            . '{{WRAPPER}} textarea,'
                            . '{{WRAPPER}} input.wpcf7-form-control::placeholder,'
                            . '{{WRAPPER}} select.wpcf7-select::placeholder,'
                            . '{{WRAPPER}} textarea.wpcf7-textarea::placeholder',
            ]
        );

        $this->add_responsive_control(
            'inputs_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    '{{WRAPPER}} .wpcf7-form-control-wrap input,
                     {{WRAPPER}} .wpcf7-form-control-wrap select,
                     {{WRAPPER}} .wpcf7-form-control-wrap textarea' => 'margin-bottom: calc({{BOTTOM}}{{UNIT}} - {{BOTTOM}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'inputs_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} input[type="text"],
                     {{WRAPPER}} input[type="url"],
                     {{WRAPPER}} input[type="search"],
                     {{WRAPPER}} input[type="email"],
                     {{WRAPPER}} input[type="password"],
                     {{WRAPPER}} input[type="tel"],
                     {{WRAPPER}} input[type="time"],
                     {{WRAPPER}} input[type="number"],
                     {{WRAPPER}} input[type="date"],
                     {{WRAPPER}} select,
                     {{WRAPPER}} textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'inputs_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} input[type="text"],
                     {{WRAPPER}} input[type="url"],
                     {{WRAPPER}} input[type="search"],
                     {{WRAPPER}} input[type="email"],
                     {{WRAPPER}} input[type="password"],
                     {{WRAPPER}} input[type="tel"],
                     {{WRAPPER}} input[type="time"],
                     {{WRAPPER}} input[type="number"],
                     {{WRAPPER}} input[type="date"],
                     {{WRAPPER}} select,
                     {{WRAPPER}} textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'inputs_height',
            [
                'label' => esc_html__( 'Inputs Height', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'min' => 30,
                'selectors' => [
                    '{{WRAPPER}} input[type="text"],
                     {{WRAPPER}} input[type="url"],
                     {{WRAPPER}} input[type="search"],
                     {{WRAPPER}} input[type="email"],
                     {{WRAPPER}} input[type="password"],
                     {{WRAPPER}} input[type="tel"],
                     {{WRAPPER}} input[type="time"],
                     {{WRAPPER}} input[type="number"],
                     {{WRAPPER}} input[type="date"],
                     {{WRAPPER}} select' => 'height: {{VALUE}}px; min-height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'textarea_height',
            [
                'label' => esc_html__( 'Textarea Height', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => 60,
                'selectors' => [
                    '{{WRAPPER}} textarea' => 'height: {{VALUE}}px; min-height: {{VALUE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs( 'inputs_colors_tabs' );

        $this->start_controls_tab(
            'inputs_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );

        $this->add_control(
            'inputs_placeholder_color_idle',
            [
                'label' => esc_html__( 'Placeholder Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} input.wpcf7-form-control::placeholder,
                     {{WRAPPER}} select.wpcf7-select::placeholder,
                     {{WRAPPER}} textarea.wpcf7-textarea::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'inputs_placeholder_color_idle-dynamic',
            [
                'label' => esc_html__('Placeholder Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'inputs_placeholder_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} input.wpcf7-form-control::placeholder,
                     body.wgl_dynamic_colors-active {{WRAPPER}} select.wpcf7-select::placeholder,
                     body.wgl_dynamic_colors-active {{WRAPPER}} textarea.wpcf7-textarea::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_idle_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} input[type="text"],
                     {{WRAPPER}} input[type="url"],
                     {{WRAPPER}} input[type="search"],
                     {{WRAPPER}} input[type="email"],
                     {{WRAPPER}} input[type="password"],
                     {{WRAPPER}} input[type="tel"],
                     {{WRAPPER}} input[type="time"],
                     {{WRAPPER}} input[type="number"],
                     {{WRAPPER}} input[type="date"],
                     {{WRAPPER}} select,
                     {{WRAPPER}} textarea' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'inputs_idle_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'inputs_idle_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} input[type="text"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="url"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="search"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="email"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="password"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="tel"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="time"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="number"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="date"],
                     body.wgl_dynamic_colors-active {{WRAPPER}} select,
                     body.wgl_dynamic_colors-active {{WRAPPER}} textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'inputs_idle_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} input[type="text"],'
                            . '{{WRAPPER}} input[type="url"],'
                            . '{{WRAPPER}} input[type="search"],'
                            . '{{WRAPPER}} input[type="email"],'
                            . '{{WRAPPER}} input[type="password"],'
                            . '{{WRAPPER}} input[type="tel"],'
                            . '{{WRAPPER}} input[type="time"],'
                            . '{{WRAPPER}} input[type="number"],'
                            . '{{WRAPPER}} input[type="date"],'
                            . '{{WRAPPER}} select,'
                            . '{{WRAPPER}} textarea',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'inputs_idle_bg',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} input[type="text"],'
                            . '{{WRAPPER}} input[type="url"],'
                            . '{{WRAPPER}} input[type="search"],'
                            . '{{WRAPPER}} input[type="email"],'
                            . '{{WRAPPER}} input[type="password"],'
                            . '{{WRAPPER}} input[type="tel"],'
                            . '{{WRAPPER}} input[type="time"],'
                            . '{{WRAPPER}} input[type="number"],'
                            . '{{WRAPPER}} input[type="date"],'
                            . '{{WRAPPER}} select,'
                            . '{{WRAPPER}} textarea',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'inputs_idle_shadow',
                'selector' => '{{WRAPPER}} input[type="text"],'
                    . '{{WRAPPER}} input[type="url"],'
                    . '{{WRAPPER}} input[type="search"],'
                    . '{{WRAPPER}} input[type="email"],'
                    . '{{WRAPPER}} input[type="password"],'
                    . '{{WRAPPER}} input[type="tel"],'
                    . '{{WRAPPER}} input[type="time"],'
                    . '{{WRAPPER}} input[type="number"],'
                    . '{{WRAPPER}} input[type="date"],'
                    . '{{WRAPPER}} select,'
                    . '{{WRAPPER}} textarea',
            ]
        );

        $this->add_control(
            'select_icon_color',
            [
                'label' => esc_html__( 'Select Icon Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'render_type' => 'template',
            ]
        );
        $this->add_control(
            'select_icon_color-dynamic',
            [
                'label' => esc_html__('Select Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'select_icon_color!' => '' ],
                'render_type' => 'template',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'inputs_focus',
            [ 'label' => esc_html__( 'Focus', 'burido-core' ) ]
        );

        $this->add_control(
            'inputs_focus_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} input[type="text"]:focus,
                     {{WRAPPER}} input[type="url"]:focus,
                     {{WRAPPER}} input[type="search"]:focus,
                     {{WRAPPER}} input[type="email"]:focus,
                     {{WRAPPER}} input[type="password"]:focus,
                     {{WRAPPER}} input[type="tel"]:focus,
                     {{WRAPPER}} input[type="time"]:focus,
                     {{WRAPPER}} input[type="number"]:focus,
                     {{WRAPPER}} input[type="date"]:focus,
                     {{WRAPPER}} select:focus,
                     {{WRAPPER}} textarea:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'inputs_focus_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'inputs_focus_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} input[type="text"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="url"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="search"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="email"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="password"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="tel"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="time"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="number"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} input[type="date"]:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} select:focus,
                     body.wgl_dynamic_colors-active {{WRAPPER}} textarea:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'inputs_focus_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} input[type="text"]:focus,'
                    . '{{WRAPPER}} input[type="url"]:focus,'
                    . '{{WRAPPER}} input[type="search"]:focus,'
                    . '{{WRAPPER}} input[type="email"]:focus,'
                    . '{{WRAPPER}} input[type="password"]:focus,'
                    . '{{WRAPPER}} input[type="tel"]:focus,'
                    . '{{WRAPPER}} input[type="time"]:focus,'
                    . '{{WRAPPER}} input[type="number"]:focus,'
                    . '{{WRAPPER}} input[type="date"]:focus,'
                    . '{{WRAPPER}} select:focus,'
                    . '{{WRAPPER}} textarea:focus',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'inputs_focus_bg',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} input[type="text"]:focus,'
                    . '{{WRAPPER}} input[type="url"]:focus,'
                    . '{{WRAPPER}} input[type="search"]:focus,'
                    . '{{WRAPPER}} input[type="email"]:focus,'
                    . '{{WRAPPER}} input[type="password"]:focus,'
                    . '{{WRAPPER}} input[type="tel"]:focus,'
                    . '{{WRAPPER}} input[type="time"]:focus,'
                    . '{{WRAPPER}} input[type="number"]:focus,'
                    . '{{WRAPPER}} input[type="date"]:focus,'
                    . '{{WRAPPER}} select:focus,'
                    . '{{WRAPPER}} textarea:focus',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'inputs_focus_shadow',
                'selector' => '{{WRAPPER}} input[type="text"]:focus,'
                    . '{{WRAPPER}} input[type="url"]:focus,'
                    . '{{WRAPPER}} input[type="search"]:focus,'
                    . '{{WRAPPER}} input[type="email"]:focus,'
                    . '{{WRAPPER}} input[type="password"]:focus,'
                    . '{{WRAPPER}} input[type="tel"]:focus,'
                    . '{{WRAPPER}} input[type="time"]:focus,'
                    . '{{WRAPPER}} input[type="number"]:focus,'
                    . '{{WRAPPER}} input[type="date"]:focus,'
                    . '{{WRAPPER}} select:focus,'
                    . '{{WRAPPER}} textarea:focus',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'inputs_not_valid',
            [ 'label' => esc_html__( 'Not Valid', 'burido-core' ) ]
        );

        $this->add_control(
            'inputs_not_valid_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-not-valid' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'inputs_not_valid_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'inputs_not_valid_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-not-valid' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'inputs_not_valid_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .wpcf7-not-valid',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'inputs_not_valid_bg',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .wpcf7-not-valid',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'inputs_not_valid_shadow',
                'selector' => '{{WRAPPER}} .wpcf7-not-valid',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> SUBMIT */

        $this->start_controls_section(
            'section_style_submit',
            [ 'label' => esc_html__( 'Submit Button', 'burido-core' ) ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'selector' => '{{WRAPPER}} .wpcf7-submit'
            ]
        );

        $this->add_responsive_control(
            'submit_full_width',
            [
                'label' => esc_html__( 'Full Width', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'width: 100%;',
                ]
            ]
        );

        $this->add_responsive_control(
            'submit_min_width',
            [
                'label' => esc_html__( 'Button min Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'submit_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-button.has-animated-bg .wpcf7-submit' => 'margin: 0;',
                    '{{WRAPPER}} .wgl-button-cf7 .wpcf7-submit' => 'margin: 0;',
                    '{{WRAPPER}} .wgl-button.has-animated-bg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-button-cf7' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'submit_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'height: auto; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-button.has-animated-bg .wpcf7-submit' => 'padding: 0;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .wpcf7-submit, {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit ~ i',
            ]
        );

        $this->add_responsive_control(
            'submit_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_animation_style',
            [
                'label' => esc_html__('Animation Style', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'render_type' => 'template',
                'options' => [
                    '' => esc_html__('None', 'burido-core'),
                    'magnetic' => esc_html__('Magnetic', 'burido-core'),
                ],
                'default' => '',
            ]
        );

        /** Magnetic Threshold */
        $this->add_control(
            'button_magnetic_threshold',
            [
                'label' => esc_html__('Magnetic Threshold', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'render_type' => 'template',
                'style_transfer' => true,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 1920, 'step' => 1],
                ],
                'condition' => [ 'button_animation_style' => 'magnetic' ],
                'default' => ['size' => 500],
            ]
        );

        $this->add_control(
            'button_magnetic_strong',
            [
                'label' => esc_html__('Magnetic Strong', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'render_type' => 'template',
                'style_transfer' => true,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 0.05, 'max' => 1, 'step' => 0.05],
                ],
                'condition' => [ 'button_animation_style' => 'magnetic' ],
                'default' => ['size' => 0.2],
            ]
        );

        $this->start_controls_tabs( 'submit' );

        $this->start_controls_tab(
            'submit_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );

        $this->add_control(
            'submit_color_idle',
            [
                'label' => esc_html__( 'Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit,
                     {{WRAPPER}} .wgl-button-cf7::before,
                     {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit ~ i,
                     {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit ~ span:not(.wpcf7-spinner)' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'submit_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'submit_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-submit,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit ~ i,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit ~ span:not(.wpcf7-spinner)' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'submit_boder_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'submit_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit,
                     {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit ~ i' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submit_boder_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'submit_border_border!' => ['', 'none'],
                    'submit_boder_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-submit,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit ~ i' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submit_bg_idle',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'selector' => '
                    {{WRAPPER}} .wpcf7-submit,
                    {{WRAPPER}} .wgl-button.has-animated-bg::before
                ',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submit_shadow_idle',
                'selector' => '{{WRAPPER}} .wpcf7-submit',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'submit_hover',
            [ 'label' => esc_html__( 'Hover', 'burido-core' ) ]
        );

        $this->add_control(
            'submit_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit:hover,
                     {{WRAPPER}} .wgl-button-cf7:hover::before,
                     {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit:hover ~ i,
                     {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit:hover ~ span:not(.wpcf7-spinner)' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'submit_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'submit_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-submit:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7:hover::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit:hover ~ i,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit:hover ~ span:not(.wpcf7-spinner)' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'submit_boder_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'submit_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit:hover,
                     {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit:hover ~ i' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submit_boder_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'submit_border_border!' => ['', 'none'],
                    'submit_boder_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-submit:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-button-cf7 .wpcf7-submit:hover ~ i' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submit_bg_hover',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'selector' => '
                    {{WRAPPER}} .wpcf7-submit:hover,
                    {{WRAPPER}} .wgl-button.has-animated-bg:hover::before
                ',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submit_shadow_hover',
                'selector' => '{{WRAPPER}} .wpcf7-submit:hover'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> NOT VALID TIP */

        $this->start_controls_section(
            'section_style_tip',
            [ 'label' => esc_html__( 'Not Valid Tip', 'burido-core' ) ]
        );

        $this->add_responsive_control(
            'tip_alignment',
            [
                'label' => esc_html__( 'Alignment', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
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
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7-not-valid-tip' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tip_typo',
                'selector' => '{{WRAPPER}} .wpcf7-not-valid-tip',
            ]
        );

        $this->add_responsive_control(
            'tip_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tip_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tip_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'tip_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> RESPONSE */

        $this->start_controls_section(
            'section_style_response',
            [ 'label' => esc_html__( 'Alert', 'burido-core' ) ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'response_typo',
                'selector' => '{{WRAPPER}} .wpcf7-response-output',
            ]
        );

        $this->add_responsive_control(
            'response_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'response_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'response_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-response-output' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'response_bg',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .wpcf7-response-output',
            ]
        );

        $this->add_control(
            'response_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-response-output' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'response_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'response_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wpcf7-response-output' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();
        $item = !empty($self) ? $self : $this;
        if (!!$_s['select_icon_color']){
            $styles = '.elementor-element-' . esc_attr( $item->get_id() ) . ' select{ ';
            $styles .= '--burido-bg-caret-2: url(\'data:image/svg+xml; utf8, '.wgl_dynamic_styles()->bg_caret_2($_s['select_icon_color']).'\');';
            $styles .= '}';
            WGL_Elementor_Helper::enqueue_css( $styles, false );
        }
        if (!!$_s['select_icon_color-dynamic']){
            $styles = 'body.wgl_dynamic_colors-active .elementor-element-' . esc_attr( $item->get_id() ) . ' select{ ';
            $styles .= '--burido-bg-caret-2: url(\'data:image/svg+xml; utf8, '.wgl_dynamic_styles()->bg_caret_2($_s['select_icon_color-dynamic']).'\');';
            $styles .= '}';
            WGL_Elementor_Helper::enqueue_css( $styles, false );
        }

        $this->add_render_attribute('wrapper', 'class', 'wgl-contact-form-7');

        if ( isset($_s['button_animation_style']) && 'magnetic' === $_s[ 'button_animation_style' ] ) {
            $this->add_render_attribute([
                'wrapper' => [
                    'class' => 'has-magnetic',
                    'data-magnetic-threshold' => $_s['button_magnetic_threshold']['size'] ?? 500,
                    'data-magnetic-strong' => $_s['button_magnetic_strong']['size'] ?? 0.5,
                ],
            ]);
        }

        $avaliable_forms = $this->get_availbale_forms();
        $shortcode = $this->get_settings( 'form_shortcode' );

        if ( ! array_key_exists( $shortcode, $avaliable_forms ) ) {
            $shortcode = array_keys( $avaliable_forms )[ 0 ];
        }

        $data = explode( '::', $shortcode );

        if ( ! empty( $data ) && 2 === count( $data ) ) {

            if(function_exists('wpcf7_contact_form')){
                if ( ! $contact_form = wpcf7_contact_form( $this->forms[ $data[ 0 ] ] ) ) {
                    $contact_form = wpcf7_get_contact_form_by_title( $data[ 1 ] );
                }

                $atts = [];
                $atts['id'] = $this->forms[ $data[ 0 ] ];
                $atts['title'] = $data[ 1 ];

                echo '<div '.$this->get_render_attribute_string('wrapper').'>' . $contact_form->form_html( $atts ) . '</div>';
            }

        }
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