<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-time-line-vertical.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Background,
    Group_Control_Image_Size,
    Group_Control_Css_Filter,
    Icons_Manager,
    Plugin,
    Utils,
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Repeater,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Cursor
};

class WGL_Time_Line_Vertical extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-time-line-vertical';
    }

    public function get_title()
    {
        return esc_html__('WGL Time Line Vertical', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-time-line-vertical';
    }

    public function get_keywords()
    {
        return [ 'time', 'line', 'timeline', 'date', 'history', 'vertical' ];
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
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_content',
            [ 'label' => esc_html__('Content', 'burido-core') ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail_idle',
            [
                'label' => esc_html__('Thumbnail', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'thumbnail_switch',
            [
                'label' => esc_html__('Change on hover?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_responsive_control(
            'thumbnail_width',
            [
                'label' => esc_html__( 'Thumbnail Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 1200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .tlv__media [class|=tlv__thumbnail]' => 'width: {{SIZE}}{{UNIT}}; --image-width: {{SIZE}};',
                ],
            ]
        );

        $repeater->add_control(
            'thumbnail_hover',
            [
                'label' => esc_html__('Hover Thumbnail', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'condition' => [ 'thumbnail_switch!' => '' ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'types' => ['classic'],
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}::before',
            ]
        );

        $repeater->add_control(
            'date',
            [
                'label' => esc_html__('Date', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'bg_date',
            [
                'label' => esc_html__('Background Date', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'rows' => 1,
                'separator' => 'before',
                'placeholder' => esc_attr__('Your title', 'burido-core'),
            ]
        );


        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum.', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => [ 'url' => '#' ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Layers', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('The first steps', 'burido-core'),
                        'bg_date' => esc_html__('2014', 'burido-core'),
                    ],
                    [
                        'title' => esc_html__('Web & mobile solutions', 'burido-core'),
                        'bg_date' => esc_html__('2018', 'burido-core'),
                    ],
                    [
                        'title' => esc_html__('Dream team', 'burido-core'),
                        'bg_date' => esc_html__('2022', 'burido-core'),
                    ],
                    [
                        'title' => esc_html__('Awarded cases', 'burido-core'),
                        'bg_date' => esc_html__('2024', 'burido-core'),
                    ],
                ],
                'title_field' => '{{title}}',
            ]
        );

        $this->add_control(
            'media_position',
            [
                'label' => esc_html__('Media Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'render_type' => 'template',
                'options' => [
                    'inner' => esc_html__('Inner', 'burido-core'),
                    'outer' => esc_html__('Outer', 'burido-core'),
                ],
                'default' => 'outer',
                'prefix_class' => 'media_position-',
            ]
        );

        $this->add_mobile_breakpoint();

        $this->end_controls_section();

        /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'content_link',
            ['label' => esc_html__('Link', 'burido-core')]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('\'Read More\' Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Use', 'burido-core'),
                'label_off' => esc_html__('Hide', 'burido-core'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'condition' => [ 'add_read_more' => 'yes' ],
                'label_block' => true,
                'default' => esc_html__('Read More', 'burido-core'),
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => esc_html__( 'Button Type', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'style_transfer' => true,
                'options' => [
                    'wgl-button' => esc_html__( 'Default Button Style', 'burido-core' ),
                    'button-read-more' => esc_html__( 'Read More Style', 'burido-core' ),
                ],
                'condition' => [ 'add_read_more' => 'yes' ],
                'default' => 'button-read-more',
            ]
        );
        $this->add_control(
            'read_more_anim',
            [
                'label' => esc_html__('Read More Animation', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'style_transfer' => true,
                'render_type' => 'template',
                'options' => [
                    'default' => esc_html__( 'Default', 'burido-core' ),
                    'reverse' => esc_html__( 'Reverse', 'burido-core' ),
                    'disable' => esc_html__( 'Disable', 'burido-core' ),
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'button_type' => 'button-read-more',
                ],
                'prefix_class' => 'button_animation-',
                'default' => 'disable',
            ]
        );
        $this->add_control(
            'read_more_icon_type',
            [
                'label' => esc_html__('Icon Type', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'label_block' => false,
                'condition' => [
                    'add_read_more' => 'yes',
                    'button_type' => 'wgl-button',
                ],
                'toggle' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__('None', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'font' => [
                        'title' => esc_html__('Icon', 'burido-core'),
                        'icon' => 'far fa-smile',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'burido-core'),
                        'icon' => 'far fa-image',
                    ]
                ],
                'default' => 'font',
            ]
        );

        $this->add_control(
            'read_more_icon_fontawesome',
            [
                'label' => esc_html__('Button Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'font',
                    'button_type' => 'wgl-button',
                ],
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
                'label_block' => true,
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fas fa-arrow-right',
                ],
            ]
        );

        $this->add_control(
            'read_more_icon_thumbnail',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'image',
                    'button_type' => 'wgl-button',
                ],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $this->add_control(
            'read_more_icon_align',
            [
                'label' => esc_html__( 'Position', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type!' => '',
                    'button_type' => 'wgl-button',
                ],
                'options' => [
                    'row' => esc_html__( 'Before', 'burido-core' ),
                    'row-reverse' => esc_html__( 'After', 'burido-core' ),
                ],
                'default' => 'row-reverse',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button .button__content' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_indent',
            [
                'label' => esc_html__( 'Icon/Image Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_text!' => '',
                    'read_more_icon_type' => ['font','image'],
                    'button_type' => 'wgl-button',
                ],
                'range' => [
                    'px' => [ 'max' => 250 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'gap: {{SIZE}}{{UNIT}}; --wgl-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_top',
            [
                'label' => esc_html__('Icon/Image Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => ['min' => -50, 'max' => 50],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_text!' => '',
                    'read_more_icon_type' => ['font','image'],
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tlw__button .tlw__button__media img' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'custom'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'font',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_type' => 'wgl-button',
                ],
                'default' => ['size' => 20, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => '--icon-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_image_size',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'custom'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 200],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'image',
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .tlw__button__media img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_stroke_size',
            [
                'label' => esc_html__('SVG Stroke Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 300],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon path' => 'stroke-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CURSOR
         */

        WGL_Cursor::init(
            $this,
            [
                'section' => true,
            ]
        );

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> APPEARANCE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_animation',
            [ 'label' => esc_html__('Appearance', 'burido-core') ]
        );
        $this->add_control(
            'add_appear',
            [
                'label' => esc_html__('Use Appear Animation?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CURVE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_curve',
            [
                'label' => esc_html__('Main Curve', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'curve_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'allowed_dimensions' => 'vertical',
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'curve_gap',
            [
                'label' => esc_html__( 'Curve Gap', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 300, 'step' => 1 ],
                ],
                'default' => ['size' => 115],
                'tablet_default' => ['size' => 70],
                'mobile_default' => ['size' => 75],
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical' => '--curve-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_curve_size',
            [
                'label' => esc_html__( 'Horizontal Curve Size', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'default' => ['size' => 85],
                'tablet_default' => ['size' => 45],
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical' => '--curve-h-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_curve_position',
            [
                'label' => esc_html__( 'Horizontal Curve Position', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -100, 'max' => 100, 'step' => 1 ],
                ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__curve-wrapper::before' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__curve-wrapper::before' => 'right: {{SIZE}}{{UNIT}}; left: auto;',

                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(odd) .tlv__curve-wrapper::before' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(even) .tlv__curve-wrapper::before' => 'left: {{SIZE}}{{UNIT}}; right: auto;',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__curve-wrapper::before,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__curve-wrapper::before,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__curve-wrapper::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__curve-wrapper::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__curve-wrapper::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__curve-wrapper::before' => 'left: {{SIZE}}{{UNIT}} !important; right: auto !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'pointer_size',
            [
                'label' => esc_html__( 'Pointer Size', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'separator' => 'before',
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'default' => [ 'size' => 60 ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical' => '--dot-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'in_pointer_icon_color',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(0),
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical' => '--dot-icon-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'start_end_curve_color',
            [
                'label' => esc_html__('Start/End Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(0),
                'selectors' => [
                    '{{WRAPPER}} .tlv__item-start,
                     {{WRAPPER}} .tlv__item-end' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_pointer' );

        $this->start_controls_tab(
            'tab_pointer_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $this->add_control(
            'v_line_bg_idle',
            [
                'label' => esc_html__('Vertical Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(0),
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'in_pointer_color_idle',
            [
                'label' => esc_html__('Pointer Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(0),
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical' => '--dot-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'h_line_bg',
            [
                'label' => esc_html__('Horizontal Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(0),
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper::before' => '--curve-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_pointer_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'v_line_bg_hover',
            [
                'label' => esc_html__('Vertical Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical .tlv__items-wrapper:hover::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'in_pointer_color_hover',
            [
                'label' => esc_html__('Pointer Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__curve-wrapper .dot' => '--dot-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'h_line_bg_hover',
            [
                'label' => esc_html__('Horizontal Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__curve-wrapper::before' => '--curve-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT & MEDIA WRAPPER
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Content & Media Wrapper', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_gap',
            [
                'label' => esc_html__( 'Items Gap', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 300, 'step' => 1 ],
                ],
                'default' => ['size' => 90],
                'tablet_default' => ['size' => 60],
                'mobile_default' => ['size' => 60],
                'selectors' => [
                    '{{WRAPPER}} .wgl-timeline-vertical' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: Left/Right values are reversed for even items.', 'burido-core' ),
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '25',
                    'right' => '35',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'tablet_default' => [
                    'top' => '15',
                    'right' => '20',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'mobile_default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(odd) .tlv__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(even) .tlv__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__content-wrapper,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__content-wrapper,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__content-wrapper,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__content-wrapper,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__content-wrapper,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(odd) .tlv__content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(even) .tlv__content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__content-wrapper,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__content-wrapper,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__content-wrapper,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__content-wrapper,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__content-wrapper,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__content-wrapper' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',

                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(odd) .tlv__content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(even) .tlv__content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__content-wrapper,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__content-wrapper,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__content-wrapper,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__content-wrapper,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__content-wrapper,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_wrapper',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_wrapper_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );

        $this->add_control(
            'wrapper_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_idle',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                    ],
                    'color' => [
                        'label' => esc_html__( 'Border Color', 'burido-core' ),
                    ],
                ],
                'selector' => '{{WRAPPER}} .tlv__content-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_idle',
                'selector' => '{{WRAPPER}} .tlv__content-wrapper',
            ]
        );

        $this->add_control(
            'wrapper_blur_idle',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-wrapper' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'wrapper_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_hover',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                    ],
                    'color' => [
                        'label' => esc_html__( 'Border Color', 'burido-core' ),
                    ],
                ],
                'selector' => '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__content-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_hover',
                'selector' => '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__content-wrapper',
            ]
        );

        $this->add_control(
            'wrapper_blur_hover',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__content-wrapper' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> MEDIA
         */

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'media_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: Left/Right values are reversed for even items.', 'burido-core' ),
            ]
        );

        $this->add_responsive_control(
            'media_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__media' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__media' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_width',
            [
                'label' => esc_html__( 'Thumbnail Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 1200 ],
                ],
                'default' => ['size' => 420, 'unit' => 'px'],
                'tablet_default' => ['size' => 320, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media [class|=tlv__thumbnail]' => 'width: {{SIZE}}{{UNIT}}; --image-width: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_width_hover',
            [
                'label' => esc_html__( 'Image Width on Hover', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 1200 ],
                ],
                'condition' => [ 'media_width[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__media [class|=tlv__thumbnail]' => 'transform: scale( calc( {{SIZE}} / var(--image-width) ) );',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'media_border',
                'fields_options' => [
                    'border' => [ 'default' => 'none' ],
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                        'selectors' => [
                            '{{SELECTOR}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; top: -{{TOP}}{{UNIT}}; right: -{{RIGHT}}{{UNIT}}; bottom: -{{BOTTOM}}{{UNIT}}; left: -{{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}} .tlv__media::before',
            ]
        );

        $this->start_controls_tabs( 'tabs_media' );
        $this->start_controls_tab(
            'tab_media_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $this->add_control(
            'media_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'media_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'media_border_border!' => ['', 'none'] ],
                'default' => WGL_Globals::get_secondary_color(0),
                'selectors' => [
                    '{{WRAPPER}} .tlv__media::before' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_border_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit'  => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__media' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_rotate_idle',
            [
                'label' => esc_html__('Image Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['size' => -15, 'unit' => 'deg'],
                'tablet_default' => ['size' => -5, 'unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__media img' => 'transform: rotate({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__media img' => 'transform: rotate(calc(-1 * {{SIZE}}{{UNIT}}));',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_border_offset_x_idle',
            [
                'label' => esc_html__('Border Offset X', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 70, 'step' => 1],
                ],
                'condition' => [ 'media_border_border!' => ['', 'none'] ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media::before' => '--border-offset-x: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_border_offset_y_idle',
            [
                'label' => esc_html__('Border Offset Y', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 70, 'step' => 1],
                ],
                'condition' => [ 'media_border_border!' => ['', 'none'] ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media::before' => '--border-offset-y: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'media_shadow_idle',
                'selector' => '{{WRAPPER}} .tlv__media',
            ]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'media_css_filters_idle',
                'selector' => '{{WRAPPER}} .tlv__media img',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_media_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'media_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__media' => 'background-color: {{VALUE}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'media_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'media_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__media::before' => 'border-color: {{VALUE}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media::before,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media::before,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media::before' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd):hover .tlv__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even):hover .tlv__media' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_rotate_hover',
            [
                'label' => esc_html__('Image Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['size' => 0, 'unit' => 'deg'],
                'tablet_default' => ['size' => 0, 'unit' => 'deg'],
                'mobile_default' => ['size' => 0, 'unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd):hover .tlv__media img' => 'transform: rotate({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even):hover .tlv__media img' => 'transform: rotate(calc(-1 * {{SIZE}}{{UNIT}}));',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media img,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media img,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media img,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media img,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media img,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media img' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_border_offset_x_hover',
            [
                'label' => esc_html__('Border Offset X', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 70, 'step' => 1],
                ],
                'condition' => [ 'media_border_border!' => ['', 'none'] ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__media::before' => '--border-offset-x: {{SIZE}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media::before,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media::before,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media::before' => '--border-offset-x: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_border_offset_y_hover',
            [
                'label' => esc_html__('Border Offset Y', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 70, 'step' => 1],
                ],
                'condition' => [ 'media_border_border!' => ['', 'none'] ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__media::before' => '--border-offset-y: {{SIZE}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media::before,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media::before,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media::before' => '--border-offset-y: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'media_shadow_hover',
                'selector' => '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__media,
                
                    body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media,
                    body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media,
                    body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media,
                    body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media,
                    body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media,
                    body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media',
            ]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'media_css_filters_hover',
                'selector' => '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__media img,
                
                    body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__media img,
                    body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__media img,
                    body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__media img,
                    body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__media img,
                    body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__media img,
                    body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__media img',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'description' => esc_html__('Note. Left/Right values are reversed for even items.', 'burido-core'),
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__content,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__content,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__content,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__content,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__content,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',

                ],
            ]
        );
        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__( 'Content Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 768 ],
                ],
                'default' => [ 'size' => 360, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content' => 'max-width: min({{SIZE}}{{UNIT}}, 100%);',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_content_bg' );

        $this->start_controls_tab(
            'tab_content_bg_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );

        $this->add_control(
            'content_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_bg_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );

        $this->add_control(
            'content_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title Styles', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_title',
                'fields_options' => [
                    'typography' => [ 'default' => 'yes' ],
                    'font_size' => [
                        'default' => [ 'size' => 32, 'unit' => 'px' ],
                        'tablet_default' => [ 'size' => 28, 'unit' => 'px' ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .tlv__title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__title,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__title,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_title' );

        $this->start_controls_tab(
            'tab_title_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'heading_text',
            [
                'label' => esc_html__('Text Styles', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_text',
                'fields_options' => [
                    'typography' => [ 'default' => 'yes' ],
                    'font_size' => [
                        'default' => [ 'size' => 18, 'unit' => 'px' ],
                    ],
                    'line_height' => [
                        'default' => [ 'size' => 1.778, 'unit' => 'em' ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .tlv__text',
            ]
        );

        $this->add_responsive_control(
            'content_text_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__text' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__text,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__text,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__text,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__text,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__text,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_content' );

        $this->start_controls_tab(
            'tab_content_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> DATE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_date',
            [
                'label' => esc_html__('Date', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date',
                'selector' => '{{WRAPPER}} .tlv__date',
            ]
        );

        $this->add_responsive_control(
            'date_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__date' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'date_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__date' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}}  {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'date_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__date' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}}  {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_date' );

        $this->start_controls_tab(
            'date_colors_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );

        $this->add_control(
            'date_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_date_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );

        $this->add_control(
            'date_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__date' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BACKGROUND DATE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_bg_date',
            [
                'label' => esc_html__('Background Date', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bg_date',
                'fields_options' => [
                    'typography' => [ 'default' => 'yes' ],
                    'font_size' => [
                        'default' => [ 'size' => 64, 'unit' => 'px' ],
                        'tablet_default' => [ 'size' => 56, 'unit' => 'px' ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .tlv__bg_date',
            ]
        );

        $this->add_responsive_control(
            'bg_date_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => [ 'media_position' => 'outer' ],
                'default' => [
                    'top' => 'auto',
                    'right' => '-38px',
                    'bottom' => 'auto',
                    'left' => 'auto',
                    'unit'  => 'custom',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => 'auto',
                    'right' => '-33px',
                    'bottom' => 'auto',
                    'left' => 'auto',
                    'unit'  => 'custom',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => 'auto',
                    'right' => 'auto',
                    'bottom' => '0px',
                    'left' => '-5px',
                    'unit'  => 'custom',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__bg_date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__bg_date' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__bg_date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__bg_date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__bg_date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__bg_date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__bg_date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__bg_date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'bg_date_margin_inner_img',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => [ 'media_position' => 'inner' ],
                'default' => [
                    'top' => 'auto',
                    'right' => '-95px',
                    'bottom' => '35%',
                    'left' => 'auto',
                    'unit'  => 'custom',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => 'auto',
                    'right' => '-60px',
                    'bottom' => '35%',
                    'left' => 'auto',
                    'unit'  => 'custom',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => 'auto',
                    'right' => 'auto',
                    'bottom' => 'auto',
                    'left' => '-80px',
                    'unit'  => 'custom',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(odd) .tlv__bg_date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(even) .tlv__bg_date' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__bg_date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__bg_date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__bg_date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__bg_date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__bg_date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__bg_date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_date_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__bg_date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__bg_date' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(odd) .tlv__bg_date' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(even) .tlv__bg_date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__bg_date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__bg_date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__bg_date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__bg_date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__bg_date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__bg_date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'bg_date_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(odd) .tlv__bg_date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__items-wrapper:nth-child(even) .tlv__bg_date' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}}  {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',

                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(odd) .tlv__bg_date' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}}.media_position-inner .tlv__items-wrapper:nth-child(even) .tlv__bg_date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__bg_date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__bg_date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__bg_date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__bg_date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__bg_date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__bg_date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_date_stroke_size',
            [
                'label' => esc_html__('Stroke Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 0, 'max' => 2, 'step' => 0.1]],
                'selectors' => [
                    '{{WRAPPER}} .tlv__bg_date' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_date_rotate',
            [
                'label' => esc_html__('BG Date Rotate', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'transform: unset; writing-mode: unset;' => [
                        'title' => esc_html__('Default', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'transform: rotate(180deg); writing-mode: vertical-rl;' => [
                        'title' => esc_html__('Rotated -90deg', 'burido-core'),
                        'icon' => 'eicon-arrow-up',
                    ],
                    'transform: unset; writing-mode: vertical-rl;' => [
                        'title' => esc_html__('Rotated +90deg', 'burido-core'),
                        'icon' => 'eicon-arrow-down',
                    ]
                ],
                'default' => 'transform: rotate(180deg); writing-mode: vertical-rl;',
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlv__bg_date' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_date_z_index',
            [
                'label' => esc_html__('Z-Index', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => -1000, 'max' => 1000, 'step' => 1]
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__bg_date' => 'z-index: {{SIZE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_bg_date' );
        $this->start_controls_tab(
            'bg_date_colors_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $this->add_control(
            'bg_date_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_h_font_color(0.16),
                'selectors' => [
                    '{{WRAPPER}} .tlv__bg_date' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_date_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__bg_date' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_date_stroke_color_idle',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_date_stroke_size[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__bg_date' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_bg_date_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'bg_date_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__bg_date' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__bg_date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__bg_date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__bg_date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__bg_date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__bg_date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__bg_date' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'bg_date_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__bg_date' => 'background-color: {{VALUE}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__bg_date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__bg_date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__bg_date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__bg_date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__bg_date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__bg_date' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'bg_date_stroke_color_hover',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_date_stroke_size[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlv__bg_date' => '-webkit-text-stroke-color: {{VALUE}};',

                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .tlv__bg_date,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .tlv__bg_date,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .tlv__bg_date,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .tlv__bg_date,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .tlv__bg_date,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .tlv__bg_date' => '-webkit-text-stroke-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BUTTON
         */

        $this->start_controls_section(
            'style_button',
            [
                'label' => esc_html__('Button', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['add_read_more!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'selector' => '{{WRAPPER}} .tlw__button .button__text',
            ]
        );
        $this->add_responsive_control(
            'button_decoration_line_size',
            [
                'label' => esc_html__('Decoration Line Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 20, 'step' => 1],
                    'em' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .button__text' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_underline_offset',
            [
                'label' => esc_html__('Underline Offset Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => 'underline' ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => -20, 'max' => 20, 'step' => 1],
                    'em' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .button__text' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '21',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_inner_padding',
            [
                'label' => esc_html__('Inner Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'render_type' => 'template',
                'dynamic' => ['active' => true],
                'fields_options' => [
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selector' => '{{WRAPPER}} .tlw__button',
            ]
        );

        $this->add_control(
            'read_more_button_width',
            [
                'label' => esc_html__( 'Button Min-Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_alignment!' => ['space-evenly', 'space-around', 'space-between'],
                ],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [
                    'px' => ['max' => 500],
                    '%' => ['max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-align-end-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Evenly', 'burido-core'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Around', 'burido-core'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'burido-core' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'button_',
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_position',
            [
                'label' => esc_html__('Button Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'relative' => esc_html__('Default', 'burido-core'),
                    'absolute' => esc_html__('Absolute', 'burido-core'),
                ],
                'default' => 'relative',
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'position: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_position_offset_x',
            [
                'label' => esc_html__( 'Offset X', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => [ 'px', '%', 'vw', 'vh', 'custom' ],
                'condition' => [
                    'button_position!' => 'relative',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'button_position_offset_y',
            [
                'label' => esc_html__( 'Offset Y', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => [ 'px', '%', 'vh', 'vw', 'custom' ],
                'condition' => [
                    'button_position!' => 'relative',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button' );
        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlw__button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button,
                     {{WRAPPER}} .tlw__button::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlw__button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .tlw__button::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_idle',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .button__text' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_idle-dynamic',
            [
                'label' => esc_html__('Decoration Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlw__button .button__text' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_idle',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon,
				     {{WRAPPER}} .tlw__button .wgl-icon::before' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'button_icon_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .tlw__button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_idle',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'stroke: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon' => 'stroke: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'button_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlw__button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_idle',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .tlw__button',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_idle',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_idle',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg', 'turn' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_item_hover',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'button_color_item_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_item_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_item_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .tlw__button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_item_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button,
                     {{WRAPPER}} .tlv__items-wrapper:hover .tlw__button::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_item_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_bg_item_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .tlw__button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .tlw__button::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_item_hover',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button .button__text' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_item_hover-dynamic',
            [
                'label' => esc_html__('Decoration Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .tlw__button .button__text' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_item_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_item_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_item_hover',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .wgl-icon,
				     {{WRAPPER}} .tlv__items-wrapper:hover .button-read-more .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_item_hover-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .tlw__button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_item_hover',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_item_hover-dynamic',
            [
                'label' => esc_html__('Icon Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_item_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'button_border_color_item_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper:hover .tlw__button' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_item_hover',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_item_hover',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_item_hover',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg', 'turn' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} tlv__items-wrapper .tlw__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_hover',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_hover-dynamic',
            [
                'label' => esc_html__('Decoration Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_hover',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon,
				     {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_hover',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_hover-dynamic',
            [
                'label' => esc_html__('Icon Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_hover',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_hover',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg', 'turn' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_active',
            ['label' => esc_html__('Active', 'burido-core')]
        );
        $this->add_control(
            'button_color_active',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_active-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_active',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:active::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_active-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_bg_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_active',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_active-dynamic',
            [
                'label' => esc_html__('Decoration Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_active-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_active',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon,
				     {{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_active-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_active',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_active-dynamic',
            [
                'label' => esc_html__('Icon Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_active',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_active-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button:active' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_active',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_active',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_active',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg', 'turn' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> BUTTON ANIMATION */

        $this->start_controls_section(
            'style_button_animation',
            [
                'label' => esc_html__( 'Button Animation', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'button_type' => 'wgl-button' ],
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
                    'separated' => esc_html__('Separated Button', 'burido-core'),
                    'highlight_animation' => esc_html__('Highlight Animation', 'burido-core'),
                    'bg_animation' => esc_html__('Background Animation ', 'burido-core'),
                    'border_animation' => esc_html__('Border Animation', 'burido-core'),
                    'magnetic' => esc_html__('Magnetic', 'burido-core'),
                    'icon_size_animation' => esc_html__('Icon Size Animation', 'burido-core'),
                    'icon_visibility' => esc_html__('Icon Visibility', 'burido-core'),
                ],
                'prefix_class' => 'has-',
                'default' => '',
            ]
        );

        /** Separated Button Animation */
        $this->add_responsive_control(
            'icon_wrapper_size',
            [
                'label' => esc_html__( 'Icon Wrapper Size', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'condition' => [ 'button_animation_style' => 'separated' ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button ' => '--wgl-icon-wrapper: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /** Highlight Animation */
        $this->add_control(
            'stroke_highlight_color_normal',
            [
                'label' => esc_html__( 'Stroke Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'highlight_animation' ],
                'selectors' => [
                    '{{WRAPPER}} .highlight_svg path' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'stroke_highlight_color_normal-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_animation_style' => 'highlight_animation',
                    'stroke_highlight_color_normal!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .highlight_svg path' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stroke_highlight_width_normal',
            [
                'label' => esc_html__( 'Stroke Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'condition' => [ 'button_animation_style' => 'highlight_animation' ],
                'range' => [
                    'px' => [ 'min' => 0.1, 'max' => 10 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .highlight_svg path' => 'stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /** Background Animation */
        $this->start_controls_tabs( 'button_animation', [
            'condition' => [ 'button_animation_style' => 'bg_animation' ],
        ] );
        $this->start_controls_tab(
            'button_animation_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_responsive_control(
            'button_bg_top_offset_idle',
            [
                'label' => esc_html__( 'Background Top Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_bg_left_offset_idle',
            [
                'label' => esc_html__( 'Background Left Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button::after' => 'left:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_bg_size',
            [
                'label' => esc_html__('Background Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 200 ],
                    '%' => [ 'min' => 0, 'max' => 100 ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button::after' => '--bg-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'button_bg_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_animation_item_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_responsive_control(
            'button_bg_top_offset_item_hover',
            [
                'label' => esc_html__( 'Background Top Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_bg_left_offset_item_hover',
            [
                'label' => esc_html__( 'Background Left Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_bg_size_item_hover',
            [
                'label' => esc_html__('Background Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'custom' ],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'render_type' => 'template',
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 2000 ],
                    '%' => [ 'min' => 0, 'max' => 100 ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_border_radius_item_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'default' => [
                    'top' => '32',
                    'right' => '32',
                    'bottom' => '32',
                    'left' => '32',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_animation_hover',
            [ 'label' => esc_html__( 'Hover', 'burido-core' ) ]
        );
        $this->add_responsive_control(
            'button_bg_top_offset_hover',
            [
                'label' => esc_html__( 'Background Top Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover::after,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:focus::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_bg_left_offset_hover',
            [
                'label' => esc_html__( 'Background Left Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover::after,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:focus::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_bg_size_hover',
            [
                'label' => esc_html__('Background Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'custom' ],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'render_type' => 'template',
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 2000 ],
                    '%' => [ 'min' => 0, 'max' => 100 ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover::after,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:focus::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'default' => [
                    'top' => '32',
                    'right' => '32',
                    'bottom' => '32',
                    'left' => '32',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover::after,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:focus::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_animation_active',
            [ 'label' => esc_html__( 'Active', 'burido-core' ) ]
        );
        $this->add_responsive_control(
            'button_bg_top_offset_active',
            [
                'label' => esc_html__( 'Background Top Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_bg_left_offset_active',
            [
                'label' => esc_html__( 'Background Left Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => -200, 'max' => 200 ],
                    '%' => ['min' => -100,'max' => 100],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_bg_size_active',
            [
                'label' => esc_html__('Background Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'custom' ],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 2000 ],
                    '%' => [ 'min' => 0, 'max' => 100 ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'button_bg_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'default' => [
                    'top' => '32',
                    'right' => '32',
                    'bottom' => '32',
                    'left' => '32',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        /** Border Animation */
        $this->add_control(
            'button_border_animation_revers',
            [
                'label' => esc_html__( 'Revers This Animation', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'revers',
                'prefix_class' => '',
                'condition' => [ 'button_animation_style' => 'border_animation' ],
            ]
        );

        $this->add_control(
            'button_border_animation_color',
            [
                'label' => esc_html__( 'Animation Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'border_animation' ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button' => '--ab-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_animation_color-dynamic',
            [
                'label' => esc_html__('Animation Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_animation_style' => 'border_animation',
                    'button_border_animation_color!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .tlv__items-wrapper .tlw__button' => '--ab-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_border_animation_offset',
            [
                'label' => esc_html__('Animation Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 20, 'step' => 1],
                ],
                'condition' => [ 'button_animation_style' => 'border_animation' ],
                'default' => ['size' => 6],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button' => '--ab-offset: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_border_animation_width',
            [
                'label' => esc_html__('Animation Border Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 10, 'step' => 1],
                ],
                'condition' => [ 'button_animation_style' => 'border_animation' ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button' => '--ab-width: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_border_animation_extend',
            [
                'label' => esc_html__('Mow Much to Extend the Border', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 50, 'step' => 1],
                ],
                'condition' => [ 'button_animation_style' => 'border_animation' ],
                'default' => ['size' => 4],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button' => '--ab-extend: {{SIZE}};',
                ],
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

        /** Icon Size Animation */
        $this->add_control(
            'button_icon_bg_animation',
            [
                'label' => esc_html__( 'Background Size(px)', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'button_animation_style' => 'icon_size_animation' ],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
                'default' => ['size' => 8, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .wgl-icon' => '--icon-bg-size: {{SIZE}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'button_icon_size_animation_tabs', [
            'condition' => [ 'button_animation_style' => 'icon_size_animation' ],
        ] );
        $this->start_controls_tab(
            'button_icon_size_animation_tab_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'button_icon_size_animation_idle',
            [
                'label' => esc_html__( 'Icon Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .wgl-icon' => '--icon-scale: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_animation_idle',
            [
                'label' => esc_html__( 'Background Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'default' => ['size' => 1, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tlw__button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'button_icon_size_animation_tab_item_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'button_icon_size_animation_item_hover',
            [
                'label' => esc_html__( 'Icon Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button .wgl-icon' => '--icon-scale: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_animation_item_hover',
            [
                'label' => esc_html__( 'Background Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper:hover .tlw__button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'button_icon_size_animation_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'button_icon_size_animation_hover',
            [
                'label' => esc_html__( 'Icon Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:focus .wgl-icon' => '--icon-scale: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_animation_hover',
            [
                'label' => esc_html__( 'Background Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'default' => ['size' => 1.25, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:hover .wgl-icon,
                     {{WRAPPER}} .tlv__items-wrapper .tlw__button:focus .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'button_icon_size_animation_tab_active',
            [ 'label' => esc_html__( 'Active', 'burido-core' ) ]
        );
        $this->add_control(
            'button_icon_size_animation_active',
            [
                'label' => esc_html__( 'Icon Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon' => '--icon-scale: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_animation_active',
            [
                'label' => esc_html__( 'Background Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.01 ] ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__items-wrapper .tlw__button:active .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        /** Icon Visibility */
        $this->add_control(
            'icon_visibility',
            [
                'label' => esc_html__( 'Icon Visibility', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [ 'button_animation_style' => 'icon_visibility' ],
                'options' => [
                    'default' => esc_html__( 'Default', 'burido-core' ),
                    'revert' => esc_html__( 'Revert', 'burido-core' ),
                ],
                'default' => 'default',
                'prefix_class' => 'icon-visibility-'
            ]
        );

        $this->end_controls_section();
    }

    protected function add_mobile_breakpoint() {
        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();

        $avaliable_breakpoints = [];
        foreach ( $active_devices as $breakpoint_key ) {
            $label = 'desktop' === $breakpoint_key ? esc_html__( 'Desktop', 'burido-core' ) : $active_breakpoints[ $breakpoint_key ]->get_label();
            $avaliable_breakpoints[$breakpoint_key] = $label;
        }

        $this->add_control(
            'wgl_mobile_breakpoint',
            [
                /* translators: %s: Device Name. */
                'label' => esc_html__( 'Set Mobile Template On:', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => $avaliable_breakpoints,
                'default' => 'mobile',
            ]
        );
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

        $this->add_render_attribute(
            'timeline-vertical', [ 'class' => [
                'wgl-timeline-vertical',
                $_s[ 'add_appear' ] ? 'appear_animation' : '',
            ] ]
        );

        // Read more button
        $btn_icon = '';
        // Read more button
        if ($_s['add_read_more']) {
            $this->add_render_attribute('btn', 'class',
                [
                    'tlw__button',
                    $_s['button_type'] ?? '',
                    !$_s['read_more_text'] ? 'no_text' : ''
                ]
            );

            $btn_icon = '';
            // ↓ Icon|Image
            if ('' !== $_s['read_more_icon_type'] ) {
                if (
                    'font' === $_s['read_more_icon_type']
                ) {
                    if(isset($_s['read_more_icon_fontawesome']['value'])) {
                        $migrated = isset( $_s['__fa4_migrated']['read_more_icon_fontawesome'] );
                        $is_new = Icons_Manager::is_migration_allowed();
                        if ( $is_new || $migrated ) {
                            ob_start();
                            Icons_Manager::render_icon($_s['read_more_icon_fontawesome'], ['class' => 'read-more-icon', 'aria-hidden' => 'true']);
                            $btn_icon = ob_get_clean();
                        }
                        if ('svg' === $_s['read_more_icon_fontawesome']['library']) {
                            $wrapper_icon = '<span class="read-more-icon read-more-svg">';
                            $wrapper_icon .= $btn_icon;
                            $wrapper_icon .= '</span>';
                            $btn_icon = $wrapper_icon;
                        }
                        $btn_icon = !!$btn_icon ? '<span class="wgl-icon"> ' . $btn_icon . '</span>' : '';

                        $btn_icon = 'wgl-button' === $_s['button_type'] ? '<div class="icon-wrapper">' . $btn_icon . '</div>' : $btn_icon;
                    }
                }

                if (
                    'image' === $_s['read_more_icon_type']
                    && !empty($_s['read_more_icon_thumbnail']['url'])
                ) {
                    $this->add_render_attribute('thumbnail', 'src', $_s['read_more_icon_thumbnail']['url']);
                    $this->add_render_attribute('thumbnail', 'alt', Control_Media::get_image_alt($_s['read_more_icon_thumbnail']));
                    $this->add_render_attribute('thumbnail', 'title', Control_Media::get_image_title($_s['read_more_icon_thumbnail']));

                    $media_html = Group_Control_Image_Size::get_attachment_image_html($_s, 'thumbnail', 'read_more_icon_thumbnail');
                    $btn_icon = '<span class="wgl-service_button__media">'.$media_html.'</span>';
                    $this->add_render_attribute(['btn' => ['class' => [ 'image']]]);
                }
            }else{
                $this->add_render_attribute(['btn' => ['class' => [ 'no_media']]]);
            }

            // ↑ icon|image
        }


        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $key = array_search($_s['wgl_mobile_breakpoint'], $active_devices);
        $all_breakpoints = array_slice($active_devices, $key);
        foreach($all_breakpoints as $breakpoint){
            $this->add_render_attribute( 'timeline-vertical', [ 'class' => [ 'breakpoint_on-' . $breakpoint ] ] );
        }

        // Render
        echo '<div ', $this->get_render_attribute_string('timeline-vertical'), '>';

        foreach ($_s['items'] as $index => $item) {

            // Read more button
            $tlv_button = '';
            if ($_s['add_read_more'] && !empty($item['link']['url'])) {
                // Link
                $link = $this->get_repeater_setting_key('link', 'list', $index);
                $this->add_link_attributes($link, $item['link']);

                $tlv_button = '<div class="wgl-button-wrapper">';
                $tlv_button .= '<a '.$this->get_render_attribute_string($link).' '.$this->get_render_attribute_string('btn').'>';
                $tlv_button .= 'wgl-button' === $_s['button_type'] ? '<div class="button__content">' : '';
                $tlv_button .= $btn_icon ?: '';
                $tlv_button .= $_s['read_more_text'] ? '<span>' . esc_html($_s['read_more_text']) . '</span>' : '';
                $tlv_button .= 'wgl-button' === $_s['button_type'] ? '</div>' : '';
                $tlv_button .= '</a>';
                $tlv_button .= '</div>';
            }

            $tlv__item = $this->get_repeater_setting_key('tlv__item', 'list', $index);
            $this->add_render_attribute([$tlv__item => [
                'class' => [
                    'tlv__items-wrapper',
                    'elementor-repeater-item-'. $item['_id']
                ]
            ]]);
            ?><div <?php echo $this->get_render_attribute_string($tlv__item) ?>><?php

            $thumbnail_idle = $this->get_repeater_setting_key('thumbnail', 'list', $index);
            $url_idle = $item['thumbnail_idle']['url'] ?? false;
            $this->add_render_attribute($thumbnail_idle, [
                'class' => 'tlv__thumbnail--idle',
                'src' => $url_idle ? esc_url($url_idle) : '',
                'alt' => Control_Media::get_image_alt($item['thumbnail_idle']),
            ]);

            $thumbnail_hover = $this->get_repeater_setting_key('thumbnail_hover', 'list', $index);
            $url_hover = $item['thumbnail_hover']['url'] ?? false;
            $this->add_render_attribute($thumbnail_hover, [
                'class' => 'tlv__thumbnail--hover',
                'src' => $url_hover ? esc_url($url_hover) : '',
                'alt' => Control_Media::get_image_alt($item['thumbnail_hover']),
            ]);
            ?><div class="tlv__item<?php echo $url_idle ? ' has_media' : '';?>">
            <div class="tlv__curve-wrapper">
                <div class="dot"><i class="wgl-svg-icon"><?php echo wgl_dynamic_styles()->wgl_theme_svg()['arrow-down-right']; ?></i></div>
            </div>
            <div class="tlv__volume-wrapper">
                <div class="tlv__content-wrapper">
                    <div class="tlv__content"><?php

                        if ('outer' !== $_s['media_position'] && $url_idle){

                            if (!!$item['bg_date']) {
                                ?><span class="tlv__bg_date"><?php
                                echo $item['bg_date'];
                                ?></span><?php
                            }

                            ?><div class="tlv__media"><?php
                                if ( $url_hover ) {
                                    echo '<img ', $this->get_render_attribute_string( $thumbnail_hover ), '/>';
                                }
                                echo '<img ', $this->get_render_attribute_string( $thumbnail_idle ), '/>';
                            ?></div><?php
                        }

                        if (!empty($item['date'])) {
                            ?><div class="tlv__date-wrapper"><?php
                                ?><span class="tlv__date"><?php
                                    echo $item['date'];
                                ?></span><?php
                            ?></div><?php
                        }

                        if (!empty($item['title'])) {
                            ?><h3 class="tlv__title"><?php
                                echo $item['title'];
                            ?></h3><?php
                        }

                        if (!empty($item['content'])) {
                            ?><div class="tlv__text"><?php
                                echo wp_kses( $item['content'], $allowed_html );
                            ?></div><?php
                        }

                        if (!empty($tlv_button)) {
                            echo $tlv_button;
                        }

                        ?></div>
                </div>
            </div>
            </div><?php

            if ('outer' === $_s['media_position'] && $url_idle){
                ?><div class="tlv__item image"><?php

                if (!!$item['bg_date']) {
                    ?><span class="tlv__bg_date"><?php
                        echo $item['bg_date'];
                    ?></span><?php
                }

                ?><div class="tlv__media"><?php
                    if ( $url_hover ) {
                        echo '<img ', $this->get_render_attribute_string( $thumbnail_hover ), '/>';
                    }
                    echo '<img ', $this->get_render_attribute_string( $thumbnail_idle ), '/>';
                    ?></div>
                </div><?php
            }

            ?></div><?php
        }

        echo '<div class="tlv__item-start"></div>';
        echo '<div class="tlv__item-end"></div>';
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
