<?php
namespace Apply;
class Controller {
  private $errors;
  private $values;
  public function __construct() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    $this->errors = new \stdClass();
    $this->values = new \stdClass();
  }
  protected function setValues($key, $value) {
    $this->values->$key = $value;
  }
  public function getValues() {
    return $this->values;
  }
  protected function setErrors($key, $error) {
    $this->errors->$key = $error;
  }
  public function getErrors($key) {
    return isset($this->errors->$key) ? $this->errors->$key : '';
  }
  // エラーチェック判定メソッド
  protected function hasError() {
    return !empty(get_object_vars($this->errors));
  }
  // ログイン確認メソッド
  protected function isLoggedIn() {
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }
}