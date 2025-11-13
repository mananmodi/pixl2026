<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-showcase.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Image_Size,
    Plugin,
    Widget_Base,
    Controls_Manager,
    Icons_Manager,
    Utils,
    Repeater,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography,
    Group_Control_Background,
    Control_Media};

use WGL_Extensions\{
    Includes\WGL_Elementor_Helper,
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Cursor
};

class WGL_Showcase extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-showcase';
    }

    public function get_title()
    {
        return esc_html__('WGL Showcase', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-showcase';
    }

    public function get_keywords()
    {
        return [ 'showcase', 'title', 'images' ];
    }

    public function get_script_depends()
    {
        return [
            'wgl-widgets',
        ];
    }


    public function get_categories()
    {
        return ['wgl-modules'];
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

        $this->add_control(
            'showcase_layout',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Layout', 'burido-core'),
                'options' => [
                    'slide' => esc_html__('Slide', 'burido-core'),
                    'interactive' => esc_html__('Interactive', 'burido-core'),
                ],
                'default' => 'interactive',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Showcase Title', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit.', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'link_active',
            [
                'label' => esc_html__( 'Active by Default', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        WGL_Cursor::init(
            $repeater,
            [
                'section' => false,
                'repeater' => true,
                'prefix' => 'showcase_',
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
                'default' => [
                    [
                        'title' => esc_html__( 'Showcase Title 1', 'burido-core' ),
                        'subtitle' => esc_html__( '01', 'burido-core' ),
                    ],
                    [
                        'title' => esc_html__( 'Showcase Title 2', 'burido-core' ),
                        'subtitle' => esc_html__( '02', 'burido-core' ),
                        'link_active' => 'yes'
                    ],
                    [
                        'title' => esc_html__( 'Showcase Title 3', 'burido-core' ),
                        'subtitle' => esc_html__( '03', 'burido-core' ),
                    ],
                    [
                        'title' => esc_html__( 'Showcase Title 4', 'burido-core' ),
                        'subtitle' => esc_html__( '04', 'burido-core' ),
                    ],
                ],
            ]
        );

        $this->add_control(
            'height_slide',
            [
                'label' => esc_html__( 'Height', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => [
                    'full' => esc_html__( 'Fit To Screen', 'burido-core' ),
                    'min-height' => esc_html__( 'Set Height', 'burido-core' ),
                ],
                'prefix_class' => 'wgl-showcase-height-',
                'condition' => [
                    'showcase_layout' => 'slide',
                ]
            ]
        );

        $this->add_responsive_control(
            'custom_height_slide',
            [
                'label' => esc_html__( 'Height', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'default' => [
                    'size' => 800,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2440,
                    ],
                ],
                'size_units' => [ 'px', 'vh', 'vw', 'custom'],
                'condition' => [
                    'showcase_layout' => 'slide',
                    'height_slide' => [ 'min-height' ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .slide-showcase .showcase__wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_width_interactive',
            [
                'label' => esc_html__( 'Image Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => [ 'px', 'vh', 'vw', 'custom'],
                'condition' => [ 'showcase_layout' => 'interactive' ],
                'default' => [ 'size' => 220 ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .interactive-showcase .showcase__image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'interactive_image_position',
            [
                'label' => esc_html__( 'Image Position', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    '%' => [ 'min' => -100, 'max' => 200 ],
                ],
                'size_units' => [ '%' ],
                'condition' => [
                    'showcase_layout' => 'interactive',
                ],
                'default' => [ 'size' => 0, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .interactive-showcase .showcase__image' => '--wgl-image-position: {{SIZE}}%;',
                ],
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Size', 'burido-core'),
                'separator' => 'before',
                'options' => [
                    '150' => esc_html__('150x150 - Thumbnail', 'burido-core'),
                    '300' => esc_html__('300x300 - Medium', 'burido-core'),
                    '768' => esc_html__('768x768 - Medium Large', 'burido-core'),
                    '1024' => esc_html__('1024x1024 - Large', 'burido-core'),
                    'full' => esc_html__('Full', 'burido-core'),
                    'custom' => esc_html__('Custom', 'burido-core'),
                ],
                'default' => 'full',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'burido-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    'img_size_string' => 'custom',
                ],
                'description' => esc_html__('Crop the original image to any custom size. You can also set a single value for width to keep the initial ratio.', 'burido-core'),
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('No Crop', 'burido-core'),
                    '1:1' => esc_html__('1:1', 'burido-core'),
                    '3:2' => esc_html__('3:2', 'burido-core'),
                    '4:3' => esc_html__('4:3', 'burido-core'),
                    '6:5' => esc_html__('6:5', 'burido-core'),
                    '9:16' => esc_html__('9:16', 'burido-core'),
                    '16:9' => esc_html__('16:9', 'burido-core'),
                    '21:9' => esc_html__('21:9', 'burido-core'),
                ],
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'items_min_height',
            [
                'label' => esc_html__( 'Items Min Height', 'burido-core' ),
                'separator' => 'before',
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1440,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [ 'size' => 213, 'unit' => 'px' ],
                'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'items_wrap',
                [
                'label' => esc_html__( 'Wrap', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'nowrap' => [
                        'title' => esc_html__( 'No Wrap', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-nowrap',
                    ],
                    'wrap' => [
                        'title' => esc_html__( 'Wrap', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-wrap',
                    ],
                ],
                'default' => 'nowrap',
                'tablet_default' => 'wrap',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item' => 'flex-wrap: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'items_justify_content',
            [
                'label' => esc_html__( 'Justify Content', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-evenly-h',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'items_align_items',
            [
                'label' => esc_html__( 'Align Items', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_mobile_breakpoint();
        $this->end_controls_section();

        /**
         * CONTENT -> BUTTON
         */

        $this->start_controls_section(
            'section_style_link',
            [
                'label' => esc_html__('Link', 'burido-core'),
            ]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Whole Item Link', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('\'Read More\' Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Use', 'burido-core'),
                'label_off' => esc_html__('Hide', 'burido-core'),
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
                    '{{WRAPPER}} .wgl-showcase_button' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-showcase_button .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-showcase_button .wgl-showcase_button__media img' => 'top: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .wgl-showcase_button .wgl-showcase_button__media img' => 'width: {{SIZE}}{{UNIT}};',
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
         * STYLE -> ITEM CONTAINER
         */

        $this->start_controls_section(
            'style_item_container',
            [
                'label' => esc_html__('Item Container', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '24',
                    'right' => '0',
                    'bottom' => '23',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'tablet_default' => [
                    'top' => '22',
                    'right' => '0',
                    'bottom' => '22',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'mobile_default' => [
                    'top' => '22',
                    'right' => '0',
                    'bottom' => '15',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'fields_options' => [
                    'border' => [ 'default' => 'solid' ],
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                        'default' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 1,
                            'left' => 0,
                        ],
                    ],
                    'color' => [
                        'label' => esc_html__( 'Border Color', 'burido-core' ),
                        'default' => WGL_Globals::get_secondary_color(0.15)
                    ],
                ],
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item',
            ]
        );

        $this->add_responsive_control(
            'image_wrapper_size',
            [
                'label' => esc_html__('Image Cointainer Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%'],
                'range' => [
                    '%' => ['max' => 100],
                ],
                'condition' => ['showcase_layout' => 'slide'],
                'default' => ['size' => 61, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .slide-showcase .showcase__images' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_wrapper_size',
            [
                'label' => esc_html__('Title Cointainer Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%'],
                'range' => [
                    '%' => ['max' => 100],
                ],
                'condition' => ['showcase_layout' => 'slide'],
                'default' => ['size' => 39, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .slide-showcase .showcase__items' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'style_image',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['showcase_layout' => 'interactive'],
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'image_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'render_type' => 'template',
                'dynamic' => ['active' => true],
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image',
            ]
        );
        $this->add_responsive_control(
            'image_visibility',
                [
                'label' => esc_html__( 'Image Visibility', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => ['showcase_layout' => 'interactive'],
                'options' => [
                    'block' => esc_html__( 'Show', 'burido-core' ),
                    'none' => esc_html__( 'Hide', 'burido-core' ),
                ],
                'default' => 'block',
                'mobile_default' => 'none',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'image_overlay_switch',
            [
                'label' => esc_html__( 'Image Overlay', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image::before' => 'display: block;',
                ],
            ]
        );
        $this->add_control(
            'image_z_index',
            [
                'label' => esc_html__('Image z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image' => 'z-index: {{VALUE}}',
                ],
            ]
        );

        $this->start_controls_tabs('image');
        $this->start_controls_tab(
            'image_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'image_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'image_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_border_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_idle',
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image',
            ]
        );
        $this->add_responsive_control(
            'image_rotation_idle',
            [
                'label' => esc_html__( 'Rotation', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => ['showcase_layout' => 'interactive'],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image' => '--wgl-image-rotate: {{SIZE}}deg;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'image_hover',
            ['label' => esc_html__('Hover/Active', 'burido-core')]
        );
        $this->add_control(
            'image_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__image,
				     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__image' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'image_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_border_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__image,
				     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__image' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_hover',
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__image,
				     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__image',
            ]
        );
        $this->add_responsive_control(
            'image_rotation_hover',
            [
                'label' => esc_html__( 'Rotation', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => ['showcase_layout' => 'interactive'],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__image,
				     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__image' => '--wgl-image-rotate: {{SIZE}}deg;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
         * STYLE -> Image Overlay
         */

        $this->start_controls_section(
            'style_image_overlay',
            [
                'label' => esc_html__('Image Overlay', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'image_overlay_switch!' => '',
                    'showcase_layout' => 'interactive'
                ],
            ]
        );

        $this->start_controls_tabs( 'overlay_tabs' );
        $this->start_controls_tab(
            'overlay_tab',
            ['label' => esc_html__('Idle' , 'burido-core')]
        );
        $this->add_control(
            'overlay_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(0),
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'overlay_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['overlay_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_rotation_idle',
            [
                'label' => esc_html__( 'Rotation', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => -360, 'max' => 360 ],
                ],
                'default' => [ 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__image::before' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'overlay_hover_tab',
            ['label' => esc_html__('Hover/Active' , 'burido-core')]
        );
        $this->add_control(
            'overlay_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(0.7),
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .showcase__image::before' => 'background-color: {{VALUE}}',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-tablet_extra .showcase__image::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-tablet .showcase__image::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-mobile_extra .showcase__image::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-mobile .showcase__image::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'overlay_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['overlay_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .showcase__image::before' => 'background-color: {{VALUE}}',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-tablet_extra .showcase__image::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-tablet .showcase__image::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-mobile_extra .showcase__image::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .breakpoint_on-mobile .showcase__image::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_rotation_hover',
            [
                'label' => esc_html__( 'Rotation', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => -360, 'max' => 360 ],
                ],
                'default' => [ 'size' => -5 ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:is(.active, :hover) .showcase__image::before' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
         * STYLE -> Title
         */

        $this->start_controls_section(
            'style_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'title_width',
            [
                'label' => esc_html__( 'Title Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [ 'px' => ['max' => 1200] ],
                'default' => [ 'size' => 53, 'unit' => '%' ],
                'tablet_default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_min_width',
            [
                'label' => esc_html__( 'Title Min-Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [ 'px' => ['max' => 1200] ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_grow',
            [
                'label' => esc_html__( 'Title Flex Grow', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [ 'px' => ['min' => -10, 'max' => 10] ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'flex-grow: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_align_items',
            [
                'label' => esc_html__( 'Align Items', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'align-self: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_order',
            [
                'label' => esc_html__('Content Order', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => -10,
                'max' => 10,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML tag', 'burido-core'),
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
                'separator' => 'before',
                'default' => 'h3',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_font_title',
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '30',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; --title-p-r: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_stroke_size',
            [
                'label' => esc_html__('Stroke Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 0, 'max' => 2, 'step' => 0.1]],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .title' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'title_tabs' );
        $this->start_controls_tab(
            'title_color_tab',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .title' => 'color: {{VALUE}};'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_bg',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_stroke_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_skew',
            [
                'label' => esc_html__('Skew the title', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => ['min' => -45, 'max' => 45],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item .title' => 'transform: skew({{SIZE}}deg)',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_animation_offset_idle',
            [
                'label' => esc_html__('Animation Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom' ],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                ],
                'default' => ['size' => 0, 'unit' => 'px'],
                'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item .showcase__title' => 'transform: translateX({{SIZE}}{{UNIT}})',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_hover_tab',
            ['label' => esc_html__('Hover/Active' , 'burido-core')]
        );
        $this->add_control(
            'title_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .title,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .title' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .title,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .title' => 'color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__title,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__title' => 'background-color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__title' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__title,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__title' => 'background-color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__title' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color_hover',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .title,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .title' => '-webkit-text-stroke-color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .title' => '-webkit-text-stroke-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_stroke_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .title,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .title' => '-webkit-text-stroke-color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .title' => '-webkit-text-stroke-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_hover_skew',
            [
                'label' => esc_html__('Skew the title', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => ['min' => -45, 'max' => 45],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .title,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .title' => 'transform: skew({{SIZE}}deg);',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .title' => 'transform: skew({{SIZE}}deg);',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_animation_offset_hover',
            [
                'label' => esc_html__('Animation Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom' ],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                ],
                'default' => ['size' => 260, 'unit' => 'px'],
                'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__title,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__title' => 'transform: translateX({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => ' --title-a-o: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_transition',
            [
                'label' => esc_html__('Transition', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.4],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .interactive-showcase .showcase__image img' => 'transition: {{SIZE}}s;',
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__title' => 'transition: {{SIZE}}s, z-index 0s 0.1s;',
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .interactive-showcase .showcase__item:hover .showcase__title' => 'transition: {{SIZE}}s, z-index 0s 0s;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
         * STYLE -> Subtitle
         */

        $this->start_controls_section(
            'style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'subtitle_width',
            [
                'label' => esc_html__( 'Subtitle Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [ 'px' => ['max' => 1200] ],
                'default' => [ 'size' => 52, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'width: {{SIZE}}{{UNIT}}; min-width: fit-content;',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_alignment',
            [
                'label' => esc_html__('Subtitle Alignment', 'burido-core'),
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
                'condition' => [ 'subtitle_width[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_align_items',
                [
                'label' => esc_html__( 'Align Items', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'align-self: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_order',
            [
                'label' => esc_html__('Subtitle Order', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => -10,
                'max' => 10,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_font_subtitle',
                'separator' => 'before',
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -100, 'max' => 100, 'step' => 1],
                ],
                'default' => ['size' => 2, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .slide-showcase .showcase__subtitle' => 'top: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .interactive-showcase .showcase__subtitle' => 'transform: translateY( {{SIZE}}{{UNIT}} );',
                ],
            ]
        );

        $this->add_control(
            'subtitle_absolute',
            [
                'label' => esc_html__( 'Place the Subtitle Absolutely', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'subtitle_top_offset[size]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'position: absolute; left: 0; top: 0;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'subtitle_border',
                'render_type' => 'template',
                'dynamic' => ['active' => true],
                'fields_options' => [
                    'width' => [  'label' => esc_html__( 'Border Width', 'burido-core' ), ],
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle',
            ]
        );
        $this->start_controls_tabs( 'subtitle_tabs' );
        $this->start_controls_tab(
            'subtitle_tab',
            ['label' => esc_html__('Idle' , 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_idle',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'subtitle_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'subtitle_border_border!' => ['', 'none'],
                    'subtitle_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__subtitle' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'subtitle_hover_tab',
            ['label' => esc_html__('Hover/Active' , 'burido-core')]
        );
        $this->add_control(
            'subtitle_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__subtitle,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__subtitle' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'subtitle_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__subtitle,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__subtitle' => 'color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__subtitle,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__subtitle' => 'background-color: {{VALUE}}',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__subtitle,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__subtitle' => 'background-color: {{VALUE}}',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__subtitle,
                    {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__subtitle' => 'border-color: {{VALUE}}',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__subtitle' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'subtitle_border_border!' => ['', 'none'],
                    'subtitle_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__subtitle,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__subtitle' => 'border-color: {{VALUE}}',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__subtitle' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'style_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__( 'Content Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [ 'px' => ['max' => 1200] ],
                'default' => [ 'size' => 390, 'unit' => 'px' ],
                'tablet_default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_grow',
            [
                'label' => esc_html__( 'Content Flex Grow', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [ 'px' => ['min' => -10, 'max' => 10] ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'flex-grow: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_align_items',
            [
                'label' => esc_html__( 'Align Items', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'align-self: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_alignment',
            [
                'label' => esc_html__('Content Alignment', 'burido-core'),
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
                'condition' => [ 'content_width[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content',
            ]
        );
        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '8',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'tablet_default' => [
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '52',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; --content-p-r: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('content_color_tab');
        $this->start_controls_tab(
            'custom_content_color_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_animation_offset_idle',
            [
                'label' => esc_html__('Animation Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom' ],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                ],
                'tablet_default' => [ 'size' => 0, 'unit' => 'px' ],
                'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item .showcase__content' => 'transform: translateX({{SIZE}}{{UNIT}})',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_content_color_hover',
            ['label' => esc_html__('Hover/Active', 'burido-core')]
        );
        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__content,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__content' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__content,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__content,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__content,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__content' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'content_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__content,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__content' => 'color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet_extra .showcase__item .showcase__content,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-tablet .showcase__item .showcase__content,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile_extra .showcase__item .showcase__content,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}}.elementor-widget-wgl-showcase .breakpoint_on-mobile .showcase__item .showcase__content' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'content_animation_offset_hover',
            [
                'label' => esc_html__('Animation Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom' ],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                ],
                'tablet_default' => [ 'size' => 260, 'unit' => 'px' ],
                'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item.active .showcase__content,
                     {{WRAPPER}}.elementor-widget-wgl-showcase .showcase__item:hover .showcase__content' => 'transform: translateX({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => '--content-a-o: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'content_transition',
            [
                'label' => esc_html__('Transition', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.4],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-showcase .showcase__content' => 'transition: {{SIZE}}s',
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
            ]
        );
        $this->add_responsive_control(
            'button_align_self',
            [
                'label' => esc_html__( 'Align Self', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'align-self: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wgl-showcase_button .button__text',
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
                    '{{WRAPPER}} .wgl-showcase_button .button__text' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-showcase_button .button__text' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-showcase_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'read_more_icon_fontawesome[value]!' => '',
                ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-showcase_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			    'selector' => '{{WRAPPER}} .wgl-showcase_button',
		    ]
	    );

        $this->add_control(
            'read_more_button_width',
            [
                'label' => esc_html__( 'Button Min-Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_alignment!' => ['space-evenly', 'space-around', 'space-between'],
                ],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [
                    'px' => ['max' => 500],
                    '%' => ['max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-showcase_button' => 'min-width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-showcase_button' => 'justify-content: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-showcase_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-showcase_button,
                     {{WRAPPER}} .wgl-showcase_button::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-showcase_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-showcase_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-showcase_button .wgl-icon,
				     {{WRAPPER}} .wgl-showcase_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-showcase_button .wgl-icon' => 'stroke: {{VALUE}}'
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
                    '{{WRAPPER}} .wgl-showcase_button' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase_button' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wgl-showcase_button',
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
                    '{{WRAPPER}} .wgl-showcase_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );

        $this->add_control(
            'button_icon_rotation_idle',
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
                    '{{WRAPPER}} .wgl-showcase_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button,
                     {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button::before' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
				     {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button' => 'border-color: {{VALUE}}'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button' => 'border-color: {{VALUE}}'
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
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-showcase_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover,
                     {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover::before' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover' => 'border-color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:hover .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active,
                     {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active::before' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active span' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active span' => 'text-decoration-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon' => 'stroke: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active' => 'border-color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-showcase_button:active .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function add_mobile_breakpoint() {
        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();

        $avaliable_breakpoints = [];
        foreach ( $active_devices as $breakpoint_key ) {
            if( array_key_exists($breakpoint_key, $active_breakpoints) ) {
                $avaliable_breakpoints[$breakpoint_key] = $active_breakpoints[$breakpoint_key]->get_label();
            }
        }

        $this->add_control(
            'wgl_mobile_breakpoint',
            [
                /* translators: %s: Device Name. */
                'label' => esc_html__( 'Set Mobile Template On', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'render_type' => 'template',
                'options' => $avaliable_breakpoints + [ '' => esc_html__('Disable', 'burido-core') ],
                'default' => 'mobile',
            ]
        );
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();
        // Build structure

        // Variables validation
        $img_size_string = $_s['img_size_string'] ?? '';
        $img_size_array = $_s['img_size_array'] ?? [];
        $img_aspect_ratio = $_s['img_aspect_ratio'] ?? '';

        // Build structure
        $items_html_title = $items_html_image = $showcase__wrapper = '';

        $this->add_render_attribute( 'general', 'class', 'wgl-showcase');
        if (!empty($_s['wgl_mobile_breakpoint'])){
            $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
            $key = array_search($_s['wgl_mobile_breakpoint'], $active_devices);
            $all_breakpoints = array_slice($active_devices, $key);
            foreach($all_breakpoints as $breakpoint){
                $this->add_render_attribute( 'general', [ 'class' => [ 'breakpoint_on-' . $breakpoint ] ] );
            }
        }

        foreach ($_s['items'] as $index => $item) {
            // Fields validation
            $thumbnail = $item['thumbnail'] ?? '';
            $image_data = wp_get_attachment_image_src($thumbnail['id'], 'full');
            $title = $item['title'] ?? '';
            $subtitle = $item['subtitle'] ?? '';
            $link = $item['link'] ?? '';
            $content = $item['content'] ?? '';

            $has_link = !empty($link['url']);

            //Cursor
            if (isset($item['cursor_tooltip']) && '' != $item['cursor_tooltip']) {
                add_filter( 'wgl/burido_module_cursor', function () { return true; });
            }
            $cursor = new WGL_Cursor;
            $cursor_data = $cursor->build($this, $item, $item['_id'], 'showcase_');

            if ($has_link) {
                $link = $this->get_repeater_setting_key('link', 'items', $index);
                $this->add_link_attributes($link, $item['link']);
            }

            //* Image size
            $dim = null;
            $image = $showcase_content = '';

            if ($image_data) {
                $dim = WGL_Elementor_Helper::get_image_dimensions(
                    $img_size_array ?: $img_size_string,
                    $img_aspect_ratio,
                    $image_data
                );

                if($dim){
                    $image_url = aq_resize($image_data[0], $dim['width'], $dim['height'], true, true, true) ?: $image_data[0];
                    //* Image Attachment
                    $image_arr = [
                        'src' => $image_url,
                        'alt' => get_post_meta($thumbnail['id'], '_wp_attachment_image_alt', true),
                    ];

                    $this->add_render_attribute('image' . $index, [
                        'class' => 'image',
                        'src' => $image_arr['src'],
                        'alt' => $image_arr['alt']
                    ]);

                    $this->add_render_attribute('showcase__image' . $index, [
                        'class' => [
                            'showcase__image',
                            $dim && 'slide' ? $_s['showcase_layout'] : '',
                        ],
                        'style' => 'background-image:url('.esc_url($image_arr['src']).')'
                    ]);
                }

                $image .=  '<div '.$this->get_render_attribute_string('showcase__image' . $index).'><div class="showcase__image-inner">';
                    $image .=  $dim ? '<img '. $this->get_render_attribute_string('image' . $index). '>' : '';
                $image .= '</div></div>';

                $items_html_image .= $image;
            }elseif (isset($thumbnail['url'])){
                $image .= '<div class="showcase__image"><div class="showcase__image-inner">';
                    $image .= '<img src="'.esc_url( $thumbnail['url'] ).'">';
                $image .= '</div></div>';

                $items_html_image .= $image;
            }

            // Content
            if (!empty($content)) {
                $showcase_content = '<div class="showcase__content">' . $content . '</div>';
            }

            // Subtitle
            $subtitle = !empty($subtitle) ? '<span class="showcase__subtitle">'. esc_html($subtitle) .'</span>' : '';

            switch ($_s['showcase_layout']) {
                case 'slide':

                    $items_html_title .= '<' . esc_attr($_s['title_tag']) . ' class="showcase__item' . ( isset($item['cursor_tooltip']) && !empty($item['cursor_tooltip']) ? ' wgl-cursor-text' : '' ) . '"' . $cursor_data . '>'
                        . '<div class="showcase__item-inner">'
                        . ($has_link ? '<a class="wgl-showcase__link" ' . $this->get_render_attribute_string($link) . '></a>' : '')
                        . (!empty($title) ? $subtitle.'<span class="title">'. esc_html($title) .'</span>' : '')
                        . '</div>'
                        . '</' . esc_attr($_s['title_tag']) . '>';

                    break;

                case 'interactive':
                    $showcase__item = $this->get_repeater_setting_key( 'item_link_active', 'items', $index );
                    $this->add_render_attribute( $showcase__item, [
                        'class' => [
                            'showcase__item',
                            $item[ 'link_active' ] ? 'active' : '',
                            ( isset($item['cursor_tooltip']) && !empty($item['cursor_tooltip']) ? ' wgl-cursor-text' : '' )
                        ],
                    ] );

                    $title = '<' . esc_attr($_s['title_tag']) . ' class="showcase__title">'
                        . $subtitle
                        . (!empty($title) ? '<span class="title">'. esc_html($title) .'</span>' : '')
                        . '</' . esc_attr($_s['title_tag']) . '>';

                    $showcase__wrapper .= '<div '. $this->get_render_attribute_string( $showcase__item ) . $cursor_data . '>';
                        if ($has_link) {
                            $showcase__wrapper .= '<a class="wgl-showcase__link" ' . $this->get_render_attribute_string($link) . '></a>';
                        }
                        $showcase__wrapper .= $title;
                        $showcase__wrapper .= $showcase_content;
                        $showcase__wrapper .= $image;
                        $showcase__wrapper .= $this->read_more_button($index, $has_link, $link, $_s);

                    $showcase__wrapper .= '</div>';
                    break;
            }
        }
        if ('slide' === $_s['showcase_layout']) {
            $this->add_render_attribute( 'general', 'class', 'slide-showcase');

            ?><div <?php echo $this->get_render_attribute_string('general') ?>>
                <div class="showcase__wrapper">
                    <div class="showcase__items"><?php
                        echo $items_html_title;
                    ?></div>
                    <div class="showcase__images"><?php
                        echo $items_html_image;
                    ?></div>
                </div>
            </div><?php
        } else {
            $this->add_render_attribute( 'general', 'class', 'interactive-showcase');

            ?><div <?php echo $this->get_render_attribute_string('general') ?>><?php
                echo $showcase__wrapper;
            ?></div><?php
        }
    }
    public function read_more_button($index, $has_link, $link_item, $_s)
    {
        $s_button = '';

        // Read more button
        if ($_s['add_read_more']) {
            $this->add_render_attribute('btn' . $index, 'class',
                [
                    'wgl-showcase_button',
                    $_s['button_type'] ?? '',
                    !$_s['read_more_text'] ? 'no_text' : ''
                ]
            );

            $btn_icon = '';
            // ↓ Icon|Image
            if ('' !== $_s['read_more_icon_type'] ) {
                if ( 'font' === $_s['read_more_icon_type'] ) {
                    if(isset($_s['read_more_icon_fontawesome']['value'])) {
                        $migrated = isset( $atts['__fa4_migrated']['read_more_icon_fontawesome'] );
                        $is_new = Icons_Manager::is_migration_allowed();
                        if ($is_new || $migrated) {
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
                    $btn_icon = '<span class="wgl-showcase_button__media">'.$media_html.'</span>';
                    $this->add_render_attribute(['btn' => ['class' => [ 'image']]]);
                }
            } else {
                $this->add_render_attribute(['btn' => ['class' => [ 'no_media']]]);
            }

            // ↑ icon|image

            $s_button = '<div class="wgl-button-wrapper">';
                $s_button .= sprintf(
                    '<%s %s %s>',
                    $has_link ? 'div' : 'a',
                    $has_link ? '' : $this->get_render_attribute_string('link'),
                    $this->get_render_attribute_string('btn' . $index)
                );
                    $s_button .= 'wgl-button' === $_s['button_type'] ? '<div class="button__content">' : '';
                        $s_button .= $btn_icon ?: '';
                        $s_button .= $_s['read_more_text'] ? '<span class="button__text">' . esc_html($_s['read_more_text']) . '</span>' : '';
                    $s_button .= 'wgl-button' === $_s['button_type'] ? '</div>' : '';
                $s_button .= $has_link ? '</div>' : '</a>';
            $s_button .= '</div>';
        }

        return $s_button;
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
