<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-background-clip-texts.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography,
    Group_Control_Background
};
use WGL_Extensions\Includes\WGL_Cursor;

class WGL_Background_Clip_Text extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-background-clip-text';
    }

    public function get_title()
    {
        return esc_html__('WGL Background Clip Text', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-background-clip-text';
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
            'title',
            [
                'label' => esc_html__('Text', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'rows' => 3,
                'default' => esc_html__('GET IN TOUCH', 'burido-core'),
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
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
            'link',
            [
                'label' => esc_html__('Title Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('https://your-link.com', 'burido-core'),
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


        /**
         * STYLES -> TITLE
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
                'name' => 'title_typo',
                'fields_options' => [
                    'typography' => [ 'default' => 'yes' ],
                    'font_size' => [
                        'default' => [ 'size' => 200, 'unit' => 'px' ],
                        'tablet_default' => [ 'size' => 130, 'unit' => 'px' ],
                        'mobile_default' => [ 'size' => 60, 'unit' => 'px' ]
                    ],
                ],
                'selector' => '{{WRAPPER}} .clip-text__title',
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
                    'span' => esc_html('‹span›'),
                    'div' => esc_html('‹div›'),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .clip-text__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_background_switch' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .clip-text__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_color_idle!' => '',
                    'title_background_switch' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .clip-text__title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .clip-text__title' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_stroke_color_idle',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_stroke_size[size]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .clip-text__title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_stroke_color_idle!' => '',
                    'title_stroke_size[size]!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .clip-text__title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'title_background_switch',
			[
				'label' => esc_html__('Backround Clip', 'burido-core'),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
                    '{{WRAPPER}} .clip-text__title' => '-webkit-background-clip: text; -webkit-text-fill-color: transparent;'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_background',
				'label' => esc_html__('Background', 'burido-core'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .clip-text__title',
                'condition' => [
                    'title_background_switch!' => '',
                ],
			]
		);

        $this->end_controls_section();

    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        if (isset($_s['cursor_tooltip']) && '' != $_s['cursor_tooltip']) {
            add_filter( 'wgl/burido_module_cursor', function () { return true; });
        }

        $cursor = new WGL_Cursor;
        $cursor_data = $cursor->build($this, $_s);

        echo '<div class="wgl-background-clip-text' . ( isset($_s['cursor_tooltip']) && !empty($_s['cursor_tooltip']) ? ' wgl-cursor-text' : '' ) . '"' . $cursor_data . '>';

        if (
            $_s['title']
        ) {
            if (!empty($_s['link']['url'])) {
                $this->add_render_attribute('link', 'class', 'clip-text__link');
                $this->add_link_attributes('link', $_s['link']);

                echo '<a ', $this->get_render_attribute_string('link'), '>';
            }

            echo '<', $_s['title_tag'], ' class="clip-text__title">', $_s['title'], '</', $_s['title_tag'], '>';

            if (!empty($_s['link']['url'])) {
                echo '</a>';
            }
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
