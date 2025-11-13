<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-striped-services.php`.
 */

namespace WGL_Extensions\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use Elementor\{Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Image_Size,
    Icons_Manager,
    Plugin,
    Utils,
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Group_Control_Background,
    Group_Control_Typography,
    Repeater};

use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals
};

class Wgl_Striped_Services extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-striped-services';
    }

    public function get_title()
    {
        return esc_html__('WGL Striped Services', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-striped-services';
    }

    public function get_keywords()
    {
        return [ 'striped', 'services', 'images', 'text', 'animation' ];
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
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'wgl_striped_services_section',
            ['label' => esc_html__('General', 'burido-core')]
        );

        $this->add_responsive_control(
            'interval',
            [
                'label' => esc_html__('Widget Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 200, 'max' => 1000],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => ['size' => 700, 'unit' => 'px'],
                'tablet_default' => ['size' => 500, 'unit' => 'px'],
                'mobile_default' => ['size' => 700, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped-services' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'serv_proportion_active',
            [
                'label' => esc_html__('Proportions for Active Sections', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [ 'px' => ['min' => 0, 'max' => 20] ],
                'default' => ['size' => 3],
                'tablet_default' => ['size' => 8],
                'mobile_default' => ['size' => 5],
                'selectors' => [ '{{WRAPPER}} .wgl-striped-services .wgl-striped.active' => 'flex: {{SIZE}};' ],
            ]
        );

        $this->add_responsive_control(
            'serv_proportion_inactive',
            [
                'label' => esc_html__('Proportions for Inactive Sections', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [ 'px' => ['min' => 0, 'max' => 20] ],
                'default' => ['size' => 1],
                'tablet_default' => ['size' => 3],
                'mobile_default' => ['size' => 2],
                'selectors' => [ '{{WRAPPER}} .wgl-striped-services .wgl-striped:not(.active)' => 'flex: {{SIZE}};' ],
            ]
        );

        $this->add_responsive_control(
            'serv_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '40',
                    'right' => '90',
                    'bottom' => '50',
                    'left' => '50',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '20',
                    'right' => '80',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '20',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'stretch_to_right_edge',
            [
                'label' => esc_html__('Stretch Widget to the Right Edge of Window', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped-services' => 'margin-right: calc(50% - 50vw); transition: .4s;'
                ],
            ]
        );

        $this->add_mobile_breakpoint();

        $this->end_controls_section();

        /** CONTENT -> CONTENT */

        $this->start_controls_section(
            'wgl_content_section',
            ['label' => esc_html__('Content', 'burido-core')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'serv_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Service Title', 'burido-core'),
                'placeholder' => esc_html__('Service Title', 'burido-core'),
            ]
        );
        $repeater->add_control(
            'serv_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_html__('Service Subtitle', 'burido-core'),
            ]
        );
        $repeater->add_control(
            'serv_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit.', 'burido-core'),
            ]
        );
        $repeater->add_control(
            'serv_bg_text',
            [
                'label' => esc_html__('Background Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'placeholder' => esc_html__('01', 'burido-core'),
                'default' => esc_html__('01', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'serv_def_active',
            [
                'label' => esc_html__('Active as Default', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['thumbnail[url]' => ''],
            ]
        );

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Background Image', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => ['url' => ''],
            ]
        );

        $repeater->add_responsive_control(
            'bg_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'responsive' => true,
                'options' => [
                    'top left' => esc_html__('Top Left', 'burido-core'),
                    'top center' => esc_html__('Top Center', 'burido-core'),
                    'top right' => esc_html__('Top Right', 'burido-core'),
                    'center left' => esc_html__('Center Left', 'burido-core'),
                    'center center' => esc_html__('Center Center', 'burido-core'),
                    'center right' => esc_html__('Center Right', 'burido-core'),
                    'bottom left' => esc_html__('Bottom Left', 'burido-core'),
                    'bottom center' => esc_html__('Bottom Center', 'burido-core'),
                    'bottom right' => esc_html__('Bottom Right', 'burido-core'),
                ],
                'default' => 'center center',
            ]
        );

        $repeater->add_control(
            'bg_size',
            [
                'label' => esc_html__('Size', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'responsive' => true,
                'options' => [
                    'auto' => esc_html__('Auto', 'burido-core'),
                    'cover' => esc_html__('Cover', 'burido-core'),
                    'contain' => esc_html__('Contain', 'burido-core'),
                ],
                'default' => 'cover',
            ]
        );

        $repeater->add_control(
            'serv_link',
            [
                'label' => esc_html__('Add Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Layers', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{serv_title}}',
                'description' => esc_html__('Enter services height in pixels', 'burido-core'),
                'default' => [
                    [
                        'serv_title' => esc_html__('Service Title 1', 'burido-core'),
                        'serv_bg_text' => esc_html__('01', 'burido-core'),
                        'bg_color' => WGL_Globals::get_secondary_color(0.6),
                        'serv_def_active' => 'yes'
                    ],
                    [
                        'serv_title' => esc_html__('Service Title 2', 'burido-core'),
                        'serv_bg_text' => esc_html__('02', 'burido-core'),
                        'bg_color' => WGL_Globals::get_secondary_color(0.7),
                    ],
                    [
                        'serv_title' => esc_html__('Service Title 3', 'burido-core'),
                        'serv_bg_text' => esc_html__('03', 'burido-core'),
                        'bg_color' => WGL_Globals::get_secondary_color(0.8),
                    ],
                    [
                        'serv_title' => esc_html__('Service Title 4', 'burido-core'),
                        'serv_bg_text' => esc_html__('04', 'burido-core'),
                        'bg_color' => WGL_Globals::get_secondary_color(0.9),
                    ],
                ],
            ]
        );

        $this->add_control(
            'deprecated_notice',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__('Two or more items are expected for correct rendering', 'burido-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Link', 'burido-core')]
        );

        $this->add_control(
            'module_link',
            [
                'label' => esc_html__('Whole Module Link', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('\'Read More\' Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Use', 'burido-core'),
                'label_off' => esc_html__('Hide', 'burido-core'),
                'default' => 'yes'
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
                'placeholder' => esc_html__('Read More', 'burido-core'),
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
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'add_read_more' => 'yes',
                    'button_type' => 'wgl-button',
                ],
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
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
                    '{{WRAPPER}} .wgl-striped_button .button__content' => 'flex-direction: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-striped_button' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-striped_button .wgl-striped_button__media img' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'button_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_type' => 'wgl-button',
                ],
                'range' => [
                    'px' => ['min' => 10, 'max' => 200 ],
                ],
                'default' => ['size' => 26],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_button' => '--icon-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button .wgl-striped_button__media img' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button .wgl-icon path' => 'stroke-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> MEDIA
         */

        $this->start_controls_section(
            'section_style_thumbnail',
            [
                'label' => esc_html__('Background Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('media_overlay_tabs');
        $this->start_controls_tab(
            'media_overlay_tab_first',
            ['label' => esc_html__('First Layer', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_idle',
                'label' => esc_html__('Background', 'burido-core'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .wgl-striped .service-image::before',
            ]
        );
        $this->add_responsive_control(
            'media_overlay_after_idle',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'separator' => 'before',
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped .service-image::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_overlay_after_active',
            [
                'label' => esc_html__('Opacity To', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .service-image::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'media_overlay_tab_second',
            ['label' => esc_html__('Second Layer', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_hover',
                'label' => esc_html__('Background', 'burido-core'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [ 'default' => 'gradient' ],
                    'color' => [
                        'label' => esc_html__( 'Background Color', 'burido-core' ),
                        'default' => WGL_Globals::get_tertiary_color(0),
                    ],
                    'color_b' => [
                        'label' => esc_html__( 'Second Background Color', 'burido-core' ),
                        'default' => WGL_Globals::get_tertiary_color(0.5),
                    ],
                    'color_stop' => [
                        'default' => [
                            'unit' => '%',
                            'size' => 30,
                        ],
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 180,
                        ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .wgl-striped .service-image::after',
            ]
        );
        $this->add_responsive_control(
            'media_overlay_before_idle',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'separator' => 'before',
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped .service-image::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'media_overlay_before_active',
            [
                'label' => esc_html__('Opacity To', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'default' => ['size' => 1, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .service-image::after' => 'opacity: {{SIZE}};',
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
            'section_style_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 36],
                        'tablet_default' => ['size' => 32],
                        'mobile_default' => ['size' => 28],
                    ],
                ],
                'selector' => '{{WRAPPER}} .wgl-striped_title',
            ]
        );
        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_max_width',
            [
                'label' => esc_html__('Max Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 850],
                ],
                'size_units' => ['px', 'vw', 'custom'],
                'default' => ['size' => 'min(35vw, 460px)', 'unit' => 'custom'],
                'tablet_default' => ['size' => 40, 'unit' => 'vw'],
                'mobile_default' => ['size' => 320, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_title' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('title_colors');
        $this->start_controls_tab(
            'title_colors_normal',
            ['label' => esc_html__('Normal', 'burido-core')]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_title' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_opacity_idle',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_title' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_colors_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped.active .wgl-striped_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_opacity_hover',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_title' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> SUBTITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'selector' => '{{WRAPPER}} .wgl-striped_subtitle',
            ]
        );
        $this->add_control(
            'subtitle_tag',
            [
                'label' => esc_html__('Subtitle HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'div',
            ]
        );
        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_max_width',
            [
                'label' => esc_html__('Max Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'vw', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 850],
                ],
                'default' => ['size' => 'min(35vw, 460px)', 'unit' => 'custom'],
                'tablet_default' => ['size' => 40, 'unit' => 'vw'],
                'mobile_default' => ['size' => 320, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_subtitle' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('subtitle_colors');
        $this->start_controls_tab(
            'subtitle_colors_normal',
            ['label' => esc_html__('Normal', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_opacity_idle',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_subtitle' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'subtitle_colors_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped.active .wgl-striped_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_opacity_hover',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_subtitle' => 'opacity: {{SIZE}};',
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
                'name' => 'content_typo',
                'selector' => '{{WRAPPER}} .wgl-striped_content',
            ]
        );
        $this->add_responsive_control(
            'content_max_width',
            [
                'label' => esc_html__('Max Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 850],
                ],
                'size_units' => ['px', 'vw', 'custom'],
                'default' => ['size' => 'min(35vw, 460px)', 'unit' => 'custom'],
                'tablet_default' => ['size' => 40, 'unit' => 'vw'],
                'mobile_default' => ['size' => 320, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'custom' ],
                'default' => [
                    'top' => '14',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'content_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .wgl-striped_content',
            ]
        );

        $this->start_controls_tabs('content_tabs');
        $this->start_controls_tab(
            'content_tab_idle',
            ['label' => esc_html__('Normal', 'burido-core')]
        );
        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_color-dynamic',
            [
                'label' => esc_html__('Content Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_bg_color',
            [
                'label' => esc_html__( 'Content Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_bg_color-dynamic',
            [
                'label' => esc_html__('Content Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_opacity_idle',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_content' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'content_tab_hover',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__( 'Content Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_color_hover-dynamic',
            [
                'label' => esc_html__('Content Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped.active .wgl-striped_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_bg_color_hover',
            [
                'label' => esc_html__( 'Content Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Content Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped.active .wgl-striped_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_opacity_hover',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_content' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BACKGROUND TEXT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'bg_text_style_section',
            [
                'label' => esc_html__('Background Text', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bg_text_typo',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 110, 'unit' => 'px'],
                        'tablet_default' => ['size' => 8, 'unit' => 'vw'],
                        'mobile_default' => ['size' => 'clamp(82px, 16vw, 110px)', 'unit' => 'custom'],
                    ],
                ],
                'selector' => '{{WRAPPER}} .wgl-striped_bg_text',
            ]
        );

        $this->add_responsive_control(
            'bg_text_position',
            [
                'label' => esc_html__('Text Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'static' => esc_html__('Static', 'burido-core'),
                    'absolute' => esc_html__('Absolute', 'burido-core'),
                ],
                'default' => 'absolute',
                'prefix_class' => 'bg_text_position%s-',
            ]
        );

        $this->add_responsive_control(
            'bg_text_alignment_h',
            [
                'label' => esc_html__('Horizontal Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => true,
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
                ],
                'condition' => [ 'bg_text_position' => 'absolute' ],
                'default' => 'flex-end',
                'mobile_default' => 'flex-end',
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_bg_text' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_text_alignment_v',
            [
                'label' => esc_html__('Vertical Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'condition' => [ 'bg_text_position' => 'absolute' ],
                'default' => 'flex-end',
                'mobile_default' => 'flex-end',
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_bg_text' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'bg_text_rotate',
            [
                'label' => esc_html__('Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['deg'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                ],
                'default' => ['size' => -90, 'unit' => 'deg'],
                'tablet_default' => ['size' => -90, 'unit' => 'deg'],
                'mobile_default' => ['size' => 0, 'unit' => 'deg'],
                'condition' => [ 'bg_text_position' => 'absolute' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_bg_text span' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'bg_text_wrapper_size',
            [
                'label' => esc_html__('Wrapper Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                    'em' => ['max' => 10, 'step' => 0.05],
                ],
                'default' => ['size' => 1.5, 'unit' => 'em'],
                'condition' => [ 'bg_text_position' => 'absolute' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_bg_text span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'bg_text_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '-0.48',
                    'bottom' => '0.41',
                    'left' => '0',
                    'unit' => 'em',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '0',
                    'right' => '-0.45',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'em',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '0',
                    'right' => '-0.2',
                    'bottom' => '-0.45',
                    'left' => '0',
                    'unit' => 'em',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_bg_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('bg_text_colors');
        $this->start_controls_tab(
            'bg_text_colors_normal',
            ['label' => esc_html__('Normal', 'burido-core')]
        );
        $this->add_control(
            'bg_text_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'bg_text_opacity_idle',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_bg_text' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'bg_text_colors_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'bg_text_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped.active .wgl-striped_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'bg_text_opacity_hover',
            [
                'label' => esc_html__('Opacity From', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped.active .wgl-striped_bg_text' => 'opacity: {{SIZE}};',
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
            'button_style_section',
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
                'selector' => '{{WRAPPER}} .wgl-striped_button .button__text',
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
                    '{{WRAPPER}} .wgl-striped_button .button__text' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button .button__text' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
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
                    'top' => '15',
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
                    '{{WRAPPER}} .wgl-striped_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'render_type' => 'template',
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                    ],
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}} .wgl-striped_button',
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
                    '{{WRAPPER}} .wgl-striped_button' => 'min-width: {{SIZE}}{{UNIT}};',
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
                        'title' => esc_html__('Space Between', 'burido-core'),
                        'icon' => 'eicon-justify-space-between-h',
                ],
                ],
                'default' => 'left',
                'prefix_class' => 'button_',
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_button' => 'justify-content: {{VALUE}};',
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
            ['label' => esc_html__('Idle' , 'burido-core') ]
        );
        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_tertiary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-striped_button,
                     {{WRAPPER}} .wgl-striped_button::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_button' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-striped_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-striped_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'read_more_icon_fontawesome[value]!' => '' ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-striped_button .wgl-icon,
				     {{WRAPPER}} .wgl-striped_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-striped_button .wgl-icon' => 'stroke: {{VALUE}}'
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
                    '{{WRAPPER}} .wgl-striped_button' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-striped_button' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wgl-striped_button',
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
                    '{{WRAPPER}} .wgl-striped_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button,
                     {{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'button_border_border!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button' => 'border-color: {{VALUE}}'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button' => 'border-color: {{VALUE}}'
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
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_item_hover',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'condition' => [ 'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover,
                     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover' => 'border-color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_hover',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_control(
            'button_color_responsive',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_responsive',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_responsive',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active span' => 'text-decoration-color: {{VALUE}};',
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button span,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button span,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button span,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button span,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button span,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button span' => 'text-decoration-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active span' => 'text-decoration-color: {{VALUE}};',
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_responsive',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_responsive',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon,
                     
                     body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon::before,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon::before,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_responsive',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_responsive',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_responsive',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => 'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_responsive',
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
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_responsive',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-widescreen .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-desktop .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-tablet .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile_extra .wgl-striped_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-striped-services.breakpoint_on-mobile .wgl-striped_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button' => '--wgl-icon-wrapper: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button::after' => 'left:{{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-striped_button::after' => '--bg-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'button_bg_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped_button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_border_radius_item_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '32',
                    'right' => '32',
                    'bottom' => '32',
                    'left' => '32',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:focus::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:focus::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:focus::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '32',
                    'right' => '32',
                    'bottom' => '32',
                    'left' => '32',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:focus::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'button_bg_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'button_animation_style' => 'bg_animation' ],
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '32',
                    'right' => '32',
                    'bottom' => '32',
                    'left' => '32',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button' => '--ab-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-striped_button' => '--ab-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button' => '--ab-offset: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button' => '--ab-width: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button' => '--ab-extend: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-striped_button .wgl-icon' => '--icon-bg-size: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-striped_button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-striped_button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-striped_button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:focus .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-striped_button:focus .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-striped_button:active .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                'label' => esc_html__( 'Set Mobile Template On', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => $avaliable_breakpoints,
                'default' => 'mobile',
            ]
        );
    }

    protected function render()
    {
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

        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('striped-services', 'class', [
            'wgl-striped-services'
        ]);

        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $key = array_search($_s['wgl_mobile_breakpoint'], $active_devices);
        $all_breakpoints = array_slice($active_devices, $key);
        foreach($all_breakpoints as $breakpoint){
            $this->add_render_attribute( 'striped-services', [ 'class' => [ 'breakpoint_on-' . $breakpoint ] ] );
        }


        // Read more button
        $s_button = '';
        if ($_s['add_read_more']) {
            $this->add_render_attribute('btn', 'class',
                [
                    'wgl-striped_button',
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
                    $btn_icon = '<span class="wgl-striped_button__media">'.$media_html.'</span>';
                    $this->add_render_attribute(['btn' => ['class' => [ 'image']]]);
                }
            }else{
                $this->add_render_attribute(['btn' => ['class' => [ 'no_media']]]);
            }
            // ↑ icon|image
        }

        echo '<div ', $this->get_render_attribute_string('striped-services'), '>';

        foreach ($_s['items'] as $index => $item) {

            $item_wrap = $this->get_repeater_setting_key('item_wrap', 'items', $index);
            $this->add_render_attribute(
                $item_wrap,
                [
                    'class' => [
                        'service-image',
                        !empty($item['thumbnail']['url']) ? '' : 'no-image',
                    ],
                    'style' => [
                        !empty($item['thumbnail']['url']) ? 'background-image: url(' . esc_url($item['thumbnail']['url']) . ');' : '',
                        $item['bg_position'] != '' ? 'background-position: ' . esc_attr($item['bg_position']) . ';' : '',
                        $item['bg_size'] != '' ? 'background-size: ' . esc_attr($item['bg_size']) . ';' : '',
                        $item['bg_color'] != '' ? 'background-color: ' . esc_attr($item['bg_color']) . ';' : '',
                    ]
                ]
            );

            $image = $this->get_repeater_setting_key('image', 'items', $index);
            $this->add_render_attribute(
                $image,
                [
                    'src' => isset($item['thumbnail']['url']) ? esc_url($item['thumbnail']['url']) : '',
                    'alt' => Control_Media::get_image_alt($item['thumbnail']),
                ]
            );

            $has_link = !empty($item['serv_link']['url']);
            if ($has_link) {
                $serv_link = $this->get_repeater_setting_key('serv_link', 'items', $index);
                $this->add_link_attributes($serv_link, $item['serv_link']);

                $striped_button = '<div class="wgl-button-wrapper">';
                    $striped_button .= sprintf(
                        '<%s %s %s>',
                        $_s['module_link'] ? 'div' : 'a',
                        $_s['module_link'] ? '' : $this->get_render_attribute_string($serv_link),
                        $this->get_render_attribute_string('btn')
                    );

                        $striped_button .= 'wgl-button' === $_s['button_type'] ? '<div class="button__content">' : '';
                            $striped_button .= $btn_icon ?: '';
                            $striped_button .= $_s['read_more_text'] ? '<span class="button__text">' . esc_html($_s['read_more_text']) . '</span>' : '';
                        $striped_button .= 'wgl-button' === $_s['button_type'] ? '</div>' : '';
                    $striped_button .= $_s['module_link'] ? '</div>' : '</a>';
                $striped_button .= '</div>';

                if ($_s['module_link']) {
                    $module_link_html = '<a class="wgl-striped__link" ' . $this->get_render_attribute_string($serv_link) . '></a>';
                }
            }

            echo '<div class="wgl-striped' . ( !empty($item['serv_def_active']) ? ' active' : '' ) . '">';
                echo '<div ', $this->get_render_attribute_string($item_wrap), '></div>';

                    echo $has_link && isset($module_link_html) ? $module_link_html : '';

                    echo '<div class="wgl-striped_wrapper">';

                        if (!empty($item['serv_bg_text'])) {
                            echo '<div class="wgl-striped_bg_text"><span>', esc_html($item['serv_bg_text']), '</span></div>';
                        }

                        if (!empty($item['serv_title'])) {
                            echo '<' . $_s['title_tag'] . ' class="wgl-striped_title">' .
                                esc_html($item['serv_title']) .
                            '</' . $_s['title_tag'] . '>';
                        }
                        if (!empty($item['serv_subtitle'])) {
                            echo '<'. $_s['subtitle_tag']. ' class="wgl-striped_subtitle">'.
                                esc_html($item['serv_subtitle']).
                            '</' . $_s['subtitle_tag'] . '>';
                        }

                        if (!empty($item['serv_content'])) {
                            echo '<div class="wgl-striped_content">'.
                                wp_kses($item['serv_content'], $kses_allowed_html).
                            '</div>';
                        }

                        echo $has_link && isset($striped_button) ? $striped_button : '';

                    echo '</div>'; // wgl-striped_content
                echo '</div>'; // wgl-striped
        }

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
