$(function(){

  //ユーザーエージェントの切り替え
 var ua = navigator.userAgent;
  if((ua.indexOf('iPhone') > 0) || ua.indexOf('iPod') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0)){
      $('head').prepend('<meta name="viewport" content="width=device-width,initial-scale=1">');
  } else {
      $('head').prepend('<meta name="viewport" content="width=1600">');
  }

  //SPハンバーガーメニュー
  var navClose = function(){
    $(".nav").removeClass("open");
    $(".btn_pagetop_sp").fadeIn(200);
    $(".registration_btn").fadeIn(200);
    $('html').removeClass("scroll-prevent");
  }
  $(".menu_btn").click(function(){
    $(".nav").slideToggle(200);
    if ($(".nav").hasClass("open")){
      navClose();
    } else {
      $(".nav").addClass("open");
      $(".btn_pagetop_sp").fadeOut(200);
      $(".registration_btn").fadeOut(200);
      $('html').addClass("scroll-prevent");
    }
	});
  $(".close").click(function(){
    $(".nav").slideToggle(200);
    navClose();
  });
  $('.sp_menu li a').click(function(){
    $(".nav").slideToggle(200);
    navClose();
  })
  var windowHeight = $(window).height();
  var headerHeight = $('header').height();
  $('.nav').css('max-height', (windowHeight-headerHeight)+'px');
  $(window).resize(function () {
    var windowHeight = $(window).height();
    var headerHeight = $('header').height();
    $('.nav').css('max-height', (windowHeight-headerHeight)+'px');
  });

  //アクセス時にID付きできた場合、header分下へスクロールさせる
  if (location.hash !== "") {
      var scrollTo = $(location.hash).offset().top;
      console.log(scrollTo);
      $('html, body').animate({'scrollTop':(scrollTo-headerHeight )+'px'}, 500);
  }

  //メニューリンクをクリックで対象の位置までスクロール
  $('.menu_link').click(function(){
    var id = $(this).attr('href');
    var scrollPosition = $(id).offset().top;
    $('html, body').animate({'scrollTop':(scrollPosition-headerHeight)+'px'}, 500);
  });

  //HOMEリンクをタップでTOPへスクロール
  $('.home_link').click(function(){
    $('html, body').animate({'scrollTop':0}, 500);
  });

  //リンク、ボタン　→　hover
  $('.hover').hover(
    function(){
      $(this).animate({'opacity':0.7}, 500);
    }
    ,
    function(){
      $(this).animate({'opacity':1}, 500);
    }
  );
  //スクロールダウンボタンをクリックで「釣魚商店について」へ
  $('.scrollDown_btn').click(function(){
    var position = $('#about_service').offset().top;
    $('html, body').animate({'scrollTop':(position-headerHeight)+'px'}, 500);
  });

  //TOPへ戻るボタン
  $('.btn_pagetop,.btn_pagetop_sp').click(function(){
    $('html, body').animate({'scrollTop':0}, 500);
  });

  $(function() {
    var btn = $('.icons');
    btn.hide();

    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
        btn.fadeIn();
      } else {
        btn.fadeOut();
      }
    });
  });
});

