<?php
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Group_Control_Border, Widget_Base, Controls_Manager};
use WGL_Extensions\Includes\WGL_Cursor;
use WPCleverWoosw;

/**
 * Wishlist widget for Header CPT
 *
 *
 * @category Class
 * @package burido-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class WGL_Header_Wishlist extends Widget_Base
{
    public function get_name() {
        return 'wgl-header-wishlist';
    }

    public function get_title() {
        return esc_html__('WooWishlist', 'burido-core');
    }

    public function get_icon() {
        return 'wgl-header-wishlist';
    }

    public function get_keywords() {
        return ['wishlist', 'woocommerce'];
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
                    '{{WRAPPER}} .woosw-menu-item-inner::before,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'icon_height',
            [
                'label' => esc_html__('Icon Height', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woosw-menu-item-inner::before,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'icon_width',
            [
                'label' => esc_html__('Icon Width', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woosw-menu-item-inner::before,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'width: {{VALUE}}px;',
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
                    '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}}{{WRAPPER}} .woosw-menu-item-inner::after,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'fields_options' => [
                    'width' => ['label' => esc_html__('Icon Border Width', 'burido-core')],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before',
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
                    '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) a::before' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .woosw-menu-item-inner::after,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .woosw-menu-item-inner::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .woosw-menu-item-inner::after,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'counter_bg_idle-dynamic',
            [
                'label' => esc_html__('Items Counter Background - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'counter_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .woosw-menu-item-inner::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::before,
                     {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item a::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     {{WRAPPER}} .wgl-wishlist .woosw-menu-item a::before' => 'transition: 0.4s;',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item a::before' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::before,
                     {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item a::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     {{WRAPPER}} .wgl-wishlist .woosw-menu-item a::before' => 'transition: 0.4s;',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item a::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::before,
                     {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item a::before' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-wishlist .woosw-menu-item-inner::before,
                     {{WRAPPER}} .wgl-wishlist .woosw-menu-item a::before' => 'transition: 0.4s;',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item a::before' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::after,
                     {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .woosw-menu-item-inner::after,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'transition: 0.4s;',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::after,
                     {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .woosw-menu-item-inner::after,
                     {{WRAPPER}} .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'transition: 0.4s;',
                ],
            ]
        );
        $this->add_control(
            'counter_bg_hover-dynamic',
            [
                'label' => esc_html__('Items Counter Background - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'counter_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item-inner::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-wishlist:hover .woosw-menu-item:not(.menu-item-type-woosw) .count' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        if (!class_exists('\WPCleverWoosw')) {
            return;
        }

        $_s = $this->get_settings_for_display();
        $cursor = new WGL_Cursor;
        $cursor_data = $cursor->build($this, $_s);
        $key = $this->get_key();

        $this->add_render_attribute('wishlist', [
            'class' => [
                'wgl-wishlist',
                'elementor-wishlist',
                'woocommerce',
                ( isset($_s['cursor_tooltip']) && !empty($_s['cursor_tooltip']) ? ' wgl-cursor-text' : '' )
            ],
        ]);

        ?><div <?php echo \WGL_Framework::render_html($this->get_render_attribute_string('wishlist')), $cursor_data ?>>
            <div class="woosw-menu-item"><?php

                ob_start();
                    ?><a href="<?php echo esc_url(WPCleverWoosw::get_url($key, true)) ?>">
                        <span class="count"><?php echo esc_html( WPCleverWoosw::get_count() ); ?></span>
                    </a>
                <?php
                echo ob_get_clean();

            ?></div>
        </div><?php
    }

    /**
     * @return string|null
     */
    public function get_key(){
        if ( ( $user_id = get_current_user_id() ) ) {
            $keys = get_user_meta( $user_id, 'woosw_keys', true ) ?: array();
            if ( is_array( $keys ) && ! empty( $keys ) ) {
                foreach ($keys as $k => $wl) {
                    return esc_attr( $k );
                }
            }
        }
        return 0;
    }
}