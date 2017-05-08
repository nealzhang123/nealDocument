(function($){
  $(function(){
    $('.main-slider').unslider({
      autoplay: true,
      delay: 3000,
      arrows: false,
      nav:false
    });

    var viewSwiper = new Swiper('.view .swiper-container', {
      // autoplay: 2000,
      autoplayDisableOnInteraction:false,
      grabCursor: true,
      onSlideChangeStart: function() {
        updateNavPosition()
      }
    })
    
    // var mySwiper = new Swiper('.view .swiper-container',{
    //     // pagination: '.pagination',
    //     loop:false,
    //     // grabCursor: true,
    //     // paginationClickable: true,
    //     autoplay: 2000,
    // });

    $('.view .arrow-left,.preview .arrow-left').on('click', function(e) {
      e.preventDefault()
      if (viewSwiper.activeIndex == 0) {
        viewSwiper.slideTo(viewSwiper.slides.length - 1, 1000);
        return
      }
      viewSwiper.slidePrev()
    })

    $('.view .arrow-right,.preview .arrow-right').on('click', function(e) {
      e.preventDefault()
      if (viewSwiper.activeIndex == viewSwiper.slides.length - 1) {
        viewSwiper.slideTo(0, 1000);
        return
      }
      viewSwiper.slideNext()
    })

    var previewSwiper = new Swiper('.preview .swiper-container', {
      visibilityFullFit: true,
      slidesPerView: 'auto',
      onlyExternal: true,
      allowSwipeToPrev: true,
      allowSwipeToNext: true,
      onClick: function(swiper, e) {
        var position = swiper.clickedIndex;
        viewSwiper.slideTo(position);
      }
    })

    function updateNavPosition() {
      $('.preview .active-nav').removeClass('active-nav')
      var activeNav = $('.preview .swiper-slide').eq(viewSwiper.activeIndex).addClass('active-nav')
      if (!activeNav.hasClass('swiper-slide-visible')) {
        if (activeNav.index() > previewSwiper.activeIndex) {
          var thumbsPerNav = Math.floor(previewSwiper.width / activeNav.width()) - 1
          previewSwiper.slideTo(activeNav.index() - thumbsPerNav)
        } else {
          previewSwiper.slideTo(activeNav.index())
        }
      }
    }


    // $(".main-navigation a").hover(function(){
    //     var current = $(this);
    //     var current_menu = $('.current-menu-item');
    //     var current_parent = $('.current-menu-parent');

    //     current_menu.removeClass('current-menu-item');
    //     current_parent.removeClass('current-menu-parent');
    // },function(){
    //     current_menu.addClass('current-menu-item');
    //     current_parent.addClass('current-menu-parent');
    // });

    var current_menu = $('.current-menu-item');
    var current_parent = $('.current-menu-parent');

    $(".main-navigation a").on("mouseover mouseout",function(event){

      if(event.type == "mouseover"){
        var current = $(this);
        
        if( current_parent.length == 0 || $(this).parent().parent().hasClass('sub-menu') ){
          current_menu.removeClass('current-menu-item');
          
        }
        current_parent.removeClass('current-menu-parent');
         
      }else if(event.type == "mouseout"){
        current_menu.addClass('current-menu-item');
        current_parent.addClass('current-menu-parent');
      }
    })

    /* SCROLL UP */
    $(window).scroll(function(){
      if ($(this).scrollTop() > 350) {
        $('.scrollup, .scrollup:before').fadeIn();
      } else {
        $('.scrollup, .scrollup:before').fadeOut();
      }
    }); 

    $('.scrollup').click(function(){
      $("html, body").animate({ scrollTop: 0 }, 600);
      return false;
    });



    $('.project_select').on('change',function(){
      $('.project-list').html(load_image);

      $.post(
        ajaxurl,
        {
          'action':         'search-select-project-ajax',
          'project_area':   $('select[name="project_area"]').val(),
          'project_design': $('select[name="project_design"]').val(),
          'project_size':   $('select[name="project_size"]').val(),
          'project_price':  $('select[name="project_price"]').val(),
          'current_cate_id':$('#current_cate_id').attr('value')
        },
        function(response){
          $('.project-list').html(response);
        }
      );
    });

    $(".extra_button").click(function() {

        $('.short_content').toggle();
        $('.full_content').slideToggle('fast');

        $(this).html($(this).html()=="展開"?"收起":"展開"); // 改变按钮的文字说明
    });


    $(".contact-submit").on('click', function(e){
      e.preventDefault();

      sweetAlert("發送成功", "感謝您對我們的支持!", "success");
      
      $.post(
        ajaxurl,
        {
          'action': 'about-form-save-ajax',
          'form_data':$(".contact-form").serializeArray(),
        },
        function( response){
          $('.contact-form')[0].reset();
        }
      );

    });
  }); 
})(jQuery);