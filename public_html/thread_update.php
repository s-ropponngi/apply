<?php
require_once(__DIR__ .'/header.php');

$thread_disp = new \Apply\Model\Thread();
if(isset($_POST['thread_id'])){
  $thread_id = $_POST['thread_id'];
  $threadDisp = $thread_disp->getThread($thread_id);
}

$threadCon = new Apply\Controller\Thread();
$threadCon->run();

?>
<h1 class="ttl__area">Edit Page</h1>
<form action="" method="post" class="new_thread" id="new_thread" enctype="multipart/form-data">

    <div class="new__thread-block">
      <div class="img__block">
        <div class="imgarea <?= isset($threadCon->getValues()->image) ? '': 'noimage' ?>">

          <div class="imgfile">
            <img src="<?= isset($_POST['thread_id']) ? './gazou/'.h($threadDisp->image) : './gazou/'.h($_POST['image']) ; ?>" alt="">
          </div>
        </div>
        <label class="file-img">
          <input type="file" name="image" accept="image/*">
          <img src="<?= SITE_URL; ?>/asset/img/img_choice.png">
        </label>
      </div>
      <div class="form__block">
        <div class="form-group">
          <label for="name">タイトル:</label>
          <select name="thread_name" type="text" class="form-control" value="<?= isset($userData->title) ? h($threadDisp->title) : ''; ?>">
            <option value="">選択してください</option>
            <option value="保護しました" id="c1" <?= $threadDisp->title == '保護しました' ? 'selected':''  ?>>保護しました</option>
            <option value="探しています" id="c2"  <?= $threadDisp->title == '探しています' ? 'selected':''  ?>>探しています</option>
          </select>
        </div>
        <div class="form-group">
          <label for="address">発見場所:</label>
          <select name="address_name" type="text" class="form-control" value="<?= isset($userData->address) ? h($threadDisp->address) : ''; ?>">
            <option value="">選択してください</option>
            <option value="北海道" <?php if ( $threadDisp->address === '北海道' ) { echo ' selected'; } ?>>北海道</option>
            <option value="青森県" <?php if ( $threadDisp->address === '青森県' ) { echo ' selected'; } ?>>青森県</option>
            <option value="岩手県" <?php if ( $threadDisp->address === '岩手県' ) { echo ' selected'; } ?>>岩手県</option>
            <option value="宮城県" <?php if ( $threadDisp->address === '宮城県' ) { echo ' selected'; } ?>>宮城県</option>
            <option value="秋田県" <?php if ( $threadDisp->address === '秋田県' ) { echo ' selected'; } ?>>秋田県</option>
            <option value="山形県" <?php if ( $threadDisp->address === '山形県' ) { echo ' selected'; } ?>>山形県</option>
            <option value="福島県" <?php if ( $threadDisp->address === '福島県' ) { echo ' selected'; } ?>>福島県</option>
            <option value="茨城県" <?php if ( $threadDisp->address === '茨城県' ) { echo ' selected'; } ?>>茨城県</option>
            <option value="栃木県" <?php if ( $threadDisp->address === '栃木県' ) { echo ' selected'; } ?>>栃木県</option>
            <option value="群馬県" <?php if ( $threadDisp->address === '群馬県' ) { echo ' selected'; } ?>>群馬県</option>
            <option value="埼玉県" <?php if ( $threadDisp->address === '埼玉県' ) { echo ' selected'; } ?>>埼玉県</option>
            <option value="千葉県" <?php if ( $threadDisp->address === '千葉県' ) { echo ' selected'; } ?>>千葉県</option>
            <option value="東京都" <?php if ( $threadDisp->address === '東京都' ) { echo ' selected'; } ?>>東京都</option>
            <option value="神奈川県" <?php if ( $threadDisp->address === '神奈川県' ) { echo ' selected'; } ?>>神奈川県</option>
            <option value="新潟県" <?php if ( $threadDisp->address === '新潟県' ) { echo ' selected'; } ?>>新潟県</option>
            <option value="富山県" <?php if ( $threadDisp->address === '富山県' ) { echo ' selected'; } ?>>富山県</option>
            <option value="石川県" <?php if ( $threadDisp->address === '石川県' ) { echo ' selected'; } ?>>石川県</option>
            <option value="福井県" <?php if ( $threadDisp->address === '福井県' ) { echo ' selected'; } ?>>福井県</option>
            <option value="山梨県" <?php if ( $threadDisp->address === '山梨県' ) { echo ' selected'; } ?>>山梨県</option>
            <option value="長野県" <?php if ( $threadDisp->address === '長野県' ) { echo ' selected'; } ?>>長野県</option>
            <option value="岐阜県" <?php if ( $threadDisp->address === '岐阜県' ) { echo ' selected'; } ?>>岐阜県</option>
            <option value="静岡県" <?php if ( $threadDisp->address === '静岡県' ) { echo ' selected'; } ?>>静岡県</option>
            <option value="愛知県" <?php if ( $threadDisp->address === '愛知県' ) { echo ' selected'; } ?>>愛知県</option>
            <option value="三重県" <?php if ( $threadDisp->address === '三重県' ) { echo ' selected'; } ?>>三重県</option>
            <option value="滋賀県" <?php if ( $threadDisp->address === '滋賀県' ) { echo ' selected'; } ?>>滋賀県</option>
            <option value="京都府" <?php if ( $threadDisp->address === '京都府' ) { echo ' selected'; } ?>>京都府</option>
            <option value="大阪府" <?php if ( $threadDisp->address === '大阪府' ) { echo ' selected'; } ?>>大阪府</option>
            <option value="兵庫県" <?php if ( $threadDisp->address === '兵庫県' ) { echo ' selected'; } ?>>兵庫県</option>
            <option value="奈良県" <?php if ( $threadDisp->address === '奈良県' ) { echo ' selected'; } ?>>奈良県</option>
            <option value="和歌山県" <?php if ( $threadDisp->address === '和歌山県' ) { echo ' selected'; } ?>>和歌山県</option>
            <option value="鳥取県" <?php if ( $threadDisp->address === '鳥取県' ) { echo ' selected'; } ?>>鳥取県</option>
            <option value="島根県" <?php if ( $threadDisp->address === '島根県' ) { echo ' selected'; } ?>>島根県</option>
            <option value="岡山県" <?php if ( $threadDisp->address === '岡山県' ) { echo ' selected'; } ?>>岡山県</option>
            <option value="広島県" <?php if ( $threadDisp->address === '広島県' ) { echo ' selected'; } ?>>広島県</option>
            <option value="山口県" <?php if ( $threadDisp->address === '山口県' ) { echo ' selected'; } ?>>山口県</option>
            <option value="徳島県" <?php if ( $threadDisp->address === '徳島県' ) { echo ' selected'; } ?>>徳島県</option>
            <option value="香川県" <?php if ( $threadDisp->address === '香川県' ) { echo ' selected'; } ?>>香川県</option>
            <option value="愛媛県" <?php if ( $threadDisp->address === '愛媛県' ) { echo ' selected'; } ?>>愛媛県</option>
            <option value="高知県" <?php if ( $threadDisp->address === '高知県' ) { echo ' selected'; } ?>>高知県</option>
            <option value="福岡県" <?php if ( $threadDisp->address === '福岡県' ) { echo ' selected'; } ?>>福岡県</option>
            <option value="佐賀県" <?php if ( $threadDisp->address === '佐賀県' ) { echo ' selected'; } ?>>佐賀県</option>
            <option value="長崎県" <?php if ( $threadDisp->address === '長崎県' ) { echo ' selected'; } ?>>長崎県</option>
            <option value="熊本県" <?php if ( $threadDisp->address === '熊本県' ) { echo ' selected'; } ?>>熊本県</option>
            <option value="大分県" <?php if ( $threadDisp->address === '大分県' ) { echo ' selected'; } ?>>大分県</option>
            <option value="宮崎県" <?php if ( $threadDisp->address === '宮崎県' ) { echo ' selected'; } ?>>宮崎県</option>
            <option value="鹿児島県" <?php if ( $threadDisp->address === '鹿児島県' ) { echo ' selected'; } ?>>鹿児島県</option>
            <option value="沖縄県" <?php if ( $threadDisp->address === '沖縄県' ) { echo ' selected'; } ?>>沖縄県</option>
          </select>
        </div>
        <div class="form-group">
          <label for="day">発見日:</label>
          <input type="text" class="form-control" name="due_date" id="due_date" value="<?= $threadDisp->due_date ?>" placeholder="選択してください">
        </div>
        <div class="form-group">
          <label for="message">特徴:</label>
          <textarea maxlength="40" type="text" name="comment" class="form-control" placeholder="40文字以内でお願いいたします"><?= isset($threadDisp->comment) ? h($threadDisp->comment) : ''; ?></textarea>
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
          <input type="hidden" name="type" value="updatethread">
          <input type="hidden" name="old_image" value="<?= h($threadDisp->image) ?>">
          <input type="hidden" name="thread_id" value="<?= h($threadDisp->id) ?>">
        </div>
        <p class="err"><?= h($threadCon->getErrors('update_thread')); ?></p>
      </div>
    </div>
    </form>
    <div class="form-group btn btn-primary" onclick="document.getElementById('new_thread').submit();"><img src="<?= SITE_URL; ?>/asset/img/edit.png"></div>

<?php require_once(__DIR__ .'/footer.php'); ?>