<?php
require_once(__DIR__ .'/header.php');
$app = new Apply\Controller\UserDelete();
$app->run();
?>
<h1 class="ttl__area">User Delete</h1>

<div class="hukidashi">
  <p>以下のユーザーを退会します。実行する場合は「退会」ボタンを押してください。</p>
</div>

<div class="container__dog">
  <div class="form__inner">
    <div class="form-group">
      <p>メールアドレス：<?= isset($app->getValues()->email) ? h($app->getValues()->email): ''; ?></p>
      <p>ユーザー名：<?= isset($app->getValues()->username) ? h($app->getValues()->username): ''; ?></p>
    </div>
  </div>
  <form class="user-delete user-confirm" action="user_delete_done.php" method="post">
    <a class="btn btn-primary" href="javascript:history.back();">まだしません。</a>
    <input type="submit" class="btn btn-primary" value="退会">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <input type="hidden" name="type" value="delete">
  </form>
</div><!--container -->
<?php
require_once(__DIR__ .'/footer.php');
?>