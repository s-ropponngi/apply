<?php
require_once(__DIR__ .'/header.php');
$app = new Apply\Controller\UserUpdate();
$app->run();
?>
<h1 class="page__ttl">マイページ</h1>
<div class="container">
  <!-- 画像の送信するときは enctype="multipart/form-data"ここを書く-->
  <form action="" method="post" id="userupdate" class="form mypage-form row" enctype="multipart/form-data">
    <div class="col-md-8">
      <div class="form-group">
        <label>メールアドレス</label>
        <input type="text" name="email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email): ''; ?>" class="form-control">
        <p class="err"><?= h($app->getErrors('email')); ?></p>
      </div>
      <div class="form-group">
        <label>ユーザー名</label>
        <input type="text" name="username" value="<?= isset($app->getValues()->username) ? h($app->getValues()->username): ''; ?>" class="form-control">
        <p class="err"><?= h($app->getErrors('username')); ?></p>
      </div>
      <button class="btn btn-primary" onclick="document.getElementById('userupdate').submit();">更新</button>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <!-- 以前登録していた画像情報を送る -->
      <input type="hidden" name="old_image" value="<?= h($app->getValues()->image); ?>">
      <p class="err"></p>
    </div>
  </form>
  <form class="user-delete" action="user_delete_confirm.php" method="post">
    <input type="submit" class="btn btn-default" value="退会する">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
</div><!--container -->
<?php
require_once(__DIR__ .'/footer.php');
?>
