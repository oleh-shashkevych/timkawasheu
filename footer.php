<footer id="colophon" class="site-footer">
    <?php
    // Определяем разрешенные теги для SVG для безопасности
    $allowed_svg_tags = array(
        'svg' => array(
            'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true,
        ),
        'path' => array(
            'd' => true, 'fill' => true,
        ),
    );
    ?>
    <div class="footer-main">
        <div class="container">
            <div class="footer-column footer-column-left">
                <?php
                if ( has_custom_logo() ) { the_custom_logo(); } 
                else { echo '<a class="site-title-fallback" href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>'; }
                
                if( $description = get_field('footer_description', 'option') ) { echo '<p class="footer-description">' . esc_html($description) . '</p>'; }
                
                if( have_rows('social_links', 'option') ): ?>
                    <div class="footer-social-icons">
                        <?php while( have_rows('social_links', 'option') ): the_row(); 
                            $svg_code = get_sub_field('social_icon_svg');
                            $url = get_sub_field('social_url');
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-icon">
                                <?php echo wp_kses($svg_code, $allowed_svg_tags); // Безопасный вывод SVG ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-column footer-column-center">
                <h4 class="footer-widget-title">Menu</h4>
                <?php wp_nav_menu( array('theme_location' => 'footer_menu', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => false) ); ?>
            </div>

            <div class="footer-column footer-column-right">
                <h4 class="footer-widget-title">Contacts</h4>
                <div class="footer-contact-info">
                    <?php 
                    if( have_rows('messenger_links', 'option') ): ?>
                        <div class="footer-messengers">
                            <?php while( have_rows('messenger_links', 'option') ): the_row(); 
                                $svg_code = get_sub_field('messenger_icon_svg');
                                $url = get_sub_field('messenger_url');
                            ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" class="messenger-icon">
                                    <?php echo wp_kses($svg_code, $allowed_svg_tags); // Безопасный вывод SVG ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php endif;

                    if( $phone = get_field('contact_phone', 'option') ) { echo '<a href="tel:'.esc_attr(preg_replace('/[^0-9+]/','',$phone)).'" class="footer-phone">'.esc_html($phone).'</a>'; }
                    if( $email = get_field('contact_email', 'option') ) { echo '<a href="mailto:'.esc_attr($email).'" class="footer-email">'.esc_html($email).'</a>'; }
                    if( $schedule = get_field('work_schedule', 'option') ) { echo '<div class="footer-schedule">'.nl2br(esc_html($schedule)).'</div>'; }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="copyright-text">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
            </div>
            <div class="developer-credit">
                <?php 
                $dev_name = get_field('developer_name', 'option');
                $dev_url = get_field('developer_url', 'option');
                if ($dev_name && $dev_url): ?>
                    <a href="<?php echo esc_url($dev_url); ?>" target="_blank"><?php echo esc_html($dev_name); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>