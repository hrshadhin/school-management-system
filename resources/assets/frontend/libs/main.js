"use strict";
var directRTL;
if (jQuery("html").attr('dir') == 'rtl') {
  directRTL = 'rtl'
} else {
  directRTL = ''
};


function is_mobile_device() {
  if (($(window).width() < 767) || (navigator.userAgent.match(/(Android|iPhone|iPod|iPad)/))) {
    return true;
  } else {
    return false;
  }
}

/**/
/* fix mobile hover */
/**/
$('*').on("hover", function () { });

/**/
/*  Tabs  */
/**/
$(".container-tabs.active").show();
$(".tabs .tabs-btn").on('click', function () {
  var idBtn = ($(this).attr("data-tabs-id"))
  var containerList = $(".tabs .container-tabs");
  var f = $(".tabs [data-tabs-id=cont-" + idBtn + "]");

  $(f).addClass("active").siblings(".container-tabs").removeClass('active');
  $(".container-tabs").fadeOut(0);
  $(".container-tabs.active").fadeIn(300);
  $(this).addClass("active").siblings(".tabs-btn").removeClass('active');
});

/**/
/*  toogles  */
/**/
$('.toggles .active').next().show();
$(".toggles .content-title").on('click', function () {
  $(this).toggleClass('active');
  $(this).next().stop().slideToggle(500);
})

/**/
/* accordions */
/**/
$('.accordions .active').next().show();
$(".accordions .content-title").on('click', function () {

  $(this).addClass('active').siblings("div").removeClass('active');
  $(this).siblings('.content').slideUp(500);
  $(this).next().stop().slideDown(500);
})

/**/
/*  Skill bar  */
/**/
$(window).scroll(progress_bar_loader);
progress_bar_loader();

function progress_bar_loader() {
  if (!is_mobile_device()) {
    $('.skill-bar-progress').each(function () {
      var el = this;
      if (is_visible(el)) {
        if ($(el).attr("processed") != "true") {
          $(el).css("width", "0%");
          $(el).attr("processed", "true");
          var val = parseInt($(el).attr("data-value"), 10);
          var fill = 0;
          var speed = val / 100;
          var timer = setInterval(function () {
            if (fill < val) {
              fill += 1;
              $(el).css("width", String(fill) + "%");
              var ind = $(el).parent().parent().find(".skill-bar-perc");
              $(ind).text(fill + "%");
            }
          }, (10 / speed));
        }
      }
    });
  } else {
    $(".skill-bar-progress").each(function () {
      var el = this;
      var fill = $(el).attr("data-value");
      var ind = $(el).parent().parent().find(".skill-bar-perc");
      $(el).css('width', fill + '%');
      $(ind).text(fill + "%");
    });
  }
}
function is_visible(el) {
  var w_h = $(window).height();
  var dif = $(el).offset().top - $(window).scrollTop();
  if ((dif > 0) && (dif < w_h)) {
    return true;
  } else {
    return false;
  }
}

/**/
/* sticky menu */
/**/
function sticky() {
  var orgElementPos = $('.sticky-wrapper').offset();
  var orgElementTop = orgElementPos.top;

  if (!($('.mobile_menu_switcher').length)) {
    add_button_menu();
  }

  if (!is_mobile_device() && (window.innerWidth > 768)) {
    if ($(".tp-banner").length || $(".row_bg").length) {
      double_menu();
    } else {
      if ($(window).scrollTop() > (orgElementTop)) {
        $('.sticky-menu').addClass('scrolling');
        //element should always have same top position and width.
      } else {
        if (!$('body.pc').length) {
          $('body').addClass('pc');
        }
        // not scrolled past the menu; only show the original position.
        $('.sticky-menu').removeClass('scrolling');
      }
    }
  }
  if (is_mobile_device() && (window.innerWidth < 768)) {
    $(".second-nav").remove();
  }
  width_sticky();
}
function width_sticky() {
  if ($("body").hasClass("boxed")) {
    var width_body = $("body").innerWidth();
    $("body.boxed .sticky-menu").css({ "width": width_body + "px" });
  } else {
    $("body .sticky-menu").css({ "width": "100%", "left": "0" });
  }
}

if ($(".main-nav").hasClass("switch-menu")) {
  menu_bar();
}
set_sticky_wrapper_height();
function set_sticky_wrapper_height() {
  if ((!$(".tp-banner").length) && (!$(".row_bg").length) && !(is_mobile_device())) {
    $('.sticky-wrapper').css({
      'height': $('.sticky-menu').innerHeight()
    })
  }
}
function add_button_menu() {
  var v = $('nav.main-nav>ul').find("li");
  for (var p = 0; p < $('nav.main-nav>ul').find("li").length; p++) {
    $(v[p]).attr('id', 'menu-item-' + p);
  }
  $('nav.main-nav').append("<i class='mobile_menu_switcher'></i>");
  $('nav.main-nav>ul ul').each(function () {
    var x = document.createElement('li');
    $(x).attr("class", "back");
    x.innerHTML = "<a href='#'>back</a>";
    this.insertBefore(x, this.firstElementChild);
  })
  $('nav.main-nav>ul').each(function () {
    var n = document.createElement("li");
    n.innerHTML = "Menu";
    $(n).attr("class", "header-menu");
    this.insertBefore(n, this.firstElementChild);
  })
  $('nav.main-nav li').each(function () {
    if ($(this).children("ul").length > 0) {
      $(this).append("<span class='button_open'></span>");
    };
  })
}
function double_menu() {
  var element = $('.tp-banner').length > 0 ? $('.tp-banner') : $('.row_bg');
  var heightElement = element.offset().top + element.innerHeight();

  if (!($('.second-nav').length)) {
    create_double_nav();
  }
  set_setting_sticky(heightElement)
}
function create_double_nav() {
  $('.sticky-menu').addClass("double-menu")
  var clone_menu = $('.sticky-menu').clone().addClass('second-nav scrolling');
  $('header').append(clone_menu);
  if ($(".second-nav .main-nav").hasClass("switch-menu")) {
    $(".second-nav .main-nav").removeClass("switch-menu");
    $(".second-nav .main-nav .menu-bar").remove();
  }
  $('.sticky-menu').css({
    "position": "absolute",
    "top": "0"
  })
  clone_menu.css({
    "transform": "translateY(-100%)",
    "position": "fixed",
    "top": "0",
    "left": "0"
  })
}
function set_setting_sticky(heightElement) {
  if ($(window).scrollTop() > heightElement) {
    $('.sticky-menu.second-nav').css({ "transform": "translateY(0)" })
  } else {
    $('.sticky-menu.second-nav').css({ "transform": "translateY(-100%)" })
  }
}
function menu_bar() {
  $(".menu-bar").on('click', function () {
    $(".main-nav.switch-menu").toggleClass("items-visible");
  })
}
/**/
/* counter */
/**/
var is_count = true
function counter() {
  if ($(".counter").length) {
    var winScr = $(window).scrollTop()
    var winHeight = $(window).height()
    var ofs = $('.counter').offset().top

    if ((winScr + winHeight) > ofs && is_count) {
      $(".counter").each(function () {
        var atr = $(this).attr('data-count');
        var item = $(this);
        var n = atr;
        var d = 0;
        var c;

        $(item).text(d);
        var interval = setInterval(function () {
          c = atr / 30;
          d += c;
          if ((atr - d) < c) {
            d = atr;
          }
          $(item).text(Math.floor(d));

          if (d == atr) {
            clearInterval(interval);
          }
        }, 30);
      });
      is_count = false;
    }
  }
}

/**/
/* scroll-top */
/**/
function scroll_top() {
  $("body").append("<div id='scroll-top'><i class='fa fa-angle-up'></i></div>")
  $('#scroll-top').on('click', function () {
    $('html, body').animate({ scrollTop: 0 });
    return false;
  });
  if ($(window).scrollTop() > 700) {
    $('#scroll-top').fadeIn();
  } else {
    $('#scroll-top').fadeOut();
  }
  $(window).scroll(function () {
    if ($(window).scrollTop() > 700) {
      $('#scroll-top').fadeIn();
    } else {
      $('#scroll-top').fadeOut();
    }
  })

}


/*  parallax  */
/**/

/**/
/*  parallax  */
/**/
jQuery.fn.parallax = function () {
  var winWidth = $(window).width();
  var winHeight = $(window).height();

  this.each(function () {
    var bgobj = $(this);
    var bgContHeight = bgobj.outerHeight();
    var bgOfsTop = bgobj.offset().top

    var parallaxContainer = bgobj.find('.parallax-image');
    var imgContWidth = parallaxContainer.outerWidth();

    var img = bgobj.find('.parallax-image img');
    var imgHeight = img.outerHeight();
    var imgWidth = img.outerWidth();

    var leftCoef = parallaxContainer.attr("data-parallax-left");
    var topCoef = parallaxContainer.attr("data-parallax-top");
    var scrollCoef = parallaxContainer.attr("data-parallax-scroll-speed");

    function formula(a, b, c) {
      return (a - b) * c
    }

    var leftOfs = -formula(imgWidth, imgContWidth, leftCoef)
    var topOfs = -formula(imgHeight, bgContHeight, topCoef)

    var corectir = (((imgHeight - bgContHeight) - (imgHeight - bgContHeight) * (scrollCoef)) * topCoef)

    var const_1 = formula(imgHeight, bgContHeight, scrollCoef)
    var const_2 = bgOfsTop - winHeight
    var const_3 = winHeight + bgContHeight
    var const_4 = const_1 / const_3;
    var const_5 = const_4 * const_2;
    var const_6 = const_5 - corectir;

    if (winWidth > 1024) {
      img.css({ 'height': 'auto', 'width': 'auto' });
      var imgWidth = img.outerWidth();
      var imgContWidth = parallaxContainer.outerWidth();

      if (imgWidth != 0) {
        var leftOfs = -formula(imgWidth, imgContWidth, leftCoef)
        var parOfs = (const_6 - const_4 * $(window).scrollTop()).toFixed(3);
        parallaxContainer.css({ '-webkit-transform': 'translateY(' + parOfs + 'px) translateZ(0)', '-moz-transform': 'translateY(' + parOfs + 'px) translateZ(0)', '-ms-transform': 'translateY(' + parOfs + 'px) translateZ(0)', 'transform': 'translateY(' + parOfs + 'px) translateZ(0)', 'left': +leftOfs + 'px' });
      };

      if (imgWidth < bgobj.outerWidth()) {
        img.css('width', "100%");
        parallaxContainer.css({ 'left': '0px' });
      };

    } else {
      img.removeAttr('width');
      img.removeAttr('height');
      parallaxContainer.removeAttr('left');

      img.css({ 'width': +imgContWidth + 'px' });
      parallaxContainer.css({ 'left': '0px', '-webkit-transform': 'translateY(' + parseInt((img.height() - bgobj.outerHeight()) / -2, 10) + 'px) translateZ(0)', '-moz-transform': 'translateY(' + parseInt((img.height() - bgobj.outerHeight()) / -2, 10) + 'px) translateZ(0)', '-ms-transform': 'translateY(' + parseInt((img.height() - bgobj.outerHeight()) / -2, 10) + 'px) translateZ(0)', 'transform': 'translateY(' + parseInt((img.height() - bgobj.outerHeight()) / -2, 10) + 'px) translateZ(0)' });

      if (img.height() < parallaxContainer.height()) {
        img.css('width', img.width() * (bgobj.outerHeight() / img.height()));
        parallaxContainer.css({ 'left': +parseInt((img.width() - parallaxContainer.width()) / -2, 10) + 'px', '-webkit-transform': 'translateY(0px)', '-moz-transform': 'translateY(0px)', '-ms-transform': 'translateY(0px)', 'transform': 'translateY(0px)' });
      }
    }

    $(window).scroll(function () {
      winWidth = $(window).width();
      if (winWidth > 1024) {
        var parOfs = (const_6 - const_4 * $(window).scrollTop()).toFixed(3);

        parallaxContainer.css({ '-webkit-transform': 'translateY(' + parOfs + 'px) translateZ(0)', '-moz-transform': 'translateY(' + parOfs + 'px) translateZ(0)', '-ms-transform': 'translateY(' + parOfs + 'px) translateZ(0)', 'transform': 'translateY(' + parOfs + 'px) translateZ(0)' });
      }
    });
  });
};

/**/
/* open search */
/**/
open_search();
function open_search() {
  $(".search-open").on('click', function (e) {
    $(".header-top-panel div.lang").toggleClass("open");
    e.stopPropagation();
  })
}

/**/
/* woocommerce_price_slider */
/**/
function woocommerce_price_slider() {
  var current_min_price
  var current_max_price
  window.woocommerce_price_slider_params = {
    'currency_pos': 'right',
    'currency_symbol': '<sup>$</sup>',
  }

  // woocommerce_price_slider_params is required to continue, ensure the object exists
  if (typeof woocommerce_price_slider_params === 'undefined') {
    return false;
  }
  // Get markup ready for slider
  $('input#min_price, input#max_price').hide();
  $('.price_slider, .price_label').show();

  // Price slider uses jquery ui
  var min_price = $('.price_slider_amount #min_price').data('min'),
    max_price = $('.price_slider_amount #max_price').data('max');

  current_min_price = parseInt(min_price, 10);
  current_max_price = parseInt(max_price, 10);


  if (woocommerce_price_slider_params.min_price) current_min_price = parseInt(woocommerce_price_slider_params.min_price, 10);
  if (woocommerce_price_slider_params.max_price) current_max_price = parseInt(woocommerce_price_slider_params.max_price, 10);
  $('body').on('price_slider_create price_slider_slide', function (event, min, max) {
    if (woocommerce_price_slider_params.currency_pos === 'left') {

      $('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + min);
      $('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + max);

    } else if (woocommerce_price_slider_params.currency_pos === 'left_space') {

      $('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + " " + min);
      $('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + " " + max);

    } else if (woocommerce_price_slider_params.currency_pos === 'right') {

      $('.price_slider_amount span.from').html(min + woocommerce_price_slider_params.currency_symbol);
      $('.price_slider_amount span.to').html(max + woocommerce_price_slider_params.currency_symbol);

    } else if (woocommerce_price_slider_params.currency_pos === 'right_space') {

      $('.price_slider_amount span.from').html(min + " " + woocommerce_price_slider_params.currency_symbol);
      $('.price_slider_amount span.to').html(max + " " + woocommerce_price_slider_params.currency_symbol);

    }

    $('body').trigger('price_slider_updated', min, max);
  });

  $('.price_slider').slider({
    range: true,
    animate: true,
    min: min_price,
    max: max_price,
    values: [current_min_price, current_max_price],
    create: function (event, ui) {

      $('.price_slider_amount #min_price').val(current_min_price);
      $('.price_slider_amount #max_price').val(current_max_price);

      $('body').trigger('price_slider_create', [current_min_price, current_max_price]);
    },
    slide: function (event, ui) {

      $('input#min_price').val(ui.values[0]);
      $('input#max_price').val(ui.values[1]);

      $('body').trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
    },
    change: function (event, ui) {

      $('body').trigger('price_slider_change', [ui.values[0], ui.values[1]]);

    },
  });
};

/**/
/* Wrap this */
/**/
$.fn.WrapThis = function (arg1, arg2) { /*=Takes 2 arguments, arg1 is how many elements to wrap together, arg2 is the element to wrap*/

  var wrapClass = "column"; //=Set class name for wrapping element

  var itemLength = $(this).find(arg2).length; //=Get the total length of elements
  var remainder = itemLength % arg1; //=Calculate the remainder for the last array
  var lastArray = itemLength - remainder; //=Calculate where the last array should begin

  var arr = [];

  if ($.isNumeric(arg1)) {
    $(this).find(arg2).each(function (idx, item) {
      var newNum = idx + 1;

      if (newNum % arg1 !== 0 && newNum <= lastArray) {
        arr.push(item);
      }
      else if (newNum % arg1 == 0 && newNum <= lastArray) {
        arr.push(item);
        var column = $(this).pushStack(arr);
        column.wrapAll('<div class="' + wrapClass + '"/>'); //=If the array reaches arg1 setting then wrap the array in a column
        arr = [];
      }
      else if (newNum > lastArray && newNum !== itemLength) { //=If newNum is greater than the lastArray setting then start new array of elements
        arr.push(item);
      }
      else { //=If newNum is greater than the length of all the elements then wrap the remainder of elements in a column
        arr.push(item);
        var column = $(this).pushStack(arr);
        column.wrapAll('<div class="' + wrapClass + '"/>');
        arr = []
      }
    });
  }
}

/**/
/* MARK */
/**/
function star_rating() {
  var stars_active = false;
  var mark
  var rating

  $(".woocommerce .stars").on("mouseover", function () {
    if (!stars_active) {
      $(this).find("span:not(.stars-active)").append("<span class='stars-active' data-set='no'>&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</span>");
      stars_active = true;
    }
  });
  $(".woocommerce .stars").on("mousemove", function (e) {
    var cursor = e.pageX;
    var ofs = $(this).offset().left;
    var fill = cursor - ofs;
    var width = $(this).width();
    var persent = Math.round(100 * fill / width);

    $(".woocommerce .stars span a").css({ "line-height": String((width + 1) / 5) + "px", "width": String(width / 5) + "px" })
    $(".woocommerce .stars span .stars-active").css("margin-top", "0px");
    $(this).find(".stars-active").css('width', String(persent) + "%");
    $(".stars-active").removeClass("fixed-mark");

  });
  $(".woocommerce .stars").on("click", function (e) {
    var cursor = e.pageX;
    var ofs = $(this).offset().left;
    var fill = cursor - ofs;
    var width = $(this).width();
    var persent = Math.round(100 * fill / width);

    mark = $(this).find(".stars-active");
    mark.css('width', String(persent) + "%").attr("data-set", String(persent));
    rating = $(this).closest('#respond').find('#rating');
    rating.val($($(this).find("span a[class*='star-']")[Math.ceil((persent).toFixed(2) / 20) - 1]).text());
  });
  $(".woocommerce .stars").on("mouseleave", function (e) {
    if ($(mark).attr("data-set") == "no") {
      mark.css("width", "0");
    }
    else {
      var persent = $(mark).attr("data-set");
      $(mark).css("width", String(persent) + "%");
      $(".stars-active").addClass("fixed-mark");
    }
  });
}

/**/
/* woocommerce button add */
/**/
function woocommerce_button_add() {

  // Orderby
  $('.woocommerce-ordering').on('change', 'select.orderby', function () {
    $(this).closest('form').submit();
  });

  // Quantity buttons
  $('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

  // Target quantity inputs on product pages
  $('input.qty:not(.product-quantity input.qty)').each(function () {
    var min = parseFloat($(this).attr('min'));

    if (min && min > 0 && parseFloat($(this).val()) < min) {
      $(this).val(min);
    }
  });

  $(document).on('click', '.plus, .minus', function () {

    // Get values
    var $qty = $(this).closest('.quantity').find('.qty'),
      currentVal = parseFloat($qty.val()),
      max = parseFloat($qty.attr('max')),
      min = parseFloat($qty.attr('min')),
      step = $qty.attr('step');

    // Format values
    if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
    if (max === '' || max === 'NaN') max = '';
    if (min === '' || min === 'NaN') min = 0;
    if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

    // Change the value
    if ($(this).is('.plus')) {

      if (max && (max == currentVal || currentVal > max)) {
        $qty.val(max);
      } else {
        $qty.val(currentVal + parseFloat(step));
      }

    } else {

      if (min && (min == currentVal || currentVal < min)) {
        $qty.val(min);
      } else if (currentVal > 0) {
        $qty.val(currentVal - parseFloat(step));
      }

    }
    // Trigger change event
    $qty.trigger('change');
  });
};


$(window).scroll(function () {
  sticky();
  counter();
})

/**/
/* on document load */
/**/
$(function () {
  star_rating()

  /**/
  /* calendar */
  /**/
  if ($("#calendar").length) {
    $('#calendar').datepicker({
      prevText: '<i class="fa fa-angle-double-left"></i>',
      nextText: '<i class="fa fa-angle-double-right"></i>',
      firstDay: 1,
      dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"]
    });
  }

  /**/
  /*woocommerce*/
  /**/
  star_rating()
  if ($(".price_slider_wrapper").length) {
    woocommerce_price_slider($)
  };
  if ($(".price_slider_wrapper").length) {
    woocommerce_button_add()
  }

  /**/
  /* woocommerce tabs */
  /**/
  if ($(".woocommerce-tabs").length) {
    $('.woocommerce-tabs .panel').hide();
    $('div' + $(".woocommerce-tabs .tabs .active a").attr('href')).show();
    $('.woocommerce-tabs ul.tabs li a').on('click', function () {
      var $tab = $(this),
        $tabs_wrapper = $tab.closest('.woocommerce-tabs');
      $('ul.tabs li', $tabs_wrapper).removeClass('active');
      $('div.panel', $tabs_wrapper).hide();
      $('div' + $tab.attr('href'), $tabs_wrapper).show();
      $tab.parent().addClass('active');
      return false;
    });
  }

  /**/
  /* list-grid switcher */
  /**/
  $(".woocommerce .products").addClass("grid-view");
  $("#list-or-grid>div").on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    if ($(this).hasClass("grid-view")) {
      if ($(".woocommerce .products").hasClass("grid-view")) {
        return false;
      } else {
        $(".woocommerce .products").fadeOut(300, function () {
          $(".woocommerce .products").addClass("grid-view").removeClass("list-view").fadeIn(300);
        });
      }
    }
    if ($(this).hasClass("list-view")) {
      if ($(".woocommerce .products").hasClass("list-view")) {
        return false;
      } else {
        $(".woocommerce .products").fadeOut(300, function () {
          $(".woocommerce .products").addClass("list-view").removeClass("grid-view").fadeIn(300);
        });
      }
    }
  });
})

/**/
/*   carousel function for event container   */
/**/
function carousel_init(url) {
  jQuery("." + url + "").each(function () {
    jQuery(this).owlCarousel({
      itemsCustom: [
        [0, 1],
        [738, 1],
        [980, 1],
        [1170, 1],
      ],
      navigation: false,
      slideSpeed: 700,
      pagination: false,
    });
    var owl = jQuery(this);
    jQuery(this).parents(".container").find(".buttons-carousel").each(function () {
      jQuery(this).children(".button-right").on('click', function () {
        owl.trigger('owl.next');
      })
      jQuery(this).children(".button-left").on('click', function () {
        owl.trigger('owl.prev');
      });
    });
  });
}
function carousel_init_list(url) {
  jQuery("." + url + "").each(function () {
    jQuery(this).owlCarousel({
      itemsCustom: [
        [0, 1],
        [738, 1],
        [980, 1],
        [1170, 1],
      ],
      navigation: false,
      slideSpeed: 700,
      pagination: false,
    });
    var owl = jQuery(this);
    jQuery(this).parents(".container").find(".buttons-carousel").each(function () {
      jQuery(this).children(".button-right").on('click', function () {
        owl.trigger('owl.next');
      })
      jQuery(this).children(".button-left").on('click', function () {
        owl.trigger('owl.prev');
      });
    });
  });
}
function cws_page_focus() {
  document.getElementsByTagName('html')[0].setAttribute('data-focus-chek', 'focused');

  window.addEventListener('focus', function () {
    document.getElementsByTagName('html')[0].setAttribute('data-focus-chek', 'focused');
  });

  window.addEventListener('blur', function () {
    document.getElementsByTagName('html')[0].removeAttribute('data-focus-chek');
  });
}

/**/
/* page ready */
/**/
$(document).ready(function () {
  cws_page_focus();
  cws_top_social_icon_animation();
  cws_top_social_init();
  cws_top_lang_init();
  /**/
  /* sticky */
  /**/
  sticky();

  /**/
  /*scroll top*/
  /**/
  scroll_top();

  /**/
  /* fancybox */
  /**/
  if ($(".fancy").length) {
    $(".fancy").fancybox();
    $('.fancybox').fancybox({
      helpers: {
        media: {}
      }
    });
  }

  /**/
  /* revolution slider */
  /**/
  $('.tp-banner').on("revolution.slide.onloaded", function (e) {
    $('.tp-banner').css("opacity", "1");
  });
  if ($('.tp-banner').length) {
    $('.tp-banner').revolution({
      dottedOverlay: "custom",
      delay: 8000,
      startwidth: 1170,
      startheight: 700,
      lazyLoad: "on",
      responsiveLevels: [4096, 1025, 778, 480],

      hideThumbs: 1000,
      thumbWidth: 100,
      thumbHeight: 50,
      thumbAmount: 5,
      navigation: {
        arrows: { enable: true }
      },
      touchenabled: "on",
      onHoverStop: "on",

      swipe_velocity: 0.7,
      swipe_min_touches: 1,
      swipe_max_touches: 1,
      drag_block_vertical: false,

      keyboardNavigation: "off",

      navigationHAlign: "center",
      navigationVAlign: "bottom",
      navigationHOffset: 0,
      navigationVOffset: 20,

      soloArrowLeftHalign: "left",
      soloArrowLeftValign: "center",
      soloArrowLeftHOffset: 20,
      soloArrowLeftVOffset: 0,

      soloArrowRightHalign: "right",
      soloArrowRightValign: "center",
      soloArrowRightHOffset: 20,
      soloArrowRightVOffset: 0,

      shadow: 0,
      fullWidth: "off",
      fullScreen: "on",

      spinner: "off",

      stopLoop: "off",
      stopAfterLoops: -1,
      stopAtSlide: -1,

      shuffle: "off",

      autoHeight: "off",
      forceFullWidth: "off",

      hideThumbsOnMobile: "off",
      hideNavDelayOnMobile: 1500,
      hideBulletsOnMobile: "off",
      hideArrowsOnMobile: "off",
      hideThumbsUnderResolution: 0,

      startWithSlide: 0,
      disableProgressBar: "on"
    })
  }
  $('.tp-banner-slider').on("revolution.slide.onloaded", function (e) {
    $('.tp-banner-slider').css("opacity", "1");
  });
  if (jQuery('.tp-banner-slider').length) {
    jQuery('.tp-banner-slider').revolution({
      responsiveLevels: [4096, 1025, 778, 480],
      dottedOverlay: "custom",
      delay: 9000,
      startwidth: 1170,
      startheight: 660,
      hideThumbs: 10,
      navigation: {
        arrows: { enable: true }
      },
      fullWidth: "on",
      forceFullWidth: "on",
      hideThumbsOnMobile: "off",
      hideNavDelayOnMobile: 1500,
      hideBulletsOnMobile: "off",
      hideArrowsOnMobile: "off",
      hideThumbsUnderResolution: 0,
      navigationType: "none"
    });
  }


  /**/
  /********   Carousel   *********/
  /**/
  var owl_three = $('.owl-three-item')
  jQuery(owl_three).each(function () {
    jQuery(this).owlCarousel({
      itemsCustom: [
        [0, 1],
        [479, 2],
        [738, 2],
        [980, 3],
        [1170, 3],
      ],
      navigation: false,
      pagination: false,
    });
    var owl = $(this)
    $(this).parent().parent().find(".carousel-button .next").on('click', function () {
      owl.trigger('owl.next');
    })
    jQuery(this).parent().parent().find(".carousel-button .prev").on('click', function () {
      owl.trigger('owl.prev');
    })
  });

  /**/
  /********   Carousel   *********/
  /**/
  var owl_three = $('.owl-two-item')
  jQuery(owl_three).each(function () {
    jQuery(this).owlCarousel({
      itemsCustom: [
        [0, 1],
        [479, 2],
        [980, 2],
        [1170, 2],
      ],
      margin: 40,
      navigation: false,
      pagination: false,
    });
    var owl = $(this)
    $(this).parent().parent().find(".carousel-button .next").on('click', function () {
      owl.trigger('owl.next');
    })
    jQuery(this).parent().parent().find(".carousel-button .prev").on('click', function () {
      owl.trigger('owl.prev');
    })
  });

  /**/
  /********   Carousel   *********/
  /**/
  var owl_widget = $('.full-width-slider')
  jQuery(owl_widget).each(function () {
    jQuery(this).owlCarousel({
      itemsCustom: [
        [0, 1],
        [738, 1],
        [980, 1],
        [1170, 1],
      ],
      singleItem: true,
      navigation: true,
      navigationText: false,
      pagination: false,
    });
  });

  /**/
  /********   Carousel   *********/
  /**/
  var owl_widget = $('.thumbnails .owl-carousel')
  jQuery(owl_widget).each(function () {
    jQuery(this).owlCarousel({
      itemsCustom: [
        [0, 3],
        [738, 3],
        [980, 3],
        [1170, 3],
      ],
      navigation: true,
      navigationText: false,
      pagination: false,
    });
  });

  /**/
  /********   Carousel   *********/
  /**/
  var owl_four = $('.owl-four-items')
  jQuery(owl_four).each(function () {
    jQuery(this).owlCarousel({
      itemsCustom: [
        [0, 1],
        [479, 2],
        [980, 3],
        [1170, 4],
      ],
      navigation: false,
      pagination: false,
    });
    var owl = $(this)
    $(this).parent().parent().find(".carousel-button .next").on('click', function () {
      owl.trigger('owl.next');
    })
    jQuery(this).parent().parent().find(".carousel-button .prev").on('click', function () {
      owl.trigger('owl.prev');
    })
  });

  /**/
  /********   Carousel   *********/
  /**/
  jQuery(".buttons-carousel .calendar-list").each(function () {
    jQuery(this).owlCarousel({
      items: 1,
      navigation: false,
      pagination: false,
    });
    var owl = $(this)
    $(this).parent().find(".button-right").on('click', function () {
      owl.trigger('owl.next');
    })
    $(this).parent().find(".button-left").on('click', function () {
      owl.trigger('owl.prev');
    })
  });



  /**/
  /********   Event content   *********/
  /**/
  if ($(".calendar-header").length) {
    $(function () {
      var event_content = {
        0: { view: "list-view-calendar", container: "day-view-wrap", carousel: "carousel-list-view.html" },
        1: { view: "week-view", container: "week-view-wrap", carousel: "carousel-week-view.html" },
        2: { view: "month", container: "event-calendar", carousel: "carousel-month-view.html" }
      };
      var i = 2;
      var window_w = $(window).outerWidth();
      var clicked_elem = $(".month-view");
      qwer();
      $('.calendar-view').on('click', function () {
        clicked_elem = $(this);
        i = clicked_elem.index();
        qwer();
      });
      function qwer() {
        $.ajax({
          type: "POST",
          url: event_content[i].view + ".html",
          cache: false,
          success: function (html) {
            $(".event-container>.previous").remove();
            $(".event-container>.current").removeClass("current").addClass("previous");
            $('.calendar-view').removeClass("active");
            clicked_elem.addClass('active');
            $(".event-container").append(html);
            carousel_init(event_content[i].container);
            $(".event-container").height($(".event-container>div:last-child").outerHeight(true));
            $(window).resize(function () {
              $(".event-container").height($(".event-container>div:last-child").outerHeight(true));
            })
            setTimeout(function () {
              $(".event-container>div:last-child").addClass("current");
            }, 400);
          },
          error: function () {
            alert("Sorry this file invalid, or your url are wrong.")
          }
        });
        $.ajax({
          type: "POST",
          url: event_content[i].carousel,
          cache: false,
          success: function (html) {
            $(".calendar-header .buttons-carousel .calendar-list").remove();
            $(".calendar-header .buttons-carousel .carousel-list").remove();
            $(".calendar-header .buttons-carousel").append(html);
            carousel_init_list("carousel-list");
          },
          error: function () {
            $(".calendar-header .buttons-carousel .carousel-list").remove();
            $(".calendar-header .buttons-carousel").append("<div class='carousel-list'><i class='fa fa-calendar'></i> July 2015</div>");
          }
        });
      };
    });
  };

  /**/
  /* popup position */
  /**/
  $(document).on("mouseenter", ".event-calendar td, .week-view-wrap td", function () {
    var popup = $(this).find(".popup");
    var HeightPopup = popup.height();

    var topChild = $(this).offset().top;
    var HeightChild = $(this).height();
    var BottomChild = topChild + HeightChild;

    var parent = $(".event-calendar");
    var topParent = parent.offset().top;
    var HeightParent = parent.height();
    var BottomParent = topParent + HeightParent;
    var bottomOfset = BottomChild - topParent;

    if (!((bottomOfset - HeightPopup) > 30)) {
      $(this).addClass("top-position");
    } else {
      $(this).removeClass("top-position");
    }
  })

  /**/
  /* info box */
  /**/
  $(".info-boxes .close-button").on('click', function () {
    $(this).parent().animate({ 'opacity': '0' }, 300).slideUp(300);
  });

  /**/
  /* widget menu */
  /**/
  $('.widget-navigation li>ul, .widget-pages li>ul').parent().addClass('has-child');
  $('.widget-navigation li>a, .widget-pages li>a').on('click', function (e) {
    e.stopPropagation();
  })
  $('.widget-navigation li, .widget-pages li').on('click', function (e) {
    e.stopPropagation();

    if ($(this).children('ul').length) {
      $(this).children('ul').slideToggle(500);
      $(this).toggleClass('active');
      $(this).children('ul').toggleClass('active')

    }
  });

  var widget_hover = $('.widget-navigation a')

  jQuery(widget_hover).each(function () {
    $(this).mouseout(function (e) {
      $(this).parent().removeClass('hover');
    });
    $(this).mousemove(function (e) {
      $(this).parent().addClass('hover');
    });
  });


  /**/
  /*flickr widget*/
  /**/
  if ($('ul#flickr-badge').length) {
    jQuery('ul#flickr-badge').jflickrfeed({
      limit: 6,
      qstrings: {
        id: '56342020@N03'
      },
      itemTemplate: '<li><div class="flickr-container"><a href="http://www.flickr.com/photos/56342020@N03"><span><img src="{{image_m}}" alt="{{title}}" /></span></a></div></li>'
    });
  };



  /**/
  /* parallax */
  /**/
  $('.parallaxed').parallax();

  /**
   * Init select2 select feilds
   */
  select2_init();

    /**
     * Subscribe email form
     */
    $('#subscribeFrom').submit(function (e) {
        e.preventDefault();
        var email = $('input[name="email"]').val();
        if(!email.length){
          alert('Enter email address!');
        }
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var that = this;
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            success: function (res) {
               if(res.success){
                 var msg = "<div class='alert alert-success emailmsg'>";
                     msg += "<strong>";
                      msg   += res.message + "</strong></div>";
                 $(that).append(msg);


               }
               else{
                   alert(res.message);
               }
            },
            error: function (error) {
                alert(error.statusText);
            }
        });

    });

});

$(window).resize(function () {

  /**/
  /* sticky */
  /**/
  sticky();

  /**/
  /* isotop */
  /**/
  if ($(".isotope").length) {
    $('.isotope').isotope({
      masonry: {}
    });
  }

  /**/
  /* height wrapper sticky menu */
  /**/
  set_sticky_wrapper_height();


  /**/
  /* parallax */
  /**/
  $('.parallaxed').parallax();
});



jQuery(window).load(function () {
  mobile_menu_controller_init();

  if ($(".isotope").length) {
    /**/
    /* ISOTOP  load */
    /**/
    var $container = $('.isotope');
    // init
    $container.isotope({
      // options
      itemSelector: '.isotope .item',
    });
    // filter isotope on initalise
    if (jQuery('.isotope-header .filter').length) {
      var selector = document.querySelector('select.filter').value;
      $container.isotope({ filter: selector });
    }

    $('.isotope-header').on('change', 'select.filter', function () {
      $('.isotope').isotope(
        {
          filter: $(this).val()
        });
      return false;
    });
  }

  /**/
  /* box tabs*/
  /**/
  if (".tabs-box") {
    box_tabs();
  }
  function box_tabs() {
    $(".tabs-box a").on('click', function () {
      if ($(this).hasClass("active")) {
      } else {
        var a = $(this).data("boxs-tab");
        var b = $(".boxs-tab [data-box='" + a + "']");
        $(".tabs-box a").removeClass("active");
        $(this).addClass("active");
        $(b).addClass("active").siblings("*").removeClass("active");
      }
    })
  }

  /**/
  /* scroll down */
  /**/
  $('.scroll-down').on('click', function () {
    $('html, body').animate({ scrollTop: $('#home').offset().top }, { duration: 1500, easing: "easeInOutExpo" });
    return false;
  });

  /**/
  /********   Carousel   *********/
  /**/
  var owl_widget = $('.widget-carousel')
  jQuery(owl_widget).each(function () {
    jQuery(this).owlCarousel({
      items: 1,
      singleItem: true,
      navigation: false,
      pagination: false,
    });
    var owl = $(this)
    if ($(this).parent().find(".carousel-button .next").length) {
      $(this).parent().find(".carousel-button .next").on('click', function () {
        owl.trigger('owl.next');
      })
      jQuery(this).parent().find(".carousel-button .prev").on('click', function () {
        owl.trigger('owl.prev');
      })
    } else {
      $(this).parent().parent().find(".carousel-button .next").on('click', function () {
        owl.trigger('owl.next');
      })
      jQuery(this).parent().parent().find(".carousel-button .prev").on('click', function () {
        owl.trigger('owl.prev');
      })
    }
  });

  /**/
  /********   Carousel   *********/
  /**/
  var owl_widget = $('.testimonials-carousel')
  jQuery(owl_widget).each(function () {
    jQuery(this).owlCarousel({
      items: 1,
      singleItem: true,
      navigation: false,
      pagination: true,
    });
  });

  /**/
  /* parallax */
  /**/
  $('.parallaxed').parallax();
});

/**/
/* mobile menu */
/**/
function mobile_menu_controller_init() {
  window.mobile_nav = {
    "is_mobile_menu": false,
    "nav_obj": jQuery(".sticky-wrapper .main-nav>ul").clone(),
    "level": 1,
    "current_id": false,
    "next_id": false,
    "prev_id": "",
    "animation_params": {
      "vertical_start": 300,
      "vertical_end": 0,
      "horizontal_start": 0,
      "horizontal_end": 270,
      "speed": 300
    }
  }
  if (false) {
    set_mobile_menu();
  }
  else {
    mobile_menu_controller();
    jQuery(window).resize(function () {
      mobile_menu_controller();
    });
  }
  mobile_nav_switcher_init();
}

function mobile_nav_switcher_init() {
  var nav_container = jQuery("nav.main-nav");
  jQuery(document).on("click", "nav.main-nav.mobile_nav .mobile_menu_switcher", function () {
    var nav = get_current_nav_level();
    var cls = "opened";
    if (nav_container.hasClass(cls)) {
      nav.stop().animate({ "margin-top": window.mobile_nav.animation_params.vertical_start + "px", "opacity": 0 }, window.mobile_nav.animation_params.speed, function () {
        nav_container.removeClass(cls);
      })
    }
    else {
      nav_container.addClass(cls);
      nav.stop().animate({ "margin-top": window.mobile_nav.animation_params.vertical_end + "px", "opacity": 1 }, window.mobile_nav.animation_params.speed);
    }
  });
}

function mobile_nav_handlers_init() {
  jQuery("nav.main-nav.mobile_nav .button_open").on("click", function (e) {
    var el = jQuery(this);
    var next_id = el.closest("li").attr("id");
    var current_nav_level = get_current_nav_level();
    var next_nav_level = get_next_nav_level(next_id);
    current_nav_level.animate({ "right": window.mobile_nav.animation_params.horizontal_end + "px", "opacity": 0 }, window.mobile_nav.animation_params.speed, function () {
      current_nav_level.remove();
      jQuery("nav.main-nav").append(next_nav_level);
      next_nav_level.css({ "margin-top": window.mobile_nav.animation_params.vertical_end + "px", "right": "-" + window.mobile_nav.animation_params.horizontal_end + "px", "opacity": 0 });
      next_nav_level.animate({ "right": window.mobile_nav.animation_params.horizontal_start + "px", "opacity": 1 }, window.mobile_nav.animation_params.speed);
      window.mobile_nav.current_id = next_id;
      window.mobile_nav.level++;
      mobile_nav_handlers_init();
    });
  });
  jQuery("nav.main-nav.mobile_nav .back>a").on("click", function () {
    var current_nav_level = get_current_nav_level();
    var next_nav_level = get_prev_nav_level();
    current_nav_level.animate({ "right": "-" + window.mobile_nav.animation_params.horizontal_end + "px", "opacity": 0 }, window.mobile_nav.animation_params.speed, function () {
      current_nav_level.remove();
      jQuery("nav.main-nav").append(next_nav_level);
      next_nav_level.css({ "margin-top": window.mobile_nav.animation_params.vertical_end + "px", "right": window.mobile_nav.animation_params.horizontal_end + "px", "opacity": 0 });
      next_nav_level.animate({ "right": window.mobile_nav.animation_params.horizontal_start + "px", "opacity": 1 }, window.mobile_nav.animation_params.speed);
      window.mobile_nav.level--;
      mobile_nav_handlers_init();
    });
  });
}

function get_current_nav_level() {
  var r = window.mobile_nav.level < 2 ? jQuery("nav.main-nav>ul") : jQuery("nav.main-nav ul");
  r.find("ul").remove();
  return r;
}

function get_next_nav_level(next_id) {
  var r = window.mobile_nav.nav_obj.find("#" + next_id).children("ul").first().clone();
  r.find("ul").remove();
  return r;
}

function get_prev_nav_level() {
  var r = {};
  if (window.mobile_nav.level > 2) {
    r = window.mobile_nav.nav_obj.find("#" + window.mobile_nav.current_id).parent("ul").parent("li");
    window.mobile_nav.current_id = r.attr("id");
    r = r.children("ul").first();
  }
  else {
    r = window.mobile_nav.nav_obj;
    window.mobile_nav.current_id = false;
  }
  r = r.clone();
  r.find("ul").remove();
  return r;
}

function mobile_menu_controller() {
  if (is_mobile() && !window.mobile_nav.is_mobile_menu) {
    set_mobile_menu();

  }
  else if (!is_mobile() && window.mobile_nav.is_mobile_menu) {
    reset_mobile_menu();
  }
}

function set_mobile_menu() {
  var nav = get_current_nav_level();
  $("nav.main-nav").addClass("mobile_nav");
  $(".sticky-menu").addClass("mobile");
  $(".sticky-menu").removeClass("scrolling");
  nav.css({ "margin-top": window.mobile_nav.animation_params.vertical_start + "px" });
  window.mobile_nav.is_mobile_menu = true;
  mobile_nav_handlers_init();
}

function reset_mobile_menu() {

  var nav = get_current_nav_level();
  $("nav.main-nav").removeClass("mobile_nav opened");
  $(".sticky-menu").removeClass("mobile");
  nav.removeAttr("style");
  window.mobile_nav.is_mobile_menu = false;
  nav.remove();
  reset_mobile_nav_params();
}

function reset_mobile_nav_params() {
  jQuery("nav.main-nav").append(window.mobile_nav.nav_obj.clone());
  window.mobile_nav.level = 1;
  window.mobile_nav.current_id = false;
  window.mobile_nav.next_id = false;
}

/* \mobile menu */

function is_mobile() {
  if (($(window).width() < 980) || (navigator.userAgent.match(/(Android|iPhone|iPod|iPad)/))) {
    return true;
  } else {
    return false;
  }
}
/* \mobile menu */
if ($(".supportForm").length) {
  /**/
  /* contact form */
  /**/

  /* validate the contact form fields */
  $(".supportForm").each(function () {
    // console.log('hi form');
    $(this).validate(  /*feedback-form*/{
      onkeyup: false,
      onfocusout: false,
      errorElement: 'p',
      errorLabelContainer: $(this).parent().children(".alert-boxes.error-alert").children(".message"),
      rules:
        {
          name:
            {
              required: true
            },
          email:
            {
              required: true,
              email: true
            },
          message:
            {
              required: true
            }
        },
      messages:
        {
          name:
            {
              required: 'Please enter your name',
            },
          email:
            {
              required: 'Please enter your email address',
              email: 'Please enter a VALID email address'
            },
          message:
            {
              required: 'Please enter your message'
            }
        },
      invalidHandler: function () {
        $(this).parent().children(".alert-boxes.error-alert").slideDown('fast');
        $("#feedback-form-success").slideUp('fast');

      },
      submitHandler: function (form) {
          $(form).children('.cws-button').hide();
        $(form).parent().children(".alert-boxes.error-alert").slideUp('fast');
        // var $form = $(form).ajaxSubmit();
        submit_handler(form, $(form).parent().children(".email_server_responce"));

      }
    });
  });

  /* Ajax, Server response */
  var submit_handler = function (form, wrapper) {

    var $wrapper = $(wrapper); //this class should be set in HTML code

    $wrapper.css("display", "block");
    var data =  $(form).serialize();
    var postUrl = $(form).attr('action');
    //send data to server
    $.post(postUrl, data, function (s_response) {
      if (s_response.info == 'success') {
        $wrapper.addClass("message message-success").append("<div class='info-boxes confirmation-message' id='feedback-form-success'><strong>Success!</strong><br><p>Your message was successfully delivered.</p></div>");
        $wrapper.delay(5000).hide(500, function () {
          $(this).removeClass("message message-success").text("").fadeIn(500);
          $wrapper.css("display", "none");
        });
        $(form)[0].reset();
          $(form).children('.cws-button').attr('pointer-events', 'all');
      } else {
        $wrapper.addClass("message message-error").append("<div class='message_box error-box'><div class='message_box_header'>Error Box</div><p>"+s_response.message+"</p></div>");
        $wrapper.delay(5000).hide(500, function () {
          $(this).removeClass("message message-success").text("").fadeIn(500);
          $wrapper.css("display", "none");
        });
      }
    });
    return false;
  }
}

function cws_top_social_icon_animation() {
  var shareButtons = jQuery(".header-top-panel  .cws_social_links>*")
    , toggleButton = jQuery(".header-top-panel  .share-toggle-button")
    , langButtons = jQuery(".header-top-panel  .cws_lang_links>*")
    , langtoggleButton = jQuery(".header-top-panel  .lang-toggle-button")

    , menuOpen = false
    , buttonsNum = shareButtons.length
    , buttonsNumLang = langButtons.length
    , buttonsMid = (buttonsNum / 2)
    , buttonsMidLang = (buttonsNumLang / 2)
    , spacing = 38
    ;

  function openShareMenu() {
    var coefDir = (directRTL == 'rtl') ? 1 : -1;
    shareButtons.each(function (i) {
      var cur = jQuery(this);
      var pos = i;
      if (pos >= 0) pos += 1;
      var dist = Math.abs(pos);
      cur.css({
        zIndex: dist
      });

      TweenMax.to(cur, 0.5 * (dist), {
        x: coefDir * pos * spacing,
        scale: 1,
        ease: Elastic.easeOut,
        easeParams: [1.01, 0.5]
      });

      TweenMax.fromTo(cur.find(".share-icon"), 0.2, {
        scale: 0
      }, {
          delay: (0.2 * dist) - 0.1,
          scale: 1.0,
          ease: Quad.easeInOut
        })
    })
  }
  function closeShareMenu() {
    shareButtons.each(function (i) {
      var cur = jQuery(this);
      var pos = i - buttonsMid;
      if (pos >= 0) pos += 1;
      var dist = Math.abs(pos);
      cur.css({
        zIndex: dist
      });

      TweenMax.to(cur, 0.4 + ((buttonsMid - dist) * 0.1), {
        x: 0,
        scale: 1,
        ease: Quad.easeInOut,
      });

      TweenMax.to(cur.find(".share-icon"), 0.2, {
        scale: 0,
        ease: Quad.easeIn
      });
    })
  }
  function openLangMenu() {
    var coefDir = (directRTL == 'rtl') ? 1 : -1;
    langButtons.each(function (i) {
      var cur = jQuery(this);
      var pos = i;
      if (pos >= 0) pos += 1;
      var dist = Math.abs(pos);
      cur.css({
        zIndex: dist
      });

      TweenMax.to(cur, 0.5 * (dist), {
        x: coefDir * pos * spacing,
        scale: 1,
        ease: Elastic.easeOut,
        easeParams: [1.01, 0.5]
      });

      TweenMax.fromTo(cur.find(".lang-icon"), 0.2, {
        scale: 0
      }, {
          delay: (0.2 * dist) - 0.1,
          scale: 1.0,
          ease: Quad.easeInOut
        })
    })
  }
  function closeLangMenu() {
    langButtons.each(function (i) {
      var cur = jQuery(this);
      var pos = i - buttonsMidLang;
      if (pos >= 0) pos += 1;
      var dist = Math.abs(pos);
      cur.css({
        zIndex: dist
      });

      TweenMax.to(cur, 0.4 + ((buttonsMidLang - dist) * 0.1), {
        x: 0,
        scale: 1,
        ease: Quad.easeInOut,
      });

      TweenMax.to(cur.find(".lang-icon"), 0.2, {
        scale: 0,
        ease: Quad.easeIn
      });
    })
  }

  function toggleShareMenu() {
    menuOpen = !menuOpen

    menuOpen ? openShareMenu() : closeShareMenu();
  }
  toggleButton.on("mousedown", function () {
    toggleShareMenu();
  })
  function toggleLangMenu() {
    menuOpen = !menuOpen

    menuOpen ? openLangMenu() : closeLangMenu();
  }

  langtoggleButton.on("mousedown", function () {
    toggleLangMenu();
  })
}
function cws_top_social_init() {
    var el = jQuery(".header-top-panel div.share-toggle-button");
    var toggle_class = "expanded";
    var parent_toggle_class = "active_social";
    if (!el.length) return;
    el.on('click', function () {
        var el = jQuery(this).parent();
        if (el.hasClass(toggle_class)) {
            el.removeClass(toggle_class);
            setTimeout(function () {
                el.closest(".header-top-panel").removeClass(parent_toggle_class);
            }, 300);
        }
        else {
            el.addClass(toggle_class);
            el.closest(".header-top-panel").addClass(parent_toggle_class);
        }
    });
}

function cws_top_lang_init() {
    var el = jQuery(".header-top-panel div.lang-toggle-button");
    var toggle_class = "expanded";
    var parent_toggle_class = "active_lang";
    if (!el.length) return;
    el.on('click', function () {
        var el = jQuery(this).parent();
        if (el.hasClass(toggle_class)) {
            el.removeClass(toggle_class);
            setTimeout(function () {
                el.closest(".header-top-panel").removeClass(parent_toggle_class);
            }, 300);
        }
        else {
            el.addClass(toggle_class);
            el.closest(".header-top-panel").addClass(parent_toggle_class);
        }
    });
}

function select2_init() {
  // console.log('called me');
  var selects = $('.select2');

  if (selects.length) {
    // console.log('fond item' + selects.length);
    selects.each(function () {
      $(this).select2();
    });
  }

}

$(function () {
    'use strict'
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    var fullUrl = getUrl.href;
    $(".main-nav ul li a").each(function () {
        if ($(this).attr("href") == fullUrl || $(this).attr("href") == baseUrl || baseUrl.slice(0, -1) == $(this).attr("href") || $(this).attr("href") == '') {
            $(".main-nav ul li a").removeClass('active');
            $(this).addClass("active");
        }

    });
});

