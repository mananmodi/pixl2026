<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-pricing-table.php`.
 */
namespace WGL_Extensions\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use Elementor\{Control_Media,
    Group_Control_Image_Size,
    Icons_Manager,
    Utils,
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Icons,
    Templates\WGL_Button
};

class WGL_Pricing_Table extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-pricing-table';
    }

    public function get_title()
    {
        return esc_html__( 'WGL Pricing Table', 'burido-core' );
    }

    public function get_icon()
    {
        return 'wgl-pricing-table';
    }

    public function get_keywords()
    {
        return [ 'price', 'table' ];
    }

    public function get_categories()
    {
        return [ 'wgl-modules' ];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'content_general',
            [ 'label' => esc_html__( 'General', 'burido-core' ) ]
        );

        $this->add_responsive_control(
            'container_min_height',
            [
                'label' => esc_html__('General Min Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'separator' => 'before',
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 1000],
                ],
                'default' => ['size' => 535],
                'mobile_default' => ['size' => 480],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_v_alignment',
            [
                'label' => esc_html__('General Vertical Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'container_min_height[size]',
                            'operator' => '>',
                            'value' => '0'
                        ],
                    ]
                ],
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
                'default' => 'flex-end',
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'container_h_alignment',
            [
                'label' => esc_html__('General Horizontal Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'burido-core'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Slide up the module.', 'burido-core' ),
            ]
        );

        $this->end_controls_section();


        /**
         * CONTENT -> CONTENT
         */

        $this->start_controls_section(
            'content_content',
            [ 'label' => esc_html__( 'Content', 'burido-core' ) ]
        );

        WGL_Icons::init(
            $this,
            [
                'section' => false,
                'prefix' => 'thumb_',
                'media_types_options' => [
                    '' => [
                        'title' => esc_html__('None', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'image' => [
                        'title' => esc_html__('Thumbnail', 'burido-core'),
                        'icon' => 'far fa-image',
                    ],
                ],
                'default' => [
                    'media_type' => '',
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
		    'pretitle_text',
		    [
			    'label' => esc_html__('Pretitle', 'burido-core'),
			    'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
			    'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: Most popular', 'WGL Pricing Table', 'burido-core' ),
		    ]
	    );

        $this->add_control(
            'title_text',
            [
                'label' => esc_html__( 'Title', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: Pricing Title', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->add_control(
            'title_suffix_enabled',
            [
                'label' => esc_html__( 'Shatter Title Into Parts?', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'title_prefix_text',
            [
                'label' => esc_html__( 'Title Prefix', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_suffix_enabled' => 'yes' ],
                'placeholder' => esc_attr_x( 'ex: 1', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->add_control(
            'title_suffix_text',
            [
                'label' => esc_html__( 'Title Suffix', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_suffix_enabled' => 'yes' ],
            ]
        );

        $this->add_control(
            'currency_text',
            [
                'label' => esc_html__( 'Currency Symbol', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: USD, $, €', 'WGL Pricing Table', 'burido-core' ),
                'default' => esc_html_x( '$', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->add_control(
            'price_text',
            [
                'label' => esc_html__( 'Price', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: 179.99', 'WGL Pricing Table', 'burido-core' ),
                'default' => esc_html_x( '300', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->add_control(
            'currency_right_text',
            [
                'label' => esc_html__( 'Currency Symbol at the End', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: USD, $, €, /', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->add_control(
            'period_text',
            [
                'label' => esc_html__( 'Period', 'burido-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr_x( 'ex: Per Week', 'WGL Pricing Table', 'burido-core' ),
                'default' => esc_html_x( '500', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => esc_html__( 'Description', 'burido-core' ),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'rows' => 1,
            ]
        );

        $this->add_control(
            'bg_text',
            [
                'label' => esc_html__( 'Background Text', 'burido-core' ),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'rows' => 1,
                'placeholder' => esc_attr__('ex: start', 'burido-core'),
                'default' => esc_html_x( 'start', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->add_control(
            'content_wysiwyg',
            [
                'label' => esc_html__( 'Content', 'burido-core' ),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__( 'Your content...', 'burido-core' ),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> BUTTON
         */

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Link', 'burido-core') ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('\'Read More\' Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Use', 'burido-core'),
                'label_off' => esc_html__('Hide', 'burido-core'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'condition' => [ 'add_read_more' => 'yes' ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'condition' => [ 'add_read_more' => 'yes' ],
                'label_block' => true,
                'placeholder' => esc_html__('Read More', 'burido-core'),
                'default' => esc_html__('Choose Plan', 'burido-core'),
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
                'default' => 'button-read-more',
            ]
        );

        $this->add_control(
            'read_more_anim',
            [
                'label' => esc_html__('Read More Animation', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'style_transfer' => true,
                'render_type' => 'template',
                'options' => [
                    'default' => esc_html__( 'Default', 'burido-core' ),
                    'reverse' => esc_html__( 'Reverse', 'burido-core' ),
                    'disable' => esc_html__( 'Disable', 'burido-core' ),
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'button_type' => 'button-read-more',
                ],
                'prefix_class' => 'button_animation-',
                'default' => 'disable',
            ]
        );

        $this->add_control(
            'read_more_icon_type',
            [
                'label' => esc_html__('Icon Type', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'label_block' => false,
                'condition' => [
                    'add_read_more' => 'yes',
                    'button_type' => 'wgl-button',
                ],
                'toggle' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__('None', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'font' => [
                        'title' => esc_html__('Icon', 'burido-core'),
                        'icon' => 'far fa-smile',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'burido-core'),
                        'icon' => 'far fa-image',
                    ]
                ],
                'default' => 'font',
            ]
        );

        $this->add_control(
            'read_more_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'add_read_more' => 'yes',
                    'button_type' => 'wgl-button',
                ],
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
            ]
        );

        $this->add_control(
            'read_more_icon_align',
            [
                'label' => esc_html__( 'Position', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type!' => '',
                    'button_type' => 'wgl-button',
                ],
                'options' => [
                    'row' => esc_html__( 'Before', 'burido-core' ),
                    'row-reverse' => esc_html__( 'After', 'burido-core' ),
                ],
                'default' => 'row-reverse',
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .button__content' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_indent',
            [
                'label' => esc_html__( 'Icon/Image Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_text!' => '',
                    'read_more_icon_type' => ['font','image'],
                    'button_type' => 'wgl-button',
                ],
                'range' => [
                    'px' => [ 'max' => 250 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_top',
            [
                'label' => esc_html__('Icon/Image Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => ['min' => -50, 'max' => 50],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_text!' => '',
                    'read_more_icon_type' => ['font','image'],
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-pricing__button .wgl-pricing__button__media img' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_type' => 'wgl-button',
                ],
                'range' => [
                    'px' => ['min' => 10, 'max' => 200 ],
                ],
                'default' => ['size' => 26],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => '--icon-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_image_size',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'custom'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 200],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'image',
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .wgl-pricing__button__media img' => 'width: {{SIZE}}{{UNIT}};',
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
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .wgl-icon path' => 'stroke-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_section();


        /**
         * CONTENT -> CREEPING LINE
         */

        $this->start_controls_section(
            'section_content_creeping_line',
            [ 'label' => esc_html__('Creeping Line', 'burido-core') ]
        );

        $this->add_control(
            'creeping_line_switch',
            [
                'label' => esc_html__('Use Creeping Line?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'creeping_line_text',
            [
                'label' => esc_html__('Creeping Line Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'condition' => [ 'creeping_line_switch' => 'yes' ],
                'label_block' => true,
                'default' => esc_html_x( 'Optimal Pricing Plan', 'WGL Pricing Table', 'burido-core' ),
            ]
        );

        $this->end_controls_section();

        /** STYLE -> CONTAINER */

        $this->start_controls_section(
            'style_container',
            [
                'label' => esc_html__( 'Container', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'container_max_width',
            [
                'label' => esc_html__( 'Max Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'vw', 'custom'],
                'range' => [
                    'px' => [ 'min' => 250, 'max' => 850 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing_plan' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_overflow',
            [
                'label' => esc_html__('The overflow of Price Section is clipped?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '124',
                    'right' => '40',
                    'bottom' => '28',
                    'left' => '40',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '105',
                    'right' => '30',
                    'bottom' => '20',
                    'left' => '30',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '95',
                    'right' => '20',
                    'bottom' => '17',
                    'left' => '20',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                        'selectors' => [
                            '{{SELECTOR}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{SELECTOR}}::before,
                             {{SELECTOR}}::after' => 'top: -{{TOP}}{{UNIT}}; right: -{{RIGHT}}{{UNIT}}; bottom: -{{BOTTOM}}{{UNIT}}; left: -{{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .pricing__wrapper',
            ]
        );

        $this->add_control(
            'container_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_shadow',
                'selector' => '{{WRAPPER}} .pricing__wrapper',
            ]
        );

        $this->start_controls_tabs( 'containers');
        $this->start_controls_tab(
            'container_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'container_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_comments_form_bg(),
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['container_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_border_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'container_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_border_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'container_border_border!' => ['', 'none'],
                    'container_border_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'container_hover',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'container_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['container_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_border_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'container_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_border_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'container_border_border!' => ['', 'none'],
                    'container_border_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> BACKGROUND OVERLAY */

        $this->start_controls_section(
            'style_bg_overlay',
            [
                'label' => esc_html__( 'Background Overlay', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'container_bg_first',
                'fields_options' => [
                    'background' => [ 'label' => esc_html__( 'First Background', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .pricing__wrapper::before',
            ]
        );
        $this->add_control(
            'container_bg_first_z_index',
            [
                'label' => esc_html__('First Background z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'condition' => [ 'container_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper::before' => 'z-index: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'container_bg_second',
                'fields_options' => [
                    'background' => [ 'label' => esc_html__( 'Second Background', 'burido-core' ) ],
                ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .pricing__wrapper::after',
            ]
        );
        $this->add_control(
            'container_bg_second_z_index',
            [
                'label' => esc_html__('Second Background z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'condition' => [ 'container_bg_second_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper::after' => 'z-index: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs('containers_bg',
            [
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [[
                        'terms' => [[
                            'name' => 'container_bg_first_background',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ], [
                        'terms' => [[
                            'name' => 'container_bg_second_background',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ],],
                ],
            ]
        );
        $this->start_controls_tab(
            'container_bg_first',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'container_bg_first_idle',
            [
                'label' => esc_html__('Opacity for First Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'container_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'container_bg_second_idle',
            [
                'label' => esc_html__('Opacity for Second Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'container_bg_second_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'container_bg_second',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'container_bg_first_hover',
            [
                'label' => esc_html__('Opacity for First Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'container_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'container_bg_second_hover',
            [
                'label' => esc_html__('Opacity for Second Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'container_bg_second_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /** STYLE -> PRICING THUMBNAIL */
	    $this->start_controls_section(
		    'style_pricing_thumbnail',
		    [
			    'label' => esc_html__( 'Thumbnail', 'burido-core' ),
			    'tab' => Controls_Manager::TAB_STYLE,
			    'condition' => [
			        'thumb_icon_type' => 'image',
			        'thumb_thumbnail[url]!' => ''
                ],
		    ]
	    );

        $this->add_responsive_control(
            'pricing_thumbnail_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'condition' => ['mask_image_animation' => ''],
                'default' => [
                    'top' => '-40',
                    'right' => '-40',
                    'bottom' => '31',
                    'left' => '-40',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '-30',
                    'right' => '-30',
                    'bottom' => '25',
                    'left' => '-30',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '-20',
                    'right' => '-20',
                    'bottom' => '20',
                    'left' => '-20',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_thumbnail_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_thumbnail_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_thumbnail_max_width',
            [
                'label' => esc_html__( 'Max Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 10, 'max' => 500 ],
                    '%' => ['min' => 10, 'max' => 100 ],
                ],
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pricing__thumbnail img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mask_image_animation',
            [
                'label' => esc_html__( 'Mask Image Animation', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->start_controls_tabs('images');
        $this->start_controls_tab(
            'image_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'image_mask_color_idle',
            [
                'label' => esc_html__('Change Color for Image', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'render_type' => 'template',
                'condition' => ['mask_image_animation!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .mask_image' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'image_mask_color_idle-dynamic',
            [
                'label' => esc_html__('Change Color for Image - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'mask_image_animation!' => '',
                    'image_mask_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .mask_image' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'image_opacity_idle',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'image_hover',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'image_mask_color_hover',
            [
                'label' => esc_html__('Change Color for Image', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'render_type' => 'template',
                'condition' => ['mask_image_animation!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .mask_image' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'image_mask_color_hover-dynamic',
            [
                'label' => esc_html__('Change Color for Image - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'mask_image_animation!' => '',
                    'image_mask_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .mask_image' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'image_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .wgl-image-box_img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /** STYLE -> PRETITLE */

	    $this->start_controls_section(
		    'style_pretitle',
		    [
			    'label' => esc_html__( 'Pretitle', 'burido-core' ),
			    'tab' => Controls_Manager::TAB_STYLE,
			    'condition' => [ 'pretitle_text!' => '' ],
		    ]
	    );
	    $this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
			    'name' => 'pretitle_typography',
			    'selector' => '{{WRAPPER}} .pretitle',
		    ]
	    );

        $this->add_responsive_control(
            'pretitle_position',
            [
                'label' => esc_html__('Pretitle Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'static' => esc_html__('Static', 'burido-core'),
                    'absolute' => esc_html__('Absolute', 'burido-core'),
                ],
                'default' => 'absolute',
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .pricing__pretitle' => 'position: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pretitle_width',
            [
                'label' => esc_html__( 'Pretitle Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 768 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pretitle' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
		    'pretitle_margin',
		    [
			    'label' => esc_html__( 'Margin', 'burido-core' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '37',
                    'right' => '31',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'tablet_default' => [
                    'top' => '27',
                    'right' => '21',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '22',
                    'right' => '16',
                    'bottom' => '20',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
			    'selectors' => [
				    '{{WRAPPER}} .pricing__pretitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );
	    $this->add_responsive_control(
		    'pretitle_padding',
		    [
			    'label' => esc_html__( 'Padding', 'burido-core' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '4',
                    'right' => '10',
                    'bottom' => '4',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			    'selectors' => [
				    '{{WRAPPER}} .pretitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );
	    $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'pretitle_border',
			    'fields_options' => [
                    'border' => [ 'default' => 'none' ],
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                    ],
				    'color' => [ 'type' => Controls_Manager::HIDDEN],
			    ],
			    'selector' => '{{WRAPPER}} .pretitle',
		    ]
	    );
	    $this->add_control(
		    'pretitle_radius',
		    [
			    'label' => esc_html__( 'Border Radius', 'burido-core' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			    'selectors' => [
				    '{{WRAPPER}} .pretitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pretitle_shadow',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .pretitle',
            ]
        );
	    $this->start_controls_tabs( 'pretitle' );
	    $this->start_controls_tab(
		    'pretitle_idle',
		    [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
	    );
	    $this->add_control(
		    'pretitle_color_idle',
		    [
			    'label' => esc_html__( 'Text Color', 'burido-core' ),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .pretitle' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'pretitle_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['pretitle_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pretitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pretitle_bg_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .pretitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pretitle_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['pretitle_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pretitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'pretitle_border_color_idle',
		    [
			    'label' => esc_html__( 'Border Color', 'burido-core' ),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [ 'pretitle_border_border!' => ['', 'none'] ],
			    'selectors' => [
				    '{{WRAPPER}} .pretitle' => 'border-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'pretitle_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'pretitle_border_border!' => ['', 'none'],
                    'pretitle_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pretitle' => 'border-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->start_controls_tab(
		    'pretitle_hover',
		    [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
	    );
	    $this->add_control(
		    'pretitle_color_hover',
		    [
			    'label' => esc_html__( 'Text Color', 'burido-core' ),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .pricing__wrapper:hover .pretitle' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'pretitle_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['pretitle_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pretitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pretitle_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pretitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pretitle_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['pretitle_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pretitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'pretitle_border_color_hover',
		    [
			    'label' => esc_html__( 'Border Color', 'burido-core' ),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [ 'pretitle_border_border!' => ['', 'none'] ],
			    'selectors' => [
				    '{{WRAPPER}} .pricing__wrapper:hover .pretitle' => 'border-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'pretitle_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'pretitle_border_border!' => ['', 'none'],
                    'pretitle_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pretitle' => 'border-color: {{VALUE}};',
                ],
            ]
        );
	    $this->end_controls_tab();
	    $this->end_controls_tabs();
	    $this->end_controls_section();

        /** STYLE -> TITLE */

        $this->start_controls_section(
            'style_title',
            [
                'label' => esc_html__( 'Title', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'title_text!' => '' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .pricing__title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}} .pricing__title',
            ]
        );

        $this->add_control(
            'title_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'title' );
        $this->start_controls_tab(
            'title_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing__title' => 'color: {{VALUE}};',
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
                'condition' => ['title_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__title' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_border_border!' => ['', 'none'],
                    'title_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__title' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__title' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_border_border!' => ['', 'none'],
                    'title_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__title' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .pricing__title',
            ]
        );

        $this->end_controls_section();

        /** STYLE -> TITLE PREFIX */

        $this->start_controls_section(
            'style_title_prefix',
            [
                'label' => esc_html__( 'Title Prefix', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                	'title_suffix_enabled' => 'yes',
                	'title_prefix_text!' => ''
                ],
            ]
        );
        $this->add_responsive_control(
            'title_prefix_width',
            [
                'label' => esc_html__( 'Prefix Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 1200 ],
                ],
                'default' => ['size' => '28', 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .title__prefix' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_prefix_typography',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'line_height' => ['default' => ['size' => 28, 'unit' => 'px']],
                ],
                'selector' => '{{WRAPPER}} .title__prefix',
            ]
        );
        $this->add_responsive_control(
            'title_prefix_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '-5',
                    'right' => '10',
                    'bottom' => '-5',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .title__prefix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_prefix_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .title__prefix' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_prefix_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '28',
                    'right' => '28',
                    'bottom' => '28',
                    'left' => '28',
                    'unit'  => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .title__prefix' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'title_prefix');
        $this->start_controls_tab(
            'title_prefix_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'title_prefix_color_idle',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title__prefix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_prefix_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_prefix_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title__prefix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_prefix_bg_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title__prefix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_prefix_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_prefix_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title__prefix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_prefix_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'title_prefix_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .title__prefix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_prefix_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_prefix_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .title__prefix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_prefix_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .title__prefix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_prefix_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_prefix_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .title__prefix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> TITLE SUFFIX */

        $this->start_controls_section(
            'style_title_suffix',
            [
                'label' => esc_html__( 'Title Suffix', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                	'title_suffix_enabled' => 'yes',
                	'title_suffix_text!' => ''
                ],
            ]
        );
        $this->add_responsive_control(
            'title_suffix_width',
            [
                'label' => esc_html__( 'Suffix Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 1200 ],
                ],
                'default' => ['unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .title__suffix' => 'width: {{SIZE}}{{UNIT}}; text-align: center;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_suffix_typography',
                'selector' => '{{WRAPPER}} .title__suffix',
            ]
        );

        $this->add_responsive_control(
            'title_suffix_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '10',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .title__suffix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_suffix_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .title__suffix' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_suffix_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .title__suffix' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('title_suffix');
        $this->start_controls_tab(
            'title_suffix_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'title_suffix_color_idle',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title__suffix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_suffix_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_suffix_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title__suffix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_suffix_bg_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title__suffix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_suffix_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_suffix_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title__suffix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_suffix_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'title_suffix_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .title__suffix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_suffix_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_suffix_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .title__suffix' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_suffix_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .title__suffix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_suffix_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_suffix_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .title__suffix' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> PRICE */

        $this->start_controls_section(
            'style_price',
            [
                'label' => esc_html__( 'Price', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'price_text!' => '' ],
            ]
        );
        $this->add_control(
            'price_order',
            [
                'label' => esc_html__('Price Order (Position)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => -10,
                'max' => 10,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} .pricing__header' => 'order: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .pricing__price',
            ]
        );

        $this->add_responsive_control(
            'price_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '14',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '8',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_value_margin',
            [
                'label' => esc_html__( 'Margin for Value', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '0',
                    'right' => '75',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .price__value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'price_bg',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__header' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'price_bg-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['price_bg!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__header' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'tabs_price' );
        $this->start_controls_tab( 'price_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'price_color_idle',
            [
                'label' => esc_html__( 'Price Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing__price' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__price' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'price_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'price_color_hover',
            [
                'label' => esc_html__( 'Price Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__price' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__price' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> PAYMENT CURRENCY */

        $this->start_controls_section(
            'style_currency',
            [
                'label' => esc_html__( 'Currency Symbol', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'currency_text!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'currency_typography',
                'selector' => '{{WRAPPER}} .price__currency',
            ]
        );

        $this->add_responsive_control(
            'currency_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'horizontal',
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .price__currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'currency_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .price__currency' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'currency_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['currency_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .service__content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /** STYLE -> PAYMENT CURRENCY */

        $this->start_controls_section(
            'style_currency_right',
            [
                'label' => esc_html__( 'Currency Symbol at the End', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'currency_right_text!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'currency_right_typography',

                'selector' => '{{WRAPPER}} .price__currency_right',
            ]
        );

        $this->add_responsive_control(
            'currency_right_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'horizontal',
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '0',
                    'right' => '4',
                    'bottom' => '0',
                    'left' => '4',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .price__currency_right' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'currency_right_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .price__currency_right' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'currency_right_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['currency_right_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .price__currency_right' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /** STYLE -> PAYMENT PERIOD */

        $this->start_controls_section(
            'style_period',
            [
                'label' => esc_html__( 'Period', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'period_text!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'period_typography',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'text_decoration' => ['default' => 'line-through'],
                ],
                'selector' => '{{WRAPPER}} .price__period',
            ]
        );

        $this->add_control(
            'period_wrap',
            [
                'label' => esc_html__( 'Enable Flex-Wrap', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .pricing__price' => 'flex-wrap: wrap;',
                ],
            ]
        );

        $this->add_responsive_control(
            'period_width',
            [
                'label' => esc_html__( 'Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 1200 ],
                    '%' => ['min' => 0,'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .price__period' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'period_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .price__period' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'period_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .price__period' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'period_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .price__period' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_period' );
        $this->start_controls_tab( 'period_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'period_color_idle',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .price__period' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'period_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['period_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .price__period' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'period_bg_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .price__period' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'period_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['period_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .price__period' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'period_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'period_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .price__period' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .price__period' => 'transition: .4s;',
                ],
            ]
        );
        $this->add_control(
            'period_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['period_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .price__period' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'period_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .price__period' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .price__period' => 'transition: .4s;',
                ],
            ]
        );
        $this->add_control(
            'period_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['period_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .price__period' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_description',
            [
                'label' => esc_html__( 'Description', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'description_text!' => '' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .pricing__description',
            ]
        );
        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '3',
                    'right' => '0',
                    'bottom'=> '0',
                    'left' => '0',
	                'unit'  => 'px',
	                'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'description_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'description_radius',
            [
                'label' => esc_html__( 'Border Radius', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'tabs_description' );
        $this->start_controls_tab( 'description_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'description_color_idle',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing__description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'description_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['description_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'description_bg_idle',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__description' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'description_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['description_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__description' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'description_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'description_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'description_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['description_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'description_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__description' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'description_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['description_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__description' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> CONTENT */

        $this->start_controls_section(
            'style_content',
            [
                'label' => esc_html__( 'Content', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'content_wysiwyg!' => '' ],
            ]
        );
        $this->add_control(
            'content_order',
            [
                'label' => esc_html__('Content Order (Position)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => -10,
                'max' => 10,
                'selectors' => [
                    '{{WRAPPER}} .pricing__content' => 'order: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'fields_options' => [
                    'typography' => [ 'default' => 'yes' ],
                    'font_size' => ['default' => ['size' => 18]],
                    'font_weight' => [ 'default' => 500 ],
                ],
                'selector' => '{{WRAPPER}} .pricing__content',
            ]
        );
        $this->add_responsive_control(
            'content_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start; text-align: left' => [
                        'title' => esc_html__( 'Left', 'burido-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center; text-align: center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end; text-align: right' => [
                        'title' => esc_html__( 'Right', 'burido-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start; text-align: left',
                'selectors' => [
                    '{{WRAPPER}} pricing__content,
                     {{WRAPPER}} pricing__content ul[class*="burido_"]' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '41',
                    'right' => '0',
                    'bottom'=> '19',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '32',
                    'right' => '0',
                    'bottom'=> '15',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__( 'Border Width', 'burido-core' ),
                    ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .pricing__content',
            ]
        );
        $this->start_controls_tabs( 'tabs_content' );
        $this->start_controls_tab( 'content_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'content_color_idle',
            [
                'label' => esc_html__( 'Content Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing__content' => 'color: {{VALUE}};',
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
                'condition' => ['content_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'content_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__content' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'content_border_border!' => ['', 'none'],
                    'content_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__content' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'content_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__( 'Content Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__content' => 'color: {{VALUE}};',
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
                'condition' => ['content_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'content_border_border!' => ['', 'none'] ],
                'default' => 'rgba(255,255,255,0.15)',
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__content' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'content_border_border!' => ['', 'none'],
                    'content_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__content' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /** STYLE -> BG TEXT */

        $this->start_controls_section(
            'style_bg_text',
            [
                'label' => esc_html__( 'Background Text', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'bg_text!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bg_text_typography',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 96],
                        'mobile_default' => ['size' => 78],
                    ],
                    'font_weight' => ['default' => 400],
                    'line_height' => ['default' => ['size' => 1.25, 'unit' => 'em']],
                ],
                'selector' => '{{WRAPPER}} .pricing__bg_text',
            ]
        );
        $this->add_responsive_control(
            'bg_text_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
                    'top' => '22',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '40',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__bg_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'tabs_bg_text' );
        $this->start_controls_tab( 'bg_text_idle',
            [ 'label' => esc_html__( 'Idle', 'burido-core' ) ]
        );
        $this->add_control(
            'bg_text_color_idle',
            [
                'label' => esc_html__( 'Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing__bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'bg_text_hover',
            [ 'label' => esc_html__( 'Item Hover', 'burido-core' ) ]
        );
        $this->add_control(
            'bg_text_color_hover',
            [
                'label' => esc_html__( 'Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__wrapper:hover .pricing__bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__wrapper:hover .pricing__bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> CREEPING LINE */

        $this->start_controls_section(
            'style_creeping_line',
            [
                'label' => esc_html__( 'Creeping Line', 'burido-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
	            'condition' => [ 'creeping_line_switch!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'creeping_line_typography',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes',
                    ],
                    'font_weight' => [
                        'default' => 500,
                    ],
                ],
                'selector' => '{{WRAPPER}} .pricing__content',
            ]
        );

        $this->add_responsive_control(
            'creeping_line_margin',
            [
                'label' => esc_html__( 'Margin', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__creeping_line' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'creeping_line_padding',
            [
                'label' => esc_html__( 'Padding', 'burido-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'allowed_dimensions' => 'horizontal',
                'default' => [
                    'top' => '',
                    'right' => '7',
                    'bottom'=> '',
                    'left' => '6',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing__creeping_line' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'creeping_line_color',
            [
                'label' => esc_html__( 'Text Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing__creeping_line' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'creeping_line_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['creeping_line_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .pricing__creeping_line' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'creeping_line_bg',
                'fields_options' => [
                    'background' => [ 'default' => 'classic' ],
                    'color' => [ 'label' => esc_html__( 'Background Color', 'burido-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .pricing__creeping_line',
            ]
        );

        $this->end_controls_section();


        /**
         * STYLE -> BUTTON
         */

        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['add_read_more!' => ''],
            ]
        );
        $this->add_control(
            'button_order',
            [
                'label' => esc_html__('Button Order (Position)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => -10,
                'max' => 10,
                'default' => '2',
                'selectors' => [
                    '{{WRAPPER}} .pricing__button' => 'order: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => ['default' => ['size' => 24]],
                ],
                'selector' => '{{WRAPPER}} .wgl-pricing__button .button__text',
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
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 20, 'step' => 1],
                    'em' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .button__text' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
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
                    'custom_fonts_button_text_decoration' => 'underline' ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => -20, 'max' => 20, 'step' => 1],
                    'em' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .button__text' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '31',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '25',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
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
                    '{{WRAPPER}} .wgl-pricing__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .wgl-pricing__button',
            ]
        );


        $this->add_control(
            'read_more_button_width',
            [
                'label' => esc_html__( 'Button Min-Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_alignment!' => ['space-evenly', 'space-around', 'space-between'],
                ],
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'range' => [
                    'px' => ['max' => 500],
                    '%' => ['max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => 'min-width: {{SIZE}}{{UNIT}};',
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
                'default' => 'left',
                'prefix_class' => 'button_',
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_position',
            [
                'label' => esc_html__('Button Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'relative' => esc_html__('Default', 'burido-core'),
                    'absolute' => esc_html__('Absolute', 'burido-core'),
                ],
                'default' => 'relative',
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'position: {{VALUE}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'button_position_offset_x',
			[
				'label' => esc_html__( 'Offset X', 'burido-core' ),
				'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%', 'vw', 'vh', 'custom' ],
                'condition' => [
                    'button_position!' => 'relative',
                ],
				'selectors' => [
					'{{WRAPPER}} .wgl-button-wrapper' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'button_position_offset_y',
			[
				'label' => esc_html__( 'Offset Y', 'burido-core' ),
				'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%', 'vh', 'vw', 'custom' ],
                'condition' => [
                    'button_position!' => 'relative',
                ],
				'selectors' => [
					'{{WRAPPER}} .wgl-button-wrapper' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button' );
        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle' , 'burido-core') ]
        );
        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => 'color: {{VALUE}};',
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
                'condition' => ['button_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-pricing__button,
                     {{WRAPPER}} .wgl-pricing__button::before' => 'background-color: {{VALUE}};',
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
                    'button_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button' => 'background-color: {{VALUE}};',
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
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button .button__text' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
		    'button_icon_color_idle',
		    [
			    'label' => esc_html__('Icon Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-pricing__button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
		    'button_icon_bg_color_idle',
		    [
			    'label' => esc_html__('Icon BG Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-pricing__button .wgl-icon,
				     {{WRAPPER}} .wgl-pricing__button .wgl-icon::before' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'button_icon_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
		    'button_icon_stroke_idle',
		    [
			    'label' => esc_html__('Stroke Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
			    'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .wgl-icon' => 'stroke: {{VALUE}}'
			    ],
		    ]
	    );
        $this->add_control(
            'button_icon_stroke_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button .wgl-icon' => 'stroke: {{VALUE}}'
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
                    'button_border_border!' => ['', 'none']
	            ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-pricing__button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_idle',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .wgl-pricing__button',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_idle',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pricing__button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
        'tab_button_item_hover',
            ['label' => esc_html__('Item Hover', 'burido-core')]
        );
        $this->add_control(
            'button_color_item_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_item_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_item_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_item_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button,
                     {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_item_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_bg_item_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_item_hover',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .button__text' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_item_hover-dynamic',
            [
                'label' => esc_html__('Decoration Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .button__text' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_item_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_item_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_item_hover',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_item_hover-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_item_hover',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_item_hover-dynamic',
            [
                'label' => esc_html__('Icon Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_item_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'button_border_color_item_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_item_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_item_hover',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_item_hover',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_item_hover',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
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
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover' => 'color: {{VALUE}};',
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
                'condition' => ['button_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover,
                     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover::before' => 'background-color: {{VALUE}}',
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
                    'button_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover' => 'background-color: {{VALUE}}',
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
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_hover',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_hover',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_hover-dynamic',
            [
                'label' => esc_html__('Icon Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_hover',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_hover',
            [
                'label' => esc_html__( 'Icon Rotate', 'burido-core' ),
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
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_type' => 'font' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-pricing__button' => '--wgl-icon-wrapper: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-pricing__button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-pricing__button::after' => 'left:{{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-pricing__button::after' => '--bg-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-pricing__button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:focus::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:focus::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:focus::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:focus::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:active::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:active::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:active::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:active::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button' => '--ab-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-pricing__button' => '--ab-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button' => '--ab-offset: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button' => '--ab-width: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button' => '--ab-extend: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-pricing__button .wgl-icon' => '--icon-bg-size: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-pricing__button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-pricing__button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-pricing__button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:focus .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-pricing__button:focus .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:active .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-pricing__button:active .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
        $wrapper_classes = $this->get_settings_for_display( 'hover_animation' ) ? ' hover-animation' : '';

        echo '<div class="wgl-pricing_plan', $wrapper_classes, '">',
            '<div class="pricing__wrapper">',

                $this->get_creeping_line(),
                $this->get_bg_text(),
                $this->get_pricing_thumbnail(),

                '<div class="pricing__pretitle">',
                    $this->get_pricing_pretitle(),
                '</div>',

                $this->get_pricing_title(),

                '<div class="pricing__header">',
                    '<div class="pricing__price">',
                        $this->get_currency(),
                        $this->get_price_value(),
                        $this->get_currency_right(),
                        $this->get_period(),
                    '</div>',
                '</div>',

                $this->get_description(),

                '<div class="pricing__content">',
                    $this->get_settings_for_display( 'content_wysiwyg' ),
                '</div>',

                '<div class="pricing__button">',
                    $this->get_button(),
                '</div>',

            '</div>',
        '</div>';
    }

    protected function get_pricing_title()
    {
        $title = $this->get_settings_for_display( 'title_text' );
        $prefix = $this->get_settings_for_display( 'title_prefix_text' );
        $suffix = $this->get_settings_for_display( 'title_suffix_text' );

        if ( !$title ) return;

        $prefix = $prefix ? '<span class="title__prefix">' . $prefix  . '</span>' : '';
        $suffix = $suffix ? '<span class="title__suffix">' . $suffix  . '</span>' : '';

        return '<div class="pricing__title">'
                . '<h4 class="title">'
                    . $prefix
                    . wp_kses( $title, self::get_kses_allowed_html() )
                    . $suffix
                . '</h4>'
            . '</div>';
    }

    protected function get_pricing_thumbnail()
    {
        $_s = $this->get_settings_for_display();
        $this->add_render_attribute('thumbnail', 'class', 'pricing__thumbnail');

        $url_image = $_s['thumb_thumbnail']['url'] ?? false;
        if(!!$url_image){
            $has_mask = $_s['mask_image_animation'] === 'yes' && !empty($_s['image_mask_color_idle']) && !!$url_image;
            if ($has_mask) {
                $this->add_render_attribute(
                    'thumbnail',
                    [
                        'class' => 'mask_image',
                        'style' => '-webkit-mask-image: url('.esc_url($url_image).');'
                    ]
                );
            }

            $icons = new WGL_Icons;
            return '<div '.$this->get_render_attribute_string('thumbnail').'>'.$icons->build($this, $_s, 'thumb_').'</div>';
        }
        return false;
    }

    protected function get_pricing_pretitle()
    {
        $pretitle = $this->get_settings_for_display( 'pretitle_text' );
        if ( !$pretitle ) return;

        return '<h6 class="pretitle">'
                . wp_kses( $pretitle, self::get_kses_allowed_html() )
            . '</h6>';
    }

    protected function get_currency()
    {
        $currency = $this->get_settings_for_display( 'currency_text' );
        if ( !$currency ) return;

        return '<span class="price__currency">'
                . esc_html( $currency )
            . '</span>';
    }

    protected function get_currency_right()
    {
        $currency = $this->get_settings_for_display( 'currency_right_text' );
        if ( !$currency ) return;

        return '<span class="price__currency_right">'
                . esc_html( $currency )
            . '</span>';
    }

    protected function get_period()
    {
        $period = $this->get_settings_for_display( 'period_text' );
        if ( !$period ) return;

        return '<span class="price__period">'
                . wp_kses( $period, self::get_kses_allowed_html() )
            . '</span>';
    }

    protected function get_description()
    {
        $description = $this->get_settings_for_display( 'description_text' );
        if ( !$description ) return;

        return '<div class="pricing__description">'
                . wp_kses( trim( $description ), self::get_kses_allowed_html() )
            . '</div>';
    }

    protected function get_bg_text()
    {
        $bg_text = $this->get_settings_for_display( 'bg_text' );
        if ( !$bg_text ) return;

        return '<div class="pricing__bg_text">'
                . wp_kses(  $bg_text, self::get_kses_allowed_html() )
            . '</div>';
    }

    protected function get_creeping_line()
    {
        $creeping_line_text = $this->get_settings_for_display( 'creeping_line_text' );
        if ( !$creeping_line_text ) return;

        $render = '<span>' . wp_kses(  $creeping_line_text, self::get_kses_allowed_html() ) . '</span>';

        return '<div class="pricing__creeping_line">'.
            '<div class="pricing__creeping_line__inner">' . str_repeat($render,10) . '</div>'.
            '<div class="pricing__creeping_line__inner">' . str_repeat($render,10) . '</div>'.
        '</div>';
    }

    protected function get_price_value()
    {
        $price = esc_html( $this->get_settings_for_display( 'price_text' ));
        if ( !$price ) return;

        preg_match( '/(.+)(\.| |,)(\d+)$/', $price, $matches, PREG_OFFSET_CAPTURE );
        if ( isset( $matches[ 0 ] ) ) {
            $price = esc_html( $matches[ 1 ][ 0 ] )
                . '<span class="price_decimal">'
                    . '<span class="price_decimal_sep">'.esc_html( $matches[ 2 ][ 0 ] ) . '</span>'
                    . esc_html( $matches[ 3 ][ 0 ] )
                . '</span>';
        }

        return '<span class="price__value">'
                . $price
            . '</span>';
    }

    protected function get_button()
    {
        $_s = $this->get_settings_for_display();
        if ( !$_s['add_read_more'] ) return;

        // Link
        if (!empty($_s['link']['url'])) {
            $this->add_link_attributes('link', $_s['link']);
        }

        // Read more button
        $s_button = '';
        if ($_s['add_read_more']) {
            $this->add_render_attribute('btn', 'class',
                [
                    'wgl-pricing__button',
                        $_s['button_type'] ?? '',
                    !$_s['read_more_text'] ? 'no_text' : ''
                ]
            );

            $btn_icon = '';
            // ↓ Icon|Image
            if ('' !== $_s['read_more_icon_type'] ) {
                if (
                    'font' === $_s['read_more_icon_type']
                ) {
                    if(isset($_s['read_more_icon_fontawesome']['value'])) {
                        $migrated = isset( $_s['__fa4_migrated']['read_more_icon_fontawesome'] );
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
                }

                if (
                    'image' === $_s['read_more_icon_type']
                    && !empty($_s['read_more_icon_thumbnail']['url'])
                ) {
                    $this->add_render_attribute('thumbnail', 'src', $_s['read_more_icon_thumbnail']['url']);
                    $this->add_render_attribute('thumbnail', 'alt', Control_Media::get_image_alt($_s['read_more_icon_thumbnail']));
                    $this->add_render_attribute('thumbnail', 'title', Control_Media::get_image_title($_s['read_more_icon_thumbnail']));

                    $media_html = Group_Control_Image_Size::get_attachment_image_html($_s, 'thumbnail', 'read_more_icon_thumbnail');
                    $btn_icon = '<span class="wgl-pricing__button__media">'.$media_html.'</span>';
                    $this->add_render_attribute(['btn' => ['class' => [ 'image']]]);
                }
            }else{
                $this->add_render_attribute(['btn' => ['class' => [ 'no_media']]]);
            }

            // ↑ icon|image

            $s_button = '<div class="wgl-button-wrapper">';
                $s_button .= sprintf(
                    '<%s %s %s>',
                    'a',
                    $this->get_render_attribute_string('link'),
                    $this->get_render_attribute_string('btn')
                );
                    $s_button .= 'wgl-button' === $_s['button_type'] ? '<div class="button__content">' : '';
                        $s_button .= $btn_icon ?: '';
                        $s_button .= $_s['read_more_text'] ? '<span class="button__text">' . esc_html($_s['read_more_text']) . '</span>' : '';
                    $s_button .= 'wgl-button' === $_s['button_type'] ? '</div>' : '';
                $s_button .= '</a>';
            $s_button .= '</div>';
        }

        return $s_button;
    }

    protected static function get_kses_allowed_html()
    {
        $allowed_attributes = [
            'id' => true,
            'class' => true,
            'style' => true,
        ];

        return [
            'a' => $allowed_attributes + [
                'href' => true,
                'title' => true,
                'rel' => true,
                'target' => true,
            ],
            'br' => $allowed_attributes,
            'b' => $allowed_attributes,
            'strong' => $allowed_attributes,
            'em' => $allowed_attributes,
            'i' => $allowed_attributes,
            'small' => $allowed_attributes,
            'sup' => $allowed_attributes,
            'sub' => $allowed_attributes,
            'span' => $allowed_attributes,
            'p' => $allowed_attributes,
            'ul' => $allowed_attributes,
            'ol' => $allowed_attributes,
            'li' => $allowed_attributes,
        ];
    }

    public function wpml_support_module()
    {
        add_filter( 'wpml_elementor_widgets_to_translate',  [ $this, 'wpml_widgets_to_translate_filter' ] );
    }

    public function wpml_widgets_to_translate_filter( $widgets )
    {
        return \WGL_Extensions\Includes\WGL_WPML_Settings::get_translate(
            $this, $widgets
        );
    }
}
