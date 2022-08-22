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
      <p>メールアドレス：<?= isset($app->getValues()->email) ? h($app->getValues()->email): ''; ?></p><br>
      <p>ユーザー名：<?= isset($app->getValues()->username) ? h($app->getValues()->username): ''; ?></p>
  <form class="form__delete" action="user_delete_done.php" method="post">
    <input type="image" class="button" src="<?= SITE_URL; ?>/asset/img/delete.png">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <input type="hidden" name="type" value="delete"><br>
    <a class="button_under" href="javascript:history.back();">キャンセル</a>
  </form>
  </div>
</div><!--container -->
<?php
require_once(__DIR__ .'/footer.php');
?>