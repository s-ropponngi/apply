<?php

namespace Apply\Exception;

class DuplicateEmail extends \Exception {
  protected $message = '既にメールアドレスが登録済みです!';
}