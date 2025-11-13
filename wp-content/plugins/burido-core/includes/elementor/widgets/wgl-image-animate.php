<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/widgets/wgl-infobox.php`.
 */
namespace WGL_Extensions\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.


use Elementor\{
    Repeater,
    Widget_Base,
    Controls_Manager,
    Control_Media};


class WGL_Image_Animate extends Widget_Base {

    public function get_name() {
        return 'wgl-image-animate';
    }

    public function get_title() {
        return esc_html__('WGL Image Animate', 'burido-core');
    }

    public function get_icon() {
        return 'wgl-image-animate';
    }

    public function get_keywords() {
        return ['image', 'animate'];
    }

    public function get_categories() {
        return ['wgl-modules'];
    }

    public function get_script_depends() {
        return [ 'jquery-appear' ];
    }


    protected function register_controls() {

        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'section_content_general',
            [
                'label' => esc_html__('General', 'burido-core'),
            ]
        );

        $this->add_control(
            'image_link',
            [
                'label' => esc_html__('Add Image Link', 'burido-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'burido-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => [
                    'url' => '',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Image Width', 'burido-core'),
                'type' => Controls_Manager::SLIDER,
                'dynamic' => ['active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 2560 ],
                ],
                'condition' => [ 'thumbnail[url]!' => '' ],
                'size_units' => ['px', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}}; max-width: unset',
                ],
            ]
        );

        $repeater->add_control(
            'top_offset',
            [
                'label' => esc_html__('Top Offset', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -1000,
                'max' => 1000,
				'step' => 1,
				'default' => '0',
                'description' => esc_html__('Enter offset in %, for example -100% or 100%', 'burido-core'),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .img-layer_item' => '--offset-top: {{VALUE}}%',
                ],
            ]
        );

        $repeater->add_control(
            'left_offset',
            [
                'label' => esc_html__('Left Offset', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'min' => -1000,
                'max' => 1000,
				'step' => 1,
				'default' => '0',
                'description' => esc_html__('Enter offset in %, for example -100% or 100%', 'burido-core'),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .img-layer_item' => '--offset-left: {{VALUE}}%',
                ],
            ]
        );

        $repeater->add_control(
            'image_animation',
            [
                'label' => esc_html__('Layer Animation', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'burido-core'),
                    'up_down1' => esc_html__('Up Down 1', 'burido-core'),
                    'up_down2' => esc_html__('Up Down 2', 'burido-core'),
                    'up_down3' => esc_html__('Up Down 3', 'burido-core'),
                    'left_right1' => esc_html__('Left Right 1', 'burido-core'),
                    'left_right2' => esc_html__('Left Right 2', 'burido-core'),
                    'left_right3' => esc_html__('Left Right 3', 'burido-core'),
                    'move1' => esc_html__('Move 1', 'burido-core'),
                    'move2' => esc_html__('Move 2', 'burido-core'),
                    'move3' => esc_html__('Move 3', 'burido-core'),
                    'move4' => esc_html__('Move 4', 'burido-core'),
                    'move-rotate1' => esc_html__('Move with Rotate 1', 'burido-core'),
                    'move-rotate2' => esc_html__('Move with Rotate 2', 'burido-core'),
                    'move-rotate3' => esc_html__('Move with Rotate 3', 'burido-core'),
                    'move-rotate4' => esc_html__('Move with Rotate 4', 'burido-core'),
                    'scale1' => esc_html__('Scale 1', 'burido-core'),
                    'scale2' => esc_html__('Scale 2', 'burido-core'),
                    'scale3' => esc_html__('Scale 3', 'burido-core'),
                    'modern1' => esc_html__('Modern 1', 'burido-core'),
                    'modern2' => esc_html__('Modern 2', 'burido-core'),
                    'modern3' => esc_html__('Modern 3', 'burido-core'),
                ],
                'default' => 'up_down',
            ]
        );

        $repeater->add_control(
            'anim_duration',
            [
                'label' => esc_html__('Animation Duration (in sec)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'condition' => [ 'image_animation!' => ['none'] ],
				'step' => 0.1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .img-layer_image' => 'animation-duration: {{VALUE}}s',
                ],
            ]
        );

        $repeater->add_control(
            'anim_duration_rotate',
            [
                'label' => esc_html__('Animation Duration Rotate (in sec)', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
                'condition' => [ 'image_animation' => ['modern1', 'modern2', 'modern3'] ],
				'step' => 0.1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .img-layer_item__inner' => 'animation-duration: {{VALUE}}s',
                ],
            ]
        );


        $avaliable_timing_function = [
            'linear' => esc_html__( 'Default | Linear', 'burido-core' ),
            'ease' => esc_html__( 'Ease', 'burido-core' ),
            'ease-in' => esc_html__( 'Ease-In', 'burido-core' ),
            'ease-out' => esc_html__( 'Ease-Out', 'burido-core' ),
            'ease-in-out' => esc_html__( 'Ease-In-Out', 'burido-core' ),
            'cubic-bezier(0.94, 0.87, 0.87, 1)' => esc_html__( 'WGL Easy Linear', 'burido-core' ),
        ];
        $repeater->add_control(
            'anim_timing_func',
            [
                'label' => esc_html__('Animation Timing Func', 'burido-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $avaliable_timing_function,
                'default' => 'cubic-bezier(0.94, 0.87, 0.87, 1)',
                'condition' => [ 'image_animation!' => 'none' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .img-layer_image' => 'animation-timing-function: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'image_order',
            [
                'label' => esc_html__('Image z-index', 'burido-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => ['active' => true],
				'step' => 1,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'z-index: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Layers', 'burido-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        wp_enqueue_script('jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js', [], false, false);

        $content = '';
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('image-animate', 'class', 'wgl-image-animate');

        if (!empty($_s['image_link']['url'])) {
            $link = true;
            $this->add_render_attribute('image_link', 'class', 'image_link');
            $this->add_link_attributes('image_link', $_s['image_link']);
        }else{ $link = false; }

        foreach ( $_s[ 'items' ] as $index => $item ) {

            $image_wrapper = $this->get_repeater_setting_key( 'image_wrapper', 'items' , $index );
            $this->add_render_attribute( $image_wrapper, [
                'class' => [
                    'img-layer_image-wrapper',
                    'elementor-repeater-item-'. $item['_id'],
                    esc_attr($item[ 'image_animation' ])
                ],
            ] );

            ob_start();

            ?><div <?php echo $this->get_render_attribute_string( $image_wrapper ); ?>>
                <div class="img-layer_item">
                    <div class="img-layer_item__inner">
                        <div class="img-layer_image">
                            <img src="<?php echo esc_url($item[ 'thumbnail' ][ 'url' ]); ?>" alt="<?php echo Control_Media::get_image_alt( $item[ 'thumbnail' ] ); ?>"/>
                        </div>
                    </div>
                </div>
            </div><?php

            $content .= ob_get_clean();
        }

        ?><div <?php echo $this->get_render_attribute_string( 'image-animate' ); ?>><?php
            if ( $link ) : ?><a <?php echo $this->get_render_attribute_string( 'image_link' ); ?>><?php endif;
                echo $content;
            if ( $link ) : ?></a><?php endif;
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