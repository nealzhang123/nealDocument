/* SCROLL UP */
(function($){
  $(function(){
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

    var current_menu = $('.current_page_item a');

    $(".main-navigation a").on("mouseover mouseout",function(event){
      if(event.type == "mouseover"){
        current_menu.parent().removeClass('current_page_item');
      }else if(event.type == "mouseout"){
        current_menu.parent().addClass('current_page_item');
      }
    });

    window.current_preview = $('.preview-active');

    $(".preview-image").on({
      mouseover:function(){
        if( !$(this).hasClass('preview-active') ){
          $(".preview-image").removeClass('preview-active');
          $(this).addClass('preview-active');

          var index = $(this).attr('data-index');

          $('.main-banner').hide();
          var rand = Math.floor( Math.random()*10 );
          var effect_arr = new Array('fadeIn','fadeInDown','fadeInLeft','fadeInRight','fadeInUp','zoomIn','slideInDown','slideInLeft','slideInRight','slideInUp');

          $('.main-banner'+index).addClass('animated '+effect_arr[rand]).show();
          setTimeout(function(){
            $('.main-banner'+index).removeClass('animated '+effect_arr[rand]);
          },1000);
        }
      },
    });

    // $('.air-td').on('hover',function(){
    //   var obj = $(this);
    //   $('.air-td').removeClass('air-td-active');
    //   obj.addClass('air-td-active');
    // });

    $('.air-div4-title1').on('hover',function(){
      $('.air-div4-title1').removeClass('air-div4-active');
      $('.air-div4-title2').removeClass('air-div4-active');
      $('.air-div4-title1').addClass('air-div4-active');

      $('.air-div4-content2').hide();
      $('.air-div4-content1').show();
    });

    $('.air-div4-title2').on('hover',function(){
      $('.air-div4-title1').removeClass('air-div4-active');
      $('.air-div4-title2').removeClass('air-div4-active');
      $('.air-div4-title2').addClass('air-div4-active');

      $('.air-div4-content1').hide();
      $('.air-div4-content2').show();
    });
    // $(".preview-image").on("mouseover mouseout",function(event){
    //   if(event.type == "mouseover"){
        
    //   }else if(event.type == "mouseout"){
        
    //   }
    // });

    // $(".preview-image").on('click',function(){
      
    // });
    $('#checkCode').on('click',function(){
      createCode();
    });

    createCode();

    $(".contact-submit").on('click', function(e){
      e.preventDefault();

      var inputCode=document.getElementById("inputCode").value;
      if(inputCode.toUpperCase() != code.toUpperCase()){
        sweetAlert("提交失敗", "驗證碼錯誤", "error");
        createCode();

        return;
      }

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

  var code;
  function createCode() 
  {
   code = "";
   var codeLength = 4; //验证码的长度
   var checkCode = document.getElementById("checkCode");
   var codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 
        'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); //所有候选组成验证码的字符，当然也可以用中文的
   for(var i = 0; i < codeLength; i++) 
   {
    var charNum = Math.floor(Math.random() * 52);
    code += codeChars[charNum];
   }
   if(checkCode) 
   {
    checkCode.className = "code";
    checkCode.innerHTML = code;
   }
  }
  
  
})(jQuery);