<?php

namespace KKF\Managers;

class AssetsManager extends BaseManager
{
    protected function addActions(): void
    {
        add_action('wp_enqueue_scripts', [ $this, 'enqueue_scripts' ]);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function enqueue_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/assets/js/main.min.js', ['jquery'], null, true);
        wp_enqueue_style('theme-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/assets/css/main.min.css');
    }

    public function enqueue_admin_scripts($hook) {
        if ('post.php' === $hook || 'post-new.php' === $hook) {
            wp_enqueue_media();
            wp_enqueue_script(
                'gallery-repeater',
                get_stylesheet_directory_uri() . '/assets/js/admin.min.js',
                array('jquery'),
                null,
                true
            );
        }
    }


}
