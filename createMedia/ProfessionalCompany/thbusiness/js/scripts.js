/* SCROLL UP */

jQuery(document).ready(function(){ 

  jQuery(window).scroll(function(){
    if (jQuery(this).scrollTop() > 350) {
      jQuery('.scrollup, .scrollup:before').fadeIn();
    } else {
      jQuery('.scrollup, .scrollup:before').fadeOut();
    }
  }); 

  jQuery('.scrollup').click(function(){
    jQuery("html, body").animate({ scrollTop: 0 }, 600);
    return false;
  });

});


/* SEARCH BOX */

jQuery(document).ready(function(){
  // jQuery(".th-search-button-icon").click(function(){
  //     jQuery(".th-search-box-container").toggle('fast');
  //   }
  // );

  // jQuery("#about-submit").on('click', function(){
  //   jQuery.post(
  //     ajaxurl,
  //     {
  //       'action': 'about-form-save-ajax',
  //       'form_data':jQuery("#about-form").serializeArray(),
  //     },
  //     function( response){
  //       sweetAlert("提醒", "感謝您對我們的支持，謝謝!", "success");
  //     }
  //   );

  // });

  var revapi = jQuery('.tp-banner').revolution(
    {
      delay:5000,
      startwidth:1170,
      startheight:500,
      hideThumbs:10

    });

  jQuery("a[rel^='prettyPhoto[pp_gal]']").prettyPhoto({
    social_tools:false,
    // overlay_gallery: true,
  });

  jQuery("a[rel^='prettyPhoto[pp_gal2]']").prettyPhoto({
    social_tools:false,
  });

  jQuery(".contact-submit").on('click', function(e){
    e.preventDefault();

    if( jQuery("input[name='name']").val().length == 0 ) {
      sweetAlert("發送失敗", "請填寫您的姓名!", "error");
      return;
    }

    if( jQuery("input[name='email']").val().length == 0 ) {
      sweetAlert("發送失敗", "請填寫您的郵箱!", "error");
      return;
    }

    sweetAlert("發送成功", "感謝您對我們的支持!", "success");
    
    jQuery.post(
      ajaxurl,
      {
        'action': 'about-form-save-ajax',
        'form_data':jQuery(".contact-form").serializeArray(),
      },
      function( response){
        jQuery('.contact-form')[0].reset();
      }
    );

  });

  // $("#revolutionSlider").each(function() {

  //   var slider = $(this);

  //   var defaults = {
  //     delay: 9000,
  //     startheight: 470,
  //     startwidth: 960,

  //     hideThumbs: 10,

  //     thumbWidth: 100,
  //     thumbHeight: 50,
  //     thumbAmount: 5,

  //     navigationType:"none",

  //     touchenabled: "on",
  //     onHoverStop: "on",

  //     navOffsetHorizontal: 0,
  //     navOffsetVertical: 20,

  //     stopAtSlide: 0,
  //     stopAfterLoops: -1,

  //     shadow: 0,
  //     fullWidth: "on",
  //   }

  //   var config = $.extend({}, defaults, options, slider.data("plugin-options"));

  //   // Initialize Slider
  //   var sliderApi = slider.revolution(config).addClass("slider-init");

  //   // Set Play Button to Visible
  //   sliderApi.bind("revolution.slide.onloaded ",function (e,data) {
  //     $(".home-player").addClass("visible");
  //   });

  // });
});
