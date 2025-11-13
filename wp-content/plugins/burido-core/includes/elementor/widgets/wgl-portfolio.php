<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-portfolio.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow,
    Utils
};
use WGL_Extensions\{
    Includes\WGL_Loop_Settings,
    Includes\WGL_Carousel_Settings,
    Templates\WGL_Portfolio as Portfolio_Template,
    Includes\WGL_Cursor,
    WGL_Framework_Global_Variables as WGL_Globals
};

class WGL_Portfolio extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-portfolio';
    }

    public function get_title()
    {
        return esc_html__('WGL Portfolio', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-portfolio';
    }

    public function get_keywords() {
        return ['portfolio'];
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    public function get_script_depends()
    {
        return [
            'swiper',
            'imagesloaded',
            'isotope',
            'wgl-widgets',
        ];
    }

    public function get_style_depends()
    {
        return [ 'swiper' ];
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
            'portfolio_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'portfolio_subtitle',
            [
                'label' => esc_html__('Subitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_sticky',
            [
                'label' => esc_html__('Module Title Sticky', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'layout' => ['grid-2'],
                ],
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => esc_html__('Show Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'layout' => ['grid-2']
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Text', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__( 'VIEW ALL PROJECTS', 'burido-core' ),
                'condition' => [
                    'layout' => ['grid-2'],
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Link', 'burido-core' ),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__( 'https://your-link.com', 'burido-core' ),
                'condition' => [
                    'layout' => ['grid-2'],
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'burido-core'),
                'type' => 'wgl-radio-image',
                'options' => [
                    'grid' => [
                        'title' => esc_html__('Grid', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_grid.png',
                    ],
                    'carousel' => [
                        'title' => esc_html__('Carousel', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_carousel.png',
                    ],
                    'grid-2' => [
                        'title' => esc_html__('Grid 2', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_grid.png',
                    ],
                    'flex-list' => [
                        'title' => esc_html__('Flex List', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_carousel.png',
                    ],
                    'masonry-1' => [
                        'title' => esc_html__('Masonry 1', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
                    ],
                    'masonry-2' => [
                        'title' => esc_html__('Masonry 2', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry_2.png',
                    ],
                    'masonry-3' => [
                        'title' => esc_html__('Masonry 3', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry_3.png',
                    ],
                    'masonry-4' => [
                        'title' => esc_html__('Masonry 4', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry_4.png',
                    ],
                ],
                'default' => 'grid',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'posts_per_row',
            [
                'label' => esc_html__('Columns Amount', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'layout' => ['grid', 'masonry-1', 'carousel']
                ],
                'options' => [
                    '1' => esc_html__('1 (one)', 'burido-core'),
                    '2' => esc_html__('2 (two)', 'burido-core'),
                    '3' => esc_html__('3 (three)', 'burido-core'),
                    '4' => esc_html__('4 (four)', 'burido-core'),
                    '5' => esc_html__('5 (five)', 'burido-core'),
                ],
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio_container' => '--pf-width: calc(100% / {{VALUE}});',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => esc_html__('Grid Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'frontend_available' => true,
                'range' => [
                    'px' => ['min' => 0, 'max' => 70, 'step' => 2],
                ],
                'default' => ['size' => 30],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio_container' => '--pf-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['layout!' => ['grid-2']],
            ]
        );

        $this->add_responsive_control(
            'flex_image_height',
            [
                'label' => esc_html__('Images Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 200, 'max' => 800, 'step' => 10],
                ],
                'default' => ['size' => 620],
                'tablet_default' => [ 'size' => 440],
                'mobile_default' => [ 'size' => 300],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio .item__image' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['layout' => ['flex-list']],
            ]
        );

        $this->add_responsive_control(
            'flex_descr_width',
            [
                'label' => esc_html__('Description Max Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 50, 'max' => 270, 'step' => 1],
                ],
                'default' => ['size' => 270],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio .item__description' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['layout' => ['flex-list']],
            ]
        );

        $this->add_control(
            'show_filter',
            [
                'label' => esc_html__('Show Filter', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'layout!' => ['carousel', 'flex-list', 'grid-2']
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'filter_counter_enabled',
            [
                'label' => esc_html__('Use Filter Counter?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_filter' => 'yes',
                    'layout!' => ['carousel', 'flex-list', 'grid-2']
                ],
            ]
        );

        $this->add_control(
            'filter_max_width_enabled',
            [
                'label' => esc_html__('Limit the Filter Container Width', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_filter' => 'yes',
                    'layout!' => ['carousel', 'flex-list', 'grid-2']
                ],
            ]
        );

        $this->add_control(
            'filter_max_width',
            [
                'label' => esc_html__('Filter Container Max Width (px)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'show_filter' => 'yes',
                    'filter_max_width_enabled' => 'yes',
                    'layout!' => ['carousel', 'flex-list', 'grid-2']
                ],
                'default' => '1170',
                'selectors' => [
                    '{{WRAPPER}} .wgl-filter_wrapper.isotope-filter' => 'width: min(100%, {{VALUE}}px); overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_alignment',
            [
                'label' => esc_html__( 'Filter Alignment', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'condition' => [
                    'show_filter' => 'yes',
                    'layout!' => ['carousel', 'flex-list', 'grid-2']
                ],
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
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'burido-core'),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                ],
                'default' => 'space-between',
            ]
        );

        $this->add_control(
            'image_masonry_size',
            [
                'label' => esc_html__('Image Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'layout' => ['masonry-2', 'masonry-3', 'masonry-4']
                ],
                'range' => [ 'px' => ['min' => 100, 'max' => 2560] ],
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'label' => esc_html__('Image Size', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'layout' => ['grid', 'carousel', 'flex-list', 'grid-2']
                ],
                'separator' => 'before',
                'options' => [
                    '150' => esc_html__('150x150 - Thumbnail', 'burido-core'),
                    '300' => esc_html__('300x300 - Medium', 'burido-core'),
                    '1024' => esc_html__('1024x1024 - Large', 'burido-core'),
                    '1140x840' => esc_html__('1140x840 - 2 Columns', 'burido-core'),
                    '740x740' => esc_html__('740x740 - 3 Columns', 'burido-core'),
                    '886' => esc_html__('886x886 - 4 Columns Wide', 'burido-core'),
                    '1280x1300' => esc_html__('1280x1300 - Grid 2', 'burido-core'),
                    '870x620' => esc_html__('870x620 - Flex List', 'burido-core'),
                    'full' => esc_html__('Full', 'burido-core'),
                    'custom' => esc_html__('Custom', 'burido-core'),
                ],
                'default' => '740x740',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'burido-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    'img_size_string' => 'custom',
                    'layout' => ['grid', 'carousel', 'flex-list', 'grid-2'],
                ],
                'description' => esc_html__('Crop the original image to any custom size. You can also set a single value for width to keep the initial ratio.', 'burido-core'),
                'default' => [
                    'width' => '740',
                    'height' => '740',
                ],
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'layout' => ['grid', 'carousel', 'flex-list', 'grid-2'],
                    'img_size_string!' => 'custom',
                ],
                'options' => [
                    '' => esc_html__('No Crop', 'burido-core'),
                    '1:1' => esc_html('1:1'),
                    '3:2' => esc_html('3:2'),
                    '4:3' => esc_html('4:3'),
                    '6:5' => esc_html('6:5'),
                    '9:16' => esc_html('9:16'),
                    '16:9' => esc_html('16:9'),
                    '21:9' => esc_html('21:9'),
                    '85:63,1:1' => esc_html__('Chess Type ( 85:63 / 1:1 )', 'burido-core'),
                    '1:1,85:63' => esc_html__('Chess Type ( 1:1 / 85:63 )', 'burido-core'),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'remainings_loading_type',
            [
                'label' => esc_html__('Remaining Posts Loading Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['layout!' => ['carousel', 'flex-list']],
                'separator' => 'before',
                'options' => [
                    'none' => esc_html__('None', 'burido-core'),
                    'pagination' => esc_html__('Pagination', 'burido-core'),
                    'infinite' => esc_html__('Infinite Scroll', 'burido-core'),
                    'load_more' => esc_html__('Load More', 'burido-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'remainings_loading_alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [
                    'remainings_loading_type' => 'pagination',
                    'layout!' => ['carousel', 'flex-list']
                ],
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-pagination' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'remainings_loading_pagination_offset',
            [
                'label' => esc_html__('Margin Top', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'remainings_loading_type' => 'pagination',
                    'layout!' => ['carousel', 'flex-list']
                ],
                'range' => [
                    'px' => ['min' => -150, 'max' => 500],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'remainings_loading_btn_items_amount',
            [
                'label' => esc_html__('Items to be loaded', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'layout!' => ['carousel', 'flex-list'],
                    'remainings_loading_type' => ['load_more', 'infinite'],
                ],
                'min' => 1,
                'default' => 4,
            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'condition' => [
                    'layout!' => ['carousel', 'flex-list'],
                    'remainings_loading_type' => 'load_more',
                ],
                'default' => esc_html__('Load More', 'burido-core'),
            ]
        );

        $this->add_control(
            'appear_animation_enabled',
            [
                'label' => esc_html__('Appear Animation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'appear_animation_style',
            [
                'label' => esc_html__('Animation Style', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['appear_animation_enabled!' => ''],
                'options' => [
                    'fade-in' => esc_html__('Fade In', 'burido-core'),
                    'flip-x' => esc_html__('Flip X', 'burido-core'),
                    'flip-x-r' => esc_html__('Flip X Reverse', 'burido-core'),
                    'flip-y' => esc_html__('Flip Y', 'burido-core'),
                    'flip-y-r' => esc_html__('Flip Y Reverse', 'burido-core'),
                    'slide-top' => esc_html__('Slide Top', 'burido-core'),
                    'slide-bottom' => esc_html__('Slide Bottom', 'burido-core'),
                    'slide-left' => esc_html__('Slide Left', 'burido-core'),
                    'slide-right' => esc_html__('Slide Right', 'burido-core'),
                    'zoom' => esc_html__('Zoom', 'burido-core'),
                ],
                'default' => 'fade-in',
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> APPEARANCE
         */

        $this->start_controls_section(
            'content_appearance',
            ['label' => esc_html__('Appearance', 'burido-core')]
        );

        $this->add_control(
            'gallery_mode_enabled',
            [
                'label' => esc_html__('Gallery Mode', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['layout!' => ['grid-2']],
            ]
        );

        $this->add_control(
            'use_additional_post',
            [
                'label' => esc_html__('Add Additional Post', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'additional_post_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => ['use_additional_post!' => ''],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Additional Post item is fully cusomizible via `Style` tab.', 'burido-core'),
            ]
        );

        $this->add_control(
            'show_portfolio_title',
            [
                'label' => esc_html__('Show Heading', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['gallery_mode_enabled' => ''],
                'separator' => 'before',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_meta_categories',
            [
                'label' => esc_html__('Show Categories', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['gallery_mode_enabled' => ''],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_meta_date',
            [
                'label' => esc_html__('Show Date', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'gallery_mode_enabled' => '',
                    'layout' => 'grid-2'
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'show_content',
            [
                'label' => esc_html__('Show Excerpt/Content', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['gallery_mode_enabled' => ''],
            ]
        );

        $this->add_control(
            'content_letter_count',
            [
                'label' => esc_html__('Content Characters Amount', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'show_content' => 'yes',
                    'gallery_mode_enabled' => '',
                ],
                'min' => 1,
                'default' => 85,
            ]
        );

        $this->add_control(
            'show_icon_button',
            [
                'label' => esc_html__('Show Icon Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'gallery_mode_enabled' => '',
                    'layout' => 'grid-2'
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'description_heading',
            [
                'label' => esc_html__('Description', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['gallery_mode_enabled' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'condition' => [
                    'gallery_mode_enabled' => '',
                    'layout!' => 'grid-2'
                ],
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'inside_image' => esc_html__('Within Image', 'burido-core'),
                    'under_image' => esc_html__('Beneath Image', 'burido-core'),
                    'pf_cursor_tooltip' => esc_html__('Cursor Tooltip', 'burido-core'),
                ],
                'default' => 'under_image',
            ]
        );

        $this->add_control(
            'description_animation',
            [
                'label' => esc_html__('Animation', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'description_position' => 'inside_image',
                    'gallery_mode_enabled' => '',
                    'layout!' => 'grid-2'
                ],
                'options' => [
                    'simple' => esc_html__('Simple', 'burido-core'),
                    'sub_layer' => esc_html__('Sub-Layer', 'burido-core'),
                    'until_hover' => esc_html__('Visible Until Hover', 'burido-core'),
                    'always_visible' => esc_html__('Always Visible', 'burido-core'),
                ],
                'default' => 'sub_layer',
            ]
        );

        $this->add_control(
            'description_alignment_v',
            [
                'label' => esc_html__('Description Position', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [
                    'gallery_mode_enabled' => '',
                    'description_position' => 'under_image',
                    'layout!' => 'grid-2'
                ],
                'toggle' => true,
                'options' => [
                    'column-reverse' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .description_under_image' => 'flex-direction: {{VALUE}};',
                ],
                'default' => 'column-reverse',
            ]
        );

        $this->add_control(
            'description_alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [
                    'gallery_mode_enabled' => '',
                    'description_position!' => 'pf_cursor_tooltip',
                ],
                'toggle' => true,
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
                        'title' => esc_html__('Justified', 'burido-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .description__wrapper' => 'text-align: {{VALUE}};',
                ],
                'prefix_class' => 'descr-align-',
            ]
        );

        $this->add_control(
            'chess_layout',
            [
                'label' => esc_html__('Chess Layout', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'chess',
                'prefix_class' => 'layout-',
                'condition' => ['layout!' => ['grid-2']],
            ]
        );

        $this->add_control(
            'chess_offset',
            [
                'label' => esc_html__('Chess Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'chess_layout!' => '',
                    'layout!' => 'grid-2'
                ],
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 300],
                    'rem' => ['min' => 0.1, 'max' => 20, 'step' => 0.1],
                ],
                'default' => ['size' => '30'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-wrapper' => 'padding-top: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .wgl-portfolio_container:not(.carousel)' => 'padding-top: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}}.item-offset-even .portfolio__item:nth-child(even)' => 'margin-top: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.item-offset-odd .portfolio__item:nth-child(odd)' => 'margin-top: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'chess_odd_even',
            [
                'label' => esc_html__('Odd/Even Item Offset', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'chess_layout!' => '',
                    'layout!' => 'grid-2'
                ],
                'options' => [
                    'odd' => esc_html__('Odd', 'burido-core'),
                    'even' => esc_html__('Even', 'burido-core'),
                ],
                'default' => 'odd',
                'prefix_class' => 'item-offset-'
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> LINKS
         */

        $this->start_controls_section(
            'content_links',
            [
                'label' => esc_html__('Links', 'burido-core'),
                'condition' => ['gallery_mode_enabled' => ''],
            ]
        );

        $this->add_control(
            'image_has_link',
            [
                'label' => esc_html__('Add link on Image', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_has_link',
            [
                'label' => esc_html__('Add link on Heading', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['show_portfolio_title!' => ''],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'link_destination',
            [
                'label' => esc_html__('Click Action', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'title_has_link',
                            'operator' => '!==',
                            'value' => '',
                        ], [
                            'name' => 'image_has_link',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'options' => [
                    'single' => esc_html__('Open Single Page', 'burido-core'),
                    'custom' => esc_html__('Open Custom Link', 'burido-core'),
                    'popup' => esc_html__('Popup the Image', 'burido-core'),
                ],
                'default' => 'single',
            ]
        );

        $this->add_control(
            'link_custom_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => ['link_destination' => 'custom'],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: Specify the link in metabox section of each corresponding post.', 'burido-core'),
            ]
        );

        $this->add_control(
            'link_target',
            [
                'label' => esc_html__('Open link in a new tab', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'conditions' => [
                    'terms' => [
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'title_has_link',
                                    'operator' => '!==',
                                    'value' => '',
                                ], [
                                    'name' => 'image_has_link',
                                    'operator' => '!==',
                                    'value' => '',
                                ],
                            ],
                        ],
                        [
                            'name' => 'link_destination',
                            'operator' => '!==',
                            'value' => 'popup',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        WGL_Cursor::init(
            $this,
            [
                'section' => true,
                'condition' => ['description_position!' => 'pf_cursor_tooltip'],
            ]
        );

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        $this->start_controls_section(
            'content_carousel',
            [
                'label' => esc_html__('Carousel Options', 'burido-core'),
                'condition' => ['layout' => 'carousel'],
            ]
        );

        WGL_Carousel_Settings::add_general_controls($this, [
            'slider_infinite'  => [
                'default' => 'yes'
            ],
            'slide_per_single' => [
                'default' => 1
            ],
        ]);

        $this->add_responsive_control(
            'center_scale_size',
            [
                'label' => esc_html__( 'Center Item Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'center_mode!' => '' ],
                'size_units' => [ '%', 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 100, 'step' => 1 ],
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .center-mode .portfolio__item.swiper-slide-active .item__wrapper' => '--wgl-portfolio-center-scale-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'around_center_scale_size',
            [
                'label' => esc_html__( 'Items Around The Central Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'center_mode!' => '' ],
                'size_units' => [ '%', 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 100, 'step' => 1 ],
                ],
                'default' => [ 'size' => 80, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .center-mode .portfolio__item:not(.swiper-slide-active) .item__wrapper' => '--wgl-portfolio-center-scale-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'variable_width',
            [
                'label' => esc_html__('Variable Width', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio_wrapper' => 'overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'variable_width_height',
            [
                'label' => esc_html__('Set Height', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'condition' => ['variable_width!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .item__image img' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'chess_divider_before',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['chess_layout!' => ''],
            ]
        );

        $this->add_control(
            'multi_sized_layout',
            [
                'label' => esc_html__( 'Multi-sized Layout', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'scale',
                'prefix_class' => 'layout-',
            ]
        );

        $this->add_responsive_control(
            'scale_size',
            [
                'label' => esc_html__( 'Scale Size', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'multi_sized_layout!' => '' ],
                'size_units' => [ '%', 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 100, 'step' => 1 ],
                ],
                'default' => [ 'size' => 80, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio__item:nth-child(even)' => '--wgl-portfolio-scale-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [[
                        'terms' => [[
                            'name' => 'chess_layout',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ], [
                        'terms' => [[
                            'name' => 'use_pagination',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ],],
                ],
            ]
        );

        WGL_Carousel_Settings::add_pagination_controls($this, [
            'pagination_type'  => [
                'default' => 'circle',
            ],
        ]);

        $this->add_control(
            'pagination_navigation_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [[
                        'terms' => [[
                            'name' => 'use_pagination',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ], [
                        'terms' => [[
                            'name' => 'use_navigation',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ],],
                ],
            ]
        );

        WGL_Carousel_Settings::add_navigation_controls($this);

        $this->add_control(
            'navigation_responsive_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [[
                        'terms' => [[
                            'name' => 'use_navigation',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ], [
                        'terms' => [[
                            'name' => 'customize_responsive',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ],],
                ],
            ]
        );

        WGL_Carousel_Settings::add_responsive_controls($this, [
            'desktop_slides' => [
                'label' => esc_html__('Columns amount', 'burido-core'),
                'max' => 5,
            ],
            'tablet_slides' => [
                'label' => esc_html__('Columns amount', 'burido-core'),
                'max' => 5,
            ],
            'mobile_slides' => [
                'label' => esc_html__('Columns amount', 'burido-core'),
                'max' => 5,
            ],
        ]);

        $this->end_controls_section();

        /**
         * SETTINGS -> QUERY
         */

        WGL_Loop_Settings::add_controls($this, [
            'post_type' => 'portfolio',
            'hide_cats' => true,
            'hide_tags' => true
        ]);

        /**
         * STYLE -> FILTER
         */

        $this->start_controls_section(
            'style_filter',
            [
                'label' => esc_html__('Filter', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_filter' => 'yes'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter',
                'selector' => '{{WRAPPER}} .isotope-filter a',
            ]
        );

        $this->add_control(
            'filter_cats_gap',
            [
                'label' => esc_html__('Categories Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100, 'step' => 2],
                ],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter' => '--wgl-filtet-categories-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_cats_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_cats_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .isotope-filter a .cat_title' => 'padding: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->add_control(
            'filter_cats_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('filter');

        $this->start_controls_tab(
            'filter_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'filter_color_idle',
            [
                'label' => esc_html__('Category Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:not(.active)' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_color_idle-dynamic',
            [
                'label' => esc_html__('Category Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['filter_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a:not(.active)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_counter_color_idle',
            [
                'label' => esc_html__('Counter Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['filter_counter_enabled' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:not(.active) .filter_counter' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_counter_color_idle-dynamic',
            [
                'label' => esc_html__('Counter Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'filter_counter_enabled' => 'yes',
                    'filter_counter_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a:not(.active) .filter_counter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:not(.active)' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['filter_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a:not(.active)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_border_idle',
                'selector' => '{{WRAPPER}} .isotope-filter a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'filter_color_hover',
            [
                'label' => esc_html__('Category Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_color_hover-dynamic',
            [
                'label' => esc_html__('Category Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['filter_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_counter_color_hover',
            [
                'label' => esc_html__('Counter Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['filter_counter_enabled' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:hover .filter_counter' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_counter_color_hover-dynamic',
            [
                'label' => esc_html__('Counter Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'filter_counter_enabled' => 'yes',
                    'filter_counter_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a:hover .filter_counter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['filter_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_border_hover',
                'selector' => '{{WRAPPER}} .isotope-filter a:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_active',
            ['label' => esc_html__('Active', 'burido-core')]
        );

        $this->add_control(
            'filter_color_active',
            [
                'label' => esc_html__('Category Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_color_active-dynamic',
            [
                'label' => esc_html__('Category Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['filter_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_counter_color_active',
            [
                'label' => esc_html__('Counter Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['filter_counter_enabled' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a.active .filter_counter' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_counter_color_active-dynamic',
            [
                'label' => esc_html__('Counter Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'filter_counter_enabled' => 'yes',
                    'filter_counter_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a.active .filter_counter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_active',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_bg_active-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['filter_bg_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_border_active',
                'selector' => '{{WRAPPER}} .isotope-filter a.active',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'filter_shadow_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'filter_shadow',
                'selector' => '{{WRAPPER}} .isotope-filter a',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> MODULE TITLE
         */

        $this->start_controls_section(
            'section_style_module_title',
            [
                'label' => esc_html__('Module Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'portfolio_title',
                            'operator' => '!in',
                            'value' => [''],
                        ], [
                            'name' => 'portfolio_subtitle',
                            'operator' => '!in',
                            'value' => [''],
                        ], [
                            'name' => 'show_button',
                            'operator' => '!in',
                            'value' => [''],
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'heading_portfolio_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['portfolio_title!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_title',
                'selector' => '{{WRAPPER}} .portfolio_title',
                'condition' => ['portfolio_title!' => ''],
            ]
        );

        $this->add_control(
            'heading_portfolio_title_color',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['portfolio_title!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_portfolio_title_color-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'portfolio_title!' => '',
                    'heading_portfolio_title_color!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'portfolio_title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['portfolio_title!' => ''],
            ]
        );

        $this->add_control(
            'heading_portfolio_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['portfolio_subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_subtitle',
                'selector' => '{{WRAPPER}} .portfolio_subtitle',
                'condition' => ['portfolio_subtitle!' => ''],
            ]
        );

        $this->add_control(
            'heading_portfolio_subtitle_color',
            [
                'label' => esc_html__('Subtitle Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['portfolio_subtitle!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_portfolio_subtitle_color-dynamic',
            [
                'label' => esc_html__('Subtitle Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'portfolio_subtitle!' => '',
                    'heading_portfolio_subtitle_color!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'portfolio_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['portfolio_subtitle!' => ''],
            ]
        );

        $this->add_control(
            'heading_portfolio_button',
            [
                'label' => esc_html__('Button', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['show_button!' => ''],
            ]
        );
        $this->start_controls_tabs(
            'heading_portfolio_button_tabs',
            [
                'condition' => ['show_button!' => ''],
            ]
        );

        $this->start_controls_tab(
            'heading_button_idle_tab',
            ['label' => esc_html__('Idle', 'burido-core')],
        );

        $this->add_control(
            'heading_button_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_header-button .wgl-button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_button_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_button_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_header-button .wgl-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_button_border_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_header-button .wgl-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_button_border_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_button_border_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_header-button .wgl-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_header-button .wgl-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_button_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_button_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_header-button .wgl-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_button_hover_tab',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'heading_button_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_header-button .wgl-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_button_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_button_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_header-button .wgl-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_button_border_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_header-button .wgl-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_button_border_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_button_border_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_header-button .wgl-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio_header-button .wgl-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_button_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_button_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio_header-button .wgl-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> OVERLAYS
         */

        $this->start_controls_section(
            'style_overlays',
            [
                'label' => esc_html__('Overlays', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_scale_animation',
            [
                'label' => esc_html__( 'Image Hover Scale Animation', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'thubmnail_underlay_heading',
            [
                'label' => esc_html__('Image Underlay', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'description_position' => 'under_image',
                    'gallery_mode_enabled' => '',
                    'layout!' => 'grid-2'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'thubmnail_underlay',
                'selector' => '{{WRAPPER}} .item__image::before',
                'condition' => [
                    'description_position' => 'under_image',
                    'gallery_mode_enabled' => '',
                    'layout!' => 'grid-2'
                ],
            ]
        );

        $this->add_responsive_control(
            'image_wrap_margin',
            [
                'label' => esc_html__('Image Wrapper Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__image-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_scale_size',
            [
                'label' => esc_html__( 'Scale Size', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_scale_animation!' => '' ],
                'range' => [
                    'px' => [ 'min' => 0.1, 'max' => 2, 'step' => 0.01 ],
                ],
                'default' => [ 'size' => 1.07 ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio__item .item__wrapper' => '--wgl-portfolio-image-scale-size: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'image_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_scale_animation!' => '' ],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.8],
                'selectors' => [
                    '{{WRAPPER}} .portfolio__item .item__wrapper' => '--wgl-portfolio-image-transition: {{SIZE}}s',
                ],
            ]
        );

        $this->add_control(
            'images_overlay_heading',
            [
                'label' => esc_html__('Images Overlay', 'burido-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('images_overlay');

        $this->start_controls_tab(
            'img_overlay_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'images_grayscale_idle',
            [
                'label' => esc_html__('Grayscale Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .item__image img' => 'filter: grayscale({{SIZE}});',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'thubmnail_overlay_idle',
                'selector' => '{{WRAPPER}} .item__image-wrap::before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'img_overlay_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'images_grayscale_hover',
            [
                'label' => esc_html__('Grayscale Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio__item:hover .item__image img' => 'filter: grayscale({{SIZE}});',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'thubmnail_overlay_hover',
                'selector' => '{{WRAPPER}} .item__image-wrap::after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'images_radius_heading',
            [
                'label' => esc_html__('Images Border Radius', 'burido-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('images_radius');

        $this->start_controls_tab(
            'img_border_radius_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'img_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio__item .item__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'img_radius_border_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'img_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio__item .item__wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> DESCRIPTIONS
         */

        $this->start_controls_section(
            'style_descriptions',
            [
                'label' => esc_html__('Descriptions', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['gallery_mode_enabled' => ''],
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'description_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'description_under_img',
                'selector' => '{{WRAPPER}} .item__description',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'description_shdw',
                'condition' => [
                    'description_position' => 'inside_image',
                    'description_animation' => 'sub_layer',
                ],
                'selector' => '{{WRAPPER}} .item__description',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> HEADINGS
         */

        $this->start_controls_section(
            'style_headings',
            [
                'label' => esc_html__('Headings', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_portfolio_title!' => '',
                    'gallery_mode_enabled' => ''
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'headings',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_responsive_control(
            'headings_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'headings' );

        $this->start_controls_tab(
            'headings_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'headings_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'headings_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['headings_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'headings_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'headings_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'headings_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['headings_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CATEGORIES
         */

        $this->start_controls_section(
            'style_categories',
            [
                'label' => esc_html__('Categories', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_meta_categories!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'categories',
                'selector' => '{{WRAPPER}} .portfolio-category',
            ]
        );

        $this->add_responsive_control(
            'cat_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .post_cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cat_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cat_sep_color',
            [
                'label' => esc_html__('Separator Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category::after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'cat_sep_color-dynamic',
            [
                'label' => esc_html__('Separator Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['cat_sep_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio-category::after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'categories' );

        $this->start_controls_tab(
            'categories_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_responsive_control(
            'cat_padding_idle',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cat_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'cat_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['cat_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio-category' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cat_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'cat_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['cat_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio-category' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'categories_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_responsive_control(
            'cat_padding_hover',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cat_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'cat_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['cat_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio-category:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cat_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'cat_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['cat_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .portfolio-category:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> EXCERPT/CONTENT
         */

        $this->start_controls_section(
            'style_excerpt',
            [
                'label' => esc_html__('Excerpt|Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_content!' => ''],
            ]
        );

        $this->add_control(
            'custom_content_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .description_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'custom_content_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['custom_content_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .description_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> LOAD MORE BUTTON
         */

        $this->start_controls_section(
            'style_load_more',
            [
                'label' => esc_html__('Load More Button', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['remainings_loading_type' => 'load_more'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'load_more',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->add_control(
            'load_more_alignment',
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
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->start_controls_tabs( 'load_more_btn' );
        $this->start_controls_tab( 'load_more_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'load_more_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_item' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'load_more_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-load_more_item:active' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'load_more_border_border!' => ['', 'none'],
                    'load_more_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-load_more_item:active' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'load_more_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'load_more_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'load_more_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .wgl-load_more_item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'load_more_border_border!' => ['', 'none'],
                    'load_more_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_wrapper .wgl-load_more_item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'load_more_active',
            ['label' => esc_html__('Active', 'burido-core')]
        );
        $this->add_control(
            'load_more_color_active',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_color_active-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_item:active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_bg_active',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more_item:active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_bg_active-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_bg_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_wrapper .load_more_item:active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_border_color_active',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'load_more_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .wgl-load_more_item:active' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_border_color_active-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'load_more_border_border!' => ['', 'none'],
                    'load_more_border_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_wrapper .wgl-load_more_item:active' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'load_more_media_heading',
            [
                'label' => esc_html__('Media', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'load_more_media_type',
            [
                'label' => esc_html__('Media Type', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__('None', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'burido-core'),
                        'icon' => 'far fa-smile',
                    ],
                ],
                'default' => 'icon'
            ]
        );
        $this->add_control(
            'load_more_media_icon',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'media_type' => 'font',
                    'icon' => [
                        'library' => 'fa-solid',
                        'value' => 'fas fa-arrow-right',
                    ],
                ],
                'condition' => ['load_more_media_type' => 'icon'],
            ]
        );
        $this->add_responsive_control(
            'load_more_icon_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['load_more_media_type' => 'icon'],
                'allowed_dimensions' => 'horizontal',
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more__icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'load_more_icon_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['load_more_media_type' => 'icon'],
                'allowed_dimensions' => 'horizontal',
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_icon_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['load_more_media_type' => 'icon'],
                'separator' => 'after',
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'load_more_icon',
            ['condition' => ['load_more_media_type' => 'icon']]
        );

        $this->start_controls_tab(
            'load_more_icon_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'load_more_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more__icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_icon_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more__icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_icon_bg_idle',
            [
                'label' => esc_html__('Icon Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_icon_bg_idle-dynamic',
            [
                'label' => esc_html__('Icon Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_icon_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'load_more_icon_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'load_more_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover .load_more__icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_icon_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_item:hover .load_more__icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_icon_bg_hover',
            [
                'label' => esc_html__('Icon Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover .load_more__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'load_more_icon_bg_hover-dynamic',
            [
                'label' => esc_html__('Icon Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['load_more_icon_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_item:hover .load_more__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> ADDITIONAL POST
         */

        $this->start_controls_section(
            'style_additional_item',
            [
                'label' => esc_html__('Additional Post', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['use_additional_post!' => ''],
            ]
        );

        $this->add_control(
            'additional_post_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'first' => esc_html__('First Item', 'burido-core'),
                    'last' => esc_html__('Last Item', 'burido-core'),
                ],
                'default' => 'last',
            ]
        );

        $this->add_control(
            'additional_post_link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'label_block' => false,
                'placeholder' => esc_attr__('https://your-link.com', 'burido-core'),
            ]
        );

        $this->add_control(
            'additional_post_img_heading',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'additional_post_img_media',
            [
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $this->add_control(
            'additional_post_btn_heading',
            [
                'label' => esc_html__('Button', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'additional_post_btn_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Coming Soon', 'burido-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'additional_post_btn',
                'selector' => '{{WRAPPER}} .additional-post .item__button',
            ]
        );

        $this->add_control(
            'additional_post_btn_align_h',
            [
                'label' => esc_html__('Horizontal Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .additional-post .item__wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'additional_post_btn_align_v',
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
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .additional-post .item__wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'additional_post_btn_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .additional-post .item__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'additional_post_btn_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .additional-post .item__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'additional_post_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .additional-post .item__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'additional_post_button',
                'selector' => '{{WRAPPER}} .additional-post .item__button',
            ]
        );

        $this->start_controls_tabs('additional_post_btn');

        $this->start_controls_tab(
            'addtnl_btn_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'addtnl_btn_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .additional-post .item__button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'addtnl_btn_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['addtnl_btn_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .additional-post .item__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'addtnl_btn_bg_idle',
                'selector' => '{{WRAPPER}} .additional-post .item__button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'addtnl_btn_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'addtnl_btn_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .additional-post .item__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'addtnl_btn_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['addtnl_btn_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .additional-post .item__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'addtnl_btn_bg_hover',
                'selector' => '{{WRAPPER}} .additional-post .item__button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CURSOR TOOLTIP
         */

        $this->start_controls_section(
            'pf_style_tooltip',
            [
                'label' => esc_html__('Cursor Tooltip', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['description_position' => 'pf_cursor_tooltip'],
            ]
        );
        $this->start_controls_tabs('pf_tabs_cursor');
        $this->start_controls_tab(
            'pf_tabs_cursor_title',
            ['label' => esc_html__('Title', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pf_tooltip_title',
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6',
            ]
        );
        $this->add_responsive_control(
            'pf_tooltip_title_width',
            [
                'label' => esc_html__('Min Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 500 ],
                ],
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pf_tooltip_title_alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => true,
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
                'default' => 'left',
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'pf_tooltip_title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'pf_tooltip_title_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pf_tooltip_title_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6',
            ]
        );
        $this->add_control(
            'pf_tooltip_title_color',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'pf_tooltip_title_bg',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip h6' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'pf_tabs_cursor_cats',
            ['label' => esc_html__('Category', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pf_tooltip_cats',
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats',
            ]
        );
        $this->add_responsive_control(
            'pf_tooltip_cats_width',
            [
                'label' => esc_html__('Min Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 500 ],
                ],
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pf_tooltip_cats_alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => true,
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
                'default' => 'left',
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'pf_tooltip_cats_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'pf_tooltip_cats_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pf_tooltip_cats_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats',
            ]
        );
        $this->add_control(
            'pf_tooltip_cats_color',
            [
                'label' => esc_html__('Category Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'pf_tooltip_cats_bg',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.portfolio-tooltip .post_cats' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        (new Portfolio_Template($atts, $this))->render($this);
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
