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

  // 全件取得
  $(document).ready(function() {
    var origin = location.origin;
    $.ajax({
      url: origin + '/ajax.php',
      type: "POST",
      data: {
        'type': 'getThreadAll',
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

          $('#thread__text' + index).append('<p id="thread__address' + index + '" class="thread__address">発見場所：</p>');

          $('#thread__address' + index).append('<span id="thread__address-span' + index + '" class="thread__address-span"></span>');

          $('#thread__address' + index).after('<p id="thread__due_date' + index + '" class="thread__due_date">発見日：</p>');

          $('#thread__due_date' + index).append('<span id="thread__due_date-span' + index + '" class="thread__due_date-span"></span>');

          $('#thread__due_date' + index).after('<p id="thread__comment' + index + '" class="thread__comment">特徴：</p>');

          $('#thread__comment' + index).append('<span id="thread__comment-span' + index + '" class="thread__comment-span"></span>');

          $('#thread__text' + index).after('<a id="comment__btn' + index + '" class="comment__btn" href="thread_disp.php/thread_id=35"></a>');

          $('#comment__btn' + index).append('<img id="comment__btnimg' + index + '" class="comment__btnimg" src="asset/img/click_btn.png">');

          $('#operation' + index).after('<div id="thread__datearea' + index + '" class="thread__datearea"></div>');

          $('#thread__datearea' + index).append('<p id="thread__date' + index + '" class="thread__date"></p>');




          $('#thread__item' + index).find('.thread__img').each( function( key, element ) {
            $(element).attr('src','./gazou/' + data[index]['image']);
          });

          $('#thread__item' + index).find('.thread__ttl').each( function( key, element ) {
            $(element).text(data[index]['title']);
          });

          $('#thread__item' + index).find('.thread__address-span').each( function( key, element ) {
            $(element).text(data[index]['address']);
          });

          $('#thread__item' + index).find('.thread__due_date-span').each( function( key, element ) {
            $(element).text(data[index]['due_date']);
          });

          $('#thread__item' + index).find('.thread__comment-span').each( function( key, element ) {
            $(element).text(data[index]['comment']);
          });

          $('#thread__item' + index).find('.thread__date').each( function( key, element ) {
            $(element).text(data[index]['created']);
          });

          $('#thread__item' + index).find('.comment__btn').each( function( key, element ) {
            $(element).attr('href','thread_disp.php?thread_id=' + data[index]['id']);
          });

          if ($.trim($('#thread__ttlarea' + index).find('.thread__ttl').text()) == '探しています') {
            $('#thread__ttlarea' + index).css('background-color','#C2DEE3')
          }else {
            $('#thread__ttlarea' + index).css('background-color','#F4C7AB')
          }
        });
      }
    });
  });

  $('[name="title"]').on('change', function(){
    var origin = location.origin;
    var title_val = $(this).val();
    $.ajax({
      url: origin + '/ajax.php',
      type: "POST",
      data: {
        'type': 'searchAddress',
        'title': title_val,
      },

    success: function (data) {
      // var $address = '';
      var $address = $('#address');
      $('.address .address').remove();
      // $address.after('');
      // $address.after('<option id="address' + index + '" class="address"></option>');
      // if()
      $.each(data,function(index) {
        $address.after('<option id="address' + index + '" class="address"></option>');
        $('#address' + index).text(data[index]['address']);
      })
    }
    })
  });


  // 検索機能
  //selectタグ（親） が変更された場合
  $('[name="address"]').on('change', function(){

    var origin = location.origin;

    // 選択されているタイトルのvalue属性値を取り出す
    var title_val = $('[name="title"]').val()
    // 選択されている都道府県のvalue属性値を取り出す
    var address_val = $(this).val();
    $.ajax({
      url: origin + '/ajax.php',
      type: "POST",
      data: {
        'type': 'searchThread',
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

          $('#thread__text' + index).after('<a id="comment__btn' + index + '" class="comment__btn"></a>');

          $('#comment__btn' + index).append('<img id="comment__btnimg' + index + '" class="comment__btnimg" src="asset/img/click_btn.png">');

          $('#operation' + index).after('<div id="thread__datearea' + index + '" class="thread__datearea"></div>');

          $('#thread__datearea' + index).append('<p id="thread__date' + index + '" class="thread__date"></p>');




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

          $('#thread__item' + index).find('.comment__btn').each( function( key, element ) {
            $(element).attr('href','thread_disp.php?thread_id=' + data[index]['id']);
          });

          if ($.trim($('#thread__ttlarea' + index).find('.thread__ttl').text()) == '探しています') {
            $('#thread__ttlarea' + index).css('background-color','#C2DEE3')
          }else {
            $('#thread__ttlarea' + index).css('background-color','#F4C7AB')
          }
        });
      }
    });
  });
});
