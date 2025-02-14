<?php

namespace KKF\Managers;
use WP_Query;
use KKF\Helpers\View;


class ShortcodeManager extends BaseManager
{
    protected function addShortCodes(): void
    {
        add_shortcode('header', [$this, 'header_shortcode']);
        add_shortcode('footer', [$this, 'footer_shortcode']);
        add_shortcode('about_us', [$this, 'about_us_shortcode']);
        add_shortcode('home_carousel', [$this, 'home_carousel_shortcode']);
        add_shortcode('home_works', [$this, 'home_works_shortcode']);
        add_shortcode('services', [$this, 'services_shortcode']);
        add_shortcode('works', [$this, 'works_shortcode']);
        add_shortcode('languages', [$this, 'languages_shortcode']);
        add_shortcode('archive', [$this, 'archive_shortcode']);
    }

    public function header_shortcode () {
        $logo = get_site_icon_url();
        $video_url = get_field('header_video');

        $pages = get_pages(array(
            'sort_column' => 'menu_order',
            'sort_order'  => 'ASC',
            'meta_key'     => 'is_menu',
            'meta_value'   => true,
        ));
        $works = get_posts(array(
            'post_type'      => 'works',
            'posts_per_page' => -1, 
            'post_status'    => 'publish', 
            'orderby'        => 'date',
            'order'          => 'ASC', 
            'meta_key'     => 'is_menu',
            'meta_value'   => true,
        ));

        
        $html = '';

        $lang = '';

        $works_text = "Աշխատանքներ";
        $all_works_text = "Բոլոր Աշխատանքները";

        if(isset($_GET['language']) && $_GET['language'] === "EN"){
            $works_text = 'Works';
            $all_works_text = 'All Works';
        } else if(isset($_GET['language']) && $_GET['language'] === "RU"){
            $works_text =  'Работы';
            $all_works_text =  'Все Работы';
        } else if(isset($_GET['language']) && $_GET['language'] === "IR"){
            $works_text = 'مشاغل';
            $all_works_text = 'تمام پروژه‌ها';
        }
        
        if(isset($_GET['language']) && $_GET['language']){
            $lang = '/?language=' . $_GET['language'];
        }

        $html .= '<div id="header1" class="header">';
            $html .= '<div class="LogoContainer">';
                $html .= '<a href="' . home_url('/') . $lang . '" class="router-link-active router-link-exact-active nav" aria-label="nav" aria-current="page">';
                   $html .= '<img alt="logo" width="100" height="100" class="lazyload" src="' . esc_url($logo) . '">';
                $html .= '</a>';
            $html .= '</div>';
            $html .= '<div class="navbarContainer" role="navigation" tabindex="0" aria-label="ԳԼԽԱՎՈՐ | ԾԱՌԱՅՈՒԹՅՈՒՆՆԵՐ">';

            if($pages) {
                foreach ($pages as $index => $page) {

                    $post_title = $page->post_title;
                    $title_en = get_field('title_en',$page->ID);
                    $title_ru = get_field('title_ru',$page->ID);
                    $title_ir = get_field('title_ir',$page->ID);
                    
                    if(isset($_GET['language']) && $_GET['language'] === "EN" && $title_en){
                        $post_title = $title_en;
                    } else  if(isset($_GET['language']) && $_GET['language'] === "IR" && $title_ir){
                        $post_title =  $title_ir;
                    }  else  if(isset($_GET['language']) && $_GET['language'] === "RU" && $title_ru){
                        $post_title = $title_ru;
                    }

                    $html .= '<a href="' .get_permalink($page->ID)  . $lang . '" class="router-link-active router-link-exact-active nav" aria-label="' .  $post_title . '" role="link" aria-current="page">';
                    $html .=   $post_title;
                    $html .= '</a>';
                }
                
                $html .= '<a href="#" class="works-nav router-link-active router-link-exact-active nav" aria-label="'. $works_text .'" role="link" aria-current="page">';
                    if(!isset($_GET['language']) || (isset($_GET['language']) && $_GET['language'] !== "IR")){
                        $html .= $works_text;
                    }
                    $html .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="15px" width="40px" version="1.1" id="Layer_1" viewBox="0 0 330 330" xml:space="preserve">
                                <path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393  c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393  s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"/>
                            </svg>';
                    if(isset($_GET['language']) && $_GET['language'] === "IR"){
                        $html .= $works_text;
                    }
                $html .= '</a>';
            }

            $html .= do_shortcode('[languages]');
            
            $html .= '</div>';
            $html .= '<div id="menu" class="menu hidden">';
                $html .= '<ul>';
        
                    if (!empty($works) && !is_wp_error($works)) {
                        $html .= '<li class="nav-all-works">';
                            $html .= '<a href="/works'. $lang .'" class="links" aria-label="all-works" role="link">'. $all_works_text .'</a>';
                        $html .= '</li>';
                        foreach ($works as $work) {
                            $work_title = $work->post_title;
                            $title_en = get_field('title_en',$work->ID);
                            $title_ru = get_field('title_ru',$work->ID);
                            $title_ir = get_field('title_ir',$work->ID);
    
                            if(isset($_GET['language']) && $_GET['language'] === "EN" && $title_en){
                                $work_title = $title_en;
                            } else  if(isset($_GET['language']) && $_GET['language'] === "IR" && $title_ir){
                                $work_title =  $title_ir;
                            }  else  if(isset($_GET['language']) && $_GET['language'] === "RU" && $title_ru){
                                $work_title = $title_ru;
                            }

                            $html .= '<li class="nav-' . esc_attr($work->post_name) . '">';
                                $html .= '<a href="' . get_permalink($work->ID) . $lang . '" class="links" aria-label="' . esc_attr($work_title) . '" role="link">' . esc_html($work_title) . '</a>';
                            $html .= '</li>';
                        }
                    }
            
                $html .= '</ul>';
            $html .= '</div>';
        $html .= '</div>';   

        return $html;
        
    }

    public function footer_shortcode() {
        $html = '';

        $phone_text = 'Զանգահարել պատվիրելու համար';
        $furniture_text = 'Որակյալ կահույք մատչելի գներով';

        if(isset($_GET['language']) && $_GET['language'] === "EN"){
            $phone_text = 'Call to order +37494000305';
            $furniture_text = 'Quality furniture at affordable prices';
        } else if(isset($_GET['language']) && $_GET['language'] === "RU"){
            $phone_text =  'Позвоните, чтобы заказать +37494000305';
            $furniture_text = 'Качественная мебель по доступным ценам';
        } else if(isset($_GET['language']) && $_GET['language'] === "IR"){
            $phone_text = '37494000305+ برای سفارش تماس بگیرید';
            $furniture_text = 'مبلمان با کیفیت با قیمت‌های مناسب';
        }   
     
        $html .= '<div id="footer" class="footer">';
            $html .= '<div class="container">';
                $html .= '<div class="furniture">';
                    $html .= '<h2>KK FURNITURE</h2>';
                    $html .= '<div class="tel_container">';
                        $html .= '<a href="tel:+37494000305">';
                            $html .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="30" width="30" version="1.1" id="Capa_1" viewBox="0 0 27.936 27.936" xml:space="preserve">';
                                $html .= '<g data-v-85c0f0d4="">';
                                $html .= '<path data-v-85c0f0d4="" d="M19.846,0H8.092C6.967,0,6.059,0.913,6.059,2.034v23.868c0,1.122,0.908,2.034,2.033,2.034h11.754 c1.121,0,2.031-0.912,2.031-2.034V2.034C21.877,0.913,20.967,0,19.846,0z M11.243,1.472h5.451v0.594h-5.451V1.472z M7.584,3.433 h12.77v11.039H7.584V3.433z M16.506,19.835v-1.764h3.525v1.764H16.506z M20.032,20.823v1.764h-3.525v-1.764H20.032z M16.506,17.155 V15.39h3.525v1.765H16.506z M11.43,25.337H7.903v-1.763h3.527V25.337z M11.43,22.586H7.903v-1.764h3.527V22.586z M11.43,19.835 H7.903v-1.764h3.527V19.835z M11.43,17.155H7.903V15.39h3.527V17.155z M15.733,25.337h-3.528v-1.763h3.527L15.733,25.337 L15.733,25.337z M15.733,22.586h-3.528v-1.764h3.527L15.733,22.586L15.733,22.586z M15.733,19.835h-3.528v-1.764h3.527 L15.733,19.835L15.733,19.835z M15.733,17.155h-3.528V15.39h3.527L15.733,17.155L15.733,17.155z M16.506,23.575h3.525v1.763h-3.525 C16.506,25.338,16.506,23.575,16.506,23.575z M19.879,27.855h-0.861c-0.281,0-0.508-0.228-0.508-0.507s0.227-0.504,0.508-0.504 h0.861c0.279,0,0.508,0.225,0.508,0.504C20.387,27.627,20.159,27.855,19.879,27.855z"></path>';
                                $html .= '</g>';
                            $html .= '</svg>';
                            $html .= $phone_text;
                        $html .= '</a>';
                    $html .= '</div>';
                $html .= '</div>';
                $html .= '<div>';
                    $html .= '<h3>'. $furniture_text .'</h3>';
                    $html .= '<div class="logoContainer">';
                        $html .= '<a href="https://www.facebook.com/profile.php?id=100009769080688" aria-label="Facebook" target="_blank">';
                            $html .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="facebook"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"></path></svg>';
                        $html .= '</a>';
                        $html .= '<a href="viber://chat?number=%2B37494000305" aria-label="Viber" target="_blank">';
                            $html .= '<svg class="viber" xmlns="http://www.w3.org/2000/svg" height="80" width="80" version="1.1" id="Layer_1" viewBox="-94.79835 -166.597 821.5857 999.582" fill="#7360f2"><path id="path182" d="M560.651 64.998c-16.56-15.28-83.48-63.86-232.54-64.52 0 0-175.78-10.6-261.47 68-47.7 47.71-64.48 117.52-66.25 204.07-1.77 86.55-4.06 248.75 152.29 292.73h.15l-.1 67.11s-1 27.17 16.89 32.71c21.64 6.72 34.34-13.93 55-36.19 11.34-12.22 27-30.17 38.8-43.89 106.93 9 189.17-11.57 198.51-14.61 21.59-7 143.76-22.66 163.63-184.84 20.51-167.17-9.92-272.91-64.91-320.57zm18.12 308.58c-16.77 135.42-115.86 143.93-134.13 149.79-7.77 2.5-80 20.47-170.83 14.54 0 0-67.68 81.65-88.82 102.88-3.3 3.32-7.18 4.66-9.77 4-3.64-.89-4.64-5.2-4.6-11.5.06-9 .58-111.52.58-111.52s-.08 0 0 0c-132.26-36.72-124.55-174.77-123.05-247.06 1.5-72.29 15.08-131.51 55.42-171.34 72.48-65.65 221.79-55.84 221.79-55.84 126.09.55 186.51 38.52 200.52 51.24 46.52 39.83 70.22 135.14 52.89 274.77z" class="cls-1" ></path><path id="path184" d="M389.471 268.768q-2.46-49.59-50.38-52.09" class="cls-2" ></path><path id="path186" d="M432.721 283.268q1-46.2-27.37-77.2c-19-20.74-45.3-32.16-79.05-34.63" class="cls-2" ></path><path id="path188" d="M477.001 300.588q-.61-80.17-47.91-126.28t-117.65-46.6" class="cls-2" ></path><path id="path190" d="M340.761 381.678s11.85 1 18.23-6.86l12.44-15.65c6-7.76 20.48-12.71 34.66-4.81a366.67 366.67 0 0130.91 19.74c9.41 6.92 28.68 23 28.74 23 9.18 7.75 11.3 19.13 5.05 31.13 0 .07-.05.19-.05.25a129.81 129.81 0 01-25.89 31.88c-.12.06-.12.12-.23.18q-13.38 11.18-26.29 12.71a17.39 17.39 0 01-3.84.24 35 35 0 01-11.18-1.72l-.28-.41c-13.26-3.74-35.4-13.1-72.27-33.44a430.39 430.39 0 01-60.72-40.11 318.31 318.31 0 01-27.31-24.22l-.92-.92-.92-.92-.92-.92c-.31-.3-.61-.61-.92-.92a318.31 318.31 0 01-24.22-27.31 430.83 430.83 0 01-40.11-60.71c-20.34-36.88-29.7-59-33.44-72.28l-.41-.28a35 35 0 01-1.71-11.18 16.87 16.87 0 01.23-3.84q1.61-12.89 12.73-26.31c.06-.11.12-.11.18-.23a129.53 129.53 0 0131.88-25.88c.06 0 .18-.06.25-.06 12-6.25 23.38-4.13 31.12 5 .06.06 16.11 19.33 23 28.74a366.67 366.67 0 0119.74 30.94c7.9 14.17 2.95 28.68-4.81 34.66l-15.65 12.44c-7.9 6.38-6.86 18.23-6.86 18.23s23.18 87.73 109.79 109.84z" class="cls-1" ></path></svg>';
                        $html .= '</a>';
                        $html .=  '<a href="#" aria-label="Instagram">';
                            $html .=  '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="instagram">';
                                $html .= '<radialGradient id="rg" r="150%" cx="30%" cy="107%" >';
                                    $html .= '<stop stop-color="#fdf497" offset="0" ></stop>';
                                    $html .= '<stop stop-color="#fdf497" offset="0.05" ></stop>';
                                    $html .= '<stop stop-color="#fd5949" offset="0.45" ></stop>';
                                    $html .= '<stop stop-color="#d6249f" offset="0.6" ></stop>';
                                    $html .= '<stop stop-color="#285AEB" offset="0.9" ></stop>';
                                $html .= '</radialGradient>';
                                $html .= '<path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" ></path>';
                            $html .= '</svg>';
                        $html .= '</a>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
    
        return $html;
    }
    
    public function about_us_shortcode() {
        $about_us = get_field('about_us');

        if(!is_array($about_us)) return ;

        $html = '';

        $html = '<div class="about_component" role="button" tabindex="0" aria-label="Expand details">';
            $html .= '<div class="aboutUsContainer" data-aos="flip-up">';
                $lang = '';

                if($_GET['language']){
                    $lang = strtolower($_GET['language']);
                }

                if($about_us['titles']) { 
                    
                    $title = $about_us['titles']['title'];

                  

                    if($lang && $lang !== 'am' && $about_us['titles']['title_' . $lang]){
                        $title = $about_us['titles']['title_' . $lang];
                    }
                    
                    $html .= '<h1>'.$title.'</h1>';
                }

                if($about_us['descriptions']) {
                    $description =  $about_us['descriptions']['description'];

                    if($lang && $lang !== 'am' && $about_us['descriptions']['description_' . $lang]){
                        $description = $about_us['descriptions']['description_' . $lang];
                    }

                    $html .= $description;
                }
                
            $html .= '</div>';

            if( $about_us['image']){
                $html .= '<div class="imgContainer fadeIn">';
                    $html .= '<img src="'.$about_us['image'].'" alt="About Us" width="300" height="300" class="img lazyload" data-aos="flip-up">';
                $html .= '</div>';
            }
           
        $html .= '</div>';
    
        return $html;
    }

    function home_carousel_shortcode($atts) {
        $gallery_images = get_post_meta(get_the_ID(), '_custom_gallery', true);
        $gallery_images = !empty($gallery_images) ? json_decode($gallery_images, true) : [];
    
        $html = '';
    
        if (!empty($gallery_images)) {
            $html .= '<div class="carousel_component swiper-container">';
                $html .= '<div class="swiper-wrapper carouselImages">';
            
                    foreach ($gallery_images as $image_id) {
                        $image_url = wp_get_attachment_image_url($image_id, 'large');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);  // Alt text
                        $caption = wp_get_attachment_caption($image_id); 
            
                        $html .= '<div class="swiper-slide imgContainer">';
                            $html .= '<figure class="carousel-item">';
                                $html .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="carousel-image" width="100%" height="auto" loading="lazy">';
                
                            if ($caption) {
                                $html .= '<figcaption class="carousel-caption">' . esc_html($caption) . '</figcaption>';
                            }
                
                            $html .= '</figure>';
                        $html .= '</div>';
                    }
        
                $html .= '</div>'; 
                $html .= '<div class="swiper-pagination"></div>';
                $html .= '<div class="swiper-button-next swiper-button-color"></div>';
                $html .= '<div class="swiper-button-prev swiper-button-color"></div>';
            $html .= '</div>';  
        }
    
        return $html;
    }
    

    function home_works_shortcode($atts) {
        $html = '';

        $lang = '';
        
        if($_GET['language']){
            $lang = '?language=' . $_GET['language'];
        }
    
        $query = new \WP_Query(array(
            'post_type'      => 'works',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'ASC'
        ));
    
        if ($query->have_posts()) {
            $html .= '<div class="works_container">';

                $our_works_text = 'ՄԵՐ ԱՇԽԱՏԱՆՔՆԵՐԸ';

                if(isset($_GET['language']) && $_GET['language'] === "EN"){
                    $our_works_text = 'OUR WORKS';
                } else if(isset($_GET['language']) && $_GET['language'] === "RU"){
                    $our_works_text = 'НАШИ РАБОТЫ';
                } else if(isset($_GET['language']) && $_GET['language'] === "IR"){
                    $our_works_text = 'کارهای ما';
                }   

                $html .= '<h2>'. $our_works_text .'</h2>';
                $html .= '<div class="works">';
    
                while ($query->have_posts()) {
                    $query->the_post();
                    $image_url =  get_the_post_thumbnail_url() ?? get_site_icon_url();
                    $work_title = get_the_title();
                    $title_en = get_field('title_en',get_the_ID());
                    $title_ru = get_field('title_ru',get_the_ID());
                    $title_ir = get_field('title_ir',get_the_ID());

                    if(isset($_GET['language']) && $_GET['language'] === "EN" &&  $title_en){
                        $work_title =  $title_en;
                    } else if(isset($_GET['language']) && $_GET['language'] === "RU" && $title_ru){
                        $work_title = $title_ru;
                    } else if(isset($_GET['language']) && $_GET['language'] === "IR" && $title_ir){
                        $work_title = $title_ir;
                    } 

                    $html .= '<div class="work fade-in aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200">';
                        $html .= '<a href="' . get_the_permalink() . $lang . '" aria-label="' . esc_attr($work_title) . '">';
                            $html .= '<div class="img lazyload" style="background-image: url(\'' . get_the_post_thumbnail_url() . '\')">';
                                $html .= '<div class="hoverCategory">';
                                    $html .= '<h3>' .  $work_title . '</h3>';
                                $html .= '</div>'; 
                            $html .= '</div>'; 
                        $html .= '</a>';
                    $html .= '</div>';  
                }
    
                $html .= '</div>'; 
            $html .= '</div>';  
    
            wp_reset_postdata();
        }
    
        return $html;
    }

    public function services_shortcode()
    {
        $services_title = get_the_title();
        $title_en = get_field('title_en',get_the_ID());
        $title_ru = get_field('title_ru',get_the_ID());
        $title_ir = get_field('title_ir',get_the_ID());

        if(isset($_GET['language']) && $_GET['language'] === "EN" &&  $title_en){
            $services_title =  $title_en;
        } else if(isset($_GET['language']) && $_GET['language'] === "RU" && $title_ru){
            $services_title = $title_ru;
        } else if(isset($_GET['language']) && $_GET['language'] === "IR" && $title_ir){
            $services_title = $title_ir;
        } 

        $services_title = strtoupper($services_title);
        
        $html = '<div class="service-container">';
            $html .= '<h1 data-aos="fade-in" data-aos-duration="1200" class="aos-init aos-animate services_title">' . $services_title . '</h1>';
            $html .= '<div class="services_container">';

            $services = get_field('services');

            if ($services) {
                foreach ($services as $index => $service) {
                    $title = $service['title'];
                    $desc = apply_filters('the_content', $service['description']); 
                    
                    if(isset($_GET['language']) && $_GET['language'] === "EN"){
                        if($service['title_en']){
                            $title = $service['title_en'];
                        }
                        if($service['description_en']){
                            $desc = $service['description_en'];
                        }
                    } else if(isset($_GET['language']) && $_GET['language'] === "RU"){
                        if($service['title_ru']){
                            $title = $service['title_ru'];
                        }
                        if($service['description_ru']){
                            $desc  = $service['description_ru'];
                        }
                    } else if(isset($_GET['language']) && $_GET['language'] === "IR"){
                        if($service['title_ir']){
                            $title = $service['title_ir'];
                        }
                        if($service['description_ir']){
                            $desc = $service['description_ir'];
                        }

                    } 

                    $imgUrl = $service['image']['url'];
                 
                    $html .= '<div class="services aos-init" data-aos="fade-up" data-aos-duration="1200">';
                        $html .= '<div class="img_container">';
                            $html .= '<img alt="' . esc_attr($title) . '" width="300" height="300" class="lazyload" data-src="' . esc_url($imgUrl) . '">';
                        $html .= '</div>';
                        $html .= '<div class="desc_container" data-aos="fade-up" data-aos-duration="1200">';
                            $html .= '<h2>' . esc_html($title) . '</h2>';
                            $html .= '<div>' . $desc . '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            }
        
            $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    public function works_shortcode()
    {
        $gallery_images = get_post_meta(get_the_ID(), '_custom_gallery', true);
        $gallery_images = !empty($gallery_images) ? json_decode($gallery_images, true) : [];
        $work_title = get_the_title();
        $title_en = get_field('title_en',get_the_ID());
        $title_ru = get_field('title_ru',get_the_ID());
        $title_ir = get_field('title_ir',get_the_ID());

        if(isset($_GET['language']) && $_GET['language'] === "EN" && $title_en){
            $work_title = $title_en;
        } else  if(isset($_GET['language']) && $_GET['language'] === "IR" && $title_ir){
            $work_title =  $title_ir;
        }  else  if(isset($_GET['language']) && $_GET['language'] === "RU" && $title_ru){
            $work_title = $title_ru;
        }
      
        ob_start();
        ?>
            <div class="works_title">
                <h1><?php echo $work_title ?></h1>
            </div>
            <div class="categoriesContainer category_hyurasenyak">
                <div class="swiper-container-categories">
                    <div class="swiper-wrapper">
                        <?php
                        foreach($gallery_images as $index => $image_id) {
                            
                            $image_url = wp_get_attachment_image_url($image_id, 'large');
                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);  // Alt text
                            ?>
                              <div class="swiper-slide">
                                <a href="<?php echo esc_url($image_url) ?>"  data-fancybox="gallery"  data-caption= "Image <?php echo $index + 1 ?>">
                                    <img
                                        alt="Image <?php echo $index + 1 ?>"
                                        class="img lazyload"
                                        data-aos="fade-in"
                                        height="350"
                                        width="400"
                                        src="<?php echo esc_url($image_url) ?>"
                                        data-src="<?php echo esc_url($image_url) ?>"
                                        loading="lazy"
                                    >
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php
        return ob_get_clean();
    }

    public function languages_shortcode() {
        $html = '';
        $am_flag =  get_stylesheet_directory_uri() . '/assets/images/am-flag.gif';
        $en_flag =  get_stylesheet_directory_uri() . '/assets/images/uk-flag.gif';
        $ir_flag =  get_stylesheet_directory_uri() . '/assets/images/ir-flag.gif';
        $ru_flag =  get_stylesheet_directory_uri() . '/assets/images/ru-flag.gif';

        $languages = [
                        ['language' => 'am', 'flag' => $am_flag, 'href' => '?language=AM'],
                        ['language' => 'en', 'flag' => $en_flag, 'href' => '?language=EN'],
                        ['language' => 'ir', 'flag' => $ir_flag, 'href' => '?language=IR'],
                        ['language' => 'ru', 'flag' => $ru_flag, 'href' => '?language=RU'],
                    ];

        $html .= '<div class="languages">';
            foreach($languages as $language){
                $html .= '<a href="'.$language['href'].'" class="'.$language['language'].'">';
                    $html .= '<img src="'.$language['flag'].'" width="30" height="20">';
                $html .= '</a>';  
            }  
        $html .= '</div>';

        return  $html; 
    }

    public function archive_shortcode(array $atts){
        $html = '';

        $atts = shortcode_atts(
            array(
                'archive' => 'false', 
            ), 
            $atts, 
            'archive_title'  
        );

        $all_works_text = "Բոլոր Աշխատանքները";

        if(isset($_GET['language']) && $_GET['language'] === "EN"){
            $all_works_text = 'All Works';
        } else if(isset($_GET['language']) && $_GET['language'] === "RU"){
            $all_works_text =  'Все Работы';
        } else if(isset($_GET['language']) && $_GET['language'] === "IR"){
            $all_works_text = 'تمام پروژه‌ها';
        }

        $all_works_text = mb_strtoupper($all_works_text, 'UTF-8');
        $archive_title = '';
       
        if (is_archive()) {
            if (have_posts()) {
                $html .= "<div class='archive'>";
                $html .= "<div class='archive_title'>";
                $html .= '<h1>' . $all_works_text . '</h1>';
                $html .= "</div>";
                $html .= "<div class='archive_posts'>";
                while (have_posts()) {
                    the_post();
        
                    $archive_title = get_the_title();
                    $post_permalink = get_permalink();
        
                    $title_en = get_field('title_en', get_the_ID());
                    $title_ru = get_field('title_ru', get_the_ID());
                    $title_ir = get_field('title_ir', get_the_ID());
        
                    if ($_GET['language'] === "EN" && $title_en) {
                        $archive_title = $title_en;
                    } elseif ($_GET['language'] === "RU" && $title_ru) {
                        $archive_title = $title_ru;
                    } elseif ($_GET['language'] === "IR" && $title_ir) {
                        $archive_title = $title_ir;
                    }
        
                    $html .= '<a href="' . esc_url($post_permalink) . '" class="archive_post">';
                    
                    $html .= "<div class='archive_post_image'>";
                    if (has_post_thumbnail()) {
                        $html .= get_the_post_thumbnail(get_the_ID(), 'full'); 
                    }
                    $html .= "</div>";
        
                    $html .= "<div class='archive_post_title'>";
                    $html .= '<h2>' . $archive_title . '</h2>';
                    $html .= "</div>";
        
                    $html .= "</a>";
                }
                $html .= "</div>";
        
                $html .= "</div>";
            }
        }

        return  $html;
    }


}
