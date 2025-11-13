<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-text-editor.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Control_Media,
    Group_Control_Background,
    Group_Control_Image_Size,
    Utils,
    Widget_Base,
    Controls_Manager,
    Repeater,
    Group_Control_Typography,
    Group_Control_Border,
    Group_Control_Box_Shadow};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Cursor
};

class WGL_Text_Editor extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-text-editor';
    }

    public function get_title()
    {
        return esc_html__('WGL Text Editor', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-text-editor';
    }

    public function get_keywords()
    {
        return [ 'editor', 'heading', 'title', 'text' ];
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
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'content_general',
            ['label' => esc_html__('General', 'burido-core')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('Title', 'burido-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('https://your-link.com', 'burido-core'),
                'default' => ['is_external' => 'true'],
            ]
        );
        $repeater->add_control(
            'customize_item_switch',
            [
                'label' => esc_html__('Customize Item', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_responsive_control(
            'text_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'vw', 'custom'],
                'condition' => ['customize_item_switch!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'customize_item_switch!' => '',
                    'image[url]!' => ''
                ],
                'size_units' => ['px', 'em','custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 800 ],
                    'em' => ['min' => 0, 'max' => 10, 'step' => 0.1 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo',
                'condition' => ['customize_item_switch!' => ''],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );
        $repeater->add_responsive_control(
            'text_stroke_size',
            [
                'label' => esc_html__('Stroke Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => ['customize_item_switch!' => ''],
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 0, 'max' => 2, 'step' => 0.1]],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'item_alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
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
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'item_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'condition' => ['customize_item_switch!' => ''],
                'min' => -5,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'z-index: {{VALUE}}; position: relative;',
                ],
            ]
        );
        $repeater->add_control(
            'text_color',
            [
                'label' => esc_html__('Color Palette', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'burido-core'),
                    'custom' => esc_html__('Custom', 'burido-core'),
                ],
                'default' => 'default',
                'separator' => 'before',
                'condition' => ['customize_item_switch!' => '']
            ]
        );

        $repeater->start_controls_tabs(
            'tabs_text_color',
            [
                'condition' => [
                    'text_color' => 'custom',
                    'customize_item_switch!' => ''
                ]
            ]
        );

        $repeater->start_controls_tab(
            'tab_text_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $repeater->add_control(
            'text_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_border_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_border_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'border_border!' => ['', 'none'],
                    'text_border_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_stroke_idle',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'text_stroke_size[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_stroke_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'text_stroke_size[size]!' => '',
                    'text_stroke_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'tab_text_hover',
            ['label' => esc_html__('Hover', 'burido-core') ]
        );
        $repeater->add_control(
            'text_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_border_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_border_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'border_border!' => ['', 'none'],
                    'text_border_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_stroke_hover',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'text_stroke_size[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'text_stroke_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'text_stroke_size[size]!' => '',
                    'text_stroke_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper {{CURRENT_ITEM}}:hover' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        WGL_Cursor::init(
            $repeater,
            [
                'section' => false,
                'repeater' => true,
                'condition' => ['customize_item_switch!' => '']
            ]
        );

        $this->add_control(
            'text_editor_list',
            [
                'label' => esc_html__('Text', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'title' => esc_html__('Title 1 ', 'burido-core') ],
                    [ 'title' => esc_html__('Title 2 ', 'burido-core') ],
                    [ 'title' => esc_html__('Title 3 ', 'burido-core') ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'toggle' => false,
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
                    ],
                ],
                'prefix_class' => 'a%s',
                'default' => 'left',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLES -> GENERAL
         */

        $this->start_controls_section(
            'style_title',
            [
                'label' => esc_html__('Text Styles', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo_all',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 48],
                        'tablet_default' => ['size' => 38],
                        'mobile_default' => ['size' => 28],
                    ],
                ],
                'selector' => '{{WRAPPER}} .text-editor_wrapper',
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
                    'span' => esc_html('‹span›'),
                    'div' => esc_html('‹div›'),
                ],
                'default' => 'h3',
            ]
        );
        $this->add_responsive_control(
            'title_display',
            [
                'label' => esc_html__( 'Display', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'inline' => esc_html__( 'Inline', 'burido-core' ),
                    'block' => esc_html__( 'Block', 'burido-core' ),
                    'inline-block' => esc_html__( 'Inline Block', 'burido-core' ),
                ],
                'default' => 'inline',
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => 'display: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'titles_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'titles_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .text-editor_wrapper > span, {{WRAPPER}} .text-editor_wrapper > a',
            ]
        );

        $this->add_responsive_control(
            'titles_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'titles_stroke_size',
            [
                'label' => esc_html__('Stroke Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 0, 'max' => 2, 'step' => 0.1]],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_text_all_color'
        );
        $this->start_controls_tab(
            'tab_text_all_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'text_color_all_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_color_all_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_color_all_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_bg_all_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_bg_all_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_bg_all_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_border_all_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_border_all_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'border_border!' => ['', 'none'],
                    'text_border_all_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_stroke_all_idle',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'titles_stroke_size[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span,
                     {{WRAPPER}} .text-editor_wrapper > a' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_stroke_all_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'titles_stroke_size[size]!' => '',
                    'text_stroke_all_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_text_all_hover',
            ['label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'text_color_all_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span:hover,
                     {{WRAPPER}} .text-editor_wrapper > a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_color_all_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_color_all_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_bg_all_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span:hover,
                     {{WRAPPER}} .text-editor_wrapper > a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_bg_all_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['text_bg_all_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_border_all_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span:hover,
                     {{WRAPPER}} .text-editor_wrapper > a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_border_all_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'border_border!' => ['', 'none'],
                    'text_border_all_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_stroke_all_hover',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'titles_stroke_size[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_wrapper > span:hover,
                     {{WRAPPER}} .text-editor_wrapper > a:hover' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_stroke_all_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'titles_stroke_size[size]!' => '',
                    'text_stroke_all_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > span:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .text-editor_wrapper > a:hover' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLES -> MASK EFFECT
         */

        $this->start_controls_section(
            'mask_effect',
            [
                'label' => esc_html__('Text Mask Effect Cursor', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'loop_animation_switch' => '',
                    'text_parallax_switch' => '',
                    'text_appear_switch' => '',
                    'scroll_text_appear_switch' => '',
                ]
            ]
        );

        $this->add_control(
            'mask_effect_switch',
            [
                'label' => esc_html__('Text Mask Effect Cursor', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'mask_size',
            [
                'label' => esc_html__('Circle Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 1000 ],
                ],
                'default' => [ 'size' => 344 ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_outer-clone' => '--circle-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['mask_effect_switch!' => '']
            ]
        );

        $this->add_responsive_control(
            'mask_point_top',
            [
                'label' => esc_html__('Start Mask Point Top (px)', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 1000 ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_outer-clone' => '--start-circle-point-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['mask_effect_switch!' => '']
            ]
        );

        $this->add_responsive_control(
            'mask_point_left',
            [
                'label' => esc_html__('Start Mask Point Left (px)', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 1000 ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .text-editor_outer-clone' => '--start-circle-point-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['mask_effect_switch!' => '']
            ]
        );

        $this->add_control(
            'mask_visibility',
            [
                'label' => esc_html__('Parallax Direction', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'always' => esc_html__('Always', 'burido-core'),
                    'on_hover' => esc_html__('On Hover', 'burido-core'),
                ],
                'default' => 'always',
                'condition' => ['mask_effect_switch!' => ''],
                'prefix_class' => 'visibility-',
            ]
        );

        $this->add_control(
			'mask_color_switch',
			[
				'label' => esc_html__('Custom Mask Color', 'burido-core'),
				'type' => Controls_Manager::SWITCHER,
                'condition' => ['mask_effect_switch!' => '']
			]
		);

        $this->start_controls_tabs(
            'tabs_mask_color',
            [
                'condition' => [
                    'mask_color_switch!' => '',
                    'mask_effect_switch!' => ''
                ],
            ]
        );

        $this->start_controls_tab(
            'tabs_mask_color_text',
            ['label' => esc_html__('Text', 'burido-core')]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mask_text_color',
				'label' => esc_html__('Background', 'burido-core'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .text-editor_wrapper-clone',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_mask_color_bg',
            ['label' => esc_html__('Background', 'burido-core')]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mask_text_bg',
				'label' => esc_html__('Background', 'burido-core'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .text-editor_outer-clone',
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLES -> LOOP ANIMATION
         */

        $this->start_controls_section(
            'loop_animation',
            [
                'label' => esc_html__('Inline Loop Animation', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mask_effect_switch' => '',
                    'text_parallax_switch' => '',
                    'text_appear_switch' => '',
                    'scroll_text_appear_switch' => '',
                ]
            ]
        );

        $this->add_control(
            'loop_animation_switch',
            [
                'label' => esc_html__('Inline Loop Animation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'loop_animation_gap',
            [
                'label' => esc_html__('Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                    'em' => [ 'min' => 0, 'max' => 10 ],
                ],
                'size_units' => ['px', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .loop_animation' => '--wgl-loop-animation-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['loop_animation_switch!' => '']
            ]
        );

        $this->add_responsive_control(
            'loop_animation_duration',
            [
                'label' => esc_html__('Animation Duration (sec)', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 1000 ],
                ],
                'condition' => ['loop_animation_switch!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .loop_animation' => '--wgl-loop-animation-duration: {{SIZE}}s;',
                ],
            ]
        );

        $this->add_control(
            'loop_animation_clone_count',
            [
                'label' => esc_html__('Count of Cloned Text', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'condition' => ['loop_animation_switch!' => '']
            ]
        );

        $this->add_control(
            'loop_animation_reverse',
            [
                'label' => esc_html__('Animation Reverse', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['loop_animation_switch!' => '']
            ]
        );

        $this->add_control(
            'loop_animation_hover_stop',
            [
                'label' => esc_html__('Animation Stop on Hover', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['loop_animation_switch!' => '']
            ]
        );

        $this->end_controls_section();

        /**
         * STYLES -> PARALLAX ANIMATION
         */

        $this->start_controls_section(
            'text_parallax',
            [
                'label' => esc_html__('Text Parallax', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mask_effect_switch' => '',
                    'loop_animation_switch' => '',
                    'text_appear_switch' => '',
                    'scroll_text_appear_switch' => '',
                ]
            ]
        );

        $this->add_control(
            'text_parallax_switch',
            [
                'label' => esc_html__('Text Parallax', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'text_parallax_dir',
            [
                'label' => esc_html__('Parallax Direction', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'vertical' => esc_html__('Vertical', 'burido-core'),
                    'horizontal' => esc_html__('Horizontal', 'burido-core'),
                ],
                'default' => 'vertical',
                'condition' => ['text_parallax_switch!' => '']
            ]
        );

        $this->add_responsive_control(
            'text_parallax_factor',
            [
                'label' => esc_html__('Parallax Factor', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'description' => esc_html__('Set elements offset and speed. It can be positive (0.3) or negative (-0.3). Less means slower.', 'burido-core'),
                'min' => -3,
                'max' => 3,
                'step' => 0.01,
                'default' => 0.15,
                'condition' => ['text_parallax_switch!' => '']
            ]
        );

        $this->end_controls_section();

        /**
         * STYLES -> APPEAR ANIMATION
         */

        $this->start_controls_section(
            'text_appear',
            [
                'label' => esc_html__('Text Appear', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mask_effect_switch' => '',
                    'loop_animation_switch' => '',
                    'text_parallax_switch' => '',
                    'scroll_text_appear_switch' => '',
                ]
            ]
        );

        $this->add_control(
            'text_appear_switch',
            [
                'label' => esc_html__('Appear Animation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'text_appear_mode',
            [
                'label' => esc_html__('Appear Mode', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'letters' => esc_html__('Letters', 'burido-core'),
                    'words' => esc_html__('Words', 'burido-core'),
                    'items' => esc_html__('Items', 'burido-core'),
                ],
                'condition' => ['text_appear_switch!' => ''],
                'default' => 'letters',
            ]
        );

        $this->add_responsive_control(
            'text_appear_animation',
            [
                'label' => esc_html__( 'Entrance Animation', 'burido-core' ),
                'type' => Controls_Manager::ANIMATION,
                'frontend_available' => true,
                'condition' => ['text_appear_switch!' => ''],
                'default' => 'fadeIn',
            ]
        );

        $this->add_control(
            'text_appear_duration',
            [
                'label' => esc_html__('Duration (ms)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'render_type' => 'template',
                'condition' => ['text_appear_switch!' => ''],
                'default' => 400,
                'selectors' => [
                    '{{WRAPPER}} .wgl-text-editor' => '--wgl-text-duration: {{VALUE}}ms;',
                ],
            ]
        );

        $this->add_control(
            'text_appear_delay',
            [
                'label' => esc_html__('Delay (ms)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'render_type' => 'template',
                'condition' => ['text_appear_switch!' => ''],
                'default' => 200,
                'selectors' => [
                    '{{WRAPPER}} .wgl-text-editor' => '--wgl-text-delay: {{VALUE}}ms;',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLES -> SCROLL APPEAR ANIMATION
         */

        $this->start_controls_section(
            'scroll_text_appear',
            [
                'label' => esc_html__('Scroll Text Appear', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mask_effect_switch' => '',
                    'loop_animation_switch' => '',
                    'text_parallax_switch' => '',
                    'text_appear_switch' => ''
                ]
            ]
        );

        $this->add_control(
            'scroll_text_appear_switch',
            [
                'label' => esc_html__('Appear Animation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'scroll_text_appear_mode',
            [
                'label' => esc_html__('Appear Mode', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'opacity' => esc_html__('Opacity', 'burido-core'),
                    'color' => esc_html__('Color', 'burido-core'),
                ],
                'condition' => ['scroll_text_appear_switch!' => ''],
                'default' => 'opacity',
            ]
        );

        $this->add_control(
            'scroll_text_start_percent',
            [
                'label' => esc_html__('Start Animation From Bottom (%)', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 0, 'max' => 100, 'step' => 1]],
                'condition' => ['scroll_text_appear_switch!' => ''],
                'default' => [ 'size' => 15 ],
            ]
        );

        $this->add_control(
            'scroll_text_duration',
            [
                'label' => esc_html__('Animation Duration in Element Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 0, 'max' => 5, 'step' => 0.1]],
                'condition' => ['scroll_text_appear_switch!' => ''],
                'default' => [ 'size' => 1 ],
            ]
        );

        $this->add_control(
            'scroll_text_opacity',
            [
                'label' => esc_html__('Undertext Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 0, 'max' => 1, 'step' => 0.05]],
                'condition' => ['scroll_text_appear_switch!' => ''],
                'default' => [ 'size' => 0.1 ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-text-editor.scroll_text_appear' => '--wgl-text-appear-opacity: {{SIZE}};',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'scroll_text_words',
            [
                'label' => esc_html__('Number of Words Animating Simultaneously', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'default' => 3,
                'condition' => [
                    'scroll_text_appear_switch!' => '',
                    'scroll_text_appear_mode' => 'opacity',
                ],
            ]
        );

        $this->add_control(
            'scroll_text_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'scroll_text_appear_switch!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-text-editor.scroll_text_appear' => '--wgl-text-appear-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();
        $items_text = $wrapper_class = $items_text_html_clone = '';
        $loop_animation_clone_count = $_s['loop_animation_clone_count'] ?: 5;
        $wrapper_class .= $_s['loop_animation_switch'] ? ' loop_animation' : '';
        $wrapper_class .= $_s['text_parallax_switch'] ? ' text_parallax' : '';
        $wrapper_class .= $_s['text_appear_switch'] ? ' text_appear appear-'.$_s['text_appear_mode'] : '';
        $wrapper_class .= $_s['loop_animation_reverse'] ? ' reverse' : '';
        $wrapper_class .= $_s['scroll_text_appear_switch'] ? ' scroll_text_appear appear-'.$_s['scroll_text_appear_mode'] : '';
        $wrapper_class .= $_s['loop_animation_hover_stop'] ? ' hover_stop' : '';
        $wrapper_class .= $_s['mask_effect_switch'] ? ' mask_effect' : '';
        $wrapper_data = '';
        $animation_delay = 0;

        if ( !!$_s['text_appear_switch'] ){
            wp_enqueue_style('animate', esc_url(get_template_directory_uri() . '/css/animate.css'), array('e-animations'));
        }

        if ($_s['text_parallax_switch']) {
            wp_enqueue_script( 'jquery-paroller', get_template_directory_uri() . '/js/jquery.paroller.min.js', ['jquery'] );
            $wrapper_data .= ' data-paroller-direction="' . $_s['text_parallax_dir'] . '"';

            $desktop = isset($_s['text_parallax_factor']) && $_s['text_parallax_factor'] !== ''
                ? $_s['text_parallax_factor']
                : null;

            $tablet = isset($_s['text_parallax_factor_tablet']) && $_s['text_parallax_factor_tablet'] !== ''
                ? $_s['text_parallax_factor_tablet']
                : $desktop;

            $mobile = isset($_s['text_parallax_factor_mobile']) && $_s['text_parallax_factor_mobile'] !== ''
                ? $_s['text_parallax_factor_mobile']
                : $tablet;

            if ($desktop !== null) {
                $wrapper_data .= ' data-paroller-factor="' . sprintf('%.2f', $desktop) . '"';
            }
            if ($tablet !== null) {
                $wrapper_data .= ' data-paroller-factor-lg="' . sprintf('%.2f', $tablet) . '" data-paroller-factor-md="' . sprintf('%.2f', $tablet) . '"';
            }
            if ($mobile !== null) {
                $wrapper_data .= ' data-paroller-factor-sm="' . sprintf('%.2f', $mobile) . '" data-paroller-factor-xs="' . sprintf('%.2f', $mobile) . '"';
            }
        }

        if ($_s['scroll_text_appear_switch']) {
            $wrapper_data .= !empty($_s['scroll_text_start_percent']['size']) ? ' data-start-percent="' . $_s['scroll_text_start_percent']['size'] . '"' : '';
            $wrapper_data .= !empty($_s['scroll_text_duration']['size']) ? ' data-duration-factor="' . $_s['scroll_text_duration']['size'] . '"' : '';
            $wrapper_data .= !empty($_s['scroll_text_opacity']['size']) ? ' data-text-opacity="' . $_s['scroll_text_opacity']['size'] . '"' : '';
            $wrapper_data .= !empty($_s['scroll_text_words']) ? ' data-delay-words="' . $_s['scroll_text_words'] . '"' : '';
        }

        foreach ($_s['text_editor_list'] as $index => $item) {
            $item_class = '';
            if (isset($item['cursor_tooltip']) && '' != $item['cursor_tooltip']) {
                add_filter( 'wgl/burido_module_cursor', function () { return true; });
                $item_class .= ' wgl-cursor-text';
            }
            $cursor = new WGL_Cursor;
            $cursor_data = $cursor->build($this, $item, $item['_id']);

            $text = $item['title'] ?? '';
            $link = $item['link'] ?? '';
            $text_appear = '';

            $this->add_render_attribute('thumbnail', 'src', $item['image']['url']);
            $this->add_render_attribute('thumbnail', 'alt', Control_Media::get_image_alt($item['image']));
            $this->add_render_attribute('thumbnail', 'title', Control_Media::get_image_title($item['image']));

            $media_html = Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'image');
            if ('' !== $media_html) {
                $item_class .= ' text-editor__image';
            }

            if ('words' === $_s['text_appear_mode']) {
                if (!!$media_html){
                    $animation_delay = $animation_delay + (int)$_s['text_appear_delay'];
                    $text_appear .= '<span class="target ' . $_s['text_appear_animation'] . '" style="--wgl-text-delay: ' . $animation_delay . 'ms">' . $media_html . '</span>';
                }

                if (!!$text){
                    foreach ($appear_array = explode(' ', $text) as $key => $value) {
                        $animation_delay = $animation_delay + (int)$_s['text_appear_delay'];
                        if ($value == ' ') {
                            $text_appear .= ' ';
                        } else {
                            $text_appear .= '<span class="target ' . $_s['text_appear_animation'] . '" style="--wgl-text-delay: ' . $animation_delay . 'ms">' . $value . '</span>';
                        }
                        if ($key !== array_key_last($appear_array)) {
                            $text_appear .= ' ';
                        }
                    }
                }
                $text = $text_appear;
            } else if ('letters' === $_s['text_appear_mode']) {
                if (!!$media_html){
                    $animation_delay = $animation_delay + (int)$_s['text_appear_delay'];
                    $text_appear .= '<span class="target ' . $_s['text_appear_animation'] . '" style="--wgl-text-delay: ' . $animation_delay . 'ms">' . $media_html . '</span>';
                }

                if (!!$text) {
                    $text_appear .= '<span class="word">';
                    $len = mb_strlen($text, 'UTF-8');
                    for ($i = 0; $i < $len; $i++) {
                        $animation_delay = $animation_delay + (int)$_s['text_appear_delay'];
                        $value = mb_substr($text, $i, 1, 'UTF-8');
                        if ($value == ' ') {
                            $text_appear .= '</span> <span class="word">';
                        } else {
                            $text_appear .= '<span class="target ' . $_s['text_appear_animation'] . '" style="--wgl-text-delay: ' . $animation_delay . 'ms">' . $value . '</span>';
                        }
                    }
                    $text_appear .= '</span>';
                }
                $text = $text_appear;
            } else if ('items' === $_s['text_appear_mode']) {
                $animation_delay = $animation_delay + (int)$_s['text_appear_delay'];
                $text = '<span class="target ' . $_s['text_appear_animation'] . '" style="--wgl-text-delay: ' . $animation_delay . 'ms">' . $media_html . $text . '</span>';
            } else {
                $text = $media_html . $text;
            }

            unset($text_appear); // break the reference

            $has_link = !empty($link['url']);

            if ($has_link) {
                $link = $this->get_repeater_setting_key('link', 'items', $index);
                $this->add_link_attributes($link, $item['link']);
                $text_tag = 'a ' . $this->get_render_attribute_string($link);
                $text_tag_close = 'a';
            } else {
                $text_tag = $text_tag_close = 'span';
            }

            if ($item['customize_item_switch']) {
                $item_class .= ' elementor-repeater-item-' . $item['_id'];
            }

            $item_class = !empty($item_class) ? ' class="' . $item_class . '"' : '';

            $items_text .= '<' . $text_tag . $item_class . $cursor_data . '>'
                . $text
                . '</' . $text_tag_close . '>';
        }

        if ($_s['mask_effect_switch']) {
            $items_text_html_clone = '<div class="text-editor_wrapper text-editor_wrapper-clone">' . $items_text . '</div>';
        }

        if ($_s['loop_animation_switch']) {
            $items_text_html_clone = str_repeat($items_text,$loop_animation_clone_count);
            $items_text_html_clone = '<div class="text-editor_wrapper text-editor_wrapper-clone">' . $items_text_html_clone . '</div>';
            $items_text_html_clone = str_repeat($items_text_html_clone,2);
        }

        $items_text_html = '<' . $_s['title_tag'] . ' class="text-editor_wrapper">' . $items_text . '</' . $_s['title_tag'] . '>';

        echo '<div class="wgl-text-editor' . $wrapper_class . '"' . $wrapper_data . '>',
            $items_text_html,
            $items_text_html_clone,
        '</div>';
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
