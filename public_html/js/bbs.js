$(function () {
  $('input[type=file]').change(function () {
    var file = $(this).prop('files')[0];

    // 画像以外は処理を停止
    if (!file.type.match('image.*')) {
      // クリア
      $(this).val('');
      $('.imgfile').html('');
      return;
    }

    // 画像表示
    var reader = new FileReader();
    reader.onload = function () {
      var img_src = $('<img>').attr('src', reader.result);
      $('.imgfile').html(img_src);
      $('.imgarea').removeClass('noimage');
    }
    reader.readAsDataURL(file);
  });

  // タイトル色付け
  $('.thread__item').find('.thread__ttlarea').each( function( index, element ) {
        if ($.trim(element.textContent) == '探しています') {
        $(this).css('background-color','#C2DEE3')
      } else if($.trim(element.textContent) == '保護しました') {
        $(this).css('background-color','#F4C7AB')
      }
  });


  // 検索機能
    // searchWord = function(){
    //   var searchText = $(this).val(), // 検索ボックスに入力された値
    //       targetText,
    //       cnt,
    //       hitNum;
    //   // 検索結果を格納するための配列を用意
    //   searchResult = [];

    //   // 検索結果エリアの表示を空にする
    //   $('.thread__item__list').empty();
    //   $('.search-result__hit-num').empty();

    //   // 検索ボックスに値が入ってる場合
    //   if (searchText != '') {
    //     $('.thread li').each(function() {
    //       targetText = $(this).text();

    //     if (targetText.indexOf(searchText) != -1) {
    //       $(this).removeClass('hidden');
    //     } else {
    //       $(this).addClass('hidden');
    //       searchResult.push(targetText);
    //     }
    //   });

    //     cnt = $('ul.thread').find('li')

    //     // ヒットの件数をページに出力
    //     hitNum = '<span>検索結果</span>：' + (cnt.length - searchResult.length) + '件見つかりました。';
    //     $('.search-result__hit-num').append(hitNum);
    //   }
    // };

    // // searchWordの実行
    // $('#search-text').on('change', searchWord);

  //   $('#select-area').on('change', function(){
  //     $.ajax({
  //         url: '/apply/public_html/ajax.php', //データベースを繋げるファイル
  //         type:"POST",
  //         data:{
  //             area: $(this).val(), //選択されたデータ取得
  //         }
  //     }).done(function(html){
  //         $("#select-area47").append(html);
  //     }).fail(function(html) {
  //         alert("error"); //通信失敗時
  //     });
  // });

  //selectタグ（親） が変更された場合
  $('[name="address"]').on('change', function(){

    var origin = location.origin;

    // 選択されているタイトルのvalue属性値を取り出す
    var title_val = $('[name="title"]').val()
    // 選択されている都道府県のvalue属性値を取り出す
    var address_val = $(this).val();
    $.ajax({
      url: origin + '/apply/public_html/ajax.php',
      type: "POST",
      data: {
        'title': title_val,
        'address':address_val,
      },
      success: function (data) {
        var $thread = $('#thread');
        $('#thread').children().remove();
        $.each(data,function(index) {

          $thread.append('<li id="thread__block' + index + '" class="thread__block"></li>');

          $('#thread__block' + index).append('<div id="thread__item' + index + '" class="thread__item"></div>');

          $('#thread__item' + index).append('<div id="thread__imgarea' + index + '" class="thread__imgarea"></div>');

          $('#thread__imgarea' + index).append('<img id="thread__img' + index + '" class="thread__img">');

          $('#thread__imgarea' + index).after('<div id="thread__ttlarea' + index + '" class="thread__ttlarea"></div>');

          $('#thread__ttlarea' + index).append('<h2 id="thread__ttl' + index + '" class="thread__ttl"></h2>');

          $('#thread__ttlarea' + index).after('<div id="operation' + index + '" class="operation"></div>');

          $('#operation' + index).append('<div id="thread__text' + index + '" class="thread__text"></div>');

          $('#thread__text' + index).append('<p id="thread__address' + index + '" class="thread__address"></p>');

          $('#thread__address' + index).after('<p id="thread__due_date' + index + '" class="thread__due_date"></p>');

          $('#thread__due_date' + index).after('<p id="thread__comment' + index + '" class="thread__comment"></p>');

          $('#thread__text' + index).after('<a id="comment_btn' + index + '" class="comment_btn"></a>');

          // $('#comment_btn' + index).after('<img id="comment__btnimg' + index + '" class="comment__btnimg" src="../asset/img/click_btn.png">');

          $('#operation' + index).after('<div id="thread__datearea' + index + '" class="thread__datearea"></div>');

          $('#comment_datearea' + index).append('<p id="thread__date' + index + '" class="thread__date"></p>');




          $('#thread__item' + index).find('.thread__img').each( function( key, element ) {
            $(element).attr('src','./gazou/' + data[index]['image']);
          });

          $('#thread__item' + index).find('.thread__ttl').each( function( key, element ) {
            $(element).text(data[index]['title']);
          });

          $('#thread__item' + index).find('.thread__address').each( function( key, element ) {
            $(element).text(data[index]['address']);
          });

          $('#thread__item' + index).find('.thread__due_date').each( function( key, element ) {
            $(element).text(data[index]['due_date']);
          });

          $('#thread__item' + index).find('.thread__comment').each( function( key, element ) {
            $(element).text(data[index]['comment']);
          });

          $('#thread__item' + index).find('.thread__date').each( function( key, element ) {
            $(element).text(data[index]['created']);
          });
        });
      }
    });
  });
});
