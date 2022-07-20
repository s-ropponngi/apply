<?php

namespace Apply\Exception;

class DeleteUser extends \Exception {
  protected $message = '既に退会済みのユーザーです！';
}