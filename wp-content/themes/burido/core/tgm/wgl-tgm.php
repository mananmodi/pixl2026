<?php

require_once get_template_directory() . '/core/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'burido_register_required_plugins');

function burido_register_required_plugins()
{
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = [
        [
            'name' => esc_html__('WGL Extensions', 'burido'),
            'slug' => 'wgl-extensions',
            'source' => get_template_directory() . '/core/tgm/plugins/wgl-extensions.zip',
            'required' => true,
            'version' => '1.0.42',
            'force_activation' => false,
            'force_deactivation' => false,
        ],
        [
            'name' => esc_html__('Burido Core', 'burido'),
            'slug' => 'burido-core',
            'source' => get_template_directory() . '/core/tgm/plugins/burido-core.zip',
            'required' => true,
            'version' => '1.1.0',
            'force_activation' => false,
            'force_deactivation' => false,
        ],
        [
            'name' => esc_html__('Elementor', 'burido'),
            'slug' => 'elementor',
            'required' => true,
        ],
        [
            'name' => esc_html__('Revolution Slider', 'burido'),
            'slug' => 'revslider',
            'source' => get_template_directory() . '/core/tgm/plugins/revslider.zip',
            'version' => '6.7.37',
        ],
        [
            'name' => esc_html__('WooCommerce', 'burido'),
            'slug' => 'woocommerce',
        ],
        [
            'name' => esc_html__('Contact Form 7', 'burido'),
            'slug' => 'contact-form-7',
        ],
        [
            'name' => esc_html__('WPC Smart Compare for WooCommerce', 'burido'),
            'slug' => 'woo-smart-compare',
        ],
        [
            'name' => esc_html__('WPC Smart Wishlist for WooCommerce', 'burido'),
            'slug' => 'woo-smart-wishlist',
        ],
        [
            'name' => esc_html__('Advanced AJAX Product Filters', 'burido'),
            'slug' => 'woocommerce-ajax-filters',
        ],
    ];

    /** Array of configuration settings. */
    $config = [
        'default_path' => '', // Default absolute path to pre-packaged plugins.
        'menu' => 'tgmpa-install-plugins',  // Menu slug.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => false, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
        'strings' => [
            'page_title' => esc_html__('Install Required Plugins', 'burido'),
            'menu_title' => esc_html__('Install Plugins', 'burido'),
            'installing' => esc_html__('Installing Plugin: %s', 'burido'), // %s = plugin name.
            'oops' => esc_html__('Something went wrong with the plugin API.', 'burido'),
            'notice_can_install_required' => esc_html__('This theme requires the following plugins: %1$s.', 'burido'), // %1$s = plugin name(s).
            'notice_can_install_recommended' => esc_html__('This theme recommends the following plugins: %1$s.', 'burido'), // %1$s = plugin name(s).
            'notice_cannot_install' => esc_html__('Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'burido'), // %1$s = plugin name(s).
            'notice_can_activate_required' => esc_html__('The following required plugins are currently inactive: %1$s.', 'burido'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => esc_html__('The following recommended plugins are currently inactive: %1$s.', 'burido'), // %1$s = plugin name(s).
            'notice_cannot_activate' => esc_html__('Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'burido'), // %1$s = plugin name(s).
            'notice_ask_to_update' => esc_html__('The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'burido'), // %1$s = plugin name(s).
            'notice_cannot_update' => esc_html__('Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'burido'), // %1$s = plugin name(s).
            'install_link' => esc_html__('Begin installing plugins', 'burido'),
            'activate_link' => esc_html__('Begin activating plugins', 'burido'),
            'return' => esc_html__('Return to Required Plugins Installer', 'burido'),
            'plugin_activated' => esc_html__('Plugin activated successfully.', 'burido'),
            'complete' => esc_html__('All plugins installed and activated successfully. %s', 'burido'), // %s = dashboard link.
            'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        ]
    ];

    tgmpa($plugins, $config);
}
