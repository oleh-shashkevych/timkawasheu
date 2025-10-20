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
    wp_enqueue_style( 'timkawasheu-style', get_stylesheet_uri(), array('timkawasheu-google-fonts'), '1.0.1' );

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

?>