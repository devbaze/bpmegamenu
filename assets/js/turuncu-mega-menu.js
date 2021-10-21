jQuery.noConflict();
(function ($) {

    var bpmenuMegaMenu = {
        init: function (jQueyr) {
            $('.bpmenu-container').append('<div class="bpmenu-backdrop"></div>')

            $('body').on('click', '.bpmenu-burger, .bpmenu-mobile-close, .bpmenu-backdrop', function(e){
                e.preventDefault();
                $('.bpmenu-menu').toggleClass('mobile');
                $('html').toggleClass('bpmenu-mobile-backdrop');
            });
        },
    };

    $(window).bind("load", function () {
        bpmenuMegaMenu.init();
    });

})(jQuery);