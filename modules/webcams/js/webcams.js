(function($) {
  // body code

$(document).ready(function() {
   // code here
   //alert('code here');

//lazyload();

//alert('sas');
//prikaz slika i videa full screen
$( '.swipebox' ).swipebox();

$('.rel_projects_carousel').carousel({
        interval: false
    });
// Go to the previous item
$("#rpc_btn_prev").click(function(){
  $(".rel_projects_carousel").carousel("prev");
});

// Go to the next item
$("#rpc_btn_next").click(function(){
  $(".rel_projects_carousel").carousel("next");
});
        
    /*
$('img').on('dragstart', function(event) { 
  console.log('drag');
  event.preventDefault(); });


    


// Mobile swipe if more than 5 pixels moved
$(".carousel").on("touchstart", function(event){
    var xClick = event.originalEvent.touches[0].pageX;
    $(this).one("touchmove", function (event) {
        var xMove = event.originalEvent.touches[0].pageX;
        if (Math.floor(xClick - xMove) > 5) {
            $(this).carousel('next');
        }
        else if (Math.floor(xClick - xMove) < -5) {
            $(this).carousel('prev');
        }
    });
    $(".carousel").on("touchend", function () {
        $(this).off("touchmove");
    });
});
// POMICANJE SLIDERA SA MIŠEM
var options = {};
var oldx = 0;
var direction = "";
var stop_timeout = false;
var stop_check_time = 500;
$.mousedirection = function (opts) {
  var defaults = {};
  options = $.extend(defaults, opts);
  $(document).bind("mousemove", function (e) {
    var activeElement = e.target || e.srcElement;
    if (e.pageX > oldx) {
      direction = "right";
    } else if (e.pageX < oldx) {
      direction = "left";
    }
    clearTimeout(stop_timeout);
    stop_timeout = setTimeout(function () {
      direction = "stop";
      $(activeElement).trigger(direction);
      $(activeElement).trigger({
        type: "mousedirection",
        direction: direction
      });
    }, stop_check_time);
    $(activeElement).trigger(direction);
    $(activeElement).trigger({
      type: "mousedirection",
      direction: direction
    });
    oldx = e.pageX;
  });
}
    
var $selector = $('.carousel');
$selector.on('mousedown', function (evt) { //dragable start
  $selector.on('mouseup mousemove', function handler(evt) {
    if (evt.type === 'mouseup') {
      // click
    } else {
      // drag
      //mouse move
      $.mousedirection();
      $selector.on("mousedirection", function (e) {
        var moving = e.direction;
        //console.log(moving); 
        if(moving = 'stop'){
          $selector.off('mousedirection');
        }
        if(e.direction != 'right'){
          $(this).carousel('next');
          //console.log('prev'); 
          $selector.off('mousedirection');
        }else{
          $(this).carousel('prev');
          $selector.off('mousedirection');
        }
      });// mouse move end
     }
     $selector.off('mouseup mousemove', handler); 
  });
});//dragable
// /POMICANJE SLIDERA SA MIŠEM

// Pomicanje slidera sa kotačićem miša
$(".carousel").on('wheel', function(event){

  if(event.originalEvent.deltaY < 0){
    $(this).carousel('prev');
  }
  else {
    $(this).carousel('next');
  }
});

$(document).ready(function(){
  $('.carousel').on({
    'wheel': function(e) {
    if (e.target.id == 'Carousel') return;
    e.preventDefault();
    e.stopPropagation();
    }
  }) 
});*/
// /Pomicanje slidera sa kotačićem miša

$('.evolve_carousel_related').slick({
  dots: true,
  infinite: false,
  speed: 300,
  //lazyLoad: 'ondemand',
  slidesToShow: 2,
  slidesToScroll: 2,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        dots: false
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

function slickInit() {
//GALERIJE
$('.evolve_carousel_project_gallery').slick({
  dots: true,
  infinite: false,
  speed: 300,
  //lazyLoad: 'ondemand',
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        dots: false
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
//VIDEO
$('.evolve_carousel').slick({
  dots: true,
  infinite: false,
  speed: 300,
  //lazyLoad: 'ondemand',
  slidesToShow: 3,
  slidesToScroll: 3,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: false,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        dots: false
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
}
slickInit();
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $(".evolve_carousel").slick("unslick");
    slickInit();
  });
 

}); //document ready
})(jQuery);