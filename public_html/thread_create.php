<?php
require_once(__DIR__ .'/header.php');
$app = new Apply\Controller\Thread();
$app->run();
?>
<h1 class="ttl__new_create"><img src="<?= SITE_URL; ?>/asset/img/new_create.png"></h1>

<div class="new__thread-block">
  <form action="" method="post" class="new_thread" id="new_thread" enctype="multipart/form-data">
    <div class="img__block">
      <div class="imgarea <?= isset($app->getValues()->image) ? '': 'noimage' ?>">
        <div class="imgfile">
          <img src="<?= isset($app->getValues()->image) ? './gazou/'. h($app->getValues()->image) : './asset/img/noimage.jpg'; ?>" alt="">
        </div>
      </div>
      <label class="file-img">
        <input type="file" name="image" accept="image/*">
        <img src="<?= SITE_URL; ?>/asset/img/img_choice.png">
      </label>
    </div>
    <div class="form__block">
      <div class="form-group">
        <label for="name">タイトル：</label>
        <select name="thread_name" type="text" class="form-control" value="<?= isset($app->getValues()->thread_name) ? h($app->getValues()->thread_name) : ''; ?>">
          <option value="">選択してください</option>
          <option value="保護しました" id="c1">保護しました</option>
          <option value="探しています" id="c2">探しています</option>
        </select>
      </div>
      <div class="form-group">
        <label for="address">発見場所：</label>
        <select name="address_name" type="text" class="form-control" value="<?= isset($app->getValues()->address_name) ? h($app->getValues()->address_name) : ''; ?>">
          <option value="">選択してください</option>
          <option value="北海道">北海道</option>
          <option value="青森県">青森県</option>
          <option value="岩手県">岩手県</option>
          <option value="宮城県">宮城県</option>
          <option value="秋田県">秋田県</option>
          <option value="山形県">山形県</option>
          <option value="福島県">福島県</option>
          <option value="茨城県">茨城県</option>
          <option value="栃木県">栃木県</option>
          <option value="群馬県">群馬県</option>
          <option value="埼玉県">埼玉県</option>
          <option value="千葉県">千葉県</option>
          <option value="東京都">東京都</option>
          <option value="神奈川県">神奈川県</option>
          <option value="新潟県">新潟県</option>
          <option value="富山県">富山県</option>
          <option value="石川県">石川県</option>
          <option value="福井県">福井県</option>
          <option value="山梨県">山梨県</option>
          <option value="長野県">長野県</option>
          <option value="岐阜県">岐阜県</option>
          <option value="静岡県">静岡県</option>
          <option value="愛知県">愛知県</option>
          <option value="三重県">三重県</option>
          <option value="滋賀県">滋賀県</option>
          <option value="京都府">京都府</option>
          <option value="大阪府">大阪府</option>
          <option value="兵庫県">兵庫県</option>
          <option value="奈良県">奈良県</option>
          <option value="和歌山県">和歌山県</option>
          <option value="鳥取県">鳥取県</option>
          <option value="島根県">島根県</option>
          <option value="岡山県">岡山県</option>
          <option value="広島県">広島県</option>
          <option value="山口県">山口県</option>
          <option value="徳島県">徳島県</option>
          <option value="香川県">香川県</option>
          <option value="愛媛県">愛媛県</option>
          <option value="高知県">高知県</option>
          <option value="福岡県">福岡県</option>
          <option value="佐賀県">佐賀県</option>
          <option value="長崎県">長崎県</option>
          <option value="熊本県">熊本県</option>
          <option value="大分県">大分県</option>
          <option value="宮崎県">宮崎県</option>
          <option value="鹿児島県">鹿児島県</option>
          <option value="沖縄県">沖縄県</option>
        </select>
      </div>
      <div class="form-group">
        <label for="day">発見日：</label>
        <input type="text" class="form-control " name="due_date" id="due_date" value="" placeholder="選択してください">
      </div>
      <div class="form-group">
        <label for="message">特徴：</label>
        <textarea maxlength="40" type="text" name="comment" class="form-control" placeholder="40文字以内でお願いいたします"><?= isset($app->getValues()->comment) ? h($app->getValues()->comment) : ''; ?></textarea>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        <input type="hidden" name="type" value="createthread">
      </div>
      <p class="err"><?= h($app->getErrors('create_thread')); ?></p>
    </div>
  </form>
</div>
<div class="form-group btn btn-primary" onclick="document.getElementById('new_thread').submit();"><img src="<?= SITE_URL; ?>/asset/img/primary.png">
</div>
<?php
require_once(__DIR__ .'/footer.php');
?>