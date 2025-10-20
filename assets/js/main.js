document.addEventListener('DOMContentLoaded', function () {

    // --- Custom Language Switcher Logic ---
    const langSwitcher = document.querySelector('.language-switcher');
    if (langSwitcher) {
        const currentLang = langSwitcher.querySelector('.lang-current');

        // Open/close dropdown on click
        currentLang.addEventListener('click', function (event) {
            event.stopPropagation();
            langSwitcher.classList.toggle('is-open');
        });

        // Close dropdown if clicking elsewhere
        document.addEventListener('click', function () {
            if (langSwitcher.classList.contains('is-open')) {
                langSwitcher.classList.remove('is-open');
            }
        });
    }

    // --- Mobile Burger Menu Logic ---
    const burgerToggle = document.querySelector('.burger-menu-toggle');
    const siteNav = document.querySelector('#site-navigation');
    const body = document.body;

    if (burgerToggle && siteNav) {
        burgerToggle.addEventListener('click', () => {
            // Toggle classes to show/hide menu and animate burger
            burgerToggle.classList.toggle('is-active');
            siteNav.classList.toggle('is-open');
            body.classList.toggle('mobile-menu-open');

            // Update aria-expanded attribute for accessibility
            const isExpanded = burgerToggle.getAttribute('aria-expanded') === 'true';
            burgerToggle.setAttribute('aria-expanded', !isExpanded);
        });
    }

});