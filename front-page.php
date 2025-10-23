<?php
get_header();
?>

<main id="primary" class="site-main">

    <?php
    // --- Hero Section ---
    
    // Получаем данные из полей
    $hero_bg_id    = get_field('hero_background_image');
    $hero_title    = get_field('hero_title');
    $hero_subtitle = get_field('hero_subtitle');
    $hero_btn_text = get_field('hero_button_text');
    
    // Новые поля
    $show_benefit = get_field('show_hero_key_benefit');
    $benefit_icon = get_field('hero_key_benefit_icon');
    $benefit_text = get_field('hero_key_benefit_text');
    
    // Получаем URL картинки из её ID
    $hero_bg_url = $hero_bg_id ? wp_get_attachment_image_url($hero_bg_id, 'full') : '';
    // Получаем список разрешенных SVG тегов
    $allowed_svg_tags = timkawasheu_get_allowed_svg_tags();

    // Проверяем, есть ли хотя бы заголовок, чтобы отобразить секцию
    if( $hero_title ):
    ?>
    <section class="hero-section" style="background-image: url('<?php echo esc_url($hero_bg_url); ?>');">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <?php if ($hero_title): ?>
                    <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>

                <?php if ($hero_subtitle): ?>
                    <p class="hero-subtitle"><?php echo nl2br(esc_html($hero_subtitle)); ?></p>
                <?php endif; ?>

                <?php
                if ( $show_benefit && $benefit_text ): 
                ?>
                    <div class="hero-key-benefit">
                        <?php if ($benefit_icon): ?>
                            <?php echo wp_kses($benefit_icon, $allowed_svg_tags); ?>
                        <?php endif; ?>
                        <span><?php echo esc_html($benefit_text); ?></span>
                    </div>
                <?php endif;
                ?>

                <?php if ($hero_btn_text): ?>
                    <div class="hero-button-wrapper">
                        <a href="#contact-section" class="hero-button">
                            <?php echo esc_html($hero_btn_text); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // --- Brands Section (Static Grid) ---
    $brands_title = get_field('brands_section_title');
    $logos = get_field('brand_logos');

    if( $brands_title || $logos ):
    ?>
    <section class="brands-section">
        <div class="container">
            <?php if ($brands_title): ?>
                <h2 class="section-title"><?php echo esc_html($brands_title); ?></h2>
            <?php endif; ?>
            
            <?php if( $logos ): ?>
                <div class="brands-grid-wrapper"> <div class="brands-grid"> <?php // Оставляем ТОЛЬКО ОДИН цикл
                        foreach( $logos as $logo ): ?>
                            <div class="brand-logo-item">
                                <img src="<?php echo esc_url($logo['brand_logo_img']['url']); ?>" alt="<?php echo esc_attr($logo['brand_logo_img']['alt']); ?>" />
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // --- Production Cycle Section ---
    $cycle_title = get_field('cycle_section_title');
    $cycle_bg_id = get_field('cycle_background_image');
    $cycle_bg_url = $cycle_bg_id ? wp_get_attachment_image_url($cycle_bg_id, 'full') : '';
    
    $cycle_img_id = get_field('cycle_central_image');
    $cycle_img_url = $cycle_img_id ? wp_get_attachment_image_url($cycle_img_id, 'large') : '';
    
    if( $cycle_title || $cycle_img_id ):
    ?>
    <section class="cycle-section" style="background-image: url('<?php echo esc_url($cycle_bg_url); ?>');">
        <div class="cycle-overlay"></div>
        <div class="container">
            <?php if ($cycle_title): ?>
                <h2 class="section-title"><?php echo esc_html($cycle_title); ?></h2>
            <?php endif; ?>

            <div class="cycle-grid">
                
                <div class="cycle-graphic-wrapper">
                    <?php if ($cycle_img_url): ?>
                        <img src="<?php echo esc_url($cycle_img_url); ?>" alt="<?php echo esc_attr($cycle_title); ?>">
                    <?php endif; ?>
                </div>

                <div class="cycle-steps-wrapper">
                    <?php if( have_rows('cycle_steps') ): ?>
                        <ol class="cycle-steps-list">
                            <?php while( have_rows('cycle_steps') ): the_row(); 
                                $step_title = get_sub_field('step_title');
                                $step_desc = get_sub_field('step_description');
                            ?>
                                <li>
                                    <div class="step-content">
                                        <h4><?php echo esc_html($step_title); ?></h4>
                                        <p><?php echo esc_html($step_desc); ?></p>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ol>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // --- Advantages Section ---

    $advantages_title = get_field('advantages_section_title');
    $advantages = get_field('advantages');

    // Определяем разрешенные теги для SVG (можно вынести в functions.php, если используется часто)
    $allowed_svg_tags = timkawasheu_get_allowed_svg_tags();

    // Проверяем, есть ли заголовок или сами преимущества
    if( $advantages_title || have_rows('advantages') ):
    ?>
    <section class="advantages-section">
        <div class="container">
            <?php if ($advantages_title): ?>
                <h2 class="section-title"><?php echo esc_html($advantages_title); ?></h2>
            <?php endif; ?>

            <?php if( have_rows('advantages') ): ?>
                <div class="advantages-grid">
                    <?php while( have_rows('advantages') ): the_row(); 
                        $icon = get_sub_field('advantage_icon');
                        $title = get_sub_field('advantage_title');
                        $description = get_sub_field('advantage_description');
                    ?>
                        <div class="advantage-item">
                            <?php if ($icon): ?>
                                <div class="advantage-icon">
                                    <?php echo wp_kses($icon, $allowed_svg_tags); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($title): ?>
                                <h3 class="advantage-title"><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <p class="advantage-description"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // --- Catalog Section ---

    $catalog_title = get_field('catalog_section_title');

    if( $catalog_title || have_rows('catalog_products') ):
    ?>
    <section class="catalog-section" id="catalog">
        <div class="container">
            <?php if ($catalog_title): ?>
                <h2 class="section-title"><?php echo esc_html($catalog_title); ?></h2>
            <?php endif; ?>

            <?php if( have_rows('catalog_products') ): ?>
                <div class="catalog-grid">
                    <?php while( have_rows('catalog_products') ): the_row(); 
                        $images = get_sub_field('product_images'); // Получаем массив картинок
                        $name = get_sub_field('product_name');

                        if( $images && $name ):
                    ?>
                        <div class="catalog-item">
                            <div class="catalog-item-image-wrapper swiper product-gallery-slider">
                                <div class="swiper-wrapper">
                                    <?php foreach( $images as $image ): ?>
                                        <div class="swiper-slide">
                                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <h3 class="catalog-item-name"><?php echo wp_kses($name, array('br' => array())); ?></h3>
                        </div>
                    <?php 
                        endif;
                    endwhile; 
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // --- About Section ---

    $about_title = get_field('about_section_title');
    $about_content = get_field('about_section_content');
    $about_image_id = get_field('about_section_image');
    $about_image_url = $about_image_id ? wp_get_attachment_image_url($about_image_id, 'large') : '';

    // Проверяем, есть ли хотя бы заголовок или контент
    if( $about_title || $about_content ):
    
    // Подготовим разрешенные теги SVG
    $allowed_svg_tags = timkawasheu_get_allowed_svg_tags();
    ?>
    <section class="about-section" id="company">
        <div class="container">
            <div class="about-grid">
                
                <div class="about-image-wrapper">
                    <?php if ($about_image_url): ?>
                        <img src="<?php echo esc_url($about_image_url); ?>" alt="<?php echo esc_attr($about_title); ?>">
                    <?php endif; ?>
                </div>

                <div class="about-content-wrapper">
                    <?php if ($about_title): ?>
                        <h2 class="section-title-left"><?php echo esc_html($about_title); ?></h2>
                    <?php endif; ?>

                    <?php if ($about_content): ?>
                        <div class="about-content">
                            <?php echo wpautop($about_content); // wpautop Cохраняет параграфы из WYSIWYG ?>
                        </div>
                    <?php endif; ?>

                    <?php if( have_rows('about_key_values') ): ?>
                        <ul class="about-values-list">
                            <?php while( have_rows('about_key_values') ): the_row(); 
                                $icon = get_sub_field('value_icon');
                                $text = get_sub_field('value_text');
                            ?>
                                <li class="value-item">
                                    <?php if ($icon): ?>
                                        <div class="value-icon">
                                            <?php echo wp_kses($icon, $allowed_svg_tags); ?>
                                        </div>
                                    <?php endif; ?>
                                    <span class="value-text"><?php echo esc_html($text); ?></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // --- Testimonials Section ---

    $testimonials_title = get_field('testimonials_title');

    if( $testimonials_title || have_rows('testimonials') ):
    ?>
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <?php if ($testimonials_title): ?>
                <h2 class="section-title"><?php echo esc_html($testimonials_title); ?></h2>
            <?php endif; ?>
        </div>

        <?php if( have_rows('testimonials') ): ?>
            <div class="testimonials-slider-wrapper">
                <div class="swiper testimonials-slider">
                    <div class="swiper-wrapper">
                        
                        <?php while( have_rows('testimonials') ): the_row(); 
                            $name = get_sub_field('testimonial_name');
                            $text = get_sub_field('testimonial_text');
                            $rating = (int) get_sub_field('testimonial_rating');
                            $first_letter = mb_substr($name, 0, 1); // Безопасно для кириллицы
                        ?>
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="testimonial-header">
                                        <div class="testimonial-avatar">
                                            <?php echo esc_html($first_letter); ?>
                                        </div>
                                        <div class="testimonial-meta">
                                            <h4 class="testimonial-name"><?php echo esc_html($name); ?></h4>
                                            <div class="testimonial-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star <?php echo ($i <= $rating) ? 'filled' : ''; ?>"></span>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <?php echo esc_html($text); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php
    // --- Contact Section ---

    $contact_title = get_field('contact_section_title');
    $contact_intro = get_field('contact_section_intro');
    $contact_image_id = get_field('contact_section_image');
    $contact_image_url = $contact_image_id ? wp_get_attachment_image_url($contact_image_id, 'large') : '';
    $contact_shortcode = get_field('contact_form_shortcode');

    if( $contact_title || $contact_shortcode ):
    ?>
    
    <section id="contact-section" class="contact-section">
        <div class="container">
            <div class="contact-grid">
                
                <div class="contact-content-wrapper">
                    <?php if ($contact_title): ?>
                        <h2 class="section-title-left"><?php echo esc_html($contact_title); ?></h2>
                    <?php endif; ?>

                    <?php if ($contact_intro): ?>
                        <p classs="contact-intro"><?php echo nl2br(esc_html($contact_intro)); ?></p>
                    <?php endif; ?>

                    <?php if ($contact_image_url): ?>
                        <div class="contact-image">
                            <img src="<?php echo esc_url($contact_image_url); ?>" alt="<?php echo esc_attr($contact_title); ?>">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="contact-form-wrapper">
                    <?php if ($contact_shortcode): ?>
                        <?php echo do_shortcode($contact_shortcode); // Выводим форму ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>

</main><?php
get_footer();