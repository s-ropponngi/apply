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
<div class="thread">
  <div class="thread__item">
    <div class="thread__head">
      <h2 class="thread__ttl">
        <!-- getThreadの戻り値がタイトル部分になる -->
        <?= h($threadDisp->title); ?>
      </h2>
      <form id="csvoutput" method="post" action="thread_csv.php">
        <button class="btn btn-primary" onclick="document.getElementById('csvoutput').submit();">CSV出力</button>
        <input type="hidden" name="thread_id" value="<?= h($thread_id); ?>">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        <input type="hidden" name="type" value="outputcsv">
      </form>
    </div>
    <ul class="thread__body">
    <li class="thread__item" data-threadid="<?= $thread->t_id; ?>">
      <div class="thread__head">
        <img src="<?= './gazou/'.h($threadDisp->image); ?>">
        <p><?= h($threadDisp->address); ?></p>
        <p><?= h($threadDisp->due_date); ?></p>
        <p><?= h($threadDisp->comment); ?></p>
      </div>
    <?php
      $comments = $threadMod->getCommentAll($threadDisp->id);
      // getCommentAllの戻り値でコメント数分処理を行っている
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
    <form action="" method="post" class="form-group">
      <div class="form-group">
        <label>コメント</label>
        <textarea type="text" name="content" class="form-control"><?= isset($threadCon->getValues()->content) ? h($threadCon->getValues()->content) : ''; ?></textarea>
        <p class="err"><?= h($threadCon->getErrors('content')); ?></p>
      </div>
      <div class="form-group">
        <input type="submit" value="書き込み" class="btn btn-primary">
      </div>
      <input type="hidden" name="thread_id" value="<?= h($thread_id); ?>">
      <input type="hidden" name="type" value="createcomment">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <p class="comment-page thread__date">スレッド作成日時：<?= h($threadDisp->created); ?></p>
  </div>
</div><!-- thread -->
<?php require_once(__DIR__ .'/footer.php'); ?>