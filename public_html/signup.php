<?php
require_once(__DIR__ .'/header.php');
// コントローラーのSingupクラスをインスタンス化している。
$app = new Apply\Controller\Signup();
$app->run();
?>

<div class="hukidashi">
  <p>こちらで会員登録してください。</p>
</div>

<div class="container__dog">
  <div class="form__inner">
    <form action="" method="post" id="signup" class="form">
      <div class="form-block">
      <label for="email"></label>
      <input type="text" name="email" value="<?= isset
      ($app->getValues()->email) ? h($app->getValues()->email): ''; ?>" placeholder="メールアドレス" class="form-control">
      <p class="err"><?= h($app->getErrors('email')); ?></p>
    </div>
    <div class="form-block">
      <label for="user"></label>
      <input type="text" name="username" value="<?= isset($app->getValues()->username) ? h($app->getValues()->username): ''; ?>" placeholder="ユーザー名" class="form-control">
      <p class="err"><?= h($app->getErrors('username')); ?></p>
    </div>
    <div class="form-block">
      <label for="password"></label>
      <input type="password" name="password" placeholder="パスワード" class="form-control">
      <p class="err"><?= h($app->getErrors('password')); ?></p>
    </div>
    <div class="button" onclick="document.getElementById('signup').submit();"><img src="<?= SITE_URL; ?>/asset/img/sign-up.png"></div>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
  <p class="form-footer"><a href="<?= SITE_URL; ?>/login.php">ログイン</a></p>
  </div>
</div><!-- container -->
<?php require_once(__DIR__ .'/footer.php'); ?>
