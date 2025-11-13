<?php

if (!class_exists('WGL_Extensions_Core')) {
    return;
}

if (!function_exists('wgl_get_redux_icons')) {
    function wgl_get_redux_icons()
    {
        return WGLAdminIcon()->get_icons_name(true);
    }

    add_filter('redux/font-icons', 'wgl_get_redux_icons',99);
}

add_action('after_setup_theme', function() {

    //* This is theme option name where all the Redux data is stored.
    $theme_slug = 'burido_set';

    /**
     * Set all the possible arguments for Redux
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */
    $theme = wp_get_theme();

    Redux::set_args($theme_slug, [
        'opt_name' => $theme_slug, //* This is where your data is stored in the database and also becomes your global variable name.
        'display_name' => $theme->get('Name'), //* Name that appears at the top of your panel
        'display_version' => $theme->get('Version'), //* Version that appears at the top of your panel
        'menu_type' => 'menu', //* Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu' => true, //* Show the sections below the admin menu item or not
        'menu_title' => esc_html__('Theme Options', 'burido'),
        'page_title' => esc_html__('Theme Options', 'burido'),
        'google_api_key' => '', //* You will need to generate a Google API key to use this feature. Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_update_weekly' => false, //* Set it you want google fonts to update weekly. A google_api_key value is required.
        'async_typography' => true, //* Must be defined to add google fonts to the typography module
        'admin_bar' => true, //* Show the panel pages on the admin bar
        'admin_bar_icon' => 'dashicons-admin-generic', //* Choose an icon for the admin bar menu
        'admin_bar_priority' => 50, //* Choose an priority for the admin bar menu
        'global_variable' => '', //* Set a different name for your global variable other than the opt_name
        'dev_mode' => false,
        'update_notice' => true, //* If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer' => true,
        'page_priority' => 3, //* Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent' => 'wgl-dashboard-panel', //* For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions' => 'manage_options', //* Permissions needed to access the options panel.
        'menu_icon' => 'dashicons-admin-generic', //* Specify a custom URL to an icon
        'last_tab' => '', //* Force your panel to always open to a specific tab (by id)
        'page_icon' => 'icon-themes', //* Icon displayed in the admin panel next to your menu_title
        'page_slug' => 'wgl-theme-options-panel', //* Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults' => true, //* On load save the defaults to DB before user clicks save or not
        'default_show' => false, //* If true, shows the default value next to each field that is not the default value.
        'default_mark' => '', //* What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export' => true, //* Shows the Import/Export panel when not used as a field.
        'transient_time' => 60 * MINUTE_IN_SECONDS, //* Show the time the page took to load, etc
        'output' => true, //* Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag' => true, //* FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database' => '', //* possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn' => true,
    ]);

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'general',
            'title' => esc_html__('General', 'burido'),
            'icon' => 'el el-screen',
            'fields' => [
                [
                    'id' => 'use_minified',
                    'title' => esc_html__('Use minified css/js files', 'burido'),
                    'type' => 'switch',
                    'desc' => esc_html__('Speed up your site load.', 'burido'),
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                ],
                [
                    'id' => 'body_settings',
                    'type' => 'section',
                    'title' => esc_html__('Body', 'burido'),
                    'indent' => true,
                ],
                [
                    'id' => 'body_lines_switch',
                    'title' => esc_html__('Body Lines', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('On', 'burido'),
                    'off' => esc_html__('Off', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'body_lines_color',
                    'title' => esc_html__('Lines Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['body_lines_switch', '=', '1'],
                    'transparent' => false,
                    'default' => [
                        'alpha' => '0.4',
                        'rgba' => 'rgba(185,185,185,0.4)',
                        'color' => '#e3e3e3',
                    ],
                ],
                [
                    'id' => 'body_settings-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'preloader-start',
                    'title' => esc_html__('Preloader', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'preloader',
                    'title' => esc_html__('Preloader', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'preloader_background',
                    'title' => esc_html__('Preloader Background', 'burido'),
                    'type' => 'color',
                    'required' => ['preloader', '=', '1'],
                    'transparent' => false,
                    'default' => '#ffffff',
                ],
                [
                    'id' => 'preloader_color',
                    'title' => esc_html__('Preloader Color', 'burido'),
                    'type' => 'color',
                    'required' => ['preloader', '=', '1'],
                    'transparent' => false,
                    'default' => '#FF7425',
                ],
                [
                    'id' => 'preloader-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'search_settings',
                    'type' => 'section',
                    'title' => esc_html__('Search', 'burido'),
                    'indent' => true,
                ],
                [
                    'id' => 'search_style',
                    'title' => esc_html__('Choose search style', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'standard' => esc_html__('Standard', 'burido'),
                        'standard_fw' => esc_html__('Full Header Width', 'burido'),
                        'alt' => esc_html__('Full Page Width', 'burido'),
                    ],
                    'default' => 'standard',
                ],
                [
                    'id' => 'search_post_type',
                    'title' => esc_html__('Search Post Types', 'burido'),
                    'type' => 'multi_text',
                    'validate' => 'no_html',
                    'add_text' => esc_html__('Add Post Type', 'burido'),
                    'default' => [],
                ],
                [
                    'id' => 'search_settings-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'cursor_settings',
                    'type' => 'section',
                    'title' => esc_html__('Cursor Pointer', 'burido'),
                    'indent' => true,
                ],
                [
                    'id' => 'cursor_switch',
                    'title' => esc_html__('Cursor Pointer', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('On', 'burido'),
                    'off' => esc_html__('Off', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'cursor_color',
                    'title' => esc_html__('Point Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['cursor_switch', '=', '1'],
                    'transparent' => false,
                    'default' => [
                        'alpha' => '0',
                        'rgba' => 'rgba(60,133,153,0)',
                        'color' => '#FF7425',
                    ],
                ],
                [
                    'id' => 'cursor_settings-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'scroll_up_settings',
                    'title' => esc_html__('Back to Top', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'scroll_up',
                    'title' => esc_html__('Button', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Disable', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'scroll_up_appearance',
                    'title' => esc_html__('Appearance', 'burido'),
                    'type' => 'switch',
                    'required' => ['scroll_up', '=', true],
                    'on' => esc_html__('Text with Icon', 'burido'),
                    'off' => esc_html__('Only Icon', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'scroll_up_text',
                    'title' => esc_html__('Button Text', 'burido'),
                    'type' => 'text',
                    'required' => ['scroll_up_appearance', '=', true],
                    'default' => esc_html__('Back To Top', 'burido'),
                ],
                [
                    'id' => 'scroll_up_arrow_color',
                    'title' => esc_html__('Text/Icon Color', 'burido'),
                    'type' => 'color',
                    'required' => ['scroll_up', '=', true],
                    'transparent' => false,
                    'default' => '#ffffff',
                ],
                [
                    'id' => 'scroll_up_arrow_color_bg',
                    'title' => esc_html__('Text/Icon Background Color', 'burido'),
                    'type' => 'color',
                    'required' => ['scroll_up', '=', true],
                    'transparent' => true,
                    'default' => '#8088E6',
                ],
                [
                    'id' => 'scroll_up_arrow_color_border',
                    'title' => esc_html__('Icon Border Color', 'burido'),
                    'type' => 'color',
                    'required' => ['scroll_up', '=', true],
                    'transparent' => true,
                    'default' => '',
                ],
                [
                    'id' => 'scroll_up_settings-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'cart_overlay_settings',
                    'title' => esc_html__('Header Cart', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'overlay_full',
                    'title' => esc_html__('Full Page Overlay', 'burido'),
                    'desc' => esc_html__( 'This option is useful if you are using a transparent header background', 'burido' ),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'cart_overlay_color',
                    'title' => esc_html__('Cart Overlay Color', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '0.3',
                        'rgba' => 'rgba(24, 24, 24, 0.3)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'cart_offset',
                    'title' => esc_html__('Top/Right Offset', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'absolute',
                    'all' => false,
                    'top' => true,
                    'right' => true,
                    'bottom' => false,
                    'left' => false,
                    'default' => [
                        'top' => '30',
                        'right' => '30',
                    ],
                ],
                [
                    'id' => 'cart_offset_m',
                    'title' => esc_html__('Top/Right Offset (Mobile)', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'absolute',
                    'all' => false,
                    'top' => true,
                    'right' => true,
                    'bottom' => false,
                    'left' => false,
                    'default' => [
                        'top' => '10',
                        'right' => '10',
                    ],
                ],
                [
                    'id' => 'cart_overlay_settings-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ],
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'editors-option',
            'title' => esc_html__('Custom JS', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'custom_js',
                    'title' => esc_html__('Custom JS', 'burido'),
                    'type' => 'ace_editor',
                    'subtitle' => esc_html__('Paste your JS code here.', 'burido'),
                    'mode' => 'javascript',
                    'theme' => 'chrome',
                    'default' => ''
                ],
                [
                    'id' => 'header_custom_js',
                    'title' => esc_html__('Custom JS', 'burido'),
                    'type' => 'ace_editor',
                    'subtitle' => esc_html__('Code to be added inside HEAD tag', 'burido'),
                    'mode' => 'html',
                    'theme' => 'chrome',
                    'default' => ''
                ],
            ],
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'header_section',
            'title' => esc_html__('Header', 'burido'),
            'icon' => 'fas fa-window-maximize',
        ]
    );

    $header_builder_items = [
        'default' => [
            'html1' => ['title' => esc_html__('HTML 1', 'burido'), 'settings' => true],
            'html2' => ['title' => esc_html__('HTML 2', 'burido'), 'settings' => true],
            'html3' => ['title' => esc_html__('HTML 3', 'burido'), 'settings' => true],
            'html4' => ['title' => esc_html__('HTML 4', 'burido'), 'settings' => true],
            'html5' => ['title' => esc_html__('HTML 5', 'burido'), 'settings' => true],
            'html6' => ['title' => esc_html__('HTML 6', 'burido'), 'settings' => true],
            'html7' => ['title' => esc_html__('HTML 7', 'burido'), 'settings' => true],
            'html8' => ['title' => esc_html__('HTML 8', 'burido'), 'settings' => true],
            'delimiter1' => ['title' => esc_html__('|', 'burido'), 'settings' => true],
            'delimiter2' => ['title' => esc_html__('|', 'burido'), 'settings' => true],
            'delimiter3' => ['title' => esc_html__('|', 'burido'), 'settings' => true],
            'delimiter4' => ['title' => esc_html__('|', 'burido'), 'settings' => true],
            'delimiter5' => ['title' => esc_html__('|', 'burido'), 'settings' => true],
            'delimiter6' => ['title' => esc_html__('|', 'burido'), 'settings' => true],
            'spacer3' => ['title' => esc_html__('Spacer 3', 'burido'), 'settings' => true],
            'spacer4' => ['title' => esc_html__('Spacer 4', 'burido'), 'settings' => true],
            'spacer5' => ['title' => esc_html__('Spacer 5', 'burido'), 'settings' => true],
            'spacer6' => ['title' => esc_html__('Spacer 6', 'burido'), 'settings' => true],
            'spacer7' => ['title' => esc_html__('Spacer 7', 'burido'), 'settings' => true],
            'spacer8' => ['title' => esc_html__('Spacer 8', 'burido'), 'settings' => true],
            'button1' => ['title' => esc_html__('Button', 'burido'), 'settings' => true],
            'button2' => ['title' => esc_html__('Button', 'burido'), 'settings' => true],
            'wpml' => ['title' => esc_html__('WPML/Polylang', 'burido'), 'settings' => false],
            'cart' => ['title' => esc_html__('Cart', 'burido'), 'settings' => true],
            'item_search' => ['title' => esc_html__('Search', 'burido'), 'settings' => false],
            'login' => ['title' => esc_html__('WC Login', 'burido'), 'settings' => false],
            'side_panel' => ['title' => esc_html__('Side Panel', 'burido'), 'settings' => true],
            'profile' => ['title' => esc_html__('Profile', 'burido'), 'settings' => true],
        ],
        'mobile' => [
            'html1' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html2' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html3' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html4' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html5' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html6' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'spacer1' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer2' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer3' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer4' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer5' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer6' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'side_panel' => ['title' => esc_html__('Side Panel', 'burido'), 'settings' => false],
            'wpml' => ['title' => esc_html__('WPML/Polylang', 'burido'), 'settings' => false],
            'cart' => ['title' => esc_html__('Cart', 'burido'), 'settings' => false],
            'item_search' => ['title' => esc_html__('Search', 'burido'), 'settings' => false],
            'login' => ['title' => esc_html__('WC Login', 'burido'), 'settings' => false],
            'button1' => ['title' => esc_html__('Button', 'burido'), 'settings' => true],
            'button2' => ['title' => esc_html__('Button', 'burido'), 'settings' => true],
            'socials' => ['title' => esc_html__('Socials', 'burido'), 'settings' => true],
            'profile' => ['title' => esc_html__('Profile', 'burido'), 'settings' => true],
        ],
        'mobile_drawer' => [
            'html1' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html2' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html3' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html4' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html5' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'html6' => ['title' => esc_html__('HTML', 'burido'), 'settings' => true],
            'wpml' => ['title' => esc_html__('WPML/Polylang', 'burido'), 'settings' => false],
            'button1' => ['title' => esc_html__('Button', 'burido'), 'settings' => true],
            'button2' => ['title' => esc_html__('Button', 'burido'), 'settings' => true],
            'spacer1' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer2' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer3' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer4' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer5' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'spacer6' => ['title' => esc_html__('Spacer', 'burido'), 'settings' => true],
            'socials' => ['title' => esc_html__('Socials', 'burido'), 'settings' => true],
            'profile' => ['title' => esc_html__('Profile', 'burido'), 'settings' => true],
        ],
    ];

    Redux::set_section(
        $theme_slug,
        [
            'title' => esc_html__('Header Builder', 'burido'),
            'id' => 'header-customize',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'header_switch',
                    'title' => esc_html__('Header', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Disable', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'header_building_tool',
                    'title' => esc_html__('Layout Building Tool', 'burido'),
                    'type' => 'select',
                    'required' => ['header_switch', '=', '1'],
                    'options' => [
                        'default' => esc_html__('Default Builder', 'burido'),
                        'elementor' => esc_html__('Elementor (recommended)', 'burido')
                    ],
                    'default' => 'default',
                ],
                [
                    'id' => 'header_page_select',
                    'type' => 'select',
                    'title' => esc_html__('Header Template', 'burido'),
                    'required' => ['header_building_tool', '=', 'elementor'],
                    'desc' => wp_kses(
                        sprintf(
                            '%s <a href="%s" target="_blank">%s</a> %s<br> %s',
                            __('Selected Template will be used for all pages by default. You can edit/create Header Template in the', 'burido'),
                            admin_url('edit.php?post_type=header'),
                            __('Header Templates', 'burido'),
                            __('dashboard tab.', 'burido'),
                            burido_quick_tip(
                                sprintf(
                                    __('Note: fine tuning is available through the Elementor\'s <code>Post Settings</code> tab, which is located <a href="%s" target="_blank">here</a>', 'burido'),
                                    get_template_directory_uri() . '/core/admin/img/dashboard/quick_tip__header_extra_options.png'
                                )
                            )
                        ),
                        ['a' => ['href' => true, 'target' => true], 'br' => [], 'span' => ['class' => true], 'i' => ['class' => true], 'code' => []]
                    ),
                    'data' => 'posts',
                    'args' => [
                        'post_type' => 'header',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ],
                ],
                [
                    'id' => 'bottom_header_layout',
                    'type' => 'custom_header_builder',
                    'title' => esc_html__('Header Builder', 'burido'),
                    'required' => ['header_building_tool', '=', 'default'],
                    'compiler' => 'true',
                    'full_width' => true,
                    'options' => [
                        'items' => $header_builder_items['default'],
                        'Top Left area' => [],
                        'Top Center area' => [],
                        'Top Right area' => [],
                        'Middle Left area' => [
                            'spacer1' => ['title' => esc_html__('Spacer 1', 'burido'), 'settings' => true],
                            'logo' => ['title' => esc_html__('Logo', 'burido'), 'settings' => false],
                        ],
                        'Middle Center area' => [
                            'menu' => ['title' => esc_html__('Menu', 'burido'), 'settings' => false],
                        ],
                        'Middle Right area' => [
                            'item_search' => ['title' => esc_html__('Search', 'burido'), 'settings' => true],
                            'spacer2' => ['title' => esc_html__('Spacer 2', 'burido'), 'settings' => true],
                        ],
                        'Bottom Left area' => [],
                        'Bottom Center area' => [],
                        'Bottom Right area' => [],
                    ],
                    'default' => [
                        'items' => $header_builder_items['default'],
                        'Top Left area' => [],
                        'Top Center area' => [],
                        'Top Right area' => [],
                        'Middle Left area' => [
                            'spacer1' => ['title' => esc_html__('Spacer 1', 'burido'), 'settings' => true],
                            'logo' => ['title' => esc_html__('Logo', 'burido'), 'settings' => false],
                        ],
                        'Middle Center area' => [
                            'menu' => ['title' => esc_html__('Menu', 'burido'), 'settings' => false],
                        ],
                        'Middle Right area' => [
                            'item_search' => ['title' => esc_html__('Search', 'burido'), 'settings' => true],
                            'spacer2' => ['title' => esc_html__('Spacer 2', 'burido'), 'settings' => true],
                        ],
                        'Bottom Left area' => [],
                        'Bottom Center area' => [],
                        'Bottom Right area' => [],
                    ],
                ],
                [
                    'id' => 'bottom_header_spacer1',
                    'title' => esc_html__('Header Spacer 1 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 40],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_spacer2',
                    'title' => esc_html__('Header Spacer 2 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 40],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_spacer3',
                    'title' => esc_html__('Header Spacer 3 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_spacer4',
                    'title' => esc_html__('Header Spacer 4 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_spacer5',
                    'title' => esc_html__('Header Spacer 5 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'height' => false,
                    'width' => true,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_spacer6',
                    'title' => esc_html__('Header Spacer 6 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'height' => false,
                    'width' => true,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_spacer7',
                    'title' => esc_html__('Header Spacer 7 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_spacer8',
                    'title' => esc_html__('Header Spacer 8 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_item_search_custom',
                    'title' => esc_html__('Customize Search', 'burido'),
                    'type' => 'switch',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_item_search_color_txt',
                    'title' => esc_html__('Icon Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_item_search_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_item_search_hover_color_txt',
                    'title' => esc_html__('Hover Icon Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_item_search_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_cart_custom',
                    'title' => esc_html__('Customize cart', 'burido'),
                    'type' => 'switch',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_cart_color_txt',
                    'title' => esc_html__('Icon Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_cart_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_cart_hover_color_txt',
                    'title' => esc_html__('Hover Icon Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_cart_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter1_height',
                    'title' => esc_html__('Delimiter Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 50],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter1_width',
                    'title' => esc_html__('Delimiter Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 1],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter1_bg',
                    'title' => esc_html__('Delimiter Background', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#000000',
                        'alpha' => '0.1',
                        'rgba' => 'rgba(0, 0, 0, 0.1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter1_margin',
                    'title' => esc_html__('Delimiter Spacing', 'burido'),
                    'type' => 'spacing',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => false,
                    'top' => false,
                    'left' => true,
                    'right' => true,
                    'default' => [
                        'margin-left' => '20',
                        'margin-right' => '30',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter2_height',
                    'title' => esc_html__('Delimiter Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'height' => true,
                    'width' => false,
                    'default' => ['height' => 100],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter2_width',
                    'title' => esc_html__('Delimiter Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'height' => false,
                    'width' => true,
                    'default' => ['width' => 1],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter2_bg',
                    'title' => esc_html__('Delimiter Background', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '.9',
                        'rgba' => 'rgba(255,255,255,0.9)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter2_margin',
                    'title' => esc_html__('Delimiter Spacing', 'burido'),
                    'type' => 'spacing',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => false,
                    'top' => false,
                    'left' => true,
                    'right' => true,
                    'default' => [
                        'margin-left' => '30',
                        'margin-right' => '30',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter3_height',
                    'title' => esc_html__('Delimiter Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 100],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter3_width',
                    'title' => esc_html__('Delimiter Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 1],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter3_bg',
                    'title' => esc_html__('Delimiter Background', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '.9',
                        'rgba' => 'rgba(255,255,255,0.9)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter3_margin',
                    'title' => esc_html__('Delimiter Spacing', 'burido'),
                    'type' => 'spacing',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => false,
                    'top' => false,
                    'left' => true,
                    'right' => true,
                    'default' => [
                        'margin-left' => '30',
                        'margin-right' => '30',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter4_height',
                    'title' => esc_html__('Delimiter Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 100],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter4_width',
                    'title' => esc_html__('Delimiter Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'height' => false,
                    'width' => true,
                    'default' => ['width' => 1],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter4_bg',
                    'title' => esc_html__('Delimiter Background', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '.9',
                        'rgba' => 'rgba(255,255,255,0.9)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter4_margin',
                    'title' => esc_html__('Delimiter Spacing', 'burido'),
                    'type' => 'spacing',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => false,
                    'top' => false,
                    'left' => true,
                    'right' => true,
                    'default' => [
                        'margin-left' => '30',
                        'margin-right' => '30',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter5_height',
                    'title' => esc_html__('Delimiter Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 100],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter5_width',
                    'title' => esc_html__('Delimiter Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'height' => false,
                    'width' => true,
                    'default' => ['width' => 1],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter5_bg',
                    'title' => esc_html__('Delimiter Background', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '.9',
                        'rgba' => 'rgba(255,255,255,0.9)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter5_margin',
                    'title' => esc_html__('Delimiter Spacing', 'burido'),
                    'type' => 'spacing',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => false,
                    'top' => false,
                    'left' => true,
                    'right' => true,
                    'default' => [
                        'margin-left' => '30',
                        'margin-right' => '30',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter6_height',
                    'title' => esc_html__('Delimiter Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'height' => true,
                    'width' => false,
                    'default' => ['height' => 100],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter6_width',
                    'title' => esc_html__('Delimiter Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_building_tool', '=', 'default'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 1],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter6_bg',
                    'title' => esc_html__('Delimiter Background', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '.9',
                        'rgba' => 'rgba(255,255,255,0.9)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_delimiter6_margin',
                    'title' => esc_html__('Delimiter Spacing', 'burido'),
                    'type' => 'spacing',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => false,
                    'top' => false,
                    'left' => true,
                    'right' => true,
                    'default' => [
                        'margin-left' => '30',
                        'margin-right' => '30',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_title',
                    'title' => esc_html__('Button Text', 'burido'),
                    'type' => 'text',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => esc_html__('Contact Us', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_link',
                    'title' => esc_html__('Link', 'burido'),
                    'type' => 'text',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => '#',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_target',
                    'title' => esc_html__('Open link in a new tab', 'burido'),
                    'type' => 'switch',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_size',
                    'title' => esc_html__('Button Size', 'burido'),
                    'type' => 'select',
                    'required' => ['header_building_tool', '=', 'default'],
                    'options' => [
                        'sm' => esc_html__('Small', 'burido'),
                        'md' => esc_html__('Medium', 'burido'),
                        'lg' => esc_html__('Large', 'burido'),
                        'xl' => esc_html__('Extra Large', 'burido'),
                    ],
                    'default' => 'md',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_radius',
                    'title' => esc_html__('Button Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => ['header_building_tool', '=', 'default'],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_custom',
                    'title' => esc_html__('Customize Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_color_txt',
                    'title' => esc_html__('Text Color Idle', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_hover_color_txt',
                    'title' => esc_html__('Text Color Hover', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_bg',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_hover_bg',
                    'title' => esc_html__('Hover Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_border',
                    'title' => esc_html__('Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button1_hover_border',
                    'title' => esc_html__('Hover Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_title',
                    'title' => esc_html__('Button Text', 'burido'),
                    'type' => 'text',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => esc_html__('Contact Us', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_link',
                    'title' => esc_html__('Link', 'burido'),
                    'type' => 'text',
                    'required' => ['header_building_tool', '=', 'default'],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_target',
                    'title' => esc_html__('Open link in a new tab', 'burido'),
                    'type' => 'switch',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_size',
                    'title' => esc_html__('Button Size', 'burido'),
                    'type' => 'select',
                    'required' => ['header_building_tool', '=', 'default'],
                    'options' => [
                        'sm' => esc_html__('Small', 'burido'),
                        'md' => esc_html__('Medium', 'burido'),
                        'lg' => esc_html__('Large', 'burido'),
                        'xl' => esc_html__('Extra Large', 'burido'),
                    ],
                    'default' => 'md',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_radius',
                    'title' => esc_html__('Button Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => ['header_building_tool', '=', 'default'],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_custom',
                    'title' => esc_html__('Customize Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['header_building_tool', '=', 'default'],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_color_txt',
                    'title' => esc_html__('Text Color Idle', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_hover_color_txt',
                    'title' => esc_html__('Text Color Hover', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_bg',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_hover_bg',
                    'title' => esc_html__('Hover Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_border',
                    'title' => esc_html__('Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_button2_hover_border',
                    'title' => esc_html__('Hover Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['bottom_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_profile_format',
                    'title' => esc_html__('Profile Format', 'burido'),
                    'type' => 'select',
                    'required' => ['header_building_tool', '=', 'default'],
                    'options' => [
                        'none' => esc_html__('None', 'burido'),
                        'def' => esc_html__('Default', 'burido'),
                        'username' => esc_html__('Username', 'burido'),
                        'display_name' => esc_html__('Public', 'burido'),
                    ],
                    'default' => 'def'
                ],
                [
                    'id' => 'bottom_header_bar_html1_editor',
                    'title' => esc_html__('HTML Element 1 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_bar_html2_editor',
                    'title' => esc_html__('HTML Element 2 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_bar_html3_editor',
                    'title' => esc_html__('HTML Element 3 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_bar_html4_editor',
                    'title' => esc_html__('HTML Element 4 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_bar_html5_editor',
                    'title' => esc_html__('HTML Element 5 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_bar_html6_editor',
                    'title' => esc_html__('HTML Element 6 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_bar_html7_editor',
                    'title' => esc_html__('HTML Element 7 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_bar_html8_editor',
                    'title' => esc_html__('HTML Element 8 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'html',
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_side_panel_color',
                    'title' => esc_html__('Icon Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(38,38,38,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'bottom_header_side_panel_background',
                    'title' => esc_html__('Background Icon', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_building_tool', '=', 'default'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '0',
                        'rgba' => 'rgba(255,255,255,0)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top-start',
                    'title' => esc_html__('Header Top Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_full_width',
                    'title' => esc_html__('Full Width Header', 'burido'),
                    'type' => 'switch',
                    'subtitle' => esc_html__('Set header content in full width', 'burido'),
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_max_width_custom',
                    'title' => esc_html__('Limit the Max Width of Container', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_max_width',
                    'title' => esc_html__('Max Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_top_max_width_custom', '=', '1'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 1290],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_height',
                    'title' => esc_html__('Header Top Height', 'burido'),
                    'type' => 'dimensions',
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 49],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_background_image',
                    'title' => esc_html__('Header Top Background Image', 'burido'),
                    'type' => 'media',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_background',
                    'title' => esc_html__('Header Top Background', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,0)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_color',
                    'title' => esc_html__('Header Top Text Color', 'burido'),
                    'type' => 'color',
                    'transparent' => false,
                    'default' => '#181818',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_bottom_border',
                    'type' => 'switch',
                    'title' => esc_html__('Set Header Top Bottom Border', 'burido'),
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_border_height',
                    'title' => esc_html__('Header Top Border Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_top_bottom_border', '=', '1'],
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => '1'],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top_bottom_border_color',
                    'title' => esc_html__('Header Top Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_top_bottom_border', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '.2',
                        'rgba' => 'rgba(162,162,162,0.2)',
                        'color' => '#a2a2a2',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_top-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle-start',
                    'title' => esc_html__('Header Middle Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_full_width',
                    'type' => 'switch',
                    'title' => esc_html__('Full Width Middle Header', 'burido'),
                    'subtitle' => esc_html__('Set header content in full width', 'burido'),
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_max_width_custom',
                    'title' => esc_html__('Limit the Max Width of Container', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_max_width',
                    'title' => esc_html__('Max Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_middle_max_width_custom', '=', '1'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 1290],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_height',
                    'title' => esc_html__('Header Middle Height', 'burido'),
                    'type' => 'dimensions',
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 80],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_background_image',
                    'title' => esc_html__('Header Middle Background Image', 'burido'),
                    'type' => 'media',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_background',
                    'title' => esc_html__('Header Middle Background', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_color',
                    'title' => esc_html__('Header Middle Text Color', 'burido'),
                    'type' => 'color',
                    'transparent' => false,
                    'default' => '#181818',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_bottom_border',
                    'title' => esc_html__('Set Header Middle Bottom Border', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_border_height',
                    'title' => esc_html__('Header Middle Border Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_middle_bottom_border', '=', '1'],
                    'height' => true,
                    'width' => false,
                    'default' => ['height' => '1'],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle_bottom_border_color',
                    'title' => esc_html__('Header Middle Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_middle_bottom_border', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(245,245,245,1)',
                        'color' => '#f5f5f5',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_middle-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom-start',
                    'title' => esc_html__('Header Bottom Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_full_width',
                    'title' => esc_html__('Full Width Bottom Header', 'burido'),
                    'type' => 'switch',
                    'subtitle' => esc_html__('Set header content in full width', 'burido'),
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_max_width_custom',
                    'title' => esc_html__('Limit the Max Width of Container', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_max_width',
                    'title' => esc_html__('Max Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_bottom_max_width_custom', '=', '1'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 1290],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_height',
                    'title' => esc_html__('Header Bottom Height', 'burido'),
                    'type' => 'dimensions',
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 100],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_background_image',
                    'title' => esc_html__('Header Bottom Background Image', 'burido'),
                    'type' => 'media',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_background',
                    'title' => esc_html__('Header Bottom Background', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '.9',
                        'rgba' => 'rgba(255,255,255,0.9)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_color',
                    'title' => esc_html__('Header Bottom Text Color', 'burido'),
                    'type' => 'color',
                    'transparent' => false,
                    'default' => '#181818',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_bottom_border',
                    'title' => esc_html__('Set Header Bottom Border', 'burido'),
                    'type' => 'switch',
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_border_height',
                    'title' => esc_html__('Header Bottom Border Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['header_bottom_bottom_border', '=', '1'],
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => '1'],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom_bottom_border_color',
                    'title' => esc_html__('Header Bottom Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['header_bottom_bottom_border', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,0.2)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_bottom-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-left-start',
                    'title' => esc_html__('Top Left Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_left_horz',
                    'type' => 'button_set',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_left_vert',
                    'type' => 'button_set',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_left_display',
                    'type' => 'button_set',
                    'title' => esc_html__('Display', 'burido'),
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-left-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-center-start',
                    'title' => esc_html__('Top Center Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_center_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_center_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_center_display',
                    'title' => esc_html__('Display', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-center-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-center-start',
                    'title' => esc_html__('Top Center Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_center_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_center_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_center_display',
                    'title' => esc_html__('Display', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-center-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-right-start',
                    'title' => esc_html__('Top Right Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_right_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'right',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_right_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_top_right_display',
                    'title' => esc_html__('Display', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-top-right-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-middle-left-start',
                    'title' => esc_html__('Middle Left Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_left_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_left_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_left_display',
                    'title' => esc_html__('Display', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-middle-left-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-middle-center-start',
                    'title' => esc_html__('Middle Center Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_center_horz',
                    'type' => 'button_set',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'center',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_center_vert',
                    'type' => 'button_set',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_center_display',
                    'title' => esc_html__('Display', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-middle-center-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-middle-right-start',
                    'title' => esc_html__('Middle Right Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_right_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'right',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_right_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_middle_right_display',
                    'type' => 'button_set',
                    'title' => esc_html__('Display', 'burido'),
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-middle-right-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-bottom-left-start',
                    'title' => esc_html__('Bottom Left Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_left_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_left_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_left_display',
                    'title' => esc_html__('Display', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-bottom-left-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-bottom-center-start',
                    'type' => 'section',
                    'title' => esc_html__('Bottom Center Column Options', 'burido'),
                    'indent' => true,
                    'required' => ['header_building_tool', '=', 'default'],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_center_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_center_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_center_display',
                    'type' => 'button_set',
                    'title' => esc_html__('Display', 'burido'),
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-bottom-center-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-bottom-right-start',
                    'title' => esc_html__('Bottom Right Column Options', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_right_horz',
                    'title' => esc_html__('Horizontal Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'right',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_right_vert',
                    'title' => esc_html__('Vertical Align', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'top' => esc_html__('Top', 'burido'),
                        'middle' => esc_html__('Middle', 'burido'),
                        'bottom' => esc_html__('Bottom', 'burido'),
                    ],
                    'default' => 'middle',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column_bottom_right_display',
                    'title' => esc_html__('Display', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'normal' => esc_html__('Normal', 'burido'),
                        'grow' => esc_html__('Grow', 'burido'),
                    ],
                    'default' => 'normal',
                    'customizer' => false,
                ],
                [
                    'id' => 'header_column-bottom-right-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_row_settings-start',
                    'title' => esc_html__('Header Settings', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'default'],
                    'indent' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_shadow',
                    'title' => esc_html__('Header Bottom Shadow', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_on_bg',
                    'title' => esc_html__('Over content', 'burido'),
                    'type' => 'switch',
                    'subtitle' => esc_html__('Display header template over the content.', 'burido'),
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'lavalamp_active',
                    'type' => 'switch',
                    'title' => esc_html__('Lavalamp Marker', 'burido'),
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'marker_active',
                    'type' => 'switch',
                    'title' => esc_html__('Marker', 'burido'),
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'sub_menu_background',
                    'type' => 'color_rgba',
                    'title' => esc_html__('Sub Menu Background', 'burido'),
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'sub_menu_color',
                    'title' => esc_html__('Sub Menu Text Color', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_mobile_queris',
                    'title' => esc_html__('Mobile Header Switch Breakpoint', 'burido'),
                    'type' => 'slider',
                    'display_value' => 'text',
                    'min' => 400,
                    'max' => 1920,
                    'default' => 1200,
                    'customizer' => false,
                ],
                [
                    'id' => 'header_row_settings-end',
                    'type' => 'section',
                    'indent' => false,
                    'customizer' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'title' => esc_html__('Header Sticky', 'burido'),
            'id' => 'header_builder_sticky',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'header_sticky',
                    'title' => esc_html__('Header Sticky', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                ],
                [
                    'id' => 'header_sticky-start',
                    'title' => esc_html__('Sticky Settings', 'burido'),
                    'type' => 'section',
                    'required' => ['header_sticky', '=', '1'],
                    'indent' => true,
                ],
                [
                    'id' => 'header_sticky_page_select',
                    'title' => esc_html__('Header Sticky Template', 'burido'),
                    'type' => 'select',
                    'required' => ['header_sticky', '=', '1'],
                    'desc' => sprintf(
                        '%s <a href="%s" target="_blank">%s</a> %s',
                        esc_html__('Selected Template will be used for all pages by default. You can edit/create Header Template in the', 'burido'),
                        admin_url('edit.php?post_type=header'),
                        esc_html__('Header Templates', 'burido'),
                        esc_html__('dashboard tab.', 'burido')
                    ),
                    'data' => 'posts',
                    'args' => [
                        'post_type' => 'header',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ],
                ],
                [
                    'id' => 'header_sticky_style',
                    'type' => 'select',
                    'title' => esc_html__('Appearance', 'burido'),
                    'options' => [
                        'standard' => esc_html__('Always Visible', 'burido'),
                        'scroll_up' => esc_html__('Visible while scrolling upwards', 'burido'),
                    ],
                    'default' => 'scroll_up',
                    'required' => ['header_sticky', '=', '1'],
                ],
                [
                    'id' => 'header_sticky-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'title' => esc_html__('Header Mobile', 'burido'),
            'id' => 'header_builder_mobile',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'mobile_header',
                    'title' => esc_html__('Mobile Header', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Custom', 'burido'),
                    'off' => esc_html__('Default', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'mobile_header_building_tool',
                    'title' => esc_html__('Mobile Header Tool', 'burido'),
                    'type' => 'select',
                    'options' => [
                        'default' => esc_html__('WGL Header (Deprecated)', 'burido'),
                        'elementor' => esc_html__('Header Templates (Recommended)', 'burido')
                    ],
                    'desc' => sprintf(
                        wp_kses(
                            __('<a href="%s" target="_blank">Elementor\'s Header Template</a> tool allows you to design a single header for both desktop and mobile screens using its responsive design features', 'burido'),
                            ['a' => ['href' => true, 'target' => true]]
                        ),
                        esc_url(admin_url('edit.php?post_type=header'))
                    ),
                    'default' => 'default',
                    'required' => [
                        ['mobile_header', '=', '1']
                    ],
                ],
                [
                    'id' => 'mobile_drawer_header_building_tool',
                    'title' => esc_html__('Mobile Drawer Tool', 'burido'),
                    'type' => 'select',
                    'options' => [
                        'default' => esc_html__('WGL Builder (Deprecated)', 'burido'),
                        'elementor' => esc_html__('Elementor Templates (Recommended)', 'burido')
                    ],
                    'default' => 'default',
                    'required' => [
                        ['mobile_header', '=', '1']
                    ],
                ],
                [
                    'id' => 'mobile_drawer_header_page_select',
                    'type' => 'select',
                    'title' => esc_html__('Drawer template', 'burido'),
                    'desc' => sprintf(
                        wp_kses(
                            __('Area for placing a mobile menu. You can edit/create it in <a href="%s" target="_blank">Templates->WGL Mobile Drawer</a>', 'burido'),
                            ['a' => ['href' => true, 'target' => true]]
                        ),
                        esc_url(admin_url('edit.php?post_type=elementor_library&tabs_group=library&elementor_library_type=wgl-mobile-drawer'))
                    ),
                    'required' => ['mobile_drawer_header_building_tool', '=', 'elementor'],
                    'data' => 'posts',
                    'args' => [
                        'post_type' => 'elementor_library',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'meta_query' => [
                            [
                                'key' => '_elementor_template_type',
                                'value' => 'wgl-mobile-drawer',
                            ],
                        ],
                    ],
                ],
                [
                    'id' => 'header_mobile_appearance-start',
                    'title' => esc_html__('Appearance', 'burido'),
                    'type' => 'section',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'indent' => true,
                ],
                [
                    'id' => 'header_mobile_height',
                    'title' => esc_html__('Header Height', 'burido'),
                    'type' => 'dimensions',
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => '60'],
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'header_mobile_full_width',
                    'title' => esc_html__('Full Width Header', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_sticky',
                    'title' => esc_html__('Mobile Sticky Header', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_over_content',
                    'title' => esc_html__('Header Over Content', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_background',
                    'title' => esc_html__('Header Background', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_color',
                    'title' => esc_html__('Header Text Color', 'burido'),
                    'type' => 'color',
                    'transparent' => false,
                    'default' => '#ffffff',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_border_color',
                    'title' => esc_html__('Header Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '0.2',
                        'rgba' => 'rgba(131,131,131,0.2)',
                        'color' => '#838383',
                    ],
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'header_mobile_appearance-end',
                    'type' => 'section',
                    'indent' => false,
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'header_mobile_menu-start',
                    'title' => esc_html__('Menu', 'burido'),
                    'type' => 'section',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'indent' => true,
                ],
                [
                    'id' => 'mobile_position',
                    'title' => esc_html__('Menu Occurrence', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                ],
                [
                    'id' => 'custom_mobile_menu',
                    'title' => esc_html__('Custom Mobile Menu', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                ],
                [
                    'id' => 'mobile_menu',
                    'type' => 'select',
                    'title' => esc_html__('Mobile Menu', 'burido'),
                    'required' => ['custom_mobile_menu', '=', '1'],
                    'select2' => ['allowClear' => false],
                    'options' => $menus = wgl_get_custom_menu(),
                    'default' => reset($menus),
                ],
                [
                    'id' => 'mobile_sub_menu_color',
                    'title' => esc_html__('Menu Text Color', 'burido'),
                    'type' => 'color',
                    'transparent' => false,
                    'default' => '#ffffff',
                ],
                [
                    'id' => 'mobile_sub_menu_color_active',
                    'title' => esc_html__('Active Menu Text Color', 'burido'),
                    'type' => 'color',
                    'transparent' => false,
                    'default' => '#8088E6',
                ],
                [
                    'id' => 'mobile_sub_menu_background',
                    'title' => esc_html__('Menu Background', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                ],
                [
                    'id' => 'mobile_sub_menu_overlay',
                    'title' => esc_html__('Menu Overlay', 'burido'),
                    'type' => 'color_rgba',
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,0.8)',
                        'color' => '#181818',
                    ],
                ],
                [
                    'id' => 'header_mobile_menu-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'mobile_header_layout',
                    'title' => esc_html__('Mobile Builder', 'burido'),
                    'type' => 'custom_header_mobile_builder',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Organize the layout of the mobile header', 'burido'),
                    'compiler' => 'true',
                    'full_width' => true,
                    'options' => [
                        'items' => $header_builder_items['mobile'],
                        'Left area' => [
                            'menu' => ['title' => esc_html__('Hamburger Menu', 'burido'), 'settings' => false],
                        ],
                        'Center area' => [
                            'logo' => ['title' => esc_html__('Logo', 'burido'), 'settings' => false],
                        ],
                        'Right area' => [
                            'cart' => ['title' => esc_html__('Cart', 'burido'), 'settings' => true],
                        ],
                    ],
                    'default' => [
                        'items' => $header_builder_items['mobile'],
                        'Left area' => [
                            'menu' => ['title' => esc_html__('Hamburger Menu', 'burido'), 'settings' => false],
                        ],
                        'Center area' => [
                            'logo' => ['title' => esc_html__('Logo', 'burido'), 'settings' => false],
                        ],
                        'Right area' => [
                            'cart' => ['title' => esc_html__('Cart', 'burido'), 'settings' => true],
                        ],
                    ],
                ],
                [
                    'id' => 'mobile_header_bar_html1_editor',
                    'title' => esc_html__('HTML Element 1 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_bar_html2_editor',
                    'title' => esc_html__('HTML Element 2 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_bar_html3_editor',
                    'title' => esc_html__('HTML Element 3 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_bar_html4_editor',
                    'title' => esc_html__('HTML Element 4 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_bar_html5_editor',
                    'title' => esc_html__('HTML Element 5 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_bar_html6_editor',
                    'title' => esc_html__('HTML Element 6 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_spacer1',
                    'title' => esc_html__('Spacer 1 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_spacer2',
                    'title' => esc_html__('Spacer 2 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_spacer3',
                    'title' => esc_html__('Spacer 3 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_spacer4',
                    'title' => esc_html__('Spacer 4 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_spacer5',
                    'title' => esc_html__('Spacer 5 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_spacer6',
                    'title' => esc_html__('Spacer 6 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_socials_font_size',
                    'title' => esc_html__('Font Size', 'burido'),
                    'type' => 'dimensions',
                    'width' => false,
                    'height' => true,
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_socials_space',
                    'title' => esc_html__('Space Between', 'burido'),
                    'type' => 'dimensions',
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => '10'],
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id'       => 'mobile_header_socials_target',
                    'type'     => 'checkbox',
                    'title'    => esc_html__('Open in new window', 'burido'),
                    'default'  => '1',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_socials_padding',
                    'title' => esc_html__('Padding', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'all' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_socials_radius',
                    'title' => esc_html__('Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id'         => 'mobile_header_socials',
                    'type'       => 'social_profiles',
                    'title'  => esc_html__('Social Links', 'burido'),
                    'subtitle'   => esc_html__('Click an icon to activate it, drag and drop to change the icon order.', 'burido'),
                    'customizer' => false,
                    'include'    => ['facebook', 'twitter', 'linkedin', 'google-plus', 'dribbble', 'flickr', 'instagram', 'pinterest', 'skype', 'tumblr', 'youtube', 'spotify', 'telegram', 'whatsapp'],
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_header_button1_title',
                    'title' => esc_html__('Button Text', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'default' => esc_html__('Contact Us', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_link',
                    'title' => esc_html__('Link', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'default' => '#',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_target',
                    'title' => esc_html__('Open link in a new tab', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_size',
                    'title' => esc_html__('Button Size', 'burido'),
                    'type' => 'select',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'options' => [
                        'sm' => esc_html__('Small', 'burido'),
                        'md' => esc_html__('Medium', 'burido'),
                        'lg' => esc_html__('Large', 'burido'),
                        'xl' => esc_html__('Extra Large', 'burido'),
                    ],
                    'default' => 'md',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_radius',
                    'title' => esc_html__('Button Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_custom',
                    'title' => esc_html__('Customize Button', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_color_txt',
                    'title' => esc_html__('Text Color Idle', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_hover_color_txt',
                    'title' => esc_html__('Text Color Hover', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_bg',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_hover_bg',
                    'title' => esc_html__('Hover Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_border',
                    'title' => esc_html__('Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button1_hover_border',
                    'title' => esc_html__('Hover Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_title',
                    'title' => esc_html__('Button Text', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'default' => esc_html__('Contact Us', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_link',
                    'title' => esc_html__('Link', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_target',
                    'title' => esc_html__('Open link in a new tab', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_size',
                    'title' => esc_html__('Button Size', 'burido'),
                    'type' => 'select',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'options' => [
                        'sm' => esc_html__('Small', 'burido'),
                        'md' => esc_html__('Medium', 'burido'),
                        'lg' => esc_html__('Large', 'burido'),
                        'xl' => esc_html__('Extra Large', 'burido'),
                    ],
                    'default' => 'md',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_radius',
                    'title' => esc_html__('Button Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_custom',
                    'title' => esc_html__('Customize Button', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_color_txt',
                    'title' => esc_html__('Text Color Idle', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_hover_color_txt',
                    'title' => esc_html__('Text Color Hover', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_bg',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_hover_bg',
                    'title' => esc_html__('Hover Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_border',
                    'title' => esc_html__('Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_header_button2_hover_border',
                    'title' => esc_html__('Hover Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'header_mobile_drawer-start',
                    'type' => 'section',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                    'indent' => true,
                ],
                [
                    'id' => 'header_mobile_drawer-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'mobile_content_header_layout',
                    'title' => esc_html__('Mobile Drawer Content', 'burido'),
                    'type' => 'custom_header_mobile_builder',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Organize the layout of the mobile header', 'burido'),
                    'compiler' => 'true',
                    'full_width' => true,
                    'options' => [
                        'items' => $header_builder_items['mobile_drawer'],
                        'Left area' => [
                            'logo' => ['title' => esc_html__('Logo', 'burido'), 'settings' => false],
                            'menu' => ['title' => esc_html__('Menu', 'burido'), 'settings' => false],
                            'item_search' => ['title' => esc_html__('Search', 'burido'), 'settings' => false],
                        ],
                    ],
                    'default' => [
                        'items' => $header_builder_items['mobile_drawer'],
                        'Left area' => [
                            'logo' => ['title' => esc_html__('Logo', 'burido'), 'settings' => false],
                            'menu' => ['title' => esc_html__('Menu', 'burido'), 'settings' => false],
                            'item_search' => ['title' => esc_html__('Search', 'burido'), 'settings' => false],
                        ],
                    ],
                ],
                [
                    'id' => 'mobile_drawer_header_bar_html1_editor',
                    'title' => esc_html__('HTML Element 1 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_bar_html2_editor',
                    'title' => esc_html__('HTML Element 2 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_bar_html3_editor',
                    'title' => esc_html__('HTML Element 3 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_bar_html4_editor',
                    'title' => esc_html__('HTML Element 4 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_bar_html5_editor',
                    'title' => esc_html__('HTML Element 5 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_bar_html6_editor',
                    'title' => esc_html__('HTML Element 6 Editor', 'burido'),
                    'type' => 'ace_editor',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'mode' => 'html',
                    'default' => '',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_spacer1',
                    'title' => esc_html__('Spacer 1 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_spacer2',
                    'title' => esc_html__('Spacer 2 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_spacer3',
                    'title' => esc_html__('Spacer 3 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_spacer4',
                    'title' => esc_html__('Spacer 4 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_spacer5',
                    'title' => esc_html__('Spacer 5 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_spacer6',
                    'title' => esc_html__('Spacer 6 Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 25],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_socials_font_size',
                    'title' => esc_html__('Font Size', 'burido'),
                    'type' => 'dimensions',
                    'width' => false,
                    'height' => true,
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_socials_space',
                    'title' => esc_html__('Space Between', 'burido'),
                    'type' => 'dimensions',
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => '10'],
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id'       => 'mobile_drawer_header_socials_target',
                    'type'     => 'checkbox',
                    'title'    => esc_html__('Open in new window', 'burido'),
                    'default'  => '1',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_socials_padding',
                    'title' => esc_html__('Padding', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'all' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_socials_radius',
                    'title' => esc_html__('Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id'        => 'mobile_drawer_header_socials',
                    'type'      => 'social_profiles',
                    'title'  => esc_html__('Social Links', 'burido'),
                    'subtitle'  => esc_html__('Click an icon to activate it, drag and drop to change the icon order.', 'burido'),
                    'customizer' => false,
                    'include'    => ['facebook', 'twitter', 'linkedin', 'google-plus', 'dribbble', 'flickr', 'instagram', 'pinterest', 'skype', 'tumblr', 'youtube', 'spotify', 'telegram', 'whatsapp'],
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_drawer_header_button1_title',
                    'title' => esc_html__('Button Text', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'default' => esc_html__('Contact Us', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_link',
                    'title' => esc_html__('Link', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'default' => '#',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_target',
                    'title' => esc_html__('Open link in a new tab', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_size',
                    'title' => esc_html__('Button Size', 'burido'),
                    'type' => 'select',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'options' => [
                        'sm' => esc_html__('Small', 'burido'),
                        'md' => esc_html__('Medium', 'burido'),
                        'lg' => esc_html__('Large', 'burido'),
                        'xl' => esc_html__('Extra Large', 'burido'),
                    ],
                    'default' => 'md',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_radius',
                    'title' => esc_html__('Button Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_custom',
                    'title' => esc_html__('Customize Button', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_color_txt',
                    'title' => esc_html__('Text Color Idle', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_hover_color_txt',
                    'title' => esc_html__('Text Color Hover', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_bg',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_hover_bg',
                    'title' => esc_html__('Hover Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_border',
                    'title' => esc_html__('Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button1_hover_border',
                    'title' => esc_html__('Hover Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button1_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'color' => '#181818',
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)'
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_title',
                    'title' => esc_html__('Button Text', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'default' => esc_html__('Contact Us', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_link',
                    'title' => esc_html__('Link', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_target',
                    'title' => esc_html__('Open link in a new tab', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'default' => true,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_size',
                    'title' => esc_html__('Button Size', 'burido'),
                    'type' => 'select',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'options' => [
                        'sm' => esc_html__('Small', 'burido'),
                        'md' => esc_html__('Medium', 'burido'),
                        'lg' => esc_html__('Large', 'burido'),
                        'xl' => esc_html__('Extra Large', 'burido'),
                    ],
                    'default' => 'md',
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_radius',
                    'title' => esc_html__('Button Border Radius', 'burido'),
                    'type' => 'text',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'desc' => esc_html__('Value in pixels.', 'burido'),
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_custom',
                    'title' => esc_html__('Customize Button', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['mobile_header', '=', '1'],
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                    'default' => false,
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_color_txt',
                    'title' => esc_html__('Text Color Idle', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_hover_color_txt',
                    'title' => esc_html__('Text Color Hover', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_bg',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_hover_bg',
                    'title' => esc_html__('Hover Background Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(255,255,255,1)',
                        'color' => '#ffffff',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_border',
                    'title' => esc_html__('Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
                [
                    'id' => 'mobile_drawer_header_button2_hover_border',
                    'title' => esc_html__('Hover Border Color', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['mobile_drawer_header_button2_custom', '=', '1'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                    'customizer' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'logo',
            'title' => esc_html__('Logo', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'header_logo',
                    'title' => esc_html__('Default Header Logo', 'burido'),
                    'type' => 'media',
                ],
                [
                    'id' => 'logo_height_custom',
                    'title' => esc_html__('Limit Default Logo Height', 'burido'),
                    'type' => 'switch',
                    'required' => ['header_logo', '!=', ''],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'logo_height',
                    'title' => esc_html__('Default Logo Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['logo_height_custom', '=', '1'],
                    'height' => true,
                    'width' => false,
                    'default' => ['height' => 90],
                ],
                [
                    'id' => 'sticky_header_logo',
                    'title' => esc_html__('Sticky Header Logo', 'burido'),
                    'type' => 'media',
                    'required' => [
                        ['header_building_tool', '=', 'default'],
                        ['header_sticky_page_select', '=', '']
                    ],
                ],
                [
                    'id' => 'sticky_logo_height_custom',
                    'title' => esc_html__('Limit Sticky Logo Height', 'burido'),
                    'type' => 'switch',
                    'required' => ['sticky_header_logo', '!=', ''],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'sticky_logo_height',
                    'title' => esc_html__('Sticky Header Logo Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['sticky_logo_height_custom', '=', '1'],
                    'height' => true,
                    'width' => false,
                    'default' => ['height' => 90],
                ],
                [
                    'id' => 'logo_mobile',
                    'title' => esc_html__('Mobile Header Logo', 'burido'),
                    'type' => 'media',
                    'required' => [
                        ['mobile_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_logo_height_custom',
                    'title' => esc_html__('Limit Mobile Logo Height', 'burido'),
                    'type' => 'switch',
                    'required' => ['logo_mobile', '!=', ''],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'mobile_logo_height',
                    'title' => esc_html__('Mobile Logo Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['mobile_logo_height_custom', '=', '1'],
                    'height' => true,
                    'width' => false,
                    'default' => ['height' => 60],
                ],
                [
                    'id' => 'logo_mobile_menu',
                    'title' => esc_html__('Mobile Menu Logo', 'burido'),
                    'type' => 'media',
                    'required' => [
                        ['mobile_drawer_header_building_tool', '=', 'default'],
                    ],
                ],
                [
                    'id' => 'mobile_logo_menu_height_custom',
                    'title' => esc_html__('Limit Mobile Menu Logo Height', 'burido'),
                    'type' => 'switch',
                    'required' => ['logo_mobile_menu', '!=', ''],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'mobile_logo_menu_height',
                    'title' => esc_html__('Mobile Menu Logo Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['mobile_logo_menu_height_custom', '=', '1'],
                    'height' => true,
                    'width' => false,
                    'default' => ['height' => 60],
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'page_title',
            'title' => esc_html__('Page Title', 'burido'),
            'icon' => 'el el-home-alt',
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'page_title_settings',
            'title' => esc_html__('General', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'page_title_switch',
                    'title' => esc_html__('Use Page Titles?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'page_title-start',
                    'title' => esc_html__('Appearance', 'burido'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', '1'],
                    'indent' => true,
                ],
                [
                    'id' => 'page_title_bg_switch',
                    'title' => esc_html__('Use Background Image/Color?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'page_title_bg_image',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'required' => ['page_title_bg_switch', '=', true],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => true,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center bottom',
                        'background-color' => '#F5F5F5',
                    ],
                ],
                [
                    'id' => 'page_title_height',
                    'title' => esc_html__('Min Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['page_title_bg_switch', '=', true],
                    'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'burido'),
                    'width' => false,
                    'height' => true,
                    'default' => ['height' => 400],
                ],
                [
                    'id' => 'page_title_padding',
                    'title' => esc_html__('Paddings Top/Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'all' => false,
                    'bottom' => true,
                    'top' => true,
                    'left' => false,
                    'right' => false,
                    'default' => [
                        'padding-top' => '70',
                        'padding-bottom' => '50',
                    ],
                ],
                [
                    'id' => 'page_title_margin',
                    'title' => esc_html__('Margin Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => true,
                    'top' => false,
                    'left' => false,
                    'right' => false,
                    'default' => ['margin-bottom' => '50'],
                ],
                [
                    'id' => 'page_title_align',
                    'title' => esc_html__('Title Alignment', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'center',
                ],
                [
                    'id' => 'page_title_breadcrumbs_switch',
                    'title' => esc_html__('Breadcrumbs', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'page_title_breadcrumbs_block_switch',
                    'title' => esc_html__('Breadcrumbs Full Width', 'burido'),
                    'type' => 'switch',
                    'required' => ['page_title_breadcrumbs_switch', '=', true],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'page_title_breadcrumbs_align',
                    'title' => esc_html__('Breadcrumbs Alignment', 'burido'),
                    'type' => 'button_set',
                    'required' => ['page_title_breadcrumbs_block_switch', '=', true],
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'center',
                ],
                [
                    'id' => 'page_title_parallax',
                    'title' => esc_html__('Parallax Effect', 'burido'),
                    'type' => 'switch',
                    'default' => false,
                ],
                [
                    'id' => 'page_title_parallax_speed',
                    'title' => esc_html__('Parallax Speed', 'burido'),
                    'type' => 'slider',
                    'required' => ['page_title_parallax', '=', '1'],
                    'min' => -5,
                    'max' => 5,
                    'step' => 0.1,
                    'default' => 0.3,
                    'resolution'    => 0.1,
                    'display_value' => 'text',
                ],
                [
                    'id' => 'page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'page_title_typography',
            'title' => esc_html__('Typography', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'page_title_font',
                    'title' => esc_html__('Page Title Font', 'burido'),
                    'type' => 'custom_typography',
                    'font-size' => true,
                    'google' => false,
                    'font-weight' => true,
                    'font-family' => false,
                    'font-style' => false,
                    'color' => true,
                    'line-height' => true,
                    'letter-spacing' => true,
                    'font-backup' => false,
                    'text-align' => false,
                    'all_styles' => false,
                    'default' => [
                        'font-weight' => '400',
                        'font-size' => '72px',
                        'line-height' => '84px',
                        'color' => '#181818',
                        'letter-spacing' => '-0.02',
                    ],
                ],
                [
                    'id' => 'page_title_breadcrumbs_font',
                    'title' => esc_html__('Breadcrumbs Font', 'burido'),
                    'type' => 'custom_typography',
                    'font-size' => true,
                    'google' => false,
                    'font-weight' => true,
                    'font-family' => false,
                    'font-style' => false,
                    'color' => true,
                    'line-height' => true,
                    'letter-spacing' => true,
                    'font-backup' => false,
                    'text-align' => false,
                    'all_styles' => false,
                    'default' => [
                        'font-weight' => '600',
                        'font-size' => '14px',
                        'color' => '#181818',
                        'line-height' => '30px',
                        'letter-spacing' => '0',
                    ],
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'title' => esc_html__('Responsive', 'burido'),
            'id' => 'page_title_responsive',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'page_title_resp_switch',
                    'title' => esc_html__('Responsive Settings', 'burido'),
                    'type' => 'switch',
                    'default' => true,
                ],
                [
                    'id' => 'page_title_resp_resolution',
                    'title' => esc_html__('Screen breakpoint', 'burido'),
                    'type' => 'slider',
                    'required' => ['page_title_resp_switch', '=', '1'],
                    'desc' => esc_html__('Use responsive settings on screens smaller then choosed breakpoint.', 'burido'),
                    'display_value' => 'text',
                    'min' => 1,
                    'max' => 1700,
                    'step' => 1,
                    'default' => 1200,
                ],
                [
                    'id' => 'page_title_resp_padding',
                    'title' => esc_html__('Page Title Paddings', 'burido'),
                    'type' => 'spacing',
                    'required' => ['page_title_resp_switch', '=', '1'],
                    'mode' => 'padding',
                    'all' => false,
                    'bottom' => true,
                    'top' => true,
                    'left' => false,
                    'right' => false,
                    'default' => [
                        'padding-top' => '80',
                        'padding-bottom' => '80',
                    ],
                ],
                [
                    'id' => 'page_title_resp_margin',
                    'title' => esc_html__('Margin Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'required' => ['page_title_resp_switch', '=', '1'],
                    'all' => false,
                    'bottom' => true,
                    'top' => false,
                    'left' => false,
                    'right' => false,
                    'default' => ['margin-bottom' => '40'],
                ],
                [
                    'id' => 'page_title_resp_font',
                    'title' => esc_html__('Page Title Font', 'burido'),
                    'type' => 'custom_typography',
                    'required' => ['page_title_resp_switch', '=', '1'],
                    'google' => false,
                    'all_styles' => false,
                    'font-family' => false,
                    'font-style' => false,
                    'font-size' => true,
                    'font-weight' => false,
                    'font-backup' => false,
                    'line-height' => true,
                    'text-align' => false,
                    'color' => true,
                    'default' => [
                        'font-size' => '44px',
                        'line-height' => '48px',
                        'color' => '#181818',
                    ],
                ],
                [
                    'id' => 'page_title_resp_breadcrumbs_switch',
                    'title' => esc_html__('Breadcrumbs', 'burido'),
                    'type' => 'switch',
                    'required' => ['page_title_resp_switch', '=', '1'],
                    'default' => true,
                ],
                [
                    'id' => 'page_title_resp_breadcrumbs_font',
                    'title' => esc_html__('Breadcrumbs Font', 'burido'),
                    'type' => 'custom_typography',
                    'required' => ['page_title_resp_breadcrumbs_switch', '=', '1'],
                    'google' => false,
                    'all_styles' => false,
                    'font-family' => false,
                    'font-style' => false,
                    'font-size' => true,
                    'font-weight' => false,
                    'font-backup' => false,
                    'line-height' => true,
                    'text-align' => false,
                    'color' => true,
                    'default' => [
                        'font-size' => '13px',
                        'color' => '#181818',
                        'line-height' => '20px',
                    ],
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'footer',
            'title' => esc_html__('Footer', 'burido'),
            'icon' => 'fas fa-window-maximize el-rotate-180',
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'footer-general',
            'title' => esc_html__('General', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'footer_switch',
                    'title' => esc_html__('Footer', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Disable', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'footer-start',
                    'title' => esc_html__('Layout', 'burido'),
                    'type' => 'section',
                    'required' => ['footer_switch', '=', '1'],
                    'indent' => true,
                ],
                [
                    'id' => 'footer_building_tool',
                    'title' => esc_html__('Layout Building Tool', 'burido'),
                    'type' => 'select',
                    'options' => [
                        'widgets' => esc_html__('Wordpress Widgets', 'burido'),
                        'elementor' => esc_html__('Elementor', 'burido'),
                    ],
                    'default' => 'widgets',
                ],
                [
                    'id' => 'footer_page_select',
                    'title' => esc_html__('Footer Template', 'burido'),
                    'type' => 'select',
                    'required' => ['footer_building_tool', '=', 'elementor'],
                    'data' => 'posts',
                    'args' => [
                        'post_type' => 'footer',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ],
                ],
                [
                    'id' => 'widget_columns',
                    'title' => esc_html__('Columns', 'burido'),
                    'type' => 'button_set',
                    'required' => ['footer_building_tool', '=', 'widgets'],
                    'options' => [
                        '1' => esc_html('1'),
                        '2' => esc_html('2'),
                        '3' => esc_html('3'),
                        '4' => esc_html('4'),
                    ],
                    'default' => '4',
                ],
                [
                    'id' => 'widget_columns_2',
                    'title' => esc_html__('Columns Layout', 'burido'),
                    'type' => 'image_select',
                    'required' => ['widget_columns', '=', '2'],
                    'options' => [
                        '6-6' => [
                            'alt' => '50-50',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/50-50.png'
                        ],
                        '3-9' => [
                            'alt' => '25-75',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/25-75.png'
                        ],
                        '9-3' => [
                            'alt' => '75-25',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/75-25.png'
                        ],
                        '4-8' => [
                            'alt' => '33-66',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/33-66.png'
                        ],
                        '8-4' => [
                            'alt' => '66-33',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/66-33.png'
                        ]
                    ],
                    'default' => '6-6',
                ],
                [
                    'id' => 'widget_columns_3',
                    'title' => esc_html__('Columns Layout', 'burido'),
                    'type' => 'image_select',
                    'required' => ['widget_columns', '=', '3'],
                    'options' => [
                        '4-4-4' => [
                            'alt' => '33-33-33',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/33-33-33.png'
                        ],
                        '3-3-6' => [
                            'alt' => '25-25-50',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/25-25-50.png'
                        ],
                        '3-6-3' => [
                            'alt' => '25-50-25',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/25-50-25.png'
                        ],
                        '6-3-3' => [
                            'alt' => '50-25-25',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/50-25-25.png'
                        ],
                    ],
                    'default' => '4-4-4',
                ],
                [
                    'id' => 'footer_spacing',
                    'title' => esc_html__('Paddings', 'burido'),
                    'type' => 'spacing',
                    'required' => ['footer_building_tool', '=', 'widgets'],
                    'output' => ['.wgl-footer'],
                    'all' => false,
                    'mode' => 'padding',
                    'units' => 'px',
                    'default' => [
                        'padding-top' => '50px',
                        'padding-right' => '0px',
                        'padding-bottom' => '0px',
                        'padding-left' => '0px'
                    ],
                ],
                [
                    'id' => 'footer_full_width',
                    'title' => esc_html__('Full Width On/Off', 'burido'),
                    'type' => 'switch',
                    'required' => ['footer_building_tool', '=', 'widgets'],
                    'default' => false,
                ],
                [
                    'id' => 'footer-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'footer-start-styles',
                    'title' => esc_html__('Footer Styling', 'burido'),
                    'type' => 'section',
                    'required' => [
                        ['footer_switch', '=', '1'],
                        ['footer_building_tool', '=', 'widgets'],
                    ],
                    'indent' => true,
                ],
                [
                    'id' => 'footer_bg_image',
                    'title' => esc_html__('Background Image', 'burido'),
                    'type' => 'background',
                    'required' => [
                        ['footer_switch', '=', '1'],
                        ['footer_building_tool', '=', 'widgets'],
                    ],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                    ],
                ],
                [
                    'id' => 'footer_align',
                    'title' => esc_html__('Content Align', 'burido'),
                    'type' => 'button_set',
                    'required' => [
                        ['footer_switch', '=', '1'],
                        ['footer_building_tool', '=', 'widgets'],
                    ],
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'center',
                ],
                [
                    'id' => 'footer_bg_color',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color',
                    'required' => [
                        ['footer_switch', '=', '1'],
                        ['footer_building_tool', '=', 'widgets'],
                    ],
                    'transparent' => false,
                    'default' => '#181818',
                ],
                [
                    'id' => 'footer_heading_color',
                    'title' => esc_html__('Headings color', 'burido'),
                    'type' => 'color',
                    'required' => [
                        ['footer_switch', '=', '1'],
                        ['footer_building_tool', '=', 'widgets'],
                    ],
                    'transparent' => false,
                    'default' => '#ffffff',
                ],
                [
                    'id' => 'footer_text_color',
                    'title' => esc_html__('Content color', 'burido'),
                    'type' => 'color',
                    'required' => [
                        ['footer_switch', '=', '1'],
                        ['footer_building_tool', '=', 'widgets'],
                    ],
                    'transparent' => false,
                    'default' => '#D5D5D5',
                ],
                [
                    'id' => 'footer_add_border',
                    'title' => esc_html__('Add Border Top', 'burido'),
                    'type' => 'switch',
                    'required' => [
                        ['footer_switch', '=', '1'],
                        ['footer_building_tool', '=', 'widgets'],
                    ],
                    'default' => false,
                ],
                [
                    'id' => 'footer_border_color',
                    'title' => esc_html__('Border color', 'burido'),
                    'type' => 'color',
                    'required' => ['footer_add_border', '=', '1'],
                    'transparent' => false,
                    'default' => '#dcdcdc',
                ],
                [
                    'id' => 'footer-end-styles',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'footer-copyright',
            'title' => esc_html__('Copyright', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'copyright_switch',
                    'type' => 'switch',
                    'title' => esc_html__('Copyright', 'burido'),
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Disable', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'copyright-start',
                    'type' => 'section',
                    'title' => esc_html__('Copyright Settings', 'burido'),
                    'indent' => true,
                    'required' => ['copyright_switch', '=', '1'],
                ],
                [
                    'id' => 'copyright_editor',
                    'title' => esc_html__('Editor', 'burido'),
                    'type' => 'editor',
                    'required' => ['copyright_switch', '=', '1'],
                    'args' => [
                        'wpautop' => false,
                        'media_buttons' => false,
                        'textarea_rows' => 2,
                        'teeny' => false,
                        'quicktags' => true,
                    ],
                    'default' => '<p>Copyright © 2024 Burido by WebGeniusLab. All Rights Reserved</p>',
                ],
                [
                    'id' => 'copyright_text_color',
                    'title' => esc_html__('Text Color', 'burido'),
                    'type' => 'color',
                    'required' => ['copyright_switch', '=', '1'],
                    'transparent' => false,
                    'default' => '#8E8E8E',
                ],
                [
                    'id' => 'copyright_bg_color',
                    'title' => esc_html__('Background Color', 'burido'),
                    'type' => 'color',
                    'required' => ['copyright_switch', '=', '1'],
                    'transparent' => false,
                    'default' => '#181818',
                ],
                [
                    'id' => 'copyright_spacing',
                    'type' => 'spacing',
                    'title' => esc_html__('Paddings', 'burido'),
                    'required' => ['copyright_switch', '=', '1'],
                    'mode' => 'padding',
                    'all' => false,
                    'left' => false,
                    'right' => false,
                    'default' => [
                        'padding-top' => '20',
                        'padding-bottom' => '20',
                    ],
                ],
                [
                    'id' => 'copyright-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'blog-option',
            'title' => esc_html__('Blog', 'burido'),
            'icon' => 'el el-bullhorn',
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'blog-list-option',
            'title' => esc_html__('Archive', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'blog_list_body-start',
                    'title' => esc_html__('Body', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'blog_body_color_bg',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'contain',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center top',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'blog_list_body-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'blog_list_page_title-start',
                    'title' => esc_html__('Page Title', 'burido'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', '1'],
                    'indent' => true,
                ],
                [
                    'id' => 'post_archive__page_title_bg_image',
                    'title' => esc_html__('Background Image', 'burido'),
                    'type' => 'background',
                    'background-color' => true,
                    'preview_media' => true,
                    'preview' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'blog_list_page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'blog_list_sidebar-start',
                    'title' => esc_html__('Sidebar', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'blog_list_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'burido'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ]
                    ],
                    'default' => 'none'
                ],
                [
                    'id' => 'blog_list_sidebar_def',
                    'title' => esc_html__('Sidebar Template', 'burido'),
                    'type' => 'select',
                    'required' => ['blog_list_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'blog_list_sidebar_def_width',
                    'title' => esc_html__('Sidebar Width', 'burido'),
                    'type' => 'button_set',
                    'required' => ['blog_list_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html( '25%' ),
                        '8' => esc_html( '33%' ),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'blog_list_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'burido'),
                    'type' => 'switch',
                    'required' => ['blog_list_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_sidebar_gap',
                    'title' => esc_html__( 'Sidebar Side Gap', 'burido' ),
                    'type' => 'select',
                    'required' => [ 'blog_list_sidebar_layout', '!=', 'none' ],
                    'options' => [
                        'def' => esc_html__( 'Default', 'burido' ),
                        '0' => esc_html( '15' ),
                        '15' => esc_html( '30' ),
                        '20' => esc_html( '35' ),
                        '25' => esc_html( '40' ),
                        '30' => esc_html( '45' ),
                        '35' => esc_html( '50' ),
                        '40' => esc_html( '55' ),
                        '45' => esc_html( '60' ),
                    ],
                    'default' => 'def',
                ],
                [
                    'id' => 'blog_list_sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'blog_list_appearance-start',
                    'title' => esc_html__('Appearance', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'blog_list_columns',
                    'title' => esc_html__('Columns in Archive', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        '12' => esc_html__('One', 'burido'),
                        '6' => esc_html__('Two', 'burido'),
                        '4' => esc_html__('Three', 'burido'),
                        '3' => esc_html__('Four', 'burido'),
                    ],
                    'default' => '12',
                ],
                [
                    'id' => 'blog_list_likes',
                    'title' => esc_html__('Likes', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_views',
                    'title' => esc_html__('Views', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_share',
                    'title' => esc_html__('Shares', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_hide_media',
                    'title' => esc_html__('Hide Media?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_hide_title',
                    'title' => esc_html__('Hide Title?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_hide_content',
                    'title' => esc_html__('Hide Content?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_post_listing_content',
                    'title' => esc_html__('Limit the characters amount in Content?', 'burido'),
                    'type' => 'switch',
                    'required' => ['blog_list_hide_content', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_letter_count',
                    'title' => esc_html__('Characters amount to be displayed in Content', 'burido'),
                    'type' => 'text',
                    'required' => ['blog_post_listing_content', '=', true],
                    'default' => '85',
                ],
                [
                    'id' => 'blog_list_read_more',
                    'title' => esc_html__('Hide Read More Button?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_meta',
                    'title' => esc_html__('Hide all post-meta?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_meta_author',
                    'title' => esc_html__('Hide post-meta author?', 'burido'),
                    'type' => 'switch',
                    'required' => ['blog_list_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_meta_comments',
                    'title' => esc_html__('Hide post-meta comments?', 'burido'),
                    'type' => 'switch',
                    'required' => ['blog_list_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'blog_list_meta_categories',
                    'title' => esc_html__('Hide post-meta categories?', 'burido'),
                    'type' => 'switch',
                    'required' => ['blog_list_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_meta_date',
                    'title' => esc_html__('Hide post-meta date?', 'burido'),
                    'type' => 'switch',
                    'required' => ['blog_list_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_list_appearance-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'blog-single-option',
            'title' => esc_html__('Single', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'blog_single_body-start',
                    'title' => esc_html__('Body', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'blog_single_body_color_bg',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'contain',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center top',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'blog_single_body-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'post_single_type_layout',
                    'title' => esc_html__('Default Post Layout', 'burido'),
                    'type' => 'button_set',
                    'desc' => esc_html__('Note: each Post can be separately customized within its Metaboxes section.', 'burido'),
                    'options' => [
                        '1' => esc_html__('Title First', 'burido'),
                        '2' => esc_html__('Image First', 'burido'),
                        '3' => esc_html__('Overlay Image', 'burido')
                    ],
                    'default' => '3',
                ],
                [
                    'id' => 'blog_single_header-start',
                    'title' => esc_html__('Header', 'burido'),
                    'type' => 'section',
                    'required' => ['header_building_tool', '=', 'elementor'],
                    'indent' => true,
                ],
                [
                    'id' => 'blog_header_conditional',
                    'title' => esc_html__('Header', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Default', 'burido'),
                    'off' => esc_html__('Custom', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'blog_single_header_page_select',
                    'type' => 'select',
                    'title' => esc_html__('Header Template', 'burido'),
                    'required' => ['blog_header_conditional', '=', ''],
                    'desc' => wp_kses(
                        sprintf(
                            '%s <a href="%s" target="_blank">%s</a> %s<br> %s',
                            __('Selected Template will be used for all pages by default. You can edit/create Header Template in the', 'burido'),
                            admin_url('edit.php?post_type=header'),
                            __('Header Templates', 'burido'),
                            __('dashboard tab.', 'burido'),
                            burido_quick_tip(
                                sprintf(
                                    __('Note: fine tuning is available through the Elementor\'s <code>Post Settings</code> tab, which is located <a href="%s" target="_blank">here</a>', 'burido'),
                                    get_template_directory_uri() . '/core/admin/img/dashboard/quick_tip__header_extra_options.png'
                                )
                            )
                        ),
                        ['a' => ['href' => true, 'target' => true], 'br' => [], 'span' => ['class' => true], 'i' => ['class' => true], 'code' => []]
                    ),
                    'data' => 'posts',
                    'args' => [
                        'post_type' => 'header',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ],
                ],
                [
                    'id' => 'blog_single_page_title-start',
                    'title' => esc_html__('Page Title', 'burido'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', '1'],
                    'indent' => true,
                ],
                [
                    'id' => 'blog_title_conditional',
                    'title' => esc_html__('Page Title Text', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Post Type Name', 'burido'),
                    'off' => esc_html__('Post Title', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'blog_single__page_title_breadcrumbs_switch',
                    'title' => esc_html__('Breadcrumbs', 'burido'),
                    'type' => 'switch',
                    'required' => ['post_single_type_layout', '!=', '3'],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'post_single__page_title_bg_switch',
                    'title' => esc_html__('Use Background Image/Color?', 'burido'),
                    'type' => 'switch',
                    'required' => ['post_single_type_layout', '!=', '3'],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'post_single__page_title_bg_image',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'required' => ['post_single_type_layout', '!=', '3'],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'post_single_layout_3_bg_image',
                    'type' => 'background',
                    'title' => esc_html__('Default Background', 'burido'),
                    'required' => ['post_single_type_layout', '=', '3'],
                    'desc' => esc_html__('Note: If Featured Image doesn\'t exist.', 'burido'),
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'background-repeat' => false,
                    'background-size' => false,
                    'background-attachment' => false,
                    'background-position' => false,
                    'default' => [
                        'background-color' => 'rgba(0,0,0,0.8)',
                    ],
                ],
                [
                    'id' => 'single_padding_layout_3',
                    'type' => 'spacing',
                    'title' => esc_html__('Padding Top/Bottom', 'burido'),
                    'required' => ['post_single_type_layout', '=', '3'],
                    'mode' => 'padding',
                    'all' => false,
                    'top' => true,
                    'right' => false,
                    'bottom' => true,
                    'left' => false,
                    'default' => [
                        'padding-top' => '422',
                        'padding-bottom' => '89',
                    ],
                ],
                [
                    'id' => 'blog_single_page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'blog_single_sidebar-start',
                    'type' => 'section',
                    'title' => esc_html__('Sidebar', 'burido'),
                    'indent' => true,
                ],
                [
                    'id' => 'single_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'burido'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ]
                    ],
                    'default' => 'right'
                ],
                [
                    'id' => 'single_sidebar_def',
                    'title' => esc_html__('Sidebar Template', 'burido'),
                    'type' => 'select',
                    'required' => ['single_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                    'default' => 'sidebar_main-sidebar',
                ],
                [
                    'id' => 'single_sidebar_def_width',
                    'title' => esc_html__('Sidebar Width', 'burido'),
                    'type' => 'button_set',
                    'required' => ['single_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html( '25%' ),
                        '8' => esc_html( '33%' ),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'single_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'burido'),
                    'type' => 'switch',
                    'required' => ['single_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'single_sidebar_gap',
                    'title' => esc_html__( 'Sidebar Side Gap', 'burido' ),
                    'type' => 'select',
                    'required' => [ 'single_sidebar_layout', '!=', 'none' ],
                    'options' => [
                        'def' => esc_html__( 'Default', 'burido' ),
                        '0' => esc_html( '15' ),
                        '15' => esc_html( '30' ),
                        '20' => esc_html( '35' ),
                        '25' => esc_html( '40' ),
                        '30' => esc_html( '45' ),
                        '35' => esc_html( '50' ),
                        '40' => esc_html( '55' ),
                        '45' => esc_html( '60' ),
                    ],
                    'default' => '40',
                ],
                [
                    'id' => 'blog_single_sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'blog_single_appearance-start',
                    'title' => esc_html__('Appearance', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'featured_image_type',
                    'title' => esc_html__('Featured Image', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'default' => esc_html__('Default', 'burido'),
                        'off' => esc_html__('Off', 'burido'),
                        'replace' => esc_html__('Replace', 'burido')
                    ],
                    'default' => 'default',
                ],
                [
                    'id' => 'featured_image_replace',
                    'title' => esc_html__('Image To Replace On', 'burido'),
                    'type' => 'media',
                    'required' => ['featured_image_type', '=', 'replace'],
                ],
                [
                    'id' => 'single_apply_animation',
                    'title' => esc_html__('Apply Animation?', 'burido'),
                    'type' => 'switch',
                    'required' => ['post_single_type_layout', '=', '3'],
                    'desc' => burido_quick_tip(
                        wp_kses(
                            __('Fade out the Post Title during page scrolling. <br>Note: affects only <code>Overlay Image</code> post layouts', 'burido'),
                            ['br' => [], 'code' => []]
                        )
                    ),
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_scroll_down',
                    'title' => esc_html__('Scroll Down Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['post_single_type_layout', '=', '3'],
                    'desc' => burido_quick_tip(
                        wp_kses(
                            __('Note: affects only <code>Overlay Image</code> post layouts', 'burido'),
                            ['code' => []]
                        )
                    ),
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_likes',
                    'title' => esc_html__('Likes', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_views',
                    'title' => esc_html__('Views', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_share',
                    'title' => esc_html__('Shares', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_meta_tags',
                    'title' => esc_html__('Tags', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'single_author_info',
                    'title' => esc_html__('Author Info', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_meta',
                    'title' => esc_html__('Hide all post-meta?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_meta_author',
                    'title' => esc_html__('Hide post-meta author?', 'burido'),
                    'type' => 'switch',
                    'required' => ['single_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'single_meta_comments',
                    'title' => esc_html__('Hide post-meta comments?', 'burido'),
                    'type' => 'switch',
                    'required' => ['single_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'single_meta_categories',
                    'title' => esc_html__('Hide post-meta categories?', 'burido'),
                    'type' => 'switch',
                    'required' => ['single_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'single_meta_date',
                    'title' => esc_html__('Hide post-meta date?', 'burido'),
                    'type' => 'switch',
                    'required' => ['single_meta', '=', false],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'blog_single_appearance-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'blog-single-related-option',
            'title' => esc_html__('Related', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'single_related_posts',
                    'title' => esc_html__('Related Posts', 'burido'),
                    'type' => 'switch',
                    'default' => true,
                ],
                [
                    'id' => 'blog_title_r',
                    'title' => esc_html__('Related Section Title', 'burido'),
                    'type' => 'text',
                    'required' => ['single_related_posts', '=', '1'],
                    'default' => esc_html__('Related posts', 'burido'),
                ],
                [
                    'id' => 'blog_cat_r',
                    'title' => esc_html__('Select Categories', 'burido'),
                    'type' => 'select',
                    'required' => ['single_related_posts', '=', '1'],
                    'multi' => true,
                    'data' => 'categories',
                    'width' => '20%',
                ],
                [
                    'id' => 'blog_column_r',
                    'title' => esc_html__('Columns', 'burido'),
                    'type' => 'button_set',
                    'required' => ['single_related_posts', '=', '1'],
                    'options' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4'
                    ],
                    'default' => '2',
                ],
                [
                    'id' => 'blog_number_r',
                    'title' => esc_html__('Number of Related Items', 'burido'),
                    'type' => 'text',
                    'required' => ['single_related_posts', '=', '1'],
                    'default' => '2',
                ],
                [
                    'id' => 'blog_carousel_r',
                    'title' => esc_html__('Display items in the carousel', 'burido'),
                    'type' => 'switch',
                    'required' => ['single_related_posts', '=', '1'],
                    'default' => true,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'portfolio-option',
            'title' => esc_html__('Portfolio', 'burido'),
            'icon' => 'el el-picture',
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'portfolio-list-option',
            'title' => esc_html__('Archive', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'portfolio_slug',
                    'title' => esc_html__('Portfolio Slug', 'burido'),
                    'type' => 'text',
                    'default' => 'portfolio',
                ],
                [
                    'id' => 'portfolio_body-start',
                    'title' => esc_html__('Body', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_body_color_bg',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'contain',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center top',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'portfolio_body-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'portfolio_archive_page_title-start',
                    'title' => esc_html__('Page Title', 'burido'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', '1'],
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_archive__page_title_bg_image',
                    'title' => esc_html__('Page Title Background Image', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'portfolio_archive_page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'portfolio_archive_sidebar-start',
                    'title' => esc_html__('Sidebar', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_list_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'burido'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ]
                    ],
                    'default' => 'none'
                ],
                [
                    'id' => 'portfolio_list_sidebar_def',
                    'title' => esc_html__('Sidebar Template', 'burido'),
                    'type' => 'select',
                    'required' => ['portfolio_list_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'portfolio_list_sidebar_def_width',
                    'title' => esc_html__('Sidebar Width', 'burido'),
                    'type' => 'button_set',
                    'required' => ['portfolio_list_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html__('25%', 'burido'),
                        '8' => esc_html__('33%', 'burido'),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'portfolio_archive_sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'portfolio_list_appearance-start',
                    'title' => esc_html__('Appearance', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_list_columns',
                    'title' => esc_html__('Columns in Archive', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        '1' => esc_html__('One', 'burido'),
                        '2' => esc_html__('Two', 'burido'),
                        '3' => esc_html__('Three', 'burido'),
                        '4' => esc_html__('Four', 'burido'),
                    ],
                    'default' => '3',
                ],
                [
                    'id' => 'portfolio_list_show_title',
                    'title' => esc_html__('Title', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'portfolio_list_show_content',
                    'title' => esc_html__('Content', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_list_show_cat',
                    'title' => esc_html__('Categories', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'portfolio_list_tooltip',
                    'title' => esc_html__('Items cursor tooltip hover animation', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_related_switch', '=', '1'],
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_list_appearance-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'portfolio-single-option',
            'title' => esc_html__('Single', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'portfolio_single_body-start',
                    'title' => esc_html__('Body', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_single_body_color_bg',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'contain',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center top',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'portfolio_single_body-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'portfolio_single_layout-start',
                    'title' => esc_html__('Layout', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_single_type_layout',
                    'title' => esc_html__('Portfolio Single Layout', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        '1' => esc_html__('Title First', 'burido'),
                        '2' => esc_html__('Image First', 'burido'),
                    ],
                    'default' => '2',
                ],
                [
                    'id' => 'portfolio_single_image',
                    'title' => esc_html__('Portfolio Image Wide', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'portfolio_single_image_width',
                    'title' => esc_html__('Max Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['portfolio_single_image', '=', true],
                    'height' => false,
                    'width' => true,
                    'default' => ['width' => 1900],
                ],
                [
                    'id' => 'portfolio_single__image_margin',
                    'title' => esc_html__('Featured Image Margin Top', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => false,
                    'top' => true,
                    'left' => false,
                    'right' => false,
                    'default' => [
                        'margin-top' => '-40',
                    ],
                ],
                [
                    'id' => 'portfolio_single_layout-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'portfolio_single_page_title-start',
                    'title' => esc_html__('Page Title', 'burido'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', true],
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_single__page_title_switch',
                    'title' => esc_html__('Use Page Title?', 'burido'),
                    'type' => 'switch',
                    'required' => ['page_title_switch', '=', true],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'portfolio_title_conditional',
                    'title' => esc_html__('Page Title Text', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Post Type Name', 'burido'),
                    'off' => esc_html__('Post Title', 'burido'),
                    'default' => true,
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single_title_align',
                    'title' => esc_html__('Title Alignment', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'center',
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single_breadcrumbs_align',
                    'title' => esc_html__('Breadcrumbs Alignment', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'center',
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single_breadcrumbs_block_switch',
                    'title' => esc_html__('Breadcrumbs Full Width', 'burido'),
                    'type' => 'switch',
                    'default' => true,
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single__page_title_bg_switch',
                    'title' => esc_html__('Use Background Image/Color?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single__page_title_bg_image',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'required' => ['portfolio_single__page_title_bg_switch', '=', true],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single__page_title_height',
                    'title' => esc_html__('Min Height', 'burido'),
                    'type' => 'dimensions',
                    'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'burido'),
                    'height' => true,
                    'width' => false,
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single__page_title_padding',
                    'title' => esc_html__('Paddings Top/Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'all' => false,
                    'bottom' => true,
                    'top' => true,
                    'left' => false,
                    'right' => false,
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single__page_title_margin',
                    'title' => esc_html__('Margin Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => true,
                    'top' => false,
                    'left' => false,
                    'right' => false,
                    'required' => [
                        ['portfolio_single__page_title_switch', '=', true],
                    ],
                ],
                [
                    'id' => 'portfolio_single_page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'portfolio_single_sidebar-start',
                    'title' => esc_html__('Sidebar', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_single_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'burido'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ]
                    ],
                    'default' => 'none'
                ],
                [
                    'id' => 'portfolio_single_sidebar_def',
                    'title' => esc_html__('Sidebar Template', 'burido'),
                    'type' => 'select',
                    'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'portfolio_single_sidebar_def_width',
                    'title' => esc_html__('Sidebar Width', 'burido'),
                    'type' => 'button_set',
                    'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html( '25%' ),
                        '8' => esc_html( '33%' ),
                    ],
                    'default' => '8',
                ],
                [
                    'id' => 'portfolio_single_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_single_sidebar_gap',
                    'title' => esc_html__( 'Sidebar Side Gap', 'burido' ),
                    'type' => 'select',
                    'required' => [ 'portfolio_single_sidebar_layout', '!=', 'none' ],
                    'options' => [
                        'def' => esc_html__( 'Default', 'burido' ),
                        '0' => esc_html( '15' ),
                        '15' => esc_html( '30' ),
                        '20' => esc_html( '35' ),
                        '25' => esc_html( '40' ),
                        '30' => esc_html( '45' ),
                        '35' => esc_html( '50' ),
                        '40' => esc_html( '55' ),
                        '45' => esc_html( '60' ),
                    ],
                    'default' => 'def',
                ],
                [
                    'id' => 'portfolio_single_sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'portfolio_single_appearance-start',
                    'title' => esc_html__('Appearance', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'portfolio_above_content_cats',
                    'title' => esc_html__('Tags', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'portfolio_above_content_share',
                    'title' => esc_html__('Shares', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'portfolio_single_meta_likes',
                    'title' => esc_html__('Likes', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_single_meta',
                    'title' => esc_html__('Hide all post-meta?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_single_meta_author',
                    'title' => esc_html__('Post-meta author', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_single_meta', '=', false],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_single_meta_comments',
                    'title' => esc_html__('Post-meta comments', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_single_meta', '=', false],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_single_meta_categories',
                    'title' => esc_html__('Post-meta categories', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_single_meta', '=', false],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_single_meta_date',
                    'title' => esc_html__('Post-meta date', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_single_meta', '=', false],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'portfolio_single_appearance-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'portfolio-related-option',
            'title' => esc_html__('Related Posts', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'portfolio_related_switch',
                    'title' => esc_html__('Related Posts', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'portfolio_related_title',
                    'title' => esc_html__('Title', 'burido'),
                    'type' => 'text',
                    'required' => ['portfolio_related_switch', '=', '1'],
                    'default' => esc_html__('Related projects', 'burido'),
                ],
                [
                    'id' => 'pf_carousel_r',
                    'title' => esc_html__('Display items within carousel for this post', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_related_switch', '=', '1'],
                    'default' => true,
                ],
                [
                    'id' => 'pf_tooltip_r',
                    'title' => esc_html__('Items cursor tooltip hover animation', 'burido'),
                    'type' => 'switch',
                    'required' => ['portfolio_related_switch', '=', '1'],
                    'default' => false,
                ],
                [
                    'id' => 'pf_column_r',
                    'title' => esc_html__('Related Columns', 'burido'),
                    'type' => 'button_set',
                    'required' => ['portfolio_related_switch', '=', '1'],
                    'options' => [
                        '2' => esc_html__('Two', 'burido'),
                        '3' => esc_html__('Three', 'burido'),
                        '4' => esc_html__('Four', 'burido'),
                    ],
                    'default' => '3',
                ],
                [
                    'id' => 'pf_number_r',
                    'title' => esc_html__('Number of Related Items', 'burido'),
                    'type' => 'text',
                    'required' => ['portfolio_related_switch', '=', '1'],
                    'default' => '3',
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'portfolio-advanced',
            'title' => esc_html__('Advanced', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'portfolio_archives',
                    'title' => esc_html__('Portfolio Archives', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Enabled', 'burido'),
                    'off' => esc_html__('Disabled', 'burido'),
                    'default' => true,
                    'desc' => burido_quick_tip(sprintf(
                        wp_kses(
                            __('Archive Page lists all the portfolio posts you have created. <br>This option will disable only the Archive Page, while the post\'s Single Pages will still be displayed. <br>Note: you need to refresh your <a href="%s">permalinks</a> after switching this option.', 'burido'),
                            ['a' => ['href' => true], 'br' => []]
                        ),
                        esc_url(admin_url('options-permalink.php'))
                    )),
                ],
                [
                    'id' => 'portfolio_singular',
                    'title' => esc_html__('Portfolio Single', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Enabled', 'burido'),
                    'off' => esc_html__('Disabled', 'burido'),
                    'default' => true,
                    'desc' => burido_quick_tip(
                        wp_kses(
                            __('By default, all Portfolio posts have their Single Pages. <br>This creates a specific URL on your website for every post. <br>Selecting "Disabled" will prevent the single view post being publicly displayed.', 'burido'),
                            ['br' => []]
                        )
                    ),
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'team-option',
            'title' => esc_html__('Team', 'burido'),
            'icon' => 'el el-user',
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'team-single-option',
            'title' => esc_html__('Single', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'team_body-start',
                    'title' => esc_html__('Body', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'team_body_color_bg',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'contain',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center top',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'team_body-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'team_single_page_title-start',
                    'title' => esc_html__('Page Title', 'burido'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', true],
                    'indent' => true,
                ],
                [
                    'id' => 'team_title_conditional',
                    'title' => esc_html__('Page Title Text', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Post Type Name', 'burido'),
                    'off' => esc_html__('Post Title', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'team_single__page_title_bg_switch',
                    'title' => esc_html__('Use Background Image/Color?', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => 'team_single__page_title_bg_image',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'required' => ['team_single__page_title_bg_switch', '=', true],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'team_single__page_title_height',
                    'title' => esc_html__('Min Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['page_title_bg_switch', '=', true],
                    'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'burido'),
                    'height' => true,
                    'width' => false,
                ],
                [
                    'id' => 'team_single__page_title_padding',
                    'title' => esc_html__('Paddings Top/Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'all' => false,
                    'bottom' => true,
                    'top' => true,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => 'team_single__page_title_margin',
                    'title' => esc_html__('Margin Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => true,
                    'top' => false,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => 'team_single_page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'team_single_sticky_image',
                    'title' => esc_html__('Sticky Image', 'burido'),
                    'type' => 'switch',
                    'default' => true,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'team-advanced',
            'title' => esc_html__('Advanced', 'burido'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'team_slug',
                    'title' => esc_html__('Team Slug', 'burido'),
                    'type' => 'text',
                    'default' => 'team',
                ],
                [
                    'id' => 'team_singular',
                    'title' => esc_html__('Team Singles', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Enabled', 'burido'),
                    'off' => esc_html__('Disabled', 'burido'),
                    'default' => true,
                    'desc' => esc_html__('By default, all team posts have single views enabled. This creates a specific URL on your website for that post. Selecting "Disabled" will prevent the single view post being publicly displayed.', 'burido'),
                ],
                [
                    'id' => 'team_archives',
                    'title' => esc_html__('Team Archive', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Enabled', 'burido'),
                    'off' => esc_html__('Disabled', 'burido'),
                    'default' => true,
                    'desc' => sprintf(
                        wp_kses(
                            __('Archive Page lists all the Team Members you have created. This option will disable only the member\'s Archive Page. The member\'s Single Pages will still be displayed. Note: you will need to refresh your <a href="%s">permalinks</a> after switching this option.', 'burido'),
                            ['a' => ['href' => true, 'target' => true]]
                        ),
                        esc_url(admin_url('options-permalink.php'))
                    ),
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'title' => esc_html__('Page 404', 'burido'),
            'id' => '404-option',
            'icon' => 'el el-error',
            'fields' => [
                [
                    'id' => '404_building_tool',
                    'title' => esc_html__('Layout Building Tool', 'burido'),
                    'type' => 'select',
                    'options' => [
                        'default' => esc_html__('Default', 'burido'),
                        'elementor' => esc_html__('Elementor', 'burido'),
                    ],
                    'default' => 'default',
                ],
                [
                    'id' => '404_template_select',
                    'type' => 'select',
                    'title' => esc_html__('Select Template', 'burido'),
                    'required' => ['404_building_tool', '=', 'elementor'],
                    'data' => 'posts',
                    'desc' => sprintf(
                        '%s <br>%s <a href="%s" target="_blank">%s</a> %s',
                        esc_html__('Selected Template will be used for 404 page by default.', 'burido'),
                        esc_html__('You can edit/create Template in the', 'burido'),
                        admin_url('edit.php?post_type=elementor_library&tabs_group=library'),
                        esc_html__('Saved Templates', 'burido'),
                        esc_html__('dashboard tab.', 'burido')
                    ),
                    'args' => [
                        'post_type' => 'elementor_library',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ],
                ],
                [
                    'id' => '404_body_color_bg',
                    'title' => esc_html__('Body Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'contain',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center top',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => '404_show_header',
                    'type' => 'switch',
                    'title' => esc_html__('Header Section', 'burido'),
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => '404_page_title_switcher',
                    'title' => esc_html__('Page Title Section', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => '404_page_title-start',
                    'type' => 'section',
                    'required' => ['404_page_title_switcher', '=', true],
                    'indent' => true,
                ],
                [
                    'id' => '404_custom_title_switch',
                    'title' => esc_html__('Page Title Text', 'burido'),
                    'type' => 'switch',
                    'required' => ['404_page_title_switcher', '=', true],
                    'on' => esc_html__('Custom', 'burido'),
                    'off' => esc_html__('Default', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => '404_page_title_text',
                    'title' => esc_html__('Custom Page Title Text', 'burido'),
                    'type' => 'text',
                    'required' => ['404_custom_title_switch', '=', true],
                ],
                [
                    'id' => '404_page__page_title_bg_switch',
                    'title' => esc_html__('Use Background Image/Color?', 'burido'),
                    'type' => 'switch',
                    'required' => ['404_page_title_switcher', '=', true],
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
                [
                    'id' => '404_page__page_title_bg_image',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'required' => ['404_page__page_title_bg_switch', '=', true],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => '404_page__page_title_height',
                    'title' => esc_html__('Min Height', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['page_title_bg_switch', '=', true],
                    'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'burido'),
                    'height' => true,
                    'width' => false,
                ],
                [
                    'id' => '404_page__page_title_padding',
                    'title' => esc_html__('Paddings Top/Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'all' => false,
                    'top' => true,
                    'bottom' => true,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => '404_page__page_title_margin',
                    'title' => esc_html__('Margin Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'all' => false,
                    'top' => false,
                    'bottom' => true,
                    'left' => false,
                    'right' => false,
                    'default' => [
                        'margin-bottom' => '0',
                    ],
                ],
                [
                    'id' => '404_page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => '404_page_main-start',
                    'type' => 'section',
                    'title' => esc_html__('Section Settings', 'burido'),
                    'indent' => true,
                ],
                [
                    'id' => '404_page_main_bg_image',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => false,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'inherit',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                    ],
                ],
                [
                    'id' => '404_page_main_padding',
                    'title' => esc_html__('Paddings Top/Bottom', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'all' => false,
                    'top' => true,
                    'bottom' => true,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => '404_page_main-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => '404_show_footer',
                    'title' => esc_html__('Footer Section', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => true,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'side_panel',
            'title' => esc_html__('Side Panel', 'burido'),
            'icon' => 'el el-indent-left',
            'fields' => [
                [
                    'id' => 'side_panel_enabled',
                    'title' => esc_html__('Side Panel', 'burido'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Disable', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'side_panel-start',
                    'title' => esc_html__('Layout', 'burido'),
                    'type' => 'section',
                    'required' => ['side_panel_enabled', '=', true],
                    'indent' => true,
                ],
                [
                    'id' => 'side_panel_building_tool',
                    'title' => esc_html__('Layout Building Tool', 'burido'),
                    'type' => 'select',
                    'options' => [
                        'widgets' => esc_html__('Wordpress Widgets', 'burido'),
                        'elementor' => esc_html__('Elementor (recommended)', 'burido'),
                    ],
                    'default' => 'elementor',
                ],
                [
                    'id' => 'side_panel_page_select',
                    'title' => esc_html__('Select Template', 'burido'),
                    'type' => 'select',
                    'required' => ['side_panel_building_tool', '=', 'elementor'],
                    'desc' => wp_kses(
                        sprintf(
                            '%s <a href="%s" target="_blank">%s</a> %s<br> %s',
                            __('You can edit/create Side Panel Template in the', 'burido'),
                            admin_url('edit.php?post_type=side_panel'),
                            __('Side Panel', 'burido'),
                            __('dashboard tab.', 'burido'),
                            burido_quick_tip(
                                sprintf(
                                    __('Note: fine tuning is available through the Elementor\'s <code>Post Settings</code> tab, which is located <a href="%s" target="_blank">here</a>', 'burido'),
                                    get_template_directory_uri() . '/core/admin/img/dashboard/quick_tip__side_panel_extra_options.png'
                                )
                            )
                        ),
                        ['a' => ['href' => true, 'target' => true], 'br' => [], 'span' => ['class' => true], 'i' => ['class' => true], 'code' => []]
                    ),
                    'data' => 'posts',
                    'args' => [
                        'post_type' => 'side_panel',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ],
                ],
                [
                    'id' => 'side_panel_spacing',
                    'title' => esc_html__('Margin', 'burido'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'required' => ['side_panel_building_tool', '=', 'widgets'],
                    'units' => 'px',
                    'all' => false,
                    'default' => [
                        'margin-top' => '',
                        'margin-right' => '',
                        'margin-bottom' => '',
                        'margin-left' => '',
                    ],
                ],
                [
                    'id' => 'side_panel_title_color',
                    'title' => esc_html__('Title Color', 'burido'),
                    'type' => 'color',
                    'required' => ['side_panel_building_tool', '=', 'widgets'],
                    'transparent' => false,
                    'default' => '#ffffff',
                ],
                [
                    'id' => 'side_panel_text_color',
                    'title' => esc_html__('Text Color', 'burido'),
                    'type' => 'color',
                    'required' => ['side_panel_building_tool', '=', 'widgets'],
                    'transparent' => false,
                    'default' => '#ffffff',
                ],
                [
                    'id' => 'side_panel_bg',
                    'title' => esc_html__('Background', 'burido'),
                    'type' => 'color_rgba',
                    'required' => ['side_panel_building_tool', '=', 'widgets'],
                    'mode' => 'background',
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(24,24,24,1)',
                        'color' => '#181818',
                    ],
                ],
                [
                    'id' => 'side_panel_text_alignment',
                    'title' => esc_html__('Text Align', 'burido'),
                    'type' => 'button_set',
                    'required' => ['side_panel_building_tool', '=', 'widgets'],
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'center' => esc_html__('Center', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'left',
                ],
                [
                    'id' => 'side_panel_width',
                    'title' => esc_html__('Width', 'burido'),
                    'type' => 'dimensions',
                    'required' => ['side_panel_building_tool', '=', 'widgets'],
                    'width' => true,
                    'height' => false,
                    'default' => ['width' => 370],
                ],
                [
                    'id' => 'side_panel_position',
                    'title' => esc_html__('Position', 'burido'),
                    'type' => 'button_set',
                    'required' => ['side_panel_building_tool', '=', 'widgets'],
                    'options' => [
                        'left' => esc_html__('Left', 'burido'),
                        'right' => esc_html__('Right', 'burido'),
                    ],
                    'default' => 'right'
                ],
                [
                    'id' => 'side_panel-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'layout_options',
            'title' => esc_html__('Sidebars', 'burido'),
            'icon' => 'el el-braille',
            'fields' => [
                [
                    'id' => 'sidebars',
                    'title' => esc_html__('Register Sidebars', 'burido'),
                    'type' => 'multi_text',
                    'validate' => 'no_html',
                    'add_text' => esc_html__('Add Sidebar', 'burido'),
                    'default' => ['Main Sidebar'],
                ],
                [
                    'id' => 'sidebars-start',
                    'title' => esc_html__('Sidebar Settings', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'page_sidebar_layout',
                    'title' => esc_html__('Page Sidebar Layout', 'burido'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'burido'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ]
                    ],
                    'default' => 'none'
                ],
                [
                    'id' => 'page_sidebar_def',
                    'title' => esc_html__('Page Sidebar', 'burido'),
                    'type' => 'select',
                    'required' => ['page_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'page_sidebar_def_width',
                    'title' => esc_html__('Page Sidebar Width', 'burido'),
                    'type' => 'button_set',
                    'required' => ['page_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html( '25%' ),
                        '8' => esc_html( '33%' ),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'page_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'burido'),
                    'type' => 'switch',
                    'required' => ['page_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'page_sidebar_gap',
                    'title' => esc_html__( 'Sidebar Side Gap', 'burido' ),
                    'type' => 'select',
                    'required' => [ 'page_sidebar_layout', '!=', 'none' ],
                    'options' => [
                        'def' => esc_html__( 'Default', 'burido' ),
                        '0' => esc_html( '15' ),
                        '15' => esc_html( '30' ),
                        '20' => esc_html( '35' ),
                        '25' => esc_html( '40' ),
                        '30' => esc_html( '45' ),
                        '35' => esc_html( '50' ),
                        '40' => esc_html( '55' ),
                        '45' => esc_html( '60' ),
                    ],
                    'default' => 'def',
                ],
                [
                    'id' => 'sidebars-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'soc_shares',
            'title' => esc_html__('Social Shares', 'burido'),
            'icon' => 'el el-share-alt',
            'fields' => [
                [
                    'id' => 'post_shares',
                    'title' => esc_html__('Share List', 'burido'),
                    'type' => 'checkbox',
                    'desc' => esc_html__('Note: used only on Blog Single, Blog List and Portfolio Single pages', 'burido'),
                    'options' => [
                        'telegram' => esc_html__('Telegram', 'burido'),
                        'reddit' => esc_html__('Reddit', 'burido'),
                        'twitter' => esc_html__('Twitter', 'burido'),
                        'whatsapp' => esc_html__('WhatsApp', 'burido'),
                        'facebook' => esc_html__('Facebook', 'burido'),
                        'pinterest' => esc_html__('Pinterest', 'burido'),
                        'linkedin' => esc_html__('Linkedin', 'burido'),
                    ],
                    'default' => [
                        'telegram' => '0',
                        'reddit' => '0',
                        'twitter' => '1',
                        'whatsapp' => '0',
                        'facebook' => '1',
                        'pinterest' => '1',
                        'linkedin' => '1',
                    ]
                ],
                [
                    'id' => 'page_socials-start',
                    'title' => esc_html__('Page Socials', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'show_soc_icon_page',
                    'title' => esc_html__('Page Social Shares', 'burido'),
                    'type' => 'switch',
                    'desc' => esc_html__('Social buttons are to be rendered on a left side of each page.', 'burido'),
                    'on' => esc_html__('Use', 'burido'),
                    'off' => esc_html__('Hide', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'soc_icon_style',
                    'title' => esc_html__('Socials visibility', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'standard' => esc_html__('Always', 'burido'),
                        'hovered' => esc_html__('On Hover', 'burido'),
                    ],
                    'default' => 'standard',
                    'required' => ['show_soc_icon_page', '=', '1'],
                ],
                [
                    'id' => 'soc_icon_offset',
                    'title' => esc_html__('Offset Top', 'burido'),
                    'type' => 'spacing',
                    'required' => ['show_soc_icon_page', '=', '1'],
                    'desc' => esc_html__('If units defined as "%" then socials will be fixed to viewport.', 'burido'),
                    'mode' => 'margin',
                    'units' => ['px', '%'],
                    'all' => false,
                    'top' => true,
                    'bottom' => false,
                    'left' => false,
                    'right' => false,
                    'default' => [
                        'margin-top' => '250',
                        'units' => 'px'
                    ],
                ],
                [
                    'id' => 'soc_icon_facebook',
                    'title' => esc_html__('Facebook Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['show_soc_icon_page', '=', '1'],
                    'default' => false,
                ],
                [
                    'id' => 'soc_icon_twitter',
                    'title' => esc_html__('Twitter Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['show_soc_icon_page', '=', '1'],
                    'default' => false,
                ],
                [
                    'id' => 'soc_icon_linkedin',
                    'title' => esc_html__('Linkedin Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['show_soc_icon_page', '=', '1'],
                    'default' => false,
                ],
                [
                    'id' => 'soc_icon_pinterest',
                    'title' => esc_html__('Pinterest Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['show_soc_icon_page', '=', '1'],
                    'default' => false,
                ],
                [
                    'id' => 'soc_icon_tumblr',
                    'title' => esc_html__('Tumblr Button', 'burido'),
                    'type' => 'switch',
                    'required' => ['show_soc_icon_page', '=', '1'],
                    'default' => false,
                ],
                [
                    'id' => 'add_custom_share',
                    'title' => esc_html__('Need Additional Socials?', 'burido'),
                    'type' => 'switch',
                    'required' => ['show_soc_icon_page', '=', '1'],
                    'on' => esc_html__('Yes', 'burido'),
                    'off' => esc_html__('No', 'burido'),
                    'default' => false,
                ],
                [
                    'id' => 'share_name-1',
                    'title' => esc_html__('Social 1 - Name', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_link-1',
                    'title' => esc_html__('Social 1 - Link', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_icons-1',
                    'title' => esc_html__('Social 1 - Icon', 'burido'),
                    'type' => 'select',
                    'required' => ['add_custom_share', '=', '1'],
                    'data' => 'elusive-icons',
                ],
                [
                    'id' => 'share_name-2',
                    'title' => esc_html__('Social 2 - Name', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_link-2',
                    'title' => esc_html__('Social 2 - Link', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_icons-2',
                    'title' => esc_html__('Social 2 - Icon', 'burido'),
                    'type' => 'select',
                    'required' => ['add_custom_share', '=', '1'],
                    'data' => 'elusive-icons',
                ],
                [
                    'id' => 'share_name-3',
                    'title' => esc_html__('Social 3 - Name', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_link-3',
                    'title' => esc_html__('Social 3 - Link', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_icons-3',
                    'title' => esc_html__('Social 3 - Icon', 'burido'),
                    'type' => 'select',
                    'required' => ['add_custom_share', '=', '1'],
                    'data' => 'elusive-icons',
                ],
                [
                    'id' => 'share_name-4',
                    'type' => 'text',
                    'title' => esc_html__('Social 4 - Name', 'burido'),
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_link-4',
                    'title' => esc_html__('Social 4 - Link', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_icons-4',
                    'type' => 'select',
                    'title' => esc_html__('Social 4 - Icon', 'burido'),
                    'required' => ['add_custom_share', '=', '1'],
                    'data' => 'elusive-icons',
                ],
                [
                    'id' => 'share_name-5',
                    'title' => esc_html__('Social 5 - Name', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_link-5',
                    'title' => esc_html__('Social 5 - Link', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_icons-5',
                    'title' => esc_html__('Social 5 - Icon', 'burido'),
                    'type' => 'select',
                    'required' => ['add_custom_share', '=', '1'],
                    'data' => 'elusive-icons',
                ],
                [
                    'id' => 'share_name-6',
                    'title' => esc_html__('Social 6 - Name', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_link-6',
                    'title' => esc_html__('Social 6 - Link', 'burido'),
                    'type' => 'text',
                    'required' => ['add_custom_share', '=', '1'],
                ],
                [
                    'id' => 'share_icons-6',
                    'title' => esc_html__('Social 6 - Icon', 'burido'),
                    'type' => 'select',
                    'required' => ['add_custom_share', '=', '1'],
                    'data' => 'elusive-icons',
                ],
                [
                    'id' => 'page_socials-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'color_options_color',
            'title' => esc_html__( 'Color Settings', 'burido' ),
            'icon' => 'el-icon-tint',
            'fields' => [
                [
                    'id' => 'theme_mode',
                    'title' => esc_html__('Theme Mode', 'burido'),
                    'type' => 'button_set',
                    'options' => [
                        'light' => esc_html__('Light', 'burido'),
                        'dark' => esc_html__('Dark', 'burido'),
                    ],
                    'default' => 'light',
                ],
                [
                    'id' => 'theme-static-color',
                    'title' => esc_html__( 'Static Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#C4C4C4',
                ],
                [
                    'id' => 'light-theme_colors-start',
                    'title' => esc_html__( 'Light Theme Colors', 'burido' ),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'theme-primary-color',
                    'title' => esc_html__( 'Primary Theme Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#8088E6',
                ],
                [
                    'id' => 'theme-secondary-color',
                    'title' => esc_html__( 'Secondary Theme Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#181818',
                ],
                [
                    'id' => 'theme-tertiary-color',
                    'title' => esc_html__( 'Tertiary Theme Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#ffffff',
                ],
                [
                    'id' => 'theme-content-color',
                    'title' => esc_html__( 'Content Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#444444',
                ],
                [
                    'id' => 'theme-headings-color',
                    'title' => esc_html__( 'Headings Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#181818',
                ],
                [
                    'id' => 'body_color_bg',
                    'title' => esc_html__('Background Image/Color', 'burido'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-image' => '',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'contain',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center top',
                        'background-color' => '#FFFFFF',
                    ],
                ],
                [
                    'id' => 'form-bg-color',
                    'title' => esc_html__( 'Comments Form Background', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#F5F5F5',
                ],
                [
                    'id' => 'light-theme_colors-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'dark-theme_colors-start',
                    'title' => esc_html__('Dark Theme Colors', 'burido'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'dark-theme-primary-color',
                    'title' => esc_html__( 'Primary Theme Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#7918EE',
                ],
                [
                    'id' => 'dark-theme-secondary-color',
                    'title' => esc_html__( 'Secondary Theme Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#FFFFFF',
                ],
                [
                    'id' => 'dark-theme-tertiary-color',
                    'title' => esc_html__( 'Tertiary Theme Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#FFFFFF',
                ],
                [
                    'id' => 'dark-theme-content-color',
                    'title' => esc_html__( 'Content Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#BCBACB',
                ],
                [
                    'id' => 'dark-theme-headings-color',
                    'title' => esc_html__( 'Headings Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#FFFFFF',
                ],
                [
                    'id' => 'dark-body_color_bg',
                    'title' => esc_html__( 'Background Color', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#181818',
                ],
                [
                    'id' => 'dark-form-bg-color',
                    'title' => esc_html__( 'Comments Form Background', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#000000',
                ],
                [
                    'id' => 'dark-theme_colors-end',
                    'type' => 'section',
                    'indent' => false,
                ],

                [
                    'id' => 'light-button_colors-start',
                    'title' => esc_html__( 'Light Button Colors', 'burido' ),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'button-color-idle',
                    'title' => esc_html__( 'Button Color Idle', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#8088E6',
                ],
                [
                    'id' => 'button-bg-idle',
                    'title' => esc_html__( 'Button Background Idle', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'button-border-idle',
                    'title' => esc_html__( 'Button Border Color Idle', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'button-color-hover',
                    'title' => esc_html__( 'Button Color Hover', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#181818',
                ],
                [
                    'id' => 'button-bg-hover',
                    'title' => esc_html__( 'Button Background Hover', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'button-border-hover',
                    'title' => esc_html__( 'Button Border Color Hover', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'light-button_colors-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'dark-button_colors-start',
                    'title' => esc_html__( 'Dark Button Colors', 'burido' ),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'dark-button-color-idle',
                    'title' => esc_html__( 'Button Color Idle', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#8088E6',
                ],
                [
                    'id' => 'dark-button-bg-idle',
                    'title' => esc_html__( 'Button Background Idle', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'dark-button-border-idle',
                    'title' => esc_html__( 'Button Border Color Idle', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'dark-button-color-hover',
                    'title' => esc_html__( 'Button Color Hover', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => false,
                    'default' => '#FFFFFF',
                ],
                [
                    'id' => 'dark-button-bg-hover',
                    'title' => esc_html__( 'Button Background Hover', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'dark-button-border-hover',
                    'title' => esc_html__( 'Button Border Color Hover', 'burido' ),
                    'type' => 'color',
                    'validate' => 'color',
                    'transparent' => true,
                    'default' => 'transparent',
                ],
                [
                    'id' => 'dark-button_colors-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    //* ↓ Typography Config
    Redux::set_section(
        $theme_slug,
        [
            'id' => 'Typography',
            'title' => esc_html__('Typography', 'burido'),
            'icon' => 'el-icon-font',
        ]
    );

    $main_typography = [
        [
            'id' => 'main-font',
            'title' => esc_html__('Content Font', 'burido'),
            'line-height' => true,
            'font-size' => true,
            'subsets' => false,
            'all_styles' => true,
            'font-weight-multi' => true,
            'letter-spacing' => true,
            'defs' => [
                'font-family' => 'DM Sans',
                'font-size' => '16px',
                'line-height' => '30px',
                'font-weight' => '400',
                'font-weight-multi' => '400,500,600,700',
            ],
        ],
        [
            'id' => 'header-font',
            'title' => esc_html__('Headings Font', 'burido'),
            'font-size' => false,
            'line-height' => false,
            'subsets' => false,
            'all_styles' => true,
            'font-weight-multi' => true,
            'letter-spacing' => true,
            'defs' => [
                'google' => true,
                'font-family' => 'Plus Jakarta Sans',
                'font-weight' => '500',
                'font-weight-multi' => '300,400,500,600,700',
                'letter-spacing' => '-0.02',
            ],
        ],
        [
            'id' => 'additional-font',
            'title' => esc_html__( 'Additional Font', 'burido' ),
            'font-size' => true,
            'line-height' => true,
            'color' => false,
            'subsets' => false,
            'all_styles' => true,
            'font-weight-multi' => true,
            'letter-spacing' => true,
            'defs' => [
                'google' => true,
                'font-family' => 'Gochi Hand',
                'font-weight' => '400',
                'font-weight-multi' => '400',
            ],
        ],
    ];
    $typography = [];
    foreach ($main_typography as $key => $value) {
        $typography[] = [
            'id' => $value['id'],
            'type' => 'custom_typography',
            'title' => $value['title'],
            'color' => $value['color'] ?? '',
            'line-height' => $value['line-height'],
            'font-size' => $value['font-size'],
            'subsets' => $value['subsets'],
            'all_styles' => $value['all_styles'],
            'font-weight-multi' => $value['font-weight-multi'] ?? '',
            'subtitle' => $value['subtitle'] ?? '',
            'letter-spacing' => $value['letter-spacing'] ?? '',
            'google' => true,
            'font-style' => true,
            'font-backup' => false,
            'text-align' => false,
            'default' => $value['defs'],
        ];
    }

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'main_typography',
            'title' => esc_html__('Main Content', 'burido'),
            'subsection' => true,
            'fields' => $typography,
        ]
    );

    //* ↓ Menu Typography
    $menu_typography = [
        [
            'id' => 'menu-font',
            'title' => esc_html__('Menu Font', 'burido'),
            'color' => false,
            'line-height' => true,
            'font-size' => true,
            'subsets' => true,
            'letter-spacing' => true,
            'defs' => [
                'google' => true,
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '16px',
                'font-weight' => '600',
                'line-height' => '24px',
                'letter-spacing' => '0',
                'text-transform' => 'none',
            ],
        ],
        [
            'id' => 'sub-menu-font',
            'title' => esc_html__('Submenu Font', 'burido'),
            'color' => false,
            'line-height' => true,
            'font-size' => true,
            'subsets' => true,
            'letter-spacing' => true,
            'defs' => [
                'google' => true,
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '15px',
                'font-weight' => '600',
                'line-height' => '30px',
                'letter-spacing' => '0',
                'text-transform' => 'none',
            ],
        ],
    ];
    $menu_typography_array = [];
    foreach ($menu_typography as $key => $value) {
        $menu_typography_array[] = [
            'id' => $value['id'],
            'type' => 'custom_typography',
            'title' => $value['title'],
            'color' => $value['color'],
            'line-height' => $value['line-height'],
            'font-size' => $value['font-size'],
            'subsets' => $value['subsets'],
            'letter-spacing' => $value['letter-spacing'],
            'google' => true,
            'font-style' => true,
            'font-backup' => false,
            'text-align' => false,
            'all_styles' => false,
            'default' => $value['defs'],
        ];
    }

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'main_menu_typography',
            'title' => esc_html__('Menu', 'burido'),
            'subsection' => true,
            'fields' => $menu_typography_array
        ]
    );
    //* ↑ menu typography

    //* ↓ Headings Typography
    $headings = [
        [
            'id' => 'header-h1',
            'title' => esc_html__('‹h1›', 'burido'),
            'defs' => [
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '56px',
                'line-height' => '70px',
                'font-weight' => '500',
                'letter-spacing' => '-0.02',
                'text-transform' => 'none',
            ],
        ],
        [
            'id' => 'header-h2',
            'title' => esc_html__('‹h2›', 'burido'),
            'defs' => [
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '48px',
                'line-height' => '60px',
                'font-weight' => '500',
                'letter-spacing' => '-0.02',
                'text-transform' => 'none',
            ],
        ],
        [
            'id' => 'header-h3',
            'title' => esc_html__('‹h3›', 'burido'),
            'defs' => [
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '40px',
                'line-height' => '52px',
                'font-weight' => '500',
                'letter-spacing' => '-0.02',
                'text-transform' => 'none',
            ],
        ],
        [
            'id' => 'header-h4',
            'title' => esc_html__('‹h4›', 'burido'),
            'defs' => [
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '36px',
                'line-height' => '48px',
                'font-weight' => '500',
                'letter-spacing' => '-0.02',
                'text-transform' => 'none',
            ],
        ],
        [
            'id' => 'header-h5',
            'title' => esc_html__('‹h5›', 'burido'),
            'defs' => [
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '30px',
                'line-height' => '44px',
                'font-weight' => '500',
                'letter-spacing' => '-0.02',
                'text-transform' => 'none',
            ],
        ],
        [
            'id' => 'header-h6',
            'title' => esc_html__('‹h6›', 'burido'),
            'defs' => [
                'font-family' => 'Plus Jakarta Sans',
                'font-size' => '26px',
                'line-height' => '36px',
                'font-weight' => '500',
                'letter-spacing' => '-0.02',
                'text-transform' => 'none',
            ],
        ],
    ];
    $headings_array = [];
    foreach ($headings as $key => $heading) {
        $headings_array[] = [
            'id' => $heading['id'],
            'type' => 'custom_typography',
            'title' => $heading['title'],
            'google' => true,
            'font-backup' => false,
            'font-size' => true,
            'line-height' => true,
            'color' => false,
            'word-spacing' => false,
            'letter-spacing' => true,
            'text-align' => false,
            'text-transform' => true,
            'default' => $heading['defs'],
        ];
    }

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'main_headings_typography',
            'title' => esc_html__('Headings', 'burido'),
            'subsection' => true,
            'fields' => $headings_array
        ]
    );

    if (class_exists('WooCommerce')) {
        Redux::set_section(
            $theme_slug,
            [
                'id' => 'shop-option',
                'title' => esc_html__('Shop', 'burido'),
                'icon' => 'el-icon-shopping-cart',
                'fields' => []
            ]
        );

        Redux::set_section(
            $theme_slug,
            [
                'id' => 'shop-catalog-option',
                'title' => esc_html__('Catalog', 'burido'),
                'subsection' => true,
                'fields' => [
                    [
                        'id' => 'shop_body_color_bg',
                        'title' => esc_html__('Body Background Image/Color', 'burido'),
                        'type' => 'background',
                        'preview' => false,
                        'preview_media' => true,
                        'background-color' => true,
                        'transparent' => false,
                        'default' => [
                            'background-image' => '',
                            'background-repeat' => 'no-repeat',
                            'background-size' => 'contain',
                            'background-attachment' => 'scroll',
                            'background-position' => 'center top',
                            'background-color' => '',
                        ],
                    ],
                    [
                        'id' => 'shop_catalog__page_title_switch',
                        'title' => esc_html__('Use Page Title?', 'burido'),
                        'type' => 'switch',
                        'required' => ['page_title_switch', '=', true],
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_catalog__page_title_bg_image',
                        'title' => esc_html__('Page Title Background Image', 'burido'),
                        'type' => 'background',
                        'required' => [
                            ['page_title_switch', '=', true],
                            ['shop_catalog__page_title_switch', '=', true],
                        ],
                        'preview' => false,
                        'preview_media' => true,
                        'background-color' => false,
                        'default' => [
                            'background-repeat' => 'repeat',
                            'background-size' => 'cover',
                            'background-attachment' => 'scroll',
                            'background-position' => 'center center',
                            'background-color' => '',
                        ]
                    ],
                    [
                        'id' => 'shop_catalog_header-start',
                        'title' => esc_html__('Header', 'burido'),
                        'type' => 'section',
                        'required' => ['header_building_tool', '=', 'elementor'],
                        'indent' => true,
                    ],
                    [
                        'id' => 'shop_catalog_header_conditional',
                        'title' => esc_html__('Header', 'burido'),
                        'type' => 'switch',
                        'on' => esc_html__('Default', 'burido'),
                        'off' => esc_html__('Custom', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_catalog_header_page_select',
                        'type' => 'select',
                        'title' => esc_html__('Header Template', 'burido'),
                        'required' => ['shop_catalog_header_conditional', '=', ''],
                        'desc' => wp_kses(
                            sprintf(
                                '%s <a href="%s" target="_blank">%s</a> %s<br> %s',
                                __('Selected Template will be used for all Shop pages by default. You can edit/create Header Template in the', 'burido'),
                                admin_url('edit.php?post_type=header'),
                                __('Header Templates', 'burido'),
                                __('dashboard tab.', 'burido'),
                                burido_quick_tip(
                                    sprintf(
                                        __('Note: fine tuning is available through the Elementor\'s <code>Post Settings</code> tab, which is located <a href="%s" target="_blank">here</a>', 'burido'),
                                        get_template_directory_uri() . '/core/admin/img/dashboard/quick_tip__header_extra_options.png'
                                    )
                                )
                            ),
                            ['a' => ['href' => true, 'target' => true], 'br' => [], 'span' => ['class' => true], 'i' => ['class' => true], 'code' => []]
                        ),
                        'data' => 'posts',
                        'args' => [
                            'post_type' => 'header',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                        ],
                    ],
                    [
                        'id' => 'shop_catalog_sidebar-start',
                        'title' => esc_html__('Sidebar Settings', 'burido'),
                        'type' => 'section',
                        'indent' => true,
                    ],
                    [
                        'id' => 'shop_catalog_sidebar_layout',
                        'title' => esc_html__('Sidebar Layout', 'burido'),
                        'type' => 'image_select',
                        'options' => [
                            'none' => [
                                'alt' => esc_html__('None', 'burido'),
                                'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                            ],
                            'left' => [
                                'alt' => esc_html__('Left', 'burido'),
                                'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                            ],
                            'right' => [
                                'alt' => esc_html__('Right', 'burido'),
                                'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                            ],
                        ],
                        'default' => 'left',
                    ],
                    [
                        'id' => 'shop_catalog_sidebar_def',
                        'title' => esc_html__('Shop Catalog Sidebar', 'burido'),
                        'type' => 'select',
                        'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                        'data' => 'sidebars',
                        'default' => 'shop_products',
                    ],
                    [
                        'id' => 'shop_catalog_sidebar_def_width',
                        'title' => esc_html__('Shop Sidebar Width', 'burido'),
                        'type' => 'button_set',
                        'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                        'options' => [
                            '9' => esc_html( '25%' ),
                            '8' => esc_html( '33%' ),
                        ],
                        'default' => '9',
                    ],
                    [
                        'id' => 'shop_catalog_sidebar_sticky',
                        'title' => esc_html__('Sticky Sidebar', 'burido'),
                        'type' => 'switch',
                        'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                        'default' => false,
                    ],
                    [
                        'id' => 'shop_catalog_sidebar_gap',
                        'title' => esc_html__( 'Sidebar Side Gap', 'burido' ),
                        'type' => 'select',
                        'required' => [ 'shop_catalog_sidebar_layout', '!=', 'none' ],
                        'options' => [
                            'def' => esc_html__( 'Default', 'burido' ),
                            '0' => esc_html( '15' ),
                            '15' => esc_html( '30' ),
                            '20' => esc_html( '35' ),
                            '25' => esc_html( '40' ),
                            '30' => esc_html( '45' ),
                            '35' => esc_html( '50' ),
                            '40' => esc_html( '55' ),
                            '45' => esc_html( '60' ),
                        ],
                        'default' => 'def',
                    ],
                    [
                        'id' => 'shop_catalog_sidebar-end',
                        'type' => 'section',
                        'indent' => false,
                    ],
                    [
                        'id' => 'shop_catalog_filters-start',
                        'title' => esc_html__('Filters Setting', 'burido'),
                        'type' => 'section',
                        'indent' => true,
                    ],
                    [
                        'id' => 'shop_filters_switcher',
                        'title' => esc_html__('Enable Filters', 'burido'),
                        'type' => 'switch',
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => false,
                    ],
                    [
                        'id' => 'shop_filters_sidebar_def',
                        'title' => esc_html__('Product Catalog Filters', 'burido'),
                        'type' => 'select',
                        'required' => ['shop_filters_switcher', '=', true],
                        'data' => 'sidebars',
                        'default' => 'shop_filters',
                    ],
                    [
                        'id' => 'shop_filters_sidebar_columns_width',
                        'title' => esc_html__('Adjust each Column Width', 'burido'),
                        'type' => 'button_set',
                        'required' => ['shop_filters_switcher', '=', true],
                        'options' => [
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                        ],
                    ],
                    [
                        'id' => 'filters_columns_1',
                        'title' => esc_html__('Column 1 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '1'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'filters_columns_2',
                        'title' => esc_html__('Column 2 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '2'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'filters_columns_3',
                        'title' => esc_html__('Column 3 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '3'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'filters_columns_4',
                        'title' => esc_html__('Column 4 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '4'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'filters_columns_5',
                        'title' => esc_html__('Column 5 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '5'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'filters_columns_6',
                        'title' => esc_html__('Column 6 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '6'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'filters_columns_7',
                        'title' => esc_html__('Column 7 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '7'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'filters_columns_8',
                        'title' => esc_html__('Column 8 Width', 'burido'),
                        'type' => 'dimensions',
                        'units' => ['px','%'],
                        'required' => [
                            'shop_filters_sidebar_columns_width', '=', '8'
                        ],
                        'width' => true,
                        'height' => false,
                        'default' => ['width' => 20, 'units' => '%'],
                    ],
                    [
                        'id' => 'shop_filters_sidebar_reset_switcher',
                        'title' => esc_html__('Reset Switcher', 'burido'),
                        'desc' => esc_html__('This button only works with the Wordpress Plugin \'Advanced AJAX Product Filters for WooCommerce\'', 'burido'),
                        'type' => 'switch',
                        'required' => ['shop_filters_switcher', '=', true],
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_catalog_filters-end',
                        'type' => 'section',
                        'indent' => false,
                    ],
                    [
                        'id' => 'shop_products_appearance-start',
                        'title' => esc_html__('Appearance', 'burido'),
                        'type' => 'section',
                        'indent' => true,
                    ],
                    [
                        'id' => 'shop_column',
                        'title' => esc_html__('Shop Column', 'burido'),
                        'type' => 'button_set',
                        'options' => [
                            '1' => esc_html('1'),
                            '2' => esc_html('2'),
                            '3' => esc_html('3'),
                            '4' => esc_html('4'),
                        ],
                        'default' => '3',
                    ],
                    [
                        'id' => 'shop_products_per_page',
                        'title' => esc_html__('Products per page', 'burido'),
                        'type' => 'spinner',
                        'min' => '1',
                        'max' => '100',
                        'default' => '12',
                    ],
                    [
                        'id' => 'use_secondary_image',
                        'title' => esc_html__('Use Secondary Image on Hover?', 'burido'),
                        'type' => 'switch',
                    ],
                    [
                        'id' => 'use_animation_shop',
                        'title' => esc_html__('Use Animation Shop?', 'burido'),
                        'type' => 'switch',
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_catalog_animation_style',
                        'title' => esc_html__('Animation Style', 'burido'),
                        'type' => 'select',
                        'required' => ['use_animation_shop', '=', true],
                        'select2' => ['allowClear' => false],
                        'options' => [
                            'fade-in' => esc_html__('Fade In', 'burido'),
                            'slide-top' => esc_html__('Slide Top', 'burido'),
                            'slide-bottom' => esc_html__('Slide Bottom', 'burido'),
                            'slide-left' => esc_html__('Slide Left', 'burido'),
                            'slide-right' => esc_html__('Slide Right', 'burido'),
                            'zoom' => esc_html__('Zoom', 'burido'),
                        ],
                        'default' => 'slide-left',
                    ],
                    [
                        'id' => 'shop_products_stars',
                        'title' => esc_html__('Star Rating', 'burido'),
                        'type' => 'switch',
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_products_overlay',
                        'title' => esc_html__('Overlay Background Color for Products', 'burido'),
                        'type' => 'color_rgba',
                        'mode' => 'background',
                        'default' => [
                            'alpha' => '0',
                            'rgba' => 'rgba(255, 255, 255, 0)',
                            'color' => '#ffffff',
                        ],
                    ],
                ]
            ]
        );

        Redux::set_section(
            $theme_slug,
            [
                'id' => 'shop-single-option',
                'title' => esc_html__('Single', 'burido'),
                'subsection' => true,
                'fields' => [
                    [
                        'id' => 'shop_single_body-start',
                        'title' => esc_html__('Body', 'burido'),
                        'type' => 'section',
                        'indent' => true,
                    ],
                    [
                        'id' => 'shop_single_body_color_bg',
                        'title' => esc_html__('Background Image/Color', 'burido'),
                        'type' => 'background',
                        'preview' => false,
                        'preview_media' => true,
                        'background-color' => true,
                        'transparent' => false,
                        'default' => [
                            'background-image' => '',
                            'background-repeat' => 'no-repeat',
                            'background-size' => 'contain',
                            'background-attachment' => 'scroll',
                            'background-position' => 'center top',
                            'background-color' => '',
                        ],
                    ],
                    [
                        'id' => 'shop_single_body-end',
                        'type' => 'section',
                        'indent' => false,
                    ],
                    [
                        'id' => 'shop_single__page_title_switch',
                        'title' => esc_html__('Use Page Title?', 'burido'),
                        'type' => 'switch',
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_single_page_title-start',
                        'title' => esc_html__('Page Title Settings', 'burido'),
                        'type' => 'section',
                        'required' => ['shop_single__page_title_switch', '=', true],
                        'indent' => true,
                    ],
                    [
                        'id' => 'shop_title_conditional',
                        'title' => esc_html__('Page Title Text', 'burido'),
                        'type' => 'switch',
                        'on' => esc_html__('Post Type Name', 'burido'),
                        'off' => esc_html__('Post Title', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_single_title_align',
                        'title' => esc_html__('Title Alignment', 'burido'),
                        'type' => 'button_set',
                        'options' => [
                            'left' => esc_html__('Left', 'burido'),
                            'center' => esc_html__('Center', 'burido'),
                            'right' => esc_html__('Right', 'burido'),
                        ],
                        'default' => 'center',
                    ],
                    [
                        'id' => 'shop_single_breadcrumbs_block_switch',
                        'title' => esc_html__('Breadcrumbs Display', 'burido'),
                        'type' => 'switch',
                        'required' => ['page_title_breadcrumbs_switch', '=', true],
                        'on' => esc_html__('Block', 'burido'),
                        'off' => esc_html__('Inline', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_single_breadcrumbs_align',
                        'title' => esc_html__('Breadcrumbs Alignment', 'burido'),
                        'type' => 'button_set',
                        'required' => [
                            ['page_title_breadcrumbs_switch', '=', true],
                            ['shop_single_breadcrumbs_block_switch', '=', true]
                        ],
                        'options' => [
                            'left' => esc_html__('Left', 'burido'),
                            'center' => esc_html__('Center', 'burido'),
                            'right' => esc_html__('Right', 'burido'),
                        ],
                        'default' => 'center',
                    ],
                    [
                        'id' => 'shop_single__page_title_bg_switch',
                        'title' => esc_html__('Use Background Image/Color?', 'burido'),
                        'type' => 'switch',
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_single__page_title_bg_image',
                        'title' => esc_html__('Background Image/Color', 'burido'),
                        'type' => 'background',
                        'required' => ['shop_single__page_title_bg_switch', '=', true],
                        'preview' => false,
                        'preview_media' => true,
                        'background-color' => true,
                        'transparent' => false,
                        'default' => [
                            'background-repeat' => 'repeat',
                            'background-size' => 'cover',
                            'background-attachment' => 'scroll',
                            'background-position' => 'center center',
                            'background-color' => '',
                        ],
                    ],
                    [
                        'id' => 'shop_single__page_title_padding',
                        'title' => esc_html__('Paddings Top/Bottom', 'burido'),
                        'type' => 'spacing',
                        'mode' => 'padding',
                        'all' => false,
                        'bottom' => true,
                        'top' => true,
                        'left' => false,
                        'right' => false,
                    ],
                    [
                        'id' => 'shop_single__page_title_margin',
                        'title' => esc_html__('Margin Bottom', 'burido'),
                        'type' => 'spacing',
                        'mode' => 'margin',
                        'all' => false,
                        'bottom' => true,
                        'top' => false,
                        'left' => false,
                        'right' => false,
                        'default' => ['margin-bottom' => '50'],
                    ],
                    [
                        'id' => 'shop_single_page_title-end',
                        'type' => 'section',
                        'indent' => false,
                    ],
                    [
                        'id' => 'shop_single_sidebar-start',
                        'title' => esc_html__('Sidebar Settings', 'burido'),
                        'type' => 'section',
                        'indent' => true,
                    ],
                    [
                        'id' => 'shop_single_sidebar_layout',
                        'title' => esc_html__('Sidebar Layout', 'burido'),
                        'type' => 'image_select',
                        'options' => [
                            'none' => [
                                'alt' => esc_html__('None', 'burido'),
                                'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                            ],
                            'left' => [
                                'alt' => esc_html__('Left', 'burido'),
                                'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                            ],
                            'right' => [
                                'alt' => esc_html__('Right', 'burido'),
                                'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                            ],
                        ],
                        'default' => 'none',
                    ],
                    [
                        'id' => 'shop_single_sidebar_def',
                        'title' => esc_html__('Sidebar Template', 'burido'),
                        'type' => 'select',
                        'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                        'data' => 'sidebars',
                    ],
                    [
                        'id' => 'shop_single_sidebar_def_width',
                        'title' => esc_html__('Sidebar Width', 'burido'),
                        'type' => 'button_set',
                        'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                        'options' => [
                            '9' => esc_html( '25%' ),
                            '8' => esc_html( '33%' ),
                        ],
                        'default' => '9',
                    ],
                    [
                        'id' => 'shop_single_sidebar_sticky',
                        'title' => esc_html__('Sticky Sidebar', 'burido'),
                        'type' => 'switch',
                        'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                        'default' => false,
                    ],
                    [
                        'id' => 'shop_single_sidebar_gap',
                        'title' => esc_html__( 'Sidebar Side Gap', 'burido' ),
                        'type' => 'select',
                        'required' => [ 'shop_single_sidebar_layout', '!=', 'none' ],
                        'options' => [
                            'def' => esc_html__( 'Default', 'burido' ),
                            '0' => esc_html( '15' ),
                            '15' => esc_html( '30' ),
                            '20' => esc_html( '35' ),
                            '25' => esc_html( '40' ),
                            '30' => esc_html( '45' ),
                            '35' => esc_html( '50' ),
                            '40' => esc_html( '55' ),
                            '45' => esc_html( '60' ),
                        ],
                        'default' => 'def',
                    ],
                    [
                        'id' => 'shop_single_sidebar-end',
                        'type' => 'section',
                        'indent' => false,
                    ],
                ]
            ]
        );

        Redux::set_section(
            $theme_slug,
            [
                'title' => esc_html__('Related', 'burido'),
                'id' => 'shop-related-option',
                'subsection' => true,
                'fields' => [
                    [
                        'id' => 'shop_related_columns',
                        'title' => esc_html__('Related products column', 'burido'),
                        'type' => 'button_set',
                        'options' => [
                            '1' => esc_html('1'),
                            '2' => esc_html('2'),
                            '3' => esc_html('3'),
                            '4' => esc_html('4'),
                        ],
                        'default' => '4',
                    ],
                    [
                        'id' => 'shop_r_products_per_page',
                        'title' => esc_html__('Related products per page', 'burido'),
                        'type' => 'spinner',
                        'min' => '1',
                        'max' => '100',
                        'default' => '4',
                    ],
                ]
            ]
        );

        Redux::set_section(
            $theme_slug,
            [
                'title' => esc_html__('Cart', 'burido'),
                'id' => 'shop-cart-option',
                'subsection' => true,
                'fields' => [
                    [
                        'id' => 'shop_cart__page_title_switch',
                        'title' => esc_html__('Use Page Title?', 'burido'),
                        'type' => 'switch',
                        'required' => ['page_title_switch', '=', true],
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_cart__page_title_bg_image',
                        'title' => esc_html__('Page Title Background Image', 'burido'),
                        'type' => 'background',
                        'required' => [
                            ['page_title_switch', '=', true],
                            ['shop_cart__page_title_switch', '=', true],
                        ],
                        'background-color' => false,
                        'preview_media' => true,
                        'preview' => false,
                        'default' => [
                            'background-repeat' => 'repeat',
                            'background-size' => 'cover',
                            'background-attachment' => 'scroll',
                            'background-position' => 'center center',
                            'background-color' => '',
                        ],
                    ],
                ]
            ]
        );

        Redux::set_section(
            $theme_slug,
            [
                'id' => 'shop-checkout-option',
                'title' => esc_html__('Checkout', 'burido'),
                'subsection' => true,
                'fields' => [
                    [
                        'id' => 'shop_checkout__page_title_switch',
                        'title' => esc_html__('Use Page Title?', 'burido'),
                        'type' => 'switch',
                        'required' => ['page_title_switch', '=', true],
                        'on' => esc_html__('Use', 'burido'),
                        'off' => esc_html__('Hide', 'burido'),
                        'default' => true,
                    ],
                    [
                        'id' => 'shop_checkout__page_title_bg_image',
                        'title' => esc_html__('Page Title Background Image', 'burido'),
                        'type' => 'background',
                        'required' => [
                            ['page_title_switch', '=', true],
                            ['shop_checkout__page_title_switch', '=', true],
                        ],
                        'background-color' => false,
                        'preview_media' => true,
                        'preview' => false,
                        'default' => [
                            'background-repeat' => 'repeat',
                            'background-size' => 'cover',
                            'background-attachment' => 'scroll',
                            'background-position' => 'center center',
                            'background-color' => '',
                        ],
                    ],
                ]
            ]
        );
    }

    $advanced_fields = [
        [
            'id' => 'advanced_warning',
            'title' => esc_html__('Attention! This tab stores functionality that can harm site reliability.', 'burido'),
            'type' => 'info',
            'desc' => esc_html__('Site troublefree operation is not ensured, if any of the following options is changed.', 'burido'),
            'style' => 'critical',
            'icon' => 'el el-warning-sign',
        ],
        [
            'id' => 'advanced_divider',
            'type' => 'divide'
        ],
        [
            'id' => 'advanced-wp-start',
            'title' => esc_html__('WordPress', 'burido'),
            'type' => 'section',
            'indent' => true,
        ],
        [
            'id' => 'disable_wp_gutenberg',
            'title' => esc_html__('Gutenberg Stylesheet', 'burido'),
            'type' => 'switch',
            'desc' => esc_html__('Dequeue CSS files.', 'burido') . burido_quick_tip(
                wp_kses(
                    __('Eliminates <code>wp-block-library-css</code> stylesheet. <br>Before disabling ensure that Gutenberg editor is not used anywhere throughout the site.', 'burido'),
                    ['br' => [], 'code' => []]
                )
            ),
            'on' => esc_html__('Dequeue', 'burido'),
            'off' => esc_html__('Default', 'burido'),
        ],
        [
            'id' => 'wordpress_widgets',
            'title' => esc_html__('WordPress Widgets', 'burido'),
            'type' => 'switch',
            'on' => esc_html__('Classic', 'burido'),
            'off' => esc_html__('Gutenberg', 'burido'),
            'default' => true,
        ],
        [
            'id' => 'wgl_input_style',
            'title' => esc_html__('Checkboxes and Radio Buttons Styling', 'burido'),
            'type' => 'switch',
            'on' => esc_html__('Disable', 'burido'),
            'off' => esc_html__('Default', 'burido'),
            'default' => false,
        ],
        [
            'id' => 'advanced-wp-end',
            'type' => 'section',
            'indent' => false,
        ],
    ];

    if (class_exists('Elementor\Plugin')) {
        $advanced_elementor = [
            [
                'id' => 'advanced-elementor-start',
                'title' => esc_html__('Elementor', 'burido'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'disable_elementor_googlefonts',
                'title' => esc_html__('Google Fonts', 'burido'),
                'type' => 'switch',
                'desc' => esc_html__('Dequeue font pack.', 'burido') . burido_quick_tip(sprintf(
                    '%s <a href="%s" target="_blank">%s</a>%s',
                    esc_html__('See: ', 'burido'),
                    esc_url('https://docs.elementor.com/article/286-speed-up-a-slow-site'),
                    esc_html__('Optimizing a Slow Site w/ Elementor', 'burido'),
                    wp_kses(
                        __('<br>Note: breaks all fonts selected within <code>Group_Control_Typography</code> (if any). Has no affect on <code>Theme Options->Typography</code> fonts.', 'burido'),
                        ['br' => [], 'code' => []]
                    )
                )),
                'on' => esc_html__('Disable', 'burido'),
                'off' => esc_html__('Default', 'burido'),
            ],
            [
                'id' => 'disable_elementor_fontawesome',
                'title' => esc_html__('Font Awesome Pack', 'burido'),
                'type' => 'switch',
                'desc' => esc_html__('Dequeue icon pack.', 'burido')
                    . burido_quick_tip(esc_html__('Note: Font Awesome is essential for Burido theme. Disable only if it already enqueued by some other plugin.', 'burido')),
                'on' => esc_html__('Disable', 'burido'),
                'off' => esc_html__('Default', 'burido'),
            ],
            [
                'id' => 'advanced-elelemntor-end',
                'type' => 'section',
                'indent' => false,
            ],
        ];
        array_push($advanced_fields, ...$advanced_elementor);
    }

    Redux::set_section(
        $theme_slug,
        [
            'id' => 'advanced',
            'title' => esc_html__('Advanced', 'burido'),
            'icon' => 'el el-warning-sign',
            'fields' => $advanced_fields
        ]
    );
});