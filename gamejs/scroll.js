$(document).ready(function () {
  // Scroll menu
  $('.js-scroll-nav').click(function(e) {
    e.preventDefault();

    var scrollDest = $(this).attr('href');
    $('html, body').animate({
      scrollTop: $(scrollDest).offset().top
    }, 1000);
  });
  
  // Sujuv scroll
  $(document).on("scroll", onScroll);

  function onScroll(event){
    var scrollPos = $(document).scrollTop() +50;
    $('.menu menuItem').each(function () {
      var currLink = $(this);
      var refElement = $(currLink.attr("href"));
      if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
        $('.menu menuItem').removeClass("active");
        currLink.addClass("active");
      }
      else{
        currLink.removeClass("active");
      }
    });
  }

});