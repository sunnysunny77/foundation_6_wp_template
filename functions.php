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

    /*
    wp_localize_script('app-js', 'path', array(
        'dir' => get_template_directory_uri(),
    ));
    */

    //AJAX
    wp_enqueue_script('jquery-form','', array( 'jquery' ), '', true);

    //theme styles
    if (is_front_page()) {
        wp_enqueue_style('home-css', get_template_directory_uri() . '/assets/css/home.css');
    } else if (is_page('about')) {
        wp_enqueue_style('about-css', get_template_directory_uri() . '/assets/css/about.css');
    } else if (is_page('contact')) {
        wp_enqueue_style('contact-css', get_template_directory_uri() . '/assets/css/contact.css');
         /*
        wp_enqueue_script('form-js', get_template_directory_uri() . '/js/form.js', array( 'jquery' ), '', true);
        wp_localize_script('form-js', 'frontend_ajax_object',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'data_var_1' => '',
        ));
        */
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

add_filter('pre_option_upload_path', function ($upload_path) {
    return  get_template_directory() . '/files';
});

add_filter('pre_option_upload_url_path', function ($upload_url_path) {
    return get_template_directory_uri() . '/files';
});

add_filter( 'option_uploads_use_yearmonth_folders', '__return_false');

/*
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

function foundation_enable_vcard_upload( $mime_types ){
    $mime_types['vcf'] = 'text/vcard';
    $mime_types['vcard'] = 'text/vcard';
    return $mime_types;
}
add_filter('upload_mimes', 'foundation_enable_vcard_upload' );

function foundation_remove_admin_menus() {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'index.php' );
	remove_menu_page( 'tools.php' );  
}
if ( current_user_can( 'editor' ) ){
    add_action( 'admin_menu', 'foundation_remove_admin_menus' );
}

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

// add menu
function foundation_add_column_parent($posts_columns)
{

    $posts_columns['parents'] = __('Parent');
      $posts_columns['child'] = __('Children');
    return $posts_columns;
}
add_filter('manage_media_columns', 'foundation_add_column_parent');

// populate menu
function foundation_custom_column($column_name, $post_id)
{

    global $wpdb;

    $meta_key =  get_post_meta($post_id, 'parent', true);

    if ('parents' == $column_name) {

        $parent = get_post_parent($post_id);

        if ($meta_key) {
            $result = $wpdb->get_var(
                $wpdb->prepare(
                    "
                SELECT meta_value FROM $wpdb->postmeta 
                WHERE meta_key = %s AND post_id = %d LIMIT 1
                ",
                    $meta_key,
                    $parent->ID
                )
            );
        }

        if ($meta_key) {
            echo $meta_key;
            if (!$result) {
                echo '<br/> Uploaded to is NULL';
            }
        } else {
            echo '-';
        }
    }

    if ('child' == $column_name) {

        $text = '';

        $parent = get_post_parent($post_id);

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "
            SELECT meta_key, post_id
            FROM $wpdb->postmeta
            WHERE meta_value = %s AND NOT post_id = %d 
            ",
                $post_id,
                $parent->ID
            )
        );

        foreach ($result as $row) {

            if (!get_post_parent($row->post_id)) {
                $text .= "<a href='" . get_edit_post_link($row->post_id) . "'>" . $row->meta_key  . "</a><br/>" . _draft_or_post_title($row->post_id) . "<br/><br/>";
            }
        }

        if ($text) {
            echo $text;
        } else {
            echo '-';
        }
    }
    return false;
}
add_action('manage_media_custom_column', 'foundation_custom_column', 10, 2);

// order menu
function foundation_add_column_sortable($columns)
{

    $columns['parents'] = 'parents';
    return $columns;
}
add_filter('manage_upload_sortable_columns', 'foundation_add_column_sortable');

// order menu
function foundation_sortable($query)
{

    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    if ('parents' === $query->get('orderby')) {
        $query->set('order', 'ASC');
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'parent');
        if ('desc' == $_REQUEST['order']) {
            $query->set('order', 'DSC');
        }
    }
}
add_action('pre_get_posts', 'foundation_sortable');

// add parent
function foundation_set_attachment($post_ID)
{

    $post = get_post_parent($post_ID);
    $post_types = ["storyboarding_films"];
    if (in_array($post->post_type, $post_types)) {
        if ($post) {
            update_post_meta($post_ID, "parent", $post->post_type);
        }
    }
}
add_action('add_attachment', 'foundation_set_attachment');
add_action('edit_attachment', 'foundation_set_attachment');

// toggle parent attach ui
function foundation_attach_action($action, $attachment_id, $parent_id)
{


    $post = get_post($parent_id);
    $post_types = ["storyboarding_films"];
    if (in_array($post->post_type, $post_types)) {
        if ($action == "attach") {
            update_post_meta($attachment_id, "parent", $post->post_type);
        } else if ($action == "detach") {
            delete_post_meta($attachment_id, 'parent');
        }
    }
}
add_action('wp_media_attach_action', 'foundation_attach_action', 10, 3);

// Delete parent on post delete
function foundation_delete_post_data($postid, $post)
{

    $post_types = ["storyboarding_films"];
    if (in_array($post->post_type, $post_types)) {
        $meta_key =  get_post_meta($postid, $post->post_type, true);
        delete_post_meta($meta_key, 'parent');
    }
    return $data;
}
add_action('before_delete_post', 'pfoundation_delete_post_data', 99, 2 );


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
   
    /*
    function foundation_remove_post($page_path, $output, $post_type)
    {
        $post = get_page_by_path($page_path, $output, $post_type);
        if ($post) {
            wp_delete_post($post->ID, true);
        }
    }
    foundation_remove_post('hello-world', 'OBJECT', 'post');
    
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

    function foundation_post_meta($id, $key, $val)
    {
        add_post_meta($id, $key, $val, true);
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

    if (!get_page(256)) {
        $page = array(
            'import_id'         =>  256,
            'post_title'     => 'About',
            'post_type'      => 'page',
            'post_name'      => 'About',
            'post_status'    => 'publish',
            'page_template' => 'page-about.php',
        );
        $id = wp_insert_post($page);
        // foundation_post_meta($id, '', '');
    }

    if (!get_page(257)) {
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

    if (!get_page(258)) {
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
}
add_action('after_switch_theme', 'foundation_on_theme_activation');