(function () {
  'use strict';

  ///////////////////////////////////////////////////////////////////////

  var slickOptions = {
    dots: false,
    dotsClass: 'slider_dots',
    slidesToScroll: 1,
    autoplay: false,
    pauseOnFocus: true,
    pauseOnHover: true
  };

  ///////////////////////////////////////////////////////////////////////

  var btnHtml = [
    '<button type="button" class="arrow arrow_{0}">',
      '<span>{1}</span>',
    '</button>'
  ].join('');


  ///////////////////////////////////////////////////////////////////////

  var $pickupSlider = $('.js_pickup_slider');
  var $fishDetailSlider = $('.js_fish_detail_slider');
  var $fishDetailThumb = $('.js_fish_detail_thumb');


  var $upConfirmSlider = $('.up_form_slider');

  ///////////////////////////////////////////////////////////////////////

  var printf = function(format) {
    for(var i = 0, len = arguments.length; i < len; i++) {
      var pattern = new RegExp('\\{' + (i - 1) + '\\}', 'g');
      format = format.replace(pattern, arguments[i]);
    }
    return format;
  };

  ///////////////////////////////////////////////////////////////////////

  if ($pickupSlider.length !== 0) {
    $pickupSlider.slick($.extend({}, slickOptions, {
      rows: 2,
      slidesToShow: 4,
      centerMode: false,
      centerPadding: 0,
      slidesToScroll: 1,
      focusOnSelect: true,
      swipe: true,
      draggable: true,
      swipeToSlide: true,
      infinite: false,
      prevArrow: printf(btnHtml, 'prev', 'Previous'),
      nextArrow: printf(btnHtml, 'next', 'Next'),
      responsive: [
      {
        breakpoint: 769,
        settings: {
          dots: true,
          rows: 1,
          slidesToShow: 1,
          centerMode: true,
          centerPadding: '80px',
        }
      }
      ]
    }));
  }

  ///////////////////////////////////////////////////////////////////////

  if ($fishDetailSlider.length !== 0) {
    $fishDetailSlider.slick($.extend({}, slickOptions, {
      arrows: false,
      rows: 1,
      slidesToShow: 1,
      asNavFor: $fishDetailThumb,
      centerMode: false,
      centerPadding: 0,
      slidesToScroll: 1,
      focusOnSelect: true,
      swipe: false,
      draggable: false,
      swipeToSlide: false,
      infinite: false,
    }));
  }

  ///////////////////////////////////////////////////////////////////////

  if ($fishDetailThumb.length !== 0) {
      $fishDetailThumb.slick($.extend({}, slickOptions, {
      arrows: false,
      rows: 1,
      slidesToShow: 3,
      asNavFor: $fishDetailSlider,
      centerMode: false,
      centerPadding: 0,
      slidesToScroll: 1,
      focusOnSelect: true,
      swipe: false,
      draggable: false,
      swipeToSlide: false,
      infinite: false,
    }));
  }

  ///////////////////////////////////////////////////////////////////////

  if ($upConfirmSlider.length !== 0) {
      $upConfirmSlider.slick($.extend({}, slickOptions, {
      dots: true,
      rows: 1,
      slidesToShow: 1,
      centerPadding: 0,
      slidesToScroll: 1,
      focusOnSelect: true,
      swipe: true,
      draggable: true,
      swipeToSlide: true,
      infinite: false,
    }));
  }

  ///////////////////////////////////////////////////////////////////////

})();
