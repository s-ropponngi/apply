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
  $('.thread').find('.thread__ttl').each( function( index, element ) {
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

        $('[name="area"]').change(function() {
          // 選択されているvalue属性値を取り出す
          var val = $('[name="area"]').val();
          console.log(val);
          $.ajax({
            url: '/apply/public_html/ajax.php', //データベースを繋げるファイル
            type:"POST",
            data:{
              area: $(this).val(),
            }
          }).done(function(html){
                $('[name="area47"]').append(html);
            }).fail(function(html) {
                alert("error"); //通信失敗時
            });
      });
  });
