jQuery(document).ready(function($) {

    $(function () {
      $('[data-bs-toggle="popover"]').popover().click(function(e) {
        // e.preventDefault();
      });
    });
  
    var body = $('body');
    var scrolled = false;
    var navbarClasses = $('#main-nav').attr('class');
    var navbarClassesBeforeOffcanvas = navbarClasses;

    // // switch to dark navbar on offcanvas show
    $('#main-nav .offcanvas').on('show.bs.offcanvas', function () {
        navbarClassesBeforeOffcanvas = $('#main-nav').attr('class');
        $('#main-nav').removeClass('navbar-light').addClass('navbar-dark');
    });

    // // switch to light navbar on offcanvas hide
    $('#main-nav .offcanvas').on('hide.bs.offcanvas', function () {
        $('#main-nav').removeClass('navbar-dark').addClass(navbarClassesBeforeOffcanvas);
    });



    jQuery(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 25) {
            body.addClass("scrolled");
            scrolled = true;
            $('#main-nav').removeClass('navbar-dark').addClass('navbar-light bg-white');
        } else {
            body.removeClass("scrolled");
            scrolled = false;
            $('#main-nav').removeClass('navbar-light bg-white').addClass(navbarClasses);
        }

        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            body.addClass("near-bottom");
        } else {
            body.removeClass("near-bottom");
        }
    });

    $('#navbarNavDropdown').on('show.bs.collapse', function () {
        body.addClass('menu-open');
    });
    $('#navbarNavOffcanvas').on('show.bs.offcanvas', function () {
        body.addClass('menu-open');
    });

    $('#navbarNavDropdown').on('hide.bs.collapse', function () {
        body.removeClass('menu-open');
    });
    $('#navbarNavOffcanvas').on('hide.bs.offcanvas', function () {
        body.removeClass('menu-open');
    });
    

});


/* Carruseles */

jQuery('.slick-slider-default').slick({
  dots: true,
  arrows: true,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  adaptiveHeight: true,
});

jQuery('.slick-carousel, .wp-block-group.is-style-slick-carousel > .wp-block-group__inner-container, .wp-block-gallery.is-style-slick-carousel').slick({
  dots: false,
  arrows: true,
  infinite: true,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

jQuery('.wp-block-group.is-layout-flex.is-style-slick-carousel-logos, .wp-block-group.is-style-slick-carousel-logos > .wp-block-group__inner-container, .wp-block-gallery.is-style-slick-carousel-logos').slick({
  dots: true,
  arrows: true,
  infinite: true,
  speed: 300,
  slidesToShow: 6,
  slidesToScroll: 6,
  autoplay: false,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4
      }
    },
    {
      breakpoint: 782,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }    
    
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});