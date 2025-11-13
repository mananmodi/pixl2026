<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-cases.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Css_Filter,
    Group_Control_Typography,
    Icons_Manager,
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Background,
    Repeater,
    Utils};
use WGL_Extensions\Includes\{
    WGL_Carousel_Settings,
	WGL_Icons
};
use WGL_Extensions\WGL_Framework_Global_Variables as WGL_Globals;

class WGL_Cases extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-cases';
    }

    public function get_title()
    {
        return esc_html__('WGL Cases', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-services-2';
    }

    public function get_keywords()
    {
        return [ 'cases', 'services', 'carousel' ];
    }

    public function get_script_depends()
    {
        return ['wgl-widgets', 'swiper'];
    }

    public function get_style_depends()
    {
        return [ 'swiper' ];
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
            'section_content_general',
            ['label' => esc_html__('General', 'burido-core')]
        );

	    $this->add_responsive_control(
		    'item_grid',
		    [
			    'label' => esc_html__('Grid Columns Amount', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'render_type' => 'template',
			    'range' => [
				    'px' => ['min' => 1, 'max' => 10 ],
			    ],
			    'size_units' => ['px'],
			    'default' => ['size' => 3],
			    'tablet_default' => ['size' => 2],
			    'mobile_default' => ['size' => 1],
			    'selectors' => [
				    '{{WRAPPER}} .case_items.swiper-slide' => 'width: calc(100% / {{SIZE}});',
				    '{{WRAPPER}} .wgl-cases:not([data-carousel="yes"])' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
			    ],
			    'label_block' => true,
		    ]
	    );

	    $this->add_responsive_control(
		    'item_gap',
		    [
			    'label' => esc_html__('Grid Gap', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'range' => [
				    'px' => ['min' => 0, 'max' => 100 ],
			    ],
			    'size_units' => ['px'],
                'label_block' => true,
			    'default' => ['size' => 30],
			    'tablet_default' => ['size' => 30],
			    'mobile_default' => ['size' => 20],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-cases:not([data-carousel="yes"])' => 'gap: {{SIZE}}px;',
                    '{{WRAPPER}} .wgl-cases[data-carousel="yes"] .case_items' => 'padding: calc({{SIZE}}px * 0.5);',
                    '{{WRAPPER}} .wgl-cases[data-carousel="yes"]' => 'margin: calc({{SIZE}}px * -0.5);',
                    '{{WRAPPER}} .wgl-cases[data-carousel="yes"] .swiper-pagination' => 'margin-bottom: calc({{SIZE}}px * 0.5);',
			    ],
		    ]
	    );

        $this->add_responsive_control(
            'items_height',
            [
                'label' => esc_html__('Module Minimum Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'vh', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 1000],
                    'vh' => ['min' => 1, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'items_v_alignment',
            [
                'label' => esc_html__('Vertical Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'burido-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
		    'item_grid_refresh',
		    [
			    'type' => Controls_Manager::HIDDEN,
			    'condition' => ['use_carousel!' => ''],
			    'render_type' => 'template',
		    ]
	    );

        $extra_controls[ 'img_size_string' ] = [
            'label' => esc_html__( 'Image Size', 'burido-core' ),
            'type' => Controls_Manager::SELECT,
            'condition' => [
                'icon_type' => 'image',
            ],
            'options' => [
                '150' => esc_html__('Thumbnail - 150x150', 'burido-core'),
                '300' => esc_html__('Medium - 300x300', 'burido-core'),
                '768' => esc_html__('Medium Large - 768x768', 'burido-core'),
                '1024' => esc_html__('Large - 1024x1024', 'burido-core'),
                '680x680' => esc_html__('680x680 - 3 Columns', 'burido-core'),
                'full' => esc_html__('Full', 'burido-core'),
                'custom' => esc_html__('Custom', 'burido-core'),
            ],
            'default' => 'full',
        ];

        $extra_controls[ 'img_size_array' ] = [
            'label' => esc_html__( 'Image Dimension', 'burido-core' ),
            'type' => Controls_Manager::IMAGE_DIMENSIONS,
            'condition' => [
                'img_size_string' => 'custom',
                'icon_type' => 'image',
            ],
            'description' => esc_html__( 'Crop the original image to any custom size. You can also set a single value for width to keep the initial ratio.', 'burido-core' ),
        ];

        $extra_controls[ 'img_aspect_ratio' ] = [
            'label' => esc_html__( 'Image Aspect Ratio', 'burido-core' ),
            'type' => Controls_Manager::SELECT,
            'condition' => [
                'img_size_string!' => 'custom',
                'icon_type' => 'image',
            ],
            'options' => [
                '' => esc_html__( 'No Crop', 'burido-core' ),
                '1:1' => esc_html( '1:1' ),
                '3:2' => esc_html( '3:2' ),
                '4:3' => esc_html( '4:3' ),
                '6:5' => esc_html( '6:5' ),
                '9:16' => esc_html( '9:16' ),
                '16:9' => esc_html( '16:9' ),
                '21:9' => esc_html( '21:9' ),
            ],
            'default' => '',
        ];

	    $repeater = new Repeater();


        $repeater->start_controls_tabs('tabs_items');

        // Tab Content
        $repeater->start_controls_tab(
            'tab_item_content',
            ['label' => esc_html__('General', 'burido-core')]
        );
        $repeater->add_control(
            'case_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: Case Title', 'WGL Cases', 'burido-core' ),
            ]
        );
        $repeater->add_control(
            'case_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: Case Subtitle', 'WGL Cases', 'burido-core' ),
            ]
        );
        $repeater->add_control(
            'case_bg_text',
            [
                'label' => esc_html__('Background Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'Case', 'WGL Cases', 'burido-core' ),
            ]
        );
        $repeater->add_control(
            'case_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('Description Text', 'burido-core'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Add Link', 'burido-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__( 'https://your-link.com', 'burido-core' ),
                'default' => [ 'url' => '#' ],
            ]
        );
        $repeater->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: Read more', 'WGL Cases', 'burido-core' ),
                'default' => esc_attr_x( 'Read More', 'WGL Cases', 'burido-core' ),
            ]
        );
        $repeater->add_responsive_control(
            'item_width',
            [
                'label' => esc_html__('Item Width', 'burido-core'),
                'description' => esc_html__('We recommend using this option if the carousel and the "variable width" option are enabled', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 10, 'max' => 500 ],
                    '%' => ['min' => 10, 'max' => 100 ],
                    'vw' => ['min' => 10, 'max' => 100 ],
                ],
                'size_units' => ['px', '%', 'vw', 'custom'],
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.case_items' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->end_controls_tab();

        // Tab Image
        $repeater->start_controls_tab(
            'tab_item_image',
            ['label' => esc_html__('Image', 'burido-core')]
        );
        WGL_Icons::init(
            $repeater,
            [
                'section' => false,
                'output' => $extra_controls,
                'use_group_control_image_size' => ! ( $extra_controls[ 'img_size_string' ] ?? null ),
                'media_types_options' => [
                    '' => [
                        'title' => esc_html__('None', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'burido-core'),
                        'icon' => 'far fa-image',
                    ],
                ],
                'prefix' => 'image_',
                'default' => [
                    'media_type' => 'image',
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_responsive_control(
            'thumbnail_width',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 10, 'max' => 500 ],
                    '%' => ['min' => 10, 'max' => 100 ],
                ],
                'size_units' => ['px', '%', 'custom'],
                'condition' => ['image_icon_type!' => ''],
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.case_items img,
				     {{WRAPPER}} {{CURRENT_ITEM}}.case_items .image_wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->end_controls_tab();

        // Tab Icon
        $repeater->start_controls_tab(
            'tab_item_icon',
            ['label' => esc_html__('Icon', 'burido-core')]
        );
        WGL_Icons::init(
            $repeater,
            [
                'output' => '',
                'section' => false,
                'media_types_options' => [
                    '' => [
                        'title' => esc_html__('None', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'font' => [
                        'title' => esc_html__('Icon', 'burido-core'),
                        'icon' => 'far fa-smile',
                    ],
                ],
                'prefix' => 'icon_'
            ]
        );

        $repeater->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'condition' => ['icon_icon_type!' => ''],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'icon_rotate',
            [
                'label' => esc_html__('Icon Rotate', 'burido-core'),
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
                'condition' => ['icon_icon_type!' => ''],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper .wgl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%', 'custom'],
                'condition' => ['icon_icon_type!' => ''],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper .wgl-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'condition' => ['icon_icon_type!' => ''],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->end_controls_tab();

        // Tab Background
        $repeater->start_controls_tab(
            'tab_item_background',
            ['label' => esc_html__('Background', 'burido-core')]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'tab_item_background',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .case_items__inner_wrapper',
            ]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'tab_item_background_overlay',
                'fields_options' => [
                    'background' => [ 'label' => esc_html__('Background Overlay', 'burido-core') ],
                ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .case_items__inner_wrapper::before',
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'list',
            [
                'label' => esc_html__('Items', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'case_title' => esc_html__('Different Tubes', 'burido-core') ],
                    [ 'case_title' => esc_html__('Stickers & Labels', 'burido-core') ],
                    [ 'case_title' => esc_html__('Folders & Brochures', 'burido-core') ],
                    [ 'case_title' => esc_html__('Metallic Packs', 'burido-core') ],
                    [ 'case_title' => esc_html__('All Sizes Boxes', 'burido-core') ],
                ],
                'title_field' => '{{{ case_title }}}',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('General Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => true,
                'options' => [
                    'left; align-items: flex-start' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center; align-items: center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right; align-items: flex-end' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center; align-items: center',
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

	    $this->add_control(
		    'chess_layout',
		    [
			    'label' => esc_html__('Chess Layout', 'burido-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'separator' => 'before',
			    'return_value' => 'chess',
			    'prefix_class' => 'layout-',
		    ]
	    );

	    $this->add_control(
		    'chess_layout_invert',
		    [
			    'label' => esc_html__('Invert Chess Layout', 'burido-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'condition' => ['chess_layout!' => ''],
			    'return_value' => 'chess',
			    'prefix_class' => 'invert-',
		    ]
	    );

	    $this->add_responsive_control(
		    'chess_offset',
		    [
			    'label' => esc_html__('Chess Offset', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'condition' => ['chess_layout!' => ''],
			    'size_units' => ['px', 'rem'],
			    'range' => [
				    'px' => ['min' => 1, 'max' => 300],
				    'rem' => ['min' => 0.1, 'max' => 20, 'step' => 0.1],
			    ],
			    'default' => ['size' => 60],
			    'tablet_default' => ['size' => 30],
			    'mobile_default' => ['size' => 0],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-cases:not([data-carousel="yes"]),
				     {{WRAPPER}} .wgl-cases[data-carousel="yes"] .swiper-container' => 'padding-top: {{SIZE}}{{UNIT}} !important;',
				    '{{WRAPPER}}:not(.invert-chess) .case_items:nth-child(even)' => 'margin-top: -{{SIZE}}{{UNIT}};',
				    '{{WRAPPER}}.invert-chess .case_items:nth-child(odd)' => 'margin-top: -{{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'chess_notice',
		    [
			    'type' => Controls_Manager::RAW_HTML,
			    'condition' => [ 'chess_layout!' => '' ],
			    'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			    'raw' => esc_html__('Note: even number of Case Items is preffered.', 'burido-core'),
		    ]
	    );

	    $this->end_controls_section();

        /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'section_content_link',
            [
                'label' => esc_html__('Link', 'burido-core'),
            ]
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
                'default' => '',
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
                'default' => 'wgl-button',
            ]
        );
        $this->add_control(
            'read_more_icon_fontawesome',
            [
                'label' => esc_html__('Button Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => [ 'add_read_more' => 'yes' ],
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
                'label_block' => true,
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fas fa-arrow-right',
                ],
            ]
        );
        $this->add_control(
            'read_more_icon_align',
            [
                'label' => esc_html__( 'Position', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[value]!' => '',
                ],
                'options' => [
                    'row' => esc_html__( 'Before', 'burido-core' ),
                    'row-reverse' => esc_html__( 'After', 'burido-core' ),
                ],
                'default' => 'row-reverse',
                'selectors' => [
                    '{{WRAPPER}} .button-read-more,
                     {{WRAPPER}} .wgl-button .button__content' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'read_more_icon_indent',
            [
                'label' => esc_html__( 'Icon/Image Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[value]!' => '',
                ],
                'range' => [
                    'px' => [ 'max' => 250 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_icon_top',
            [
                'label' => esc_html__('Icon Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 300],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button .wgl-icon' => 'top: {{SIZE}}{{UNIT}}; --icon-translate-y: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_responsive_control(
            'button_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
                'condition' => [ 'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button .wgl-icon path' => 'stroke-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
	    $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        WGL_Carousel_Settings::add_controls($this, [
            'use_carousel' => [ 'default' => 'yes' ],
            'variable_width_enable' => true,
            'variable_width' => [ 'default' => '' ],
            'slide_per_single' => [ 'default' => 'yes' ],
            'slider_infinite' => [ 'default' => 'yes' ],
            'use_pagination' => [ 'default' => 'yes' ],
        ]);

        /**
         * STYLES -> ITEMS
         */

        $this->start_controls_section(
            'section_style_items',
            [
                'label' => esc_html__('Items', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .case_items__inner_wrapper',
            ]
        );
        $this->add_responsive_control(
            'items_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -5,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} .case_items' => 'z-index: {{VALUE}}; position: relative',
                ],
            ]
        );
        $this->start_controls_tabs( 'tabs_items' );
        $this->start_controls_tab(
            'tab_item_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg_idle',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .case_items__inner_wrapper',
            ]
        );
        $this->add_control(
            'item_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'item_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'item_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'item_border_border!' => ['', 'none'],
                    'item_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items__inner_wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'items_border_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_idle',
                'selector' => '{{WRAPPER}} .case_items__inner_wrapper',
            ]
        );
        $this->add_control(
            'item_blur_idle',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper::after' => 'backdrop-filter: blur({{SIZE}}px);-webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_item_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .case_items__inner_wrapper:hover',
            ]
        );
        $this->add_control(
            'item_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'item_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'item_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'item_border_border!' => ['', 'none'],
                    'item_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items__inner_wrapper:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'items_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_hover',
                'selector' => '{{WRAPPER}} .case_items__inner_wrapper:hover',
            ]
        );
        $this->add_control(
            'item_blur_hover',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover::after' => 'backdrop-filter: blur({{SIZE}}px);-webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'item_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['s'],
                'range' => [
                    's' => ['min' => 0, 'max' => 2, 'step' => 0.1 ],
                ],
                'default' => ['size' => 0.4, 'unit' => 's'],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper' => 'transition: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> TITLE
         */

        $this->start_controls_section(
            'style_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .case_title',
            ]
        );

        $this->add_control(
            'title_font_family',
            [
                'label' => esc_html__('Theme Font Family', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'burido-core'),
                    'header' => esc_html__('Headings Font', 'burido-core'),
                    'content' => esc_html__('Content Font', 'burido-core'),
                    'additional' => esc_html__('Additional Font', 'burido-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_title' => 'font-family: var(--burido-{{VALUE}}-font-family);',
                ],
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
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .case_title__wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .case_title__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'titles_tabs',
        );
        $this->start_controls_tab(
            'title_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_title' => 'color: {{VALUE}};',
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
                'condition' => [ 'title_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_opacity_idle',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_title' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover .case_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_hover-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'title_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items__inner_wrapper:hover .case_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover .case_title' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> SUBTITLE
         */

        $this->start_controls_section(
            'style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_subtitle',
                'selector' => '{{WRAPPER}} .case_subtitle',
            ]
        );

        $this->add_control(
            'subtitle_tag',
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
                'default' => 'div',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '5',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_subtitle__wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .case_subtitle__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'subtitles_tabs',
        );
        $this->start_controls_tab(
            'subtitle_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_idle',
            [
                'label' => esc_html__('Subtitle Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_idle-dynamic',
            [
                'label' => esc_html__('Subtitle Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'subtitle_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => esc_html__('Subtitle Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover .case_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_hover-dynamic',
            [
                'label' => esc_html__('Subtitle Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items__inner_wrapper:hover .case_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BG OVERLAY
         */

        $this->start_controls_section(
            'style_bg_overlay',
            [
                'label' => esc_html__('BG Overlay', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_bg',
                'selector' => '{{WRAPPER}} .case_items__inner_wrapper::before',
            ]
        );
        $this->add_control(
            'overlay_bg_z_index',
            [
                'label' => esc_html__('Z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper::before' => 'z-index: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs( 'tabs_overlay_bg' );
        $this->start_controls_tab(
            'tab_overlay_bg_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_responsive_control(
            'overlay_bg_first_idle',
            [
                'label' => esc_html__('Opacity for Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_overlay_bg_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'overlay_bg_hover',
            [
                'label' => esc_html__('Opacity for Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BG TEXT
         */

        $this->start_controls_section(
            'style_bg_text',
            [
                'label' => esc_html__('BG Text', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_bg_text',
                'selector' => '{{WRAPPER}} .case_bg_text',
            ]
        );

        $this->add_responsive_control(
            'bg_text_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '-300',
                    'bottom' => '-100',
                    'left' => '-300',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_bg_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_text_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .case_bg_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'bg_text_tabs',
        );
        $this->start_controls_tab(
            'bg_text_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'bg_text_color_idle',
            [
                'label' => esc_html__('Background Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_idle-dynamic',
            [
                'label' => esc_html__('Background Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_text_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'bg_text_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'bg_text_color_hover',
            [
                'label' => esc_html__('Background Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover .case_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_hover-dynamic',
            [
                'label' => esc_html__('Background Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_text_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items__inner_wrapper:hover .case_bg_text' => 'color: {{VALUE}};',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}} .case_content__wrapper',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .case_content__wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .case_content__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'contents_tabs' );
        $this->start_controls_tab(
            'content_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'content_color_idle',
            [
                'label' => esc_html__('Content Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_content__wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_color_idle-dynamic',
            [
                'label' => esc_html__('Content Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'content_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_content__wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'content_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Content Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items__inner_wrapper:hover .case_content__wrapper' => 'color: {{VALUE}};',
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
                'condition' => [ 'content_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items__inner_wrapper:hover .case_content__wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLES -> IMAGE
         */

        $this->start_controls_section(
            'section_style_images',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
	    $this->add_responsive_control(
		    'thumbnail_height',
		    [
			    'label' => esc_html__('Image Wrapper Height', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 500 ],
			    ],
			    'size_units' => ['px', 'custom'],
			    'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} .case_items .image_wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
		    ]
	    );
	    $this->add_responsive_control(
		    'thumbnail_width',
		    [
			    'label' => esc_html__('Image Width', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 500 ],
				    '%' => ['min' => 10, 'max' => 100 ],
			    ],
			    'size_units' => ['px', '%', 'custom'],
			    'label_block' => true,
                'default' => ['size' => 100, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .case_items .wgl-image-box_img img' => 'width: {{SIZE}}{{UNIT}}; --image-width: {{SIZE}};',
                ],
		    ]
	    );
        $this->add_responsive_control(
            'thumbnail_width_hover',
            [
                'label' => esc_html__( 'Image Width on Hover', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 500 ],
                ],
                'condition' => [ 'thumbnail_width[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .wgl-image-box_img img' => 'transform: scale( calc( {{SIZE}} / var(--image-width) ) );',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -5,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper ' => 'z-index: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'thumbnail_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '30',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'thumbnail_icon_show_over_image',
            [
                'label' => esc_html__('Show Icon/Text over Image', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Use', 'burido-core'),
                'label_off' => esc_html__('Hide', 'burido-core'),
			    'separator' => 'before',
                'default' => '',
            ]
        );

        $this->start_controls_tabs('thumbnail_tabs');
        $this->start_controls_tab(
            'thumbnail_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'thumbnail_opacity_idle',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'thumbnail_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_css_filters_idle',
                'selector' => '{{WRAPPER}} .image_wrapper img',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumbnail_shadow_idle',
                'selector' => '{{WRAPPER}} .image_wrapper .wgl-image-box_img',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'thumbnail_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'thumbnail_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .image_wrapper img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'thumbnail_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit'  => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .image_wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_css_filters_hover',
                'selector' => '{{WRAPPER}} .case_items:hover .image_wrapper img',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumbnail_shadow_hover',
                'selector' => '{{WRAPPER}} .case_items:hover .image_wrapper .wgl-image-box_img',
            ]
        );
        $this->add_control(
            'thumbnail_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['s'],
                'range' => [
                    's' => ['min' => 0, 'max' => 2, 'step' => 0.1 ],
                ],
                'default' => ['size' => 0.6, 'unit' => 's'],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper img' => 'transition: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> ICON OVER IMAGE
         */

        $this->start_controls_section(
            'style_icon_over_image',
            [
                'label' => esc_html__('Icon/Text Over Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'thumbnail_icon_show_over_image' => 'yes' ],
            ]
        );
        $this->add_responsive_control(
            'text_over_image_width',
            [
                'label' => esc_html__('Wrapper Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px','em','rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'default' => ['size' => 100, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper .wgl-icon' => 'min-width: {{SIZE}}px; min-height: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'text_over_image',
            [
                'label' => esc_html__('Text Over Image', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_attr_x( 'MORE', 'WGL Cases', 'burido-core' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_over_image_fonts',
                'condition' => [ 'text_over_image!' => '' ],
                'selector' => '{{WRAPPER}} .wgl-text_over_image',
            ]
        );

        $this->add_control(
            'thumbnail_icon',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
                'label_block' => true,
            ]
        );

        $this->add_responsive_control(
            'thumbnail_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px','em','rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 200, 'step' => 1 ],
                ],
                'condition' => [ 'thumbnail_icon[value]!' => '' ],
                'default' => ['size' => 20, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_icon_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '22',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_icon_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '100',
                    'right' => '100',
                    'bottom' => '100',
                    'left' => '100',
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('thumbnail_icons');
        $this->start_controls_tab(
            'thumbnail_icon_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'thumbnail_text_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'text_over_image!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-text_over_image' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_text_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'text_over_image!' => '',
                    'thumbnail_text_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-text_over_image' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'thumbnail_icon[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'thumbnail_icon[value]!' => '',
                    'thumbnail_icon_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .image_wrapper .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'thumbnail_icon_bg_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .image_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumbnail_icon_shadow_idle',
                'selector' => '{{WRAPPER}} .image_wrapper .wgl-icon',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'thumbnail_icon_border_idle',
                'selector' => '{{WRAPPER}} .image_wrapper .wgl-icon',
            ]
        );
        $this->add_control(
            'thumbnail_icon_blur_idle',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image_wrapper .wgl-icon' => 'backdrop-filter: blur({{SIZE}}px);-webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'thumbnail_icon_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'thumbnail_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'text_over_image!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .wgl-text_over_image' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_text_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'text_over_image!' => '',
                    'thumbnail_text_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items:hover .wgl-text_over_image' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_color_case_button__hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'thumbnail_icon[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .image_wrapper .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_color_case_button__hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'thumbnail_icon[value]!' => '',
                    'thumbnail_icon_color_case_button__hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items:hover .image_wrapper .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_bg_color_case_button__hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .image_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'thumbnail_icon_bg_color_case_button__hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'thumbnail_icon_bg_color_case_button__hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items:hover .image_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumbnail_icon_shadow_case_button__hover',
                'selector' => '{{WRAPPER}} .case_items:hover .image_wrapper .wgl-icon',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'thumbnail_icon_border_case_button__hover',
                'selector' => '{{WRAPPER}} .case_items:hover .image_wrapper .wgl-icon',
            ]
        );
        $this->add_control(
            'thumbnail_icon_blur_case_button__hover',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .image_wrapper .wgl-icon' => 'backdrop-filter: blur({{SIZE}}px);-webkit-backdrop-filter: blur({{SIZE}}px);',
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
            'style_icon',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icons_size',
            [
                'label' => esc_html__('Font Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'default' => ['size' => 53],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icons_rotate',
            [
                'label' => esc_html__('Icon Rotate', 'burido-core'),
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
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'icons_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -5,
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper ' => 'z-index: {{VALUE}}; position: relative;',
                ],
            ]
        );
        $this->add_control(
            'icons_bubble',
            [
                'label' => esc_html__('Show Bubble for Icon', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon::after' => 'display: block;',
                ],
            ]
        );
        $this->add_responsive_control(
            'icons_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '19',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icons_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icons_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .icon_wrapper .wgl-icon',
            ]
        );
        $this->add_responsive_control(
            'icons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_icons',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_icons_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'icon_colors_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_colors_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_colors_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .icon_wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_bg_idle',
            [
                'label' => esc_html__('Icon Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_bg_idle-dynamic',
            [
                'label' => esc_html__('Icon Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icons_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .icon_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_border_color_idle',
            [
                'label' => esc_html__('Icon Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'icon_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_border_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_border_border!' => ['', 'none'],
                    'icons_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .icon_wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icons_idle',
                'selector' => '{{WRAPPER}} .icon_wrapper .wgl-icon',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_icons_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'icons_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icons_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_bg_hover',
            [
                'label' => esc_html__('Icon Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_bg_hover-dynamic',
            [
                'label' => esc_html__('Icon Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icons_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_border_color_hover',
            [
                'label' => esc_html__('Icon Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'icon_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icons_border_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_border_border!' => ['', 'none'],
                    'icons_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icons_hover',
                'selector' => '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Bubble
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_bubble',
            [
                'label' => esc_html__('Bubble', 'burido-core'),
                'condition' => [ 'icons_bubble!' => '' ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'bubble_top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -200, 'max' => 200],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 1],
                ],
                'default' => ['size' => 61, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon::after' => '--bubble-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'bubble_left_offset',
            [
                'label' => esc_html__('Left Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -200, 'max' => 200],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon::after' => '--bubble-left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'bubble_size',
            [
                'label' => esc_html__('Bubble Diameter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => ['max' => 700],
                ],
                'default' => ['size' => 230, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_animation',
            [
                'label' => esc_html__('Bubble Animation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'bubble',
                'prefix_class' => 'animation_',
            ]
        );
        $this->add_responsive_control(
            'bubble_animation_top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 1],
                ],
                'condition' => [ 'icon_animation' => 'bubble' ],
                'default' => ['size' => 40, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon::after' => '--bubble-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'bubble_animation_left_offset',
            [
                'label' => esc_html__('Left Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 1],
                ],
                'condition' => [ 'icon_animation' => 'bubble' ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon::after' => '--bubble-left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'bubble_animation_size',
            [
                'label' => esc_html__('Bubble Diameter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => ['max' => 700],
                ],
                'condition' => [ 'icon_animation' => 'bubble' ],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'tabs_bubble_styles' );
        $this->start_controls_tab(
            'tab_bubble_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $this->add_control(
            'bubble_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper .wgl-icon::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bubble_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'bubble_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .icon_wrapper .wgl-icon::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_bubble_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'bubble_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon::after' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'bubble_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'bubble_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .case_items:hover .icon_wrapper .wgl-icon::after' => 'background-color: {{VALUE}};'
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
		    'section_style_button',
		    [
			    'label' => esc_html__('Button', 'burido-core'),
			    'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'add_read_more' => 'yes' ],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
			    'name' => 'button_custom_fonts',
			    'selector' => '{{WRAPPER}} .wgl-cases__button',
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
                    'button_custom_fonts_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 20, 'step' => 1],
                    'em' => ['min' => 0, 'max' => 1, 'step' => 0.05],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
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
                    'button_custom_fonts_text_decoration' => 'underline' ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => -20, 'max' => 20, 'step' => 1],
                    'em' => ['min' => -1, 'max' => 1, 'step' => 0.05],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
	    $this->add_responsive_control(
		    'button_margin',
		    [
			    'label' => esc_html__('Margin', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%', 'custom'],
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
				    '{{WRAPPER}} .wgl-cases__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-cases__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			    'selector' => '{{WRAPPER}} .wgl-cases__button',
		    ]
	    );

        $this->add_control(
            'read_more_button_width',
            [
                'label' => esc_html__( 'Button Min-Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [
                    'px' => ['max' => 500],
                    '%' => ['max' => 100],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button' => 'width: {{SIZE}}{{UNIT}};',
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
                'default' => 'space-between',
                'prefix_class' => 'button_',
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button' => 'justify-content: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-cases__button' => 'color: {{VALUE}};',
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
                'condition' => [ 'button_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button' => 'color: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-cases__button' => 'background-color: {{VALUE}};',
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
                    'button_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button' => 'background-color: {{VALUE}};',
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
                    'button_custom_fonts_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button' => 'text-decoration-color: {{VALUE}};',
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
                    'button_custom_fonts_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button' => 'text-decoration-color: {{VALUE}};',
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
                    'button_border_border!' => ['', 'none'] ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-cases__button' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button' => 'border-color: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-cases__button:hover,
				     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button' => 'color: {{VALUE}};',
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
                'condition' => [ 'button_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button:hover,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button' => 'color: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-cases__button:hover,
                     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button' => 'background-color: {{VALUE}}',
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
                    'button_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button' => 'background-color: {{VALUE}}',
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
                    'button_custom_fonts_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button:hover span,
				     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button span' => 'text-decoration-color: {{VALUE}};',
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
                    'button_custom_fonts_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button:hover span,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button span' => 'text-decoration-color: {{VALUE}};',
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
                    'button_border_border!' => ['', 'none'] ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-cases__button:hover,
				     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button' => 'border-color: {{VALUE}}'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button:hover,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-cases__button' => 'border-color: {{VALUE}}'
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->end_controls_tabs();
	    $this->end_controls_section();

        /**
	     * STYLE -> BUTTON ICON
	     */

	    $this->start_controls_section(
		    'section_style_button_icon',
		    [
			    'label' => esc_html__('Button Icon', 'burido-core'),
			    'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_type' => 'wgl-button',
                    'add_read_more' => 'yes'
                ],
		    ]
	    );
	    $this->add_responsive_control(
		    'button_icon_padding',
		    [
			    'label' => esc_html__('Padding', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', 'em', '%', 'custom'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );
	    $this->add_responsive_control(
		    'button_icon_radius',
		    [
			    'label' => esc_html__('Border Radius', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%', 'custom'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );
	    $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'button_icon_border',
			    'render_type' => 'template',
			    'dynamic' => ['active' => true],
			    'fields_options' => [
                    'border' => [ 'default' => 'none' ],
				    'color' => ['type' => Controls_Manager::HIDDEN],
			    ],
			    'selector' => '{{WRAPPER}} .wgl-icon',
		    ]
	    );
        $this->start_controls_tabs( 'tabs_button_icon' );
	    $this->start_controls_tab(
		    'tab_button_icon_idle',
		    ['label' => esc_html__('Idle', 'burido-core')]
	    );
	    $this->add_control(
		    'button_icon_icon_color_idle',
		    [
			    'label' => esc_html__('Icon Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_btn_border_idle(),
			    'selectors' => [
				    '{{WRAPPER}} .wgl-icon' => 'color: {{VALUE}}'
			    ],
		    ]
	    );
        $this->add_control(
            'button_icon_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_icon_icon_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_icon_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'button_icon_border_color_idle',
		    [
			    'label' => esc_html__('Border Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [ 'button_icon_border_border!' => ['', 'none'] ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-icon' => 'border-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'button_icon_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_icon_border_border!' => ['', 'none'],
                    'button_icon_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon' => 'border-color: {{VALUE}};',
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->start_controls_tab(
		    'tab_button_icon_hover',
		    ['label' => esc_html__('Hover', 'burido-core')]
	    );
	    $this->add_control(
		    'button_icon_color_hover',
		    [
			    'label' => esc_html__('Icon Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button:hover .wgl-icon,
                     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                'condition' => [ 'button_icon_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button:hover .wgl-icon,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button:hover .wgl-icon,
                     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_icon_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button:hover .wgl-icon,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'button_icon_border_color_hover',
		    [
			    'label' => esc_html__('Border Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'button_icon_border_border!' => ['', 'none'] ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-cases__button:hover .wgl-icon,
				     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-icon' => 'border-color: {{VALUE}}'
			    ],
		    ]
	    );
        $this->add_control(
            'button_icon_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_icon_border_border!' => ['', 'none'],
                    'button_icon_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__button:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-icon' => 'border-color: {{VALUE}}'
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
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-cases__button:hover .wgl-icon,
				     {{WRAPPER}} .wgl-cases__link:hover ~ .wgl-button-wrapper .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button' => '--wgl-icon-wrapper: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => 'left:{{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => '--bg-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-offset: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-width: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-extend: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-button .wgl-icon' => '--icon-bg-size: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'wgl-cases' ],
                'data-carousel' => $_s['use_carousel']
            ]
        );

        // Render
        echo '<div ', $this->get_render_attribute_string('wrapper'), '>',
            $this->get_cases_html(),
        '</div>';
    }

    protected function get_cases_html()
    {
        $_s = $this->get_settings_for_display();

        // Icon
        $thumb_icon = '';
        if (!empty($_s['thumbnail_icon']['value']) || !empty($_s['text_over_image'])) {
            $thumb_icon = '<div class="media-wrapper icon-wrapper"><div class="wgl-icon">';
            if (!empty($_s['text_over_image'])) {
                $thumb_icon .= '<span class="wgl-text_over_image">' . $_s['text_over_image'] . '</span>';
            }
            if (!empty($_s['thumbnail_icon']['value'])) {
                if ('svg' === $_s['thumbnail_icon']['library']) {
                    $thumb_icon .= '<span class="icon elementor-icon">';
                }

                // Icon migration
                $migrated = isset($atts['__fa4_migrated']['thumbnail_icon']);
                $is_new = Icons_Manager::is_migration_allowed();
                if ($is_new || $migrated) {
                    ob_start();
                    Icons_Manager::render_icon($_s['thumbnail_icon'], ['class' => 'icon elementor-icon', 'aria-hidden' => 'true']);
                    $thumb_icon .= ob_get_clean();
                } else {
                    $thumb_icon .= '<i class="icon elementor-icon ' . esc_attr($_s['thumbnail_icon']['value']) . '"></i>';
                }

                if ('svg' === $_s['thumbnail_icon']['library']) {
                    $thumb_icon .= '</span>';
                }
            }
            $thumb_icon .= '</div></div>';
        }

        $content = $btn_icon = $link = '';
        foreach ($_s['list'] as $index => $item) {

	        // Image
	        $image = new WGL_Icons;
            $case_image = $image->build($this, $item, 'image_');

	        // Icon
	        $icon = new WGL_Icons;
            $case_icon = $icon->build($this, $item, 'icon_');

            $has_link = !empty($item['link']['url']);
	        if ($has_link) {
                $link = $this->get_repeater_setting_key('link', 'list', $index);
                $this->add_link_attributes($link, $item['link']);
            }

            $btn = $this->get_repeater_setting_key('btn', 'list', $index);
            if ($_s['add_read_more']) {
                $this->add_render_attribute($btn, 'class',
                    [
                        'wgl-cases__button',
                        $_s['button_type'] ?? '',
                        !$item['read_more_text'] ? 'no_text' : ''
                    ]
                );
                if ($_s['read_more_icon_fontawesome']['value']) {
                    if(isset($_s['read_more_icon_fontawesome']['value'])) {
                        $migrated = isset( $atts['__fa4_migrated']['read_more_icon_fontawesome'] );
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
                } else {
                    $this->add_render_attribute([$btn => ['class'=> 'no_media']]);
                }

                $case_button = '<div class="wgl-button-wrapper">';
                    $case_button .= sprintf(
                        '<%s %s %s>',
                        $_s['module_link'] || !$has_link ? 'div' : 'a',
                        $_s['module_link'] || !$has_link ? '' : $this->get_render_attribute_string($link),
                        $this->get_render_attribute_string($btn)
                    );

                        $case_button .= 'wgl-button' === $_s['button_type'] ? '<div class="button__content">' : '';
                            $case_button .= $btn_icon ?: '';
                            $case_button .= $item['read_more_text'] ? '<span>' . esc_html($item['read_more_text']) . '</span>' : '';
                        $case_button .= 'wgl-button' === $_s['button_type'] ? '</div>' : '';
                    $case_button .= $_s['module_link'] || !$has_link ? '</div>' : '</a>';
                $case_button .= '</div>';
            }

            // Content
            $title = '';
            if (!empty($item['case_title'])) {
                $title .= '<div class="case_title__wrapper">';
                    $title .= '<' . esc_attr($_s['title_tag']) . ' class="case_title">';
                        $title .= '<span>'.$item['case_title'].'</span>';
                    $title .= '</' . esc_attr($_s['title_tag']) . '>';
                $title .= '</div>';
            }

            $subtitle = '';
            if (!empty($item['case_subtitle'])) {
                $subtitle .= '<div class="case_subtitle__wrapper">';
                    $subtitle .= '<' . esc_attr($_s['subtitle_tag']) . ' class="case_subtitle">';
                        $subtitle .= '<span>'.$item['case_subtitle'].'</span>';
                    $subtitle .= '</' . esc_attr($_s['subtitle_tag']) . '>';
                $subtitle .= '</div>';
            }

            $bg_text = '';
            if (!empty($item['case_bg_text'])) {
                $bg_text .= '<div class="case_bg_text">' . $item['case_bg_text'] . '</div>';
            }

            // Content
            $case_content = '';
            if (!empty($item['case_content'])) {
                $case_content .= '<div class="case_content__wrapper">';
                $case_content .= $item['case_content'];
                $case_content .= '</div>';
            }

            ob_start();

            echo '<div class="case_items elementor-repeater-item-'. $item['_id'] . (($_s['use_carousel']) ? ' swiper-slide' : '') .'">';
            echo '<div class="case_items__inner_wrapper">';
                if ($_s['module_link'] && $has_link) {
                    echo '<a class="wgl-cases__link" ' . $this->get_render_attribute_string($link) . '></a>';
                }

                if (!!$case_image || !!$thumb_icon) {
                    echo '<div class="image_wrapper">'
                        .$case_image
                        .$thumb_icon
                    .'</div>';
                }

                if (!!$case_icon) {
                    echo '<div class="icon_wrapper">'
                        .$case_icon
                    .'</div>';
                }

                echo $bg_text ?? '';

                echo $title ?? '';

                echo $subtitle ?? '';

                echo $case_content ?? '';

	            echo $case_button ?? '';

            echo '</div></div>';

            $content .= ob_get_clean();
        }

        return !$_s['use_carousel'] ? $content : $this->apply_carousel_settings($content);
    }

    protected function apply_carousel_settings($content)
    {
        $_s = $this->get_settings_for_display();
        $_s['slides_per_row'] = $_s['item_grid']['size'] ?? 4;

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
