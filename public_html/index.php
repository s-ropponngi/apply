<?php
require_once(__DIR__ .'/header.php');
$threadMod = new Apply\Model\Thread();
$threads = $threadMod->getThreadAll();
?>

<p>説明文</p>
<h1 class="page__ttl">ホーム画面</h1>
<form action="thread_search.php" method="get" class="form-group form-search">
  <div class="form-group">
    <input type="text" name="keyword" placeholder="スレッド検索">
  </div>
  <div class="form-group">
    <input type="submit" value="検索" class="btn btn-primary">
    <!-- searchthreadも一緒に送る -->
    <input type="hidden" name="type" value="searchthread">
  </div>
</form>


<ul class="thread">
  <?php foreach($threads as $thread): ?>
    <li class="thread__item" data-threadid="<?= $thread->t_id; ?>">
      <div class="thread__head">
        <img src="<?= './gazou/'.h($thread->image); ?>">
        <h2 class="thread__ttl">
          <?= h($thread->title); ?>
        </h2>
      <div class="thread__text">
        <p>都道府県：<?= h($thread->address); ?></p>
        <p>発見日：<?= h($thread->due_date); ?></p>
        <p>特徴：<?= h($thread->comment); ?></p>
      </div>
      <div class="operation">
        <a class="btn btn-primary" href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->t_id; ?>">詳細</a>
      </div>
    </div>
      <p class="thread__date">スレッド作成日時：<?= h($thread->created); ?></p>
    </li>
  <?php endforeach?>
</ul><!-- thread -->
<?php
require_once(__DIR__ .'/footer.php');
?>
