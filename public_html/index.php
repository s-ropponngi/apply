<?php
require_once(__DIR__ .'/header.php');
$threadMod = new Apply\Model\Thread();
$threads = $threadMod->getThreadAll();
// $threads = $threadMod->searchThread()
?>

<p>説明文</p>
<h1 class="page__ttl">ホーム画面</h1>
<div class="search-area">
  <form>
    <select class="title" name="title">
      <option value="">選択してください</option>
      <option value="保護しました" id = "c1">保護しました</option>
      <option value="探しています" id = "c2">探しています</option>
    </select>
    <select class="address" name="address">
      <option value="">都道府県</option>
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
  </form>
</div>

<ul id="thread" class="thread">
  <!-- <li class="thread__item" data-threadid="<?= $thread->t_id; ?>"> -->
  <div class="thread__brock">
    <li class="thread__item">
      <div class="thread__head">
        <img class="main-image">
        <h2 class="thread__ttl">
          <!-- <?= h($thread->title); ?> -->
        </h2>
        <div class="operation">
          <div class="thread__text">
            <p class="address__text"></p>
            <p class="due_date__text"></p>
            <p class="comment__text"></p>
          <!-- <p>都道府県：<?= h($thread->address); ?></p>
          <p>発見日：<?= h($thread->due_date); ?></p>
          <p>特徴：<?= h($thread->comment); ?></p> -->
          </div>
          <a class="comment_btn" href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->t_id; ?>"><img src="<?= SITE_URL; ?>/asset/img/click_btn.png"></a>
        </div>
      </div>
      <p class="thread__date"></p>
    <!-- <p class="thread__date">スレッド作成日時：<?= h($thread->created); ?></p> -->
    </li>
  </div>
</ul><!-- thread -->


<?php
require_once(__DIR__ .'/footer.php');
?>
