<?php

namespace KKF\Managers;

define('UNI_REST_NAMESPACE', 'uni');

class HooksManager extends BaseManager
{
    protected function addActions(): void
    {
        add_action('init', [$this, 'createWorksPostType']);
    }

    protected function addFilters(): void
    {
       
    }

   
    public function createWorksPostType(): void
    {
        $labels = array(
            'name'               => _x('Աշխատանքներ', 'post type general name', 'textdomain'),
            'singular_name'      => _x('Աշխատանք', 'post type singular name', 'textdomain'),
            'menu_name'          => _x('Աշխատանքներ', 'admin menu', 'textdomain'),
            'name_admin_bar'     => _x('Աշխատանք', 'add new on admin bar', 'textdomain'),
            'add_new'            => _x('Add New', 'Աշխատանք', 'textdomain'),
            'add_new_item'       => __('Add New Work', 'textdomain'),
            'new_item'           => __('New Work', 'textdomain'),
            'edit_item'          => __('Edit Work', 'textdomain'),
            'view_item'          => __('View  Work', 'textdomain'),
            'all_items'          => __('All Works', 'textdomain'),
            'search_items'       => __('Search Works', 'textdomain'),
            'parent_item_colon'  => __('Parent Works:', 'textdomain'),
            'not_found'          => __('Աշխատանքներ չեն գտնվել։', 'textdomain'),
            'not_found_in_trash' => __('Աշխատանքներ չեն գտնվել աղբարկղում։', 'textdomain'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'works', 'with_front' => false),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions'),
            'show_in_rest'       => true,
            'menu_icon'          => 'dashicons-portfolio',
            'exclude_from_search'=> false,
            'has_archive'        => true,
            'template'           => [
                [ 'core/heading', [ 'level' => 1, 'placeholder' => 'Work Title' ] ],
                [ 'core/paragraph', [ 'placeholder' => 'Description of the work...' ] ],
                [ 'core/image', [] ],
                [ 'core/gallery', [] ],
            ],
        );

        register_post_type('works', $args);
    }

}
