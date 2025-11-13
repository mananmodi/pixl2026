<?php

defined( 'ABSPATH' ) || exit;

/**
 * Portfolio CPT
 *
 * @package burido-core\includes\post-types
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Portfolio
{
    private $type = 'portfolio';
    private $slug;
    private $portfolio_singular;
    private $portfolio_archive;
    private $name;
    private $singular_name;
    private $plural_name;

    public function __construct()
    {
        $this->name = esc_html__( 'Portfolio', 'burido-core' );
        $this->singular_name = esc_html__( 'Portfolio Post', 'burido-core' );
        $this->plural_name = esc_html__( 'Portfolio Posts', 'burido-core' );
        $this->slug = WGL_Framework::get_option( 'portfolio_slug' ) ?: 'portfolio';
        $this->portfolio_singular = (bool)WGL_Framework::get_option('portfolio_singular');
        $this->portfolio_archive = (bool)WGL_Framework::get_option('portfolio_archives');

        add_action( 'init', [ $this, 'register_taxonomy_category' ] );
        add_action( 'init', [ $this, 'register_taxonomy_tag' ] );
        add_action( 'init', [ $this, 'register_cpt' ] );
        add_action( 'manage_portfolio_posts_custom_column', [ $this, 'column_image_thumbnail' ], 10, 2 );

        if ((!$this->portfolio_singular || !$this->portfolio_archive)) {
            add_action( 'template_redirect', [$this, 'portfolio_redirect'] );
        }

        add_filter( 'single_template', [ $this, 'get_custom_pt_single_template' ] );
        add_filter( 'archive_template', [ $this, 'get_custom_pt_archive_template' ] );
        add_filter( 'manage_portfolio_posts_columns',  [ $this, 'column_image_name' ] );

        add_theme_support( 'post-thumbnails' );
    }

    public function register_cpt()
    {
        $labels = [
            'name' => $this->name,
            'singular_name' => $this->singular_name,
            'add_new' => sprintf( esc_html__( 'Add New %s', 'burido-core' ), $this->singular_name ),
            'add_new_item' => sprintf( esc_html__( 'Add New %s', 'burido-core' ), $this->singular_name ),
            'edit_item' => sprintf( esc_html__( 'Edit %s', 'burido-core' ), $this->singular_name ),
            'new_item' => sprintf( esc_html__( 'New %s', 'burido-core' ), $this->singular_name ),
            'all_items' => sprintf( esc_html__( 'All %s', 'burido-core' ), $this->plural_name ),
            'view_item' => sprintf( esc_html__( 'View %s', 'burido-core' ), $this->singular_name ),
            'search_items' => sprintf( esc_html__( 'Search %s', 'burido-core' ), $this->plural_name ),
            'not_found' => sprintf( esc_html__( 'No %s found', 'burido-core' ), strtolower( $this->plural_name ) ),
            'not_found_in_trash' => sprintf( esc_html__( 'No %s found in Trash', 'burido-core' ), strtolower( $this->plural_name ) ),
            'parent_item_colon' => '',
            'menu_name' => $this->name
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'query_var' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'rewrite' => [ 'slug' => $this->slug ],
            'menu_position' => 12,
            'menu_icon' => 'dashicons-images-alt2',
            'supports' => [
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'page-attributes',
                'comments',
            ],
            'taxonomies' => [
                $this->type . '-category',
                $this->type . '-tag'
            ],
            'has_archive' => true,
        ];

        register_post_type( $this->type, $args );
    }

    public function portfolio_redirect()
    {
        if (
            class_exists('Elementor\Plugin')
            && \Elementor\Plugin::$instance->preview->is_preview_mode(get_the_ID())
        ) {
            return;
        }

        if (!$this->portfolio_archive && !$this->portfolio_singular) {
            if ( !is_singular($this->slug) && !is_post_type_archive($this->slug))
                return;

            wp_redirect( home_url() );
        }

        if (!$this->portfolio_singular) {
            if ( !is_singular($this->slug) )
                return;

            wp_redirect( get_post_type_archive_link($this->slug), 301 );
        }

        if (!$this->portfolio_archive) {
            if ( !is_post_type_archive($this->slug) )
                return;

            wp_redirect( home_url() );
        }

        exit;
    }

    public function register_taxonomy_category()
    {
        $labels = [
            'name' => sprintf( esc_html__( '%s Categories', 'burido-core' ), $this->name ),
            'menu_name' => sprintf( esc_html__( '%s Categories', 'burido-core' ), $this->name ),
            'singular_name' => sprintf( esc_html__( '%s Category', 'burido-core' ), $this->name ),
            'search_items' => sprintf( esc_html__( 'Search %s Categories', 'burido-core' ), $this->name ),
            'all_items' => sprintf( esc_html__( 'All %s Categories', 'burido-core' ), $this->name ),
            'parent_item' => sprintf( esc_html__( 'Parent %s Category', 'burido-core' ), $this->name ),
            'parent_item_colon' => sprintf( esc_html__( 'Parent %s Category:', 'burido-core' ), $this->name ),
            'new_item_name' => sprintf( esc_html__( 'New %s Category Name', 'burido-core' ), $this->name ),
            'add_new_item' => sprintf( esc_html__( 'Add New %s Category', 'burido-core' ), $this->name ),
            'edit_item' => sprintf( esc_html__( 'Edit %s Category', 'burido-core' ), $this->name ),
            'update_item' => sprintf( esc_html__( 'Update %s Category', 'burido-core' ), $this->name ),
        ];

        $args = [
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'publicly_queryable'  => $this->portfolio_archive,
            'rewrite' => [ 'slug' => $this->slug . '-category' ],
        ];

        register_taxonomy( $this->type . '-category', [ $this->type ], $args );
    }

    public function register_taxonomy_tag()
    {
        $labels = [
            'name' => sprintf( esc_html__( '%s Tags', 'burido-core' ), $this->name ),
            'menu_name' => sprintf( esc_html__( '%s Tags', 'burido-core' ), $this->name ),
            'singular_name' => sprintf( esc_html__( '%s Tag', 'burido-core' ), $this->name ),
            'popular_items' => esc_html__( 'Popular Tags', 'burido-core' ),
            'search_items' => esc_html__( 'Search Tag', 'burido-core' ),
            'all_items' => sprintf( esc_html__( 'All %s Tags', 'burido-core' ), $this->name ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'new_item_name' => esc_html__( 'New Tag Name', 'burido-core' ),
            'add_new_item' => sprintf( esc_html__( 'Add New %s Tag', 'burido-core' ), $this->name ),
            'edit_item' => sprintf( esc_html__( 'Edit %s Tag', 'burido-core' ), $this->name ),
            'update_item' => esc_html__( 'Update Tag', 'burido-core' ),
        ];

        $args = [
            'labels' => $labels,
            'hierarchical' => false,
            'update_count_callback' => '_update_post_term_count',
            'show_ui' => true,
            'show_in_rest' => true,
            'query_var' => true,
            'publicly_queryable'  => $this->portfolio_archive,
            'rewrite' => [ 'slug' => $this->slug . '-tag' ],
        ];

        register_taxonomy( $this->type . '-tag', [ $this->type ], $args );
    }

    // Custom column with featured image
    function column_image_name( $columns )
    {
        $array1 = array_slice( $columns, 0, 1 );
        $array2 = [ 'image' => __( 'Featured Image', 'burido-core' ) ];
        $array3 = array_slice( $columns, 1 );

        $output = array_merge( $array1, $array2, $array3 );

        return $output;
    }

    function column_image_thumbnail( $column, $post_id )
    {
        if ( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, [ 80, 80 ] );
        }
    }

    /** @see https://codex.wordpress.org/Plugin_API/Filter_Reference/single_template */
    function get_custom_pt_single_template( $single_template )
    {
        global $post;

        if ( $post->post_type == $this->type ) {
            if ( file_exists( get_template_directory() . '/single-portfolio.php' ) ) {
                return $single_template;
            }

            $single_template = plugin_dir_path( dirname( __FILE__ ) ) . 'portfolio/templates/single-portfolio.php';
        }

        return $single_template;
    }

    /** @see https://codex.wordpress.org/Plugin_API/Filter_Reference/archive_template */
    function get_custom_pt_archive_template( $archive_template )
    {
        global $post;

        if (
            is_post_type_archive( $this->type )
            || is_archive() && ! empty( $post->post_type ) && $this->type === $post->post_type
        ) {
            if ( file_exists( get_template_directory() . '/archive-portfolio.php' ) ) {
                return $archive_template;
            }

            $archive_template = plugin_dir_path( dirname( __FILE__ ) ) . 'portfolio/templates/archive-portfolio.php';
        }

        return $archive_template;
    }
}
