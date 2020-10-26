
// var mySwiper = new Swiper ('.swiper-container', {
//  })

// ブラウザチェック
// jQuery(function($){
//
//   console.log(platform.name);
//
//   if(platform.name == 'Chrome' || platform.name == 'Microsoft Edge' || platform.name == 'Chrome Mobile'){
//     $('.stop-logo').addClass('hide');
//   }else{
//     $('.svgall').addClass('hide');
//   }
//
//     });

// SVG　手書き風アニメーション
// jQuery(function($){
//   new Vivus('move', {
//     // type: 'scenario-sync',
//     type: 'oneByOne',
//     duration: 100,
//     forceRender: false,
//     animTimingFunction: Vivus.EASE,
//     start: 'autostart',
//     selfDestroy: true
//   })
// });

/*パッシング*/
 let windowHeight = jQuery(window).height(); //<- 画面の縦幅

jQuery(function($){

  $('.service-flow-phase-wrapper').each(function(){
    $(this).click(function(){
      $(this).find('.service-flow-phase-toggle-image').toggleClass('minus');
      $(this).find('.service-flow-phase-detail').toggleClass('show');
    });
  });

  $(window).scroll(function(){
    setTimeout(function(){
      $("#section-works-wrapper").each(function(){
        var sww_div_pos = $(this).offset();
        var scrollPosition = $(window).scrollTop();

        if (scrollPosition > sww_div_pos.top - windowHeight) {

          $(this).attr('id','section-works-wrapper-animation');

          }

        });

        $(".section-title-wrapper").each(function(){
          var sectw_div_pos = $(this).offset();
          var scrollPosition = $(window).scrollTop();

          if (scrollPosition > sectw_div_pos.top - windowHeight) {

            $(this).addClass('animation');

            }

          });

          // $(".first-plan-title-wrapper").each(function(){
          //   var fptw_div_pos = $(this).offset();
          //   var scrollPosition = $(window).scrollTop();
          //
          //   if (scrollPosition > fptw_div_pos.top - (windowHeight / 2)) {
          //
          //     console.log("OK");
          //
          //     }
          //
          //   });

        $(".service-title-wrapper").each(function(){
          var stw_div_pos = $(this).offset();
          var scrollPosition = $(window).scrollTop();

          if (scrollPosition > stw_div_pos.top - windowHeight) {

            $(this).addClass('animation');

            }

          });
    } , 1000);

   });
});

/*スクロールトップ*/

jQuery(function($){
  $(document).on('click', '.gotoTOP-wrapper', function () {
    $('html, body').animate({scrollTop: 0}, 750);
  });
});

/*ハンバーガーメニュー*/
jQuery(function($){
  $(document).on('click', '.hamburger-menu', function () {
    $('.header-menu-list-wrapper').toggleClass('active');
    $('.hamburger-menu').toggleClass('active');
    $('.sidebar').toggleClass('active');
  });
});

// テキストエリア自動リサイズ
  // jQuery(function($){
  //   autosize(document.querySelector('textarea'));
  // });

// 入力チェック

// メールアドレスチェック
jQuery(function($){

  $('.mail-address-first').change(function(){

    EmailPatternCheck('.mail-address-first');

  });

  $('.mail-address-second').change(function(){

    EmailPatternCheck('.mail-address-second');

  });

});

// 電話番号チェック
jQuery(function($){

  $('.TEL').change(function(){

    TELPatternCheck('.TEL');

  });

});

// 送信時チェック
jQuery(function($){

  $('form').submit(function(){

    // 送信内容確認処理
    if(!InputCheck()){

      return false;

    }
    // 送信確認処理
    if(!confirm('この内容で送信してもよろしいですか？')){

      return false;

    }else{

      alert('送信に成功しました。');

    }

  });

});

// チェック用関数定義

// メールアドレスチェック用関数
function EmailPatternCheck(className){

 const element_mail = document.querySelector(className);
 const value_mail = element_mail.value;

 if(!value_mail.match(/^([a-z0-9_\.\-])+@([a-z0-9_\.\-])+[^.]$/i)){

  alert("メールアドレスを再入力してください");

  setTimeout(function(){

   element_mail.focus();

  }, 1);
  return false;

 }

 return true;

}

// メールアドレス一致確認用チェック関数
function EmailEqualCheck(){

  var element_mail_first = document.querySelector('.mail-address-first');
  var value_mail_first = element_mail_first.value;
  var element_mail_second = document.querySelector('.mail-address-second');
  var value_mail_second = element_mail_second.value;

  if(value_mail_first != value_mail_second){

    alert("同じメールアドレスを入力してください");

    setTimeout(function(){

     element_mail_second.focus();

    }, 1);

    return false;

  }

  return true;

}

// メールアドレスチェック用関数

function EmailCheck(className){

  if(EmailPatternCheck(className)){
    if(EmailEqualCheck()){
      return true;
    }
  }

  return false;

}

// 電話番号チェック用関数

function TELPatternCheck(className){

 const element_TEL = document.querySelector(className);
 var value_TEL =  element_TEL.value;

 // バリデーション関数
 var validateTelNeo = function (value) {
  return /^[0０]/.test(value) && libphonenumber.isValidNumber(value, 'JP');
 }

 // 整形関数
 var formatTel = function (value) {
  return new libphonenumber.AsYouType('JP').input(value);
 }

 var main = function (tel) {
  if (!validateTelNeo(tel)) {
    alert("電話番号を再入力してください");

    setTimeout(function(){

	element_TEL.focus();

   }, 1);

    return false;
  }

  var formattedTel = formatTel(tel);
  document.querySelector(className).value = formattedTel;
  return true;

 }

 if(!main(value_TEL)){

  return false;

 }else{

  return true;

 }

}

// チェックボックスチェック用関数

function PPCheck(Id){

  console.log(document.getElementById(Id).checked);

  if(!document.getElementById(Id).checked || document.getElementById(Id).checked == null){

    alert("個人情報保護方針に同意された方のみ、送信できます。");

    setTimeout(function(){

      document.getElementById(Id).focus();

    }, 1);

    return false;

  }

  return true;

}

// 未入力チェック用関数

function NullCheck(){

  const msg_array = ["会社名が未入力です",
  "ご担当者名が未入力です",
  "メールアドレスが未入力です",
  "電話番号が未入力です",
  "お問い合わせ内容が未入力です"];

  var element_company_name = "";
  element_company_name = document.querySelector('.company-name');
  const value_company_name = element_company_name.value;

  var element_staff_name = "";
  element_staff_name = document.querySelector('.staff-name');
  const value_staff_name = element_staff_name.value;

  var element_mail_first = "";
  var element_mail_second = "";
  element_mail_first = document.querySelector('.mail-address-first');
  element_mail_second = document.querySelector('.mail-address-second');
  value_mail_first = element_mail_first.value;
  value_mail_second = element_mail_second.value;

  var element_TEL = "";
  element_TEL = document.querySelector('.TEL');
  const value_TEL = element_TEL.value;

  var element_content_main = "";
  element_content_main = document.getElementById("contact-main");
  const value_content_main = element_content_main.value;

  if(value_company_name == ""){

    alert(msg_array[0]);

    setTimeout(function(){

      element_company_name.focus();

    }, 1);

    return false;

  }else{

    if(value_staff_name == ""){

      alert(msg_array[1]);

      setTimeout(function(){

        element_staff_name.focus();

      }, 1);

      return false;

    }else{

      if(value_mail_first == "" || value_mail_second == ""){

        alert(msg_array[2]);

        setTimeout(function(){

          element_mail_first.focus();

        }, 1);

        return false;

      }else{

        if(value_TEL == ""){

          alert(msg_array[3]);

          setTimeout(function(){

            element_TEL.focus();

          }, 1);

          return false;

        }else{

          if(value_content_main == ""){

            alert(msg_array[4]);

            setTimeout(function(){

              element_content_main.focus();

            }, 1);

            return false;

          }

        }

      }

    }

  }

  return true;

}

// 送信時チェック用関数
function InputCheck(){

 if(NullCheck()){
  if(EmailCheck('.mail-address-first') && EmailCheck('.mail-address-second')){
   if(TELPatternCheck('.TEL')){
     if(PPCheck('OK')){

       return true;

    }

   }

  }

 }

 return false;

}
