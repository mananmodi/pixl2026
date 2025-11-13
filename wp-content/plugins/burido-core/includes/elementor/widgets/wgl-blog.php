<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-blog.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow
};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Loop_Settings,
    Includes\WGL_Carousel_Settings,
    Templates\WGL_Blog as Blog_Template,
    Includes\WGL_Cursor
};

class WGL_Blog extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-blog';
    }

    public function get_title()
    {
        return esc_html__('WGL Blog', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-blog';
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    public function get_keywords() {
        return ['blog', 'posts'];
    }

    public function get_script_depends()
    {
        return [
            'swiper',
            'jarallax',
            'jarallax-video',
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
         * CONTENT -> LAYOUT
         */

        $this->start_controls_section(
            'section_content_layout',
            ['label' => esc_html__('Layout', 'burido-core')]
        );

        $this->add_control(
            'blog_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'blog_subtitle',
            [
                'label' => esc_html__('Subitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'separator' => 'after',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'blog_layout',
            [
                'label' => esc_html__('Layout', 'burido-core'),
                'type' => 'wgl-radio-image',
                'options' => [
                    'grid' => [
                        'title' => esc_html__('Grid', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_grid.png',
                    ],
                    'masonry' => [
                        'title' => esc_html__('Masonry', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
                    ],
                    'carousel' => [
                        'title' => esc_html__('Carousel', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/layout_carousel.png',
                    ],
                ],
                'default' => 'grid',
            ]
        );

        $this->add_responsive_control(
            'blog_columns',
            [
                'label' => esc_html__('Grid Columns Amount', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'render_type' => 'template',
                'frontend_available' => true,
                'options' => [
                    '1' => esc_html__('1 (one)', 'burido-core'),
                    '2' => esc_html__('2 (two)', 'burido-core'),
                    '3' => esc_html__('3 (three)', 'burido-core'),
                    '4' => esc_html__('4 (four)', 'burido-core'),
                    '5' => esc_html__('5 (five)', 'burido-core'),
                ],
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} .blog-style-standard' => '--posts-width: calc(100% / {{VALUE}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'col_gap',
            [
                'label' => esc_html__('Column Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-style-standard' => '--posts-col-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label' => esc_html__('Row Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-style-standard' => '--posts-row-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'label' => esc_html__('Image Size', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'separator' => 'before',
                'options' => [
                    '150' => esc_html__('Thumbnail - 150x150', 'burido-core'),
                    '300' => esc_html__('Medium - 300x300', 'burido-core'),
                    '768' => esc_html__('Medium Large - 768x768', 'burido-core'),
                    '1024' => esc_html__('Large - 1024x1024', 'burido-core'),
                    '766x520' => esc_html__('740x540 - 3 Columns', 'burido-core'),
                    '1140x950' => esc_html__('1140x950 - 2 Columns', 'burido-core'),
                    '1170x613' => esc_html__('1170x613 - 1 Column', 'burido-core'),
                    'full' => esc_html__('Full', 'burido-core'),
                    'custom' => esc_html__('Custom', 'burido-core'),
                ],
                'default' => '1170x613',
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
                'default' => [
                    'width' => '1170',
                    'height' => '700',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'img_size_string!' => 'custom',
                ],
                'options' => [
                    '' => esc_html__('No Crop', 'burido-core'),
                    '1:1' => esc_html__('1:1', 'burido-core'),
                    '3:2' => esc_html__('3:2', 'burido-core'),
                    '4:3' => esc_html__('4:3', 'burido-core'),
                    '6:5' => esc_html__('6:5', 'burido-core'),
                    '9:16' => esc_html__('9:16', 'burido-core'),
                    '16:9' => esc_html__('16:9', 'burido-core'),
                    '21:9' => esc_html__('21:9', 'burido-core'),
                    '10:7,1:1' => esc_html__('Chess Type ( 10:7 / 1:1 )', 'burido-core'),
                    '1:1,10:7' => esc_html__('Chess Type ( 1:1 / 10:7 )', 'burido-core'),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'navigation_type',
            [
                'label' => esc_html__('Navigation Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['blog_layout' => ['grid', 'masonry']],
                'separator' => 'before',
                'options' => [
                    'none' => esc_html__('None', 'burido-core'),
                    'pagination' => esc_html__('Pagination', 'burido-core'),
                    'load_more' => esc_html__('Load More', 'burido-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_responsive_control(
            'navigation_align',
            [
                'label' => esc_html__('Navigation\'s Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['navigation_type' => 'pagination'],
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
                'prefix_class' => 'nav-%s',
                'default' => 'left',
            ]
        );

        $this->add_control(
            'navigation_offset',
            [
                'label' => esc_html__('Navigation Margin Top', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'navigation_type' => 'pagination',
                    'blog_layout' => ['grid', 'masonry']
                ],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 240],
                ],
                'default' => ['size' => 40],
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
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry'],
                ],
                'min' => 1,
                'default' => 3,
            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry']
                ],
                'default' => esc_html__('Load More', 'burido-core'),
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
            'hide_media',
            [
                'label' => esc_html__('Hide Media?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'media_link',
            [
                'label' => esc_html__('Clickable Image?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_media' => ''],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hide_blog_title',
            [
                'label' => esc_html__('Hide Title?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_content',
            [
                'label' => esc_html__('Hide Content?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'content_letter_count',
            [
                'label' => esc_html__('Content Characters Amount', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'condition' => ['hide_content' => ''],
                'min' => 1,
                'default' => 170,
            ]
        );

        $this->add_control(
            'read_more_hide',
            [
                'label' => esc_html__('Hide \'Read More\' button?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Read More Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'condition' => ['read_more_hide' => ''],
                'default' => esc_html__('Read More', 'burido-core'),
            ]
        );

        $this->add_control(
            'hide_all_meta',
            [
                'label' => esc_html__('Hide all post meta?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'meta_author',
            [
                'label' => esc_html__('Hide author?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_comments',
            [
                'label' => esc_html__('Hide comments?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_categories',
            [
                'label' => esc_html__('Hide post-meta categories?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_date',
            [
                'label' => esc_html__('Hide post-meta date?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'hide_views',
            [
                'label' => esc_html__('Hide Views?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes',
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'hide_likes',
            [
                'label' => esc_html__('Hide Likes?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'hide_share',
            [
                'label' => esc_html__('Hide Shares?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->end_controls_section();

        WGL_Cursor::init(
            $this,
            [
                'section' => true,
            ]
        );

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        $this->start_controls_section(
            'content_carousel',
            [
                'label' => esc_html__('Carousel Options', 'burido-core'),
                'condition' => ['blog_layout' => 'carousel']
            ]
        );

        WGL_Carousel_Settings::add_general_controls($this);

        $this->add_control(
            'pagination_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['use_pagination' => 'yes'],
            ]
        );

        WGL_Carousel_Settings::add_pagination_controls($this, [
            'pagination_margin' => [
                'default' => [
                    'top' => '-35',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
            ]
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

        WGL_Carousel_Settings::add_responsive_controls($this);

        $this->end_controls_section();

        /**
         * SETTINGS -> QUERY
         */

        WGL_Loop_Settings::add_controls(
            $this,
            ['post_type' => 'post']
        );

        /**
         * STYLE -> POST ITEM
         */

        $this->start_controls_section(
            'section_style_post_item',
            [
                'label' => esc_html__('Post Item', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_wrapper_padding',
            [
                'label' => esc_html__('Content Section Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_wrapper .blog-post_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item',
                'selector' => '{{WRAPPER}} .blog-post_wrapper',
            ]
        );

        $this->add_control(
            'item_bg',
            [
                'label' => esc_html__('Add Item Background', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'label' => esc_html__('Background', 'burido-core'),
                'condition' => ['item_bg' => 'yes'],
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .blog-post_wrapper',
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
                'condition' => ['blog_title!' => ''],
            ]
        );

        $this->add_control(
            'heading_blog_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_title',
                'selector' => '{{WRAPPER}} .blog_title',
            ]
        );

        $this->add_control(
            'blog_title_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'blog_title_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['blog_title_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .blog_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'blog_title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .blog_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_blog_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_subtitle',
                'selector' => '{{WRAPPER}} .blog_subtitle',
            ]
        );

        $this->add_control(
            'blog_subtitle_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'blog_subtitle_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['blog_subtitle_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .blog_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'blog_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .blog_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_blog_headings',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .blog-post_title,'
                            . '{{WRAPPER}} .blog-post_title > a',
            ]
        );

        $this->add_control(
            'heading_tag',
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
                ],
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('headings');

        $this->start_controls_tab(
            'tab_headings_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'headings_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title a,
                     {{WRAPPER}} .blog-post_quote-text,
                     {{WRAPPER}} .link_post' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .blog-post_title a,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .blog-post_quote-text,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .link_post' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_headings_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'headings_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title a:hover' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .blog-post_title a:hover' => 'color: {{VALUE}};',
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
                'condition' => ['hide_content' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content',
                'selector' => '{{WRAPPER}} .blog-post_text',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_text, {{WRAPPER}} .blog-post_quote-author-name' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blog-post.format-no_featured' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['content_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .blog-post_text,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .blog-post_quote-author-name' => 'color: {{VALUE}};',
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .blog-post.format-no_featured' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> META DATA
         */

        $this->start_controls_section(
            'style_meta_data',
            [
                'label' => esc_html__('Meta Data', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'hide_all_meta',
                            'operator' => '==',
                            'value' => ''
                        ],
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'meta_author',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_comments',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_categories',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_date',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_data',
                'selector' => '{{WRAPPER}} .meta-data',
            ]
        );

        $this->add_responsive_control(
            'meta_data_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_wrapper .post_meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_data_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_wrapper .post_meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_meta_data',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_meta_data_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'meta_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .meta-data' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'meta_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['meta_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .meta-data' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_meta_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'meta_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .meta-data a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'meta_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['meta_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .meta-data a:hover' => 'color: {{VALUE}};',
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
                'condition' => ['hide_media' => ''],
            ]
        );


        $this->add_control(
            'image_scale_animation',
            [
                'label' => esc_html__( 'Image Hover Scale Animation', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
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
                    '{{WRAPPER}} .blog-post_media' => '--wgl-blog-image-scale-size: {{SIZE}};',
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
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_media' => '--wgl-blog-image-transition: {{SIZE}}s',
                ],
            ]
        );

        $this->add_control(
            'media_overlay_idle',
            [
                'label' => esc_html__('Image Overlay Idle', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .format-standard-image .image-overlay::before' => 'content: \'\'',
                    '{{WRAPPER}} .format-image .image-overlay::before' => 'content: \'\'',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_idle',
                'label' => esc_html__('Background', 'burido-core'),
                'condition' => ['media_overlay_idle!' => ''],
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .image-overlay::before',
            ]
        );

        $this->add_control(
            'media_overlay_hover',
            [
                'label' => esc_html__('Image Hover Overlay', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .format-standard-image .image-overlay::after' => 'content: \'\'',
                    '{{WRAPPER}} .format-image .image-overlay::after' => 'content: \'\'',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_hover',
                'label' => esc_html__('Background', 'burido-core'),
                'condition' => ['media_overlay_hover!' => ''],
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .image-overlay::after',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> READ MORE
         */

        $this->start_controls_section(
            'section_style_read_more',
            [
                'label' => esc_html__('Read More', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['read_more_hide' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more',
                'selector' => '{{WRAPPER}} .button-read-more',
            ]
        );

        $this->add_responsive_control(
            'read_more_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'read_more_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .button-read-more',
            ]
        );

        $this->start_controls_tabs(
            'tabs_read_more',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_read_more_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'read_more_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'read_more_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['read_more_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .button-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more::after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'read_more_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['read_more_icon_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .button-read-more::after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'read_more_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'read_more_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'read_more_border_border!' => ['', 'none'],
                    'read_more_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .button-read-more' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_read_more_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'read_more_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'read_more_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['read_more_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .button-read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:hover::after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'read_more_icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['read_more_icon_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .button-read-more:hover::after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'read_more_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'read_more_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'read_more_border_border!' => ['', 'none'],
                    'read_more_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .button-read-more:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> LOAD MORE
         */

        $this->start_controls_section(
            'style_load_more',
            [
                'label' => esc_html__('Load More', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry'],
                ],
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
                'separator' => 'before',
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '22',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
	                'unit' => 'px',
	                'isLinked' => false
                ],
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
                'separator' => 'after',
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'load_more_btn',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'load_more_idle',
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

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow_idle',
                'selector' => '{{WRAPPER}} .load_more_item',
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
                    '{{WRAPPER}} .load_more_item:hover' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .load_more_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow_hover',
                'selector' => '{{WRAPPER}} .load_more_item:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

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
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'load_more_media_icon',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'condition' => ['load_more_media_type' => 'icon'],
            ]
        );

        $this->add_responsive_control(
            'load_more_icon_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['load_more_media_type' => 'icon'],
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
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
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
                'label' => esc_html__('Background Color', 'burido-core'),
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
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
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
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
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
                'label' => esc_html__('Background Color', 'burido-core'),
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
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
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
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        (new Blog_Template())->render($this, $atts);
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
