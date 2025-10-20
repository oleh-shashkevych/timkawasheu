<?php
/**
 * The template for displaying the landing page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TimkawashEU_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    // Стандартный цикл WordPress. Он может вывести контент из редактора,
    // но основную логику мы будем строить с помощью ACF ниже.
    while ( have_posts() ) :
        the_post();
        
        // Эта функция выведет контент, который ты добавишь
        // в стандартный редактор WordPress для этой страницы.
        // Полезно для основного текста, если он нужен.
        the_content();

    endwhile; // Конец цикла.
    ?>

    </main><?php
get_footer();