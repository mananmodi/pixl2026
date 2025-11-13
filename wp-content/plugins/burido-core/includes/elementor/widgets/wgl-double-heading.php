<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-double-headings.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Background,
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography,
    Group_Control_Border,
    Group_Control_Box_Shadow};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Cursor
};

class WGL_Double_Heading extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-double-heading';
    }

    public function get_title()
    {
        return esc_html__('WGL Double Heading', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-double-heading';
    }

    public function get_script_depends() {
        return ['jquery-appear'];
    }

    public function get_keywords()
    {
        return [ 'double', 'dblh', 'heading', 'title', 'text' ];
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
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('ex: About Our Company', 'burido-core'),
                'default' => esc_html__('Double Heading Subtitle', 'burido-core'),
            ]
        );
        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_part-1',
            [
                'label' => esc_html__('1st Part', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'rows' => 3,
                'placeholder' => esc_attr__('1st part', 'burido-core'),
                'default' => esc_html__('Double Heading Title', 'burido-core'),
            ]
        );

        $this->add_control(
            'title_part-2',
            [
                'label' => esc_html__('2nd Part', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'rows' => 3,
                'placeholder' => esc_attr__('2nd part', 'burido-core'),
            ]
        );

        $this->add_control(
            'title_part-3',
            [
                'label' => esc_html__('3rd Part', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'rows' => 3,
                'placeholder' => esc_attr__('3rd part', 'burido-core'),
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('Description Text', 'burido-core'),
                'label_block' => true,
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
                'name' => 'title_all',
                'fields_options' => [
                    'typography' => [ 'default' => 'yes' ],
                    'font_size' => [
                        'default' => [ 'size' => 48, 'unit' => 'px' ],
                        'tablet_default' => [ 'size' => 40, 'unit' => 'px' ],
                        'mobile_default' => [ 'size' => 30, 'unit' => 'px' ]
                    ],
                    'line_height' => ['default' => ['size' => 1.33, 'unit' => 'em']],
                ],
                'selector' => '{{WRAPPER}} .dblh__title-wrapper',
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
		    'title_display',
		    [
			    'label' => esc_html__( 'Display', 'burido-core' ),
			    'type' => Controls_Manager::SELECT,
			    'options' => [
				    'inline' => esc_html__( 'Inline', 'burido-core' ),
				    'block' => esc_html__( 'Block', 'burido-core' ),
				    'inline-block' => esc_html__( 'Inline Block', 'burido-core' ),
			    ],
			    'default' => 'inline',
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title' => 'display: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_1st_heading',
            [
                'label' => esc_html__('1st Part', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['title_part-1!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_first',
                'condition' => ['title_part-1!' => ''],
                'selector' => '{{WRAPPER}} .dblh__title-1',
            ]
        );
        $this->add_responsive_control(
            'title_first_padding',
            [
                'label' => esc_html__('Padding for 1st Part', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => ['title_part-1!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
		    'title_first_stroke_size',
		    [
			    'label' => esc_html__('Stroke Width', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => ['px'],
			    'range' => ['px' => ['min' => 0, 'max' => 2, 'step' => 0.1]],
			    'condition' => ['title_part-1!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-1' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_first_gradient',
            [
                'label' => esc_html__('Use Gradient for First Part', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'burido-core'),
                'label_off' => esc_html__('No', 'burido-core'),
                'condition' => ['title_part-1!' => ''],
                'prefix_class' => 'title_gradient-',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => '-webkit-background-clip: text; -webkit-text-fill-color: transparent;',
                ],
            ]
        );
	    $this->start_controls_tabs(
		    'tabs_title_first', [
                'condition' => [
                    'title_part-1!' => '',
                ],
		    ]
	    );
	    $this->start_controls_tab(
		    'tabs_title_first_idle',
		    ['label' => esc_html__('Idle', 'burido-core')]
	    );
        $this->add_control(
            'title_1st_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['title_part-1!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_1st_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-1!' => '',
                    'title_1st_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-1' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_1st_stroke_color_idle',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                	'title_part-1!' => '',
                	'title_first_stroke_size[size]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_1st_stroke_color_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-1!' => '',
                    'title_first_stroke_size[size]!' => '',
                    'title_1st_stroke_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-1' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->start_controls_tab(
		    'tabs_title_first_hover',
		    ['label' => esc_html__('Hover', 'burido-core')]
	    );
	    $this->add_control(
		    'title_1st_color_hover',
		    [
			    'label' => esc_html__('Text Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_part-1!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-wrapper:hover  .dblh__title-1' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_1st_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-1!' => '',
                    'title_1st_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-wrapper:hover  .dblh__title-1' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'title_1st_stroke_color_hover',
		    [
			    'label' => esc_html__('Stroke Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [
				    'title_part-1!' => '',
				    'title_first_stroke_size[size]!' => '',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-wrapper:hover .dblh__title-1' => '-webkit-text-stroke-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_1st_stroke_color_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-1!' => '',
                    'title_first_stroke_size[size]!' => '',
                    'title_1st_stroke_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-wrapper:hover .dblh__title-1' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->end_controls_tabs();

        $this->add_control(
            'title_2nd_heading',
            [
                'label' => esc_html__('2nd Part', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['title_part-2!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_second',
                'condition' => ['title_part-2!' => ''],
                'selector' => '{{WRAPPER}} .dblh__title-2',
            ]
        );

        $this->add_responsive_control(
            'title_second_padding',
            [
                'label' => esc_html__('Padding for 2nd Part', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => ['title_part-2!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
		    'title_second_stroke_size',
		    [
			    'label' => esc_html__('Stroke Width', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => ['px'],
			    'range' => ['px' => ['min' => 0, 'max' => 2, 'step' => 0.1]],
			    'condition' => ['title_part-2!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-2' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_second_gradient',
            [
                'label' => esc_html__('Use Gradient for Second Part', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'burido-core'),
                'label_off' => esc_html__('No', 'burido-core'),
                'condition' => ['title_part-2!' => ''],
                'prefix_class' => 'title_gradient-',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => '-webkit-background-clip: text; -webkit-text-fill-color: transparent;',
                ],
            ]
        );
	    $this->start_controls_tabs(
		    'tabs_title_second', [
			    'condition' => [
                    'title_part-2!' => '',
                ],
		    ]
	    );
	    $this->start_controls_tab(
		    'tabs_title_second_idle',
		    ['label' => esc_html__('Idle', 'burido-core')]
	    );
	    $this->add_control(
		    'title_2nd_color_idle',
		    [
			    'label' => esc_html__('Text Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_part-2!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-2' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_2nd_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-2!' => '',
                    'title_2nd_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-2' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'title_2nd_stroke_color_idle',
		    [
			    'label' => esc_html__('Stroke Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [
				    'title_part-2!' => '',
				    'title_second_stroke_size[size]!' => '',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-2' => '-webkit-text-stroke-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_2nd_stroke_color_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-2!' => '',
                    'title_second_stroke_size[size]!' => '',
                    'title_2nd_stroke_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-2' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->start_controls_tab(
		    'tabs_title_second_hover',
		    ['label' => esc_html__('Hover', 'burido-core')]
	    );
	    $this->add_control(
		    'title_2nd_color_hover',
		    [
			    'label' => esc_html__('Text Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_part-2!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-wrapper:hover  .dblh__title-2' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_2nd_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-2!' => '',
                    'title_2nd_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-wrapper:hover  .dblh__title-2' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'title_2nd_stroke_color_hover',
		    [
			    'label' => esc_html__('Stroke Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [
				    'title_part-2!' => '',
				    'title_second_stroke_size[size]!' => '',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-wrapper:hover .dblh__title-2' => '-webkit-text-stroke-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_2nd_stroke_color_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-2!' => '',
                    'title_second_stroke_size[size]!' => '',
                    'title_2nd_stroke_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-wrapper:hover .dblh__title-2' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->end_controls_tabs();

        $this->add_control(
            'title_3rd_heading',
            [
                'label' => esc_html__('3rd Part', 'burido-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['title_part-3!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_third',
                'condition' => ['title_part-3!' => ''],
                'selector' => '{{WRAPPER}} .dblh__title-3',
            ]
        );

        $this->add_responsive_control(
            'title_third_padding',
            [
                'label' => esc_html__('Padding for 3rd Part', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => ['title_part-3!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

	    $this->add_responsive_control(
		    'title_third_stroke_size',
		    [
			    'label' => esc_html__('Stroke Width', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => ['px'],
			    'range' => ['px' => ['min' => 0, 'max' => 2, 'step' => 0.1]],
			    'condition' => ['title_part-3!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-3' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_third_gradient',
            [
                'label' => esc_html__('Use Gradient for Third Part', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'burido-core'),
                'label_off' => esc_html__('No', 'burido-core'),
                'condition' => ['title_part-3!' => ''],
                'prefix_class' => 'title_gradient-',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => '-webkit-background-clip: text; -webkit-text-fill-color: transparent;',
                ],
            ]
        );
	    $this->start_controls_tabs(
		    'tabs_title_third', [
                'condition' => [
                    'title_part-3!' => '',
                ],
		    ]
	    );
	    $this->start_controls_tab(
		    'tabs_title_third_idle',
		    ['label' => esc_html__('Idle', 'burido-core')]
	    );
	    $this->add_control(
		    'title_3rd_color_idle',
		    [
			    'label' => esc_html__('Text Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_part-3!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-3' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_3rd_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-3!' => '',
                    'title_3rd_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-3' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'title_3rd_stroke_color_idle',
		    [
			    'label' => esc_html__('Stroke Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [
				    'title_part-3!' => '',
				    'title_third_stroke_size[size]!' => '',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-3' => '-webkit-text-stroke-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_3rd_stroke_color_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-3!' => '',
                    'title_third_stroke_size[size]!' => '',
                    'title_3rd_stroke_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-3' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->start_controls_tab(
		    'tabs_title_third_hover',
		    ['label' => esc_html__('Hover', 'burido-core')]
	    );
	    $this->add_control(
		    'title_3rd_color_hover',
		    [
			    'label' => esc_html__('Text Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_part-3!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-wrapper:hover  .dblh__title-3' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_3rd_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-3!' => '',
                    'title_3rd_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-wrapper:hover  .dblh__title-3' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'title_3rd_stroke_color_hover',
		    [
			    'label' => esc_html__('Stroke Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [
				    'title_part-3!' => '',
				    'title_third_stroke_size[size]!' => '',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .dblh__title-wrapper:hover .dblh__title-3' => '-webkit-text-stroke-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'title_3rd_stroke_color_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_part-3!' => '',
                    'title_third_stroke_size[size]!' => '',
                    'title_3rd_stroke_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__title-wrapper:hover .dblh__title-3' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLES -> TITLE GRADIENT
         */

        $this->start_controls_section(
            'style_title_gradient',
            [
                'label' => esc_html__('Gradient for the Entire Widget', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_gradient',
            [
                'label' => esc_html__('Use Gradient', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'burido-core'),
                'label_off' => esc_html__('No', 'burido-core'),
                'prefix_class' => 'title_gradient-',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => '-webkit-background-clip: text; -webkit-text-fill-color: transparent;',
                ],
            ]
        );
        $this->add_control(
            'title_gradient_color_1',
            [
                'label' => esc_html__('Primary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'title_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => '--gradient-color-1: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_gradient_color_2',
            [
                'label' => esc_html__('Secondary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'title_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => '--gradient-color-2: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_gradient_location_1',
            [
                'label' => esc_html__('First Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 0 ],
                'render_type' => 'ui',
                'condition' => [ 'title_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => '--gradient-location-1: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_gradient_location_2',
            [
                'label' => esc_html__('Second Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
                'render_type' => 'ui',
                'condition' => [ 'title_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => '--gradient-location-2: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'title_gradient_type',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'linear' => esc_html__( 'Linear', 'burido-core' ),
                    'radial' => esc_html__( 'Radial', 'burido-core' ),
                ],
                'default' => 'radial',
                'render_type' => 'ui',
                'condition' => [ 'title_gradient!' => '' ],
            ]
        );
        $this->add_responsive_control(
            'title_gradient_angle',
            [
                'label' => esc_html__('Angle', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'default' => [ 'unit' => 'deg', 'size' => 180 ],
                'range' => [
                    'deg' => [ 'step' => 10 ],
                ],
                'condition' => [
                    'title_gradient!' => '',
                    'title_gradient_type' => 'linear',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_gradient_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'burido-core' ),
                    'center left' => esc_html__( 'Center Left', 'burido-core' ),
                    'center right' => esc_html__( 'Center Right', 'burido-core' ),
                    'top center' => esc_html__( 'Top Center', 'burido-core' ),
                    'top left' => esc_html__( 'Top Left', 'burido-core' ),
                    'top right' => esc_html__( 'Top Right', 'burido-core' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'burido-core' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'burido-core' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'burido-core' ),
                    'var(--h-pos) var(--v-pos)' => esc_html__( 'Custom', 'burido-core' ),
                ],
                'default' => 'center center',
                'condition' => [
                    'title_gradient!' => '',
                    'title_gradient_type' => 'radial',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => 'background-color: transparent; background-image: radial-gradient(circle at {{VALUE}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_gradient_h_position',
            [
                'label' => esc_html__('Horizontal Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_gradient!' => '',
                    'title_gradient_type' => 'radial',
                    'title_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 50, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => '--h-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_gradient_v_position',
            [
                'label' => esc_html__('Vertical Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_gradient!' => '',
                    'title_gradient_type' => 'radial',
                    'title_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-wrapper' => '--v-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLES -> TITLE FIRST GRADIENT
         */

        $this->start_controls_section(
            'style_title_first_gradient',
            [
                'label' => esc_html__('Gradient for the First Part', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'title_first_gradient!' => '' ],
            ]
        );
        $this->add_control(
            'title_first_gradient_color_1',
            [
                'label' => esc_html__('Primary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => '--gradient-color-1: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_first_gradient_color_2',
            [
                'label' => esc_html__('Secondary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => '--gradient-color-2: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_first_gradient_location_1',
            [
                'label' => esc_html__('First Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 0 ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => '--gradient-location-1: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_first_gradient_location_2',
            [
                'label' => esc_html__('Second Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => '--gradient-location-2: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'title_first_gradient_type',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'linear' => esc_html__( 'Linear', 'burido-core' ),
                    'radial' => esc_html__( 'Radial', 'burido-core' ),
                ],
                'default' => 'radial',
                'render_type' => 'ui',
            ]
        );
        $this->add_responsive_control(
            'title_first_gradient_angle',
            [
                'label' => esc_html__('Angle', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'default' => [ 'unit' => 'deg', 'size' => 180 ],
                'range' => [
                    'deg' => [ 'step' => 10 ],
                ],
                'condition' => [ 'title_first_gradient_type' => 'linear' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_first_gradient_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'burido-core' ),
                    'center left' => esc_html__( 'Center Left', 'burido-core' ),
                    'center right' => esc_html__( 'Center Right', 'burido-core' ),
                    'top center' => esc_html__( 'Top Center', 'burido-core' ),
                    'top left' => esc_html__( 'Top Left', 'burido-core' ),
                    'top right' => esc_html__( 'Top Right', 'burido-core' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'burido-core' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'burido-core' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'burido-core' ),
                    'var(--h-pos) var(--v-pos)' => esc_html__( 'Custom', 'burido-core' ),
                ],
                'default' => 'center center',
                'condition' => [ 'title_first_gradient_type' => 'radial' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => 'background-color: transparent; background-image: radial-gradient(circle at {{VALUE}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_first_gradient_h_position',
            [
                'label' => esc_html__('Horizontal Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_first_gradient_type' => 'radial',
                    'title_first_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 50, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => '--h-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_first_gradient_v_position',
            [
                'label' => esc_html__('Vertical Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_first_gradient_type' => 'radial',
                    'title_first_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-1 > span' => '--v-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLES -> TITLE SECOND GRADIENT
         */

        $this->start_controls_section(
            'style_title_second_gradient',
            [
                'label' => esc_html__('Gradient for the Second Part', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'title_second_gradient!' => '' ],
            ]
        );
        $this->add_control(
            'title_second_gradient_color_1',
            [
                'label' => esc_html__('Primary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => '--gradient-color-1: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_second_gradient_color_2',
            [
                'label' => esc_html__('Secondary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => '--gradient-color-2: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_second_gradient_location_1',
            [
                'label' => esc_html__('First Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 0 ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => '--gradient-location-1: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_second_gradient_location_2',
            [
                'label' => esc_html__('Second Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => '--gradient-location-2: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'title_second_gradient_type',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'linear' => esc_html__( 'Linear', 'burido-core' ),
                    'radial' => esc_html__( 'Radial', 'burido-core' ),
                ],
                'default' => 'radial',
                'render_type' => 'ui',
            ]
        );
        $this->add_responsive_control(
            'title_second_gradient_angle',
            [
                'label' => esc_html__('Angle', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'default' => [ 'unit' => 'deg', 'size' => 180 ],
                'range' => [
                    'deg' => [ 'step' => 10 ],
                ],
                'condition' => [ 'title_second_gradient_type' => 'linear' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_second_gradient_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'burido-core' ),
                    'center left' => esc_html__( 'Center Left', 'burido-core' ),
                    'center right' => esc_html__( 'Center Right', 'burido-core' ),
                    'top center' => esc_html__( 'Top Center', 'burido-core' ),
                    'top left' => esc_html__( 'Top Left', 'burido-core' ),
                    'top right' => esc_html__( 'Top Right', 'burido-core' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'burido-core' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'burido-core' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'burido-core' ),
                    'var(--h-pos) var(--v-pos)' => esc_html__( 'Custom', 'burido-core' ),
                ],
                'default' => 'center center',
                'condition' => [ 'title_second_gradient_type' => 'radial' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => 'background-color: transparent; background-image: radial-gradient(circle at {{VALUE}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_second_gradient_h_position',
            [
                'label' => esc_html__('Horizontal Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_second_gradient_type' => 'radial',
                    'title_second_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 50, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => '--h-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_second_gradient_v_position',
            [
                'label' => esc_html__('Vertical Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_second_gradient_type' => 'radial',
                    'title_second_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-2 > span' => '--v-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLES -> TITLE THIRD GRADIENT
         */

        $this->start_controls_section(
            'style_title_third_gradient',
            [
                'label' => esc_html__('Gradient for the Third Part', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'title_third_gradient!' => '' ],
            ]
        );
        $this->add_control(
            'title_third_gradient_color_1',
            [
                'label' => esc_html__('Primary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => '--gradient-color-1: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_third_gradient_color_2',
            [
                'label' => esc_html__('Secondary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => '--gradient-color-2: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_third_gradient_location_1',
            [
                'label' => esc_html__('First Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 0 ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => '--gradient-location-1: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_third_gradient_location_2',
            [
                'label' => esc_html__('Second Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => '--gradient-location-2: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'title_third_gradient_type',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'linear' => esc_html__( 'Linear', 'burido-core' ),
                    'radial' => esc_html__( 'Radial', 'burido-core' ),
                ],
                'default' => 'radial',
                'render_type' => 'ui',
            ]
        );
        $this->add_responsive_control(
            'title_third_gradient_angle',
            [
                'label' => esc_html__('Angle', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'default' => [ 'unit' => 'deg', 'size' => 180 ],
                'range' => [
                    'deg' => [ 'step' => 10 ],
                ],
                'condition' => [ 'title_third_gradient_type' => 'linear' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_third_gradient_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'burido-core' ),
                    'center left' => esc_html__( 'Center Left', 'burido-core' ),
                    'center right' => esc_html__( 'Center Right', 'burido-core' ),
                    'top center' => esc_html__( 'Top Center', 'burido-core' ),
                    'top left' => esc_html__( 'Top Left', 'burido-core' ),
                    'top right' => esc_html__( 'Top Right', 'burido-core' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'burido-core' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'burido-core' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'burido-core' ),
                    'var(--h-pos) var(--v-pos)' => esc_html__( 'Custom', 'burido-core' ),
                ],
                'default' => 'center center',
                'condition' => [ 'title_third_gradient_type' => 'radial' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => 'background-color: transparent; background-image: radial-gradient(circle at {{VALUE}}, var(--gradient-color-1) var(--gradient-location-1), var(--gradient-color-2) var(--gradient-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_third_gradient_h_position',
            [
                'label' => esc_html__('Horizontal Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_third_gradient_type' => 'radial',
                    'title_third_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 50, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => '--h-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_third_gradient_v_position',
            [
                'label' => esc_html__('Vertical Position', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => -2560, 'max' => 2560 ],
                    '%' => [ 'min' => -100, 'max' => 200 ],
                    'vw' => [ 'min' => -100, 'max' => 100 ],
                ],
                'condition' => [
                    'title_third_gradient_type' => 'radial',
                    'title_third_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__title-3 > span' => '--v-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'style_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['content!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}} .dblh__content',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '17',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .dblh__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .dblh__content' => 'color: {{VALUE}};',
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
                'condition' => [ 'content_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_content_color_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .dblh__content' => 'color: {{VALUE}};'
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
                'condition' => [ 'content_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .dblh__content' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLES -> SUBTITLE
         */

        $this->start_controls_section(
            'style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => ['default' => [ 'size' => 14, 'unit' => 'px' ]],
                    'font_weight' => ['default' => 600],
                    'line_height' => ['default' => ['size' => 1.143, 'unit' => 'em']],
                    'text_transform' => ['default' => 'uppercase'],
                ],
                'selector' => '{{WRAPPER}} .dblh__subtitle',
            ]
        );

        $this->add_control(
            'sub_title_tag',
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
                'default' => 'div',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '14',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '12',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .dblh__subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .dblh__subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__subtitle' => 'color: {{VALUE}};',
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
                'condition' => [ 'subtitle_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dblh__subtitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_bg_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .dblh__subtitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'subtitle_shadow',
                'selector' => '{{WRAPPER}} .dblh__subtitle',
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

        echo '<div class="wgl-double-heading' . ( isset($_s['cursor_tooltip']) && !empty($_s['cursor_tooltip']) ? ' wgl-cursor-text' : '' ) . '"' . $cursor_data . '>';

        if ($_s['subtitle']) {
            echo '<', $_s['sub_title_tag'], ' class="dblh__subtitle">',
                $_s['subtitle'],
            '</', $_s['sub_title_tag'], '>';
        }

        if (
            $_s['title_part-1']
            || $_s['title_part-2']
            || $_s['title_part-3']
        ) {

            if (!empty($_s['link']['url'])) {
                $this->add_render_attribute('link', 'class', 'dblh__link');
                $this->add_link_attributes('link', $_s['link']);

                echo '<a ', $this->get_render_attribute_string('link'), '>';
            }

            echo '<', $_s['title_tag'], ' class="dblh__title-wrapper">',
                $_s['title_part-1'] ? '<span class="dblh__title dblh__title-1"><span>' . $_s['title_part-1'] . '</span></span>' : '',
                $_s['title_part-2'] ? '<span class="dblh__title dblh__title-2"><span>' . $_s['title_part-2'] . '</span></span>' : '',
                $_s['title_part-3'] ? '<span class="dblh__title dblh__title-3"><span>' . $_s['title_part-3'] . '</span></span>' : '',
            '</', $_s['title_tag'], '>';

            if (!empty($_s['link']['url'])) {
                echo '</a>';
            }
        }

        if ($_s['content']) {
            echo '<div class="dblh__content">',
                $_s['content'],
            '</div>';
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
