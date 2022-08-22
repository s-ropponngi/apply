<?php
require_once(__DIR__ .'/header.php');
// Loginクラスのインスタンス化
$app = new Apply\Controller\Login();
$app->run();
?>

<div class="hukidashi">
  <p>こちらでログインしてください。</p>
</div>

  <div class="container__cat">
    <div class="form__inner">
      <form action="" method="post" id="login" class="form">
        <div class="form-block">
          <label for="email"></label>
          <input type="text" name="email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>" placeholder="メールアドレス">
        </div>
        <div class="form-block">
          <label for="password"></label>
          <input type="password" name="password" placeholder="パスワード">
        </div>
        <p class="err"><?= h($app->getErrors('login')); ?></p>
        <div class="button" onclick="document.getElementById('login').submit();"><img src="<?= SITE_URL; ?>/asset/img/login.png"></div>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    <p class="form-footer"><a href="signup.php">ユーザー登録</a></p>
  </div>
</div><!--container -->
<?php require_once(__DIR__ .'/footer.php'); ?>