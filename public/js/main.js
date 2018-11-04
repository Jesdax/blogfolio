var bootstrap = function bootstrap(app) {
    if (document.readyState != 'loading') {
        app();
    } else {
        document.addEventListener('DOMContentLoaded', app);
    }
};

var app = function app() {

    (function borderEffects() {
        var navLinks = document.getElementsByClassName('nav')[0].
        getElementsByClassName('link');
        var updateBorder = function updateBorder(el) {
            el.addEventListener('click', function () {
                document.getElementsByClassName('current')[0].
                classList.remove('current');
                el.classList.add('current');
            });
        };
        Array.from(navLinks, updateBorder);
    })();

    (function mobileView() {
        var toggleMobileDropdown = function toggleMobileDropdown() {
            document.getElementsByClassName('nav')[0].
            classList.toggle('visible');
        };
        document.getElementsByClassName('fa-bars')[0].
        addEventListener('click', toggleMobileDropdown);
    })();

    (function carousel() {
        var rightArrow = document.getElementsByClassName('fa-arrow-right')[0];
        var leftArrow = document.getElementsByClassName('fa-arrow-left')[0];
        var location = document.getElementsByClassName('carousel__location')[0];
        var carouselPosition = 0;

        //move carousel +/-100% on arrow click, hide/show right or left arrow when needed
        rightArrow.addEventListener('click', function () {
            carouselPosition++;
            if (carouselPosition === 1) {
                leftArrow.classList.remove('hidden');
            } else
            if (carouselPosition === 6) {
                rightArrow.classList.add('hidden');
            }
            var moveRight = carouselPosition * 100 + '%';
            location.style.right = moveRight;
        });

        leftArrow.addEventListener('click', function () {
            carouselPosition--;
            if (carouselPosition === 0) {
                leftArrow.classList.add('hidden');
            } else
            if (carouselPosition === 5) {
                rightArrow.classList.remove('hidden');
            }
            var moveLeft = carouselPosition * 100 + '%';
            location.style.right = moveLeft;
        });
    })();
};
bootstrap(app);