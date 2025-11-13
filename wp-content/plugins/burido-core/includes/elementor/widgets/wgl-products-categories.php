<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-products-categories.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Border,
    Plugin,
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography,
    Group_Control_Box_Shadow};
use WGL_Extensions\{
    Includes\WGL_Carousel_Settings,
    Includes\WGL_Elementor_Helper,
    WGL_Framework_Global_Variables as WGL_Globals
};

class WGL_Products_Categories extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-products-categories';
    }

    public function get_keywords() {
        return ['products', 'category', 'categories', 'shop', 'woocommerce'];
    }

    public function get_title()
    {
        return esc_html__('WGL Products Categories', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-products-categories';
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    public function get_script_depends()
    {
        return ['jquery-appear'];
    }

    public static function get_term_parents_list( $term_id, $taxonomy, $args = array() ) {
        $list = '';
        $term = get_term( $term_id, $taxonomy );

        if ( is_wp_error( $term ) ) {
            return $term;
        }

        if ( ! $term ) {
            return $list;
        }

        $term_id = $term->term_id;

        $defaults = array(
                'format'    => 'name',
                'separator' => '/',
                'inclusive' => true,
        );

        $args = wp_parse_args( $args, $defaults );

        foreach ( array(  'inclusive' ) as $bool ) {
            $args[ $bool ] = wp_validate_boolean( $args[ $bool ] );
        }

        $parents = get_ancestors( $term_id, $taxonomy, 'taxonomy' );

        if ( $args['inclusive'] ) {
            array_unshift( $parents, $term_id );
        }

        $a = count($parents) - 1;
        foreach ( array_reverse( $parents ) as $index => $term_id ) {
            $parent = get_term( $term_id, $taxonomy );
            $temp_sep = $args['separator'];
            $lastElement = reset($parents);
            $first = end($parents);

            if($index == $a - 1){
                $temp_sep = '';
            }
            if( $term_id != $lastElement){
                $name   = $parent->name;
                $list .= $name . $temp_sep;
            }
        }

        return $list;
    }

    public static function categories_suggester() {
        $content = array();

        $categories = get_terms( 'product_cat' );
        foreach ( $categories as $cat ) {
            $args = array(
              'separator' => ' > ',
              'format'    => 'name',
            );

            $parent = self::get_term_parents_list( $cat->term_id, 'product_cat', array());

            $content[(string) $cat->slug] = $cat->name.(!empty($parent) ? esc_html__(' (Parent categories: (', 'burido-core') .$parent.'))' : "");
        }
        return $content;
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
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'render_type' => 'template',
                'devices' => ['widescreen', 'desktop', 'tablet', 'mobile'],
                'min' => 1,
                'max' => 6,
                'default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 2,
                'selectors' => [
                    '{{WRAPPER}} .wgl-products-categories' => '--columns: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'categories_gap',
            [
                'label' => esc_html__('Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'render_type' => 'template',
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'default' => [ 'size' => '30' ],
                'tablet_default' => ['size' => '30'],
                'mobile_default' => ['size' => '20'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-products-categories' => '--categories-gap: {{SIZE}}{{UNIT}}',
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
                    '560' => esc_html__('560x560 - Default', 'burido-core'),
                    'full' => esc_html__('Full', 'burido-core'),
                    'custom' => esc_html__('Custom', 'burido-core'),
                ],
                'default' => '560',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'burido-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [ 'img_size_string' => 'custom' ],
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
                'default' => '1:1',
            ]
        );

		$this->add_control(
			'products_categories',
			[
				'label' => esc_html__( 'Categories', 'burido-core' ),
				'type' => Controls_Manager::SELECT2,
				'options' => self::categories_suggester(),
				'default' => [],
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'exclude_categories',
			[
				'label' => esc_html__( 'Exclude These Categories', 'burido-core' ),
				'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'burido-core' ),
                'label_off' => esc_html__( 'Off', 'burido-core' ),
                'return_value' => 'yes',
                'description' => esc_html__('Leave empty for all','burido-core'),
			]
		);

		$this->add_control(
			'show_count',
			[
				'label' => esc_html__( 'Show Count', 'burido-core' ),
				'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'burido-core' ),
                'label_off' => esc_html__( 'Off', 'burido-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
			]
		);

        $this->add_control(
            'title_position',
            [
                'label' => esc_html__('Position of Title and Count', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'under_image' => esc_html__('Beneath Image', 'burido-core'),
                    'cursor_tooltip' => esc_html__('Cursor Tooltip', 'burido-core'),
                ],
                'default' => 'under_image',
            ]
        );

		$this->add_control(
			'orderby_categories',
			[
				'label' => esc_html__( 'Order By', 'burido-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name' => esc_html__( 'Name', 'burido-core' ),
					'slug' => esc_html__( 'Slug', 'burido-core' ),
					'description' => esc_html__( 'Description', 'burido-core' ),
					'count' => esc_html__( 'Count', 'burido-core' ),
				],
			]
		);

		$this->add_control(
			'order_categories',
			[
				'label' => esc_html__( 'Order', 'burido-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => esc_html__( 'ASC', 'burido-core' ),
					'desc' => esc_html__( 'DESC', 'burido-core' ),
				],
			]
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

        WGL_Carousel_Settings::add_pagination_controls($this);

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
                'condition' => ['use_pagination!' => ''],
            ]
        );
        WGL_Carousel_Settings::add_responsive_controls($this);
        $this->end_controls_section();

	    /**
	     * STYLE -> GENERAL
	     */

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('General', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'alignment',
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
                'default' => 'center',
                'prefix_class' => 'a%s',
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Item Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'allowed_dimensions' => 'vertical',
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '15',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .cats_item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__('Item Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '16',
                    'right' => '16',
                    'bottom' => '16',
                    'left' => '16',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .cats_item-link' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-link' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_idle',
                'selector' => '{{WRAPPER}} .cats_item-link',
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
                    '{{WRAPPER}} .cats_item-link:hover' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_hover',
                'selector' => '{{WRAPPER}} .cats_item-link:hover',
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
			    'label' => esc_html__('Image Width', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => ['px', '%', 'custom'],
			    'range' => [
				    'px' => ['min' => 50, 'max' => 500 ],
				    '%' => ['min' => 10, 'max' => 100 ],
			    ],
                'default' => ['size' => 280, 'unit' => 'px'],
			    'selectors' => [
				    '{{WRAPPER}} .cats_item-media .cats_item-image' => 'width: {{SIZE}}{{UNIT}};',
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
				    '{{WRAPPER}} .cats_item-media .cats_item-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );
	    $this->add_responsive_control(
		    'image_padding',
		    [
			    'label' => esc_html__( 'Padding', 'burido-core' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '19',
                    'right' => '19',
                    'bottom' => '19',
                    'left' => '19',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
			    'selectors' => [
				    '{{WRAPPER}} .cats_item-media .cats_item-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'top' => '240',
                    'right' => '240',
                    'bottom' => '240',
                    'left' => '240',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-media .cats_item-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'fields_options' => [
                    'border' => [ 'default' => 'solid' ],
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                        ],
                    ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}}  .cats_item-media .cats_item-image',
            ]
        );

        $this->start_controls_tabs( 'tabs_image' );
        $this->start_controls_tab(
            'tab_image_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $this->add_control(
            'image_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-media .cats_item-image' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-media .cats_item-image' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .cats_item-media .cats_item-image' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-media .cats_item-image' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_idle',
                'selector' => '{{WRAPPER}} .cats_item-media .cats_item-image',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_image_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );
        $this->add_control(
            'image_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .cats_item:hover .cats_item-media .cats_item-image' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item:hover .cats_item-media .cats_item-image' => 'background-color: {{VALUE}};',
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
                'default' => WGL_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .cats_item:hover .cats_item-media .cats_item-image' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item:hover .cats_item-media .cats_item-image' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_border_offset_hover',
            [
                'label' => esc_html__('Border Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 70, 'step' => 1],
                ],
                'condition' => [ 'image_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .cats_item:hover .tlv__media::before' => '--border-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_hover',
                'selector' => '{{WRAPPER}} .cats_item:hover .cats_item-media .cats_item-image',
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
                'selector' => '{{WRAPPER}} .cats_item-title',
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
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .cats_item-title' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-link:hover .cats_item-title' => 'color: {{VALUE}};',
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
                'condition' => ['title_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-link:hover .cats_item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * STYLE -> COUNT
         */

        $this->start_controls_section(
            'section_style_count',
            [
                'label' => esc_html__('Count', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_count!' => '']
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'count',
                'selector' => '{{WRAPPER}} .cats_item-count',
            ]
        );

        $this->add_control(
            'count_tag',
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
            'count_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '3',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_count');

        $this->start_controls_tab(
            'tab_count_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'count_color_idle',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .cats_item-count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'count_color_idle-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['count_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_count_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'count_color_hover',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .cats_item-link:hover .cats_item-count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'count_color_hover-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['count_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .cats_item-link:hover .cats_item-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CURSOR TOOLTIP
         */

        $this->start_controls_section(
            'style_tooltip',
            [
                'label' => esc_html__('Cursor Tooltip', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['title_position' => 'cursor_tooltip'],
            ]
        );
        $this->start_controls_tabs('tabs_cursor');
        $this->start_controls_tab(
            'tabs_cursor_title',
            ['label' => esc_html__('Title', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_title',
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6',
            ]
        );
        $this->add_responsive_control(
            'tooltip_title_width',
            [
                'label' => esc_html__('Min Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 500 ],
                ],
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tooltip_title_alignment',
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
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'tooltip_title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'tooltip_title_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tooltip_title_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6',
            ]
        );
        $this->add_control(
            'tooltip_title_color',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_h_font_color(),
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'tooltip_title_bg',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip h6' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_cursor_count',
            ['label' => esc_html__('Count', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_count',
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count',
            ]
        );
        $this->add_responsive_control(
            'tooltip_count_width',
            [
                'label' => esc_html__('Min Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 500 ],
                ],
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tooltip_count_alignment',
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
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'tooltip_count_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'tooltip_count_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tooltip_count_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                ],
                'selector' => '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count',
            ]
        );
        $this->add_control(
            'tooltip_count_color',
            [
                'label' => esc_html__('Count Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'tooltip_count_bg',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '#wgl-cursor .wgl-element-{{ID}}.product-cat-tooltip .count' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        // Cursor
        if ('cursor_tooltip' === $_s['title_position']) {
            add_filter( 'wgl/burido_module_cursor', function () { return true; });

            $cursor_class = ' data-cursor-class="wgl-element-'.$this->get_id().' product-cat-tooltip"';
            $this->add_render_attribute( 'item',  ['class' =>  'wgl-cursor-text']  );
        }

        // Images
        $img_size_string = $_s['img_size_string'] ?? '';
        $img_size_array = $_s['img_size_array'] ?? [];
        $img_aspect_ratio = $_s['img_aspect_ratio'] ?? '';

        $this->add_render_attribute( 'wrapper', [
			'class' => [
                'wgl-products-categories',
                'carousel' == $_s['products_layout'] ? 'carousel-cats' : '',
            ],
        ] );

        $this->add_render_attribute( 'item', [
			'class' => [
                'cats_item',
                'carousel' === $_s['products_layout'] ? ' swiper-slide' : ''
            ],
        ] );

        $count_render = $count_data = $cursor_data = '';
        $slug = $cat_id = [];
        if (empty($_s['products_categories'])) {
            $slug = [];
        } else {
            foreach( $_s['products_categories'] as $cat ) {
                $slug[] = $cat;
                $category = get_term_by('slug', $cat, 'product_cat');
                $cat_id[] = $category->term_id;
            }
        }

        $args = [
            'taxonomy' => 'product_cat',
            'slug' => !$_s['exclude_categories'] ? $slug : [],
            'order' => $_s['order_categories'],
            'orderby' => $_s['orderby_categories'],
            'exclude' => $_s['exclude_categories'] ? $cat_id : [],
        ];

        $categories = get_terms( $args );

        ob_start();
        foreach( $categories as $cat ){
            if($cat){
                $image_resized_url = '';
                $title = $cat->name;

                if (!empty($_s['show_count'])){
                    $count = $cat->count;
                    $count_render = $count._nx(
                        ' Item',
                        ' Items',
                        $count,
                        'category count',
                        'burido-core'
                    );
                }

                $cat_link = get_term_link($cat->term_id);
                $image_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                $image_data = wp_get_attachment_image_src ( $image_id, 'full' );
                if ( !empty( $image_data[ 0 ] ) ) {
                    $dimensions = WGL_Elementor_Helper::get_image_dimensions(
                        $img_size_array ?: $img_size_string,
                        $img_aspect_ratio,
                        $image_data
                    );
                    $dimensions[ 'width' ] = $dimensions[ 'width' ] ?? $image_data[ 1 ] ?? null;
                    $dimensions[ 'height' ] = $dimensions[ 'height' ] ?? $image_data[ 2 ] ?? null;

                    $image_full_url = $image_data[ 0 ];
                    $image_resized_url = aq_resize( $image_full_url, $dimensions[ 'width' ], $dimensions[ 'height' ], true, true, true ) ?: $image_full_url;
                }


                if ('cursor_tooltip' === $_s['title_position']) {
                    if(!empty($_s['show_count'])){
                        $count_data = '<div class=\'count\'>'.$count_render.'</div>';
                    }
                    $cursor_data = ' data-cursor-text="<h6>' . $title. '</h6>' . $count_data .'"' . $cursor_class;
                }

                echo '<div '.$this->get_render_attribute_string( 'item' ). ('cursor_tooltip' === $_s['title_position'] ? $cursor_data : '').'>',
                    '<a class="cats_item-link" href="'.$cat_link.'">',
                        !empty($image_resized_url) ? '<div class="cats_item-media"><img class="cats_item-image" src="'. $image_resized_url .'" alt="'.esc_attr(!empty($image_alt) ? $image_alt : $title).'" /></div>' : '',
                        '<'.$_s['title_tag'].' class="cats_item-title">'.$title.'</'.$_s['title_tag'].'>',
                        !empty($_s['show_count']) ? '<span class="cats_item-count">'.$count_render.'</span>' : '',
                    '</a>',
                '</div>';
            }
        }
        $content = ob_get_clean();

        echo '<div '.$this->get_render_attribute_string( 'wrapper' ).'>',
            'carousel' === $_s['products_layout'] ? $this->apply_carousel_options($content, $_s) : $content,
        '</div>';

    }

    protected function apply_carousel_options($items_html, $_s)
    {
        $_s['categories_gap'] = !empty($_s['categories_gap']['size']) ? $_s['categories_gap'] : ['size' => '30'];
        $_s['slides_per_row'] = $_s['grid_columns'];

        $_s['responsive_gap'] = [
            'desktop_gap' => $_s['categories_gap'],
            'tablet_gap' => !empty($_s['categories_gap_tablet']['size']) ? $_s['categories_gap_tablet'] : $_s['categories_gap'],
            'mobile_gap' => !empty($_s['categories_gap_mobile']['size']) ? $_s['categories_gap_mobile'] : $_s['categories_gap'],
        ];

        return WGL_Carousel_Settings::init($_s, $items_html);
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