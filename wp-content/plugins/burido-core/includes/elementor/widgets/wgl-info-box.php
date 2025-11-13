<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-infobox.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Border,
    Repeater,
    Widget_Base,
    Controls_Manager,
    Utils,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background,
    Group_Control_Css_Filter};
use WGL_Extensions\{
	WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Icons,
    Templates\WGLInfoBoxes,
    Includes\WGL_Cursor
};

class WGL_Info_Box extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-infobox';
    }

    public function get_title()
    {
        return esc_html__('WGL Info Box', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-infobox';
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    public function get_keywords() {
        return ['info', 'box', 'infobox', 'icon', 'button'];
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
            'layout',
            [
                'label' => esc_html__('Layout', 'burido-core'),
                'type' => 'wgl-radio-image',
                'condition' => ['icon_type!' => ''],
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_def.png',
                    ],
                    'left' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_left.png',
                    ],
                    'top_left' => [
                        'title' => esc_html__('Top Left', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_left_top.png',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_right.png',
                    ],
                    'top_right' => [
                        'title' => esc_html__('Top Right', 'burido-core'),
                        'image' => WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/img/wgl_elementor_addon/icons/style_right_top.png',
                    ],
                ],
                'default' => 'top',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
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
                'prefix_class' => 'a%s',
            ]
        );

        $this->add_control(
            'title_alignment',
            [
                'label' => esc_html__('Title Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['layout' => ['top_left', 'top_right']],
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'burido-core'),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
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
                'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'display: flex; justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * CONTENT -> ICON/IMAGE
         */

        $output = [];

        $output['view'] = [
            'label' => esc_html__('View', 'burido-core'),
            'type' => Controls_Manager::SELECT,
            'condition' => ['icon_type' => ['font', 'number', 'image']],
            'options' => [
                'default' => esc_html__('Default', 'burido-core'),
                'bubble'   => esc_html__('Bubble', 'burido-core'),
            ],
            'default' => 'default',
            'prefix_class' => 'wgl-view-',
        ];

        WGL_Icons::init(
            $this,
            [
                'output' => $output,
                'section' => true,
                'media_types_options' => [
                    '' => [
                        'title' => esc_html__('None', 'burido-core'),
                        'icon' => 'eicon-ban',
                    ],
                    'number' => [
                        'title' => esc_html__('Number', 'burido-core'),
                        'icon' => 'fa fa-list-ol',
                    ],
                    'font' => [
                        'title' => esc_html__('Icon', 'burido-core'),
                        'icon' => 'far fa-smile',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'burido-core'),
                        'icon' => 'far fa-image',
                    ],
                ],
                'default' => [
                    'media_type' => 'font',
                    'icon' => [
                        'library' => 'solid',
                        'value' => 'fas fa-icons'
                    ],
                ],
            ]
        );

        /**
         * CONTENT -> CONTENT
         */

        $this->start_controls_section(
            'content_content',
            ['label' => esc_html__('Content', 'burido-core')]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'ib_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Info Box Title', 'burido-core'),
            ]
        );
        $repeater->add_control(
            'items_title_color_idle',
            [
                'label' => esc_html__('Title Color Idle', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'items_title_color_idle-dynamic',
            [
                'label' => esc_html__('Title Color Idle - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'items_title_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'items_title_color_hover',
            [
                'label' => esc_html__('Title Color Hover', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'items_title_color_idle!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'transition: .4s;',
                ],
            ]
        );
        $repeater->add_control(
            'items_title_color_hover-dynamic',
            [
                'label' => esc_html__('Title Color Hover - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'items_title_color_idle!' => '',
                    'items_title_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'items',
            [
                'label' => esc_html__('Titles', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['ib_title' => esc_html__('Info Box Title', 'burido-core')],
                ],
                'title_field' => '{{{ ib_title }}}',
            ]
        );

        $this->add_control(
            'ib_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,

			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

	    $this->add_control(
		    'ib_bg_text',
		    [
			    'label' => esc_html__('Background Text', 'burido-core'),
			    'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
			    'label_block' => true,
                'placeholder' => esc_attr__('ex: 01', 'burido-core'),
		    ]
	    );

        $this->add_control(
            'ib_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('Description Text', 'burido-core'),
                'label_block' => true,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'burido-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'content_link',
            ['label' => esc_html__('Link', 'burido-core')]
        );

        $this->add_control(
            'link',
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
                'label_block' => true,
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
                'default' => 'yes',
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
			    'label' => esc_html__('Button Icon', 'burido-core'),
			    'type' => Controls_Manager::ICONS,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'font',
                    'button_type' => 'wgl-button',
                ],
			    'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
			    'label_block' => true,
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fas fa-arrow-right',
                ],
		    ]
	    );

        $this->add_control(
            'read_more_icon_thumbnail',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'image',
                    'button_type' => 'wgl-button',
                ],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
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
                    '{{WRAPPER}} .wgl-button .button__content' => 'flex-direction: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-infobox_button' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_button .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-infobox_button .wgl-infobox_button__media img' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'custom'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_type' => 'font',
                    'read_more_icon_fontawesome[value]!' => '',
                    'button_type' => 'wgl-button',
                ],
                'default' => ['size' => 20, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => '--icon-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_button .wgl-infobox_button__media img' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-icon path' => 'stroke-width: {{SIZE}}{{UNIT}};'
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

        /**
         * STYLE -> GENERAL
         */

        $this->start_controls_section(
            'style_general',
            [
                'label' => esc_html__('General', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox' => 'min-height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_wrapper' => 'justify-content: {{VALUE}}; align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'general_padding',
            [
                'label' => esc_html__('General Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_min_height',
            [
                'label' => esc_html__('Content Min Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'separator' => 'before',
                'size_units' => [ 'px', '%', 'vw', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 1000],
                ],
                'selectors' => [
                    '{{WRAPPER}} .content_wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_v_alignment',
            [
                'label' => esc_html__('Content Vertical Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'content_min_height[size]',
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
                    '{{WRAPPER}} .content_wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_wrapper_padding',
            [
                'label' => esc_html__('Content Wrapper Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .content_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();


        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'style_icon',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'font'],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'default' => ['size' => 60],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_rotate',
            [
                'label' => esc_html__('Icon Rotate', 'burido-core'),
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
            'icon_gradient',
            [
                'label' => esc_html__('Enable Icon Gradient', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon::before' => 'background: -webkit-linear-gradient(var(--ib-icon-clr-first), var(--ib-icon-clr-sec)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;',
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
                'default' => [
		            'top' => '0',
		            'right' => '0',
		            'bottom' => '12',
		            'left' => '0',
		            'unit'  => 'px',
		            'isLinked' => false
	            ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'dynamic' => ['active' => true],
                'fields_options' => [ 'color' => [ 'type' => Controls_Manager::HIDDEN ] ],
                'selector' => '{{WRAPPER}} .media-wrapper .wgl-icon',
            ]
        );
        $this->add_responsive_control(
            'icon_border_radius',
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
                'default' => WGL_Globals::get_h_font_color(0.4),
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .media-wrapper .wgl-icon::before' => '--ib-icon-clr-first: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .media-wrapper .wgl-icon::before' => '--ib-icon-clr-first: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_primary_sec_color_idle',
            [
                'label' => esc_html__('Gradient Color Secondary', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'icon_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon::before' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_primary_sec_color_idle-dynamic',
            [
                'label' => esc_html__('Gradient Color Secondary - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_gradient!' => '',
                    'icon_primary_sec_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .media-wrapper .wgl-icon::before' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['view!' => 'bubble'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'view!' => 'bubble',
                    'icon_bg_color_idle!' => ''
                ],
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
                'condition' => [ 'icon_border_border!' => ['', 'none'] ],
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
                    'icon_border_border!' => ['', 'none'],
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
                'default' => WGL_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon::before' => '--ib-icon-clr-first: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon::before' => '--ib-icon-clr-first: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_primary_sec_color_hover',
            [
                'label' => esc_html__('Gradient Color Secondary', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'icon_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon::before' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_primary_sec_color_hover-dynamic',
            [
                'label' => esc_html__('Gradient Color Secondary - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'icon_gradient!' => '',
                    'icon_primary_sec_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon::before' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['view!' => 'bubble'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'view!' => 'bubble',
                    'icon_bg_color_hover!' => ''
                ],
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
                'condition' => [ 'icon_border_border!' => ['', 'none'] ],
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
                    'icon_border_border!' => ['', 'none'],
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
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> Number
         */

		$this->start_controls_section(
			'section_style_number',
			[
				'label' => esc_html__('Number', 'burido-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'icon_type'  => 'number' ],
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typo',
                'selector' => '{{WRAPPER}} .wgl-number',
            ]
        );

		$this->add_responsive_control(
			'number_space',
			[
				'label' => esc_html__('Margin', 'burido-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
                'default' => [
		            'top' => '0',
		            'right' => '15',
		            'bottom' => '0',
		            'left' => '-16',
		            'unit'  => 'px',
		            'isLinked' => false
	            ],
				'selectors' => [
					'{{WRAPPER}} .wgl-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_padding',
			[
				'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'number_border_width',
			[
				'label' => esc_html__('Border Width', 'burido-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wgl-number' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
				],
			]
		);

		$this->add_responsive_control(
			'number_border_radius',
			[
				'label' => esc_html__('Border Radius', 'burido-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'number_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -5,
                'selectors' => [
                    '{{WRAPPER}} .wgl-number' => 'z-index: {{VALUE}};',
                ],
            ]
        );

	    $this->add_control(
		    'number_separator',
		    [
			    'label' => esc_html__('Show Separator?', 'burido-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'separator' => 'before',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .number-wrapper::after' => 'display: block;',
                ],
		    ]
	    );

	    $this->add_responsive_control(
		    'number_separator_margin',
		    [
			    'label' => esc_html__('Margin Separator', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%', 'rem' ],
			    'condition' => [ 'number_separator!' => '' ],
                'default' => [
                    'top' => '23',
                    'right' => '0',
                    'bottom' => '29',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
			    'selectors' => [
				    '{{WRAPPER}} .number-wrapper::after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'number_separator_width',
		    [
			    'label' => esc_html__('Width Separator', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => ['px', '%', 'custom'],
			    'range' => [
				    'px' => ['min' => 1, 'max' => 800],
				    '%' => ['min' => .1, 'max' => 100],
			    ],
                'condition' => [ 'number_separator!' => '' ],
                'selectors' => [
				    '{{WRAPPER}} .number-wrapper::after' => 'width: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'number_separator_height',
		    [
			    'label' => esc_html__('Height Separator', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => ['px', '%', 'custom'],
			    'range' => [
				    'px' => ['min' => 1, 'max' => 800],
				    '%' => ['min' => .1, 'max' => 100],
			    ],
                'condition' => [ 'number_separator!' => '' ],
			    'selectors' => [
				    '{{WRAPPER}} .number-wrapper::after' => 'height: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_responsive_control(
            'number_rotation',
            [
                'label' => esc_html__('Enable Rotation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'default' => 'yes',
                'tablet_default' => 'yes',
                'mobile_default' => 'yes',
                'return_value' => 'yes',
                'prefix_class' => 'enable-rotation%s-',
            ]
        );

        $this->start_controls_tabs( 'number_colors' );
        $this->start_controls_tab(
            'number_colors_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );
        $this->add_control(
            'primary_number_color',
            [
                'label' => esc_html__('Number Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-number' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'primary_number_color-dynamic',
            [
                'label' => esc_html__('Number Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['primary_number_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-number' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_bg_color',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_bg_color-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['number_bg_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_separator_color',
            [
                'label' => esc_html__('Separator Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'number_separator!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .number-wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_separator_color-dynamic',
            [
                'label' => esc_html__('Separator Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'number_separator!' => '',
                    'number_separator_color!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .number-wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'primary_number_border',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-number' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'primary_number_border-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['primary_number_border!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-number' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'number_shadow',
                'selector' => '{{WRAPPER}} .wgl-number',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'number_colors_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );

        $this->add_control(
            'number_primary_color_hover',
            [
                'label' => esc_html__('Number Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_primary_color_hover-dynamic',
            [
                'label' => esc_html__('Number Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['number_primary_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['number_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_separator_color_hover',
            [
                'label' => esc_html__('Separator Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'number_separator!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .number-wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_separator_color_hover-dynamic',
            [
                'label' => esc_html__('Separator Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'number_separator!' => '',
                    'number_separator_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .number-wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_primary_border_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-number' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_primary_border_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['number_primary_border_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-number' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'number_hover_shadow',
                'selector' =>  '{{WRAPPER}} .elementor-widget-container:hover .wgl-number',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section();

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'style_image',
            [
                'label' => esc_html__('Image', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'image'],
            ]
        );

        $this->add_responsive_control(
            'image_alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper.img-wrapper,
                     {{WRAPPER}} figure.wgl-image-box_img' => 'text-align: {{VALUE}};',
                ],
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
                    'right' => '0',
                    'bottom' => '12',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper.img-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'px' => ['min' => 0, 'max' => 800],
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'default' => ['size' => 100, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_z_index',
            [
                'label' => __( 'Z-Index', 'burido-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -5,
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img img' => 'z-index: {{VALUE}}; position: relative;',
                ],
            ]
        );

	    $this->start_controls_tabs('image_effects');

        $this->start_controls_tab(
            'Idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

	    $this->add_control(
		    'image_bg_color_idle',
		    [
			    'label' => esc_html__('Image BG Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-image-box_img' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'image_bg_color_idle-dynamic',
            [
                'label' => esc_html__('Image BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-image-box_img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .wgl-image-box_img img',
            ]
        );

        $this->add_responsive_control(
            'image_opacity',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_blur',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img img' => 'filter: blur({{SIZE}}px);',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .wgl-image-box_img,
				     {{WRAPPER}} .media-wrapper .wgl-image-box_img img,
				     {{WRAPPER}} .media-wrapper .wgl-image-box_img::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'image_shadow_idle',
			    'selector' => '{{WRAPPER}} .wgl-image-box_img img',
		    ]
	    );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'default' => ['size' => 0.5],
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
            'hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

	    $this->add_control(
		    'image_bg_color_hover',
		    [
			    'label' => esc_html__('Image BG Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'image_bg_color_hover-dynamic',
            [
                'label' => esc_html__('Image BG Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['image_bg_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-image-box_img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img',
            ]
        );

        $this->add_responsive_control(
            'image_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_blur_hover',
            [
                'label' => esc_html__('Blur', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 30, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img' => 'filter: blur({{SIZE}}px);',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-image-box_img,
				     {{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-image-box_img img,
				     {{WRAPPER}} .elementor-widget-container:hover .media-wrapper .wgl-image-box_img::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'image_shadow_hover',
			    'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img',
		    ]
	    );

        $this->add_control(
            'hover_animation_image_scale',
            [
                'label' => esc_html__('Scale Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ '%' ],
                'range' => [
                    '%' => ['min' => 0.8, 'max' => 1.2, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .media-wrapper img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

	    $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Bubble
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_bubble',
            [
                'label' => esc_html__('Bubble', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_type' => ['font', 'number', 'image'],
                    'view' => 'bubble',
                ],
            ]
        );

        $this->add_responsive_control(
            'bubble_top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -200, 'max' => 200],
                    'px' => ['min' => -1000, 'max' => 1000, 'step' => 1],
                ],
                'default' => ['size' => 17, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-image-box_img::after' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'bubble_left_offset',
            [
                'label' => esc_html__('Left Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -200, 'max' => 200],
                    'px' => ['min' => -1000, 'max' => 1000, 'step' => 1],
                ],
                'default' => ['size' => 39, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-image-box_img::after' => 'left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'bubble_size',
            [
                'label' => esc_html__('Bubble Diameter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => ['max' => 700],
                ],
                'default' => ['size' => 51, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-image-box_img::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
		    'icon_animation',
		    [
			    'label' => esc_html__('Bubble Animation', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'icon_type' => ['font', 'number', 'image'],
                    'view' => 'bubble',
                ],
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'bubble',
                'prefix_class' => 'animation_',
                'default' => ''
		    ]
	    );

        $this->add_responsive_control(
            'bubble_animation_top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 1],
                ],
                'condition' => [ 'icon_animation' => 'bubble' ],
                'default' => ['size' => -59, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-image-box_img::after' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'bubble_animation_left_offset',
            [
                'label' => esc_html__('Left Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['%', 'px', 'custom'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 1],
                ],
                'default' => ['size' => -59, 'unit' => 'px'],
                'condition' => [ 'icon_animation' => 'bubble' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-image-box_img::after' => 'left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'bubble_animation_size',
            [
                'label' => esc_html__('Bubble Diameter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => ['max' => 700],
                ],
                'condition' => [ 'icon_animation' => 'bubble' ],
                'default' => ['size' => 154, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-image-box_img::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs(
            'tabs_bubble_styles',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_bubble_idle',
            [ 'label' => esc_html__('Idle', 'burido-core') ]
        );

        $this->add_control(
            'bubble_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-image-box_img::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bubble_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bubble_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-icon::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-number .number::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble .wgl-image-box_img::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_bubble_hover',
            [ 'label' => esc_html__('Hover', 'burido-core') ]
        );

        $this->add_control(
            'bubble_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-icon::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-number .number::after,
                     {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-image-box_img::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bubble_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bubble_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-icon::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-number .number::after,
                     body.wgl_dynamic_colors-active {{WRAPPER}}.elementor-widget-wgl-infobox.wgl-view-bubble:hover .wgl-image-box_img::after' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wgl-infobox_title',
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
                'size_units' => [ 'px', 'em', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-title_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'title_border',
			    'render_type' => 'template',
                'dynamic' => ['active' => true],
                'fields_options' => [
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
			    'selector' => '{{WRAPPER}} .wgl-infobox_title',
		    ]
	    );

        $this->add_responsive_control(
            'title_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_width',
            [
                'label' => esc_html__('Title Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', '%', 'vw', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 1200],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title-idle' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_title' => 'z-index: {{VALUE}}; position: relative;',
                ],
            ]
        );

        $this->add_control(
            'title_separator',
            [
                'label' => esc_html__('Show Separator?', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-title_wrapper::after' => 'display: inline-block;',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_separator_position',
            [
                'label' => esc_html__('Separator Position', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => true,
                'condition' => ['title_separator!' => ''],
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'burido-core'),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'icon' => 'eicon-justify-end-v',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'burido-core'),
                        'icon' => 'eicon-align-end-h',
                    ],
                ],
                'selectors_dictionary' => [
                    'left' => 'position: absolute; left: 0; top: 0;',
                    'bottom' => 'position: static;',
                    'right' => 'position: absolute; right: 0; top: 0;',
                ],
                'default' => 'bottom',
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-title_wrapper::after' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_separator_margin',
            [
                'label' => esc_html__('Margin Separator', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%', 'rem', 'custom' ],
                'condition' => ['title_separator!' => ''],
                'default' => [
                    'top' => '26',
                    'right' => '0',
                    'bottom'=> '17',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-title_wrapper::after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_separator_width',
            [
                'label' => esc_html__('Width Separator', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 800],
                    '%' => ['min' => 1, 'max' => 100],
                ],
                'condition' => ['title_separator!' => ''],
                'default' => ['size' => 100, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-title_wrapper::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_separator_height',
            [
                'label' => esc_html__('Height Separator', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 800],
                    '%' => ['min' => 1, 'max' => 100],
                ],
                'condition' => ['title_separator!' => ''],
                'default' => ['size' => 1, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-title_wrapper::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'title',
            [ 'separator' => 'before' ]
        );
        $this->start_controls_tab(
            'title_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'title_shadow_idle',
			    'selector' => '{{WRAPPER}} .wgl-infobox_title',
		    ]
	    );

        $this->add_control(
            'separator_color_idle',
            [
                'label' => esc_html__('Separator Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['title_separator!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-title_wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'separator_color_idle-dynamic',
            [
                'label' => esc_html__('Separator Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_separator!' => '',
                    'separator_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox-title_wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
	            'condition' => [ 'title_border_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_title' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_blur_idle',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Title Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
		    'title_hover_shift',
		    [
			    'label' => esc_html__('Lift up the title', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'size_units' => [ 'px', 'custom' ],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'transform: translateY({{SIZE}}{{UNIT}})',
			    ],
		    ]
	    );
        $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'title_shadow_hover',
			    'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title',
		    ]
	    );
	    $this->add_control(
		    'separator_color_hover',
		    [
			    'label' => esc_html__('Separator Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['title_separator!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox-title_wrapper::after' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'separator_color_hover-dynamic',
            [
                'label' => esc_html__('Separator Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'title_separator!' => '',
                    'separator_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox-title_wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
	            'condition' => [
	            	'title_border_border!' => ['', 'none']
	            ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_bg_blur_hover',
            [
                'label' => esc_html__('Backdrop Filter', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 100, 'step' => 0.5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
            'style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['ib_subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .wgl-infobox_subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
	                'top' => '0',
	                'right' => '0',
	                'bottom' => '10',
	                'left' => '0',
	                'unit'  => 'px',
	                'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_subtitle_styles');
        $this->start_controls_tab(
            'tab_subtitle_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['subtitle_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_subtitle_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_subtitle' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_subtitle' => 'color: {{VALUE}};',
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
                'condition' => ['ib_bg_text!' => ''],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
			    'name' => 'bg_text_custom_fonts',
			    'selector' => '{{WRAPPER}} .wgl-infobox_bg_text',
		    ]
	    );

        $this->add_responsive_control(
            'bg_text_alignment',
            [
                'label' => esc_html__('Background Text Alignment', 'burido-core'),
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
                    '{{WRAPPER}} .wgl-infobox_bg_text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

	    $this->add_responsive_control(
		    'bg_text_width',
		    [
			    'label' => esc_html__('BG Text Wrapper Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'px', '%', 'vw', 'custom' ],
                'range' => [
                    '%' => [ 'min' => 10, 'max' => 100, 'step' => 1 ],
                    'vw' => [ 'min' => 10, 'max' => 100, 'step' => 1 ],
                    'px' => [ 'min' => 10, 'max' => 960, 'step' => 1 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_text' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
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
			    'selectors' => [
				    '{{WRAPPER}} .wgl-infobox_bg_text' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
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
                    'top' => '0',
                    'right' => '0',
                    'bottom'=> '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-infobox_bg_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				    '{{WRAPPER}} .wgl-infobox_bg_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				    '{{WRAPPER}} .wgl-infobox_bg_text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				    '{{WRAPPER}} .wgl-infobox_bg_text' => 'z-index: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'bg_text_gradient',
            [
                'label' => esc_html__('Enable Background Text Gradient', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_text' => 'background: -webkit-linear-gradient(var(--ib-icon-clr-first), var(--ib-icon-clr-sec)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;',
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
			    'label' => esc_html__('BG Text Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'default' => WGL_Globals::get_primary_color(),
			    'selectors' => [
				    '{{WRAPPER}} .wgl-infobox_bg_text' => 'color: {{VALUE}}; --ib-icon-clr-first: {{VALUE}}',
			    ],
		    ]
	    );
        $this->add_control(
            'bg_text_color_idle-dynamic',
            [
                'label' => esc_html__('BG Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_bg_text' => 'color: {{VALUE}}; --ib-icon-clr-first: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_text_sec_color_idle',
            [
                'label' => esc_html__('BG Text Gradient Color Secondary', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_text_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_text' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_text_sec_color_idle-dynamic',
            [
                'label' => esc_html__('BG Text Gradient Color Secondary - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'bg_text_gradient!' => '',
                    'bg_text_sec_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_bg_text' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_text_gradient' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_text' => 'background-color: {{VALUE}};',
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
                'condition' => [
                    'bg_text_gradient' => '',
                    'bg_text_bg_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_bg_text' => 'background-color: {{VALUE}};',
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
			    'selectors' => [
				    '{{WRAPPER}} .wgl-infobox_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
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
			    'label' => esc_html__('BG Text Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => 'color: {{VALUE}}; --ib-icon-clr-first: {{VALUE}}',
			    ],
		    ]
	    );
        $this->add_control(
            'bg_text_color_hover-dynamic',
            [
                'label' => esc_html__('BG Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['bg_text_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => 'color: {{VALUE}}; --ib-icon-clr-first: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_text_sec_color_hover',
            [
                'label' => esc_html__('BG Text Gradient Color Secondary', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_text_gradient!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_text_sec_color_hover-dynamic',
            [
                'label' => esc_html__('BG Text Gradient Color Secondary - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'bg_text_gradient!' => '',
                    'bg_text_sec_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => '--ib-icon-clr-sec: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_text_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'bg_text_gradient' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => 'background-color: {{VALUE}};',
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
                'condition' => [
                    'bg_text_gradient' => '',
                    'bg_text_bg_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => 'background-color: {{VALUE}};',
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
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_text' => '-webkit-text-stroke-color: {{VALUE}};',
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
                'condition' => ['ib_content!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-infobox_content',
            ]
        );

        $this->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '12',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'custom_content_mask_color',
                'label' => esc_html__('Background', 'burido-core'),
                'types' => ['classic', 'gradient'],
                'condition' => ['custom_bg' => 'custom'],
                'selector' => '{{WRAPPER}} .wgl-infobox_content',
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
                    '{{WRAPPER}} .wgl-infobox_content' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_content' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_content' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_content' => 'color: {{VALUE}};',
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
            'style_button',
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
                'selector' => '{{WRAPPER}} .wgl-infobox_button .button__text',
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
                    '{{WRAPPER}} .wgl-infobox_button .button__text' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_button .button__text' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-infobox_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'read_more_icon_fontawesome[value]!' => '',
                ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-infobox_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'button_border',
			    'render_type' => 'template',
			    'dynamic' => ['active' => true],
			    'fields_options' => [
				    'color' => ['type' => Controls_Manager::HIDDEN],
			    ],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => ''],
			    'selector' => '{{WRAPPER}} .wgl-infobox_button',
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
                    '{{WRAPPER}} .wgl-infobox_button' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
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
                'prefix_class' => 'button%s-',
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button' => 'justify-content: {{VALUE}};',
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
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-infobox_button,
                     {{WRAPPER}} .wgl-infobox_button::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-infobox_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
				    '{{WRAPPER}} .wgl-icon,
				     {{WRAPPER}} .wgl-infobox_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .wgl-infobox_button .wgl-icon' => 'stroke: {{VALUE}}'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button .wgl-icon' => 'stroke: {{VALUE}}'
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
                    '{{WRAPPER}} .wgl-infobox_button' => 'border-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_button' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wgl-infobox_button',
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
                    '{{WRAPPER}} .wgl-infobox_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
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
                    '{{WRAPPER}} .wgl-infobox_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button,
                     {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button::before' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .button__text' => 'text-decoration-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon' => 'stroke: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button' => 'border-color: {{VALUE}}'
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button' => 'border-color: {{VALUE}}'
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
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_item_hover',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_button .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover,
                     {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover::before' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover span' => 'text-decoration-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon' => 'stroke: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover' => 'border-color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_hover',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:hover .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_active',
            ['label' => esc_html__('Active', 'burido-core')]
        );
        $this->add_control(
            'button_color_active',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active' => 'color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_active',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active,
                     {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active::before' => 'background-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_decoration_color_active',
            [
                'label' => esc_html__('Decoration Line Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'custom_fonts_button_text_decoration' => ['line-through', 'overline', 'underline'] ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active span' => 'text-decoration-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active span' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_color_active',
            [
                'label' => esc_html__('Icon BG Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[value]!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon,
				     {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon::before' => 'background-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon,
				     body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_stroke_active',
            [
                'label' => esc_html__('Icon Stroke Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'read_more_icon_fontawesome[library]' => 'svg' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon' => 'stroke: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_active',
            [
                'label' => esc_html__('Border Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'button_type' => 'wgl-button',
                    'button_border_border!' => ['', 'none']
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active' => 'border-color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_active',
                'condition' => [
                    'button_type' => 'wgl-button',
                ],
                'selector' => '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active',
            ]
        );
        $this->add_control(
            'button_bg_backdrop_filter_active',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
        $this->add_control(
            'button_icon_rotation_active',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-infobox_button:active .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BACKGROUND
         */

        $this->start_controls_section(
            'style_background',
            [
                'label' => esc_html__('Background', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_overflow',
            [
                'label' => esc_html__('Module Overflow', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Theme Default', 'burido-core'),
                    'overflow: visible;' => esc_html__('Visible', 'burido-core'),
                    'overflow: hidden;' => esc_html__('Hidden', 'burido-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'ib_bg_first',
                'fields_options' => [
                    'background' => [ 'label' => esc_html__( 'First Background', 'burido-core' ) ],
                ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wgl-infobox_bg_wrapper::before',
            ]
        );
        $this->add_control(
            'ib_bg_first_z_index',
            [
                'label' => esc_html__('First Background z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'condition' => [ 'ib_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_wrapper::before' => 'z-index: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'ib_bg_second',
                'fields_options' => [
                    'background' => [ 'label' => esc_html__( 'Second Background', 'burido-core' ) ],

                ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wgl-infobox_bg_wrapper::after',
            ]
        );
        $this->add_control(
            'ib_bg_second_z_index',
            [
                'label' => esc_html__('Second Background z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'step' => 1,
                'condition' => [ 'ib_bg_second_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_wrapper::after' => 'z-index: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
		    'ib_bg_position',
		    [
			    'label' => esc_html__('Position for Background', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
			    'size_units' => ['px', '%', 'custom'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-infobox_bg_wrapper' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border_idle',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                    'color' => [ 'type' => Controls_Manager::HIDDEN ],
                ],
                'selector' => '{{WRAPPER}} .wgl-infobox_bg_wrapper',
            ]
        );
	    $this->start_controls_tabs('tabs_background');
        $this->start_controls_tab(
            'tab_bg_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );
        $this->add_responsive_control(
            'ib_bg_first_idle',
            [
                'label' => esc_html__('Opacity for First Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'ib_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_wrapper::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ib_bg_second_idle',
            [
                'label' => esc_html__('Opacity for Second Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'ib_bg_second_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_wrapper::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'item_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'item_border_idle_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_bg_wrapper' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'item_border_color_idle-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'item_border_idle_border!' => ['', 'none'],
                    'item_border_color_idle!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox_bg_wrapper' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'container_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'container_shadow_idle',
			    'selector' => '{{WRAPPER}} .elementor-widget-container',

		    ]
	    );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'container_blur_idle',
                'selector' => '{{WRAPPER}} .wgl-infobox_bg_wrapper',
            ]
        );
	    $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_bg_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );
        $this->add_control(
            'ib_bg_first_hover',
            [
                'label' => esc_html__('Opacity for First Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'ib_bg_first_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_wrapper::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ib_bg_second_hover',
            [
                'label' => esc_html__('Opacity for Second Background', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01 ],
                ],
                'condition' => [ 'ib_bg_second_background!' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_wrapper::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'item_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'burido-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => [ 'item_border_idle_border!' => ['', 'none'] ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_wrapper' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'item_border_color_hover-dynamic',
            [
                'label' => esc_html__('Border Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'item_border_idle_border!' => ['', 'none'],
                    'item_border_color_hover!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_wrapper' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'container_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'container_shadow_hover',
			    'selector' => '{{WRAPPER}} .elementor-widget-container:hover',
		    ]
	    );
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'container_blur_hover',
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_bg_wrapper',
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
                    '{{WRAPPER}} .elementor-widget-container,
                     {{WRAPPER}} .wgl-infobox_bg_wrapper' => 'transition: {{SIZE}}s',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * CONTENT -> HOVER ANIMATION
         */

        $this->start_controls_section(
            'content_animation',
            [
                'label' => esc_html__('Hover Animation', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'hover_lifting',
            [
                'label' => esc_html__('Lift Up the Item', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'hover_toggling' => '',
                    'hover_toggling_icon' => ''
                ],
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'lifting',
                'prefix_class' => 'animation_'
            ]
        );

        $this->add_control(
            'hover_toggling_icon',
            [
                'label' => esc_html__('Toggle Icon Visibility', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'background_animation' => '',
                    'hover_lifting' => '',
                    'hover_toggling' => '',
                    'layout' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'toggling_icon',
                'prefix_class' => 'animation_'
            ]
        );

        $this->add_responsive_control(
            'hover_toggling_icon_offset',
            [
                'label' => esc_html__('Animation Distance', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'background_animation' => '',
                    'hover_lifting' => '',
                    'hover_toggling' => '',
                    'hover_toggling_icon!' => '',
                    'layout' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 100],
                ],
                'default' => ['size' => 40],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling_icon .content_wrapper' => 'padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.animation_toggling_icon .elementor-widget-container:hover .content_wrapper' => 'padding-left: {{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.animation_toggling_icon .media-wrapper' => 'transform: translateX(-{{SIZE}}{{UNIT}}) scale(0.5);',
                ],
            ]
        );

        $this->add_control(
            'hover_toggling',
            [
                'label' => esc_html__('Toggle Content Visibility', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'hover_lifting' => '',
                    'hover_toggling_icon' => '',
                ],
                'label_on' => esc_html__('On', 'burido-core'),
                'label_off' => esc_html__('Off', 'burido-core'),
                'return_value' => 'toggling',
                'prefix_class' => 'animation_',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_toggling_bg',
                'condition' => [ 'hover_toggling!' => '' ],
                'selector' => '{{WRAPPER}} .content_wrapper',
            ]
        );
        $this->add_responsive_control(
            'hover_toggling_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'hover_toggling!' => '' ],
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .content_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'hover_toggling_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'hover_toggling!' => '' ],
                'size_units' => ['px', '%', 'custom'],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .content_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'hover_toggling_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'hover_toggling!' => '' ],
                'range' => [
                    'px' => ['min' => 0.1, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 0.6],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling .wgl-infobox_content' => 'transition-duration: {{SIZE}}s;',
                ],
            ]
        );

        $this->add_control(
            'background_animation',
            [
                'label' => esc_html__('Background Animation', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'burido-core'),
                    'borders' => esc_html__('Borders', 'burido-core'),
                    'gradient' => esc_html__('Gradient', 'burido-core'),
                ],
                'frontend_available' => true,
                'condition' => ['hover_toggling_icon' => ''],
                'prefix_class' => 'bg_animation-',
            ]
        );

        $this->add_control(
            'container_animation_color',
            [
                'label' => esc_html__('Border Color for Animation', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['background_animation' => 'borders'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before,
                     {{WRAPPER}} .wgl-infobox::after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_animation_color-dynamic',
            [
                'label' => esc_html__('Border Color for Animation - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['container_animation_color!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox::before,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox::after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_width',
            [
                'label' => esc_html__('Wrapper Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'background_animation' => 'gradient' ],
                'size_units' => ['px', '%', 'vw', 'vh', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 2560],
                    '%' => ['min' => 0, 'max' => 200],
                    'vw' => ['min' => 0, 'max' => 100],
                    'vh' => ['min' => 0, 'max' => 100],
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_height',
            [
                'label' => esc_html__('Wrapper Height', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'background_animation' => 'gradient' ],
                'size_units' => ['px', '%', 'vw', 'vh', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 2560],
                    '%' => ['min' => 0, 'max' => 200],
                    'vw' => ['min' => 0, 'max' => 100],
                    'vh' => ['min' => 0, 'max' => 100],
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'overlay_color_1',
            [
                'label' => esc_html__('Primary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'background_animation' => 'gradient' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => '--overlay-color-1: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'overlay_color_1-dynamic',
            [
                'label' => esc_html__('Primary Gradient Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'background_animation' => 'gradient',
                    'overlay_color_1!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox::before' => '--overlay-color-1: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'overlay_color_2',
            [
                'label' => esc_html__('Secondary Gradient Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'background_animation' => 'gradient' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => '--overlay-color-2: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'overlay_color_2-dynamic',
            [
                'label' => esc_html__('Secondary Gradient Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'background_animation' => 'gradient',
                    'overlay_color_2!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-infobox::before' => '--overlay-color-2: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_location_1',
            [
                'label' => esc_html__('First Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 0 ],
                'render_type' => 'ui',
                'condition' => [ 'background_animation' => 'gradient' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => '--overlay-location-1: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'overlay_location_2',
            [
                'label' => esc_html__('Second Color Location', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ '%', 'px' ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
                'render_type' => 'ui',
                'condition' => [ 'background_animation' => 'gradient' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => '--overlay-location-2: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'overlay_gradient_type',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'linear' => esc_html__( 'Linear', 'burido-core' ),
                    'radial' => esc_html__( 'Radial', 'burido-core' ),
                ],
                'render_type' => 'ui',
                'condition' => [ 'background_animation' => 'gradient' ],
                'default' => 'linear',
            ]
        );

        $this->add_responsive_control(
            'overlay_gradient_angle',
            [
                'label' => esc_html__('Angle', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => [ 'step' => 10 ],
                ],
                'condition' => [
                    'background_animation' => 'gradient',
                    'overlay_gradient_type' => 'linear',
                ],
                'default' => [ 'unit' => 'deg', 'size' => 0 ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, var(--overlay-color-1) var(--overlay-location-1), var(--overlay-color-2) var(--overlay-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_gradient_position',
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
                    'background_animation' => 'gradient',
                    'overlay_gradient_type' => 'radial',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => 'background-color: transparent; background-image: radial-gradient(circle at {{VALUE}}, var(--overlay-color-1) var(--overlay-location-1), var(--overlay-color-2) var(--overlay-location-2));',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_gradient_h_position',
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
                    'background_animation' => 'gradient',
                    'overlay_gradient_type' => 'radial',
                    'overlay_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 50, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => '--h-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_gradient_v_position',
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
                    'background_animation' => 'gradient',
                    'overlay_gradient_type' => 'radial',
                    'overlay_gradient_position' => 'var(--h-pos) var(--v-pos)',
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox::before' => '--v-pos: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
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
                    '{{WRAPPER}} .wgl-button' => '--wgl-icon-wrapper: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => 'left:{{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => '--bg-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover::after,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'left: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-color: {{VALUE}};',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-offset: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-width: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button' => '--ab-extend: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-button .wgl-icon' => '--icon-bg-size: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .wgl-button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-button .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:hover .wgl-icon,
                     {{WRAPPER}} .elementor-widget-container .wgl-button:focus .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active .wgl-icon' => '--icon-scale: {{SIZE}};',
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
                    '{{WRAPPER}} .elementor-widget-container .wgl-button:active .wgl-icon' => '--icon-bg-scale: {{SIZE}};',
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
        $atts = $this->get_settings_for_display();

        (new WGLInfoBoxes())->render($this, $atts);
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