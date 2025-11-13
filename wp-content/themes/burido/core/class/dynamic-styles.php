<?php

defined( 'ABSPATH' ) || exit;

use WGL_Extensions\Includes\WGL_Elementor_Helper;
use WGL_Extensions\WGL_Framework_Global_Variables;

/**
 * Dynamic Styles
 *
 *
 * @package burido\core\class
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class WGL_Framework_Dynamic_Styles
{
    protected static $instance;

    private $template_directory_uri;
    private $use_minified;
    private $enqueued_stylesheets = [];
    private $header_page_id;
    private $header_building_tool;
    private $gradient_enabled;
    private $theme_color_mode;

    public function __construct()
    {
        // do nothing.
    }

    public static function instance()
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function construct()
    {
        $this->template_directory_uri = get_template_directory_uri();
        $this->use_minified = WGL_Framework::get_option('use_minified') ? '.min' : '';
        $this->header_building_tool = WGL_Framework::get_option('header_building_tool');
        $this->gradient_enabled = WGL_Framework::get_mb_option('use-gradient', 'mb_page_colors_switch', 'custom');
        $this->theme_color_mode = WGL_Framework::get_option('theme_mode');

        $this->enqueue_styles_and_scripts();
        $this->add_body_classes();
    }

    public function enqueue_styles_and_scripts()
    {
        add_action( 'wp_enqueue_scripts', [ $this, 'frontend_stylesheets' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

        //* Elementor Compatibility
        add_action( 'wp_enqueue_scripts', [ $this, 'get_elementor_css_theme_builder' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'elementor_column_fix' ] );

        add_action( 'admin_enqueue_scripts', [ $this, 'admin_stylesheets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
    }

    public function get_elementor_css_theme_builder()
    {
        $current_post_id = get_the_ID();
        $css_files = [];

        $locations[] = $this->get_elementor_css_cache_header();
        $locations[] = $this->get_elementor_css_cache_header_sticky();
        $locations[] = $this->get_elementor_css_cache_footer();
        $locations[] = $this->get_elementor_css_cache_side_panel();
        $locations[] = $this->get_elementor_css_cache_mobile_drawer();

        foreach ($locations as $location) {
            //* Don't enqueue current post here (let the preview/frontend components to handle it)
            if ($location && $current_post_id !== $location) {
                $css_file = new \Elementor\Core\Files\CSS\Post($location);
                $css_files[] = $css_file;
            }
        }

        if (!empty($css_files)) {
            \Elementor\Plugin::$instance->frontend->enqueue_styles();
            \Elementor\Plugin::$instance->widgets_manager->enqueue_widgets_styles();
            foreach ($css_files as $css_file) {
                $css_file->enqueue();
            }
        }
    }

    public function get_elementor_css_cache_header()
    {
        if (
            ! apply_filters( 'wgl/header/enable', true )
            || ! class_exists( '\Elementor\Core\Files\CSS\Post' )
        ) {
            // Bailtout.
            return;
        }

        if (
            $this->RWMB_is_active()
            && 'custom' === rwmb_meta( 'mb_customize_header_layout' )
            && 'default' !== rwmb_meta( 'mb_header_content_type' )
        ) {
            $this->header_building_tool = 'elementor';
            $this->header_page_id = rwmb_meta( 'mb_customize_header' );
        } else {
            $this->header_page_id = WGL_Framework::get_option( 'header_page_select' );
        }

        // Shop Catalog custom header template
        if (
            function_exists('is_woocommerce') && is_woocommerce()
            || function_exists('is_cart') && is_cart()
            || function_exists('is_checkout') && is_checkout()
            || function_exists('is_account_page') && is_account_page()
        ) {
            if ('0' == WGL_Framework::get_option('shop_catalog_header_conditional')) {
                $this->header_page_id = WGL_Framework::get_option('shop_catalog_header_page_select') ?: $this->header_page_id;
            }
        }

        if ( 'elementor' === $this->header_building_tool ) {
            return $this->multi_language_support( $this->header_page_id, 'header' );
        }
    }

    public function get_elementor_css_cache_header_sticky()
    {
        if (
            ! apply_filters( 'wgl/header/enable', true )
            || 'elementor' !== $this->header_building_tool
            || ! class_exists( '\Elementor\Core\Files\CSS\Post' )
        ) {
            // Bailtout.
            return;
        }

        $header_sticky_page_id = '';

        if (
            $this->RWMB_is_active()
            && 'custom' === rwmb_meta( 'mb_customize_header_layout' )
            && 'default' !== rwmb_meta( 'mb_sticky_header_content_type' )
        ) {
            $header_sticky_page_id = rwmb_meta( 'mb_customize_sticky_header' );
        } elseif ( WGL_Framework::get_option( 'header_sticky' ) ) {
            $header_sticky_page_id = WGL_Framework::get_option( 'header_sticky_page_select' );
        }

        return $this->multi_language_support( $header_sticky_page_id, 'header' );
    }

    public function get_elementor_css_cache_footer()
    {
        $footer = apply_filters( 'wgl/footer/enable', true );
        $footer_switch = $footer[ 'footer_switch' ] ?? '';

        if (
            ! $footer_switch
            || 'elementor' !== WGL_Framework::get_mb_option( 'footer_building_tool', 'mb_footer_switch', 'on' )
            || ! class_exists( '\Elementor\Core\Files\CSS\Post' )
        ) {
            // Bailout.
            return;
        }

        $footer_page_id = WGL_Framework::get_mb_option( 'footer_page_select', 'mb_footer_switch', 'on' );

        return $this->multi_language_support( $footer_page_id, 'footer' );
    }

    public function get_elementor_css_cache_side_panel()
    {
        if (
            !WGL_Framework::get_option('side_panel_enabled')
            || 'elementor' !== WGL_Framework::get_mb_option('side_panel_building_tool', 'mb_customize_side_panel', 'custom')
            || !class_exists('\Elementor\Core\Files\CSS\Post')
        ) {
            // Bailout.
            return;
        }

        $sp_page_id = WGL_Framework::get_mb_option('side_panel_page_select', 'mb_customize_side_panel', 'custom');

        return $this->multi_language_support($sp_page_id, 'side_panel');
    }

    public function get_elementor_css_cache_mobile_drawer()
    {
        $mobile_header_custom = WGL_Framework::get_option('mobile_header');
        if (
            !empty($mobile_header_custom) && 'elementor' !==  WGL_Framework::get_option('mobile_drawer_header_building_tool')
            || !class_exists('\Elementor\Core\Files\CSS\Post')
        ) {
            // Bailout.
            return;
        }

        $header_drawer_settings = \Elementor\Core\Settings\Manager::get_settings_managers('page')->get_model($this->header_page_id)->get_data('settings')['mobile_drawer_template'] ?? '';
        $active_template = '';
        if(!empty($header_drawer_settings) && 'wgl_default_template_drawer' !== $header_drawer_settings){
            $active_template = (int) $header_drawer_settings;
        }else{
            $active_template = (int) WGL_Framework::get_option('mobile_drawer_header_page_select');
        }

        if(empty($active_template)){
            // Bailout.
            return;
        }

        return $this->multi_language_support($active_template, 'elementor_library');
    }

    public function multi_language_support($page_id, $page_type)
    {
        if (!$page_id) {
            // Bailout.
            return;
        }

        $page_id = intval($page_id);

        if (class_exists('Polylang') && function_exists('pll_current_language')) {
            $currentLanguage = pll_current_language();
            $translations = PLL()->model->post->get_translations($page_id);

            $polylang_id = $translations[$currentLanguage] ?? '';
            $page_id = $polylang_id ?: $page_id;
        }

        if (class_exists('SitePress')) {
            $wpml_id = wpml_object_id_filter($page_id, $page_type, false, ICL_LANGUAGE_CODE);
            if (
                $wpml_id
                && 'trash' !== get_post_status($wpml_id)
            ) {
                $page_id = $wpml_id;
            }
        }

        return $page_id;
    }

    public function elementor_column_fix()
    {
        $css = '.elementor-container > .elementor-row > .elementor-column > .elementor-element-populated,'
            . '.elementor-container > .elementor-column > .elementor-element-populated {'
                . 'padding-top: 0;'
                . 'padding-bottom: 0;'
            . '}';

        $css .= '.elementor-column-gap-default > .elementor-row > .elementor-column > .elementor-element-populated,'
            . '.elementor-column-gap-default > .elementor-column > .theiaStickySidebar > .elementor-element-populated,'
            . '.elementor-column-gap-default > .elementor-column > .elementor-element-populated {'
                . 'padding-left: 15px;'
                . 'padding-right: 15px;'
            . '}';

        wp_add_inline_style('elementor-frontend', $css);
    }

    public function frontend_stylesheets()
    {
        wp_enqueue_style(
            WGL_Framework_Global_Variables::get_theme_slug() . '-theme-info',
            get_bloginfo('stylesheet_url'),
            [],
            WGL_Framework_Global_Variables::get_theme_version()
        );

        $this->enqueue_css_variables();
        $this->enqueue_additional_styles();
        $this->enqueue_theme_stylesheet( 'main' . (is_rtl() ? '-rtl' : ''), '/css/' );
        $this->enqueue_pluggable_styles();
        $this->enqueue_theme_stylesheet( 'responsive' . (is_rtl() ? '-rtl' : ''), '/css/', $this->enqueued_stylesheets );
        $this->enqueue_theme_stylesheet( 'dynamic' . (is_rtl() ? '-rtl' : ''), '/css/', $this->enqueued_stylesheets );

        if (is_rtl()) {
            wp_enqueue_style(
                'rtl-mod',
                $this->template_directory_uri . '/css/rtl-mod.css',
                [],
                WGL_Framework_Global_Variables::get_theme_version()
            );
        }
    }

    public function enqueue_css_variables()
    {
        return wp_add_inline_style(
            WGL_Framework_Global_Variables::get_theme_slug() . '-theme-info',
            $this->retrieve_css_variables_and_extra_styles()
        );
    }

    public function enqueue_additional_styles()
    {
        wp_enqueue_style(
            'select2',
            $this->template_directory_uri . '/js/select2/css/select2.css',
            [],
            WGL_Framework_Global_Variables::get_theme_version()
        );

        wp_enqueue_style(
            'font-awesome-5-all',
            $this->template_directory_uri . '/css/font-awesome-5.min.css',
            [],
            WGL_Framework_Global_Variables::get_theme_version()
        );
    }

    public function retrieve_css_variables_and_extra_styles()
    {
        if (class_exists('Redux')) {
            // Customizer
            if (!empty($GLOBALS['burido_set'])) {
                new WGL_Framework_Global_Variables();
            }
        }

        $root_vars = $extra_css = '';

        /**
         * Color Variables
         */
        if (
            class_exists('RWMB_Loader')
            && 'custom' === WGL_Framework::get_mb_option('page_colors_switch')
        ) {
            $theme_primary_color = WGL_Framework::get_mb_option('theme-primary-color');
            $theme_secondary_color = WGL_Framework::get_mb_option('theme-secondary-color');
            $theme_tertiary_color = WGL_Framework::get_mb_option('theme-tertiary-color');
            $theme_static_color = WGL_Framework::get_mb_option('theme-static-color');

            $main_font_color = WGL_Framework::get_mb_option( 'theme-content-color' );
            $h_font_color = WGL_Framework::get_mb_option( 'theme-headings-color' );

            $form_bg_color = WGL_Framework::get_mb_option( 'form-bg-color' );

            $button_color_idle = WGL_Framework::get_mb_option( 'button-color-idle' );
            $button_bg_idle = WGL_Framework::get_mb_option( 'button-bg-idle' );
            $button_border_idle = WGL_Framework::get_mb_option( 'button-border-idle' );
            $button_color_hover = WGL_Framework::get_mb_option( 'button-color-hover' );
            $button_bg_hover = WGL_Framework::get_mb_option( 'button-bg-hover' );
            $button_border_hover = WGL_Framework::get_mb_option( 'button-border-hover' );

            $cursor_point_color = WGL_Framework::get_mb_option('cursor_color')['rgba'] ?? '';

            $scroll_up_arrow_color = WGL_Framework::get_mb_option('scroll_up_arrow_color');
            $scroll_up_arrow_color_bg = WGL_Framework::get_mb_option('scroll_up_arrow_color_bg');
            $scroll_up_arrow_color_border = WGL_Framework::get_mb_option('scroll_up_arrow_color_border');

            $this->gradient_enabled && $theme_gradient_from = WGL_Framework::get_mb_option('theme-gradient-from');
            $this->gradient_enabled && $theme_gradient_to = WGL_Framework::get_mb_option('theme-gradient-to');
        } else {
            $theme_primary_color = WGL_Framework_Global_Variables::get_primary_color();
            $theme_secondary_color = WGL_Framework_Global_Variables::get_secondary_color();
            $theme_tertiary_color = WGL_Framework_Global_Variables::get_tertiary_color();
            $theme_static_color = WGL_Framework_Global_Variables::get_static_color();

            $main_font_color = WGL_Framework_Global_Variables::get_main_font_color();
            $h_font_color = WGL_Framework_Global_Variables::get_h_font_color();

            $button_color_idle = WGL_Framework_Global_Variables::get_btn_color_idle();
            $button_bg_idle = WGL_Framework_Global_Variables::get_btn_bg_idle();
            $button_border_idle = WGL_Framework_Global_Variables::get_btn_border_idle();
            $button_color_hover = WGL_Framework_Global_Variables::get_btn_color_hover();
            $button_bg_hover = WGL_Framework_Global_Variables::get_btn_bg_hover();
            $button_border_hover = WGL_Framework_Global_Variables::get_btn_border_hover();

            $cursor_point_color = WGL_Framework_Global_Variables::get_cursor_point_color();

            $form_bg_color = WGL_Framework::get_option( 'form-bg-color' );

            $scroll_up_arrow_color = WGL_Framework::get_option('scroll_up_arrow_color');
            $scroll_up_arrow_color_bg = WGL_Framework::get_option('scroll_up_arrow_color_bg');
            $scroll_up_arrow_color_border = WGL_Framework::get_option('scroll_up_arrow_color_border');

            $this->gradient_enabled && $theme_gradient = WGL_Framework::get_option('theme-gradient');
        }

	    $root_vars .= '--burido-primary-color: ' . esc_attr( $theme_primary_color ?: 'unset' ) . ';';
	    $root_vars .= '--burido-secondary-color: ' . esc_attr( $theme_secondary_color ?: 'unset' ) . ';';
	    $root_vars .= '--burido-tertiary-color: ' . esc_attr( $theme_tertiary_color ?: 'unset' ) . ';';
	    $root_vars .= '--burido-static-color: ' . esc_attr( $theme_static_color ?: 'unset' ) . ';';

	    $root_vars .= '--burido-button-color-idle: ' . esc_attr( $button_color_idle ?: 'unset' ) . ';';
	    $root_vars .= '--burido-button-bg-idle: ' . esc_attr( $button_bg_idle ?: 'unset' ) . ';';
	    $root_vars .= '--burido-button-border-idle: ' . esc_attr( $button_border_idle ?: 'unset' ) . ';';
	    $root_vars .= '--burido-button-color-hover: ' . esc_attr( $button_color_hover ?: 'unset' ) . ';';
	    $root_vars .= '--burido-button-bg-hover: ' . esc_attr( $button_bg_hover ?: 'unset' ) . ';';
	    $root_vars .= '--burido-button-border-hover: ' . esc_attr( $button_border_hover ?: 'unset' ) . ';';

	    $root_vars .= '--burido-button-color-rgb-idle: ' . ( $button_color_idle ? esc_attr(WGL_Framework::hex_to_rgb($button_color_idle)) : 'unset' ) . ';';
	    $root_vars .= '--burido-button-bg-rgb-idle: ' . ( $button_bg_idle ? esc_attr(WGL_Framework::hex_to_rgb($button_bg_idle)) : 'unset' ) . ';';
	    $root_vars .= '--burido-button-border-rgb-idle: ' . ( $button_border_idle ? esc_attr(WGL_Framework::hex_to_rgb($button_border_idle)) : 'unset' ) . ';';
	    $root_vars .= '--burido-button-color-rgb-hover: ' . ( $button_color_hover ? esc_attr(WGL_Framework::hex_to_rgb($button_color_hover)) : 'unset' ) . ';';
	    $root_vars .= '--burido-button-bg-rgb-hover: ' . ( $button_bg_hover ? esc_attr(WGL_Framework::hex_to_rgb($button_bg_hover)) : 'unset' ) . ';';
	    $root_vars .= '--burido-button-border-rgb-hover: ' . ( $button_border_hover ? esc_attr(WGL_Framework::hex_to_rgb($button_border_hover)) : 'unset' ) . ';';

	    $root_vars .= '--burido-cursor-point-color: ' . ( $cursor_point_color ? esc_attr($cursor_point_color) : 'unset' ) . ';';

        $root_vars .= '--burido-form-bg-color: ' . ( $form_bg_color ? esc_attr($form_bg_color) : 'unset' ) . ';';
        $root_vars .= '--burido-form-bg-color-rgb: ' . ( $form_bg_color ? esc_attr(WGL_Framework::hex_to_rgb($form_bg_color)) : '255,255,255' ) . ';';

	    $root_vars .= '--burido-back-to-top-color: ' . ( $scroll_up_arrow_color ? esc_attr($scroll_up_arrow_color) : 'unset' ) . ';';
	    $root_vars .= '--burido-back-to-top-color-bg: ' . ( $scroll_up_arrow_color_bg ? esc_attr($scroll_up_arrow_color_bg) : 'unset' ) . ';';
	    $root_vars .= '--burido-back-to-top-color-border: ' . ( $scroll_up_arrow_color_border ? esc_attr($scroll_up_arrow_color_border) : 'unset' ) . ';';

        $root_vars .= '--burido-primary-rgb: ' . ( $theme_primary_color ? esc_attr(WGL_Framework::hex_to_rgb($theme_primary_color)) : 'unset' ) . ';';
        $root_vars .= '--burido-secondary-rgb: ' . ( $theme_secondary_color ? esc_attr(WGL_Framework::hex_to_rgb($theme_secondary_color)) : 'unset' ) . ';';
        $root_vars .= '--burido-tertiary-rgb: ' . ( $theme_tertiary_color ? esc_attr(WGL_Framework::hex_to_rgb($theme_tertiary_color)) : 'unset' ) . ';';
        $root_vars .= '--burido-static-rgb: ' . ( $theme_static_color ? esc_attr(WGL_Framework::hex_to_rgb($theme_static_color)) : 'unset' ) . ';';
        $root_vars .= '--burido-content-rgb: ' . ( $main_font_color ? esc_attr(WGL_Framework::hex_to_rgb($main_font_color)) : 'unset' ) . ';';
        $root_vars .= '--burido-header-rgb: ' . ( $h_font_color ? esc_attr(WGL_Framework::hex_to_rgb($h_font_color)) : 'unset' ) . ';';
        $root_vars .= '--burido-form-bg-rgb: ' . ( $form_bg_color ? esc_attr(WGL_Framework::hex_to_rgb($form_bg_color)) : 'unset' ) . ';';

        $cart_overlay = WGL_Framework::get_option('cart_overlay_color')['rgba'] ?? '';
        if (!empty($cart_overlay)){
            $root_vars .= '--burido-cart-overlay: ' . esc_attr($cart_overlay) . ';';
        }

        $body_bg = WGL_Framework::get_option('body_color_bg');
        $body_bg = !empty($body_bg['background-color']) ? $body_bg['background-color'] : '#fff';
        $root_vars .= '--body-background-color: ' . $body_bg . ';';

        $shop_products_overlay = WGL_Framework::get_option('shop_products_overlay')['rgba'] ?? 'transparent';
        $root_vars .= '--burido-shop-products-overlay: ' . ( !empty($shop_products_overlay) ? esc_attr($shop_products_overlay) : 'transparent' ) . ';';

        $body_lines_color = WGL_Framework::get_mb_option('body_lines_color', 'mb_body_lines_switch', 'on') ?? 'unset';
        $body_lines_color = is_array($body_lines_color) ? $body_lines_color['rgba'] : $body_lines_color;
        $root_vars .= '--burido-body-lines-color: ' . esc_attr($body_lines_color) . ';';
        //* ↑ color variables

        /**
         * Product Filter Columns Width
         */
        for ($i = 1; $i <= 8; $i++) { // Columns 1-8
            ${'col' . $i} = WGL_Framework::get_option('filters_columns_' . $i);
            if (isset(${'col' . $i})){
                $root_vars .= '--burido-filters-columns-'.$i.': ' . (${'col'.$i}['width'] ? esc_attr( ${'col'.$i}['width'] ) : '') . ';';
            }
        }
        //* ↑ product filter columns width

        /**
         * Headings Variables
         */
        $header_font = WGL_Framework::get_option( 'header-font' );
        $root_vars .= '--burido-header-font-family: ' . ( !empty($header_font['font-family']) ? esc_attr($header_font['font-family']) : 'unset' ) . ';';
        $root_vars .= '--burido-header-font-weight: ' . ( !empty($header_font['font-weight']) ? esc_attr($header_font['font-weight']) : 'unset' ) . ';';
        $root_vars .= '--burido-header-font-color: ' . $h_font_color . ';';
        $root_vars .= '--burido-header-letter-spacing: ' . ( !empty($header_font['letter-spacing']) ? esc_attr(floatval($header_font['letter-spacing'])).'em' : 'normal' ) . ';';

        for ($i = 1; $i <= 6; $i++) { // H1 - H6
            ${'h' . $i} = WGL_Framework::get_option('header-h' . $i);

            $root_vars .= '--burido-h'.$i.'-font-family: ' . (!empty(${'h'.$i}['font-family']) ? esc_attr( ${'h'.$i}['font-family'] ) : 'unset') . ';';
            $root_vars .= '--burido-h'.$i.'-font-size: ' . (!empty(${'h'.$i}['font-size']) ? esc_attr( ${'h'.$i}['font-size'] ) : 'unset') . ';';
            $root_vars .= '--burido-h'.$i.'-line-height: ' . (!empty(${'h'.$i}['line-height']) ? esc_attr( ${'h'.$i}['line-height'] ) : 'unset') . ';';
            $root_vars .= '--burido-h'.$i.'-font-weight: ' . (!empty(${'h'.$i}['font-weight']) ? esc_attr( ${'h'.$i}['font-weight'] ) : 'unset') . ';';
            $root_vars .= '--burido-h'.$i.'-text-transform: ' . (!empty(${'h'.$i}['text-transform']) ? esc_attr( ${'h'.$i}['text-transform'] ) : 'unset') . ';';
            $root_vars .= '--burido-h'.$i.'-letter-spacing: ' . (!empty(${'h'.$i}['letter-spacing']) ? esc_attr(floatval( ${'h'.$i}['letter-spacing'] )).'em' : 'normal') . ';';
        }
        //* ↑ headings variables

        /**
         * Content Variables
         */
        $main_font = WGL_Framework::get_option( 'main-font' );
        $content_line_height = !empty($main_font['line-height']) && !empty($main_font['font-size']) ? round(((int)$main_font['line-height'] / (int)$main_font['font-size']), 3) : '';

	    $root_vars .= '--burido-content-font-family: ' . ( !empty($main_font['font-family']) ? esc_attr($main_font['font-family']) : 'unset') . ';';
	    $root_vars .= '--burido-content-font-size: ' . ( !empty($main_font['font-size']) ? esc_attr($main_font['font-size']) : 'unset') . ';';
	    $root_vars .= '--burido-content-line-height: ' . esc_attr($content_line_height) . ';';
	    $root_vars .= '--burido-content-font-weight: ' . ( !empty($main_font['font-weight']) ? esc_attr($main_font['font-weight']) : 'unset') . ';';
	    $root_vars .= '--burido-content-color: ' . ( $main_font_color ? esc_attr($main_font_color) : 'unset') . ';';
        $root_vars .= '--burido-content-letter-spacing: ' . ( !empty($main_font['letter-spacing']) ? esc_attr(floatval($main_font['letter-spacing'])).'em' : 'normal' ) . ';';
        //* ↑ content variables

        /**
         * Additional Variables
         */
        $extra_font = WGL_Framework::get_option('additional-font');
        $root_vars .= '--burido-additional-font-family: ' . ( !empty($extra_font['font-family']) ? esc_attr($extra_font['font-family']) : 'unset') . ';';
        $root_vars .= '--burido-additional-font-weight: ' . ( !empty($extra_font['font-weight']) ? esc_attr($extra_font['font-weight']) : 'unset') . ';';
        $root_vars .= '--burido-additional-letter-spacing: ' . ( !empty($extra_font['letter-spacing']) ? esc_attr(floatval($extra_font['letter-spacing'])).'em' : 'normal' ) . ';';
        //* ↑ additional variables

        /**
         * Menu Variables
         */
        $menu_font = WGL_Framework::get_option( 'menu-font' );
        $root_vars .= '--burido-menu-font-family: ' . ( !empty($menu_font['font-family']) ? esc_attr($menu_font['font-family']) : 'unset') . ';';
        $root_vars .= '--burido-menu-font-size: ' . ( !empty($menu_font['font-size']) ? esc_attr($menu_font['font-size']) : 'unset') . ';';
        $root_vars .= '--burido-menu-line-height: ' . ( !empty($menu_font['line-height']) ? esc_attr($menu_font['line-height']) : 'unset') . ';';
        $root_vars .= '--burido-menu-font-weight: ' . ( !empty($menu_font['font-weight']) ? esc_attr($menu_font['font-weight']) : 'unset') . ';';
        $root_vars .= '--burido-menu-letter-spacing: ' . ( !empty($menu_font['letter-spacing']) ? esc_attr(floatval($menu_font['letter-spacing'])) . 'em' : 'normal') . ';';
        //* ↑ menu variables

        /**
         * Submenu Variables
         */
        $sub_menu_font = WGL_Framework::get_option('sub-menu-font');
        $root_vars .= '--burido-submenu-font-family: ' . ( !empty($sub_menu_font['font-family']) ? esc_attr($sub_menu_font['font-family']) : 'unset') . ';';
        $root_vars .= '--burido-submenu-font-size: ' . ( !empty($sub_menu_font['font-size']) ? esc_attr($sub_menu_font['font-size']) : 'unset') . ';';
        $root_vars .= '--burido-submenu-line-height: ' . ( !empty($sub_menu_font['line-height']) ? esc_attr($sub_menu_font['line-height']) : 'unset') . ';';
        $root_vars .= '--burido-submenu-font-weight: ' . ( !empty($sub_menu_font['font-weight']) ? esc_attr($sub_menu_font['font-weight']) : 'normal') . ';';
        $root_vars .= '--burido-submenu-letter-spacing: ' . ( !empty($sub_menu_font['letter-spacing']) ? esc_attr(floatval($sub_menu_font['letter-spacing'])) . 'em' : 'normal') . ';';

        $sub_menu_color = WGL_Framework::get_option('sub_menu_color')['color'] ?? 'unset';
        $sub_menu_bg = WGL_Framework::get_option('sub_menu_background')['rgba'] ?? 'unset';
        $root_vars .= '--burido-submenu-color: ' . ( $sub_menu_color ? esc_attr($sub_menu_color) : 'unset' ) . ';';
        $root_vars .= '--burido-submenu-color-rgb: ' . ( $sub_menu_color ? esc_attr(WGL_Framework::hex_to_rgb($sub_menu_color)) : 'unset' ) . ';';
        $root_vars .= '--burido-submenu-background: ' . ( $sub_menu_bg ? esc_attr($sub_menu_bg) : 'unset' ) . ';';

        $mob_sub_menu_color = WGL_Framework::get_option('mobile_sub_menu_color') ?? 'unset';
        $mob_sub_menu_color_active = WGL_Framework::get_option('mobile_sub_menu_color_active') ?? 'unset';
        $mob_sub_menu_bg = WGL_Framework::get_option('mobile_sub_menu_background')['rgba'] ?? 'unset';
        $mob_sub_menu_overlay = WGL_Framework::get_option('mobile_sub_menu_overlay')['rgba'] ?? 'unset';
        $root_vars .= '--burido-submenu-mobile-color: ' . esc_attr($mob_sub_menu_color) . ';';
        $root_vars .= '--burido-submenu-mobile-color-active: ' . esc_attr($mob_sub_menu_color_active) . ';';
        $root_vars .= '--burido-submenu-mobile-background: ' . esc_attr($mob_sub_menu_bg) . ';';
        $root_vars .= '--burido-submenu-mobile-overlay: ' . esc_attr($mob_sub_menu_overlay) . ';';

        $sub_menu_border = WGL_Framework::get_option('header_sub_menu_bottom_border');
        if ($sub_menu_border) {
            $sub_menu_border_height = WGL_Framework::get_option('header_sub_menu_border_height')['height'] ?? '0';
            $sub_menu_border_color = WGL_Framework::get_option('header_sub_menu_bottom_border_color')['rgba'] ?? 'unset';

            $extra_css .= '.primary-nav ul li ul li:not(:last-child),'
                . '.sitepress_container > .wpml-ls ul ul li:not(:last-child) {'
                    . ($sub_menu_border_height ? 'border-bottom-width: ' . esc_attr($sub_menu_border_height) . 'px;' : '')
                    . ($sub_menu_border_color ? 'border-bottom-color: ' . esc_attr($sub_menu_border_color) . ';' : '')
                    . 'border-bottom-style: solid;'
                . '}';
        }
        //* ↑ submenu variables

        /**
         * Header Mobile
         */
        $header_mobile_height = ((bool)WGL_Framework::get_option('mobile_header') && WGL_Framework::get_option('header_mobile_height')['height']) ? WGL_Framework::get_option('header_mobile_height')['height'] : '60px';

        $root_vars .= '--burido-header-mobile-height: ' . esc_attr($header_mobile_height) . ';';
        //* ↑ Header Mobile

        /**
         * Footer Variables
         */
        if (
            WGL_Framework::get_option('footer_switch')
            && 'widgets' === WGL_Framework::get_option('footer_building_tool')
        ) {
	        $footer_text_color = WGL_Framework::get_option('footer_text_color') ?? 'unset';
	        $footer_heading_color = WGL_Framework::get_option('footer_heading_color') ?? 'unset';
	        $copyright_text_color = WGL_Framework::get_mb_option('copyright_text_color', 'mb_copyright_switch', 'on') ?? 'unset';
            $root_vars .= '--burido-footer-content-color: ' . esc_attr($footer_text_color) . ';';
            $root_vars .= '--burido-footer-heading-color: ' . esc_attr($footer_heading_color) . ';';
            $root_vars .= '--burido-copyright-content-color: ' . esc_attr($copyright_text_color) . ';';
        }
        //* ↑ footer variables

        /**
         * Side Panel Variables
         */
        $sidepanel_title_color = WGL_Framework::get_mb_option('side_panel_title_color', 'mb_customize_side_panel', 'custom') ?? 'unset';
        $root_vars .= '--burido-sidepanel-title-color: ' . esc_attr($sidepanel_title_color) . ';';
        //* ↑ side panel variables

        /**
         * Encoded SVG variables
         */
        $svg_h_font_color = $h_font_color ? esc_attr($h_font_color) : '#000';
        $root_vars .= '--burido-bg-caret: url(\'data:image/svg+xml; utf8, '.$this->bg_caret($main_font_color ? esc_attr($main_font_color) : '#000').'\');';
        $root_vars .= '--burido-bg-caret-h: url(\'data:image/svg+xml; utf8, '.$this->bg_caret($svg_h_font_color, 0.5).'\');';
        $root_vars .= '--burido-bg-caret-1: url(\'data:image/svg+xml; utf8, '.$this->bg_caret($theme_primary_color ? esc_attr($theme_primary_color) : '#000').'\');';
        $root_vars .= '--burido-bg-caret-2: url(\'data:image/svg+xml; utf8, '.$this->bg_caret($theme_secondary_color ? esc_attr($theme_secondary_color) : '#000').'\');';
        $root_vars .= '--burido-bg-caret-3: url(\'data:image/svg+xml; utf8, '.$this->bg_caret($theme_tertiary_color ? esc_attr($theme_tertiary_color) : '#fff').'\');';

        $root_vars .= '--burido-bg-caret2: url(\'data:image/svg+xml; utf8, '.$this->bg_caret_2($main_font_color ? esc_attr($main_font_color) : '#000').'\');';
        $root_vars .= '--burido-bg-caret2-h: url(\'data:image/svg+xml; utf8, '.$this->bg_caret_2($svg_h_font_color, 0.5).'\');';
        $root_vars .= '--burido-bg-caret2-1: url(\'data:image/svg+xml; utf8, '.$this->bg_caret_2($theme_primary_color ? esc_attr($theme_primary_color) : '#000').'\');';
        $root_vars .= '--burido-bg-caret2-2: url(\'data:image/svg+xml; utf8, '.$this->bg_caret_2($theme_secondary_color ? esc_attr($theme_secondary_color) : '#000').'\');';
        $root_vars .= '--burido-bg-caret2-3: url(\'data:image/svg+xml; utf8, '.$this->bg_caret_2($theme_tertiary_color ? esc_attr($theme_tertiary_color) : '#fff').'\');';

        $root_vars .= '--burido-button-loading: url(\'data:image/svg+xml; utf8, '.$this->wgl_button_loading($theme_tertiary_color ? esc_attr($theme_tertiary_color) : '#fff').'\');';
        $root_vars .= '--burido-button-loading-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_button_loading($h_font_color ? esc_attr($h_font_color) : '#000').'\');';
        $root_vars .= '--burido-button-success: url(\'data:image/svg+xml; utf8, '.$this->wgl_button_success($theme_tertiary_color ? esc_attr($theme_tertiary_color) : '#fff').'\');';
        $root_vars .= '--burido-button-success-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_button_success($h_font_color ? esc_attr($h_font_color) : '#000').'\');';
        $root_vars .= '--burido-notice-info: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['notice-info'].'\');';
        $root_vars .= '--burido-notice-warning: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['notice-warning'].'\');';
        $root_vars .= '--burido-notice-success: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['notice-success'].'\');';
        $root_vars .= '--burido-notice-error: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['notice-error'].'\');';
        $root_vars .= '--burido-search: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['search'].'\');';
        $root_vars .= '--burido-arrow-down-right-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['arrow-down-right'].'\');';
        $root_vars .= '--burido-link-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['link'].'\');';
        $root_vars .= '--burido-quote-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['quote'].'\');';
        $root_vars .= '--burido-search-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['search'].'\');';
        $root_vars .= '--burido-check-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['check'].'\');';
        $root_vars .= '--burido-share-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['share'].'\');';
        $root_vars .= '--burido-close-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['close'].'\');';
        $root_vars .= '--burido-cart-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['cart'].'\');';
        $root_vars .= '--burido-heart-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['heart'].'\');';
        $root_vars .= '--burido-compare-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['compare'].'\');';
        $root_vars .= '--burido-arrow-theme-h: url(\'data:image/svg+xml; utf8, '.$this->wgl_theme_svg($svg_h_font_color, 1, true)['arrow-theme'].'\');';

        //* ↑ encoded SVG variables
	    /**
	     * Title variables
	     */
	    $root_vars .= '--wgl_price_label: "' . esc_html__( 'Price:', 'burido' ) . '";';

	    //* ↑ encoded Title variables

        /**
         * Cart variables
         */

        $cart_offset = WGL_Framework::get_option('cart_offset');
        $root_vars .= !empty($cart_offset['top']) ? '--wgl-positioning-cart-top:' . (int) $cart_offset['top'] . ';' : '';
        $root_vars .= !empty($cart_offset['right']) ? '--wgl-positioning-cart-right:' . (int) $cart_offset['right'] . ';' : '';

        $cart_offset_m = WGL_Framework::get_option('cart_offset_m');
        $root_vars .= !empty($cart_offset_m['top']) ? '--wgl-m-positioning-cart-top:' . (int) $cart_offset_m['top'] . ';' : '';
        $root_vars .= !empty($cart_offset_m['right']) ? '--wgl-m-positioning-cart-right:' . (int) $cart_offset_m['right'] . ';' : '';

        //* ↑ encoded Cart variables

	    /**
         * Elementor Container
         */
        $root_vars .= '--burido-elementor-container-width: ' . $this->get_elementor_container_width() . 'px;';
        //* ↑ elementor container

        $css_variables = ':root {' . $root_vars . '}';

        $extra_css .= $this->get_mobile_header_extra_css();
        $extra_css .= $this->get_page_title_responsive_extra_css();
        $extra_css .= $this->get_dark_mode_css();
        if (
            class_exists('\Elementor\Plugin')
            && version_compare(ELEMENTOR_VERSION, '3.4', '>')
        ) {
            $extra_css .= $this->init_additional_breakpoints();
        }
        return $css_variables . $this->minify_css($extra_css);
    }

    public function bg_caret($fill = '#000', $opacity = '1'){
        $output = '<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" x="0" y="0" viewBox="0 0 451.847 451.847" preserveAspectRatio="none" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751   c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0   c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z"></path></svg>';
        return $this->get_data_from_svg( $output );
    }
    public function bg_caret_2($fill = '#000', $opacity = '1'){
        $output = '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" x="0" y="0" viewBox="0 0 10 10" preserveAspectRatio="none" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M8.00003 6.93944L1.25005 0.189453L0.189392 1.25011L6.93938 8.00009H1.25003V9.50009H9.50003V1.25009H8.00003V6.93944Z"/></svg>';
        return $this->get_data_from_svg( $output );
    }

    public function wgl_button_loading($fill = '#fff', $opacity = '1'){
        $output = '<svg xmlns="http://www.w3.org/2000/svg" width="489.698px" height="489.698px" viewBox="0 0 489.698 489.698" preserveAspectRatio="none" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M468.999,227.774c-11.4,0-20.8,8.3-20.8,19.8c-1,74.9-44.2,142.6-110.3,178.9c-99.6,54.7-216,5.6-260.6-61l62.9,13.1    c10.4,2.1,21.8-4.2,23.9-15.6c2.1-10.4-4.2-21.8-15.6-23.9l-123.7-26c-7.2-1.7-26.1,3.5-23.9,22.9l15.6,124.8    c1,10.4,9.4,17.7,19.8,17.7c15.5,0,21.8-11.4,20.8-22.9l-7.3-60.9c101.1,121.3,229.4,104.4,306.8,69.3    c80.1-42.7,131.1-124.8,132.1-215.4C488.799,237.174,480.399,227.774,468.999,227.774z"/><path d="M20.599,261.874c11.4,0,20.8-8.3,20.8-19.8c1-74.9,44.2-142.6,110.3-178.9c99.6-54.7,216-5.6,260.6,61l-62.9-13.1    c-10.4-2.1-21.8,4.2-23.9,15.6c-2.1,10.4,4.2,21.8,15.6,23.9l123.8,26c7.2,1.7,26.1-3.5,23.9-22.9l-15.6-124.8    c-1-10.4-9.4-17.7-19.8-17.7c-15.5,0-21.8,11.4-20.8,22.9l7.2,60.9c-101.1-121.2-229.4-104.4-306.8-69.2    c-80.1,42.6-131.1,124.8-132.2,215.3C0.799,252.574,9.199,261.874,20.599,261.874z"/></svg>';
        return $this->get_data_from_svg( $output );
    }

    public function wgl_button_success($fill = '#fff', $opacity = '1'){
        $output = '<svg xmlns="http://www.w3.org/2000/svg" width="512px" height="512px" viewBox="0 0 24 24" preserveAspectRatio="none" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="m21.73 5.68-13 14a1 1 0 0 1 -.73.32 1 1 0 0 1 -.71-.29l-5-5a1 1 0 0 1 1.42-1.42l4.29 4.27 12.27-13.24a1 1 0 1 1 1.46 1.36z"/></svg>';
        return $this->get_data_from_svg( $output );
    }

    public function get_data_from_svg( $svg ) {
        return str_replace( [ '<', '>', '#' ], [ '%3C', '%3E', '%23' ], $svg );
    }

    /**
     * @param string $fill
     * @param string $opacity
     * @param boolean $clear
     * @return array
     */
    public function wgl_theme_svg($fill = 'currentColor', $opacity = '1', $clear = false){
        $output['notice-info'] = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).'; transform: rotate(180deg);"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';

        $output['notice-warning'] = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';

        $output['notice-success'] = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';

        $output['notice-error'] = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';

        $output['like'] = '<svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M0 0h24v24H0z" fill="none"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg>';

        $output['liked'] = '<svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';

        $output['link'] = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><path d="M15 7h3a5 5 0 0 1 5 5 5 5 0 0 1-5 5h-3m-6 0H6a5 5 0 0 1-5-5 5 5 0 0 1 5-5h3"></path><line x1="8" y1="12" x2="16" y2="12"></line></svg>';

        $output['quote'] = '<svg width="1em" height="1em" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z"/></svg>';

        $output['check'] = '<svg width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M6.12669 13.9771C5.97396 14.1308 5.76558 14.2165 5.54913 14.2165C5.33267 14.2165 5.1243 14.1308 4.97157 13.9771L0.359012 9.36384C-0.119671 8.88516 -0.119671 8.10894 0.359012 7.63116L0.936573 7.05345C1.4154 6.57476 2.19072 6.57476 2.6694 7.05345L5.54913 9.93332L13.3306 2.15174C13.8094 1.67305 14.5855 1.67305 15.0634 2.15174L15.641 2.72945C16.1196 3.20813 16.1196 3.98419 15.641 4.46213L6.12669 13.9771Z"/></svg>';

        $output['close'] = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

        $output['cart'] = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';

        $output['share'] = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>';

        $output['search'] = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';

        $output['heart'] = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';

        $output['arrow-theme'] = '<svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M5 7v4h13.17l-3.58-3.59L16 6l6 6-6 6-1.41-1.41L18.17 13H3V7h2z"/></svg>';

        $output['arrow-left'] = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="'.esc_attr($fill).'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: '.esc_attr($opacity).';"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>';

        $output['arrow-down-right'] = '<svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><rect fill="none" height="24" width="24"/><path d="M9,19l1.41-1.41L5.83,13H22V11H5.83l4.59-4.59L9,5l-7,7L9,19z"/></svg>';

        $output['compare'] = '<svg width="1em" height="1em" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M0.83 6.67C0.83 6.45 0.92 6.23 1.08 6.08C1.23 5.92 1.45 5.83 1.67 5.83H7.99L6.08 3.92C5.99 3.85 5.93 3.75 5.89 3.65C5.85 3.55 5.82 3.44 5.82 3.33C5.82 3.22 5.84 3.11 5.89 3.01C5.93 2.91 5.99 2.81 6.07 2.73C6.15 2.66 6.24 2.59 6.34 2.55C6.44 2.51 6.55 2.49 6.66 2.49C6.77 2.49 6.88 2.51 6.99 2.56C7.09 2.6 7.18 2.66 7.26 2.74L10.59 6.08C10.75 6.23 10.83 6.45 10.83 6.67C10.83 6.89 10.75 7.1 10.59 7.26L7.26 10.59C7.18 10.67 7.09 10.73 6.99 10.78C6.88 10.82 6.77 10.84 6.66 10.84C6.55 10.84 6.44 10.82 6.34 10.78C6.24 10.74 6.15 10.68 6.07 10.6C5.99 10.52 5.93 10.43 5.89 10.33C5.84 10.22 5.82 10.11 5.82 10C5.82 9.89 5.85 9.78 5.89 9.68C5.93 9.58 5.99 9.49 6.08 9.41L7.99 7.5H1.67C1.45 7.5 1.23 7.41 1.08 7.26C0.92 7.1 0.83 6.89 0.83 6.67ZM18.33 12.5H12.01L13.92 10.59C14.07 10.43 14.16 10.22 14.16 10C14.15 9.78 14.07 9.58 13.91 9.42C13.76 9.27 13.55 9.18 13.33 9.18C13.11 9.18 12.9 9.26 12.74 9.41L9.41 12.74C9.25 12.9 9.17 13.11 9.17 13.33C9.17 13.55 9.25 13.77 9.41 13.92L12.74 17.26C12.9 17.41 13.11 17.49 13.33 17.49C13.55 17.49 13.76 17.4 13.91 17.25C14.07 17.09 14.15 16.88 14.16 16.66C14.16 16.45 14.07 16.23 13.92 16.08L12.01 14.17H18.33C18.55 14.17 18.77 14.08 18.92 13.92C19.08 13.77 19.17 13.55 19.17 13.33C19.17 13.11 19.08 12.9 18.92 12.74C18.77 12.59 18.55 12.5 18.33 12.5Z"/></svg>';

        $output['user'] = '<svg width="1em" height="1em" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg" fill="'.esc_attr($fill).'" style="opacity: '.esc_attr($opacity).';"><path d="M288.38 275C288.38 281.9 282.79 287.5 275.88 287.5S263.38 281.9 263.38 275C263.38 230.89 237.99 191.84 198.4 173.37C184.7 182.27 168.41 187.5 150.89 187.5C133.31 187.5 116.95 182.24 103.22 173.27C91.4 178.85 80.45 186.36 71.34 195.47C50.09 216.72 38.38 244.97 38.38 275C38.38 281.9 32.79 287.5 25.88 287.5S13.38 281.9 13.38 275C13.38 238.29 27.69 203.77 53.66 177.79C62.35 169.09 72.46 161.64 83.29 155.49C70.87 140.38 63.39 121.05 63.39 100C63.39 51.75 102.65 12.5 150.89 12.5S238.39 51.75 238.39 100C238.39 121 230.95 140.28 218.57 155.37C261.48 179.53 288.38 224.67 288.38 275zM150.89 37.5C116.43 37.5 88.39 65.54 88.39 100S116.43 162.5 150.89 162.5S213.39 134.46 213.39 100S185.35 37.5 150.89 37.5z"/></svg>';

        $output = apply_filters('wgl_filter_theme_svg', $output);
        return $clear ? $this->get_data_from_svg( $output ) : $output;
    }


    public function init_additional_breakpoints()
    {
        $extra_css = '';
        $breakpoints = array_reverse(\Elementor\Plugin::$instance->breakpoints->get_active_breakpoints());
        $extra_css .= $this->content_alignment_responsive();
        $extra_css .= $this->media_content_responsive();
        $extra_css .= $this->hide_element_responsive(false, '-desktop');
        foreach ( $breakpoints as $breakpoint_name => $breakpoint ) {
            $extra_css .= $this->content_alignment_responsive($breakpoints[$breakpoint_name]->get_value(), '-'. $breakpoint_name);
            $extra_css .= $this->media_content_responsive($breakpoints[$breakpoint_name]->get_value(), '-'. $breakpoint_name);
            $extra_css .= $this->media_alignment_responsive($breakpoints[$breakpoint_name]->get_value(), '-'. $breakpoint_name);
            $extra_css .= $this->hide_element_responsive($breakpoints[$breakpoint_name]->get_value(), '-'. $breakpoint_name);
		}
        return $extra_css;
    }

    public function hide_element_responsive( $value = false, $media = '' )
    {
        $resolution = '-widescreen' === $media ? 'min' : 'max';
        $extra_css = $value ? '@media ('.$resolution.'-width: '.$value.'px) {' : '';
        $extra_css .= '
            .wgl-hidden'.$media.' {
                display: none;
            }';
        $extra_css .= $value ? '}' : '';

        return $extra_css;
    }

    public function content_alignment_responsive( $value = false, $media = '' )
    {
        $resolution = '-widescreen' === $media ? 'min' : 'max';
        $extra_css = $value ? '@media ('.$resolution.'-width: '.$value.'px) {' : '';
        $extra_css .= '
            body .a'.$media.'left {
                text-align: left;
            }
            body .a'.$media.'center {
                text-align: center;
            }
            body .a'.$media.'right {
                text-align: right;
            }
            body .a'.$media.'justify {
                text-align: justify;
            }';
        $extra_css .= $value ? '}' : '';

        return $extra_css;
    }

    public function media_alignment_responsive( $value = false, $media = '' )
    {
        $resolution = '-widescreen' === $media ? 'min' : 'max';
        $extra_css = $value ? '@media ('.$resolution.'-width: '.$value.'px) {' : '';
        $extra_css .= '
            body .a'.$media.'center .wgl-layout-left{
                justify-content: center;
            }
            body .a'.$media.'center .wgl-layout-right{
                justify-content: center;
            }
            body .a'.$media.'left .wgl-layout-left {
                justify-content: flex-start;
            }
            body .a'.$media.'left .wgl-layout-right {
                justify-content: flex-end;
            }

            body .a'.$media.'right .wgl-layout-left{
                justify-content: flex-end;
            }
            body .a'.$media.'right .wgl-layout-right{
                justify-content: flex-start;
            }';
        $extra_css .= $value ? '}' : '';

        return $extra_css;
    }

    public function media_content_responsive( $value = false, $media = '' )
    {
        $resolution = '-widescreen' === $media ? 'min' : 'max';
        $extra_css = $value ? '@media ('.$resolution.'-width: '.$value.'px) {' : '';
        $extra_css .= '
            body .wgl-layout'.$media.'-top {
                flex-direction: column;
            }
            body .wgl-layout'.$media.'-left {
                flex-direction: row;
            }
            body .wgl-layout'.$media.'-right {
                flex-direction: row-reverse;
            }';
        $extra_css .= $value ? '}' : '';

        return $extra_css;
    }

    public function get_dark_mode_css()
    {
        $css = '';
        if (
            class_exists('RWMB_Loader')
            && 'on' === WGL_Framework::get_mb_option('body_switch')
        ) {
            $css .= '.wgl-dark-mode{
                --body-background-color: ' . WGL_Framework::get_mb_option('dark-body_color_bg') . ';
                --body-background-rgb-color: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-body_color_bg'))) . ';

            }';
        } else{
            $css .= '.wgl-dark-mode{
                --body-background-color: ' . WGL_Framework::get_option('dark-body_color_bg') . ';
                --body-background-rgb-color: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-body_color_bg'))) . ';
            }';
        }

        if (
            class_exists('RWMB_Loader')
            && 'custom' === WGL_Framework::get_mb_option('page_colors_switch')
        ) {
            $css .= '.wgl-dark-mode{
                --burido-primary-color: ' . WGL_Framework::get_mb_option('dark-theme-primary-color') . ';
                --burido-secondary-color: ' . WGL_Framework::get_mb_option('dark-theme-secondary-color') . ';
                --burido-tertiary-color: ' . WGL_Framework::get_mb_option('dark-theme-tertiary-color') . ';
                --burido-content-color: ' . WGL_Framework::get_mb_option('dark-theme-content-color') . ';
                --burido-header-font-color: ' . WGL_Framework::get_mb_option('dark-theme-headings-color') . ';

                --burido-form-bg-color: ' . WGL_Framework::get_mb_option('dark-form-bg-color') . ';

                --burido-button-color-idle: ' . WGL_Framework::get_mb_option('dark-button-color-idle') . ';
                --burido-button-bg-idle: ' . WGL_Framework::get_mb_option('dark-button-bg-idle') . ';
                --burido-button-border-idle: ' . WGL_Framework::get_mb_option('dark-button-border-idle') . ';
                --burido-button-color-hover: ' . WGL_Framework::get_mb_option('dark-button-color-hover') . ';
                --burido-button-bg-hover: ' . WGL_Framework::get_mb_option('dark-button-bg-hover') . ';
                --burido-button-border-hover: ' . WGL_Framework::get_mb_option('dark-button-border-hover') . ';

                --burido-primary-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-theme-primary-color'))) . ';
                --burido-secondary-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-theme-secondary-color'))) . ';
                --burido-tertiary-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-theme-tertiary-color'))) . ';
                --burido-content-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-theme-content-color'))) . ';
                --burido-header-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-theme-headings-color'))) . ';

                --burido-form-bg-color-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-form-bg-color'))) . ';

                --burido-button-color-rgb-idle: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-button-color-idle'))) . ';
                --burido-button-bg-rgb-idle: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-button-bg-idle'))) . ';
                --burido-button-border-rgb-idle: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-button-border-idle'))) . ';
                --burido-button-color-rgb-hover: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-button-color-hover'))) . ';
                --burido-button-bg-rgb-hover: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-button-bg-hover'))) . ';
                --burido-button-border-rgb-hover: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_mb_option('dark-button-border-hover'))) . ';
            }';
        } else {
            $css .= '.wgl-dark-mode{
                --burido-primary-color: ' . WGL_Framework::get_option('dark-theme-primary-color') . ';
                --burido-secondary-color: ' . WGL_Framework::get_option('dark-theme-secondary-color') . ';
                --burido-tertiary-color: ' . WGL_Framework::get_option('dark-theme-tertiary-color') . ';
                --burido-content-color: ' . WGL_Framework::get_option('dark-theme-content-color') . ';
                --burido-header-font-color: ' . WGL_Framework::get_option('dark-theme-headings-color') . ';

                --burido-form-bg-color: ' . WGL_Framework::get_option('dark-form-bg-color') . ';

                --burido-button-color-idle: ' . WGL_Framework::get_option('dark-button-color-idle') . ';
                --burido-button-bg-idle: ' . WGL_Framework::get_option('dark-button-bg-idle') . ';
                --burido-button-border-idle: ' . WGL_Framework::get_option('dark-button-border-idle') . ';
                --burido-button-color-hover: ' . WGL_Framework::get_option('dark-button-color-hover') . ';
                --burido-button-bg-hover: ' . WGL_Framework::get_option('dark-button-bg-hover') . ';
                --burido-button-border-hover: ' . WGL_Framework::get_option('dark-button-border-hover') . ';

                --burido-primary-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-theme-primary-color'))) . ';
                --burido-secondary-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-theme-secondary-color'))) . ';
                --burido-tertiary-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-theme-tertiary-color'))) . ';
                --burido-content-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-theme-content-color'))) . ';
                --burido-header-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-theme-headings-color'))) . ';

                --burido-form-bg-color-rgb: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-form-bg-color'))) . ';

                --burido-button-color-rgb-idle: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-button-color-idle'))) . ';
                --burido-button-bg-rgb-idle: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-button-bg-idle'))) . ';
                --burido-button-border-rgb-idle: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-button-border-idle'))) . ';
                --burido-button-color-rgb-hover: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-button-color-hover'))) . ';
                --burido-button-bg-rgb-hover: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-button-bg-hover'))) . ';
                --burido-button-border-rgb-hover: ' . esc_attr(WGL_Framework::hex_to_rgb(WGL_Framework::get_option('dark-button-border-hover'))) . ';
            }';
        }

        return $css;
    }

    public function get_elementor_container_width()
    {
        if (
            did_action('elementor/loaded')
            && defined('ELEMENTOR_VERSION')
        ) {
            if (version_compare(ELEMENTOR_VERSION, '3.0', '<')) {
                $container_width = get_option('elementor_container_width') ?: 1140;
            } else {
                $kit_id = (new \Elementor\Core\Kits\Manager())->get_active_id();
                $meta_key = \Elementor\Core\Settings\Page\Manager::META_KEY;
                $kit_settings = get_post_meta($kit_id, $meta_key, true);
                $container_width = $kit_settings['container_width']['size'] ?? 1140;
            }
        }

        return $container_width ?? 1170;
    }

    protected function get_mobile_header_extra_css()
    {
        $extra_css = '';

        $this->get_elementor_css_cache_header();

        if (WGL_Framework::get_option('mobile_header') && 'elementor' !== WGL_Framework::get_option('mobile_header_building_tool')) {
            $mobile_background = WGL_Framework::get_option('mobile_background')['rgba'] ?? '';
            $mobile_color = WGL_Framework::get_option('mobile_color');
            $mobile_border_color = WGL_Framework::get_option('mobile_border_color')['rgba'] ?? '';

            $extra_css .= '.wgl-theme-header {'
                    . 'background-color: ' . esc_attr($mobile_background) . ' !important;'
                    . 'color: ' . esc_attr($mobile_color) . ' !important;'
                    . 'border-bottom: 1px solid ' . esc_attr($mobile_border_color) . ' !important;'
                . '}';
        }

        if ('elementor' !== WGL_Framework::get_option('mobile_header_building_tool')) {
            $extra_css .= 'header.wgl-theme-header .wgl-mobile-header {'
                    . 'display: block;'
                . '}'
                . '.wgl-site-header,'
                . '.wgl-theme-header .primary-nav {'
                    . 'display: none;'
                . '}'
                . '.wgl-theme-header .hamburger-box {'
                    . 'display: inline-flex;'
                . '}'
                . 'header.wgl-theme-header .mobile_nav_wrapper .primary-nav {'
                    . 'display: block;'
                . '}';
        }else{
            $extra_css .= '.wgl-menu-outer_content .elementor-mobile-breakpoint .primary-nav,
            body.single-header.elementor-editor-active .wgl-site-header .wgl-menu-outer_content .elementor-mobile-breakpoint .primary-nav{
                display:block;
            }
            .elementor-mobile-breakpoint .hamburger-box,
            body.single-header.elementor-editor-active .wgl-site-header .elementor-mobile-breakpoint .hamburger-box{
                display:block;
            }
            .wgl-menu-outer_content .elementor-mobile-breakpoint .hamburger-box,
            body.single-header.elementor-editor-active .wgl-site-header .wgl-menu-outer_content .elementor-mobile-breakpoint .hamburger-box{
                display:none;
            }
            body .wgl-mobile-header{
                display:block;
            }
            .wgl-theme-header .hamburger-box{
                display:inline-flex;
            }
            body .wgl-mobile-header .wgl-header-row{
                display: none;
            }';
        }

        $extra_css .= '.wgl-theme-header .wgl-sticky-header {'
                . 'display: none;'
            . '}'
            . '.wgl-page-socials {'
                . 'display: none;'
            . '}'
            . '.wgl-body-bg {'
                . 'top: var(--burido-header-mobile-height) !important;'
            . '}';

        $mobile_sticky = WGL_Framework::get_option('mobile_sticky');
        $mobile_over_content = WGL_Framework::get_option('mobile_over_content');

        if ('elementor' === WGL_Framework::get_option('mobile_header_building_tool')) {
            if (
                !empty($this->header_page_id)
                && did_action('elementor/loaded')
            ) {
                // Get the page settings manager
                $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');

                // Get the settings model for header post
                $page_settings_model = $page_settings_manager->get_model($this->header_page_id);

                $mobile_sticky = $page_settings_model->get_data('settings')['mobile_sticky'] ?? '';
                $mobile_over_content = $page_settings_model->get_data('settings')['header_on_bg'] ?? '';
            }
        }

        if ($mobile_over_content) {
            $extra_css .= 'body .wgl-theme-header {'
                    . 'position: absolute;'
                    . 'z-index: 1001;'
                    . 'width: 100%;'
                    . 'left: 0;'
                    . 'top: 0;'
                . '}';

            if ($mobile_sticky) {
                $extra_css .= 'body .wgl-theme-header .wgl-mobile-header {'
                        . 'position: absolute;'
                        . 'left: 0;'
                        . 'width: 100%;'
                    . '}';
            }

        }

        if ( $mobile_sticky ) {
            $extra_css .= 'body .wgl-theme-header,'
                . 'body .wgl-theme-header.header_overlap {'
                .   'position: sticky;'
                .   'top: 0;'
                . '}'
                . '.admin-bar .wgl-theme-header{'
                .   'top: var(--admin-bar-height);'
                . '}'
                . 'body.mobile_switch_on{'
                .   'position: static !important;'
                . '}'
                . 'body.admin-bar .sticky_mobile .wgl-menu_outer{'
                .   'top: 0px;'
                .   'height: 100vh;'
                . '}'
                . '.wgl-theme-header .wgl_notices_wrapper{'
                .   'transform: translateY(calc(var(--height) + var(--admin-bar-height))) !important;'
                . '}';
        }
        $extra_css .= 'body .wgl-theme-header .mini_cart-overlay{'
                . 'top: calc(-1px * var(--wgl-m-positioning-cart-top, var(--positioning-size)));'
                . 'right: calc(-1px * var(--wgl-m-positioning-cart-right, var(--positioning-size)));'
            . '}';
        $extra_css .= 'body .wgl-theme-header .wgl_notices_wrapper{'
                . '--positioning-size: 0;'
                . 'max-width: calc(100% - calc(var(--wgl-m-positioning-cart-right, var(--positioning-size)) * 2px));'
                . 'padding-right: 0;'
                . 'top: calc(1px * var(--wgl-m-positioning-cart-top, var(--positioning-size)));'
                . 'right: calc(1px * var(--wgl-m-positioning-cart-right, var(--positioning-size)));'
            . '}';
        $extra_css .= 'body div.wc-block-components-notice-banner{'
                . 'margin-bottom: calc(1px * var(--wgl-m-positioning-cart-right, var(--positioning-size)));'
            . '}';
        $extra_css .= 'body .wgl-theme-header .wgl_notices_wrapper.stick_top{'
                . 'top: max(1px * var(--wgl-m-positioning-cart-top, var(--positioning-size)), 0px);'
            . '}';

        $extra_css2 = '.wgl-theme-header .wgl-sticky-header.sticky_active ~ .wgl_notices_wrapper {'
                . 'transform: translateY(calc(var(--sticky-height) + var(--admin-bar-height)));'
            . '}';

        return '@media only screen and (max-width: ' . $this->get_header_mobile_breakpoint() . 'px) {' . $extra_css . '}'.
            '@media only screen and (min-width: ' . ((int)$this->get_header_mobile_breakpoint() + 1) . 'px) {' . $extra_css2 . '}';
    }

    protected function get_header_mobile_breakpoint()
    {
        $elementor_breakpoint = '';

        if (
            'elementor' === $this->header_building_tool
            && $this->header_page_id
            && did_action('elementor/loaded')
        ) {
            $settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
            $settings_model = $settings_manager->get_model($this->header_page_id);

            $elementor_breakpoint = $settings_model->get_data('settings')['mobile_breakpoint'] ?? '';
        }

        return $elementor_breakpoint ?: (int) WGL_Framework::get_option('header_mobile_queris');
    }

    protected function get_page_title_responsive_extra_css()
    {
        $queried_post_type = get_post_type();
        $responsive_disabled = ! WGL_Framework::get_option( 'page_title_resp_switch' );

        if (
            $this->RWMB_is_active()
            && 'on' === rwmb_meta('mb_page_title_switch')
            && rwmb_meta('mb_page_title_resp_switch')
        ) {
            $responsive_disabled = false;
        }

        if ( $responsive_disabled ) {
            // Bailout.
            return;
        }

        $pt_padding = WGL_Framework::get_mb_option('page_title_resp_padding', 'mb_page_title_resp_switch', true);
        $pt_margin = WGL_Framework::get_mb_option('page_title_resp_margin', 'mb_page_title_resp_switch', true);

        $extra_css = '.page-header {'
            . (!empty($pt_padding['padding-top']) ? 'padding-top: ' . esc_attr((int) $pt_padding['padding-top']) . 'px !important;' : '')
            . (!empty($pt_padding['padding-bottom']) ? 'padding-bottom: ' . esc_attr((int) $pt_padding['padding-bottom']) . 'px !important;' : '')
            . (!empty($pt_margin['margin-bottom']) ? 'margin-bottom: ' . esc_attr((int) $pt_margin['margin-bottom']) . 'px !important;' : '')
            . 'min-height: auto !important;'
        . '}';

        $breadcrumbs_switch = WGL_Framework::get_mb_option('page_title_resp_breadcrumbs_switch', 'mb_page_title_resp_switch', true);

        //* Title
        $pt_font = WGL_Framework::get_mb_option('page_title_resp_font', 'mb_page_title_resp_switch', true);
        $pt_color = !empty($pt_font['color']) ? 'color: ' . esc_attr($pt_font['color']) . ' !important;' : '';
        $pt_f_size = !empty($pt_font['font-size']) ? ' font-size: ' . esc_attr((int) $pt_font['font-size']) . 'px !important;' : '';
        $pt_line_height = !empty($pt_font['line-height']) ? ' line-height: ' . esc_attr((int) $pt_font['line-height']) . 'px !important;' : '';
        $pt_additional_style = !(bool) $breadcrumbs_switch ? ' margin-bottom: 0 !important;' : '';
        $title_style = $pt_color . $pt_f_size . $pt_line_height . $pt_additional_style;

        $extra_css .= '.page-header_content .page-header_title {' . $title_style . '}';

        //* Breadcrumbs
        $breadcrumbs_font = WGL_Framework::get_mb_option('page_title_resp_breadcrumbs_font', 'mb_page_title_resp_switch', true);
        $breadcrumbs_color = !empty($breadcrumbs_font['color']) ? 'color: ' . esc_attr($breadcrumbs_font['color']) . ' !important;' : '';
        $breadcrumbs_f_size = !empty($breadcrumbs_font['font-size']) ? 'font-size: ' . esc_attr((int) $breadcrumbs_font['font-size']) . 'px !important;' : '';
        $breadcrumbs_line_height = !empty($breadcrumbs_font['line-height']) ? 'line-height: ' . esc_attr((int) $breadcrumbs_font['line-height']) . 'px !important;' : '';
        $breadcrumbs_display = !(bool) $breadcrumbs_switch ? 'display: none !important;' : '';
        $breadcrumbs_style = $breadcrumbs_color . $breadcrumbs_f_size . $breadcrumbs_line_height . $breadcrumbs_display;

        $extra_css .= '.page-header_content .page-header_breadcrumbs {' . $breadcrumbs_style . '}';

        //* Blog Single Type 3
        if (
            is_single()
            && 'post' === get_post_type()
            && '3' === WGL_Framework::get_mb_option('post_single_type_layout', 'mb_post_layout_conditional', 'custom')
        ) {
            $blog_t3_padding = WGL_Framework::get_option('single_padding_layout_3');
            $blog_t3_p_top = $blog_t3_padding[ 'padding-top' ] ?? '';
            $blog_t3_p_bottom = $blog_t3_padding[ 'padding-bottom' ] ?? '';
            $blog_t3_p_top_responsive = $blog_t3_p_top > $blog_t3_p_bottom ? 80 + (int) $blog_t3_p_bottom : (int) $blog_t3_p_top;
            $blog_t3_p_top_responsive = $blog_t3_p_top_responsive > 200 ? 200 : $blog_t3_p_top_responsive;
            $blog_t3_style = 'padding-top: ' . $blog_t3_p_top_responsive . 'px !important;';
            $blog_t3_style .= 'padding-bottom: 50px !important;';

            $extra_css .= '.single-post .post_featured_bg > .blog-post {' . esc_attr( $blog_t3_style ) . '}';
        }

        $pt_breakpoint = (int) WGL_Framework::get_mb_option('page_title_resp_resolution', 'mb_page_title_resp_switch', true);

        return '@media (max-width: ' . $pt_breakpoint . 'px) {' . $extra_css . '}';
    }

    /**
     * Enqueue theme stylesheets
     *
     * Function keeps track of already enqueued stylesheets and stores them in `enqueued_stylesheets[]`
     *
     * @param string   $tag      Unprefixed handle.
     * @param string   $file_dir Optional. Path to stylesheet folder, relative to theme root folder.
     * @param string[] $deps     Optional. An array of registered stylesheet handles this stylesheet depends on.
     */
    public function enqueue_theme_stylesheet( String $tag, $file_dir = '/css/pluggable/', $deps = [] )
    {
        $prefixed_tag = WGL_Framework_Global_Variables::get_theme_slug() . '-' . $tag;

        wp_enqueue_style(
            $prefixed_tag,
            $this->template_directory_uri . $file_dir . $tag . $this->use_minified . '.css',
            $deps,
            WGL_Framework_Global_Variables::get_theme_version()
        );

        $this->enqueued_stylesheets[] = $prefixed_tag;
    }

    public function enqueue_pluggable_styles()
    {
        //* Preloader
        WGL_Framework::get_option( 'preloader' ) && $this->enqueue_theme_stylesheet( 'preloader' . (is_rtl() ? '-rtl' : '') );

        //* Page 404|Search
        ( is_404() || is_search() ) && $this->enqueue_theme_stylesheet( 'page-404' . (is_rtl() ? '-rtl' : '') );

        //* Gutenberg
        WGL_Framework::get_option( 'disable_wp_gutenberg' )
            ? wp_dequeue_style( 'wp-block-library' )
            : $this->enqueue_theme_stylesheet( 'gutenberg' . (is_rtl() ? '-rtl' : '') );

        //* Post Single
        if ( is_single() ) {
            $post_type = get_post()->post_type;
            if (
                'post' === $post_type
                || 'portfolio' === $post_type
            ) {
                $this->enqueue_theme_stylesheet( 'blog-post-single' . (is_rtl() ? '-rtl' : '') );
            } elseif ( 'team' === $post_type ) {
                $this->enqueue_theme_stylesheet( 'team-post-single' . (is_rtl() ? '-rtl' : '') );
            }
        }

        //* WooCommerce Plugin
        class_exists( 'WooCommerce' ) && $this->enqueue_theme_stylesheet( 'woocommerce' . (is_rtl() ? '-rtl' : '') );

        //* Side Panel
        if (
            WGL_Framework::get_option( 'side_panel_enabled' )
            || 'side_panel' === ( get_queried_object()->post_type ?? '' )
            || (class_exists('RWMB_Loader') && 'default' != rwmb_meta('mb_customize_side_panel'))
        ) {
            $this->enqueue_theme_stylesheet( 'side-panel' . (is_rtl() ? '-rtl' : '') );
        }

        //* WPML plugin
        class_exists( 'SitePress' ) && $this->enqueue_theme_stylesheet( 'wpml' . (is_rtl() ? '-rtl' : '') );

        //* Polylang plugin
        if (function_exists('pll_the_languages')) {
            $this->enqueue_theme_stylesheet('polylang' . (is_rtl() ? '-rtl' : ''));
        }
    }

    public function frontend_scripts()
    {

        wp_enqueue_script(
            'select2',
            $this->template_directory_uri . '/js/select2/js/select2.full.min.js',
            ['jquery'],
            WGL_Framework_Global_Variables::get_theme_version(),
            true
        );

        wp_enqueue_script(
            WGL_Framework_Global_Variables::get_theme_slug() . '-theme-addons',
            $this->template_directory_uri . '/js/theme-addons' . $this->use_minified . '.js',
            ['jquery'],
            WGL_Framework_Global_Variables::get_theme_version(),
            true
        );

        wp_enqueue_script(
            WGL_Framework_Global_Variables::get_theme_slug() . '-theme',
            $this->template_directory_uri . '/js/theme.js',
            ['jquery'],
            WGL_Framework_Global_Variables::get_theme_version(),
            true
        );

        wp_localize_script(
            WGL_Framework_Global_Variables::get_theme_slug() . '-theme',
            'wgl_core',
            [
                'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
                'nonce' => esc_js( wp_create_nonce('wgl_ajax_nonce') )
            ]
        );

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    public function admin_stylesheets()
    {
        wp_enqueue_style(
            WGL_Framework_Global_Variables::get_theme_slug() . '-admin',
            $this->template_directory_uri . '/core/admin/css/admin.css',
            [],
            WGL_Framework_Global_Variables::get_theme_version()
        );

        $this->enqueue_additional_styles();

        wp_enqueue_style( 'wp-color-picker' );
    }

    public function admin_scripts()
    {
        wp_enqueue_media();

        wp_enqueue_script('wp-color-picker');
	    wp_localize_script('wp-color-picker', 'wpColorPickerL10n', [
		    'clear' => esc_html__('Clear', 'burido'),
		    'clearAriaLabel' => esc_html__('Clear color', 'burido'),
		    'defaultString' => esc_html__('Default', 'burido'),
		    'defaultAriaLabel' => esc_html__('Select default color', 'burido'),
		    'pick' => esc_html__('Select', 'burido'),
		    'defaultLabel' => esc_html__('Color value', 'burido'),
        ]);

        wp_enqueue_script(
            WGL_Framework_Global_Variables::get_theme_slug() . '-admin',
            $this->template_directory_uri . '/core/admin/js/admin.js',
            [],
            WGL_Framework_Global_Variables::get_theme_version()
        );

        $currentTheme = wp_get_theme();
        $theme_name = false == $currentTheme->parent()
            ? wp_get_theme()->get('Name')
            : wp_get_theme()->parent()->get('Name');
        $theme_name = trim($theme_name);

        $purchase_code = $email = '';
        if (WGL_Framework::wgl_theme_activated()) {
            $theme_details = get_option('wgl_licence_validated');
            $purchase_code = $theme_details['purchase'] ?? '';
            $email = $theme_details['email'] ?? '';
        }

        wp_localize_script(
            WGL_Framework_Global_Variables::get_theme_slug() . '-admin',
            'wgl_verify',
            [
                'ajaxurl' => esc_js(admin_url('admin-ajax.php')),
                'wglUrlActivate' => esc_js(WGL_Theme_Verify::get_instance()->api . 'verification'),
                'wglUrlReset' => esc_js(WGL_Theme_Verify::get_instance()->api . 'reset_activation'),
                'wglUrlDeactivate' => esc_js(WGL_Theme_Verify::get_instance()->api . 'deactivate'),
                'domainUrl' => esc_js(site_url('/')),
                'themeName' => esc_js($theme_name),
                'purchaseCode' => esc_js($purchase_code),
                'email' => esc_js($email),
                'message' => esc_js(esc_html__('Thank you, your license has been validated', 'burido')),
                'ajax_nonce' => esc_js(wp_create_nonce('_notice_nonce')),
                'titleCodeRigistered' => esc_js(esc_html__('This purchase code has been registered', 'burido')),
                'messageCodeRigistered' => esc_js(esc_html__('Please go to your previous working environment and deactivate the purchase code to use it again (WP dashboard -> WebGeniusLab -> Activate Theme -> click on the button "Deactivate" )', 'burido')),
                'messageLostCode' => esc_js(esc_html__('Lost access to your previous site?', 'burido')),
                'activate_plugin_btn_text' => esc_js(esc_html__( 'Activate', 'burido' )),
                'update_plugin_btn_text' => esc_js(esc_html__( 'Update', 'burido' )),
                'deactivate_plugin_btn_text' => esc_js(esc_html__( 'Deactivate', 'burido' )),
                'install_plugin_btn_text' => esc_js(esc_html__( 'Install', 'burido' )),
                'activate_process_plugin_btn_text'  => esc_js(esc_html__( 'Activating', 'burido' )),
                'update_process_plugin_btn_text' => esc_js(esc_html__( 'Updating', 'burido' )),
                'deactivate_process_plugin_btn_text' => esc_js(esc_html__( 'Deactivating', 'burido' )),
                'install_process_plugin_btn_text' => esc_js(esc_html__( 'Installing', 'burido' )),
                'install_activation_error' => esc_js(sprintf(
                    '<p><a href="%s" target="_blank">%s</a></p>',
                    admin_url('themes.php?page=tgmpa-install-plugins'),
                    esc_html__('Something went wrong.', 'burido'),
                )),
            ]
        );
    }

    protected function add_body_classes()
    {
        add_filter( 'body_class', function ( Array $classes ) {
            if ( !WGL_Framework::get_option('wgl_input_style') ) {
                $classes[] = 'wgl-style-input';
            }

            if ( $this->gradient_enabled ) {
                $classes[] = 'theme-gradient';
            }

            if ('dark' === $this->theme_color_mode) {
                $classes[] = 'wgl-dark-mode wgl-init-dark';
            }

            if (
                is_single()
                && 'post' === get_post_type( get_queried_object_id() )
                && '3' === WGL_Framework::get_mb_option( 'post_single_type_layout', 'mb_post_layout_conditional', 'custom' )
            ) {
                $classes[] = WGL_Framework_Global_Variables::get_theme_slug() . '-blog-type-overlay';
            }

            return $classes;
        } );

        add_filter( 'wgl/header/mobile_width', function ($data) {
            return $this->get_header_mobile_breakpoint();
        } );
    }

    public function RWMB_is_active()
    {
        $id = ! is_archive() ? get_queried_object_id() : 0;

        return class_exists( 'RWMB_Loader' ) && 0 !== $id;
    }

    public function minify_css($css = null)
    {
        $css = str_replace(',{', '{', $css);
        $css = str_replace(', ', ',', $css);
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
        $css = trim($css);

        return $css;
    }
}

function wgl_dynamic_styles()
{
    return WGL_Framework_Dynamic_Styles::instance();
}

wgl_dynamic_styles()->construct();
