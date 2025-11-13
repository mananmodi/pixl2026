<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-team.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Css_Filter,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow
};
use WGL_Extensions\{
    WGL_Framework_Global_Variables as WGL_Globals,
    Includes\WGL_Loop_Settings,
    Includes\WGL_Carousel_Settings,
    Templates\WGL_Team as Team_Template,
    Includes\WGL_Cursor
};

class WGL_Team extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-team';
    }

    public function get_title()
    {
        return esc_html__('WGL Team', 'burido-core');
    }

    public function get_icon()
    {
        return 'wgl-team';
    }

    public function get_keywords() {
        return ['team'];
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

        $this->add_responsive_control(
            'posts_per_row',
            [
                'label' => esc_html__('Columns Amount', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1 (one)', 'burido-core'),
                    '2' => esc_html__('2 (two)', 'burido-core'),
                    '3' => esc_html__('3 (three)', 'burido-core'),
                    '4' => esc_html__('4 (four)', 'burido-core'),
                    '5' => esc_html__('5 (five)', 'burido-core'),
                    '6' => esc_html__('6 (six)', 'burido-core'),
                ],
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'selectors' => [
                    '{{WRAPPER}} .wgl_module_team' => '--team-width: calc(100% / {{VALUE}});',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'posts_gap',
            [
                'label' => esc_html__('Grid Gap', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'frontend_available' => true,
                'range' => [
                    'px' => ['min' => 0, 'max' => 70, 'step' => 2],
                ],
                'default' => ['size' => 10],
                'selectors' => [
                    '{{WRAPPER}} .wgl_module_team' => '--team-grid-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
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
                'prefix_class' => 'a',
                'default' => 'left',
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Images Size', 'burido-core'),
                'separator' => 'before',
                'options' => [
                    '150' => esc_html__('150x150 - Thumbnail', 'burido-core'),
                    '300' => esc_html__('300x300 - Medium', 'burido-core'),
                    '768' => esc_html__('768x768 - Medium Large', 'burido-core'),
                    '1024' => esc_html__('1024x1024 - 1 Column', 'burido-core'),
                    '800' => esc_html__('800x800 - 2 Columns', 'burido-core'),
                    '686x560' => esc_html__('686x560 - 3 Columns', 'burido-core'),
                    'full' => esc_html__('Full', 'burido-core'),
                    'custom' => esc_html__('Custom', 'burido-core'),
                ],
                'default' => '686x560',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'burido-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => ['img_size_string' => 'custom'],
                'description' => esc_html__('You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'burido-core'),
                'default' => [
                    'width' => '740',
                    'height' => '970',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Aspect Ratio', 'burido-core'),
                'options' => [
                    '' => esc_html__('No Crop', 'burido-core'),
                    '1:1' => esc_html('1:1'),
                    '3:2' => esc_html('3:2'),
                    '4:3' => esc_html('4:3'),
                    '6:5' => esc_html('6:5'),
                    '9:16' => esc_html('9:16'),
                    '16:9' => esc_html('16:9'),
                    '21:9' => esc_html('21:9'),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'thumbnail_linked',
            [
                'label' => esc_html__('Add Link on Image', 'burido-core'),
                'separator' => 'before',
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'heading_linked',
            [
                'label' => esc_html__('Add Link on Heading', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> APPEARANCE
         */

        $this->start_controls_section(
            'content_appearance',
            ['label' => esc_html__('Appearance', 'burido-core')]
        );

        $this->add_control(
            'hide_title',
            [
                'label' => esc_html__('Hide Title', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_highlited_info',
            [
                'label' => esc_html__('Hide Highlighted Info', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_socials',
            [
                'label' => esc_html__('Hide Social Icons', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_content',
            [
                'label' => esc_html__('Hide Excerpt|Content', 'burido-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'content_limit',
            [
                'label' => esc_html__('Excerpt|Content Characters Amount', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
                'dynamic' => ['active' => true],
                'condition' => ['hide_content!' => 'yes'],
                'label_block' => true,
                'min' => 5,
                'default' => '100',
            ]
        );

        WGL_Cursor::init(
            $this,
            [
                'section' => false,
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

	    WGL_Carousel_Settings::add_controls(
            $this,
            [
                'pagination_margin' => [
                    'default' => [
                        'top' => '30',
                        'right' => '0',
                        'bottom' => '0',
                        'left' => '0',
                        'unit' => 'px',
                        'isLinked' => false
                    ],
                ],
            ]
        );

        /**
         * SETTINGS -> QUERY
         */

        WGL_Loop_Settings::add_controls(
            $this,
            [
                'post_type' => 'team',
                'hide_cats' => true,
                'hide_tags' => true
            ]
        );

        /**
         * STYLE -> ITEM CONTAINERS
         */

        $this->start_controls_section(
            'style_item_containers',
            [
                'label' => esc_html__('Item Containers', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_box_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'allowed_dimensions' => 'vertical',
				'placeholder' => [
					'top' => '',
					'right' => 'auto',
					'bottom' => '',
					'left' => 'auto',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl_module_team .team__member' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
            ]
        );

        $this->add_responsive_control(
            'item_box_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_box_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'item_box',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'item_box_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_idle',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .member__wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_idle',
                'selector' => '{{WRAPPER}} .member__wrapper',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_box_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_box_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .member__wrapper:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_hover',
                'selector' => '{{WRAPPER}} .member__wrapper:hover',
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
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__thumbnail,
                     {{WRAPPER}} .member__thumbnail img,
                     {{WRAPPER}} .member__thumbnail::before,
                     {{WRAPPER}} .member__thumbnail::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_scale_animation',
            [
                'label' => esc_html__( 'Image Hover Scale Animation', 'burido-core' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'image_scale_size',
            [
                'label' => esc_html__( 'Scale Size', 'burido-core' ),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_scale_animation!' => '' ],
                'range' => [
                    'px' => [ 'min' => 0.1, 'max' => 2, 'step' => 0.01 ],
                ],
                'default' => [ 'size' => 1.03 ],
                'selectors' => [
                    '{{WRAPPER}} .member__thumbnail' => '--wgl-team-image-scale-size: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'image_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'condition' => [ 'image_scale_animation!' => '' ],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.6],
                'selectors' => [
                    '{{WRAPPER}} .member__thumbnail' => '--wgl-team-image-transition: {{SIZE}}s',
                ],
            ]
        );

        $this->start_controls_tabs('overlay');

        $this->start_controls_tab(
            'overlay_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_idle',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .member__thumbnail::before',
            ]
        );

        $this->add_control(
            'overlay_blend_idle',
            [
                'label' => esc_html__('Blend Mode', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Disabled', 'burido-core'),
                    'multiply' => esc_html__('Multiply', 'burido-core'),
                    'screen' => esc_html__('Screen', 'burido-core'),
                    'overlay' => esc_html__('Overlay', 'burido-core'),
                    'darken' => esc_html__('Darken', 'burido-core'),
                    'lighten' => esc_html__('Lighten', 'burido-core'),
                    'color-dodge' => esc_html__('Color Dodge', 'burido-core'),
                    'saturation' => esc_html__('Saturation', 'burido-core'),
                    'color' => esc_html__('Color', 'burido-core'),
                    'difference' => esc_html__('Difference', 'burido-core'),
                    'exclusion' => esc_html__('Exclusion', 'burido-core'),
                    'hue' => esc_html__('Hue', 'burido-core'),
                    'luminosity' => esc_html__('Luminosity', 'burido-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .member__thumbnail::before' => 'mix-blend-mode: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'overlay_notice_idle',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => [
                    'overlay_blend_idle!' => '',
                    'overlay_idle_color' => ''
                ],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Blend Mode affects only overlay color|image. Please choose one.', 'burido-core' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'overlay_idle',
                'selector' => '{{WRAPPER}} .member__thumbnail img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'overlay_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .member__thumbnail::after',
            ]
        );

        $this->add_control(
            'overlay_blend_hover',
            [
                'label' => esc_html__('Blend Mode', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Disabled', 'burido-core'),
                    'multiply' => esc_html__('Multiply', 'burido-core'),
                    'screen' => esc_html__('Screen', 'burido-core'),
                    'overlay' => esc_html__('Overlay', 'burido-core'),
                    'darken' => esc_html__('Darken', 'burido-core'),
                    'lighten' => esc_html__('Lighten', 'burido-core'),
                    'color-dodge' => esc_html__('Color Dodge', 'burido-core'),
                    'saturation' => esc_html__('Saturation', 'burido-core'),
                    'color' => esc_html__('Color', 'burido-core'),
                    'difference' => esc_html__('Difference', 'burido-core'),
                    'exclusion' => esc_html__('Exclusion', 'burido-core'),
                    'hue' => esc_html__('Hue', 'burido-core'),
                    'luminosity' => esc_html__('Luminosity', 'burido-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .member__thumbnail::after' => 'mix-blend-mode: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'overlay_notice_hover',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => [
                    'overlay_blend_hover!' => '',
                    'overlay_hover_color' => ''
                ],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Blend Mode affects only overlay color|image. Please choose one.', 'burido-core' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'overlay_hover',
                'selector' => '{{WRAPPER}} .member__wrapper:hover .member__thumbnail img',
            ]
        );

        $this->add_control(
            'overlay_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .member__thumbnail,
                     {{WRAPPER}} .member__thumbnail img,
                     {{WRAPPER}} .member__thumbnail::before,
                     {{WRAPPER}} .member__thumbnail::after' => 'transition-duration: {{SIZE}}s;',
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
                'name' => 'title',
                'selector' => '{{WRAPPER}} .member__name',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .member__name',
            ]
        );

        $this->start_controls_tabs(
            'tabs_title',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_title_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .member__name' => 'color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .member__name' => 'color: {{VALUE}}',
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
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .member__name a:hover' => 'color: {{VALUE}}',
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
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .member__name a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> HIGHLIGHTED INFO
         */

        $this->start_controls_section(
            'style_highlighted_info',
            [
                'label' => esc_html__('Highlighted Info', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta',
                'selector' => '{{WRAPPER}} .member__highlighted',
            ]
        );

        $this->add_responsive_control(
            'highlighted_meta_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__highlighted' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'highlighted_meta_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__highlighted' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_highlighted',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_highlighted_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'highlighted_idle',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .member__highlighted' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'highlighted_idle-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['highlighted_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .member__highlighted' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'highlighted_bg_idle',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .member__highlighted',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_highlighted_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'highlighted_hover',
            [
                'label' => esc_html__('Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .member__wrapper:hover .member__highlighted' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'highlighted_hover-dynamic',
            [
                'label' => esc_html__('Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['highlighted_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .member__wrapper:hover .member__highlighted' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'highlighted_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .member__wrapper:hover .member__highlighted',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'highlighted_meta_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .member__highlighted',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> SOCIALS
         */

        $this->start_controls_section(
            'style_socials',
            [
                'label' => esc_html__('Socials', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'socials_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__socials' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'socials_padding',
            [
                'label' => esc_html__('Padding', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__socials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'socials_radius',
            [
                'label' => esc_html__('Border Radius', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__socials' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'socials_wrap_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .member__socials' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'socials_wrap_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['socials_wrap_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .member__socials' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->start_controls_tabs(
            'socials',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'socials_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'socials_color_idle',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .social__icon' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'socials_color_idle-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['socials_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .social__icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'socials_bg_idle',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .social__icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'socials_bg_idle-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['socials_bg_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .social__icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'socials_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'socials_color_hover',
            [
                'label' => esc_html__('Icon Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .social__icon:hover,
                     {{WRAPPER}} .team__member .social__icon::after' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'socials_color_hover-dynamic',
            [
                'label' => esc_html__('Icon Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['socials_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .social__icon:hover,
                     body.wgl_dynamic_colors-active {{WRAPPER}} .team__member .social__icon::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'socials_bg_hover',
            [
                'label' => esc_html__('Background Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .social__icon:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'socials_bg_hover-dynamic',
            [
                'label' => esc_html__('Background Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['socials_bg_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .social__icon:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> EXCERPT | CONTENT
         */

        $this->start_controls_section(
            'style_excerpt',
            [
                'label' => esc_html__('Excerpt | Content', 'burido-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_content' => ''],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'burido-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .member__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .member__excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt',
                'selector' => '{{WRAPPER}} .member__excerpt',
            ]
        );

	    $this->start_controls_tabs(
            'tabs_excerpt',
            ['separator' => 'before']
        );

	    $this->start_controls_tab(
            'tab_excerpt_idle',
            ['label' => esc_html__('Idle', 'burido-core')]
        );

        $this->add_control(
            'excerpt_color_idle',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .member__excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'excerpt_color_idle-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['excerpt_color_idle!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .member__excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_excerpt_hover',
            ['label' => esc_html__('Hover', 'burido-core')]
        );

        $this->add_control(
            'excerpt_color_hover',
            [
                'label' => esc_html__('Text Color', 'burido-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .member__wrapper:hover .member__excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'excerpt_color_hover-dynamic',
            [
                'label' => esc_html__('Text Color - Dynamic', 'burido-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'dynamic' => ['active' => true],
                'condition' => ['excerpt_color_hover!' => ''],
                'selectors' => [
                    'body.wgl_dynamic_colors-active {{WRAPPER}} .member__wrapper:hover .member__excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        (new Team_Template())->render($this, $atts);
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
