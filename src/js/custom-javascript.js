const { auto } = require("@popperjs/core");

jQuery(document).ready(function($) {

    $('[data-bs-toggle="popover"]').popover().click(function(e) {
      e.preventDefault();
    });

    // $('[data-infografia-target-image-id]').click(function(e) {
    //   $('[data-infografia-image-id]').removeClass('active');
    //   var targetImageId = $(this).data('infografia-target-image-id');
    //   $('[data-infografia-image-id=' + targetImageId + ']').addClass('active');
    // });
  
    // on popover show
    $('[data-bs-toggle="popover"]').on('show.bs.popover', function () {
      $('.estancias-infografia-completa').removeClass('active');
      $('[data-infografia-image-id]').removeClass('active');
      var targetImageId = $(this).data('infografia-target-image-id');
      $('[data-infografia-image-id=' + targetImageId + ']').addClass('active');
    });
    
    // on popover dismiss
    $('[data-bs-toggle="popover"]').on('hidden.bs.popover', function () {
      // si pasado un tiempo no hay ningún popover visible, se añade la clase active a todos
      setTimeout(function() {
        if ($('.popover').length === 0) {
          $('.estancias-infografia-completa').addClass('active');
          $('[data-infografia-image-id]').removeClass('active');
        }
      }, 200);
      

    });

    var body = $('body');
    var lastScrollTop = 0;
    var scrolled = false;
    var navbarClasses = $('#main-nav').attr('class');
    var navbarClassesBeforeOffcanvas = navbarClasses;
    var scrollTimer = 0;
    var mouseTimer = 0;

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
        clearTimeout(scrollTimer);

        if (scroll >= 25) {
            body.addClass("scrolled");
            scrolled = true;
            $('#main-nav').removeClass('navbar-dark').addClass('navbar-light bg-white');
        } else {
            body.removeClass("scrolled");
            scrolled = false;
            $('#main-nav').removeClass('navbar-light bg-white').addClass(navbarClasses);
        }

        if (scroll > lastScrollTop) {
            // Scroll hacia abajo
            body.removeClass('scrolled-up').addClass('scrolled-down');
        } else {
            // Scroll hacia arriba
            body.removeClass('scrolled-down').addClass('scrolled-up');
        }

        lastScrollTop = scroll;


        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            body.addClass("near-bottom");
        } else {
            body.removeClass("near-bottom");
        }

      // Remove .scrolled-up and .scrolled-down classes after 3 seconds without scrolling and mouse interactions
      clearTimeout(mouseTimer);
      mouseTimer = setTimeout(function() {
        body.removeClass('scrolled-up scrolled-down');
      }, 3000);

    });

    // on mouse move, clear the timer
    $(document).mousemove(function() {
      clearTimeout(mouseTimer);
      mouseTimer = setTimeout(function() {
        body.removeClass('scrolled-up scrolled-down');
      }, 3000);
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
    
    $('.slick-slider-btn-navigation a').click(function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('#' + target).slick('slickGoTo', parseInt($(this).data('slide')));
    });

    $('a[href=#video], .is-style-video-desplegable .btn-close').click(function(e) {
      e.preventDefault();
      $(this).parents('.wp-block-cover').toggleClass('playing');
    });

    // smooth scroll with 80px offset
    $('a[href^="#"]').on('click', function(event) {
      var target = $(this.getAttribute('href'));
      if (target.length) {
        event.preventDefault();
        $('html, body').stop().animate({
          scrollTop: target.offset().top - 80
        }, 1000);
      }
    });

    // smooth scroll on window load if anchor is present in URL
    if (window.location.hash) {
      var target = $(window.location.hash);
      if (target.length) {
        $('html, body').stop().animate({
          scrollTop: target.offset().top - 80
        }, 1000);
      }
    }

    // open pdfs in new tab
    $('a[href$=".pdf"]').attr('target', '_blank');

    $('.leer-mas-btn').on('click', function(e) {
      e.preventDefault();
      $(this).parent().toggleClass('active');
    });

});


jQuery(window).on('load', function() {
    jQuery('body').addClass('loaded');
    jQuery('.slick-carousel').slick('resize');
});

jQuery(window).on('resize', function() {
    jQuery('.slick-carousel').slick('resize');
});

jQuery(window).on('orientationchange', function() {
    jQuery('.slick-carousel').slick('resize');
});



/* Carruseles */
// const prevArrow = '<button class="slick-prev slick-prev-custom" arial-label="Previous" type="button"><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 40C8.9543 40 -2.7141e-06 31.0457 -1.74846e-06 20C-7.8281e-07 8.9543 8.95431 -2.7141e-06 20 -1.74846e-06C31.0457 -7.8281e-07 40 8.9543 40 20C40 31.0457 31.0457 40 20 40ZM16.1206 13.5198C15.7554 13.1055 15.1632 13.1055 14.798 13.5198L9.58704 19.4308C9.22182 19.8451 9.22182 20.5168 9.58704 20.931L14.798 26.8421C15.1632 27.2563 15.7554 27.2563 16.1206 26.8421C16.4858 26.4278 16.4858 25.7561 16.1206 25.3418L12.4912 21.2248L29.6865 21.2248C30.2388 21.2248 30.6865 20.7771 30.6865 20.2248C30.6865 19.6725 30.2388 19.2248 29.6865 19.2248L12.4138 19.2248L16.1206 15.02C16.4858 14.6057 16.4858 13.934 16.1206 13.5198Z" fill="var(--bs-dark)"/></svg></button>';
// const nextArrow = '<button class="slick-next slick-next-custom" arial-label="Next" type="button"><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.49691e-06C31.0457 5.4282e-06 40 8.95431 40 20C40 31.0457 31.0457 40 20 40C8.9543 40 1.56562e-06 31.0457 3.49691e-06 20C5.4282e-06 8.95431 8.95431 1.56562e-06 20 3.49691e-06ZM23.8794 26.4802C24.2446 26.8945 24.8368 26.8945 25.202 26.4802L30.413 20.5692C30.7782 20.1549 30.7782 19.4833 30.413 19.069L25.202 13.1579C24.8368 12.7437 24.2446 12.7437 23.8794 13.1579C23.5142 13.5722 23.5142 14.2439 23.8794 14.6582L27.5088 18.7752L10.3135 18.7752C9.7612 18.7752 9.31348 19.2229 9.31348 19.7752C9.31348 20.3275 9.76119 20.7752 10.3135 20.7752L27.5862 20.7752L23.8794 24.98C23.5142 25.3943 23.5142 26.066 23.8794 26.4802Z" fill="var(--bs-dark)"/></svg></button>';
// const prevArrow = '<button class="slick-prev slick-prev-custom" arial-label="Prev" type="button"><svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22L2 12L12 2" stroke="var(--bs-dark)" stroke-width="2" stroke-linecap="square"/></svg></button>';
// const nextArrow = '<button class="slick-next slick-next-custom" arial-label="Next" type="button"><svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 22L12 12L2 2" stroke="var(--bs-dark)" stroke-width="2" stroke-linecap="square"/></svg></button>';

jQuery('.slick-slider-default').slick({
  fade: true,
  dots: false,
  arrows: true,
  infinite: false,
  speed: 600,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: false,
  adaptiveHeight: true
});

jQuery('.slick-tabs-slider').slick({
  fade: true,
  dots: false,
  arrows: false,
  infinite: false,
  speed: 600,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: false,
  adaptiveHeight: true
});

jQuery('.slick-slider-timeline').slick({
  fade: false,
  dots: false,
  arrows: true,
  infinite: false,
  speed: 600,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: false,
  adaptiveHeight: false
});


jQuery('.slick-carousel, .wp-block-group.is-style-slick-carousel > .wp-block-group__inner-container').slick({
  dots: true,
  arrows: true,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: false,
  responsive: [
    // {
    //   breakpoint: 992,
    //   settings: {
    //     slidesToShow: 3,
    //     slidesToScroll: 1
    //   }
    // },
    {
      breakpoint: 1200,
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

jQuery('.wp-block-gallery.is-style-slick-carousel').slick({
  dots: false,
  arrows: true,
  infinite: true,
  speed: 300,
  slidesToShow: 6,
  slidesToScroll: 1,
  autoplay: true,
  lazyLoad: 'ondemand',
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
  ]
});

jQuery('.slick-carousel-testimonios').slick({
  dots: false,
  arrows: true,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: false,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 781,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

jQuery('.wp-block-group.is-layout-flex.is-style-slick-carousel-logos, .wp-block-group.is-style-slick-carousel-logos > .wp-block-group__inner-container, .wp-block-gallery.is-style-slick-carousel-logos').slick({
  dots: true,
  arrows: true,
  infinite: false,
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

jQuery('#featured-offcanvas .featured-pages-carousel').slick({
  dots: true,
  arrows: true,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: false,
  autoplaySpeed: 3000,
  responsive: [
    {
      breakpoint: 9999,
      settings: 'unslick'
    },
    {
      breakpoint: 781,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

jQuery('.content-area .featured-pages-carousel').slick({
  dots: true,
  arrows: true,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: false,
  autoplaySpeed: 3000,
  responsive: [
    {
      breakpoint: 1200,
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
  ]
});