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
  })
});

