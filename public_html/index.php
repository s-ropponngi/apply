<?php
require_once(__DIR__ .'/header.php');
$threadMod = new Apply\Model\Thread();
$threads = $threadMod->getThreadAll();
?>
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
        <img src="<?= h($thread->image); ?>">
        <h2 class="thread__ttl">
          <?= h($thread->title); ?>
        </h2>
        <p><?= h($thread->address); ?></p><br>
        <p><?= h($thread->due_date); ?></p><br>
        <p><?= h($thread->comment); ?></p><br>
      <div class="fav__btn<?php if(isset($thread->f_id)) { echo ' active';} ?>"><i class="fas fa-star"></i></div>
      </div>
<ul class="thread__body">
  <?php
    $comments = $threadMod->getComment($thread->t_id);
    foreach($comments as $comment):
  ?>
  <li class="comment__item">
          <div class="comment__item__head">
            <span class="comment__item__num"><?= h($comment->comment_num); ?></span>
            <span class="comment__item__name">名前：<?= h($comment->username); ?></span>
            <span class="comment__item__date">投稿日時：<?= h($comment->created); ?></span>
          </div>
          <p class="comment__item__content"><?= h($comment->content); ?></p>
        <?php endforeach; ?>
        </li>
      </ul>
      <div class="operation">
      <a href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->t_id; ?>">書き込み&すべて読む(<?= h($threadMod->getCommentCount($thread->t_id)); ?>)</a>
        <p class="thread__date">スレッド作成日時：<?= h($thread->created); ?></p>
      </div>
    </li>
  <?php endforeach?>
</ul><!-- thread -->
<?php
require_once(__DIR__ .'/footer.php');
?>
