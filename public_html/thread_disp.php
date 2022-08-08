<?php
require_once(__DIR__ .'/header.php');
$threadCon = new Apply\Controller\Thread();
$threadCon->run();
// thread_idはクエリパラメータで値いを取得
// $_GETはリンクがGET送信だから
$thread_id = $_GET['thread_id'];
$threadMod = new Apply\Model\Thread();
// $thread_idは$thread_id = $_GET['thread_id'];クエリパラメータで取得した値
$threadDisp = $threadMod->getThread($thread_id);
?>
<h1 class="page__ttl">スレッド詳細</h1>
<div class="thread__disp">
  <ul class="thread">
    <li class="thread__block" data-threadid="<?= $thread->t_id; ?>">
      <div class="thread__item" >
        <div class="thread__imgarea">
          <img src="<?= './gazou/'.h($threadDisp->image); ?>">
        </div>
        <div class="thread__ttlarea">
          <h2 class="thread__ttl"><?= h($threadDisp->title); ?></h2>
        </div>
        <div class="operation">
          <div class="thread__text">
            <p>都道府県：<?= h($threadDisp->address); ?></p>
            <p>発見日：<?= h($threadDisp->due_date); ?></p>
            <p>特徴：<?= h($threadDisp->comment); ?></p>
          </div>
        </div>
        <div class="thread__datearea">
        <p class="comment-page thread__date">スレッド作成日時：<?= h($threadDisp->created); ?></p>
        </div>
    <?php
      $comments = $threadMod->getCommentAll($threadDisp->id);
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
    <form action="" method="post" class="form-group">
      <div class="comment__form-group">
        <label>コメント投稿</label>
        <textarea type="text" name="content" class="form-control"><?= isset($threadCon->getValues()->content) ? h($threadCon->getValues()->content) : ''; ?></textarea>
        <p class="err"><?= h($threadCon->getErrors('content')); ?></p>
      </div>
      <div class="comment__form-group">
        <input type="submit" value="書き込み" class="btn btn-primary">
      </div>
      <input type="hidden" name="thread_id" value="<?= h($thread_id); ?>">
      <input type="hidden" name="type" value="createcomment">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
      </div>
      </ul>
</div><!-- thread -->
<?php require_once(__DIR__ .'/footer.php'); ?>