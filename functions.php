<?php
/**
 * Функции и определения темы TimkawashEU Theme
 *
 * @package TimkawashEU_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Защита от прямого доступа
}

/**
 * =================================================================
 * 1. БАЗОВАЯ НАСТРОЙКА ТЕМЫ
 * =================================================================
 */
function timkawasheu_setup() {
    load_theme_textdomain( 'timkawasheu', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    register_nav_menus( array(
        'primary_menu' => esc_html__( 'Primary Menu', 'timkawasheu' ),
        'footer_menu'  => esc_html__( 'Footer Menu', 'timkawasheu' ),
    ) );
}
add_action( 'after_setup_theme', 'timkawasheu_setup' );

/**
 * =================================================================
 * 2. ПОДКЛЮЧЕНИЕ ШРИФТОВ, СТИЛЕЙ И СКРИПТОВ
 * =================================================================
 */
function timkawasheu_scripts() {
    // Подключаем Google Fonts: Montserrat
    wp_enqueue_style( 'timkawasheu-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap', array(), null );
    
    // Подключаем основной файл стилей
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0' );
    wp_enqueue_style( 'timkawasheu-style', get_stylesheet_uri(), array('timkawasheu-google-fonts'), '1.0.1' );

    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0', true );
    wp_enqueue_script( 'timkawasheu-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'timkawasheu_scripts' );

/**
 * =================================================================
 * 3. СОЗДАНИЕ СТРАНИЦЫ НАСТРОЕК ТЕМЫ С ПОМОЩЬЮ ACF PRO
 * =================================================================
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Theme Customization',
        'menu_title'	=> 'Theme Customization',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false,
        'icon_url'      => 'dashicons-admin-settings',
        'position'      => 21
    ));
}

/**
 * =================================================================
 * 4. РЕГИСТРАЦИЯ ГРУПП ПОЛЕЙ ACF ЧЕРЕЗ PHP
 * =================================================================
 */
if( function_exists('acf_add_local_field_group') ):

// Группа полей для настроек хедера
acf_add_local_field_group(array(
	'key' => 'group_header_settings',
	'title' => 'Theme Header Settings',
	'fields' => array(
		array(
			'key' => 'field_show_top_bar',
			'label' => 'Display Top Info Bar?',
			'name' => 'show_top_bar',
			'type' => 'true_false',
			'instructions' => 'Check this to display the informational bar above the main header.',
			'message' => '',
			'ui' => 1,
		),
		array(
			'key' => 'field_top_bar_text',
			'label' => 'Text for Top Info Bar',
			'name' => 'top_bar_text',
			'type' => 'textarea',
			'instructions' => 'Enter the text you want to display in the top bar.',
			'rows' => 2,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_show_top_bar',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'theme-general-settings', // Привязываем к нашей странице настроек
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
));

// Группа полей для настроек футера (Footer Settings ACF Group)
acf_add_local_field_group(array(
    'key' => 'group_footer_settings',
    'title' => 'Theme Footer Settings',
    'fields' => array(
        // Column 1: Description & Socials
        array(
            'key' => 'field_footer_description',
            'label' => 'Description under Logo',
            'name' => 'footer_description',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_social_links',
            'label' => 'Social Links',
            'name' => 'social_links',
            'type' => 'repeater',
            'layout' => 'block', // 'block' layout is more convenient for textareas
            'button_label' => 'Add Social Link',
            'sub_fields' => array(
                array(
                    'key' => 'field_social_icon_svg',
                    'label' => 'Social Icon (SVG Code)',
                    'name' => 'social_icon_svg',
                    'type' => 'textarea', // Changed from 'select'
                    'instructions' => 'Paste the full <svg>...</svg> code here.',
                ),
                array(
                    'key' => 'field_social_url',
                    'label' => 'URL',
                    'name' => 'social_url',
                    'type' => 'url',
                ),
            ),
        ),
        // Column 3: Contacts
        array(
            'key' => 'field_contact_phone',
            'label' => 'Phone Number',
            'name' => 'contact_phone',
            'type' => 'text',
        ),
        array(
            'key' => 'field_contact_email',
            'label' => 'Email Address',
            'name' => 'contact_email',
            'type' => 'email',
        ),
        array(
            'key' => 'field_work_schedule',
            'label' => 'Work Schedule',
            'name' => 'work_schedule',
            'type' => 'textarea',
            'rows' => 4,
        ),
        array(
            'key' => 'field_messenger_links',
            'label' => 'Messenger Links',
            'name' => 'messenger_links',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Messenger Link',
            'sub_fields' => array(
                array(
                    'key' => 'field_messenger_icon_svg',
                    'label' => 'Messenger Icon (SVG Code)',
                    'name' => 'messenger_icon_svg',
                    'type' => 'textarea', // Changed from 'select'
                    'instructions' => 'Paste the full <svg>...</svg> code here.',
                ),
                array(
                    'key' => 'field_messenger_url',
                    'label' => 'URL',
                    'name' => 'messenger_url',
                    'type' => 'url',
                ),
            ),
        ),
        // Bottom Row
        array(
            'key' => 'field_developer_name',
            'label' => 'Developer Credit Text',
            'name' => 'developer_name',
            'type' => 'text',
            'default_value' => 'Website development',
        ),
        array(
            'key' => 'field_developer_url',
            'label' => 'Developer URL',
            'name' => 'developer_url',
            'type' => 'url',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'theme-general-settings',
            ),
        ),
    ),
));

// Группа полей для секции "Главный экран"
acf_add_local_field_group(array(
	'key' => 'group_hero_section',
	'title' => 'Page Hero Section',
	'fields' => array(
		array(
			'key' => 'field_hero_background_image',
			'label' => 'Background Image',
			'name' => 'hero_background_image',
			'type' => 'image',
			'instructions' => 'Recommended size: 1920x1080px. This image will be darkened for text readability.',
			'return_format' => 'id', // Возвращаем ID для лучшей производительности
		),
		array(
			'key' => 'field_hero_title',
			'label' => 'Main Title (H1)',
			'name' => 'hero_title',
			'type' => 'text',
			'placeholder' => 'e.g., Become our partner',
		),
		array(
			'key' => 'field_hero_subtitle',
			'label' => 'Subtitle',
			'name' => 'hero_subtitle',
			'type' => 'textarea',
			'rows' => 2,
			'placeholder' => 'Short engaging text for wholesale customers.',
		),
		array(
			'key' => 'field_hero_button_text',
			'label' => 'Button Text',
			'name' => 'hero_button_text',
			'type' => 'text',
			'default_value' => 'Contact us',
		),
	),
	'location' => array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page', 
            ),
        ),
    ),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content', // Скрываем стандартный редактор
	),
));

// Группа полей для секции "Преимущества"
acf_add_local_field_group(array(
	'key' => 'group_advantages_section',
	'title' => 'Page Advantages Section',
	'fields' => array(
        array(
			'key' => 'field_advantages_section_title',
			'label' => 'Section Title',
			'name' => 'advantages_section_title',
			'type' => 'text',
            'placeholder' => 'e.g., Why Choose Timka Wash?',
		),
		array(
			'key' => 'field_advantages_repeater',
			'label' => 'Advantages',
			'name' => 'advantages',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Add Advantage',
			'sub_fields' => array(
				array(
					'key' => 'field_advantage_icon',
					'label' => 'Icon (SVG Code)',
					'name' => 'advantage_icon',
					'type' => 'textarea',
                    'instructions' => 'Paste the full <svg>...</svg> code here. Recommended size: 64x64px.',
				),
                array(
					'key' => 'field_advantage_title',
					'label' => 'Title',
					'name' => 'advantage_title',
					'type' => 'text',
				),
                array(
					'key' => 'field_advantage_description',
					'label' => 'Description',
					'name' => 'advantage_description',
					'type' => 'textarea',
                    'rows' => 3,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 1, // Ставим после Hero-секции
	'position' => 'normal',
	'style' => 'default',
));

// Группа полей для секции "Каталог"
acf_add_local_field_group(array(
	'key' => 'group_catalog_section',
	'title' => 'Page Catalog Section',
	'fields' => array(
		array(
			'key' => 'field_catalog_section_title',
			'label' => 'Section Title',
			'name' => 'catalog_section_title',
			'type' => 'text',
            'placeholder' => 'e.g., Our Products',
		),
		array(
			'key' => 'field_catalog_products',
			'label' => 'Products',
			'name' => 'catalog_products',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Add Product',
			'sub_fields' => array(
				array(
					'key' => 'field_product_image',
					'label' => 'Product Image',
					'name' => 'product_image',
					'type' => 'image',
                    'return_format' => 'url', // Возвращаем URL для <img>
                    'preview_size' => 'medium',
				),
                array(
					'key' => 'field_product_name',
					'label' => 'Product Name',
					'name' => 'product_name',
					'type' => 'text',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 2, // После секции "Преимущества"
	'position' => 'normal',
	'style' => 'default',
));

// Группа полей для секции "О компании"
acf_add_local_field_group(array(
	'key' => 'group_about_section',
	'title' => 'Page About Section',
	'fields' => array(
		array(
			'key' => 'field_about_section_title',
			'label' => 'Section Title',
			'name' => 'about_section_title',
			'type' => 'text',
            'placeholder' => 'e.g., About Timka Wash',
		),
        array(
			'key' => 'field_about_section_content',
			'label' => 'Content',
			'name' => 'about_section_content',
			'type' => 'wysiwyg', // Редактор с форматированием
            'tabs' => 'visual',
            'media_upload' => 0,
            'toolbar' => 'basic', // Упрощенная панель
		),
        array(
			'key' => 'field_about_section_image',
			'label' => 'Image',
			'name' => 'about_section_image',
			'type' => 'image',
            'return_format' => 'id',
            'instructions' => 'An engaging image of your process, team, or products.',
		),
        array(
			'key' => 'field_about_key_values',
			'label' => 'Key Values / Facts',
			'name' => 'about_key_values',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Add Value',
            'sub_fields' => array(
                array(
					'key' => 'field_about_value_icon',
					'label' => 'Icon (SVG Code)',
					'name' => 'value_icon',
					'type' => 'textarea',
				),
                array(
					'key' => 'field_about_value_text',
					'label' => 'Text',
					'name' => 'value_text',
					'type' => 'text',
				),
            ),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 3, // После "Каталога"
	'position' => 'normal',
	'style' => 'default',
));

// Группа полей для секции "Отзывы"
acf_add_local_field_group(array(
	'key' => 'group_testimonials_section',
	'title' => 'Page Testimonials Section',
	'fields' => array(
		array(
			'key' => 'field_testimonials_title',
			'label' => 'Section Title',
			'name' => 'testimonials_title',
			'type' => 'text',
            'placeholder' => 'e.g., What Our Partners Say',
		),
		array(
			'key' => 'field_testimonials_repeater',
			'label' => 'Testimonials',
			'name' => 'testimonials',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Add Testimonial',
			'sub_fields' => array(
				array(
					'key' => 'field_testimonial_name',
					'label' => 'Author Name',
					'name' => 'testimonial_name',
					'type' => 'text',
				),
                array(
					'key' => 'field_testimonial_text',
					'label' => 'Testimonial Text',
					'name' => 'testimonial_text',
					'type' => 'textarea',
                    'rows' => 4,
				),
                array(
					'key' => 'field_testimonial_rating',
					'label' => 'Rating (1-5)',
					'name' => 'testimonial_rating',
					'type' => 'number',
                    'min' => 1,
                    'max' => 5,
                    'step' => 1,
                    'default_value' => 5,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 4, // После "О компании"
	'position' => 'normal',
	'style' => 'default',
));

// Группа полей для секции "Контактная форма"
acf_add_local_field_group(array(
	'key' => 'group_contact_section',
	'title' => 'Page Contact Section',
	'fields' => array(
		array(
			'key' => 'field_contact_section_title',
			'label' => 'Section Title',
			'name' => 'contact_section_title',
			'type' => 'text',
            'placeholder' => 'e.g., Let\'s Start a Partnership',
		),
        array(
			'key' => 'field_contact_section_intro',
			'label' => 'Intro Text',
			'name' => 'contact_section_intro',
			'type' => 'textarea',
            'rows' => 3,
            'placeholder' => 'Short text encouraging users to fill out the form.',
		),
        array(
			'key' => 'field_contact_section_image',
			'label' => 'Image',
			'name' => 'contact_section_image',
			'type' => 'image',
            'return_format' => 'id',
		),
        array(
			'key' => 'field_contact_form_shortcode',
			'label' => 'Contact Form 7 Shortcode',
			'name' => 'contact_form_shortcode',
			'type' => 'text',
            'instructions' => 'Paste the CF7 shortcode here, e.g., [contact-form-7 id="123"]',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 6, // Последняя секция
	'position' => 'normal',
	'style' => 'default',
));

endif;

/**
 * =================================================================
 * 5. ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ (HELPERS)
 * =================================================================
 */
function timkawasheu_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'timkawasheu_mime_types');

/**
 * Возвращает массив разрешенных тегов и атрибутов для wp_kses (для SVG)
 * @return array
 */
function timkawasheu_get_allowed_svg_tags() {
    return array(
        'svg' => array(
            'xmlns' => true,
            'viewBox' => true,  // <-- Добавляем camelCase
            'viewbox' => true,  // (и оставляем lowercase)
            'width' => true,
            'height' => true,
            'fill' => true,
            'stroke' => true,
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
            'class' => true,
            'aria-hidden' => true,
        ),
        'g' => array( // <-- ДОБАВЛЕН ТЕГ <g>
            'id' => true,
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
            'fill' => true,
            'stroke' => true,
            'transform' => true,
        ),
        'path' => array(
            'd' => true,
            'fill' => true,
            'stroke' => true,
            'fill-rule' => true,  // <-- ДОБАВЛЕН
            'clip-rule' => true,  // <-- ДОБАВЛЕН
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
        ),
        'circle' => array(
            'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true,
        ),
        'rect' => array(
            'x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true,
        ),
        'polyline' => array(
            'points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true,
        ),
        'line' => array(
            'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true,
        ),
    );
}

/**
 * Отключает автоматическое добавление <p> и <br> в Contact Form 7
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

?>