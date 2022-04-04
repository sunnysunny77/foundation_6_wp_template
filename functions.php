<?php

if (!isset($content_width)) {
    $content_width = 1920;
}

if (!function_exists('foundation_setup')) {

    function foundation_setup()
    {
        register_nav_menus(
            array(
                'main-nav' => 'Main Navigation',
                'footer-nav' => 'Footer Navigation',
            )
        );

        add_theme_support('widget-customizer');

        add_theme_support('custom-logo', array('height' => 100, 'width' => 100,  'unlink-homepage-logo' => true,  'header-text' => array('site-title', 'site-description')));

        add_theme_support('title-tag');

        add_theme_support('html5', ['script', 'style', 'comment-form', 'search-form', 'gallery', 'caption']);

        add_theme_support('menus');

        // add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));

        // add_theme_support('automatic-feed-links');

        // add_theme_support('post-thumbnails');
    }
}
add_action('after_setup_theme', 'foundation_setup');

function foundation_scripts()
{

    //foundation 6 for sites and icons
    wp_deregister_script('jquery');

    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/vendor/jquery.js', '', '', false);

    wp_enqueue_script('foundation-js', get_template_directory_uri() . '/js/vendor/foundation.min.js', array( 'jquery' ), '', true);

    wp_enqueue_style('foundation-css', get_template_directory_uri() . '/assets/css/foundation.min.css');

    wp_enqueue_style('icons', get_template_directory_uri() . '/assets/css/icons/foundation-icons.css');

    wp_enqueue_script('what-input', get_template_directory_uri() . '/js/vendor/what-input.js', array( 'jquery' ), '', true);

    wp_enqueue_script('app-js', get_template_directory_uri() . '/js/app.js', array( 'jquery' ), '', true);

    //AJAX
    wp_enqueue_script('jquery-form','', array( 'jquery' ), '', true);

    //theme styles
    if (is_front_page()) {
        wp_enqueue_style('home-css', get_template_directory_uri() . '/assets/css/home.css');
    } else if (is_page('about')) {
        wp_enqueue_style('about-css', get_template_directory_uri() . '/assets/css/about.css');
    } else if (is_page('contact')) {
        wp_enqueue_style('contact-css', get_template_directory_uri() . '/assets/css/contact.css');
    /*  wp_enqueue_script('form-js', get_template_directory_uri() . '/js/form.js', array( 'jquery' ), '', true);
        wp_localize_script('form-js', 'frontend_ajax_object',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'data_var_1' => '',
        )*/
    } else if (is_page('gallery')) {
        wp_enqueue_style('gallery-css', get_template_directory_uri() . '/assets/css/gallery.css');
    } else if (is_home()) {
        wp_enqueue_style('blog-css', get_template_directory_uri() . '/assets/css/blog.css');
    } else if (is_single()) {
        wp_enqueue_style('single-css', get_template_directory_uri() . '/assets/css/single.css');
    } else if (is_archive()) {
        wp_enqueue_style('archive-css', get_template_directory_uri() . '/assets/css/archive.css');
    } else if (is_search()) {
        wp_enqueue_style('search-css', get_template_directory_uri() . '/assets/css/search.css');
    } else if (is_404()) {
        wp_enqueue_style('notfound-css', get_template_directory_uri() . '/assets/css/notfound.css');
    }
}
add_action('wp_enqueue_scripts', 'foundation_scripts');

function foundation_custom_sidebars()
{
    register_sidebar(
        array(
            'name' => 'widget one',
            'id' => 'widget_one',
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<span class="widgettitle">',
            'after_title'   => '</span>',
        )
    );
}
add_action('widgets_init', 'foundation_custom_sidebars');

function foundation_post_limits($query)
{
    if (!is_admin() && $query->is_main_query()) {

        if (is_home()) {
            $query->set('posts_per_page', '3');
        }
    }
}
add_action('pre_get_posts', 'foundation_post_limits');

function foundation_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'foundation_session');

/*
function foundation_remove_frameborder($return, $data)
{
    if (is_object($data)) {
        $return = str_ireplace(
            array(
                'frameborder="0"'
            ),
            '',
            $return
        );
    }
    return $return;
}
add_filter('oembed_dataparse', 'foundation_remove_frameborder', 10, 3);
*/

add_filter('pre_option_upload_path', function ($upload_path) {
    return  get_template_directory() . '/files';
});

add_filter('pre_option_upload_url_path', function ($upload_url_path) {
    return get_template_directory_uri() . '/files';
});

function foundation_enable_vcard_upload( $mime_types ){
    $mime_types['vcf'] = 'text/vcard';
    $mime_types['vcard'] = 'text/vcard';
    return $mime_types;
}
add_filter('upload_mimes', 'foundation_enable_vcard_upload' );

/*
function foundation_replace_content($text_content)
{
    if (is_single() || is_home()) {
        $text = array(
            '<p>' => '<p class="callout">',
        );

        $text_content = str_ireplace(array_keys($text), $text, $text_content);
    }

    return $text_content;
}
add_filter('the_content', 'foundation_replace_content');

function foundation_submit_form()
{
 
   require_once(get_template_directory() . '/'); 
    
    =

    <form class="grid-x align-center" method="post" id="submit_form">   
        <input type="hidden" name="action" value="submit_form" >  
    </form>
    
   
  
    exit();
}
add_action('wp_ajax_submit_form', "foundation_submit_form");
add_action('wp_ajax_nopriv_submit_form', 'foundation_submit_form');


function foundation_cptui_register_my_cpts()
{

    $labels = [
        "name" => __("", "custom-post-type-ui"),
        "singular_name" => __("", "custom-post-type-ui"),
    ];

    $args = [
        "label" => __("", "custom-post-type-ui"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => ["slug" => "", "with_front" => true],
        "query_var" => true,
        "supports" => ["title"],
        "show_in_graphql" => false,
    ];

    register_post_type("products", $args);
}

add_action('init', 'foundation_cptui_register_my_cpts');

*/

function foundation_on_theme_activation()
{
    function foundation_post_meta($id, $key, $val)
    {
        add_post_meta($id, $key, $val, true);
    }

    /*
       $ = [ '' => [ , ];

    if (get_post_type_object("")) {
        foreach ($ as $x => $) {
            $page = array(
                'post_type'      => '',
                'post_status'    => 'publish',
                'post_title' =>  $x,
            );
            $id = wp_insert_post($page);
           foundation_post_meta($id, '', '');
        }
    }
    */

    if (!get_option('page_on_front')) {
        $page = array(
            'import_id'      =>  254,
            'post_title'     => 'Home',
            'post_type'      => 'page',
            'post_name'      => 'Home',
            'post_status'    => 'publish',
        );
        $id = wp_insert_post($page);
        update_option('page_on_front', $id);
        update_option('show_on_front', 'page');
       // foundation_post_meta($id, '', '');
    }

    if (!get_option('page_for_posts')) {
        $page = array(
            'post_title'     => 'Posts',
            'post_type'      => 'page',
            'post_name'      => 'Posts',
            'post_status'    => 'publish',
        );
        $id = wp_insert_post($page);
        update_option('page_for_posts', $id);
    }

    if (!get_page_template_slug(256)) {
        $page = array(
            'import_id'         =>  256,
            'post_title'     => 'Video',
            'post_type'      => 'page',
            'post_name'      => 'Video',
            'post_status'    => 'publish',
            'page_template' => 'page-video.php',
        );
        $id = wp_insert_post($page);
        // foundation_post_meta($id, '', '');
    }

    if (!get_page_template_slug(257)) {
        $page = array(
            'import_id'         =>  257,
            'post_title'     => 'Contact',
            'post_type'      => 'page',
            'post_name'      => 'Contact',
            'post_status'    => 'publish',
            'page_template' => 'page-contact.php',
        );
        $id = wp_insert_post($page);
        // foundation_post_meta($id, '', '');
    }

    if (!get_page_template_slug(258)) {
        $page = array(
            'import_id'         =>  258,
            'post_title'     => 'Gallery',
            'post_type'      => 'page',
            'post_name'      => 'Gallery',
            'post_status'    => 'publish',
            'page_template' => 'page-gallery.php',
        );
        $id = wp_insert_post($page);
          // foundation_post_meta($id, '', '');
    }

    update_option('uploads_use_yearmonth_folders', 0);
}
add_action('after_switch_theme', 'foundation_on_theme_activation');