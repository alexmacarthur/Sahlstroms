var Sahlstroms = {

    windowHeight: $(window).height(),
    windowWidth: $(window).width(),
    $VanHolder : $('#VanHolder'),

    init : function() {
        this.slickSliders();
        this.navLinks();
        this.ajaxForms();
        this.mobileMenu();
        this.happyEaster();
        this.flexboxCheck();
    },

    flexboxCheck : function() {
        var d = document.documentElement.style;
        if (!('flexWrap' in d) && !('WebkitFlexWrap' in d) && !('msFlexWrap' in d)){
            $('body').addClass('no-flexbox');
        }
    }, 

    slickSliders : function() {
        $('#homeSlider').slick({
            dots: false,
            infinite: true,
            autoplaySpeed: 5000,
            speed: 2000,
            fade: true,
            cssEase: 'linear',
            autoplay:true
        });

        $('#brandsSlider').slick({
            dots: false,
            infinite: true,
            autoplaySpeed: 5000,
            speed: 200,
            cssEase: 'linear',
            autoplay:true,
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive : [{
                breakpoint: 750,
                settings: {
                    slidesToShow: 2
                }
            },{
                breakpoint: 600,
                settings: {
                    slidesToShow: 1
                }
            }
            ]
        });
    },

    navLinks : function() {
        var $navLinks = $('#navLinks');

        $navLinks.dropit({
            action: 'mouseenter'
        });

        $navLinks.on('click', '.dropit-trigger > a', function(e) {
            e.preventDefault();
        });
    },

    ajaxForms : function() {
        var form = $('#ajax-contact');
        var formMessages = $('.form-messages');
        $(form).submit(function(e) {
            e.preventDefault();
            formMessages.html('Processing...');
            formMessages.removeClass('processing success error').addClass('processing');

            $.ajax({
                type: 'POST',
                url: sahlstroms.ajax_url,
                data: $(form).serialize() + '&action=email_action'
            })
            .done(function(response) {
                $(formMessages).removeClass('error success processing');
                $(formMessages).addClass('success');
                $(formMessages).text("Your message was successfully sent.");

                $('#name').val('');
                $('#email').val('');
                $('#message').val('');
                $('#phonenumber').val('');
                $('#citystate').val('');
                $('#address').val('');
            })
            .fail(function(data) {
                $(formMessages).removeClass('error success processing');
                $(formMessages).addClass('error');
                $(formMessages).text("Oops! An error occured and your message could not be sent.");
                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text('Oops! An error occured and your message could not be sent.');
                }
            });
        });
    },

    mobileMenu : function() {
        var $mobileNavLinks = $('#mobileNavLinks');
        var $mobileNavLinksList = $('#mobileNavLinksList');
        var newMargin = ((Sahlstroms.windowHeight - $mobileNavLinksList.height()) / 2) < 75 ? 75 : (Sahlstroms.windowHeight - $mobileNavLinksList.height()) / 2;

        $('#mobile-menu-toggle').click(function(){
            if($mobileNavLinks.hasClass('open-mobile-menu')){
                $mobileNavLinks.removeClass('open-mobile-menu');
            }else{
                $mobileNavLinks.addClass('open-mobile-menu');
            }
        });

        $('#close-mobile-menu').click(function(){
           $mobileNavLinks.removeClass('open-mobile-menu');
        });

        $mobileNavLinksList.css('margin-top', newMargin);
    },

    happyEaster : function() {
        Sahlstroms.$VanHolder.css('height', Sahlstroms.windowHeight);

        var egg = new Egg("s,a,h,l,s,t,r,o,m", function(e) {
            Sahlstroms.easterEgg();
        }).listen();

        $('.mobile-only-es').on('click', '#eOnlyTrigger', function(e) {
            e.preventDefault();
            Sahlstroms.easterEgg();
        });

        $('.ribbon').on('click', '#eBanner', function(e) {
            e.preventDefault();
            Sahlstroms.easterEgg();
        });
    },

    easterEgg : function() {
        Sahlstroms.$VanHolder.addClass('move');

        setTimeout(function(){
            Sahlstroms.$VanHolder.removeClass('move');
        }, 9000);
    }
};

$(document).ready(function(){
    Sahlstroms.init();
});
