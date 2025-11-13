<?php

defined('ABSPATH') || exit;

use WGL_Extensions\WGL_Framework_Global_Variables;

if (!class_exists('Burido_Global_Functions')) {
    /**
     * Burido Global Functions
     *
     *
     * @package burido\core\class
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     */
    class Burido_Global_Functions
    {
        function __construct()
        {
            self::declare_global_functions();
            self::declare_theme_filters();
        }

        /**
         * Declaration of Theme specific functions, which can be called globally.
         */
        public static function declare_global_functions()
        {
            if (!function_exists('wgl_get_custom_menu')) {
                /**
                 * Retrieves all registered navigation menu.
                 */
                function wgl_get_custom_menu()
                {
                    $nav_menus = [];
                    $terms = get_terms('nav_menu');
                    foreach ($terms as $term) {
                        $nav_menus[$term->name] = $term->name;
                    }

                    return $nav_menus;
                }
            }

            if (!function_exists('wgl_theme_main_menu')) {
                /**
                 * Displays a navigation menu.
                 *
                 * @param int|string|WP_Term $menu  Desired menu. Accepts a menu ID, slug,
                 *                                  name, or object.
                 * @param bool $children_counter    Whether to count submenu `li` items.
                 * @param bool $submenu_disable     If `true` will render only top-level menu
                 *                                  w/o submenu elements. Default `null`.
                 */
                function wgl_theme_main_menu($menu = '', $children_counter = false, $submenu_disable = null)
                {
                    wp_nav_menu([
                        'menu' => $menu,
                        'theme_location' => 'main_menu',
                        'container' => '',
                        'container_class' => '',
                        'after' => '',
                        'link_before' => '<span class="item_wrapper_text">',
                        'link_after' => '</span>',
                        'walker' => class_exists( 'WGL_Mega_Menu_Walker') ? new WGL_Mega_Menu_Walker($children_counter, $submenu_disable) : ''
                    ]);
                }
            }

            if (!function_exists('burido_get_all_sidebars')) {
                /**
                 * @return array registered sidebars
                 */
                function burido_get_all_sidebars()
                {
                    global $wp_registered_sidebars;

                    if (empty($wp_registered_sidebars)) {
                        return;
                    }

                    foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
                        $out[$sidebar_id] = $sidebar['name'];
                    }

                    return $out ?? [];
                }
            }

            if (!function_exists('burido_quick_tip')) {
                /**
                 * Render string as a QuickTip element.
                 *
                 * @return string
                 */
                function burido_quick_tip(String $string)
                {
                    return sprintf(
                        '<span class="burido-tip">'
                            . '<i class="tip-icon el el-question-sign"></i>'
                            . '<span class="tip-content">%s</span>'
                            . '</span>',
                        $string
                    );
                }
            }
        }

        /**
         * Declaration of Theme specific functions,
         * which be called via filters.
         */
        private static function declare_theme_filters()
        {
            if (!function_exists('burido_tiny_mce_buttons_2')) {
                function burido_tiny_mce_buttons_2($buttons )
                {
                    array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
                    return $buttons;

                }
            }
            if (!function_exists('burido_tiny_mce_before_init')) {
                function burido_tiny_mce_before_init($settings)
                {
                    $settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';

                    $style_formats = [
                        [
                            'title' => esc_html__('Dropcap', 'burido'),
                            'items' => [
                                [
                                    'title' => esc_html__('Simple Primary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap primary simple',
                                ],
                                [
                                    'title' => esc_html__('Simple Secondary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap secondary simple',
                                ],
                                [
                                    'title' => esc_html__('Simple Heading Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap heading simple',
                                ],
                                [
                                    'title' => esc_html__('Primary Text Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap primary',
                                ],
                                [
                                    'title' => esc_html__('Secondary Text Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap secondary',
                                ],
                                [
                                    'title' => esc_html__('Heading Text Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap heading',
                                ],
                                [
                                    'title' => esc_html__('Primary Background Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap primary alt',
                                ],
                                [
                                    'title' => esc_html__('Secondary Background Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'dropcap secondary alt',
                                ],
                                [
                                    'title' => esc_html__('Rounded', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'rounded',
                                ],
                            ],
                        ],
                        [
                            'title' => esc_html__('Highlighter', 'burido'),
                            'items' => [
                                [
                                    'title' => esc_html__('Primary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'highlighter primary',
                                ],
                                [
                                    'title' => esc_html__('Secondary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'highlighter secondary',
                                ],
                                [
                                    'title' => esc_html__('Tertiary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'highlighter tertiary',
                                ],
                                [
                                    'title' => esc_html__('Header Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'highlighter header',
                                ],
                            ],
                        ],
                        [
                            'title' => esc_html__('Font Family', 'burido'),
                            'items' => [
                                [
                                    'title' => esc_html__('Content Font Family', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'theme-content-font',
                                ],
                                [
                                    'title' => esc_html__('Header Font Family', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'theme-header-font',
                                ],
                                [
                                    'title' => esc_html__('Tertiary Font Family', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'theme-additional-font',
                                ],
                            ],
                        ],
                        [
                            'title' => esc_html__('Font Weight', 'burido'),
                            'items' => [
                                [
                                    'title' => esc_html__('Default', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => 'inherit'],
                                ], [
                                    'title' => esc_html__('Lightest (100)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '100'],
                                ], [
                                    'title' => esc_html__('Lighter (200)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '200'],
                                ], [
                                    'title' => esc_html__('Light (300)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '300'],
                                ], [
                                    'title' => esc_html__('Normal (400)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '400'],
                                ], [
                                    'title' => esc_html__('Medium (500)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '500'],
                                ], [
                                    'title' => esc_html__('Semi-Bold (600)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '600'],
                                ], [
                                    'title' => esc_html__('Bold (700)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '700'],
                                ], [
                                    'title' => esc_html__('Bolder (800)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '800'],
                                ], [
                                    'title' => esc_html__('Extra Bold (900)', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['font-weight' => '900'],
                                ],
                            ]
                        ],
                        [
                            'title' => esc_html__('List Style', 'burido'),
                            'items' => [
                                [
                                    'title' => esc_html__('Dot', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_dot',
                                ], [
                                    'title' => esc_html__('Check', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_check',
                                ], [
		                            'title' => esc_html__('Circle', 'burido'),
		                            'selector' => 'ul',
		                            'classes' => 'burido_circle',
	                            ], [
                                    'title' => esc_html__('Square', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_square',
                                ], [
                                    'title' => esc_html__('Plus', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_plus',
                                ], [
                                    'title' => esc_html__('Line', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_line',
                                ], [
                                    'title' => esc_html__('Hyphen', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_hyphen',
                                ], [
                                    'title' => esc_html__('Rhombus', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_rhombus',
                                ], [
                                    'title' => esc_html__('Star', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_star',
                                ], [
                                    'title' => esc_html__('Arrow', 'burido'),
                                    'selector' => 'ul',
                                    'classes' => 'burido_arrow',
                                ], [
                                    'title' => esc_html__('Icon Primary Color', 'burido'),
                                    'selector' => 'ul[class*="burido_"], ol',
                                    'classes' => 'list_primary_color',
                                ], [
                                    'title' => esc_html__('Icon Secondary Color', 'burido'),
                                    'selector' => 'ul[class*="burido_"], ol',
                                    'classes' => 'list_secondary_color',
                                ], [
                                    'title' => esc_html__('Icon Tertiary Color', 'burido'),
                                    'selector' => 'ul[class*="burido_"], ol',
                                    'classes' => 'list_tertiary_color',
                                ], [
                                    'title' => esc_html__('Icon Heading Color', 'burido'),
                                    'selector' => 'ul[class*="burido_"], ol',
                                    'classes' => 'list_heading_color',
                                ], [
                                    'title' => esc_html__('Icon Bg Primary Color', 'burido'),
                                    'selector' => 'ul[class*="burido_"], ol',
                                    'classes' => 'list_primary_bg_color',
                                ], [
                                    'title' => esc_html__('Icon Bg Secondary Color', 'burido'),
                                    'selector' => 'ul[class*="burido_"], ol',
                                    'classes' => 'list_secondary_bg_color',
                                ], [
                                    'title' => esc_html__('List w/ Right Icons', 'burido'),
                                    'selector' => 'ul[class*="burido_"], ol',
                                    'classes' => 'icon_right',
                                ], [
                                    'title' => esc_html__('Disabled Item', 'burido'),
                                    'selector' => 'ul li, ol li',
                                    'classes' => 'burido_disabled_item',
                                ], [
                                    'title' => esc_html__('No List Style', 'burido'),
                                    'selector' => 'ul, ol',
                                    'classes' => 'no-list-style',
                                ], [
                                    'title' => esc_html__('Inline Icon', 'burido'),
                                    'selector' => 'ul, ol',
                                    'classes' => 'icon_inline',
                                ],
                            ]
                        ],
                        [
                            'title' => esc_html__('Text Color', 'burido'),
                            'items' => [[
                                    'title' => esc_html__('Primary Color', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['color' => 'var(--burido-primary-color)'],
                                ], [
                                    'title' => esc_html__('Secondary Color', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['color' => 'var(--burido-secondary-color)'],
                                ],
                                [
                                    'title' => esc_html__('Tertiary Color', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['color' => 'var(--burido-tertiary-color)'],
                                ],
                                [
                                    'title' => esc_html__('Content Color', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['color' => 'var(--burido-content-color)'],
                                ],
                                [
                                    'title' => esc_html__('Header Color', 'burido'),
                                    'inline' => 'span',
                                    'styles' => ['color' => 'var(--burido-header-font-color)'],
                                ],
                            ]
                        ],
                        [
                            'title' => esc_html__('Underline', 'burido'),
                            'items' => [
                                [
                                    'title' => esc_html__('Primary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'underline primary',
                                ],
                                [
                                    'title' => esc_html__('Secondary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'underline secondary',
                                ],
                                [
                                    'title' => esc_html__('Tertiary Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'underline tertiary',
                                ],
                                [
                                    'title' => esc_html__('Header Color', 'burido'),
                                    'inline' => 'span',
                                    'classes' => 'underline header',
                                ],
                            ],
                        ],
                    ];

                    $settings['style_formats'] = str_replace('"', "'", json_encode($style_formats));
                    $settings['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 22px 24px 28px 32px 36px";
                    $settings['extended_valid_elements'] = 'span[*],a[*],i[*]';

                    return $settings;
                }
            }

            if (!function_exists('burido_comment_form_fields')) {
                function burido_comment_form_fields($fields)
                {
                    $new_fields = [];

                    $myorder = ['author', 'email', 'url', 'comment'];

                    foreach ($myorder as $key) {
                        $new_fields[$key] = $fields[$key] ?? '';
                        unset($fields[$key]);
                    }

                    if ($fields) {
                        foreach ($fields as $key => $val) {
                            $new_fields[$key] = $val;
                        }
                    }

                    return $new_fields;
                }
            }

            if (!function_exists('burido_categories_postcount_filter')) {
                function burido_categories_postcount_filter($variable)
                {
	                if (strpos($variable, '</a> (')) {
		                $variable = str_replace('</a> (', '<span class="post_count">', $variable);
		                $variable = str_replace('</a>&nbsp;(', '<span class="post_count">', $variable);
		                $variable = str_replace(')', '</span></a>', $variable);
	                } else {
		                $variable = str_replace('</a> <span class="count">(', '<span class="post_count">', $variable);
		                $variable = str_replace(')</span>', '</span></a>', $variable);
	                }

                    $pattern1 = '/cat-item-\d+/';
                    preg_match_all($pattern1, $variable, $matches);
                    if (isset($matches[0])) {
                        foreach ($matches[0] as $value) {
                            $int = (int) str_replace('cat-item-', '', $value);
                            $icon_image_id = get_term_meta($int, 'category-icon-image-id', true);
                            if (!empty($icon_image_id)) {
                                $icon_image = wp_get_attachment_image_src($icon_image_id, 'full');
                                $icon_image_alt = get_post_meta($icon_image_id, '_wp_attachment_image_alt', true);
                                $replacement = '$1<img class="cats_item-image" src="' . esc_url($icon_image[0]) . '" alt="' . (!empty($icon_image_alt) ? esc_attr($icon_image_alt) : '') . '"/>';
                                $pattern = '/(cat-item-' . $int . '+.*?><a.*?>)/';
                                $variable = preg_replace($pattern, $replacement, $variable);
                            }
                        }
                    }

                    return $variable;
                }
            }

            if (!function_exists('burido_render_archive_widgets')) {
                function burido_render_archive_widgets(
                    $link_html,
                    $url,
                    $text,
                    $format,
                    $before,
                    $after
                ) {
                    $text = wptexturize($text);
                    $url = esc_url($url);

                    if ('link' == $format) {
                        $link_html = "\t<link rel='archives' title='" . esc_attr($text) . "' href='$url' />\n";
                    } elseif ('option' == $format) {
                        $link_html = "\t<option value='$url'>$before $text $after</option>\n";
                    } elseif ('html' == $format) {

                        $after = str_replace('(', '', $after);
                        $after = str_replace(' ', '', $after);
                        $after = str_replace('&nbsp;', '', $after);
                        $after = str_replace(')', '', $after);

                        $after = !empty($after) ? ' <span class="post_count">' . esc_html($after) . '</span> ' : '';

                        $link_html = '<li>' . esc_html($before) . '<a href="' . esc_url($url) . '">' . esc_html($text) . $after . '</a></li>';
                    } else { // custom
                        $link_html = "\t$before<a href='$url'>$text</a>$after\n";
                    }

                    return $link_html;
                }
            }

            if (!function_exists('burido_header_enable')) {
                function burido_header_enable()
                {
                    $header_switch = WGL_Framework::get_option('header_switch');
                    if (empty($header_switch)) {
                        return false;
                    }

                    $id = !is_archive() ? get_queried_object_id() : 0;

                    if (
                        class_exists('RWMB_Loader')
                        && 0 !== $id
                        && rwmb_meta('mb_customize_header_layout') == 'hide'
                    ) {
                        // Don't render header if in metabox set to hide it.
                        return false;
                    }

                    $page_not_found = WGL_Framework::get_option('404_show_header');
                    if (
                        is_404()
                        && !$page_not_found
                    ) {
                        // hide if 404 page
                        return;
                    }

                    return true;
                }
            }

            if (!function_exists('burido_page_title_enable')) {
                function burido_page_title_enable()
                {
                    $id = !is_archive() ? get_queried_object_id() : 0;

                    $output['mb_page_title_switch'] = '';
                    if (is_404()) {
                        $output['page_title_switch'] = WGL_Framework::get_option('404_page_title_switcher') ? 'on' : 'off';
                    } else if(class_exists( 'WooCommerce' ) && is_product()){
                        $output['page_title_switch'] = WGL_Framework::get_option('shop_single__page_title_switch') ? 'on' : 'off';
                    } else if(is_singular('portfolio')){
                        $output['page_title_switch'] = WGL_Framework::get_option('portfolio_single__page_title_switch') ? 'on' : 'off';
                    } else {
                        $output['page_title_switch'] = WGL_Framework::get_option('page_title_switch') ? 'on' : 'off';
                        if (class_exists('RWMB_Loader') && $id !== 0) {
                            $output['mb_page_title_switch'] = rwmb_meta('mb_page_title_switch');
                        }

                        if('on' === $output['page_title_switch'] && class_exists( 'WooCommerce' )){
                            if (is_shop() || is_product_category() || is_product_tag()) {
                                $output['page_title_switch'] = WGL_Framework::get_option('shop_catalog__page_title_switch') ? 'on' : 'off';
                            } else if(is_cart()) {
                                $output['page_title_switch'] = WGL_Framework::get_option('shop_cart__page_title_switch') ? 'on' : 'off';
                            } else if(is_checkout()) {
                                $output['page_title_switch'] = WGL_Framework::get_option('shop_checkout__page_title_switch') ? 'on' : 'off';
                            }
                        }
                    }

                    $output['single'] = ['type' => '', 'layout' => ''];

                    /**
                     * Check the Post Type
                     *
                     * Aimed to prevent Page Title rendering for the following pages:
                     *	- blog single type 3;
                     */
                    if (
                        get_post_type($id) == 'post'
                        && is_single()
                    ) {
                        $output['single']['type'] = 'post';
                        $output['single']['layout'] = WGL_Framework::get_mb_option('post_single_type_layout', 'mb_post_layout_conditional', 'custom');
                        if ('3' === $output['single']['layout']) {
                            $output['page_title_switch'] = 'off';
                        }
                    }

                    if (isset($output['mb_page_title_switch']) && 'on' === $output['mb_page_title_switch']) {
                        $output['page_title_switch'] = 'on';
                    }

                    if (
                        is_front_page()
                        || isset($output['mb_page_title_switch']) && 'off' === $output['mb_page_title_switch']
                    ) {
                        $output['page_title_switch'] = 'off';
                    }

                    return $output;
                }
            }

            if (!function_exists('burido_after_main_content')) {
                function burido_after_main_content()
                {
                    $scroll_up = WGL_Framework::get_option('scroll_up');
                    $scroll_up_as_text = WGL_Framework::get_option('scroll_up_appearance');
                    $scroll_up_text = WGL_Framework::get_option('scroll_up_text');

                    // Page Socials
                    if (
                        is_page()
                        && function_exists('wgl_extensions_social')
                    ) {
                        // ↓ Conditions Check
                        $render_socials = true;
                        if (
                            class_exists('WooCommerce')
                            && (is_cart() || is_checkout())
                        ) {
                            // exclude Cart and Checkout pages
                            $render_socials = false;
                        }
                        if ($render_socials) {
                            $render_socials = WGL_Framework::get_option('show_soc_icon_page');
                        }
                        if (
                            class_exists('RWMB_Loader')
                            && get_queried_object_id() !== 0
                        ) {
                            switch (rwmb_meta('mb_customize_soc_shares')) {
                                case 'on':
                                    $render_socials = true;
                                    break;
                                case 'off':
                                    $render_socials = false;
                                    break;
                            }
                        }
                        // ↑ conditions check

                        if ($render_socials) {
                            wgl_extensions_social()->render_social_shares();
                        }
                    }

                    // Scroll Up Button
                    if ($scroll_up) {
                        echo '<div id="scroll_up" class="' . ($scroll_up_as_text ? 'scroll_up-text' : 'scroll_up-icon') . '">',
                            $scroll_up_as_text ? '<span>' . esc_html($scroll_up_text) . '</span>' : '',
                            '<i class="wgl-svg-icon">'.wgl_dynamic_styles()->wgl_theme_svg()['arrow-theme'].'</i>',
                        '</div>';
                    }

                    // Body Lines
                    $body_lines_switch = WGL_Framework::get_option('body_lines_switch');
                    if (class_exists('RWMB_Loader') && get_queried_object_id() !== 0) {
                        if (WGL_Framework::get_mb_option('body_lines_switch') == 'on') {
                            $body_lines_switch = true;
                        } elseif (WGL_Framework::get_mb_option('body_lines_switch') == 'off') {
                            $body_lines_switch = false;
                        }
                    }
                    if ($body_lines_switch) {
                        echo '<div class="wgl-body-lines"><span></span></div>';
                    }

                    // Dynamic Styles
                    global $burido_dynamic_css;
                    if (!empty($burido_dynamic_css['style'])) {
                        echo '<span',
                            ' id="burido-footer-inline-css"',
                            ' class="dynamic_styles-footer"',
                            '>',
                            esc_html($burido_dynamic_css['style']),
                            '</span>';
                    }

                    // Cursor
                    $cursor = apply_filters('wgl/burido_module_cursor', false);
                    if ($cursor || WGL_Framework::get_option('cursor_switch')) {
                        echo '<div id="wgl-cursor"><div id="wgl-cursor-pointer"></div></div>';
                    }
                }
            }

            if (!function_exists('burido_footer_enable')) {
                function burido_footer_enable()
                {
                    $output = [];
                    $output['footer_switch'] = WGL_Framework::get_option('footer_switch');
                    $output['copyright_switch'] = WGL_Framework::get_option('copyright_switch');

                    if (class_exists('RWMB_Loader') && get_queried_object_id() !== 0) {
                        $output['mb_footer_switch'] = rwmb_meta('mb_footer_switch');
                        $output['mb_copyright_switch'] = rwmb_meta('mb_copyright_switch');

                        if ($output['mb_footer_switch'] == 'on') {
                            $output['footer_switch'] = true;
                        } elseif ($output['mb_footer_switch'] == 'off') {
                            $output['footer_switch'] = false;
                        }

                        if ($output['mb_copyright_switch'] == 'on') {
                            $output['copyright_switch'] = true;
                        } elseif ($output['mb_copyright_switch'] == 'off') {
                            $output['copyright_switch'] = false;
                        }
                    }

                    // Hide on 404 page
                    $page_not_found = WGL_Framework::get_option('404_show_footer');
                    if (
                        is_404()
                        && !$page_not_found
                    ) {
                        $output['footer_switch'] = $output['copyright_switch'] = false;
                    }

                    return $output;
                }
            }
        }
    }

    new Burido_Global_Functions();
}
