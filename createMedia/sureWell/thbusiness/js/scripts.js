(function($){
  $(function(){
    // $('.main-slider').unslider({
    //   autoplay: true,
    //   delay: 3000,
    //   arrows: false,
    //   nav:false
    // });

    jQuery('#site-navigation ul:first-child').clone().appendTo('.responsive-mainnav');

    jQuery('#main-nav-button').click(function(event){
      event.preventDefault();
      jQuery('.responsive-mainnav').slideToggle();
    });

    if (document.documentElement.clientWidth < 600) {
      var swiper = new Swiper('.swiper-container', {
          pagination: '.swiper-pagination',
          slidesPerView: 2,
          spaceBetween: 30,
          nextButton: '.swiper-button-next',
          prevButton: '.swiper-button-prev',
          // runCallbacksOnInit : true,
          // onClick: function(swiper){
          //   console.log(swiper);
          //   // swiper.slideTo(swiper.clickedIndex, 1000);
          // },
          // onSlideChangeStart: function(swiper){
          //   console.log(swiper);
          // }
      });
    }else{
      var swiper = new Swiper('.swiper-container', {
          pagination: '.swiper-pagination',
          slidesPerView: 6,
          spaceBetween: 30,
          nextButton: '.swiper-button-next',
          prevButton: '.swiper-button-prev',
          // runCallbacksOnInit : true,
          // onClick: function(swiper){
          //   console.log(swiper);
          //   // swiper.slideTo(swiper.clickedIndex, 1000);
          // },
          // onSlideChangeStart: function(swiper){
          //   console.log(swiper);
          // }
      });
    }
    $('.product-menu-mobile').on('change',function(){
      var url = $('.product-menu-mobile :selected').attr('data-href');
      document.location.href = url;
    });

    // swiper.slideTo(swiper.activeIndex, 1000);
    // console.log(swiper.activeIndex);
    // console.log(swiper.translate);

    // $('.swiper-button-next').on('click', function(e) {
    //   e.preventDefault();

    //   swiper.slideNext();
    // })

    $(".product-list-item").on('click', function(e){
      e.preventDefault();
      var obj = $(this);
      var pid = obj.attr('data-id');
      var cat_id = obj.attr('data-cate');
      
      current_url_en = product_url_en+'?cat_id='+cat_id+'&pid='+pid;
      current_url_hk = product_url_hk+'?cat_id='+cat_id+'&pid='+pid;

      $('.header_trans_en').attr('href',current_url_en);
      $('.header_trans_hk').attr('href',current_url_hk);

      $.post(
        ajaxurl,
        {
          'action': 'get-product-infor-ajax',
          'pid':pid,
        },
        function( response){
          response = $.parseJSON(response);
          // swiper.slideTo(swiper.clickedIndex, 1000);
          $(".product-list-item").parent().removeClass('swiper-slide-active');
          obj.parent().addClass('swiper-slide-active');

          $('.product_inside_image').attr('src',response.image_url);
          $('.product_content').html(response.content);

          $("html,body").animate({scrollTop: $(".product_inside").offset().top-45}, 1000);
        }
      );
    });

    // var viewSwiper = new Swiper('.view .swiper-container', {
    //   // autoplay: 2000,
    //   autoplayDisableOnInteraction:false,
    //   grabCursor: true,
    //   onSlideChangeStart: function() {
    //     updateNavPosition()
    //   }
    // })
    
    // var mySwiper = new Swiper('.view .swiper-container',{
    //     // pagination: '.pagination',
    //     loop:false,
    //     // grabCursor: true,
    //     // paginationClickable: true,
    //     autoplay: 2000,
    // });

    // $('.view .arrow-left,.preview .arrow-left').on('click', function(e) {
    //   e.preventDefault()
    //   if (viewSwiper.activeIndex == 0) {
    //     viewSwiper.slideTo(viewSwiper.slides.length - 1, 1000);
    //     return
    //   }
    //   viewSwiper.slidePrev()
    // })

    // $('.view .arrow-right,.preview .arrow-right').on('click', function(e) {
    //   e.preventDefault()
    //   if (viewSwiper.activeIndex == viewSwiper.slides.length - 1) {
    //     viewSwiper.slideTo(0, 1000);
    //     return
    //   }
    //   viewSwiper.slideNext()
    // })

    // var previewSwiper = new Swiper('.preview .swiper-container', {
    //   visibilityFullFit: true,
    //   slidesPerView: 'auto',
    //   onlyExternal: true,
    //   allowSwipeToPrev: true,
    //   allowSwipeToNext: true,
    //   onClick: function(swiper, e) {
    //     var position = swiper.clickedIndex;
    //     viewSwiper.slideTo(position);
    //   }
    // })

    // function updateNavPosition() {
    //   $('.preview .active-nav').removeClass('active-nav')
    //   var activeNav = $('.preview .swiper-slide').eq(viewSwiper.activeIndex).addClass('active-nav')
    //   if (!activeNav.hasClass('swiper-slide-visible')) {
    //     if (activeNav.index() > previewSwiper.activeIndex) {
    //       var thumbsPerNav = Math.floor(previewSwiper.width / activeNav.width()) - 1
    //       previewSwiper.slideTo(activeNav.index() - thumbsPerNav)
    //     } else {
    //       previewSwiper.slideTo(activeNav.index())
    //     }
    //   }
    // }


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

    $(".contact-reset").on('click', function(e){
      e.preventDefault();

      $('.contact-form')[0].reset();
    });

    $(".contact-submit").on('click', function(e){
      e.preventDefault();

      if( $("input[name='company']").val().length == 0 ) {
        if( map_lang == 'zh-hk' ){
          sweetAlert("提交失敗", "請填寫公司名稱!", "error");
        }
        if( map_lang == 'en' ){
          sweetAlert("Submit Failed", "Please Input Company!", "error");
        }
        return;
      }

      if( $("input[name='name']").val().length == 0 ) {
        if( map_lang == 'zh-hk' ){
          sweetAlert("提交失敗", "請填寫聯繫人!", "error");
        }
        if( map_lang == 'en' ){
          sweetAlert("Submit Failed", "Please Input Name!", "error");
        }
        return;
      }

      if( $("input[name='tel']").val().length == 0 ) {
        if( map_lang == 'zh-hk' ){
          sweetAlert("提交失敗", "請填寫電話!", "error");
        }
        if( map_lang == 'en' ){
          sweetAlert("Submit Failed", "Please Input Telphone!", "error");
        }
        return;
      }

      if( $("input[name='tax']").val().length == 0 ) {
        if( map_lang == 'zh-hk' ){
          sweetAlert("提交失敗", "請填寫傳真!", "error");
        }
        if( map_lang == 'en' ){
          sweetAlert("Submit Failed", "Please Input Tax!", "error");
        }
        return;
      }

      if( $("input[name='email']").val().length == 0 ) {
        if( map_lang == 'zh-hk' ){
          sweetAlert("提交失敗", "請填寫電郵!", "error");
        }
        if( map_lang == 'en' ){
          sweetAlert("Submit Failed", "Please Input Email!", "error");
        }
        return;
      }

      if( $("input[name='address']").val().length == 0 ) {
        if( map_lang == 'zh-hk' ){
          sweetAlert("提交失敗", "請填寫地址!", "error");
        }
        if( map_lang == 'en' ){
          sweetAlert("Submit Failed", "Please Input Address!", "error");
        }
        return;
      }

      if( $("textarea[name='message']").val().length == 0 ) {
        if( map_lang == 'zh-hk' ){
          sweetAlert("提交失敗", "請填寫查詢內容!", "error");
        }
        if( map_lang == 'en' ){
          sweetAlert("Submit Failed", "Please Input Question!", "error");
        }
        return;
      }

      if( map_lang == 'zh-hk' ){
        sweetAlert("發送成功", "感謝您對我們的支持!", "success");
      }
      if( map_lang == 'en' ){
        sweetAlert("Submit Success", "Thanks For Your Support!", "success");
      }

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