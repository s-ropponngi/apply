<?php
require_once(__DIR__ .'/header.php');
$threadMod = new Apply\Model\Thread();
$threads = $threadMod->getThreadAll();
$addresses = $threadMod->searchThread();
?>

<p>説明文</p>
<h1 class="page__ttl">ホーム画面</h1>
<div class="search-area">
  <form>
    <select name="area">
      <option value="">選択してください</option>
      <option value="保護しました">保護しました</option>
      <option value="探しています">探しています</option>
    </select>
    <select select name="area47">
    <option value="">都道府県</option>
    <?php foreach($addresses as $address): ?>
    <option><? h($address); ?></option>
    <?php endforeach?>
    </select>
  </form>
    <div class="search-result">
        <div class="search-result__hit-num"></div>
        <div class="thread__item__list"></div>
    </div>
</div>

<ul class="thread">
  <?php foreach($threads as $thread): ?>
    <li class="thre">
       <div class="thread__item" data-threadid="<?= $thread->t_id; ?>">
          <div class="thread__head">
            <img src="<?= './gazou/'.h($thread->image); ?>">
            <h2 class="thread__ttl">
              <?= h($thread->title); ?>
            </h2>
          <div class="text_btn">
            <div class="thread__text">
              <p>都道府県：<?= h($thread->address); ?></p>
              <p>発見日：<?= h($thread->due_date); ?></p>
              <p>特徴：<?= h($thread->comment); ?></p>
            </div>
            <div class="comment_btn">
              <a href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->t_id; ?>"><img src="<?= SITE_URL; ?>/asset/img/click_btn.png"></a>
            </div>
          </div>
          </div>
        <p class="thread__date">スレッド作成日時：<?= h($thread->created); ?></p>
        </div>
    </li>
  <?php endforeach?>
</ul><!-- thread -->
<?php
require_once(__DIR__ .'/footer.php');
?>
