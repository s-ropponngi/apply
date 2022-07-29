<?php
namespace Apply\Model;
class Thread extends \Apply\Model {
  public function createThread($values) {
    try {
      // // トランザクション開始
      $this->db->beginTransaction();

      // threadsテーブルに新規レコードの作成
      $sql = "INSERT INTO threads (user_id,title,image,address,due_date,comment,created,modified) VALUES (:user_id,:title,:image,:address,:due_date,:comment,now(),now())";
      $stmt = $this->db->prepare($sql);
      // バインド変数に変えてる部分
      $stmt->bindValue('user_id',$values['user_id']);
      $stmt->bindValue('title',$values['title']);
      $stmt->bindValue('image',$values['image']);
      $stmt->bindValue('address',$values['address']);
      $stmt->bindValue('due_date',$values['due_date']);
      $stmt->bindValue('comment',$values['comment']);
      $res = $stmt->execute();
      $thread_id = $this->db->lastInsertId();

      $this->db->commit();
      // 予期せぬエラー(例外処理)が出たらcatchで処理
    } catch (\Exception $e) {
      echo $e->getMessage();

      // トランザクション取り消し(ロールバック)
      $this->db->rollBack();
    }
  }
    // 全スレッド取得
    public function getThreadAll(){
      // $user_id = $_SESSION['me']->id;
      // $stmt = $this->db->query("SELECT t.id AS t_id,title,t.created,f.id AS f_id FROM threads AS t LEFT JOIN favorites AS f ON t.delflag = 0 AND t.id = f.thread_id  AND f.user_id = $user_id ORDER BY t.id desc");

      $stmt = $this->db->query("SELECT id AS t_id,title,image,created,address,due_date,comment FROM threads WHERE delflag = 0 ORDER BY id desc");
      return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

// コメント取得
public function getComment($thread_id){
  $stmt = $this->db->prepare("SELECT comment_num,username,content,comments.created FROM comments INNER JOIN users ON user_id = users.id WHERE thread_id =:thread_id AND comments.delflag = 0 ORDER BY comment_num ASC LIMIT 5;");
  $stmt->execute([':thread_id' => $thread_id]);
  return $stmt->fetchAll(\PDO::FETCH_OBJ);
}

// コメント数取得
public function getCommentCount($thread_id) {
  $stmt = $this->db->prepare("SELECT COUNT(comment_num) AS record_num FROM comments  WHERE thread_id = :thread_id AND delflag = 0;");
  $stmt->bindValue('thread_id',$thread_id);
  $stmt->execute();
  $res =  $stmt->fetch(\PDO::FETCH_ASSOC);
  return $res['record_num'];
}

// スレッド1件取得(スレッド内容を取得)
public function getThread($thread_id){
  $stmt = $this->db->prepare("SELECT * FROM threads WHERE id = :id AND delflag = 0;");
  $stmt->bindValue(":id",$thread_id);
  $stmt->execute();
  return $stmt->fetch(\PDO::FETCH_OBJ);
}

// コメント全件取得(コメントの内容とか誰がコメントしたかのかを取得)
// どこのスレッドかはクエリパラメータで取得している
public function getCommentAll($thread_id){
  $stmt = $this->db->prepare("SELECT comment_num,username,content,comments.created FROM comments INNER JOIN users ON user_id = users.id WHERE thread_id =:thread_id AND comments.delflag = 0 ORDER BY comment_num ASC;");
  $stmt->execute([':thread_id' => $thread_id]);
  return $stmt->fetchAll(\PDO::FETCH_OBJ);
}

// コメント投稿
public function createComment($values) {
  try {
    $this->db->beginTransaction();
    $lastNum = 0;
    // スレッドに対して何件目のコメントなのか調べている
    $sql = "SELECT comment_num FROM comments WHERE thread_id = :thread_id ORDER BY comment_num DESC LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue('thread_id',$values['thread_id']);
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    // データベースから取得してきたcomment_num値に+1をしている
    $lastNum = $res->comment_num;
    $lastNum++;
    // コメントに入力した内容をcommentテーブルにINSERTする
    $sql = "INSERT INTO comments (thread_id,comment_num,user_id,content,created,modified) VALUES (:thread_id,:comment_num,:user_id,:content,now(),now())";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue('thread_id',$values['thread_id']);
    // $lastNumは直近で取得してきたcomment_numに+1した値
    $stmt->bindValue('comment_num',$lastNum);
    $stmt->bindValue('user_id',$values['user_id']);
    $stmt->bindValue('content',$values['content']);
    $stmt->execute();
    $this->db->commit();
  } catch (\Exception $e) {
    echo $e->getMessage();
    $this->db->rollBack();
  }
}

// 検索
//Ajaxで渡ってきた値をもとに threadsテーブル から該当する model を抽出
public function searchThread() {
    $title_name = $_POST['title_id'];
    $sql = 'SELECT * FROM threads WHERE title = :title_id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':title_id',(int)$title_name, PDO::PARAM_INT);
    $stmt->execute();

    //抽出された値を $model_list配列 に格納
    $title_list = array();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
      $title_list[$row['id']] = $row['title_name'];
    }
    header('Content-Type: application/json');
    //json形式で index.php へバックする
    echo json_encode($title_list);

  }


// ログインしている人の情報をマイページのフォームに反映させる
public function find($id) {
  $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id;");
  $stmt->bindValue('id',$id);
  $stmt->execute();
  $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
  $user = $stmt->fetch();
  return $user;
}

public function update($values) {
  $stmt = $this->db->prepare("UPDATE threads SET image = :image where id = :id");
  $stmt->execute([
    ':image' => $values['image'],
    ':id' => $_SESSION['me']->id,
  ]);
}

}