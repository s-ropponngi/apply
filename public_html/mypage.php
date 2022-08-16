<?php
require_once(__DIR__ .'/header.php');
$app = new Apply\Controller\UserUpdate();
$app->run();
// $app = new Apply\Controller\UserUpdate();
// $userDatas = $app->run();
$user = new \Apply\Model\User();
$userDatas = $user->find($_SESSION['me']->id);
$userNames = $user->findUser($_SESSION['me']->id);
?>
<h1 class="ttl__mypage"><img src="<?= SITE_URL; ?>/asset/img/mypage.png"></h1>



  <?php foreach($userDatas as $userData): ?>
    <div class="new__thread-block">
      <div class="img__block">
        <div class="imgarea <?= isset($userData->image) ? '': 'noimage' ?>">
          <div class="imgfile">
            <img src="<?= './gazou/'.h($userData->image); ?>" alt="">
          </div>
        </div>
      </div>
      <div class="form__block">
        <div class="form-group">
          <label for="name">タイトル:</label>
          <div name="thread_name" class="form-control"><?= isset($userData->title) ? h($userData->title) : ''; ?></div>
        </div>
        <div class="form-group">
          <label for="address">発見場所:</label>
          <div name="address_name" class="form-control"><?= isset($userData->address) ? h($userData->address) : ''; ?></div>
        </div>
        <div class="form-group">
          <label for="day">発見日:</label>
          <div class="form-control" name="due_date"><?= $userData->due_date ?></div>
        </div>
        <div class="form-group">
          <label for="message">特徴:</label>
          <div name="comment" class="form-control"><?= isset($userData->comment) ? h($userData->comment) : ''; ?></div>
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </div>
        <form action="thread_update.php" method="post" class="new_thread" id="<?= 'new_thread'. $userData->id ?> " enctype="multipart/form-data">
          <input type="image" class="form-group btn btn-primary" src="<?= SITE_URL; ?>/asset/img/edit.png">
          <input type="hidden" name="thread_id" value="<?= h($userData->id); ?>">
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
      </div>
    </div>
    <?php endforeach; ?>

<div class="neko-wrap-c">
  <div class="container">
    <form action="" method="post" id="userupdate" class="form mypage-form row" enctype="multipart/form-data">
      <div class="form">
        <div class="form-block">
          <label for="email"></label>
          <input type="text" name="email" value="<?= isset($userNames->email) ? h($userNames->email): ''; ?>" placeholder="メールアドレス">
          <p class="err"><?= h($app->getErrors('email')); ?></p>
        </div>
        <div class="form-block">
          <label for="user"></label>
          <input type="text" name="username" value="<?= isset($userNames->username) ? h($userNames->username): ''; ?>" placeholder="ユーザー名">
          <p class="err"><?= h($app->getErrors('username')); ?></p>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('userupdate').submit();">更新</button>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </div>
    </form>
    <form class="user-delete" action="user_delete_confirm.php" method="post">
      <input type="submit" class="btn btn-default" value="退会する">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </div><!--container -->
</div>

<?php
require_once(__DIR__ .'/footer.php');
?>
