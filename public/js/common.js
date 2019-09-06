(function () {
  'use strict';

  ///////////////////////////////////////////////////////////////////////

  const toggleMenu = function (evt) {
    evt.preventDefault();
    evt.stopPropagation();

    $(".js_header_band").toggleClass('open');
    $(".js_header_navi").toggleClass('open');
  };

  ///////////////////////////////////////////////////////////////////////

  const toggleArea = function (evt) {
    evt.preventDefault();
    evt.stopPropagation();

    $(evt.currentTarget).toggleClass('open');
  };

  ///////////////////////////////////////////////////////////////////////

  const howtoTabArea = function (evt) {
    evt.preventDefault();
    evt.stopPropagation();

    var indexNum = $(".howto_panel").index(evt.currentTarget);

    $(".howto_panel").removeClass('current');
    $(".howto_inner").removeClass('current');
    $(".howto_panel").eq(indexNum).addClass('current');
    $(".howto_inner").eq(indexNum).addClass('current');
  };

  ///////////////////////////////////////////////////////////////////////

  const tabBaloonArea = function (evt) {
    evt.preventDefault();
    evt.stopPropagation();

    var indexNum = 0;
    var selectText = "";
    if($(this).hasClass('js_tab_baloon')){
      indexNum = $(".js_tab_baloon").index(evt.currentTarget);
    }
    else {
      indexNum = $(".js_tab_select").prop("selectedIndex");
    }

    $(".js_tab_select").prop('selectedIndex', indexNum);
    selectText = $(".js_tab_select").find('option:selected');
    $('.tab_select_label').text(selectText.text());

    $(".js_tab_baloon").removeClass('current');
    $(".js_tab_baloon_inner").removeClass('current');
    $(".js_tab_baloon").eq(indexNum).addClass('current');
    $(".js_tab_baloon_inner").eq(indexNum).addClass('current');
  };

  ///////////////////////////////////////////////////////////////////////

  const changeCheckArea = function (evt) {
    evt.stopPropagation();

    var check = $('.js_checkbox input:checkbox').prop('checked');

    if(check){
      $(".js_checkbox_area").prop('disabled', false);
    }
    else{
      $(".js_checkbox_area").prop('disabled', true);
    }
  }

  ///////////////////////////////////////////////////////////////////////

  const openDropDown = function (evt) {
    evt.preventDefault();
    evt.stopPropagation();

    $(".header_account").addClass('open');
  }

  ///////////////////////////////////////////////////////////////////////

  const openDropNotif = function (evt) {
    evt.preventDefault();
    evt.stopPropagation();

    $(".header_notif").addClass('open');
  }

  //////////////////////////////////////////////////////////////////////

  const openModal = function (evt) {
    evt.preventDefault();
    evt.stopPropagation();

    const imgSrc = evt.target.src;
    $(".modal_image").attr("src",imgSrc);
    $(".modal").addClass('open');
  }

  ///////////////////////////////////////////////////////////////////////

  const closeModal = function (evt) {
    evt.stopPropagation();

    if(!$(evt.target).closest(".modal_image").length){
      $(".modal").removeClass('open');
    }
  }

  ///////////////////////////////////////////////////////////////////////

  const closeDropDown = function (evt) {
    evt.stopPropagation();

    if (!$(evt.target).hasClass('.header_account').length) {
      $(".header_account").removeClass('open');
    }
  }

  ///////////////////////////////////////////////////////////////////////

  const closeDropNotif = function (evt) {
    evt.stopPropagation();

    if (!$(evt.target).hasClass('.header_notif').length) {
      $(".header_notif").removeClass('open');
    }
  }

  ///////////////////////////////////////////////////////////////////////

  const bindEvents = function () {
    $(".js_header_open").on('click', toggleMenu);
    $(".js_header_band").on('click', toggleMenu);
    $(".js_header_close").on('click', toggleMenu);
    $(".js_faq_line").on('click', toggleArea);
    $(".js_howto_panel").on('click', howtoTabArea);
    $(".js_tab_baloon").on('click', tabBaloonArea);
    $(".js_tab_select").on('change', tabBaloonArea);
    $(".js_checkbox").on('click', changeCheckArea);

    $(".js_header_dropdown").on('click', openDropDown);
    $(".js_modal_open").on('click', openModal);
    $(".js_modal_close").on('click', closeModal);
    $(".js_notif_open").on('click', openDropNotif);
    $(".modal").on('click', closeModal);
    $(document).on('click', closeDropDown);
    $(document).on('click', closeDropNotif);
  };

  ///////////////////////////////////////////////////////////////////////

  $(window).on('load resize scroll', function() {
    var scrollHeight = $(document).height();
    var scrollPosition = $(window).height() + $(window).scrollTop();
    var footHeight = $("footer").innerHeight();
    var spappHeight = $(".sp_app").innerHeight();
    if (window.matchMedia('(max-width:768px)').matches) {
      if ( scrollHeight - scrollPosition  <= footHeight + spappHeight ) {
        $(".sell_btn").css({
          "position":"absolute",
          "bottom": spappHeight + 20,
          "right": "20px"
        });
      } else {
        $(".sell_btn").css({
          "position":"fixed",
          "bottom": "20px",
          "right": "20px",
          "z-index": 10
        });
      }
    } else {
      if ( scrollHeight - scrollPosition  <= footHeight ) {
        $(".sell_btn").css({
          "position":"absolute",
          "bottom": "50px",
          "right": "50px"
        });
      } else {
        $(".sell_btn").css({
          "position":"fixed",
          "bottom": "50px",
          "right": "50px",
          "z-index": 10
        });
      }
    }
  });

  ///////////////////////////////////////////////////////////////////////

  $("#stop_dealing").click(function(){
    if ($("#stop_dealing_box").hasClass("stop_dealing_open")) {
      $("#stop_dealing_box").removeClass("stop_dealing_open");
    } else {
      $("#stop_dealing_box").addClass("stop_dealing_open");
    }
  });

  ///////////////////////////////////////////////////////////////////////

  const initialize = function () {
    bindEvents();
  };

  ///////////////////////////////////////////////////////////////////////


  if (location.hash !== "") {
    var hash = location.hash.split('?', 1);
    hash = hash[0];
    if ($(hash).length > 0) {
      var headerHeight = $('.header').height() + 10;
      var scrollTo = $(hash).offset().top;
      //FIXME: ちらつくので　コメントアウトの方で実装したい
      // $(window).scrollTop((scrollTo-headerHeight));
      $('html, body').animate({'scrollTop':(scrollTo-headerHeight )+'px'}, 5);
    }
  }

  $('a[href^="#"]').click(function(){
    var speed = 600;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    $("html, body").animate({scrollTop:position}, speed, "swing");
    return false;
  });

  ///////////////////////////////////////////////////////////////////////

    $('.rdc_label').click(function(){
      if($(this).find('input').prop('checked')) {
        $(this).find('.rd_checked').removeClass('hide');
      } else {
        $(this).find('.rd_checked').addClass('hide');
      }
    });

    ///////////////////////////////////////////////////////////////////////

  initialize();
})();
