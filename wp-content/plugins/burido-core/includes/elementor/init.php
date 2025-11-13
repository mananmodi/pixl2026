<?php

define('WGL_ELEMENTOR_MODULE_URL', plugins_url('/', __FILE__));
define('WGL_ELEMENTOR_MODULE_PATH', plugin_dir_path(__FILE__));
define('WGL_ELEMENTOR_MODULE_FILE', __FILE__);

use Elementor\{
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Background,
    Plugin
};
use WGL_Extensions\WGL_Framework_Global_Variables as WGL_Globals;

if (!class_exists('WGL_Elementor_Module')) {
    /**
     * WGL Elementor Module
     *
     *
     * @package burido-core\includes\elementor
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     */
    class WGL_Elementor_Module
    {
        /**
         * @var string The defualt path to elementor dir on this plugin.
         */
        private $dir_path;

        private static $instance;

        public $sections = [];

        const CACHE_META_KEY = '_elementor_element_cache';

        public function __construct()
        {
            $this->dir_path = plugin_dir_path(__FILE__);

            add_action('plugins_loaded', [$this, 'elementor_setup']);

            add_action('elementor/init', [$this, 'optimize_elementor'], 5);
            add_action('elementor/init', [$this, 'inject_wgl_categories']);
            add_action('elementor/init', [$this, 'elementor_libraries']);

            add_filter('elementor/widgets/wordpress/widget_args', [$this, 'wgl_widget_args'], 10, 1); // WPCS: spelling ok.

            add_action('elementor/init', [$this, 'add_hooks']);
            add_action('elementor/init', [$this, 'wgl_elementor_settings_init']);
        }

        public function add_hooks()
        {
            add_action('elementor/element/section/section_advanced/before_section_end', [$this, 'wgl_change_min_zindex'], 20, 2);
	        add_action('elementor/element/column/section_advanced/before_section_end', [$this, 'wgl_change_min_zindex'], 20, 2);

            // Empowers overflow hidden
            add_action('elementor/element/section/section_layout/before_section_end', [$this, 'empowers_column_overflow'], 20, 2);

	        add_action('elementor/element/common/_section_style/before_section_end', [$this, 'wgl_pointer_events'], 20, 2);
            add_action('elementor/element/section/section_advanced/before_section_end', [$this, 'wgl_pointer_events'], 20, 2);
            add_action('elementor/element/column/section_advanced/before_section_end', [$this, 'wgl_pointer_events'], 20, 2);
            add_action('elementor/element/container/section_layout_additional_options/before_section_end', [$this, 'wgl_pointer_events'], 10, 2);

            add_action('elementor/element/common/_section_responsive/before_section_end', [$this, 'wgl_hide_under'], 20, 2);

            add_filter('wgl_opacity_by_gradient_newest', '__return_true');

            // Add WGL extension control section to Section panel
            add_action('elementor/frontend/section/before_render', [$this, 'extended_row_render'], 10, 1);
            add_action('elementor/frontend/container/before_render', [$this, 'extended_row_render'], 10, 1);

            add_action('elementor/element/section/section_typo/after_section_end', [$this, 'extended_animation_options'], 10, 2);
            add_action('elementor/element/container/_section_transform/after_section_end', [$this, 'extended_animation_options'], 10, 2);

            add_action('elementor/element/container/_section_transform/after_section_end', [$this, 'extended_container_stretch_section_options'], 10, 2);

            add_action('elementor/element/section/section_typo/after_section_end', [$this, 'extended_clip_path'], 10, 2);
            add_action('elementor/element/container/_section_transform/after_section_end', [$this, 'extended_clip_path'], 10, 2);

            // Add Compatible for new feature Element Caching
            if('disable' !== get_option( 'elementor_element_cache_ttl', '' )){
                add_filter('elementor/frontend/builder_content_data', [ $this, 'cache_page_elementor'], 10, 2);
            }

            add_filter('elementor/controls/animations/additional_animations', [ $this, 'add_extensions_animations']);
        }

        public function wgl_elementor_settings_init() {
            $this->requiere_all_files('settings');
        }

        /**
         * Eliminate redundant functionality
         * and speed up website load
         */
        public function optimize_elementor()
        {
            if (!class_exists('\WGL_Framework')) {
                return;
            }

            if (WGL_Framework::get_option('disable_elementor_googlefonts')) {
                /**
                 * Disable Google Fonts
                 * Note: breaks all fonts selected within `Group_Control_Typography` (if any).
                 */
                add_filter('elementor/frontend/print_google_fonts', '__return_false');
            }

            if (WGL_Framework::get_option('disable_elementor_fontawesome')) {
                /** Disable Font Awesome pack */
                add_action('elementor/frontend/after_register_styles', function () {
                    foreach (['solid', 'regular', 'brands'] as $style) {
                        wp_deregister_style('elementor-icons-fa-' . $style);
                    }
                }, 20);
            }
        }

        public function elementor_libraries()
        {
            $this->init_portfolio_archive_template();
            $this->init_team_archive_template();
            $this->init_mobile_drawer_template();
        }

        public function init_portfolio_archive_template()
        {
            require_once $this->dir_path . 'library/cpt_archive/wgl-portfolio-archive.php';
            add_action('elementor/documents/register', [ $this, 'register_porfolio_archive_types' ], 0);
            add_filter('single_template', [ \WGL_Extensions\Library\WGL_Portfolio_Archive::get_class_full_name(), 'get_single_template' ]);
        }

        public function register_porfolio_archive_types()
        {
            Plugin::instance()->documents->register_document_type(\WGL_Extensions\Library\WGL_Portfolio_Archive::$name, \WGL_Extensions\Library\WGL_Portfolio_Archive::get_class_full_name());
        }

        public function init_team_archive_template()
        {
            require_once $this->dir_path . 'library/cpt_archive/wgl-team-archive.php';
            add_action('elementor/documents/register', [ $this, 'register_team_archive_types' ], 0);
            add_filter('single_template', [ \WGL_Extensions\Library\WGL_Team_Archive::get_class_full_name(), 'get_single_template' ]);
        }

        public function register_team_archive_types()
        {
            Plugin::instance()->documents->register_document_type(\WGL_Extensions\Library\WGL_Team_Archive::$name, \WGL_Extensions\Library\WGL_Team_Archive::get_class_full_name());
        }

        public function init_mobile_drawer_template()
        {
            require_once $this->dir_path . 'library/mobile_drawer/wgl-mobile-drawer.php';
            add_action('elementor/documents/register', [ $this, 'register_mobile_drawer_types' ], 0);
            add_action('elementor/documents/register_controls', [ \WGL_Extensions\Library\WGL_Mobile_Drawer::get_class_full_name(), 'inject_options_post' ], 10, 1);
            add_filter('single_template', [ \WGL_Extensions\Library\WGL_Mobile_Drawer::get_class_full_name(), 'get_single_template' ]);
        }

        public function register_mobile_drawer_types()
        {
            Plugin::instance()->documents->register_document_type(\WGL_Extensions\Library\WGL_Mobile_Drawer::$name, \WGL_Extensions\Library\WGL_Mobile_Drawer::get_class_full_name());
        }

        public function elementor_setup()
        {
            $this->requiere_all_files('includes');
            $this->requiere_all_files('templates');

            /**
             * Check if Elementor installed and activated
             * @see https://developers.elementor.com/creating-an-extension-for-elementor/
             */
            if (!did_action('elementor/loaded')) {
                return;
            }

            $this->init_addons();
        }

        /**
         * Load required file for addons integration
         */
        public function init_addons()
        {
            add_action('elementor/widgets/register', [$this, 'widgets_area']);

            add_action('elementor/frontend/after_register_scripts', [$this, 'frontend_scripts_registration']);
            add_action('wp_enqueue_scripts', [ $this, 'register_dependencies' ], 9999);
            add_action('elementor/frontend/before_enqueue_scripts', [$this, 'enqueue_scripts']);

            add_action( 'init', [ $this, 'add_wpml_support' ] );

            $this->init_all_modules();
        }

        public function init_all_modules()
        {
            foreach (glob($this->dir_path . 'modules/' . '*.php') as $file_name) {
                $base = basename(str_replace('.php', '', $file_name));
                $class = ucwords(str_replace('-', ' ', $base));
                $class = str_replace(' ', '_', $class);
                $class = sprintf('WGL_Extensions\Modules\%s', $class);

                // Class File
                require_once $file_name;

                if (class_exists($class)) {
                    new $class();
                }
            }
        }

        /**
         * Register addon by file name.
         */
        public function register_controls_addon($file_name)
        {
            $controls_manager = Plugin::$instance->controls_manager;

            $base = basename(str_replace('.php', '', $file_name));
            $class = ucwords(str_replace('-', ' ', $base));
            $class = str_replace(' ', '_', $class);
            $class = sprintf('WGL_Extensions\Controls\%s', $class);

            // Class Constructor File
            require_once $file_name;

            if (class_exists($class)) {
                $controls_manager->register(new $class);
            }
        }

        /**
         * Load widgets require function
         */
        public function widgets_area()
        {
            $this->requiere_all_files('widgets');
            $this->requiere_all_files('header');
        }

        private function requiere_all_files($require_file = 'widgets', $wpml_translate = false)
        {
            $template_names = [];
            $template_path = '/wgl-extensions/elementor/'.$require_file.'/';
            $plugin_template_path = $this->dir_path . $require_file.'/';
            $ext_template_path = WGL_EXTENSIONS_ELEMENTOR_PATH . $require_file.'/';

            foreach (glob($ext_template_path . '*.php') as $file) {
                $template_name = basename($file);
                array_push($template_names, $template_name);
            }

            foreach (glob($plugin_template_path . '*.php') as $file) {
                $template_name = basename($file);
                array_push($template_names, $template_name);
            }

            $files = wgl_extensions_global()->get_locate_template(
                $template_names,
                '/elementor/' . $require_file . '/',
                $template_path,
                realpath(__DIR__ . '/..')
            );

            switch ($require_file) {
                case 'templates':
                case 'includes':
                case 'settings':
                    foreach ((array) $files as $file) {
                        require_once $file;
                    }
                    break;
                case 'header':
                case 'widgets':
                    foreach ((array) $files as $file_name) {
                        $this->register_wgl_widget($file_name, $wpml_translate);
                    }
                    break;
            }
        }

        public function register_wgl_widget($file_name = '', $wpml_translate = false)
        {
            $widget_manager = Plugin::instance()->widgets_manager;

            $base = basename(str_replace('.php', '', $file_name));
            $class = ucwords(str_replace('-', ' ', $base));
            $class = str_replace('Wgl', 'WGL', $class);
            $class = str_replace(' ', '_', $class);
            $class = sprintf('WGL_Extensions\Widgets\%s', $class);

            if ($this->unvalid_widget_registration($class)) {
                // Bailout.
                return;
            }

            require_once $file_name;

            if (class_exists($class)) {
                if(!$wpml_translate){
                    $widget_manager->register( new $class );
                }else{
                    $widget = new $class();
                    if(method_exists(new $class(), 'wpml_support_module')){
                        $widget->wpml_support_module();
                    }
                }
            }
        }

        private function unvalid_widget_registration($class)
        {
            if (
                'WGL_Extensions\Widgets\WGL_Header_Wpml' === $class
                && !class_exists('\SitePress')
            ) {
                return true;
            }

            if (!class_exists('\WooCommerce')) {
                if (
                    'WGL_Extensions\Widgets\WGL_Header_Cart' === $class
                    || 'WGL_Extensions\Widgets\WGL_Header_login' === $class
                    || 'WGL_Extensions\Widgets\WGL_Products_Grid' === $class
                    || 'WGL_Extensions\Widgets\WGL_Products_Categories' === $class
                ) {
                    return true;
                }
            }

            if (!class_exists('WPCF7_ContactForm')) {
                if (
                    'WGL_Extensions\Widgets\WGL_Contact_Form_7' === $class
                ) {
                    return true;
                }
            }

            return false; // registration can be continued
        }

        public function frontend_scripts_registration()
        {
            wp_register_script(
                'wgl-widgets',
                WGL_ELEMENTOR_MODULE_URL . '/assets/js/wgl_elementor_widgets.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'isotope',
                WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/js/isotope.pkgd.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

	        wp_register_script(
		        'jquery-easypiechart',
		        get_template_directory_uri() . '/js/jquery.easypiechart.min.js',
		        ['jquery'],
		        '2.1.7',
		        true
	        );

            wp_register_script(
                'jquery-appear',
                get_template_directory_uri() . '/js/jquery.appear.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jarallax',
                get_template_directory_uri() . '/js/jarallax.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jarallax-video',
                get_template_directory_uri() . '/js/jarallax-video.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-countdown',
                get_template_directory_uri() . '/js/jquery.countdown.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'cocoen',
                get_template_directory_uri() . '/js/cocoen.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'matter',
                get_template_directory_uri() . '/js/matter.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-justifiedGallery',
                get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_enqueue_script(
                'gsap',
                get_template_directory_uri() . '/js/gsap-core.min.js',
                ['jquery'],
                '3.13.0',
                true
            );

            wp_register_script(
                'gsap-scroll-trigger',
                get_template_directory_uri() . '/js/ScrollTrigger.min.js',
                ['jquery','gsap'],
                '3.13.0',
                true
            );
        }

        public function register_dependencies()
        {
			wp_register_script(
				'wgl-text-path',
				WGL_ELEMENTOR_MODULE_URL . '/assets/js/wgl_text_path.js',
				['elementor-frontend'],
				'1.0.1',
				true
			);
		}

        public function inject_wgl_categories()
        {
            $elements_manager = Plugin::instance()->elements_manager;

            $elements_manager->add_category(
                'wgl-modules',
                ['title' => esc_html__('WGL Modules', 'burido-core')]
            );

            $elements_manager->add_category(
                'wgl-header-modules',
                ['title' => esc_html__('WGL Header Modules', 'burido-core')]
            );
        }

        public function wgl_widget_args($params)
        {
            // Default wrapper for widget and title
            $id = str_replace('wp-', '', $params['widget_id']);
            $id = str_replace('-', '_', $id);

            $wrapper_before = '<div class="wgl-elementor-widget widget '. WGL_Globals::get_theme_slug() . '_widget ' . esc_attr($id) . '">';
            $wrapper_after = '</div>';
            $title_before = '<div class="title-wrapper"><span class="title">';
            $title_after = '</span></div>';

            $default_widget_args = [
                'id' => 'sidebar_' . esc_attr(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $params['widget_id'])))),
                'before_widget' => $wrapper_before,
                'after_widget' => $wrapper_after,
                'before_title' => $title_before,
                'after_title' => $title_after,
            ];

            return $default_widget_args;
        }

	    public function wgl_change_min_zindex( $element, $args )
	    {
		    /* @var \Elementor\Widget_Base $element */
		    $element->update_control( 'z_index', [
			    'min' => -9999,
		    ] );
	    }

	    public function empowers_column_overflow( $element, $args )
	    {
		    /* @var \Elementor\Widget_Base $element */
		    $element->update_control( 'overflow', [
                'options' => [
                    '' => esc_html__( 'Default', 'burido-core' ),
                    'hidden' => esc_html__( 'Hidden', 'burido-core' ),
                    'hidden !important' => esc_html__( 'Hidden Important', 'burido-core' ),
                    'clip' => esc_html__( 'Clip', 'burido-core' ),
                ],
		    ] );
	    }

	    public function wgl_pointer_events( $element, $args )
	    {
		    /* @var \Elementor\Widget_Base $element */
		    $element->add_control(
			    'wgl_pointer_events',
			    [
				    'label' => esc_html__( 'WGL Pointer Events', 'burido-core' ),
				    'type' => Controls_Manager::SELECT,
				    'options' => [
					    '' => esc_html__( 'Default', 'burido-core' ),
					    'auto' => esc_html__( 'Auto', 'burido-core' ),
					    'none' => esc_html__( 'None', 'burido-core' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}}' => 'pointer-events: {{VALUE}};',
				    ],
			    ]
		    );

            $element->add_control(
                'wgl_easy_sticky',
                [
                    'label' => esc_html__( 'WGL Easy Sticky', 'burido-core' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('On', 'burido-core'),
                    'label_off' => esc_html__('Off', 'burido-core'),
                ]
            );
            $element->add_responsive_control(
                'wgl_easy_sticky_enable',
                [
                    'label' => esc_html__('Position', 'burido-core'),
                    'type' => Controls_Manager::SELECT,
                    'condition' => ['wgl_easy_sticky!' => ''],
                    'options' => [
                        'sticky' => esc_html__('Sticky', 'burido-core'),
                        'relative' => esc_html__('Relative', 'burido-core'),
                    ],
                    'selectors_dictionary' => [
                        'sticky' => 'position: sticky; align-self: flex-start;',
                        'relative' => 'position: relative; align-self: unset;',
                    ],
                    'default' => 'sticky',
                    'tablet_default' => 'relative',
                    'selectors' => [
                        '{{WRAPPER}}' => '{{VALUE}};',
                    ],
                ]
            );
            $element->add_responsive_control(
                'wgl_easy_sticky_offset_top',
                [
                    'label' => esc_html__('Top Offset', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'condition' => ['wgl_easy_sticky!' => ''],
                    'size_units' => ['px', 'vw', 'vh', 'custom'],
                    'range' => [ 'px' => [ 'min' => -100, 'max' => 1000 ] ],
                    'default' => ['size' => 0],
                    'tablet_default' => ['size' => 0],
                    'selectors' => [
                        '{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
	    }

	    public function wgl_hide_under( $element, $args )
	    {
		    /* @var \Elementor\Widget_Base $element */
            $element->add_control(
                'wgl_hide_el_under_enable',
                [
                    'label' => esc_html__('Custom Responsive Visibility', 'burido-core'),
                    'description' => esc_html__('Experimental Features from WGL', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'separator' => 'before',
                ]
            );
            $element->add_control(
                'wgl_hide_el_under',
                [
                    'label' => esc_html__( 'Hide Element Under (px)', 'burido-core' ),
                    'type' => Controls_Manager::SLIDER,
			        'dynamic' => ['active' => true],
                    'size_units' => ['px'],
                    'range' => [ 'px' => [ 'min' => 280, 'max' => 2560 ] ],
                    'condition' => ['wgl_hide_el_under_enable!' => ''],
                    'default' => ['size' => 0],
                    'selectors' => [
                        '/* {{WRAPPER}}' => '*/@media (max-width:{{wgl_hide_el_under.SIZE}}px){/*',
                        '*/ body:not(.e-preview--show-hidden-elements) {{WRAPPER}}' => 'display: none;',
                        'body.e-preview--show-hidden-elements {{WRAPPER}}' => 'background: repeating-linear-gradient(125deg, rgba(0, 0, 0, .1), rgba(0, 0, 0, .1) 1px, transparent 2px, transparent 9px); border: 1px solid rgba(0, 0, 0, .05); opacity: 0.5; filter: grayscale(1);',
                        '} {{WRAPPER}}' => 'display: block;',
                    ],
                ]
            );
	    }

        public function add_wpml_support() {
            if(class_exists('\SitePress')){
                $this->requiere_all_files('widgets', true);
                $this->requiere_all_files('header', true);
            }
        }

        /**
         * Creates and returns an instance of the class
         *
         * @return object
         */
        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        function theme_section_settings_elementor($settings) {

            $new_arr = $cursor_keys = $stretch_section_keys = $parallax_section_keys = [];
            // Cursor
            if (!empty($settings['cursor_tooltip'])) {
                $cursor_keys = [
                    'cursor_tooltip',
                    'cursor_tooltip_type',
                    'tooltip_text',
                    'tooltip_descr',
                    'cursor_thumbnail',
                    'tooltip_thumbnail_width',
                    'cursor_color_bg',
                    'tabs_cursor',
                    'tabs_cursor_title',
                    'tooltip_title',
                    'tooltip_title_width',
                    'tooltip_title_alignment',
                    'tooltip_title_padding',
                    'tooltip_title_radius',
                    'tooltip_title_border',
                    'tooltip_title_color',
                    'tooltip_title_bg',
                    'tooltip_descr',
                    'tooltip_descr_width',
                    'tooltip_descr_alignment',
                    'tooltip_descr_padding',
                    'tooltip_descr_radius',
                    'tooltip_descr_border',
                    'tooltip_descr_color',
                    'tooltip_descr_bg',
                    'cursor_tooltip_bg',
                    'cursor_prop',
                    'tooltip_bg_width',
                    'tooltip_bg_height',
                    'tooltip_bg_radius',
                    'tooltip_bg_color',
                    'tooltip_bg_blur',
                ];
            }
            // Stretch Section
            if (!empty($settings['apply_stretch_section'])) {
                $stretch_section_keys = [
                    'apply_stretch_section',
                ];
            }
            // Dynamic Colors
            if (!empty($settings['dynamic_colors_switcher'])) {
                $parallax_section_keys = [
                    'dynamic_colors_switcher',
                    'dynamic_colors_sensitivity',
                    'dynamic_colors_bg',
                ];
            }

            $all_keys = array_unique(array_merge($cursor_keys, $stretch_section_keys, $parallax_section_keys));

            foreach ($all_keys as $key) {
                if (array_key_exists($key, $settings)) {
                    $new_arr[$key] = $settings[$key];
                }
            }

            return $new_arr;
        }

        public function extended_row_render(\Elementor\Element_Base $element)
        {
            if (
                'section' !== $element->get_name()
                && 'container' !== $element->get_name()
            ) {
                // Bailout.
                return;
            }

            $settings = $element->get_settings();
            $data = $element->get_data();
            $settings = $this->theme_section_settings_elementor($settings);

            if (!empty($settings)) {
                $this->sections[$data['id']] = $settings;
            }
        }

        public function enqueue_scripts()
        {
            wp_localize_script(WGL_Globals::get_theme_slug() . '-theme-addons', 'wgl_section_settings', [
                $this->sections,
            ]);
        }

        public function extended_animation_options($widget, $args)
        {

            /**
             * GENERAL -> CURSOR
             */

            $widget->start_controls_section(
                'extended_cursor_tooltip',
                [
                    'label' => esc_html__('WGL Cursor Tooltip', 'burido-core'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $widget->add_control(
                'cursor_tooltip',
                [
                    'label' => esc_html__('Add Cursor Tooltip', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                ]
            );

            $widget->add_responsive_control(
                'cursor_margin',
                [
                    'label' => esc_html__('Margin', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => ['cursor_tooltip' => 'yes']
                ]
            );
            $widget->add_control(
                'tooltip_transition',
                [
                    'label' => esc_html__('Tooltip Transition (sec)', 'burido-core'),
                    'type' => Controls_Manager::NUMBER,
                    'dynamic' => ['active' => true],
                    'min' => 0,
                    'max' => 5,
                    'step' => 0.1,
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}' => '--transition: {{VALUE}}s;',
                    ],
                    'condition' => ['cursor_tooltip' => 'yes']
                ]
            );
            $widget->add_control(
                'cursor_prop',
                [
                    'label' => esc_html__('Cursor Property', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['cursor_tooltip' => 'yes'],
                    'default' => ''
                ]
            );

            $widget->add_control(
                'cursor_tooltip_type',
                [
                    'label' => esc_html__('Tooltip Type', 'burido-core'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'simple' => esc_html__('Simple', 'burido-core'),
                        'custom' => esc_html__('Custom Text', 'burido-core'),
                        'image' => esc_html__('Image', 'burido-core'),
                    ],
                    'default' => 'text',
                    'condition' => ['cursor_tooltip' => 'yes']
                ]
            );

            $widget->add_control(
                'tooltip_text',
                [
                    'label' => esc_html__('Tooltip Title', 'burido-core'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'condition' => [
                        'cursor_tooltip_type' => 'custom',
                        'cursor_tooltip' => 'yes'
                    ],
                    'default' => esc_html__('View More', 'burido-core'),
                    'label_block' => true,
                ]
            );

            $widget->add_control(
                'tooltip_descr',
                [
                    'label' => esc_html__('Tooltip Description', 'burido-core'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => ['active' => true],
                    'condition' => [
                        'cursor_tooltip_type' => 'custom',
                        'cursor_tooltip' => 'yes'
                    ],
                    'label_block' => true,
                ]
            );

            $widget->add_control(
                'cursor_thumbnail',
                [
                    'label' => esc_html__('Thumbnail', 'burido-core'),
                    'type' => Controls_Manager::MEDIA,
                    'dynamic' => ['active' => true],
                    'label_block' => true,
                    'condition' => [
                        'cursor_tooltip_type' => 'image',
                        'cursor_tooltip' => 'yes'
                    ],
                ]
            );
            $widget->add_responsive_control(
                'tooltip_thumbnail_width',
                [
                    'label' => esc_html__('Width', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 10, 'max' => 500 ],
                    ],
                    'size_units' => [ 'px', 'vw', 'custom'],
                    'condition' => [
                        'cursor_tooltip_type' => 'image',
                        'cursor_tooltip' => 'yes'
                    ],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $widget->add_control(
                'cursor_color_bg',
                [
                    'label' => esc_html__('Background Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'condition' => [
                        'cursor_tooltip_type' => 'simple',
                        'cursor_tooltip' => 'yes'
                    ],
                ]
            );

            $widget->start_controls_tabs(
                'tabs_cursor', [
                    'condition' => [
                        'cursor_tooltip_type' => ['def', 'custom'],
                        'cursor_tooltip' => 'yes'
                    ]
                ]
            );
            $widget->start_controls_tab(
                'tabs_cursor_title',
                ['label' => esc_html__('Title', 'burido-core')]
            );
            $widget->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'tooltip_title',
                    'selector' => '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6',
                ]
            );
            $widget->add_responsive_control(
                'tooltip_title_width',
                [
                    'label' => esc_html__('Min Width', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 50, 'max' => 500 ],
                    ],
                    'size_units' => [ 'px', '%', 'custom' ],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6' => 'min-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $widget->add_responsive_control(
                'tooltip_title_alignment',
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
                    'default' => 'left',
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6' => 'text-align: {{VALUE}}',
                    ],
                ]
            );
            $widget->add_responsive_control(
                'tooltip_title_padding',
                [
                    'label' => esc_html__('Padding', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $widget->add_control(
                'tooltip_title_radius',
                [
                    'label' => esc_html__('Border Radius', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $widget->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'tooltip_title_border',
                    'fields_options' => [
                        'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                        'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                    ],
                    'selector' => '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6',
                ]
            );
            $widget->add_control(
                'tooltip_title_color',
                [
                    'label' => esc_html__('Title Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $widget->add_control(
                'tooltip_title_bg',
                [
                    'label' => esc_html__('Background Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js h6' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $widget->end_controls_tab();
            $widget->start_controls_tab(
                'tabs_cursor_descr',
                ['label' => esc_html__('Description', 'burido-core')]
            );
            $widget->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'tooltip_descr',
                    'selector' => '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr',
                ]
            );
            $widget->add_responsive_control(
                'tooltip_descr_width',
                [
                    'label' => esc_html__('Min Width', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 50, 'max' => 500 ],
                    ],
                    'size_units' => [ 'px', '%', 'custom' ],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr' => 'min-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $widget->add_responsive_control(
                'tooltip_descr_alignment',
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
                    'default' => 'left',
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr' => 'text-align: {{VALUE}}',
                    ],
                ]
            );
            $widget->add_responsive_control(
                'tooltip_descr_padding',
                [
                    'label' => esc_html__('Padding', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $widget->add_control(
                'tooltip_descr_radius',
                [
                    'label' => esc_html__('Border Radius', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $widget->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'tooltip_descr_border',
                    'fields_options' => [
                        'width' => [ 'label' => esc_html__( 'Border Width', 'burido-core' ) ],
                        'color' => [ 'label' => esc_html__( 'Border Color', 'burido-core' ) ],
                    ],
                    'selector' => '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr',
                ]
            );
            $widget->add_control(
                'tooltip_descr_color',
                [
                    'label' => esc_html__('Description Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $widget->add_control(
                'tooltip_descr_bg',
                [
                    'label' => esc_html__('Background Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js .descr' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $widget->end_controls_tab();

            $widget->start_controls_tab(
                'tabs_cursor_bg',
                ['label' => esc_html__('Background', 'burido-core')]
            );

            $widget->add_control(
                'cursor_tooltip_bg',
                [
                    'label' => esc_html__('Add Tooltip Background', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                ]
            );

            $widget->add_responsive_control(
                'tooltip_bg_width',
                [
                    'label' => esc_html__('Width', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 10, 'max' => 1500 ],
                    ],
                    'size_units' => [ 'px', 'vw', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js::before' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => ['cursor_tooltip_bg' => 'yes'],
                ]
            );

            $widget->add_responsive_control(
                'tooltip_bg_height',
                [
                    'label' => esc_html__('Height', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => [ 'min' => 10, 'max' => 1500 ],
                    ],
                    'size_units' => [ 'px', 'vw', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js::before' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => ['cursor_tooltip_bg' => 'yes'],
                ]
            );

            $widget->add_control(
                'tooltip_bg_radius',
                [
                    'label' => esc_html__('Border Radius', 'burido-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'custom'],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => ['cursor_tooltip_bg' => 'yes'],
                ]
            );

            $widget->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'tooltip_bg_color',
                    'label' => esc_html__('Background', 'burido-core'),
                    'types' => ['classic', 'gradient'],
                    'selector' => '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js::before',
                    'condition' => ['cursor_tooltip_bg' => 'yes'],
                ]
            );

            $widget->add_control(
                'tooltip_bg_blur',
                [
                    'label' => esc_html__('Blur', 'burido-core'),
                    'type' => Controls_Manager::SLIDER,
                    'dynamic' => ['active' => true],
                    'range' => [
                        'px' => ['max' => 100, 'step' => 0.1],
                    ],
                    'selectors' => [
                        '#wgl-cursor .wgl-element-{{ID}}.cursor-from-js::before' => 'filter: blur({{SIZE}}px);',
                    ],
                    'condition' => ['cursor_tooltip_bg' => 'yes'],
                ]
            );

            $widget->end_controls_tab();
            $widget->end_controls_tabs();
            $widget->end_controls_section();


            /**
             * Dynamic Colors
             */

            $widget->start_controls_section(
                'extended_dynamic_colors',
                [
                    'label' => esc_html__('WGL Dynamic Colors', 'burido-core'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $widget->add_control(
                'dynamic_colors_switcher',
                [
                    'label' => esc_html__('Enable Dynamic Colors', 'burido-core'),
                    'description' => sprintf(
                        esc_html__( 'Changes will be reflected only after %1$s saving %3$s and %2$s reloading %3$s preview.', 'burido-core' ),
                        '<a href="javascript: $e.run( \'document/save/default\' )">',
                        '<a href="javascript: $e.run( \'preview/reload\' )">',
                        '</a>'
                    ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'enable',
                    'prefix_class' => 'wgl_dynamic_colors_',
                ]
            );

            $widget->add_control(
                'dynamic_colors_sensitivity',
                [
                    'label' => esc_html__( 'Sensitivity', 'burido-core' ),
                    'type' => Controls_Manager::NUMBER,
                    'dynamic' => [  'active' => true],
                    'condition' => [ 'dynamic_colors_switcher!' => '' ],
                    'min' => 0,
                    'max' => 300,
                    'prefix_class' => 'wgl_dynamic_colors_sensitivity-',
                ]
            );

            $widget->add_control(
                'dynamic_colors_bg',
                [
                    'label' => esc_html__('Container Background Color', 'burido-core'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [  'active' => true],
                    'condition' => [ 'dynamic_colors_switcher!' => '' ],
                    'selectors' => [
                        'body.wgl_dynamic_colors-active {{WRAPPER}}.wgl_dynamic_colors_enable' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $widget->end_controls_section();
        }

        public function extended_container_stretch_section_options($widget, $args)
        {
            /**
             * Stretch Section
             */

            $widget->start_controls_section(
                'extended_stretch_section',
                [
                    'label' => esc_html__('WGL Stretch Section', 'burido-core'),
                    'tab' => Controls_Manager::TAB_LAYOUT,
                    'hide_in_inner' => true,
                ]
            );

            $widget->add_control(
                'apply_stretch_section',
                [
                    'label' => esc_html__('Stretch Section', 'burido-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'return_value' => 'section-stretched',
                    'hide_in_inner' => true,
                    'description' => esc_html__( 'Stretch the section to the full width of the page using JS.', 'burido-core' ),
                    'frontend_available' => true,
                ]
            );

            $widget->end_controls_section();
        }

        public function extended_clip_path($widget, $args)
        {
            /**
             * CLIP PATH
             */

            $widget->start_controls_section(
                'extended_clip_path',
                [
                    'label' => esc_html__('WGL Clip Path', 'burido-core'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $widget->add_control(
                'clip_path_pattern',
                [
                    'label' => esc_html__('Select the Pattern', 'burido-core'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__('None', 'burido-core'),
                        'corner' => esc_html__('Clip the Corner', 'burido-core'),
                        'custom' => esc_html__('Custom', 'burido-core'),
                    ],
                    'default' => '',
                    'prefix_class' => 'wgl-clip-path-',
                ]
            );

            $widget->add_responsive_control(
                'clip_path_corner',
                [
                    'label' => esc_html__( 'Clip Size', 'burido-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'custom' ],
                    'condition' => ['clip_path_pattern' => 'corner'],
                    'selectors' => [
                        '{{WRAPPER}}' => '--wgl-clip-size-top: {{TOP}}{{UNIT}}; --wgl-clip-size-right: {{RIGHT}}{{UNIT}}; --wgl-clip-size-bottom: {{BOTTOM}}{{UNIT}}; --wgl-clip-size-left: {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $widget->add_control(
                'clip_path_custom',
                [
                    'label' => esc_html__( 'Custom Clip Path', 'burido-core' ),
                    'description' => esc_html__( 'You can use Clip Path Generator from the Internet', 'burido-core' ),
                    'type' => Controls_Manager::CODE,
                    'condition' => ['clip_path_pattern' => 'custom'],
                    'language' => 'css',
                    'render_type' => 'ui',
                    'rows' => 14,
                    'selectors' => [
                        '{{WRAPPER}}' => 'clip-path: {{VALUE}};',
                    ],
                ]
            );

            $widget->end_controls_section();
        }

        function extractElements($array, $types = ['container', 'section', 'column']) {
            $result = [];

            foreach ($array as $element) {
                if (is_array($element)) {
                    if (isset($element['elType']) && in_array($element['elType'], $types)) {
                        $result[] = $element;
                    }

                    if (isset($element['elements']) && is_array($element['elements'])) {
                        $result = array_merge($result, $this->extractElements($element['elements'], $types));
                    }
                }
            }

            return $result;
        }

        public function get_json_meta( $key, $ID )
        {
            $meta = get_post_meta( $ID, $key, true );

            if ( is_string( $meta ) && ! empty( $meta ) ) {
                $meta = json_decode( $meta, true );
            }

            if ( empty( $meta ) ) {
                $meta = [];
            }

            return $meta;
        }

        private function get_document_cache( $post_id )
        {
            $cache = $this->get_json_meta( static::CACHE_META_KEY, $post_id );

            if ( empty( $cache['timeout'] ) ) {
                return false;
            }

            if ( current_time( 'timestamp' ) > $cache['timeout'] ) {
                return false;
            }

            if ( ! is_array( $cache['value'] ) ) {
                return false;
            }

            return $cache['value'];
        }

        public function cache_page_elementor($data, $post_id)
        {
            $cached_data = $this->get_document_cache($post_id);

            if ( false === $cached_data ) {
                return $data;
            }
            $extract_settings = $this->extractElements($data);
            foreach($extract_settings as $extract_setting){
                $setting_id = $extract_setting['id'] ?? '';
                if($setting_id){
                    $settings = $this->theme_section_settings_elementor($extract_setting['settings']);

                    // Cursor Extensions
                    if (!empty($settings['cursor_tooltip'])) {
                        $settings['cursor_tooltip_type']        = $settings['cursor_tooltip_type'] ?? 'text';
                        $settings['tooltip_text']               = $settings['tooltip_text'] ?? esc_html__('View More', 'burido-core');
                        $settings['tooltip_descr']              = $settings['tooltip_descr'] ?? '';
                        $settings['cursor_thumbnail']           = $settings['cursor_thumbnail'] ?? ['url' => ''];
                        $settings['cursor_color_bg']            = $settings['cursor_color_bg'] ?? '';
                        $settings['tabs_cursor']                = $settings['tabs_cursor'] ?? '';
                        $settings['cursor_tooltip_bg']          = $settings['cursor_tooltip_bg'] ?? '';
                    }

                    if (!empty($settings)) {
                        $this->sections[$setting_id] = $settings;
                    }
                }
            }
            return $data;
        }

        public function add_extensions_animations($animations)
        {
            $wgl_animations = [
                esc_html__('WGL Animations', 'burido-core') => [
                    'wgl_fade_up'     => esc_html__('WGL Fade Up', 'burido-core'),
                    'wgl_fade_right'  => esc_html__('WGL Fade Right', 'burido-core'),
                    'wgl_fade_left'   => esc_html__('WGL Fade Left', 'burido-core'),
                    'wgl_fade_down'   => esc_html__('WGL Fade Down', 'burido-core'),
                    'wgl_fade'        => esc_html__('WGL Fade', 'burido-core'),
                ],
            ];

            $wgl_animations = apply_filters('wgl_elementor_additional_animations', $wgl_animations);

            return array_merge($animations, $wgl_animations);
        }
    }
}

if (!function_exists('wgl_elementor_module')) {
    function wgl_elementor_module()
    {
        return WGL_Elementor_Module::get_instance();
    }

    wgl_elementor_module();
}
