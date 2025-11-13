<?php
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Group_Control_Border, Plugin, Widget_Base, Controls_Manager};
use WGL_Extensions\Includes\WGL_Cursor;

/**
 * Cart widget for Header CPT
 *
 *
 * @category Class
 * @package burido-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class WGL_Header_Cart extends Widget_Base
{
    public function get_name() {
        return 'wgl-header-cart';
    }

    public function get_title() {
        return esc_html__('WooCart', 'burido-core');
    }

    public function get_icon() {
        return 'wgl-header-cart';
    }

    public function get_keywords() {
        return ['cart', 'basket', 'woocommerce'];
    }

    public function get_categories() {
        return [ 'wgl-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'wgl-widgets',
        ];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_search_settings',
            [ 'label' => esc_html__('General', 'burido-core') ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count .wgl-icon-cart' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'cart_height',
            [
                'label' => esc_html__('Icon Height', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count .wgl-icon-cart' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'cart_width',
            [
                'label' => esc_html__('Icon Width', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count .wgl-icon-cart' => 'width: {{VALUE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * GENERAL -> CURSOR
         */

        WGL_Cursor::init(
            $this,
            [
                'section' => true,
            ]
        );

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__('General', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Icon Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'count_margin',
            [
                'label' => esc_html__('Count Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'fields_options' => [
                    'width' => ['label' => esc_html__('Border Width', 'burido-core')],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart',
            ]
        );
        $this->start_controls_tabs('icon_style_tabs');
        $this->start_controls_tab(
            'tab_idle',
            [ 'label' => esc_html__('Idle' , 'burido-core') ]
        );
        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_idle',
            [
                'label' => esc_html__('Icon Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_bg_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_idle',
            [
                'label' => esc_html__( 'Icon Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'icon_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_border_border!' => ['', 'none'],
                    'icon_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart .woo_mini-count .wgl-icon-cart' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'counter_color_idle',
            [
                'label' => esc_html__('Items Counter Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count > span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'counter_color_idle-dynamic',
            [
                'label' => esc_html__('Items Counter Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'counter_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .woo_mini-count > span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'counter_bg_idle',
            [
                'label' => esc_html__('Items Counter Background', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count > span' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'counter_bg_idle-dynamic',
            [
                'label' => esc_html__('Items Counter Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'counter_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .woo_mini-count > span' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_hover',
            [ 'label' => esc_html__('Hover' , 'burido-core') ]
        );
        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .woo_mini-count .wgl-icon-cart' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart:hover .woo_mini-count .wgl-icon-cart' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_hover',
            [
                'label' => esc_html__('Icon Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .woo_mini-count .wgl-icon-cart' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_bg_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart:hover .woo_mini-count .wgl-icon-cart' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_hover',
            [
                'label' => esc_html__( 'Icon Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'icon_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .woo_mini-count .wgl-icon-cart' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_border_border!' => ['', 'none'],
                    'icon_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart:hover .woo_mini-count .wgl-icon-cart' => 'border-color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'counter_color_hover',
		    [
			    'label' => esc_html__('Items Counter Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .mini-cart:hover .woo_mini-count > span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .woo_mini-count > span' => 'transition: 0.4s;',
			    ],
		    ]
	    );
        $this->add_control(
            'counter_color_hover-dynamic',
            [
                'label' => esc_html__('Items Counter Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'counter_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart:hover .woo_mini-count > span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'counter_bg_hover',
            [
                'label' => esc_html__('Items Counter Background', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .woo_mini-count > span' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .woo_mini-count > span' => 'transition: 0.4s;',
                ],
            ]
        );
        $this->add_control(
            'counter_bg_hover-dynamic',
            [
                'label' => esc_html__('Items Counter Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'counter_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mini-cart:hover .woo_mini-count > span' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        if (!class_exists('\WooCommerce')) {
            return;
        }
	    global $wgl_woo_cart;
	    $wgl_woo_cart = true;?>
        <div class="wgl-mini-cart_wrapper">
            <div class="mini-cart woocommerce"><?php
            echo $this->icon_cart();?>
            </div>
        </div><?php
    }

    public function icon_cart()
    {

        $_s = $this->get_settings_for_display();

        if (isset($_s['cursor_tooltip']) && '' != $_s['cursor_tooltip']) {
            add_filter( 'wgl/burido_module_cursor', function () { return true; });
        }

        $cursor = new WGL_Cursor;
        $cursor_data = $cursor->build($this, $_s);

        ob_start();
        $this->add_render_attribute('cart', [
            'class' => [
                'wgl-cart',
                'woo_icon',
                'elementor-cart',
                ( isset($_s['cursor_tooltip']) && !empty($_s['cursor_tooltip']) ? ' wgl-cursor-text' : '' )
            ]
        ]);
        $this->add_render_attribute('cart', 'role', 'button' );
        $this->add_render_attribute('cart', 'title', esc_attr__('Click to open Shopping Cart', 'burido-core')); ?>

        <a <?php echo \WGL_Framework::render_html($this->get_render_attribute_string('cart')), $cursor_data ?>>
            <span class="woo_mini-count"><?php
                echo '<i class="wgl-icon-cart">'.wgl_dynamic_styles()->wgl_theme_svg()['cart'].'</i>';

                if ((!(bool) Plugin::$instance->editor->is_edit_mode())) {
                    echo \WooCommerce::instance()->cart->cart_contents_count > 0
                        ? '<span>' . esc_html( \WooCommerce::instance()->cart->cart_contents_count ) .'</span>'
                        : '';
                }else{
                    echo '<span>5</span>';
                }
            ?></span>
        </a><?php

        return ob_get_clean();
    }
}