<?php
namespace WGL_Extensions\Includes;

defined('ABSPATH') || exit;

use Elementor\{
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Background
};

if (!class_exists('WGL_Cursor')) {
    /**
     * WGL Elementor Media Settings
     *
     *
     * @package burido-core\includes\elementor
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     * @version 1.0.0
     */
    class WGL_Cursor
    {
        private static $instance;

        public function build($self, $atts, $repeater_id = '', $pref = '')
        {
            return (new WGL_Cursor_Builder())->build($self, $atts, $repeater_id, $pref);
        }

        /**
         * @since 1.0.0
         * @version 1.0.0
         */
        public static function init($self, $attrs = [])
        {

            // Variables validation
            $section = $attrs['section'] ?? true;
            $repeater = isset($attrs['repeater']) && $attrs['repeater'] ? '{{CURRENT_ITEM}}' : '.wgl-element-{{ID}}.cursor-global';
            $prefix = $attrs['prefix'] ?? '';

            if ($section) {
                $self->start_controls_section(
                    $prefix . 'add_cursor_tooltip_section',
                    [
                        'label' => esc_html__('Cursor Tooltip', 'burido-core'),
                        'condition' => $attrs['condition'] ?? [],
                    ]
                );
            }

            $self->add_control(
                $prefix . 'cursor_tooltip',
                [
                    'label' => esc_html__('Cursor Tooltip', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ($attrs['condition'] ?? []),
                ]
            );
            $self->add_responsive_control(
                $prefix . 'cursor_margin',
                [
                    'label' => esc_html__('Margin', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '#wgl-cursor {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [$prefix . 'cursor_tooltip' => 'yes'] + ($attrs['condition'] ?? []),
                ]
            );
            $self->add_control(
                $prefix . 'tooltip_transition',
                [
                    'label' => esc_html__('Tooltip Transition (sec)', 'burido-core'),
                    'type' => Controls_Manager::NUMBER,
                    'dynamic' => ['active' => true],
                    'min' => 0,
                    'max' => 5,
                    'step' => 0.1,
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}' => '--transition: {{VALUE}}s;',
                        '#wgl-cursor {{CURRENT_ITEM}}' => '--transition: {{VALUE}}s;',
                    ],
                    'condition' => [$prefix . 'cursor_tooltip' => 'yes'] + ($attrs['condition'] ?? []),
                ]
            );
            $self->add_control(
                $prefix . 'cursor_prop',
                [
                    'label' => esc_html__('Cursor Property', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [$prefix . 'cursor_tooltip' => 'yes'] + ($attrs['condition'] ?? []),
                    'default' => ''
                ]
            );

            $self->add_control(
                $prefix . 'cursor_tooltip_type',
                [
                    'label' => esc_html__('Tooltip Type', 'burido-core'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'simple' => esc_html__('Simple', 'burido-core'),
                        'def' => esc_html__('Default Text', 'burido-core'),
                        'custom' => esc_html__('Custom Text', 'burido-core'),
                        'image' => esc_html__('Image', 'burido-core'),
                    ],
                    'default' => 'simple',
                    'condition' => [$prefix . 'cursor_tooltip' => 'yes'] + ($attrs['condition'] ?? []),
                ]
            );

            $self->add_control(
                $prefix . 'tooltip_text',
                [
                    'label' => esc_html__('Tooltip Title', 'burido-core'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'condition' => [
                        $prefix . 'cursor_tooltip_type' => 'custom',
                        $prefix . 'cursor_tooltip' => 'yes'
                    ] + ($attrs['condition'] ?? []),
                    'label_block' => true,
                ]
            );

            WGL_Icons::init(
                $self,
                [
                    'output' => '',
                    'section' => false,
                    'media_types_options' => [
                        '' => [
                            'title' => esc_html__('None', 'burido-core'),
                            'icon' => 'eicon-ban',
                        ],
                        'font' => [
                            'title' => esc_html__('Icon', 'burido-core'),
                            'icon' => 'far fa-smile',
                        ],
                    ],
                    'default' => [
                        'media_type' => 'font',
                    ],
                    'condition' => [
                        $prefix . 'cursor_tooltip_type' => 'custom',
                        $prefix . 'cursor_tooltip' => 'yes'
                    ] + ($attrs['condition'] ?? []),
                    'prefix' => $prefix . 'tooltip_'
                ]
            );

            $self->add_control(
                $prefix . 'cursor_thumbnail',
                [
                    'label' => esc_html__('Thumbnail', 'burido-core'),
                    'type' => Controls_Manager::MEDIA,
                    'dynamic' => ['active' => true],
                    'label_block' => true,
                    'condition' => [
                        $prefix . 'cursor_tooltip_type' => 'image',
                        $prefix . 'cursor_tooltip' => 'yes'
                    ] + ($attrs['condition'] ?? []),
                ]
            );

            $self->add_responsive_control(
                $prefix . 'tooltip_thumbnail_width',
                [
                    'label' => esc_html__('Width', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 10, 'max' => 500 ],
                    ],
                    'size_units' => [ 'px', 'vw', 'custom'],
                    'condition' => [
                        $prefix . 'cursor_tooltip_type' => 'image',
                        $prefix . 'cursor_tooltip' => 'yes'
                    ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.' img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $self->add_control(
                $prefix . 'tooltip_thumbnail_animation',
                [
                    'label' => esc_html__('Tooltip Type', 'burido-core'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'zoom' => esc_html__('Zoom', 'burido-core'),
                        'fade' => esc_html__('Fade', 'burido-core'),
                        'slide-in-left' => esc_html__('Slide in Left', 'burido-core'),
                        'slide-in-right' => esc_html__('Slide in Right', 'burido-core'),
                        'slide-in-top' => esc_html__('Slide in Top', 'burido-core'),
                        'slide-in-bot' => esc_html__('Slide in Bottom', 'burido-core'),
                    ],
                    'default' => 'zoom',
                    'condition' => [
                        $prefix . 'cursor_tooltip_type' => 'image',
                        $prefix . 'cursor_tooltip' => 'yes'
                    ] + ($attrs['condition'] ?? []),
                ]
            );

            $self->add_control(
                $prefix . 'cursor_color_bg',
                [
                    'label' => esc_html__('Background Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'condition' => [
                        $prefix . 'cursor_tooltip_type' => 'simple',
                        $prefix . 'cursor_tooltip' => 'yes'
                    ] + ($attrs['condition'] ?? []),
                ]
            );

            $self->start_controls_tabs(
                $prefix . 'tabs_cursor'
            );
            $self->start_controls_tab(
                $prefix . 'tabs_cursor_title',
                [
                    'label' => esc_html__('Content', 'burido-core'),
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                ]
            );
            $self->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => $prefix . 'tooltip_title',
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selector' => '#wgl-cursor '.$repeater.' h6',
                ]
            );
            $self->add_responsive_control(
                $prefix . 'tooltip_icon_size',
                [
                    'label' => esc_html__('Icon Size', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 0, 'max' => 200 ],
                    ],
                    'size_units' => [ 'px', 'em', 'custom'],
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes',
                            $prefix . 'tooltip_icon_type' => 'font'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.' .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $self->add_responsive_control(
                $prefix . 'tooltip_title_padding',
                [
                    'label' => esc_html__('Padding', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.' h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $self->add_control(
                $prefix . 'tooltip_title_radius',
                [
                    'label' => esc_html__('Border Radius', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.' h6' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $self->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => $prefix . 'tooltip_title_border',
                    'fields_options' => [
                        'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                        'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                    ],
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selector' => '#wgl-cursor '.$repeater.' h6',
                ]
            );
            $self->add_control(
                $prefix . 'tooltip_title_color',
                [
                    'label' => esc_html__('Title Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.' h6' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $self->add_control(
                $prefix . 'tooltip_icon_color',
                [
                    'label' => esc_html__('Icon Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes',
                            $prefix . 'tooltip_icon_type' => 'font'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.' .wgl-icon' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $self->add_control(
                $prefix . 'tooltip_title_bg',
                [
                    'label' => esc_html__('Background Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.' h6' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $self->end_controls_tab();

            $self->start_controls_tab(
                $prefix . 'tabs_cursor_background',
                [
                    'label' => esc_html__('Tooltip Background', 'burido-core'),
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                ]
            );

            $self->add_control(
                $prefix . 'cursor_tooltip_bg',
                [
                    'label' => esc_html__('Add Tooltip Background', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'condition' => [
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                ]
            );

            $self->add_responsive_control(
                $prefix . 'tooltip_bg_width',
                [
                    'label' => esc_html__('Width', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 10, 'max' => 1500 ],
                    ],
                    'size_units' => [ 'px', 'vw', 'custom'],
                    'condition' => [
                            $prefix . 'cursor_tooltip_bg' => 'yes',
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater => '--tooltip-bg-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $self->add_responsive_control(
                $prefix . 'tooltip_bg_height',
                [
                    'label' => esc_html__('Height', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 10, 'max' => 1500 ],
                    ],
                    'size_units' => [ 'px', 'vw', 'custom'],
                    'condition' => [
                            $prefix . 'cursor_tooltip_bg' => 'yes',
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater => '--tooltip-bg-height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $self->add_control(
                $prefix . 'tooltip_bg_radius',
                [
                    'label' => esc_html__('Border Radius', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'condition' => [
                            $prefix . 'cursor_tooltip_bg' => 'yes',
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater => '--tooltip-bg-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $self->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => $prefix . 'tooltip_bg_color',
                    'label' => esc_html__('Background', 'burido-core'),
                    'types' => ['classic', 'gradient'],
                    'fields_options' => [
                        'background' => [ 'label' => esc_html__('Background', 'burido-core'), ],
                    ],
                    'condition' => [
                            $prefix . 'cursor_tooltip_bg' => 'yes',
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selector' => '#wgl-cursor  '.$repeater.'::before',
                ]
            );
            $self->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => $prefix . 'tooltip_additional_bg_color',
                    'label' => esc_html__('Additional Background', 'burido-core'),
                    'types' => ['classic', 'gradient'],
                    'fields_options' => [
                        'background' => [ 'label' => esc_html__('Additional Background', 'burido-core'), ],
                    ],
                    'condition' => [
                            $prefix . 'cursor_tooltip_bg' => 'yes',
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selector' => '#wgl-cursor  '.$repeater.'::after',
                ]
            );
            $self->add_control(
                $prefix . 'tooltip_bg_blur',
                [
                    'label' => esc_html__('Blur', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => ['max' => 100, 'step' => 0.1],
                    ],
                    'condition' => [
                            $prefix . 'cursor_tooltip_bg' => 'yes',
                            $prefix . 'cursor_tooltip_type' => ['def', 'custom'],
                            $prefix . 'cursor_tooltip' => 'yes'
                        ] + ($attrs['condition'] ?? []),
                    'selectors' => [
                        '#wgl-cursor '.$repeater.'::after' => 'filter: blur({{SIZE}}px);',
                    ],
                ]
            );
            $self->end_controls_tab();
            $self->end_controls_tabs();

            if (!empty($attrs['output'])) {
                foreach ($attrs['output'] as $key => $value) {
                    $self->add_control(
                        $key,
                        $value
                    );
                }
            }

            if ($section) {
                $self->end_controls_section();
            }
        }

        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }
    }
}

if (!class_exists('WGL_Cursor_Builder')) {
    /**
     * WGL Cursor Build
     *
     *
     * @package burido-core\includes\elementor
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     * @version 1.0.0
     */
    class WGL_Cursor_Builder
    {
        private static $instance;

        /**
         * @since 1.0.0
         * @version 1.0.0
         */
        public function build($self, $atts, $repeater_id, $pref)
        {
            $prefix = !empty($pref) ? $pref : '';

            $cursor_tooltip = isset($atts[$prefix . 'cursor_tooltip']) ? $atts[$prefix . 'cursor_tooltip'] : false;
            $id = $self ? $self->get_id() : 0;
            if (!empty($repeater_id)) {
                $id = $repeater_id;
            }

            if (!$cursor_tooltip) {
                // Bailout.
                return '';
            }

            $cursor_class = 'wgl-element-'.$id.' cursor-global elementor-repeater-item-'.$id;
            $cursor_class .= $atts[$prefix . 'cursor_tooltip_bg'] ? ' tooltip_bg' : '';
            $cursor_class .= empty($atts[$prefix . 'cursor_prop']) ? ' cursor_center' : '';

            // Icon/Image
            ob_start();
            if (!empty($atts[$prefix . 'tooltip_icon_type'])) {
                $icons = new WGL_Icons;
                echo $icons->build($self, $atts, $prefix . 'tooltip_');
            }
            $tooltip_icon = ob_get_clean();

            switch ($atts[$prefix . 'cursor_tooltip_type']) {
                case 'image':
                    $cursor_image = isset($atts[$prefix . 'cursor_thumbnail']['url']) && !empty($atts[$prefix . 'cursor_thumbnail']['url']) ? '<img src=\'' . esc_url($atts[$prefix . 'cursor_thumbnail']['url']) . '\' alt=\'' . ($atts[$prefix . 'cursor_thumbnail']['alt'] ?? '1') . '\'>' : '';
                    $cursor_class .= ' animation-' . $atts[$prefix . 'tooltip_thumbnail_animation'];
                    break;

                case 'custom':
                    if ($atts[$prefix . 'tooltip_text']) {
                        $cursor_text = '<h6>'
                            . $atts[$prefix . 'tooltip_text']
                            . ($atts[$prefix . 'tooltip_icon_type'] ? $tooltip_icon : '')
                        . '</h6>';
                    } else if ($atts[$prefix . 'tooltip_icon_type']) {
                        $cursor_text = $tooltip_icon;
                    }
                    break;

                case 'def':
                    $cursor_text = '<h6>'.esc_attr__('More', 'burido-core').'</h6>';
                    break;

                case 'simple':
                    $cursor_color = $atts[$prefix . 'cursor_color_bg'] ?? '';
                    break;

                default:
                    $cursor_text = $cursor_image = $cursor_color = '';
                    break;
            }

            $cursor_class_data = !empty($cursor_class) ? ' data-cursor-class="' . esc_attr($cursor_class) . '"' : '';
            $cursor_text_data = !empty($cursor_text) ? ' data-cursor-text="' . esc_attr($cursor_text) . '"' : '';
            $cursor_image_data = !empty($cursor_image) ? ' data-cursor-image="' . esc_attr($cursor_image) . '"' : '';
            $cursor_color_bg = !empty($cursor_color) ? ' data-cursor-color-bg="' . esc_attr($cursor_color) . '"' : '';
            $cursor_color_prop = empty($atts[$prefix . 'cursor_prop']) ? ' data-cursor-prop="none"' : '';

            $output = $cursor_color_bg . $cursor_class_data . $cursor_image_data . $cursor_text_data . $cursor_color_prop;

            return $output;
        }

        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }
    }
}
