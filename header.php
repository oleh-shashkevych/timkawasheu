<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">

    <?php // -- Опциональная верхняя полоска (данные из ACF Options Page) --
    if ( get_field( 'show_top_bar', 'option' ) ) : 
        $top_bar_text = get_field( 'top_bar_text', 'option' );
        if ( ! empty( $top_bar_text ) ) :
    ?>
    <div class="top-bar">
        <div class="container">
            <?php echo esc_html( $top_bar_text ); ?>
        </div>
    </div>
    <?php 
        endif;
    endif; 
    ?>

    <div class="main-header">
        <div class="container">

            <div class="header-left">
                <?php // -- Custom Polylang Language Switcher --
                if ( function_exists( 'pll_the_languages' ) ) {
                    $languages = pll_the_languages( array( 'raw' => 1 ) );
                    $current_lang = null;
                    $other_langs = array();

                    foreach ( $languages as $lang ) {
                        if ( $lang['current_lang'] ) {
                            $current_lang = $lang;
                        } else {
                            $other_langs[] = $lang;
                        }
                    }

                    if ( $current_lang ) : ?>
                    <div class="language-switcher">
                        <div class="lang-current">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                            </svg>
                            <span><?php echo esc_html( strtoupper($current_lang['slug']) ); ?></span>
                        </div>
                        <?php if ( !empty($other_langs) ): ?>
                        <ul class="lang-dropdown">
                            <?php foreach ($other_langs as $lang) : ?>
                                <li>
                                    <a href="<?php echo esc_url($lang['url']); ?>">
                                        <?php echo esc_html( strtoupper($lang['slug']) ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php endif;
                }
                ?>
            </div>

            <div class="header-center">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    echo '<a class="site-title-fallback" href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>';
                }
                ?>
            </div>

            <div class="header-right">
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary_menu',
                        'menu_id'        => 'primary-menu',
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </nav>
                <div class="site-overlay"></div>
                <button class="burger-menu-toggle" aria-label="Open menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            
        </div>
    </div>

</header>