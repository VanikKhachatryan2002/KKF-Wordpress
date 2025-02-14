<?php

namespace KKF\Managers;

class ACF extends BaseManager
{
    protected function addActions(): void
    {
        add_action('add_meta_boxes', [$this, 'custom_gallery_meta_box']);
        add_action('save_post', [$this, 'save_custom_gallery']);
        add_action('save_post', [$this, 'save_custom_fields']);
        add_action('acf/init', [$this, 'register_fields']);

    }

    public function custom_gallery_meta_box() {
        $page_slug = '';
        $post_type = get_post_type();

        if(isset($_GET['post'])){
            $post = get_post($_GET['post']);
            $page_slug = $post->post_name;
        }

        if($page_slug === 'home'){
            add_meta_box(
                'custom_gallery',
                'Homepage Gallery',
                [$this, 'custom_gallery_callback'],
                'page',
                'normal',
                'high'
            );
        } 

        if ($post_type === 'works') {
            add_meta_box(
                'custom_gallery',                  
                'Works Gallery',                  
                [$this, 'custom_gallery_callback'], 
                'works',                           
                'normal',                         
                'high'                           
            );
        }
       
    }

    public function custom_gallery_callback($post) {
        wp_nonce_field(basename(__FILE__), 'custom_gallery_nonce');
        $gallery_images = get_post_meta($post->ID, '_custom_gallery', true);
        $gallery_images = !empty($gallery_images) ? json_decode($gallery_images, true) : [];
        ?>
        <div id="custom-gallery-wrapper">
            <a href="#" class="add_gallery_image button">Add Image</a>
            <ul class="gallery-preview">
                <?php if (!empty($gallery_images)) : ?>
                    <?php foreach ($gallery_images as $index => $image_id) : ?>
                        <li class="gallery-item">
                            <input type="hidden" name="custom_gallery[<?php echo $index; ?>]" value="<?php echo esc_attr($image_id); ?>">
                            <img src="<?php echo wp_get_attachment_thumb_url($image_id); ?>" />
                            <a href="#" class="remove-gallery-item">Remove</a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <style>
            .gallery-preview img { width: 100px; height: auto; margin: 5px; }
            .gallery-item { position: relative; display: inline-block; }
            .remove-gallery-item { position: absolute; top: 5px; right: 5px; background: #f00; color: #fff; text-decoration: none; padding: 2px 5px; }
        </style>
        <?php
    }

    public function save_custom_gallery($post_id) {
        if (!isset($_POST['custom_gallery_nonce']) || !wp_verify_nonce($_POST['custom_gallery_nonce'], basename(__FILE__))) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['custom_gallery'])) {
            $gallery_images = array_map('sanitize_text_field', $_POST['custom_gallery']);
            update_post_meta($post_id, '_custom_gallery', json_encode($gallery_images));
        } else {
            delete_post_meta($post_id, '_custom_gallery');
        }
    }
   
   public function save_custom_fields($post_id) {
        $post = get_post($post_id);

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        if ($post && $post->post_name === 'services') {
            $services = [];

            if (isset($_POST['acf']['services']) && is_array($_POST['acf']['services'])) {
                foreach ($_POST['acf']['services'] as $service) {
                    $services[] = [
                        'title' => isset($service['title']) ? sanitize_text_field($service['title']) : '',
                        'title_en' => isset($service['title_en']) ? sanitize_text_field($service['title_en']) : '',
                        'title_ru' => isset($service['title_ru']) ? sanitize_text_field($service['title_ru']) : '',
                        'title_ir' => isset($service['title_ir']) ? sanitize_text_field($service['title_ir']) : '',
                        'description' => isset($service['description']) ? sanitize_textarea_field($service['description']) : '',
                        'description_en' => isset($service['description_en']) ? sanitize_textarea_field($service['description_en']) : '',
                        'description_ru' => isset($service['description_ru']) ? sanitize_textarea_field($service['description_ru']) : '',
                        'description_ir' => isset($service['description_ir']) ? sanitize_textarea_field($service['description_ir']) : '',
                        'image' => isset($service['image']) ? sanitize_text_field($service['image']) : '',
                    ];
                }
            }
                
            if (!empty($services)) {
                update_post_meta($post_id, 'services_repeater', $services);
            } else {
                delete_post_meta($post_id, 'services_repeater');
            }
        }
    }


    public function register_fields() {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group([
                'key' => 'group_1_services',
                'title' => 'Services Repeater',
                'fields' => [
                    [
                        'key' => 'field_1_services',
                        'label' => 'Services',
                        'name' => 'services',
                        'type' => 'repeater',
                        'sub_fields' => [
                            [
                                'key' => 'field_2_title',
                                'label' => 'Title',
                                'name' => 'title',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_2_title_en',
                                'label' => 'Title EN',
                                'name' => 'title_en',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_2_title_ru',
                                'label' => 'Title RU',
                                'name' => 'title_ru',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_2_title_ir',
                                'label' => 'Title IR',
                                'name' => 'title_ir',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_3_description',
                                'label' => 'Description',
                                'name' => 'description',
                                'type' => 'wysiwyg',
                            ],
                            [
                                'key' => 'field_3_description_en',
                                'label' => 'Description EN',
                                'name' => 'description_en',
                                'type' => 'wysiwyg',
                            ],
                            [
                                'key' => 'field_3_description_ru',
                                'label' => 'Description RU',
                                'name' => 'description_ru',
                                'type' => 'wysiwyg',
                            ],
                            [
                                'key' => 'field_3_description_ir',
                                'label' => 'Description IR',
                                'name' => 'description_ir',
                                'type' => 'wysiwyg',
                            ],
                            [
                                'key' => 'field_4_image',
                                'label' => 'Image',
                                'name' => 'image',
                                'type' => 'image',
                                'return_format' => 'array',
                            ],
                        ],
                    ],
                ],
                'location' => [
                    [
                        [
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'page',
                        ],
                    ],
                ],
            ]);
        }
    }

 
}
