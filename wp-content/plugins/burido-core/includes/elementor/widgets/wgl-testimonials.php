<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-testimonials.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Utils,
    Repeater,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography,
    Group_Control_Background
};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Carousel_Settings,
    Includes\WGL_Cursor,
    Templates\WGL_Testimonials as Testimonials_Template
};

class WGL_Testimonials extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-testimonials';
    }

    public function get_title()
    {
        return esc_html__('WGL Testimonials', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-testimonials';
    }

    public function get_keywords()
    {
        return [ 'testimonials', 'carousel', 'slider' ];
    }

    public function get_script_depends()
    {
        return ['swiper'];
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
            'content_general',
            ['label' => esc_html__('General', 'burido-core')]
        );

        $this->add_control(
            'posts_per_row',
            [
                'label' => esc_html__('Grid Columns Amount', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1 (one)', 'burido-core'),
                    '2' => esc_html__('2 (two)', 'burido-core'),
                    '3' => esc_html__('3 (three)', 'burido-core'),
                    '4' => esc_html__('4 (four)', 'burido-core'),
                    '5' => esc_html__('5 (five)', 'burido-core'),
                ],
                'default' => '2',
            ]
        );

        $repeater = new Repeater();

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
            'author_name',
            [
                'label' => esc_html__('Author Name', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'link_author',
            [
                'label' => esc_html__('Link Author', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'author_position',
            [
                'label' => esc_html__('Author Position', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_html__('Your Title', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_html__('Your Subtitle', 'burido-core'),
            ]
        );

        $repeater->add_control(
            'quote_rating',
            [
                'label' => esc_html__( 'Rating', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'None', 'burido-core' ),
                    1 => esc_html__( '1 star', 'burido-core' ),
                    2 => esc_html__( '2 stars', 'burido-core' ),
                    3 => esc_html__( '3 stars', 'burido-core' ),
                    4 => esc_html__( '4 stars', 'burido-core' ),
                    5 => esc_html__( '5 stars', 'burido-core' ),
                ],
                'default' => '',
            ]
        );

        $repeater->add_control(
            'quote',
            [
                'label' => esc_html__('Quote', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_html__('"Lorem ipsum dolor sit amet, consectetur adipisicing elit."', 'burido-core'),
                'default' => esc_html__('"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec molestie erat felis, scelerisque consequat sapien placerat eu."', 'burido-core'),
            ]
        );

        WGL_Cursor::init(
            $repeater,
            [
                'section' => false,
                'repeater' => true,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'author_name' => esc_html__('Garold Luiss', 'burido-core'),
                        'author_position' => esc_html__('Developer', 'burido-core'),
                    ],
                    [
                        'author_name' => esc_html__('Christina Grant', 'burido-core'),
                        'author_position' => esc_html__('Designer', 'burido-core'),
                    ],
                    [
                        'author_name' => esc_html__('Steve Kavel', 'burido-core'),
                        'author_position' => esc_html__('Manager', 'burido-core'),
                    ],
                    [
                        'author_name' => esc_html__('Tina Moore', 'burido-core'),
                        'author_position' => esc_html__('Manager', 'burido-core'),
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ author_name }}}',
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'burido-core'),
                'type' => 'wgl-radio-image',
                'options' => [
                    'top_block' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_1.png',
                    ],
                    'bottom_block' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_4.png',
                    ],
                    'top_inline' => [
                        'title' => esc_html__('Top Inline', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_2.png',
                    ],
                    'bottom_inline' => [
                        'title' => esc_html__('Bottom Inline', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_3.png',
                    ],
                    'left_block' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_5.png',
                    ],
                ],
                'default' => 'top_inline',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
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

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Enable Hover Animation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Lift up the item on hover.', 'burido-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        WGL_Carousel_Settings::add_controls($this, [
            'use_carousel' => [ 'default' => 'yes' ],
            'use_navigation' => [ 'default' => 'yes' ],
            'use_pagination' => [ 'default' => '' ],
            '3d_animation_options' => 'enabled',
            'animation_style' => [ 'default' => 'default' ],
            'slide_per_single' => [ 'default' => 'yes' ],
            'pagination_margin' => [ 'default' => [
                'top' => '60',
                'right' => '0',
                'bottom' => '0',
                'left' => '0',
                'unit' => 'px',
                'isLinked' => false
            ], ],
            'navigation_position' => [ 'default' => 'nearby' ],
            'navigation_alignment_h' => [ 'default' => 'center' ],
            'navigation_alignment_v' => [ 'default' => 'flex-end' ],
            'navigation_margin' => [
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '-80',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '-40',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
            ],
        ]);

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
            'item_gap',
            [
                'label' => esc_html__('Items Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [ 'px' => ['min' => 0, 'max' => 100] ],
                'size_units' => ['px', 'custom'],
                'default' => ['size' => 10, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials' => '--wgl-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'custom'],
                'allowed_dimensions' => 'vertical',
                'selectors' => [
                    '{{WRAPPER}} .testimonial__item' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .testimonial__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .testimonial__item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .testimonial__item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}} .testimonial__item',
            ]
        );

        $this->add_control(
            'item_blur',
            [
                'label' => esc_html__('Background Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial__item' => 'backdrop-filter: blur({{SIZE}}px);-webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );

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
                'selector' => '{{WRAPPER}} .item__title',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title tag', 'burido-core'),
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
            'title_width',
            [
                'label' => esc_html__('Title Wrapper Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 1200 ],
                    '%' => ['min' => 5, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .item__title' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'right' => '0',
                    'bottom' => '15',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .item__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .item__title',
            ]
        );

        $this->add_responsive_control(
            'title_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['title_icon_enabled!' => ''],
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .item__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .item__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Title Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .item__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_color-dynamic',
            [
                'label' => esc_html__('Title Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .item__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'style_title_icon',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_icon_enabled',
            [
                'label' => esc_html__('Use Icon', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .testimonial__item .item__icon' => 'display: inline-flex;'
                ],
            ]
        );
        $this->add_control(
            'title_icon_display',
            [
                'label' => esc_html__( 'Display', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'render_type' => 'template',
                'condition' => ['title_icon_enabled!' => ''],
                'options' => [
                    'content' => esc_html__( 'With Content', 'burido-core' ),
                    'block' => esc_html__( 'Top', 'burido-core' ),
                ],
                'default' => 'content',
            ]
        );
	    $this->add_responsive_control(
		    'title_icon_size',
		    [
			    'label' => esc_html__('Icon Size', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_icon_enabled!' => ''],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 200],
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .testimonial__item .item__icon' => 'font-size: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['title_icon_enabled!' => ''],
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial__item .item__icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
		    'icon_padding',
		    [
			    'label' => esc_html__('Padding', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'condition' => ['title_icon_enabled!' => ''],
			    'size_units' => ['px', 'em', '%', 'custom'],
			    'selectors' => [
				    '{{WRAPPER}} .testimonial__item .item__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'icon_radius',
		    [
			    'label' => esc_html__('Border Radius', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'condition' => ['title_icon_enabled!' => ''],
			    'size_units' => ['px', 'em', '%', 'custom'],
			    'selectors' => [
				    '{{WRAPPER}} .testimonial__item .item__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'title_icon_color',
		    [
			    'label' => esc_html__('Icon Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_icon_enabled!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .testimonial__item .item__icon' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_icon_color-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_icon_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonial__item .item__icon' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'title_icon_bg',
		    [
			    'label' => esc_html__('Background Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_icon_enabled!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .testimonial__item .item__icon' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_icon_bg-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_icon_bg!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonial__item .item__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> QUOTE
         */

        $this->start_controls_section(
            'style_quote',
            [
                'label' => esc_html__('Quote', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_quote',
                'selector' => '{{WRAPPER}} .item__quote',
            ]
        );

        $this->add_control(
            'quote_tag',
            [
                'label' => esc_html__('Quote tag', 'burido-core'),
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
                'default' => 'div',
            ]
        );

        $this->add_responsive_control(
            'quote_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'quote_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'quote_border',
                'fields_options' => [
                    'border' => [ 'default' => '' ],
                    'color' => [
                        'label' => esc_html__( 'Border Color', 'burido-core' ),
                        'default' => WGL_Globals::get_secondary_color(0.15),
                    ],
                ],
                'selector' => '{{WRAPPER}} .item__quote',
            ]
        );

        $this->add_responsive_control(
            'quote_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__quote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'quote_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .item__quote' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'quote_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['quote_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .item__quote' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'quote_bg',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .item__quote' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'quote_bg-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['quote_bg!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .item__quote' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> AUTHOR BLOCK
         */

        $this->start_controls_section(
            'style_author',
            [
                'label' => esc_html__('Author Block', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'author_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> AUTHOR THUMBNAIL
         */

        $this->start_controls_section(
            'style_thumnail',
            [
                'label' => esc_html__('Author Thumbnail', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'frontend_available' => true,
                'range' => [
                    'px' => ['min' => 20, 'max' => 400],
                ],
                'default' => ['size' => 100],
	            'selectors' => [
		            '{{WRAPPER}} .author__thumbnail' => '--image-width: {{SIZE}};',
	            ],
            ]
        );
        $this->add_responsive_control(
            'image_not_active_size',
            [
                'label' => esc_html__('Not Active Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 20, 'max' => 400],
                ],
	            'selectors' => [
		            '{{WRAPPER}} .author__thumbnail' => '--image-not-active-width: {{SIZE}};',
	            ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .author__thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
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
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .author__thumbnail,
                     {{WRAPPER}} .author__thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .author__thumbnail',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonials_image_shadow',
                'selector' => '{{WRAPPER}} .author__thumbnail',
            ]
        );

        $this->start_controls_tabs('image_tabs');

        $this->start_controls_tab(
            'tab_image_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'image_bg_color_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .author__thumbnail' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__thumbnail' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'image_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .author__thumbnail' => 'border-color: {{VALUE}};',
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
                'condition' => [
                    'image_border_border!' => ['', 'none'],
                    'image_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__thumbnail' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'testimonials_triangle_color_idle',
            [
                'label' => esc_html__( 'Triangle Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'testimonials_triangle_enabled!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .author__thumbnail::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'testimonials_triangle_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'testimonials_triangle_enabled!' => '',
                    'testimonials_triangle_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__thumbnail::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_image_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'image_bg_color_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .testimonials__wrapper:hover .author__thumbnail,
                     {{WRAPPER}} .swiper-slide.swiper-slide-active .author__thumbnail' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonials__wrapper:hover .author__thumbnail,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .swiper-slide.swiper-slide-active .author__thumbnail' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'image_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials__wrapper:hover .author__thumbnail,
                     {{WRAPPER}} .swiper-slide.swiper-slide-active .author__thumbnail' => 'border-color: {{VALUE}};',
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
                'condition' => [
                    'image_border_border!' => ['', 'none'],
                    'image_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonials__wrapper:hover .author__thumbnail,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .swiper-slide.swiper-slide-active .author__thumbnail' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> AUTHOR NAME
         */

        $this->start_controls_section(
            'style_name',
            [
                'label' => esc_html__('Author Name', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_tag',
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
                'default' => 'h3',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_name',
                'selector' => '{{WRAPPER}} .author__name',
            ]
        );

        $this->add_responsive_control(
            'name_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .author__name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('name_colors');
        $this->start_controls_tab(
            'tab_name_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'name_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .author__name' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'name_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['name_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__name' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_name_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'name_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .author__name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'name_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['name_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> AUTHOR POSITION
         */

        $this->start_controls_section(
            'style_position',
            [
                'label' => esc_html__('Author Position', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_position',
                'selector' => '{{WRAPPER}} .author__position',
            ]
        );
        $this->add_control(
            'position_tag',
            [
                'label' => esc_html__('HTML tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'span',
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
            ]
        );
        $this->add_responsive_control(
            'position_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .author__position_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'position_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .author__position' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'position_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .author__position' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'position_border',
                'selector' => '{{WRAPPER}} .author__position',
            ]
        );

        $this->start_controls_tabs('position_tabs');
        $this->start_controls_tab(
            'position_tab_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'position_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .author__position' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['position_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__position' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .author__position' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_bg_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['position_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__position' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'position_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .author__position' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'position_border_border!' => ['', 'none'],
                    'position_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .author__position' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'position_tab_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'position_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .testimonials__wrapper:hover .author__position' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['position_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonials__wrapper:hover .author__position' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .testimonials__wrapper:hover .author__position' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['position_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonials__wrapper:hover .author__position' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'position_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials__wrapper:hover .author__position' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'position_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'position_border_border!' => ['', 'none'],
                    'position_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonials__wrapper:hover .author__position' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> AUTHOR SUBTITLE
         */

        $this->start_controls_section(
            'style_subtitle',
            [
                'label' => esc_html__('Author Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_subtitle',
                'selector' => '{{WRAPPER}} .item__subtitle',
            ]
        );
        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .item__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('subtitle_tabs');
        $this->start_controls_tab(
            'subtitle_tab_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .item__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .item__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'subtitle_tab_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .testimonials__wrapper:hover .item__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .testimonials__wrapper:hover .item__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> RATING */

        $this->start_controls_section(
            'style_rating',
            [
                'label' => esc_html__( 'Rating', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rating_typography',
                'exclude' => [ 'font_family', 'text_transform', 'font_style', 'text_decoration', 'line_height' ],
                'selector' => '{{WRAPPER}} .item__rating',
            ]
        );
        $this->add_responsive_control(
            'rating_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .item__rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'rating_filled_color',
            [
                'label' => esc_html__( 'Filled Stars Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .item__rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'rating_filled_color-dynamic',
            [
                'label' => esc_html__('Filled Stars Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['rating_filled_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .item__rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'rating_empty_color',
            [
                'label' => esc_html__( 'Empty Stars Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .item__rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'rating_empty_color-dynamic',
            [
                'label' => esc_html__('Empty Stars Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['rating_empty_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .item__rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        (new Testimonials_Template())->render(
            $this,
            $this->get_settings_for_display()
        );
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
