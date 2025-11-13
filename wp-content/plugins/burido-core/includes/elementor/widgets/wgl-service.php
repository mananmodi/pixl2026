<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-service.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Border,
    Plugin,
    Widget_Base,
    Controls_Manager,
    Icons_Manager,
    Group_Control_Image_Size,
    Control_Media,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background,
    Group_Control_Css_Filter};

use WGL_Extensions\{
    Includes\WGL_Icons,
    Includes\WGL_Cursor,
    WGL_Framework_Global_Variables as WGL_Globals,
};

class WGL_Service extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-service';
    }

    public function get_title()
    {
        return esc_html__('WGL Service', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-services-1';
    }

    public function get_keywords()
    {
        return [ 'service', 'animation' ];
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> SERVICE CONTENT
         */

        $this->start_controls_section(
            'wgl_service_content',
            ['label' => esc_html__('Service Content', 'burido-core')]
        );

        $this->add_control(
            's_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'rows' => 1,
                'default' => esc_html__('Service Title', 'burido-core'),
            ]
        );

        $this->add_control(
            's_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Service Subtitle', 'burido-core'),
            ]
        );

        $this->add_control(
            's_bg_text',
            [
                'label' => esc_html__('Background Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('ex: 01', 'burido-core'),
            ]
        );

        $this->add_control(
            's_description',
            [
                'label' => esc_html__('Description', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis.', 'burido-core'),
            ]
        );

        $this->add_control(
            'alignment',
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
                'default' => 'left',
                'prefix_class' => 'a',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'full_height',
            [
                'label' => esc_html__('Full Height Column', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'full',
                'prefix_class' => 'height_',
                'default' => 'full',
            ]
        );

        $this->add_control(
            'toggling_image',
            [
                'label' => esc_html__('Toggle Image Visibility', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'image',
                'prefix_class' => 'toggling_',
            ]
        );
        $this->add_control(
            'toggling_content',
            [
                'label' => esc_html__('Toggle Content Visibility', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'content',
                'prefix_class' => 'toggling_',
                'default' => 'content',
            ]
        );

        $this->add_responsive_control(
            'container_height',
            [
                'label' => esc_html__('Set Minimum Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'vw', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 1000],
                    'vw' => ['min' => 10, 'max' => 70],
                ],
                'default' => ['size' => 570, 'unit' => 'px'],
                'tablet_default' => ['size' => 500, 'unit' => 'px'],
                'mobile_default' => ['size' => 400, 'unit' => 'px'],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'toggling_content',
                            'operator' => '!==',
                            'value' => '',
                        ], [
                            'name' => 'toggling_image',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service ' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'toggling_content',
                            'operator' => '!==',
                            'value' => '',
                        ], [
                            'name' => 'toggling_image',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'range' => [
                    'px' => ['min' => 0.1, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 0.6 ],
                'selectors' => [
                    '{{WRAPPER}}.toggling_content .wgl-service_description,
                    {{WRAPPER}}.toggling_image .wgl-service_media' => '--dur: {{SIZE}}s;',
                ],
            ]
        );

        $this->add_mobile_breakpoint();

        $this->end_controls_section();

        /**
         * CONTENT -> ICON/IMAGE
         */

        $output = [];

        WGL_Icons::init(
            $this,
            [
                'output' => $output,
                'section' => true,
                'default' => [
                    'icon' => [
                        'library' => 'fa-solid',
                        'value' => 'fas fa-arrow-right',
                    ],
                ],
            ]
        );

        /**
         * CONTENT -> BUTTON
         */

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Link', 'burido-core') ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'module_link',
                            'operator' => '!=',
                            'value' => '',
                        ],
                        [
                            'name' => 'add_read_more',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'module_link',
            [
                'label' => esc_html__('Whole Module Link', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
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
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'condition' => [ 'add_read_more' => 'yes' ],
                'label_block' => true,
                'placeholder' => esc_html__('Read More', 'burido-core'),
                'default' => esc_html__('Read More', 'burido-core'),
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
                    '{{WRAPPER}} .wgl-service_button .button__content' => 'flex-direction: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-service_button' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-service_button .wgl-service_button__media img' => 'top: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .wgl-service_button' => '--icon-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-service_button__media img' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-icon path' => 'stroke-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * CONTENT -> CURSOR
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
            'general_style_section',
            [
                'label' => esc_html__('General', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'service_bg_first',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'First Background', 'burido-core' ),
                        'default' => 'classic'
                    ],
                    'color' => [
                        'label' => esc_html__( 'Background Color', 'burido-core' ),
                        'default' => WGL_Globals::get_secondary_color(),
                    ],
                ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wgl-service::before',
            ]
        );
        $this->add_control(
            'service_bg_first_z_index',
            [
                'label' => esc_html__('First Background z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'condition' => [ 'service_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service::before' => 'z-index: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'service_bg_second',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Second Background', 'burido-core' ),
                        'default' => 'gradient'
                    ],
                    'color' => [
                        'label' => esc_html__( 'Background Color', 'burido-core' ),
                        'default' => WGL_Globals::get_primary_color(0),
                    ],
                    'color_stop' => [
                        'default' => ['size' => 41, 'unit' => '%'],
                    ],
                    'color_b' => [
                        'label' => esc_html__( 'Second Background Color', 'burido-core' ),
                        'default' => WGL_Globals::get_primary_color(),
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 180,
                        ],
                    ],
                ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wgl-service::after',
            ]
        );
        $this->add_control(
            'service_bg_second_z_index',
            [
                'label' => esc_html__('Second Background z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'condition' => [ 'service_bg_second_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service::after' => 'z-index: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'general_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '50',
                    'right' => '50',
                    'bottom' => '41',
                    'left' => '50',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '23',
                    'left' => '30',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '15',
                    'left' => '20',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'general_border_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_background');
        $this->start_controls_tab(
            'tab_bg_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_responsive_control(
            'service_bg_first_idle',
            [
                'label' => esc_html__('Opacity for First Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'service_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'service_bg_second_idle',
            [
                'label' => esc_html__('Opacity for Second Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'service_bg_second_background!' => '' ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_bg_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_responsive_control(
            'service_bg_first_hover',
            [
                'label' => esc_html__('Opacity for First Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'service_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service:hover::before,
                     {{WRAPPER}} .wgl-service_link:hover ~ .wgl-service::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'service_bg_second_hover',
            [
                'label' => esc_html__('Opacity for Second Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'service_bg_second_background!' => '' ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service:hover::after,
                     {{WRAPPER}} .wgl-service_link:hover ~ .wgl-service::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'item_bg_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.4],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service' => 'transition: {{SIZE}}s',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_bg_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_responsive_control(
            'service_bg_first_responsive',
            [
                'label' => esc_html__('Opacity for First Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'service_bg_first_background!' => '' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen::before,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop::before,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'service_bg_second_responsive',
            [
                'label' => esc_html__('Opacity for Second Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'service_bg_second_background!' => '' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen::after,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop::after,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra::after,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet::after,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra::after,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ICON/Image
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon_image',
            [
                'label' => esc_html__('Icon/Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'font'],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'default' => ['size' => 20],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_rotate',
            [
                'label' => esc_html__('Rotate', 'burido-core'),
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
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Button Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'static' => esc_html__('Default', 'burido-core'),
                    'absolute' => esc_html__('Absolute', 'burido-core'),
                ],
                'render_type' => 'template',
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_media' => 'position: {{VALUE}}; top: 0; right: 0; left: 0',
                ],
            ]
        );

        $this->add_control(
            'icon_alignment',
            [
                'label' => esc_html__('Icon Alignment', 'burido-core'),
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
                'condition' => ['icon_position' => 'absolute'],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_media' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'selector' => '{{WRAPPER}} .media-wrapper .wgl-icon',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_icons' );
        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'icon_primary_color_idle',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_primary_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['icon_primary_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_secondary_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_secondary_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['icon_secondary_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['icon_border_border!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_border_border!' => '',
                    'icon_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .media-wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_idle',
                'selector' => '{{WRAPPER}} .media-wrapper .wgl-icon',
            ]
        );
        $this->add_control(
            'icon_scale_idle',
            [
                'label' => esc_html__( 'Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'x' ],
                'range' => [
                    'x' => [ 'min' => 0.5, 'max' => 2, 'step' => 0.01 ],
                ],
                'default' => [ 'unit' => 'x' ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'transform: scale( {{SIZE}} );',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'icon_primary_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_primary_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['icon_primary_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_secondary_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_secondary_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['icon_secondary_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['icon_border_border!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_border_border!' => '',
                    'icon_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_hover',
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon',
            ]
        );
        $this->add_control(
            'icon_scale_hover',
            [
                'label' => esc_html__( 'Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'x' ],
                'range' => [
                    'x' => [ 'min' => 0.5, 'max' => 2, 'step' => 0.01 ],
                ],
                'default' => [ 'unit' => 'x' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'transform: scale( {{SIZE}} );',
                ],
            ]
        );
        $this->add_control(
            'icon_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'default' => ['size' => 0.6],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_icon_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_control(
            'icon_primary_color_responsive',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_primary_color_responsive-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['icon_primary_color_responsive!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_secondary_color_responsive',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_secondary_color_responsive-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['icon_secondary_color_responsive!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_responsive',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['icon_border_border!' => ''],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_responsive-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_border_border!' => '',
                    'icon_border_color_responsive!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_responsive',
                'selector' => 'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon',
            ]
        );
        $this->add_control(
            'icon_scale_responsive',
            [
                'label' => esc_html__( 'Scale', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'x' ],
                'range' => [
                    'x' => [ 'min' => 0.5, 'max' => 2, 'step' => 0.01 ],
                ],
                'default' => [ 'unit' => 'x' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .media-wrapper .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .media-wrapper .wgl-icon' => 'transform: scale( {{SIZE}} );',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Icon/IMAGE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_image_icon',
            [
                'label' => esc_html__('Icon/Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'image'],
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'left' => '0',
                    'right' => '0',
                    'bottom' => '25',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_media .wgl-image-box_img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 800],
                    '%' => ['min' => 5, 'max' => 100],
                ],
                'default' => ['size' => 100, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation_image',
            [
                'label' => esc_html__('Hover Animation', 'burido-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->start_controls_tabs('image_effects');
        $this->start_controls_tab(
            'image_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .wgl-image-box_img img',
            ]
        );
        $this->add_control(
            'image_opacity',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'default' => ['size' => 0.3],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'image_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img',
            ]
        );
        $this->add_control(
            'image_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'image_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_responsive',
                'selector' => 'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-image-box_img img,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-image-box_img img,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-image-box_img img,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-image-box_img img,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-image-box_img img,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-image-box_img img',
            ]
        );
        $this->add_control(
            'image_opacity_responsive',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'default' => ['size' => 1],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-image-box_img img,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-image-box_img img,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-image-box_img img,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-image-box_img img,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-image-box_img img,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> TITLE
         */

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'condition' => [ 's_title!' => '' ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__('‹h1›', 'burido-core'),
                    'h2' => esc_html__('‹h2›', 'burido-core'),
                    'h3' => esc_html__('‹h3›', 'burido-core'),
                    'h4' => esc_html__('‹h4›', 'burido-core'),
                    'h5' => esc_html__('‹h5›', 'burido-core'),
                    'h6' => esc_html__('‹h6›', 'burido-core'),
                    'div' => esc_html__('‹div›', 'burido-core'),
                    'span' => esc_html__('‹span›', 'burido-core'),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'label' => esc_html__('Typography', 'burido-core'),
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 46],
                    ],
                    'line_height' => ['default' => ['size' => 1.22, 'unit' => 'em']],
                    'letter_spacing' => ['default' => ['size' => 0]],
                ],
                'selector' => '{{WRAPPER}} .wgl-service_title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '50',
                    'right' => '0',
                    'bottom' => '31',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin_hover',
            [
                'label' => esc_html__('Margin on Hover', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '50',
                    'right' => '0',
                    'bottom' => '12',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_title,
                     body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_title,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_title,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'service_color_tab_title' );
        $this->start_controls_tab(
            'custom_service_color_idle',
            ['label' => esc_html__('Idle' , 'burido-core')]
        );
        $this->add_control(
            'service_color_1',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'service_color_1-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_1!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_service_color_hover',
            ['label' => esc_html__('Hover' , 'burido-core')]
        );
        $this->add_control(
            'service_color_1_hover',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_1_hover-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_1_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_service_color_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_control(
            'service_color_1_responsive',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_title,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_title,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_1_responsive-dynamic',
            [
                'label' => esc_html__('Title Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_1_responsive!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> SUBTITLE
         */

        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['s_subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_custom_fonts',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 500],
                ],
                'selector' => '{{WRAPPER}} .wgl-service_subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Subtitle Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => 'auto',
                    'left' => '0',
                    'unit' => 'custom',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_rotation',
            [
                'label' => esc_html__( 'Rotation', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'deg', 'turn' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                ],
                'default' => [ 'unit' => 'deg' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_subtitle' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -2000, 'max' => 1000, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_subtitle' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_left_offset',
            [
                'label' => esc_html__('Left Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -2000, 'max' => 1000, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_subtitle' => 'left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'hover_stroke',
            [
                'label' => esc_html__('Animation Text', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'stroke',
                'prefix_class' => 'animation_',
            ]
        );

        $this->start_controls_tabs( 'service_color_tab_subtitle' );
        $this->start_controls_tab(
            'custom_service_color_subtitle_idle',
            [
                'label' => esc_html__('Idle' , 'burido-core'),
            ]
        );
        $this->add_control(
            'service_color_subtitle',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_subtitle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_subtitle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_stroke_subtitle',
            [
                'label' => esc_html__('Stroke', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['hover_stroke' => 'stroke'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_subtitle' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_stroke_subtitle-dynamic',
            [
                'label' => esc_html__('Stroke - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'hover_stroke' => 'stroke',
                    'service_color_stroke_subtitle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_subtitle' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_service_color_subtitle_hover',
            [
                'label' => esc_html__('Hover' , 'burido-core'),
            ]
        );
        $this->add_control(
            'service_color_subtitle_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_subtitle_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_subtitle_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_stroke_subtitle_hover',
            [
                'label' => esc_html__('Stroke', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['hover_stroke' => 'stroke'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_subtitle' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_stroke_subtitle_hover-dynamic',
            [
                'label' => esc_html__('Stroke - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'hover_stroke' => 'stroke',
                    'service_color_stroke_subtitle_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_subtitle' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_service_color_subtitle_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_control(
            'service_color_subtitle_responsive',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_subtitle,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_subtitle,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_subtitle_responsive-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_subtitle_responsive!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_stroke_subtitle_responsive',
            [
                'label' => esc_html__('Stroke', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['hover_stroke' => 'stroke'],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_subtitle,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_subtitle,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_subtitle' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'service_color_stroke_subtitle_responsive-dynamic',
            [
                'label' => esc_html__('Stroke - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'hover_stroke' => 'stroke',
                    'service_color_stroke_subtitle_responsive!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_subtitle' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BG Text
         */

        $this->start_controls_section(
            'background_text',
            [
                'label' => esc_html__('Background Text', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['s_bg_text!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bg_text_custom_fonts',
                'selector' => '{{WRAPPER}} .wgl-service_bg_text',
            ]
        );

        $this->add_responsive_control(
            'bg_text_wrapper_size',
            [
                'label' => esc_html__('Wrapper Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                    'em' => ['min' => 1, 'max' => 20],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_text_stroke_size',
            [
                'label' => esc_html__('Stroke Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 2, 'step' => 0.1],
                ],
                'default' => [ 'unit' => 'px', 'size' => 0.5 ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_text_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '9',
                    'right' => '0',
                    'bottom'=> '0',
                    'left' => '9',
                    'unit'  => '%',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_text_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_text_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_text_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -5,
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_bg_text_styles');

        $this->start_controls_tab(
            'tab_bg_text',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'bg_text_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => 'rgba(255,255,255,0)',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_bg_text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_stroke_idle',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['bg_text_stroke_size!' => ''],
                'default' => 'rgba(255,255,255,1)',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_stroke_idle-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'bg_text_stroke_size!' => '',
                    'bg_text_stroke_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_bg_text_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'bg_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => 'rgba(255,255,255,1)',
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_bg_text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_bg_text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_stroke_hover',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['bg_text_stroke_size!' => ''],
                'default' => 'rgba(255,255,255,0)',
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_stroke_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'bg_text_stroke_size!' => '',
                    'bg_text_stroke_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_bg_text_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_control(
            'bg_text_color_responsive',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => 'rgba(255,255,255,1)',
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_bg_text,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_bg_text,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_bg_text,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_bg_text,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_bg_text,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_color_responsive-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_responsive!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_bg_text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_responsive',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_bg_text,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_bg_text,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_bg_text,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_bg_text,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_bg_text,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_bg_text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_responsive-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_bg_color_responsive!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_bg_text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_stroke_responsive',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['bg_text_stroke_size!' => ''],
                'default' => 'rgba(255,255,255,0)',
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_bg_text,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_bg_text,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_bg_text,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_bg_text,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_bg_text,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_text_stroke_responsive-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'bg_text_stroke_size!' => '',
                    'bg_text_stroke_responsive!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_bg_text,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> DESCRIPTION
         */

        $this->start_controls_section(
            'descr_style_section',
            [
                'label' => esc_html__('Description', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['s_description!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'descr_custom_fonts',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 20],
                        'mobile_default' => ['size' => 18],
                    ],
                    'line_height' => ['default' => ['size' => 1.7, 'unit' => 'em']],
                ],
                'selector' => '{{WRAPPER}} .wgl-service_description',
            ]
        );

        $this->add_responsive_control(
            'descr_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_wrapper_description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'descr_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '1',
                    'right' => '0',
                    'bottom' => '31',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('service_color_tab_descr');
        $this->start_controls_tab(
            'custom_service_color_normal_descr',
            ['label' => esc_html__('Idle' , 'burido-core')]
        );
        $this->add_control(
            'service_color_descr',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_description' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'service_color_descr-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_descr!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_description' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_service_color_descr_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'service_color_descr_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_description' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'service_color_descr_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_descr_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_description' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'custom_service_color_descr_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_control(
            'service_color_descr_responsive',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_description,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_description,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_description,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_description,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_description,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_description' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'service_color_descr_responsive-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['service_color_descr_responsive!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .breakpoint_on-widescreen .wgl-service_description,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .breakpoint_on-desktop .wgl-service_description,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .wgl-service_description,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .wgl-service_description,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .wgl-service_description,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .wgl-service_description' => 'color: {{VALUE}};'
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
            'button_style_section',
            [
                'label' => esc_html__('Button', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['add_read_more!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'selector' => '{{WRAPPER}} .wgl-service_button .button__text',
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
                    '{{WRAPPER}} .wgl-service_button .button__text' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button .button__text' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
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
                    'top' => '15',
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
                    '{{WRAPPER}} .wgl-service_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .wgl-service_button',
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
                    '{{WRAPPER}} .wgl-service_button' => 'min-width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button' => 'justify-content: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-service_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-service_button,
                     {{WRAPPER}} .wgl-service_button::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-service_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-service_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-service_button .wgl-icon,
				     {{WRAPPER}} .wgl-service_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-icon' => 'stroke: {{VALUE}}'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button .wgl-icon' => 'stroke: {{VALUE}}'
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
                    '{{WRAPPER}} .wgl-service_button' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-service_button' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wgl-service_button',
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
                    '{{WRAPPER}} .wgl-service_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                'default' => WGL_Globals::get_tertiary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button,
                     {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon' => 'stroke: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button' => 'border-color: {{VALUE}}'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-service_button' => 'border-color: {{VALUE}}'
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
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover,
                     {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button:hover' => 'border-color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_responsive',
            ['label' => esc_html__('Responsive', 'burido-core')]
        );
        $this->add_control(
            'button_color_responsive',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_active-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
			    'dynamic' => ['active' => true],
                'condition' => ['button_color_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_responsive',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_active-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_bg_active!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_responsive',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active span' => 'text-decoration-color: {{VALUE}};',
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button span,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button span,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button span,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button span,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button span,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_active-dynamic',
            [
                'label' => esc_html__('Decoration Line Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'],
                    'button_decoration_color_active!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active span' => 'text-decoration-color: {{VALUE}};',
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button span,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_responsive',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_active-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_responsive',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon,
                     
                     body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon::before,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon::before,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon::before,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon::before,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon::before,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_active-dynamic',
            [
                'label' => esc_html__('Icon BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_icon_bg_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon::before,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_responsive',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_active-dynamic',
            [
                'label' => esc_html__('Icon Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg',
                    'button_icon_stroke_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_responsive',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_active-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none'],
                    'button_border_color_active!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_responsive',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => 'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_responsive',
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
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_responsive',
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
                    'body[data-elementor-device-mode="widescreen"] {{WRAPPER}} .wgl-service.breakpoint_on-widescreen .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-service.breakpoint_on-desktop .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .wgl-service.breakpoint_on-tablet .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile_extra .wgl-service_button .wgl-icon,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .wgl-service.breakpoint_on-mobile .wgl-service_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button' => '--wgl-icon-wrapper: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button::after' => 'left:{{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button::after' => '--bg-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-service_button:focus::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-service_button:focus::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-service_button:focus::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-service_button:focus::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button' => '--ab-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-service_button' => '--ab-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button' => '--ab-offset: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button' => '--ab-width: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button' => '--ab-extend: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-icon' => '--icon-bg-size: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-service_button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-service_button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-service_button:focus .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-service_button:focus .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-service_button:active .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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

    protected function add_mobile_breakpoint() {
        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();

        $avaliable_breakpoints = [];
        foreach ( $active_devices as $breakpoint_key ) {
            $label = 'desktop' === $breakpoint_key ? esc_html__( 'Desktop', 'burido-core' ) : $active_breakpoints[ $breakpoint_key ]->get_label();
            $avaliable_breakpoints[$breakpoint_key] = $label;
        }
        $this->add_control(
            'wgl_mobile_breakpoint',
            [
                /* translators: %s: Device Name. */
                'label' => esc_html__( 'Set Mobile Template On', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => $avaliable_breakpoints,
                'default' => 'tablet',
            ]
        );
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        if (isset($_s['cursor_tooltip']) && '' != $_s['cursor_tooltip']) {
            add_filter( 'wgl/burido_module_cursor', function () { return true; });
        }

        $kses_allowed_html = [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true,
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'i' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
            'p' => ['id' => true, 'class' => true, 'style' => true],
            'small' => ['id' => true, 'class' => true, 'style' => true],
            'ul' => ['id' => true, 'class' => true, 'style' => true],
            'ol' => ['id' => true, 'class' => true, 'style' => true],
            'li' => ['id' => true, 'class' => true, 'style' => true],
        ];

        $cursor_data = '';

        if(isset($_s['cursor_tooltip']) && $_s['cursor_tooltip']){
            $cursor = new WGL_Cursor;
            $cursor_data = $cursor->build($this, $_s);
        }

        $this->add_render_attribute(
            'service',
            [
                'class' => [
                    'wgl-service',
                    isset($_s['cursor_tooltip']) && $_s['cursor_tooltip'] ? 'wgl-cursor-text additional-cursor' : '',
                ]
            ]
        );

        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $key = array_search($_s['wgl_mobile_breakpoint'], $active_devices);
        $all_breakpoints = array_slice($active_devices, $key);
        foreach($all_breakpoints as $breakpoint){
            $this->add_render_attribute( 'service', [ 'class' => [ 'breakpoint_on-' . $breakpoint ] ] );
        }

        // Link
        if (!empty($_s['item_link']['url'])) {
            $this->add_link_attributes('link', $_s['item_link']);
        }

        // BG Text
        $service_bg_text = !empty($_s['s_bg_text']) ? '<div class="wgl-service_bg_text">' . wp_kses($_s['s_bg_text'], $kses_allowed_html) . '</div>' : '';

        // Media
        if (!empty($_s['icon_type'])) {
            $media = new WGL_Icons;
            $service_media = $media->build($this, $_s, []);
        }

        // Read more button
        if ($_s['add_read_more']) {
            $this->add_render_attribute('btn', 'class',
                [
                    'wgl-service_button',
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
                    $btn_icon = '<span class="wgl-service_button__media">'.$media_html.'</span>';
                    $this->add_render_attribute(['btn' => ['class' => [ 'image']]]);
                }
            }else{
                $this->add_render_attribute(['btn' => ['class' => [ 'no_media']]]);
            }

            // ↑ icon|image

            $s_button = '<div class="wgl-button-wrapper">';
                $s_button .= sprintf(
                    '<%s %s %s>',
                    $_s['module_link'] ? 'div' : 'a',
                    $_s['module_link'] ? '' : $this->get_render_attribute_string('link'),
                    $this->get_render_attribute_string('btn')
                );
                    $s_button .= 'wgl-button' === $_s['button_type'] ? '<div class="button__content">' : '';
                        $s_button .= $btn_icon ?: '';
                        $s_button .= $_s['read_more_text'] ? '<span class="button__text">' . esc_html($_s['read_more_text']) . '</span>' : '';
                    $s_button .= 'wgl-button' === $_s['button_type'] ? '</div>' : '';
                $s_button .= $_s['module_link'] ? '</div>' : '</a>';
            $s_button .= '</div>';
        }

        // Render
        if ($_s['module_link'] && !empty($_s['item_link']['url'])) {
            ?><a class="wgl-service_link" <?php echo $this->get_render_attribute_string('link'); ?>></a><?php
        }

        ?><div <?php echo $this->get_render_attribute_string('service') , $cursor_data; ?>><?php

            echo $service_bg_text;

            if (!empty($service_media)) {
                ?><div class="wgl-service_media"><?php
                    echo $service_media;
                ?></div><?php
            }

            if (!empty($_s['s_subtitle'])) {
                ?><div class="wgl-service_subtitle"><?php echo wp_kses($_s['s_subtitle'], $kses_allowed_html); ?></div><?php
            }

            if (!empty($_s['s_title'])) {
                echo '<'. $_s['title_tag']. ' class="wgl-service_title">';
                    echo '<span class="service_title">'. wp_kses($_s['s_title'], $kses_allowed_html).'</span>';
                echo '</'. $_s['title_tag']. '>';
            }

            if (!empty( $_s['s_description'] ) ) {
                echo '<div class="wgl-service_wrapper_description">';
                    echo '<div class="wgl-service_description">';
                        echo wp_kses($_s['s_description'], $kses_allowed_html);
                    echo '</div>';
                echo '</div>';
            }

            if (!empty($s_button)) {
                echo $s_button;
            }

        ?></div><?php
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
