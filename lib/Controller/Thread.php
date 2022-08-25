<?php
namespace Apply\Controller;

///// 画像をs3へアップロードする/////
require(__DIR__ . '/../../vendor/autoload.php');
use Aws\S3\S3Client;
use Aws\Credentials\CredentialProvider;
// use Dotenv\Dotenv;
//////////////////////////////////


class Thread extends \Apply\Controller {
  public function run() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(isset($_POST['type'])){
        if ($_POST['type']  === 'createthread') {
          $this->createThread();
        } elseif($_POST['type']  === 'createcomment') {
          $this->createComment();
        } elseif($_POST['type']  === 'updatethread'){
          $this->updateThread();
        }
      }
    }
  }

  private function createThread(){
    try {
      $this->validate();
    } catch (\Apply\Exception\EmptyPost $e) {
        $this->setErrors('create_thread', $e->getMessage());
    } catch (\Apply\Exception\CharLength $e) {
        $this->setErrors('create_thread', $e->getMessage());
    }
    $this->setValues('thread_name', $_POST['thread_name']);
    $this->setValues('address_name', $_POST['address_name']);
    $this->setValues('due_date', $_POST['due_date']);
    $this->setValues('comment', $_POST['comment']);
    if ($this->hasError()){
      return;
    } else {
      $threadModel = new \Apply\Model\Thread();

      // 画像の編集(画像のリンク変更)
      if($_FILES['image']['name'] == '') {
        $old_img = $_POST['old_image'];
        $user_img['name'] = $old_img;
      }else{
        $user_img = $_FILES['image'];
        $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
        $user_img['name'] = uniqid("img_") .'.'. $ext;
      }
      try {
        $userModel = new \Apply\Model\Thread();

        // Model部分に渡すようにしている部分
        $threadModel->createThread([
          'image' => $user_img['name'],
          'title' => $_POST['thread_name'],
          'address' => $_POST['address_name'],
          'due_date' => $_POST['due_date'],
          'comment' => $_POST['comment'],
          'user_id' => $_SESSION['me']->id
        ]);
        if($user_img['size'] > 0) {
          ///// 画像をs3へアップロードする/////
          $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'ap-northeast-1',
            'credentials' => CredentialProvider::defaultProvider(),
            // 'credentials' => false
          ]);

          // よく使われる書き方だが、動かなかった。
          // $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
          // $dotenv->load();
          // $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

          $bucket = 'applylook';

          $upload = $s3->upload($bucket, $_FILES['image']['name'], fopen($_FILES['image']['tmp_name'], 'rb'), 'public-read');
          //////////////////////////////////
        }
      }catch(\Exception $e){
        return;
      }
    }
      header('Location: '. SITE_URL . '/index.php');
      exit();
  }

  protected function showUser() {
    $user = new \Apply\Model\Thread();
    $userData = $user->find($_SESSION['me']->id);
    $this->setValues('image', $userData->image);
  }



  private function createComment() {
    try {
        $this->validate();
      } catch (\Apply\Exception\EmptyPost $e) {
          $this->setErrors('content', $e->getMessage());
      } catch (\Apply\Exception\CharLength $e) {
          $this->setErrors('content', $e->getMessage());
      }

      $this->setValues('content', $_POST['content']);
      if ($this->hasError()) {
        return;
      } else {
          $threadModel = new \Apply\Model\Thread();
          $threadModel->createComment([
            'thread_id' => $_POST['thread_id'],
            'user_id' => $_SESSION['me']->id,
            'content' => $_POST['content'],
          ]);
      }
      header('Location: '. SITE_URL . '/thread_disp.php?thread_id=' . $_POST['thread_id']);
      exit();
  }

  private function updateThread() {
    try {
      $this->validateupdate();
      } catch (\Apply\Exception\EmptyPost $e) {
          $this->setErrors('update_thread', $e->getMessage());
      } catch (\Apply\Exception\CharLength $e) {
          $this->setErrors('update_thread', $e->getMessage());
      }
      $this->setValues('thread_name', $_POST['thread_name']);
      $this->setValues('address_name', $_POST['address_name']);
      $this->setValues('comment', $_POST['comment']);
    if ($this->hasError()){
      return;
    } else {
      $threadModel = new \Apply\Model\Thread();

      // 画像の編集(画像のリンク変更)
      if($_FILES['image']['name'] == '') {
        $old_img = $_POST['old_image'];
        $user_img['name'] = $old_img;
      }else{
        $user_img = $_FILES['image'];
        $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
        $user_img['name'] = uniqid("img_") .'.'. $ext;
      }
      try {
        $userModel = new \Apply\Model\Thread();

        // Model部分に渡すようにしている部分
      $threadModel->updateThread([
        'image' => $user_img['name'],
        'title' => $_POST['thread_name'],
        'address' => $_POST['address_name'],
        'due_date' => $_POST['due_date'],
        'comment' => $_POST['comment'],
        'thread_id' => $_POST['thread_id']
      ]);
        if($user_img['size'] > 0) {
          unlink('./gazou/'.$old_img);
          move_uploaded_file($user_img['tmp_name'],'./gazou/'.$user_img['name']);
        }
      }catch(\Exception $e){
        return;
      }
    }
      header('Location: '. SITE_URL . '/index.php');
      exit();
    }

    private function validate() {
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        exit();
      }
      // 新規スレッド作成のスレッド名と最初のコメントのバリデーション
      if ($_POST['type'] === 'createthread') {
        // thread_nameとcommentにPOST送信されていなかったら不正な投稿(!issetはセットされていない意味)
        if (!isset($_POST['thread_name']) || !isset($_POST['comment'])){
          echo '不正な投稿です';
          exit();
        }
        if ( $_FILES['image']['type'] === ''|| $_POST['thread_name'] === '' || $_POST['comment'] === ''|| $_POST['address_name'] === ''|| $_POST['due_date'] === ''){
          throw new \Apply\Exception\EmptyPost("全て入力してください！");
        }
        // 20文字以上入力したらエラーがでる
        if (mb_strlen($_POST['thread_name']) > 20) {
          // エラーが出たらここが実行される
          throw new \Apply\Exception\CharLength("スレッド名が長すぎます！");
        }
        // 200文字以上入力したらエラーがでる
        if (mb_strlen($_POST['comment']) > 200) {
          // エラーが出たらここが実行される
          throw new \Apply\Exception\CharLength("コメントが長すぎます！");
        }
      }
      // スレッド詳細画面でコメントのバリデーション
      if($_POST['type'] === 'createcomment') {
        if (!isset($_POST['content'])){
          echo '不正な投稿です';
          exit();
        }
        if($_POST['content'] === '') {
          throw new \Apply\Exception\EmptyPost("コメントが入力されていません！");
        }
        if (mb_strlen($_POST['content']) > 200) {
          throw new \Apply\Exception\CharLength("コメントが長すぎます！");
      }
    }
  }

  private function validateupdate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if ($_POST['type'] === 'updatethread') {
      if (!isset($_POST['thread_name']) ){
        echo '不正な投稿です';
        exit();
      }
      if ($_POST['thread_name'] === '' || $_POST['comment'] === ''|| $_POST['address_name'] === ''|| $_POST['due_date'] === ''){
        throw new \Apply\Exception\EmptyPost("全て入力してください！");
      }
      }
    }
  }


