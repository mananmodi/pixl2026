<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-products-grid.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
	Group_Control_Border,
	Widget_Base,
	Controls_Manager,
	Group_Control_Typography,
	Group_Control_Box_Shadow
};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Loop_Settings,
    Includes\WGL_Carousel_Settings,
    Templates\WGLProductsGrid
};

class WGL_Products_Grid extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-products-grid';
    }

    public function get_keywords() {
        return ['products', 'shop', 'woocommerce'];
    }

    public function get_title()
    {
        return esc_html__('WGL Products Grid', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-products-grid';
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    public function get_script_depends()
    {
        return ['jquery-appear', 'swiper'];
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

        $this->add_control(
            'products_layout',
            [
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
            'grid_columns',
            [
                'label' => esc_html__('Grid Columns Amount', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'render_type' => 'template',
                'options' => [
                    '1' => esc_html__('1 (one)', 'burido-core'),
                    '2' => esc_html__('2 (two)', 'burido-core'),
                    '3' => esc_html__('3 (three)', 'burido-core'),
                    '4' => esc_html__('4 (four)', 'burido-core'),
                    '5' => esc_html__('5 (five)', 'burido-core'),
                    '6' => esc_html__('6 (six)', 'burido-core'),
                ],
                'default' => '4',
                'prefix_class' => 'columns%s-'
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Size', 'burido-core'),
                'options' => [
                    '150' => 'Thumbnail - 150x150',
                    '300' => 'Medium - 300x300',
                    '768' => 'Medium Large - 768x768',
                    '1024' => 'Large - 1024x1024',
                    '540x520' => '540x520',
                    'full' => 'Full',
                    'custom' => 'Custom',
	                '' => 'Default Woo Size',
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'burido-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'description' => esc_html__('You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'burido-core'),
                'condition' => [
                    'img_size_string' => 'custom',
                ],
                'default' => [
                    'width' => '540',
                    'height' => '600',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Aspect Ratio', 'burido-core'),
                'options' => [
                    '1:1' => esc_html__('1:1', 'burido-core'),
                    '3:2' => esc_html__('3:2', 'burido-core'),
                    '4:3' => esc_html__('4:3', 'burido-core'),
                    '6:5' => esc_html__('6:5', 'burido-core'),
                    '9:16' => esc_html__('9:16', 'burido-core'),
                    '16:9' => esc_html__('16:9', 'burido-core'),
                    '21:9' => esc_html__('21:9', 'burido-core'),
                    '' => esc_html__('No Crop', 'burido-core'),
                ],
	            'condition' => [
		            'img_size_string!' => '',
	            ],
                'default' => '',
            ]
        );

        $this->add_control(
            'hide_stars',
            array(
                'label' => esc_html__('Hide Stars', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .star-rating' => 'display: none;',
                ],
            )
        );

        $this->add_control(
            'show_header_products',
            array(
                'label' => esc_html__('Show Header Shop', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'show_res_count',
            array(
                'label' => esc_html__('Show Result Count', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
	            'condition' => [ 'show_header_products' => 'yes' ],
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'yes',
	            'default' => 'yes',
            )
        );

        $this->add_control(
            'show_sorting',
            array(
                'label' => esc_html__('Show Default Sorting', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
	            'condition' => [ 'show_header_products' => 'yes' ],
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'yes',
	            'default' => 'yes',
            )
        );

        $this->add_control(
            'isotope_filter',
            [
                'label' => esc_html__('Use Filter?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['products_layout!' => 'carousel'],
            ]
        );

	    $this->add_control(
		    'filter_counter_enabled',
		    [
			    'label' => esc_html__('Show Number of Categories', 'burido-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'condition' => ['isotope_filter' => 'yes'],
		    ]
	    );

	    $this->add_control(
		    'filter_max_width_enabled',
		    [
			    'label' => esc_html__('Limit the Filter Container Width', 'burido-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'condition' => ['isotope_filter' => 'yes'],
		    ]
	    );

	    $this->add_control(
		    'max_width_filter',
		    [
			    'label' => esc_html__('Filter Container Max Width (px)', 'burido-core'),
			    'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
			    'condition' => [
				    'isotope_filter' => 'yes',
				    'filter_max_width_enabled' => 'yes',
			    ],
			    'default' => '1170',
			    'selectors' => [
				    '{{WRAPPER}} .wgl-filter_wrapper.isotope-filter' => 'width: min(100%, {{VALUE}}px);',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'filter_alignment',
		    [
			    'label' => esc_html__('Filter Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'condition' => ['isotope_filter' => 'yes'],
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
            'products_navigation',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Navigation', 'burido-core'),
	            'condition' => ['products_layout!' => 'carousel'],
                'options' => [
                    '' => 'None',
                    'pagination' => 'Pagination',
                    'load_more' => 'Load More',
                ],
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'navigation_align',
            [
                'label' => esc_html__('Navigation\'s Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['products_navigation' => 'pagination'],
                'render_type' => 'template',
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
                    'products_navigation' => 'pagination',
                    'products_layout' => ['grid', 'masonry']
                ],
                'size_units' => ['px', 'em', 'rem'],
                'default' => ['size' => 44],
                'range' => [
                    'px' => ['min' => 0, 'max' => 240],
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
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'products_navigation' => 'load_more',
                    'products_layout!' => 'carousel'
                ],
                'default' => esc_html__('4', 'burido-core'),
            ]
        );

        $this->add_control(
            'name_load_more',
            array(
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
	            'default' => esc_html__('More Products', 'burido-core'),
                'condition' => [
                    'products_navigation' => 'load_more',
                    'products_layout!' => 'carousel'
                ],
            )
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        $this->start_controls_section(
            'section_content_carousel',
            [
                'label' => esc_html__('Carousel Options', 'burido-core'),
                'condition' => ['products_layout' => 'carousel']
            ]
        );

        WGL_Carousel_Settings::add_general_controls($this);

        $this->add_control(
            'pagination_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['use_pagination!' => ''],
            ]
        );

        WGL_Carousel_Settings::add_pagination_controls($this, [
            'use_pagination' => [
                'default' => 'yes',
            ],
            'pagination_margin' => [
                'default' => [
                    'top' => '47',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
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

        WGL_Carousel_Settings::add_responsive_controls($this);

        $this->end_controls_section();

        /**
         * SETTINGS -> QUERY
         */

        WGL_Loop_Settings::add_controls($this, [
            'post_type' => 'product',
            'hide_tags' => true,
            'hide_cats' => true,
        ]);

	    /**
	     * STYLE -> FILTER
	     */

	    $this->start_controls_section(
		    'style_filter',
		    [
			    'label' => esc_html__('Filter', 'burido-core'),
			    'tab' => Controls_Manager::TAB_STYLE,
			    'condition' => ['isotope_filter' => 'yes'],
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

        $this->add_control(
            'filter_counter_animation_idle',
            [
                'label' => esc_html__('Animation Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['filter_counter_enabled' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a .cat_title::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_counter_animation_idle-dynamic',
            [
                'label' => esc_html__('Animation Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'filter_counter_enabled' => 'yes',
                    'filter_counter_animation_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a .cat_title::before' => 'color: {{VALUE}};',
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
                'condition' => ['filter_counter_color_hover!' => ''],
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
            'filter_extra_element_color_active',
            [
                'label' => esc_html__('Animated Element Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_extra_element_color_active-dynamic',
            [
                'label' => esc_html__('Animated Element Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['filter_extra_element_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .isotope-filter a::after' => 'background-color: {{VALUE}};',
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

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('General', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'products_gap',
            [
                'label' => esc_html__('Products Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 60, 'step' => 2],
                ],
	            'devices' => [ 'desktop', 'tablet', 'mobile' ],
	            'default' => [ 'size' => '30' ],
                'tablet_default' => ['size' => '30'],
                'mobile_default' => ['size' => '20'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-products' => '--products-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Product Inner Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .woo_product_inner_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__('Product Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .woo_product_inner_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_item');

        $this->start_controls_tab(
            'tab_item_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'item_bg_color_idle',
            [
                'label' => esc_html__('Item Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woo_product_inner_wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'item_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Item Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['item_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .woo_product_inner_wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_idle',
                'selector' => '{{WRAPPER}} .woo_product_inner_wrapper',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'item_bg_color_hover',
            [
                'label' => esc_html__('Item Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product:hover .woo_product_inner_wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'item_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Item Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['item_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product:hover .woo_product_inner_wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_hover',
                'selector' => '{{WRAPPER}} .product:hover .woo_product_inner_wrapper',
            ]
        );

	    $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'burido-core'),
                'separator' => 'before',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .woo_product_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_radius',
            [
                'label' => esc_html__('Content Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .woo_product_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                'condition' => ['products_title!' => ''],
            ]
        );

        $this->add_control(
            'heading_products_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_title',
                'selector' => '{{WRAPPER}} .products_title',
            ]
        );

        $this->add_control(
            'heading_products_title_color',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .products_title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_products_title_color-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_products_title_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .products_title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'products_title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_products_subtitle',
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
                'selector' => '{{WRAPPER}} .products_subtitle',
            ]
        );

        $this->add_control(
            'heading_products_subtitle_color',
            [
                'label' => esc_html__('Subtitle Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .products_subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_products_subtitle_color-dynamic',
            [
                'label' => esc_html__('Subtitle Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['heading_products_subtitle_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .products_subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'products_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> STARS
         */

        $this->start_controls_section(
            'section_style_stars',
            [
                'label' => esc_html__('Stars', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'hide_stars!' => 'yes' ],
            ]
        );
        $this->add_responsive_control(
            'stars_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_stars');
        $this->start_controls_tab(
            'tab_stars_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'stars_primary_color_idle',
            [
                'label' => esc_html__('Stars Primary Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'stars_primary_color_idle-dynamic',
            [
                'label' => esc_html__('Stars Primary Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['stars_primary_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'stars_secondary_color_idle',
            [
                'label' => esc_html__('Stars Secondary Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'stars_secondary_color_idle-dynamic',
            [
                'label' => esc_html__('Stars Secondary Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['stars_secondary_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_stars_hover',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'stars_primary_color_hover',
            [
                'label' => esc_html__('Stars Primary Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product:hover .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'stars_primary_color_hover-dynamic',
            [
                'label' => esc_html__('Stars Primary Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['stars_primary_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product:hover .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'stars_secondary_color_hover',
            [
                'label' => esc_html__('Stars Secondary Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product:hover .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'stars_secondary_color_hover-dynamic',
            [
                'label' => esc_html__('Stars Secondary Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['stars_secondary_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product:hover .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

	    $this->add_responsive_control(
		    'image_width',
		    [
			    'label' => esc_html__('Image Max Width', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => ['px', '%', 'custom'],
			    'range' => [
				    'px' => ['min' => 50, 'max' => 500 ],
				    '%' => ['min' => 10, 'max' => 100 ],
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .product .woo_product_image' => 'max-width: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'image_margin',
		    [
			    'label' => esc_html__( 'Margin', 'burido-core' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%', 'custom' ],
			    'selectors' => [
				    '{{WRAPPER}} .product .picture' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );
	    $this->add_responsive_control(
		    'image_padding',
		    [
			    'label' => esc_html__( 'Padding', 'burido-core' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%', 'custom' ],
			    'selectors' => [
				    '{{WRAPPER}} .product .picture' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .product .picture::before',
            ]
        );
        $this->add_control(
            'secondary_image',
            [
                'label' => esc_html__('Show Secondary Image on Hover', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .product .picture img ~ img' => 'display: block;',
                ],
            ]
        );

        $this->add_control(
            'image_overlay_color',
            [
                'label' => esc_html__('Image Overlay Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product .picture' => '--burido-shop-products-overlay: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_overlay_color-dynamic',
            [
                'label' => esc_html__('Image Overlay Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_overlay_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product .picture' => '--burido-shop-products-overlay: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_image');
        $this->start_controls_tab(
            'tab_image_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'image_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .product .picture' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .product .picture::before' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product .picture::before' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_idle',
                'selector' => '{{WRAPPER}} .product .picture::before',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_image_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'image_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .product:hover .picture' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .product:hover .picture::before' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product:hover .picture::before' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_hover',
                'selector' => '{{WRAPPER}} .product:hover .picture::before',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> TITLE
         */

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
                'name' => 'title',
                'selector' => '{{WRAPPER}} .woocommerce-loop-product__title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_title');
        $this->start_controls_tab(
            'tab_title_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__title' => 'color: {{VALUE}};',
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
                'condition' => ['title_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .woocommerce-loop-product__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_title_item_hover',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'htitle_color_item_hover',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product:hover .woocommerce-loop-product__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'htitle_color_item_hover-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['htitle_color_item_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product:hover .woocommerce-loop-product__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_title_hover',
            ['label' => esc_html__('Title Hover', 'burido-core')]
        );
        $this->add_control(
            'htitle_color_hover',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product .woocommerce-loop-product__title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'htitle_color_hover-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['htitle_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product .woocommerce-loop-product__title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> PRICE
         */

        $this->start_controls_section(
            'section_style_price',
            [
                'label' => esc_html__('Price', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price',
                'selector' => '{{WRAPPER}} .wgl-products .price',
            ]
        );

        $this->add_responsive_control(
            'price_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-products .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_price');

        $this->start_controls_tab(
            'tab_price_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'price_color_idle',
            [
                'label' => esc_html__('Price Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-products .product' => '--burido-price-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'price_color_idle-dynamic',
            [
                'label' => esc_html__('Price Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['price_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-products .product' => '--burido-price-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'old_price_color_idle',
            [
                'label' => esc_html__('Old Price Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-products .product' => '--burido-price-del-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'old_price_color_idle-dynamic',
            [
                'label' => esc_html__('Old Price Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['old_price_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-products .product' => '--burido-price-del-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_price_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'price_color_hover',
            [
                'label' => esc_html__('Price Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-products .product:hover' => '--burido-price-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'price_color_hover-dynamic',
            [
                'label' => esc_html__('Price Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['price_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-products .product:hover' => '--burido-price-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'old_price_color_hover',
            [
                'label' => esc_html__('Old Price Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-products .product:hover' => '--burido-price-del-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'old_price_color_hover-dynamic',
            [
                'label' => esc_html__('Old Price Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['old_price_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-products .product:hover' => '--burido-price-del-color: {{VALUE}};',
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
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button',
                'selector' => '{{WRAPPER}} .product a.button',
            ]
        );

        $this->add_control(
            'button_width',
            [
                'label' => esc_html__('Min Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 400],
                    '%' => ['min' => 10, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product a.button,
				     {{WRAPPER}} .product a.wc-forward' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .product a.button,
				     {{WRAPPER}} .product a.wc-forward' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .product a.button,
				     {{WRAPPER}} .product a.wc-forward',
            ]
        );

        $this->add_control(
            'button_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .product a.button,
				     {{WRAPPER}} .product a.wc-forward' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button');
        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Button Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .product a.button,
				     {{WRAPPER}} .product a.wc-forward' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_idle-dynamic',
            [
                'label' => esc_html__('Button Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .product a.button::before,
				     {{WRAPPER}} .product a.wc-forward::before' => 'color: {{VALUE}};',
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
                'condition' => ['button_icon_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button::before,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_color_idle',
            [
                'label' => esc_html__('Button Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product a.button,
				     {{WRAPPER}} .product a.wc-forward' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Button Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'button_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .product a.button,
				     {{WRAPPER}} .product a.wc-forward' => 'border-color: {{VALUE}};',
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
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward' => 'border-color: {{VALUE}};',
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
                'label' => esc_html__('Button Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .product a.button.added,
                     {{WRAPPER}} .product a.button:hover,
				     {{WRAPPER}} .product a.wc-forward:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_hover-dynamic',
            [
                'label' => esc_html__('Button Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button.added,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button:hover,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .product a.button.added::before,
                     {{WRAPPER}} .product a.button::before,
                     {{WRAPPER}} .product a.wc-forward::before' => 'transition: .4s;',
                    '{{WRAPPER}} .product a.button.added::before,
                     {{WRAPPER}} .product a.button:hover::before,
                     {{WRAPPER}} .product a.wc-forward:hover::before' => 'color: {{VALUE}};',
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
                'condition' => ['button_icon_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button.added::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button:hover::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward:hover::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__('Button Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .product a.button.added,
                     {{WRAPPER}} .product a.button:hover,
				     {{WRAPPER}} .product a.wc-forward:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Button Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button.added,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button:hover,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'button_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .product a.button.added,
                     {{WRAPPER}} .product a.button:hover,
				     {{WRAPPER}} .product a.wc-forward:hover' => 'border-color: {{VALUE}};',
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
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button.added,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.button:hover,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .product a.wc-forward:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> LOAD MORE BUTTON
         */

        $this->start_controls_section(
            'style_load_more',
            [
                'label' => esc_html__('Load More Button', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['products_navigation' => 'load_more'],
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
         * STYLE -> LABEL SALE
         */

        $this->start_controls_section(
            'section_style_label_sale',
            [
                'label' => esc_html__('Label Sale', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_sale',
                'selector' => '{{WRAPPER}} span.onsale',
            ]
        );

        $this->add_control(
            'label_sale_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'label_sale_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['label_sale_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} span.onsale' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'label_sale_bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'label_sale_bg_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['label_sale_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} span.onsale' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_sale_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'label_sale_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /**
         * STYLE -> COMPARE & WISHLIST
         */

        $this->start_controls_section(
            'section_style_compare_icon',
            [
                'label' => esc_html__('Compare and Wishlist Icon', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'compare_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'custom'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 50],
                ],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'compare_icon_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} a.woosc-btn [class*=-btn-icon], {{WRAPPER}} a.woosw-btn [class*=-btn-icon]',
            ]
        );
        $this->add_control(
            'compare_icon_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_compare_icon');
        $this->start_controls_tab(
            'tab_compare_icon_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'compare_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['compare_icon_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['compare_icon_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'compare_icon_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'compare_icon_border_border!' => ['', 'none'],
                    'compare_icon_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn [class*=-btn-icon],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn [class*=-btn-icon]' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_compare_icon_hover',
            ['label' => esc_html__('Icon Hover', 'burido-core')]
        );
        $this->add_control(
            'compare_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn:hover [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn:hover [class*=-btn-icon]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['compare_icon_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn:hover [class*=-btn-icon],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn:hover [class*=-btn-icon]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn:hover [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn:hover [class*=-btn-icon]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['compare_icon_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn:hover [class*=-btn-icon],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn:hover [class*=-btn-icon]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'compare_icon_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn:hover [class*=-btn-icon],
                     {{WRAPPER}} a.woosw-btn:hover [class*=-btn-icon]' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'compare_icon_border_border!' => ['', 'none'],
                    'compare_icon_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn:hover [class*=-btn-icon],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn:hover [class*=-btn-icon]' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
         * STYLE -> COMPARE & WISHLIST TITLE
         */

        $this->start_controls_section(
            'section_style_compare_title',
            [
                'label' => esc_html__('Compare and Wishlist Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'compare_title',
                'selector' => '{{WRAPPER}} a.woosc-btn [class*=-btn-text], {{WRAPPER}} a.woosw-btn [class*=-btn-text]',
            ]
        );
        $this->add_control(
            'compare_title_color',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn [class*=-btn-text],
                     {{WRAPPER}} a.woosw-btn [class*=-btn-text]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_title_color-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['compare_title_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn [class*=-btn-text],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn [class*=-btn-text]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_title_bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} a.woosc-btn [class*=-btn-text],
                     {{WRAPPER}} a.woosw-btn [class*=-btn-text]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'compare_title_bg_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['compare_title_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} a.woosc-btn [class*=-btn-text],
                     body.wgl_dynamic_colors-active {{WRAPPER}} a.woosw-btn [class*=-btn-text]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        (new WGLProductsGrid())->render(
            $this->get_settings_for_display(),
            $this
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
