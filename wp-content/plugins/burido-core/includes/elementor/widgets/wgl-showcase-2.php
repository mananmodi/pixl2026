<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-showcase-2.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Plugin,
    Utils,
    Widget_Base,
    Controls_Manager,
    Icons_Manager,
    Repeater,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography,
    Group_Control_Background};

use WGL_Extensions\{Includes\WGL_Elementor_Helper, WGL_Framework_Global_Variables as WGL_Globals, Includes\WGL_Cursor};

class WGL_Showcase_2 extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-showcase-2';
    }

    public function get_title()
    {
        return esc_html__('WGL Showcase 2', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-showcase-2';
    }

    public function get_keywords()
    {
        return [ 'showcase 2', 'title', 'images' ];
    }

    public function get_script_depends()
    {
        return [
            'wgl-widgets',
        ];
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

        $repeater = new Repeater();
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );
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
            'title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Showcase Title', 'burido-core'),
            ]
        );
        $repeater->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
            ]
        );
        $repeater->add_control(
            'bg_text',
            [
                'label' => esc_html__('Background Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link_active',
            [
                'label' => esc_html__( 'Active by Default', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        WGL_Cursor::init(
            $repeater,
            [
                'section' => false,
                'repeater' => true,
                'prefix' => 'showcase_',
            ]
        );
        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
                'default' => [
                    [
                        'title' => esc_html__( 'Cosmetics', 'burido-core' ),
                        'bg_text' => esc_html__( 'Cosmetics', 'burido-core' ),
                        'subtitle' => esc_html__( '15', 'burido-core' ),
                    ],
                    [
                        'title' => esc_html__( 'Food & Drinks', 'burido-core' ),
                        'bg_text' => esc_html__( 'Food & Drinks', 'burido-core' ),
                        'subtitle' => esc_html__( '19', 'burido-core' ),
                    ],
                    [
                        'title' => esc_html__( 'Gift Boxes', 'burido-core' ),
                        'bg_text' => esc_html__( 'Gift Boxes', 'burido-core' ),
                        'subtitle' => esc_html__( '27', 'burido-core' ),
                        'link_active' => 'yes'
                    ],
                    [
                        'title' => esc_html__( 'Business', 'burido-core' ),
                        'bg_text' => esc_html__( 'Business', 'burido-core' ),
                        'subtitle' => esc_html__( '38', 'burido-core' ),
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'items_justify_content',
            [
                'label' => esc_html__( 'Justify Items', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'style_transfer' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-evenly-h',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item_inner' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_justify',
            [
                'label' => esc_html__( 'Justify Content', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'style_transfer' => true,
                'options' => [
                    '0' => [
                        'title' => esc_html__( 'Default', 'burido-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    '0 auto' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                ],
                'condition' => ['items_justify_content' => 'flex-start'],
                'default' => '0 auto',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__content_wrapper' => 'margin: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'items_align_items',
            [
                'label' => esc_html__( 'Align Items', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'style_transfer' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'default' => 'center',
                'tablet_default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item,
                     {{WRAPPER}} .showcase-2__item_inner' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'style_transfer' => true,
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
                'tablet_default' => 'center',
                'mobile_default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item,
                     {{WRAPPER}} .showcase-2__content_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_animation',
            [
                'label' => esc_html__('Content Animation', 'burido-core'),
                'description' => esc_html__('Show Content on Hover', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('True', 'burido-core'),
                'label_off' => esc_html__('False', 'burido-core'),
                'default' => 'yes',
            ]
        );
        $this->add_mobile_breakpoint();
        $this->end_controls_section();

        /**
         * CONTENT -> BUTTON
         */

        $this->start_controls_section(
            'section_style_link',
            [
                'label' => esc_html__('Link', 'burido-core'),
            ]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Whole Item Link', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_type',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'burido-core'),
                    'btn' => esc_html__('Button', 'burido-core'),
                ],
                'condition' => ['add_read_more' => 'yes'],
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_type' => 'btn'
                ],
                'label_block' => true,
                'default' => esc_html__('Read More', 'burido-core'),
            ]
        );

        $this->add_control(
            'read_more_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_type' => 'icon'
                ],
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fas fa-arrow-right',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_type' => 'icon',
                    'read_more_icon_fontawesome[value]!' => '',
                ],
                'range' => [
                    'px' => ['min' => 10, 'max' => 200 ],
                ],
                'default' => ['size' => 30 ],
                'mobile_default' => ['size' => 24 ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_spacing',
            [
                'label' => esc_html__('Icon Wrapper Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_type' => 'icon',
                    'read_more_icon_fontawesome[value]!' => '',
                ],
                'range' => [
                    'px' => ['min' => 10, 'max' => 100 ],
                ],
                'default' => ['size' => 40 ],
                'mobile_default' => ['size' => 30 ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

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
        $this->add_control(
            'item_overflow',
            [
                'label' => esc_html__('Items Overflow', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Theme Default', 'burido-core'),
                    'overflow: visible;' => esc_html__('Visible', 'burido-core'),
                    'overflow: hidden;' => esc_html__('Hidden', 'burido-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item' => '{{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_height',
            [
                'label' => esc_html__( 'Items Min Height', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', '%', 'vh', 'vw', 'custom'],
                'default' => ['size' => 160, 'unit' => 'px'],
                'tablet_default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '3px',
                    'right' => '15.6%',
                    'bottom' => '4px',
                    'left' => '15.6%',
                    'unit' => 'custom',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '30px',
                    'right' => '4%',
                    'bottom' => '30px',
                    'left' => '10%',
                    'unit' => 'custom',
                    'isLinked' => false
                ],
                'mobile_default' => [
                    'top' => '20px',
                    'right' => '4.65%',
                    'bottom' => '20px',
                    'left' => '13%',
                    'unit' => 'custom',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .showcase-2__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_separator',
            [
                'label' => esc_html__( 'Separator Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'separator' => 'before',
                'size_units' => ['px'],
                'range' => [ 'px' => ['min' => 0, 'max' => 10] ],
                'default' => ['size' => 1, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-showcase-2' => '--separator-width: {{SIZE}}px; --separator-opacity: 1;',
                ],
            ]
        );
        $this->add_control(
            'item_separator_position',
            [
                'label' => esc_html__('Separator Position', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'horizontal',
                'size_units' => ['px', '%', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item::after' => 'right: {{RIGHT}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'item_separator_color',
            [
                'label' => esc_html__('Separator Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-showcase-2' => '--separator-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'item_separator_color-dynamic',
            [
                'label' => esc_html__('Separator Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['item_separator_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-showcase-2' => '--separator-color: {{VALUE}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'item_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => -5,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} ' => 'z-index: {{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'item_tabs' );
        $this->start_controls_tab(
            'item_idle_tab',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg_idle',
                'selector' => '{{WRAPPER}} .showcase-2__background::before',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border_idle',
                'selector' => '{{WRAPPER}} .showcase-2__item',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_idle',
                'selector' => '{{WRAPPER}} .showcase-2__item',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_hover_tab',
            ['label' => esc_html__('Hover/Active' , 'burido-core')]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg_hover',
                'fields_options' => [
                    'background' => [ 'default' => '' ],
                    'color' => [
                        'label' => esc_html__( 'Background Color', 'burido-core' ),
                        'default' => 'rgba(250, 169, 165, 1)',
                    ],
                    'color_b' => [
                        'label' => esc_html__( 'Second Background Color', 'burido-core' ),
                        'default' => WGL_Globals::get_primary_color(),
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 90,
                        ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .showcase-2__background::after',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border_hover',
                'selector' => '{{WRAPPER}} .showcase-2__item.active,
                     {{WRAPPER}} .showcase-2__item:hover,

                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_hover',
                'selector' => '{{WRAPPER}} .showcase-2__item.active,
                     {{WRAPPER}} .showcase-2__item:hover,

                     body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item'
            ]
        );
        $this->add_control(
            'item_transition',
            [
                'label' => esc_html__('Transition', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.4],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item' => 'transition: {{SIZE}}s',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> Title
         */

        $this->start_controls_section(
            'style_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'title_width',
            [
                'label' => esc_html__( 'Title Width', 'burido-core' ),
                'description' => esc_html__( 'Title Width has Priority', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'vw', 'custom'],
                'range' => [ 'px' => ['max' => 1200] ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__title' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_align_self',
            [
                'label' => esc_html__( 'Align Self', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__title' => 'align-self: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'min' => -5,
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__title, {{WRAPPER}} .title' => 'z-index: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_tag',
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
                'separator' => 'before',
                'default' => 'h3',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_font_title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 64, 'unit' => 'px'],
                        'mobile_default' => ['size' => 28, 'unit' => 'px'],
                    ],
                ],
                'selector' => '{{WRAPPER}} .title',
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .title' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'title_tabs' );
        $this->start_controls_tab(
            'title_color_tab',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_bg',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_bg!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => [ 'title_stroke_size[size]!' => ['', 0] ],
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_stroke_size[size]!' => ['', 0],
                    'title_stroke_color!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_skew',
            [
                'label' => esc_html__('Skew the title', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => ['min' => -45, 'max' => 45],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item .title' => 'transform: skew({{SIZE}}deg)',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_hover_tab',
            ['label' => esc_html__('Hover/Active' , 'burido-core')]
        );
        $this->add_control(
            'title_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .title,
                     {{WRAPPER}} .showcase-2__item:hover .title' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .title' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'title_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['title_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .title,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .title' => 'color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__title,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__title' => 'background-color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__title' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__title,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__title' => 'background-color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color_hover',
            [
                'label' => esc_html__('Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'title_stroke_size[size]!' => ['', 0] ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .title,
                     {{WRAPPER}} .showcase-2__item:hover .title' => '-webkit-text-stroke-color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .title,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .title,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .title,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_stroke_color_hover-dynamic',
            [
                'label' => esc_html__('Stroke Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_stroke_size[size]!' => ['', 0],
                    'title_stroke_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .title,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .title' => '-webkit-text-stroke-color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .title,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_hover_skew',
            [
                'label' => esc_html__('Skew the title', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => ['min' => -45, 'max' => 45],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .title,
                     {{WRAPPER}} .showcase-2__item:hover .title' => 'transform: skew({{SIZE}}deg)',
                ],
            ]
        );
        $this->add_control(
            'title_transition',
            [
                'label' => esc_html__('Transition', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.4],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__title,
                     {{WRAPPER}} .title' => 'transition: {{SIZE}}s',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> Subtitle
         */

        $this->start_controls_section(
            'style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'subtitle_position',
            [
                'label' => esc_html__('Subtitle Position', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'burido-core'),
                    'left_w' => esc_html__('Left of the Title Wrapper', 'burido-core'),
                    'right_w' => esc_html__('Right of the Title Wrapper', 'burido-core'),
                    'left' => esc_html__('Left of the Title', 'burido-core'),
                    'right' => esc_html__('Right of the Title', 'burido-core'),
                ],
                'default' => 'right',
            ]
        );
        $this->add_responsive_control(
            'subtitle_visibility',
            [
                'label' => esc_html__('Subtitle Visibility', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('Hide', 'burido-core'),
                    'inline-block' => esc_html__('Show', 'burido-core'),
                ],
                'default' => 'inline-block',
                'mobile_default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'display: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_width',
            [
                'label' => esc_html__( 'Subtitle Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'vw', 'custom'],
                'range' => [ 'px' => ['max' => 1200] ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_align_self',
                [
                'label' => esc_html__( 'Align Self', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'align-self: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_alignment',
            [
                'label' => esc_html__('Self Alignment', 'burido-core'),
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
                    '{{WRAPPER}} .showcase-2__subtitle' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_font_subtitle',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .showcase-2__subtitle',
            ]
        );
        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'px' => ['min' => -100, 'max' => 100, 'step' => 1],
                ],
                'default' => ['size' => 11, 'unit' => 'px'],
                'tablet_default' => ['size' => 2, 'unit' => 'px'],
                'mobile_default' => ['size' => 2, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'transform: translateY( {{SIZE}}{{UNIT}} );',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_offset',
            [
                'label' => esc_html__('Left Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => -100, 'max' => 100, 'step' => 1],
                ],
                'condition' => [ 'subtitle_position' => 'right' ],
                'default' => ['size' => 7, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_offset_right',
            [
                'label' => esc_html__('Right Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => -100, 'max' => 100, 'step' => 1],
                ],
                'condition' => [ 'subtitle_position' => 'left' ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'subtitle_border',
                'render_type' => 'template',
                'dynamic' => ['active' => true],
                'fields_options' => [
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}} .showcase-2__subtitle',
            ]
        );
        $this->start_controls_tabs( 'subtitle_tabs' );
        $this->start_controls_tab(
            'subtitle_tab',
            ['label' => esc_html__('Idle' , 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_idle',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__subtitle' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'subtitle_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'subtitle_border_border!' => ['', 'none'],
                    'subtitle_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__subtitle' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'subtitle_hover_tab',
            ['label' => esc_html__('Hover/Active' , 'burido-core')]
        );
        $this->add_control(
            'subtitle_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__subtitle,
                    {{WRAPPER}} .showcase-2__item:hover .showcase-2__subtitle' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'subtitle_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__subtitle' => 'color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__subtitle,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__subtitle' => 'background-color: {{VALUE}}',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__subtitle' => 'background-color: {{VALUE}}',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__subtitle,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__subtitle' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'subtitle_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__subtitle,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__subtitle' => 'border-color: {{VALUE}}',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__subtitle,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__subtitle' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> Background Text
         */

        $this->start_controls_section(
            'style_bg_text',
            [
                'label' => esc_html__('Background Text', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .showcase-2__bg_text' => 'z-index: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_font_bg_text',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => ['size' => 'clamp(56px, 14vw, 170px)', 'unit' => 'custom'],
                    ],
                    'line_height' => ['default' => ['size' => 1.2, 'unit' => 'em']],
                ],
                'selector' => '{{WRAPPER}} .showcase-2__bg_text',
            ]
        );
        $this->add_responsive_control(
            'bg_text_position',
            [
                'label' => esc_html__('Position', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__bg_text' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
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
                    'top' => 'auto',
                    'right' => 'auto',
                    'bottom' => 'auto',
                    'left' => '0',
                    'unit' => 'custom',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__bg_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'bg_text_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '10',
                    'unit' => '%',
                    'isLinked' => false
                ],
                'tablet_default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '3',
                    'unit' => '%',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__bg_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'bg_text_tabs' );
        $this->start_controls_tab(
            'bg_text_color_tab',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'bg_text_color',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__bg_text' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'bg_text_color-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__bg_text' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'bg_text_hover_tab',
            ['label' => esc_html__('Hover/Active' , 'burido-core')]
        );
        $this->add_control(
            'bg_text_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#EFEFEF',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__bg_text,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__bg_text' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__bg_text,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__bg_text,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__bg_text,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__bg_text' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'bg_text_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__bg_text,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__bg_text' => 'color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__bg_text,
                     body.wgl_dynamic_colors-active body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__bg_text,
                     body.wgl_dynamic_colors-active body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__bg_text,
                     body.wgl_dynamic_colors-active body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__bg_text' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'bg_text_transition',
            [
                'label' => esc_html__('Transition', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.4],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__bg_text' => 'transition: {{SIZE}}s',
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
            ]
        );
        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__( 'Content Width', 'burido-core' ),
                'description' => esc_html__( 'Title Width has Priority', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', '%', 'vw', 'custom'],
                'range' => [ 'px' => ['max' => 1200] ],
                'default' => ['size' => '525', 'unit' => 'px'],
                'tablet_default' => ['size' => '100', 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__content_wrapper,
                     {{WRAPPER}} .showcase-2__content' => '--sc2-content-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_align_self',
            [
                'label' => esc_html__( 'Align Self', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__content_wrapper' => 'align-self: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_alignment',
            [
                'label' => esc_html__('Self Alignment', 'burido-core'),
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
                    '{{WRAPPER}} .showcase-2__content_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .showcase-2__content_wrapper',
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'vw', 'custom'],
                'tablet_default' => [
                    'top' => '15',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .showcase-2__content_wrapper' => 'color: {{VALUE}};',
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
                'condition' => ['content_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__content_wrapper' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__content_wrapper,
                    {{WRAPPER}} .showcase-2__item:hover .showcase-2__content_wrapper' => 'color: {{VALUE}};',

                    'body[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__content_wrapper,
                     body[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__content_wrapper,
                     body[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__content_wrapper,
                     body[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__content_wrapper' => 'color: {{VALUE}};',
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
                'condition' => ['content_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__content_wrapper,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__content_wrapper' => 'color: {{VALUE}};',

                    'body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet_extra"] {{WRAPPER}} .breakpoint_on-tablet_extra .showcase-2__item .showcase-2__content_wrapper,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="tablet"] {{WRAPPER}} .breakpoint_on-tablet .showcase-2__item .showcase-2__content_wrapper,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile_extra"] {{WRAPPER}} .breakpoint_on-mobile_extra .showcase-2__item .showcase-2__content_wrapper,
                     body.wgl_dynamic_colors-active[data-elementor-device-mode="mobile"] {{WRAPPER}} .breakpoint_on-mobile .showcase-2__item .showcase-2__content_wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_transition',
            [
                'label' => esc_html__('Transition', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.8],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__content_wrapper' => 'transition: {{SIZE}}s',
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
            'image_style_section',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                    'full' => esc_html__('Full', 'burido-core'),
                    'custom' => esc_html__('Custom', 'burido-core'),
                ],
                'default' => 'full',
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
                'default' => '',
            ]
        );
        $this->add_responsive_control(
            'image_custom_width',
            [
                'label' => esc_html__( 'Image Width', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => [ 'px', 'vh', 'vw', 'custom'],
                'default' => [ 'size' => 370 ],
                'tablet_default' => [ 'size' => 300 ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_position',
            [
                'label' => esc_html__( 'Image Horizontal Position', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    '%' => [ 'min' => -150, 'max' => 150 ],
                    'px' => [ 'min' => -1920, 'max' => 1920 ],
                ],
                'size_units' => [ 'px', '%', 'custom' ],
                'default' => [ 'size' => 80, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__image' => '--wgl-image-position: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'image_near_title',
            [
                'label' => esc_html__( 'Place Image Near Title', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'render_type' => 'template',
                'dynamic' => ['active' => true],
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}} .showcase-2__image',
            ]
        );
        $this->add_responsive_control(
            'image_visibility',
            [
                'label' => esc_html__( 'Image Visibility', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'block' => esc_html__( 'Show', 'burido-core' ),
                    'none' => esc_html__( 'Hide', 'burido-core' ),
                ],
                'default' => 'block',
                'mobile_default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__image' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('image');
        $this->start_controls_tab(
            'image_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'image_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__image' => 'border-color: {{VALUE}}'
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
                'condition' => ['image_border_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__image' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_idle',
                'selector' => '{{WRAPPER}} .showcase-2__image',
            ]
        );
        $this->add_responsive_control(
            'image_rotation_idle',
            [
                'label' => esc_html__( 'Rotation', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                ],
                'default' => [ 'size' => 15, 'unit' => 'deg' ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__image' => '--wgl-image-rotate: {{SIZE}}deg;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'image_hover',
            ['label' => esc_html__('Hover/Active', 'burido-core')]
        );
        $this->add_control(
            'image_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__image,
				     {{WRAPPER}} .showcase-2__item:hover .showcase-2__image' => 'border-color: {{VALUE}}'
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
                'condition' => ['image_border_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__image,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__image' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_hover',
                'selector' => '{{WRAPPER}} .showcase-2__item.active .showcase-2__image,
				     {{WRAPPER}} .showcase-2__item:hover .showcase-2__image',
            ]
        );
        $this->add_responsive_control(
            'image_rotation_hover',
            [
                'label' => esc_html__( 'Rotation', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => [ 'min' => -360, 'max' => 360 ],
                ],
                'default' => [ 'size' => 0, 'unit' => 'deg' ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__image,
				     {{WRAPPER}} .showcase-2__item:hover .showcase-2__image' => '--wgl-image-rotate: {{SIZE}}deg;',
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
            ]
        );
        $this->add_responsive_control(
            'button_align_self',
            [
                'label' => esc_html__( 'Align Self', 'burido-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'burido-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'align-self: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'separator' => 'before',
                'condition' => [
                    'read_more_type' => 'btn'
                ],
                'selector' => '{{WRAPPER}} .showcase-2__button span',
            ]
        );
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => ['min' => -100, 'max' => 100],
                    '%' => ['min' => -100, 'max' => 100],
                ],
                'default' => [ 'size' => 1, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button-wrapper' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 50, 'step' => 1 ],
                ],
                'condition' => [ 'read_more_type' => 'icon' ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'render_type' => 'template',
                'condition' => [ 'read_more_type' => 'icon' ],
                'fields_options' => [
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                    'width' => ['label' => esc_html__( 'Border Width', 'burido-core' )],
                ],
                'selector' => '{{WRAPPER}} .showcase-2__button',
            ]
        );

        $this->start_controls_tabs( 'button_color_tab' );
        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle' , 'burido-core') ]
        );
        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__button' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'background-color: {{VALUE}};',
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
                'condition' => ['button_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__button' => 'background-color: {{VALUE}};',
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
                    'button_border_border!' => ['', 'none'],
                    'read_more_type' => 'icon'
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'border-color: {{VALUE}};',
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
                    'read_more_type' => 'icon',
                    'button_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_color_idle',
                'selector' => '{{WRAPPER}} .showcase-2__button',

            ]
        );

        $this->add_control(
            'button_icon_rotate_idle',
            [
                'label' => esc_html__('Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'condition' => [ 'read_more_type' => 'icon' ],
                'default' => ['size' => 45, 'unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button i' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_button_opacity_idle',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['%'],
                'range' => [
                    '%' => ['min' => 0, 'max' => 1, 'step' => 0.02],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__button' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_hover_item',
            [ 'label' => esc_html__( 'Hover Item', 'burido-core' ) ]
        );
        $this->add_control(
            'button_color_hover_item',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__button' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_hover_item-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_hover_item!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__button' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover_hover_item',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover_hover_item-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_bg_hover_hover_item!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover_item',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_border_border!' => ['', 'none'],
                    'read_more_type' => 'icon'
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover_item-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [

                    'button_border_border!' => ['', 'none'],
                    'read_more_type' => 'icon',
                    'button_border_color_hover_item!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item:hover .showcase-2__button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_color_hover_item',
                'selector' => '{{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__button',

            ]
        );

        $this->add_control(
            'button_icon_rotate_hover_item',
            [
                'label' => esc_html__('Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'condition' => [ 'read_more_type' => 'icon' ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__button i,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__button i' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_button_opacity_hover_item',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['%'],
                'range' => [
                    '%' => ['min' => 0, 'max' => 1, 'step' => 0.02],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item.active .showcase-2__button,
                     {{WRAPPER}} .showcase-2__item:hover .showcase-2__button' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_hover_button',
            [ 'label' => esc_html__( 'Hover Button', 'burido-core' ) ]
        );
        $this->add_control(
            'button_color_hover_button',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_hover_button-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_color_hover_button!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover_hover_button',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover_hover_button-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['button_bg_hover_hover_button!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover_button',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_border_border!' => ['', 'none'],
                    'read_more_type' => 'icon'
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover_button-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_border_border!' => ['', 'none'],
                    'read_more_type' => 'icon',
                    'button_border_color_hover_button!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_color_hover_button',
                'selector' => '{{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover',

            ]
        );

        $this->add_control(
            'button_icon_rotate_hover_button',
            [
                'label' => esc_html__('Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'condition' => [ 'read_more_type' => 'icon' ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover i' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_button_opacity_hover_button',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['%'],
                'range' => [
                    '%' => ['min' => 0, 'max' => 1, 'step' => 0.02],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-2__item .wgl-button-wrapper .showcase-2__button:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function add_mobile_breakpoint() {
        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();

        $avaliable_breakpoints = [];
        foreach ( $active_devices as $breakpoint_key ) {
            if( array_key_exists($breakpoint_key, $active_breakpoints) ) {
                $avaliable_breakpoints[$breakpoint_key] = $active_breakpoints[$breakpoint_key]->get_label();
            }
        }

        $this->add_control(
            'wgl_mobile_breakpoint',
            [
                /* translators: %s: Device Name. */
                'label' => esc_html__( 'Set Mobile Template On', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'render_type' => 'template',
                'options' => $avaliable_breakpoints + [ '' => esc_html__('Disable', 'burido-core') ],
                'default' => 'tablet',
            ]
        );
    }

    protected function render()
    {
        // Build structure
        $_s = $this->get_settings_for_display();

        // Variables validation
        $img_size_string = $_s['img_size_string'] ?? '';
        $img_size_array = $_s['img_size_array'] ?? [];
        $img_aspect_ratio = $_s['img_aspect_ratio'] ?? '';

        $showcase_2__wrapper = '';
        foreach ($_s['items'] as $index => $item) {

            // Fields validation
            $title = $item['title'] ?? '';
            $subtitle = $item['subtitle'] ?? '';
            $link = $item['link'] ?? '';
            $content = $item['content'] ?? '';
            $bg_text = $item['bg_text'] ?? '';

            if (!$title && !$content) return;

            $has_link = !empty($link['url']);

            if ($has_link) {
                $link = $this->get_repeater_setting_key('link', 'items', $index);
                $this->add_link_attributes($link, $item['link']);
            }

            //Cursor
            if (isset($item['showcase_cursor_tooltip']) && '' != $item['showcase_cursor_tooltip']) {
                add_filter( 'wgl/burido_module_cursor', function () { return true; });
            }
            $cursor = new WGL_Cursor;
            $cursor_data = $cursor->build($this, $item, $item['_id'], 'showcase_');

            $showcase_2__item = $this->get_repeater_setting_key( 'item_link_active', 'items', $index );
            $this->add_render_attribute( $showcase_2__item, [
                'class' => [
                    'showcase-2__item',
                    'elementor-repeater-item-'. $item['_id'],
                    $item[ 'link_active' ] ? 'active' : '',
                    isset($item['showcase_cursor_tooltip']) && !empty($item['showcase_cursor_tooltip']) ? 'wgl-cursor-text' : ''
                ],
            ] );

            //* Image size
            $image = '';
            if($thumbnail = $item['thumbnail']){
                $dim = null;
                $image_data = wp_get_attachment_image_src($thumbnail['id'], 'full');

                if ($image_data) {
                    $dim = WGL_Elementor_Helper::get_image_dimensions(
                        $img_size_array ?: $img_size_string,
                        $img_aspect_ratio,
                        $image_data
                    );
                }
                if($dim){
                    $image_url = aq_resize($image_data[0], $dim['width'], $dim['height'], true, true, true) ?: $image_data[0];

                    $this->add_render_attribute('image' . $index, [
                        'class' => 'image',
                        'src' => $image_url,
                        'alt' => get_post_meta($thumbnail['id'], '_wp_attachment_image_alt', true)
                    ]);

                    $this->add_render_attribute('showcase-2__image' . $index, [
                        'class' => 'showcase-2__image',
                    ]);

                    $image .= '<span '.$this->get_render_attribute_string('showcase-2__image' . $index).'>';
                        $image .=  '<img '. $this->get_render_attribute_string('image' . $index). '>';
                    $image .= '</span>';
                }
            }

            $subtitle = !empty($subtitle) ? '<span class="showcase-2__subtitle">'. esc_html($subtitle) .'</span>' : '';
            $title = ('left_w' === $_s['subtitle_position'] ? $subtitle : '' )
                . '<' . esc_attr($_s['title_tag']) . ' class="showcase-2__title">'
                    . ('left' === $_s['subtitle_position'] ? $subtitle : '' )
                    . (!empty($title) ? '<span class="title">'. esc_html($title) .'</span>' : '')
                    . ('yes' === $_s['image_near_title'] ? $image : '' )
                    . ('right' === $_s['subtitle_position'] ? $subtitle : '' )
                . '</' . esc_attr($_s['title_tag']) . '>'
                . ('right_w' === $_s['subtitle_position'] ? $subtitle : '' );

            if (!empty($content)) {
                $content = '<div class="showcase-2__content_wrapper"><div class="showcase-2__content">' . $content . '</div></div>';
            }

            if (!empty($bg_text)) {
                $bg_text = '<div class="showcase-2__bg_text">' . $bg_text . '</div>';
            }

            $showcase_2__wrapper .= '<div '. $this->get_render_attribute_string( $showcase_2__item ). ' ' . $cursor_data . '>';

                $showcase_2__wrapper .= '<div class="showcase-2__background"></div>';

                $showcase_2__wrapper .= $bg_text;

                if ($_s['add_item_link'] && $has_link) {
                    $showcase_2__wrapper .= '<a class="showcase-2__link" ' . $this->get_render_attribute_string($link) . '></a>';
                }

                $showcase_2__wrapper .= 'default' === $_s['subtitle_position'] ? $subtitle : '';

                $showcase_2__wrapper .= '<div class="showcase-2__item_inner">';
                    $showcase_2__wrapper .= $title;
                    $showcase_2__wrapper .= $content;
                $showcase_2__wrapper .= '</div>';

                $showcase_2__wrapper .= $this->read_more_button($index, $has_link, $link, $_s);
                $showcase_2__wrapper .= 'yes' !== $_s['image_near_title'] ? $image : '';
            $showcase_2__wrapper .= '</div>';
        }

        $this->add_render_attribute( 'general', [
            'class' => [
                'wgl-showcase-2',
                $_s['content_animation'] ? 'content_animation-yes' : '',
            ],
        ] );

        if (!empty($_s['wgl_mobile_breakpoint'])){
            $active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();
            $this->add_render_attribute( 'general', [
                'data-breakpoint' => $active_breakpoints[ $_s['wgl_mobile_breakpoint'] ]->get_value()
            ] );

            $active_devices = Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
            $key = array_search($_s['wgl_mobile_breakpoint'], $active_devices);
            $all_breakpoints = array_slice($active_devices, $key);
            foreach($all_breakpoints as $breakpoint){
                $this->add_render_attribute( 'general', [ 'class' => [ 'breakpoint_on-' . $breakpoint ] ] );
            }
        }

        ?><div <?php echo $this->get_render_attribute_string('general') ?>><?php
            echo $showcase_2__wrapper;
        ?></div><?php
    }

    public function read_more_button($index, $has_link, $link_item, $_s)
    {
        $s_button = '';

        // Read more button
        if ($_s['add_read_more']) {
            $this->add_render_attribute('btn' . $index, 'class', ['showcase-2__button', 'icon' === $_s['read_more_type'] ? 'icon-read-more' : 'button-read-more']);

            $icon_font = $_s['read_more_icon_fontawesome'];

            $migrated = isset($this->get_settings_for_display('__fa4_migrated')['read_more_icon_fontawesome']);
            $is_new = Icons_Manager::is_migration_allowed();
            $icon_output = '';

            if ($is_new || $migrated) {
                ob_start();
                Icons_Manager::render_icon($icon_font, ['aria-hidden' => 'true']);
                $icon_output .= ob_get_clean();
            } else {
                $icon_output .= '<i class="icon ' . esc_attr($icon_font) . '"></i>';
            }

            if (!empty($icon_output) || $_s['read_more_text']) {
                $s_button = '<div class="wgl-button-wrapper">';
                    $s_button .= sprintf('<%s %s %s>',
                        !$has_link ? 'div' : 'a',
                        $has_link ? $this->get_render_attribute_string($link_item) : '',
                        $this->get_render_attribute_string('btn' . $index)
                    );

                    if ('icon' === $_s['read_more_type']) {
                        $s_button .= $icon_output;
                    } else {
                        $s_button .= $_s['read_more_text'] ? '<span>' . esc_html($_s['read_more_text']) . '</span>' : '';
                    }

                    $s_button .= !$has_link ? '</div>' : '</a>';
                $s_button .= '</div>';
            }
        }

        return $s_button;
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
