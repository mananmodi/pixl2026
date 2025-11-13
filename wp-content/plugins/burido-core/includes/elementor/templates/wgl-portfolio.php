<?php
/**
 * This template can be overridden by copying it to `yourtheme[-child]/wgl-extensions/elementor/templates/wgl-portfolio.php`.
 */
namespace WGL_Extensions\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Icons_Manager,
    Control_Media
};
use WGL_Extensions\Includes\{
    WGL_Loop_Settings,
    WGL_Elementor_Helper,
    WGL_Carousel_Settings,
    WGL_Cursor
};
use WGL_Framework;

/**
 * WGL Elementor Portfolio Template
 *
 *
 * @package burido-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class WGL_Portfolio
{
    private $attributes;
    private $item;
    private $query;

    public function __construct(
        $attributes = null,
        $self = null,
        $ajax_qeury = null
    ) {
        $this->attributes = $attributes;
        $this->item = $self;
        $this->query = $ajax_qeury;
        if (isset($this->attributes['grid_gap']) && isset($this->attributes['grid_gap']['size'])){
            $this->attributes['grid_gap'] = $this->attributes['grid_gap']['size'];
        }
    }

    public function render($_this = [])
    {
        $this->attributes['module_id'] = uniqid('portfolio_module_');
        $id = $_this ? $_this->get_id() : 0;
        $class_wrap = '';

        $this->query = $this->formalize_query();

        $this->layout_determination();
        $this->enqueue_scripts();

        if (
            'grid-2' == $this->attributes['layout']
            && (!empty($this->attributes['portfolio_title'])
            || !empty($this->attributes['portfolio_subtitle'])
            || !empty($this->attributes['show_button']))
        ) {
            $class_wrap = ' portfolio_header-inline';
        }

        echo '<section class="wgl_cpt_section">';
        echo '<div class="wgl-portfolio' . $class_wrap . '" id="' . esc_attr($this->attributes['module_id']) . '">';

        $this->render_header_section();

        echo '<div class="wgl-portfolio_wrapper">',
        '<div' , $this->get_row_classes() , '>',
                $this->get_posts_html(false, $id, $_this),
        '</div>',
        '</div>';

        $this->render_remaining_posts_section();

        echo '</div>';
        echo '</section>';
    }

    public function support_archive_tax()
    {
        global $post;
        if(is_tax() && is_archive() && ! empty( $post->post_type ) && 'portfolio' === $post->post_type){
            $tax_obj = get_queried_object();
            $term_id = $tax_obj->term_id ?? '';
            $taxonomies = [];
            if ($term_id) {
                $taxonomies[] = $tax_obj->taxonomy . ': ' . $tax_obj->slug;
            }
            $this->attributes['taxonomies'] = $taxonomies;
        }
    }

    public function formalize_query()
    {
        if (!empty($this->query)) {
            // Bailout, if ajax query is already set.
            return;
        }

        $this->support_archive_tax();

        list($query_args) = WGL_Loop_Settings::buildQuery($this->attributes);

        $query_args['paged'] = get_query_var('paged') ?: 1;
        $query_args['post_type'] = 'portfolio';

        $this->attributes['query_args'] = $query_args;

        $wp_query_instance = new \WP_Query($query_args);

        $this->attributes['post_count'] = $wp_query_instance->post_count;
        $this->attributes['found_posts'] = $wp_query_instance->found_posts;

        return $wp_query_instance;
    }

    public function layout_determination()
    {
        if (!empty($this->attributes['mb_pf_carousel_r'])) {
            $this->attributes['layout'] = 'carousel';
        }
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('imagesloaded');

        if ($this->attributes['appear_animation_enabled']) {
            wp_enqueue_script('jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js');
        }

        if (0 === strpos($this->attributes['layout'], 'masonry')) {
            wp_enqueue_script('isotope', WGL_EXTENSIONS_ELEMENTOR_URL . 'assets/js/isotope.pkgd.min.js', ['imagesloaded']);
        }

        if (0 === strpos($this->attributes['layout'], 'carousel')){
            wp_enqueue_script('swiper', get_template_directory_uri() . '/js/swiper/js/swiper-bundle.min.js', array(), false, false);
            wp_enqueue_style('swiper', get_template_directory_uri() . '/js/swiper/css/swiper-bundle.min.css');
        }
    }

    public function render_header_section() {

        ob_start();
            $this->portfolio_double_headings();
        $double_headings = ob_get_clean();
        $class = '';

        if ($this->attributes['title_sticky']) {
            wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js');
            $class .= ' sticky-sidebar';
        }

        $class .= $this->attributes['filter_alignment'] ? ' filter-' . $this->attributes['filter_alignment'] : '';
        $class .= !empty($this->attributes['filter_alignment_tablet']) ? ' filter-tablet-' . $this->attributes['filter_alignment_tablet'] : '';
        $class .= !empty($this->attributes['filter_alignment_mobile']) ? ' filter-mobile-' . $this->attributes['filter_alignment_mobile'] : '';

        if ($this->attributes['show_filter'] || !empty($double_headings)) {
            echo '<div class="wgl-portfolio_header wgl-cpt_header', esc_attr($class), '">',
                !empty($double_headings) ? $double_headings : '';
                $this->attributes['show_filter'] ? $this->render_filter() : '';
            echo '</div>';
        }
    }

    public function render_filter()
    {
        if (!$this->attributes['show_filter']) {
            // Bailout;
            return;
        }

        $class = 'carousel' !== $this->attributes['layout'] ? ' isotope-filter' : '';
        $class .= $this->attributes['filter_counter_enabled'] ? ' has_filter_counter' : '';

        echo '<div class="wgl-filter_wrapper portfolio__filter', esc_attr($class), '">',
            '<div class="swiper wgl-filter_swiper_wrapper">',
                '<div class="swiper-wrapper">',
                    $this->get_filter_categories(),
                '</div>',
            '</div>',
        '</div>';
    }

    public function portfolio_double_headings()
    {
        $module_title = $this->attributes['portfolio_title'] ?? '';
        $module_subtitle = $this->attributes['portfolio_subtitle'] ?? '';
        $module_button = $this->attributes['show_button'] ?? '';
        $button_text = $this->attributes['button_text'] ?? '';

        if (!$module_title && !$module_subtitle && !$module_button) {
            // Bailout.
            return;
        }

        echo '<div class="item_title">';

        if ($module_subtitle) {
            echo '<div class="portfolio_subtitle">', $module_subtitle, '</div>';
        }

        if ($module_title) {
            echo '<h3 class="portfolio_title">', $module_title, '</h3>';
        }

        if (
            $this->attributes['show_button']
            && !empty($this->attributes['button_link']['url'])
            && !empty($button_text)
        ) {

            if ( ! empty( $this->attributes[ 'button_link' ][ 'url' ] ) ) {
                $this->item->add_link_attributes( 'wrapper', $this->attributes[ 'button_link' ] );
            }

            // Render
            echo '<div class="portfolio_header-button">',
                '<a class="wgl-button btn-size-xl"', $this->item->get_render_attribute_string( 'wrapper' ), '>',
                    '<div class="button__content">',
                        esc_html__($button_text, 'burido-core'),
                    '</div>',
                '</a>',
            '</div>';
        }

        echo '</div>';
    }

    protected function get_filter_categories()
    {
        $data_category = $this->query->query['tax_query'] ?? [];

        $include = $exclude = [];
        if (!is_tax() && !empty($data_category[0])) {
            if ('IN' === $data_category[0]['operator']) {
                foreach ($data_category[0]['terms'] as $value) {
                    $idObj = get_term_by('slug', $value, 'portfolio-category');
                    $id_list[] = $idObj->term_id;
                }

                $include = implode(',', $id_list);
            } elseif ('NOT IN' === $data_category[0]['operator']) {
                foreach ($data_category[0]['terms'] as $value) {
                    $idObj = get_term_by('slug', $value, 'portfolio-category');
                    $id_list[] = $idObj->term_id;
                }

                $exclude = implode(',', $id_list);
            }
        }

        $cats = get_terms([
            'taxonomy' => 'portfolio-category',
            'include' => $include,
            'exclude' => $exclude,
            'hide_empty' => true
        ]);

        $page_transitions = '';
        if (class_exists('\ElementorPro\Modules\ThemeBuilder\Module')) {
            $page_transitions = ' data-e-disable-page-transition="true"';
        }

        $out = '<a href="#"'.$page_transitions.' data-filter=".portfolio__item" class="isotope__filter swiper-slide active">'
            . '<span class="cat_title">'.esc_html__('All', 'burido-core').'</span>'
            . '<span class="filter_counter"></span>'
            . '</a>';

        foreach ($cats as $cat) if ($cat->count > 0) {
            $out .= '<a'
                . ' class="swiper-slide"'
                . ' href="' . get_term_link($cat->term_id, 'portfolio-category') . '"'
                . $page_transitions
                . ' data-filter=".' . $cat->slug . '"'
                . ' >';
            $out .= '<span class="cat_title">'.$cat->name.'</span>';
            $out .= '<span class="filter_counter"></span>';
            $out .= '</a>';
        }

        return $out;
    }

    protected function get_row_classes()
    {
        extract($this->attributes);

        $classes = 'wgl-portfolio_container container-grid row';
        $classes .= $appear_animation_enabled ? ' appear-animation' : '';
        $classes .= $appear_animation_enabled && !empty($appear_animation_style) ? ' anim-' . $appear_animation_style : '';

        if (0 === strpos($layout, 'masonry')) {
            $classes .= ' isotope';
            $classes .= ' ' . $layout;
        } else {
            switch ($layout) {
                case 'carousel':
                    $classes .= ' carousel';
                    break;
                case 'flex-list':
                    $classes .= ' flex-list';
                    break;
                case 'grid-2':
                    $classes .= ' grid-2';
                    break;
                case 'related':
                    $classes .= !empty($mb_pf_carousel_r) ? ' carousel' : ' isotope';
                    break;
                default:
                    $classes .= !empty($show_filter) ? ' masonry isotope' : ' grid';
                    break;
            }
        }

        // $classes .= $posts_per_row ? ' col-' . $posts_per_row : '';

        return ' class="' . esc_attr( $classes ) . '"';
    }

    public function get_posts_html($ajax_offset = false, $id = 0, $_this = [])
    {
        extract($this->attributes);

        switch ($layout) {
            default:
            case 'masonry-4':
                $max_masonry_row_items = 6;
                break;

            case 'masonry-2':
            case 'masonry-3':
                $max_masonry_row_items = 8;
                break;
        }

        if ($this->query->have_posts()) {
            ob_start();
            if (
                'masonry-2' === $layout
                || 'masonry-3' === $layout
                || 'masonry-4' === $layout
            ) {
                echo '<div class="pf_item_size" style="width: 25%;"></div>';
            }

            $this->attributes['additional_post_is_rendered'] = $this->attributes['additional_post_is_rendered'] ?? false;
            $this->attributes['masonry_post_index'] = $this->attributes['masonry_post_index'] ?? 0;

            if($ajax_offset){
                $temp_value = $ajax_offset;
                while($temp_value > $max_masonry_row_items){
                    $temp_value = $temp_value - $max_masonry_row_items;
                }
                $this->attributes['masonry_post_index'] = $temp_value;
            }

            $use_additional_post = $use_additional_post ?? '';

            while ($this->query->have_posts()) {
                $this->query->the_post();

                $this->attributes['masonry_post_index'] = $this->attributes['masonry_post_index'] < $max_masonry_row_items
                    ? 1 + $this->attributes['masonry_post_index']
                    : 1;

                if (
                    $use_additional_post
                    && !$this->attributes['additional_post_is_rendered']
                    && 'first' === $additional_post_position
                    && 0 == $this->query->current_post
                ) {
                    $this->render_additional_grid_post();
                }

                $this->render_grid_post($id, $_this);

                if (
                    $use_additional_post
                    && !$this->attributes['additional_post_is_rendered']
                    && 'last' === $additional_post_position
                    && $this->query->current_post == $this->query->post_count - 1
                ) {
                    $this->render_additional_grid_post();
                }
            }
            $posts_html = ob_get_clean();
            wp_reset_postdata();

            if ('carousel' === $layout) {
                $posts_html = $this->apply_carousel_settings($posts_html);
            }
        }

        return $posts_html ?? '';
    }

    public function render_grid_post($id, $_this)
    {
        extract($this->attributes);

        $cursor = new WGL_Cursor;
        $cursor_data = $cursor->build($_this, $this->attributes);

        if (isset($cursor_tooltip) && '' != $cursor_tooltip) {
            add_filter( 'wgl/burido_module_cursor', function () { return true; });
        }

        $description_position = $description_position ?? '';
        $description_animation = $description_animation ?? '';
        $gallery_mode_enabled = $gallery_mode_enabled ?? '';

        ob_start();
            $this->render_grid_post_categories(false);
        $cats = ob_get_clean();
        $cats_data = preg_replace('/\"/','\'',$cats);

        if ('pf_cursor_tooltip' === $description_position) {
            add_filter( 'wgl/burido_module_cursor', function () { return true; });

            $pf_cursor_class = ' data-cursor-class="wgl-element-'.$id.' portfolio-tooltip"';
            $pf_cursor_data = ' data-cursor-text="<h6>' . get_the_title() . '</h6>' . $cats_data . '"' . $pf_cursor_class;
        }

        echo '<article class="portfolio__item', $this->get_grid_item_classes(), '">';

        $wrapper_class = $description_position ? ' description_' . $description_position : '';
        $wrapper_class .= 'inside_image' === $description_position ? ' animation_' . $description_animation : '';
        $wrapper_class .= 'pf_cursor_tooltip' === $description_position ? ' wgl-cursor-text description_under_image' : '';
        $wrapper_class .= $gallery_mode_enabled ? ' gallery_mode' : '';

        echo '<div class="item__wrapper', esc_attr($wrapper_class), '"' . ('pf_cursor_tooltip' === $description_position ? $pf_cursor_data : '') .'>';

        $link_params['link_destination'] = $link_destination ?? '';
        $link_params['link_target'] = $link_target ?? '';
        $link_params['additional_class'] = ' portfolio_link';
        $link = $this->get_link($link_params);

        echo '<div class="item__image' . ( isset($cursor_tooltip) && (bool)$cursor_tooltip ? ' wgl-cursor-text' : '' ) . '"' . $cursor_data . '>';

            echo '<div class="item__image-wrap">', $this->get_grid_post_image(), '</div>';
            echo $image_has_link ? $link : '';

        echo '</div>';

        if ($gallery_mode_enabled) {
            $img_id = get_post_thumbnail_id(get_the_ID());
            $img_url = wp_get_attachment_image_url($img_id, 'full');

            echo '<a',
                ' href="', esc_url($img_url), '"',
                ' data-elementor-open-lightbox="yes"',
                ' data-elementor-lightbox-slideshow="' . esc_attr($module_id) . '"',
                '>',
                '<i class="wgl-svg-icon">', wgl_dynamic_styles()->wgl_theme_svg()['search'], '</i>',
            '</a>';

        } else {
            $this->standard_mode_post($link);
        }

        echo '</div>';

        echo '</article>';
    }

    public function get_grid_item_classes()
    {
        $class = ' item'; // ajax requiered class

        $class .= $this->get_categories_slugs();

        $class .= 'carousel' === $this->attributes['layout'] ? ' swiper-slide' : '';

        return esc_attr($class);
    }

    protected function get_categories_slugs()
    {
        $terms = wp_get_post_terms(get_the_id(), 'portfolio-category');

        $categories = '';
        for ($i = 0, $count = count($terms); $i < $count; $i++) {
            $term = $terms[$i];
            $categories .= ' ' . $term->slug;
        }

        return esc_attr($categories);
    }

    public function get_grid_post_image()
    {
        $img_id = get_post_thumbnail_id(get_the_ID());
        $url = wp_get_attachment_image_url($img_id, 'full');

        if (!$url) {
            // Bailout.
            return;
        }

        $layout = $this->attributes['layout'];

        if (0 === strpos($layout, 'masonry')) {
            $grid_gap = $this->attributes['grid_gap'];
            $img_size = $this->attributes['image_masonry_size'];

            $elementor_container_width = (int) wgl_dynamic_styles()->get_elementor_container_width();
            $elementor_container_width = isset($img_size) && isset($img_size['size']) && !!$img_size['size'] ? max(100, (int)$img_size['size']) : $elementor_container_width;

            $full_viewport_width = $elementor_container_width - ($grid_gap * 2);
            $half_viewport_width = ($elementor_container_width / 2 - $grid_gap * 2);

            $post_index = $this->attributes['masonry_post_index'];

            if ('masonry-2' === $layout) {
                switch ($post_index) {
                    case 2:
                    case 6:
                        $dimensions = [
                            'width' => $full_viewport_width / 2,
                            'height' => $full_viewport_width
                        ];
                        break;
                    case 3:
                    case 4:
                    case 5:
                    case 8:
                        $dimensions = [
                            'width' => $half_viewport_width,
                            'height' => $half_viewport_width
                        ];
                        break;

                    default:
                        $dimensions = [
                            'width' => $full_viewport_width,
                            'height' => $full_viewport_width
                        ];
                }
            } elseif ('masonry-3' === $layout) {
                switch ($post_index) {
                    case 2:
                    case 5:
                        $dimensions = [
                            'width' => $full_viewport_width,
                            'height' => $full_viewport_width / 2
                        ];
                        $style = ' style="margin-top: -'.((int)$grid_gap/2).'px;"';
                        break;
                    case 3:
                    case 4:
                    case 7:
                    case 8:
                        $dimensions = [
                            'width' => $half_viewport_width,
                            'height' => $half_viewport_width
                        ];
                        break;

                    default:
                        $dimensions = [
                            'width' => $full_viewport_width,
                            'height' => $full_viewport_width
                        ];
                }
            } elseif ('masonry-4' === $layout) {
                switch ($post_index) {
                    case 1:
                    case 6:
                        $dimensions = [
                            'width' => $full_viewport_width,
                            'height' => $full_viewport_width / 2
                        ];
                        $style = ' style="margin-top: -'.((int)$grid_gap/2).'px;"';
                        break;
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $dimensions = [
                            'width' => $half_viewport_width,
                            'height' => $half_viewport_width
                        ];
                        break;

                    default:
                        $dimensions = [
                            'width' => $full_viewport_width,
                            'height' => $full_viewport_width
                        ];
                }
            }
        } else if ('carousel' === $layout && (bool)$this->attributes['variable_width']) {
            $dimensions = [];
        } else {
            $img_size_array = $this->attributes['img_size_array'] ?? '';
            $img_size_string = $this->attributes['img_size_string'] ?? '';
            $img_aspect_ratio = $this->attributes['img_aspect_ratio'] ?? '';

            $ratio_arr = explode( ',', $img_aspect_ratio );
            if ( 2 === count($ratio_arr)){
                $ratio_arr_1 = $ratio_arr[0];
                $ratio_arr_2 = $ratio_arr[1];

                if ($this->query->current_post % 2 == 0) {
                    $img_aspect_ratio = $ratio_arr_1;
                } else {
                    $img_aspect_ratio = $ratio_arr_2;
                }
            }

            $dimensions = class_exists('WGL_Extensions\Includes\WGL_Elementor_Helper') ? WGL_Elementor_Helper::get_image_dimensions($img_size_array ?: $img_size_string, $img_aspect_ratio) : [];
        }

        empty($dimensions['width']) || $url = aq_resize($url, $dimensions['width'], $dimensions['height'], true, true, true) ?: $url;

        $alt = trim(strip_tags(get_post_meta($img_id, '_wp_attachment_image_alt', true)));

        return '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"'. ( $style ?? '' ) .'>';
    }

    public function standard_mode_post($link)
    {
        extract($this->attributes);

        echo '<div class="item__description">';

        if (
            $image_has_link
            && 'pf_cursor_tooltip' !== $description_position
            && 'under_image' !== $description_position
            && 'sub_layer' !== $description_animation
            && 'grid-2' !== $layout
        ) {
            echo $link;
        }

        $link_params['link_destination'] = $link_destination ?? '';
        $link_params['link_target'] = $link_target ?? '';

            echo '<div class="description__wrapper">';

                if ($show_portfolio_title) {
                    $link_params['link_content'] = get_the_title();
                    $title_has_link = $title_has_link ?? '';

                    echo '<div class="item__title">',
                        '<h5 class="title">',
                        ($title_has_link ? $this->get_link($link_params) : '<span>' . get_the_title() . '</span>'),
                        '</h5>',
                    '</div>';
                }

                $this->render_grid_post_categories();

                $this->render_post_content();

            echo '</div>';

            echo '<div class="description__footer">';

                $this->render_grid_post_date();
                $this->render_grid_post_button();

            echo '</div>';

        echo '</div>'; // item__description
    }

    public function apply_carousel_settings($posts_html)
    {
        $this->attributes['slides_per_row'] = $this->attributes['posts_per_row'];

        return WGL_Carousel_Settings::init($this->attributes, $posts_html);
    }

    protected function render_grid_post_date()
    {
        if (!$this->attributes['show_meta_date']) {
            // Bailout.
            return;
        }

        echo '<div class="item__date">',
            '<span class="item__date-title">', esc_html__('DATE:', 'burido-core'), '</span>',
            '<span class="item__date-date">', esc_html(get_the_time(get_option('date_format'))), '</span>',
        '</div>';
    }

    protected function render_grid_post_button()
    {
        if (!$this->attributes['show_icon_button']) {
            // Bailout.
            return;
        }
        $link_params['link_destination'] = 'single';
        echo '<div class="item__button">',
            $this->get_link($link_params),
        '</div>';
    }

    protected function render_grid_post_categories($links = true)
    {
        if (!$this->attributes['show_meta_categories']) {
            // Bailout.
            return;
        }

        $cats_html = '';

        if ($links) {
            $tag = 'a';
            $link_url = true;
        } else {
            $tag = 'span';
            $link_url = false;
        }

        $p_cats = wp_get_post_terms(get_the_id(), 'portfolio-category');
        if (!empty($p_cats)) {
            $cats_html = '<div class="post_cats">';
            for ($i = 0, $count = count($p_cats); $i < $count; $i++) {
                $term = $p_cats[$i];
                $name = $term->name;
                $link = get_category_link($term->term_id);

                $cats_html .= '<' . $tag . ($link_url ? ' href=' . esc_url($link) : '') . ' class="portfolio-category">' . esc_html($name) . '</' . $tag . '>';
            }
            $cats_html .= '</div>';
        }

        echo $cats_html;
    }

    protected function render_post_content()
    {
        if (!$this->attributes['show_content']) {
            // Bailout.
            return;
        }

        $letter_count = !empty($this->attributes['content_letter_count']) ? $this->attributes['content_letter_count'] : '';

        $post = get_post(get_the_id());

        $chars_count = $letter_count ?: $this->characters_limit();
        $content = !empty($post->post_excerpt) ? $post->post_excerpt : $post->post_content;
        $content = preg_replace('~\[[^\]]+\]~', '', $content);
        $content = strip_tags($content);
        $content = WGL_Framework::modifier_character($content, $chars_count, '');

        if ($content) {
            echo '<div class="description_content">',
                '<div class="content">',
                    $content,
                '</div>',
            '</div>';
        }
    }

    protected function characters_limit()
    {
        switch ($this->attributes['posts_per_row']) {
            case '1':
                $limit = 300;
                break;
            default:
            case '2':
                $limit = 145;
                break;
            case '3':
                $limit = 70;
                break;
            case '4':
                $limit = 55;
                break;
        }

        return $limit;
    }

    public function render_additional_grid_post()
    {
        $img_url = $this->attributes['additional_post_img_media']['url'] ?? '';
        if (
            $img_url
            && isset($this->attributes['img_size_string'])
        ) {
            $dimensions = WGL_Elementor_Helper::get_image_dimensions(
                $this->attributes['img_size_array'] ?: $this->attributes['img_size_string'],
                $this->attributes['img_aspect_ratio'] ?: ''
            );

            empty($dimensions['width']) || $img_url = aq_resize($img_url, $dimensions['width'], $dimensions['height'], true, true, true) ?: $img_url;
        }
        $this->item->add_render_attribute('additional__img', 'src', esc_url($img_url));
        $this->item->add_render_attribute('additional__img', 'alt', Control_Media::get_image_alt($this->attributes['additional_post_img_media']));

        $link = $this->attributes['additional_post_link'];
        $this->item->add_render_attribute('link', 'class', 'item__button');
        empty($link['url']) || $this->item->add_link_attributes('link', $link);

        echo '<article class="portfolio__item additional-post ' , ( 'carousel' === $this->attributes['layout'] ? ' swiper-slide' : '' ) , '">',
            '<div class="item__wrapper">',
                '<div class="item__image">',
                    '<img ', $this->item->get_render_attribute_string('additional__img'), '>',
                '</div>',
                '<a ', $this->item->get_render_attribute_string('link'), '>',
                    esc_html($this->attributes['additional_post_btn_text']),
                '</a>',
            '</div>',
        '</article>';

        $this->attributes['additional_post_is_rendered'] = true;
        $this->attributes['masonry_post_index'] = 1 + $this->attributes['masonry_post_index'];
    }

    public function get_link($link_settings)
    {
        extract($link_settings);

        $href = $href ?? get_permalink();
        $target = !empty($link_target) ? ' target="_blank"' : '';
        $additional_class = $additional_class ?? '';
        $link_content = $link_content ?? '';

        switch ($link_destination) {
            case 'popup':
                $attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                $link = '<a'
                    . ' href="' . $attachment_url . '"'
                    . ($additional_class ? ' class="' . $additional_class . '"' : '')
                    . ' data-elementor-open-lightbox="yes"'
                    . ' data-elementor-lightbox-slideshow="' . esc_attr($this->attributes['module_id']) . '"'
                    . '>'
                    . $link_content
                    . '</a>';
                break;

            case 'custom':
                if (
                    class_exists('RWMB_Loader')
                    && rwmb_meta('mb_portfolio_link')
                    && !empty(rwmb_meta('portfolio_custom_url'))
                ) {
                    $href = rwmb_meta('portfolio_custom_url');
                }
                $link = '<a href="' . esc_url($href) . '"' . $target . ' class="custom_link' . $additional_class . '">'
                    . $link_content
                    . '</a>';
                break;

            default:
            case 'single':
                $link = '<a href="' . esc_url($href) . '"' . $target . ' class="single_link' . $additional_class . '">'
                    . $link_content
                    . '</a>';
                break;
        }

        return $link;
    }

    protected function render_remaining_posts_section()
    {
        $remainings_loading_type = $this->attributes['remainings_loading_type'] ?? '';

        switch ($remainings_loading_type) {
            case 'pagination':
                echo WGL_Framework::pagination($this->query, $this->attributes['remainings_loading_alignment']);
                break;

            case 'load_more':
                $this->render_load_more_btn();
                break;

            case 'infinite':
                $this->render_infinite_scroll();
                break;
        }
    }

    public function render_load_more_btn()
    {
        if ($this->query->post_count > $this->query->found_posts) {
            // Bailout.
            return;
        }

        WGL_Framework::render_load_more_button($this->attributes);
    }

    public function render_infinite_scroll()
    {
        if ($this->query->post_count > $this->query->found_posts) {
            // Bailout.
            return;
        }

        wp_enqueue_script('waypoints');

        $uniq = uniqid();

        $non_empty_attributes = array_filter($this->attributes, function($value) {
            return !empty($value) ? $value : false;
        });

        $ajax_data_str = htmlspecialchars(json_encode($non_empty_attributes), ENT_QUOTES, 'UTF-8');

        echo '<div class="clear"></div>',
            '<div class="text-center load_more_wrapper">',
            '<div class="infinity_item">',
            '<span class="wgl-ellipsis">',
                '<span></span><span></span>',
                '<span></span><span></span>',
            '</span>',
            '</div>',
            '<form class="posts_grid_ajax">',
                "<input type='hidden' class='ajax_data' name='",esc_attr($uniq)."_ajax_data' value='",esc_attr($ajax_data_str),"' />",
            '</form>',
        '</div>';
    }

    public function render_item_single()
    {

        $pf_image__style = '';
        $pf_image_margin_top = WGL_Framework::get_option('portfolio_single__image_margin')['margin-top'];

        if ($pf_image_margin_top) {
            $pf_image__style = 'style="margin-top: ' . $pf_image_margin_top . '"';
        }

        echo '<article class="wgl-portfolio-single_item" ', $pf_image__style, '>';
        echo '<div class="portfolio__item">';

        echo '<div class="portfolio-item__meta-wrap single_meta">';
            switch (WGL_Framework::get_mb_option('portfolio_single_type_layout', 'mb_portfolio_post_conditional', 'custom')) {
                case '1':
                    echo $this->render_single_post_categories();
                    $this->render_post_title();
                    $this->render_post_meta();
                    $this->render_single_post_image();
                    break;
                default:
                case '2':
                    $this->render_single_post_image();
                    echo $this->render_single_post_categories();
                    $this->render_post_title();
                    $this->render_post_meta();
                    break;
            }
        echo '</div>';

        $content = apply_filters('the_content', get_post_field('post_content', get_the_id()));
        if ($content) {
            echo '<div class="description_content">',
                '<div class="content">',
                    $content,
                '</div>',
            '</div>';
        }

        // ↓ Post Meta Information
        $tags_enabled = (bool)WGL_Framework::get_option('portfolio_above_content_cats');
        $shares_enabled = (bool)WGL_Framework::get_option('portfolio_above_content_share');
        if (class_exists('RWMB_Loader')) {
            if ('default' !== rwmb_meta('mb_portfolio_above_content_cats')) {
                $tags_enabled_mb = rwmb_meta('mb_portfolio_above_content_cats');
                if ($tags_enabled_mb == 'yes') {
                    $tags_enabled = true;
                } elseif ($tags_enabled_mb == 'no') {
                    $tags_enabled = false;
                }
            }

            if ('default' !== rwmb_meta('mb_portfolio_above_content_share')) {
                $shares_enabled_mb = rwmb_meta('mb_portfolio_above_content_share');
                if ($shares_enabled_mb == 'yes') {
                    $shares_enabled = true;
                } elseif ($shares_enabled_mb == 'no') {
                    $shares_enabled = false;
                }
            }
        }

        $tags_html = $tags_enabled ? $this->get_tags() : '';
        $socials_html = $shares_enabled ? $this->get_post_socials() : '';
        if ($tags_html || $socials_html) {
            echo '<div class="single_post_info">',
                $tags_html,
                $socials_html,
            '</div>';

            echo '<div class="clear"></div>';
        }
        // ↑ post meta information

        echo '</div>';
        echo '</article>';
    }

    public function get_tags()
    {
        $tags = $this->get_tags_list('<div class="tagcloud-wrapper"><div class="tagcloud">', '</div></div>');

        return !is_wp_error($tags) ? $tags : '';
    }

    /**
     * Filters the tags list for a given post.
     */
    protected function get_tags_list(
        $before = '',
        $after = '',
        $sep = ' '
    ) {
        global $post;

        return apply_filters(
            'the_tags',
            get_the_term_list(
                $post->ID,
                'portfolio-tag',
                $before,
                $sep,
                $after
            ),
            $before,
            $sep,
            $after,
            $post->ID
        );
    }

    protected function get_post_socials()
    {
        if (function_exists('wgl_extensions_social')) {
            ob_start();
                // Socials
                echo '<div class="share_post-container">';
                    wgl_extensions_social()->post_share();
                echo '</div>';
            return ob_get_clean();
        }
    }

    protected function get_post_likes()
    {
        if (
            !WGL_Framework::get_option('portfolio_single_meta_likes')
            || !function_exists('wgl_simple_likes')
        ) {
            // Bailout.
            return;
        }

        return wgl_simple_likes()->get_likes_button();
    }

    protected function get_post_date()
    {
        $date_enable = (bool)WGL_Framework::get_option('portfolio_single_meta_date');
        if (
            class_exists('RWMB_Loader')
            && 'default' != rwmb_meta('mb_portfolio_single_meta_date')
        ) {
            $date_enable_mb = rwmb_meta('mb_portfolio_single_meta_date');
            if ($date_enable_mb == 'yes') {
                $date_enable = true;
            } elseif ($date_enable_mb == 'no') {
                $date_enable = false;
            }
        }

        if ($date_enable) {
            return '<span class="post_date">'
                . esc_html(get_the_time(get_option('date_format')))
                . '</span>';
        }
    }

    protected function get_post_author()
    {
        if (!WGL_Framework::get_option('portfolio_single_meta_author')) {
            // Bailout.
            return;
        }

        return '<span class="post_author"><span>'.
        esc_html__('By ', 'burido-core').
        '<a href="'. esc_url(get_author_posts_url(get_the_author_meta('ID'))). '">'.
            esc_html(get_the_author_meta('display_name')).
        '</a>'.
    '</span></span>';
    }

    protected function get_post_comments()
    {
        if (!WGL_Framework::get_option('portfolio_single_meta_comments')) {
            // Bailout.
            return;
        }

        $amount = get_comments_number(get_the_ID());

        return '<span class="comments_post">'
            . '<a href="' . esc_url(get_comments_link()) . '">'
            . esc_html($amount)
            . ' '
            . esc_html(_n('Comment', 'Comments', $amount, 'burido-core'))
            . '</a>'
            . '</span>';
    }

    protected function render_single_post_categories()
    {
        $cats_enabled = (bool)WGL_Framework::get_option('portfolio_single_meta_categories');
        if (
            class_exists('RWMB_Loader')
            && 'default' != rwmb_meta('mb_portfolio_single_meta_categories')
        ) {
            $cats_enabled_mb = rwmb_meta('mb_portfolio_single_meta_categories');
            if ($cats_enabled_mb == 'yes') {
                $cats_enabled = true;
            } elseif ($cats_enabled_mb == 'no') {
                $cats_enabled = false;
            }
        }

        if (
            $cats_enabled
            && $cats = wp_get_post_terms(get_the_id(), 'portfolio-category')
        ) {
            $cats_html = '<span class="post_categories">';
            for ($i = 0, $count = count($cats); $i < $count; $i++) {
                $term = $cats[$i];
                $link = get_category_link($term->term_id);

                $cats_html .= '<span>'
                    . '<a href=' . esc_html($link) . ' class="portfolio-category">'
                    . esc_html($term->name)
                    . '</a>'
                    . '</span>';
            }
            $cats_html .= '</span>';
        }

        return $cats_html ?? '';
    }

    protected function render_post_meta()
    {
        $hide_all_meta = WGL_Framework::get_option('portfolio_single_meta');
        if ($hide_all_meta) {
            // Bailout.
            return;
        }

        $meta_data = $this->get_post_date()
            . $this->get_post_author()
            . $this->get_post_comments();
        $meta_likes = $this->get_post_likes();

        if ($meta_data || $meta_likes) {
            echo '<div class="meta_wrapper">';
                if ($meta_data) {
                    echo '<div class="meta-data">',
                        $meta_data,
                    '</div>';
                }
                if ($meta_likes) {
                    echo '<div class="meta-data">',
                        $meta_likes,
                    '</div>';
                }
            echo '</div>';
        }
    }

    protected function render_post_title()
    {
        if (class_exists('RWMB_Loader')) {
            $mb_title_enabled = rwmb_meta('mb_portfolio_title');
        }
        $title_enabled = isset($mb_title_enabled) ? $mb_title_enabled : true;

        echo $title_enabled ? '<h1 class="item__title">' . get_the_title() . '</h1>' : '';
    }

    protected function render_single_post_image( $echo = true )
    {
        $featured_replaced = [];
        $class = $data_width = '';
        $featured_type = WGL_Framework::get_mb_option('portfolio_featured_image_type', 'mb_portfolio_featured_image_conditional', 'custom');
        $image_wide = (bool)WGL_Framework::get_option('portfolio_single_image');
        $content_width = WGL_Framework::get_option('portfolio_single_image_width');

        if ($image_wide) {
            $class = ' item__image-wide';
            $data_width = isset($content_width['width']) && !empty($content_width) ? ' data-img-width="'.$content_width['width'].'"' : '';
        }
        if ('off' === $featured_type) {
            // Bailout.
            return;
        }
        if ('replace' === $featured_type) {
            $featured_replaced = WGL_Framework::get_mb_option('portfolio_featured_image_replace', 'mb_portfolio_featured_image_conditional', 'custom');
        }

        $img_id = 0;
        if ($featured_replaced) {
            $img_id = array_values($featured_replaced)[0]['ID'] ?? 0;
        }
        $img_id = $img_id ?: get_post_thumbnail_id(get_the_ID());

        $url = wp_get_attachment_image_url($img_id, 'full');

        if (!$url) {
            // Bailout.
            return;
        }

        $alt = trim(strip_tags(get_post_meta($img_id, '_wp_attachment_image_alt', true)));

        $render = '<div class="item__image'.$class.'"'.$data_width.'>'.
            '<img'.
                ' src="'. esc_url( $url ). '"'.
                ' alt="'. esc_attr( $alt ). '"'.
            '>'.
        '</div>';
        if (!!$echo){
            echo WGL_Framework::render_html($render);
        }else{
            return $render;
        }
    }
}
