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
  jQuery(".th-search-button-icon").click(function(){
    jQuery(".th-search-box-container").toggle('fast');
  }
  );

  jQuery("#about-submit").on('click', function(){
    jQuery.post(
      ajaxurl,
      {
        'action': 'about-form-save-ajax',
        'form_data':jQuery("#about-form").serializeArray(),
      },
      function( response){
        sweetAlert("提醒", "感謝您對我們的支持，謝謝!", "success");
      }
    );

  });
});
