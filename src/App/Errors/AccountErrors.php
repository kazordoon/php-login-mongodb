<?php

namespace App\Errors;

class AccountErrors {
  public const LOGIN_ERROR = 'It was not possible to authenticate.';

  public const EMAIL_ALREADY_IN_USE = 'This email is already in use.';
  public const EMAIL_ALREADY_VERIFIED = 'This email has already been verified before.';
}
