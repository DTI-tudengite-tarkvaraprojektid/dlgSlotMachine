$(document).ready(function () {

  function zoe(strength, negative, context, item) {
    var movementStrength = strength;
    var height = movementStrength / $(window).height();
    var width = movementStrength / $(window).width();

    $(context).mousemove(function(e){
      var pageX = e.pageX - ($(window).width() / 2);
      var pageY = e.pageY - ($(window).height() / 2);
      var newvalueX = width * pageX * -1 - 25;
      var newvalueY = height * pageY * -1 - 50;
      if (negative === true){
        $(item).css({
          transform: 'translateY('+(newvalueX * -1)+'px) translateX('+(newvalueY * -1)+'px)'
        });
      } else{
        $(item).css({
          transform: 'translateY('+newvalueX+'px) translateX('+newvalueY+'px)'
        });
      }

    });
  }

  zoe(20, true, 'body', '.section-bg--about-01');
  zoe(45, false, 'body', '.section-bg--about-02');

  zoe(20, true, 'body', '.section-bg--contact-01');
  zoe(45, false, 'body', '.section-bg--contact-02');

  // Scroll menu

  $('.js-scroll-nav').click(function(e) {
    e.preventDefault();

    var scrollDest = $(this).attr('href');
    $('html, body').animate({
      scrollTop: $(scrollDest).offset().top
    }, 1000);
  });


  // Ticker

  var timer = setInterval( newsTicker, 3000 );

  function newsTicker() {

    $('.ticker').each(function() {

      var $cur = $(this)
        .find('.current')
        .fadeOut()
        .removeClass('current');

      var $next = $cur.next().length?$cur.next():$(this).children().eq(0);

      $next
        .fadeIn()
        .addClass('current');
    });

  }

  // Grid

  var $grid = $('.grid').masonry({
    itemSelector: '.grid-item'
  });

  // layout Masonry after each image loads
  $grid.imagesLoaded().progress( function() {
    $grid.masonry('layout');
  });

  // Popup

  $('.js-portfolio a').magnificPopup({
    type: 'image',
    fixedContentPos: true,
    gallery:{
      enabled:true
    }
  });

  // Sujuv scroll

  $(document).on("scroll", onScroll);

  function onScroll(event){
    var scrollPos = $(document).scrollTop() +50;
    $('.menu a').each(function () {
      var currLink = $(this);
      var refElement = $(currLink.attr("href"));
      if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
        $('.menu a').removeClass("active");
        currLink.addClass("active");
      }
      else{
        currLink.removeClass("active");
      }
    });
  }

});