<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-flipbox.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Icons_Manager,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background
};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Icons
};

class WGL_Flipbox extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-flipbox';
    }

    public function get_title()
    {
        return esc_html__('WGL Flipbox', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-flipbox';
    }

    public function get_keywords()
    {
        return [ 'flip', 'box', 'change', 'rotation' ];
    }

    public function get_categories()
    {
        return ['wgl-modules'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'burido-core')]
        );

        $this->add_control(
            'dev_view',
            [
                'label' => esc_html__('Show Back Side', 'burido-core'),
                'description' => esc_html__('This option does not affect the result in any way', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '-active',
                'prefix_class' => 'dev_view'
            ]
        );

        $this->add_control(
            'flip_direction',
            [
                'label' => esc_html__('Flip Direction', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'flip_right' => esc_html__('Right', 'burido-core'),
                    'flip_left' => esc_html__('Left', 'burido-core'),
                    'flip_top' => esc_html__('Top', 'burido-core'),
                    'flip_bottom' => esc_html__('Bottom', 'burido-core'),
                ],
                'default' => 'flip_right',
            ]
        );

        $this->add_responsive_control(
            'flipbox_height',
            [
                'label' => esc_html__('Module Height', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => 150,
                'step' => 10,
                'default' => 330,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_item',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_item_front',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_control(
            'h_alignment_front',
            [
                'label' => esc_html__('Horizontal Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'v_alignment_front',
            [
                'label' => esc_html__('Vertical Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'burido-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_back',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_control(
            'h_alignment_back',
            [
                'label' => esc_html__('Horizontal Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content::after' => '{{VALUE}}: 0;',
                ],
            ]
        );

        $this->add_control(
            'v_alignment_back',
            [
                'label' => esc_html__('Vertical Alignment', 'burido-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'burido-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'burido-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'burido-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> MEDIA
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_media',
            ['label' => esc_html__('Media', 'burido-core')]
        );

        $this->start_controls_tabs( 'flipbox_icon' );

        $this->start_controls_tab(
            'flipbox_front_icon',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        WGL_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'burido-core'),
                'output' => '',
                'section' => false,
	            'default' => [
		            'media_type' => '',
		            'icon' => [
			            'library' => 'solid',
			            'value' => 'fas fa-icons'
		            ],
	            ],
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
                'prefix' => 'front_'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_icon',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        WGL_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'burido-core'),
                'output' => '',
                'section' => false,
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
                'prefix' => 'back_'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_content',
            ['label' => esc_html__('Content', 'burido-core')]
        );

        $this->start_controls_tabs('tabs_content');

        $this->start_controls_tab(
            'tab_content_front',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_control(
            'subtitle_front',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('Play to Earn', 'burido-core'),
            ]
        );

        $this->add_control(
            'title_front',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('Flipbox Title', 'burido-core'),
                'default' => esc_html__('Flipbox Title', 'burido-core'),
            ]
        );

        $this->add_control(
            'content_front',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'separator' => 'before',
                'label_block' => true,
                'placeholder' => esc_attr__('Front Content', 'burido-core'),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_back',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_control(
            'back_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'back_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'back_content',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('Back Content', 'burido-core'),
                'default' => esc_attr__('Quiet propulsion and less time lost at the fueling dock make the best way to spend time on the water', 'burido-core'),
            ]
        );

        $this->add_control(
            'back_content_trail',
            [
                'label' => esc_html__('Add Content Trailing Line', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['back_content!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'margin-bottom: 1em;',
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content::after' => 'content: \'\'',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> LINK
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_link',
            ['label' => esc_html__('Link', 'burido-core')]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['add_read_more' => ''],
            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'condition' => ['add_item_link!' => ''],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['add_item_link' => ''],
                'default' => ''
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'condition' => ['add_read_more!' => ''],
                'label_block' => true,
            ]
        );

        $this->start_controls_tabs(
            'tabs_button_link', [
                'condition' => [
                    'add_item_link' => '',
                    'add_read_more!' => ''
                ],
            ]
        );

        $this->start_controls_tab(
            'tab_button_front',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_control(
            'read_more_type_front',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon only', 'burido-core'),
                    'btn' => esc_html__('Button (Text with Icon)', 'burido-core'),
                ],
                'default' => 'icon',
            ]
        );

		$this->add_control(
            'read_more_text_front',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
				'condition' => [ 'read_more_type_front' => 'btn' ],
                'label_block' => true,
            ]
        );

	    $this->add_control(
            'read_more_icon_fontawesome_front',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
            ]
        );

        $this->add_control(
            'read_more_icon_align_front',
            [
                'label' => esc_html__( 'Position', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_front[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'options' => [
                    'row' => esc_html__( 'Before', 'burido-core' ),
                    'row-reverse' => esc_html__( 'After', 'burido-core' ),
                ],
                'default' => 'row-reverse',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_button.button-read-more' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_indent_front',
            [
                'label' => esc_html__( 'Icon Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_front[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'range' => [
                    'px' => [ 'max' => 250 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_button.button-read-more' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_indent_front_hover',
            [
                'label' => esc_html__( 'Icon Offset on Hover', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_front[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'range' => [
                    'px' => [ 'max' => 250 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_button.button-read-more:hover' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_top_front',
            [
                'label' => esc_html__('Icon Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => ['min' => -50, 'max' => 50],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_front[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_button.button-read-more .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_back',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_control(
            'read_more_type_back',
            [
                'label' => esc_html__('Type', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'burido-core'),
                    'btn' => esc_html__('Button', 'burido-core'),
                ],
                'default' => 'btn',
            ]
        );

		$this->add_control(
            'read_more_text_back',
            [
                'label' => esc_html__('Button Text', 'burido-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => ['active' => true],
				'condition' => [ 'read_more_type_back' => 'btn' ],
                'label_block' => true,
                'default' => esc_html__('Read More', 'burido-core'),
            ]
        );

	    $this->add_control(
            'read_more_icon_fontawesome_back',
            [
                'label' => esc_html__('Icon', 'burido-core'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'burido-core'),
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fas fa-arrow-right',
                ],
            ]
        );

        $this->add_control(
            'read_more_icon_align_back',
            [
                'label' => esc_html__( 'Position', 'burido-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_back[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'options' => [
                    'row' => esc_html__( 'Before', 'burido-core' ),
                    'row-reverse' => esc_html__( 'After', 'burido-core' ),
                ],
                'default' => 'row-reverse',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_button.button-read-more' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_indent_back',
            [
                'label' => esc_html__( 'Icon Offset', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_back[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'range' => [
                    'px' => [ 'max' => 250 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_button.button-read-more' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_indent_back_hover',
            [
                'label' => esc_html__( 'Icon Offset on Hover', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_back[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'range' => [
                    'px' => [ 'max' => 250 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_button.button-read-more:hover' => 'gap: {{SIZE}}{{UNIT}}; --wgl-icon-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_top_back',
            [
                'label' => esc_html__('Icon Top Offset', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => ['min' => -50, 'max' => 50],
                ],
                'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_icon_fontawesome_back[value]!' => '',
                    'read_more_text_back!' => '',
                    'read_more_type_back' => 'btn'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_button.button-read-more .wgl-icon' => '--icon-translate-y: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

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

        $this->start_controls_tabs('flipbox_style');

        $this->start_controls_tab(
            'flipbox_front_style',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'front_background',
                'label' => esc_html__('Front Background', 'burido-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wgl-flipbox_front',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_style',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'back_background',
                'label' => esc_html__('Back Background', 'burido-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wgl-flipbox_back',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'flipbox_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'flipbox_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'flipbox_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'flipbox_border',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'flipbox_shadow',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> MEDIA
         */

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_media' );

        $this->start_controls_tab(
            'tab_media_front',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typo_front',
                'condition' => ['front_icon_type' => 'number'],
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-icon',
            ]
        );

        $this->add_responsive_control(
            'icon_size_front',
            [
                'label' => esc_html__('Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => ['front_icon_type' => 'font'],
                'range' => [
                    'px' => ['min' => 16, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_margin_front',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '23',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding_front',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['front_icon_type' => ['font', 'number']],
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .media-wrapper .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'media_icon_rotate_front',
            [
                'label' => esc_html__('Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'condition' => ['front_icon_type' => 'font'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .media-wrapper .wgl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'icon_color_front',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['front_icon_type' => ['font', 'number']],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_front-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'front_icon_type' => ['font', 'number'],
                    'icon_color_front!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
			'icon_bg_front',
			[
				'label' => esc_html__('Additional Color', 'burido-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
				'condition' => ['front_icon_type' => ['font', 'number']],
				'selectors' => [
					'{{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'background-color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
            'icon_bg_front-dynamic',
            [
                'label' => esc_html__('Additional Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'front_icon_type' => ['font', 'number'],
                    'icon_bg_front!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow_front',
                'condition' => ['front_icon_type' => ['font', 'number']],
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border_front',
                'condition' => ['front_icon_type' => ['font', 'number']],
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-icon',
            ]
        );

        $this->add_responsive_control(
		    'icon_border_radius_front',
		    [
			    'label' => esc_html__('Border Radius', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%', 'custom'],
                'condition' => ['front_icon_type' => ['font', 'number']],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );


        $this->add_responsive_control(
            'image_width_front',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'front_icon_type' => 'image',
                    'front_thumbnail[url]!' => '',
                ],
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 800 ],
                    '%' => ['min' => 5, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_media_back',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typo_back',
                'condition' => ['front_icon_type' => 'number'],
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-icon',
            ]
        );

        $this->add_responsive_control(
            'icon_size_back',
            [
                'label' => esc_html__('Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => ['back_icon_type' => 'font'],
                'range' => [
                    'px' => ['min' => 16, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_margin_back',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '23',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding_back',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['back_icon_type' => ['font', 'number']],
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .media-wrapper .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'media_icon_rotate_back',
            [
                'label' => esc_html__('Rotate', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'size_units' => ['deg', 'turn'],
                'condition' => ['back_icon_type' => 'font'],
                'range' => [
                    'deg' => ['min' => -360, 'max' => 360],
                    'turn' => ['min' => -1, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['unit' => 'deg'],
                'tablet_default' => ['unit' => 'deg'],
                'mobile_default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .media-wrapper .wgl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'icon_color_back',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'condition' => ['back_icon_type' => ['font', 'number']],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_back-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'back_icon_type' => ['font', 'number'],
                    'icon_color_back!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
			'icon_bg_back',
			[
				'label' => esc_html__('Additional Color', 'burido-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
				'condition' => ['back_icon_type' => ['font', 'number']],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'background-color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
            'icon_bg_back-dynamic',
            [
                'label' => esc_html__('Additional Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [
                    'back_icon_type' => ['font', 'number'],
                    'icon_bg_back!' => ''
                ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow_back',
                'condition' => ['back_icon_type' => ['font', 'number']],
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border_back',
                'condition' => ['back_icon_type' => ['font', 'number']],
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-icon',
            ]
        );

        $this->add_responsive_control(
		    'icon_border_radius_back',
		    [
			    'label' => esc_html__('Border Radius', 'burido-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%', 'custom'],
                'condition' => ['back_icon_type' => ['font', 'number']],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_responsive_control(
            'image_width_back',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'condition' => [
                    'back_icon_type' => 'image',
                    'back_thumbnail[url]!' => '',
                ],
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 800 ],
                    '%' => ['min' => 5, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_title');

        $this->start_controls_tab(
            'front_title_style',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_front',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title',
            ]
        );

        $this->add_control(
            'title_tag_front',
            [
                'label' => esc_html__('HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'title_color_front',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_front-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'title_color_front!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin_front',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_title_style',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_back',
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title',
            ]
        );

        $this->add_control(
            'title_tag_back',
            [
                'label' => esc_html__('HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'title_color_back',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_back-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'title_color_back!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin_back',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '15',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Subtitle
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_subtitle');

        $this->start_controls_tab(
            'front_subtitle_style',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_front',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_subtitle span',
            ]
        );

        $this->add_control(
            'subtitle_tag_front',
            [
                'label' => esc_html__('HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' =>'‹div›',
                    'p' =>  '‹p›',
                    'span' => '‹span›',
                ],
                'default' => 'div',
            ]
        );

        $this->add_control(
            'subtitle_color_front',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_subtitle span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_front-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_color_front!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_subtitle span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_margin_front',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_subtitle span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_subtitle_style',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_back',
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_subtitle span',
            ]
        );

        $this->add_control(
            'subtitle_tag_back',
            [
                'label' => esc_html__('HTML Tag', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
                'default' => 'div',
            ]
        );

        $this->add_control(
            'subtitle_color_back',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_subtitle span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'subtitle_color_back-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'subtitle_color_back!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_subtitle span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_margin_back',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_subtitle span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_content_styles' );

        $this->start_controls_tab(
            'front_content_style',
            ['label' => esc_html__('Front', 'burido-core')]
        );

        $this->add_responsive_control(
            'front_content_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_front_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content',
            ]
        );

        $this->add_control(
            'front_content_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'front_content_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'front_content_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_content_style',
            ['label' => esc_html__('Back', 'burido-core')]
        );

        $this->add_responsive_control(
            'back_content_offset',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_back_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content',
            ]
        );

        $this->add_control(
            'back_content_color',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'back_content_color-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'back_content_color!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BUTTON ICON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_button_icon',
            [
                'label' => esc_html__('Button Icon(Only Icon Type)', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['add_read_more!' => ''],
            ]
        );

        $this->add_responsive_control(
		    'read_more_icon_size',
		    [
			    'label' => esc_html__('Icon Size', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 200 ],
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more i' => 'font-size: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_control(
            'read_more_icon_rotate',
            [
                'label' => esc_html__('Icon Rotate', 'burido-core'),
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more .wgl-icon' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
		    'read_more_icon_spacing',
		    [
			    'label' => esc_html__('Icon Wrapper Size', 'burido-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 100 ],
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more i,
				     {{WRAPPER}} .wgl-flipbox_button.icon-read-more span' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_responsive_control(
            'button_icon_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'default' => [
                    'top' => '18',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs(
            'tabs_button_icon',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_button_icon_idle',
            ['label' => esc_html__('Idle' , 'burido-core')]
        );

        $this->add_control(
            'button_icon_color_idle',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_icon_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.icon-read-more .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'button_icon_bg_idle',
		    [
			    'label' => esc_html__('Background Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more' => 'background: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'button_icon_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_icon_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.icon-read-more' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_icon_idle',
                'label' => esc_html__('Border Type', 'burido-core'),
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.icon-read-more',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_icon_idle',
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.icon-read-more',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_icon_hover',
            ['label' => esc_html__('Hover' , 'burido-core')]
        );

        $this->add_control(
            'button_icon_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'title_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.icon-read-more:hover .wgl-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.icon-read-more:hover' => 'background: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'button_icon_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_icon_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.icon-read-more:hover' => 'background: {{VALUE}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_icon_hover',
                'label' => esc_html__('Border Type', 'burido-core'),
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.icon-read-more:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_icon_hover',
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.icon-read-more:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BUTTON TEXT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button Text (Text with Icon Type)', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['add_read_more!' => ''],
            ]
        );

        $this->add_responsive_control(
            'custom_button_text_icon_size',
            [
                'label' => esc_html__('Icon Size', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 10, 'max' => 200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_button_text_icon_rotate',
            [
                'label' => esc_html__('Icon Rotate', 'burido-core'),
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more i' => '--icon-rotate: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_button_text_font',
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.button-read-more',
            ]
        );

        $this->add_responsive_control(
            'custom_button_text_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_button_text_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'button_text_border_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs(
            'tabs_button_text',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_button_text_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'button_text_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_text_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.button-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'button_text_bg_idle',
		    [
			    'label' => esc_html__('Background Color', 'burido-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_button.button-read-more' => 'background: {{VALUE}};',
			    ],
		    ]
	    );
        $this->add_control(
            'button_text_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_text_bg_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.button-read-more' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_icon_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_text_icon_color_idle!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.button-read-more .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_text_idle',
                'label' => esc_html__('Border Type', 'burido-core'),
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.button-read-more',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_text_shadow_idle',
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.button-read-more',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            ['label' => esc_html__('Hover' , 'burido-core')]
        );
        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more:hover' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'button_text_color_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_text_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.button-read-more:hover' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'button_text_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more:hover' => 'background: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'button_text_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_text_bg_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.button-read-more:hover' => 'background: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'button_text_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_button.button-read-more:hover .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_icon_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => [ 'button_text_icon_color_hover!' => '' ],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .wgl-flipbox_button.button-read-more:hover .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_text_border_hover',
                'label' => esc_html__('Border Type', 'burido-core'),
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.button-read-more:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_text_shadow_hover',
                'selector' => '{{WRAPPER}} .wgl-flipbox_button.button-read-more:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        $kses_allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
                'rel' => true, 'target' => true
            ],
            'br' => ['class' => true, 'style' => true],
            'em' => ['class' => true, 'style' => true],
            'strong' => ['class' => true, 'style' => true],
            'span' => ['class' => true, 'style' => true],
            'p' => ['class' => true, 'style' => true]
        ];

        $this->add_render_attribute('flipbox', 'class', ['wgl-flipbox', 'type_'.$_s['flip_direction'] ]);

        if (isset($_s['link']['url'])) $this->add_link_attributes('flipbox_link', $_s['link']);

        $this->add_render_attribute('item_link', 'class', 'wgl-flipbox_item-link');
        if (isset($_s['item_link']['url'])) $this->add_link_attributes('item_link', $_s['item_link']);

        // Icon/Image
        ob_start();
        if (!empty($_s['front_icon_type'])) {
            $icons = new WGL_Icons;
            echo $icons->build($this, $_s, 'front_');
        }
        $front_media = ob_get_clean();

        ob_start();
        if (!empty($_s['back_icon_type'])) {
            $icons = new WGL_Icons;
            echo $icons->build($this, $_s, 'back_');
        }
        $back_media = ob_get_clean();

        $front_btn = $back_btn = '';
        // Read more button
        if ($_s['add_read_more']) {
            $btn = ['front', 'back'];
            foreach ($btn as $v) {
                $this->add_render_attribute('btn_'.$v, 'class', ['wgl-flipbox_button','btn_'.$v, 'icon' === $_s['read_more_type_'.$v] ? 'icon-read-more' : 'button-read-more']);

                ${'icon_'.$v} = $_s['read_more_icon_fontawesome_'.$v];

                $migrated = isset($_s['__fa4_migrated']['read_more_icon_fontawesome_'.$v]);
                $is_new = Icons_Manager::is_migration_allowed();
                $icon_output = '';

                if ( $is_new || $migrated ) {
                    ob_start();
	                Icons_Manager::render_icon(
		                $_s['read_more_icon_fontawesome_'.$v],
		                [
			                'class' => 'read-more-icon',
			                'aria-hidden' => 'true',
		                ]
	                );
                    $icon_output .= ob_get_clean();
                } else {
                    $icon_output .= '<i class="icon read-more-icon '.esc_attr(${'icon_'.$v}).'"></i>';
                }

                if (!empty($icon_output) || $_s['read_more_text_'.$v]){
                    ${$v.'_btn'} = '<div class="wgl-flipbox_button-wrap">';
                        ${$v.'_btn'} .= sprintf('<%s %s %s>',
                            'a',
                            $this->get_render_attribute_string('flipbox_link'),
                            $this->get_render_attribute_string('btn_'.$v)
                        );

                        ${$v.'_btn'} .= $icon_output;
                        if('icon' !== $_s['read_more_type_' .$v]){
                            ${$v.'_btn'} .= $_s['read_more_text_'.$v] ? '<span>' . esc_html($_s['read_more_text_'.$v]) . '</span>' : '';
                        }
                        ${$v.'_btn'} .= '</a>';
                    ${$v.'_btn'} .= '</div>';
                }
            }
        }

        // Render
        echo '<div ', $this->get_render_attribute_string('flipbox'), '>';
            echo '<div class="wgl-flipbox_wrap">';

                echo '<div class="wgl-flipbox_front">';
                    if ($_s['front_icon_type'] && $front_media) {
                        echo '<div class="wgl-flipbox_media-wrap">',
                            $front_media,
                        '</div>';
                    }
                    if (!empty($_s['subtitle_front'])) {
                        echo '<', $_s['subtitle_tag_front'], ' class="wgl-flipbox_subtitle">',
                            '<span>',
                                wp_kses($_s['subtitle_front'], $kses_allowed_html),
                            '</span>',
                        '</', $_s['subtitle_tag_front'], '>';
                    }
                    if (!empty($_s['title_front'])) {
                        echo '<', $_s['title_tag_front'], ' class="wgl-flipbox_title">',
                            '<span>',
                                wp_kses($_s['title_front'], $kses_allowed_html),
                            '</span>',
                        '</', $_s['title_tag_front'], '>';
                    }
                    if (!empty($_s['content_front'])) {
                        echo '<div class="wgl-flipbox_content">',
                            wp_kses($_s['content_front'], $kses_allowed_html),
                        '</div>';
                    }

                    echo $front_btn;

                echo '</div>'; // wgl-flipbox_front

                echo '<div class="wgl-flipbox_back">';
                    if ($_s['back_icon_type'] && $back_media) {
                        echo '<div class="wgl-flipbox_media-wrap">',
                            $back_media,
                        '</div>';
                    }
                    if (!empty($_s['back_subtitle'])) {
                        echo '<', $_s['subtitle_tag_back'], ' class="wgl-flipbox_subtitle">',
                            '<span>',
                                wp_kses($_s['back_subtitle'], $kses_allowed_html),
                            '</span>',
                        '</', $_s['subtitle_tag_back'], '>';
                    }
                    if (!empty($_s['back_title'])) {
                        echo '<', $_s['title_tag_back'], ' class="wgl-flipbox_title">',
                            '<span>',
                                wp_kses($_s['back_title'], $kses_allowed_html),
                            '</span>',
                        '</', $_s['title_tag_back'], '>';
                    }
                    if (!empty($_s['back_content'])) {
                        echo '<div class="wgl-flipbox_content">',
                            wp_kses($_s['back_content'], $kses_allowed_html),
                        '</div>';
                    }
                    echo $back_btn;

                echo '</div>'; // _back

            echo '</div>';

            if ($_s['add_item_link']) {
                echo '<a ', $this->get_render_attribute_string('item_link'), '></a>';
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