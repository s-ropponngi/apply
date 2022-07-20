<?php
namespace Apply\Controller;
class Search extends \Apply\Controller {
  public function run() {
    // GET送信の処理に対して
    if($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['type'] === 'searchthread') {
      $threadData = $this->searchThread();
      return $threadData;
    }
  }
  public function searchThread(){
    try {
      $this->validateSearch();
    } catch (\Apply\Exception\EmptyPost $e) {
      $this->setErrors('keyword', $e->getMessage());
    } catch (\Apply\Exception\CharLength $e) {
      $this->setErrors('keyword', $e->getMessage());
    }

    $keyword = $_GET['keyword'];
    $this->setValues('keyword', $keyword);
    if ($this->hasError()) {
      return;
    } else {
      $threadModel = new \Apply\Model\Thread();
      $threadData = $threadModel->searchThread($keyword);
      return $threadData;
    }
  }

 // GET送信用のヴァリデーション
 private function validateSearch() {
  if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type'])) {
    if ($_GET['keyword'] === ''){
      throw new \Apply\Exception\EmptyPost("検索キーワードが入力されていません！");
    }
    if (mb_strlen($_GET['keyword']) > 20) {
      throw new \Apply\Exception\CharLength("キーワードが長すぎます！");
    }
  }
}
}