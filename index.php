<?php get_header(); ?>

<main id="primary" class="site-main">

    <?php
    if ( have_posts() ) :

        /* Начало цикла */
        while ( have_posts() ) :
            the_post();

            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php

        endwhile;

    else :
        // Если постов нет
        echo '<p>No content found.</p>';

    endif;
    ?>

</main><?php get_footer(); ?>