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

    // --- Mobile Burger Menu Logic (ОБНОВЛЕНО) ---
    const burgerToggle = document.querySelector('.burger-menu-toggle');
    const siteNav = document.querySelector('#site-navigation');
    const body = document.body;
    const siteOverlay = document.querySelector('.site-overlay'); // Наш новый оверлей
    const menuLinks = document.querySelectorAll('#site-navigation a'); // Все ссылки в меню

    // Проверяем наличие всех элементов
    if (burgerToggle && siteNav && body && siteOverlay && menuLinks.length > 0) {

        // Функция ОТКРЫТИЯ меню
        const openMenu = () => {
            burgerToggle.classList.add('is-active');
            siteNav.classList.add('is-open');
            body.classList.add('mobile-menu-open');
            siteOverlay.classList.add('is-visible'); // Показываем оверлей
            burgerToggle.setAttribute('aria-expanded', 'true');
        };

        // Функция ЗАКРЫТИЯ меню
        const closeMenu = () => {
            burgerToggle.classList.remove('is-active');
            siteNav.classList.remove('is-open');
            body.classList.remove('mobile-menu-open');
            siteOverlay.classList.remove('is-visible'); // Скрываем оверлей
            burgerToggle.setAttribute('aria-expanded', 'false');
        };

        // 1. Клик по бургеру (изменяем старую логику)
        burgerToggle.addEventListener('click', () => {
            const isExpanded = burgerToggle.getAttribute('aria-expanded') === 'true';
            if (isExpanded) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // 2. Клик по оверлею (запрос #2)
        siteOverlay.addEventListener('click', closeMenu);

        // 3. Клик по ссылке в меню (запрос #3)
        menuLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    }

    // --- Testimonials Slider Logic ---
    const testimonialsSlider = new Swiper('.testimonials-slider', {
        // Настройки
        loop: true,
        speed: 800,
        spaceBetween: 30, // Расстояние между слайдами
        autoplay: {
            delay: 6000, // Твои 6 секунд
            disableOnInteraction: false,
        },
        
        // Показываем 4 слайда на десктопе
        slidesPerView: 4,

        // Адаптация (Breakpoints)
        breakpoints: {
            // когда ширина <= 0px
            0: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // когда ширина <= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            // когда ширина <= 1024px
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            // когда ширина <= 1200px
            1200: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },

        // Навигация
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // Пагинация (точки внизу)
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

});