<?php
namespace Apply\Model;
class User extends \Apply\Model {

  public function create($values) {
    $stmt = $this->db->prepare("INSERT INTO users (username,email,password,created,modified) VALUES (:username,:email,:password,now(),now());");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      // パスワードのハッシュ化
      ':password' => password_hash($values['password'],PASSWORD_DEFAULT)
    ]);
    // メールアドレスがユニークでなければfalseを返す
    if ($res === false) {
      throw new \Apply\Exception\DuplicateEmail();
    }
  }
  public function login($values) {
    // $this->dbはModel.phpのprotected $db;
    // prepareはデータベースに実行するSQL文を入力しますよメソッド
    // (prepareメソッドはユーザーからの入力をSQLに含めることが出来ます（つまり変数を埋め込みできる)。)
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email;");
    $stmt->execute([
      // バインド変数(:email)
      ':email' => $values['email']
    ]);
    // データから取得してきたデータを$userに代入している
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    // emptyは$userが空の状態か教えてくれる(空だったときは例外処理が実行される)
    if (empty($user)) {
      throw new \Apply\Exception\UnmatchEmailOrPassword();
    }
    // メールアドレスは合っていたがパスワードが間違っていたときの例外処理が行われる
    if (!password_verify($values['password'], $user->password)) {
      throw new \Apply\Exception\UnmatchEmailOrPassword();
    }
// 既に登録されているユーザーがログインしたらここが反応する
    if ($user->delflag == 1) {
      throw new \Apply\Exception\DeleteUser();
    }
    // 呼び出し元に戻す(Login.phpの$user = $userModel->loginに戻る)
    return $user;
  }

  // ログインしている人の情報をマイページのフォームに反映させる
  public function find($id) {
    $stmt = $this->db->prepare("SELECT * FROM users JOIN threads ON users.id = threads.user_id WHERE users.id = :id;");
    $stmt->bindValue('id',$id);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetchAll();
    return $user;
  }

// 退会ページに飛ばすユーザーの値
  public function findUser($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE users.id = :id;");
    $stmt->bindValue('id',$id);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    return $user;
  }

  public function update($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username,email = :email, modified = now() where id = :id;");
    $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':id' => $_SESSION['me']->id,
    ]);
    // 既に登録されているメールアドレスが登録されたらここが反応する
    if ($res === false) {
      throw new \Apply\Exception\DuplicateEmail();
    }
  }

  public function delete() {
    // UPDATE文を使ってdelflagを0から1に変更して日付を削除した日に変更する
    $stmt = $this->db->prepare("UPDATE users SET delflag = :delflag,modified = now() where id = :id;");
    $stmt->execute([
      ':delflag' => 1,
      ':id' => $_SESSION['me']->id,
    ]);
  }
}